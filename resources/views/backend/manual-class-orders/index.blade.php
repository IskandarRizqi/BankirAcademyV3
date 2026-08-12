@extends('layouts.compact')

@section('content')
    @php
        $isEdit = filled($order);
        $formAction = $isEdit
            ? route('admin.manual-class-orders.update', $order->id)
            : route('admin.manual-class-orders.store');
        $selectedClassId = old('class_id', $order->class_id ?? '');
        $selectedUserId = old('user_id', $order->user_id ?? '');
        $nominal = old('nominal', $order->dataPayment->nominal ?? ($order->price_final ?? ''));
    @endphp

    <div class="container-fluid py-4">

        {{-- Page Header & Trigger Modal Button --}}
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
            <div>
                <h4 class="font-weight-bold text-dark mb-1">Order Kelas Manual (IHT)</h4>
                <p class="text-muted small mb-0">Kelola pendaftaran peserta IHT secara manual tanpa melalui payment gateway.
                </p>
            </div>
            <div>
                <button type="button"
                    class="btn btn-primary font-weight-bold px-4 py-2 shadow-sm d-inline-flex align-items-center"
                    data-toggle="modal" data-target="#modalManualOrder"
                    style="border-radius: 10px; background: #4f46e5; border: none;">
                    <i class="bx bx-plus-circle font-size-18 mr-2"></i> Buat Order Manual Baru
                </button>
            </div>
        </div>

        {{-- Card Container Tabel Order --}}
        <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 16px;">
            <div class="card-header bg-white py-3 px-4 border-0 d-flex align-items-center justify-content-between">
                <h6 class="font-weight-bold text-dark mb-0 d-flex align-items-center">
                    <i class="bx bx-list-ul text-primary mr-2 font-size-20"></i> Daftar Order Kelas Manual
                </h6>
                <span class="badge badge-soft-primary px-3 py-2 font-weight-bold">{{ $orders->count() }} Total Order</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="manual-class-orders-table" style="width:100%;">
                        <thead class="bg-light text-muted small text-uppercase">
                            <tr>
                                <th class="border-top-0 pl-4" style="width: 50px;">#</th>
                                <th class="border-top-0">No Invoice</th>
                                <th class="border-top-0">User / Peserta</th>
                                <th class="border-top-0">Kelas IHT</th>
                                <th class="border-top-0">Total Bayar</th>
                                <th class="border-top-0 text-center pr-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="small text-dark">
                            @foreach ($orders as $manualOrder)
                                <tr>
                                    <td class="pl-4 font-weight-bold align-middle">{{ $loop->iteration }}</td>
                                    <td class="align-middle">
                                        <span
                                            class="font-weight-bold text-primary d-block">{{ $manualOrder->no_invoice }}</span>
                                        <small class="text-muted"><i
                                                class="bx bx-time mr-1"></i>{{ $manualOrder->created_at?->format('d/m/Y H:i') }}</small>
                                    </td>
                                    <td class="align-middle">
                                        <span
                                            class="font-weight-bold text-dark d-block">{{ $manualOrder->user->name ?? '-' }}</span>
                                        <small class="text-muted">{{ $manualOrder->user->email ?? '-' }}</small>
                                    </td>
                                    <td class="align-middle font-weight-bold text-dark">
                                        {{ $manualOrder->class->title ?? '-' }}
                                    </td>
                                    <td class="align-middle font-weight-bold text-success">
                                        Rp {{ number_format((float) $manualOrder->price_final, 0, ',', '.') }}
                                    </td>
                                    <td class="align-middle pr-4 text-center">
                                        <div class="btn-group shadow-sm" role="group"
                                            style="border-radius: 8px; overflow: hidden;">
                                            <a href="{{ route('admin.manual-class-orders.edit', $manualOrder->id) }}"
                                                class="btn btn-sm btn-light border-0 text-warning bs-tooltip"
                                                title="Edit Order">
                                                <i class="bx bx-edit-alt font-size-16"></i>
                                            </a>
                                            <form
                                                action="{{ route('admin.manual-class-orders.destroy', $manualOrder->id) }}"
                                                method="POST" class="d-inline" data-delete-order-form>
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="btn btn-sm btn-light border-0 text-danger bs-tooltip"
                                                    title="Hapus Order" data-delete-order>
                                                    <i class="bx bx-trash font-size-16"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- MODAL FORM: TAMBAH / EDIT ORDER MANUAL --}}
        <div class="modal fade" id="modalManualOrder" tabindex="-1" role="dialog" aria-labelledby="modalManualOrderLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content border-0 shadow-lg" style="border-radius: 18px;">

                    {{-- Modal Header --}}
                    <div class="modal-header border-0 text-white p-4"
                        style="background: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%); border-radius: 18px 18px 0 0;">
                        <div>
                            <h5 class="modal-title font-weight-bold text-white mb-1" id="modalManualOrderLabel">
                                <i class="bx bx-file-find mr-1 text-warning"></i>
                                {{ $isEdit ? 'Edit Order Kelas Manual' : 'Buat Order Kelas Manual' }}
                            </h5>
                            <p class="small text-white-50 mb-0">Lengkapi formulir di bawah ini untuk mendaftarkan peserta ke
                                kelas IHT.</p>
                        </div>
                        @if ($isEdit)
                            <span class="badge badge-warning px-3 py-2 font-weight-bold">Invoice:
                                {{ $order->no_invoice }}</span>
                        @else
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"
                                style="opacity: 0.8;">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        @endif
                    </div>

                    {{-- Modal Body --}}
                    <form action="{{ $formAction }}" method="POST">
                        @csrf
                        @if ($isEdit)
                            @method('PUT')
                        @endif

                        <div class="modal-body p-4">

                            {{-- Alert Server Validation Errors --}}
                            @if ($errors->any())
                                <div class="alert alert-danger border-0 shadow-sm mb-4 d-flex align-items-start"
                                    style="border-radius: 12px;">
                                    <i class="bx bx-error-circle font-size-20 mr-2 mt-1"></i>
                                    <ul class="mb-0 pl-3 small">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row">
                                {{-- Pilih Kelas --}}
                                <div class="col-md-6 form-group mb-3">
                                    <label for="manual-class-id" class="font-weight-bold text-dark small mb-2">Kelas IHT
                                        Aktif <span class="text-danger">*</span></label>
                                    <select name="class_id" id="manual-class-id" class="form-control" required
                                        style="width:100%;">
                                        <option value="">Pilih kelas...</option>
                                        @foreach ($classes as $class)
                                            <option value="{{ $class->id }}"
                                                {{ (string) $selectedClassId === (string) $class->id ? 'selected' : '' }}>
                                                {{ $class->title }}
                                                @if ($class->date_end)
                                                    (s/d {{ \Carbon\Carbon::parse($class->date_end)->format('d/m/Y') }})
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Pilih User Peserta --}}
                                <div class="col-md-6 form-group mb-3">
                                    <label for="manual-user-id" class="font-weight-bold text-dark small mb-2">User Peserta
                                        (Role 2) <span class="text-danger">*</span></label>
                                    <select name="user_id" id="manual-user-id" class="form-control" required
                                        style="width:100%;">
                                        <option value="">Pilih user...</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ (string) $selectedUserId === (string) $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} - {{ $user->email }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Nominal Order --}}
                                <div class="col-12 form-group mb-4">
                                    <label for="manual-nominal" class="font-weight-bold text-dark small mb-2">Nominal
                                        Order (Rupiah) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light font-weight-bold text-muted"
                                                style="border-radius: 10px 0 0 10px;">Rp</span>
                                        </div>
                                        <input type="text" name="nominal" id="manual-nominal" class="form-control"
                                            inputmode="numeric" autocomplete="off" data-rupiah-input
                                            value="{{ $nominal }}" placeholder="0" required
                                            style="border-radius: 0 10px 10px 0;">
                                    </div>
                                    <small class="form-text text-muted mt-1"><i class="bx bx-info-circle mr-1"></i>Nilai
                                        ini otomatis digunakan sebagai nominal transaksi, harga kelas, dan harga
                                        final.</small>
                                </div>
                            </div>

                            {{-- Alert Informasi Otomatisasi --}}
                            <div class="p-3 border-0 rounded-lg d-flex align-items-center"
                                style="background-color: #f0fdf4; border-radius: 12px;">
                                <i class="bx bx-check-shield text-success font-size-24 mr-3"></i>
                                <div class="small text-secondary">
                                    <strong>Sistem Otomatis:</strong> Invoice, status lunas, order IHT, konfirmasi, serta
                                    penerbitan sertifikat peserta akan dibuat secara otomatis setelah disimpan.
                                </div>
                            </div>

                        </div>

                        {{-- Modal Footer --}}
                        <div class="modal-footer bg-light border-0 px-4 py-3" style="border-radius: 0 0 18px 18px;">
                            @if ($isEdit)
                                <a href="{{ route('admin.manual-class-orders.index') }}"
                                    class="btn btn-light font-weight-bold text-muted px-4"
                                    style="border-radius: 10px;">Batal Edit</a>
                            @else
                                <button type="button" class="btn btn-light font-weight-bold text-muted px-4"
                                    data-dismiss="modal" style="border-radius: 10px;">Batal</button>
                            @endif
                            <button type="submit"
                                class="btn btn-primary font-weight-bold px-4 d-inline-flex align-items-center"
                                style="border-radius: 10px; background: #4f46e5; border: none;">
                                <i class="bx bx-save mr-1 font-size-18"></i>
                                {{ $isEdit ? 'Perbarui Order' : 'Simpan Order' }}
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>
@endsection

