-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 22, 2024 at 02:50 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `siprestik_smkislamkrembung`
--

-- --------------------------------------------------------

--
-- Table structure for table `adds`
--

CREATE TABLE `adds` (
  `id` bigint(20) NOT NULL,
  `tag` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `adds`
--

INSERT INTO `adds` (`id`, `tag`, `created_at`, `updated_at`) VALUES
(33, '92:4B:B8:89:E8', '2024-07-21 02:01:07', '2024-07-21 02:01:07'),
(36, '29:A9:B7:89:BE', '2024-07-21 18:44:07', '2024-07-21 18:44:07'),
(38, '4B:9D:CE:13:0B', '2024-07-21 21:08:56', '2024-07-21 21:08:56'),
(39, '99:80:25:16:2A', '2024-07-21 21:23:57', '2024-07-21 21:23:57');

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tag` varchar(255) NOT NULL,
  `information` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendances`
--

INSERT INTO `attendances` (`id`, `tag`, `information`, `status`, `date`, `time`, `image_path`, `created_at`, `updated_at`) VALUES
(34, '92:4B:B8:89:E8', 'in', 'Telat', '2024-07-21', '16:32:10', 'storage/public/images/image_20240721_093244.jpg', '2024-07-21 02:32:49', '2024-07-21 02:32:49'),
(37, '92:4B:B8:89:E8', 'out', 'Keluar', '2024-07-21', '16:50:51', 'storage/public/images/image_20240721_095124.jpg', '2024-07-21 02:51:29', '2024-07-21 02:51:29'),
(38, '6E:52:B8:89:0D', 'in', 'Telat', '2024-07-21', '17:24:30', 'storage/public/images/image_20240721_102504.jpg', '2024-07-21 03:25:09', '2024-07-21 03:25:09'),
(39, '6E:52:B8:89:0D', 'out', 'Keluar', '2024-07-21', '17:25:50', 'storage/public/images/image_20240721_102623.jpg', '2024-07-21 03:26:28', '2024-07-21 03:26:28'),
(40, '99:80:25:16:2A', 'in', 'Telat', '2024-07-22', '08:39:55', 'storage/public/images/image_20240722_014001.jpg', '2024-07-21 18:40:12', '2024-07-21 18:40:12'),
(41, '29:A9:B7:89:BE', 'in', 'Telat', '2024-07-22', '08:46:07', 'storage/public/images/image_20240722_014613.jpg', '2024-07-21 18:46:18', '2024-07-21 18:46:18'),
(42, '6E:52:B8:89:0D', 'in', 'Telat', '2024-07-22', '10:51:52', 'storage/public/images/image_20240722_035158.jpg', '2024-07-21 20:52:03', '2024-07-21 20:52:03'),
(43, '29:A9:B7:89:BE', 'out', 'Keluar', '2024-07-22', '11:31:58', 'storage/public/images/image_20240722_043204.jpg', '2024-07-21 21:32:10', '2024-07-21 21:32:10'),
(44, '99:80:25:16:2A', 'out', 'Keluar', '2024-07-22', '11:35:23', 'storage/public/images/image_20240722_043529.jpg', '2024-07-21 21:35:34', '2024-07-21 21:35:34');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
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
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(2, '2019_08_19_000000_create_failed_jobs_table', 1),
(3, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(4, '2024_06_27_130910_create_siswas_table', 1),
(5, '2024_06_27_162830_create_users_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `in_start` time NOT NULL,
  `in_end` time NOT NULL,
  `out_start` time NOT NULL,
  `out_end` time NOT NULL,
  `fine` varchar(255) NOT NULL,
  `fuel` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `in_start`, `in_end`, `out_start`, `out_end`, `fine`, `fuel`, `created_at`, `updated_at`) VALUES
(1, '07:00:00', '07:30:00', '10:44:00', '23:59:59', '123', '132', '2024-07-06 07:46:33', '2024-07-06 07:46:33');

-- --------------------------------------------------------

--
-- Table structure for table `siswas`
--

CREATE TABLE `siswas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nis` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `no_absen` varchar(255) NOT NULL,
  `jurusan` varchar(255) NOT NULL,
  `kelas` varchar(255) NOT NULL,
  `uid_rfid` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'alpha',
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `siswas`
--

INSERT INTO `siswas` (`id`, `nis`, `nama`, `no_absen`, `jurusan`, `kelas`, `uid_rfid`, `status`, `gambar`, `created_at`, `updated_at`) VALUES
(16, '2131730121', 'Masyrifatul Ummah', '12', 'Teknik Komputer dan Jaringan (TKJ)', '12 Teknik Komputer dan Jaringan (TKJ) 1', '6E:52:B8:89:0D', 'alpha', 'face_images/qaNvn3ciGhrkN8RdbO7cxCnvCpTEL49WUlFeGTrP.jpg', '2024-07-21 16:54:18', '2024-07-21 16:54:18'),
(18, '2131730018', 'Aslikh Halina', '5', 'Teknik Komputer dan Jaringan (TKJ)', '12 Teknik Komputer dan Jaringan (TKJ) 2', '29:A9:B7:89:BE', 'alpha', 'face_images/X9WfEendKJs0iXsDpcrrjp0YxkUXzKwHUKV8YyU1.jpg', '2024-07-21 18:44:53', '2024-07-21 18:44:53'),
(19, '2131730141', 'Karin Archita Erlinda', '10', 'Teknik Komputer dan Jaringan (TKJ)', '12 Teknik Komputer dan Jaringan (TKJ) 3', '99:80:25:16:2A', 'alpha', 'face_images/20nBSoSQ1OhH2ikoveQtkGRJX5EmQlXtBksprR35.jpg', '2024-07-21 21:24:44', '2024-07-21 21:24:44');

-- --------------------------------------------------------

--
-- Table structure for table `student_attendances`
--

CREATE TABLE `student_attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nis` varchar(255) NOT NULL,
  `tanggal` datetime NOT NULL,
  `status` enum('alpha','izin','sakit') NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_attendances`
--

INSERT INTO `student_attendances` (`id`, `nis`, `tanggal`, `status`, `gambar`, `created_at`, `updated_at`) VALUES
(2, '2131730121', '2024-07-19 07:00:00', 'sakit', 'images/dNEEGlTbOMadTXRwGIpRyF79F9aI95pnK2ALf3VL.jpg', '2024-07-21 16:59:27', '2024-07-21 16:59:27'),
(3, '2131730141', '2024-07-21 11:42:00', 'sakit', 'images/0qIPE2fIyCzsN1l34go8SH7DrtAcZUYZoNrFZUIy.jpg', '2024-07-21 21:43:01', '2024-07-21 21:43:01');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin_sekolah', '$2y$12$0I4hvVPMBqMyuqm9dLolX.Cqr2L05KjVs7zLVR0.P66mj6s4QzZ2S', 'admin_sekolah', NULL, '2024-06-27 09:50:19', '2024-06-27 09:50:19'),
(2, 'admin_tu', '$2y$12$kyTfz/2psJbsdnPPtt6jDu8m8Rw5P6Av8WVrwBKGD.gsS4bdG1q3W', 'admin_tu', NULL, '2024-06-27 09:50:20', '2024-06-27 09:50:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adds`
--
ALTER TABLE `adds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `siswas`
--
ALTER TABLE `siswas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `siswas_nis_unique` (`nis`),
  ADD UNIQUE KEY `siswas_uid_rfid_unique` (`uid_rfid`);

--
-- Indexes for table `student_attendances`
--
ALTER TABLE `student_attendances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nis` (`nis`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adds`
--
ALTER TABLE `adds`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `siswas`
--
ALTER TABLE `siswas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `student_attendances`
--
ALTER TABLE `student_attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `student_attendances`
--
ALTER TABLE `student_attendances`
  ADD CONSTRAINT `student_attendances_ibfk_1` FOREIGN KEY (`nis`) REFERENCES `siswas` (`nis`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
