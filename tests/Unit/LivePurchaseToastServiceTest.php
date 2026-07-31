<?php

namespace Tests\Unit;

use App\Services\LivePurchaseToastService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\TestCase;
use ReflectionMethod;
use Tests\CreatesApplication;

class LivePurchaseToastServiceTest extends TestCase
{
    use CreatesApplication;

    private LivePurchaseToastService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new LivePurchaseToastService;
        config()->set('app.timezone', 'Asia/Jakarta');
        config()->set('app.live_purchase_toast.start_time', '09:00');
        config()->set('app.live_purchase_toast.end_time', '20:00');
        config()->set('app.live_purchase_toast.min_interval_seconds', 60);
        config()->set('app.live_purchase_toast.max_interval_seconds', 3600);
    }

    public function test_display_window_is_open_from_nine_until_twenty(): void
    {
        $method = new ReflectionMethod($this->service, 'isWithinDisplayHours');
        $method->setAccessible(true);

        $this->assertFalse($method->invoke($this->service, Carbon::parse('2026-07-31 08:59:59', 'Asia/Jakarta')));
        $this->assertTrue($method->invoke($this->service, Carbon::parse('2026-07-31 09:00:00', 'Asia/Jakarta')));
        $this->assertTrue($method->invoke($this->service, Carbon::parse('2026-07-31 19:59:59', 'Asia/Jakarta')));
        $this->assertFalse($method->invoke($this->service, Carbon::parse('2026-07-31 20:00:00', 'Asia/Jakarta')));
    }

    public function test_next_display_interval_stays_between_one_minute_and_one_hour(): void
    {
        $method = new ReflectionMethod($this->service, 'nextDisplayAt');
        $method->setAccessible(true);
        $now = Carbon::parse('2026-07-31 10:00:00', 'Asia/Jakarta');

        for ($attempt = 0; $attempt < 20; $attempt++) {
            $next = $method->invoke($this->service, $now);
            $interval = $now->diffInSeconds($next);

            $this->assertGreaterThanOrEqual(60, $interval);
            $this->assertLessThanOrEqual(3600, $interval);
        }
    }

    public function test_next_display_moves_to_next_opening_when_random_interval_crosses_end_time(): void
    {
        $method = new ReflectionMethod($this->service, 'nextDisplayAt');
        $method->setAccessible(true);
        $now = Carbon::parse('2026-07-31 19:59:59', 'Asia/Jakarta');

        $next = $method->invoke($this->service, $now);

        $this->assertSame('09:00', $next->format('H:i'));
        $this->assertSame('2026-08-01', $next->format('Y-m-d'));
    }
}
