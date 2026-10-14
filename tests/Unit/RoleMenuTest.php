<?php

namespace Tests\Unit;

use App\Http\Controllers\API\NavigationController;
use App\Models\User;
use App\Support\RoleMenu;
use Illuminate\Http\Request;
use Tests\TestCase;

class RoleMenuTest extends TestCase
{
    public function test_role_six_has_the_same_menu_order_as_the_compact_website(): void
    {
        $this->assertSame(
            [
                'dashboard',
                'competencies',
                'general_training',
                'training_history',
                'jobs',
                'cv_ats',
                'certificates',
            ],
            array_column(RoleMenu::forRole(6), 'key')
        );
    }

    public function test_navigation_api_returns_role_six_menu_data(): void
    {
        $request = Request::create('/api/v1/navigation', 'GET');
        $request->setUserResolver(fn () => new User(['role' => 6]));

        $response = app(NavigationController::class)($request);
        $data = $response->getData(true);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame(6, $data['data']['role_id']);
        $this->assertCount(7, $data['data']['menus']);
        $this->assertSame('Dashboard', $data['data']['menus'][0]['label']);
    }

    public function test_roles_other_than_six_do_not_receive_student_menu(): void
    {
        $this->assertSame([], RoleMenu::forRole(2));
    }

    public function test_bank_and_school_receive_organization_menus(): void
    {
        $this->assertSame(
            [
                'organization_dashboard',
                'organization_users',
                'organization_monitoring',
                'organization_scholarships',
            ],
            array_column(RoleMenu::forRole(4), 'key')
        );

        $this->assertSame(
            [
                'organization_dashboard',
                'organization_users',
                'organization_monitoring',
            ],
            array_column(RoleMenu::forRole(5), 'key')
        );
    }

    public function test_navigation_api_returns_the_bank_menu(): void
    {
        $request = Request::create('/api/v1/navigation', 'GET');
        $request->setUserResolver(fn () => new User([
            'role' => 4,
            'email' => 'bank@example.com',
        ]));

        $response = app(NavigationController::class)($request);
        $data = $response->getData(true);

        $this->assertSame(4, $data['data']['role_id']);
        $this->assertSame('organization_dashboard', $data['data']['menus'][0]['key']);
        $this->assertCount(4, $data['data']['menus']);
    }
}
