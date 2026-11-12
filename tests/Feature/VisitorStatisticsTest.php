<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Visitor;
use App\Services\VisitorTrackingService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class VisitorStatisticsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow('2026-11-05 10:00:00');
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();
        parent::tearDown();
    }

    public function test_one_ip_visiting_one_page_once_creates_one_record(): void
    {
        $this->recordPage('203.0.113.1', '/kredit');

        $this->assertDatabaseCount('visitors', 1);
    }

    public function test_repeated_same_page_on_same_day_is_deduplicated(): void
    {
        $service = app(VisitorTrackingService::class);
        $request = $this->getRequest('/kredit', '203.0.113.1');

        $service->recordPageVisit($request);
        $service->recordPageVisit($request);

        $this->assertDatabaseCount('visitors', 1);
    }

    public function test_one_ip_can_have_two_page_records_on_the_same_day(): void
    {
        $this->recordPage('203.0.113.1', '/kredit');
        $this->recordPage('203.0.113.1', '/tabungan');

        $this->assertDatabaseCount('visitors', 2);
    }

    public function test_unique_visitor_count_across_two_pages_is_one(): void
    {
        $this->recordPage('203.0.113.1', '/kredit');
        $this->recordPage('203.0.113.1', '/tabungan');

        $this->assertSame(1, Visitor::where('visitor_type', Visitor::TYPE_LANDING)
            ->distinct()
            ->count('ip_address'));
    }

    public function test_top_pages_count_unique_ips(): void
    {
        $this->recordPage('203.0.113.1', '/kredit');
        $this->recordPage('203.0.113.1', '/kredit');
        $this->recordPage('203.0.113.2', '/kredit');
        $this->recordPage('203.0.113.1', '/tabungan');

        $this->assertSame(2, Visitor::where('page_url', '/kredit')->distinct()->count('ip_address'));
        $this->assertSame(1, Visitor::where('page_url', '/tabungan')->distinct()->count('ip_address'));
    }

    public function test_visitors_on_two_dates_are_counted_in_their_period(): void
    {
        $this->recordPage('203.0.113.1', '/kredit', '2026-11-05 10:00:00');
        $this->recordPage('203.0.113.2', '/kredit', '2026-11-04 10:00:00');

        $this->assertSame(2, Visitor::whereYear('visited_at', 2026)->distinct()->count('ip_address'));
        $this->assertSame(1, Visitor::whereDate('visited_at', '2026-11-05')->distinct()->count('ip_address'));
    }

    public function test_mobile_user_agent_is_classified_as_mobile(): void
    {
        $this->assertTrue(app(VisitorTrackingService::class)->isMobile(
            'Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X)'
        ));
    }

    public function test_desktop_user_agent_is_classified_as_pc_or_desktop(): void
    {
        $this->assertFalse(app(VisitorTrackingService::class)->isMobile(
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
        ));
    }

    public function test_public_ip_location_is_saved_from_geolocation_service(): void
    {
        Cache::forget('visitor-geolocation:'.hash('sha256', '8.8.8.8'));
        Http::fake([
            'https://ipwho.is/*' => Http::response([
                'success' => true,
                'country_code' => 'ID',
                'country' => 'Indonesia',
                'region' => 'Jawa Barat',
                'city' => 'Bandung',
            ]),
        ]);

        $this->recordPage('8.8.8.8', '/kredit');

        $this->assertDatabaseHas('visitors', [
            'ip_address' => '8.8.8.8',
            'country_code' => 'ID',
            'country' => 'Indonesia',
            'province' => 'Jawa Barat',
            'city' => 'Bandung',
        ]);
        Http::assertSentCount(1);
    }

    public function test_dashboard_shows_visitor_location_statistics(): void
    {
        $admin = User::factory()->create(['email' => 'root@root.root', 'role' => 0]);

        Visitor::create([
            'ip_address' => '203.0.113.10',
            'country_code' => 'ID',
            'country' => 'Indonesia',
            'province' => 'Jawa Barat',
            'city' => 'Bandung',
            'page_url' => '/kredit',
            'page_label' => 'Kredit',
            'visitor_type' => Visitor::TYPE_LANDING,
            'visitor_date' => '2026-11-05',
            'visited_year' => 2026,
            'visited_at' => '2026-11-05 10:00:00',
        ]);

        $this->actingAs($admin)
            ->get('/admin/statistik-visitor')
            ->assertOk()
            ->assertSee('Visitor Berdasarkan Wilayah')
            ->assertSee('Jawa Barat')
            ->assertSee('Bandung');
    }

    public function test_auth_and_transaction_categories_are_recorded_separately(): void
    {
        $service = app(VisitorTrackingService::class);
        $request = $this->getRequest('/login', '203.0.113.1');

        $service->recordAuth($request);
        $service->recordTransaction($request);

        $this->assertDatabaseHas('visitors', [
            'visitor_type' => Visitor::TYPE_AUTH,
            'ip_address' => '203.0.113.1',
        ]);
        $this->assertDatabaseHas('visitors', [
            'visitor_type' => Visitor::TYPE_TRANSACTION,
            'ip_address' => '203.0.113.1',
        ]);
    }

    public function test_dashboard_does_not_error_without_visitor_data(): void
    {
        $admin = User::factory()->create(['email' => 'root@root.root', 'role' => 0]);

        $this->actingAs($admin)
            ->get('/admin/statistik-visitor')
            ->assertOk()
            ->assertSee('Belum ada data visitor')
            ->assertSee('Hari ini')
            ->assertSee('2026-11-05 - 2026-11-05');
    }

    public function test_dashboard_supports_monthly_and_yearly_filters(): void
    {
        $admin = User::factory()->create(['email' => 'root@root.root', 'role' => 0]);

        $this->actingAs($admin)
            ->get('/admin/statistik-visitor?period=monthly')
            ->assertOk()
            ->assertSee('Bulan ini')
            ->assertSee('2026-11-01 - 2026-11-05');

        $this->actingAs($admin)
            ->get('/admin/statistik-visitor?period=yearly')
            ->assertOk()
            ->assertSee('Tahun ini')
            ->assertSee('2026-01-01 - 2026-11-05');
    }

    public function test_dashboard_supports_last_fourteen_days_filter(): void
    {
        $admin = User::factory()->create(['email' => 'root@root.root', 'role' => 0]);

        $this->actingAs($admin)
            ->get('/admin/statistik-visitor?period=14days')
            ->assertOk()
            ->assertSee('14 hari terakhir')
            ->assertSee('2026-10-23 - 2026-11-05');
    }

    public function test_dashboard_supports_custom_date_filter(): void
    {
        $admin = User::factory()->create(['email' => 'root@root.root', 'role' => 0]);

        $this->actingAs($admin)
            ->get('/admin/statistik-visitor?period=custom&start_date=2026-11-01&end_date=2026-11-04')
            ->assertOk()
            ->assertSee('Rentang custom')
            ->assertSee('2026-11-01 - 2026-11-04');
    }

    public function test_custom_date_filter_requires_a_complete_date_range(): void
    {
        $admin = User::factory()->create(['email' => 'root@root.root', 'role' => 0]);

        $this->actingAs($admin)
            ->get('/admin/statistik-visitor?period=custom&start_date=2026-11-01')
            ->assertSessionHasErrors('end_date');
    }

    public function test_non_admin_cannot_access_visitor_dashboard(): void
    {
        $user = User::factory()->create(['email' => 'member@example.com', 'role' => 2]);

        $this->actingAs($user)
            ->get('/admin/statistik-visitor')
            ->assertStatus(302)
            ->assertRedirect('/');
    }

    public function test_public_visitor_middleware_records_only_successful_page_requests(): void
    {
        Route::middleware('visitor')->get('/test-public-visitor', fn () => response('ok'));

        $this->withServerVariables(['REMOTE_ADDR' => '203.0.113.9'])
            ->get('/test-public-visitor')
            ->assertOk();

        $this->assertDatabaseHas('visitors', [
            'ip_address' => '203.0.113.9',
            'page_url' => '/test-public-visitor',
            'visitor_type' => Visitor::TYPE_LANDING,
        ]);
    }

    private function recordPage(string $ip, string $url, string $visitedAt = '2026-11-05 10:00:00'): void
    {
        $request = $this->getRequest($url, $ip);
        Carbon::setTestNow($visitedAt);
        app(VisitorTrackingService::class)->recordPageVisit($request);
        Carbon::setTestNow('2026-11-05 10:00:00');
    }

    private function getRequest(string $url, string $ip)
    {
        return Request::create($url, 'GET', [], [], [], ['REMOTE_ADDR' => $ip]);
    }
}
