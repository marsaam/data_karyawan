-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 25, 2025 at 07:24 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `data_karyawan`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `karyawans`
--

CREATE TABLE `karyawans` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_karyawan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tempat_lahir` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1 = Laki-laki, 2 = Perempuan',
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `karyawans`
--

INSERT INTO `karyawans` (`id`, `nama_lengkap`, `no_karyawan`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `foto`, `created_at`, `updated_at`) VALUES
(1, 'Andi Saputra', 'KRY001', 'Jakarta', '1990-01-15', '1', 'photo1.jpg', '2025-07-25 12:15:08', '2025-07-25 12:15:08'),
(2, 'Budi Hartono', 'KRY002', 'Bandung', '1985-06-20', '1', 'photo2.jpg', '2025-07-25 12:15:08', '2025-07-25 12:15:08'),
(3, 'Citra Dewi', 'KRY003', 'Surabaya', '1992-09-10', '2', 'photo3.jpeg', '2025-07-25 12:15:08', '2025-07-25 12:15:08');

-- --------------------------------------------------------

--
-- Table structure for table `keluargas`
--

CREATE TABLE `keluargas` (
  `id` bigint UNSIGNED NOT NULL,
  `karyawan_id` bigint UNSIGNED NOT NULL,
  `nama_keluarga` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hubungan` enum('1','2','3','4','5','6','7') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1 = Ayah, 2 = Ibu, 3 = Suami, 4 = Istri, 5 = Anak',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `keluargas`
--

