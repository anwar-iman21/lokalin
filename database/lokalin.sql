-- =====================================================================
-- LOKALIN - Database Dump Lengkap (Struktur + Data Demo)
-- Smart Digital Ecosystem for Local UMKM - iTechnoCup 2026
--
-- File ini adalah PENGGANTI dari perintah:
--   php artisan migrate --seed
--
-- CARA IMPORT (phpMyAdmin):
-- 1. Buat database kosong baru bernama: lokalin
-- 2. Buka database tersebut, klik tab "Import"
-- 3. Pilih file ini, lalu klik "Go" / "Kirim"
-- 4. Selesai - seluruh tabel dan data demo langsung terisi.
--
-- CARA IMPORT (CLI / terminal):
--   mysql -u root -p lokalin < lokalin.sql
--
-- Setelah import, LANGSUNG lanjut ke langkah composer install, .env,
-- npm install & build, lalu php artisan serve seperti biasa.
-- Anda TIDAK PERLU lagi menjalankan php artisan migrate atau
-- php artisan db:seed karena database sudah lengkap dari file ini.
-- =====================================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- ---------------------------------------------------------------------
-- Struktur tabel: users
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
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
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_role_index` (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- Struktur tabel: password_reset_tokens
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- Struktur tabel: sessions
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `payload` longtext NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- Struktur tabel: cache
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- Struktur tabel: jobs / job_batches / failed_jobs
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- Struktur tabel: categories
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- Struktur tabel: umkm_profiles
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `umkm_profiles`;
CREATE TABLE `umkm_profiles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `category_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text,
  `logo` varchar(255) DEFAULT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `opening_hours` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected','suspended') NOT NULL DEFAULT 'pending',
  `rating_avg` decimal(3,2) NOT NULL DEFAULT '0.00',
  `rating_count` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `umkm_profiles_slug_unique` (`slug`),
  KEY `umkm_profiles_user_id_foreign` (`user_id`),
  KEY `umkm_profiles_category_id_foreign` (`category_id`),
  KEY `umkm_profiles_status_category_id_index` (`status`,`category_id`),
  CONSTRAINT `umkm_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `umkm_profiles_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- Struktur tabel: products
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `umkm_id` bigint unsigned NOT NULL,
  `category_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text,
  `price` decimal(12,2) NOT NULL,
  `stock` int unsigned NOT NULL DEFAULT '0',
  `image` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `sold_count` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_umkm_id_slug_unique` (`umkm_id`,`slug`),
  KEY `products_category_id_foreign` (`category_id`),
  KEY `products_status_category_id_index` (`status`,`category_id`),
  CONSTRAINT `products_umkm_id_foreign` FOREIGN KEY (`umkm_id`) REFERENCES `umkm_profiles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- Struktur tabel: product_images
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `product_images`;
CREATE TABLE `product_images` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_images_product_id_foreign` (`product_id`),
  CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- Struktur tabel: carts
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `carts`;
CREATE TABLE `carts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `umkm_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `carts_user_id_foreign` (`user_id`),
  KEY `carts_umkm_id_foreign` (`umkm_id`),
  CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `carts_umkm_id_foreign` FOREIGN KEY (`umkm_id`) REFERENCES `umkm_profiles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- Struktur tabel: cart_items
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `cart_items`;
CREATE TABLE `cart_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `cart_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `quantity` int unsigned NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cart_items_cart_id_product_id_unique` (`cart_id`,`product_id`),
  KEY `cart_items_product_id_foreign` (`product_id`),
  CONSTRAINT `cart_items_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- Struktur tabel: orders
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_number` varchar(255) NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `umkm_id` bigint unsigned NOT NULL,
  `fulfillment_method` enum('delivery','pickup') NOT NULL,
  `status` enum('pending','confirmed','processing','ready','delivering','completed','cancelled') NOT NULL DEFAULT 'pending',
  `recipient_name` varchar(255) NOT NULL,
  `recipient_phone` varchar(255) NOT NULL,
  `address` text,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `delivery_note` text,
  `subtotal` decimal(12,2) NOT NULL DEFAULT '0.00',
  `total` decimal(12,2) NOT NULL DEFAULT '0.00',
  `confirmed_at` timestamp NULL DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `cancel_reason` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_order_number_unique` (`order_number`),
  KEY `orders_umkm_id_status_index` (`umkm_id`,`status`),
  KEY `orders_user_id_status_index` (`user_id`,`status`),
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `orders_umkm_id_foreign` FOREIGN KEY (`umkm_id`) REFERENCES `umkm_profiles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- Struktur tabel: order_items
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `order_items`;
CREATE TABLE `order_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `quantity` int unsigned NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_product_id_foreign` (`product_id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- Struktur tabel: reviews
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `reviews`;
CREATE TABLE `reviews` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `umkm_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `rating` tinyint unsigned NOT NULL,
  `comment` text,
  `status` enum('visible','hidden') NOT NULL DEFAULT 'visible',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `reviews_order_id_product_id_unique` (`order_id`,`product_id`),
  KEY `reviews_product_id_foreign` (`product_id`),
  KEY `reviews_umkm_id_foreign` (`umkm_id`),
  KEY `reviews_user_id_foreign` (`user_id`),
  CONSTRAINT `reviews_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reviews_umkm_id_foreign` FOREIGN KEY (`umkm_id`) REFERENCES `umkm_profiles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- Struktur tabel: ai_generations
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `ai_generations`;
CREATE TABLE `ai_generations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `umkm_id` bigint unsigned NOT NULL,
  `type` enum('caption','content_idea','description','promotion_strategy') NOT NULL,
  `input` json DEFAULT NULL,
  `output` longtext,
  `is_fallback` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ai_generations_umkm_id_foreign` (`umkm_id`),
  CONSTRAINT `ai_generations_umkm_id_foreign` FOREIGN KEY (`umkm_id`) REFERENCES `umkm_profiles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- Struktur tabel: notifications
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_user_id_is_read_index` (`user_id`,`is_read`),
  CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- Struktur tabel: activity_logs
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `activity_logs`;
CREATE TABLE `activity_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_logs_user_id_foreign` (`user_id`),
  CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- Struktur tabel: migrations (agar Laravel tahu semua migration
-- "sudah dijalankan" dan tidak mencoba membuat ulang tabel di atas)
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_reset_tokens_table', 1),
('2019_08_19_000000_create_sessions_table', 1),
('2019_12_14_000001_create_cache_table', 1),
('2019_12_14_000002_create_jobs_table', 1),
('2024_01_01_000010_create_categories_table', 1),
('2024_01_01_000020_create_umkm_profiles_table', 1),
('2024_01_01_000030_create_products_table', 1),
('2024_01_01_000031_create_product_images_table', 1),
('2024_01_01_000040_create_carts_table', 1),
('2024_01_01_000041_create_cart_items_table', 1),
('2024_01_01_000050_create_orders_table', 1),
('2024_01_01_000051_create_order_items_table', 1),
('2024_01_01_000060_create_reviews_table', 1),
('2024_01_01_000070_create_ai_generations_table', 1),
('2024_01_01_000080_create_notifications_table', 1),
('2024_01_01_000090_create_activity_logs_table', 1);

