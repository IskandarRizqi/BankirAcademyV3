@extends('layouts.app') {{-- Sesuaikan layout utama Anda --}}

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm text-center p-4">
                <div class="card-body">
                    <div class="mb-3">
                        <i class="bi bi-envelope-exclamation text-warning display-1"></i>
                    </div>
                    <h3 class="card-title fw-bold mb-2">Akun Anda Belum Aktif</h3>
                    <p class="text-muted">
                        Silakan verifikasi email pribadi Anda (<strong>{{ $profile->email ?? auth()->user()->email }}</strong>) 
                        dengan mengklik tautan yang telah kami kirimkan.
                    </p>

                    @if (session('success'))
                        <div class="alert alert-success mt-3" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger mt-3" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="mt-4">
                        <form action="{{ route('siswa.resend.verification') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-send me-1"></i> Kirim Ulang Email Verifikasi
                            </button>
                        </form>
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                           class="text-secondary small">
                           Keluar dari akun
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection