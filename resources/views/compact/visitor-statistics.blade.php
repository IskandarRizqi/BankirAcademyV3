@extends('layouts.compact')

@section('title', 'Statistik Visitor')

@section('content')
    <style>
        .visitor-statistics .stat-card,
        .visitor-statistics .chart-card {
            background: #fff;
            border: 0;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(15, 23, 42, .06);
        }

        .visitor-statistics .stat-card {
            height: 100%;
            padding: 20px;
        }

        .visitor-statistics .stat-label {
            color: #64748b;
            font-size: .78rem;
            font-weight: 700;
            letter-spacing: .03em;
            text-transform: uppercase;
        }

        .visitor-statistics .stat-value {
            color: #0f172a;
            font-size: 1.8rem;
            font-weight: 800;
            line-height: 1;
        }

        .visitor-statistics .chart-card {
            padding: 22px;
        }

        .visitor-statistics .chart-container {
            min-height: 320px;
        }

        .visitor-statistics .empty-message {
            color: #64748b;
            font-size: .85rem;
        }

        .visitor-statistics .table td,
        .visitor-statistics .table th {
            vertical-align: middle;
        }

        @media (max-width: 575.98px) {
            .visitor-statistics .chart-card {
                padding: 16px;
            }

            .visitor-statistics .chart-container {
                min-height: 260px;
            }
        }
    </style>

    @php
        $monthLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $hasMonthlyData = collect($statistics)->contains(function ($statistic) {
            return collect($statistic['monthly_chart'])->sum() > 0;
        });
        $topPageLabels = $topPages->pluck('page_label')->map(fn ($label) => $label ?: 'Halaman publik')->values();
        $topPageValues = $topPages->pluck('unique_visitors')->map(fn ($value) => (int) $value)->values();
    @endphp

    <div class="container-fluid px-2 px-md-4 mt-4 visitor-statistics">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">
            <div>
                <h1 class="h3 font-weight-bold text-dark mb-1">Statistik Visitor</h1>
                <p class="text-muted mb-0">Visitor unik berdasarkan IP address untuk periode tahun {{ $year }}.</p>
            </div>
            <form method="GET" action="{{ route('admin.visitor-statistics') }}" class="mt-3 mt-md-0">
                <label for="visitor-year" class="sr-only">Filter tahun</label>
                <select id="visitor-year" name="year" class="form-control" onchange="this.form.submit()">
                    @foreach ($years as $availableYear)
                        <option value="{{ $availableYear }}" @selected($availableYear === $year)>{{ $availableYear }}</option>
                    @endforeach
                </select>
            </form>
        </div>

        <div class="nav nav-pills mb-4" aria-label="Kategori statistik visitor">
            @foreach ($statistics as $type => $statistic)
                <a class="nav-link mr-2 mb-2 {{ $loop->first ? 'active' : '' }}" href="#visitor-{{ $type }}">
                    {{ $statistic['label'] }}
                </a>
            @endforeach
        </div>

        <div class="row mb-4">
            @foreach ($statistics as $type => $statistic)
                <div class="col-12 col-lg-4 mb-3" id="visitor-{{ $type }}">
                    <div class="stat-card">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="stat-label">{{ $statistic['label'] }}</span>
                            <i class="fas fa-chart-line text-primary"></i>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div class="text-muted small mb-1">Harian</div>
                                <div class="stat-value">{{ number_format($statistic['daily']) }}</div>
                            </div>
                            <div class="col-4">
                                <div class="text-muted small mb-1">Bulanan</div>
                                <div class="stat-value">{{ number_format($statistic['monthly']) }}</div>
                            </div>
                            <div class="col-4">
                                <div class="text-muted small mb-1">Tahunan</div>
                                <div class="stat-value">{{ number_format($statistic['yearly']) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row">
            <div class="col-12 col-xl-8 mb-4">
                <div class="chart-card h-100">
                    <div class="d-flex flex-column flex-sm-row justify-content-between mb-2">
                        <div>
                            <h2 class="h5 font-weight-bold mb-1">Visitor per Bulan</h2>
                            <p class="text-muted small mb-0">Tiga kategori utama, selalu menampilkan 12 bulan.</p>
                        </div>
                    </div>
                    <div id="visitor-monthly-chart" class="chart-container"></div>
                    <p class="empty-message mb-0" id="visitor-monthly-empty" @if ($hasMonthlyData) hidden @endif>
                        Belum ada data visitor pada tahun ini.
                    </p>
                </div>
            </div>

            <div class="col-12 col-xl-4 mb-4">
                <div class="chart-card h-100">
                    <h2 class="h5 font-weight-bold mb-1">Perangkat Landing Page</h2>
                    <p class="text-muted small">Dihitung dari IP unik, tanpa menampilkan IP.</p>
                    <div id="visitor-device-chart" class="chart-container"></div>
                    <p class="empty-message mb-0" id="visitor-device-empty" @if ($deviceStatistics['total'] > 0) hidden @endif>
                        Belum ada data perangkat.
                    </p>
                    <div class="small text-muted mt-2">
                        Mobile: {{ number_format($deviceStatistics['mobile']) }} ({{ $deviceStatistics['mobile_percentage'] }}%)
                        <br>
                        PC/Desktop: {{ number_format($deviceStatistics['desktop']) }} ({{ $deviceStatistics['desktop_percentage'] }}%)
                    </div>
                </div>
            </div>

            <div class="col-12 mb-4">
                <div class="chart-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h2 class="h5 font-weight-bold mb-1">Lima Halaman Terpopuler</h2>
                            <p class="text-muted small mb-0">Visitor unik per halaman landing page.</p>
                        </div>
                    </div>
                    <div id="visitor-top-pages-chart" class="chart-container" style="min-height: 300px;"></div>
                    @if ($topPages->isEmpty())
                        <p class="empty-message mb-0" id="visitor-top-pages-empty">Belum ada data halaman pada tahun ini.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                <thead>
                                    <tr>
                                        <th>Halaman</th>
                                        <th class="text-right">Visitor unik</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($topPages as $page)
                                        <tr>
                                            <td>{{ $page->page_label ?: 'Halaman publik' }}</td>
                                            <td class="text-right font-weight-bold">{{ number_format($page->unique_visitors) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var monthlyElement = document.getElementById('visitor-monthly-chart');
            var deviceElement = document.getElementById('visitor-device-chart');
            var monthlySeries = @json(collect($statistics)->map(function ($statistic) {
                return ['name' => $statistic['label'], 'data' => $statistic['monthly_chart']];
            })->values());
            var monthlyHasData = monthlySeries.some(function(series) {
                return series.data.some(function(value) { return value > 0; });
            });

            if (monthlyElement && typeof ApexCharts !== 'undefined') {
                new ApexCharts(monthlyElement, {
                    chart: { type: 'line', height: 320, toolbar: { show: false }, fontFamily: 'Inter, sans-serif' },
                    series: monthlySeries,
                    colors: ['#2563eb', '#16a34a', '#f97316'],
                    stroke: { curve: 'smooth', width: 3 },
                    markers: { size: 4 },
                    xaxis: { categories: @json($monthLabels) },
                    yaxis: { min: 0, forceNiceScale: true, labels: { formatter: function(value) { return Math.round(value); } } },
                    legend: { position: 'top' },
                    noData: { text: 'Belum ada data visitor' },
                    tooltip: { y: { formatter: function(value) { return Math.round(value) + ' visitor unik'; } } }
                }).render();
            }
            if (monthlyHasData) document.getElementById('visitor-monthly-empty').hidden = true;

            if (deviceElement && typeof ApexCharts !== 'undefined') {
                new ApexCharts(deviceElement, {
                    chart: { type: 'donut', height: 280, fontFamily: 'Inter, sans-serif' },
                    series: [{{ $deviceStatistics['mobile'] }}, {{ $deviceStatistics['desktop'] }}],
                    labels: ['Mobile', 'PC/Desktop'],
                    colors: ['#2563eb', '#94a3b8'],
                    legend: { position: 'bottom' },
                    dataLabels: { enabled: true },
                    noData: { text: 'Belum ada data perangkat' }
                }).render();
            }

            var topPagesElement = document.getElementById('visitor-top-pages-chart');
            if (topPagesElement && typeof ApexCharts !== 'undefined') {
                new ApexCharts(topPagesElement, {
                    chart: { type: 'bar', height: 300, toolbar: { show: false }, fontFamily: 'Inter, sans-serif' },
                    series: [{ name: 'Visitor unik', data: @json($topPageValues) }],
                    colors: ['#7c3aed'],
                    plotOptions: { bar: { horizontal: true, borderRadius: 5, barHeight: '55%' } },
                    xaxis: { categories: @json($topPageLabels), min: 0 },
                    yaxis: { labels: { maxWidth: 180 } },
                    dataLabels: { enabled: true },
                    noData: { text: 'Belum ada data halaman' },
                    tooltip: { y: { formatter: function(value) { return Math.round(value) + ' visitor unik'; } } }
                }).render();
            }
        });
    </script>
@endsection
