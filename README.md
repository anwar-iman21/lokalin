# LOKALIN
### Smart Digital Ecosystem for Local UMKM

LOKALIN adalah platform digitalisasi UMKM yang dibangun untuk **Web Development Competition Mahasiswa iTechnoCup 2026**, dengan fokus SDG 8 — *Pekerjaan Layak dan Pertumbuhan Ekonomi*. LOKALIN membantu UMKM lokal "naik kelas" dari usaha offline menjadi usaha dengan sistem digital: Digital Store, katalog produk, pemesanan online (delivery/pickup), pengelolaan pesanan, dashboard bisnis dengan grafik, QR Code toko, dan Asisten Bisnis AI.

---

## 1. Ringkasan Fitur

**Pelanggan**
- Jelajahi & cari UMKM berdasarkan kategori/nama
- Digital Store per UMKM (katalog produk publik)
- Keranjang belanja (satu toko per keranjang untuk menjaga alur pesanan tetap sederhana)
- Checkout dengan metode **Delivery** (alamat + lokasi GPS via `navigator.geolocation`) atau **Pickup**
- Tracking status pesanan & tombol "Buka Rute" (Google Maps)
- Beri ulasan & rating setelah pesanan selesai
- Kelola profil & notifikasi

**UMKM**
- Profil toko (logo, cover, lokasi GPS, jam operasional) — perlu disetujui admin sebelum tampil publik
- CRUD produk (nama, harga, stok, foto, status)
- Kelola pesanan masuk dengan alur status (pending → confirmed → processing → ready → [delivering] → completed)
- Dashboard dengan statistik & grafik pendapatan (Chart.js)
- Halaman **Analitik** (pendapatan 6 bulan, produk terlaris, distribusi status pesanan)
- **QR Code Digital Store** — bisa diunduh & ditempel di toko fisik
- **Asisten Bisnis AI** — membuat caption promosi, deskripsi produk, ide konten, dan strategi promosi. Menggunakan Anthropic API jika `ANTHROPIC_API_KEY` diisi di `.env`; jika kosong/gagal, otomatis memakai generator berbasis aturan (fallback) sehingga fitur **tetap berjalan tanpa API key**.

**Admin**
- Dashboard statistik platform + grafik transaksi
- Approve/reject/suspend/reactivate UMKM
- Kelola pelanggan (aktif/nonaktifkan akun)
- Kelola kategori (CRUD)
- Kelola & moderasi produk (aktif/nonaktifkan)
- Lihat seluruh transaksi
- Moderasi ulasan (tampilkan/sembunyikan)

---

## 2. Tech Stack

| Layer | Teknologi |
|---|---|
| Backend | Laravel 10 (PHP 8.1+) |
| Database | MySQL (default) / SQLite (opsional, untuk demo cepat) |
| Frontend | Blade + Tailwind CSS + Alpine.js |
| Build tool | Vite |
| Grafik | Chart.js (CDN) |
| QR Code | qrcode.js (CDN, generate di sisi browser) |
| AI | Anthropic API (opsional) dengan fallback rule-based generator |

---

## 3. Struktur Folder Penting

```
app/
  Http/
    Controllers/      -> Auth, Customer, Umkm, Admin, Store, Landing, Notification
    Middleware/        -> EnsureRole (role:customer|umkm|admin), EnsureUmkmApproved
    Requests/           -> Form Request validation per modul
  Models/               -> User, UmkmProfile, Category, Product, Cart, Order, Review, dst.
  Services/             -> OrderService (transaksi order), AiAssistantService (AI + fallback)
database/
  migrations/           -> seluruh skema database
  seeders/               -> data demo (akun, kategori, produk, order)
resources/
  views/
    components/          -> layouts (app/guest/dashboard) & komponen reusable
    landing/ auth/ customer/ umkm/ admin/ store/ notifications/
routes/web.php           -> seluruh routing aplikasi
```

---

## 4. Instalasi & Menjalankan Project

> **Prasyarat:** PHP >= 8.1, Composer, Node.js >= 18, dan MySQL (atau gunakan SQLite, lihat bagian 4b).

### Langkah instalasi (MySQL — default)

```bash
# 1. Masuk ke folder project
cd LOKALIN

# 2. Install dependency PHP
composer install

# 3. Salin file environment & generate application key
cp .env.example .env
php artisan key:generate

# 4. Buat database MySQL kosong bernama "lokalin" (via phpMyAdmin/CLI),
#    lalu sesuaikan DB_USERNAME / DB_PASSWORD di file .env jika perlu

# 5. Jalankan migrasi + seeder (data demo)
php artisan migrate --seed

# 6. Buat symlink storage (agar gambar upload bisa diakses publik)
php artisan storage:link

# 7. Install dependency frontend & build asset
npm install
npm run build

# 8. Jalankan server lokal
php artisan serve
```

Buka `http://localhost:8000` di browser.

### 4b. Cara Cepat dengan SQLite (opsional, tanpa setup MySQL)

Jika ingin demo cepat tanpa menyiapkan server MySQL:

```bash
touch database/database.sqlite
```

Lalu ubah bagian database di `.env` menjadi:

```
DB_CONNECTION=sqlite
DB_DATABASE=/path/absolut/ke/project/database/database.sqlite
```

(Hapus/comment baris `DB_HOST`, `DB_PORT`, `DB_USERNAME`, `DB_PASSWORD` jika ada.) Lalu lanjutkan dari langkah `php artisan migrate --seed` di atas.

