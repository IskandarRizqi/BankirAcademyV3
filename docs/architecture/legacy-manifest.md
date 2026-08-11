# Legacy Manifest

Status: diperbarui setelah refactor tahap 2. File legacy tidak dihapus; dipindahkan ke `docs/legacy`.

| Item | Status | Bukti awal | Tindakan aman |
| --- | --- | --- | --- |
| `Front\\LayananController` | diarsipkan | tidak ditemukan pada route aktif maupun caller internal | dipindahkan ke `docs/legacy/mvc/controllers/Front` |
| `Front\\LokerController` | legacy/partial | resource `/loker-front` memiliki action CRUD yang tidak lengkap | review caller, nonaktifkan route yang mati, lalu arsipkan |
| `/tesapi` | dinonaktifkan | action `tesapi` tidak ditemukan dan tidak ada caller internal | route dikomentari di `routes/web/auth.php` |
| `/registerinstructor`, `/registerc`, `/detail-kelas` | dinonaktifkan | closure memanggil view `front.*` yang tidak tersedia | route dikomentari di `routes/web/transactions.php` |
| `/template` | dinonaktifkan | view `front.cvtemplate.cv` tidak tersedia | route dikomentari di `routes/web/public.php` |
| route `front.*` dengan view tidak tersedia | stale/broken candidate | source view `front` tidak ditemukan | jangan aktifkan kembali; arsipkan route/controller branch setelah audit |
| `compact.materi-umum` | kandidat stale view | tidak ditemukan reference controller aktif | pindahkan setelah `View::exists` dan grep reference bersih |
| `compact.detail-materi` | kandidat stale view | tidak ditemukan reference controller aktif | pindahkan setelah audit compiled/source caller |
| `PenarikanDana` | belum terverifikasi | tidak ditemukan reference kode aplikasi | cek migration, dump, dan data production sebelum arsip |
| `FeeModel` | diarsipkan | tidak ditemukan reference runtime setelah admin fee dilepas | dipindahkan ke `docs/legacy/mvc/models` |
| `BonusAplikasiModel` | diarsipkan | hanya dipakai controller bonus admin yang sudah tidak aktif | dipindahkan ke `docs/legacy/mvc/models` |

## Tahap 2: backend.template

Scope baru menetapkan `layouts.compact` sebagai layout halaman aplikasi aktif. Seluruh view yang memakai `backend.template` dipindahkan ke `docs/legacy/views` setelah route dan controller runtime-nya dinonaktifkan.

Route admin yang dipertahankan karena digunakan oleh menu compact:

- `/admin/classes*`
- `/admin/instructor` dan operasi instruktur
- `/admin/pembayaran*`
- `/admin/order-kelas-manual*`
- `/admin/loker*`
- `/admin/perusahaan*`
- `/admin/sop*`

Route admin legacy yang dinonaktifkan:

- `/admin/prepotes*`
- `/admin/banner*`
- `/admin/partner*`
- `/admin/peserta*`
- `/admin/kupon*`
- `/admin/fee*`
- `/admin/corporate*` CRUD
- `/admin/pages*`
- `/admin/laman*`
- `/admin/user*` legacy
- `/admin/ipakses*`
- `/admin/bonus-aplikasi*`
- `/admin/member*` legacy
- `/admin/withdraw*` admin
- `/admin/referral*` dan `/admin/master/*`

Controller yang masih dibutuhkan oleh route aktif dipangkas ke method non-view yang relevan:

- `Backend\\CorporateController`: lookup corporate pada transaksi
- `Backend\\MembershipController`: invoice pending member
- `Backend\\WithdrawController`: proses withdraw compact
- `Backend\\PrepotestController`: penyimpanan jawaban siswa
- `Backend\\RefferalController`: referral public/transaction

Controller yang hanya melayani backend.template dipindahkan ke `docs/legacy/mvc/controllers`.

Wrapper admin yang sudah digunakan route bukan legacy orphan dan harus dipertahankan selama migrasi:

- `Admin\\PaymentController`
- `Admin\\InstructorController`
- `Admin\\CompanyController`
- `Admin\\LokerController`
- `Admin\\LokerApplicationController`
