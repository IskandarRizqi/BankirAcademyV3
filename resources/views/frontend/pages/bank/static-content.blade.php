@php
    $bankSource = config('bank-pages.sources.' . $bankPage);
    $bankPath = $bankSource ? public_path('bank/' . $bankSource) : null;
    $bankMarkup = is_string($bankPath) && is_file($bankPath) ? file_get_contents($bankPath) : '';
    preg_match('/<main\b[^>]*>(.*?)<\/main>/is', $bankMarkup, $bankMatches);
    $bankContent = $bankMatches[1] ?? '';

    $bankLinks = [
        'index.html#beranda' => route('frontend.home') . '#beranda',
        'index.html#layanan' => route('frontend.home') . '#layanan',
        'index.html#talent-solutions' => route('frontend.home') . '#talent-solutions',
        'index.html#foundations' => route('frontend.home') . '#foundations',
        'index.html#kelas-online' => route('frontend.home') . '#kelas-online',
        'index.html' => route('frontend.home'),
        'kelas-online.html' => route('frontend.classes.index'),
        'kurikulum.html' => route('frontend.curriculum'),
        'login.html' => route('login.new'),
        'banking-solution.html' => route('frontend.service.banking-solution'),
        'capacity-building.html' => route('frontend.service.capacity-building'),
        'banking-talent-solution.html' => route('frontend.service.banking-talent'),
        'learning-management-system.html' => route('frontend.service.lms'),
        'inovasi-program.html' => route('frontend.service.innovation'),
        'program-csr.html' => route('frontend.service.csr'),
        'headhunting.html' => route('frontend.talent.headhunting'),
        'outsourcing.html' => route('frontend.talent.outsourcing'),
        'job-connect.html' => route('frontend.talent.job-connect'),
        'bakti-pendidikan.html' => route('frontend.foundation.education'),
        'bakti-umkm.html' => route('frontend.foundation.umkm'),
        'tanya-jawab.html' => route('frontend.support.faq'),
        'syarat-dan-ketentuan.html' => route('frontend.support.terms'),
        'kebijakan-privasi.html' => route('frontend.support.privacy'),
        'kontak-kami.html' => route('frontend.support.contact'),
    ];

    foreach (glob(public_path('bank/kelas-*.html')) ?: [] as $classPath) {
        $classFile = basename($classPath);
        $classSlug = pathinfo($classFile, PATHINFO_FILENAME);
        $bankLinks[$classFile] = route('frontend.class.static', ['slug' => $classSlug]);
    }

    foreach ($bankLinks as $bankLink => $bankUrl) {
        $bankContent = str_replace(
            ['href="' . $bankLink . '"', "href='" . $bankLink . "'"],
            ['href="' . e($bankUrl) . '"', "href='" . e($bankUrl) . "'"],
            $bankContent
        );
    }
@endphp

{!! $bankContent !!}
