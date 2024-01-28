-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 13, 2022 at 11:11 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `clinicdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `drugs_lists`
--

CREATE TABLE `drugs_lists` (
  `drug_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `drug_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cost_price` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sell_price` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_qty` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `drugs_lists`
--

INSERT INTO `drugs_lists` (`drug_id`, `drug_name`, `unit_id`, `cost_price`, `sell_price`, `item_qty`, `description`, `created_at`, `updated_at`) VALUES
('DG-12271316530', 'Atarax 50mg', '1', '100', '200', '0', '-', '2022-08-13 09:05:33', '2022-08-13 19:17:37'),
('DG-12271321020', 'Amoxycillin', '1', '30', '100', '100', '-', '2022-08-12 19:10:26', '2022-08-13 16:34:47'),
('DG-12271321029', 'Atarax', '2', '100', '200', '100', '-', '2022-08-12 19:10:37', '2022-08-13 17:25:02');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_05_30_122643_create_patient_list_table', 1),
(6, '2022_06_10_110536_create_patient_history_table', 1),
(7, '2022_06_10_113139_create_drugs_list_table', 1),
(8, '2022_06_10_113923_create_orders_table', 1),
(9, '2022_06_19_005707_create_orders_detail_table', 1),
(10, '2022_06_19_010359_create_sexes_table', 1),
(11, '2022_06_19_010431_create_typedrugs_table', 1),
(12, '2022_07_05_134954_create_patient_log_table', 1),
(13, '2022_07_05_135752_create_stocks_log_table', 1),
(14, '2022_07_11_170124_create_typeusers_table', 1),
(15, '2022_08_01_153826_create_stocks_detail_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `patient_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grandtotal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_order` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders_details`
--

CREATE TABLE `orders_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `drug_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` int(11) NOT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `patient_histories`
--

CREATE TABLE `patient_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `patient_symptoms` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_history` date NOT NULL,
  `next_check` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patient_histories`
--

INSERT INTO `patient_histories` (`id`, `patient_id`, `order_id`, `patient_symptoms`, `date_history`, `next_check`, `created_at`, `updated_at`) VALUES
(1, 'PB-12271322342', 'DB-1227142223', '5555', '2022-08-14', '2022-08-28', '2022-08-13 19:02:29', '2022-08-13 19:02:29'),
(2, 'PC-12271315247', 'DC-1227142711', '55555', '2022-08-14', '2022-08-28', '2022-08-13 19:07:21', '2022-08-13 19:07:21');

-- --------------------------------------------------------

--
-- Table structure for table `patient_lists`
--

CREATE TABLE `patient_lists` (
  `patient_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nickname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sex` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthdate` date NOT NULL,
  `drug_allergy` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `users_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `line_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patient_lists`
--

INSERT INTO `patient_lists` (`patient_id`, `name`, `nickname`, `tel`, `address`, `sex`, `birthdate`, `drug_allergy`, `users_image`, `line_id`, `type`, `created_at`, `updated_at`) VALUES
('PB-122713215157', 'ชนิตา  มาพึ่ง', 'ออย', '0910148604', '109', '2', '2018-02-11', '-', 'image/patient/1741058117617447.png', 'cntmp', 1, '2022-08-13 14:52:17', '2022-08-13 14:54:00'),
('PB-12271322342', 'ปัญญาพล พุทธชาติ', 'บาส', '0956251001', '65/35', '1', '1999-11-11', '-', 'image/patient/1740984547059715.png', 'Baspanyapon', 1, '2022-08-12 19:24:07', '2022-08-12 19:24:07'),
('PB-12271404231', 'สรศักดิ์ โพธิ์เทพ', 'น๊อต', '0123456', '11/1', '1', '1999-11-11', '-', '0', 'NotSorrasak', 1, '2022-08-13 17:42:51', '2022-08-13 17:42:51'),
('PB-12271404510', 'ชาคริต', 'โอ๊ต', '012345678', '65/35', '1', '2012-06-07', '-', '0', 'OatChakrit', 1, '2022-08-13 17:45:40', '2022-08-13 17:45:40'),
('PB-12271404823', 'test', 'testt', '01234526', '1164', '1', '1997-06-08', '-', '0', 'testline', 1, '2022-08-13 17:48:50', '2022-08-13 17:48:50'),
('PC-12271315247', 'วิษณุ แป้นสุวรรณ์', 'ณุ', '0123456789', '1/1', '1', '1998-07-17', '-', 'image/patient/1741033644189896.png', '์NuWisanu', 2, '2022-08-13 08:24:30', '2022-08-13 15:54:21'),
('PC-122713225944', 'สรศักดิ์ โพธิ์เทพ', 'น๊อต', '012345678', '11/1', '1', '2022-08-20', '-', 'image/patient/1741062342012101.jpg', 'NotSorrasak', 2, '2022-08-13 16:00:12', '2022-08-13 16:00:48'),
('PC-1227140491', 'เด็ก', 'เด็กๆ', '012345', '11/1', '1', '2022-08-27', '-', '0', 'Dek', 2, '2022-08-13 17:49:36', '2022-08-13 17:49:36');

-- --------------------------------------------------------

--
-- Table structure for table `patient_logs`
--

CREATE TABLE `patient_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patient_logs`
--

INSERT INTO `patient_logs` (`id`, `patient_id`, `type`, `status`, `created_at`, `updated_at`) VALUES
(1, 'PB-12271322342', 1, 1, '2022-08-13 19:47:17', '2022-08-13 19:47:17'),
(2, 'PC-12271315247', 2, 1, '2022-08-13 19:57:28', '2022-08-13 19:57:28');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sexes`
--

CREATE TABLE `sexes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sex_name` char(10) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sexes`
--

INSERT INTO `sexes` (`id`, `sex_name`) VALUES
(1, 'ชาย'),
(2, 'หญิง');

-- --------------------------------------------------------

--
-- Table structure for table `stocks_details`
--

CREATE TABLE `stocks_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `stock_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `drug_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount_old` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `amount_total` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stocks_details`
--

INSERT INTO `stocks_details` (`id`, `stock_id`, `drug_id`, `amount_old`, `amount`, `amount_total`, `created_at`, `updated_at`) VALUES
(1, 'ST-D-12271421325', 'DG-12271316530', 150, 50, 100, '2022-08-13 19:13:26', '2022-08-13 19:13:26'),
(2, 'ST-D-12271421531', 'DG-12271316530', 100, 50, 50, '2022-08-13 19:15:36', '2022-08-13 19:15:36'),
(3, 'ST-D-12271421552', 'DG-12271316530', 50, 50, 0, '2022-08-13 19:17:37', '2022-08-13 19:17:37');

-- --------------------------------------------------------

--
-- Table structure for table `stocks_logs`
--

CREATE TABLE `stocks_logs` (
  `stock_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stocks_logs`
--

INSERT INTO `stocks_logs` (`stock_id`, `status`, `created_at`, `updated_at`) VALUES
('ST-D-12271421325', '2', '2022-08-13 19:13:26', '2022-08-13 19:13:26'),
('ST-D-12271421531', '2', '2022-08-13 19:15:36', '2022-08-13 19:15:36'),
('ST-D-12271421552', '2', '2022-08-13 19:17:37', '2022-08-13 19:17:37');

-- --------------------------------------------------------

--
-- Table structure for table `typedrugs`
--

CREATE TABLE `typedrugs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `typename` char(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `typedrugs`
--

INSERT INTO `typedrugs` (`id`, `typename`, `created_at`, `updated_at`) VALUES
(1, 'เม็ด', NULL, NULL),
(2, 'เข็ม', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `typeusers`
--

CREATE TABLE `typeusers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `typeusersname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `typeusers`
--

INSERT INTO `typeusers` (`id`, `typeusersname`) VALUES
(1, 'ผู้ดูแลระบบ'),
(2, 'พนักงาน'),
(3, 'หมอกระดูก'),
(4, 'หมอเด็ก');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `type`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin Admin', 'admin@argon.com', '2022-08-12 19:10:11', '$2y$10$dUtUqR5i9hSpWD8Q5bdBCOckwrwp1hXNixOZz1jZa5yFNj91mh6wq', 1, NULL, '2022-08-12 19:10:11', '2022-08-12 19:10:11'),
(2, 'User User', 'user@argon.com', '2022-08-12 19:10:11', '$2y$10$JKqy1qlYZGbQ2DQcY9.v5.odl/al25hpFRyYzD3xOyWdi4ICAWjkm', 2, NULL, '2022-08-12 19:10:11', '2022-08-12 19:10:11'),
(3, 'Doctor Bone', 'Drbone@argon.com', '2022-08-12 19:10:11', '$2y$10$a5Xs83FDblpGLtmtm75UXewXGPA2a3nS1vjOIa46LmPu5W61038sG', 3, NULL, '2022-08-12 19:10:11', '2022-08-12 19:10:11'),
(4, 'Doctor Child', 'Drchild@argon.com', '2022-08-12 19:10:11', '$2y$10$doQh8wgCFDQFoL6UEEdD3e6.7JBTMGg670xPdMds.KYB8ivjLQd5u', 4, NULL, '2022-08-12 19:10:11', '2022-08-12 19:10:11'),
(10, 'test', 'basindy2542@hotmail.com', NULL, '$2y$10$8bEb9F3/SOU0kl4cAcpDketWXVbW/ZevdEPSICJLhgDBWcMzZfBvq', 1, NULL, '2022-08-13 17:34:18', '2022-08-13 17:34:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `drugs_lists`
--
ALTER TABLE `drugs_lists`
  ADD PRIMARY KEY (`drug_id`);

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
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `orders_details`
--
ALTER TABLE `orders_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `patient_histories`
--
ALTER TABLE `patient_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patient_lists`
--
ALTER TABLE `patient_lists`
  ADD PRIMARY KEY (`patient_id`);

--
-- Indexes for table `patient_logs`
--
ALTER TABLE `patient_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `sexes`
--
ALTER TABLE `sexes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stocks_details`
--
ALTER TABLE `stocks_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stocks_logs`
--
ALTER TABLE `stocks_logs`
  ADD PRIMARY KEY (`stock_id`);

--
-- Indexes for table `typedrugs`
--
ALTER TABLE `typedrugs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `typeusers`
--
ALTER TABLE `typeusers`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `orders_details`
--
ALTER TABLE `orders_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patient_histories`
--
ALTER TABLE `patient_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `patient_logs`
--
ALTER TABLE `patient_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sexes`
--
ALTER TABLE `sexes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `stocks_details`
--
ALTER TABLE `stocks_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `typedrugs`
--
ALTER TABLE `typedrugs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `typeusers`
--
ALTER TABLE `typeusers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
