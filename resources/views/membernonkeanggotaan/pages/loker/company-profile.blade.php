@extends('layouts.appmembernonanggota')

@section('title', 'Profil Perusahaan')

@section('content')
@php
    $company = $company ?? null;
    $selectedLocations = $selectedLocations ?? [
        'cities' => collect(),
        'districts' => collect(),
        'villages' => collect(),
    ];
    $logo = data_get(json_decode((string) ($company->image ?? ''), true), 'url');
    $logoUrl = filled($logo)
        ? (\Illuminate\Support\Str::startsWith($logo, ['http://', 'https://', '/']) ? $logo : asset('image/loker/' . basename($logo)))
        : null;
@endphp

<style>
    .company-page {
        display: flex;
        flex-direction: column;
        gap: 22px;
    }

    .company-hero {
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

    .company-hero::after {
        content: "";
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(255, 255, 255, .06) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255, 255, 255, .06) 1px, transparent 1px);
        background-size: 38px 38px;
        mask-image: linear-gradient(90deg, transparent, #000 22%, #000 88%, transparent);
        pointer-events: none;
    }

    .company-hero__content {
        position: relative;
        z-index: 1;
        max-width: 760px;
    }

    .company-hero__eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 12px;
        padding: 7px 12px;
        border: 1px solid rgba(255, 255, 255, .18);
        border-radius: 999px;
        background: rgba(255, 255, 255, .12);
        color: rgba(255, 255, 255, .9);
        font-size: 12px;
        font-weight: 800;
        letter-spacing: .06em;
        text-transform: uppercase;
        backdrop-filter: blur(10px);
    }

    .company-hero__title {
        margin: 0;
        font-size: clamp(28px, 4vw, 46px);
        font-weight: 900;
        letter-spacing: -.05em;
        line-height: 1.05;
    }

    .company-hero__description {
        max-width: 620px;
        margin: 14px 0 0;
        color: rgba(255, 255, 255, .82);
        font-size: 15px;
        line-height: 1.7;
    }

    .company-panel {
        border: 1px solid #e7e9f0;
        border-radius: 20px;
        background: #ffffff;
        box-shadow: 0 12px 34px rgba(15, 23, 42, .045);
    }

    .company-panel__body {
        padding: 24px;
    }

    .company-panel__header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 22px;
    }

    .company-panel__header h2 {
        margin: 0;
        color: #111827;
        font-size: 22px;
        font-weight: 900;
        letter-spacing: -.03em;
    }

    .company-panel__header p {
        margin: 5px 0 0;
        color: #6b7280;
        font-size: 13px;
    }

    .company-form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
    }

    .company-form-field--wide {
        grid-column: 1 / -1;
    }

    .company-form-field label {
        display: block;
        margin-bottom: 6px;
        color: #374151;
        font-size: 12px;
        font-weight: 800;
    }

    .company-form-control {
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

    .company-form-control:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, .1);
    }

    .company-form-control:disabled {
        background: #f9fafb;
        color: #9ca3af;
        cursor: not-allowed;
    }

    .company-form-field textarea {
        min-height: 96px;
        resize: vertical;
    }

    .company-form-field .select2-container {
        width: 100% !important;
    }

    .company-form-field .select2-container--default .select2-selection--single {
        min-height: 42px;
        border: 1px solid #e5e7eb;
        border-radius: 9px;
    }

    .company-form-field .select2-container--default .select2-selection--single .select2-selection__rendered {
        padding: 7px 30px 7px 11px;
        color: #111827;
        font-size: 13px;
        line-height: 26px;
    }

    .company-form-field .select2-container--default .select2-selection--single .select2-selection__arrow {
        top: 8px;
        right: 8px;
    }

    .company-logo-upload {
        display: grid;
        grid-template-columns: 96px minmax(0, 1fr);
        gap: 14px;
        align-items: center;
    }

    .company-logo-preview {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 96px;
        height: 76px;
        overflow: hidden;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        background: #f8fafc;
    }

    .company-logo-preview img {
        width: 100%;
        height: 100%;
        padding: 8px;
        object-fit: contain;
    }

    .company-logo-placeholder {
        color: #9ca3af;
        font-size: 24px;
    }

    .company-form-help {
        display: block;
        margin-top: 5px;
        color: #9ca3af;
        font-size: 11px;
    }

    .company-form-error {
        display: block;
        margin-top: 5px;
        color: #dc2626;
        font-size: 11px;
    }

    .company-form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 22px;
    }

    .company-button {
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

    .company-button:hover,
    .company-button:focus-visible {
        background: #3730a3;
        color: #ffffff;
    }

    .company-button--secondary {
        background: #f3f4f6;
        color: #4b5563;
    }

    .company-button--secondary:hover,
    .company-button--secondary:focus-visible {
        background: #e5e7eb;
        color: #1f2937;
    }

    @media (max-width: 767.98px) {
        .company-hero {
            padding: 22px;
            border-radius: 20px;
        }

        .company-panel__body {
            padding: 18px;
        }

        .company-panel__header {
            flex-direction: column;
        }

        .company-form-grid {
            grid-template-columns: 1fr;
        }

        .company-form-field--wide {
            grid-column: auto;
        }

        .company-logo-upload {
            grid-template-columns: 1fr;
        }

        .company-form-actions {
            flex-direction: column-reverse;
        }

        .company-button {
            width: 100%;
        }
    }
</style>

<div class="company-page">
    <section class="company-hero" aria-labelledby="company-page-title">
        <div class="company-hero__content">
            <span class="company-hero__eyebrow"><i class="fas fa-building" aria-hidden="true"></i> Company Career Center</span>
            <h1 class="company-hero__title" id="company-page-title">Lengkapi profil perusahaan</h1>
            <p class="company-hero__description">
                Profil perusahaan akan digunakan sebagai identitas pada setiap lowongan yang Anda posting di Bankir Academy.
            </p>
        </div>
    </section>

    <section class="company-panel" aria-labelledby="company-form-title">
        <div class="company-panel__body">
            <div class="company-panel__header">
                <div>
                    <h2 id="company-form-title">Informasi perusahaan</h2>
                    <p>{{ $company ? 'Perbarui informasi perusahaan Anda.' : 'Isi data berikut sebelum memasang lowongan kerja.' }}</p>
                </div>
                @if($company && $company->isComplete())
                    <a href="{{ route('membernonanggota.loker.manage.index') }}" class="company-button">
                        <i class="fas fa-briefcase" aria-hidden="true"></i> Kelola lowongan
                    </a>
                @endif
            </div>

            <form method="POST" action="{{ route('membernonanggota.loker.manage.company.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="company-form-grid">
                    <div class="company-form-field">
                        <label for="company-name">Nama perusahaan <span class="text-danger">*</span></label>
                        <input type="text" id="company-name" name="nama" class="company-form-control" value="{{ old('nama', $company->nama ?? '') }}" required>
                        @error('nama')<span class="company-form-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="company-form-field">
                        <label for="company-email">Email perusahaan <span class="text-danger">*</span></label>
                        <input type="email" id="company-email" name="email" class="company-form-control" value="{{ old('email', $company->email ?? '') }}" required>
                        @error('email')<span class="company-form-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="company-form-field company-form-field--wide">
                        <label for="company-address">Alamat lengkap <span class="text-danger">*</span></label>
                        <textarea id="company-address" name="alamat" class="company-form-control" required>{{ old('alamat', $company->alamat ?? '') }}</textarea>
                        @error('alamat')<span class="company-form-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="company-form-field">
                        <label for="company-province">Provinsi <span class="text-danger">*</span></label>
                        <select id="company-province" name="provinsi" class="company-form-control" required>
                            <option value="">Pilih provinsi</option>
                            @foreach($provinces as $province)
                                <option value="{{ $province->id }}" @selected((string) old('provinsi', $company->provinsi ?? '') === (string) $province->id)>{{ $province->name }}</option>
                            @endforeach
                        </select>
                        @error('provinsi')<span class="company-form-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="company-form-field">
                        <label for="company-city">Kabupaten / kota <span class="text-danger">*</span></label>
                        <select id="company-city" name="kabupaten" class="company-form-control" required {{ old('provinsi', $company->provinsi ?? '') ? '' : 'disabled' }}>
                            <option value="">Pilih kabupaten / kota</option>
                            @foreach($selectedLocations['cities'] as $city)
                                <option value="{{ $city->id }}" @selected((string) old('kabupaten', $company->kabupaten ?? '') === (string) $city->id)>{{ $city->name }}</option>
                            @endforeach
                        </select>
                        @error('kabupaten')<span class="company-form-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="company-form-field">
                        <label for="company-district">Kecamatan <span class="text-danger">*</span></label>
                        <select id="company-district" name="kecamatan" class="company-form-control" required {{ old('kabupaten', $company->kabupaten ?? '') ? '' : 'disabled' }}>
                            <option value="">Pilih kecamatan</option>
                            @foreach($selectedLocations['districts'] as $district)
                                <option value="{{ $district->id }}" @selected((string) old('kecamatan', $company->kecamatan ?? '') === (string) $district->id)>{{ $district->name }}</option>
                            @endforeach
                        </select>
                        @error('kecamatan')<span class="company-form-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="company-form-field">
                        <label for="company-village">Kelurahan <span class="text-danger">*</span></label>
                        <select id="company-village" name="kelurahan" class="company-form-control" required {{ old('kecamatan', $company->kecamatan ?? '') ? '' : 'disabled' }}>
                            <option value="">Pilih kelurahan</option>
                            @foreach($selectedLocations['villages'] as $village)
                                <option value="{{ $village->id }}" @selected((string) old('kelurahan', $company->kelurahan ?? '') === (string) $village->id)>{{ $village->name }}</option>
                            @endforeach
                        </select>
                        @error('kelurahan')<span class="company-form-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="company-form-field company-form-field--wide">
                        <label for="company-logo">Logo perusahaan <span class="text-danger">*</span></label>
                        <div class="company-logo-upload">
                            <div class="company-logo-preview">
                                @if($logo)
                                    <img src="{{ $logoUrl }}" alt="Logo {{ $company->nama }}" id="company-logo-preview">
                                @else
                                    <span class="company-logo-placeholder" id="company-logo-placeholder"><i class="fas fa-image" aria-hidden="true"></i></span>
                                    <img src="" alt="Preview logo perusahaan" id="company-logo-preview" hidden>
                                @endif
                            </div>
                            <div>
                                <input type="file" id="company-logo" name="image" class="company-form-control" accept=".jpg,.jpeg,.png,.webp" {{ $company && $company->image ? '' : 'required' }}>
                                <span class="company-form-help">Format JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.</span>
                            </div>
                        </div>
                        @error('image')<span class="company-form-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="company-form-actions">
                    <a href="{{ route('membernonanggota.loker.index') }}" class="company-button company-button--secondary">Kembali</a>
                    <button type="submit" class="company-button"><i class="fas fa-save" aria-hidden="true"></i> Simpan profil perusahaan</button>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    (function () {
        const province = $('#company-province');
        const city = $('#company-city');
        const district = $('#company-district');
        const village = $('#company-village');

        if (!province.length || typeof $.fn.select2 !== 'function') {
            return;
        }

        function configureSelect(select, url, placeholder, parent) {
            select.select2({
                width: '100%',
                placeholder: placeholder,
                allowClear: true,
                ajax: {
                    url: url,
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term || '',
                            page: params.page || 1,
                            parent_id: parent.val() || ''
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data.results || [],
                            pagination: data.pagination || { more: false }
                        };
                    },
                    cache: true
                }
            });
        }

        configureSelect(city, '{{ route('membernonanggota.loker.manage.locations.cities') }}', 'Pilih kabupaten / kota', province);
        configureSelect(district, '{{ route('membernonanggota.loker.manage.locations.districts') }}', 'Pilih kecamatan', city);
        configureSelect(village, '{{ route('membernonanggota.loker.manage.locations.villages') }}', 'Pilih kelurahan', district);
        province.select2({ width: '100%', placeholder: 'Pilih provinsi', allowClear: true });

        function resetSelect(select, disabled) {
            select.val(null).trigger('change');
            select.prop('disabled', disabled);
        }

        province.on('change', function () {
            resetSelect(city, !province.val());
            resetSelect(district, true);
            resetSelect(village, true);
        });

        city.on('change', function () {
            resetSelect(district, !city.val());
            resetSelect(village, true);
        });

        district.on('change', function () {
            resetSelect(village, !district.val());
        });
    })();

    (function () {
        const input = document.getElementById('company-logo');
        const preview = document.getElementById('company-logo-preview');
        const placeholder = document.getElementById('company-logo-placeholder');

        if (!input || !preview) {
            return;
        }

        input.addEventListener('change', function (event) {
            const file = event.target.files && event.target.files[0];

            if (!file) {
                return;
            }

            preview.src = URL.createObjectURL(file);
            preview.hidden = false;

            if (placeholder) {
                placeholder.hidden = true;
            }
        });
    })();
</script>
@endpush
