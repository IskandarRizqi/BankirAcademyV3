# Bankir Academy V3

Dokumentasi teknis alur order dan pembayaran menggunakan DOKU.

## Daftar Isi

- [Arsitektur Singkat](#arsitektur-singkat)
- [Status dan Tipe Pembayaran](#status-dan-tipe-pembayaran)
- [Komponen Utama](#komponen-utama)
- [Flow Umum Pembayaran](#flow-umum-pembayaran)
- [Flow Membership](#flow-membership)
- [Flow Kelas Berbayar](#flow-kelas-berbayar)
- [Flow Kelas Gratis](#flow-kelas-gratis)
- [Flow Ebook dan Video](#flow-ebook-dan-video)
- [Flow Ebook dan Video Gratis](#flow-ebook-dan-video-gratis)
- [Webhook DOKU](#webhook-doku)
- [Callback Browser dan SweetAlert](#callback-browser-dan-sweetalert)
- [Expiry dan Pembatalan](#expiry-dan-pembatalan)
- [Menambahkan Jenis Order Baru](#menambahkan-jenis-order-baru)
- [Checklist Testing](#checklist-testing)
- [Catatan Teknis](#catatan-teknis)

## Arsitektur Singkat

Sistem pembayaran menggunakan dua jalur yang berbeda tetapi terhubung melalui nomor invoice:

```text
User
  |
  v
Order endpoint di PaymentController
  |
  v
DataPayment.status = PENDING
  |
  v
Buat checkout DOKU
  |
  v
User membayar di halaman DOKU
  |
  +--> Browser callback ke /pembayaran?invoice_number=...
  |
  +--> Webhook DOKU ke /api/c4/notifikasi
          |
          v
     CheckoutController
          |
          v
     Validasi invoice, signature, nominal, dan status
          |
          v
     Fulfillment akses sesuai tipe order
```

Webhook adalah sumber kebenaran untuk menganggap pembayaran berhasil. Browser callback hanya digunakan untuk mengembalikan user ke halaman aplikasi dan menampilkan status terbaru dari database.

## Status dan Tipe Pembayaran

Konstanta berada di `app/Models/DataPayment.php`.

### Status internal `DataPayment`

| Konstanta | Nilai | Arti |
|---|---:|---|
| `STATUS_PAID` | `1` | Pembayaran berhasil |
| `STATUS_PENDING` | `2` | Menunggu pembayaran atau konfirmasi |
| `STATUS_CANCELED` | `99` | Gagal, expired, atau dibatalkan |

### Tipe pembelian

| Konstanta | Nilai | Arti |
|---|---:|---|
| `PURCHASE_TYPE_MEMBERSHIP` | `1` | Membership |
| `PURCHASE_TYPE_CLASS` | `2` | Kelas atau materi kelas |
| `PURCHASE_TYPE_EBOOK` | `3` | Ebook |
| `PURCHASE_TYPE_VIDEO` | `4` | Video |

### Tipe membership

| Konstanta | Nilai | Arti | Harga |
|---|---:|---|---:|
| `MEMBERSHIP_TYPE_COMPANY` | `1` | Membership perusahaan | Rp3.000.000 |
| `MEMBERSHIP_TYPE_INDIVIDUAL` | `2` | Membership perorangan | Rp99.000 |

### Status DOKU

Status DOKU yang dianggap berhasil oleh `CheckoutController`:

```text
SUCCESS, PAID, SETTLEMENT, CAPTURE, COMPLETED
```

Status DOKU yang dianggap gagal:

```text
FAILED, CANCEL, CANCELED, CANCELLED, EXPIRED, DENIED
```

## Komponen Utama

| Komponen | File | Tanggung jawab |
|---|---|---|
| Pembuatan order | `app/Http/Controllers/PaymentController.php` | Validasi order, membuat `DataPayment`, membuat checkout DOKU |
| Webhook dan fulfillment | `app/Http/Controllers/CheckoutController.php` | Validasi notifikasi DOKU dan mengaktifkan akses |
| Histori pembayaran | `app/Http/Controllers/MemberNonAnggota/BillingController.php` | Menampilkan billing, callback browser, dan filter histori |
| Expiry pembayaran | `app/Services/PaymentExpiryService.php` | Membatalkan payment pending yang sudah expired |
| Ledger pembayaran | `app/Models/DataPayment.php` | Menyimpan identitas dan status semua payment |
| Order kelas | `app/Models/ClassPaymentModel.php` | Menyimpan detail order kelas |
| Profil membership | `app/Models/UserProfileModel.php` | Menyimpan status, masa aktif, tanggal bergabung, dan tipe membership |

## Flow Umum Pembayaran

### 1. User mengirim order

Request masuk ke method pada `PaymentController` melalui route yang membutuhkan autentikasi.

Validasi minimal:

- User harus login.
- ID resource harus valid.
- Harga harus dihitung dari sumber data server jika memungkinkan.
- Jangan menjadikan hidden input `nominal` sebagai sumber harga yang dipercaya.

### 2. Simpan order pending

Order disimpan pada tabel `datapayment` dengan informasi utama:

```text
no_invoice
user_id
pembelian
nominal
qty
status
keterangan
tipe_pembelian
link_payment
```

Untuk order yang membutuhkan resource khusus, simpan foreign key-nya:

```text
class_id
materi_id
submateri_id
tipe_membership
```

Pembuatan data yang saling terkait harus berada dalam `DB::transaction()`.

### 3. Buat checkout DOKU

Request dikirim ke:

```text
{DOKU_URL}/checkout/v1/payment
```

Request berisi:

- `order.amount`
- `order.invoice_number`
- `order.callback_url`
- `order.line_items`
- data customer
- `payment.payment_due_date`
- `additional_info`

Request ditandatangani menggunakan digest SHA-256 dan HMAC-SHA256.

Jika DOKU mengembalikan payment URL:

1. Simpan URL ke `datapayment.link_payment`.
2. Redirect user ke URL DOKU.

Jika DOKU gagal mengembalikan URL:

1. Ubah status payment menjadi `STATUS_CANCELED`.
2. Kembali ke halaman sebelumnya dengan flash `error`.

### 4. User membayar di DOKU

DOKU memproses pembayaran dan melakukan dua hal:

- Mengarahkan browser user ke `callback_url`.
- Mengirim server-to-server notification ke webhook.

Kedua proses tersebut dapat terjadi dalam urutan berbeda. Karena itu, callback browser tidak boleh langsung mengaktifkan akses.

### 5. Webhook memproses pembayaran

Webhook mencari `DataPayment` berdasarkan `no_invoice`, mengunci baris payment, memvalidasi data, lalu menjalankan processor sesuai `tipe_pembelian`.

Semua update payment dan aktivasi akses harus dilakukan dalam transaksi database dan bersifat idempotent.

## Flow Membership

### Route dan file terkait

```text
POST /payment-membership
PaymentController::paymentmembership()
```

Webhook membership diproses melalui:

```text
POST /api/c4/notifikasi
CheckoutController::handleDokuTransactionNotification()
```

### Pembuatan order

User memilih salah satu tipe:

- Perusahaan: `membership_tipe = 1`, harga server-side Rp3.000.000.
- Perorangan: `membership_tipe = 2`, harga server-side Rp99.000.

Controller tidak mempercayai nominal dari form. Harga ditentukan melalui konfigurasi server berdasarkan `membership_tipe`.

`DataPayment` menyimpan:

```text
pembelian = membership
tipe_pembelian = 1
tipe_membership = 1 atau 2
nominal = harga membership
status = 2
expired = 60 menit
```

Setelah payment URL berhasil dibuat, `user_profile.status_membership` menjadi `2` atau pending.

### Saat webhook sukses

`CheckoutController::processMembershipPayment()` melakukan:

1. Lock payment dengan `lockForUpdate()`.
2. Validasi tipe pembelian.
3. Validasi nominal DOKU dengan `datapayment.nominal`.
4. Hentikan proses jika payment sudah paid agar webhook duplikat aman.
5. Lock profile user.
6. Hitung masa aktif baru.
7. Update:

```text
status_membership = 1
masa_aktif_membership = satu tahun dari masa aktif sebelumnya atau tanggal sekarang
tipe_membership = tipe payment
tanggal_bergabung_membership = diisi jika masih kosong
```

8. Update `datapayment.status = 1`.

### Pesan user

- Pending: order membership berhasil dibuat dan pembayaran sedang diverifikasi.
- Sukses: pembayaran membership berhasil dan masa aktif diperbarui.
- Gagal: pembayaran membership gagal atau dibatalkan.

## Flow Kelas Berbayar

### Route dan file terkait

```text
POST /payment-order-class
PaymentController::paymentorderclass()
```

### Validasi dan kalkulasi

Controller memvalidasi:

- `class_id`
- jumlah peserta
- data nama, email, dan nomor handphone setiap peserta
- pilihan sertifikat
- kuota kelas
- harga kelas dari `ClassPricingModel`

Total dihitung dari:

```text
total kelas = harga efektif per peserta x jumlah peserta
total sertifikat = biaya sertifikat x jumlah peserta
grand total = total kelas + total sertifikat
```

Harga kelas dan kuota harus ditentukan dari database. Request client hanya digunakan sebagai input pilihan, bukan sumber kebenaran harga.

### Data yang dibuat

Dalam satu transaksi dibuat atau diperbarui:

1. `ClassPaymentModel` untuk detail order kelas.
2. `DataPayment` sebagai ledger pembayaran.
3. `ClassParticipantModel` sebagai data peserta.
4. `SertifikatPesertaModel` jika data sertifikat diperlukan.

Invoice yang sama disimpan pada `ClassPaymentModel` dan `DataPayment`.

### Jika total lebih dari nol

1. Buat checkout DOKU melalui `createClassDokuPaymentUrl()`.
2. Simpan payment URL.
3. Redirect user ke DOKU.
4. Tunggu webhook.
5. `processClassPayment()` memvalidasi nominal dan status.
6. Buat atau update peserta kelas.
7. Update:

```text
class_payment.status = 1
```

### Pesan user

Jika payment masih pending:

```text
Pesanan kelas "<Nama Kelas>" berhasil dibuat. Silakan selesaikan pembayaran untuk mengaktifkan akses ke kelas.
```

Jika sukses:

```text
Pembayaran untuk kelas "<Nama Kelas>" berhasil dikonfirmasi. Akses Anda ke kelas telah diaktifkan. Silakan buka menu Pembelajaran Saya Anda untuk mulai belajar.
```

## Flow Kelas Gratis

Kelas dianggap gratis jika harga kelas dan biaya tambahan yang dipilih menghasilkan total `0`.

### Kelas gratis tanpa sertifikat berbayar

Flow saat ini:

1. Validasi kelas dan kuota.
2. Hitung `grand_total = 0`.
3. Buat `ClassPaymentModel` dengan status paid.
4. Buat `DataPayment` dengan status `STATUS_PAID`.
5. Buat data peserta.
6. Buat data sertifikat jika diperlukan.
7. Tidak memanggil DOKU.
8. Redirect ke `/pembayaran?invoice_number=...`.
9. `BillingController` membaca payment paid dan menampilkan flash sukses.

Pesan yang digunakan sama dengan pesan pembayaran sukses kelas berbayar:

```text
Pembayaran untuk kelas "<Nama Kelas>" berhasil dikonfirmasi. Akses Anda ke kelas telah diaktifkan. Silakan buka menu Pembelajaran Saya Anda untuk mulai belajar.
```

### Kelas gratis dengan sertifikat berbayar

Jika kelas gratis tetapi sertifikat memiliki biaya:

1. Harga kelas tetap `0`.
2. Biaya sertifikat dihitung.
3. Jika total sertifikat lebih dari `0`, DOKU tetap digunakan.
4. Akses final menunggu webhook sukses.
5. Setelah webhook sukses, peserta dan status payment diaktifkan.

### Catatan implementasi gratis

Jangan membuat URL DOKU untuk total `0`. Tetapkan status paid hanya setelah seluruh data akses lokal berhasil dibuat dalam transaksi.

## Flow Ebook dan Video

### Route

Ebook:

```text
POST /payment/order-ebook
PaymentController::paymentorderebook()
```

Video:

```text
POST /payment/order-video
PaymentController::paymentordervideo()
```

### Pembuatan order

Ebook dan video menyimpan resource pada `submateri_id`.

Ebook:

```text
pembelian = ebook
submateri_id = ID ebook
status = 2
```

Video:

```text
pembelian = video
submateri_id = ID video
status = 2
```

Keduanya menggunakan helper `createClassDokuPaymentUrl()` untuk membuat checkout DOKU dan membawa invoice pada browser callback.

### Saat webhook sukses

`CheckoutController::processEbookPayment()` digunakan untuk ebook dan video.

Prosesnya:

1. Cari `DataPayment` berdasarkan invoice.
2. Validasi tipe melalui dispatcher webhook.
3. Update status payment menjadi paid.
4. Insert akses ke `history_pelatihan`.
5. Catat transaksi pada `RiwayatTransaksi`.

### Pesan pending ebook

```text
Pesanan ebook "<Nama Ebook>" berhasil dibuat. Silakan selesaikan pembayaran untuk mengaktifkan akses ke ebook.
```

### Pesan pending video

```text
Pesanan video "<Nama Video>" berhasil dibuat. Silakan selesaikan pembayaran untuk mengaktifkan akses ke video.
```

### Pesan sukses ebook

```text
Pembayaran untuk Ebook "<Nama Ebook>" berhasil dikonfirmasi. Akses Anda ke Ebook telah diaktifkan. Silakan buka menu Pembelajaran Saya untuk mulai belajar.
```

### Pesan sukses video

```text
Pembayaran untuk Video "<Nama Video>" berhasil dikonfirmasi. Akses Anda ke video telah diaktifkan. Silakan buka menu Pembelajaran Saya untuk mulai belajar.
```

Nama item diambil melalui relasi `DataPayment::subMateri()`.

## Flow Ebook dan Video Gratis

Ebook dan video gratis belum termasuk dalam flow order gratis yang didukung.

Kondisi saat ini:

- Akses langsung untuk konten gratis dapat diberikan oleh controller pembelajaran.
- Jika form order ebook/video tetap dikirim dengan nominal `0`, flow checkout DOKU tidak digunakan.
- Pengembangan order gratis ebook/video harus dibuat sebagai fitur terpisah.

Sebelum mengaktifkan flow tersebut, tentukan lebih dahulu:

1. Apakah perlu membuat baris `DataPayment` paid atau tidak.
2. Apakah akses dibuat melalui `history_pelatihan`.
3. Apakah perlu mencatat `RiwayatTransaksi`.
4. Apakah user perlu menerima invoice.
5. Apakah order gratis boleh dibuat berulang.

Jangan menganggap harga `0` sebagai pembayaran DOKU. Gunakan branch gratis khusus dan buat fulfillment lokal yang idempotent.

## Webhook DOKU

### Endpoint utama

```text
POST /api/c4/notifikasi
CheckoutController::handleDokuTransactionNotification()
```

Endpoint tambahan yang masih tersedia:

```text
POST /api/doku/notification
POST /api/doku/membership/notification
```

Untuk order baru, gunakan dispatcher utama `/api/c4/notifikasi` agar semua tipe order diproses melalui jalur yang sama.

### Urutan dispatcher

1. Ambil nomor invoice dari payload:
   - `invoice_number`
   - `order.invoice_number`
   - `order.invoiceNumber`
2. Validasi invoice tidak kosong.
3. Abaikan invoice yang bukan diawali `BANKIR`.
4. Validasi signature DOKU.
5. Jika signature tidak tersedia atau tidak valid, lakukan check status ke DOKU.
6. Ambil `DataPayment` berdasarkan invoice.
7. Tentukan processor dari `tipe_pembelian`.
8. Jalankan processor dalam transaksi.
9. Kembalikan response dengan status hasil processor.

### Validasi signature

Signature memakai data:

```text
Client-Id
Request-Id
Request-Timestamp
Request-Target
Digest
```

Digest body dibuat dengan SHA-256. Signature dibuat dengan HMAC-SHA256 menggunakan `DOKU_SECRET_KEY`.

### Idempotency

Webhook dapat dikirim lebih dari satu kali. Processor wajib:

- Mengunci payment dengan `lockForUpdate()`.
- Mengecek status paid sebelum membuat akses.
- Tidak membuat peserta atau histori akses dua kali.
- Menggunakan `insertOrIgnore` atau unique key untuk data akses jika sesuai kebutuhan.

## Callback Browser dan SweetAlert

Callback DOKU diarahkan ke:

```text
/pembayaran?invoice_number=<invoice>
```

`BillingController::redirectAfterPayment()` hanya membaca status lokal berdasarkan invoice dan user yang sedang login.

Hasil callback:

- Status paid: flash `success`.
- Status canceled: flash `error`.
- Status pending: flash `info`.

SweetAlert dirender oleh:

```text
resources/views/membernonkeanggotaan/partials/scripts.blade.php
```

Gunakan pola berikut untuk redirect berbasis flash:

```php
return redirect('/pembayaran')->with('success', 'Pesan sukses.');
return redirect('/pembayaran')->with('error', 'Pesan gagal.');
return redirect('/pembayaran')->with('info', 'Pesan informasi.');
```

Jangan mengaktifkan akses hanya dari query string callback browser. Aktivasi harus dilakukan dari webhook atau branch gratis yang sudah diverifikasi server.

## Expiry dan Pembatalan

Service:

```text
app/Services/PaymentExpiryService.php
```

Pemanggilan utama terjadi saat user membuka halaman billing atau profil. Artinya, expiry saat ini bersifat lazy, bukan scheduler-based.

Payment normal menggunakan waktu expiry:

```text
created_at + expired menit
```

Nilai default payment adalah `60` menit.

Jika payment expired:

1. Lock payment.
2. Pastikan status masih pending.
3. Ubah status menjadi `STATUS_CANCELED`.
4. Tambahkan keterangan pembatalan.
5. Jika payment membership, reset status profile yang masih pending.

Payment IHT memiliki pengecualian sendiri karena dapat menunggu konfirmasi tanpa expiry normal.

## Menambahkan Jenis Order Baru

Gunakan langkah berikut agar jenis order baru mudah dirawat.

### 1. Definisikan identitas order

Tentukan:

- Nama pembelian.
- Nilai string `pembelian`.
- Nilai integer `tipe_pembelian`.
- Resource ID yang dimiliki order.
- Tabel fulfillment atau tabel akses.
- Apakah membutuhkan quantity, expiry, sertifikat, atau metadata tambahan.

Tambahkan konstanta pada `DataPayment`. Jangan menggunakan tipe order yang sudah ada hanya karena alurnya terlihat mirip.

### 2. Siapkan database dan model

Jika diperlukan:

1. Buat migration.
2. Tambahkan field ke `$fillable`.
3. Tambahkan cast ke `$casts`.
4. Tambahkan relasi model.
5. Tambahkan unique key untuk mencegah akses ganda.

### 3. Buat endpoint order

Endpoint baru harus:

1. Memastikan user login.
2. Memvalidasi resource ID.
3. Mengambil harga dari database.
4. Tidak mempercayai harga dari client.
5. Mengecek duplicate active order jika diperlukan.
6. Membuat `DataPayment` dalam transaksi.
7. Membuat invoice unik dengan prefix `BANKIR`.
8. Menyimpan `status = STATUS_PENDING`.
9. Menyimpan `tipe_pembelian` dan resource ID.

### 4. Buat helper checkout DOKU

Helper harus:

- Menolak nominal kurang dari `1` untuk order berbayar.
- Menggunakan line item yang benar.
- Menggunakan callback dengan invoice.
- Menggunakan payment due date yang sesuai.
- Mengirim `additional_info.pembelian_tipe`.
- Membuat digest dan signature.
- Menyimpan `link_payment` hanya setelah URL valid.
- Tidak menulis secret ke log.

### 5. Tambahkan dispatcher webhook

Tambahkan branch pada `handleDokuTransactionNotification()` berdasarkan:

```php
$payment->tipe_pembelian
```

Jangan menentukan jenis order hanya dari keberadaan relasi tabel lain.

### 6. Buat processor fulfillment

Processor baru harus:

1. Lock `DataPayment`.
2. Validasi tipe pembelian.
3. Validasi nominal terhadap nominal yang disimpan server.
4. Mengecek status sukses DOKU.
5. Return aman jika sudah diproses.
6. Membuat akses dalam transaksi.
7. Update status payment.
8. Mencatat histori transaksi jika dibutuhkan.
9. Mencegah duplicate akses.

### 7. Tambahkan billing dan pesan

Update:

- `BillingController::paymentContext()`.
- `pendingPaymentMessage()`.
- `confirmedPaymentMessage()`.
- Query eager loading relasi item.
- `billing-history-items.blade.php` jika label atau invoice berbeda.

### 8. Tambahkan expiry dan callback

Pastikan jenis order baru memiliki keputusan yang jelas:

- Menggunakan expiry standar.
- Memiliki expiry khusus.
- Tidak memiliki expiry karena gratis.

Callback browser harus selalu mencari invoice milik user yang sedang login.

### 9. Tambahkan test

Minimal test yang dibutuhkan:

1. Request order valid.
2. Resource tidak ditemukan.
3. Harga invalid atau mismatch.
4. DOKU gagal mengembalikan URL.
5. Webhook sukses.
6. Webhook duplikat.
7. Webhook gagal.
8. Nominal webhook mismatch.
9. Payment expired.
10. Callback browser sebelum webhook.
11. Callback browser setelah webhook.
12. Invoice milik user lain.
13. Akses tidak dibuat dua kali.
14. Order gratis jika memang didukung.

## Checklist Testing

Sebelum merge perubahan pembayaran:

```bash
php artisan view:cache
php artisan test
php -l app/Http/Controllers/PaymentController.php
php -l app/Http/Controllers/CheckoutController.php
git diff --check
```

Checklist manual:

- Buat order dari user yang sudah login.
- Pastikan harga berasal dari server.
- Pastikan invoice tersimpan di `datapayment`.
- Pastikan payment URL tersimpan setelah response DOKU sukses.
- Simulasikan webhook sukses.
- Simulasikan webhook duplicate.
- Simulasikan webhook gagal.
- Simulasikan nominal mismatch.
- Kembali dari DOKU sebelum webhook masuk.
- Pastikan SweetAlert menampilkan status yang benar.
- Pastikan akses tidak dibuat dua kali.
- Pastikan payment user lain tidak dapat dibaca melalui callback.

## Catatan Teknis

Beberapa hal yang perlu diperhatikan saat maintenance:

1. `DataPayment` adalah ledger utama. Jangan membuat alur payment baru tanpa menyimpan invoice dan status di sini.
2. `ClassPaymentModel` masih digunakan untuk detail order kelas. Untuk order kelas, invoice pada kedua tabel harus sama.
3. Webhook adalah sumber kebenaran pembayaran. Callback browser hanya untuk UX.
4. Harga membership ditentukan server-side berdasarkan tipe membership.
5. Ebook dan video gratis belum memiliki flow order gratis yang didukung.
6. Payment expiry saat ini berjalan lazy ketika user membuka halaman tertentu.
7. DOKU notification endpoint harus menggunakan URL publik yang dapat diakses DOKU.
8. Jangan mencatat `DOKU_SECRET_KEY`, signature lengkap, atau credential lain ke log.
9. Gunakan transaksi database saat mengubah status payment sekaligus membuat akses.
10. Pastikan migration payment dijalankan sebelum kode yang menggunakan field baru.

## Konfigurasi DOKU

Nama environment variable yang digunakan:

```env
DOKU_CLIENT_ID=
DOKU_SECRET_KEY=
DOKU_URL=
DOKU_NOTIFICATION_URL=
```

`DOKU_NOTIFICATION_URL` harus menunjuk ke endpoint dispatcher utama, contoh:

```text
https://domain.example/api/c4/notifikasi
```

Jangan commit file `.env` atau credential DOKU ke repository.
