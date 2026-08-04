<section class="section" id="faq">
    <div class="container">
        @include('frontend.components.section-head', [
            'eyebrow' => 'Pusat Bantuan',
            'title' => 'Pertanyaan yang Sering Diajukan',
            'description' => 'Informasi awal mengenai program, peserta, sertifikat, kerja sama, dan akses pembelajaran.',
        ])

        @include('frontend.components.faq-list', [
            'items' => [
                [
                    'question' => 'Siapa yang dapat mengikuti program Bankir Academy?',
                    'answer' => 'Program dapat diikuti oleh pelajar, mahasiswa, fresh graduate, calon bankir, pegawai bank, pimpinan, HR, UMKM, dan institusi sesuai sasaran serta prasyarat masing-masing program.',
                    'open' => true,
                ],
                [
                    'question' => 'Apakah program dapat disesuaikan untuk institusi?',
                    'answer' => 'Ya. Topik, metode, durasi, jumlah peserta, evaluasi, dan deliverables dapat disusun berdasarkan kebutuhan serta ruang lingkup yang disepakati.',
                ],
                [
                    'question' => 'Apakah setiap program mendapatkan sertifikat?',
                    'answer' => 'Penerbitan sertifikat mengikuti ketentuan masing-masing program, seperti kehadiran, penyelesaian materi, asesmen, tugas, dan persyaratan administrasi.',
                ],
                [
                    'question' => 'Apakah Bankir Academy menjamin peserta diterima bekerja?',
                    'answer' => 'Tidak. Program pembelajaran dan Job Connect membantu meningkatkan kesiapan serta akses informasi, tetapi proses seleksi dan keputusan penerimaan sepenuhnya berada pada institusi pemberi kerja.',
                ],
                [
                    'question' => 'Bagaimana cara mengajukan program CSR pendidikan?',
                    'answer' => 'Mitra dapat menyampaikan sasaran peserta, wilayah, tema, jumlah peserta, jadwal, dan hasil yang diharapkan. Tim akan menyusun konsep program dan mekanisme evaluasinya.',
                ],
                [
                    'question' => 'Apakah materi regulasi selalu diperbarui?',
                    'answer' => 'Materi ditinjau secara berkala. Namun, peserta dan institusi tetap perlu memeriksa peraturan, surat edaran, serta sumber resmi terbaru sebelum mengambil keputusan atau menerapkan kebijakan.',
                ],
            ],
        ])
    </div>
</section>
