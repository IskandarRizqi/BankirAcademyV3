<?php

namespace Tests\Unit;

use App\Models\User;
use App\Support\AdminPanel;
use PHPUnit\Framework\TestCase;

class AdminPanelTest extends TestCase
{
    public function test_legacy_root_can_access_admin_panel(): void
    {
        $user = new User(['role' => 0, 'email' => 'root@root.root']);

        $this->assertTrue(AdminPanel::canAccess($user));
    }

    public function test_cb_root_can_access_admin_panel(): void
    {
        $user = new User(['role' => 4, 'email' => 'cb@bankir.academy']);

        $this->assertTrue(AdminPanel::canAccess($user));
    }

    public function test_other_role_four_users_cannot_access_admin_panel(): void
    {
        $user = new User(['role' => 4, 'email' => 'bank@example.com']);

        $this->assertFalse(AdminPanel::canAccess($user));
    }
}
