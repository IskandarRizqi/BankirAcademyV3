<style>
    .news-form-card{border:0;border-radius:14px;box-shadow:0 8px 26px rgba(38,50,74,.06)}.news-form-card .card-header{background:#fff;border-bottom:1px solid #edf0f6;padding:17px 21px;font-weight:800;color:#26324a}.news-form-card .card-body{padding:21px}.news-form-card label{color:#64708a;font-size:12px;font-weight:700}.news-form-card .form-control{border-color:#e3e8f1;border-radius:8px;min-height:42px}.news-form-card textarea.form-control{min-height:unset}.news-form-help{color:#8993a7;font-size:11px}.news-existing-image{position:relative}.news-existing-image img{height:90px;width:100%;object-fit:cover;border-radius:8px}.news-existing-image label{position:absolute;right:6px;top:5px;background:#fff;border-radius:6px;padding:4px 6px}.news-upload-preview{display:flex;flex-wrap:wrap;gap:8px;margin-top:10px}.news-upload-preview img{width:90px;height:66px;border-radius:7px;object-fit:cover}.news-form-submit{border-radius:9px;padding:11px 18px}
</style>

<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if ($method !== 'POST') @method($method) @endif
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card news-form-card mb-4">
                <div class="card-header"><i class="fas fa-pen-nib text-primary mr-2"></i>Konten Utama</div>
                <div class="card-body">
                    <div class="form-group"><label for="title">Judul Berita *</label><input id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $news->title ?? '') }}" required>@error('title')<small class="text-danger">{{ $message }}</small>@enderror</div>
                    <div class="form-group mb-0"><label for="content">Isi Berita *</label><textarea id="news-editor" name="content" rows="18" class="form-control @error('content') is-invalid @enderror">{{ old('content', $news->content ?? '') }}</textarea><small class="news-form-help">Gunakan heading, paragraf, daftar, gambar, dan tautan agar konten nyaman dibaca.</small><small id="news-editor-error" class="text-danger d-block" @if (!$errors->has('content')) hidden @endif>@error('content'){{ $message }}@else Isi berita wajib diisi.@enderror</small></div>
                </div>
            </div>
            <div class="card news-form-card">
                <div class="card-header"><i class="fas fa-search text-primary mr-2"></i>Metadata SEO</div>
                <div class="card-body">
                    <div class="form-group"><label for="slug">Slug URL</label><input id="slug" name="slug" class="form-control" value="{{ old('slug', $news->slug ?? '') }}" placeholder="akan dibuat otomatis dari judul"><small class="news-form-help">Gunakan huruf kecil dan tanda hubung. Slug yang sudah dipublikasikan sebaiknya tidak diubah.</small>@error('slug')<small class="text-danger d-block">{{ $message }}</small>@enderror</div>
                    <div class="form-group"><label for="excerpt">Ringkasan Berita</label><textarea id="excerpt" name="excerpt" rows="3" maxlength="320" class="form-control">{{ old('excerpt', $news->excerpt ?? '') }}</textarea><small class="news-form-help">Dipakai di kartu berita dan ringkasan sosial.</small></div>
                    <div class="form-group"><label for="meta_title">Meta Title</label><input id="meta_title" name="meta_title" maxlength="70" class="form-control" value="{{ old('meta_title', $news->meta_title ?? '') }}"></div>
                    <div class="form-group"><label for="meta_description">Meta Description</label><textarea id="meta_description" name="meta_description" maxlength="160" rows="3" class="form-control">{{ old('meta_description', $news->meta_description ?? '') }}</textarea></div>
                    <div class="form-group mb-0"><label for="meta_keywords">Meta Keywords</label><input id="meta_keywords" name="meta_keywords" class="form-control" value="{{ old('meta_keywords', $news->meta_keywords ?? '') }}" placeholder="berita perbankan, bankir academy"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card news-form-card mb-4">
                <div class="card-header"><i class="fas fa-images text-primary mr-2"></i>Banner Berita</div>
                <div class="card-body">
                    <label for="banner_images">Upload Banner {{ $news ? '' : '*' }}</label>
                    <input id="banner_images" name="banner_images[]" type="file" multiple accept="image/jpeg,image/png,image/webp" class="form-control-file d-block @error('banner_images') is-invalid @enderror">
                    <small class="news-form-help d-block mt-2">Pilih beberapa gambar sekaligus. JPG, PNG, WEBP, maksimal 5 MB per gambar dan 10 gambar.</small>
                    <div id="news-upload-preview" class="news-upload-preview"></div>
                    @if ($news && $news->bannerImages->isNotEmpty())
                        <hr><small class="news-form-help d-block mb-2">Banner tersimpan. Centang untuk menghapus.</small>
                        <div class="row">
                            @foreach ($news->bannerImages as $image)
                                <div class="col-6 mb-3 news-existing-image"><img src="{{ $image->url }}" alt=""><label><input type="checkbox" name="remove_images[]" value="{{ $image->id }}"> Hapus</label></div>
                            @endforeach
                        </div>
                    @endif
                    @error('banner_images.*')<small class="text-danger d-block mt-2">{{ $message }}</small>@enderror
                </div>
            </div>
            <div class="card news-form-card mb-4">
                <div class="card-header"><i class="fas fa-sliders-h text-primary mr-2"></i>Publikasi</div>
                <div class="card-body">
                    <label for="status">Status Berita</label>
                    <select id="status" name="status" class="form-control">
                        <option value="0" @selected(old('status', (int) ($news->status ?? 0)) == 0)>Simpan sebagai draft</option>
                        <option value="1" @selected(old('status', (int) ($news->status ?? 0)) == 1)>Publish sekarang</option>
                    </select>
                    <small class="news-form-help d-block mt-2">Saat publish, URL berita otomatis masuk ke sitemap website.</small>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-block news-form-submit"><i class="fas fa-save mr-1"></i> {{ $submitLabel }}</button>
        </div>
    </div>
</form>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('form[action="{{ $action }}"]');
            if (window.tinymce) {
                tinymce.init({
                    selector: '#news-editor', height: 560, menubar: true,
                    plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen table wordcount',
                    toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | bullist numlist | link image | removeformat code fullscreen',
                    content_style: 'body { font-family:Inter,Arial,sans-serif; font-size:16px; line-height:1.7; padding:12px; }',
                    setup: function (editor) {
                        editor.on('input change keyup', function () {
                            const error = document.getElementById('news-editor-error');
                            if (editor.getContent({ format: 'text' }).trim()) error.hidden = true;
                        });
                    }
                });
            }
            if (form) form.addEventListener('submit', function (event) {
                if (window.tinymce) tinymce.triggerSave();
                const textarea = document.getElementById('news-editor');
                const error = document.getElementById('news-editor-error');
                if (!textarea.value.trim()) {
                    event.preventDefault();
                    error.hidden = false;
                    error.textContent = 'Isi berita wajib diisi.';
                    if (window.tinymce && tinymce.get('news-editor')) tinymce.get('news-editor').focus();
                }
            });
            const input = document.getElementById('banner_images');
            const preview = document.getElementById('news-upload-preview');
            if (input && preview) input.addEventListener('change', function () { preview.innerHTML = ''; Array.from(input.files).forEach(file => { const reader = new FileReader(); reader.onload = event => { const image = document.createElement('img'); image.src = event.target.result; image.alt = file.name; preview.appendChild(image); }; reader.readAsDataURL(file); }); });
        });
    </script>
@endpush
