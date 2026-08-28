@extends('layouts.compact')

@section('content')
    <div class="py-4" style="background-color: #f8fafc; min-height: 100vh;">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="font-weight-bold text-dark mb-0">Edit Artikel</h4>
                <a href="{{ route('articles.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
            </div>

            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body p-4">
                    <form action="{{ route('articles.update', $article->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label for="keyword" class="text-secondary small font-weight-bold">Keyword</label>
                            <input type="text" name="keyword" id="keyword"
                                class="form-control @error('keyword') is-invalid @enderror"
                                value="{{ old('keyword', $article->keyword) }}" required>
                            @error('keyword')
                                <small class="text-danger mt-1 d-block">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="title" class="text-secondary small font-weight-bold">Judul Artikel</label>
                            <input type="text" name="title" id="title"
                                class="form-control @error('title') is-invalid @enderror"
                                value="{{ old('title', $article->title) }}" required>
                            @error('title')
                                <small class="text-danger mt-1 d-block">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="content" class="text-secondary small font-weight-bold">Konten Artikel</label>
                            <textarea name="content" id="content" rows="10" class="form-control @error('content') is-invalid @enderror"
                                required>{{ old('content', $article->content) }}</textarea>
                            @error('content')
                                <small class="text-danger mt-1 d-block">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary font-weight-bold px-4"
                                style="border-radius: 8px;">
                                <i class="fas fa-save mr-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection
