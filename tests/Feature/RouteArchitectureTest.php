<?php

namespace Tests\Feature;

use App\Http\Middleware\AksesByIpAddress;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Tests\TestCase;

class RouteArchitectureTest extends TestCase
{
    public function test_browser_route_loader_uses_domain_modules(): void
    {
        $modules = [
            'admin.php',
            'compact.php',
            'transactions.php',
            'auth.php',
            'public.php',
            'member-non-anggota.php',
        ];

        foreach ($modules as $module) {
            $this->assertFileExists(base_path('routes/web/'.$module));
        }
    }

    public function test_current_route_boundaries_remain_registered(): void
    {
        foreach ([
            'home',
            'frontend.home',
            'siswa.materi.index',
            'membernonanggota.cv-ats.index',
            'api.recent-registrations.random',
            'perusahaan.index',
            'admin.loker.index',
            'apply.index',
            'admin.applications.cv',
            'lokerdraft.index',
            'lokerdraft.update',
            'lokerdraft.publish',
            'membernonanggota.membership-profile.update',
            'membernonanggota.membership-profile.edit',
            'membernonanggota.membership-profile.locations.cities',
            'membernonanggota.membership-profile.locations.districts',
            'membernonanggota.membership-profile.locations.villages',
        ] as $name) {
            $this->assertNotNull(Route::getRoutes()->getByName($name), $name.' route is missing');
        }
    }

    public function test_public_catalog_routes_do_not_require_login_or_ip_whitelist(): void
    {
        foreach ([
            'api.v1.public.classes.index',
            'api.v1.public.classes.show',
            'api.v1.public.ebooks.index',
            'api.v1.public.interactive-videos.index',
            'api.v1.public.articles.index',
            'api.v1.public.articles.show',
            'api.v1.public.jobs.index',
            'api.v1.public.jobs.show',
        ] as $name) {
            $route = Route::getRoutes()->getByName($name);

            $this->assertNotNull($route, $name.' route is missing');
            $this->assertNotContains('auth', $route->gatherMiddleware(), $name.' must be public');
            $this->assertNotContains(AksesByIpAddress::class, $route->gatherMiddleware(), $name.' must not require IP whitelist');
        }
    }

    public function test_mobile_dashboard_and_payments_use_mobile_access_boundary(): void
    {
        foreach ([
            'api.v1.auth.dashboard',
            'api.v1.navigation.index',
            'api.v1.participant.profile',
            'api.v1.payments.index',
            'api.v1.learning.catalog',
            'api.v1.profile.membership.show',
            'api.v1.member.jobs.index',
            'api.v1.company.profile.show',
        ] as $name) {
            $route = Route::getRoutes()->getByName($name);

            $this->assertNotNull($route, $name.' route is missing');
            $this->assertContains('mobile.access', $route->middleware(), $name.' must use mobile access policy');
        }

        $this->assertContains('mobile.role:6', Route::getRoutes()->getByName('api.v1.learning.catalog')->middleware());
        $this->assertContains('mobile.role:6', Route::getRoutes()->getByName('api.v1.participant.profile')->middleware());
        $this->assertContains('mobile.role:2', Route::getRoutes()->getByName('api.v1.member.jobs.index')->middleware());
        $this->assertContains('mobile.membership:company', Route::getRoutes()->getByName('api.v1.company.profile.show')->middleware());
    }

    public function test_compact_layout_and_dashboard_views_remain_available(): void
    {
        $this->assertTrue(View::exists('layouts.compact'));
        $this->assertTrue(View::exists('compact.index'));
        $this->assertTrue(View::exists('compact.materi-siswa'));
    }

    public function test_loker_draft_page_uses_bootstrap_datatables_without_alpine_markup(): void
    {
        $view = file_get_contents(resource_path('views/loker-draft/index.blade.php'));

        $this->assertStringContainsString('loker-draft-table', $view);
        $this->assertStringContainsString('createDataTable', $view);
        $this->assertStringNotContainsString('x-data', $view);
        $this->assertStringNotContainsString('x-model', $view);
    }

    public function test_backend_template_runtime_is_archived(): void
    {
        $this->assertFileDoesNotExist(resource_path('views/backend/template.blade.php'));
        $this->assertFileDoesNotExist(resource_path('views/backend/beranda.blade.php'));
        $this->assertNull(Route::getRoutes()->getByName('banner.index'));
        $this->assertNull(Route::getRoutes()->getByName('fee.index'));
        $this->assertNull(Route::getRoutes()->getByName('user.index'));
        $this->assertNull(Route::getRoutes()->getByName('classes.show'));
        $this->assertNull(Route::getRoutes()->getByName('perusahaan.show'));
        $this->assertNull(Route::getRoutes()->getByName('apply.create'));
    }
}
