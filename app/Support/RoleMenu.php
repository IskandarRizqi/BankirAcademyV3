<?php

namespace App\Support;

use App\Models\DataPayment;
use App\Models\User;

class RoleMenu
{
    public static function forRole(int $role): array
    {
        return self::decorate(match ($role) {
            4 => self::bankMenus(),
            5 => self::schoolMenus(),
            6 => self::studentMenus(),
            default => [],
        });
    }

    public static function forUser(User $user): array
    {
        $role = (int) $user->role;
        if (in_array($role, [4, 5, 6], true)) {
            return self::forRole($role);
        }

        if ($role !== 2) {
            return [];
        }

        $membershipType = (int) $user->userProfile?->tipe_membership;
        $menus = array_merge(self::memberMenus(), match ($membershipType) {
            DataPayment::MEMBERSHIP_TYPE_INDIVIDUAL => self::individualMenus(),
            DataPayment::MEMBERSHIP_TYPE_COMPANY => self::companyMenus(),
            default => [],
        });

        return self::decorate($menus);
    }

    private static function decorate(array $menus): array
    {
        return array_map(function (array $menu): array {
            $path = ltrim($menu['url'], '/');

            return $menu + [
                'active' => request()->is($path),
                'can_see' => true,
                'has_submenu' => false,
            ];
        }, $menus);
    }

    private static function memberMenus(): array
    {
        return [
            ['key' => 'member_dashboard', 'label' => 'Dashboard', 'icon' => 'dashboard', 'url' => '/dash-beranda', 'section' => 'Beranda', 'order' => 1],
            ['key' => 'event', 'label' => 'Event', 'icon' => 'event', 'url' => '/event-kelas', 'section' => 'Eksplorasi', 'order' => 2],
            ['key' => 'membership_profile', 'label' => 'Update Profile', 'icon' => 'profile', 'url' => '/member/profile/membership', 'section' => 'Akun', 'order' => 3],
            ['key' => 'ebook', 'label' => 'Ebook', 'icon' => 'ebook', 'url' => '/ebook', 'section' => 'Eksplorasi', 'order' => 4],
            ['key' => 'video', 'label' => 'Video', 'icon' => 'video', 'url' => '/video', 'section' => 'Eksplorasi', 'order' => 5],
            ['key' => 'billing', 'label' => 'Pembelian', 'icon' => 'billing', 'url' => '/pembayaran', 'section' => 'Transaksi', 'order' => 6],
            ['key' => 'classes', 'label' => 'Pembelajaran Anda', 'icon' => 'kelas', 'url' => '/kelas-event', 'section' => 'Pembelajaran', 'order' => 7],
            ['key' => 'certificates', 'label' => 'Sertifikat', 'icon' => 'sertifikat', 'url' => '/sertifikat-kelas', 'section' => 'Pembelajaran', 'order' => 8],
            ['key' => 'jobs', 'label' => 'Loker', 'icon' => 'loker', 'url' => '/member/loker', 'section' => 'Karier', 'order' => 9],
        ];
    }

    private static function individualMenus(): array
    {
        return [
            ['key' => 'cv_ats', 'label' => 'Buat CV ATS', 'icon' => 'cv', 'url' => '/member/cv-ats', 'section' => 'Karier', 'order' => 10],
            ['key' => 'job_history', 'label' => 'Riwayat Lamaran', 'icon' => 'riwayat', 'url' => '/member/loker/riwayat', 'section' => 'Karier', 'order' => 11],
            ['key' => 'consultation', 'label' => 'Konsultasi', 'icon' => 'konsultasi', 'url' => '/comingsoon', 'section' => 'Fitur Membership', 'order' => 12],
            ['key' => 'community', 'label' => 'Komunitas', 'icon' => 'komunitas', 'url' => '/comingsoon', 'section' => 'Fitur Membership', 'order' => 13],
            ['key' => 'affiliate', 'label' => 'Program Afiliasi', 'icon' => 'afiliasi', 'url' => '/comingsoon', 'section' => 'Fitur Membership', 'order' => 14],
            ['key' => 'member_point', 'label' => 'Member Point', 'icon' => 'point', 'url' => '/comingsoon', 'section' => 'Fitur Membership', 'order' => 15],
        ];
    }

