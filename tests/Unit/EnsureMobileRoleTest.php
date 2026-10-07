<?php

namespace Tests\Unit;

use App\Http\Middleware\EnsureMobileRole;
use App\Models\User;
use Illuminate\Http\Request;
use Tests\TestCase;

class EnsureMobileRoleTest extends TestCase
{
    public function test_allowed_role_passes_the_mobile_role_guard(): void
    {
        $request = Request::create('/api/v1/learning/catalog', 'GET');
        $request->setUserResolver(fn () => new User(['role' => 6]));

        $response = app(EnsureMobileRole::class)->handle(
            $request,
            fn ($request) => response()->json(['success' => true]),
            '6'
        );

        $this->assertSame(200, $response->getStatusCode());
    }

    public function test_other_role_is_rejected_by_the_mobile_role_guard(): void
    {
        $request = Request::create('/api/v1/learning/catalog', 'GET');
        $request->setUserResolver(fn () => new User(['role' => 2]));

        $response = app(EnsureMobileRole::class)->handle(
            $request,
            fn ($request) => response()->json(['success' => true]),
            '6'
        );

        $this->assertSame(403, $response->getStatusCode());
        $this->assertSame('mobile_role_forbidden', $response->getData(true)['code']);
    }
}
