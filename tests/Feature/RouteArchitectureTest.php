<?php

namespace Tests\Feature;

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
        ] as $name) {
            $this->assertNotNull(Route::getRoutes()->getByName($name), $name.' route is missing');
        }
    }

    public function test_compact_layout_and_dashboard_views_remain_available(): void
    {
        $this->assertTrue(View::exists('layouts.compact'));
        $this->assertTrue(View::exists('compact.index'));
        $this->assertTrue(View::exists('compact.materi-siswa'));
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
