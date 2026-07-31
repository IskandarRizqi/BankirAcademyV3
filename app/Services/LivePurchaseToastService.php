<?php

namespace App\Services;

use App\Models\ClassesModel;
use App\Models\FakeOrderCustomer;
use App\Models\SubMateriModel;
use Carbon\Carbon;
use Illuminate\Contracts\Cache\LockTimeoutException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class LivePurchaseToastService
{
    public function getNextToast(Request $request): array
    {
        if (! config('app.live_purchase_toast.enabled', true)) {
            return $this->emptyResponse();
        }

        $now = now(config('app.timezone', 'Asia/Jakarta'));
        $ipAddress = $request->ip() ?: '0.0.0.0';
        $lockKey = 'fake-order-customer:'.$now->toDateString();

        try {
            return Cache::lock($lockKey, 10)->block(5, function () use ($ipAddress, $now) {
                return DB::transaction(function () use ($ipAddress, $now) {
                    return $this->createOrSkipToast($ipAddress, $now);
                });
            });
        } catch (LockTimeoutException) {
            return $this->emptyResponse(60);
        }
    }

    private function createOrSkipToast(string $ipAddress, Carbon $now): array
    {
        $displayDate = $now->toDateString();
        $maxPerIp = min(50, max(0, (int) config('app.live_purchase_toast.max_per_ip_per_day', 50)));

        if ($maxPerIp === 0) {
            return $this->emptyResponse();
        }

        $todayToasts = FakeOrderCustomer::query()
            ->where('ip_address', $ipAddress)
            ->where('display_date', $displayDate)
            ->orderBy('id')
            ->lockForUpdate()
            ->get();

        if ($todayToasts->count() >= $maxPerIp) {
            return $this->emptyResponse();
        }

        $latestToast = $todayToasts->last();
        $isFirstToastToday = $latestToast === null;

        if (! $isFirstToastToday && $latestToast->next_display_at && $latestToast->next_display_at->isFuture()) {
            return $this->emptyResponse($now->diffInSeconds($latestToast->next_display_at));
        }

        if (! $isFirstToastToday && ! $this->isWithinDisplayHours($now)) {
            return $this->emptyResponse($this->secondsUntilNextOpening($now));
        }

        $product = $this->randomProduct();

        if ($product === null) {
            return $this->emptyResponse($this->isWithinDisplayHours($now)
                ? (int) config('app.live_purchase_toast.min_interval_seconds', 60)
                : $this->secondsUntilNextOpening($now));
        }

        $customerName = $this->uniqueCustomerName($displayDate);
        $customerCity = fake('id_ID')->city();
        $nextDisplayAt = $this->nextDisplayAt($now);
        $timeAgo = random_int(1, 5).' menit yang lalu';

        FakeOrderCustomer::create([
            'ip_address' => $ipAddress,
            'customer_name' => $customerName,
            'customer_city' => $customerCity,
            'product_type' => $product['type'],
            'product_id' => $product['id'],
            'product_name' => $product['name'],
            'display_date' => $displayDate,
            'shown_at' => $now,
            'next_display_at' => $nextDisplayAt,
        ]);

        $typeLabel = $product['type'];
        $message = sprintf(
            '%s dari %s membeli %s %s',
            $customerName,
            $customerCity,
            $typeLabel,
            $product['name']
        );

        return [
            'success' => true,
            'data' => [
                'name' => $customerName,
                'city' => $customerCity,
                'type' => $product['type'],
                'product_name' => $product['name'],
                'time_ago' => $timeAgo,
                'message' => $message,
            ],
            'retry_after' => $now->diffInSeconds($nextDisplayAt),
        ];
    }

    private function randomProduct(): ?array
    {
        foreach (Arr::shuffle(['class', 'video', 'ebook']) as $type) {
            $product = match ($type) {
                'class' => ClassesModel::query()
                    ->select(['id', 'title'])
                    ->where('status', 1)
                    ->whereNotNull('title')
                    ->where('title', '!=', '')
                    ->inRandomOrder()
                    ->first(),
                'video' => SubMateriModel::query()
                    ->select(['id', 'nama'])
                    ->where('tipe_link', 0)
                    ->whereNotNull('nama')
                    ->where('nama', '!=', '')
                    ->inRandomOrder()
                    ->first(),
                'ebook' => SubMateriModel::query()
                    ->select(['id', 'nama'])
                    ->where('tipe_link', 1)
                    ->whereNotNull('nama')
                    ->where('nama', '!=', '')
                    ->inRandomOrder()
                    ->first(),
            };

            if ($product) {
                return [
                    'id' => $product->id,
                    'type' => $type,
                    'name' => $type === 'class' ? $product->title : $product->nama,
                ];
            }
        }

        return null;
    }

    private function uniqueCustomerName(string $displayDate): string
    {
        $faker = fake('id_ID')->unique();

        for ($attempt = 0; $attempt < 100; $attempt++) {
            $name = trim($faker->name());
            $exists = FakeOrderCustomer::query()
                ->where('display_date', $displayDate)
                ->whereRaw('LOWER(customer_name) = ?', [strtolower($name)])
                ->exists();

            if (! $exists) {
                return $name;
            }
        }

        throw new \RuntimeException('Unable to generate a unique fake customer name.');
    }

    private function nextDisplayAt(Carbon $now): Carbon
    {
        $minInterval = max(60, (int) config('app.live_purchase_toast.min_interval_seconds', 60));
        $maxInterval = min(3600, max($minInterval, (int) config('app.live_purchase_toast.max_interval_seconds', 3600)));
        $candidate = $now->copy()->addSeconds(random_int($minInterval, $maxInterval));

        if (! $this->isWithinDisplayHours($candidate)) {
            return $this->nextOpening($candidate);
        }

        return $candidate;
    }

    private function isWithinDisplayHours(Carbon $time): bool
    {
        [$start, $end] = $this->displayWindow($time);

        return $time->greaterThanOrEqualTo($start) && $time->lessThan($end);
    }

    private function secondsUntilNextOpening(Carbon $time): int
    {
        return max(1, $time->diffInSeconds($this->nextOpening($time)));
    }

    private function nextOpening(Carbon $time): Carbon
    {
        [$start] = $this->displayWindow($time);

        if ($time->lessThan($start)) {
            return $start;
        }

        return $start->addDay();
    }

    private function displayWindow(Carbon $time): array
    {
        $date = $time->toDateString();
        $timezone = $time->getTimezone();
        $start = Carbon::parse($date.' '.config('app.live_purchase_toast.start_time', '09:00'), $timezone);
        $end = Carbon::parse($date.' '.config('app.live_purchase_toast.end_time', '20:00'), $timezone);

        return [$start, $end];
    }

    private function emptyResponse(?int $retryAfter = null): array
    {
        return [
            'success' => false,
            'data' => null,
            'retry_after' => $retryAfter,
        ];
    }
}
