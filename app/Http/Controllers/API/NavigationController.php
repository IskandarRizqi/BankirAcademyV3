<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Support\RoleMenu;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NavigationController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $roleId = (int) $request->user()->role;
        $menus = collect(RoleMenu::forRole($roleId))
            ->map(fn (array $menu): array => [
                'key' => $menu['key'],
                'label' => $menu['label'],
                'icon' => $menu['icon'],
                'section' => $menu['section'],
                'order' => $menu['order'],
                'screen' => $menu['key'],
            ])
            ->values();

        return response()->json([
            'success' => true,
            'message' => 'Menu navigasi berhasil diambil.',
            'data' => [
                'role_id' => $roleId,
                'menus' => $menus,
            ],
        ]);
    }
}
