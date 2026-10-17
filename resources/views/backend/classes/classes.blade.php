@extends('layouts.compact')

@section('content')
    <style>
        .calendar-summary {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
            margin-bottom: 20px;
        }

        .calendar-summary-item {
            padding: 10px 14px;
            border: 1px solid #e8edf3;
            border-radius: 10px;
            background: #fbfcfe;
        }

        .calendar-summary-item small {
            display: block;
            color: #7b8794;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .calendar-summary-item strong {
            display: block;
            color: #1f2937;
            font-size: 18px;
            line-height: 1;
        }

        .class-calendar-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 16px;
        }

        .class-calendar-toolbar h4 {
            min-width: 180px;
            margin: 0;
            color: #1f2937;
            text-align: center;
            text-transform: capitalize;
        }

        .class-calendar-layout {
            display: grid;
            grid-template-columns: minmax(0, 1.65fr) minmax(280px, .8fr);
            gap: 20px;
            align-items: start;
        }

        .class-info-panel {
            min-height: 100%;
            padding: 20px;
            border: 1px solid #e8edf3;
            border-radius: 10px;
            background: #fbfcfe;
        }

        .class-info-panel h5 {
            color: #1f2937;
        }

        .class-info-value {
            margin-bottom: 14px;
        }

        .class-info-value small {
            display: block;
            margin-bottom: 3px;
            color: #7b8794;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .class-info-value span {
            display: block;
            color: #374151;
            font-size: 13px;
        }

        .calendar-class-list {
            max-height: 220px;
            overflow-y: auto;
        }

        .calendar-class-link {
            display: block;
            width: 100%;
            margin-bottom: 7px;
            padding: 8px 10px;
            border: 1px solid #e4e9f0;
            border-radius: 7px;
            background: #fff;
            color: #374151;
            text-align: left;
        }

        .calendar-class-link:hover {
            border-color: #4361ee;
            color: #263b80;
        }

        .calendar-class-link strong,
        .calendar-class-link small {
            display: block;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .calendar-class-link strong {
            font-size: 12px;
        }

        .calendar-class-link small {
            margin-top: 3px;
            color: #7b8794;
            font-size: 11px;
        }

        .class-calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, minmax(0, 1fr));
            overflow: hidden;
            border: 1px solid #e8edf3;
            border-radius: 10px;
        }

        .class-calendar-weekday {
            padding: 8px 6px;
            background: #f7f9fc;
            border-bottom: 1px solid #e8edf3;
            color: #7b8794;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .04em;
            text-align: center;
            text-transform: uppercase;
        }

        .class-calendar-day {
            min-height: 96px;
            padding: 6px;
            border-right: 1px solid #e8edf3;
            border-bottom: 1px solid #e8edf3;
            background: #fff;
        }

        .class-calendar-day:nth-child(7n) {
            border-right: 0;
        }

        .class-calendar-day.is-outside {
            background: #fbfcfe;
        }

        .class-calendar-day.is-outside .calendar-day-number {
            color: #b8c1cc;
        }

        .class-calendar-day.is-today .calendar-day-number {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background: #4361ee;
            color: #fff;
        }

        .calendar-day-number {
            display: inline-block;
            margin-bottom: 6px;
            color: #4b5563;
            font-size: 12px;
            font-weight: 700;
        }

        .calendar-event {
            display: block;
            width: 100%;
            overflow: hidden;
            margin-bottom: 4px;
            padding: 5px 7px;
            border: 0;
            border-left: 3px solid #4361ee;
            border-radius: 5px;
            background: #eef2ff;
            color: #263b80;
            font-size: 11px;
            line-height: 1.25;
            text-align: left;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .calendar-event.is-offline {
            border-left-color: #f59e0b;
            background: #fff7e6;
            color: #8a5a00;
        }

        .calendar-event.is-online {
            border-left-color: #10b981;
            background: #ecfdf5;
            color: #087a59;
        }

        .calendar-event.is-past {
            border-left-color: #9aa5b1;
            background: #f1f3f5;
            color: #6b7280;
        }

        .calendar-legend {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 10px;
        }

        .calendar-legend-item {
            color: #6b7280;
            font-size: 11px;
            font-weight: 600;
        }

        .calendar-legend-dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            margin-right: 4px;
            border-radius: 50%;
            background: #4361ee;
        }

        .calendar-legend-dot.is-past {
            background: #9aa5b1;
        }

        #classListView .table {
            font-size: 12px;
        }

        #classListView .table th,
        #classListView .table td {
            padding: 8px 6px;
        }

        .calendar-more {
            display: block;
            padding: 2px 5px;
            border: 0;
            background: transparent;
            color: #4361ee;
            font-size: 11px;
            font-weight: 700;
        }

        .calendar-empty {
            padding: 40px 16px;
            color: #7b8794;
            text-align: center;
        }

        @media (max-width: 767.98px) {
            .calendar-summary {
                grid-template-columns: 1fr;
            }

            .class-calendar-toolbar {
                flex-wrap: wrap;
                justify-content: center;
            }

            .class-calendar-toolbar h4 {
                order: -1;
                width: 100%;
            }

            .class-calendar-layout {
                grid-template-columns: 1fr;
            }

            .class-calendar-day {
                min-height: 74px;
                padding: 5px;
            }

            .calendar-event {
                padding: 4px;
                font-size: 10px;
            }

            .class-calendar-weekday {
                padding: 8px 2px;
                font-size: 9px;
            }
        }
    </style>
    <div class="col-lg-12">
        <div class="card shadow-sm border-0 mb-4">
            {{-- Card Header / Filter Bar --}}
            <div class="card-body">
                <form action="/admin/classes" method="GET">
                    <div class="row align-items-center justify-content-between g-3">
                        <div class="col-lg-8">
                            <div class="row align-items-center">
                                {{-- Range Date Filter --}}
                                <div class="col-md-7 mb-2 mb-md-0">
                                    <label class="form-label font-weight-bold text-muted small mb-1">Periode Tanggal</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control" value="{{ $param['date_start'] }}"
                                            name="param_date_start" aria-label="Date Start">
                                        <div class="input-group-append input-group-prepend">
                                            <span class="input-group-text bg-light text-muted">s/d</span>
                                        </div>
                                        <input type="date" class="form-control" value="{{ $param['date_end'] }}"
                                            name="param_date_end" aria-label="Date End">
                                    </div>
                                </div>

                                {{-- Action Buttons --}}
                                <div class="col-md-5 d-flex align-items-end mt-2 mt-md-0 pt-md-4">
                                    <button class="btn btn-primary mr-2 flex-grow-1" type="submit">
                                        <i class="bx bx-search-alt mr-1"></i> Cari
                                    </button>
                                    <a href="/admin/classes" class="btn btn-outline-secondary">
                                        <i class="bx bx-refresh mr-1"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </div>

                        {{-- Add New Class --}}
                        <div class="col-lg-4 text-lg-right mt-3 mt-lg-0 pt-lg-4">
                            <a href="/admin/classes/create" class="btn btn-success px-4">
                                <i class="bx bx-plus mr-1"></i> Tambah Kelas Baru
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-4" id="classCalendarView">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between flex-wrap mb-3">
                    <div>
                        <h4 class="font-weight-bold mb-1"><i class="bx bx-calendar mr-2 text-primary"></i>Kalender Kelas</h4>
                        <p class="text-muted small mb-0">Jadwal pelaksanaan dan sesi kelas dari data kelas yang dipilih.</p>
                    </div>
                    <span class="badge badge-light border text-muted mt-2 mt-md-0">
                        <i class="bx bx-info-circle mr-1"></i> Klik jadwal untuk melihat informasi kelas
                    </span>
                </div>

                <div class="calendar-summary">
                    <div class="calendar-summary-item">
                        <small>Total kelas pada filter</small>
                        <strong>{{ $calendarSummary['classes'] }}</strong>
                    </div>
                    <div class="calendar-summary-item">
                        <small>Sesi terjadwal</small>
                        <strong>{{ $calendarSummary['scheduled'] }}</strong>
                    </div>
                    <div class="calendar-summary-item">
                        <small>Belum ada jadwal</small>
                        <strong>{{ $calendarSummary['without_schedule'] }}</strong>
                    </div>
                </div>

                <div class="class-calendar-layout">
                    <div>
                        <div class="class-calendar-toolbar">
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-outline-secondary" id="calendarPrevious" aria-label="Bulan sebelumnya">
                                    <i class="bx bx-chevron-left"></i>
                                </button>
                                <button type="button" class="btn btn-outline-secondary" id="calendarToday">Hari ini</button>
                                <button type="button" class="btn btn-outline-secondary" id="calendarNext" aria-label="Bulan berikutnya">
                                    <i class="bx bx-chevron-right"></i>
                                </button>
                            </div>
                            <h4 id="calendarMonthLabel"></h4>
                            <span class="small text-muted"><i class="bx bx-time-five mr-1"></i>Waktu lokal</span>
                        </div>

                        <div id="classCalendarGrid" class="class-calendar-grid" aria-live="polite"></div>
                        <div class="calendar-legend" aria-label="Keterangan warna kalender">
                            <span class="calendar-legend-item"><span class="calendar-legend-dot"></span>Akan datang</span>
                            <span class="calendar-legend-item"><span class="calendar-legend-dot is-past"></span>Sudah terlewat</span>
                        </div>
                        @if (count($calendarEvents) === 0)
                            <div class="calendar-empty">Belum ada tanggal pelaksanaan atau sesi event pada hasil filter ini.</div>
                        @endif
                    </div>

                    <aside class="class-info-panel">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="font-weight-bold mb-0"><i class="bx bx-book-content mr-2 text-primary"></i>Informasi Kelas</h5>
                            <span id="calendarInfoStatus" class="badge badge-success">-</span>
                        </div>
                        <div id="calendarInfoEmpty" class="calendar-empty py-4 px-0">
                            Pilih jadwal pada kalender untuk melihat informasi kelas.
                        </div>
                        <div id="calendarInfoContent" style="display: none;">
                            <h5 id="calendarInfoTitle" class="font-weight-bold mb-3"></h5>
                            <div class="class-info-value">
                                <small>Kategori</small>
                                <span id="calendarInfoCategory"></span>
                            </div>
                            <div class="class-info-value">
                                <small>Jadwal</small>
                                <span id="calendarInfoTime"></span>
                            </div>
                            <div class="class-info-value">
                                <small>Jenis / Lokasi</small>
                                <span id="calendarInfoLocation"></span>
                            </div>
                            <div class="class-info-value">
                                <small>Kapasitas Peserta</small>
                                <span id="calendarInfoCapacity"></span>
                            </div>
                            <div class="class-info-value">
                                <small>Keterangan</small>
                                <span id="calendarInfoDescription"></span>
                            </div>
                            <a href="#" id="calendarInfoManage" class="btn btn-sm btn-primary btn-block mb-3">
                                <i class="bx bx-edit mr-1"></i>Kelola Event Kelas
                            </a>
                            <button type="button" id="calendarInfoDetail" class="btn btn-sm btn-outline-secondary btn-block">
                                <i class="bx bx-detail mr-1"></i>Lihat Detail Jadwal
                            </button>
                        </div>
                        <div class="border-top pt-3 mt-3">
                            <h6 class="font-weight-bold text-dark mb-2">Kelas di bulan ini</h6>
                            <div id="calendarMonthClasses" class="calendar-class-list">
                                <span class="small text-muted">Belum ada jadwal pada bulan ini.</span>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>

        {{-- Main Table Section --}}
        <div class="card shadow-sm border-0" id="classListView">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="tblClasses" class="table table-hover align-middle mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th width="5%">Status</th>
                                <th>Pendaftaran</th>
                                <th>Pelaksanaan</th>
                                <th>Tipe</th>
                                <th>Jam</th>
                                <th width="20%">Kelas</th>
                                <th>Kategori</th>
                                <th>Instruktur</th>
                                <th class="text-center" width="10%">
                                    Peserta<br>
                                    <small class="text-muted"><span class="text-danger font-weight-bold">A</span> (All) |
                                        <span class="text-success font-weight-bold">L</span> (Lunas)</small>
                                </th>
                                <th class="text-center">Data</th>
                                <th class="text-center" width="8%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($classes as $k => $v)
                                <tr>
                                    {{-- Status Badge --}}
                                    <td>
                                        <span
                                            class="badge badge-{{ $v->status == 1 ? 'success' : 'danger' }} badge-pill px-2 py-1">
                                            {{ $v->status == 1 ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>

                                    {{-- Date --}}
                                    <td>
                                        <span
                                            hidden>{{ $v->date_start ? Carbon\Carbon::parse($v->date_start)->format('U') : 0 }}</span>
                                        @if (!$v->date_start && !$v->date_end && $v->iht == 1)
                                            <span class="badge badge-soft-info badge-pill">Kelas IHT</span>
                                        @elseif($v->date_start)
                                            <div class="small font-weight-bold">
                                                {{ Carbon\Carbon::parse($v->date_start)->format('d/m/Y') }}
                                                <span class="text-muted">s/d</span>
                                                {{ Carbon\Carbon::parse($v->date_end)->format('d/m/Y') }}
                                            </div>
                                        @else
                                            <span class="badge badge-light text-muted">Akan Datang</span>
                                        @endif
                                    </td>

                                    {{-- Class Date --}}
                                    <td>
                                        @if ($v->class_date)
                                            <span class="small font-weight-bold">
                                                {{ Carbon\Carbon::parse($v->class_date)->format('d/m/Y') }}
                                            </span>
                                        @else
                                            <span class="badge badge-light text-muted">Belum Set</span>
                                        @endif
                                    </td>

                                    {{-- Class Type --}}
                                    <td>
                                        <span class="badge badge-{{ $v->kategori == 0 ? 'primary' : 'info' }}">
                                            {{ $v->kategori == 0 ? 'Online' : 'Offline' }}
                                        </span>
                                    </td>

                                    {{-- Time --}}
                                    <td>
                                        @if (!$v->date_start && !$v->date_end && $v->iht == 1)
                                            <span class="badge badge-soft-info">Kelas IHT</span>
                                        @elseif($v->jam_acara != null)
                                            <small class="font-weight-bold text-dark"><i
                                                    class="bx bx-time-five mr-1"></i>{{ $v->jam_acara }}</small>
                                        @else
                                            <span class="badge badge-soft-danger text-danger">Belum Set</span>
                                        @endif
                                    </td>

                                    {{-- Class Title --}}
                                    <td>
                                        <div class="text-truncate font-weight-bold text-dark" style="max-width: 220px;"
                                            title="{{ $v->title }}">
                                            {{ $v->title }}
                                        </div>
                                    </td>

                                    {{-- Category --}}
                                    <td><span class="text-muted small font-weight-bold">{{ $v->category }}</span></td>

                                    {{-- Instructors --}}
                                    <td>
                                        @foreach ($v->instructor_list as $i)
                                            <span
                                                class="badge badge-light border text-dark mr-1 mb-1">{{ $i->name }}</span>
                                        @endforeach
                                    </td>

                                    {{-- Participants Count --}}
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-outline-danger py-0 px-2 bs-tooltip"
                                            title="Total Peserta" data-toggle="modal" data-target="#listPesertaModal"
                                            onclick="openPeserta({{ $v->peserta_list['all'] }}, {{ $v->id }})">
                                            {{ count($v->peserta_list['all']) }}
                                        </button>
                                        <span class="text-muted mx-1">|</span>
                                        <button type="button" class="btn btn-sm btn-outline-success py-0 px-2 bs-tooltip"
                                            title="Peserta Lunas" data-toggle="modal" data-target="#listPesertaModal"
                                            onclick="openPeserta({{ $v->peserta_list['lunas'] }}, {{ $v->id }})">
                                            {{ count($v->peserta_list['lunas']) }}
                                        </button>
                                    </td>

                                    {{-- Quick Data Actions --}}
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <button
                                                class="btn {{ $v->pricing ? 'btn-info' : 'btn-outline-secondary' }} bs-tooltip"
                                                title="Pricing" onclick="classPricing({{ $v }})">
                                                <i class="bx bx-dollar"></i>
                                            </button>
                                            <button
                                                class="btn {{ count($v->content_list) > 0 ? 'btn-success' : 'btn-outline-secondary' }} bs-tooltip"
                                                title="File Content" onclick="classContent({{ $v }})">
                                                <i class="bx bx-file"></i>
                                            </button>
                                            <a class="btn {{ $v->events_exist ? 'btn-primary' : 'btn-outline-secondary' }} bs-tooltip"
                                                title="Event Schedule"
                                                href="/admin/classes/createevent/{{ $v->id }}">
                                                <i class="bx bx-calendar"></i>
                                            </a>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <button
                                                    class="btn {{ $v->certif_exist ? 'btn-warning text-white' : 'btn-outline-secondary' }} dropdown-toggle bs-tooltip"
                                                    type="button" data-toggle="dropdown" aria-expanded="false"
                                                    title="Certificate Setting">
                                                    <i class="bx bx-certification"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right shadow border-0">
                                                    <a class="dropdown-item"
                                                        href="/admin/classes/createcertificate/{{ $v->id }}"><i
                                                            class="bx bx-plus-circle mr-2"></i>Create Certificate</a>
                                                    <a class="dropdown-item"
                                                        href="/admin/classes/previewcertificate/{{ $v->id }}"
                                                        target="_blank"><i class="bx bx-show mr-2"></i>Show
                                                        Certificate</a>
                                                    <a class="dropdown-item"
                                                        href="/admin/classes/getreview/{{ $v->id }}"
                                                        target="_blank"><i class="bx bx-star mr-2"></i>Show Review</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item text-primary" href="javascript:void(0)"
                                                        data-toggle="modal" data-target="#modalSertifikat"
                                                        onclick="biayasertifikat('{{ $v->id }}','{{ $v->tipebs }}','{{ $v->nominal }}')">
                                                        <i class="bx bx-coin-stack mr-2"></i>Biaya Sertifikat
                                                    </a>
                                                </div>
                                            </div>
                                            <button
                                                class="btn {{ $v->videos ? 'btn-info' : 'btn-outline-secondary' }} bs-tooltip"
                                                title="Video Material" onclick="classVideo({{ $v }})">
                                                <i class="bx bx-video-plus"></i>
                                            </button>
                                        </div>
                                    </td>

                                    {{-- Main Options Dropdown --}}
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light border dropdown-toggle" type="button"
                                                data-toggle="dropdown" aria-expanded="false">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right shadow border-0">
                                                @if ($v->landing_page_enabled)
                                                    <a class="dropdown-item" href="{{ route('frontend.class.landing', $v->slug) }}"
                                                        target="_blank" rel="noopener"><i
                                                            class="bx bx-mobile-alt text-success mr-2"></i>Buka Landing Promo</a>
                                                @endif
                                                <form action="{{ route('admin.classes.landing.generate', $v->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item {{ $v->landing_page_enabled ? 'text-primary' : 'text-success' }}"
                                                        onclick="return {{ $v->landing_page_enabled ? 'confirm(\'Ganti tema landing page ini?\')' : 'true' }}">
                                                        <i class="bx {{ $v->landing_page_enabled ? 'bx-refresh' : 'bx-magic-wand' }} mr-2"></i>{{ $v->landing_page_enabled ? 'Regenerate Tema' : 'Generate Landing' }}
                                                    </button>
                                                </form>
                                                <a class="dropdown-item"
                                                    href="/admin/classes/{{ $v->id }}/edit"><i
                                                        class="bx bx-edit text-warning mr-2"></i>Edit</a>
                                                <a class="dropdown-item" href="javascript:void(0)"
                                                    onclick="activedClasses({{ $v->id }},{{ $v->status }})">
                                                    <i
                                                        class="bx bx-power-off text-info mr-2"></i>{{ $v->status == 1 ? 'De-Activate' : 'Activate' }}
                                                </a>
                                                <a class="dropdown-item" href="javascript:void(0)"
                                                    onclick="openClasses({{ $v->id }},{{ $v->is_open }})">
                                                    <i
                                                        class="bx bx-door-open text-primary mr-2"></i>{{ $v->is_open == 1 ? 'Close Class' : 'Open Class' }}
                                                </a>
                                                <a class="dropdown-item" href="javascript:void(0)"
                                                    data-target="#upcomingmodal" data-toggle="modal"
                                                    onclick="setupcoming({{ $v }})">
                                                    <i class="bx bx-time text-secondary mr-2"></i>Set Status Running
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item text-danger" href="javascript:void(0)"
                                                    onclick="deleteClasses({{ $v->id }})">
                                                    <i class="bx bx-trash mr-2"></i>Hapus
                                                </a>
                                                <form action="#" method="post" id="formdelclasses">@csrf
                                                    @method('DELETE')</form>
                                                <form action="#" method="get" id="formacclasses">@csrf</form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <div class="modal fade" id="calendarEventModal" tabindex="-1" aria-labelledby="calendarEventModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-light">
                    <h5 class="modal-title font-weight-bold" id="calendarEventModalLabel">Detail Jadwal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <h5 id="calendarEventTitle" class="font-weight-bold text-dark mb-3"></h5>
                    <dl class="row mb-0 small">
                        <dt class="col-4 text-muted">Jenis</dt>
                        <dd class="col-8" id="calendarEventKind"></dd>
                        <dt class="col-4 text-muted">Waktu</dt>
                        <dd class="col-8" id="calendarEventTime"></dd>
                        <dt class="col-4 text-muted">Lokasi</dt>
                        <dd class="col-8" id="calendarEventLocation"></dd>
                        <dt class="col-4 text-muted">Keterangan</dt>
                        <dd class="col-8" id="calendarEventDescription"></dd>
                    </dl>
                </div>
                <div class="modal-footer bg-light">
                    <a href="#" id="calendarEventManage" class="btn btn-primary"><i class="bx bx-edit mr-1"></i>Kelola Event Kelas</a>
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal List Peserta --}}
    <div class="modal fade" id="listPesertaModal" tabindex="-1" aria-labelledby="listPesertaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-light">
                    <h5 class="modal-title font-weight-bold" id="listPesertaModalLabel"><i
                            class="bx bx-group mr-2"></i>List Peserta Sertifikat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="tblListPeserta" class="table table-hover table-striped mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Status</th>
                                    {{-- <th>Nama Akun</th> --}}
                                    <th>Nama Sertifikat</th>
                                    <th>No HP</th>
                                    <th>Instansi</th>
                                    <th>Price</th>
                                    <th>Sertifikat</th>
                                </tr>
                            </thead>
                            <tbody id="listPeserta"></tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Biaya Sertifikat --}}
    <div class="modal fade" id="modalSertifikat" tabindex="-1" aria-labelledby="modalSertifikatLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <form action="/classes/biaya_certificate" method="POST">
                    @csrf
                    <div class="modal-header bg-light">
                        <h5 class="modal-title font-weight-bold" id="modalSertifikatLabel"><i
                                class="bx bx-coin-stack mr-2"></i>Biaya Sertifikat</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="text" name="id_kelas" id="id_kelas" hidden>
                        <div class="form-group">
                            <label class="font-weight-bold">Tipe Biaya</label>
                            <select name="tipe" id="tipe" class="form-control" required>
                                <option value="0">Nominal (Fixed IDR)</option>
                                <option value="1">Persentase (%)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Nominal / Persentase</label>
                            <input type="text" name="nominal" id="nominal" class="form-control"
                                placeholder="Masukkan nilai" required>
                            <small id="labelNominal" class="form-text text-primary font-weight-bold mt-1"></small>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Upcoming / Reschedule / Running --}}
    <div class="modal fade" id="upcomingmodal" tabindex="-1" aria-labelledby="upcomingmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-light">
                    <h5 class="modal-title font-weight-bold"><i class="bx bx-time-five mr-2"></i>Update Status Kelas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/admin/classes/setupcoming" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="text" name="upcoming_id" id="upcoming_id" hidden>
                        <div class="form-group">
                            <label class="font-weight-bold mb-3">Pilih Status Keberlangsungan Kelas:</label>
                            <div class="custom-control custom-radio mb-2">
                                <input type="radio" id="upcoming0" name="upcoming" value="0"
                                    class="custom-control-input">
                                <label class="custom-control-label font-weight-bold text-success" for="upcoming0">
                                    Running <small class="text-muted d-block">Kelas sedang berjalan aktif</small>
                                </label>
                            </div>
                            <div class="custom-control custom-radio mb-2">
                                <input type="radio" id="upcoming2" name="upcoming" value="2"
                                    class="custom-control-input">
                                <label class="custom-control-label font-weight-bold text-warning" for="upcoming2">
                                    Re-Schedule <small class="text-muted d-block">Jadwal kelas ditunda / diubah</small>
                                </label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="upcoming3" name="upcoming" value="1"
                                    class="custom-control-input">
                                <label class="custom-control-label font-weight-bold text-info" for="upcoming3">
                                    Upcoming <small class="text-muted d-block">Kelas dijadwalkan di masa depan</small>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
                        <button class="btn btn-primary px-4" type="submit">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('backend.classes.newclassesmodal')
    @include('backend.classes.classpricingmodal')
    @include('backend.classes.classvideomodal')
    @include('backend.classes.classcontentmodal')
