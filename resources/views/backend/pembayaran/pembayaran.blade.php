@extends('layouts.compact')

@section('content')
    <style>
        .payment-page {
            --payment-primary: #4f46e5;
            --payment-ink: #172033;
            --payment-muted: #748096;
            --payment-line: #e9edf5;
            color: var(--payment-ink);
        }

        .payment-page__heading {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 24px;
        }

        .payment-page__eyebrow {
            margin-bottom: 7px;
            color: var(--payment-primary);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .payment-page__title {
            margin-bottom: 5px;
            color: var(--payment-ink);
            font-size: 25px;
            font-weight: 800;
        }

        .payment-page__description {
            max-width: 650px;
            margin-bottom: 0;
            color: var(--payment-muted);
            font-size: 13px;
        }

        .payment-count {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
            padding: 9px 13px;
            color: #4338ca;
            background: #eef0ff;
            border: 1px solid #dfe2ff;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 800;
        }

        .payment-filter-card,
        .payment-table-card {
            border: 1px solid var(--payment-line) !important;
            border-radius: 16px !important;
            box-shadow: 0 8px 24px rgba(31, 41, 72, .06) !important;
        }

        .payment-filter-card__header,
        .payment-table-card__header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .payment-filter-card__header {
            margin-bottom: 20px;
        }

        .payment-section-title {
            margin: 0;
            color: var(--payment-ink);
            font-size: 15px;
            font-weight: 800;
        }

        .payment-section-subtitle {
            margin: 4px 0 0;
            color: var(--payment-muted);
            font-size: 12px;
        }

        .payment-filter-label {
            display: block;
            margin-bottom: 8px;
            color: #4b556b;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .02em;
        }

        .payment-date-inputs .form-control,
        .payment-date-inputs .input-group-text {
            height: 42px;
            border-color: var(--payment-line);
            font-size: 12px;
        }

        .payment-date-inputs .input-group-text {
            color: #8a94a6;
            background: #f8f9fc;
        }

        .payment-status-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 8px;
        }

        .payment-status-option {
            position: relative;
            min-width: 0;
        }

        .payment-status-option input {
            position: absolute;
            width: 1px;
            height: 1px;
            opacity: 0;
        }

        .payment-status-option label {
            display: flex;
            align-items: center;
            min-height: 37px;
            margin: 0;
            padding: 7px 9px;
            overflow: hidden;
            color: #667085;
            background: #fff;
            border: 1px solid var(--payment-line);
            border-radius: 9px;
            cursor: pointer;
            font-size: 11px;
            font-weight: 700;
            line-height: 1.2;
            text-overflow: ellipsis;
            transition: color .15s ease, background .15s ease, border-color .15s ease;
            white-space: nowrap;
        }

        .payment-status-option label::before {
            width: 7px;
            height: 7px;
            margin-right: 7px;
            flex: 0 0 7px;
            background: #c7cedb;
            border-radius: 50%;
            content: '';
        }

        .payment-status-option input:checked + label {
            color: #4338ca;
            background: #f2f3ff;
            border-color: #aeb4ff;
        }

        .payment-status-option input:checked + label::before {
            background: var(--payment-primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, .12);
        }

        .payment-status-option input:focus-visible + label {
            outline: 2px solid rgba(79, 70, 229, .35);
            outline-offset: 2px;
        }

        .payment-filter-actions {
            display: grid;
            grid-template-columns: minmax(0, 1.35fr) minmax(74px, .65fr);
            gap: 8px;
        }

        .payment-filter-actions .btn {
            height: 42px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 800;
        }

        .payment-table-card__header {
            padding: 17px 20px;
            border-bottom: 1px solid var(--payment-line);
        }

        .payment-table-card__meta {
            color: var(--payment-muted);
            font-size: 12px;
            font-weight: 600;
        }

        #tblPembayaran {
            min-width: 1180px;
        }

        #tblPembayaran thead th {
            padding-top: 13px;
            padding-bottom: 13px;
            color: #8a94a6;
            background: #fafbfe;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .06em;
            white-space: nowrap;
        }

        #tblPembayaran tbody td {
            padding-top: 15px;
            padding-bottom: 15px;
            border-color: #f0f2f7;
            vertical-align: middle;
        }

        #tblPembayaran tbody tr:hover {
            background: #fafbff;
        }

        @media (max-width: 767.98px) {
            .payment-page__heading {
                align-items: flex-start;
                flex-direction: column;
                gap: 12px;
            }

            .payment-page__title {
                font-size: 22px;
            }

            .payment-status-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }
    </style>
    <div class="container-fluid py-4 payment-page">

        {{-- Header Halaman --}}
        <div class="payment-page__heading">
            <div>
                <div class="payment-page__eyebrow">Administrasi Keuangan</div>
                <h1 class="payment-page__title">Kelola Pembayaran</h1>
                <p class="payment-page__description">Pantau transaksi masuk, verifikasi bukti transfer, dan kelola sertifikat
                    siswa.</p>
            </div>
            <div class="payment-count"><i class="bx bx-receipt"></i>{{ number_format($pembayaran->count()) }} transaksi</div>
        </div>

        {{-- Filter Card --}}
        <div class="card payment-filter-card mb-4">
            <div class="card-body p-4">
                <div class="payment-filter-card__header">
                    <div>
                        <h2 class="payment-section-title">Filter transaksi</h2>
                        <p class="payment-section-subtitle">Pilih periode dan status yang ingin ditampilkan.</p>
                    </div>
                    <i class="bx bx-slider-alt text-muted font-size-20"></i>
                </div>
                <form action="/admin/pembayaran" method="get">
                    <div class="row align-items-end">

                        {{-- Input Filter Tanggal --}}
                        <div class="col-xl-4 col-lg-5 mb-3 mb-xl-0">
                            <label class="payment-filter-label"><i class="bx bx-calendar mr-1"></i> Rentang tanggal transaksi</label>
                            <div class="input-group payment-date-inputs">
                                <input type="date" class="form-control border-right-0" value="{{ $param['date'][0] }}"
                                    name="param_date_start" style="border-radius: 10px 0 0 10px;">
                                <div class="input-group-append">
                                    <span
                                        class="input-group-text bg-light text-muted border-left-0 border-right-0">s/d</span>
                                </div>
                                <input type="date" class="form-control border-left-0" value="{{ $param['date'][1] }}"
                                    name="param_date_end" style="border-radius: 0 10px 10px 0;">
                            </div>
                        </div>

                        {{-- Filter Checkbox Status --}}
                        <div class="col-xl-6 col-lg-7 mb-3 mb-xl-0">
                            <label class="payment-filter-label"><i class="bx bx-filter-alt mr-1"></i> Status pembayaran</label>
                            <div class="payment-status-grid">
                                <div class="payment-status-option">
                                    <input type="checkbox" id="checkBelumLunas"
                                        name="param_checked_lunas[]" value="0"
                                        {{ in_array(0, $param['status']) ? 'checked' : '' }}>
                                    <label for="checkBelumLunas">Belum Lunas</label>
                                </div>
                                <div class="payment-status-option">
                                    <input type="checkbox" id="checkLunas"
                                        name="param_checked_lunas[]" value="1"
                                        {{ in_array(1, $param['status']) ? 'checked' : '' }}>
                                    <label for="checkLunas">Lunas</label>
                                </div>
                                <div class="payment-status-option">
                                    <input type="checkbox" id="checkPending"
                                        name="param_checked_lunas[]" value="2"
                                        {{ in_array(2, $param['status']) ? 'checked' : '' }}>
                                    <label for="checkPending">Pending</label>
                                </div>
                                <div class="payment-status-option">
                                    <input type="checkbox" id="checkMenungguKonfirmasi"
                                        name="param_checked_lunas[]" value="3"
                                        {{ in_array(3, $param['status']) ? 'checked' : '' }}>
                                    <label for="checkMenungguKonfirmasi">Menunggu Konfirmasi</label>
                                </div>
                                <div class="payment-status-option">
                                    <input type="checkbox" id="checkDitolak"
                                        name="param_checked_lunas[]" value="98"
                                        {{ in_array(98, $param['status']) ? 'checked' : '' }}>
                                    <label for="checkDitolak">Ditolak</label>
                                </div>
                                <div class="payment-status-option">
                                    <input type="checkbox" id="checkDibatalkan"
                                        name="param_checked_lunas[]" value="99"
                                        {{ in_array(99, $param['status']) ? 'checked' : '' }}>
                                    <label for="checkDibatalkan">Dibatalkan</label>
                                </div>
                            </div>
                        </div>

                        {{-- Tombol Submit / Reset --}}
                        <div class="col-xl-2 col-lg-12">
                            <div class="payment-filter-actions">
                                <button class="btn btn-primary d-flex align-items-center justify-content-center" type="submit"
                                    style="background: #4f46e5; border: none;">
                                    <i class="bx bx-search mr-1 font-size-18"></i> Cari
                                </button>
                                <a href="/admin/pembayaran" class="btn btn-light text-muted d-flex align-items-center justify-content-center">
                                    Reset
                                </a>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        {{-- Tabel Data Pembayaran --}}
        <div class="card payment-table-card overflow-hidden">
            <div class="payment-table-card__header">
                <div>
                    <h2 class="payment-section-title">Daftar pembayaran</h2>
                    <p class="payment-section-subtitle">Transaksi terbaru sesuai filter yang dipilih.</p>
                </div>
                <span class="payment-table-card__meta">{{ number_format($pembayaran->count()) }} data</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="tblPembayaran" class="table table-hover align-middle mb-0" style="width:100%;">
                        <thead class="bg-light text-muted small text-uppercase">
                            <tr>
                                <th class="border-top-0 pl-4" style="width: 50px;">#</th>
                                <th class="border-top-0">Status</th>
                                <th class="border-top-0">No Invoice</th>
                                <th class="border-top-0">Skema / Metode</th>
                                <th class="border-top-0">Bukti / Link Pembayaran</th>
                                <th class="border-top-0">Total Harga</th>
                                {{-- <th class="border-top-0">Tanggal Kelas</th> --}}
                                <th class="border-top-0">Modul Kelas</th>
                                <th class="border-top-0">Kategori</th>
                                <th class="border-top-0">Nama User</th>
                                <th class="border-top-0 text-center">Cetak</th>
                                <th class="border-top-0 text-center pr-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="small text-dark">
                            @foreach ($pembayaran as $key => $p)
                                @php
                                    $linkPayment = $p->link_payment;

                                    // Cek apakah link_payment berupa URL eksternal valid (http:// atau https://)
                                    $isExternalUrl =
                                        filter_var($linkPayment, FILTER_VALIDATE_URL) &&
                                        (str_starts_with($linkPayment, 'http://') ||
                                            str_starts_with($linkPayment, 'https://'));

                                    // Cek keberadaan file bukti transfer (baik dari kolom bukti_transfer atau link_payment yang berupa path/file lokal)
                                    $hasBuktiTransfer =
                                        !empty($p->bukti_transfer) || (!empty($linkPayment) && !$isExternalUrl);

                                    // Menentukan URL file lokal jika ada
                                    $fileUrl = !empty($p->bukti_transfer)
                                        ? asset('storage/' . $p->bukti_transfer)
                                        : (!empty($linkPayment) && !$isExternalUrl
                                            ? asset('storage/' . $linkPayment)
                                            : null);
                                    $isManualPayment = $p->payment_method === 'manual' || !$isExternalUrl;
                                    $isMembership = (int) $p->tipe_pembelian === \App\Models\DataPayment::PURCHASE_TYPE_MEMBERSHIP;
                                @endphp
                                <tr>
                                    <td class="pl-4 font-weight-bold align-middle">{{ $key + 1 }}</td>

                                    {{-- Status Badge --}}
                                    <td class="align-middle">
                                        @if ($p->status == 1)
                                            <span class="badge badge-soft-success px-2 py-1 font-weight-bold"><i
                                                    class="bx bx-check-circle mr-1"></i>Lunas</span>
                                        @elseif ($p->status == \App\Models\DataPayment::STATUS_WAITING_CONFIRMATION)
                                             <span class="badge badge-soft-warning px-2 py-1 font-weight-bold"><i
                                                     class="bx bx-time-five mr-1"></i>Menunggu Konfirmasi</span>
                                        @elseif ($p->status == \App\Models\DataPayment::STATUS_REJECTED)
                                             <span class="badge badge-soft-danger px-2 py-1 font-weight-bold"><i
                                                     class="bx bx-error-circle mr-1"></i>Ditolak</span>
                                        @elseif ($p->status == \App\Models\DataPayment::STATUS_CANCELED)
                                            <span class="badge badge-soft-danger px-2 py-1 font-weight-bold"><i
                                                    class="bx bx-x-circle mr-1"></i>Dibatalkan</span>
                                        @elseif ($p->status == \App\Models\DataPayment::STATUS_PENDING)
                                            <span class="badge badge-soft-warning px-2 py-1 font-weight-bold"><i
                                                    class="bx bx-time-five mr-1"></i>Pending</span>
                                        @elseif ($p->status == 0)
                                            <span class="badge badge-soft-secondary px-2 py-1 font-weight-bold"><i
                                                    class="bx bx-minus-circle mr-1"></i>Belum Lunas</span>
                                        @else
                                            <span class="badge badge-soft-danger px-2 py-1 font-weight-bold"><i
                                                    class="bx bx-x-circle mr-1"></i>Belum Lunas</span>
                                        @endif
                                    </td>

                                    <td class="align-middle font-weight-bold text-primary">{{ $p->no_invoice }}</td>

                                    {{-- Skema / Metode Pembayaran --}}
                                    <td class="align-middle">
                                        {{-- Payment Gateway HANYA jika link_payment bernilai URL eksternal valid --}}
                                        @if (!$isManualPayment)
                                            <span class="badge badge-soft-primary"><i
                                                    class="bx bx-credit-card mr-1"></i>Payment Gateway</span>
                                        @else
                                            <span class="badge badge-soft-info"><i class="bx bx-transfer mr-1"></i>Transfer
                                                Manual</span>
                                        @endif
                                    </td>

                                    {{-- Preview Bukti Transfer ATAU Link Gateway --}}
                                    <td class="align-middle">
                                        @if ($isExternalUrl)
                                            {{-- Tampilan jika link_payment adalah URL Payment Gateway --}}
                                            <a href="{{ $linkPayment }}" target="_blank" rel="noopener"
                                                class="btn btn-sm btn-outline-primary" style="border-radius: 6px;">
                                                <i class="bx bx-link-external mr-1"></i> Link Payment
                                            </a>
                                        @elseif ($hasBuktiTransfer)
                                            {{-- Tampilan jika berupa file bukti transfer lokal --}}
                                            <a href="{{ $fileUrl }}" target="_blank" class="text-primary">Lihat
                                                File</a>
                                        @else
                                            {{-- Tampilan jika tidak ada link maupun file --}}
                                            <span class="text-muted font-italic">- Tidak Ada -</span>
                                        @endif
                                    </td>

                                    <td class="align-middle font-weight-bold text-dark">
                                        {{ numfmt_format_currency(numfmt_create('id_ID', \NumberFormatter::CURRENCY), $p->nominal, 'IDR') }}
                                    </td>

                                    {{-- <td class="align-middle">
                                        @if (!empty($p->date_start))
                                            @if (Carbon\Carbon::parse($p->date_start)->format('d-m-Y') == Carbon\Carbon::parse($p->date_end)->format('d-m-Y'))
                                                {{ Carbon\Carbon::parse($p->date_start)->format('d/m/Y') }}
                                            @else
                                                {{ Carbon\Carbon::parse($p->date_start)->format('d/m/Y') }} <br>
                                                <small class="text-muted">s/d
                                                    {{ Carbon\Carbon::parse($p->date_end)->format('d/m/Y') }}</small>
                                            @endif
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td> --}}

                                    <td class="align-middle text-truncate" style="max-width: 160px;"
                                        title="{{ $p->title ?? $p->pembelian }}">
                                        {{ $p->title ?? $p->pembelian }}
                                    </td>
                                    <td class="align-middle">
                                        <span
                                            class="badge badge-light border text-secondary">{{ $p->category ?? $p->tipe_pembelian }}</span>
                                    </td>
                                    <td class="align-middle font-weight-bold">{{ $p->name ?? '-' }}</td>
                                    <td class="align-middle text-center">
                                        @if ($p->sudah_cetak == 1)
                                            <span class="badge badge-soft-info"><i class="bx bx-check"></i> Sudah</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>

                                    {{-- Tombol Aksi --}}
                                    <td class="align-middle pr-4 text-center">
                                        <div class="btn-group shadow-sm" role="group"
                                            style="border-radius: 8px; overflow: hidden;">

                                            {{-- Undo Cetak --}}
                                            @if ($p->sudah_cetak == 1)
                                                <button class="btn btn-sm btn-light border-0 text-warning bs-tooltip"
                                                    title="Undo Status Cetak"
                                                    onclick="cancelsudahcetak({{ $p->id }},{{ $p->sudah_cetak }})">
                                                    <i class='bx bx-undo font-size-16'></i>
                                                </button>
                                            @endif

                                            {{-- Certificate Status --}}
                                            @if ($p->status == 1)
                                                <button
                                                    class="btn btn-sm btn-light border-0 {{ $p->certificate == 1 ? 'text-warning' : 'text-success' }} bs-tooltip"
                                                    title="{{ $p->certificate == 1 ? 'Unpublish Certificate' : 'Publish Certificate' }}"
                                                    onclick="publichCertificate({{ $p->id }},{{ $p->certificate ?? 0 }})">
                                                    <i class='bx bxs-file-doc font-size-16'></i>
                                                </button>

                                                {{-- Batal Lunas --}}
                                                <button class="btn btn-sm btn-light border-0 text-danger bs-tooltip"
                                                    title="Batal Lunas"
                                                    onclick="approved('{{ $p->no_invoice }}',{{ $p->status }})">
                                                    <i class='bx bx-x-circle font-size-16'></i>
                                                </button>
                                            @elseif (!$isManualPayment)
                                                {{-- Set Lunas --}}
                                                <button class="btn btn-sm btn-light border-0 text-success bs-tooltip"
                                                    title="Set Lunas"
                                                    onclick="approved('{{ $p->no_invoice }}',{{ $p->status }})">
                                                    <i class='bx bx-check-circle font-size-16'></i>
                                                </button>
                                            @endif

                                            {{-- Edit Bukti Transfer (Ditampilkan untuk SEMUA transaksi Transfer Manual / yang BUKAN Payment Gateway) --}}
                                            @if ($isManualPayment && $p->file)
                                                <button class="btn btn-sm btn-light border-0 text-primary bs-tooltip"
                                                    title="Edit Bukti Transfer"
                                                    onclick="updatebukti('{{ json_encode($p) }}')">
                                                    <i class='bx bx-edit-alt font-size-16'></i>
                                                </button>
                                            @endif

                                            @if ($isManualPayment && $p->status == \App\Models\DataPayment::STATUS_WAITING_CONFIRMATION)
                                                <button class="btn btn-sm btn-light border-0 text-success bs-tooltip"
                                                    title="Setujui pembayaran"
                                                    onclick="approved('{{ $p->no_invoice }}',{{ $p->status }})">
                                                    <i class='bx bx-check-circle font-size-16'></i>
                                                </button>
                                                <button class="btn btn-sm btn-light border-0 text-danger bs-tooltip"
                                                    title="Tolak bukti pembayaran"
                                                    onclick="rejectPayment('{{ $p->no_invoice }}')">
                                                    <i class='bx bx-x-circle font-size-16'></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <form action="#" method="post" id="formpembayaran">
                        @csrf
                        <input type="text" name="id" id="id" hidden>
                        <input type="text" name="certificate" id="certificate" hidden>
                        <input type="text" name="status" id="status" hidden>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="rejectPaymentModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
                    <form action="/admin/pembayaran/reject" method="POST">
                        @csrf
                        <div class="modal-header border-0">
                            <h5 class="modal-title font-weight-bold">Tolak Bukti Pembayaran</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" id="rejectPaymentId">
                            <label for="rejectionReason" class="font-weight-bold small">Alasan penolakan</label>
                            <textarea class="form-control" name="rejection_reason" id="rejectionReason" rows="4" maxlength="1000" required placeholder="Contoh: Bukti transfer tidak terbaca atau nominal tidak sesuai."></textarea>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger">Tolak Pembayaran</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Modal Update Bukti Transfer --}}
        <div class="modal fade" id="cardupdateprofile" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title font-weight-bold text-dark" id="modalLabel">
                            <i class="bx bx-upload text-primary mr-1"></i> Update Bukti Transfer
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="/admin/pembayaran/updatebukti" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body py-4">
                            <input type="text" name="idpembayaran" id="idpembayaran" hidden>

                            <div class="form-group mb-3">
                                <label class="font-weight-bold text-muted small mb-2">Upload File Foto Bukti Baru</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="foto" id="foto"
                                        accept="image/*" onchange="loadFile(event)" required>
                                    <label class="custom-file-label" for="foto">Pilih berkas gambar...</label>
                                </div>
                            </div>

                            <div class="text-center mt-3 p-3 bg-light rounded border" style="border-radius: 12px;">
                                <label class="d-block text-muted small mb-2">Pratinjau Gambar:</label>
                                <img id="output" class="img-fluid rounded border shadow-sm"
                                    style="max-height: 250px; width: auto;">
                            </div>
                        </div>
                        <div class="modal-footer border-0 pt-0">
                            <button type="button" class="btn btn-light font-weight-bold" data-dismiss="modal"
                                style="border-radius: 10px;">Batal</button>
                            <button class="btn btn-primary font-weight-bold px-4" type="submit"
                                style="border-radius: 10px; background: #4f46e5; border: none;">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('custom-js')
    <script>
        createDataTable('#tblPembayaran');

        var loadFile = function(event) {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src)
            }
        };

        function updatebukti(params) {
            let j = typeof params === 'string' ? JSON.parse(params) : params;
            $('#cardupdateprofile').modal('show');
            $('#idpembayaran').val(j.id);
            if (j.file) {
                $('#output').attr('src', '/getBerkas?rf=' + j.file);
            } else {
                $('#output').attr('src', '');
            }
        }

        function rejectPayment(invoice) {
            $('#rejectPaymentId').val(invoice);
            $('#rejectionReason').val('');
            $('#rejectPaymentModal').modal('show');
        }

        function approved(id, status) {
            var s = {
                title: 'Konfirmasi Status?',
                text: "Tandai pembayaran ini sebagai Lunas!",
                icon: 'info', // 'type' diubah ke 'icon' untuk SweetAlert2
                showCancelButton: true,
                confirmButtonText: 'Ya, Proses',
                cancelButtonText: 'Batal',
                padding: '2em'
            }
            if (status == 1) {
                s = {
                    title: 'Konfirmasi Batalkan Lunas?',
                    text: "Tandai pembayaran ini kembali menjadi Belum Lunas!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Batalkan',
                    cancelButtonText: 'Batal',
                    padding: '2em'
                }
            }
            // PERBAIKAN: Gunakan Swal.fire(s) bukan swal(s)
            Swal.fire(s).then(function(result) {
                if (result.isConfirmed || result.value) {
                    $('#formpembayaran').attr('action', '/admin/pembayaran/approved');
                    $('#id').val(id);
                    $('#status').val(status);
                    $('#formpembayaran').submit();
                }
            })
        }

        function publichCertificate(id, certificate) {
            var s = {
                title: 'Publikasi Sertifikat?',
                text: "Terbitkan sertifikat untuk user ini!",
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Ya, Terbitkan',
                cancelButtonText: 'Batal',
                padding: '2em'
            }
            if (certificate == 1) {
                s = {
                    title: 'Batalkan Sertifikat?',
                    text: "Sembunyikan sertifikat untuk user ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Sembunyikan',
                    cancelButtonText: 'Batal',
                    padding: '2em'
                }
            }
            // PERBAIKAN: Gunakan Swal.fire(s)
            Swal.fire(s).then(function(result) {
                if (result.isConfirmed || result.value) {
                    $('#formpembayaran').attr('action', '/admin/pembayaran/certificate');
                    $('#id').val(id);
                    $('#certificate').val(certificate);
                    $('#formpembayaran').submit();
                }
            })
        }

        function cancelsudahcetak(id, certificate) {
            var s = {
                title: 'Reset Status Cetak?',
                text: "Ubah status cetak menjadi 0, user dapat memilih ulang opsi cetak.",
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Ya, Reset',
                cancelButtonText: 'Batal',
                padding: '2em'
            }
            // PERBAIKAN: Gunakan Swal.fire(s)
            Swal.fire(s).then(function(result) {
                if (result.isConfirmed || result.value) {
                    $('#formpembayaran').attr('action', '/admin/pembayaran/setsudahcetak');
                    $('#id').val(id);
                    $('#certificate').val(certificate);
                    $('#formpembayaran').submit();
                }
            })
        }
    </script>
@endsection
