@php
    $profile = $membershipProfile ?? null;
    $locations = $membershipLocations ?? ['cities' => collect(), 'districts' => collect(), 'villages' => collect()];
@endphp

@once
    <style>
        .membership-profile-modal .modal-content {
            border: 0;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 24px 70px rgba(15, 23, 42, .22);
        }

        .membership-profile-modal .modal-header {
            padding: 20px 22px 0;
            border-bottom: 0;
        }

        .membership-profile-modal__title {
            margin: 0;
            color: #111827;
            font-size: 20px;
            font-weight: 800;
            line-height: 1.3;
        }

        .membership-profile-modal__subtitle {
            margin: 6px 0 0;
            color: #6b7280;
            font-size: 13px;
            line-height: 1.6;
        }

        .membership-profile-modal .modal-body {
            padding: 22px;
        }

        .membership-profile-form {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .membership-profile-form__field {
            min-width: 0;
        }

        .membership-profile-form__field--wide {
            grid-column: 1 / -1;
        }

        .membership-profile-form__label {
            display: block;
            margin-bottom: 6px;
            color: #374151;
            font-size: 12px;
            font-weight: 700;
        }

        .membership-profile-form__control {
            display: block;
            width: 100%;
            min-height: 42px;
            padding: 9px 11px;
            border: 1px solid #d1d5db;
            border-radius: 9px;
            background: #fff;
            color: #111827;
            font-size: 13px;
        }

        textarea.membership-profile-form__control {
            min-height: 82px;
            resize: vertical;
        }

        .membership-profile-form__control:focus {
            border-color: #4f46e5;
            outline: 0;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, .12);
        }

        .membership-profile-form__error {
            display: block;
            margin-top: 5px;
            color: #b91c1c;
            font-size: 11px;
        }

        .membership-profile-form__actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 18px;
        }

        .membership-profile-form__button {
            min-height: 42px;
            padding: 9px 15px;
            border: 0;
            border-radius: 9px;
            background: #111827;
            color: #fff;
            font-size: 13px;
            font-weight: 800;
        }

        .membership-profile-form__button:hover {
            background: #4f46e5;
            color: #fff;
        }

        .membership-profile-form__button--secondary {
            background: #f3f4f6;
            color: #374151;
        }

        @media (max-width: 575.98px) {
            .membership-profile-form {
                grid-template-columns: 1fr;
            }

            .membership-profile-form__field--wide {
                grid-column: auto;
            }

            .membership-profile-form__actions {
                flex-direction: column-reverse;
            }

            .membership-profile-form__button {
                width: 100%;
            }
        }
    </style>
@endonce

