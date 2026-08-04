@extends('layouts.appmembernonanggota')

@section('title', $loker ? 'Edit Lowongan' : 'Tambah Lowongan')

@section('content')
@php
    $selectedSkills = old('skill', $loker ? (json_decode((string) $loker->skill, true) ?: []) : []);
    $selectedTypes = old('type', $loker ? (json_decode((string) $loker->type, true) ?: []) : []);
    $salary = old('gaji_min', $loker ? (int) $loker->gaji_min : '');
    $salaryDisplay = $salary !== '' ? 'Rp '.number_format((float) preg_replace('/[^0-9]/', '', (string) $salary), 0, ',', '.') : '';
@endphp

<style>
    .loker-form-page {
        display: flex;
        flex-direction: column;
        gap: 22px;
    }

    .loker-form-hero {
        position: relative;
        overflow: hidden;
        border-radius: 24px;
        padding: 28px;
        background:
            radial-gradient(circle at 82% 18%, rgba(6, 182, 212, .26), transparent 30%),
            linear-gradient(135deg, #111827 0%, #312e81 52%, #4f46e5 100%);
        color: #ffffff;
        box-shadow: 0 20px 48px rgba(49, 46, 129, .18);
    }

    .loker-form-hero__content {
        position: relative;
        z-index: 1;
    }

    .loker-form-hero__back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        min-height: 36px;
        color: rgba(255, 255, 255, .82);
        font-size: 13px;
        font-weight: 800;
    }

    .loker-form-hero__back:hover {
        color: #ffffff;
    }

    .loker-form-hero h1 {
        margin: 22px 0 0;
        font-size: clamp(28px, 4vw, 44px);
        font-weight: 900;
        letter-spacing: -.05em;
        line-height: 1.05;
    }

    .loker-form-hero p {
        max-width: 640px;
        margin: 12px 0 0;
        color: rgba(255, 255, 255, .82);
        font-size: 14px;
        line-height: 1.7;
    }

    .loker-form-panel {
        border: 1px solid #e7e9f0;
        border-radius: 20px;
        background: #ffffff;
        box-shadow: 0 12px 34px rgba(15, 23, 42, .045);
    }

    .loker-form-panel__body {
        padding: 24px;
    }

    .loker-form-company {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 22px;
        padding: 13px 15px;
        border: 1px solid #e0e7ff;
        border-radius: 12px;
        background: #f8faff;
        color: #374151;
        font-size: 13px;
    }

    .loker-form-company i {
        color: #4f46e5;
    }

    .loker-form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
    }

    .loker-form-field--wide {
        grid-column: 1 / -1;
    }

    .loker-form-field label {
        display: block;
        margin-bottom: 6px;
        color: #374151;
        font-size: 12px;
        font-weight: 800;
    }

    .loker-form-control {
        width: 100%;
        min-height: 42px;
        padding: 8px 11px;
        border: 1px solid #e5e7eb;
        border-radius: 9px;
        outline: none;
        background: #ffffff;
        color: #111827;
        font-size: 13px;
        transition: border-color .18s ease, box-shadow .18s ease;
    }

    .loker-form-control:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, .1);
    }

    .loker-form-field textarea {
        min-height: 120px;
        resize: vertical;
    }

    .loker-form-field .cke_chrome {
        overflow: hidden;
        border: 1px solid #e5e7eb;
        border-radius: 9px;
        box-shadow: none;
    }

    .loker-form-field .cke_focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, .1);
    }

    .loker-form-field .select2-container {
        width: 100% !important;
    }

    .loker-form-field .select2-container--default .select2-selection--multiple {
        min-height: 42px;
        padding: 3px 6px;
        border: 1px solid #e5e7eb;
        border-radius: 9px;
    }

    .loker-form-field .select2-container--default.select2-container--focus .select2-selection--multiple {
        border-color: #4f46e5;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, .1);
    }

    .loker-form-help {
        display: block;
        margin-top: 5px;
        color: #9ca3af;
        font-size: 11px;
    }

    .loker-form-error {
        display: block;
        margin-top: 5px;
        color: #dc2626;
        font-size: 11px;
    }

    .loker-form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 22px;
    }

    .loker-form-button {
        display: inline-flex;
        min-height: 42px;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 9px 16px;
        border: 0;
        border-radius: 9px;
        background: #4f46e5;
        color: #ffffff;
        font-size: 12px;
        font-weight: 850;
        text-decoration: none;
        cursor: pointer;
    }

    .loker-form-button:hover,
    .loker-form-button:focus-visible {
        background: #3730a3;
        color: #ffffff;
    }

    .loker-form-button--secondary {
        background: #f3f4f6;
        color: #4b5563;
    }

    .loker-form-button--secondary:hover,
    .loker-form-button--secondary:focus-visible {
        background: #e5e7eb;
        color: #1f2937;
    }

    @media (max-width: 767.98px) {
        .loker-form-hero {
            padding: 22px;
            border-radius: 20px;
        }

        .loker-form-panel__body {
            padding: 18px;
        }

        .loker-form-grid {
            grid-template-columns: 1fr;
        }

        .loker-form-field--wide {
            grid-column: auto;
        }

        .loker-form-actions {
            flex-direction: column-reverse;
        }

        .loker-form-button {
            width: 100%;
        }
    }
