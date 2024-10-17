-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 17, 2024 at 03:04 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `universal_portal_technowiz`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `name`, `image`, `created_at`, `updated_at`) VALUES
(3, 'Jazz ESL', NULL, '2024-10-16 12:18:04', '2024-10-16 12:18:04'),
(4, 'Gamez Academy', NULL, '2024-10-16 12:18:16', '2024-10-16 12:18:16');

-- --------------------------------------------------------

--
-- Table structure for table `blacklisted_numbers`
--

CREATE TABLE `blacklisted_numbers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `app_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `is_blocked` tinyint(1) NOT NULL DEFAULT 1,
  `blocked_at` timestamp NULL DEFAULT NULL,
  `unblocked_at` timestamp NULL DEFAULT NULL,
  `blacklisted_by` varchar(255) DEFAULT NULL,
  `blacklisted_by_ip` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blacklisted_numbers`
--

INSERT INTO `blacklisted_numbers` (`id`, `phone_number`, `app_id`, `reason`, `is_blocked`, `blocked_at`, `unblocked_at`, `blacklisted_by`, `blacklisted_by_ip`, `created_at`, `updated_at`) VALUES
(1, '923055363862', 3, NULL, 0, '2024-10-17 02:50:32', '2024-10-17 02:51:25', 'Muneeb', '127.0.0.1', '2024-10-17 02:37:55', '2024-10-17 02:51:25');

-- --------------------------------------------------------

--
-- Table structure for table `campaigns`
--

CREATE TABLE `campaigns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `app_id` bigint(20) UNSIGNED DEFAULT NULL,
  `source` varchar(255) NOT NULL,
  `threshold` int(11) DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `starts_at` time DEFAULT NULL,
  `pause_at` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `campaigns`
--

INSERT INTO `campaigns` (`id`, `name`, `app_id`, `source`, `threshold`, `is_deleted`, `deleted_at`, `status`, `starts_at`, `pause_at`, `created_at`, `updated_at`) VALUES
(6, 'jazz esl campaign', 3, 'ndnc', 10, 0, NULL, 0, '15:39:00', '16:40:00', '2024-10-17 08:15:41', '2024-10-17 12:16:47'),
(7, 'Gamez Academy Campaign', 4, 'ndnc', 10, 0, NULL, 0, '15:39:00', '16:40:00', '2024-10-17 08:16:06', '2024-10-17 12:16:47');

-- --------------------------------------------------------

--
-- Table structure for table `campaign_a_p_i_s`
--

CREATE TABLE `campaign_a_p_i_s` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `app_id` bigint(20) UNSIGNED DEFAULT NULL,
  `api_url` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `campaign_a_p_i_s`
--

INSERT INTO `campaign_a_p_i_s` (`id`, `app_id`, `api_url`, `created_at`, `updated_at`) VALUES
(7, 3, 'http://lp.jazzesl.com.pk', '2024-10-16 12:20:50', '2024-10-17 02:54:21'),
(8, 4, 'http://lp.gamezacademy.pk', '2024-10-16 12:21:37', '2024-10-17 02:43:27');

-- --------------------------------------------------------

--
-- Table structure for table `campaign_user_data`
--

CREATE TABLE `campaign_user_data` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campaign_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_count` int(11) NOT NULL,
  `fetched_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `campaign_user_data`
--

