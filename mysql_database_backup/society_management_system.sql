-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20260814.7ff5dd5b7e
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 17, 2026 at 05:49 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

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
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activity_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `name`, `activity_key`, `created_at`, `updated_at`) VALUES
(1, 'Access', 'access', '2025-08-08 00:48:56', '2025-08-08 00:48:56'),
(2, 'Create', 'create', '2025-08-07 18:29:27', '2025-08-08 01:07:08'),
(3, 'Edit', 'edit', '2025-08-08 00:58:43', '2025-08-08 00:58:43'),
(4, 'Delete', 'delete', '2025-08-08 02:16:10', '2025-08-08 02:16:10'),
(5, 'View', 'view', '2025-08-08 18:31:21', '2025-08-08 18:31:21'),
(6, 'Move', 'move', '2025-08-09 01:06:29', '2025-08-09 01:06:29'),
(8, 'Change Status', 'change_status', '2026-08-17 12:59:15', '2026-08-17 12:59:15'),
(9, 'Download', 'download', '2026-08-18 14:35:03', '2026-08-18 14:35:03'),
(10, 'Assign', 'assign', '2026-09-05 16:41:49', '2026-09-05 16:41:49'),
(11, 'Pay', 'pay', '2026-09-16 10:46:01', '2026-09-16 10:46:01'),
(12, 'Collect', 'collect', '2026-09-28 02:11:49', '2026-09-28 02:11:49');

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--
CREATE TABLE `bills` (
  `id` bigint UNSIGNED NOT NULL,
  `plot_and_unit_id` bigint UNSIGNED NOT NULL,
  `bill_number` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `billing_month` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `due_date` date NOT NULL,
  `plot_type_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `billing_units` int UNSIGNED NOT NULL DEFAULT '1',
  `rate_snapshot` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discount_snapshot` decimal(10,2) NOT NULL DEFAULT '0.00',
  `gross_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `net_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `paid_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` enum('Unpaid','Partial','Paid','Overdue') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Unpaid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`id`, `plot_and_unit_id`, `bill_number`, `billing_month`, `due_date`, `plot_type_name`, `billing_units`, `rate_snapshot`, `discount_snapshot`, `gross_amount`, `net_amount`, `paid_amount`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'BIL-112026-09-NL47', '2026-11', '2026-12-10', 'Empty Plot', 1, 0.00, 0.00, 0.00, 0.00, 0.00, 'Paid', '2026-11-16 04:24:31', '2026-11-16 04:24:31'),
(2, 2, 'BIL-112026-07-3FS7', '2026-11', '2026-12-10', 'Under Construction', 1, 1500.00, 0.00, 1500.00, 1500.00, 0.00, 'Unpaid', '2026-11-16 04:24:31', '2026-11-16 04:24:31'),
(3, 3, 'BIL-112026-18/C-DJWZ', '2026-11', '2026-12-10', 'Under Construction', 1, 1500.00, 0.00, 1500.00, 1500.00, 0.00, 'Unpaid', '2026-11-16 04:24:31', '2026-11-16 04:24:31'),
(4, 4, 'BIL-112026-12/A-XN0F', '2026-11', '2026-12-10', 'Apartment', 7, 250.00, 50.00, 1750.00, 1700.00, 0.00, 'Unpaid', '2026-11-16 04:24:31', '2026-11-16 04:24:31'),
(5, 5, 'BIL-112026-25/B-BVSQ', '2026-11', '2026-12-10', 'Apartment', 10, 250.00, 0.00, 2500.00, 2500.00, 0.00, 'Unpaid', '2026-11-16 04:24:31', '2026-11-16 04:24:31'),
(6, 6, 'BIL-112026-05-93TC', '2026-11', '2026-12-10', 'Apartment', 18, 250.00, 500.00, 4500.00, 4000.00, 0.00, 'Unpaid', '2026-11-16 04:24:31', '2026-11-16 04:24:31'),
(7, 7, 'BIL-112026-03-7JMZ', '2026-11', '2026-12-10', 'Apartment', 8, 250.00, 200.00, 2000.00, 1800.00, 0.00, 'Unpaid', '2026-11-16 04:24:31', '2026-11-16 04:24:31'),
(8, 8, 'BIL-112026-08-BUGC', '2026-11', '2026-12-10', 'Owner', 4, 250.00, 0.00, 1000.00, 1000.00, 0.00, 'Unpaid', '2026-11-16 04:24:31', '2026-11-16 04:24:31'),
(9, 9, 'BIL-112026-02-PUNZ', '2026-11', '2026-12-10', 'Owner', 2, 250.00, 0.00, 500.00, 500.00, 0.00, 'Unpaid', '2026-11-16 04:24:31', '2026-11-16 04:24:31'),
(10, 10, 'BIL-112026-14-PSEK', '2026-11', '2026-12-10', 'Commercial', 5, 1500.00, 500.00, 7500.00, 7000.00, 0.00, 'Unpaid', '2026-11-16 04:24:31', '2026-11-16 04:24:31');

-- --------------------------------------------------------

