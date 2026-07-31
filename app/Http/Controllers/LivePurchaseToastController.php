<?php

namespace App\Http\Controllers;

use App\Services\LivePurchaseToastService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LivePurchaseToastController extends Controller
{
    public function __invoke(Request $request, LivePurchaseToastService $service): JsonResponse
    {
        return response()->json($service->getNextToast($request));
    }
}
