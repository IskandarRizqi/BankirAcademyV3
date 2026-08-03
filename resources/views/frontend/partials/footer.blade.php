    <footer class="site-footer">
      <div class="footer-main">
        <div class="container footer-grid">
          <div class="footer-brand">
            <a class="brand active" href="{{ route('frontend.home') }}">
              <svg aria-hidden="true" class="brand-logo">
                <use href="#logo-ba"></use>
              </svg>
              <span class="brand-copy"
                ><strong>Bankir Academy</strong
                ><small style="color: #aaa5cf"
                  >Learning · Talent · Banking Solutions</small
                ></span
              >
            </a>
            <p>
              Platform pembelajaran dan pengembangan ekosistem perbankan untuk
              calon bankir, profesional, institusi, sekolah, kampus, UMKM, dan
              komunitas.
            </p>
            <form
              action="#"
              class="newsletter"
              method="post"
              onsubmit="
                event.preventDefault();
                alert(
                  'Terima kasih. Fitur berlangganan dapat dihubungkan ke sistem email Anda.',
                );
              "
            >
              <label class="sr-only" for="newsletterEmail">Alamat email</label>
              <input
                id="newsletterEmail"
                placeholder="Masukkan alamat email"
                required=""
                type="email"
              />
              <button aria-label="Berlangganan" type="submit">→</button>
            </form>
            <div class="footer-contact">
              <span class="contact-row"><i>✉</i> info@bankiracademy.co.id</span>
              <span class="contact-row"
                ><i>⌖</i> Permata Puri, Ngaliyan, Semarang</span
              >
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
    <a
      aria-label="Hubungi Bankir Academy"
      class="floating-help"
      href="mailto:info@bankiracademy.co.id"
    >
      <span>✉</span><span>Butuh bantuan?</span>
    </a>
    <script>
          const header = document.getElementById('siteHeader');
          const menuToggle = document.getElementById('menuToggle');
          const mobilePanel = document.getElementById('mobilePanel');

          window.addEventListener('scroll', () => {
            header.classList.toggle('scrolled', window.scrollY > 20);
          });

          menuToggle.addEventListener('click', () => {
            const open = mobilePanel.classList.toggle('open');
            document.body.classList.toggle('menu-open', open);
            menuToggle.setAttribute('aria-expanded', String(open));
            menuToggle.textContent = open ? '✕' : '☰';
          });

          document.querySelectorAll('.mobile-main[type="button"]').forEach(button => {
            button.addEventListener('click', () => {
              const sub = button.nextElementSibling;
              const open = sub.classList.toggle('open');
              button.querySelector('span').textContent = open ? '−' : '＋';
            });
          });

          document.querySelectorAll('.mobile-panel a').forEach(link => {
            link.addEventListener('click', () => {
              mobilePanel.classList.remove('open');
              document.body.classList.remove('menu-open');
              menuToggle.setAttribute('aria-expanded', 'false');
              menuToggle.textContent = '☰';
            });
          });

          document.querySelectorAll('.faq-q').forEach(button => {
            button.addEventListener('click', () => {
              const item = button.closest('.faq-item');
              const wasOpen = item.classList.contains('open');
              document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('open'));
              if (!wasOpen) item.classList.add('open');
            });
          });

          const sections = document.querySelectorAll('main section[id]');
          const navLinks = document.querySelectorAll('.desktop-nav > a.nav-link, .desktop-nav > .nav-item > a.nav-link');
          const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
              if (!entry.isIntersecting) return;
              navLinks.forEach(link => link.classList.remove('active'));
              const id = entry.target.id;
              const direct = document.querySelector(`.desktop-nav a[href="#${id}"]`);
              if (direct) direct.classList.add('active');
              if (['banking-solution','capacity-building','banking-talent','lms','inovasi','csr','layanan','innovation-lab'].includes(id)) {
                document.querySelector('.desktop-nav a[href="#layanan"]')?.classList.add('active');
              }
              if (['talent-solutions'].includes(id)) {
                document.querySelector('.desktop-nav a[href="#talent-solutions"]')?.classList.add('active');
              }
              if (['foundations'].includes(id)) {
                document.querySelector('.desktop-nav a[href="#foundations"]')?.classList.add('active');
              }
            });
          }, {rootMargin:'-35% 0px -55% 0px'});
          sections.forEach(section => observer.observe(section));
    </script>
