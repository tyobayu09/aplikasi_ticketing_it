-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2026 at 03:32 AM
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
-- Database: `ticket_it_jmi`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `jobs`
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
-- Table structure for table `job_batches`
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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_02_23_062304_create_tickets_table', 1);

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
-- Table structure for table `sessions`
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
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('lzYRzoHBN7FXIkZCQaoRAaz3cUhse6WujTvo57QR', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibTY1NXBVYUlrYkZvRXVwbkFsVUhXZGRqUkttTVkzcFJrZUZuZFgxaSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9fQ==', 1774592261),
('TFqxWero91vzUZRt6F0BPIk1eKYNghusuhrBMBvz', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicjkzMDV5bXNueXVDVm5pcUpSTGZhbEdkYUdsbm9yb092QmoyY2VFdCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9jaGVjay1uZXctdGlja2V0cyI7czo1OiJyb3V0ZSI7czoxOToiYWRtaW4udGlja2V0cy5jaGVjayI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1773025085);

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ticket_number` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `requester_name` varchar(255) NOT NULL,
  `divisi` varchar(255) NOT NULL,
  `no_wa` varchar(255) NOT NULL,
  `subject` text NOT NULL,
  `priority` enum('Low','Medium','High','Critical') NOT NULL,
  `status` enum('New','Open','On-hold','Pending','Resolved','Spam','Trash') NOT NULL DEFAULT 'New',
  `channel` varchar(255) NOT NULL DEFAULT 'Web',
  `assigned_to` varchar(255) DEFAULT NULL,
  `started_at` timestamp NULL DEFAULT NULL,
  `finished_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `ticket_number`, `location`, `requester_name`, `divisi`, `no_wa`, `subject`, `priority`, `status`, `channel`, `assigned_to`, `started_at`, `finished_at`, `created_at`, `updated_at`) VALUES
(1, 'TKT-0LDVF', 'JMI Krian, Sidoarjo', 'tyo', 'HRD', '0987586535', 'Mengalami kerusakan pada keyboard atau papan tik adalah kendala yang umum terjadi pada sebagian besar perangkat elektronik seperti laptop.\r\nSalah satu penyebab papan tik rusak dan tak bisa digunakan, yakni intensitas penggunaan yang tinggi ataupun menekan tombol terlalu keras.', 'Low', 'New', 'Web Publik', NULL, NULL, NULL, '2026-03-02 07:36:09', '2026-03-02 07:36:09'),
(2, 'TKT-W2KNU', 'JMI Krian, Sidoarjo', 'tyo', 'HRD', '0987586535', 'Mengalami kerusakan pada keyboard atau papan tik adalah kendala yang umum terjadi pada sebagian besar perangkat elektronik seperti laptop.\r\nSalah satu penyebab papan tik rusak dan tak bisa digunakan, yakni intensitas penggunaan yang tinggi ataupun menekan tombol terlalu keras.', 'Low', 'Resolved', 'Web Publik', 'Tyo Bayu', '2026-03-02 07:41:03', '2026-03-04 00:58:47', '2026-03-02 07:36:10', '2026-03-04 00:58:47'),
(3, 'IT-KRIAN-001', 'JMI Krian, Sidoarjo', 'tyo', 'kabag', '0987586535', 'mouse tidak muncul crusor', 'Low', 'New', 'Web Publik', NULL, NULL, NULL, '2026-03-05 01:35:55', '2026-03-05 01:35:55'),
(4, 'IT-KRIAN-002', 'JMI Krian, Sidoarjo', 'tyo', 'kabag', '0987586535', 'printer rusak', 'Medium', 'Resolved', 'Web Publik', 'Tyo Bayu', '2026-03-05 01:39:16', '2026-03-09 02:23:15', '2026-03-05 01:37:33', '2026-03-09 02:23:15'),
(5, 'IT-MOJOAGUNG-001', 'Mojoagung, Jombang', 'tyo', 'kabag', '0987586535', 'laptop tiba tiba mati', 'Medium', 'New', 'Web Publik', NULL, NULL, NULL, '2026-03-05 01:42:14', '2026-03-05 01:42:14'),
(6, 'IT-MOJOAGUNG-002', 'Mojoagung, Jombang', 'tyo', 'kabag', '0987586535', 'printer kebakar', 'Critical', 'New', 'Web Publik', NULL, NULL, NULL, '2026-03-05 01:42:52', '2026-03-05 01:42:52'),
(7, 'IT-MOJOAGUNG-003', 'Mojoagung, Jombang', 'tyo', 'kabag', '0987586535', 'kabel cas putus', 'Low', 'New', 'Web Publik', NULL, NULL, NULL, '2026-03-05 01:55:51', '2026-03-05 01:55:51'),
(8, 'IT-MOJOAGUNG-004', 'PT JMI - Mojoagung, Jombang', 'Pak agung', 'MAGANG', '087656789098', 'laptop tiba tiba mati', 'Medium', 'New', 'Web Publik', NULL, NULL, NULL, '2026-03-05 02:04:02', '2026-03-05 02:04:02'),
(9, 'IT-MOJOAGUNG-005', 'Mojoagung, Jombang', 'Pak agung', 'MAGANG', '087656789098', 'laptop rusak', 'Medium', 'On-hold', 'Web Publik', 'Tyo Bayu', NULL, NULL, '2026-03-05 02:23:10', '2026-03-05 02:24:11'),
(10, 'IT-KRIAN-003', 'JMI Krian, Sidoarjo', 'CONTOH', 'MAGANG', '087656789098', 'kabel cas laptop lenovo rusak', 'Low', 'New', 'Web Publik', NULL, NULL, NULL, '2026-03-09 02:46:07', '2026-03-09 02:46:07');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `location`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin IT Krian', 'krian@onemed.co.id', NULL, '$2y$12$NzzZNV2J98I.MEKkfs0HneNXSOUMoCQtVsaI9bM10wkWDnlTFndSa', 'JMI Krian, Sidoarjo', 'eD6YkTk1Yw0glDF5x9LHAsWDUkBrtFarwDxLExvVc3t8OUxIRfAfUHIG3iWO', '2026-03-02 07:40:03', '2026-03-02 07:40:03'),
(2, 'Admin IT Mojoagung', 'mojoagung@onemed.co.id', NULL, '$2y$12$COeoh9xLdr5Vg0LYIYcyGuPICxEfPD8oPI0gy9lMp0o3KNGsEwF3O', 'Mojoagung, Jombang', 'rbw0fQ9qoOt12qU9XoGcCt0boxLo7AKQFVXTMN8bcBibJj0Q2ZR0ycMgU3Bb', '2026-03-02 07:40:03', '2026-03-02 07:40:03'),
(3, 'Admin IT Batang', 'batang@onemed.co.id', NULL, '$2y$12$RLvyWwxBz7D1CsLcQPO8ZO1t8kv76.cL4oUP1mPN3odmOPr8Fo0CS', 'Batang, Jawa Tengah', NULL, '2026-03-02 07:40:03', '2026-03-02 07:40:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tickets_ticket_number_unique` (`ticket_number`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