### 4c. Mode pengembangan (opsional)

Untuk hot-reload saat mengembangkan tampilan:

```bash
npm run dev
```

jalankan di terminal terpisah, bersamaan dengan `php artisan serve`.

---

## 5. Akun Demo

Seluruh akun berikut dibuat otomatis oleh `php artisan migrate --seed`.

| Role | Email | Password |
|---|---|---|
| Admin | `admin@lokalin.test` | `password` |
| Pelanggan | `customer@lokalin.test` | `password` |
| UMKM (disetujui) | `umkm1@lokalin.test` s/d `umkm5@lokalin.test` | `password` |
| UMKM (menunggu approval — untuk demo alur admin) | `umkm-pending@lokalin.test` | `password` |

Data demo juga mencakup: 5 UMKM dengan produk masing-masing, satu pesanan berstatus **completed** beserta ulasannya, dan satu pesanan berstatus **pending** siap untuk didemokan alur "Kelola Pesanan" di sisi UMKM.

---

## 6. Fitur AI (Opsional)

Fitur **Asisten Bisnis AI** di dashboard UMKM berjalan dalam dua mode:

- **Mode Live** — jika `ANTHROPIC_API_KEY` diisi di `.env`, permintaan diteruskan ke Anthropic API.
- **Mode Fallback (default)** — jika key kosong atau permintaan API gagal (mis. tanpa koneksi internet saat demo), sistem otomatis memakai generator berbasis aturan bawaan, sehingga fitur **tetap dapat didemokan kapan saja tanpa bergantung pada API key/internet**.

Untuk mengaktifkan mode live, isi di `.env`:
```
ANTHROPIC_API_KEY=sk-ant-xxxxxxxx
```

---

## 7. Alur Demo yang Disarankan untuk Juri

1. Buka **landing page** → tunjukkan storytelling masalah-solusi-dampak.
2. Login sebagai **customer** → jelajahi UMKM → buka Digital Store → tambah produk ke keranjang → checkout (coba mode delivery dengan tombol GPS, atau pickup) → lihat status pesanan.
3. Login sebagai **umkm1** → tunjukkan dashboard, kelola pesanan masuk (ubah status), kelola produk, buka halaman **QR Code** (unduh), coba **Asisten AI**, lihat halaman **Analitik**.
4. Login sebagai **admin** → tunjukkan approval UMKM (`umkm-pending@lokalin.test` masih berstatus *menunggu*), kelola kategori/produk/pelanggan, moderasi ulasan.
5. Sebagai customer, selesaikan pesanan **pending** dari sisi UMKM sampai *completed*, lalu beri ulasan dari sisi customer.

---

## 8. Keamanan

- Password di-hash dengan bcrypt (`Hash::make`), tidak pernah disimpan plain text.
- Proteksi CSRF aktif di semua form (`@csrf`).
- Validasi input di seluruh form menggunakan Laravel Form Request.
- Middleware role-based (`role:customer|umkm|admin`) mencegah akses lintas peran.
- Middleware `umkm.approved` mencegah UMKM yang belum disetujui mengelola produk/pesanan.
- Upload gambar divalidasi tipe (`image`) dan ukuran maksimum.
- Mass assignment dibatasi lewat `$fillable` di setiap model.
- Query database memakai Eloquent/Query Builder (parameter binding), bukan raw SQL string concatenation, untuk mencegah SQL injection.
- `.env` **tidak** disertakan dalam paket ini — hanya `.env.example` tanpa secret apa pun.

---

## 9. Catatan Keterbatasan Verifikasi (Wajib Dibaca)

Source code ini ditulis dan diverifikasi *statis* (syntax check PHP untuk seluruh 100+ file, pengecekan konsistensi nama route antara `routes/web.php` dan seluruh view, pengecekan komponen Blade, serta pengecekan namespace/`use` di setiap class) di lingkungan sandbox yang **tidak memiliki akses ke Packagist/getcomposer.org**. Akibatnya:

- `composer install` **belum pernah dijalankan** terhadap kode ini, sehingga folder `vendor/` belum ada dan proses runtime penuh (`php artisan serve`, `php artisan migrate`, load halaman sungguhan) **belum dapat diverifikasi end-to-end** di lingkungan pembuatan.
- Kemungkinan kecil masih ada isu yang hanya muncul saat runtime penuh (mis. kesalahan minor pada satu relasi/query spesifik) yang tidak tertangkap oleh pengecekan statis. Jika ditemukan saat Anda menjalankan project, umumnya perbaikannya kecil (typo nama kolom/relasi) dan mudah ditelusuri lewat pesan error Laravel.
- **Yang sudah diverifikasi:** seluruh migration, model, controller, request, middleware, route, dan view telah dicek konsistensinya secara silang (nama route, nama komponen Blade, namespace class) dan seluruh file PHP lolos `php -l` (syntax check) tanpa error.

Disarankan setelah instalasi, jalankan `php artisan route:list` untuk memastikan seluruh route ter-load tanpa error, sebagai langkah verifikasi cepat tambahan.

---

## 10. Lisensi

Dibuat untuk keperluan kompetisi iTechnoCup 2026. Bebas dipakai/dimodifikasi untuk keperluan pembelajaran.
#   l o k a l i n  
 #   l o k a l i n  
 