-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 22 Jun 2022 pada 13.20
-- Versi server: 5.7.33
-- Versi PHP: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `skripsi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(10) UNSIGNED NOT NULL,
  `nama_kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `created_at`, `updated_at`) VALUES
(1, 'Minuman', '2021-12-06 09:52:40', '2022-05-18 18:57:18'),
(2, 'Alat Mandi', '2021-12-06 09:52:44', '2021-12-06 09:52:44'),
(4, 'Jajanan', '2021-12-06 09:53:00', '2021-12-06 09:53:00'),
(13, 'Bumbu Dapur', '2021-12-08 21:53:07', '2021-12-08 21:53:07'),
(14, 'Makanan', '2022-05-18 06:27:31', '2022-05-18 06:27:31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `merk`
--

CREATE TABLE `merk` (
  `id_merk` int(10) UNSIGNED NOT NULL,
  `nama_merk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `merk`
--

INSERT INTO `merk` (`id_merk`, `nama_merk`, `created_at`, `updated_at`) VALUES
(1, 'Pocary Sweat', '2021-12-06 09:53:35', '2021-12-06 09:53:35'),
(2, 'Aqua', '2021-12-06 09:53:40', '2021-12-06 09:53:40'),
(3, 'Djarum Super', '2021-12-06 09:53:45', '2021-12-06 09:53:45'),
(4, 'Sidu', '2021-12-06 09:53:49', '2021-12-06 09:53:49'),
(6, 'Pepsodent', '2021-12-06 09:53:57', '2021-12-06 09:53:57'),
(7, 'Tanggo', '2021-12-08 10:31:13', '2021-12-08 10:31:13'),
(39, 'Indomie', '2021-12-08 22:17:00', '2021-12-08 22:17:00'),
(40, 'Closeup', '2021-12-24 08:33:03', '2021-12-24 08:33:03'),
(43, 'Gudang garam', '2021-12-24 09:59:21', '2021-12-24 09:59:21'),
(45, 'Masako', '2022-05-18 19:00:42', '2022-05-18 19:00:42'),
(46, 'coffee mix', '2022-05-29 22:44:24', '2022-05-29 22:44:24'),
(47, 'ABC', '2022-05-30 01:35:16', '2022-05-30 01:35:16'),
(48, 'Kapal Api', '2022-05-30 01:36:34', '2022-05-30 01:36:34');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2021_08_04_161430_add_column_to_users_table', 1),
(7, '2021_08_04_162214_create_kategori_table', 1),
(8, '2021_08_04_182124_create_produk_table', 1),
(9, '2021_08_05_010422_create_supplier_table', 1),
(10, '2021_08_05_010656_create_pembelian_table', 1),
(11, '2021_08_05_010719_create_pembelian_detail_table', 1),
(12, '2021_08_05_010736_create_penjualan_table', 1),
(13, '2021_08_05_010746_create_penjualan_detail_table', 1),
(14, '2021_08_05_010802_create_setting_table', 1),
(15, '2021_08_05_012538_create_pengeluaran_table', 1),
(16, '2021_08_07_081254_create_sessions_table', 1),
(17, '2021_09_05_151831_tambah_foreign_key_to_produk_table', 1),
(18, '2021_12_06_153503_create_merk_table', 1),
(19, '2021_12_06_165031_tambah_id_merk_to_produk_table', 1),
(21, '2021_12_08_185245_kode_produk_add_to_produk_table', 2),
(23, '2021_12_10_112403_alamat_add_to_supplier_table', 3),
(25, '2021_12_24_140628_create_stock_table', 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembelian`
--

CREATE TABLE `pembelian` (
  `id_pembelian` int(10) UNSIGNED NOT NULL,
  `id_supplier` int(11) NOT NULL,
  `total_item` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `bayar` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pembelian`
--

INSERT INTO `pembelian` (`id_pembelian`, `id_supplier`, `total_item`, `total_harga`, `bayar`, `created_at`, `updated_at`) VALUES
(1, 1, 10, 130000, 130000, '2022-04-18 10:19:35', '2022-04-18 10:26:44'),
(7, 1, 5, 30000, 30000, '2022-04-18 12:09:47', '2022-04-18 12:10:14'),
(8, 1, 10, 50000, 50000, '2022-05-12 09:37:07', '2022-05-12 09:37:40'),
(11, 1, 10, 25000, 25000, '2022-06-17 23:43:38', '2022-06-17 23:47:40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembelian_detail`
--

CREATE TABLE `pembelian_detail` (
  `id_pembelian_detail` int(10) UNSIGNED NOT NULL,
  `id_pembelian` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pembelian_detail`
--

INSERT INTO `pembelian_detail` (`id_pembelian_detail`, `id_pembelian`, `id_produk`, `harga_beli`, `jumlah`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 13000, 10, 130000, '2022-04-18 10:19:40', '2022-04-18 10:26:28'),
(7, 7, 3, 6000, 5, 30000, '2022-04-18 12:09:56', '2022-04-18 12:10:12'),
(8, 8, 2, 5000, 10, 50000, '2022-05-12 09:37:14', '2022-05-12 09:37:37'),
(11, 11, 9, 2500, 10, 25000, '2022-06-17 23:43:58', '2022-06-17 23:44:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengeluaran`
--

CREATE TABLE `pengeluaran` (
  `id_pengeluaran` int(10) UNSIGNED NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `nominal` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan`
--

CREATE TABLE `penjualan` (
  `id_penjualan` int(10) UNSIGNED NOT NULL,
  `total_item` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `bayar` int(11) NOT NULL DEFAULT '0',
  `diterima` int(11) NOT NULL DEFAULT '0',
  `id_user` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `penjualan`
--

INSERT INTO `penjualan` (`id_penjualan`, `total_item`, `total_harga`, `bayar`, `diterima`, `id_user`, `created_at`, `updated_at`) VALUES
(1, 1, 14000, 14000, 14000, 1, '2022-04-18 10:26:54', '2022-04-18 10:27:15'),
(2, 1, 14000, 14000, 14000, 1, '2022-04-18 10:28:48', '2022-04-18 10:28:56'),
(3, 1, 7000, 7000, 10000, 1, '2022-04-18 10:32:28', '2022-04-18 10:32:51'),
(6, 15, 130000, 130000, 150000, 2, '2022-04-18 11:54:46', '2022-04-18 12:03:29'),
(16, 5, 35000, 35000, 35000, 1, '2022-04-18 12:36:26', '2022-04-18 12:36:45'),
(23, 5, 25000, 25000, 30000, 1, '2022-04-30 12:04:09', '2022-04-30 12:16:10'),
(24, 12, 88000, 88000, 100000, 1, '2022-05-16 14:30:08', '2022-05-16 14:30:42'),
(27, 4, 24000, 24000, 50000, 1, '2022-05-16 14:33:41', '2022-05-16 14:56:18'),
(29, 1, 7000, 7000, 10000, 1, '2022-05-18 05:33:32', '2022-05-18 05:33:44'),
(31, 2, 12000, 12000, 12000, 1, '2022-05-18 05:52:25', '2022-05-18 05:53:01'),
(32, 1, 6000, 6000, 6000, 1, '2022-05-18 05:56:05', '2022-05-18 05:57:01'),
(33, 1, 6000, 6000, 6000, 1, '2022-05-18 05:59:12', '2022-05-18 05:59:20'),
(40, 2, 20000, 20000, 20000, 1, '2022-05-18 19:07:02', '2022-05-18 19:07:15'),
(45, 30, 180000, 180000, 200000, 1, '2022-05-30 00:16:25', '2022-05-30 00:16:46'),
(46, 11, 80000, 80000, 100000, 1, '2022-05-30 01:37:03', '2022-05-30 01:37:50'),
(49, 3, 9000, 9000, 10000, 1, '2022-05-30 01:41:14', '2022-05-30 01:41:28'),
(50, 2, 14000, 14000, 20000, 1, '2022-05-30 04:54:18', '2022-05-30 04:55:11'),
(51, 3, 22000, 22000, 25000, 1, '2022-05-30 04:55:14', '2022-05-30 05:00:48'),
(53, 4, 16000, 16000, 20000, 1, '2022-06-05 06:44:49', '2022-06-05 06:45:14'),
(54, 2, 10000, 10000, 10000, 1, '2022-06-14 00:18:46', '2022-06-14 00:19:08'),
(55, 1, 5000, 5000, 5000, 1, '2022-06-14 00:19:26', '2022-06-14 00:19:46'),
(56, 3, 18000, 18000, 18000, 1, '2022-06-14 00:19:53', '2022-06-14 00:20:20'),
(58, 1, 5000, 5000, 5000, 3, '2022-06-15 20:28:43', '2022-06-15 20:29:07'),
(59, 2, 6000, 6000, 10000, 3, '2022-06-15 20:29:14', '2022-06-15 20:29:31'),
(61, 2, 8000, 8000, 10000, 2, '2022-06-16 19:32:50', '2022-06-16 19:33:21'),
(62, 20, 60000, 60000, 60000, 1, '2022-06-17 23:37:34', '2022-06-17 23:37:49'),
(63, 0, 0, 0, 0, 1, '2022-06-17 23:47:53', '2022-06-17 23:47:53');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan_detail`
--

CREATE TABLE `penjualan_detail` (
  `id_penjualan_detail` int(10) UNSIGNED NOT NULL,
  `id_penjualan` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `harga_beli` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `keuntungan` int(255) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `penjualan_detail`
--

INSERT INTO `penjualan_detail` (`id_penjualan_detail`, `id_penjualan`, `id_produk`, `harga_beli`, `harga_jual`, `keuntungan`, `jumlah`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 4, '12000', 14000, 2000, 1, 14000, '2022-04-18 10:27:05', '2022-04-18 10:27:05'),
(2, 2, 4, '12000', 14000, 2000, 1, 14000, '2022-04-18 10:28:52', '2022-04-18 10:28:52'),
(4, 6, 3, '5000', 6000, 10000, 10, 60000, '2022-04-18 11:54:48', '2022-04-18 12:02:34'),
(5, 6, 4, '13000', 14000, 5000, 5, 70000, '2022-04-18 12:02:41', '2022-04-18 12:02:46'),
(13, 16, 3, '5000', 7000, 10000, 5, 35000, '2022-04-18 12:36:29', '2022-04-18 12:36:32'),
(15, 23, 2, '4000', 5000, 5000, 5, 25000, '2022-04-30 12:15:06', '2022-04-30 12:15:23'),
(16, 24, 4, '13000', 14000, 2000, 2, 28000, '2022-05-16 14:30:15', '2022-05-16 14:30:24'),
(17, 24, 2, '4000', 6000, 20000, 10, 60000, '2022-05-16 14:30:30', '2022-05-16 14:30:35'),
(18, 27, 2, '5000', 6000, 4000, 4, 24000, '2022-05-16 14:54:27', '2022-05-16 14:54:36'),
(19, 29, 3, '6000', 7000, 1000, 1, 7000, '2022-05-18 05:33:37', '2022-05-18 05:33:37'),
(20, 31, 2, '5000', 6000, 2000, 2, 12000, '2022-05-18 05:52:29', '2022-05-18 05:52:33'),
(21, 32, 2, '5000', 6000, 1000, 1, 6000, '2022-05-18 05:56:08', '2022-05-18 05:56:08'),
(22, 33, 2, '5000', 6000, 1000, 1, 6000, '2022-05-18 05:59:15', '2022-05-18 05:59:15'),
(27, 40, 4, '13000', 14000, 1000, 1, 14000, '2022-05-18 19:07:06', '2022-05-18 19:07:06'),
(28, 40, 2, '5000', 6000, 1000, 1, 6000, '2022-05-18 19:07:09', '2022-05-18 19:07:09'),
(38, 45, 2, '5000', 6000, 30000, 30, 180000, '2022-05-30 00:16:29', '2022-05-30 00:16:35'),
(39, 46, 7, '4600', 5000, 1200, 3, 15000, '2022-05-30 01:37:08', '2022-05-30 01:37:11'),
(40, 46, 9, '2500', 3000, 500, 1, 3000, '2022-05-30 01:37:15', '2022-05-30 01:37:15'),
(41, 46, 8, '9500', 10000, 2500, 5, 50000, '2022-05-30 01:37:26', '2022-05-30 01:37:29'),
(42, 46, 2, '5000', 6000, 2000, 2, 12000, '2022-05-30 01:37:33', '2022-05-30 01:37:36'),
(46, 49, 6, '2300', 3000, 2100, 3, 9000, '2022-05-30 01:41:17', '2022-05-30 01:41:22'),
(47, 50, 3, '6000', 7000, 1658880000, 2, 14000, '2022-05-30 04:54:22', '2022-05-30 04:54:42'),
(48, 51, 8, '9500', 10000, 1500, 1, 10000, '2022-05-30 04:56:42', '2022-05-30 04:56:57'),
(49, 51, 2, '5000', 6000, 2000, 2, 12000, '2022-05-30 04:57:01', '2022-05-30 04:57:04'),
(50, 53, 7, '4600', 5000, 800, 2, 10000, '2022-06-05 06:44:54', '2022-06-05 06:44:59'),
(51, 53, 9, '2500', 3000, 1000, 2, 6000, '2022-06-05 06:45:02', '2022-06-05 06:45:06'),
(52, 54, 3, '6000', 7000, 5000, 1, 7000, '2022-06-14 00:18:51', '2022-06-14 00:18:58'),
(53, 54, 9, '2500', 3000, 500, 1, 3000, '2022-06-14 00:19:01', '2022-06-14 00:19:01'),
(54, 55, 7, '4600', 5000, 400, 1, 5000, '2022-06-14 00:19:34', '2022-06-14 00:19:34'),
(55, 56, 2, '5000', 6000, 18000, 3, 18000, '2022-06-14 00:19:58', '2022-06-14 00:20:08'),
(56, 58, 7, '4600', 5000, 400, 1, 5000, '2022-06-15 20:29:02', '2022-06-15 20:29:02'),
(57, 59, 9, '2500', 3000, 1000, 2, 6000, '2022-06-15 20:29:19', '2022-06-15 20:29:25'),
(59, 61, 7, '4600', 5000, 400, 1, 5000, '2022-06-16 19:33:14', '2022-06-16 19:33:14'),
(60, 61, 9, '2500', 3000, 500, 1, 3000, '2022-06-16 19:33:17', '2022-06-16 19:33:17'),
(61, 62, 9, '2500', 3000, 10000, 20, 60000, '2022-06-17 23:37:39', '2022-06-17 23:37:43'),
(62, 63, 3, '6000', 7000, 1000, 1, 7000, '2022-06-17 23:47:58', '2022-06-17 23:47:58'),
(63, 63, 8, '9500', 10000, 500, 1, 10000, '2022-06-17 23:48:32', '2022-06-17 23:48:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(10) UNSIGNED NOT NULL,
  `id_kategori` int(10) UNSIGNED NOT NULL,
  `id_merk` int(10) UNSIGNED NOT NULL,
  `nama_produk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_produk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id_produk`, `id_kategori`, `id_merk`, `nama_produk`, `kode_produk`, `created_at`, `updated_at`) VALUES
(2, 4, 7, 'Tanggo', 'P000002', '2022-01-12 05:41:58', '2022-05-30 00:16:20'),
(3, 2, 6, 'Pepsodent Kecil', 'P000003', '2022-01-15 18:06:30', '2022-04-28 21:50:03'),
(4, 2, 6, 'Pepsodent Besar', 'P000004', '2022-04-12 01:44:46', '2022-04-12 01:44:46'),
(6, 1, 2, 'Air Mineral Aqua  kecil', 'P000005', '2022-05-30 01:33:22', '2022-05-30 01:34:47'),
(7, 1, 2, 'Air Mineral Aqua  Besar', 'P000007', '2022-05-30 01:34:37', '2022-05-30 01:34:37'),
(8, 14, 47, 'Sardines Extra Pedas', 'P000008', '2022-05-30 01:35:55', '2022-05-30 01:35:55'),
(9, 1, 48, 'Kopi Kapal Api Sachet', 'P000009', '2022-05-30 01:36:57', '2022-05-30 01:36:57');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('2xaGsVwm7cXM4FI8XKgnAG4xm09Ho9jv4bkJxAO9', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMGRRUndncERSaHA0MEJpU2dqOU00S1Iwbk9LMW44bXJLWWhiOEgwRSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly9sb2NhbGhvc3Qvc2tyaXBzaSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1655903850),
('Begovqhb9gpvhy9tbEZGqp0ngCWEh0XV7G4ZkxJ4', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiVDlnVXBDQTFYTDNUMmlYbDNMU0JSTGJUbUE2U1U1U2UzdHVSWmFSSCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1655534267),
('XtVattH8NZcRu4K1W5wyMFcZZW1hAAJEaumzgRBC', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNGNVZzNubEdVRmJ4M09DZEpIOTJXTjVWRmIyM3pXTFBiSUw3MXlRNyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9sb2NhbGhvc3Qvc2tyaXBzaS9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1655903851),
('yisrdH5g6D797RrmwnuM4jPtCVtJN04yUdhJiLAf', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', 'YTo4OntzOjY6Il90b2tlbiI7czo0MDoiOWdvY1pBYUFsNXdGRHV1OTB4MnhEQ0R2SWIyOGdXSmJyQTZ4NVljMiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6ODk6Imh0dHA6Ly9sb2NhbGhvc3Qvc2tyaXBzaS9sYXBvcmFua2V1YW5nYW4/dGFuZ2dhbF9ha2hpcj0yMDIyLTA2LTE4JnRhbmdnYWxfYXdhbD0yMDIyLTA2LTExIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2MDoiJDJ5JDEwJFR4UjN0c0d6NVBwcUVDZHlvN1IwMy5vaDJWNmNkeFZJSjJWYld3ZDFNanpPaGRkRVhDbGdTIjtzOjEyOiJpZF9wZW5qdWFsYW4iO2k6NjM7czoxMjoiaWRfcGVtYmVsaWFuIjtpOjExO3M6MTE6ImlkX3N1cHBsaWVyIjtzOjE6IjEiO30=', 1655534991);

-- --------------------------------------------------------

--
-- Struktur dari tabel `setting`
--

CREATE TABLE `setting` (
  `id_setting` int(10) UNSIGNED NOT NULL,
  `nama_perusahaan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `telepon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe_nota` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `setting`
--

INSERT INTO `setting` (`id_setting`, `nama_perusahaan`, `alamat`, `telepon`, `tipe_nota`, `created_at`, `updated_at`) VALUES
(1, 'Bintang Permai', 'Kepuh Permai D31, Wedomartani, Ngemplak, Sleman', '08983674571', 2, NULL, '2022-03-31 11:18:57');

-- --------------------------------------------------------

--
-- Struktur dari tabel `stock`
--

CREATE TABLE `stock` (
  `id_stock` int(10) UNSIGNED NOT NULL,
  `id_produk` int(10) UNSIGNED NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `stock`
--

INSERT INTO `stock` (`id_stock`, `id_produk`, `harga_beli`, `harga_jual`, `stock`, `status`, `created_at`, `updated_at`) VALUES
(19, 3, 6000, 7000, 11, '0', '2022-05-18 12:50:38', '2022-06-14 00:19:08'),
(20, 4, 13000, 14000, 9, '0', '2022-05-18 12:51:17', '2022-05-18 19:07:15'),
(24, 2, 5000, 6000, 3, '0', NULL, '2022-06-14 00:20:20'),
(27, 6, 2300, 3000, 9, '0', '2022-05-30 01:33:22', '2022-05-30 01:41:28'),
(28, 7, 4600, 5000, 4, '0', '2022-05-30 01:34:37', '2022-06-16 19:33:21'),
(29, 8, 9500, 10000, 9, '0', '2022-05-30 01:35:55', '2022-05-30 05:00:48'),
(30, 9, 2500, 3000, 3, '0', '2022-05-30 01:36:57', '2022-06-17 23:47:40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` int(10) UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telepon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `nama`, `alamat`, `telepon`, `created_at`, `updated_at`) VALUES
(1, 'Joko Santosa', 'Jalan raya tajem', '08983674571', '2021-12-10 04:42:01', '2021-12-10 04:43:37'),
(3, 'Bagus Purnomo', 'Psr. Ki Hajar Dewantara', '089637874571', '2022-05-19 00:39:00', '2022-05-19 00:39:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` tinyint(4) NOT NULL DEFAULT '0',
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `foto`, `level`, `two_factor_secret`, `two_factor_recovery_codes`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', NULL, '$2y$10$TxR3tsGz5PpqECdyo7R03.oh2V6cdxVIJ2VbWwd1MjzOhddEXClgS', 'dist/img/avatar04.png', 1, NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-06 09:52:31'),
(2, 'ferry', 'ferry@gmail.com', NULL, '$2y$10$45POGgYcBQ1FsX.38SziZO4Pf0nzCC9yU8meYCSyUnBrTsueZYVoC', 'dist/img/avatar04.png', 2, NULL, NULL, NULL, NULL, NULL, '2021-12-11 22:09:11', '2022-06-16 19:32:21'),
(3, 'Hasta', 'andihasta@gmail.com', NULL, '$2y$10$B45bqZ6plO3HkWcg75yb..eZgT6gPK853eusLEUA7tYM16B27EeKC', 'dist/img/avatar04.png', 2, NULL, NULL, NULL, NULL, NULL, '2022-06-15 20:28:14', '2022-06-15 20:28:14');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`),
  ADD UNIQUE KEY `kategori_nama_kategori_unique` (`nama_kategori`);

--
-- Indeks untuk tabel `merk`
--
ALTER TABLE `merk`
  ADD PRIMARY KEY (`id_merk`),
  ADD UNIQUE KEY `merk_nama_merk_unique` (`nama_merk`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indeks untuk tabel `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`id_pembelian`);

--
-- Indeks untuk tabel `pembelian_detail`
--
ALTER TABLE `pembelian_detail`
  ADD PRIMARY KEY (`id_pembelian_detail`);

--
-- Indeks untuk tabel `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD PRIMARY KEY (`id_pengeluaran`);

--
-- Indeks untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_penjualan`);

--
-- Indeks untuk tabel `penjualan_detail`
--
ALTER TABLE `penjualan_detail`
  ADD PRIMARY KEY (`id_penjualan_detail`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD KEY `produk_id_kategori_foreign` (`id_kategori`),
  ADD KEY `produk_id_merk_foreign` (`id_merk`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id_setting`);

--
-- Indeks untuk tabel `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id_stock`);

--
-- Indeks untuk tabel `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `merk`
--
ALTER TABLE `merk`
  MODIFY `id_merk` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `id_pembelian` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `pembelian_detail`
--
ALTER TABLE `pembelian_detail`
  MODIFY `id_pembelian_detail` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `pengeluaran`
--
ALTER TABLE `pengeluaran`
  MODIFY `id_pengeluaran` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id_penjualan` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT untuk tabel `penjualan_detail`
--
ALTER TABLE `penjualan_detail`
  MODIFY `id_penjualan_detail` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `setting`
--
ALTER TABLE `setting`
  MODIFY `id_setting` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `stock`
--
ALTER TABLE `stock`
  MODIFY `id_stock` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT untuk tabel `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supplier` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_id_kategori_foreign` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`),
  ADD CONSTRAINT `produk_id_merk_foreign` FOREIGN KEY (`id_merk`) REFERENCES `merk` (`id_merk`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
