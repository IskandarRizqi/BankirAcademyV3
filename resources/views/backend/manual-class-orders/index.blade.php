@extends('layouts.compact')

@section('content')
@php
    $isEdit = filled($order);
    $formAction = $isEdit
        ? route('admin.manual-class-orders.update', $order->id)
        : route('admin.manual-class-orders.store');
    $selectedClassId = old('class_id', $order->class_id ?? '');
    $selectedUserId = old('user_id', $order->user_id ?? '');
    $nominal = old('nominal', $order->dataPayment->nominal ?? $order->price_final ?? '');
@endphp

<div class="col-12">
    <div class="widget widget-content-area br-4 mb-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
            <div>
                <h4 class="mb-1">{{ $isEdit ? 'Edit Order Kelas Manual' : 'Order Kelas Manual' }}</h4>
                <p class="text-muted mb-0">Buat order IHT untuk user peserta tanpa melalui payment gateway.</p>
            </div>
            @if($isEdit)
                <span class="badge badge-info p-2">Invoice {{ $order->no_invoice }}</span>
            @endif
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 pl-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ $formAction }}" method="POST">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="manual-class-id">Kelas IHT aktif</label>
                    <select name="class_id" id="manual-class-id" class="form-control" required>
                        <option value="">Pilih kelas</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ (string) $selectedClassId === (string) $class->id ? 'selected' : '' }}>
                                {{ $class->title }}
                                @if($class->date_end)
                                    (sampai {{ \Carbon\Carbon::parse($class->date_end)->format('d/m/Y') }})
                                @endif
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 form-group">
                    <label for="manual-user-id">User peserta (role 2)</label>
                    <select name="user_id" id="manual-user-id" class="form-control" required>
                        <option value="">Pilih user</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ (string) $selectedUserId === (string) $user->id ? 'selected' : '' }}>
                                {{ $user->name }} - {{ $user->email }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 form-group">
                    <label for="manual-nominal">Nominal Order (Rupiah)</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp</span>
                        </div>
                        <input type="text" name="nominal" id="manual-nominal" class="form-control" inputmode="numeric" autocomplete="off" data-rupiah-input value="{{ $nominal }}" required>
                    </div>
                    <small class="form-text text-muted">Nilai ini digunakan sebagai nominal, harga kelas, dan harga final.</small>
                </div>
            </div>

            <div class="alert alert-info mb-3">
                <strong>Data otomatis:</strong> invoice, status lunas, order IHT, konfirmasi, dan sertifikat peserta akan disimpan sesuai aturan order manual.
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bx bx-save mr-1"></i>
                {{ $isEdit ? 'Perbarui Order' : 'Simpan Order' }}
            </button>
            @if($isEdit)
                <a href="{{ route('admin.manual-class-orders.index') }}" class="btn btn-light">Batal</a>
            @endif
        </form>
    </div>

    <div class="widget widget-content-area br-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
            <h5 class="mb-0">Daftar Order Kelas Manual</h5>
            <span class="text-muted small">{{ $orders->count() }} order</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover" id="manual-class-orders-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Invoice</th>
                        <th>User</th>
                        <th>Kelas</th>
                        <th>Total Bayar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $manualOrder)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <strong>{{ $manualOrder->no_invoice }}</strong>
                                <small class="d-block text-muted">{{ $manualOrder->created_at?->format('d/m/Y H:i') }}</small>
                            </td>
                            <td>
                                {{ $manualOrder->user->name ?? '-' }}
                                <small class="d-block text-muted">{{ $manualOrder->user->email ?? '-' }}</small>
                            </td>
                            <td>{{ $manualOrder->class->title ?? '-' }}</td>
                            <td>Rp {{ number_format((float) $manualOrder->price_final, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('admin.manual-class-orders.edit', $manualOrder->id) }}" class="btn btn-sm btn-warning">
                                    <i class="bx bx-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.manual-class-orders.destroy', $manualOrder->id) }}" method="POST" class="d-inline" data-delete-order-form>
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger" data-delete-order>
                                        <i class="bx bx-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection

@section('custom-js')
<script>
    $(function () {
        @if(session('manual_order_success'))
            Sweetalert2.fire({
                title: 'Berhasil!',
                text: @json(session('manual_order_success')),
                type: 'success',
                confirmButtonClass: 'btn btn-success',
                buttonsStyling: false
            });
        @endif

        $('#manual-class-id, #manual-user-id').select2({
            width: '100%'
        });

        createDataTable('#manual-class-orders-table', {
            order: [[0, 'asc']]
        });

        $(document).on('click', '[data-delete-order]', function () {
            var form = $(this).closest('[data-delete-order-form]');

            Sweetalert2.fire({
                title: 'Hapus order ini?',
                text: 'Data pembayaran dan peserta terkait akan ikut dihapus.',
                type: 'warning',
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonClass: 'btn btn-danger',
                cancelButtonClass: 'btn btn-secondary ml-2',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then(function (result) {
                if (result.value) {
                    form[0].submit();
                }
            });
        });

        function formatRupiah(value) {
            var digits = String(value || '').replace(/\D/g, '');

            return digits.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        $('[data-rupiah-input]').each(function () {
            var input = this;
            input.value = formatRupiah(input.value);

            input.addEventListener('input', function () {
                input.value = formatRupiah(input.value);
            });
        });
    });
</script>
@endsection
