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
        $currentYear = now()->year;
        $validated = $request->validate([
            'year' => ['nullable', 'integer', 'min:2000', 'max:'.$currentYear],
        ]);
        $year = (int) ($validated['year'] ?? $currentYear);

        $categories = [
            Visitor::TYPE_LANDING => 'Landing Page',
            Visitor::TYPE_AUTH => 'Login / Register',
            Visitor::TYPE_TRANSACTION => 'Transaksi',
        ];
        $statistics = [];

        foreach ($categories as $type => $label) {
            $statistics[$type] = [
                'label' => $label,
                'daily' => $this->periodCount($type, $year, 'day'),
                'monthly' => $this->periodCount($type, $year, 'month'),
                'yearly' => $this->periodCount($type, $year, 'year'),
                'monthly_chart' => $this->monthlyChart($type, $year),
            ];
        }

        return view('compact.visitor-statistics', [
            'year' => $year,
            'years' => $this->availableYears($year, $currentYear),
            'statistics' => $statistics,
            'deviceStatistics' => $this->deviceStatistics($year),
            'topPages' => $this->topPages($year),
        ]);
    }

    private function baseQuery(string $type, int $year)
    {
        return Visitor::query()
            ->where('visitor_type', $type)
            ->where('visited_year', $year);
    }

    private function periodCount(string $type, int $year, string $period): int
    {
        $query = $this->baseQuery($type, $year);

        if ($period === 'day') {
            $date = Carbon::create($year, now()->month, 1);
            $date->day(min(now()->day, $date->daysInMonth));
            $query->whereDate('visited_at', $date->toDateString());
        } elseif ($period === 'month') {
            $query->whereMonth('visited_at', now()->month);
        }

        return (int) $query->distinct()->count('ip_address');
    }

    private function monthlyChart(string $type, int $year): array
    {
        $months = [];

        for ($month = 1; $month <= 12; $month++) {
            $start = Carbon::create($year, $month, 1)->startOfMonth();
            $end = $start->copy()->endOfMonth();
            $months[] = (int) $this->baseQuery($type, $year)
                ->whereBetween('visited_at', [$start, $end])
                ->distinct()
                ->count('ip_address');
        }

        return $months;
    }

    private function deviceStatistics(int $year): array
    {
        $visitors = $this->baseQuery(Visitor::TYPE_LANDING, $year)
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

    private function topPages(int $year)
    {
        return $this->baseQuery(Visitor::TYPE_LANDING, $year)
            ->select(['page_url', 'page_label'])
            ->selectRaw('COUNT(DISTINCT ip_address) as unique_visitors')
            ->groupBy('page_url', 'page_label')
            ->orderByDesc('unique_visitors')
            ->limit(5)
            ->get();
    }

    private function availableYears(int $selectedYear, int $currentYear): array
    {
        return Visitor::query()
            ->whereBetween('visited_year', [2000, $currentYear])
            ->distinct()
            ->orderByDesc('visited_year')
            ->pluck('visited_year')
            ->map(fn ($year) => (int) $year)
            ->push($selectedYear)
            ->push($currentYear)
            ->unique()
            ->sortDesc()
            ->values()
            ->all();
    }
}