<div class="modal fade membership-profile-modal" id="membershipProfileModal" tabindex="-1" role="dialog"
    aria-labelledby="membershipProfileModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="membership-profile-modal__title" id="membershipProfileModalTitle">Lengkapi profile Anda
                    </h5>
                    <p class="membership-profile-modal__subtitle">Data ini digunakan untuk proses pendaftaran membership
                        dan dapat diperbarui kapan saja.</p>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup"><span
                        aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                <form method="POST" action="{{ route('membernonanggota.membership-profile.update') }}">
                    @csrf
                    <input type="hidden" name="membership_tipe" id="membership-profile-type"
                        value="{{ old('membership_tipe', session('open_membership_profile', '')) }}">

                    <div class="membership-profile-form">
                        <div class="membership-profile-form__field">
                            <label class="membership-profile-form__label" for="membership-profile-name">Nama lengkap
                                <span class="text-danger">*</span></label>
                            <input class="membership-profile-form__control" id="membership-profile-name" name="name"
                                type="text" value="{{ old('name', $profile->name ?? '') }}" required>
                            @error('name')
                                <span class="membership-profile-form__error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="membership-profile-form__field">
                            <label class="membership-profile-form__label" for="membership-profile-phone">Nomor HP <span
                                    class="text-danger">*</span></label>
                            <input class="membership-profile-form__control" id="membership-profile-phone" name="phone"
                                type="text" value="{{ old('phone', $profile->phone ?? '') }}" inputmode="tel"
                                required>
                            @error('phone')
                                <span class="membership-profile-form__error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="membership-profile-form__field">
                            <label class="membership-profile-form__label" for="membership-profile-gender">Gender <span
                                    class="text-danger">*</span></label>
                            <select class="membership-profile-form__control" id="membership-profile-gender"
                                name="gender" required>
                                <option value="">Pilih gender</option>
                                <option value="1" @selected((string) old('gender', $profile->gender ?? '') === '1')>Laki-laki</option>
                                <option value="0" @selected((string) old('gender', $profile->gender ?? '') === '0')>Perempuan</option>
                            </select>
                            @error('gender')
                                <span class="membership-profile-form__error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="membership-profile-form__field">
                            <label class="membership-profile-form__label" for="membership-profile-birth-date">Tanggal
                                lahir <span class="text-danger">*</span></label>
                            <input class="membership-profile-form__control" id="membership-profile-birth-date"
                                name="tanggal_lahir" type="date"
                                value="{{ old('tanggal_lahir', $profile->tanggal_lahir ?? '') }}"
                                max="{{ now()->format('Y-m-d') }}" required>
                            @error('tanggal_lahir')
                                <span class="membership-profile-form__error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="membership-profile-form__field membership-profile-form__field--wide">
                            <label class="membership-profile-form__label" for="membership-profile-address">Alamat
                                lengkap <span class="text-danger">*</span></label>
                            <textarea class="membership-profile-form__control" id="membership-profile-address" name="alamat" required>{{ old('alamat', $profile->alamat ?? ($profile->description ?? '')) }}</textarea>
                            @error('alamat')
                                <span class="membership-profile-form__error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="membership-profile-form__field">
                            <label class="membership-profile-form__label" for="membership-profile-province">Provinsi
                                <span class="text-danger">*</span></label>
                            <select class="membership-profile-form__control" id="membership-profile-province"
                                name="provinsi_id" required>
                                <option value="">Pilih provinsi</option>
                                @foreach ($membershipProvinces ?? [] as $province)
                                    <option value="{{ $province->id }}" @selected((string) old('provinsi_id', $profile->provinsi_id ?? '') === (string) $province->id)>
                                        {{ $province->name }}</option>
                                @endforeach
                            </select>
                            @error('provinsi_id')
                                <span class="membership-profile-form__error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="membership-profile-form__field">
                            <label class="membership-profile-form__label" for="membership-profile-city">Kota / kabupaten
                                <span class="text-danger">*</span></label>
                            <select class="membership-profile-form__control" id="membership-profile-city" name="kota_id"
                                required {{ old('provinsi_id', $profile->provinsi_id ?? '') ? '' : 'disabled' }}>
                                <option value="">Pilih kota / kabupaten</option>
                                @foreach ($locations['cities'] as $city)
                                    <option value="{{ $city->id }}" @selected((string) old('kota_id', $profile->kota_id ?? '') === (string) $city->id)>
                                        {{ $city->name }}</option>
                                @endforeach
                            </select>
                            @error('kota_id')
                                <span class="membership-profile-form__error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="membership-profile-form__field">
                            <label class="membership-profile-form__label" for="membership-profile-district">Kecamatan
                                <span class="text-danger">*</span></label>
                            <select class="membership-profile-form__control" id="membership-profile-district"
                                name="kecamatan_id" required
                                {{ old('kota_id', $profile->kota_id ?? '') ? '' : 'disabled' }}>
                                <option value="">Pilih kecamatan</option>
                                @foreach ($locations['districts'] as $district)
                                    <option value="{{ $district->id }}" @selected((string) old('kecamatan_id', $profile->kecamatan_id ?? '') === (string) $district->id)>
                                        {{ $district->name }}</option>
                                @endforeach
                            </select>
                            @error('kecamatan_id')
                                <span class="membership-profile-form__error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="membership-profile-form__field">
                            <label class="membership-profile-form__label" for="membership-profile-village">Kelurahan
                                <span class="text-danger">*</span></label>
                            <select class="membership-profile-form__control" id="membership-profile-village"
                                name="kelurahan_id" required
                                {{ old('kecamatan_id', $profile->kecamatan_id ?? '') ? '' : 'disabled' }}>
                                <option value="">Pilih kelurahan</option>
                                @foreach ($locations['villages'] as $village)
                                    <option value="{{ $village->id }}" @selected((string) old('kelurahan_id', $profile->kelurahan_id ?? '') === (string) $village->id)>
                                        {{ $village->name }}</option>
                                @endforeach
                            </select>
                            @error('kelurahan_id')
                                <span class="membership-profile-form__error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="membership-profile-form__actions">
                        <button type="button"
                            class="membership-profile-form__button membership-profile-form__button--secondary"
                            data-dismiss="modal">Batal</button>
                        <button type="submit" class="membership-profile-form__button">Simpan profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('membershipProfileModal');
            const province = document.getElementById('membership-profile-province');
            const city = document.getElementById('membership-profile-city');
            const district = document.getElementById('membership-profile-district');
            const village = document.getElementById('membership-profile-village');
            const membershipType = document.getElementById('membership-profile-type');

            if (!modal) return;

            document.querySelectorAll('[data-member-type]').forEach(function(button) {
                button.addEventListener('click', function() {
                    if (membershipType) {
                        membershipType.value = this.dataset.memberType || '';
                    }
                });
            });

            // Reset dropdown pilihan & kembalikan ke status disabled
            function resetSelect(select, defaultText) {
                select.innerHTML = `<option value="">${defaultText}</option>`;
                select.value = '';
                select.disabled = true;
            }

            // Fetch options secara native lewat Fetch API
            function loadLocations(url, parentId, targetSelect, defaultText) {
                if (!parentId) {
                    resetSelect(targetSelect, defaultText);
                    return Promise.resolve();
                }

                targetSelect.innerHTML = `<option value="">Memuat...</option>`;
                targetSelect.disabled = true;

                const requestUrl = `${url}?parent_id=${encodeURIComponent(parentId)}`;

                return fetch(requestUrl, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        const items = data.results || [];
                        let optionsHtml = `<option value="">${defaultText}</option>`;

                        items.forEach(item => {
                            optionsHtml +=
                                `<option value="${item.id}">${item.text || item.name}</option>`;
                        });

                        targetSelect.innerHTML = optionsHtml;
                        targetSelect.disabled = false;
                    })
                    .catch(error => {
                        console.error('Gagal memuat data lokasi:', error);
                        resetSelect(targetSelect, 'Gagal memuat data');
                    });
            }

            // Event listener perubahan Provinsi
            province.addEventListener('change', function() {
                const provinceId = this.value;
                resetSelect(district, 'Pilih kecamatan');
                resetSelect(village, 'Pilih kelurahan');

                loadLocations(
                    '{{ route('membernonanggota.membership-profile.locations.cities') }}',
                    provinceId,
                    city,
                    'Pilih kota / kabupaten'
                );
            });

            // Event listener perubahan Kota
            city.addEventListener('change', function() {
                const cityId = this.value;
                resetSelect(village, 'Pilih kelurahan');

                loadLocations(
                    '{{ route('membernonanggota.membership-profile.locations.districts') }}',
                    cityId,
                    district,
                    'Pilih kecamatan'
                );
            });

            // Event listener perubahan Kecamatan
            district.addEventListener('change', function() {
                const districtId = this.value;

                loadLocations(
                    '{{ route('membernonanggota.membership-profile.locations.villages') }}',
                    districtId,
                    village,
                    'Pilih kelurahan'
                );
            });

            // Tampilkan modal jika session/error memerlukan modal terbuka
            @if (session('open_membership_type'))
                if (typeof $ !== 'undefined') {
                    const type = @json((int) session('open_membership_type'));
                    const target = type === 1 ? '#membershipPackageModal' : '#membershipIndividualModal';
                    $(target).modal('show');
                }
            @elseif (session('open_membership_profile') || ($errors->any() && old('membership_tipe')))
                if (typeof $ !== 'undefined') {
                    $('#membershipProfileModal').modal('show');
                }
            @endif
        });
    </script>
@endpush
