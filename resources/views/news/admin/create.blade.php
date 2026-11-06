@extends('layouts.compact')

@section('title', 'Tulis Berita')

@section('content')
    <div class="news-admin-page">
        <div class="news-admin-heading"><div><span class="news-admin-kicker">Pusat informasi</span><h1>Tulis Berita</h1><p>Lengkapi konten, banner, dan metadata agar berita siap ditemukan di mesin pencari.</p></div><a href="{{ route('admin.news.index') }}" class="btn btn-light"><i class="fas fa-arrow-left mr-1"></i> Kembali</a></div>
        @include('news.admin._form', ['action' => route('admin.news.store'), 'method' => 'POST', 'news' => null, 'submitLabel' => 'Simpan Berita'])
    </div>
@endsection
