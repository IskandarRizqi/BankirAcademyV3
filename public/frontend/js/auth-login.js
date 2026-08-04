document.addEventListener('DOMContentLoaded', () => {
    const password = document.getElementById('password');
    const toggle = document.querySelector('.password-toggle');

    if (!password || !toggle) return;

    toggle.addEventListener('click', () => {
        const visible = password.type === 'password';
        password.type = visible ? 'text' : 'password';
        toggle.textContent = visible ? 'Sembunyikan' : 'Lihat';
        toggle.setAttribute('aria-pressed', String(visible));
        toggle.setAttribute('aria-label', visible ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');
    });
});