@section('custom-js')
    <script>
        $(function() {
            // Otomatis buka modal jika dalam mode Edit atau terdapat Error Server Validation
            @if ($isEdit || $errors->any())
                $('#modalManualOrder').modal('show');
            @endif

            @if (session('manual_order_success'))
                Sweetalert2.fire({
                    title: 'Berhasil!',
                    text: @json(session('manual_order_success')),
                    type: 'success',
                    confirmButtonClass: 'btn btn-success',
                    buttonsStyling: false
                });
            @endif

            // Inisialisasi Select2 di dalam Modal
            $('#manual-class-id, #manual-user-id').select2({
                dropdownParent: $('#modalManualOrder'),
                width: '100%'
            });

            // Inisialisasi DataTables
            createDataTable('#manual-class-orders-table', {
                order: [
                    [0, 'asc']
                ]
            });

            // Event Handler Hapus Order
            $(document).on('click', '[data-delete-order]', function() {
                var form = $(this).closest('[data-delete-order-form]');

                Sweetalert2.fire({
                    title: 'Hapus order ini?',
                    text: 'Data pembayaran dan peserta terkait akan ikut dihapus secara permanen.',
                    type: 'warning',
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonClass: 'btn btn-danger font-weight-bold px-3',
                    cancelButtonClass: 'btn btn-secondary font-weight-bold px-3 ml-2',
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal'
                }).then(function(result) {
                    if (result.value) {
                        form[0].submit();
                    }
                });
            });

            // Formatter Input Rupiah
            function formatRupiah(value) {
                var digits = String(value || '').replace(/\D/g, '');
                return digits.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }

            $('[data-rupiah-input]').each(function() {
                var input = this;
                input.value = formatRupiah(input.value);

                input.addEventListener('input', function() {
                    input.value = formatRupiah(input.value);
                });
            });
        });
    </script>
@endsection