@endsection

@section('custom-js')
    <script>
        const classCalendarEvents = @json($calendarEvents);
        let calendarCursor = new Date();

        function calendarDateKey(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');

            return `${year}-${month}-${day}`;
        }

        function calendarEventTime(event) {
            if (event.all_day) {
                return 'Sepanjang hari';
            }

            const start = new Date(event.start);
            const end = event.end ? new Date(event.end) : null;
            const formatTime = date => date.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit'
            });

            return `${formatTime(start)}${end ? ' - ' + formatTime(end) : ''}`;
        }

        function calendarEventDate(event) {
            const date = new Date(`${event.date}T00:00:00`);

            return date.toLocaleDateString('id-ID', {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
        }

        function renderClassCalendar() {
            const grid = document.getElementById('classCalendarGrid');
            const year = calendarCursor.getFullYear();
            const month = calendarCursor.getMonth();
            const monthLabel = new Date(year, month, 1).toLocaleDateString('id-ID', {
                month: 'long',
                year: 'numeric'
            });
            const firstDay = (new Date(year, month, 1).getDay() + 6) % 7;
            const eventsByDate = classCalendarEvents.reduce((groups, event, index) => {
                if (!groups[event.date]) {
                    groups[event.date] = [];
                }
                groups[event.date].push({
                    ...event,
                    index
                });
                return groups;
            }, {});

            document.getElementById('calendarMonthLabel').textContent = monthLabel;
            grid.innerHTML = '';

            ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'].forEach(day => {
                const weekday = document.createElement('div');
                weekday.className = 'class-calendar-weekday';
                weekday.textContent = day;
                grid.appendChild(weekday);
            });

            for (let cellIndex = 0; cellIndex < 42; cellIndex++) {
                const date = new Date(year, month, cellIndex - firstDay + 1);
                const dateKey = calendarDateKey(date);
                const day = document.createElement('div');
                const isOutside = date.getMonth() !== month;
                const isToday = dateKey === calendarDateKey(new Date());
                day.className = `class-calendar-day${isOutside ? ' is-outside' : ''}${isToday ? ' is-today' : ''}`;

                const number = document.createElement('span');
                number.className = 'calendar-day-number';
                number.textContent = date.getDate();
                day.appendChild(number);

                const dateEvents = eventsByDate[dateKey] || [];
                dateEvents.slice(0, 4).forEach(event => {
                    const eventButton = document.createElement('button');
                    eventButton.type = 'button';
                    eventButton.className = `calendar-event ${event.type === 1 ? 'is-offline' : 'is-online'} ${event.is_past ? 'is-past' : 'is-upcoming'}`;
                    eventButton.dataset.eventIndex = event.index;
                    eventButton.title = `${event.title} - ${calendarEventTime(event)}`;
                    eventButton.textContent = event.all_day ? event.title : `${calendarEventTime(event)} ${event.title}`;
                    day.appendChild(eventButton);
                });

                if (dateEvents.length > 4) {
                    const more = document.createElement('span');
                    more.className = 'calendar-more';
                    more.textContent = `+ ${dateEvents.length - 4} lainnya`;
                    day.appendChild(more);
                }

                grid.appendChild(day);
            }

            renderCalendarMonthInfo();
        }

        let selectedCalendarEventIndex = null;

        function renderCalendarMonthInfo() {
            const monthEvents = classCalendarEvents
                .map((event, index) => ({
                    ...event,
                    index
                }))
                .filter(event => {
                    const date = new Date(`${event.date}T00:00:00`);
                    return date.getFullYear() === calendarCursor.getFullYear() && date.getMonth() === calendarCursor.getMonth();
                });
            const classes = new Map();

            monthEvents.forEach(event => {
                if (!classes.has(event.class_id)) {
                    classes.set(event.class_id, {
                        ...event,
                        totalEvents: 0
                    });
                }
                classes.get(event.class_id).totalEvents++;
            });

            const list = document.getElementById('calendarMonthClasses');
            list.innerHTML = '';

            if (classes.size === 0) {
                list.innerHTML = '<span class="small text-muted">Belum ada jadwal pada bulan ini.</span>';
                selectedCalendarEventIndex = null;
                document.getElementById('calendarInfoEmpty').style.display = '';
                document.getElementById('calendarInfoContent').style.display = 'none';
                const status = document.getElementById('calendarInfoStatus');
                status.textContent = '-';
                status.classList.remove('badge-success', 'badge-danger', 'badge-primary', 'badge-secondary');
                return;
            }

            classes.forEach(event => {
                const button = document.createElement('button');
                button.type = 'button';
                button.className = 'calendar-class-link';
                button.dataset.eventIndex = event.index;

                const title = document.createElement('strong');
                title.textContent = event.class_title;
                const meta = document.createElement('small');
                meta.textContent = `${event.totalEvents} jadwal | ${event.category || 'Tanpa kategori'}`;
                button.append(title, meta);
                list.appendChild(button);
            });

            const selectedIsVisible = monthEvents.some(event => event.index === selectedCalendarEventIndex);
            if (!selectedIsVisible) {
                showCalendarEvent(monthEvents[0].index);
            }
        }

        function showCalendarEvent(eventIndex) {
            const event = classCalendarEvents[eventIndex];
            if (!event) {
                return;
            }

            selectedCalendarEventIndex = eventIndex;
            document.getElementById('calendarInfoEmpty').style.display = 'none';
            document.getElementById('calendarInfoContent').style.display = '';
            const status = document.getElementById('calendarInfoStatus');
            status.textContent = event.schedule_status;
            status.classList.remove('badge-success', 'badge-danger');
            status.classList.toggle('badge-primary', !event.is_past);
            status.classList.toggle('badge-secondary', event.is_past);
            document.getElementById('calendarInfoTitle').textContent = event.class_title;
            document.getElementById('calendarInfoCategory').textContent = `${event.category || '-'} | ${event.class_type}`;
            document.getElementById('calendarInfoTime').textContent = `${calendarEventDate(event)}, ${calendarEventTime(event)}`;
            document.getElementById('calendarInfoLocation').textContent = event.location || (event.all_day ? event.class_type : 'Online');
            document.getElementById('calendarInfoCapacity').textContent = event.participant_limit || 'Tidak dibatasi';
            document.getElementById('calendarInfoDescription').textContent = event.description || 'Tidak ada keterangan.';
            document.getElementById('calendarInfoManage').href = event.manage_url;
        }

        function openCalendarEventDetail(eventIndex) {
            const event = classCalendarEvents[eventIndex];
            if (!event) {
                return;
            }

            document.getElementById('calendarEventTitle').textContent = event.class_title;
            document.getElementById('calendarEventKind').textContent = event.kind;
            document.getElementById('calendarEventTime').textContent = `${calendarEventDate(event)}, ${calendarEventTime(event)}`;
            document.getElementById('calendarEventLocation').textContent = event.location || (event.all_day ? event.class_type : 'Online');
            document.getElementById('calendarEventDescription').textContent = event.description || '-';
            document.getElementById('calendarEventManage').href = event.manage_url;
            $('#calendarEventModal').modal('show');
        }

        $('#calendarPrevious').on('click', function() {
            calendarCursor.setMonth(calendarCursor.getMonth() - 1);
            renderClassCalendar();
        });

        $('#calendarNext').on('click', function() {
            calendarCursor.setMonth(calendarCursor.getMonth() + 1);
            renderClassCalendar();
        });

        $('#calendarToday').on('click', function() {
            calendarCursor = new Date();
            renderClassCalendar();
        });

        $('#classCalendarGrid').on('click', '.calendar-event', function() {
            showCalendarEvent(Number(this.dataset.eventIndex));
        });

        $('#calendarMonthClasses').on('click', '.calendar-class-link', function() {
            showCalendarEvent(Number(this.dataset.eventIndex));
        });

        $('#calendarInfoDetail').on('click', function() {
            openCalendarEventDetail(selectedCalendarEventIndex);
        });

        renderClassCalendar();
        createDataTable('#tblClasses');
        createDataTable('#tblListPeserta');

        $(document).ready(function() {
            $('#tipe, #nominal').on('input change', function() {
                var v = $('#nominal').val();
                if ($('#tipe').val() == 0) {
                    var n = Number(v).toLocaleString('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    });
                    $('#labelNominal').text(n);
                } else {
                    $('#labelNominal').text(v + ' %');
                }
            });

            $('#numClassPrice').on('input change', function() {
                toggleDiscountInput();
                updatePricingPreview();
            });

            $(document).on('click', '.pricing-help', function(event) {
                event.preventDefault();
                event.stopPropagation();

                $('.pricing-help-panel').remove();
                $('<span>', {
                    class: 'pricing-help-panel',
                    role: 'tooltip',
                    text: $(this).data('help-title') + ': ' + $(this).data('help-content')
                }).insertAfter(this);
            });

            $(document).on('click', function(event) {
                if (!$(event.target).closest('.pricing-help, .pricing-help-panel').length) {
                    $('.pricing-help-panel').remove();
                }
            });

            $('#discount_type').on('change', function() {
                toggleDiscountInput();
                updatePricingPreview();
            });

            $('#discount_value').on('input change', function() {
                if ($('#discount_type').val() === 'nominal') {
                    $(this).val(formatRupiah($(this).val()));
                }
                updatePricingPreview();
            });

            $('#newClassesForm').on('submit', function() {
                if ($('#discount_type').val() === 'nominal') {
                    $('#discount_value').val(normalizeRupiah($('#discount_value').val()));
                }

                $('.participant-discount-amount').each(function() {
                    $(this).val(normalizeRupiah($(this).val()));
                });
            });

            $(document).on('input', '.participant-discount-amount', function() {
                $(this).val(formatRupiah($(this).val()));
            });
        });

        function toggleDiscountInput() {
            var nominal = $('#discount_type').val() === 'nominal';
            var price = Number($('#numClassPrice').val()) || 0;
            $('#discount-currency-prefix').toggle(nominal);
            $('#discount-percent-suffix').toggle(!nominal);
            $('#discount_value').attr('max', nominal ? price * 0.15 : 15);

            if (nominal) {
                $('#discount_value').attr('inputmode', 'numeric');
                $('#discount_value').val(formatRupiah($('#discount_value').val()));
            } else {
                $('#discount_value').attr('inputmode', 'decimal');
                $('#discount_value').val(normalizePercent($('#discount_value').val()));
            }
        }

        function normalizeRupiah(value) {
            return String(value || '').replace(/\D/g, '');
        }

        function formatRupiah(value) {
            var normalized = normalizeRupiah(value);
            return normalized ? Number(normalized).toLocaleString('id-ID') : '';
        }

        function normalizePercent(value) {
            return String(value || '').replace(/[^0-9.,]/g, '').replace(',', '.');
        }

        function updatePricingPreview() {
            var price = Number($('#numClassPrice').val()) || 0;
            var rawValue = $('#discount_type').val() === 'nominal' ?
                normalizeRupiah($('#discount_value').val()) :
                normalizePercent($('#discount_value').val());
            var value = Number(rawValue) || 0;
            var discount = $('#discount_type').val() === 'percent' ?
                price * value / 100 :
                value;

            $('#nomClassPrice').text('Rp. ' + price.toLocaleString('id-ID'));
            $('#discount-preview').text(
                'Harga setelah diskon: Rp ' + Math.max(0, price - discount).toLocaleString('id-ID')
            );
        }

        function updateParticipantDiscountEmptyState() {
            $('#participantDiscountEmpty').toggle($('#participantDiscountRows tr').length === 0);
        }

        function addParticipantDiscountRow(minimumParticipants, discountAmount) {
            var minimum = minimumParticipants || '';
            var amount = discountAmount || '';
            var row = $('<tr>');
            row.append($('<td>').append($('<input>', {
                type: 'number',
                name: 'participant_discount_minimum[]',
                class: 'form-control',
                min: 1,
                step: 1,
                required: true,
                value: minimum,
                placeholder: 'Contoh: 2'
            })));
            row.append($('<td>').append($('<div>', {
                class: 'input-group'
            }).append($('<div>', {
                class: 'input-group-prepend'
            }).append($('<span>', {
                class: 'input-group-text',
                text: 'Rp'
            }))).append($('<input>', {
                type: 'text',
                name: 'participant_discount_amount[]',
                class: 'form-control participant-discount-amount',
                inputmode: 'numeric',
                required: true,
                value: formatRupiah(amount),
                placeholder: 'Contoh: 50.000'
            }))));
            row.append($('<td>', {
                class: 'text-center'
            }).append($('<button>', {
                type: 'button',
                class: 'btn btn-sm btn-outline-danger',
                title: 'Hapus kondisi',
                html: '<i class="bx bx-trash"></i>',
                click: function() {
                    row.remove();
                    updateParticipantDiscountEmptyState();
                }
            })));
            $('#participantDiscountRows').append(row);
            updateParticipantDiscountEmptyState();
        }

        function biayasertifikat(id, tipe, nominal) {
            $('#id_kelas').val(id);
            $('#tipe').val(tipe);
            $('#nominal').val(nominal);
            $('#nominal').change();
        }

        function openPeserta(data, id_class) {
            let html = '';
            $('#listPeserta').html('');

            if (data.length > 0) {
                data.forEach(el => {
                    try {
                        if (el.nama_sertifikat && el.nama_sertifikat.startsWith('[')) {
                            daftarNama = JSON.parse(el.nama_sertifikat);
                        } else if (el.nama_sertifikat) {
                            daftarNama = [el.nama_sertifikat]; // Jika bukan array, jadikan array tunggal
                        } else {
                            daftarNama = [el.user_name]; // Fallback ke nama akun jika data sertifikat kosong
                        }
                    } catch (e) {
                        daftarNama = [el.nama_sertifikat];
                    }
                    daftarNama.forEach(namaIndividu => {
                        let status = el.status ? '<span class="badge badge-success">Lunas</span>' :
                            '<span class="badge badge-warning">Belum Lunas</span>';
                        html += `
                    <tr>
                        <td>${status}</td>
                        <td>${namaIndividu ?? '-'}</td>
                        <td>${el.phone ?? '-'}</td>
                        <td>${el.user_name ?? '-'}</td>
                        <td>Rp ${Number(el.price || 0).toLocaleString('id-ID')}</td>
                      <td><a class="btn btn-primary" title="Preview" href="/admin/classes/previewcertificate/${id_class}/${namaIndividu}/${el.user_name}" target="_blank">Show Certificate</a></td>
                    </tr>
                `;
                    });
                })
            } else {
                html = `<tr><td colspan="7" class="text-center text-muted py-3">Tidak ada data peserta.</td></tr>`;
            }
            $('#listPeserta').html(html);
        }

        function activedClasses(id, s) {
            swal({
                title: 'Are you sure?',
                text: "You want change status class?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Confirm',
                padding: '2em'
            }).then(function(result) {
                if (result.value) {
                    $('#formacclasses').attr('action', '/admin/classes/activated/' + id + '/' + s);
                    $('#formacclasses').submit();
                } else {
                    $('#formacclasses').attr('action', '#');
                }
            })
        }

        function deleteClasses(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                padding: '2em'
            }).then(function(result) {
                if (result.value) {
                    $('#formdelclasses').attr('action', '/admin/classes/' + id);
                    $('#formdelclasses').submit();
                } else {
                    $('#formdelclasses').attr('action', '#');
                }
            })
        }

        function classVideo(c) {
            $('.hdnClassesId').val(c.id);
            $('.activeClassTitle').text(c.title);
            if (c.videos) {
                $('#video_preview').attr('src', '/video/kelas/' + `{{ Auth::user()->email }}` + '/' + c.videos.image);
            }
            openmodal('#classVideoModal');
        }

        function classPricing(c) {
            $('#numClassPrice').val(0);
            $('#discount_type').val('percent');
            $('#discount_value').val(0);
            $('#individual_discount').val(0);
            $('#company_online_discount').val(0);
            $('#company_offline_discount').val(0);
            $('#company_iht_discount').val(0);
            $('#iht-discount-only').val(0);
            $('#bolClassGratis').prop('checked', false);
            $('#participantDiscountRows').empty();
            updateParticipantDiscountEmptyState();

            const isIht = Number(c.iht) === 1;
            const classType = isIht ? 'iht' : (Number(c.kategori) === 1 ? 'offline' : 'online');
            $('#regular-pricing-fields').toggle(!isIht);
            $('#iht-pricing-fields').toggle(isIht);
            $('#numClassPrice').prop('required', !isIht);
            $('.company-discount-online').toggle(classType === 'online');
            $('.company-discount-offline').toggle(classType === 'offline');
            $('.company-discount-iht').toggle(classType === 'iht');

            if (c.pricing) {
                $('#numClassPrice').val(c.pricing.price).trigger('change').trigger('input');
                if (c.pricing.gratis == 1) {
                    $('#bolClassGratis').prop('checked', true);
                }

                $('#discount_type').val(c.pricing.discount_type || 'nominal');
                $('#discount_value').val(c.pricing.discount_value || c.pricing.promo_price || 0);

                const discounts = c.pricing.membership_discounts || [];
                const getDiscount = (membershipType, category) => {
                    const discount = discounts.find(item => item.membership_type === membershipType && item
                        .discount_category === category);
                    return discount ? discount.discount_percent : 0;
                };

                $('#individual_discount').val(getDiscount('individual', 'individual_class'));
                $('#company_online_discount').val(getDiscount('company', 'company_online'));
                $('#company_offline_discount').val(getDiscount('company', 'company_offline'));
                $('#company_iht_discount').val(getDiscount('company', 'company_iht'));
                $('#iht-discount-only').val(getDiscount('company', 'company_iht'));

                (c.pricing.participant_discounts || []).forEach(function(discount) {
                    addParticipantDiscountRow(discount.minimum_participants, discount.discount_amount);
                });
            }

            $('#discount_type').trigger('change');
            $('.hdnClassesId').val(c.id);
            $('.activeClassTitle').text(c.title);
            openmodal('#classPricingModal');
        }

        function classContent(c) {
            $('#tbdClassContent').html('');
            $('.hdnClassesId').val(c.id);
            if (c.content_list) {
                console.log(c.content_list);
                c.content_list.forEach(e => {
                    var sd = '';
                    var sg = '';
                    var sv = '';
                    var dd = 'style="display:none;"';
                    var dg = 'style="display:none;"';
                    var dv = 'style="display:none;"';

                    if (e.type == 1) {
                        sd = 'selected';
                        dd = '';
                    } else if (e.type == 2) {
                        sg = 'selected';
                        dg = '';
                    } else if (e.type == 3) {
                        sv = 'selected';
                        dv = '';
                    }

                    $('#tbdClassContent').append('' +
                        '<tr>' +
                        '	<td>' +
                        '		<input type="hidden" name="txtClassContentId[]" class="form-control txtClassContentId" value="' +
                        e.id + '">' +
                        '		<select name="slcClassContentType[]" class="form-control slcClassContentType" onchange="slcClassContentTypeChanged($(this))">' +
                        '			<option value="1" ' + sd + '>Dokumen</option>' +
                        '			<option value="2" ' + sg + '>Gambar</option>' +
                        '			<option value="3" ' + sv + '>Video</option>' +
                        '		</select>' +
                        '	</td>' +
                        '	<td>' +
                        '		<input type="text" name="txtClassContentTitle[]" class="form-control txtClassContentTitle" value="' +
                        e.title + '">' +
                        '	</td>' +
                        '	<td>' +
                        '		<small>Change File Only If Needed</small><a href="getBerkas?rf=/' + e.url +
                        '" target="_blank"> Download</a>' +
                        '		<input type="file" name="txtClassContentDoc[]" class="form-control txtClassContentDoc" ' +
                        dd + ' value="' + e.url + '">' +
                        '		<input type="file" name="txtClassContentImg[]" class="form-control txtClassContentImg" ' +
                        dg + ' value="' + e.url + '">' +
                        '		<input type="text" name="txtClassContentVid[]" class="form-control txtClassContentVid" ' +
                        dv + ' value="' + e.url + '">' +
                        '	</td>' +
                        '	<td>' +
                        '		<button class="btn btn-danger" onclick="delClassContentRow($(this),' + e.id +
                        ')"><i class="bx bx-trash"></i></button>' +
                        '	</td>' +
                        '</tr>' +
                        '');
                });
            }
            openmodal('#classContentModal');
        }

        function addNewClassContentRow() {
            $('#tbdClassContent').append(
                '<tr>' +
                '	<td>' +
                '		<input type="hidden" name="txtClassContentId[]" class="form-control txtClassContentId" value="0">' +
                '		<select name="slcClassContentType[]" class="form-control slcClassContentType" onchange="slcClassContentTypeChanged($(this))">' +
                '			<option value="1">Dokumen</option>' +
                '			<option value="2">Gambar</option>' +
                '			<option value="3">Video</option>' +
                '		</select>' +
                '	</td>' +
                '	<td>' +
                '		<input type="text" name="txtClassContentTitle[]" class="form-control txtClassContentTitle">' +
                '	</td>' +
                '	<td>' +
                '		<input type="file" name="txtClassContentDoc[]" class="form-control txtClassContentDoc">' +
                '		<input type="file" name="txtClassContentImg[]" class="form-control txtClassContentImg" style="display: none;">' +
                '		<input type="text" name="txtClassContentVid[]" class="form-control txtClassContentVid" style="display: none;">' +
                '	</td>' +
                '	<td>' +
                '		<button class="btn btn-danger" onclick="delClassContentRow($(this),0)"><i class="bx bx-trash"></i></button>' +
                '	</td>' +
                '</tr>');
        }

        function slcClassContentTypeChanged(ths) {
            ths.parent('td').parent('tr').find('.txtClassContentDoc,.txtClassContentImg,.txtClassContentVid').hide();
            var v = ths.val();
            if (v == 1) {
                ths.parent('td').parent('tr').find('.txtClassContentDoc').show();
            } else if (v == 2) {
                ths.parent('td').parent('tr').find('.txtClassContentImg').show();
            } else if (v == 3) {
                ths.parent('td').parent('tr').find('.txtClassContentVid').show();
            }
        }

        function delClassContentRow(ths, id) {
            var tr = ths.parent('td').parent('tr');
            $('.hdnContentTBDId').val($('.hdnContentTBDId').val() + ',' + id);
            if (!tr.attr('clsCtnId') || tr.attr('clsCtnId') == 0) {
                tr.remove();
            }
        }
    </script>
@endsection
