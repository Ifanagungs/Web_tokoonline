# Toko Online Tri Bhakti At Taqwa

E-commerce platform sederhana yang dibangun dengan Laravel 12.

## Fitur Utama
- Katalog Produk
- Keranjang Belanja
- Sistem Checkout (COD & Transfer Bank)
- Dashboard Admin
- Manajemen Stok Produk, dll

## Persyaratan Sistem
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL/MariaDB

## Instalasi
1. Clone repository
2. Jalankan `composer install`
3. Jalankan `npm install && npm run build`
4. Salin `.env.example` ke `.env` dan sesuaikan konfigurasi database
5. Jalankan `php artisan key:generate`
6. Jalankan `php artisan migrate --seed`
7. Jalankan `php artisan storage:link`
8. Jalankan `php artisan serve`

---

## Panduan Pengelolaan Toko

### 1. Cara Mengubah Logo
Logo utama dapat ditemukan di direktori `public/images/logo.png`.
- Untuk mengganti logo, cukup ganti file `logo.png` tersebut dengan logo baru Anda dengan nama yang sama.
- Referensi logo di kode berada pada file: `resources/views/components/storefront/navbar.blade.php`.

### 2. Cara Mengubah Ongkos Kirim
Saat ini ongkos kirim (shipping cost) diatur secara flat (Rata). Untuk mengubah nilainya:
1. Buka file `app/Http/Controllers/CartController.php`. Ubah nilai `10000` pada method `index`, `update`, dan `destroy`.
2. Buka file `app/Http/Controllers/CheckoutController.php`. Ubah nilai `10000` pada method `index` dan `store`.

*Disarankan untuk menggunakan nilai yang sama di kedua file tersebut agar konsisten.*

### 3. Pengaturan Waktu (Timezone)
Aplikasi ini menggunakan timezone **Asia/Jakarta (WIB)** yang diatur di file `config/app.php`.

### 4. Sistem Pembayaran COD
Pesanan dengan metode pembayaran **COD (Cash on Delivery)** akan secara otomatis memiliki status **"Diproses"** segera setelah checkout berhasil.

### 5. Cara Mengubah Rekening Pembayaran
Informasi nomor rekening bank ditampilkan pada halaman sukses checkout dan detail pesanan. Untuk mengubahnya:
1. Buka file `resources/views/checkout/success.blade.php`. Cari dan ubah teks **"Bank BCA - 1234567890"** serta nama pemilik rekening.
2. Buka file `resources/views/orders/show.blade.php`. Cari dan ubah teks **"BCA 1234567890"** serta nama pemilik rekening.

*Pastikan informasi di kedua file tersebut sama agar pelanggan tidak bingung.*

---

## Lisensi
Aplikasi ini dikembangkan untuk kebutuhan internal Toko Tri Bhakti At Taqwa.