--
-- Table structure for table `bulksms`
--
CREATE TABLE `bulksms` (
  `id` bigint UNSIGNED NOT NULL,
  `phone_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sms_type` enum('custom','draft') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `draft_id` int DEFAULT NULL,
  `language` enum('english','bangla') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `custom_sms` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sending_method` enum('send_now','scheduled_message') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `schedule_time` datetime DEFAULT NULL,
  `status` enum('canceled','sent') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bulksms`
--

INSERT INTO `bulksms` (`id`, `phone_no`, `sms_type`, `draft_id`, `language`, `custom_sms`, `sending_method`, `schedule_time`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, 'custom', NULL, 'english', 'hello', NULL, NULL, 'canceled', '2026-10-07 00:09:07', '2026-10-07 00:09:07'),
(2, NULL, 'custom', NULL, 'english', 'hello', NULL, NULL, 'canceled', '2026-10-07 00:13:05', '2026-10-07 00:13:05'),
(3, NULL, 'custom', NULL, 'english', 'test', NULL, NULL, 'canceled', '2026-10-07 00:13:25', '2026-10-07 00:13:25'),
(4, NULL, 'custom', NULL, 'english', 'test', NULL, NULL, 'canceled', '2026-10-07 00:15:19', '2026-10-07 00:15:19'),
(5, NULL, 'custom', NULL, 'english', 'Hello Naeem vai. Please find a buffet restaurant near Uttara. Thank you', NULL, NULL, 'canceled', '2026-10-07 00:17:48', '2026-10-07 00:17:48'),
(6, NULL, 'custom', NULL, 'english', 'test', NULL, NULL, 'canceled', '2026-10-07 00:19:46', '2026-10-07 00:19:46'),
(13, '8801610440622', 'draft', 1, 'english', NULL, NULL, NULL, 'sent', '2026-10-12 03:37:47', '2026-10-12 03:37:47'),
(14, '8801710872443', 'draft', 1, 'english', NULL, NULL, NULL, 'sent', '2026-10-12 03:37:47', '2026-10-12 03:37:47'),
(15, '8801945678901', 'draft', 1, 'english', NULL, NULL, NULL, 'sent', '2026-10-12 03:37:47', '2026-10-12 03:37:47'),
(16, '8801711111111', 'draft', 1, 'english', NULL, NULL, NULL, 'sent', '2026-10-12 03:37:47', '2026-10-12 03:37:47'),
(17, '8801933333333', 'draft', 1, 'english', NULL, NULL, NULL, 'sent', '2026-10-12 03:37:47', '2026-10-12 03:37:47'),
(18, '8801555555555', 'draft', 1, 'english', NULL, NULL, NULL, 'sent', '2026-10-12 03:37:47', '2026-10-12 03:37:47'),
(19, '8801567890123', 'draft', 1, 'english', NULL, NULL, NULL, 'sent', '2026-10-12 03:37:47', '2026-10-12 03:37:47'),
(20, '8801744866016', 'draft', 1, 'english', NULL, NULL, NULL, 'sent', '2026-10-12 03:37:47', '2026-10-12 03:37:47'),
(23, '8801610440622', 'custom', NULL, 'english', 'this is a single test message', NULL, NULL, 'canceled', '2026-10-12 04:29:22', '2026-10-12 04:29:22'),
(24, '8801610440622', 'custom', NULL, 'english', 'test', NULL, NULL, 'sent', '2026-10-12 04:36:36', '2026-10-12 04:36:36'),
(25, '8801610440622', 'custom', NULL, 'english', 'test', NULL, NULL, 'sent', '2026-10-12 04:37:52', '2026-10-12 04:37:52'),
(26, '8801610440622', 'custom', NULL, 'english', 'hello noyon', NULL, NULL, 'sent', '2026-11-16 08:01:34', '2026-11-16 08:01:34'),
(27, '8801760440622', 'custom', NULL, 'english', 'Dear Abdul Mannan,\r\nYour outstanding dues for the month of N/A is 0.00 or 0.00. please pay in time', NULL, NULL, 'sent', '2026-11-16 08:03:40', '2026-11-16 08:03:40'),
(28, '8801760440622', 'custom', NULL, 'english', 'Hello Abdul Mannan', NULL, NULL, 'sent', '2026-11-16 08:03:50', '2026-11-16 08:03:50'),
(29, '8801760440622', 'custom', NULL, 'english', 'Hello Abdul Mannan, This is a test message with amount 0.00 and due month is N/A. Thank you', NULL, NULL, 'sent', '2026-11-16 08:04:01', '2026-11-16 08:04:01'),
(30, '8801610440622', 'custom', NULL, 'english', 'Hello Engr. Kamal Hossain, This is a test message with amount 1500.00 and due month is November 2026. Thank you', NULL, NULL, 'sent', '2026-11-16 08:04:12', '2026-11-16 08:04:12'),
(31, '8801610440622', 'custom', NULL, 'english', 'test', NULL, NULL, 'sent', '2026-11-16 08:04:22', '2026-11-16 08:04:22'),
(32, '8801760440622', 'custom', NULL, 'english', 'hello', NULL, NULL, 'sent', '2026-11-16 08:04:32', '2026-11-16 08:04:32'),
(33, '8801610440622', 'custom', NULL, 'english', 'hello', NULL, NULL, 'sent', '2026-11-16 08:04:42', '2026-11-16 08:04:42');

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
-- Table structure for table `dashboard_notification_reads`
--
CREATE TABLE `dashboard_notification_reads` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `notification_key` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `viewed_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dashboard_notification_reads`
--

INSERT INTO `dashboard_notification_reads` (`id`, `user_id`, `notification_key`, `viewed_at`) VALUES
(1, 1, 'bill_month-2026-11', '2026-11-16 08:22:23'),
(2, 1, 'plot-1', '2026-11-16 08:22:23'),
(3, 1, 'plot-3', '2026-11-16 08:22:23'),
(4, 1, 'plot-4', '2026-11-16 08:22:23'),
(5, 1, 'plot-5', '2026-11-16 08:22:23'),
(6, 1, 'plot-6', '2026-11-16 08:22:23'),
(7, 1, 'plot-7', '2026-11-16 08:22:23'),
(8, 1, 'plot-8', '2026-11-16 08:22:23'),
(9, 1, 'plot-9', '2026-11-16 08:22:23'),
(10, 1, 'plot-10', '2026-11-16 08:22:23'),
(11, 1, 'plot-2', '2026-11-16 08:22:23');

-- --------------------------------------------------------

--
-- Table structure for table `drafts`
--
CREATE TABLE `drafts` (
  `id` bigint UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `language` enum('Bangla','English') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `length` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `drafts`
--

INSERT INTO `drafts` (`id`, `type`, `message`, `language`, `length`, `created_at`, `updated_at`) VALUES
(1, 'Invoice', 'Dear customer, your monthly invoice is ready. Please make your payment within the due date.', 'English', 99, '2026-11-12 05:18:56', '2026-11-12 05:18:56'),
(2, 'Payment Reminder', 'Dear customer, this is a reminder that your payment is due. Please complete your payment on time.', 'English', 101, '2026-11-12 05:18:56', '2026-11-12 05:18:56'),
(3, 'Notice', 'প্রিয় গ্রাহক, আপনার মাসিক বিল পরিশোধের সময় হয়েছে। নির্ধারিত সময়ের মধ্যে বিল পরিশোধ করুন।', 'Bangla', 88, '2026-11-12 05:18:56', '2026-11-12 05:18:56'),
(4, 'Collection', 'Dear customer, our collection representative will visit your area for monthly collection.', 'English', 89, '2026-11-12 05:18:56', '2026-11-12 05:18:56');

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
-- Table structure for table `jobs`
--
CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--
CREATE TABLE `members` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `flat_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `name`, `flat_no`, `number`, `email`, `amount`, `created_at`, `updated_at`) VALUES
(9, 'Nusrat Jahan', '202', '01823456789', 'nusrat.jahan@example.com', 0.00, '2026-09-08 03:49:34', '2026-09-08 03:49:34'),
(10, 'Md. Rakib Hasan', '303', '01934567890', 'rakib@example.com', 0.00, '2026-09-08 03:49:34', '2026-09-08 03:49:34'),
(11, 'Sadia Rahman', '404', '01645678901', 'sadia.rahman@example.com', 0.00, '2026-09-08 03:49:34', '2026-09-08 03:49:34'),
(12, 'Tanvir Ahmed', '505', '01556789012', 'tanvir.ahmed@example.com', 0.00, '2026-09-08 03:49:34', '2026-09-08 03:49:34'),
(13, 'Farhan Hossain', '606', '01767890123', 'farhan.hossain@example.com', 0.00, '2026-09-07 21:49:50', '2026-09-07 21:49:50'),
(14, 'Mim Akter', '707', '01878901234', 'mim.akter@example.com', 0.00, '2026-09-07 21:49:50', '2026-09-07 21:49:50'),
(15, 'Shakil Ahmed', '808', '01989012345', 'shakil.ahmed@example.com', 0.00, '2026-09-07 21:49:50', '2026-09-07 21:49:50'),
(16, 'Jannatul Ferdous', '909', '01690123456', 'jannatul.ferdous@example.com', 0.00, '2026-09-07 21:49:50', '2026-09-07 21:49:50'),
(17, 'Imran Kabir', '110', '01501234567', 'imran.kabir@example.com', 0.00, '2026-09-07 21:49:50', '2026-09-07 21:49:50'),
(18, 'Rafiul Islam', '111', '01711223344', 'rafiul.islam@example.com', 0.00, '2026-09-07 21:49:50', '2026-09-07 21:49:50'),
(19, 'Tania Sultana', '112', '01822334455', 'tania.sultana@example.com', 0.00, '2026-09-07 21:49:50', '2026-09-07 21:49:50'),
(20, 'Mahmud Hasan', '113', '01933445566', 'mahmud.hasan@example.com', 0.00, '2026-09-07 21:49:50', '2026-09-07 21:49:50'),
(21, 'Priya Das', '114', '01644556677', 'priya.das@example.com', 0.00, '2026-09-07 21:49:50', '2026-09-07 21:49:50'),
(22, 'Arif Rahman', '115', '01555667788', 'arif.rahman@example.com', 0.00, '2026-09-07 21:49:50', '2026-09-07 21:49:50'),
(23, 'Md Mahiuddin', '10', '01610440622', 'mahiuddin@example.com', 0.00, '2026-09-08 18:59:47', '2026-09-08 18:59:47'),
(24, 'Naeem Biswas', '11', '01710872443', 'naeem@example.com', 0.00, '2026-09-08 19:00:46', '2026-09-08 19:00:46');

-- --------------------------------------------------------

--
-- Table structure for table `member_login_otps`
--
CREATE TABLE `member_login_otps` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `otp_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expires_at` timestamp NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2025_08_03_201440_create_permissions_table', 1),
(7, '2025_08_03_201552_create_role_permissions_table', 1),
(8, '2025_08_08_062716_create_activities_table', 1),
(9, '2025_08_12_191731_create_roles_table', 1),
(10, '2026_08_13_085722_create_roads_table', 1),
(11, '2026_08_13_085723_create_plot_types_table', 1),
(12, '2026_08_13_085724_create_plot_and_units_table', 1),
(13, '2026_08_16_062600_create_members_table', 1),
(14, '2026_08_18_050126_create_collections_table', 1),
(15, '2026_09_08_044553_create_sector_collenctions_table', 1),
(16, '2026_09_20_052306_create_settings_table', 1),
(17, '2026_09_22_074803_create_bills_table', 1),
(18, '2026_09_22_081714_create_payments_table', 1),
(19, '2026_09_23_124139_create_drafts_table', 1),
(20, '2026_09_29_112140_create_bulksms_table', 1),
(21, '2026_10_07_133949_create_jobs_table', 1),
(22, '2026_10_13_112019_create_member_login_otps_table', 1),
(23, '2026_10_15_120000_create_dashboard_notification_reads_table', 1),
(24, '2026_10_15_131000_add_import_batch_id_to_plot_and_units_table', 1),
(25, '2026_11_08_000000_add_login_background_images_to_settings_table', 1),
(26, '2026_11_09_000000_create_missing_flats_table', 1),
(27, '2026_11_09_010000_add_missing_flat_note_to_plot_and_units_table', 1),
(28, '2026_11_09_020000_move_missing_flat_note_to_missing_flats_table', 1),
(29, '2026_11_12_000000_add_profile_image_to_users_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `missing_flats`
--
CREATE TABLE `missing_flats` (
  `id` bigint UNSIGNED NOT NULL,
  `plot_and_unit_id` bigint UNSIGNED NOT NULL,
  `flat_number` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci
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
-- Table structure for table `password_reset_tokens`
--
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('admin@example.com', '$2y$12$RQxDrG39UVwkTpI8kRbUruUHnb1gO9Tri4RXYNbDKMhcACx.2OaXy', '2025-08-12 06:18:29');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--
CREATE TABLE `payments` (
  `id` bigint UNSIGNED NOT NULL,
  `bill_id` bigint UNSIGNED NOT NULL,
  `payment_number` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` date NOT NULL,
  `method` enum('Cash','bKash','Nagad','Bank Transfer','Cheque') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Cash',
  `transaction_ref` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `received_by` bigint UNSIGNED DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--
CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_no` int DEFAULT NULL,
  `activity_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `menu_type`, `menu_key`, `order_no`, `activity_id`, `created_at`, `updated_at`) VALUES
(12, 'Settings', 'main_menu', NULL, 28, NULL, '2026-07-29 08:15:32', '2026-10-29 08:29:06'),
(13, 'Site Settings', 'sub_menu', 'site_settings', 30, '1', '2026-07-29 08:16:34', '2026-10-29 08:29:06'),
(17, 'Permissions', 'sub_menu', 'permissions', 24, '1,2,3,4,5,6', '2026-07-29 10:02:41', '2026-10-29 08:29:06'),
(19, 'Activities', 'sub_menu', 'activities', 20, '1,2,3,4', '2026-08-15 10:27:19', '2026-10-29 08:29:06'),
(20, 'Administrations', 'main_menu', NULL, 19, NULL, '2026-08-15 10:30:35', '2026-10-29 08:29:06'),
(21, 'Roles', 'sub_menu', 'roles', 21, '1,2,3,4', '2026-08-15 10:32:42', '2026-10-29 08:29:06'),
(22, 'Plot Types', 'sub_menu', 'plot_types', 29, '1,2,3,4,8', '2026-08-17 07:00:57', '2026-10-29 08:29:06'),
(23, 'People', 'main_menu', NULL, 1, NULL, '2026-08-17 07:02:23', '2026-10-29 08:29:06'),
(24, 'Plot And Units', 'sub_menu', 'plot_and_units', 2, '1,2,3,4,5', '2026-08-17 07:03:04', '2026-10-29 08:29:06'),
(25, 'Collection Management', 'main_menu', NULL, 7, NULL, '2026-08-17 07:03:38', '2026-10-29 08:29:06'),
(27, 'Payments', 'sub_menu', 'collections', 9, '1,9', '2026-08-18 08:38:56', '2026-10-29 08:29:06'),
(28, 'Users', 'sub_menu', 'users', 23, '1,2,3,4', '2026-09-01 05:23:24', '2026-10-29 08:29:06'),
(29, 'Roads', 'sub_menu', 'roads', 22, '1,2,3,4', '2026-09-02 09:37:44', '2026-10-29 08:29:06'),
(30, 'Collectors', 'sub_menu', 'collectors', 10, '1,3,4,10', '2026-09-05 10:38:17', '2026-10-29 08:29:06'),
(31, 'Upoad Members', 'sub_menu', 'upload_members', 3, '1', '2026-09-15 08:49:18', '2026-10-29 08:29:06'),
(32, 'Payment Management', 'main_menu', NULL, 4, NULL, '2026-09-16 04:42:35', '2026-10-29 08:29:06'),
(33, 'My Payments', 'sub_menu', 'my_payments', 5, '1,9,11', '2026-09-16 04:46:21', '2026-10-29 08:29:06'),
(36, 'Payments Report', 'sub_menu', 'payments_report', 6, '1,9', '2026-09-16 05:01:27', '2026-10-29 08:29:06'),
(37, 'Bill Collections', 'sub_menu', 'bill_generator', 8, '1,2,12', '2026-09-27 20:13:06', '2026-10-29 08:29:06'),
(38, 'SMS Managements', 'main_menu', NULL, 11, NULL, '2026-09-27 20:14:27', '2026-10-29 08:29:06'),
(39, 'Bulksms', 'sub_menu', 'bulk_sms', 12, '1', '2026-09-27 20:22:19', '2026-10-29 08:29:06'),
(40, 'Draft SMS', 'sub_menu', 'draft_sms', 13, '1,2,3,4', '2026-09-27 20:23:03', '2026-10-29 08:29:06'),
(41, 'SMS History', 'sub_menu', 'sms_history', 14, '1,9', '2026-09-27 20:40:41', '2026-10-29 08:29:06'),
(42, 'Access Control', 'main_menu', NULL, 25, NULL, '2026-09-27 22:39:02', '2026-10-29 08:29:06'),
(43, 'Role Wise Permission', 'sub_menu', 'role_permission', 26, '1', '2026-09-27 22:39:36', '2026-10-29 08:29:06'),
(44, 'User Wise Permission', 'sub_menu', 'user_permission', 27, '1', '2026-09-27 22:40:16', '2026-10-29 08:29:06'),
(45, 'Report Management', 'main_menu', NULL, 15, NULL, '2026-10-29 08:25:48', '2026-10-29 08:29:06'),
(46, 'Plot Report', 'sub_menu', 'plot_report', 16, '1,9', '2026-10-29 08:27:04', '2026-10-29 08:29:06'),
(47, 'Bulk Report', 'sub_menu', 'bulk_report', 18, '1,9', '2026-10-29 08:27:32', '2026-10-29 08:29:06'),
(48, 'Bill Report', 'sub_menu', 'bill_report', 17, '1,9', '2026-10-29 08:28:04', '2026-10-29 08:29:06');

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
-- Table structure for table `plot_and_units`
--
CREATE TABLE `plot_and_units` (
  `id` bigint UNSIGNED NOT NULL,
  `plot_type_id` bigint UNSIGNED NOT NULL,
  `road_id` bigint UNSIGNED NOT NULL,
  `unique_id` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(254) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `flat_no` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `holding_no` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `building_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Optional for plots/vacant land',
  `total_flat` smallint UNSIGNED DEFAULT '0',
  `occupied_flat` smallint UNSIGNED DEFAULT '0',
  `flat_numbers` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Comma-separated flat tags e.g. 2A,2B,3A,3C',
  `collection_type` enum('Group','Individual') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `collection_rate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `discount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `status` enum('Active','Inactive','Hold','Archived') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `import_batch_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `plot_and_units`
--

INSERT INTO `plot_and_units` (`id`, `plot_type_id`, `road_id`, `unique_id`, `name`, `email`, `phone`, `flat_no`, `holding_no`, `building_name`, `total_flat`, `occupied_flat`, `flat_numbers`, `collection_type`, `collection_rate`, `total_amount`, `discount`, `status`, `created_at`, `updated_at`, `import_batch_id`) VALUES
(1, 1, 4, 'UTR03-0409-EMT', 'Abdul Mannan', NULL, '01760440622', NULL, '09', NULL, 0, 0, NULL, 'Individual', 0.00, 0.00, 0.00, 'Active', '2026-11-12 05:18:53', '2026-11-12 05:18:53', NULL),
(2, 2, 1, 'UTR03-0107-CONS', 'Engr. Kamal Hossain', 'kamal@example.com', '01610440622', NULL, '07', 'Green Horizon', 0, 0, NULL, 'Individual', 1500.00, 1500.00, 0.00, 'Active', '2026-08-04 05:18:53', '2026-08-04 05:18:53', NULL),
(3, 2, 5, 'UTR03-0518/C-CONS', 'Barrister Shahriar Kabir', 'shahriar@kabir-law.com', '01945678901', NULL, '18/C', 'Skyline Heights', 0, 0, NULL, 'Individual', 1500.00, 1500.00, 0.00, 'Active', '2026-11-12 05:18:53', '2026-11-12 05:18:53', NULL),
(4, 3, 1, 'UTR03-0112/A-1A', 'Md. Rahim Uddin', 'rahim@example.com', '01711111111', '1A', '12/A', 'Rahim Tower', 8, 7, '1A,1B,2A,2B,3A,3B,4A,4B', 'Group', 250.00, 1700.00, 50.00, 'Active', '2026-11-12 05:18:53', '2026-11-12 05:18:53', NULL),
(5, 3, 2, 'UTR03-0225/B-3B', 'Fatema Khatun', 'fatema@example.com', '01933333333', '3B', '25/B', 'Fatema Heights', 12, 10, '1A,1B,2A,2B,3A,3B,4A,4B,5A,5B,6A,6B', 'Individual', 250.00, 2500.00, 0.00, 'Active', '2026-11-12 05:18:53', '2026-11-12 05:18:53', NULL),
(6, 3, 3, 'UTR03-0305-2A', 'Nusrat Jahan', 'nusrat@example.com', '01555555555', '2A', '05', 'Jahan Palace', 20, 18, '1A,1B,2A,2B,3A,3B,4A,4B,5A,5B', 'Group', 250.00, 4000.00, 500.00, 'Active', '2026-11-12 05:18:53', '2026-11-12 05:18:53', NULL),
(7, 3, 6, 'UTR03-0603-3A', 'Mahbubur Rahman', 'mahbub.rahman@example.com', '01567890123', '3A', '03', 'Rose Wood Residency', 10, 8, '1A,1B,2A,2B,3A,3B,4A,4B,5A,5B', 'Group', 250.00, 1800.00, 200.00, 'Active', '2026-11-12 05:18:53', '2026-11-12 05:18:53', NULL),
(8, 4, 2, 'UTR03-0208-2A', 'Imtiaz Ahmed Khan', 'imtiaz.khan@example.com', '01834567890', '2A', '08', 'Khan Bhaban', 4, 4, '1A,1B,2A,2B', 'Individual', 250.00, 1000.00, 0.00, 'Active', '2026-11-12 05:18:53', '2026-11-12 05:18:53', NULL),
(9, 4, 7, 'UTR03-0702-2B', 'Kabir Chowdhury', 'kabir.chowdhury@example.com', '01799887766', '2B', '02', 'Chowdhury Villa', 2, 2, '2A,2B', 'Individual', 250.00, 500.00, 0.00, 'Active', '2026-11-12 05:18:53', '2026-11-12 05:18:53', NULL),
(10, 5, 3, 'UTR03-0314-7C', 'Tariqul Islam', 'tariqul@commercial.com', '01712345678', '7C', '14', 'Sector 3 Commercial Plaza', 6, 5, 'Shop-1,Shop-2,Office-1,Office-2,Office-3', 'Group', 1500.00, 7000.00, 500.00, 'Active', '2026-11-12 05:18:53', '2026-11-12 05:18:53', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `plot_types`
--
CREATE TABLE `plot_types` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `fees` decimal(10,2) NOT NULL,
  `status` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active' COMMENT 'Status: Active/Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `plot_types`
--

INSERT INTO `plot_types` (`id`, `name`, `slug`, `description`, `fees`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Empty Plot', 'empty-plot', 'Vacant ground awaiting building development', 0.00, 'Active', NULL, NULL),
(2, 'Under Construction', 'under-construction', 'Ongoing site development in progress', 1500.00, 'Active', NULL, NULL),
(3, 'Apartment', 'apartment', 'Multi-unit residential society housing space', 250.00, 'Active', NULL, NULL),
(4, 'Owner', 'owner', 'Private residence occupied by owner', 250.00, 'Active', NULL, NULL),
(5, 'Commercial', 'commercial', 'Dedicated space for business operations', 1500.00, 'Active', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roads`
--
CREATE TABLE `roads` (
  `id` bigint UNSIGNED NOT NULL,
  `collector_id` bigint UNSIGNED DEFAULT NULL,
  `number` varchar(21) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roads`
--

INSERT INTO `roads` (`id`, `collector_id`, `number`, `created_at`, `updated_at`) VALUES
(1, 10, '01', NULL, NULL),
(2, 10, '02', NULL, NULL),
(3, 10, '03', NULL, NULL),
(4, 10, '04', NULL, NULL),
(5, 10, '05', NULL, NULL),
(6, 10, '06', NULL, NULL),
(7, 10, '07', NULL, NULL),
(8, 10, '07/A', NULL, NULL),
(9, 10, '07/B', NULL, NULL),
(10, 10, '07/C', NULL, NULL),
(11, 10, '08', NULL, NULL),
(12, 10, '09', NULL, NULL),
(13, 10, '10', NULL, NULL),
(14, NULL, '11', NULL, NULL),
(15, NULL, '12', NULL, NULL),
(16, NULL, '13', NULL, NULL),
(17, NULL, '13/A', NULL, NULL),
(18, NULL, '13/B', NULL, NULL),
(19, NULL, '14', NULL, NULL),
(20, NULL, '15', NULL, NULL),
(21, NULL, '16', NULL, NULL),
(22, NULL, '17', NULL, NULL),
(23, NULL, '18', NULL, NULL),
(24, NULL, '19', NULL, NULL),
(25, NULL, '20', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--
CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2025-08-12 07:37:14', '2025-08-12 07:45:45'),
(5, 'collector', '2026-09-01 16:45:40', '2026-09-01 16:45:40'),
(7, 'member', '2026-09-14 17:17:17', '2026-09-14 17:17:17');

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--
CREATE TABLE `role_permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `permission_id` bigint UNSIGNED DEFAULT NULL,
  `activity_id` int DEFAULT NULL,
  `menu_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`id`, `role`, `user_id`, `permission_id`, `activity_id`, `menu_key`, `created_at`, `updated_at`) VALUES
(1563, 'collector', NULL, 27, 1, 'collections', '2026-09-16 17:09:25', '2026-09-16 17:09:25'),
(1564, 'collector', NULL, 27, 8, 'collections', '2026-09-16 17:09:25', '2026-09-16 17:09:25'),
(1565, 'collector', NULL, 27, 9, 'collections', '2026-09-16 17:09:25', '2026-09-16 17:09:25'),
(1623, 'member', NULL, 33, 1, 'my_payments', '2026-09-16 17:25:53', '2026-09-16 17:25:53'),
(1624, 'member', NULL, 33, 9, 'my_payments', '2026-09-16 17:25:53', '2026-09-16 17:25:53'),
(1625, 'member', NULL, 33, 11, 'my_payments', '2026-09-16 17:25:53', '2026-09-16 17:25:53'),
(1626, 'member', NULL, 36, 1, 'payments_report', '2026-09-16 17:25:53', '2026-09-16 17:25:53'),
(1627, 'member', NULL, 36, 9, 'payments_report', '2026-09-16 17:25:53', '2026-09-16 17:25:53'),
(1678, 'admin', NULL, 24, 1, 'plot_and_units', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1679, 'admin', NULL, 24, 2, 'plot_and_units', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1680, 'admin', NULL, 24, 3, 'plot_and_units', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1681, 'admin', NULL, 24, 4, 'plot_and_units', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1682, 'admin', NULL, 24, 5, 'plot_and_units', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1683, 'admin', NULL, 31, 1, 'upload_members', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1684, 'admin', NULL, 33, 1, 'my_payments', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1685, 'admin', NULL, 33, 9, 'my_payments', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1686, 'admin', NULL, 33, 11, 'my_payments', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1687, 'admin', NULL, 36, 1, 'payments_report', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1688, 'admin', NULL, 36, 9, 'payments_report', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1689, 'admin', NULL, 37, 1, 'bill_generator', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1690, 'admin', NULL, 37, 2, 'bill_generator', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1691, 'admin', NULL, 37, 12, 'bill_generator', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1692, 'admin', NULL, 27, 1, 'collections', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1693, 'admin', NULL, 27, 9, 'collections', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1694, 'admin', NULL, 30, 1, 'collectors', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1695, 'admin', NULL, 30, 3, 'collectors', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1696, 'admin', NULL, 30, 4, 'collectors', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1697, 'admin', NULL, 30, 10, 'collectors', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1698, 'admin', NULL, 39, 1, 'bulk_sms', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1699, 'admin', NULL, 40, 1, 'draft_sms', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1700, 'admin', NULL, 40, 2, 'draft_sms', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1701, 'admin', NULL, 40, 3, 'draft_sms', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1702, 'admin', NULL, 40, 4, 'draft_sms', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1703, 'admin', NULL, 41, 1, 'sms_history', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1704, 'admin', NULL, 41, 9, 'sms_history', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1705, 'admin', NULL, 46, 1, 'plot_report', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1706, 'admin', NULL, 46, 9, 'plot_report', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1707, 'admin', NULL, 48, 1, 'bill_report', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1708, 'admin', NULL, 48, 9, 'bill_report', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1709, 'admin', NULL, 47, 1, 'bulk_report', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1710, 'admin', NULL, 47, 9, 'bulk_report', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1711, 'admin', NULL, 19, 1, 'activities', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1712, 'admin', NULL, 19, 2, 'activities', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1713, 'admin', NULL, 19, 3, 'activities', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1714, 'admin', NULL, 19, 4, 'activities', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1715, 'admin', NULL, 21, 1, 'roles', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1716, 'admin', NULL, 21, 2, 'roles', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1717, 'admin', NULL, 21, 3, 'roles', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1718, 'admin', NULL, 21, 4, 'roles', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1719, 'admin', NULL, 29, 1, 'roads', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1720, 'admin', NULL, 29, 2, 'roads', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1721, 'admin', NULL, 29, 3, 'roads', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1722, 'admin', NULL, 29, 4, 'roads', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1723, 'admin', NULL, 28, 1, 'users', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1724, 'admin', NULL, 28, 2, 'users', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1725, 'admin', NULL, 28, 3, 'users', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1726, 'admin', NULL, 28, 4, 'users', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1727, 'admin', NULL, 17, 1, 'permissions', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1728, 'admin', NULL, 17, 2, 'permissions', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1729, 'admin', NULL, 17, 3, 'permissions', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1730, 'admin', NULL, 17, 4, 'permissions', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1731, 'admin', NULL, 17, 5, 'permissions', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1732, 'admin', NULL, 17, 6, 'permissions', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1733, 'admin', NULL, 43, 1, 'role_permission', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1734, 'admin', NULL, 44, 1, 'user_permission', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1735, 'admin', NULL, 22, 1, 'plot_types', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1736, 'admin', NULL, 22, 2, 'plot_types', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1737, 'admin', NULL, 22, 3, 'plot_types', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1738, 'admin', NULL, 22, 4, 'plot_types', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1739, 'admin', NULL, 22, 8, 'plot_types', '2026-11-16 04:24:14', '2026-11-16 04:24:14'),
(1740, 'admin', NULL, 13, 1, 'site_settings', '2026-11-16 04:24:14', '2026-11-16 04:24:14');

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
(1, 'UT0365410', 6, '54', 4, 9, '10', '01234567890', 'test@test.com', 1000.00, 0, NULL, '2026-09-07 17:58:11', '2026-09-07 20:16:23'),
(2, 'UT0365411', 6, '54', 4, 9, '11', '01234567812', 'test2@test.com', 1000.00, 1, '2026-09-08', '2026-09-07 17:58:11', '2026-09-07 20:16:23'),
(3, 'UT03100515', 10, '5', 3, 10, '15', '01234567834', 'rakib@gmail.com', 1500.00, 0, NULL, '2026-09-07 20:35:06', '2026-09-07 20:35:06'),
(4, 'UT03100516', 10, '5', 3, 11, '16', '012345678335', 'sadia@gmail.com', 1500.00, 0, NULL, '2026-09-07 20:35:06', '2026-09-07 20:35:06'),
(5, 'UT03100517', 10, '5', 3, 12, '17', '01234567836', 'ranvir@gmail.com', 1500.00, 0, NULL, '2026-09-07 20:35:06', '2026-09-07 20:35:06'),
(20, 'UT03834122020', 8, '34', 12, 24, '11', '8801710872443', 'naeem@example.com', 2500.00, 0, NULL, '2026-09-08 21:53:31', '2026-09-08 21:53:39'),
(21, 'UT03834122021', 8, '34', 12, 23, '10', '8801610440622', 'mahiuddin@example.com', 2500.00, 0, NULL, '2026-09-08 21:53:39', '2026-09-08 21:53:47');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--
CREATE TABLE `settings` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `login_background_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `login_panel_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_driver` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_host` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_port` int NOT NULL,
  `mail_username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_encryption` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_from_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_from_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `copy_right` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `logo`, `login_background_image`, `login_panel_image`, `address`, `contact`, `email`, `mail_driver`, `mail_host`, `mail_port`, `mail_username`, `mail_password`, `mail_encryption`, `mail_from_address`, `mail_from_name`, `copy_right`, `created_at`, `updated_at`) VALUES
(1, 'Sector 3 Welfare Society', '1787134206_default.png', 'login_background_image_61adaf51-6195-456e-8adc-8d4f042a60d9.jpg', 'login_panel_image_cbc09f3d-2dfd-4382-be4e-f51c8baf0721.jpg', 'House-10, Road-07, Sector-03, Uttara,Dhaka-1230, Bangladesh', '8801234567890', 'info@sector3society.com', 'smtp', 'sandbox.smtp.mailtrap.io', 587, 'd1b3021b79c020', '32918f66f08d5c', 'tls', 'support@sector3society.com', 'Society Management System', NULL, '2026-03-31 22:18:14', '2026-11-15 11:38:27');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--
CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `uid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `uid`, `role`, `name`, `username`, `email`, `phone`, `profile_image`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, NULL, 'admin', 'Admin', 'admin', 'admin@example.com', '1571234569', 'assets/images/default-user.svg', '2025-08-02 04:49:38', '$2y$12$dmhp2VydIdIJvtBm8NR9I.MoS/HEhtWDJSPdUCPMS6I/ReKJEWK0e', 'an7yWtfHwIkDiEzDwx5qCg7UsmbiXwD66TblstsT5wpCbF8GPeAcopTf5VZ2', '2025-08-02 04:49:38', '2025-08-02 02:08:44'),
(9, NULL, 'collector', 'Naeem biswas', 'naeem', 'nayeembiswas@sector3.com', '15712994567', 'assets/images/default-user.svg', NULL, '$2y$12$WnDMkEfc7v8.CtDpKF6P6.3KnrMd5NPaSXOQB943Y8kRKxs2w5LhW', NULL, '2026-09-01 20:51:46', '2026-09-01 20:51:46'),
(10, NULL, 'collector', 'mahiuddin', 'mahiuddin', 'mahiuddin@test.com', '233126263', 'assets/images/default-user.svg', NULL, '$2y$12$.nH1B9qV9T13m0IXTNMRA.Drl.iJ8A.SpPxm6LQ/hUjVXnTK/Rgd6', NULL, '2026-09-05 20:22:42', '2026-09-05 20:22:42'),
(11, 'UTR03-0409-EMT', 'member', 'Abdul Mannan', NULL, NULL, '01644444444', 'assets/images/default-user.svg', NULL, '$2y$12$N.pdE1BFSezO8PY32MfE8..Gsr7N9zkUk7ktIxYEgR/sw76nptpNC', NULL, '2026-11-12 05:18:53', '2026-11-12 05:18:53'),
(12, 'UTR03-0107-CONS', 'member', 'Engr. Kamal Hossain', NULL, 'kamal@example.com', '01822222222', 'assets/images/default-user.svg', NULL, '$2y$12$XY8UxXp91zDTQBdvn4l/J.1cEaZzOzvh8uB2CpW/ofWDHDC7fcifO', NULL, '2026-08-04 05:18:53', '2026-08-04 05:18:53'),
(13, 'UTR03-0518/C-CONS', 'member', 'Barrister Shahriar Kabir', NULL, 'shahriar@kabir-law.com', '01945678901', 'assets/images/default-user.svg', NULL, '$2y$12$bLE8S7qutDRyEFcj1EO5rOEvF2RBEJfLIfGQ2JAoDTZCcF.GxYkdq', NULL, '2026-11-12 05:18:53', '2026-11-12 05:18:53'),
(14, 'UTR03-0112/A-1A', 'member', 'Md. Rahim Uddin', NULL, 'rahim@example.com', '01711111111', 'assets/images/default-user.svg', NULL, '$2y$12$Ok1v3JB8EothB.EELaMJFuQlizs/4X6BnePsi.6f.D1K7dHAj2isq', NULL, '2026-11-12 05:18:53', '2026-11-12 05:18:53'),
(15, 'UTR03-0225/B-3B', 'member', 'Fatema Khatun', NULL, 'fatema@example.com', '01933333333', 'assets/images/default-user.svg', NULL, '$2y$12$VLkewD2iT8GHyh8Xw4qFHukRidXbr97iHS.m1ZsZjOSxbscn.wnlK', NULL, '2026-11-12 05:18:53', '2026-11-12 05:18:53'),
(16, 'UTR03-0305-2A', 'member', 'Nusrat Jahan', NULL, 'nusrat@example.com', '01555555555', 'assets/images/default-user.svg', NULL, '$2y$12$cicMhviUCFSJ27DWh0rXGuFO8wCQMFYwImlAPFjrAVYe.gjx/U4dG', NULL, '2026-11-12 05:18:53', '2026-11-12 05:18:53'),
(17, 'UTR03-0603-3A', 'member', 'Mahbubur Rahman', NULL, 'mahbub.rahman@example.com', '01567890123', 'assets/images/default-user.svg', NULL, '$2y$12$CQnghF6VCj/eH2QSqPnCOuxdqH9a6s6jZOuTgPLu9al3zhWo8elA2', NULL, '2026-11-12 05:18:53', '2026-11-12 05:18:53'),
(18, 'UTR03-0208-2A', 'member', 'Imtiaz Ahmed Khan', NULL, 'imtiaz.khan@example.com', '01834567890', 'assets/images/default-user.svg', NULL, '$2y$12$1eJPrn2T/6P3AdXA8oMF3.5F2JRjFXVX4ZXgnl9A4pH6Z.z3WoSDy', NULL, '2026-11-12 05:18:53', '2026-11-12 05:18:53'),
(19, 'UTR03-0702-2B', 'member', 'Kabir Chowdhury', NULL, 'kabir.chowdhury@example.com', '01799887766', 'assets/images/default-user.svg', NULL, '$2y$12$U8oVMONPk7ex.pH.paNIE.fA/h9wCkboO35AYNLWFK6J3zYCYdkoK', NULL, '2026-11-12 05:18:53', '2026-11-12 05:18:53'),
(20, 'UTR03-0314-7C', 'member', 'Tariqul Islam', NULL, 'tariqul@commercial.com', '01712345678', 'assets/images/default-user.svg', NULL, '$2y$12$zaZJrT.kmKBRBqaq3iL8BOyGUCzc3.J/zNEoNubs2Q3P5ocE2IFia', NULL, '2026-11-12 05:18:53', '2026-11-12 05:18:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_property_month_bill` (`plot_and_unit_id`,`billing_month`),
  ADD UNIQUE KEY `bills_bill_number_unique` (`bill_number`),
  ADD KEY `bills_billing_month_status_index` (`billing_month`,`status`);

--
-- Indexes for table `bulksms`
--
ALTER TABLE `bulksms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `collections`
--
ALTER TABLE `collections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dashboard_notification_reads`
--
ALTER TABLE `dashboard_notification_reads`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dashboard_notification_reads_user_id_notification_key_unique` (`user_id`,`notification_key`);

--
-- Indexes for table `drafts`
--
ALTER TABLE `drafts`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `member_login_otps`
--
ALTER TABLE `member_login_otps`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `member_login_otps_user_id_unique` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `missing_flats`
--
ALTER TABLE `missing_flats`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `missing_flats_plot_and_unit_id_flat_number_unique` (`plot_and_unit_id`,`flat_number`);

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
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payments_payment_number_unique` (`payment_number`),
  ADD KEY `payments_bill_id_foreign` (`bill_id`),
  ADD KEY `payments_received_by_foreign` (`received_by`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`),
  ADD UNIQUE KEY `permissions_menu_key_unique` (`menu_key`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `plot_and_units_plot_type_id_foreign` (`plot_type_id`),
  ADD KEY `plot_and_units_road_id_holding_no_index` (`road_id`,`holding_no`),
  ADD KEY `plot_and_units_name_index` (`name`),
  ADD KEY `plot_and_units_import_batch_id_index` (`import_batch_id`);

--
-- Indexes for table `plot_types`
--
ALTER TABLE `plot_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `plot_types_name_unique` (`name`),
  ADD UNIQUE KEY `plot_types_slug_unique` (`slug`);

--
-- Indexes for table `roads`
--
ALTER TABLE `roads`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roads_number_unique` (`number`),
  ADD KEY `roads_collector_id_foreign` (`collector_id`);

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
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `bulksms`
--
ALTER TABLE `bulksms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `collections`
--
ALTER TABLE `collections`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dashboard_notification_reads`
--
ALTER TABLE `dashboard_notification_reads`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `drafts`
--
ALTER TABLE `drafts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `member_login_otps`
--
ALTER TABLE `member_login_otps`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `missing_flats`
--
ALTER TABLE `missing_flats`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plot_and_units`
--
ALTER TABLE `plot_and_units`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `plot_types`
--
ALTER TABLE `plot_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `roads`
--
ALTER TABLE `roads`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1741;

--
-- AUTO_INCREMENT for table `sector_collenctions`
--
ALTER TABLE `sector_collenctions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bills`
--
ALTER TABLE `bills`
  ADD CONSTRAINT `bills_plot_and_unit_id_foreign` FOREIGN KEY (`plot_and_unit_id`) REFERENCES `plot_and_units` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `dashboard_notification_reads`
--
ALTER TABLE `dashboard_notification_reads`
  ADD CONSTRAINT `dashboard_notification_reads_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `member_login_otps`
--
ALTER TABLE `member_login_otps`
  ADD CONSTRAINT `member_login_otps_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `missing_flats`
--
ALTER TABLE `missing_flats`
  ADD CONSTRAINT `missing_flats_plot_and_unit_id_foreign` FOREIGN KEY (`plot_and_unit_id`) REFERENCES `plot_and_units` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_bill_id_foreign` FOREIGN KEY (`bill_id`) REFERENCES `bills` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_received_by_foreign` FOREIGN KEY (`received_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `plot_and_units`
--
ALTER TABLE `plot_and_units`
  ADD CONSTRAINT `plot_and_units_plot_type_id_foreign` FOREIGN KEY (`plot_type_id`) REFERENCES `plot_types` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `plot_and_units_road_id_foreign` FOREIGN KEY (`road_id`) REFERENCES `roads` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `roads`
--
ALTER TABLE `roads`
  ADD CONSTRAINT `roads_collector_id_foreign` FOREIGN KEY (`collector_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `role_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
