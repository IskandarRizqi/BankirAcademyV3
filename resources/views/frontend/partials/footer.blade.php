    <footer class="site-footer">
        <div class="footer-main">
            <div class="container footer-grid">
                <div class="footer-brand">
                    <a class="brand active" href="{{ route('frontend.home') }}">
                        <img src="{{ asset('bankir-academy-icon.png') }}" alt="logo">
                        <span class="brand-copy"><strong>Bankir Academy</strong><small class="brand-copy-muted">Learning ·
                                Talent · Banking Solutions</small></span>
                    </a>
                    <p>
                        Platform pembelajaran dan pengembangan ekosistem perbankan untuk
                        calon bankir, profesional, institusi, sekolah, kampus, UMKM, dan
                        komunitas.
                    </p>
                    <form action="#" class="newsletter" method="post"
                        onsubmit="
                event.preventDefault();
                alert(
                  'Terima kasih. Fitur berlangganan dapat dihubungkan ke sistem email Anda.',
                );
              ">
                        <label class="sr-only" for="newsletterEmail">Alamat email</label>
                        <input id="newsletterEmail" placeholder="Masukkan alamat email" required="" type="email" />
                        <button aria-label="Berlangganan" type="submit">→</button>
                    </form>
                    <div class="footer-contact">
                        <span class="contact-row"><i>✉</i> info@bankiracademy.co.id</span>
                        <span class="contact-row"><i>⌖</i> Permata Puri, Ngaliyan, Semarang</span>
                        <span class="contact-row"><i>◎</i> bankiracademy.co.id</span>
                    </div>
                </div>
                <div>
                    <div class="footer-title">Kenali</div>
                    <nav class="footer-links">
                        <a href="{{ route('frontend.home') }}#beranda">Tentang Kami</a>
                        <a href="{{ route('frontend.curriculum') }}">Kurikulum</a>
                    </nav>
                </div>
                <div>
                    <div class="footer-title">Pusat Bantuan</div>
                    <nav class="footer-links">
                        <a href="{{ route('frontend.support.faq') }}">Tanya Jawab (FAQ)</a>
                        <a href="{{ route('frontend.support.faq') }}#administrasi">Panduan Pendaftaran</a>
                        <a href="{{ route('frontend.support.terms') }}">Syarat &amp; Ketentuan</a>
                        <a href="{{ route('frontend.support.privacy') }}">Kebijakan Privasi</a>
                        <a href="{{ route('frontend.support.contact') }}">Kontak Kami</a>
                    </nav>
                </div>
                <div>
                    <div class="footer-title">Tautan</div>
                    <nav class="footer-links">
                        <a href="{{ route('frontend.home') }}#kelas-online">Promo</a>
                        <a href="{{ route('frontend.articles.index') }}">Artikel</a>
                        <a href="{{ route('frontend.talent.job-connect') }}">Pusat Lowongan Kerja</a>
                        <a href="{{ route('frontend.classes.index') }}">Kelas Online</a>
                        <a href="{{ route('login.new') }}">Login</a>
                    </nav>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container footer-bottom-inner">
                <span>Copyright © 2026 Bankir Academy. All rights reserved.</span>
                <div class="footer-legal">
                    <a href="{{ route('frontend.support.terms') }}">Syarat &amp; Ketentuan</a>
                    <a href="{{ route('frontend.support.privacy') }}">Kebijakan Privasi</a>
                </div>
            </div>
        </div>
    </footer>
    <!-- Ganti href dengan URL WhatsApp resmi Bankir Academy -->
    {{-- <a aria-label="Hubungi Bankir Academy" class="floating-help" href="mailto:info@bankiracademy.co.id">
        <span>✉</span><span>Butuh bantuan?</span>
    </a> --}}
    <div class="assistant-welcome" id="assistantWelcome" role="status" aria-live="polite">
        <button class="assistant-welcome-close" type="button" data-assistant-close
            aria-label="Tutup pesan bantuan">&times;</button>
        <div class="assistant-welcome-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2L13.6 8.4L20 10L13.6 11.6L12 18L10.4 11.6L4 10L10.4 8.4L12 2Z"
                    fill="currentColor" />
                <path d="M19 16L19.7 18.3L22 19L19.7 19.7L19 22L18.3 19.7L16 19L18.3 18.3L19 16Z"
                    fill="currentColor" />
            </svg>
        </div>
        <div class="assistant-welcome-content">
            <strong>Halo, saya AI Assistant Bankir Academy</strong>
            <p>Butuh bantuan memahami sistem, kelas, atau layanan kami? Klik tombol WhatsApp di bawah, ya.</p>
        </div>
    </div>
    <a href="https://wa.me/6289682019523?text=Halo%20Tim%20Bankir%20Academy,%20saya%20ingin%20menanyakan%20tentang%20sistem%20dan%20layanan"
        aria-label="Hubungi Bankir Academy melalui WhatsApp" class="floating-help" target="_blank"
        rel="noopener noreferrer">
        <span class="floating-help-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill="currentColor"
                    d="M20.52 3.48A11.94 11.94 0 0 0 12.03 0C5.45 0 .1 5.35.1 11.93c0 2.1.55 4.15 1.6 5.96L0 24l6.25-1.64a11.94 11.94 0 0 0 5.78 1.49h.01c6.58 0 11.93-5.35 11.93-11.93 0-3.19-1.24-6.18-3.45-8.44ZM12.04 21.8h-.01a9.88 9.88 0 0 1-5.03-1.38l-.36-.21-3.71.97.99-3.62-.23-.37a9.88 9.88 0 0 1-1.52-5.26c0-5.45 4.44-9.88 9.89-9.88a9.82 9.82 0 0 1 6.99 2.9 9.83 9.83 0 0 1 2.89 7c0 5.45-4.44 9.88-9.9 9.88Zm5.42-7.4c-.3-.15-1.77-.87-2.04-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.94 1.17-.17.2-.35.22-.65.07-.3-.15-1.25-.46-2.38-1.47-.88-.78-1.47-1.75-1.64-2.05-.17-.3-.02-.46.13-.61.14-.14.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.07-.15-.67-1.61-.92-2.2-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.49s1.07 2.89 1.22 3.09c.15.2 2.1 3.21 5.09 4.5.71.31 1.27.49 1.71.63.72.23 1.38.2 1.9.12.58-.09 1.77-.72 2.02-1.42.25-.7.25-1.3.17-1.42-.07-.12-.27-.2-.57-.35Z" />
            </svg>
        </span>
        <span class="floating-help-copy">
            <strong>Butuh bantuan?</strong>
            <small>Tanyakan sistem &amp; layanan</small>
        </span>
        <span class="floating-help-arrow" aria-hidden="true">→</span>
    </a>
    <style>
        .assistant-welcome {
            position: fixed;
            right: 22px;
            bottom: 88px;
            z-index: 91;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            width: min(320px, calc(100vw - 44px));
            padding: 14px 34px 14px 14px;
            color: #282346;
            background: #fff;
            border: 1px solid #e7e8f3;
            border-radius: 16px;
            box-shadow: 0 16px 40px rgba(52, 42, 120, 0.18);
            animation: assistant-welcome-in 0.35s ease both;
        }

        .assistant-welcome::after {
            content: '';
            position: absolute;
            right: 35px;
            bottom: -7px;
            width: 14px;
            height: 14px;
            background: #fff;
            border-right: 1px solid #e7e8f3;
            border-bottom: 1px solid #e7e8f3;
            transform: rotate(45deg);
        }

        .assistant-welcome[hidden] {
            display: none;
        }

        .assistant-welcome-close {
            position: absolute;
            top: 8px;
            right: 9px;
            width: 24px;
            height: 24px;
            padding: 0;
            color: #8d89a1;
            background: transparent;
            border: 0;
            border-radius: 50%;
            font-size: 20px;
            line-height: 1;
            cursor: pointer;
        }

        .assistant-welcome-close:hover {
            color: #342a78;
            background: #f1efff;
        }

        .assistant-welcome-icon {
            display: inline-flex;
            flex: 0 0 34px;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            color: #6757d9;
            background: #f1efff;
            border-radius: 11px;
        }

        .assistant-welcome-icon svg {
            width: 20px;
            height: 20px;
        }

        .assistant-welcome-content {
            position: relative;
            z-index: 1;
        }

        .assistant-welcome-content strong {
            display: block;
            padding-right: 3px;
            color: #342a78;
            font-size: 11px;
            font-weight: 800;
            line-height: 1.35;
        }

        .assistant-welcome-content p {
            margin: 5px 0 0;
            color: #716d85;
            font-size: 10px;
            line-height: 1.5;
        }

        @keyframes assistant-welcome-in {
            from {
                opacity: 0;
                transform: translateY(8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .floating-help {
            gap: 10px;
            padding: 9px 12px 9px 9px;
            background: linear-gradient(135deg, #25d366, #128c7e);
            border: 1px solid rgba(255, 255, 255, 0.22);
            text-decoration: none;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .floating-help:hover {
            color: #fff;
            transform: translateY(-3px);
            box-shadow: 0 18px 38px rgba(16, 119, 73, 0.36);
        }

        .floating-help-icon {
            display: inline-flex;
            flex: 0 0 34px;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            color: #128c7e;
            background: #fff;
            border-radius: 50%;
        }

        .floating-help-icon svg {
            width: 20px;
            height: 20px;
        }

        .floating-help-copy {
            display: flex;
            flex-direction: column;
            gap: 2px;
            line-height: 1.2;
        }

        .floating-help-copy strong {
            color: #fff;
            font-size: 11px;
            font-weight: 800;
        }

        .floating-help-copy small {
            color: rgba(255, 255, 255, 0.82);
            font-size: 9px;
            font-weight: 600;
        }

        .floating-help-arrow {
            color: rgba(255, 255, 255, 0.85);
            font-size: 16px;
            line-height: 1;
        }

        @media (max-width: 700px) {
            .assistant-welcome {
                right: 14px;
                bottom: 82px;
                width: min(320px, calc(100vw - 28px));
            }
        }
    </style>
    <script>
        document.querySelector('[data-assistant-close]')?.addEventListener('click', function() {
            document.getElementById('assistantWelcome').hidden = true;
        });
    </script>
    <script src="{{ asset('frontend/js/bankir-academy.js') }}" defer></script>
