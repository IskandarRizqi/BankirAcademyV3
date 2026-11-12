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

        .visitor-statistics .filter-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 16px;
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
        $hasDailyData = collect($statistics)->contains(function ($statistic) {
            return collect($statistic['daily_chart'])->sum() > 0;
        });
        $topPageLabels = $topPages->pluck('page_label')->map(fn($label) => $label ?: 'Halaman publik')->values();
        $topPageValues = $topPages->pluck('unique_visitors')->map(fn($value) => (int) $value)->values();
    @endphp

    <div class="container-fluid px-2 px-md-4 mt-4 visitor-statistics">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">
            <div>
                <h1 class="h3 font-weight-bold text-dark mb-1">Statistik Visitor</h1>
                <p class="text-muted mb-0">Visitor unik berdasarkan IP address pada {{ $periodLabel }} ({{ $startDate }}
                    - {{ $endDate }}).</p>
            </div>
        </div>

        <form method="GET" action="{{ route('admin.visitor-statistics') }}" class="filter-card mb-4">
            <div class="form-row align-items-end">
                <div class="col-12 col-md-4 col-lg-3 mb-3 mb-md-0">
                    <label for="visitor-period" class="font-weight-bold small">Periode statistik</label>
                    <select id="visitor-period" name="period" class="form-control">
                        <option value="today" @selected($period === 'today')>Hari Ini</option>
                        <option value="weekly" @selected($period === 'weekly')>Mingguan (7 hari terakhir)</option>
                        <option value="14days" @selected($period === '14days')>14 hari terakhir</option>
                        <option value="monthly" @selected($period === 'monthly')>Bulanan (bulan ini)</option>
                        <option value="yearly" @selected($period === 'yearly')>Tahunan (tahun ini)</option>
                        <option value="custom" @selected($period === 'custom')>Custom</option>
                    </select>
                </div>
                <div id="visitor-custom-dates" class="col-12 col-md-6 col-lg-4 mb-3 mb-md-0"
                    @if ($period !== 'custom') hidden @endif>
                    <div class="form-row">
                        <div class="col-6">
                            <label for="visitor-start-date" class="font-weight-bold small">Dari</label>
                            <input id="visitor-start-date" type="date" name="start_date"
                                value="{{ $period === 'custom' ? $startDate : '' }}" class="form-control">
                        </div>
                        <div class="col-6">
                            <label for="visitor-end-date" class="font-weight-bold small">Sampai</label>
                            <input id="visitor-end-date" type="date" name="end_date"
                                value="{{ $period === 'custom' ? $endDate : '' }}" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-auto">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter mr-1"></i> Terapkan filter
                    </button>
                </div>
            </div>
        </form>

        {{-- <div class="nav nav-pills mb-4" aria-label="Kategori statistik visitor">
            @foreach ($statistics as $type => $statistic)
                <a class="nav-link mr-2 mb-2 {{ $loop->first ? 'active' : '' }}" href="#visitor-{{ $type }}">
                    {{ $statistic['label'] }}
                </a>
            @endforeach
        </div> --}}

        <div class="row mb-4">
            @foreach ($statistics as $type => $statistic)
                <div class="col-12 col-lg-4 mb-3" id="visitor-{{ $type }}">
                    <div class="stat-card">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="stat-label">{{ $statistic['label'] }}</span>
                            <i class="fas fa-chart-line text-primary"></i>
                        </div>
                        <div class="text-muted small mb-1">Visitor unik dalam periode terpilih</div>
                        <div class="stat-value">{{ number_format($statistic['total']) }}</div>
                        <div class="text-muted small mt-2">{{ $startDate }} - {{ $endDate }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row">
            <div class="col-12 col-xl-8 mb-4">
                <div class="chart-card h-100">
                    <div class="d-flex flex-column flex-sm-row justify-content-between mb-2">
                        <div>
                            <h2 class="h5 font-weight-bold mb-1">Visitor per Hari</h2>
                            <p class="text-muted small mb-0">Tiga kategori utama dalam periode terpilih.</p>
                        </div>
                    </div>
                    <div id="visitor-daily-chart" class="chart-container"></div>
                    <p class="empty-message mb-0" id="visitor-daily-empty" @if ($hasDailyData) hidden @endif>
                        Belum ada data visitor pada periode ini.
                    </p>
                </div>
            </div>

            <div class="col-12 col-xl-4 mb-4">
                <div class="chart-card h-100">
                    <h2 class="h5 font-weight-bold mb-1">Perangkat Landing Page</h2>
                    <p class="text-muted small">Dihitung dari IP unik pada periode terpilih.</p>
                    <div id="visitor-device-chart" class="chart-container"></div>
                    <p class="empty-message mb-0" id="visitor-device-empty" @if ($deviceStatistics['total'] > 0) hidden @endif>
                        Belum ada data perangkat.
                    </p>
                    <div class="small text-muted mt-2">
                        Mobile: {{ number_format($deviceStatistics['mobile']) }}
                        ({{ $deviceStatistics['mobile_percentage'] }}%)
                        <br>
                        PC/Desktop: {{ number_format($deviceStatistics['desktop']) }}
                        ({{ $deviceStatistics['desktop_percentage'] }}%)
                    </div>
                </div>
            </div>

            <div class="col-12 mb-4">
                <div class="chart-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h2 class="h5 font-weight-bold mb-1">Lima Halaman Terpopuler</h2>
                            <p class="text-muted small mb-0">Visitor unik per halaman pada periode terpilih.</p>
                        </div>
                    </div>
                    <div id="visitor-top-pages-chart" class="chart-container" style="min-height: 300px;"></div>
                    @if ($topPages->isEmpty())
                        <p class="empty-message mb-0" id="visitor-top-pages-empty">Belum ada data halaman pada periode ini.
                        </p>
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
                                            <td class="text-right font-weight-bold">
                                                {{ number_format($page->unique_visitors) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-12 mb-4">
                <div class="chart-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h2 class="h5 font-weight-bold mb-1">Visitor Berdasarkan Wilayah</h2>
                            <p class="text-muted small mb-0">Visitor unik landing page berdasarkan perkiraan lokasi IP.</p>
                        </div>
                    </div>
                    @if ($locationStatistics['provinces']->isEmpty() && $locationStatistics['cities']->isEmpty())
                        <p class="empty-message mb-0">Belum ada data wilayah pada periode ini.</p>
                    @else
                        <div class="row">
                            <div class="col-12 col-lg-5 mb-4 mb-lg-0">
                                <h3 class="h6 font-weight-bold">Provinsi</h3>
                                <div class="table-responsive">
                                    <table class="table table-borderless mb-0">
                                        <thead>
                                            <tr>
                                                <th>Wilayah</th>
                                                <th class="text-right">Visitor unik</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($locationStatistics['provinces'] as $province)
                                                <tr>
                                                    <td>{{ $province->province }}</td>
                                                    <td class="text-right font-weight-bold">
                                                        {{ number_format($province->unique_visitors) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-12 col-lg-7">
                                <h3 class="h6 font-weight-bold">Kota/Kabupaten</h3>
                                <div class="table-responsive">
                                    <table class="table table-borderless mb-0">
                                        <thead>
                                            <tr>
                                                <th>Kota/Kabupaten</th>
                                                <th>Provinsi</th>
                                                <th class="text-right">Visitor unik</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($locationStatistics['cities'] as $city)
                                                <tr>
                                                    <td>{{ $city->city }}</td>
                                                    <td>{{ $city->province }}</td>
                                                    <td class="text-right font-weight-bold">
                                                        {{ number_format($city->unique_visitors) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var periodElement = document.getElementById('visitor-period');
            var customDatesElement = document.getElementById('visitor-custom-dates');
            var dailyElement = document.getElementById('visitor-daily-chart');
            var deviceElement = document.getElementById('visitor-device-chart');
            var dailySeries = @json(collect($statistics)->map(function ($statistic) {
                        return ['name' => $statistic['label'], 'data' => $statistic['daily_chart']];
                    })->values());
            var dailyHasData = dailySeries.some(function(series) {
                return series.data.some(function(value) {
                    return value > 0;
                });
            });
            var chartDays = @json(count($chartLabels));
            var maxDateLabels = chartDays > 90 ? 12 : (chartDays > 7 ? 7 : chartDays);
            var dateLabelStep = Math.max(1, Math.ceil(chartDays / maxDateLabels));

            if (dailyElement && typeof ApexCharts !== 'undefined') {
                new ApexCharts(dailyElement, {
                    chart: {
                        type: 'line',
                        height: chartDays > 7 ? 350 : 320,
                        toolbar: {
                            show: false
                        },
                        fontFamily: 'Inter, sans-serif'
                    },
                    series: dailySeries,
                    colors: ['#2563eb', '#16a34a', '#f97316'],
                    stroke: {
                        curve: 'smooth',
                        width: 3
                    },
                    markers: {
                        size: chartDays > 31 ? 0 : (chartDays > 14 ? 2 : 4),
                        hover: {
                            sizeOffset: 3
                        }
                    },
                    xaxis: {
                        categories: @json($chartLabels),
                        tickAmount: maxDateLabels,
                        labels: {
                            rotate: chartDays > 7 ? -45 : 0,
                            rotateAlways: chartDays > 7,
                            hideOverlappingLabels: true,
                            trim: false,
                            formatter: function(value, timestamp, opts) {
                                if (!opts || typeof opts.i !== 'number') {
                                    return value;
                                }

                                return opts.i % dateLabelStep === 0 || opts.i === chartDays - 1 ? value : '';
                            }
                        },
                        axisTicks: {
                            show: chartDays <= 31
                        }
                    },
                    yaxis: {
                        min: 0,
                        forceNiceScale: true,
                        labels: {
                            formatter: function(value) {
                                return Math.round(value);
                            }
                        }
                    },
                    legend: {
                        position: 'top'
                    },
                    noData: {
                        text: 'Belum ada data visitor'
                    },
                    tooltip: {
                        y: {
                            formatter: function(value) {
                                return Math.round(value) + ' visitor unik';
                            }
                        }
                    }
                }).render();
            }
            if (dailyHasData) document.getElementById('visitor-daily-empty').hidden = true;

            if (periodElement && customDatesElement) {
                periodElement.addEventListener('change', function() {
                    customDatesElement.hidden = this.value !== 'custom';
                });
            }

            if (deviceElement && typeof ApexCharts !== 'undefined') {
                new ApexCharts(deviceElement, {
                    chart: {
                        type: 'donut',
                        height: 280,
                        fontFamily: 'Inter, sans-serif'
                    },
                    series: [{{ $deviceStatistics['mobile'] }}, {{ $deviceStatistics['desktop'] }}],
                    labels: ['Mobile', 'PC/Desktop'],
                    colors: ['#2563eb', '#94a3b8'],
                    legend: {
                        position: 'bottom'
                    },
                    dataLabels: {
                        enabled: true
                    },
                    noData: {
                        text: 'Belum ada data perangkat'
                    }
                }).render();
            }

            var topPagesElement = document.getElementById('visitor-top-pages-chart');
            if (topPagesElement && typeof ApexCharts !== 'undefined') {
                new ApexCharts(topPagesElement, {
                    chart: {
                        type: 'bar',
                        height: 300,
                        toolbar: {
                            show: false
                        },
                        fontFamily: 'Inter, sans-serif'
                    },
                    series: [{
                        name: 'Visitor unik',
                        data: @json($topPageValues)
                    }],
                    colors: ['#7c3aed'],
                    plotOptions: {
                        bar: {
                            horizontal: true,
                            borderRadius: 5,
                            barHeight: '55%'
                        }
                    },
                    xaxis: {
                        categories: @json($topPageLabels),
                        min: 0
                    },
                    yaxis: {
                        labels: {
                            maxWidth: 180
                        }
                    },
                    dataLabels: {
                        enabled: true
                    },
                    noData: {
                        text: 'Belum ada data halaman'
                    },
                    tooltip: {
                        y: {
                            formatter: function(value) {
                                return Math.round(value) + ' visitor unik';
                            }
                        }
                    }
                }).render();
            }
        });
    </script>
@endsection
