-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20260814.7ff5dd5b7e
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 15, 2026 at 09:12 AM
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
(9, 'Download', 'download', '2026-08-19 02:35:03', '2026-08-19 02:35:03'),
(10, 'Assign', 'assign', '2026-09-06 04:41:49', '2026-09-06 04:41:49');

-- --------------------------------------------------------

--
-- Table structure for table `collections`
--
CREATE TABLE `collections` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `flat_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `name`, `flat_no`, `number`, `email`, `created_at`, `updated_at`) VALUES
(9, 'Nusrat Jahan', '202', '01823456789', 'nusrat.jahan@example.com', '2026-09-08 09:49:34', '2026-09-08 09:49:34'),
(10, 'Md. Rakib Hasan', '303', '01934567890', 'rakib@example.com', '2026-09-08 09:49:34', '2026-09-08 09:49:34'),
(11, 'Sadia Rahman', '404', '01645678901', 'sadia.rahman@example.com', '2026-09-08 09:49:34', '2026-09-08 09:49:34'),
(12, 'Tanvir Ahmed', '505', '01556789012', 'tanvir.ahmed@example.com', '2026-09-08 09:49:34', '2026-09-08 09:49:34'),
(13, 'Farhan Hossain', '606', '01767890123', 'farhan.hossain@example.com', '2026-09-08 03:49:50', '2026-09-08 03:49:50'),
(14, 'Mim Akter', '707', '01878901234', 'mim.akter@example.com', '2026-09-08 03:49:50', '2026-09-08 03:49:50'),
(15, 'Shakil Ahmed', '808', '01989012345', 'shakil.ahmed@example.com', '2026-09-08 03:49:50', '2026-09-08 03:49:50'),
(16, 'Jannatul Ferdous', '909', '01690123456', 'jannatul.ferdous@example.com', '2026-09-08 03:49:50', '2026-09-08 03:49:50'),
(17, 'Imran Kabir', '110', '01501234567', 'imran.kabir@example.com', '2026-09-08 03:49:50', '2026-09-08 03:49:50'),
(18, 'Rafiul Islam', '111', '01711223344', 'rafiul.islam@example.com', '2026-09-08 03:49:50', '2026-09-08 03:49:50'),
(19, 'Tania Sultana', '112', '01822334455', 'tania.sultana@example.com', '2026-09-08 03:49:50', '2026-09-08 03:49:50'),
(20, 'Mahmud Hasan', '113', '01933445566', 'mahmud.hasan@example.com', '2026-09-08 03:49:50', '2026-09-08 03:49:50'),
(21, 'Priya Das', '114', '01644556677', 'priya.das@example.com', '2026-09-08 03:49:50', '2026-09-08 03:49:50'),
(22, 'Arif Rahman', '115', '01555667788', 'arif.rahman@example.com', '2026-09-08 03:49:50', '2026-09-08 03:49:50'),
(23, 'Md Mahiuddin', '10', '01610440622', 'mahiuddin@example.com', '2026-09-09 00:59:47', '2026-09-09 00:59:47'),
(24, 'Naeem Biswas', '11', '01710872443', 'naeem@example.com', '2026-09-09 01:00:46', '2026-09-09 01:00:46');

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
(15, '2026_08_16_114233_create_plot_types_table', 9),
(16, '2026_08_18_050126_create_collections_table', 10),
(18, '2026_09_03_073224_create_roads_table', 11),
(19, '2026_09_08_044553_create_sector_collenctions_table', 12);

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
(12, 'Settings', 'main_menu', NULL, 12, NULL, '2026-07-30 02:15:32', '2026-09-06 04:38:22'),
(13, 'Site Settings', 'sub_menu', 'site_settings', 13, '1', '2026-07-30 02:16:34', '2026-09-06 04:38:22'),
(17, 'Permissions', 'sub_menu', 'permissions', 11, '1,2,3,4,5,6', '2026-07-30 04:02:41', '2026-09-06 04:38:22'),
(19, 'Activities', 'sub_menu', 'activities', 7, '1,2,3,4', '2026-08-16 04:27:19', '2026-09-06 04:38:22'),
(20, 'Administrations', 'main_menu', NULL, 6, NULL, '2026-08-16 04:30:35', '2026-09-06 04:38:22'),
(21, 'Roles', 'sub_menu', 'roles', 8, '1,2,3,4', '2026-08-16 04:32:42', '2026-09-06 04:38:22'),
(22, 'Plot Types', 'sub_menu', 'plot_types', 14, '1,2,3,4,8', '2026-08-18 01:00:57', '2026-09-06 04:38:22'),
(23, 'People', 'main_menu', NULL, 1, NULL, '2026-08-18 01:02:23', '2026-09-06 04:38:22'),
(24, 'Plot And Units', 'sub_menu', 'plot_and_units', 2, '1,2,3,4,5', '2026-08-18 01:03:04', '2026-09-06 04:38:22'),
(25, 'Collection Management', 'main_menu', NULL, 3, NULL, '2026-08-18 01:03:38', '2026-09-06 04:38:49'),
(27, 'Collections', 'sub_menu', 'collections', 4, '1,3,4,8,9', '2026-08-19 02:38:56', '2026-09-06 04:38:22'),
(28, 'Users', 'sub_menu', 'users', 10, '1,2,3,4', '2026-09-01 23:23:24', '2026-09-06 04:38:22'),
(29, 'Roads', 'sub_menu', 'roads', 9, '1,2,3,4', '2026-09-03 03:37:44', '2026-09-06 04:38:22'),
(30, 'Collectors', 'sub_menu', 'collectors', 5, '1,3,4,10', '2026-09-06 04:38:17', '2026-09-06 04:42:21');

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
  `unique_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `road` int DEFAULT NULL,
  `holding_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `building_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_flat` int DEFAULT NULL,
  `occupied_flat` int DEFAULT NULL,
  `building_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `collection_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `collection_rate` decimal(10,2) DEFAULT NULL,
  `collection_amount` decimal(12,2) DEFAULT NULL,
  `discount` decimal(12,2) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `flat_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` tinyint(1) DEFAULT '0',
  `payment_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `plot_and_units`