</style>

<div class="loker-form-page">
    <section class="loker-form-hero" aria-labelledby="loker-form-title">
        <div class="loker-form-hero__content">
            <a href="{{ route('membernonanggota.loker.manage.index') }}" class="loker-form-hero__back">
                <i class="fas fa-arrow-left" aria-hidden="true"></i> Kembali ke daftar lowongan
            </a>
            <h1 id="loker-form-title">{{ $loker ? 'Edit lowongan kerja' : 'Tambah lowongan kerja' }}</h1>
            <p>{{ $loker ? 'Perubahan lowongan akan dikirim kembali untuk approval admin.' : 'Isi informasi posisi dengan jelas agar mudah dipahami kandidat.' }}</p>
        </div>
    </section>

    <section class="loker-form-panel" aria-labelledby="loker-form-section-title">
        <div class="loker-form-panel__body">
            <div class="loker-form-company">
                <i class="fas fa-building" aria-hidden="true"></i>
                <span>Lowongan akan diposting atas nama <strong>{{ $company->nama }}</strong>.</span>
            </div>

            <form id="loker-posting-form" method="POST" action="{{ $loker ? route('membernonanggota.loker.manage.update', $loker->id) : route('membernonanggota.loker.manage.store') }}">
                @csrf
                @if($loker)
                    @method('PUT')
                @endif

                <div class="loker-form-grid">
                    <div class="loker-form-field loker-form-field--wide">
                        <label for="loker-title">Judul posisi <span class="text-danger">*</span></label>
                        <input type="text" id="loker-title" name="title" class="loker-form-control" value="{{ old('title', $loker->title ?? '') }}" required>
                        @error('title')<span class="loker-form-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="loker-form-field">
                        <label for="loker-salary">Gaji minimum <span class="text-danger">*</span></label>
                        <input type="text" id="loker-salary" name="gaji_min" class="loker-form-control" value="{{ old('gaji_min', $salaryDisplay) }}" inputmode="numeric" required>
                        <span class="loker-form-help">Masukkan nominal dalam rupiah, contoh Rp 5.000.000.</span>
                        @error('gaji_min')<span class="loker-form-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="loker-form-field">
                        <label for="loker-type">Tipe pekerjaan <span class="text-danger">*</span></label>
                        <select id="loker-type" name="type[]" class="loker-form-control" multiple required>
                            @foreach($types as $type)
                                <option value="{{ $type }}" @selected(in_array($type, (array) $selectedTypes, true))>{{ $type }}</option>
                            @endforeach
                            @foreach((array) $selectedTypes as $type)
                                @if(!in_array($type, $types, true))<option value="{{ $type }}" selected>{{ $type }}</option>@endif
                            @endforeach
                        </select>
                        @error('type')<span class="loker-form-error">{{ $message }}</span>@enderror
                        @error('type.*')<span class="loker-form-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="loker-form-field loker-form-field--wide">
                        <label for="loker-description">Deskripsi lowongan <span class="text-danger">*</span></label>
                        <textarea id="loker-description" name="deskripsi" class="loker-form-control" required>{{ old('deskripsi', $loker->deskripsi ?? '') }}</textarea>
                        @error('deskripsi')<span class="loker-form-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="loker-form-field loker-form-field--wide">
                        <label for="loker-jobdesk">Jobdesk / tanggung jawab <span class="text-danger">*</span></label>
                        <textarea id="loker-jobdesk" name="jobdesk" class="loker-form-control" required>{{ old('jobdesk', $loker->jobdesk ?? '') }}</textarea>
                        @error('jobdesk')<span class="loker-form-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="loker-form-field">
                        <label for="loker-start-date">Tanggal mulai <span class="text-danger">*</span></label>
                        <input type="date" id="loker-start-date" name="tanggal_awal" class="loker-form-control" value="{{ old('tanggal_awal', $loker->tanggal_awal ?? '') }}" required>
                        @error('tanggal_awal')<span class="loker-form-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="loker-form-field">
                        <label for="loker-end-date">Tanggal berakhir <span class="text-danger">*</span></label>
                        <input type="date" id="loker-end-date" name="tanggal_akhir" class="loker-form-control" value="{{ old('tanggal_akhir', $loker->tanggal_akhir ?? '') }}" required>
                        @error('tanggal_akhir')<span class="loker-form-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="loker-form-field loker-form-field--wide">
                        <label for="loker-skill">Skill yang dibutuhkan <span class="text-danger">*</span></label>
                        <select id="loker-skill" name="skill[]" class="loker-form-control" multiple required>
                            @foreach($skills as $skill)
                                <option value="{{ $skill }}" @selected(in_array($skill, (array) $selectedSkills, true))>{{ $skill }}</option>
                            @endforeach
                            @foreach((array) $selectedSkills as $skill)
                                @if(!in_array($skill, $skills, true))<option value="{{ $skill }}" selected>{{ $skill }}</option>@endif
                            @endforeach
                        </select>
                        <span class="loker-form-help">Ketik skill lalu tekan Enter untuk menambahkan tag.</span>
                        @error('skill')<span class="loker-form-error">{{ $message }}</span>@enderror
                        @error('skill.*')<span class="loker-form-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="loker-form-actions">
                    <a href="{{ route('membernonanggota.loker.manage.index') }}" class="loker-form-button loker-form-button--secondary">Batal</a>
                    <button type="submit" class="loker-form-button"><i class="fas fa-paper-plane" aria-hidden="true"></i> Kirim untuk approval</button>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script src="{{ asset('Backend/plugins/ckeditor/ckeditor.js') }}"></script>
