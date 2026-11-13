<section class="cv-ats-cta" aria-labelledby="cv-ats-cta-title">
    <div class="cv-ats-cta__icon" aria-hidden="true">
        <i class="fas fa-file-alt"></i>
    </div>
    <div class="cv-ats-cta__content">
        <span class="cv-ats-cta__eyebrow">Layanan gratis Bankir Academy</span>
        <h2 id="cv-ats-cta-title">Buat CV ATS gratis</h2>
        <p>Susun CV yang rapi dan mudah dibaca sistem rekrutmen untuk meningkatkan peluang Anda dilirik perusahaan.</p>
        @auth
            <a class="cv-ats-cta__button" href="{{ route('cvats.index') }}">
                <i class="fas fa-arrow-right" aria-hidden="true"></i>
                Buat CV ATS sekarang
            </a>
        @else
            <a class="cv-ats-cta__button" href="{{ route('login.new', ['redirect' => '/cvats']) }}">
                <i class="fas fa-sign-in-alt" aria-hidden="true"></i>
                Login untuk mulai
            </a>
        @endauth
    </div>
</section>

<style>
    .cv-ats-cta {
        position: relative;
        display: flex;
        gap: 16px;
        overflow: hidden;
        margin: 30px 0;
        padding: 23px;
        border: 1px solid #d9d6ff;
        border-radius: 16px;
        background: linear-gradient(135deg, #f1f0ff 0%, #f8fbff 100%);
    }

    .cv-ats-cta::after {
        position: absolute;
        top: -45px;
        right: -28px;
        width: 130px;
        height: 130px;
        border-radius: 50%;
        background: rgba(99, 102, 241, .11);
        content: '';
    }

    .cv-ats-cta__icon {
        position: relative;
        z-index: 1;
        display: inline-flex;
        width: 42px;
        height: 42px;
        flex: 0 0 42px;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: #5148c5;
        color: #fff;
        font-size: 17px;
    }

    .cv-ats-cta__content {
        position: relative;
        z-index: 1;
    }

    .cv-ats-cta__eyebrow {
        display: block;
        margin-bottom: 5px;
        color: #5d56d9;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .1em;
        text-transform: uppercase;
    }

    .cv-ats-cta h2 {
        margin: 0 0 7px;
        color: #202d48;
        font-size: 20px;
        line-height: 1.25;
    }

    .cv-ats-cta p {
        margin: 0 0 15px;
        color: #5e6980;
        font-size: 13px;
        line-height: 1.6;
    }

    .cv-ats-cta__button {
        display: inline-flex;
        min-height: 38px;
        align-items: center;
        gap: 7px;
        padding: 8px 13px;
        border-radius: 9px;
        background: #5148c5;
        color: #fff;
        font-size: 12px;
        font-weight: 800;
        text-decoration: none;
    }

    .cv-ats-cta__button:hover,
    .cv-ats-cta__button:focus-visible {
        background: #4038a5;
        color: #fff;
        text-decoration: none;
    }

    .loker-detail-side .cv-ats-cta {
        margin: 0;
    }

    @media (max-width: 575.98px) {
        .cv-ats-cta {
            padding: 19px;
        }
    }
</style>
