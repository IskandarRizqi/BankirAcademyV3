<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Visitor;
use App\Services\VisitorTrackingService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
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
            ->get('/admin/statistik-visitor?year=2026')
            ->assertOk()
            ->assertSee('Belum ada data visitor');
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
