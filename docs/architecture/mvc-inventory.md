# MVC Inventory

## Canonical Boundary

| Boundary | Controller | View | Model/service |
| --- | --- | --- | --- |
| Admin compact | `App\Http\Controllers\Admin` dan controller domain admin | `resources/views/compact` serta halaman backend yang sudah memakai compact | model domain terkait |
| Student compact | `Beasiswa\SiswaMateriController`, `LamaranController`, dan controller sertifikat | `resources/views/compact` | learning, progress, certificate |
| Website publik | `Front` dan `frontend` controllers | `resources/views/frontend` | catalog, CMS, public order |
| Member non-anggota | `MemberNonAnggota` | `resources/views/membernonkeanggotaan` | ebook, video, billing, loker |
| API/integration | `API` dan webhook controllers | JSON/PDF/response, tanpa Blade halaman | payment, recent registration, catalog |

## Aturan Controller

- Route baru harus menunjuk namespace boundary yang sesuai.
- Wrapper pada namespace `Admin` dipertahankan sampai implementasi legacy tidak lagi dipakai.
- Controller legacy tidak dipindahkan hanya berdasarkan nama; pemindahan harus didahului audit referensi.

## Aturan Model

- Model tidak dipindahkan atau di-rename massal tanpa memastikan `$table`, relasi, casts, observer, job, dan polymorphic type.
- Model dengan nama mirip dicatat sebagai domain berbeda sampai schema membuktikan sebaliknya.

## Aturan View

- Halaman dashboard/admin/student utama menggunakan `layouts.compact`.
- View publik dan member non-anggota tetap memakai layout masing-masing.
- View PDF, redirect payment, email, dan partial bukan halaman compact dan tidak boleh dipindahkan hanya karena berada di folder `compact`.