--

INSERT INTO `plot_and_units` (`id`, `unique_id`, `road`, `holding_no`, `building_type`, `total_flat`, `occupied_flat`, `building_name`, `collection_type`, `collection_rate`, `collection_amount`, `discount`, `date`, `status`, `name`, `flat_no`, `number`, `email`, `payment_status`, `payment_date`, `created_at`, `updated_at`) VALUES
(14, 'UT0361/A1410', 6, '1/A', '10', 10, 8, 'Amicus', 'Group', 250.00, 1500.00, 500.00, '2026-09-11', 1, 'Ex Name', '01', '8801234567890', 'test@example.com', NULL, NULL, '2026-09-10 12:26:35', '2026-09-13 01:49:31'),
(59, 'UT0371/B590', 7, '1/B', '9', 0, 0, 'Nanadan kanon Haousing', 'Individual', 1500.00, 1000.00, 500.00, '2026-09-02', 1, 'Aminul Haque', '02', '8801970247545', 'aminul_h@live.com', 0, NULL, '2026-09-13 04:06:53', '2026-09-15 01:56:38'),
(60, 'UT0392/C6012', 9, '2/C', '10', 12, 10, 'Kolmi lata Housing', 'Group', 250.00, 2500.00, 0.00, '2026-09-03', 1, 'Rasel Miah', '01', '8801330563459', 'rasel@dev.com', 1, '2026-09-14', '2026-09-13 04:06:53', '2026-09-15 02:03:26');

-- --------------------------------------------------------

--
-- Table structure for table `plot_types`
--
CREATE TABLE `plot_types` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `amount` int DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `plot_types`
--

INSERT INTO `plot_types` (`id`, `name`, `amount`, `status`, `created_at`, `updated_at`) VALUES
(8, 'Empty Plot', 0, 1, '2026-08-17 23:09:57', '2026-08-17 23:09:57'),
(9, 'Under Construction', 1500, 1, '2026-08-17 23:10:17', '2026-08-25 05:16:09'),
(10, 'Apartment', 250, 1, '2026-08-17 23:10:31', '2026-08-25 05:15:55'),
(11, 'Owner Made Building', 250, 1, '2026-08-17 23:10:48', '2026-08-25 05:15:42'),
(12, 'Commercial Building', 1500, 1, '2026-08-17 23:11:05', '2026-08-25 05:15:25'),
(14, NULL, NULL, 1, '2026-09-13 03:57:36', '2026-09-13 03:57:36');