    private static function companyMenus(): array
    {
        return [
            ['key' => 'sop', 'label' => 'SOP', 'icon' => 'sop', 'url' => '/member/sop', 'section' => 'Fitur Membership', 'order' => 10],
            ['key' => 'bonus_application', 'label' => 'Bonus Aplikasi', 'icon' => 'aplikasi', 'url' => '/member/bonus-aplikasi', 'section' => 'Fitur Membership', 'order' => 11],
            ['key' => 'company_profile', 'label' => 'Profil Perusahaan', 'icon' => 'profile', 'url' => '/member/pasang-loker/perusahaan', 'section' => 'Fitur Membership', 'order' => 12],
            ['key' => 'company_jobs', 'label' => 'Pasang Loker', 'icon' => 'loker', 'url' => '/member/pasang-loker/posting', 'section' => 'Fitur Membership', 'order' => 13],
            ['key' => 'incubation', 'label' => 'Program Inkubasi UMKM', 'icon' => 'inkubasi', 'url' => '/comingsoon', 'section' => 'Fitur Membership', 'order' => 14],
            ['key' => 'consultation', 'label' => 'Konsultasi', 'icon' => 'konsultasi', 'url' => '/comingsoon', 'section' => 'Fitur Membership', 'order' => 15],
            ['key' => 'community_affiliate', 'label' => 'Komunitas & Program Afiliasi', 'icon' => 'komunitas', 'url' => '/comingsoon', 'section' => 'Fitur Membership', 'order' => 16],
        ];
    }

    private static function studentMenus(): array
    {
        return [
            [
                'key' => 'dashboard',
                'label' => 'Dashboard',
                'icon' => 'dashboard',
                'url' => '/home',
                'section' => 'Beranda',
                'order' => 1,
            ],
            [
                'key' => 'competencies',
                'label' => 'Kompetensi',
                'icon' => 'graduate',
                'url' => '/pelatihan',
                'section' => 'Pembelajaran Peserta',
                'order' => 2,
            ],
            [
                'key' => 'general_training',
                'label' => 'Pelatihan Umum',
                'icon' => 'teacher',
                'url' => '/materi-umum',
                'section' => 'Pembelajaran Peserta',
                'order' => 3,
            ],
            [
                'key' => 'training_history',
                'label' => 'History Pelatihan',
                'icon' => 'history',
                'url' => '/materi-umum/history',
                'section' => 'Pembelajaran Peserta',
                'order' => 4,
            ],
            [
                'key' => 'jobs',
                'label' => 'Lowongan Kerja',
                'icon' => 'bar-chart-2',
                'url' => '/lowongan',
                'section' => 'Karier Peserta',
                'order' => 5,
            ],
            [
                'key' => 'cv_ats',
                'label' => 'Buat CV ATS',
                'icon' => 'zap',
                'url' => '/cvats',
                'section' => 'Karier Peserta',
                'order' => 6,
            ],
            [
                'key' => 'certificates',
                'label' => 'Sertifikat',
                'icon' => 'sertificate',
                'url' => '/sertifikat',
                'section' => 'Pembelajaran Peserta',
                'order' => 7,
            ],
        ];
    }

    private static function bankMenus(): array
    {
        return [
            ['key' => 'organization_dashboard', 'label' => 'Dashboard', 'icon' => 'dashboard', 'url' => '/organization/dashboard', 'section' => 'Beranda', 'order' => 1],
            ['key' => 'organization_users', 'label' => 'Sekolah & Peserta', 'icon' => 'users', 'url' => '/organization/users', 'section' => 'Manajemen', 'order' => 2],
            ['key' => 'organization_monitoring', 'label' => 'Monitoring Peserta', 'icon' => 'bar-chart-2', 'url' => '/organization/monitoring', 'section' => 'Manajemen', 'order' => 3],
            ['key' => 'organization_scholarships', 'label' => 'Approval Beasiswa', 'icon' => 'approval', 'url' => '/organization/scholarships', 'section' => 'Manajemen', 'order' => 4],
        ];
    }

    private static function schoolMenus(): array
    {
        return [
            ['key' => 'organization_dashboard', 'label' => 'Dashboard', 'icon' => 'dashboard', 'url' => '/organization/dashboard', 'section' => 'Beranda', 'order' => 1],
            ['key' => 'organization_users', 'label' => 'Peserta', 'icon' => 'users', 'url' => '/organization/users', 'section' => 'Manajemen', 'order' => 2],
            ['key' => 'organization_monitoring', 'label' => 'Monitoring Peserta', 'icon' => 'bar-chart-2', 'url' => '/organization/monitoring', 'section' => 'Manajemen', 'order' => 3],
        ];
    }
}
