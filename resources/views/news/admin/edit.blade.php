@extends('layouts.compact')

@section('title', 'Edit Berita')

@section('content')
    <div class="news-admin-page">
        <div class="news-admin-heading"><div><span class="news-admin-kicker">Pusat informasi</span><h1>Edit Berita</h1><p>Perbarui isi berita tanpa kehilangan URL yang sudah dibagikan.</p></div><a href="{{ route('admin.news.index') }}" class="btn btn-light"><i class="fas fa-arrow-left mr-1"></i> Kembali</a></div>
        @include('news.admin._form', ['action' => route('admin.news.update', $news), 'method' => 'PUT', 'news' => $news, 'submitLabel' => 'Simpan Perubahan'])
    </div>
@endsection
