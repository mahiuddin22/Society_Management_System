-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20260814.7ff5dd5b7e
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 24, 2026 at 09:58 AM
-- Server version: 8.4.3
-- PHP Version: 8.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `society_management_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--
CREATE TABLE `activities` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `activity_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `name`, `activity_key`, `created_at`, `updated_at`) VALUES
(1, 'Access', 'access', '2025-08-08 12:48:56', '2025-08-08 12:48:56'),
(2, 'Create', 'create', '2025-08-08 06:29:27', '2025-08-08 13:07:08'),
(3, 'Edit', 'edit', '2025-08-08 12:58:43', '2025-08-08 12:58:43'),
(4, 'Delete', 'delete', '2025-08-08 14:16:10', '2025-08-08 14:16:10'),
(5, 'View', 'view', '2025-08-09 06:31:21', '2025-08-09 06:31:21'),
(6, 'Move', 'move', '2025-08-09 13:06:29', '2025-08-09 13:06:29'),
(8, 'Change Status', 'change_status', '2026-08-18 00:59:15', '2026-08-18 00:59:15'),
(9, 'Download', 'download', '2026-08-19 02:35:03', '2026-08-19 02:35:03');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--
CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--
CREATE TABLE `members` (
  `id` bigint UNSIGNED NOT NULL,
  `unique_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `road` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `holding_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `plot_and_unit_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `flat_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `payment_status` tinyint(1) NOT NULL DEFAULT '0',
  `payment_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `unique_id`, `road`, `holding_no`, `plot_and_unit_id`, `name`, `flat_no`, `number`, `email`, `amount`, `payment_status`, `payment_date`, `created_at`, `updated_at`) VALUES
(23, 'UT031/A154', '1/A', '15', 1, 'Md Mahiuddin', '4', '01234567890', 'mahiuddin@gmai.com', 2500.00, 1, '2026-08-23', '2026-08-20 01:59:54', '2026-08-23 06:19:35'),
(24, 'UT031/A155', '1/A', '15', 1, 'Md Noyon', '5', '01234567890', 'noyon@gmai.com', 2500.00, 1, '2026-08-23', '2026-08-20 01:59:54', '2026-08-23 06:16:45');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--
CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2014_10_12_100000_create_password_resets_table', 2),
(6, '2025_08_03_201440_create_permissions_table', 2),
(7, '2025_08_03_201552_create_role_permissions_table', 2),
(8, '2025_08_03_204700_add_menu_key_to_role_permissions_table', 3),
(9, '2025_08_05_112549_create_user_permissions_table', 4),
(10, '2025_08_08_062716_create_activities_table', 5),
(11, '2025_08_12_191731_create_roles_table', 6),
(12, '2026_08_13_085724_create_plot_and_units_table', 7),
(14, '2026_08_16_062600_create_members_table', 8),
(15, '2026_08_16_114233_create_plot_types_table', 9);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--
CREATE TABLE `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('admin@example.com', '$2y$12$RQxDrG39UVwkTpI8kRbUruUHnb1gO9Tri4RXYNbDKMhcACx.2OaXy', '2025-08-12 12:18:29');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--
CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu_type` enum('main_menu','sub_menu') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `menu_key` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_no` int DEFAULT NULL,
  `activity_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `menu_type`, `menu_key`, `order_no`, `activity_id`, `created_at`, `updated_at`) VALUES
(12, 'Settings', 'main_menu', NULL, 5, NULL, '2026-07-30 02:15:32', '2026-08-18 01:01:02'),
(13, 'Site Settings', 'sub_menu', 'site_settings', 6, '1', '2026-07-30 02:16:34', '2026-08-18 01:01:02'),
(17, 'Permissions', 'sub_menu', 'permissions', 4, '1,2,3,4,5,6', '2026-07-30 04:02:41', '2026-08-18 01:01:02'),
(19, 'Activities', 'sub_menu', 'activities', 2, '1,2,3,4', '2026-08-16 04:27:19', '2026-08-18 01:01:02'),
(20, 'Administrative Setup', 'main_menu', NULL, 1, NULL, '2026-08-16 04:30:35', '2026-08-18 01:01:02'),
(21, 'Roles', 'sub_menu', 'roles', 3, '1,2,3,4', '2026-08-16 04:32:42', '2026-08-18 01:01:02'),
(22, 'Plot Types', 'sub_menu', 'plot_types', 7, '1,2,3,4,8', '2026-08-18 01:00:57', '2026-08-18 01:01:02'),
(23, 'People', 'main_menu', NULL, NULL, NULL, '2026-08-18 01:02:23', '2026-08-18 01:02:23'),
(24, 'Plot And Units', 'sub_menu', 'plot_and_units', NULL, '1,2,3,4,5', '2026-08-18 01:03:04', '2026-08-18 01:03:04'),
(25, 'Finance', 'main_menu', NULL, NULL, NULL, '2026-08-18 01:03:38', '2026-08-18 01:03:38'),
(27, 'Collections', 'sub_menu', 'collections', NULL, '1,3,4,8,9', '2026-08-19 02:38:56', '2026-08-19 02:38:56');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--
CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plot_and_units`
--
CREATE TABLE `plot_and_units` (
  `id` bigint UNSIGNED NOT NULL,
  `road` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `holding_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `building_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_flat` int DEFAULT NULL,
  `occupied_flat` int DEFAULT NULL,
  `collection_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_person` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `collection_rate` decimal(10,2) DEFAULT NULL,
  `collection_amount` decimal(12,2) DEFAULT NULL,
  `discount` decimal(12,2) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `plot_and_units`
--

INSERT INTO `plot_and_units` (`id`, `road`, `holding_no`, `building_type`, `total_flat`, `occupied_flat`, `collection_type`, `contact_person`, `collection_rate`, `collection_amount`, `discount`, `date`, `status`, `created_at`, `updated_at`) VALUES
(1, '1/A', '15', '8', NULL, NULL, 'Group', NULL, 0.00, 0.00, 0.00, '2026-08-20', 1, '2026-08-16 03:25:46', '2026-08-24 03:46:34');

-- --------------------------------------------------------

--
-- Table structure for table `plot_types`
--
CREATE TABLE `plot_types` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` int NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `plot_types`
--

INSERT INTO `plot_types` (`id`, `name`, `amount`, `status`, `created_at`, `updated_at`) VALUES
(8, 'Empty Plot', 0, 1, '2026-08-17 23:09:57', '2026-08-17 23:09:57'),
(9, 'Under Construction', 250, 1, '2026-08-17 23:10:17', '2026-08-17 23:10:17'),
(10, 'Apartment', 300, 1, '2026-08-17 23:10:31', '2026-08-17 23:10:31'),
(11, 'Owner Made Building', 500, 1, '2026-08-17 23:10:48', '2026-08-17 23:10:48'),
(12, 'Commercial Building', 1000, 1, '2026-08-17 23:11:05', '2026-08-17 23:11:05'),
(13, 'other', 500, 0, '2026-08-17 23:11:19', '2026-08-18 01:27:29');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--
CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2025-08-12 13:37:14', '2025-08-12 13:45:45');

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--
CREATE TABLE `role_permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int DEFAULT NULL,
  `permission_id` bigint UNSIGNED NOT NULL,
  `activity_id` int DEFAULT NULL,
  `menu_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`id`, `role`, `user_id`, `permission_id`, `activity_id`, `menu_key`, `created_at`, `updated_at`) VALUES
(1124, 'admin', NULL, 24, 1, 'plot_and_units', '2026-08-19 02:39:27', '2026-08-19 02:39:27'),
(1125, 'admin', NULL, 24, 2, 'plot_and_units', '2026-08-19 02:39:27', '2026-08-19 02:39:27'),
(1126, 'admin', NULL, 24, 3, 'plot_and_units', '2026-08-19 02:39:27', '2026-08-19 02:39:27'),
(1127, 'admin', NULL, 24, 4, 'plot_and_units', '2026-08-19 02:39:27', '2026-08-19 02:39:27'),
(1128, 'admin', NULL, 24, 5, 'plot_and_units', '2026-08-19 02:39:27', '2026-08-19 02:39:27'),
(1129, 'admin', NULL, 27, 1, 'collections', '2026-08-19 02:39:27', '2026-08-19 02:39:27'),
(1130, 'admin', NULL, 27, 3, 'collections', '2026-08-19 02:39:27', '2026-08-19 02:39:27'),
(1131, 'admin', NULL, 27, 4, 'collections', '2026-08-19 02:39:27', '2026-08-19 02:39:27'),
(1132, 'admin', NULL, 27, 8, 'collections', '2026-08-19 02:39:27', '2026-08-19 02:39:27'),
(1133, 'admin', NULL, 27, 9, 'collections', '2026-08-19 02:39:27', '2026-08-19 02:39:27'),
(1134, 'admin', NULL, 19, 1, 'activities', '2026-08-19 02:39:27', '2026-08-19 02:39:27'),
(1135, 'admin', NULL, 19, 2, 'activities', '2026-08-19 02:39:27', '2026-08-19 02:39:27'),
(1136, 'admin', NULL, 19, 3, 'activities', '2026-08-19 02:39:27', '2026-08-19 02:39:27'),
(1137, 'admin', NULL, 19, 4, 'activities', '2026-08-19 02:39:27', '2026-08-19 02:39:27'),
(1138, 'admin', NULL, 21, 1, 'roles', '2026-08-19 02:39:27', '2026-08-19 02:39:27'),
(1139, 'admin', NULL, 21, 2, 'roles', '2026-08-19 02:39:27', '2026-08-19 02:39:27'),
(1140, 'admin', NULL, 21, 3, 'roles', '2026-08-19 02:39:27', '2026-08-19 02:39:27'),
(1141, 'admin', NULL, 21, 4, 'roles', '2026-08-19 02:39:27', '2026-08-19 02:39:27'),
(1142, 'admin', NULL, 17, 1, 'permissions', '2026-08-19 02:39:27', '2026-08-19 02:39:27'),
(1143, 'admin', NULL, 17, 2, 'permissions', '2026-08-19 02:39:27', '2026-08-19 02:39:27'),
(1144, 'admin', NULL, 17, 3, 'permissions', '2026-08-19 02:39:27', '2026-08-19 02:39:27'),
(1145, 'admin', NULL, 17, 4, 'permissions', '2026-08-19 02:39:27', '2026-08-19 02:39:27'),
(1146, 'admin', NULL, 17, 5, 'permissions', '2026-08-19 02:39:27', '2026-08-19 02:39:27'),
(1147, 'admin', NULL, 17, 6, 'permissions', '2026-08-19 02:39:27', '2026-08-19 02:39:27'),
(1148, 'admin', NULL, 13, 1, 'site_settings', '2026-08-19 02:39:27', '2026-08-19 02:39:27'),
(1149, 'admin', NULL, 22, 1, 'plot_types', '2026-08-19 02:39:27', '2026-08-19 02:39:27'),
(1150, 'admin', NULL, 22, 2, 'plot_types', '2026-08-19 02:39:27', '2026-08-19 02:39:27'),
(1151, 'admin', NULL, 22, 3, 'plot_types', '2026-08-19 02:39:27', '2026-08-19 02:39:27'),
(1152, 'admin', NULL, 22, 4, 'plot_types', '2026-08-19 02:39:27', '2026-08-19 02:39:27'),
(1153, 'admin', NULL, 22, 8, 'plot_types', '2026-08-19 02:39:27', '2026-08-19 02:39:27');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--
CREATE TABLE `settings` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `contact` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_driver` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_host` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_port` int DEFAULT NULL,
  `mail_username` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_encryption` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_from` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_from_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `copy_right` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `logo`, `address`, `contact`, `email`, `mail_driver`, `mail_host`, `mail_port`, `mail_username`, `mail_password`, `mail_encryption`, `mail_from`, `mail_from_name`, `copy_right`, `created_at`, `updated_at`) VALUES
(1, 'Sector 3 Welfare Society', '1787134206_default.png', 'House-10, Road-07, Sector-03, Uttara,Dhaka-1230, Bangladesh', '+8801234567890', 'info@sector3society.com', 'smtp', 'sandbox.smtp.mailtrap.io', 2525, 'd1b3021b79c020', '32918f66f08d5c', 'tls', 'support@jobkhoja.com', 'JobKhoja', 'JobKhoja.com | All Rights Reserved', '2026-04-01 04:18:14', '2026-08-19 04:10:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--
CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `role` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'student',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Admin', 'admin@example.com', '2025-08-02 10:49:38', '$2y$12$dmhp2VydIdIJvtBm8NR9I.MoS/HEhtWDJSPdUCPMS6I/ReKJEWK0e', 'llNFs6sPqQQ8wT0yodHlEfLwtvxBPX7VvjQBP6ioKU8KkpIoy8qS7FPud1ig', '2025-08-02 10:49:38', '2025-08-02 08:08:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `members_plot_and_unit_id_foreign` (`plot_and_unit_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `plot_and_units`
--
ALTER TABLE `plot_and_units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plot_types`
--
ALTER TABLE `plot_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_permissions_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
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
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plot_and_units`
--
ALTER TABLE `plot_and_units`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `plot_types`
--
ALTER TABLE `plot_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1154;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `members`
--
ALTER TABLE `members`
  ADD CONSTRAINT `members_plot_and_unit_id_foreign` FOREIGN KEY (`plot_and_unit_id`) REFERENCES `plot_and_units` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `role_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
