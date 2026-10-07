<?php

namespace App\Support;

class RoleMenu
{
    public static function forRole(int $role): array
    {
        if ($role !== 6) {
            return [];
        }

        return array_map(function (array $menu): array {
            $path = ltrim($menu['url'], '/');

            return $menu + [
                'active' => request()->is($path),
                'can_see' => true,
                'has_submenu' => false,
            ];
        }, self::studentMenus());
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
}