INSERT INTO `campaign_user_data` (`id`, `campaign_id`, `user_count`, `fetched_at`, `created_at`, `updated_at`) VALUES
(1, NULL, 0, '2024-10-14 05:51:30', '2024-10-14 05:51:30', '2024-10-14 05:51:30'),
(2, NULL, 1, '2024-10-14 05:55:55', '2024-10-14 05:55:55', '2024-10-14 05:55:55'),
(3, NULL, 2, '2024-10-14 06:00:22', '2024-10-14 06:00:22', '2024-10-14 06:00:22'),
(4, NULL, 0, '2024-10-14 06:05:43', '2024-10-14 06:05:43', '2024-10-14 06:05:43'),
(5, NULL, 0, '2024-10-14 07:05:52', '2024-10-14 07:05:52', '2024-10-14 07:05:52'),
(6, NULL, 0, '2024-10-14 07:05:52', '2024-10-14 07:05:52', '2024-10-14 07:05:52'),
(7, NULL, 1, '2024-10-14 07:15:19', '2024-10-14 07:15:19', '2024-10-14 07:15:19'),
(8, NULL, 0, '2024-10-14 07:15:19', '2024-10-14 07:15:19', '2024-10-14 07:15:19'),
(9, NULL, 1, '2024-10-14 07:16:22', '2024-10-14 07:16:22', '2024-10-14 07:16:22'),
(10, NULL, 0, '2024-10-14 07:16:23', '2024-10-14 07:16:23', '2024-10-14 07:16:23'),
(11, NULL, 1, '2024-10-14 07:17:20', '2024-10-14 07:17:20', '2024-10-14 07:17:20'),
(12, NULL, 1, '2024-10-14 07:17:20', '2024-10-14 07:17:20', '2024-10-14 07:17:20'),
(13, NULL, 0, '2024-10-14 07:20:13', '2024-10-14 07:20:13', '2024-10-14 07:20:13'),
(14, NULL, 0, '2024-10-14 07:20:13', '2024-10-14 07:20:13', '2024-10-14 07:20:13'),
(15, NULL, 0, '2024-10-14 07:39:17', '2024-10-14 07:39:17', '2024-10-14 07:39:17'),
(16, NULL, 0, '2024-10-14 07:39:17', '2024-10-14 07:39:17', '2024-10-14 07:39:17'),
(17, NULL, 1, '2024-10-14 07:41:45', '2024-10-14 07:41:45', '2024-10-14 07:41:45'),
(18, NULL, 1, '2024-10-14 07:42:39', '2024-10-14 07:42:39', '2024-10-14 07:42:39'),
(19, NULL, 1, '2024-10-14 07:42:39', '2024-10-14 07:42:39', '2024-10-14 07:42:39'),
(20, NULL, 1, '2024-10-14 07:43:15', '2024-10-14 07:43:15', '2024-10-14 07:43:15'),
(21, NULL, 1, '2024-10-14 07:44:10', '2024-10-14 07:44:10', '2024-10-14 07:44:10'),
(22, NULL, 0, '2024-10-14 08:08:36', '2024-10-14 08:08:36', '2024-10-14 08:08:36'),
(23, NULL, 0, '2024-10-14 08:10:01', '2024-10-14 08:10:01', '2024-10-14 08:10:01'),
(24, NULL, 0, '2024-10-14 08:11:01', '2024-10-14 08:11:01', '2024-10-14 08:11:01'),
(25, NULL, 0, '2024-10-14 09:02:46', '2024-10-14 09:02:46', '2024-10-14 09:02:46'),
(26, NULL, 0, '2024-10-14 09:03:24', '2024-10-14 09:03:24', '2024-10-14 09:03:24'),
(27, NULL, 0, '2024-10-14 09:14:57', '2024-10-14 09:14:57', '2024-10-14 09:14:57'),
(28, NULL, 0, '2024-10-14 09:16:53', '2024-10-14 09:16:53', '2024-10-14 09:16:53'),
(29, NULL, 0, '2024-10-14 09:16:54', '2024-10-14 09:16:54', '2024-10-14 09:16:54'),
(30, NULL, 1, '2024-10-14 09:18:12', '2024-10-14 09:18:12', '2024-10-14 09:18:12'),
(31, NULL, 0, '2024-10-14 09:18:12', '2024-10-14 09:18:12', '2024-10-14 09:18:12'),
(32, NULL, 1, '2024-10-14 09:19:36', '2024-10-14 09:19:36', '2024-10-14 09:19:36'),
(33, NULL, 1, '2024-10-14 09:19:36', '2024-10-14 09:19:36', '2024-10-14 09:19:36'),
(34, NULL, 2, '2024-10-14 09:20:27', '2024-10-14 09:20:27', '2024-10-14 09:20:27'),
(35, NULL, 1, '2024-10-14 09:20:28', '2024-10-14 09:20:28', '2024-10-14 09:20:28'),
(36, NULL, 2, '2024-10-14 09:21:41', '2024-10-14 09:21:41', '2024-10-14 09:21:41'),
(37, NULL, 2, '2024-10-14 09:22:14', '2024-10-14 09:22:14', '2024-10-14 09:22:14'),
(38, NULL, 2, '2024-10-14 09:22:38', '2024-10-14 09:22:38', '2024-10-14 09:22:38'),
(39, NULL, 1, '2024-10-14 09:22:38', '2024-10-14 09:22:38', '2024-10-14 09:22:38'),
(40, NULL, 0, '2024-10-15 01:20:54', '2024-10-15 01:20:54', '2024-10-15 01:20:54'),
(41, NULL, 0, '2024-10-15 01:20:54', '2024-10-15 01:20:54', '2024-10-15 01:20:54'),
(42, NULL, 0, '2024-10-15 01:24:12', '2024-10-15 01:24:12', '2024-10-15 01:24:12'),
(43, NULL, 0, '2024-10-15 01:24:13', '2024-10-15 01:24:13', '2024-10-15 01:24:13'),
(44, NULL, 0, '2024-10-15 01:25:16', '2024-10-15 01:25:16', '2024-10-15 01:25:16'),
(45, NULL, 0, '2024-10-15 01:26:23', '2024-10-15 01:26:23', '2024-10-15 01:26:23'),
(46, NULL, 0, '2024-10-15 01:26:45', '2024-10-15 01:26:45', '2024-10-15 01:26:45'),
(47, NULL, 0, '2024-10-15 01:26:46', '2024-10-15 01:26:46', '2024-10-15 01:26:46'),
(48, NULL, 0, '2024-10-15 01:42:13', '2024-10-15 01:42:13', '2024-10-15 01:42:13'),
(49, NULL, 0, '2024-10-15 01:42:13', '2024-10-15 01:42:13', '2024-10-15 01:42:13'),
(50, NULL, 0, '2024-10-15 01:42:42', '2024-10-15 01:42:42', '2024-10-15 01:42:42'),
(51, NULL, 0, '2024-10-15 02:08:29', '2024-10-15 02:08:29', '2024-10-15 02:08:29'),
(52, NULL, 0, '2024-10-15 02:09:17', '2024-10-15 02:09:18', '2024-10-15 02:09:18'),
(53, NULL, 0, '2024-10-15 02:09:18', '2024-10-15 02:09:18', '2024-10-15 02:09:18'),
(54, NULL, 0, '2024-10-15 02:12:01', '2024-10-15 02:12:01', '2024-10-15 02:12:01'),
(55, NULL, 0, '2024-10-15 02:12:01', '2024-10-15 02:12:01', '2024-10-15 02:12:01'),
(56, NULL, 0, '2024-10-15 02:15:00', '2024-10-15 02:15:00', '2024-10-15 02:15:00'),
(57, NULL, 0, '2024-10-15 02:15:01', '2024-10-15 02:15:01', '2024-10-15 02:15:01'),
(58, NULL, 0, '2024-10-15 02:20:01', '2024-10-15 02:20:01', '2024-10-15 02:20:01'),
(59, NULL, 0, '2024-10-15 02:20:01', '2024-10-15 02:20:01', '2024-10-15 02:20:01'),
(60, NULL, 1, '2024-10-15 02:23:10', '2024-10-15 02:23:10', '2024-10-15 02:23:10'),
(61, NULL, 0, '2024-10-15 02:23:10', '2024-10-15 02:23:10', '2024-10-15 02:23:10'),
(62, NULL, 5, '2024-10-15 03:32:14', '2024-10-15 03:32:14', '2024-10-15 03:32:14'),
(63, NULL, 4, '2024-10-15 03:32:14', '2024-10-15 03:32:14', '2024-10-15 03:32:14'),
(64, NULL, 5, '2024-10-15 03:33:34', '2024-10-15 03:33:34', '2024-10-15 03:33:34'),
(65, NULL, 5, '2024-10-15 03:35:01', '2024-10-15 03:35:01', '2024-10-15 03:35:01'),
(66, NULL, 5, '2024-10-15 03:36:01', '2024-10-15 03:36:01', '2024-10-15 03:36:01'),
(67, NULL, 5, '2024-10-15 03:37:01', '2024-10-15 03:37:01', '2024-10-15 03:37:01'),
(68, NULL, 5, '2024-10-15 03:38:01', '2024-10-15 03:38:01', '2024-10-15 03:38:01'),
(69, NULL, 5, '2024-10-15 03:39:01', '2024-10-15 03:39:01', '2024-10-15 03:39:01'),
(70, NULL, 5, '2024-10-15 03:40:01', '2024-10-15 03:40:01', '2024-10-15 03:40:01'),
(71, NULL, 0, '2024-10-15 03:46:25', '2024-10-15 03:46:25', '2024-10-15 03:46:25'),
(72, NULL, 0, '2024-10-15 03:48:37', '2024-10-15 03:48:37', '2024-10-15 03:48:37'),
(73, NULL, 0, '2024-10-15 03:48:37', '2024-10-15 03:48:37', '2024-10-15 03:48:37'),
(74, NULL, 0, '2024-10-15 04:44:43', '2024-10-15 04:44:43', '2024-10-15 04:44:43'),
(75, NULL, 0, '2024-10-15 04:44:52', '2024-10-15 04:44:52', '2024-10-15 04:44:52'),
(76, NULL, 0, '2024-10-15 04:46:35', '2024-10-15 04:46:35', '2024-10-15 04:46:35'),
(77, NULL, 0, '2024-10-15 04:46:35', '2024-10-15 04:46:35', '2024-10-15 04:46:35'),
(78, NULL, 10, '2024-10-15 04:50:23', '2024-10-15 04:50:23', '2024-10-15 04:50:23'),
(79, NULL, 0, '2024-10-15 04:50:24', '2024-10-15 04:50:24', '2024-10-15 04:50:24'),
(80, NULL, 8, '2024-10-15 06:28:33', '2024-10-15 06:28:33', '2024-10-15 06:28:33'),
(81, NULL, 0, '2024-10-15 06:28:34', '2024-10-15 06:28:34', '2024-10-15 06:28:34'),
(82, NULL, 7, '2024-10-15 06:30:32', '2024-10-15 06:30:32', '2024-10-15 06:30:32'),
(83, NULL, 1, '2024-10-15 06:30:32', '2024-10-15 06:30:32', '2024-10-15 06:30:32'),
(84, NULL, 7, '2024-10-15 06:30:58', '2024-10-15 06:30:58', '2024-10-15 06:30:58'),
(85, NULL, 1, '2024-10-15 06:30:58', '2024-10-15 06:30:58', '2024-10-15 06:30:58'),
(86, NULL, 7, '2024-10-15 06:54:36', '2024-10-15 06:54:36', '2024-10-15 06:54:36'),
(87, NULL, 0, '2024-10-15 06:54:36', '2024-10-15 06:54:36', '2024-10-15 06:54:36'),
(88, NULL, 7, '2024-10-15 06:55:17', '2024-10-15 06:55:17', '2024-10-15 06:55:17'),
(89, NULL, 0, '2024-10-15 06:55:17', '2024-10-15 06:55:17', '2024-10-15 06:55:17'),
(90, NULL, 10, '2024-10-15 07:26:50', '2024-10-15 07:26:50', '2024-10-15 07:26:50'),
(91, NULL, 0, '2024-10-15 07:26:50', '2024-10-15 07:26:50', '2024-10-15 07:26:50'),
(92, NULL, 11, '2024-10-16 00:57:22', '2024-10-16 00:57:22', '2024-10-16 00:57:22'),
(93, NULL, 2, '2024-10-16 00:57:31', '2024-10-16 00:57:31', '2024-10-16 00:57:31'),
(94, NULL, 4, '2024-10-16 01:03:09', '2024-10-16 01:03:09', '2024-10-16 01:03:09'),
(95, NULL, 4, '2024-10-16 01:03:16', '2024-10-16 01:03:16', '2024-10-16 01:03:16'),
(96, NULL, 5, '2024-10-16 01:05:48', '2024-10-16 01:05:48', '2024-10-16 01:05:48'),
(97, NULL, 1, '2024-10-16 01:05:54', '2024-10-16 01:05:54', '2024-10-16 01:05:54'),
(98, NULL, 0, '2024-10-17 02:41:32', '2024-10-17 02:41:32', '2024-10-17 02:41:32'),
(99, NULL, 0, '2024-10-17 02:41:32', '2024-10-17 02:41:32', '2024-10-17 02:41:32'),
(100, NULL, 6, '2024-10-17 02:43:48', '2024-10-17 02:43:48', '2024-10-17 02:43:48'),
(101, NULL, 13, '2024-10-17 02:43:51', '2024-10-17 02:43:51', '2024-10-17 02:43:51'),
(102, 6, 2, '2024-10-17 03:23:39', '2024-10-17 03:23:39', '2024-10-17 03:23:39'),
(103, 7, 15, '2024-10-17 03:23:44', '2024-10-17 03:23:44', '2024-10-17 03:23:44'),
(104, 6, 5, '2024-10-17 03:24:56', '2024-10-17 03:24:56', '2024-10-17 03:24:56'),
(105, 7, 13, '2024-10-17 03:24:58', '2024-10-17 03:24:58', '2024-10-17 03:24:58'),
(106, 6, 7, '2024-10-17 03:26:47', '2024-10-17 03:26:47', '2024-10-17 03:26:47'),
(107, 7, 10, '2024-10-17 03:26:49', '2024-10-17 03:26:49', '2024-10-17 03:26:49'),
(108, 6, 5, '2024-10-17 03:28:30', '2024-10-17 03:28:30', '2024-10-17 03:28:30'),
(109, 7, 14, '2024-10-17 03:28:32', '2024-10-17 03:28:32', '2024-10-17 03:28:32'),
(110, 6, 3, '2024-10-17 04:22:45', '2024-10-17 04:22:45', '2024-10-17 04:22:45'),
(111, 7, 5, '2024-10-17 04:22:50', '2024-10-17 04:22:50', '2024-10-17 04:22:50'),
(112, 6, 2, '2024-10-17 04:24:28', '2024-10-17 04:24:28', '2024-10-17 04:24:28'),
(113, 7, 8, '2024-10-17 04:24:30', '2024-10-17 04:24:30', '2024-10-17 04:24:30'),
(114, 6, 3, '2024-10-17 04:26:00', '2024-10-17 04:26:00', '2024-10-17 04:26:00'),
(115, 7, 8, '2024-10-17 04:26:05', '2024-10-17 04:26:05', '2024-10-17 04:26:05'),
(116, 6, 2, '2024-10-17 04:27:00', '2024-10-17 04:27:00', '2024-10-17 04:27:00'),
(117, 7, 9, '2024-10-17 04:27:02', '2024-10-17 04:27:02', '2024-10-17 04:27:02'),
(118, 6, 5, '2024-10-17 05:40:42', '2024-10-17 05:40:42', '2024-10-17 05:40:42'),
(119, 7, 5, '2024-10-17 05:40:45', '2024-10-17 05:40:45', '2024-10-17 05:40:45'),
(120, 6, 5, '2024-10-17 05:41:48', '2024-10-17 05:41:48', '2024-10-17 05:41:48'),
(121, 7, 5, '2024-10-17 05:41:53', '2024-10-17 05:41:53', '2024-10-17 05:41:53'),
(122, 6, 1, '2024-10-17 05:46:00', '2024-10-17 05:46:00', '2024-10-17 05:46:00'),
(123, 7, 6, '2024-10-17 05:46:05', '2024-10-17 05:46:05', '2024-10-17 05:46:05'),
(124, 6, 3, '2024-10-17 05:49:34', '2024-10-17 05:49:34', '2024-10-17 05:49:34'),
(125, 7, 7, '2024-10-17 05:49:38', '2024-10-17 05:49:38', '2024-10-17 05:49:38'),
(126, 6, 6, '2024-10-17 05:55:49', '2024-10-17 05:55:49', '2024-10-17 05:55:49'),
(127, 7, 4, '2024-10-17 05:55:53', '2024-10-17 05:55:53', '2024-10-17 05:55:53'),
(128, 6, 5, '2024-10-17 06:08:37', '2024-10-17 06:08:37', '2024-10-17 06:08:37'),
(129, 7, 4, '2024-10-17 06:08:42', '2024-10-17 06:08:42', '2024-10-17 06:08:42'),
(130, 6, 4, '2024-10-17 06:11:21', '2024-10-17 06:11:21', '2024-10-17 06:11:21'),
(131, 7, 7, '2024-10-17 06:11:25', '2024-10-17 06:11:25', '2024-10-17 06:11:25'),
(132, 6, 4, '2024-10-17 06:18:14', '2024-10-17 06:18:14', '2024-10-17 06:18:14'),
(133, 7, 7, '2024-10-17 06:18:19', '2024-10-17 06:18:19', '2024-10-17 06:18:19');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(3, '2024_09_25_174949_create_organizers_table', 1),
(4, '2024_09_26_111402_create_applications_table', 1),
(5, '2024_09_26_133132_create_campaigns_table', 1),
(6, '2024_10_14_090254_create_campaign_user_data_table', 2),
(7, '2024_10_14_091249_create_campaign_user_data_table', 3),
(8, '2024_10_14_123037_create_campaign_a_p_i_s_table', 4),
(10, '2024_10_16_063408_create_blacklisted_numbers_table', 5),
(11, '2024_10_17_080817_add_threshold_to_campaigns_table', 6),
(12, '2024_10_17_081356_update_threshold_in_campaigns_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `organizers`
--

CREATE TABLE `organizers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `organizers`
--

INSERT INTO `organizers` (`id`, `username`, `email`, `password`, `last_login`, `created_at`, `updated_at`) VALUES
(1, 'Organizer@technowiz', '', '$2y$10$bcO8Miv1FLKxziqDv3TwUO5Si5HjzsuEr1ujogOT/myCZVnysWTjq', '2024-10-17 04:21:56', NULL, '2024-10-17 04:21:56');

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
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blacklisted_numbers`
--
ALTER TABLE `blacklisted_numbers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blacklisted_numbers_app_id_foreign` (`app_id`);

--
-- Indexes for table `campaigns`
--
ALTER TABLE `campaigns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `campaigns_app_id_foreign` (`app_id`);

--
-- Indexes for table `campaign_a_p_i_s`
--
ALTER TABLE `campaign_a_p_i_s`
  ADD PRIMARY KEY (`id`),
  ADD KEY `campaign_a_p_i_s_app_id_foreign` (`app_id`);

--
-- Indexes for table `campaign_user_data`
--
ALTER TABLE `campaign_user_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `campaign_user_data_campaign_id_foreign` (`campaign_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organizers`
--
ALTER TABLE `organizers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `organizers_username_unique` (`username`),
  ADD UNIQUE KEY `organizers_email_unique` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

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
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `blacklisted_numbers`
--
ALTER TABLE `blacklisted_numbers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `campaigns`
--
ALTER TABLE `campaigns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `campaign_a_p_i_s`
--
ALTER TABLE `campaign_a_p_i_s`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `campaign_user_data`
--
ALTER TABLE `campaign_user_data`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `organizers`
--
ALTER TABLE `organizers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blacklisted_numbers`
--
ALTER TABLE `blacklisted_numbers`
  ADD CONSTRAINT `blacklisted_numbers_app_id_foreign` FOREIGN KEY (`app_id`) REFERENCES `applications` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `campaigns`
--
ALTER TABLE `campaigns`
  ADD CONSTRAINT `campaigns_app_id_foreign` FOREIGN KEY (`app_id`) REFERENCES `applications` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `campaign_a_p_i_s`
--
ALTER TABLE `campaign_a_p_i_s`
  ADD CONSTRAINT `campaign_a_p_i_s_app_id_foreign` FOREIGN KEY (`app_id`) REFERENCES `applications` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `campaign_user_data`
--
ALTER TABLE `campaign_user_data`
  ADD CONSTRAINT `campaign_user_data_campaign_id_foreign` FOREIGN KEY (`campaign_id`) REFERENCES `campaigns` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
