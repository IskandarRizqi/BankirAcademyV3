@extends('layouts.appmembernonanggota')

@section('title', $cv->exists ? 'Edit CV ATS' : 'Buat CV ATS')

@section('content')
    @php
        $experienceItems = old('experiences');
        $experienceItems = $experienceItems === null ? $experiences : $experienceItems;
        $trainingItems = old('trainings');
        $trainingItems = $trainingItems === null ? $trainings : $trainingItems;
    @endphp
    <style>
        .cv-form-page {
            display: flex;
            flex-direction: column;
            gap: 22px;
            margin: 0 auto;
            margin-bottom: 40px;
        }

        .cv-form-header,
        .cv-form-card {
            border: 1px solid var(--border);
            border-radius: 16px;
            background: #fff;
            box-shadow: var(--shadow-sm);
        }

        .cv-form-header {
            position: relative;
            overflow: hidden;
            border-radius: 24px;
            padding: clamp(24px, 5vw, 42px);
            color: #ffffff;
            background:
                radial-gradient(circle at 84% 18%, rgba(129, 140, 248, .35), transparent 28%),
                linear-gradient(135deg, #111827 0%, #312e81 55%, #4f46e5 100%);
            box-shadow: 0 20px 48px rgba(49, 46, 129, .2);
        }

        .cv-form-header::after {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255, 255, 255, .06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, .06) 1px, transparent 1px);
            background-size: 38px 38px;
            content: '';
            mask-image: linear-gradient(90deg, transparent, #000 22%, #000 88%, transparent);
            pointer-events: none;
        }

        .cv-form-header__content {
            position: relative;
            z-index: 1;
            max-width: 680px;
        }

        .cv-form-header__eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 14px;
            padding: 7px 12px;
            border: 1px solid rgba(255, 255, 255, .2);
            border-radius: 999px;
            background: rgba(255, 255, 255, .12);
            color: rgba(255, 255, 255, .9);
            font-size: 12px;
            font-weight: 800;
            letter-spacing: .06em;
            text-transform: uppercase;
        }

        .cv-form-header__title {
            margin: 0;
            font-size: clamp(28px, 4vw, 46px);
            font-weight: 900;
            letter-spacing: -.05em;
            line-height: 1.05;
        }

        .cv-form-header__description {
            max-width: 650px;
            margin: 14px 0 0;
            color: rgba(255, 255, 255, .84);
            font-size: 15px;
            line-height: 1.7;
        }

        .cv-form-card {
            padding: 28px 32px;
        }

        .cv-form-section+.cv-form-section {
            margin-top: 34px;
            padding-top: 30px;
            border-top: 1px solid #edf0f5;
        }

        .cv-form-section-title {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 6px;
            color: #172033;
            font-size: 1.08rem;
            font-weight: 800;
        }

        .cv-form-section-title i {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            border-radius: 10px;
            color: #4f46e5;
            background: #eef0fe;
        }

        .cv-form-help {
            margin: 0 0 20px 44px;
            color: #6b7280;
            font-size: 13px;
        }

        .cv-form-page .form-label {
            margin-bottom: 7px;
            color: #374151;
            font-size: 13px;
            font-weight: 700;
        }

        .cv-form-page .form-control,
        .cv-form-page .custom-select {
            min-height: 46px;
            border-color: #dfe3eb;
            border-radius: 9px;
            color: #172033;
            font-size: 14px;
        }

        .cv-form-page textarea.form-control {
            min-height: 110px;
            resize: vertical;
        }

        .cv-form-page .form-control:focus,
        .cv-form-page .custom-select:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, .14);
        }

        .cv-field-hint {
            margin-top: 6px;
            color: #6b7280;
            font-size: 12px;
        }

        .cv-repeater {
            padding: 18px;
            border: 1px solid #e8ebf2;
            border-radius: 12px;
            background: #fbfcfe;
        }

        .cv-repeater+.cv-repeater {
            margin-top: 14px;
        }

        .cv-repeater-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 16px;
        }

        .cv-repeater-heading strong {
            color: #172033;
            font-size: 14px;
        }

        .cv-repeater .btn-remove {
            min-height: 38px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
        }

        .cv-add-button {
            min-height: 44px;
            border: 1px dashed #9ca3af;
            border-radius: 9px;
            color: #4f46e5;
            font-weight: 700;
        }

        .cv-add-button:hover {
            color: #3730a3;
            border-color: #6366f1;
            background: #f5f5ff;
        }

        .cv-form-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 28px;
            padding-top: 24px;
            border-top: 1px solid #edf0f5;
        }

        .cv-form-footer .btn {
            min-height: 46px;
            border-radius: 9px;
            font-weight: 700;
        }

        @media (max-width: 767.98px) {

            .cv-form-header,
            .cv-form-card {
                padding: 22px;
            }

            .cv-form-help {
                margin-left: 0;
            }

            .cv-form-footer {
                display: grid;
                grid-template-columns: 1fr;
            }

            .cv-form-footer .btn {
                width: 100%;
            }
        }
    </style>

    <div class="cv-form-page">
        <section class="cv-form-header" aria-labelledby="cv-form-title">
            <div class="cv-form-header__content">
                <span class="cv-form-header__eyebrow">
                    <i class="fas fa-file-signature" aria-hidden="true"></i>
                    CV ATS
                </span>
                <h1 class="cv-form-header__title" id="cv-form-title">
                    {{ $cv->exists ? 'Perbarui CV ATS' : 'Buat CV ATS Anda' }}</h1>
                <p class="cv-form-header__description">Isi informasi dengan lengkap dan gunakan bahasa yang ringkas agar CV
                    mudah dibaca oleh sistem rekrutmen.</p>
            </div>
        </section>

        <form action="{{ $cv->exists ? route('membernonanggota.cv-ats.update') : route('membernonanggota.cv-ats.store') }}"
            method="POST" novalidate>
            @csrf
            @if ($cv->exists)
                @method('PUT')
            @endif

            <div class="cv-form-card">
                <!-- Data Pribadi Section -->
                <section class="cv-form-section">
                    <h2 class="cv-form-section-title"><i class="fas fa-user" aria-hidden="true"></i> Data Pribadi</h2>
                    <p class="cv-form-help">Informasi dasar yang akan ditampilkan di bagian utama CV Anda.</p>
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label" for="nama_lengkap">Nama lengkap <span
                                    class="text-danger">*</span></label>
                            <input id="nama_lengkap" type="text" name="nama_lengkap"
                                class="form-control @error('nama_lengkap') is-invalid @enderror"
                                value="{{ old('nama_lengkap', $cv->nama_lengkap) }}" autocomplete="name" required>
                            @error('nama_lengkap')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="nama_panggilan">Nama panggilan <span
                                    class="text-danger">*</span></label>
                            <input id="nama_panggilan" type="text" name="nama_panggilan"
                                class="form-control @error('nama_panggilan') is-invalid @enderror"
                                value="{{ old('nama_panggilan', $cv->nama_panggilan) }}" required>
                            @error('nama_panggilan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tempat Lahir (New Field) -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="tempat_lahir">Tempat lahir <span
                                    class="text-danger">*</span></label>
                            <input id="tempat_lahir" type="text" name="tempat_lahir"
                                class="form-control @error('tempat_lahir') is-invalid @enderror"
                                value="{{ old('tempat_lahir', $cv->tempat_lahir) }}" placeholder="Contoh: Jakarta" required>
                            @error('tempat_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tanggal Lahir (New Field) -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="tanggal_lahir">Tanggal lahir <span
                                    class="text-danger">*</span></label>
                            <input id="tanggal_lahir" type="date" name="tanggal_lahir"
                                class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                value="{{ old('tanggal_lahir', optional($cv->tanggal_lahir)->format('Y-m-d') ?? $cv->tanggal_lahir) }}"
                                required>
                            @error('tanggal_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="agama">Agama <span class="text-danger">*</span></label>
                            <select id="agama" name="agama" class="custom-select @error('agama') is-invalid @enderror"
                                required>
                                <option value="">Pilih agama</option>
                                @foreach (['islam' => 'Islam', 'katholik' => 'Katholik', 'protestan' => 'Protestan', 'hindu' => 'Hindu', 'budha' => 'Budha', 'tuhan yang maha esa' => 'Tuhan Yang Maha Esa'] as $value => $label)
                                    <option value="{{ $value }}" @selected(old('agama', $cv->agama) === $value)>{{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('agama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="statusperkawinan">Status perkawinan <span
                                    class="text-danger">*</span></label>
                            <select id="statusperkawinan" name="statusperkawinan"
                                class="custom-select @error('statusperkawinan') is-invalid @enderror" required>
                                <option value="">Pilih status</option>
                                @foreach (['Belum Menikah', 'Menikah', 'Duda/Janda'] as $status)
                                    <option value="{{ $status }}" @selected(old('statusperkawinan', $cv->statusperkawinan) === $status)>{{ $status }}
                                    </option>
                                @endforeach
                            </select>
                            @error('statusperkawinan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-8 mb-3">
                            <label class="form-label" for="telpdomisili">No. Telepon / WhatsApp <span
                                    class="text-danger">*</span></label>
                            <input id="telpdomisili" type="tel" inputmode="numeric" pattern="[0-9]*" data-numeric-only
                                name="telpdomisili" class="form-control @error('telpdomisili') is-invalid @enderror"
                                value="{{ old('telpdomisili', $cv->telpdomisili) }}" autocomplete="tel" required>
                            @error('telpdomisili')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="kodepos">Kode pos <span class="text-danger">*</span></label>
                            <input id="kodepos" type="text" inputmode="numeric" name="kodepos"
                                class="form-control @error('kodepos') is-invalid @enderror"
                                value="{{ old('kodepos', $cv->kodepos) }}" maxlength="5" required>
                            @error('kodepos')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label" for="alamatdomisili">Alamat domisili <span
                                    class="text-danger">*</span></label>
                            <textarea id="alamatdomisili" name="alamatdomisili"
                                class="form-control @error('alamatdomisili') is-invalid @enderror" rows="2" autocomplete="street-address"
                                required>{{ old('alamatdomisili', $cv->alamatdomisili) }}</textarea>
                            @error('alamatdomisili')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 mb-0">
                            <label class="form-label" for="pengalamanspesifik">Ringkasan Profil / Ringkasan Keahlian <span
                                    class="text-danger">*</span></label>
                            <textarea id="pengalamanspesifik" name="pengalamanspesifik"
                                class="form-control @error('pengalamanspesifik') is-invalid @enderror" rows="5" maxlength="2000"
                                placeholder="Tuliskan ringkasan keahlian, fokus karier, dan nilai yang dapat Anda berikan." required>{{ old('pengalamanspesifik', $cv->pengalamanspesifik) }}</textarea>
                            @error('pengalamanspesifik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </section>

                <!-- Riwayat Pendidikan Section -->
                <section class="cv-form-section">
                    <h2 class="cv-form-section-title"><i class="fas fa-graduation-cap" aria-hidden="true"></i> Riwayat
                        Pendidikan</h2>
                    <p class="cv-form-help">Isi salah satu atau kedua riwayat pendidikan berikut sesuai latar belakang
                        Anda.</p>
                    <h3 class="h6 font-weight-bold text-dark mb-3">Perguruan Tinggi (S1 / D4)</h3>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="perguruannama">Nama universitas</label>
                            <input id="perguruannama" type="text" name="perguruannama"
                                class="form-control @error('perguruannama') is-invalid @enderror"
                                value="{{ old('perguruannama', $cv->perguruannama) }}">
                            @error('perguruannama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="perguruanfakultas">Fakultas / program studi</label>
                            <input id="perguruanfakultas" type="text" name="perguruanfakultas"
                                class="form-control @error('perguruanfakultas') is-invalid @enderror"
                                value="{{ old('perguruanfakultas', $cv->perguruanfakultas) }}">
                            @error('perguruanfakultas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="perguruangelar">Gelar</label>
                            <input id="perguruangelar" type="text" name="perguruangelar"
                                class="form-control @error('perguruangelar') is-invalid @enderror"
                                value="{{ old('perguruangelar', $cv->perguruangelar) }}">
                            @error('perguruangelar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="perguruantahun">Tahun</label>
                            <input id="perguruantahun" type="text" name="perguruantahun"
                                class="form-control @error('perguruantahun') is-invalid @enderror"
                                value="{{ old('perguruantahun', $cv->perguruantahun) }}" placeholder="2022 - 2026">
                            @error('perguruantahun')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <h3 class="h6 font-weight-bold text-dark mb-3 mt-2">SMA / SMK / Sederajat</h3>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="smanama">Nama sekolah</label>
                            <input id="smanama" type="text" name="smanama"
                                class="form-control @error('smanama') is-invalid @enderror"
                                value="{{ old('smanama', $cv->smanama) }}">
                            @error('smanama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label" for="smafakultas">Jurusan</label>
                            <input id="smafakultas" type="text" name="smafakultas"
                                class="form-control @error('smafakultas') is-invalid @enderror"
                                value="{{ old('smafakultas', $cv->smafakultas) }}">
                            @error('smafakultas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label" for="smatahun">Tahun</label>
                            <input id="smatahun" type="text" name="smatahun"
                                class="form-control @error('smatahun') is-invalid @enderror"
                                value="{{ old('smatahun', $cv->smatahun) }}" placeholder="2019 - 2022">
                            @error('smatahun')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </section>

                <!-- Pengalaman Kerja Section -->
                <section class="cv-form-section">
                    <div class="d-flex align-items-start justify-content-between flex-wrap mb-3">
                        <div>
                            <h2 class="cv-form-section-title mb-1"><i class="fas fa-briefcase" aria-hidden="true"></i>
                                Pengalaman Kerja</h2>
                            <p class="cv-form-help mb-0">Tambahkan satu atau lebih pengalaman kerja. Bagian ini boleh
                                dikosongkan.</p>
                        </div>
                        <button type="button" class="btn cv-add-button mt-2 mt-md-0" data-add-repeater="experiences"><i
                                class="fas fa-plus mr-2" aria-hidden="true"></i> Tambah pengalaman</button>
                    </div>
                    <div id="experiences-list">
                        @foreach ($experienceItems as $index => $experience)
                            <div class="cv-repeater" data-repeater-item>
                                <div class="cv-repeater-heading"><strong>Pengalaman {{ $index + 1 }}</strong><button
                                        type="button" class="btn btn-outline-danger btn-remove" data-remove-repeater><i
                                            class="fas fa-trash-alt mr-1" aria-hidden="true"></i> Hapus</button></div>
                                <div class="row">
                                    <div class="col-md-6 mb-3"><label class="form-label">Nama perusahaan</label><input
                                            type="text" name="experiences[{{ $index }}][company]"
                                            class="form-control"
                                            value="{{ old("experiences.$index.company", $experience['company'] ?? '') }}"
                                            required></div>
                                    <div class="col-md-6 mb-3"><label class="form-label">Jabatan / Posisi</label><input
                                            type="text" name="experiences[{{ $index }}][position]"
                                            class="form-control"
                                            value="{{ old("experiences.$index.position", $experience['position'] ?? '') }}"
                                            required></div>
                                    <div class="col-md-4 mb-3"><label class="form-label">Tahun / Periode</label><input
                                            type="text" name="experiences[{{ $index }}][period]"
                                            class="form-control"
                                            value="{{ old("experiences.$index.period", $experience['period'] ?? '') }}"
                                            placeholder="2023 - 2024" required></div>
                                    <div class="col-md-8 mb-0"><label class="form-label">Tanggung Jawab Utama</label>
                                        <textarea name="experiences[{{ $index }}][responsibility]" class="form-control" rows="5"
                                            maxlength="5000" required>{{ old("experiences.$index.responsibility", $experience['responsibility'] ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <p id="experiences-empty" class="text-muted small mt-3 mb-0"
                        @if (count($experienceItems)) hidden @endif>Belum ada pengalaman kerja. Gunakan tombol di atas
                        untuk menambahkan.</p>
                </section>

                <!-- Pelatihan & Sertifikasi Section -->
                <section class="cv-form-section">
                    <div class="d-flex align-items-start justify-content-between flex-wrap mb-3">
                        <div>
                            <h2 class="cv-form-section-title mb-1"><i class="fas fa-certificate" aria-hidden="true"></i>
                                Pelatihan &amp; Sertifikasi</h2>
                            <p class="cv-form-help mb-0">Tambahkan pelatihan atau sertifikasi yang relevan dengan
                                kompetensi Anda.</p>
                        </div>
                        <button type="button" class="btn cv-add-button mt-2 mt-md-0" data-add-repeater="trainings"><i
                                class="fas fa-plus mr-2" aria-hidden="true"></i> Tambah pelatihan</button>
                    </div>
                    <div id="trainings-list">
                        @foreach ($trainingItems as $index => $training)
                            <div class="cv-repeater" data-repeater-item>
                                <div class="cv-repeater-heading"><strong>Pelatihan {{ $index + 1 }}</strong><button
                                        type="button" class="btn btn-outline-danger btn-remove" data-remove-repeater><i
                                            class="fas fa-trash-alt mr-1" aria-hidden="true"></i> Hapus</button></div>
                                <div class="row">
                                    <div class="col-md-5 mb-3"><label class="form-label">Nama pelatihan</label><input
                                            type="text" name="trainings[{{ $index }}][name]"
                                            class="form-control"
                                            value="{{ old("trainings.$index.name", $training['name'] ?? '') }}" required>
                                    </div>
                                    <div class="col-md-5 mb-3"><label class="form-label">Penyelenggara</label><input
                                            type="text" name="trainings[{{ $index }}][organizer]"
                                            class="form-control"
                                            value="{{ old("trainings.$index.organizer", $training['organizer'] ?? '') }}"
                                            required></div>
                                    <div class="col-md-2 mb-0"><label class="form-label">Tahun</label><input
                                            type="text" name="trainings[{{ $index }}][year]"
                                            class="form-control"
                                            value="{{ old("trainings.$index.year", $training['year'] ?? '') }}" required>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <p id="trainings-empty" class="text-muted small mt-3 mb-0"
                        @if (count($trainingItems)) hidden @endif>Belum ada pelatihan atau sertifikasi.</p>
                </section>

                <div class="cv-form-footer">
                    <a href="{{ route('membernonanggota.cv-ats.index') }}" class="btn btn-light border px-4">Batal</a>
                    <button type="submit" class="btn btn-primary px-4"><i class="fas fa-save mr-2"
                            aria-hidden="true"></i> {{ $cv->exists ? 'Simpan Perubahan' : 'Simpan CV ATS' }}</button>
                </div>
            </div>
        </form>
    </div>

    <template id="experience-template">
        <div class="cv-repeater" data-repeater-item>
            <div class="cv-repeater-heading"><strong>Pengalaman <span data-repeater-number></span></strong><button
                    type="button" class="btn btn-outline-danger btn-remove" data-remove-repeater><i
                        class="fas fa-trash-alt mr-1" aria-hidden="true"></i> Hapus</button></div>
            <div class="row">
                <div class="col-md-6 mb-3"><label class="form-label">Nama perusahaan</label><input type="text"
                        name="experiences[__INDEX__][company]" class="form-control" required></div>
                <div class="col-md-6 mb-3"><label class="form-label">Jabatan / Posisi</label><input type="text"
                        name="experiences[__INDEX__][position]" class="form-control" required></div>
                <div class="col-md-4 mb-3"><label class="form-label">Tahun / Periode</label><input type="text"
                        name="experiences[__INDEX__][period]" class="form-control" placeholder="2023 - 2024" required>
                </div>
                <div class="col-md-8 mb-0"><label class="form-label">Tanggung Jawab Utama</label>
                    <textarea name="experiences[__INDEX__][responsibility]" class="form-control" rows="5" maxlength="5000"
                        required></textarea>
                </div>
            </div>
        </div>
    </template>

    <template id="training-template">
        <div class="cv-repeater" data-repeater-item>
            <div class="cv-repeater-heading"><strong>Pelatihan <span data-repeater-number></span></strong><button
                    type="button" class="btn btn-outline-danger btn-remove" data-remove-repeater><i
                        class="fas fa-trash-alt mr-1" aria-hidden="true"></i> Hapus</button></div>
            <div class="row">
                <div class="col-md-5 mb-3"><label class="form-label">Nama pelatihan</label><input type="text"
                        name="trainings[__INDEX__][name]" class="form-control" required></div>
                <div class="col-md-5 mb-3"><label class="form-label">Penyelenggara</label><input type="text"
                        name="trainings[__INDEX__][organizer]" class="form-control" required></div>
                <div class="col-md-2 mb-0"><label class="form-label">Tahun</label><input type="text"
                        name="trainings[__INDEX__][year]" class="form-control" required></div>
            </div>
        </div>
    </template>
@endsection

@push('scripts')
    <script>
        (function() {
            document.querySelectorAll('[data-numeric-only]').forEach(function(input) {
                input.addEventListener('input', function() {
                    this.value = this.value.replace(/[^0-9]/g, '');
                });
            });

            function updateRepeaterState(type) {
                var list = document.getElementById(type + '-list');
                var empty = document.getElementById(type + '-empty');
                var items = list.querySelectorAll('[data-repeater-item]');

                items.forEach(function(item, index) {
                    var number = item.querySelector('[data-repeater-number]');
                    if (number) number.textContent = index + 1;
                });

                if (empty) empty.hidden = items.length > 0;
            }

            document.querySelectorAll('[data-add-repeater]').forEach(function(button) {
                button.addEventListener('click', function() {
                    var type = button.getAttribute('data-add-repeater');
                    var list = document.getElementById(type + '-list');
                    var template = document.getElementById(type === 'experiences' ?
                        'experience-template' : 'training-template');
                    var index = list.querySelectorAll('[data-repeater-item]').length;
                    var html = template.innerHTML.replace(/__INDEX__/g, index);
                    list.insertAdjacentHTML('beforeend', html);
                    updateRepeaterState(type);
                });
            });

            document.addEventListener('click', function(event) {
                var removeButton = event.target.closest('[data-remove-repeater]');
                if (!removeButton) return;

                var item = removeButton.closest('[data-repeater-item]');
                var list = item.parentElement;
                item.remove();
                updateRepeaterState(list.id.replace('-list', ''));
            });

            updateRepeaterState('experiences');
            updateRepeaterState('trainings');
        }());
    </script>
@endpush