<script>
    (function () {
        if (typeof CKEDITOR !== 'undefined') {
            const editor = CKEDITOR.replace('loker-jobdesk', {
                height: 240,
                resize_enabled: false,
                enterMode: CKEDITOR.ENTER_P,
                toolbar: [
                    {
                        name: 'clipboard',
                        items: ['Undo', 'Redo']
                    },
                    {
                        name: 'basicstyles',
                        items: ['Bold', 'Italic', 'Underline', 'RemoveFormat']
                    },
                    {
                        name: 'paragraph',
                        items: ['NumberedList', 'BulletedList', 'Outdent', 'Indent', 'Blockquote']
                    }
                ],
                removePlugins: 'uploadimage,uploadfile,filebrowser,image,flash,iframe,mediaembed,smiley,table,tabletools,sourcearea',
                removeButtons: 'Image,UploadImage,Flash,Table,Source',
                allowedContent: 'p br strong em u ul ol li blockquote',
                disallowedContent: '*[on*]; *{*}'
            });

            document.getElementById('loker-posting-form').addEventListener('submit', function () {
                editor.updateElement();
            });
        }

        if (typeof $.fn.select2 === 'function') {
            $('#loker-skill, #loker-type').select2({
                width: '100%',
                tags: true,
                tokenSeparators: [','],
                placeholder: 'Ketik lalu tekan Enter'
            });
        }

        if (typeof Cleave !== 'undefined') {
            new Cleave('#loker-salary', {
                prefix: 'Rp ',
                numeral: true,
                numeralThousandsGroupStyle: 'thousand',
                delimiter: '.',
                numeralDecimalMark: ',',
                numeralDecimalScale: 0,
                rawValueTrimPrefix: true
            });
        }
    })();
</script>
@endpush
