(function () {
    const header = document.getElementById('siteHeader');
    const menuToggle = document.getElementById('menuToggle');
    const mobilePanel = document.getElementById('mobilePanel');

    if (header) {
        const updateHeader = () => header.classList.toggle('scrolled', window.scrollY > 20);
        window.addEventListener('scroll', updateHeader, { passive: true });
        updateHeader();
    }

    const closeMobileMenu = () => {
        if (!mobilePanel || !menuToggle) return;

        mobilePanel.classList.remove('open');
        document.body.classList.remove('menu-open');
        menuToggle.setAttribute('aria-expanded', 'false');
        menuToggle.textContent = '☰';
    };

    if (menuToggle && mobilePanel) {
        menuToggle.addEventListener('click', () => {
            const open = mobilePanel.classList.toggle('open');
            document.body.classList.toggle('menu-open', open);
            menuToggle.setAttribute('aria-expanded', String(open));
            menuToggle.textContent = open ? '✕' : '☰';
        });

        mobilePanel.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', closeMobileMenu);
        });
    }

    document.querySelectorAll('.mobile-main[type="button"]').forEach((button) => {
        button.addEventListener('click', () => {
            const sub = button.nextElementSibling;
            const open = sub.classList.toggle('open');
            button.querySelector('span:last-child').textContent = open ? '−' : '＋';
        });
    });

    document.querySelectorAll('.faq-q').forEach((button) => {
        button.addEventListener('click', () => {
            const item = button.closest('.faq-item');
            const wasOpen = item.classList.contains('open');
            document.querySelectorAll('.faq-item').forEach((faq) => faq.classList.remove('open'));
            if (!wasOpen) item.classList.add('open');
        });
    });

    const sections = document.querySelectorAll('main section[id]');
    const navLinks = document.querySelectorAll(
        '.desktop-nav > a.nav-link, .desktop-nav > .nav-item > a.nav-link',
    );

    if ('IntersectionObserver' in window && sections.length && navLinks.length) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;

                navLinks.forEach((link) => link.classList.remove('active'));
                const id = entry.target.id;
                const direct = document.querySelector(`.desktop-nav a[href="#${id}"]`);
                if (direct) direct.classList.add('active');
                if (['banking-solution', 'capacity-building', 'banking-talent', 'lms', 'inovasi', 'csr', 'layanan', 'innovation-lab'].includes(id)) {
                    document.querySelector('.desktop-nav a[href="#layanan"]')?.classList.add('active');
                }
                if (id === 'talent-solutions') {
                    document.querySelector('.desktop-nav a[href="#talent-solutions"]')?.classList.add('active');
                }
                if (id === 'foundations') {
                    document.querySelector('.desktop-nav a[href="#foundations"]')?.classList.add('active');
                }
            });
        }, { rootMargin: '-35% 0px -55% 0px' });

        sections.forEach((section) => observer.observe(section));
    }
}());