-- =====================================================================
-- DATA DEMO (setara hasil php artisan db:seed)
-- =====================================================================

-- ---------------------------------------------------------------------
-- Data: categories
-- ---------------------------------------------------------------------
INSERT INTO `categories` (`id`, `name`, `slug`, `icon`, `created_at`, `updated_at`) VALUES
(1, 'Makanan & Minuman', 'makanan-minuman', '🍔', NOW(), NOW()),
(2, 'Fashion & Aksesoris', 'fashion-aksesoris', '👗', NOW(), NOW()),
(3, 'Kerajinan Tangan', 'kerajinan-tangan', '🧶', NOW(), NOW()),
(4, 'Kecantikan & Perawatan', 'kecantikan-perawatan', '💄', NOW(), NOW()),
(5, 'Jasa & Layanan', 'jasa-layanan', '🛠️', NOW(), NOW()),
(6, 'Pertanian & Sembako', 'pertanian-sembako', '🌾', NOW(), NOW());

-- ---------------------------------------------------------------------
-- Data: users
-- Semua akun demo memakai password: password
-- (hash bcrypt di bawah adalah hasil asli Hash::make('password') Laravel)
-- ---------------------------------------------------------------------
INSERT INTO `users` (`id`, `name`, `email`, `phone`, `email_verified_at`, `password`, `role`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Admin LOKALIN', 'admin@lokalin.test', '081200000001', NOW(), '$2y$10$2G30sJIs4WrtsT37gbynJODWoWEDFWbErg7WkvZvYi1E3Le4Ji1yW', 'admin', 'active', NOW(), NOW()),
(2, 'Budi Santoso', 'customer@lokalin.test', '081200000002', NOW(), '$2y$10$2G30sJIs4WrtsT37gbynJODWoWEDFWbErg7WkvZvYi1E3Le4Ji1yW', 'customer', 'active', NOW(), NOW()),
(3, 'Kopi Senja (Pemilik)', 'umkm1@lokalin.test', '081300000000', NOW(), '$2y$10$2G30sJIs4WrtsT37gbynJODWoWEDFWbErg7WkvZvYi1E3Le4Ji1yW', 'umkm', 'active', NOW(), NOW()),
(4, 'Batik Rahayu (Pemilik)', 'umkm2@lokalin.test', '081300000001', NOW(), '$2y$10$2G30sJIs4WrtsT37gbynJODWoWEDFWbErg7WkvZvYi1E3Le4Ji1yW', 'umkm', 'active', NOW(), NOW()),
(5, 'Kriya Anyaman Asri (Pemilik)', 'umkm3@lokalin.test', '081300000002', NOW(), '$2y$10$2G30sJIs4WrtsT37gbynJODWoWEDFWbErg7WkvZvYi1E3Le4Ji1yW', 'umkm', 'active', NOW(), NOW()),
(6, 'Sabun Herbal Alami (Pemilik)', 'umkm4@lokalin.test', '081300000003', NOW(), '$2y$10$2G30sJIs4WrtsT37gbynJODWoWEDFWbErg7WkvZvYi1E3Le4Ji1yW', 'umkm', 'active', NOW(), NOW()),
(7, 'Warung Nasi Ibu Sri (Pemilik)', 'umkm5@lokalin.test', '081300000004', NOW(), '$2y$10$2G30sJIs4WrtsT37gbynJODWoWEDFWbErg7WkvZvYi1E3Le4Ji1yW', 'umkm', 'active', NOW(), NOW()),
(8, 'Toko Baru (Pemilik)', 'umkm-pending@lokalin.test', '081300000099', NOW(), '$2y$10$2G30sJIs4WrtsT37gbynJODWoWEDFWbErg7WkvZvYi1E3Le4Ji1yW', 'umkm', 'active', NOW(), NOW()),
(9, 'Siti Aminah', 'siti.aminah@example.test', '081400000001', NOW(), '$2y$10$2G30sJIs4WrtsT37gbynJODWoWEDFWbErg7WkvZvYi1E3Le4Ji1yW', 'customer', 'active', NOW(), NOW()),
(10, 'Andi Wijaya', 'andi.wijaya@example.test', '081400000002', NOW(), '$2y$10$2G30sJIs4WrtsT37gbynJODWoWEDFWbErg7WkvZvYi1E3Le4Ji1yW', 'customer', 'active', NOW(), NOW()),
(11, 'Dewi Lestari', 'dewi.lestari@example.test', '081400000003', NOW(), '$2y$10$2G30sJIs4WrtsT37gbynJODWoWEDFWbErg7WkvZvYi1E3Le4Ji1yW', 'customer', 'active', NOW(), NOW()),
(12, 'Rizky Pratama', 'rizky.pratama@example.test', '081400000004', NOW(), '$2y$10$2G30sJIs4WrtsT37gbynJODWoWEDFWbErg7WkvZvYi1E3Le4Ji1yW', 'customer', 'active', NOW(), NOW()),
(13, 'Putri Ayu', 'putri.ayu@example.test', '081400000005', NOW(), '$2y$10$2G30sJIs4WrtsT37gbynJODWoWEDFWbErg7WkvZvYi1E3Le4Ji1yW', 'customer', 'active', NOW(), NOW());

-- ---------------------------------------------------------------------
-- Data: carts (setiap customer otomatis punya 1 keranjang kosong)
-- ---------------------------------------------------------------------
INSERT INTO `carts` (`id`, `user_id`, `umkm_id`, `created_at`, `updated_at`) VALUES
(1, 2, NULL, NOW(), NOW()),
(2, 9, NULL, NOW(), NOW()),
(3, 10, NULL, NOW(), NOW()),
(4, 11, NULL, NOW(), NOW()),
(5, 12, NULL, NOW(), NOW()),
(6, 13, NULL, NOW(), NOW());

-- ---------------------------------------------------------------------
-- Data: umkm_profiles
-- ---------------------------------------------------------------------
INSERT INTO `umkm_profiles` (`id`, `user_id`, `category_id`, `name`, `slug`, `description`, `phone`, `address`, `latitude`, `longitude`, `opening_hours`, `status`, `rating_avg`, `rating_count`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 'Kopi Senja', 'kopi-senja', 'Kedai kopi rumahan dengan biji kopi lokal pilihan dari petani sekitar.', '081300000000', 'Jl. Contoh Raya No. 1, Bandar Lampung', -5.3971000, 105.2668000, '08.00 - 20.00 WIB (Senin - Sabtu)', 'approved', 5.00, 1, NOW(), NOW()),
(2, 4, 2, 'Batik Rahayu', 'batik-rahayu', 'Produsen batik tulis dan cap khas daerah, diwariskan turun-temurun.', '081300000001', 'Jl. Contoh Raya No. 2, Bandar Lampung', -5.3871000, 105.2768000, '08.00 - 20.00 WIB (Senin - Sabtu)', 'approved', 0.00, 0, NOW(), NOW()),
(3, 5, 3, 'Kriya Anyaman Asri', 'kriya-anyaman-asri', 'Kerajinan anyaman bambu dan rotan ramah lingkungan.', '081300000002', 'Jl. Contoh Raya No. 3, Bandar Lampung', -5.3771000, 105.2868000, '08.00 - 20.00 WIB (Senin - Sabtu)', 'approved', 0.00, 0, NOW(), NOW()),
(4, 6, 4, 'Sabun Herbal Alami', 'sabun-herbal-alami', 'Sabun dan perawatan kulit berbahan herbal alami tanpa bahan kimia keras.', '081300000003', 'Jl. Contoh Raya No. 4, Bandar Lampung', -5.3671000, 105.2968000, '08.00 - 20.00 WIB (Senin - Sabtu)', 'approved', 0.00, 0, NOW(), NOW()),
(5, 7, 5, 'Warung Nasi Ibu Sri', 'warung-nasi-ibu-sri', 'Warung makan rumahan dengan menu masakan rumahan khas nusantara.', '081300000004', 'Jl. Contoh Raya No. 5, Bandar Lampung', -5.3571000, 105.3068000, '08.00 - 20.00 WIB (Senin - Sabtu)', 'approved', 0.00, 0, NOW(), NOW()),
(6, 8, 1, 'Toko Camilan Baru', 'toko-camilan-baru', 'UMKM baru yang baru saja mendaftar dan menunggu persetujuan admin.', '081300000099', 'Jl. Pendaftar Baru No. 9, Bandar Lampung', NULL, NULL, NULL, 'pending', 0.00, 0, NOW(), NOW());


-- ---------------------------------------------------------------------
-- Data: products
-- ---------------------------------------------------------------------
INSERT INTO `products` (`id`, `umkm_id`, `category_id`, `name`, `slug`, `description`, `price`, `stock`, `status`, `sold_count`, `created_at`, `updated_at`) VALUES
-- Kopi Senja (umkm_id = 1)
(1, 1, 1, 'Kopi Susu Gula Aren', 'kopi-susu-gula-aren', 'Produk unggulan dari Kopi Senja. Dibuat dengan bahan berkualitas dan penuh perhatian pada detail.', 18000.00, 35, 'active', 24, NOW(), NOW()),
(2, 1, 1, 'Americano Dingin', 'americano-dingin', 'Produk unggulan dari Kopi Senja. Dibuat dengan bahan berkualitas dan penuh perhatian pada detail.', 15000.00, 40, 'active', 18, NOW(), NOW()),
(3, 1, 1, 'Kopi Tubruk Original', 'kopi-tubruk-original', 'Produk unggulan dari Kopi Senja. Dibuat dengan bahan berkualitas dan penuh perhatian pada detail.', 12000.00, 50, 'active', 12, NOW(), NOW()),
(4, 1, 1, 'Roti Bakar Cokelat Keju', 'roti-bakar-cokelat-keju', 'Produk unggulan dari Kopi Senja. Dibuat dengan bahan berkualitas dan penuh perhatian pada detail.', 16000.00, 20, 'active', 9, NOW(), NOW()),
-- Batik Rahayu (umkm_id = 2)
(5, 2, 2, 'Kain Batik Tulis Motif Parang', 'kain-batik-tulis-motif-parang', 'Produk unggulan dari Batik Rahayu. Dibuat dengan bahan berkualitas dan penuh perhatian pada detail.', 250000.00, 15, 'active', 7, NOW(), NOW()),
(6, 2, 2, 'Kemeja Batik Pria Lengan Panjang', 'kemeja-batik-pria-lengan-panjang', 'Produk unggulan dari Batik Rahayu. Dibuat dengan bahan berkualitas dan penuh perhatian pada detail.', 175000.00, 18, 'active', 11, NOW(), NOW()),
(7, 2, 2, 'Dress Batik Wanita', 'dress-batik-wanita', 'Produk unggulan dari Batik Rahayu. Dibuat dengan bahan berkualitas dan penuh perhatian pada detail.', 210000.00, 12, 'active', 5, NOW(), NOW()),
-- Kriya Anyaman Asri (umkm_id = 3)
(8, 3, 3, 'Tas Anyaman Rotan', 'tas-anyaman-rotan', 'Produk unggulan dari Kriya Anyaman Asri. Dibuat dengan bahan berkualitas dan penuh perhatian pada detail.', 95000.00, 22, 'active', 14, NOW(), NOW()),
(9, 3, 3, 'Tempat Tisu Bambu', 'tempat-tisu-bambu', 'Produk unggulan dari Kriya Anyaman Asri. Dibuat dengan bahan berkualitas dan penuh perhatian pada detail.', 35000.00, 30, 'active', 8, NOW(), NOW()),
(10, 3, 3, 'Keranjang Piknik Anyaman', 'keranjang-piknik-anyaman', 'Produk unggulan dari Kriya Anyaman Asri. Dibuat dengan bahan berkualitas dan penuh perhatian pada detail.', 120000.00, 10, 'active', 3, NOW(), NOW()),
-- Sabun Herbal Alami (umkm_id = 4)
(11, 4, 4, 'Sabun Batang Lidah Buaya', 'sabun-batang-lidah-buaya', 'Produk unggulan dari Sabun Herbal Alami. Dibuat dengan bahan berkualitas dan penuh perhatian pada detail.', 22000.00, 45, 'active', 20, NOW(), NOW()),
(12, 4, 4, 'Sabun Cair Sereh Wangi', 'sabun-cair-sereh-wangi', 'Produk unggulan dari Sabun Herbal Alami. Dibuat dengan bahan berkualitas dan penuh perhatian pada detail.', 28000.00, 33, 'active', 16, NOW(), NOW()),
(13, 4, 4, 'Lulur Tradisional Rempah', 'lulur-tradisional-rempah', 'Produk unggulan dari Sabun Herbal Alami. Dibuat dengan bahan berkualitas dan penuh perhatian pada detail.', 30000.00, 25, 'active', 10, NOW(), NOW()),
-- Warung Nasi Ibu Sri (umkm_id = 5)
(14, 5, 5, 'Nasi Ayam Geprek', 'nasi-ayam-geprek', 'Produk unggulan dari Warung Nasi Ibu Sri. Dibuat dengan bahan berkualitas dan penuh perhatian pada detail.', 15000.00, 40, 'active', 31, NOW(), NOW()),
(15, 5, 5, 'Nasi Rendang', 'nasi-rendang', 'Produk unggulan dari Warung Nasi Ibu Sri. Dibuat dengan bahan berkualitas dan penuh perhatian pada detail.', 20000.00, 35, 'active', 27, NOW(), NOW()),
(16, 5, 5, 'Sayur Lodeh + Tempe', 'sayur-lodeh-tempe', 'Produk unggulan dari Warung Nasi Ibu Sri. Dibuat dengan bahan berkualitas dan penuh perhatian pada detail.', 10000.00, 30, 'active', 19, NOW(), NOW()),
(17, 5, 5, 'Es Teh Manis', 'es-teh-manis', 'Produk unggulan dari Warung Nasi Ibu Sri. Dibuat dengan bahan berkualitas dan penuh perhatian pada detail.', 5000.00, 60, 'active', 42, NOW(), NOW());

-- ---------------------------------------------------------------------
-- Data: orders (2 contoh pesanan demo dari Budi Santoso ke Kopi Senja)
-- ---------------------------------------------------------------------
INSERT INTO `orders` (`id`, `order_number`, `user_id`, `umkm_id`, `fulfillment_method`, `status`, `recipient_name`, `recipient_phone`, `address`, `latitude`, `longitude`, `delivery_note`, `subtotal`, `total`, `confirmed_at`, `completed_at`, `created_at`, `updated_at`) VALUES
(1, 'LKN-DEMO-COMPLETED', 2, 1, 'pickup', 'completed', 'Budi Santoso', '081200000002', NULL, NULL, NULL, NULL, 36000.00, 36000.00, DATE_SUB(NOW(), INTERVAL 3 DAY), DATE_SUB(NOW(), INTERVAL 2 DAY), DATE_SUB(NOW(), INTERVAL 3 DAY), DATE_SUB(NOW(), INTERVAL 2 DAY)),
(2, 'LKN-DEMO-PENDING', 2, 1, 'delivery', 'pending', 'Budi Santoso', '081200000002', 'Jl. Demo Pengantaran No. 1, Bandar Lampung', -5.3971000, 105.2668000, 'Tolong tanpa gula tambahan, terima kasih.', 18000.00, 18000.00, NULL, NULL, NOW(), NOW());

-- ---------------------------------------------------------------------
-- Data: order_items
-- ---------------------------------------------------------------------
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `price`, `quantity`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Kopi Susu Gula Aren', 18000.00, 2, 36000.00, DATE_SUB(NOW(), INTERVAL 3 DAY), DATE_SUB(NOW(), INTERVAL 3 DAY)),
(2, 2, 1, 'Kopi Susu Gula Aren', 18000.00, 1, 18000.00, NOW(), NOW());

-- ---------------------------------------------------------------------
-- Data: reviews (ulasan untuk pesanan yang sudah completed)
-- ---------------------------------------------------------------------
INSERT INTO `reviews` (`id`, `order_id`, `product_id`, `umkm_id`, `user_id`, `rating`, `comment`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 2, 5, 'Kopinya enak banget, kekinian tapi tetap khas lokal. Pasti order lagi!', 'visible', DATE_SUB(NOW(), INTERVAL 2 DAY), DATE_SUB(NOW(), INTERVAL 2 DAY));

-- ---------------------------------------------------------------------
-- Sinkronkan AUTO_INCREMENT agar data baru yang ditambahkan lewat
-- aplikasi (setelah import) melanjutkan dari ID berikutnya, bukan
-- mulai dari 1 lagi / bentrok dengan data demo di atas.
-- ---------------------------------------------------------------------
ALTER TABLE `categories` AUTO_INCREMENT = 7;
ALTER TABLE `users` AUTO_INCREMENT = 14;
ALTER TABLE `carts` AUTO_INCREMENT = 7;
ALTER TABLE `umkm_profiles` AUTO_INCREMENT = 7;
ALTER TABLE `products` AUTO_INCREMENT = 18;
ALTER TABLE `orders` AUTO_INCREMENT = 3;
ALTER TABLE `order_items` AUTO_INCREMENT = 3;
ALTER TABLE `reviews` AUTO_INCREMENT = 2;

SET FOREIGN_KEY_CHECKS = 1;

-- =====================================================================
-- SELESAI. Database "lokalin" siap dipakai.
--
-- Akun demo (semua password: password):
--   Admin      : admin@lokalin.test
--   Pelanggan  : customer@lokalin.test
--   UMKM       : umkm1@lokalin.test s/d umkm5@lokalin.test
--   UMKM (pending, untuk demo approval admin) : umkm-pending@lokalin.test
-- =====================================================================
