-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 19 Agu 2026 pada 10.32
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lokalin`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `ai_generations`
--

CREATE TABLE `ai_generations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `umkm_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('caption','content_idea','description','promotion_strategy') NOT NULL,
  `input` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`input`)),
  `output` longtext DEFAULT NULL,
  `is_fallback` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `ai_generations`
--

INSERT INTO `ai_generations` (`id`, `umkm_id`, `type`, `input`, `output`, `is_fallback`, `created_at`, `updated_at`) VALUES
(1, 1, 'promotion_strategy', '{\"type\":\"promotion_strategy\",\"product_name\":null,\"description\":null,\"target_customer\":null,\"business_type\":\"Coffe Americano\",\"keywords\":null}', '1. Aktifkan Digital Store LOKALIN dan sebarkan QR Code di lokasi usaha Coffe Americano Anda.\n2. Posting produk secara rutin (2-3 kali seminggu) di media sosial dengan foto yang menarik.\n3. Berikan promo bundling atau diskon kecil untuk pembelian pertama lewat LOKALIN.\n4. Ajak pelanggan yang puas untuk memberi review di Digital Store Anda.', 1, '2026-08-15 04:04:50', '2026-08-15 04:04:50'),
(2, 1, 'caption', '{\"type\":\"caption\",\"product_name\":\"Buku Tulis\",\"description\":\"Dibuat oleh tangan profesional\",\"target_customer\":\"Siswa\\/i\",\"business_type\":null,\"keywords\":null}', '✨ Buku Tulis siap menemani hari-hari Siswa/i! Dibuat dengan bahan pilihan dan penuh cinta oleh UMKM lokal. Yuk pesan sekarang sebelum kehabisan! 🛍️ #ProdukLokal #DukungUMKM', 1, '2026-08-15 04:05:35', '2026-08-15 04:05:35'),
(3, 1, 'description', '{\"type\":\"description\",\"product_name\":\"Buku Tulis\",\"description\":null,\"target_customer\":null,\"business_type\":null,\"keywords\":\"Buku\"}', 'Buku Tulis adalah produk unggulan UMKM lokal yang dibuat dengan bahan berkualitas dan proses yang terjaga kebersihannya. Cocok untuk Buku. Nikmati cita rasa/kualitas terbaik langsung dari produsen lokal.', 1, '2026-08-15 04:05:59', '2026-08-15 04:05:59'),
(4, 1, 'content_idea', '{\"type\":\"content_idea\",\"product_name\":null,\"description\":null,\"target_customer\":null,\"business_type\":\"Penerbit Laduny\",\"keywords\":null}', '1. Behind the scenes proses pembuatan Kopi Senja di usaha Penerbit Laduny Anda.\n2. Testimoni pelanggan yang sudah mencoba Kopi Senja.\n3. Tips atau cara menikmati/menggunakan Kopi Senja dengan cara unik.\n4. Promo spesial akhir pekan untuk Kopi Senja.\n5. Cerita di balik berdirinya usaha Penerbit Laduny Anda (storytelling brand).', 1, '2026-08-15 04:06:11', '2026-08-15 04:06:11'),
(5, 1, 'description', '{\"type\":\"description\",\"product_name\":\"Kerupuk Bambu\",\"description\":null,\"target_customer\":null,\"business_type\":null,\"keywords\":\"Kerupuk\"}', 'JUDUL PRODUK\nKerupuk Bambu\n\nRINGKASAN\nKerupuk Bambu merupakan produk UMKM lokal yang dapat menjadi pilihan bagi pelanggan yang ingin mendukung usaha lokal.\n\nDESKRIPSI\nKerupuk Bambu dibuat dan ditawarkan oleh pelaku UMKM lokal dengan perhatian terhadap kualitas produk dan kebutuhan pelanggan.\n\nKata kunci yang relevan: Kerupuk.\n\nKEUNGGULAN\n• Produk dari UMKM lokal.\n• Mendukung perkembangan ekonomi lokal.\n• Dapat menjadi pilihan untuk kebutuhan pelanggan sehari-hari.\n\nCOCOK UNTUK\nPelanggan yang membutuhkan produk lokal dan ingin mendukung pelaku UMKM di sekitarnya.\n\nCALL TO ACTION\nTertarik mencoba? Lihat detail produk dan lakukan pemesanan melalui LOKALIN.', 1, '2026-08-17 15:29:25', '2026-08-17 15:29:25'),
(6, 1, 'promotion_strategy', '{\"type\":\"promotion_strategy\",\"product_name\":null,\"description\":null,\"target_customer\":null,\"business_type\":\"Coffe Americano\",\"keywords\":null}', '1. Aktifkan Digital Store LOKALIN dan sebarkan QR Code di lokasi usaha Coffe Americano.\n2. Posting produk secara rutin dengan foto dan video yang menarik.\n3. Gunakan promo bundling untuk meningkatkan nilai transaksi.\n4. Ajak pelanggan memberikan review setelah melakukan pembelian.\n5. Gunakan WhatsApp Business untuk membangun hubungan dengan pelanggan.\n6. Buat konten edukasi yang berhubungan dengan produk.\n7. Gunakan storytelling untuk memperkenalkan perjalanan usaha.\n8. Evaluasi produk dan konten berdasarkan respon pelanggan.', 1, '2026-08-17 15:29:45', '2026-08-17 15:29:45'),
(7, 1, 'promotion_strategy', '{\"type\":\"promotion_strategy\",\"product_name\":null,\"description\":null,\"target_customer\":null,\"business_type\":\"Coffe Americano\",\"keywords\":null}', '1. Aktifkan Digital Store LOKALIN dan sebarkan QR Code di lokasi usaha Coffe Americano.\n2. Posting produk secara rutin dengan foto dan video yang menarik.\n3. Gunakan promo bundling untuk meningkatkan nilai transaksi.\n4. Ajak pelanggan memberikan review setelah melakukan pembelian.\n5. Gunakan WhatsApp Business untuk membangun hubungan dengan pelanggan.\n6. Buat konten edukasi yang berhubungan dengan produk.\n7. Gunakan storytelling untuk memperkenalkan perjalanan usaha.\n8. Evaluasi produk dan konten berdasarkan respon pelanggan.', 1, '2026-08-17 15:29:46', '2026-08-17 15:29:46'),
(8, 1, 'content_idea', '{\"type\":\"content_idea\",\"product_name\":null,\"description\":null,\"target_customer\":null,\"business_type\":\"Penerbit Laduny\",\"keywords\":null}', '1. Behind the Scenes\nTujuan: Membangun kepercayaan\nKonsep: Tampilkan proses pembuatan Kopi Senja.\nHook: Pernah penasaran bagaimana Kopi Senja dibuat?\nFormat: Video pendek\nCTA: Follow untuk melihat proses lainnya.\n\n2. Kenalan dengan Produk\nTujuan: Meningkatkan awareness\nKonsep: Perkenalkan Kopi Senja kepada calon pelanggan.\nHook: Sudah kenal dengan Kopi Senja?\nFormat: Foto carousel\nCTA: Cek katalog produk.\n\n3. Testimoni Pelanggan\nTujuan: Meningkatkan kepercayaan\nKonsep: Tampilkan pengalaman pelanggan.\nHook: Apa kata pelanggan kami?\nFormat: Foto / video\nCTA: Coba sendiri produknya.\n\n4. Tips Edukasi\nTujuan: Meningkatkan engagement\nKonsep: Berikan tips yang berkaitan dengan Kopi Senja.\nHook: Tahukah kamu tips sederhana ini?\nFormat: Carousel\nCTA: Simpan postingan ini.\n\n5. Promo Terbatas\nTujuan: Mendorong pembelian\nKonsep: Buat penawaran sederhana dengan batas waktu.\nHook: Promo spesial hanya untuk periode tertentu!\nFormat: Story / Post\nCTA: Pesan sekarang.', 1, '2026-08-17 15:29:54', '2026-08-17 15:29:54'),
(9, 1, 'description', '{\"type\":\"description\",\"product_name\":\"Tahu Bulat\",\"description\":null,\"target_customer\":null,\"business_type\":null,\"keywords\":\"Tahu\"}', 'JUDUL PRODUK\nTahu Bulat\n\nRINGKASAN\nTahu Bulat merupakan produk UMKM lokal yang dapat menjadi pilihan bagi pelanggan yang ingin mendukung usaha lokal.\n\nDESKRIPSI\nTahu Bulat dibuat dan ditawarkan oleh pelaku UMKM lokal dengan perhatian terhadap kualitas produk dan kebutuhan pelanggan.\n\nKata kunci yang relevan: Tahu.\n\nKEUNGGULAN\n• Produk dari UMKM lokal.\n• Mendukung perkembangan ekonomi lokal.\n• Dapat menjadi pilihan untuk kebutuhan pelanggan sehari-hari.\n\nCOCOK UNTUK\nPelanggan yang membutuhkan produk lokal dan ingin mendukung pelaku UMKM di sekitarnya.\n\nCALL TO ACTION\nTertarik mencoba? Lihat detail produk dan lakukan pemesanan melalui LOKALIN.', 1, '2026-08-17 15:30:26', '2026-08-17 15:30:26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `umkm_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `umkm_id`, `created_at`, `updated_at`) VALUES
(1, 2, NULL, '2026-08-14 14:44:13', '2026-08-18 05:38:06'),
(2, 9, NULL, '2026-08-14 14:44:13', '2026-08-14 14:44:13'),
(3, 10, NULL, '2026-08-14 14:44:13', '2026-08-14 14:44:13'),
(4, 11, NULL, '2026-08-14 14:44:13', '2026-08-14 14:44:13'),
(5, 12, NULL, '2026-08-14 14:44:13', '2026-08-14 14:44:13'),
(6, 13, NULL, '2026-08-14 14:44:13', '2026-08-14 14:44:13'),
(7, 14, NULL, '2026-08-18 05:40:35', '2026-08-18 05:40:35'),
(8, 16, NULL, '2026-08-18 05:48:03', '2026-08-18 05:48:03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cart_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `icon`, `created_at`, `updated_at`) VALUES
(1, 'Makanan & Minuman', 'makanan-minuman', '🍔', '2026-08-14 14:44:13', '2026-08-14 14:44:13'),
(2, 'Fashion & Aksesoris', 'fashion-aksesoris', '👗', '2026-08-14 14:44:13', '2026-08-14 14:44:13'),
(3, 'Kerajinan Tangan', 'kerajinan-tangan', '🧶', '2026-08-14 14:44:13', '2026-08-14 14:44:13'),
(4, 'Kecantikan & Perawatan', 'kecantikan-perawatan', '💄', '2026-08-14 14:44:13', '2026-08-14 14:44:13'),
(5, 'Jasa & Layanan', 'jasa-layanan', '🛠️', '2026-08-14 14:44:13', '2026-08-14 14:44:13'),
(6, 'Pertanian & Sembako', 'pertanian-sembako', '🌾', '2026-08-14 14:44:13', '2026-08-14 14:44:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_sessions_table', 1),
(4, '2019_12_14_000001_create_cache_table', 1),
(5, '2019_12_14_000002_create_jobs_table', 1),
(6, '2024_01_01_000010_create_categories_table', 1),
(7, '2024_01_01_000020_create_umkm_profiles_table', 1),
(8, '2024_01_01_000030_create_products_table', 1),
(9, '2024_01_01_000031_create_product_images_table', 1),
(10, '2024_01_01_000040_create_carts_table', 1),
(11, '2024_01_01_000041_create_cart_items_table', 1),
(12, '2024_01_01_000050_create_orders_table', 1),
(13, '2024_01_01_000051_create_order_items_table', 1),
(14, '2024_01_01_000060_create_reviews_table', 1),
(15, '2024_01_01_000070_create_ai_generations_table', 1),
(16, '2024_01_01_000080_create_notifications_table', 1),
(17, '2024_01_01_000090_create_activity_logs_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `title`, `message`, `url`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 15, 'Toko Disetujui', 'Selamat! Toko \"Mie Ayam Kondang\" telah disetujui dan kini tampil di LOKALIN.', 'http://127.0.0.1:8000/umkm/dashboard', 1, '2026-08-18 05:42:48', '2026-08-18 05:49:52'),
(2, 8, 'Toko Disetujui', 'Selamat! Toko \"Toko Camilan Baru\" telah disetujui dan kini tampil di LOKALIN.', 'http://127.0.0.1:8000/umkm/dashboard', 1, '2026-08-18 05:42:57', '2026-08-18 06:19:59'),
(3, 17, 'Toko Disetujui', 'Selamat! Toko \"Penebit Syukhira\" telah disetujui dan kini tampil di LOKALIN.', 'http://127.0.0.1:8000/umkm/dashboard', 1, '2026-08-18 06:26:47', '2026-08-18 06:27:25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `umkm_id` bigint(20) UNSIGNED NOT NULL,
  `fulfillment_method` enum('delivery','pickup') NOT NULL,
  `status` enum('pending','confirmed','processing','ready','delivering','completed','cancelled') NOT NULL DEFAULT 'pending',
  `recipient_name` varchar(255) NOT NULL,
  `recipient_phone` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `delivery_note` text DEFAULT NULL,
  `subtotal` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `confirmed_at` timestamp NULL DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `cancel_reason` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `user_id`, `umkm_id`, `fulfillment_method`, `status`, `recipient_name`, `recipient_phone`, `address`, `latitude`, `longitude`, `delivery_note`, `subtotal`, `total`, `confirmed_at`, `completed_at`, `cancelled_at`, `cancel_reason`, `created_at`, `updated_at`) VALUES
(1, 'LKN-DEMO-COMPLETED', 2, 1, 'pickup', 'completed', 'Budi Santoso', '081200000002', NULL, NULL, NULL, NULL, 36000.00, 36000.00, '2026-08-11 14:44:13', '2026-08-12 14:44:13', NULL, NULL, '2026-08-11 14:44:13', '2026-08-12 14:44:13'),
(2, 'LKN-DEMO-PENDING', 2, 1, 'delivery', 'completed', 'Budi Santoso', '081200000002', 'Jl. Demo Pengantaran No. 1, Bandar Lampung', -5.3971000, 105.2668000, 'Tolong tanpa gula tambahan, terima kasih.', 18000.00, 18000.00, '2026-08-18 06:02:04', '2026-08-18 06:02:10', NULL, NULL, '2026-08-14 14:44:13', '2026-08-18 06:02:10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `price`, `quantity`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Kopi Susu Gula Aren', 18000.00, 2, 36000.00, '2026-08-11 14:44:13', '2026-08-11 14:44:13'),
(2, 2, 1, 'Kopi Susu Gula Aren', 18000.00, 1, 18000.00, '2026-08-14 14:44:13', '2026-08-14 14:44:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `umkm_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(12,2) NOT NULL,
  `stock` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `sold_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id`, `umkm_id`, `category_id`, `name`, `slug`, `description`, `price`, `stock`, `image`, `status`, `sold_count`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Kopi Susu Gula Aren', 'kopi-susu-gula-aren', 'Produk unggulan dari Kopi Senja. Dibuat dengan bahan berkualitas dan penuh perhatian pada detail.', 18000.00, 35, 'products/6M0AohPxLwZT3WAiIPkcsCwONo0widxelW67z5SL.jpg', 'active', 24, '2026-08-14 14:44:13', '2026-08-18 06:04:34'),
(2, 1, 1, 'Americano Dingin', 'americano-dingin', 'Produk unggulan dari Kopi Senja. Dibuat dengan bahan berkualitas dan penuh perhatian pada detail.', 15000.00, 40, 'products/Tii8czeiqLwzfGJadYSz1kSzYzrmqve8GHGNiQvM.jpg', 'active', 18, '2026-08-14 14:44:13', '2026-08-18 06:05:03'),
(3, 1, 1, 'Kopi Tubruk Original', 'kopi-tubruk-original', 'Produk unggulan dari Kopi Senja. Dibuat dengan bahan berkualitas dan penuh perhatian pada detail.', 12000.00, 50, 'products/iLCqbfs1YsVXkFj9JuZMuGY27QGFjR3D362ksGID.jpg', 'active', 12, '2026-08-14 14:44:13', '2026-08-18 06:05:31'),
(4, 1, 1, 'Roti Bakar Cokelat Keju', 'roti-bakar-cokelat-keju', 'Produk unggulan dari Kopi Senja. Dibuat dengan bahan berkualitas dan penuh perhatian pada detail.', 16000.00, 20, 'products/MYGdlGo9l0LGmapKiq4E4aMMB5Q1vZ1BPPrDYU10.jpg', 'active', 9, '2026-08-14 14:44:13', '2026-08-18 06:05:51'),
(5, 2, 2, 'Kain Batik Tulis Motif Parang', 'kain-batik-tulis-motif-parang', 'Produk unggulan dari Batik Rahayu. Dibuat dengan bahan berkualitas dan penuh perhatian pada detail.', 250000.00, 15, 'products/hSeZ3G4Q67lwgkATYD7Rr5RZiRty4oZIzuMQ7eUq.jpg', 'active', 7, '2026-08-14 14:44:13', '2026-08-18 06:08:48'),
(6, 2, 2, 'Kemeja Batik Pria Lengan Panjang', 'kemeja-batik-pria-lengan-panjang', 'Produk unggulan dari Batik Rahayu. Dibuat dengan bahan berkualitas dan penuh perhatian pada detail.', 175000.00, 18, 'products/9k59MRkffQLdCnx7zTsef4GXgwEz4XTY21us3aF8.jpg', 'active', 11, '2026-08-14 14:44:13', '2026-08-18 06:09:09'),
(7, 2, 2, 'Dress Batik Wanita', 'dress-batik-wanita', 'Produk unggulan dari Batik Rahayu. Dibuat dengan bahan berkualitas dan penuh perhatian pada detail.', 210000.00, 12, 'products/iVXZUeoWlrpZ1yTNu0Om59NhtqoYf20NxLqoupxM.jpg', 'active', 5, '2026-08-14 14:44:13', '2026-08-18 06:09:40'),
(8, 3, 3, 'Tas Anyaman Rotan', 'tas-anyaman-rotan', 'Produk unggulan dari Kriya Anyaman Asri. Dibuat dengan bahan berkualitas dan penuh perhatian pada detail.', 95000.00, 22, 'products/Zic8n7IIopOpMiMzltNzBo9Ve7npYmDyiSLHjZs3.jpg', 'active', 14, '2026-08-14 14:44:13', '2026-08-18 06:12:45'),
(9, 3, 3, 'Tempat Tisu Bambu', 'tempat-tisu-bambu', 'Produk unggulan dari Kriya Anyaman Asri. Dibuat dengan bahan berkualitas dan penuh perhatian pada detail.', 35000.00, 30, 'products/iZh9eOooPB1zAnZu9k9noRtHEntmzYflvljzjQQk.jpg', 'active', 8, '2026-08-14 14:44:13', '2026-08-18 06:13:30'),
(10, 3, 3, 'Keranjang Piknik Anyaman', 'keranjang-piknik-anyaman', 'Produk unggulan dari Kriya Anyaman Asri. Dibuat dengan bahan berkualitas dan penuh perhatian pada detail.', 120000.00, 10, 'products/KkzTNJa5d8IdGnXCEXLWvdCUm1hoOr1L0TQLiF9B.jpg', 'active', 3, '2026-08-14 14:44:13', '2026-08-18 06:13:49'),
(11, 4, 4, 'Sabun Batang Lidah Buaya', 'sabun-batang-lidah-buaya', 'Produk unggulan dari Sabun Herbal Alami. Dibuat dengan bahan berkualitas dan penuh perhatian pada detail.', 22000.00, 45, 'products/AyHWXHxQZdtCugb5s2ZUVjU11GcawPXEOug1JRSv.jpg', 'active', 20, '2026-08-14 14:44:13', '2026-08-18 06:15:31'),
(12, 4, 4, 'Sabun Cair Sereh Wangi', 'sabun-cair-sereh-wangi', 'Produk unggulan dari Sabun Herbal Alami. Dibuat dengan bahan berkualitas dan penuh perhatian pada detail.', 28000.00, 33, 'products/L25lPFSWEhdPZkgOH6hmp6qry3awcWi9lMu3mZaZ.jpg', 'active', 16, '2026-08-14 14:44:13', '2026-08-18 06:16:01'),
(13, 4, 4, 'Lulur Tradisional Rempah', 'lulur-tradisional-rempah', 'Produk unggulan dari Sabun Herbal Alami. Dibuat dengan bahan berkualitas dan penuh perhatian pada detail.', 30000.00, 25, 'products/fDxqgbzwDQq8UGbmrSvHYKh0G30QmnvmjBUvgkWK.jpg', 'active', 10, '2026-08-14 14:44:13', '2026-08-18 06:16:21'),
(14, 5, 5, 'Nasi Ayam Geprek', 'nasi-ayam-geprek', 'Produk unggulan dari Warung Nasi Ibu Sri. Dibuat dengan bahan berkualitas dan penuh perhatian pada detail.', 15000.00, 40, 'products/0EA8FF6wsMOL29P3mivCSsvbICy5CpoNkduYQLEb.jpg', 'active', 31, '2026-08-14 14:44:13', '2026-08-18 06:18:17'),
(15, 5, 5, 'Nasi Rendang', 'nasi-rendang', 'Produk unggulan dari Warung Nasi Ibu Sri. Dibuat dengan bahan berkualitas dan penuh perhatian pada detail.', 20000.00, 35, 'products/19GGIcETXGgNhJKCWrkycl6qx7k3bW0gofvYZTwQ.jpg', 'active', 27, '2026-08-14 14:44:13', '2026-08-18 06:18:35'),
(16, 5, 5, 'Sayur Lodeh + Tempe', 'sayur-lodeh-tempe', 'Produk unggulan dari Warung Nasi Ibu Sri. Dibuat dengan bahan berkualitas dan penuh perhatian pada detail.', 10000.00, 30, 'products/dgbARgBfuo34bdRqf8juK6eVhcNLTGgj9mr6vSiB.jpg', 'active', 19, '2026-08-14 14:44:13', '2026-08-18 06:19:06'),
(17, 5, 5, 'Es Teh Manis', 'es-teh-manis', 'Produk unggulan dari Warung Nasi Ibu Sri. Dibuat dengan bahan berkualitas dan penuh perhatian pada detail.', 5000.00, 60, 'products/Epa4rhL7mWaZNHkbmEdFgjqqq0yTLbKL1dQVMQhQ.jpg', 'active', 42, '2026-08-14 14:44:13', '2026-08-18 06:19:27'),
(18, 7, 1, 'Mie Ayam Kondang', 'mie-ayam-kondang-hwk7c', 'Mie Ayam Kondang adalah tempat kuliner yang menyajikan mie ayam dengan cita rasa gurih, lezat, dan menggugah selera. Menggunakan bahan pilihan dan racikan bumbu yang khas, setiap porsi dibuat dengan penuh perhatian untuk memberikan rasa yang nikmat dan memuaskan.\r\n\r\nCocok untuk makan sendiri, bersama keluarga, maupun nongkrong bersama teman. Yuk, nikmati kelezatan Mie Ayam Kondang dan rasakan sendiri kenikmatannya! 🍜✨', 10000.00, 8763, 'products/LckLk61mohcbRCibwQw3e5WyTwb7CM2IFU6xIANp.jpg', 'active', 0, '2026-08-18 05:55:50', '2026-08-18 05:56:51'),
(19, 6, 1, 'Roti Gembong', 'roti-gembong-ce5nl', 'Roti Gembong memiliki cita rasa yang khas dan banyak varian.', 30000.00, 135, 'products/1ABYJK8ABgKJ4vA3xIHiSyCZRoWK3cEkWZv7GoWz.jpg', 'active', 0, '2026-08-18 06:23:25', '2026-08-18 06:23:25'),
(20, 8, 5, 'Buku Cetak', 'buku-cetak-cbkfp', 'Buku cetak untuk semua kalangan.', 25000.00, 134, 'products/Cmy9126CchIjnH7Ev9uzocypLxcl0xZFbn06Bkfb.jpg', 'active', 0, '2026-08-18 06:28:25', '2026-08-18 06:28:25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `umkm_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL,
  `comment` text DEFAULT NULL,
  `status` enum('visible','hidden') NOT NULL DEFAULT 'visible',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `reviews`
--

INSERT INTO `reviews` (`id`, `order_id`, `product_id`, `umkm_id`, `user_id`, `rating`, `comment`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 2, 5, 'Kopinya enak banget, kekinian tapi tetap khas lokal. Pasti order lagi!', 'visible', '2026-08-12 14:44:13', '2026-08-12 14:44:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('i46XeRHMJBDjl3TeZLOgW52DBJC8QabbnlEZk63B', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVXQxTHUxS2RaQjBJcmhEUWhGSlhyZUxja2lKWWFZaWg2MzgwQUh5RSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fX0=', 1787034514),
('XaE1ygjdTVLZlErAYSPeEkKgjMPkoPUuE01NmzQ3', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSEU0dWdaNkNYNXB5NlhTUUwyeUo0Y2V2Y04zakFNNWsxWU9QbnpDVyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fX0=', 1787096721);

-- --------------------------------------------------------

--
-- Struktur dari tabel `umkm_profiles`
--

CREATE TABLE `umkm_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `opening_hours` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected','suspended') NOT NULL DEFAULT 'pending',
  `rating_avg` decimal(3,2) NOT NULL DEFAULT 0.00,
  `rating_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `umkm_profiles`
--

INSERT INTO `umkm_profiles` (`id`, `user_id`, `category_id`, `name`, `slug`, `description`, `logo`, `cover`, `phone`, `address`, `latitude`, `longitude`, `opening_hours`, `status`, `rating_avg`, `rating_count`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 'Kopi Senja', 'kopi-senja', 'Kedai kopi rumahan dengan biji kopi lokal pilihan dari petani sekitar.', 'logos/S3dpLGRdhjqQdMtOCne4n3T3sBhqT9b8zh6mj5qk.jpg', 'covers/iXEPVtAnChZY7pN2yU7xWalMPxOyL6gZLYREbA33.jpg', '081300000000', 'Jl. Contoh Raya No. 1, Bandar Lampung', -5.3971000, 105.2668000, '08.00 - 20.00 WIB (Senin - Sabtu)', 'approved', 5.00, 1, '2026-08-14 14:44:13', '2026-08-18 06:03:47'),
(2, 4, 2, 'Batik Rahayu', 'batik-rahayu', 'Produsen batik tulis dan cap khas daerah, diwariskan turun-temurun.', 'logos/xzJb6fAtUxr8KBd2DVKsR1Mu7qGJdTinOJgXt6nV.jpg', 'covers/EjTkrzKXp7a2bmikwsziIY8eGmqsmVpY3jVATsV6.jpg', '081300000001', 'Jl. Contoh Raya No. 2, Bandar Lampung', -5.3871000, 105.2768000, '08.00 - 20.00 WIB (Senin - Sabtu)', 'approved', 0.00, 0, '2026-08-14 14:44:13', '2026-08-18 06:08:11'),
(3, 5, 3, 'Kriya Anyaman Asri', 'kriya-anyaman-asri', 'Kerajinan anyaman bambu dan rotan ramah lingkungan.', 'logos/KxxfN22xXMzXrcROnjxSlSE5BKe4MYc7SAjdM78u.jpg', 'covers/ULKji4n0LHJMZh6l8I36h4s9xykuhp5b29ngk0mP.jpg', '081300000002', 'Jl. Contoh Raya No. 3, Bandar Lampung', -5.3771000, 105.2868000, '08.00 - 20.00 WIB (Senin - Sabtu)', 'approved', 0.00, 0, '2026-08-14 14:44:13', '2026-08-18 06:10:43'),
(4, 6, 4, 'Sabun Herbal Alami', 'sabun-herbal-alami', 'Sabun dan perawatan kulit berbahan herbal alami tanpa bahan kimia keras.', 'logos/4Z6m7bRg7dGxWQW7tu78DlKci077K5SL1xGWOLSN.jpg', 'covers/owktQdpjxK72lxSaXba0KBh1j9AQPnSiEVZRV03g.jpg', '081300000003', 'Jl. Contoh Raya No. 4, Bandar Lampung', -5.3671000, 105.2968000, '08.00 - 20.00 WIB (Senin - Sabtu)', 'approved', 0.00, 0, '2026-08-14 14:44:13', '2026-08-18 06:15:06'),
(5, 7, 5, 'Warung Nasi Ibu Sri', 'warung-nasi-ibu-sri', 'Warung makan rumahan dengan menu masakan rumahan khas nusantara.', 'logos/hmYXHd3XeEzjSYRIfGjeVNG7ZJyqW4ct1PGGAbIL.jpg', 'covers/kH2B2bIWsNePl5cwKgX457fNFGX6YJm2WQjIk0mK.jpg', '081300000004', 'Jl. Contoh Raya No. 5, Bandar Lampung', -5.3571000, 105.3068000, '08.00 - 20.00 WIB (Senin - Sabtu)', 'approved', 0.00, 0, '2026-08-14 14:44:13', '2026-08-18 06:17:48'),
(6, 8, 1, 'Toko Camilan Baru', 'toko-camilan-baru', 'UMKM baru yang baru saja mendaftar dan menunggu persetujuan admin.', 'logos/nhe46iF97wEfVGD47yySDA1PrVZmsJMaDHQX8IPx.jpg', 'covers/1BM8NvaSwdKlOCFNbsVSli01Gdt3p8kKQL56pSGL.jpg', '081300000099', 'Jl. Pendaftar Baru No. 9, Bandar Lampung', NULL, NULL, NULL, 'approved', 0.00, 0, '2026-08-14 14:44:13', '2026-08-18 06:20:56'),
(7, 15, 1, 'Mie Ayam Kondang', 'mie-ayam-kondang-ssJRV', 'Mie Ayam Kondang adalah tempat kuliner yang menyajikan mie ayam dengan cita rasa gurih, lezat, dan menggugah selera. Menggunakan bahan pilihan dan racikan bumbu yang khas, setiap porsi dibuat dengan penuh perhatian untuk memberikan rasa yang nikmat dan memuaskan.\r\n\r\nCocok untuk makan sendiri, bersama keluarga, maupun nongkrong bersama teman. Yuk, nikmati kelezatan Mie Ayam Kondang dan rasakan sendiri kenikmatannya! 🍜✨', 'logos/2CRgoNx6qjYWxVdU64ApMy8a6hqJ7hNsh1I7Nj3y.jpg', 'covers/4Xty6wgLR9AyQGjRrCkRyoFkip2K8rViBA74ylTT.jpg', '087467466657', 'Mie Ayam Kondang, V8JH+52W, Lapangan Kampus, Iringmulyo, Kec. Metro Tim., Kota Metro, Lampung 34124', -5.1193716, 105.3238818, '18.00 - 22.00 WIB (Setiap Hari)', 'approved', 0.00, 0, '2026-08-18 05:41:22', '2026-08-18 05:55:15'),
(8, 17, 5, 'Penebit Syukhira', 'penebit-syukhira-clDI8', 'Jasa penerbitan buku ISBN.', 'logos/M1AaHTRkG46m2LQecrkr1QNm5t3zxXAYAh9G9f0V.jpg', 'covers/GYzYb5C18lutG5nSP6Y5WF500kw3wwRrGpiNS8Rk.jpg', '088767635463', 'Metro - Lampung', -5.1194644, 105.3238951, '07.00 - 22.00 WIB (Setiap Hari)', 'approved', 0.00, 0, '2026-08-18 06:24:31', '2026-08-18 06:26:47');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('customer','umkm','admin') NOT NULL DEFAULT 'customer',
  `status` enum('active','suspended') NOT NULL DEFAULT 'active',
  `avatar` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `email_verified_at`, `password`, `role`, `status`, `avatar`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin LOKALIN', 'admin@lokalin.test', '081200000001', '2026-08-14 14:44:13', '$2y$10$2G30sJIs4WrtsT37gbynJODWoWEDFWbErg7WkvZvYi1E3Le4Ji1yW', 'admin', 'active', NULL, 'fQ0Bktl3gm9UC18SrV5a8zVwrsutYIGZkCi5LDvJNTHHF8t5y21OCtGOs8xO', '2026-08-14 14:44:13', '2026-08-14 14:44:13'),
(2, 'Budi Santoso', 'customer@lokalin.test', '088213536703', '2026-08-14 14:44:13', '$2y$10$2G30sJIs4WrtsT37gbynJODWoWEDFWbErg7WkvZvYi1E3Le4Ji1yW', 'customer', 'active', 'avatars/i3U0jFuuYqd447och09F98JyE2UIksODKRulUKuF.jpg', 'w4O5Kxr87D0uhedJ27w3YVf1Hwhq7jQTTkJGVif886cUVauR6GknbHFHg2Cm', '2026-08-14 14:44:13', '2026-08-18 05:39:53'),
(3, 'Kopi Senja (Pemilik)', 'umkm1@lokalin.test', '081300000000', '2026-08-14 14:44:13', '$2y$10$2G30sJIs4WrtsT37gbynJODWoWEDFWbErg7WkvZvYi1E3Le4Ji1yW', 'umkm', 'active', NULL, NULL, '2026-08-14 14:44:13', '2026-08-14 14:44:13'),
(4, 'Batik Rahayu (Pemilik)', 'umkm2@lokalin.test', '081300000001', '2026-08-14 14:44:13', '$2y$10$2G30sJIs4WrtsT37gbynJODWoWEDFWbErg7WkvZvYi1E3Le4Ji1yW', 'umkm', 'active', NULL, NULL, '2026-08-14 14:44:13', '2026-08-14 14:44:13'),
(5, 'Kriya Anyaman Asri (Pemilik)', 'umkm3@lokalin.test', '081300000002', '2026-08-14 14:44:13', '$2y$10$2G30sJIs4WrtsT37gbynJODWoWEDFWbErg7WkvZvYi1E3Le4Ji1yW', 'umkm', 'active', NULL, NULL, '2026-08-14 14:44:13', '2026-08-14 14:44:13'),
(6, 'Sabun Herbal Alami (Pemilik)', 'umkm4@lokalin.test', '081300000003', '2026-08-14 14:44:13', '$2y$10$2G30sJIs4WrtsT37gbynJODWoWEDFWbErg7WkvZvYi1E3Le4Ji1yW', 'umkm', 'active', NULL, NULL, '2026-08-14 14:44:13', '2026-08-14 14:44:13'),
(7, 'Warung Nasi Ibu Sri (Pemilik)', 'umkm5@lokalin.test', '081300000004', '2026-08-14 14:44:13', '$2y$10$2G30sJIs4WrtsT37gbynJODWoWEDFWbErg7WkvZvYi1E3Le4Ji1yW', 'umkm', 'active', NULL, NULL, '2026-08-14 14:44:13', '2026-08-14 14:44:13'),
(8, 'Toko Baru (Pemilik)', 'umkm-pending@lokalin.test', '081300000099', '2026-08-14 14:44:13', '$2y$10$2G30sJIs4WrtsT37gbynJODWoWEDFWbErg7WkvZvYi1E3Le4Ji1yW', 'umkm', 'active', NULL, NULL, '2026-08-14 14:44:13', '2026-08-14 14:44:13'),
(9, 'Siti Aminah', 'siti.aminah@example.test', '081400000001', '2026-08-14 14:44:13', '$2y$10$2G30sJIs4WrtsT37gbynJODWoWEDFWbErg7WkvZvYi1E3Le4Ji1yW', 'customer', 'active', NULL, NULL, '2026-08-14 14:44:13', '2026-08-14 14:44:13'),
(10, 'Andi Wijaya', 'andi.wijaya@example.test', '081400000002', '2026-08-14 14:44:13', '$2y$10$2G30sJIs4WrtsT37gbynJODWoWEDFWbErg7WkvZvYi1E3Le4Ji1yW', 'customer', 'active', NULL, NULL, '2026-08-14 14:44:13', '2026-08-14 14:44:13'),
(11, 'Dewi Lestari', 'dewi.lestari@example.test', '081400000003', '2026-08-14 14:44:13', '$2y$10$2G30sJIs4WrtsT37gbynJODWoWEDFWbErg7WkvZvYi1E3Le4Ji1yW', 'customer', 'active', NULL, NULL, '2026-08-14 14:44:13', '2026-08-14 14:44:13'),
(12, 'Rizky Pratama', 'rizky.pratama@example.test', '081400000004', '2026-08-14 14:44:13', '$2y$10$2G30sJIs4WrtsT37gbynJODWoWEDFWbErg7WkvZvYi1E3Le4Ji1yW', 'customer', 'active', NULL, NULL, '2026-08-14 14:44:13', '2026-08-14 14:44:13'),
(13, 'Putri Ayu', 'putri.ayu@example.test', '081400000005', '2026-08-14 14:44:13', '$2y$10$2G30sJIs4WrtsT37gbynJODWoWEDFWbErg7WkvZvYi1E3Le4Ji1yW', 'customer', 'active', NULL, NULL, '2026-08-14 14:44:13', '2026-08-18 05:48:54'),
(14, 'Ahmad Anwarul Iman Alfaqih', 'iman@lokalin.test', '088213536703', NULL, '$2y$12$gc0I3QF5SqO04TusmtM2y.mfytK8NB5Dt5riXpM0yNNh3A22SDpdy', 'customer', 'active', 'avatars/AUD4T4wFNMSBCyloQaLXuYEFz5mC6TWBsNixmrfI.jpg', NULL, '2026-08-18 05:40:35', '2026-08-18 05:40:50'),
(15, 'Mie Ayam Kondang', 'kondang1@lokalin.test', '087654456376', NULL, '$2y$12$EbcZ7hb.ibndhMg/fsi56.jss4shcnuvKLZeVNmYq2Ti7tYGQJw9K', 'umkm', 'active', NULL, NULL, '2026-08-18 05:41:22', '2026-08-18 05:41:22'),
(16, 'Yandri Utama', 'yandri@lokalin', '088998765534', NULL, '$2y$12$KbRFO5VSma81/eI73rXKvuuXg0d5WfUDOFrH6z6snw5.6pb2VrnSW', 'customer', 'active', NULL, NULL, '2026-08-18 05:48:03', '2026-08-18 05:48:03'),
(17, 'Penebit Syukhira', 'penerbit@lokalin.test', '088763533224', NULL, '$2y$12$kbrZL9xhcsE4faVqPau9LuSHqCORwPZF2bTVUBnKj0lx2vSxZ5UUe', 'umkm', 'active', NULL, NULL, '2026-08-18 06:24:31', '2026-08-18 06:24:31');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `ai_generations`
--
ALTER TABLE `ai_generations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ai_generations_umkm_id_foreign` (`umkm_id`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_user_id_foreign` (`user_id`),
  ADD KEY `carts_umkm_id_foreign` (`umkm_id`);

--
-- Indeks untuk tabel `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cart_items_cart_id_product_id_unique` (`cart_id`,`product_id`),
  ADD KEY `cart_items_product_id_foreign` (`product_id`);

--
-- Indeks untuk tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_is_read_index` (`user_id`,`is_read`);

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_umkm_id_status_index` (`umkm_id`,`status`),
  ADD KEY `orders_user_id_status_index` (`user_id`,`status`);

--
-- Indeks untuk tabel `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_umkm_id_slug_unique` (`umkm_id`,`slug`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_status_category_id_index` (`status`,`category_id`);

--
-- Indeks untuk tabel `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_product_id_foreign` (`product_id`);

--
-- Indeks untuk tabel `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reviews_order_id_product_id_unique` (`order_id`,`product_id`),
  ADD KEY `reviews_product_id_foreign` (`product_id`),
  ADD KEY `reviews_umkm_id_foreign` (`umkm_id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `umkm_profiles`
--
ALTER TABLE `umkm_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `umkm_profiles_slug_unique` (`slug`),
  ADD KEY `umkm_profiles_user_id_foreign` (`user_id`),
  ADD KEY `umkm_profiles_category_id_foreign` (`category_id`),
  ADD KEY `umkm_profiles_status_category_id_index` (`status`,`category_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_index` (`role`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `ai_generations`
--
ALTER TABLE `ai_generations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `umkm_profiles`
--
ALTER TABLE `umkm_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `ai_generations`
--
ALTER TABLE `ai_generations`
  ADD CONSTRAINT `ai_generations_umkm_id_foreign` FOREIGN KEY (`umkm_id`) REFERENCES `umkm_profiles` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_umkm_id_foreign` FOREIGN KEY (`umkm_id`) REFERENCES `umkm_profiles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_umkm_id_foreign` FOREIGN KEY (`umkm_id`) REFERENCES `umkm_profiles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_umkm_id_foreign` FOREIGN KEY (`umkm_id`) REFERENCES `umkm_profiles` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_umkm_id_foreign` FOREIGN KEY (`umkm_id`) REFERENCES `umkm_profiles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `umkm_profiles`
--
ALTER TABLE `umkm_profiles`
  ADD CONSTRAINT `umkm_profiles_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `umkm_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
