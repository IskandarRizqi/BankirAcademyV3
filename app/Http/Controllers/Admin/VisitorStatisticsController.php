<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Visitor;
use App\Services\VisitorTrackingService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VisitorStatisticsController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'period' => ['nullable', 'in:today,weekly,14days,monthly,yearly,custom'],
            'start_date' => ['nullable', 'required_if:period,custom', 'date'],
            'end_date' => ['nullable', 'required_if:period,custom', 'date', 'after_or_equal:start_date'],
        ]);
        $range = $this->resolveRange($validated);
        $start = $range['start'];
        $end = $range['end'];
        $chartLabels = $this->chartLabels($start, $end);

        $categories = [
            Visitor::TYPE_LANDING => 'Landing Page',
            Visitor::TYPE_AUTH => 'Login / Register',
            Visitor::TYPE_TRANSACTION => 'Transaksi',
        ];
        $statistics = [];

        foreach ($categories as $type => $label) {
            $statistics[$type] = [
                'label' => $label,
                'total' => $this->periodCount($type, $start, $end),
                'daily_chart' => $this->dailyChart($type, $start, $end),
            ];
        }

        return view('compact.visitor-statistics', [
            'period' => $range['period'],
            'periodLabel' => $range['label'],
            'startDate' => $start->toDateString(),
            'endDate' => $end->toDateString(),
            'chartLabels' => $chartLabels,
            'statistics' => $statistics,
            'deviceStatistics' => $this->deviceStatistics($start, $end),
            'topPages' => $this->topPages($start, $end),
            'locationStatistics' => $this->locationStatistics($start, $end),
        ]);
    }

    private function resolveRange(array $validated): array
    {
        $period = $validated['period'] ?? 'today';
        $today = now();
        $end = $today->copy()->endOfDay();

        if ($period === 'custom') {
            $start = Carbon::parse($validated['start_date'])->startOfDay();
            $end = Carbon::parse($validated['end_date'])->endOfDay();
        } elseif ($period === 'yearly') {
            $start = $today->copy()->startOfYear();
        } elseif ($period === 'monthly') {
            $start = $today->copy()->startOfMonth();
        } elseif ($period === '14days') {
            $start = $today->copy()->subDays(13)->startOfDay();
        } elseif ($period === 'weekly') {
            $start = $today->copy()->subDays(6)->startOfDay();
        } else {
            $start = $today->copy()->startOfDay();
        }

        return [
            'period' => $period,
            'label' => match ($period) {
                'today' => 'Hari ini',
                'weekly' => '7 hari terakhir',
                '14days' => '14 hari terakhir',
                'monthly' => 'Bulan ini',
                'yearly' => 'Tahun ini',
                default => 'Rentang custom',
            },
            'start' => $start,
            'end' => $end,
        ];
    }

    private function baseQuery(string $type, Carbon $start, Carbon $end)
    {
        return Visitor::query()
            ->where('visitor_type', $type)
            ->whereBetween('visited_at', [$start, $end]);
    }

    private function periodCount(string $type, Carbon $start, Carbon $end): int
    {
        return (int) $this->baseQuery($type, $start, $end)
            ->distinct()
            ->count('ip_address');
    }

    private function dailyChart(string $type, Carbon $start, Carbon $end): array
    {
        $counts = $this->baseQuery($type, $start, $end)
            ->selectRaw('DATE(visited_at) as visit_date, COUNT(DISTINCT ip_address) as unique_visitors')
            ->groupByRaw('DATE(visited_at)')
            ->pluck('unique_visitors', 'visit_date');
        $data = [];

        for ($date = $start->copy()->startOfDay(); $date->lte($end); $date->addDay()) {
            $data[] = (int) $counts->get($date->toDateString(), 0);
        }

        return $data;
    }

    private function chartLabels(Carbon $start, Carbon $end): array
    {
        $labels = [];

        for ($date = $start->copy()->startOfDay(); $date->lte($end); $date->addDay()) {
            $labels[] = $date->format('d/m');
        }

        return $labels;
    }

    private function deviceStatistics(Carbon $start, Carbon $end): array
    {
        $visitors = $this->baseQuery(Visitor::TYPE_LANDING, $start, $end)
            ->select(['ip_address', 'user_agent'])
            ->get()
            ->unique('ip_address');
        $total = $visitors->count();
        $mobile = $visitors->filter(function (Visitor $visitor) {
            return app(VisitorTrackingService::class)->isMobile((string) $visitor->user_agent);
        })->count();
        $desktop = $total - $mobile;

        return [
            'total' => $total,
            'mobile' => $mobile,
            'desktop' => $desktop,
            'mobile_percentage' => $total > 0 ? round(($mobile / $total) * 100, 1) : 0,
            'desktop_percentage' => $total > 0 ? round(($desktop / $total) * 100, 1) : 0,
        ];
    }

    private function topPages(Carbon $start, Carbon $end)
    {
        return $this->baseQuery(Visitor::TYPE_LANDING, $start, $end)
            ->select(['page_url', 'page_label'])
            ->selectRaw('COUNT(DISTINCT ip_address) as unique_visitors')
            ->groupBy('page_url', 'page_label')
            ->orderByDesc('unique_visitors')
            ->limit(5)
            ->get();
    }

    private function locationStatistics(Carbon $start, Carbon $end): array
    {
        $provinces = $this->baseQuery(Visitor::TYPE_LANDING, $start, $end)
            ->selectRaw("COALESCE(NULLIF(province, ''), 'Tidak diketahui') as province")
            ->selectRaw('COUNT(DISTINCT ip_address) as unique_visitors')
            ->groupByRaw("COALESCE(NULLIF(province, ''), 'Tidak diketahui')")
            ->orderByDesc('unique_visitors')
            ->limit(10)
            ->get();

        $cities = $this->baseQuery(Visitor::TYPE_LANDING, $start, $end)
            ->selectRaw("COALESCE(NULLIF(city, ''), 'Tidak diketahui') as city")
            ->selectRaw("COALESCE(NULLIF(province, ''), '-') as province")
            ->selectRaw('COUNT(DISTINCT ip_address) as unique_visitors')
            ->groupByRaw("COALESCE(NULLIF(city, ''), 'Tidak diketahui'), COALESCE(NULLIF(province, ''), '-')")
            ->orderByDesc('unique_visitors')
            ->limit(15)
            ->get();

        return compact('provinces', 'cities');
    }
}
