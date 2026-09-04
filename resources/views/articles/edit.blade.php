@extends('layouts.compact')

@section('content')
    <div class="py-4" style="background-color: #f8fafc; min-height: 100vh;">
        <div class="container-fluid px-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="font-weight-bold text-dark mb-0">Edit Artikel</h4>
                <a href="{{ route('articles.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
            </div>

            <!-- WAJIB: Tambahkan enctype="multipart/form-data" -->
            <form action="{{ route('articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Kolom Kiri: Editor Utama -->
                    <div class="col-lg-8 mb-4">
                        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                            <div class="card-body p-4">
                                <!-- Judul Artikel -->
                                <div class="form-group mb-3">
                                    <label for="title" class="text-secondary small font-weight-bold">Judul
                                        Artikel</label>
                                    <input type="text" name="title" id="title"
                                        class="form-control form-control-lg @error('title') is-invalid @enderror"
                                        value="{{ old('title', $article->title) }}" required>
                                    @error('title')
                                        <small class="text-danger mt-1 d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- WYSIWYG Editor Konten -->
                                <div class="form-group mb-0">
                                    <label for="content" class="text-secondary small font-weight-bold">Konten Artikel (HTML
                                        Body Only)</label>
                                    <textarea name="content" id="editor" rows="15" class="form-control @error('content') is-invalid @enderror">{{ old('content', $article->content) }}</textarea>
                                    @error('content')
                                        <small class="text-danger mt-1 d-block">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan: Metadata, Gambar, & Parameter SEO -->
                    <div class="col-lg-4">
                        <!-- Card Featured Image -->
                        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
                            <div class="card-header bg-white border-bottom py-3">
                                <h6 class="font-weight-bold text-dark mb-0">
                                    <i class="fas fa-image text-primary mr-1"></i> Gambar Artikel
                                </h6>
                            </div>
                            <div class="card-body p-3">
                                <div class="form-group mb-0 text-center">
                                    <!-- Container Preview Gambar -->
                                    <div class="mb-3 p-2 border rounded bg-light">
                                        <img id="imagePreview" src="{{ $article->image_url }}" alt="Preview Gambar"
                                            class="img-fluid rounded shadow-sm"
                                            style="max-height: 200px; width: 100%; object-fit: cover;">
                                    </div>

                                    <label for="image"
                                        class="text-secondary small font-weight-bold d-block text-left">Ganti Gambar
                                        (Opsional)</label>
                                    <input type="file" name="image" id="image"
                                        class="form-control-file @error('image') is-invalid @enderror" accept="image/*"
                                        onchange="previewImage(event)">
                                    <small class="text-muted d-block text-left mt-1">Format: JPG, PNG, WEBP (Max: 2MB). Jika
                                        diunggah, gambar akan disimpan di Storage lokal.</small>

                                    @error('image')
                                        <small class="text-danger mt-1 d-block text-left">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Card SEO & Pengaturan -->
                        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
                            <div class="card-header bg-white border-bottom py-3">
                                <h6 class="font-weight-bold text-dark mb-0">
                                    <i class="fas fa-cog text-primary mr-1"></i> Pengaturan & SEO
                                </h6>
                            </div>
                            <div class="card-body p-3">
                                <!-- Keyword -->
                                <div class="form-group mb-3">
                                    <label for="keyword" class="text-secondary small font-weight-bold">Keyword
                                        Utama</label>
                                    <input type="text" name="keyword" id="keyword"
                                        class="form-control @error('keyword') is-invalid @enderror"
                                        value="{{ old('keyword', $article->keyword) }}" required>
                                    @error('keyword')
                                        <small class="text-danger mt-1 d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Slug -->
                                <div class="form-group mb-3">
                                    <label for="slug" class="text-secondary small font-weight-bold">URL Slug</label>
                                    <input type="text" name="slug" id="slug"
                                        class="form-control @error('slug') is-invalid @enderror"
                                        value="{{ old('slug', $article->slug) }}" required>
                                    @error('slug')
                                        <small class="text-danger mt-1 d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Meta Description -->
                                <div class="form-group mb-3">
                                    <label for="meta_description" class="text-secondary small font-weight-bold">Meta
                                        Description</label>
                                    <textarea name="meta_description" id="meta_description" rows="3"
                                        class="form-control @error('meta_description') is-invalid @enderror">{{ old('meta_description', $article->meta_description) }}</textarea>
                                    @error('meta_description')
                                        <small class="text-danger mt-1 d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Meta Keywords -->
                                <div class="form-group mb-4">
                                    <label for="meta_keywords" class="text-secondary small font-weight-bold">Meta
                                        Keywords</label>
                                    <input type="text" name="meta_keywords" id="meta_keywords"
                                        class="form-control @error('meta_keywords') is-invalid @enderror"
                                        value="{{ old('meta_keywords', $article->meta_keywords) }}"
                                        placeholder="keyword1, keyword2">
                                    @error('meta_keywords')
                                        <small class="text-danger mt-1 d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <hr>

                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-primary btn-block font-weight-bold py-2 shadow-sm"
                                    style="border-radius: 8px;">
                                    <i class="fas fa-save mr-1"></i> Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- FontAwesome & TinyMCE Plugin Integration -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            tinymce.init({
                selector: '#editor',
                height: 500,
                menubar: true,
                plugins: [
                    'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                    'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                    'insertdatetime', 'media', 'table', 'help', 'wordcount'
                ],
                toolbar: 'undo redo | blocks | ' +
                    'bold italic backcolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat | image link code | help',
                content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px; line-height:1.6 }',
                valid_elements: '*[*]',
                extended_valid_elements: '*[*]'
            });
        });

        // Script JS Preview Image Live
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('imagePreview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
