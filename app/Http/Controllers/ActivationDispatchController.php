<?php

namespace App\Http\Controllers;

use App\Jobs\SendUserActivationEmail;
use App\Models\User;
use Illuminate\Bus\Batch;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Services\FonnteService;
use Illuminate\Support\Facades\Http;

class ActivationDispatchController extends Controller
{

    public function send(FonnteService $fonnte)
    {
        $response = $fonnte->sendMessage(
            '083156666466',
            'Halo dari Laravel 2'
        );

        if ($response->failed()) {
            return response()->json([
                'success' => false,
                'response' => $response->json(),
            ], $response->status());
        }

        return response()->json([
            'success' => true,
            'response' => $response->json(),
        ]);
    }
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => [
                'nullable',
                'integer',
                'exists:users,id',
                'required_without:user_ids',
                'prohibits:user_ids',
            ],

            'user_ids' => [
                'nullable',
                'array',
                'min:1',
                'required_without:user_id',
                'prohibits:user_id',
            ],

            'user_ids.*' => [
                'integer',
                'distinct',
                'exists:users,id',
            ],

            // 'scope' => [
            //     'nullable',
            //     'string',
            //     'max:100',
            //     'exists:contact_mappings,scope',
            // ],
        ]);

        $scope = $validated['scope'] ?? 'default';

        $userIds = collect(
            $validated['user_ids']
                ?? [$validated['user_id']]
        )->unique()->values();
        /*
        * Single user
        */
        if ($userIds->count() === 1) {
            $activationId = (string) Str::uuid();

            SendUserActivationEmail::dispatch(
                activationId: $activationId,
                userId: (int) $userIds->first(),
                scope: $scope,
            );

            return response()->json([
                'message' => 'Email aktivasi masuk ke antrean.',
                'mode' => 'single',
                'activation_id' => $activationId,
            ], 202);
        }

        /*
         * Multi-user
         */
        $jobs = $userIds
            ->values()
            ->map(function ($userId, $index) use ($scope) {
                return (new SendUserActivationEmail(
                    activationId: (string) Str::uuid(),
                    userId: (int) $userId,
                    scope: $scope,
                ))->delay(now()->addMinutes($index));
            })
            ->all();

        $batch = Bus::batch($jobs)
            ->name('Kirim email aktivasi user')
            ->allowFailures()
            ->onQueue('activation-mails')
            ->dispatch();

        return response()->json([
            'message' => 'Batch email aktivasi masuk ke antrean.',
            'mode' => 'batch',
            'batch_id' => $batch->id,
            'total' => $userIds->count(),
        ], 202);
    }
    public function sendFromLink(
        Request $request,
        User $user
    ): RedirectResponse {
        $scope = $request->query('scope', 'default');

        $activationId = (string) Str::uuid();

        Log::info('send email 1', [$user, $user->getKey()]);

        SendUserActivationEmail::dispatch(
            activationId: $activationId,
            userId: (int) $user->getKey(),
            scope: $scope,
        );

        if ($request->routing) {
            return redirect()
                ->to('/')
                ->with(
                    'success',
                    "Email aktivasi untuk {$user->name} telah masuk antrean."
                );
        }

        return redirect()
            ->back()
            ->with(
                'success',
                "Email aktivasi untuk {$user->name} telah masuk antrean."
            );
    }
}
