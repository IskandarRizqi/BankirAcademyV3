@extends('layouts.compact')

@section('title', 'Kelola Berita')

@section('content')
    <div class="news-admin-page">
        <div class="news-admin-heading">
            <div>
                <span class="news-admin-kicker">Pusat informasi</span>
                <h1>Kelola Berita</h1>
                <p>Terbitkan kabar terbaru Bankir Academy dengan struktur konten yang siap dibaca dan dibagikan.</p>
            </div>
            <a href="{{ route('admin.news.create') }}" class="btn btn-primary news-admin-primary">
                <i class="fas fa-plus mr-1"></i> Tulis Berita
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row news-admin-stats">
            <div class="col-md-4 mb-3"><div class="news-stat"><span>Total berita</span><strong>{{ number_format($stats['total']) }}</strong><small>Draft dan terbit</small></div></div>
            <div class="col-md-4 mb-3"><div class="news-stat news-stat--green"><span>Sudah terbit</span><strong>{{ number_format($stats['published']) }}</strong><small>Tampil untuk publik</small></div></div>
            <div class="col-md-4 mb-3"><div class="news-stat news-stat--orange"><span>Total dibaca</span><strong>{{ number_format($stats['views']) }}</strong><small>Akumulasi semua berita</small></div></div>
        </div>

        <div class="card news-admin-card">
            <div class="card-body">
                <form class="row align-items-end mb-4" method="GET">
                    <div class="col-md-7 mb-3 mb-md-0">
                        <label for="news-search">Cari berita</label>
                        <input id="news-search" type="search" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari judul atau slug...">
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label for="news-status">Status</label>
                        <select id="news-status" name="status" class="form-control">
                            <option value="">Semua status</option>
                            <option value="1" @selected(request('status') === '1')>Published</option>
                            <option value="0" @selected(request('status') === '0')>Draft</option>
                        </select>
                    </div>
                    <div class="col-md-2"><button class="btn btn-outline-primary btn-block" type="submit">Filter</button></div>
                </form>

                <div class="table-responsive">
                    <table class="table news-admin-table align-middle">
                        <thead><tr><th>Berita</th><th>Status</th><th>Dibaca</th><th>Diperbarui</th><th class="text-right">Aksi</th></tr></thead>
                        <tbody>
                            @forelse ($news as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if ($item->bannerImages->first())
                                                <img class="news-admin-thumb" src="{{ $item->bannerImages->first()->url }}" alt="">
                                            @else
                                                <div class="news-admin-thumb news-admin-thumb--empty"><i class="fas fa-newspaper"></i></div>
                                            @endif
                                            <div><strong class="d-block">{{ $item->title }}</strong><small class="text-muted">/berita/{{ $item->slug }}</small></div>
                                        </div>
                                    </td>
                                    <td><span class="news-status {{ $item->status ? 'news-status--published' : 'news-status--draft' }}">{{ $item->status ? 'Published' : 'Draft' }}</span></td>
                                    <td><i class="far fa-eye text-muted mr-1"></i>{{ number_format($item->views) }}</td>
                                    <td class="text-muted">{{ optional($item->updated_at)->format('d M Y H:i') }}</td>
                                    <td class="text-right text-nowrap">
                                        @if ($item->status)
                                            <a href="{{ route('frontend.news.show', $item->slug) }}" target="_blank" class="btn btn-sm btn-light" title="Lihat"><i class="fas fa-external-link-alt"></i></a>
                                            <form class="d-inline" action="{{ route('admin.news.unpublish', $item) }}" method="POST">@csrf @method('PATCH')<button class="btn btn-sm btn-outline-warning" title="Jadikan draft"><i class="fas fa-eye-slash"></i></button></form>
                                        @else
                                            <form class="d-inline" action="{{ route('admin.news.publish', $item) }}" method="POST">@csrf @method('PATCH')<button class="btn btn-sm btn-outline-success" title="Publish"><i class="fas fa-globe"></i></button></form>
                                        @endif
                                        <a href="{{ route('admin.news.edit', $item) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="fas fa-pen"></i></a>
                                        <form class="d-inline" action="{{ route('admin.news.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus berita ini?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger" title="Hapus"><i class="fas fa-trash"></i></button></form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center py-5 text-muted">Belum ada berita. Mulai dari tombol <strong>Tulis Berita</strong>.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">{{ $news->links() }}</div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <style>
        .news-admin-page{padding:28px 4px 46px;color:#26324a}.news-admin-heading{display:flex;justify-content:space-between;align-items:end;gap:20px;margin-bottom:26px}.news-admin-heading h1{font-size:30px;font-weight:800;margin:4px 0 6px}.news-admin-heading p{color:#74809a;margin:0}.news-admin-kicker{color:#556ee6;font-size:12px;font-weight:800;letter-spacing:.12em;text-transform:uppercase}.news-admin-primary{border-radius:9px;padding:11px 17px}.news-stat{background:#fff;border-left:4px solid #556ee6;border-radius:12px;padding:17px 20px;box-shadow:0 8px 22px rgba(38,50,74,.06)}.news-stat--green{border-color:#12b886}.news-stat--orange{border-color:#f59f00}.news-stat span,.news-stat small{display:block;color:#78849a;font-size:12px}.news-stat strong{display:block;font-size:25px;margin:4px 0}.news-admin-card{border:0;border-radius:14px;box-shadow:0 8px 26px rgba(38,50,74,.06)}.news-admin-card label{color:#64708a;font-size:12px;font-weight:700}.news-admin-table th{border-top:0;color:#7a8498;font-size:11px;text-transform:uppercase;letter-spacing:.06em}.news-admin-table td{padding:15px 8px}.news-admin-thumb{width:54px;height:44px;object-fit:cover;border-radius:8px;margin-right:12px}.news-admin-thumb--empty{background:#eef1f8;color:#9aa5bb;display:inline-flex;align-items:center;justify-content:center}.news-status{border-radius:99px;font-size:11px;font-weight:700;padding:5px 9px}.news-status--published{background:#e6fcf5;color:#087f5b}.news-status--draft{background:#fff4e6;color:#d9480f}@media(max-width:700px){.news-admin-heading{align-items:start;flex-direction:column}.news-admin-heading h1{font-size:25px}.news-admin-table{min-width:760px}}
    </style>
@endpush
