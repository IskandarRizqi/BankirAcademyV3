# Dokumentasi Sebelum Refactor

Tanggal baseline: 2026-08-11

## Kondisi Worktree

Worktree sudah memiliki perubahan lokal sebelum refactor ini dimulai. Perubahan tersebut tidak di-reset atau dibatalkan. Refactor hanya boleh menambahkan perubahan yang diperlukan dan harus menghindari konflik dengan perubahan lokal tersebut.

## Route Yang Dimuat

`RouteServiceProvider` memuat empat sumber route:

| Sumber | Middleware/prefix | Peran |
| --- | --- | --- |
| `routes/api.php` | `api`, prefix `/api` | API, callback payment, webhook |
| `routes/web.php` | `web` | dashboard, admin, auth, transaksi, siswa |
| `routes/frontend.php` | `web` | website publik, katalog, loker publik |
| `routes/membernonanggota.php` | `web` | member non-anggota |

Akibatnya route browser tersebar di tiga file web dan urutan pemuatan route ikut menentukan hasil resolusi route yang tumpang tindih.

## Layout Aktif

- Dashboard/admin/member utama: `layouts.compact`
- Website publik: `layouts.appfrontend`
- Member non-anggota: `layouts.appmembernonanggota`
- Authentication: `layouts.applogin` dan `layouts.app`
- Legacy backend: `backend.template`

Terdapat 42 source Blade yang langsung menggunakan `@extends('layouts.compact')`. View compact tetap menjadi scope utama refactor dashboard/admin, sedangkan frontend publik dan member non-anggota tetap dipertahankan sebagai boundary fitur terpisah.

## Struktur Controller

Controller aktif masih tersebar pada namespace `Admin`, `Backend`, `Front`, `Loker`, `Beasiswa`, `MemberNonAnggota`, `API`, dan root controller. Beberapa controller `Admin` baru merupakan wrapper dari controller legacy, misalnya:

- `Admin\PaymentController` -> `Backend\PembayaranController`
- `Admin\InstructorController` -> `Backend\InstructorController`
- `Admin\CompanyController` -> `Loker\PerusahaanController`
- `Admin\LokerController` -> `Loker\BerandaLoker`
- `Admin\LokerApplicationController` -> `Backend\LokerApplyController`

Wrapper tersebut dianggap aktif dan tidak boleh diarsipkan sebelum seluruh route dan caller bermigrasi.

## Struktur Model

Model masih menggunakan pola penamaan lama seperti `ClassesModel`, `MembershipModel`, `PreposttestModel`, dan `PrepotesModel`. Beberapa pasangan model memiliki tabel atau domain berbeda, sehingga rename massal berisiko terhadap relasi, table inference, polymorphic type, dan queued job.

## Kandidat Legacy Awal

Kandidat berikut belum langsung dihapus; statusnya harus divalidasi melalui route, view, job, command, dan database:

- `Front\LayananController` tidak memiliki referensi route yang ditemukan.
- `Front\LokerController` hanya terhubung ke resource route dengan method CRUD yang tidak lengkap.
- `/tesapi` menunjuk ke action `tesapi` yang tidak ditemukan.
- Beberapa route closure masih memanggil view `front.*` yang tidak ada pada source view saat ini.
- `compact.materi-umum` dan `compact.detail-materi` tidak memiliki referensi controller aktif yang ditemukan.
- `PenarikanDana` belum memiliki referensi kode aplikasi yang ditemukan; perlu validasi migration/database sebelum dipindahkan.

## Aturan Baseline

Tahap pertama refactor tidak mengubah URL, route name, response, middleware permission, database schema, atau layout publik/member non-anggota. Setiap perubahan struktur harus dapat dibandingkan dengan baseline route list.
