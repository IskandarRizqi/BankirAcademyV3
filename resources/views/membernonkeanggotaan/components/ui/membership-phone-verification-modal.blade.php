@php
    $profile = $membershipProfile ?? auth()->user()->profile;
    $membershipType = session('phone_verification_membership_type');
@endphp

@once
    <style>
        .membership-phone-verification-modal .modal-content {
            border: 0;
            border-radius: 18px;
            box-shadow: 0 24px 70px rgba(15, 23, 42, .22);
        }

        .membership-phone-verification-modal .modal-header,
        .membership-phone-verification-modal .modal-body {
            padding: 22px;
        }

        .membership-phone-verification-modal .modal-header {
            border-bottom: 0;
            padding-bottom: 0;
        }

        .membership-phone-verification-modal__title {
            margin: 0;
            color: #111827;
            font-size: 20px;
            font-weight: 800;
        }

        .membership-phone-verification-modal__description {
            margin: 8px 0 18px;
            color: #6b7280;
            font-size: 13px;
            line-height: 1.6;
        }

        .membership-phone-verification-modal__phone {
            display: block;
            margin-bottom: 16px;
            padding: 11px 13px;
            border-radius: 9px;
            background: #f3f4f6;
            color: #374151;
            font-size: 14px;
            font-weight: 800;
            text-align: center;
        }

        .membership-phone-verification-modal__input {
            display: block;
            width: 100%;
            min-height: 46px;
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 9px;
            color: #111827;
            font-size: 20px;
            font-weight: 800;
            letter-spacing: .28em;
            text-align: center;
        }

        .membership-phone-verification-modal__input:focus {
            border-color: #4f46e5;
            outline: 0;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, .12);
        }

        .membership-phone-verification-modal__button {
            width: 100%;
            min-height: 42px;
            margin-top: 12px;
            padding: 9px 15px;
            border: 0;
            border-radius: 9px;
            background: #111827;
            color: #fff;
            font-size: 13px;
            font-weight: 800;
        }

        .membership-phone-verification-modal__resend {
            display: block;
            width: 100%;
            margin-top: 12px;
            padding: 0;
            border: 0;
            background: transparent;
            color: #4f46e5;
            font-size: 12px;
            font-weight: 800;
        }
    </style>
@endonce

<div class="modal fade membership-phone-verification-modal" id="membershipPhoneVerificationModal" tabindex="-1"
    role="dialog" aria-labelledby="membershipPhoneVerificationModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="membership-phone-verification-modal__title" id="membershipPhoneVerificationModalTitle">
                        Verifikasi nomor handphone</h5>
                    <p class="membership-phone-verification-modal__description">
                        Masukkan kode OTP yang dikirim ke WhatsApp Anda sebelum memilih membership.
                    </p>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup"><span
                        aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                <span class="membership-phone-verification-modal__phone">+{{ $profile?->phone ?? '-' }}</span>

                <form method="POST" action="{{ route('membernonanggota.membership-phone.verify') }}">
                    @csrf
                    <input type="hidden" name="membership_tipe" value="{{ $membershipType }}">
                    <input class="membership-phone-verification-modal__input" name="otp" type="text"
                        inputmode="numeric" pattern="[0-9]{6}" maxlength="6" autocomplete="one-time-code"
                        placeholder="••••••" required>
                    <button type="submit" class="membership-phone-verification-modal__button">Verifikasi OTP</button>
                </form>

                <form method="POST" action="{{ route('membernonanggota.membership-phone.send') }}">
                    @csrf
                    <input type="hidden" name="membership_tipe" value="{{ $membershipType }}">
                    <button type="submit" class="membership-phone-verification-modal__resend">Kirim ulang OTP</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('open_phone_verification') || ($errors->has('otp') && old('otp') !== null))
                if (typeof $ !== 'undefined') {
                    $('#membershipPhoneVerificationModal').modal('show');
                }
            @endif
        });
    </script>
@endpush