-- --------------------------------------------------------

--
-- Table structure for table `roads`
--
CREATE TABLE `roads` (
  `id` bigint UNSIGNED NOT NULL,
  `collector_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roads`
--

INSERT INTO `roads` (`id`, `collector_id`, `name`, `created_at`, `updated_at`) VALUES
(3, '10', 'Road 01', '2026-09-03 03:42:09', '2026-09-06 03:12:12'),
(4, '10', 'Road 02', '2026-09-03 03:45:35', '2026-09-06 03:12:12'),
(5, '10', 'Road 03', '2026-09-03 03:45:42', '2026-09-06 03:12:12'),
(6, '10', 'Road 04', '2026-09-03 03:45:48', '2026-09-06 03:12:12'),
(7, '10', 'Road 05', '2026-09-03 03:45:54', '2026-09-06 03:12:12'),
(8, '9', 'Road 06', '2026-09-03 03:46:06', '2026-09-06 03:12:37'),
(9, '9', 'Road 07', '2026-09-03 03:46:28', '2026-09-06 03:12:37'),
(10, '9', 'Road 07-A', '2026-09-03 03:56:19', '2026-09-06 03:12:37'),
(11, '9', 'Road 07-B', '2026-09-03 03:56:24', '2026-09-06 03:12:37'),
(12, '9', 'Road 07-C', '2026-09-03 03:56:31', '2026-09-06 03:12:37'),
(13, '9', 'Road 08', '2026-09-03 03:46:36', '2026-09-06 03:12:37'),
(14, '9', 'Road 09', '2026-09-03 03:46:43', '2026-09-06 03:12:37'),
(15, '9', 'Road 10', '2026-09-03 03:46:53', '2026-09-06 03:12:37'),
(16, NULL, 'Road 11', '2026-09-03 03:47:04', '2026-09-03 03:47:04'),
(17, NULL, 'Road 12', '2026-09-03 03:48:23', '2026-09-03 03:48:23'),
(18, NULL, 'Road 13', '2026-09-03 03:48:28', '2026-09-03 03:48:28'),
(19, NULL, 'Road 13-A', '2026-09-03 03:50:23', '2026-09-03 03:50:23'),
(20, NULL, 'Road 13-B', '2026-09-03 03:50:33', '2026-09-03 03:50:33'),
(21, NULL, 'Road 14', '2026-09-03 03:48:34', '2026-09-03 03:48:34'),
(22, NULL, 'Road 15', '2026-09-03 03:52:59', '2026-09-03 03:52:59'),
(23, NULL, 'Road 16', '2026-09-03 03:53:09', '2026-09-03 03:53:09'),
(24, NULL, 'Road 17', '2026-09-03 03:54:40', '2026-09-03 03:54:40'),
(25, NULL, 'Road 18', '2026-09-03 03:54:44', '2026-09-03 03:54:44'),
(26, NULL, 'Road 19', '2026-09-03 03:54:49', '2026-09-03 03:54:49'),
(27, NULL, 'Road 20', '2026-09-03 03:54:56', '2026-09-03 03:54:56'),
(1118, NULL, NULL, '2026-09-13 03:57:36', '2026-09-13 03:57:36');

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
(1, 'admin', '2025-08-12 13:37:14', '2025-08-12 13:45:45'),
(5, 'collector', '2026-09-01 22:45:40', '2026-09-01 22:45:40'),
(7, 'member', '2026-09-14 23:17:17', '2026-09-14 23:17:17');

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
(1319, 'admin', NULL, 24, 1, 'plot_and_units', '2026-09-06 04:46:28', '2026-09-06 04:46:28'),
(1320, 'admin', NULL, 24, 2, 'plot_and_units', '2026-09-06 04:46:28', '2026-09-06 04:46:28'),
(1321, 'admin', NULL, 24, 3, 'plot_and_units', '2026-09-06 04:46:28', '2026-09-06 04:46:28'),
(1322, 'admin', NULL, 24, 4, 'plot_and_units', '2026-09-06 04:46:28', '2026-09-06 04:46:28'),
(1323, 'admin', NULL, 24, 5, 'plot_and_units', '2026-09-06 04:46:28', '2026-09-06 04:46:28'),
(1324, 'admin', NULL, 27, 1, 'collections', '2026-09-06 04:46:28', '2026-09-06 04:46:28'),
(1325, 'admin', NULL, 27, 3, 'collections', '2026-09-06 04:46:28', '2026-09-06 04:46:28'),
(1326, 'admin', NULL, 27, 4, 'collections', '2026-09-06 04:46:28', '2026-09-06 04:46:28'),
(1327, 'admin', NULL, 27, 8, 'collections', '2026-09-06 04:46:28', '2026-09-06 04:46:28'),
(1328, 'admin', NULL, 27, 9, 'collections', '2026-09-06 04:46:28', '2026-09-06 04:46:28'),
(1329, 'admin', NULL, 30, 1, 'collectors', '2026-09-06 04:46:28', '2026-09-06 04:46:28'),
(1330, 'admin', NULL, 30, 3, 'collectors', '2026-09-06 04:46:28', '2026-09-06 04:46:28'),
(1331, 'admin', NULL, 30, 4, 'collectors', '2026-09-06 04:46:28', '2026-09-06 04:46:28'),
(1332, 'admin', NULL, 30, 10, 'collectors', '2026-09-06 04:46:28', '2026-09-06 04:46:28'),
(1333, 'admin', NULL, 19, 1, 'activities', '2026-09-06 04:46:28', '2026-09-06 04:46:28'),
(1334, 'admin', NULL, 19, 2, 'activities', '2026-09-06 04:46:28', '2026-09-06 04:46:28'),
(1335, 'admin', NULL, 19, 3, 'activities', '2026-09-06 04:46:28', '2026-09-06 04:46:28'),
(1336, 'admin', NULL, 19, 4, 'activities', '2026-09-06 04:46:28', '2026-09-06 04:46:28'),
(1337, 'admin', NULL, 21, 1, 'roles', '2026-09-06 04:46:28', '2026-09-06 04:46:28'),
(1338, 'admin', NULL, 21, 2, 'roles', '2026-09-06 04:46:28', '2026-09-06 04:46:28'),
(1339, 'admin', NULL, 21, 3, 'roles', '2026-09-06 04:46:28', '2026-09-06 04:46:28'),
(1340, 'admin', NULL, 21, 4, 'roles', '2026-09-06 04:46:28', '2026-09-06 04:46:28'),
(1341, 'admin', NULL, 29, 1, 'roads', '2026-09-06 04:46:28', '2026-09-06 04:46:28'),
(1342, 'admin', NULL, 29, 2, 'roads', '2026-09-06 04:46:28', '2026-09-06 04:46:28'),
(1343, 'admin', NULL, 29, 3, 'roads', '2026-09-06 04:46:28', '2026-09-06 04:46:28'),
(1344, 'admin', NULL, 29, 4, 'roads', '2026-09-06 04:46:28', '2026-09-06 04:46:28'),
(1345, 'admin', NULL, 28, 1, 'users', '2026-09-06 04:46:28', '2026-09-06 04:46:28'),
(1346, 'admin', NULL, 28, 2, 'users', '2026-09-06 04:46:28', '2026-09-06 04:46:28'),
(1347, 'admin', NULL, 28, 3, 'users', '2026-09-06 04:46:28', '2026-09-06 04:46:28'),
(1348, 'admin', NULL, 28, 4, 'users', '2026-09-06 04:46:28', '2026-09-06 04:46:28'),
(1349, 'admin', NULL, 17, 1, 'permissions', '2026-09-06 04:46:28', '2026-09-06 04:46:28'),
(1350, 'admin', NULL, 17, 2, 'permissions', '2026-09-06 04:46:28', '2026-09-06 04:46:28'),
(1351, 'admin', NULL, 17, 3, 'permissions', '2026-09-06 04:46:28', '2026-09-06 04:46:28'),
(1352, 'admin', NULL, 17, 4, 'permissions', '2026-09-06 04:46:28', '2026-09-06 04:46:28'),
(1353, 'admin', NULL, 17, 5, 'permissions', '2026-09-06 04:46:28', '2026-09-06 04:46:28'),
(1354, 'admin', NULL, 17, 6, 'permissions', '2026-09-06 04:46:28', '2026-09-06 04:46:28'),
(1355, 'admin', NULL, 13, 1, 'site_settings', '2026-09-06 04:46:28', '2026-09-06 04:46:28'),
(1356, 'admin', NULL, 22, 1, 'plot_types', '2026-09-06 04:46:28', '2026-09-06 04:46:28'),
(1357, 'admin', NULL, 22, 2, 'plot_types', '2026-09-06 04:46:28', '2026-09-06 04:46:28'),
(1358, 'admin', NULL, 22, 3, 'plot_types', '2026-09-06 04:46:28', '2026-09-06 04:46:28'),
(1359, 'admin', NULL, 22, 4, 'plot_types', '2026-09-06 04:46:28', '2026-09-06 04:46:28'),
(1360, 'admin', NULL, 22, 8, 'plot_types', '2026-09-06 04:46:28', '2026-09-06 04:46:28'),
(1367, 'collector', NULL, 27, 1, 'collections', '2026-09-06 05:42:03', '2026-09-06 05:42:03'),
(1368, 'collector', NULL, 27, 8, 'collections', '2026-09-06 05:42:03', '2026-09-06 05:42:03'),
(1369, 'collector', NULL, 27, 9, 'collections', '2026-09-06 05:42:03', '2026-09-06 05:42:03'),
(1370, 'collector', NULL, 30, 1, 'collectors', '2026-09-06 05:42:03', '2026-09-06 05:42:03'),
(1371, 'collector', NULL, 30, 3, 'collectors', '2026-09-06 05:42:03', '2026-09-06 05:42:03'),
(1372, 'collector', NULL, 30, 4, 'collectors', '2026-09-06 05:42:03', '2026-09-06 05:42:03'),
(1373, 'collector', NULL, 30, 10, 'collectors', '2026-09-06 05:42:03', '2026-09-06 05:42:03');

-- --------------------------------------------------------

--
-- Table structure for table `sector_collenctions`
--
CREATE TABLE `sector_collenctions` (
  `id` bigint UNSIGNED NOT NULL,
  `unique_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `road_id` int DEFAULT NULL,
  `holding_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `plot_and_unit_id` int DEFAULT NULL,
  `member_id` int DEFAULT NULL,
  `flat_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_status` tinyint NOT NULL DEFAULT '0',
  `payment_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sector_collenctions`
--

INSERT INTO `sector_collenctions` (`id`, `unique_id`, `road_id`, `holding_no`, `plot_and_unit_id`, `member_id`, `flat_no`, `number`, `email`, `amount`, `payment_status`, `payment_date`, `created_at`, `updated_at`) VALUES
(1, 'UT0365410', 6, '54', 4, 9, '10', '01234567890', 'test@test.com', 1000.00, 0, NULL, '2026-09-07 23:58:11', '2026-09-08 02:16:23'),
(2, 'UT0365411', 6, '54', 4, 9, '11', '01234567812', 'test2@test.com', 1000.00, 1, '2026-09-08', '2026-09-07 23:58:11', '2026-09-08 02:16:23'),
(3, 'UT03100515', 10, '05', 3, 10, '15', '01234567834', 'rakib@gmail.com', 1500.00, 0, NULL, '2026-09-08 02:35:06', '2026-09-08 02:35:06'),
(4, 'UT03100516', 10, '05', 3, 11, '16', '012345678335', 'sadia@gmail.com', 1500.00, 0, NULL, '2026-09-08 02:35:06', '2026-09-08 02:35:06'),
(5, 'UT03100517', 10, '05', 3, 12, '17', '01234567836', 'ranvir@gmail.com', 1500.00, 0, NULL, '2026-09-08 02:35:06', '2026-09-08 02:35:06'),
(20, 'UT03834122020', 8, '34', 12, 24, '11', '8801710872443', 'naeem@example.com', 2500.00, 0, NULL, '2026-09-09 03:53:31', '2026-09-09 03:53:39'),
(21, 'UT03834122021', 8, '34', 12, 23, '10', '8801610440622', 'mahiuddin@example.com', 2500.00, 0, NULL, '2026-09-09 03:53:39', '2026-09-09 03:53:47');

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
  `mail_from_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_from_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `copy_right` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `logo`, `address`, `contact`, `email`, `mail_driver`, `mail_host`, `mail_port`, `mail_username`, `mail_password`, `mail_encryption`, `mail_from_address`, `mail_from_name`, `copy_right`, `created_at`, `updated_at`) VALUES
(1, 'Sector 3 Welfare Society', '1787134206_default.png', 'House-10, Road-07, Sector-03, Uttara,Dhaka-1230, Bangladesh', '+8801234567890', 'info@sector3society.com', 'smtp', 'sandbox.smtp.mailtrap.io', 587, 'd1b3021b79c020', '32918f66f08d5c', 'tls', 'support@sector3society.com', 'Society Management System', NULL, '2026-04-01 04:18:14', '2026-08-25 03:21:42');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--
CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `uid` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'student',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `uid`, `role`, `name`, `username`, `email`, `phone`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, NULL, 'admin', 'Admin', 'admin', 'admin@example.com', NULL, '2025-08-02 10:49:38', '$2y$12$dmhp2VydIdIJvtBm8NR9I.MoS/HEhtWDJSPdUCPMS6I/ReKJEWK0e', 'p1mRQHJcNxuxARvzuw4u3ShPefpelAcEL39uKkAZbZ14KMPl9QMwNprzi67C', '2025-08-02 10:49:38', '2025-08-02 08:08:44'),
(9, NULL, 'collector', 'Naeem biswas', 'naeem', 'nayeembiswas@sector3.com', NULL, NULL, '$2y$12$WnDMkEfc7v8.CtDpKF6P6.3KnrMd5NPaSXOQB943Y8kRKxs2w5LhW', NULL, '2026-09-02 02:51:46', '2026-09-02 02:51:46'),
(10, NULL, 'collector', 'mahiuddin', 'mahiuddin', 'mahiuddin@test.com', NULL, NULL, '$2y$12$.nH1B9qV9T13m0IXTNMRA.Drl.iJ8A.SpPxm6LQ/hUjVXnTK/Rgd6', NULL, '2026-09-06 02:22:42', '2026-09-06 02:22:42'),
(17, 'UT0361/A1410', 'member', 'Ex Name', 'exname', 'test@example.com', '8801234567890', NULL, '$2y$12$gscCF7yAURrvKKvzxHORBuRHKX9nXGlDSTL1sFLiNHyzLAsoz/Tzm', NULL, '2026-09-15 00:21:38', '2026-09-15 00:22:15'),
(18, 'UT0371/B590', 'member', 'Aminul Haque', 'aminulhaque', 'aminul_h@live.com', '8801970247545', NULL, '$2y$12$shJWPj.9CZrjcyKThvNYb.0hB9h77JyVNoHeMo0IfIte82rtIqGEe', NULL, '2026-09-15 01:56:38', '2026-09-15 01:56:38'),
(19, 'UT0392/C6012', 'member', 'Rasel Miah', 'raselmiah', 'rasel@dev.com', '8801330563459', NULL, '$2y$12$wtk4WbbnolNKDMa1SgyAweVWSPtIsvzYt2vGnBvauMu0w6PyU0HU2', NULL, '2026-09-15 02:03:26', '2026-09-15 02:03:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `collections`
--
ALTER TABLE `collections`
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
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `roads`
--
ALTER TABLE `roads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

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
-- Indexes for table `sector_collenctions`
--
ALTER TABLE `sector_collenctions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sector_collenctions_unique_id_unique` (`unique_id`);

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
  ADD UNIQUE KEY `phone` (`phone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `collections`
--
ALTER TABLE `collections`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plot_and_units`
--
ALTER TABLE `plot_and_units`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `plot_types`
--
ALTER TABLE `plot_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `roads`
--
ALTER TABLE `roads`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1119;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1374;

--
-- AUTO_INCREMENT for table `sector_collenctions`
--
ALTER TABLE `sector_collenctions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `role_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