INSERT INTO `keluargas` (`id`, `karyawan_id`, `nama_keluarga`, `hubungan`, `created_at`, `updated_at`) VALUES
(1, 1, 'Budi Santoso', '1', '2025-07-25 12:15:08', '2025-07-25 12:15:08'),
(2, 1, 'Siti Aminah', '2', '2025-07-25 12:15:08', '2025-07-25 12:15:08'),
(3, 2, 'Dewi Lestari', '4', '2025-07-25 12:15:08', '2025-07-25 12:15:08'),
(4, 2, 'Rafi Maulana', '5', '2025-07-25 12:15:08', '2025-07-25 12:15:08'),
(5, 3, 'Nuraini', '6', '2025-07-25 12:15:08', '2025-07-25 12:15:08'),
(6, 3, 'Fikri', '7', '2025-07-25 12:15:08', '2025-07-25 12:15:08');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_07_25_052540_create_karyawans_table', 1),
(6, '2025_07_25_052557_create_keluargas_table', 1),
(7, '2025_07_25_052613_create_pendidikans_table', 1),
(8, '2025_07_25_071859_create_permission_tables', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(3, 'App\\Models\\User', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pendidikans`
--

CREATE TABLE `pendidikans` (
  `id` bigint UNSIGNED NOT NULL,
  `karyawan_id` bigint UNSIGNED NOT NULL,
  `jenjang` enum('1','2','3','4','5') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1 = SMA/K, 2 = D3, 3 = D4/S1, 4 = S2, 5 = S3',
  `institusi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_lulus` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pendidikans`
--

INSERT INTO `pendidikans` (`id`, `karyawan_id`, `jenjang`, `institusi`, `tanggal_lulus`, `created_at`, `updated_at`) VALUES
(1, 1, '3', 'Universitas Indonesia', '2012-07-01', '2025-07-25 12:15:08', '2025-07-25 12:15:08'),
(2, 1, '4', 'Institut Teknologi Bandung', '2015-07-01', '2025-07-25 12:15:08', '2025-07-25 12:15:08'),
(3, 2, '2', 'Politeknik Negeri Jakarta', '2010-06-20', '2025-07-25 12:15:08', '2025-07-25 12:15:08'),
(4, 2, '3', 'Universitas Padjadjaran', '2013-06-30', '2025-07-25 12:15:08', '2025-07-25 12:15:08'),
(5, 3, '1', 'SMA Negeri 1 Surabaya', '2009-05-15', '2025-07-25 12:15:08', '2025-07-25 12:15:08'),
(6, 3, '3', 'Universitas Airlangga', '2014-07-10', '2025-07-25 12:15:08', '2025-07-25 12:15:08');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'create karyawan', 'web', '2025-07-25 12:15:08', '2025-07-25 12:15:08'),
(2, 'edit karyawan', 'web', '2025-07-25 12:15:08', '2025-07-25 12:15:08'),
(3, 'delete karyawan', 'web', '2025-07-25 12:15:08', '2025-07-25 12:15:08'),
(4, 'view karyawan', 'web', '2025-07-25 12:15:08', '2025-07-25 12:15:08'),
(5, 'create user', 'web', '2025-07-25 12:15:08', '2025-07-25 12:15:08'),
(6, 'edit user', 'web', '2025-07-25 12:15:08', '2025-07-25 12:15:08'),
(7, 'delete user', 'web', '2025-07-25 12:15:08', '2025-07-25 12:15:08'),
(8, 'view user', 'web', '2025-07-25 12:15:08', '2025-07-25 12:15:08'),
(9, 'create role', 'web', '2025-07-25 12:15:08', '2025-07-25 12:15:08'),
(10, 'edit role', 'web', '2025-07-25 12:15:08', '2025-07-25 12:15:08'),
(11, 'delete role', 'web', '2025-07-25 12:15:08', '2025-07-25 12:15:08'),
(12, 'view role', 'web', '2025-07-25 12:15:08', '2025-07-25 12:15:08'),
(13, 'ekspor PDF karyawan', 'web', '2025-07-25 12:15:08', '2025-07-25 12:15:08'),
(14, 'ekspor PDF user', 'web', '2025-07-25 12:15:08', '2025-07-25 12:15:08');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'web', '2025-07-25 12:15:08', '2025-07-25 12:15:08'),
(2, 'Admin', 'web', '2025-07-25 12:15:08', '2025-07-25 12:15:08'),
(3, 'User', 'web', '2025-07-25 12:15:08', '2025-07-25 12:15:08');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(1, 2),
(2, 2),
(3, 2),
(4, 2),
(13, 2),
(4, 3),
(13, 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '3',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Nuraini', 'superadmin@example.com', '$2y$10$gtg/5Hj1Q5huQCkDly/JQOED69p78JeZzJOik2UpcQtr6q0xLocdS', '1', NULL, '2025-07-25 12:15:08', '2025-07-25 12:15:08'),
(2, 'Bulan Tsabita', 'admin@example.com', '$2y$10$KguUi8nqlO981il.laXxD.SV52BRhfR9VPGccQLJHX3FB58cF42Ve', '2', NULL, '2025-07-25 12:15:08', '2025-07-25 12:15:08'),
(3, 'Gita Wulan', 'user@example.com', '$2y$10$oMWweRNelAFoRak59ru9meDTSCclrekRwn74moTV4x5y7ZIKyNfJW', '3', NULL, '2025-07-25 12:15:08', '2025-07-25 12:15:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `karyawans`
--
ALTER TABLE `karyawans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `karyawans_no_karyawan_unique` (`no_karyawan`);

--
-- Indexes for table `keluargas`
--
ALTER TABLE `keluargas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `keluargas_karyawan_id_foreign` (`karyawan_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pendidikans`
--
ALTER TABLE `pendidikans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pendidikans_karyawan_id_foreign` (`karyawan_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `karyawans`
--
ALTER TABLE `karyawans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `keluargas`
--
ALTER TABLE `keluargas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pendidikans`
--
ALTER TABLE `pendidikans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `keluargas`
--
ALTER TABLE `keluargas`
  ADD CONSTRAINT `keluargas_karyawan_id_foreign` FOREIGN KEY (`karyawan_id`) REFERENCES `karyawans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pendidikans`
--
ALTER TABLE `pendidikans`
  ADD CONSTRAINT `pendidikans_karyawan_id_foreign` FOREIGN KEY (`karyawan_id`) REFERENCES `karyawans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
