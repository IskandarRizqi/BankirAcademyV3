<?php

namespace Tests\Unit;

use App\Models\User;
use App\Support\MobileAccess;
use Tests\TestCase;

class MobileAccessTest extends TestCase
{
    public function test_root_role_is_blocked_from_mobile(): void
    {
        $user = new User([
            'role' => 0,
            'email' => 'root@example.com',
        ]);

        $this->assertTrue(MobileAccess::isBlocked($user));
    }

    public function test_cb_account_is_blocked_from_mobile_regardless_of_case(): void
    {
        $user = new User([
            'role' => 4,
            'email' => 'CB@BANKIR.ACADEMY',
        ]);

        $this->assertTrue(MobileAccess::isBlocked($user));
    }

    public function test_regular_account_is_allowed_on_mobile(): void
    {
        $user = new User([
            'role' => 6,
            'email' => 'student@example.com',
        ]);

        $this->assertFalse(MobileAccess::isBlocked($user));
    }
}
