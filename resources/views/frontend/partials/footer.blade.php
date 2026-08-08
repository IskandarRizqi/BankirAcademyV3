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
                        <a class="active" href="{{ route('frontend.home') }}#beranda">Tentang Kami</a>
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
                        <a class="active" href="{{ route('frontend.home') }}#kelas-online">Promo</a>
                        <a href="{{ route('frontend.talent.job-connect') }}">Pusat Lowongan Kerja</a>
                        <a class="active" href="{{ route('frontend.classes.index') }}">Kelas Online</a>
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
    <a href="https://wa.me/6289682019523?text=Halo%20Tim%20Bankir%20Academy,%20saya%20butuh%20bantuan"
        class="floating-help" target="_blank">
        <span>✉</span><span>Butuh bantuan?</span></a>
    <script src="{{ asset('frontend/js/bankir-academy.js') }}" defer></script>
