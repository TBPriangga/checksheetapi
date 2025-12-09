-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 22, 2025 at 05:07 AM
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
-- Database: `internal_portal_aji`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_box_packaging`
--

CREATE TABLE `delivery_box_packaging` (
  `id` int(11) NOT NULL,
  `box_name` varchar(11) NOT NULL,
  `box_code` varchar(14) NOT NULL,
  `box_area` varchar(20) NOT NULL DEFAULT 'PT AJI',
  `part_sk` varchar(7) DEFAULT NULL,
  `part_name` varchar(255) DEFAULT NULL,
  `part_no` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `id_partcard` varchar(20) DEFAULT NULL,
  `qty` int(5) NOT NULL DEFAULT 0,
  `sku` int(5) NOT NULL DEFAULT 0,
  `customer` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `delivery_box_packaging`
--

INSERT INTO `delivery_box_packaging` (`id`, `box_name`, `box_code`, `box_area`, `part_sk`, `part_name`, `part_no`, `created_at`, `updated_at`, `id_partcard`, `qty`, `sku`, `customer`) VALUES
(1, 'D331', 'TAG RFID', 'PT AJI', NULL, NULL, NULL, '2024-01-23 10:00:44', '2024-01-23 10:00:44', NULL, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `delivery_box_type`
--

CREATE TABLE `delivery_box_type` (
  `id` int(11) NOT NULL,
  `box_name` varchar(30) NOT NULL,
  `max` int(10) NOT NULL DEFAULT 0,
  `min` int(10) NOT NULL DEFAULT 0,
  `status` int(1) NOT NULL DEFAULT 0,
  `berat` int(11) NOT NULL DEFAULT 0,
  `ukuran` varchar(255) NOT NULL,
  `lot` int(3) NOT NULL DEFAULT 0,
  `pocket` int(1) NOT NULL DEFAULT 0,
  `cover` int(1) NOT NULL DEFAULT 0,
  `color` varchar(30) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `delivery_box_type`
--

INSERT INTO `delivery_box_type` (`id`, `box_name`, `max`, `min`, `status`, `berat`, `ukuran`, `lot`, `pocket`, `cover`, `color`, `image`, `created_at`, `updated_at`) VALUES
(1, 'D331', 0, 0, 0, 1, '40x40x40', 12, 1, 1, 'merah', '1705978896.jpg', '2024-01-23 03:01:36', '2024-01-23 10:01:36');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_claim`
--

CREATE TABLE `delivery_claim` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_pickup_id` varchar(255) NOT NULL,
  `claim_date` date NOT NULL,
  `problem` varchar(255) NOT NULL,
  `part_number` varchar(255) NOT NULL,
  `part_name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `part_number_actual` varchar(255) NOT NULL,
  `part_name_actual` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `evidence` varchar(255) NOT NULL,
  `corrective_action` mediumtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delivery_claim`
--

INSERT INTO `delivery_claim` (`id`, `customer_pickup_id`, `claim_date`, `problem`, `part_number`, `part_name`, `category`, `part_number_actual`, `part_name_actual`, `qty`, `evidence`, `corrective_action`, `created_at`, `updated_at`) VALUES
(1, 'ADM', '2022-11-03', 'pi', '81910-BZ150-00', 'REFLECTOR ASSY, REFLEX RH', 'MIX PART', '81740-BZ110-00', 'LAMP ASSY SIDE TURN SIGNAL LH', 1, 'R5MuGIuelcfLmsIJPZeWXhOwtqsh3Fp3ZKsgYVtT.jpg', 'ca', '2022-11-03 04:31:35', '2022-11-03 04:31:35'),
(2, 'ASKI', '2022-11-03', 'problem', '81740-BZ110-00', 'LAMP ASSY SIDE TURN SIGNAL LH', 'MISS PART', '81730-BZ190-00', 'LAMP ASSY SIDE TURN SIGNAL RH', 1, '8oHFg0JG4OLdvgxTPBoU4LmrwWYBaovmAEM84j3m.jpg', 'ca', '2022-11-03 04:32:50', '2022-11-03 04:32:50'),
(3, 'ASKI', '2022-11-03', 'pi', '81740-BZ110-00', 'LAMP ASSY SIDE TURN SIGNAL LH', 'MISS PART', '81910-BZ260-00', 'REFLECTOR ASSY, REFLEX RH', 1, 'Pfwo8pbC5BviPy3DZqc6IGSokqHo1mOW7Jjh9uiy.jpg', 'ca', '2022-11-03 05:09:00', '2022-11-03 05:09:00');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_customers`
--

CREATE TABLE `delivery_customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_code` varchar(255) NOT NULL,
  `customer_name` varchar(189) NOT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delivery_customers`
--

INSERT INTO `delivery_customers` (`id`, `customer_code`, `customer_name`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'TORICA', 'Torica Indonesia', NULL, '2022-07-26 04:27:49', '2022-07-26 04:27:49'),
(2, 'KBI', 'Kyoraku Blowmolding Indonesia', NULL, '2022-07-26 04:27:49', '2022-07-26 04:27:49'),
(3, 'NISSAN', 'Nissan Motor Distributor Indonesia', NULL, '2022-07-26 04:27:49', '2022-07-26 04:27:49'),
(4, 'IAMI', 'Isuzu Astra Motor Indonesia', NULL, '2022-07-26 04:27:49', '2022-07-26 04:27:49'),
(5, 'TMMIN', 'Toyota Motor Manufacturing Indonesia', NULL, '2022-07-26 04:27:49', '2022-07-26 04:27:49'),
(6, 'ADM', 'Astra Daihatsu Motor', NULL, '2022-07-26 04:27:49', '2022-07-26 04:27:49'),
(7, 'KTSI', 'Kasai Teck See Indonesia', NULL, '2022-07-26 04:27:49', '2022-07-26 04:27:49'),
(8, 'FRINA', 'Frina Lestari Nusantara', NULL, '2022-07-26 04:27:49', '2022-07-26 04:27:49'),
(9, 'ASKI', 'Astra Komponen Indonesia', NULL, '2022-07-26 04:27:49', '2022-07-26 04:27:49'),
(10, 'TSC', 'Takagi Sari Multi Utama', NULL, '2022-07-26 04:27:49', '2022-07-26 04:27:49'),
(11, 'MMKYSI', 'Mitsubishi Motors Krama Yudha Sales Indonesia', NULL, '2022-07-26 04:27:49', '2022-07-26 04:27:49'),
(12, 'AWP', 'Astra Otoparts Tbk Div Adiwira Plastik', NULL, '2022-07-26 04:27:49', '2022-07-26 04:27:49'),
(13, 'AMK', 'Andalan Multi Kencana', NULL, '2022-07-26 04:27:49', '2022-07-26 04:27:49'),
(14, 'AHM', 'Astra Honda Motor', NULL, '2022-07-26 04:27:49', '2022-07-26 04:27:49'),
(15, 'DSO', 'PT Astra Internasional  TBK DSO', NULL, '2022-07-26 04:27:49', '2022-07-26 04:27:49'),
(16, 'JUOKU', 'Juoku Technology Ltd', NULL, '2022-07-26 04:27:49', '2022-07-26 04:27:49');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_henkaten`
--

CREATE TABLE `delivery_henkaten` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `position` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `shift` varchar(255) NOT NULL,
  `henkaten_status` int(11) DEFAULT NULL,
  `date_henkaten` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delivery_henkaten`
--

INSERT INTO `delivery_henkaten` (`id`, `position`, `user_id`, `shift`, `henkaten_status`, `date_henkaten`, `created_at`, `updated_at`) VALUES
(1, 'preparation', '00001', 'SHIFT 1', NULL, NULL, NULL, NULL),
(2, 'preparation_pulling_1', '00002', 'SHIFT 1', NULL, NULL, NULL, NULL),
(3, 'delivery_control', '00003', 'SHIFT 1', NULL, NULL, NULL, NULL),
(4, 'pulling_oem_2', '00004', 'SHIFT 1', NULL, NULL, NULL, NULL),
(5, 'pulling_oem_1', '00005', 'SHIFT 1', NULL, NULL, NULL, NULL),
(6, 'sparepart', '00006', 'SHIFT 1', NULL, NULL, NULL, NULL),
(7, 'packaging_2', '00008', 'SHIFT 1', NULL, NULL, NULL, NULL),
(8, 'packaging_1', '00009', 'SHIFT 1', NULL, NULL, NULL, NULL),
(9, 'preparation_pulling_2', '0989', 'SHIFT 1', NULL, NULL, NULL, NULL),
(10, 'packaging_1', '000012', 'SHIFT 2', NULL, NULL, NULL, NULL),
(11, 'packaging_2', '000022', 'SHIFT 2', NULL, NULL, NULL, NULL),
(12, 'delivery_control', '00809', 'SHIFT 2', NULL, NULL, NULL, NULL),
(13, 'preparation_pulling_1', '006005', 'SHIFT 2', NULL, NULL, NULL, NULL),
(14, 'preparation_pulling_2', '00892', 'SHIFT 2', NULL, NULL, NULL, NULL),
(15, 'sparepart', '0789', 'SHIFT 2', NULL, NULL, NULL, NULL),
(16, 'preparation', '0777', 'SHIFT 2', NULL, NULL, NULL, NULL),
(17, 'pulling_oem_1', '0778', 'SHIFT 2', NULL, NULL, NULL, NULL),
(18, 'pulling_oem_2', '08777', 'SHIFT 2', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `delivery_henkaten_detail`
--

CREATE TABLE `delivery_henkaten_detail` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `area` varchar(255) NOT NULL,
  `mp_before` varchar(255) NOT NULL,
  `mp_after` varchar(255) NOT NULL,
  `reason_henkaten` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL COMMENT 'type henkaten atau substitue',
  `default_area_mp_after` varchar(255) NOT NULL,
  `date_henkaten` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delivery_henkaten_detail`
--

INSERT INTO `delivery_henkaten_detail` (`id`, `area`, `mp_before`, `mp_after`, `reason_henkaten`, `type`, `default_area_mp_after`, `date_henkaten`, `created_at`, `updated_at`) VALUES
(1, 'delivery_control', 'TEST1', 'RISQI', 'Absence', 'henkaten', 'preparation', '2022-08-31 16:02:28', '2022-08-31 09:02:28', '2022-08-31 09:02:28'),
(2, 'delivery_control', 'TEST1', 'RISQI', 'Absence', 'henkaten', 'preparation', '2022-08-31 16:02:28', '2022-08-31 09:02:28', '2022-08-31 09:02:28'),
(3, 'delivery_control', 'TEST1', 'RISQI', 'Absence', 'henkaten', 'preparation', '2022-08-31 16:02:28', '2022-08-31 09:02:28', '2022-08-31 09:02:28'),
(4, 'delivery_control', 'TEST1', 'RISQI', 'Absence', 'henkaten', 'preparation', '2022-08-31 16:02:29', '2022-08-31 09:02:29', '2022-08-31 09:02:29'),
(5, 'delivery_control', 'SILMA FITRIA', 'RISQI', 'Permit', 'henkaten', 'preparation', '2022-08-31 16:04:36', '2022-08-31 09:04:36', '2022-08-31 09:04:36'),
(6, 'delivery_control', 'SILMA FITRIA', 'UNTUNG SETYADI', 'Sick Leave', 'default', 'delivery_control', '2022-09-06 09:47:38', '2022-09-06 02:47:38', '2022-09-06 02:47:38'),
(7, 'delivery_control', 'UNTUNG SETYADI', 'SILMA FITRIA', 'Sick Leave', 'default', 'delivery_control', '2022-09-06 09:47:45', '2022-09-06 02:47:45', '2022-09-06 02:47:45');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_lines`
--

CREATE TABLE `delivery_lines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `line_code` varchar(40) NOT NULL,
  `line_name` varchar(100) NOT NULL,
  `line_category` varchar(40) NOT NULL,
  `tonase` varchar(15) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delivery_lines`
--

INSERT INTO `delivery_lines` (`id`, `line_code`, `line_name`, `line_category`, `tonase`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'AL1', 'AIR LEAKAGE 1', 'ASSY', NULL, NULL, '2022-07-27 02:16:20', '2022-07-27 02:16:20'),
(2, 'AL2', 'AIR LEAKAGE 2', 'ASSY', NULL, NULL, '2022-07-27 02:16:20', '2022-07-27 02:16:20'),
(3, 'AL3', 'AIR LEAKAGE 3', 'ASSY', NULL, NULL, '2022-07-27 02:16:20', '2022-07-27 02:16:20'),
(4, 'GLU1', 'GLUE 1', 'ASSY', NULL, NULL, '2022-07-27 02:16:20', '2022-07-27 02:16:20'),
(5, 'GLU2', 'GLUE 2', 'ASSY', NULL, NULL, '2022-07-27 02:16:20', '2022-07-27 02:16:20'),
(6, 'GLU3', 'GLUE 3', 'ASSY', NULL, NULL, '2022-07-27 02:16:20', '2022-07-27 02:16:20'),
(7, 'HINS', 'HOT INSERT                                        ', 'ASSY', NULL, NULL, '2022-07-27 02:16:20', '2022-07-27 02:16:20'),
(8, 'HPW1', 'HOT PLATE 1', 'ASSY', NULL, NULL, '2022-07-27 02:16:20', '2022-07-27 02:16:20'),
(9, 'HPW2', 'HOT PLATE 2', 'ASSY', NULL, NULL, '2022-07-27 02:16:20', '2022-07-27 02:16:20'),
(10, 'HPW3', 'HOT PLATE 3', 'ASSY', NULL, NULL, '2022-07-27 02:16:20', '2022-07-27 02:16:20'),
(11, 'HPW4', 'HOT PLATE 4', 'ASSY', NULL, NULL, '2022-07-27 02:16:20', '2022-07-27 02:16:20'),
(12, 'HPW5', 'HOT PLATE 5', 'ASSY', NULL, NULL, '2022-07-27 02:16:20', '2022-07-27 02:16:20'),
(13, 'KOJA', 'KOJA', 'ASSY', NULL, NULL, '2022-07-27 02:16:20', '2022-07-27 02:16:20'),
(14, 'MANL', 'MANUAL', 'ASSY', NULL, NULL, '2022-07-27 02:16:20', '2022-07-27 02:16:20'),
(15, 'POS1', 'POST 1', 'ASSY', NULL, NULL, '2022-07-27 02:16:20', '2022-07-27 02:16:20'),
(16, 'POS2', 'POST 2', 'ASSY', NULL, NULL, '2022-07-27 02:16:20', '2022-07-27 02:16:20'),
(17, 'ULM1', 'ULTRASONIC 1', 'ASSY', NULL, NULL, '2022-07-27 02:16:20', '2022-07-27 02:16:20'),
(18, 'ULM2', 'ULTRASONIC 2', 'ASSY', NULL, NULL, '2022-07-27 02:16:20', '2022-07-27 02:16:20'),
(19, 'ULM3', 'ULTRASONIC 3', 'ASSY', NULL, NULL, '2022-07-27 02:16:20', '2022-07-27 02:16:20'),
(20, 'ULM4', 'ULTRASONIC 4', 'ASSY', NULL, NULL, '2022-07-27 02:16:20', '2022-07-27 02:16:20'),
(21, 'ULM5', 'ULTRASONIC 5', 'ASSY', NULL, NULL, '2022-07-27 02:16:20', '2022-07-27 02:16:20'),
(22, 'VIB1', 'VIBRATION 1', 'ASSY', NULL, NULL, '2022-07-27 02:16:20', '2022-07-27 02:16:20'),
(23, 'VIB2', 'VIBRATION 2', 'ASSY', NULL, NULL, '2022-07-27 02:16:20', '2022-07-27 02:16:20'),
(24, 'VIB3', 'VIBRATION 3', 'ASSY', NULL, NULL, '2022-07-27 02:16:20', '2022-07-27 02:16:20'),
(25, 'INJ01', 'INJECTION 1', 'INJECTION', '1250 T', NULL, '2022-07-27 02:16:20', '2022-07-27 02:16:20'),
(26, 'INJ02', 'INJECTION 2', 'INJECTION', '160 T', NULL, '2022-07-27 02:16:20', '2022-07-27 02:16:20'),
(27, 'INJ03', 'INJECTION 3', 'INJECTION', '160 T', NULL, '2022-07-27 02:16:20', '2022-07-27 02:16:20'),
(28, 'INJ04', 'INJECTION 4', 'INJECTION', '650 T', NULL, '2022-07-27 02:16:20', '2022-07-27 02:16:20'),
(29, 'INJ05', 'INJECTION 5', 'INJECTION', '650 T', NULL, '2022-07-27 02:16:20', '2022-07-27 02:16:20'),
(30, 'INJ06', 'INJECTION 6', 'INJECTION', '1250 T', NULL, '2022-07-27 02:16:20', '2022-07-27 02:16:20'),
(31, 'INJ07', 'INJECTION 7', 'INJECTION', '650 T', NULL, '2022-07-27 02:16:20', '2022-07-27 02:16:20'),
(32, 'INJ08', 'INJECTION 8                          ', 'INJECTION', '1450 T', NULL, '2022-07-27 02:16:20', '2022-07-27 02:16:20'),
(33, 'INJ09', 'INJECTION 9', 'INJECTION', '450 T', NULL, '2022-07-27 02:16:20', '2022-07-27 02:16:20'),
(34, 'INJ10', 'INJECTION 10', 'INJECTION', '450 T', NULL, '2022-07-27 02:16:20', '2022-07-27 02:16:20'),
(35, 'INJ11', 'INJECTION 11', 'INJECTION', '1850 T', NULL, '2022-07-27 02:16:20', '2022-07-27 02:16:20'),
(36, 'INJ12', 'INJECTION 12                        ', 'INJECTION', '1850 T', NULL, '2022-07-27 02:16:20', '2022-07-27 02:16:20'),
(37, 'SPT ', 'SPARE PART', 'SPAREPART', NULL, NULL, '2022-07-27 02:16:20', '2022-07-27 02:16:20'),
(38, 'HC', 'HARDCOATING                                       ', 'SURFACE THREATMENT', NULL, NULL, '2022-07-27 02:16:20', '2022-07-27 02:16:20'),
(39, 'MTZ1', 'METALIZING 1                                        ', 'SURFACE THREATMENT', NULL, NULL, '2022-07-27 02:16:20', '2022-07-27 02:16:20'),
(40, 'MTZ2', 'METALIZING 2', 'SURFACE THREATMENT', NULL, NULL, '2022-07-27 02:16:20', '2022-07-27 02:16:20'),
(41, 'PNT', 'PAINTING                                          ', 'SURFACE THREATMENT', NULL, NULL, '2022-07-27 02:16:20', '2022-07-27 02:16:20'),
(42, 'PNT_MANL', 'PAINTING MANUAL', 'SURFACE THREATMENT', NULL, NULL, '2022-07-27 02:16:20', '2022-07-27 02:16:20');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_log_truck`
--

CREATE TABLE `delivery_log_truck` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_pickup_id` varchar(255) NOT NULL,
  `vendor` varchar(255) NOT NULL,
  `jenis` varchar(255) DEFAULT NULL,
  `security_name` varchar(255) DEFAULT NULL,
  `driver_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delivery_log_truck`
--

INSERT INTO `delivery_log_truck` (`id`, `customer_pickup_id`, `vendor`, `jenis`, `security_name`, `driver_name`, `created_at`, `updated_at`) VALUES
(1, 'ADM ASSY 1', 'vendor 3', 'arrival', 'security 1', 'supir 1', '2022-08-30 03:16:21', '2022-08-30 03:16:21'),
(2, 'ADM ASSY 1', 'vendor 3', 'departure', 'security 1', 'supir 1', '2022-08-30 03:16:26', '2022-08-30 03:16:26'),
(3, 'ADM ASSY 1', 'vendor 3', 'arrival', 'security 1', 'supir 1', '2022-08-31 02:17:39', '2022-08-31 02:17:39'),
(4, 'ADM ASSY 1', 'vendor 3', 'departure', 'security 1', 'supir 1', '2022-08-31 02:17:42', '2022-08-31 02:17:42'),
(5, 'ADM ASSY 1', 'vendor 1', 'arrival', 'security 1', 'supir 2', '2022-09-06 04:16:48', '2022-09-06 04:16:48'),
(6, 'ADM ASSY 1', 'vendor 1', 'departure', 'security 1', 'supir 2', '2022-09-06 04:16:52', '2022-09-06 04:16:52'),
(7, 'ADM ASSY 1', 'vendor 2', 'arrival', 'security 1', 'supir 1', '2022-09-06 04:18:36', '2022-09-06 04:18:36'),
(8, 'ADM ASSY 1', 'vendor 2', 'departure', 'security 1', 'supir 1', '2022-09-06 04:18:39', '2022-09-06 04:18:39'),
(9, 'ADM ASSY 1', 'milk run 1', 'arrival', 'security 1', 'supir 1', '2022-09-16 07:44:35', '2022-09-16 07:44:35'),
(10, 'ADM ASSY 1', 'milk run 1', 'departure', 'security 1', 'supir 1', '2022-09-16 07:57:59', '2022-09-16 07:57:59'),
(11, 'ADM ASSY 1', 'milk run 1', 'arrival', 'security 1', 'supir 1', '2022-09-16 08:02:12', '2022-09-16 08:02:12'),
(12, 'ADM ASSY 1', 'milk run 1', 'departure', 'security 1', 'supir 1', '2022-09-16 08:03:17', '2022-09-16 08:03:17'),
(13, 'KBI', 'vendor 41', 'arrival', 'security 1', 'ss', '2023-01-12 03:35:36', '2023-01-12 03:35:36'),
(14, 'KBI', 'vendor 41', 'departure', 'security 1', 'ss', '2023-01-12 03:35:42', '2023-01-12 03:35:42');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_man_powers`
--

CREATE TABLE `delivery_man_powers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `npk` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `area` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `shift` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delivery_man_powers`
--

INSERT INTO `delivery_man_powers` (`id`, `name`, `npk`, `position`, `area`, `title`, `shift`, `photo`, `created_at`, `updated_at`) VALUES
(6, 'TAUFIK RAHMAN', '00001', 'PREPARATION', 'preparation', 'MEMBER', 'SHIFT 1', 'yqrxvhe1AHMj54YEtZ93VHf4cCtSXCcSOetTeLSX.jpg', '2022-07-19 01:54:33', '2022-11-03 05:22:56'),
(7, 'HARIANTO', '00002', 'PREPARATION,PULLING', 'preparation_pulling_1', 'MEMBER', 'SHIFT 1', 'KLYynBWeIwnCGQlblpxUaDP5IsstsscC0vV09UQ7.jpg', '2022-07-19 02:02:50', '2022-08-01 04:29:36'),
(8, 'SILMA FITRIA', '00003', 'DELIVERY CONTROL', 'delivery_control', 'MEMBER', 'SHIFT 1', 'ofaYQ7spkZbLcuBMnsoNU091DhqjloSX3MadrXjD.jpg', '2022-07-19 02:08:27', '2022-08-26 04:03:10'),
(9, 'EGA SUGIARTO', '00004', 'PULLING', 'pulling_oem_2', 'MEMBER', 'SHIFT 1', 'wRn4xjZouvFsvID4vshG44o6xPX1THmi1CmODjQL.jpg', '2022-07-19 02:16:45', '2022-08-02 04:17:24'),
(10, 'HADI UTAMA', '00005', 'PULLING', 'pulling_oem_1', 'MEMBER', 'SHIFT 1', '2A91wTJ1x63lzyLHoKlNsFmGO8dd9P6Ixr5jR2XZ.jpg', '2022-07-19 02:26:23', '2022-08-02 04:38:11'),
(11, 'HERI ISMANTO', '00006', 'SPAREPART', 'sparepart', 'MEMBER', 'SHIFT 1', '8NnvWk300AsBBNnhb2mJSjMqfBYuqlRCLOV5z75K.jpg', '2022-07-19 02:29:57', '2022-08-02 04:21:45'),
(12, 'ROHENDI', '00008', 'PACKAGING CONTROL,PREPARATION', 'packaging_2', 'MEMBER', 'SHIFT 1', 'dHPZTtzKUcKYEPoYk33dpnMACwiqxdCY6YGTMd4s.jpg', '2022-07-19 02:35:45', '2022-08-02 04:22:30'),
(13, 'WANDI', '00009', 'PACKAGING CONTROL', 'packaging_1', 'MEMBER', 'SHIFT 1', 'RQY1aQE8eolKikx9Zm4aGbQIL3aXM7WBzmjcdQtd.jpg', '2022-07-19 02:38:01', '2022-08-02 04:22:40'),
(14, 'RISQI', '000010', 'PREPARATION', 'preparation', 'MEMBER', 'SHIFT 1', 'JuQqsiOC96U2igDafYezPaHEhhw4aqyBDGUAbKgi.jpg', '2022-07-19 20:03:48', '2022-08-02 07:37:33'),
(15, 'UNTUNG SETYADI', '000011', 'DELIVERY CONTROL,PULLING,PACKAGING CONTROL,PREPARATION', 'delivery_control', 'LEADER', 'SHIFT 1', 'eFF4iUOprcBrCgIQjXHThFmdTG22UHHgfqg4cGR9.jpg', '2022-07-19 20:16:11', '2022-08-02 04:23:05'),
(16, 'GIRI', '000012', 'PULLING,PACKAGING CONTROL', 'packaging_1', 'MEMBER', 'SHIFT 2', 'qo3v26jsxdNbXoIpxBqCOh2S6DQmVSGnOhCJaLdq.jpg', '2022-07-19 22:53:57', '2022-08-03 08:04:04'),
(17, 'Samsul', '000013', 'PULLING,SPAREPART', 'pulling_oem_1', 'MEMBER', 'SHIFT 1', 'Ny2sJ8901sJ3RS6Abi52yQJf6PMqxpzI3Sm2Qoym.jpg', '2022-08-10 04:35:58', '2022-08-10 05:37:04'),
(18, 'miqdad agil amarullah', '000022', 'PACKAGING CONTROL', 'packaging_2', 'MEMBER', 'SHIFT 2', 'kEg6wuu1IzxG7N7WcllO9Z6HtP3tgTFSqfIftgUN.png', '2022-08-26 05:47:58', '2022-08-30 05:45:43'),
(19, 'TEST1', '00809', 'DELIVERY CONTROL', 'delivery_control', 'MEMBER', 'SHIFT 2', 'PtQM58l5Fbrc8JNE963lkFkd7Mb9BbKvvdxh6zJC.png', '2022-08-30 05:55:26', '2022-08-31 03:08:58'),
(20, 'TEST2', '006005', 'PULLING', 'preparation_pulling_1', 'MEMBER', 'SHIFT 2', 'iiYWdXf2RSxSxLGPeN6YcgCb28fDGWeM5Z8J0P3m.png', '2022-08-30 05:56:33', '2022-08-31 03:09:11'),
(21, 'TEST3', '00892', 'PULLING,PULLING', 'preparation_pulling_2', 'MEMBER', 'SHIFT 2', '1ZOIU8MypzEmu9H5hyno55LmqkBFWSI2IRR6zGdG.png', '2022-08-31 03:20:33', '2022-08-31 03:21:21'),
(22, 'TEST4', '0789', 'SPAREPART', 'sparepart', 'MEMBER', 'SHIFT 2', 'KQMtaXgp0XOlQaw0fL5TifaF9UKEXGUqICRSRwJm.png', '2022-08-31 03:22:41', '2022-08-31 03:22:41'),
(23, 'TEST5', '0777', 'PREPARATION', 'preparation', 'MEMBER', 'SHIFT 2', 'JHtUAOvAS8IRBTQ2g07yv4QKENfCGbsV6if36G1y.png', '2022-08-31 03:23:28', '2022-08-31 03:23:28'),
(24, 'TEST6', '0778', 'PULLING', 'pulling_oem_1', 'MEMBER', 'SHIFT 2', 'yxMMYZoLpgDDq1ZGk6EMbgrf6aav0Km4VFfMmuwn.png', '2022-08-31 03:24:25', '2022-08-31 03:24:25'),
(25, 'TEST7', '08777', 'PULLING', 'pulling_oem_2', 'MEMBER', 'SHIFT 2', '5B6gbiaSTrfllwabn9VbmCjiu0jinMaoYpuvbkWt.png', '2022-08-31 03:24:48', '2022-08-31 03:24:48'),
(26, 'TEST8', '0989', 'PULLING', 'preparation_pulling_2', 'MEMBER', 'SHIFT 1', '6rtzb4ncoBs8pliDUCicrGsbvnfpM7KbtRNpRIWz.png', '2022-08-31 03:26:27', '2022-09-05 08:31:44');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_matrix_skills`
--

CREATE TABLE `delivery_matrix_skills` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `skill_id` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `value` int(11) NOT NULL DEFAULT 0,
  `category` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delivery_matrix_skills`
--

INSERT INTO `delivery_matrix_skills` (`id`, `skill_id`, `user_id`, `value`, `category`, `created_at`, `updated_at`) VALUES
(94, 'Create MO', '00001', 1, 'PPC', '2022-08-16 04:18:47', '2022-08-16 04:18:47'),
(95, 'Create PRO', '00001', 1, 'PPC', '2022-08-16 04:18:47', '2022-08-16 04:18:47'),
(96, 'Print Partcard', '00001', 1, 'PPC', '2022-08-16 04:18:47', '2022-08-16 04:18:47'),
(97, 'Create RPB', '00001', 1, 'PPC', '2022-08-16 04:18:47', '2022-08-16 04:18:47'),
(98, 'Pulling FG', '00001', 1, 'Pulling FG OEM', '2022-08-16 04:18:47', '2022-08-16 04:18:47'),
(99, 'Backflush transaction', '00001', 1, 'Pulling FG OEM', '2022-08-16 04:18:47', '2022-08-16 04:18:47'),
(100, 'FIFO', '00001', 1, 'Pulling FG OEM', '2022-08-16 04:18:47', '2022-08-16 04:18:47'),
(101, 'Update Stock FG', '00001', 1, 'Pulling FG OEM', '2022-08-16 04:18:47', '2022-08-16 04:18:47'),
(102, 'Compare data', '00001', 1, 'Pulling FG OEM', '2022-08-16 04:18:47', '2022-08-16 04:18:47'),
(103, 'Download Kanban Customer email / portal', '00001', 1, 'Delivery Control', '2022-08-16 04:18:47', '2022-08-16 04:18:47'),
(104, 'Print Delivery Noted & Kanban Customer', '00001', 1, 'Delivery Control', '2022-08-16 04:18:47', '2022-08-16 04:18:47'),
(105, 'Prepare Surat Jalan', '00001', 1, 'Delivery Control', '2022-08-16 04:18:47', '2022-08-16 04:18:47'),
(106, 'Upload DO', '00001', 1, 'Delivery Control', '2022-08-16 04:18:47', '2022-08-16 04:18:47'),
(107, 'Prepare delivery ADM SAP', '00001', 1, 'Preparation Delivery OEM', '2022-08-16 04:18:47', '2022-08-16 04:18:47'),
(108, 'Prepare delivery ADM KAP', '00001', 1, 'Preparation Delivery OEM', '2022-08-16 04:18:47', '2022-08-16 04:18:47'),
(109, 'Prepare delivery TMMIN', '00001', 1, 'Preparation Delivery OEM', '2022-08-16 04:18:47', '2022-08-16 04:18:47'),
(110, 'Prepare delviery IAMI', '00001', 1, 'Preparation Delivery OEM', '2022-08-16 04:18:47', '2022-08-16 04:18:47'),
(111, 'Prepare delivery customer direct', '00001', 1, 'Preparation Delivery OEM', '2022-08-16 04:18:47', '2022-08-16 04:18:47'),
(112, 'Backflush transaction Prepare', '00001', 1, 'Preparation Delivery OEM', '2022-08-16 04:18:47', '2022-08-16 04:18:47'),
(113, 'FIFO Preparation', '00001', 1, 'Preparation Delivery OEM', '2022-08-16 04:18:47', '2022-08-16 04:18:47'),
(114, 'P & S part', '00001', 1, 'Sparepart', '2022-08-16 04:18:47', '2022-08-16 04:18:47'),
(115, 'P & S Sticker', '00001', 1, 'Sparepart', '2022-08-16 04:18:47', '2022-08-16 04:18:47'),
(116, 'Update Stock SPT', '00001', 1, 'Sparepart', '2022-08-16 04:18:47', '2022-08-16 04:18:47'),
(117, 'P & S Plastic', '00001', 1, 'Sparepart', '2022-08-16 04:18:47', '2022-08-16 04:18:47'),
(118, 'Prepare Delivery Sparepart', '00001', 1, 'Sparepart', '2022-08-16 04:18:47', '2022-08-16 04:18:47'),
(119, 'Create, Upload & Print ASN', '00001', 1, 'Sparepart', '2022-08-16 04:18:47', '2022-08-16 04:18:47'),
(120, 'Prepare box for production', '00001', 1, 'Packaging Control', '2022-08-16 04:18:47', '2022-08-16 04:18:47'),
(121, 'Cleaning return Box from customer', '00001', 1, 'Packaging Control', '2022-08-16 04:18:47', '2022-08-16 04:18:47'),
(122, 'Maintenance trolly', '00001', 1, 'Packaging Control', '2022-08-16 04:18:47', '2022-08-16 04:18:47'),
(123, 'Forklift', '00001', 1, 'Packaging Control', '2022-08-16 04:18:47', '2022-08-16 04:18:47'),
(124, 'Control stock packaging', '00001', 1, 'Packaging Control', '2022-08-16 04:18:47', '2022-08-16 04:18:47'),
(125, 'Create MO', '00002', 3, 'PPC', '2022-08-16 04:19:42', '2022-08-26 08:27:50'),
(126, 'Create PRO', '00002', 4, 'PPC', '2022-08-16 04:19:42', '2022-08-26 08:27:30'),
(127, 'Print Partcard', '00002', 4, 'PPC', '2022-08-16 04:19:42', '2022-08-26 08:27:30'),
(128, 'Create RPB', '00002', 1, 'PPC', '2022-08-16 04:19:42', '2022-08-16 04:19:42'),
(129, 'Pulling FG', '00002', 1, 'Pulling FG OEM', '2022-08-16 04:19:42', '2022-08-16 04:19:42'),
(130, 'Backflush transaction', '00002', 1, 'Pulling FG OEM', '2022-08-16 04:19:42', '2022-08-16 04:19:42'),
(131, 'FIFO', '00002', 1, 'Pulling FG OEM', '2022-08-16 04:19:42', '2022-08-16 04:19:42'),
(132, 'Update Stock FG', '00002', 1, 'Pulling FG OEM', '2022-08-16 04:19:42', '2022-08-16 04:19:42'),
(133, 'Compare data', '00002', 1, 'Pulling FG OEM', '2022-08-16 04:19:42', '2022-08-16 04:19:42'),
(134, 'Download Kanban Customer email / portal', '00002', 1, 'Delivery Control', '2022-08-16 04:19:42', '2022-08-16 04:19:42'),
(135, 'Print Delivery Noted & Kanban Customer', '00002', 1, 'Delivery Control', '2022-08-16 04:19:42', '2022-08-16 04:19:42'),
(136, 'Prepare Surat Jalan', '00002', 1, 'Delivery Control', '2022-08-16 04:19:42', '2022-08-16 04:19:42'),
(137, 'Upload DO', '00002', 1, 'Delivery Control', '2022-08-16 04:19:42', '2022-08-16 04:19:42'),
(138, 'Prepare delivery ADM SAP', '00002', 1, 'Preparation Delivery OEM', '2022-08-16 04:19:42', '2022-08-16 04:19:42'),
(139, 'Prepare delivery ADM KAP', '00002', 1, 'Preparation Delivery OEM', '2022-08-16 04:19:42', '2022-08-16 04:19:42'),
(140, 'Prepare delivery TMMIN', '00002', 1, 'Preparation Delivery OEM', '2022-08-16 04:19:42', '2022-08-16 04:19:42'),
(141, 'Prepare delviery IAMI', '00002', 1, 'Preparation Delivery OEM', '2022-08-16 04:19:42', '2022-08-16 04:19:42'),
(142, 'Prepare delivery customer direct', '00002', 1, 'Preparation Delivery OEM', '2022-08-16 04:19:42', '2022-08-16 04:19:42'),
(143, 'Backflush transaction Prepare', '00002', 1, 'Preparation Delivery OEM', '2022-08-16 04:19:42', '2022-08-16 04:19:42'),
(144, 'FIFO Preparation', '00002', 1, 'Preparation Delivery OEM', '2022-08-16 04:19:42', '2022-08-16 04:19:42'),
(145, 'P & S part', '00002', 1, 'Sparepart', '2022-08-16 04:19:42', '2022-08-16 04:19:42'),
(146, 'P & S Sticker', '00002', 1, 'Sparepart', '2022-08-16 04:19:42', '2022-08-16 04:19:42'),
(147, 'Update Stock SPT', '00002', 1, 'Sparepart', '2022-08-16 04:19:42', '2022-08-16 04:19:42'),
(148, 'P & S Plastic', '00002', 1, 'Sparepart', '2022-08-16 04:19:42', '2022-08-16 04:19:42'),
(149, 'Prepare Delivery Sparepart', '00002', 1, 'Sparepart', '2022-08-16 04:19:42', '2022-08-16 04:19:42'),
(150, 'Create, Upload & Print ASN', '00002', 1, 'Sparepart', '2022-08-16 04:19:42', '2022-08-16 04:19:42'),
(151, 'Prepare box for production', '00002', 1, 'Packaging Control', '2022-08-16 04:19:42', '2022-08-16 04:19:42'),
(152, 'Cleaning return Box from customer', '00002', 1, 'Packaging Control', '2022-08-16 04:19:42', '2022-08-16 04:19:42'),
(153, 'Maintenance trolly', '00002', 1, 'Packaging Control', '2022-08-16 04:19:42', '2022-08-16 04:19:42'),
(154, 'Forklift', '00002', 1, 'Packaging Control', '2022-08-16 04:19:42', '2022-08-16 04:19:42'),
(155, 'Control stock packaging', '00002', 1, 'Packaging Control', '2022-08-16 04:19:42', '2022-08-16 04:19:42'),
(156, 'Create MO', '00003', 1, 'PPC', '2022-08-26 08:27:00', '2022-08-26 08:27:00'),
(157, 'Create PRO', '00003', 1, 'PPC', '2022-08-26 08:27:00', '2022-08-26 08:27:00'),
(158, 'Print Partcard', '00003', 1, 'PPC', '2022-08-26 08:27:00', '2022-08-26 08:27:00'),
(159, 'Create RPB', '00003', 1, 'PPC', '2022-08-26 08:27:00', '2022-08-26 08:27:00'),
(160, 'Pulling FG', '00003', 1, 'Pulling FG OEM', '2022-08-26 08:27:00', '2022-08-26 08:27:00'),
(161, 'Backflush transaction', '00003', 1, 'Pulling FG OEM', '2022-08-26 08:27:00', '2022-08-26 08:27:00'),
(162, 'FIFO', '00003', 1, 'Pulling FG OEM', '2022-08-26 08:27:00', '2022-08-26 08:27:00'),
(163, 'Update Stock FG', '00003', 1, 'Pulling FG OEM', '2022-08-26 08:27:00', '2022-08-26 08:27:00'),
(164, 'Compare data', '00003', 1, 'Pulling FG OEM', '2022-08-26 08:27:00', '2022-08-26 08:27:00'),
(165, 'Download Kanban Customer email / portal', '00003', 1, 'Delivery Control', '2022-08-26 08:27:00', '2022-08-26 08:27:00'),
(166, 'Print Delivery Noted & Kanban Customer', '00003', 1, 'Delivery Control', '2022-08-26 08:27:00', '2022-08-26 08:27:00'),
(167, 'Prepare Surat Jalan', '00003', 1, 'Delivery Control', '2022-08-26 08:27:00', '2022-08-26 08:27:00'),
(168, 'Upload DO', '00003', 1, 'Delivery Control', '2022-08-26 08:27:00', '2022-08-26 08:27:00'),
(169, 'Prepare delivery ADM SAP', '00003', 1, 'Preparation Delivery OEM', '2022-08-26 08:27:00', '2022-08-26 08:27:00'),
(170, 'Prepare delivery ADM KAP', '00003', 1, 'Preparation Delivery OEM', '2022-08-26 08:27:00', '2022-08-26 08:27:00'),
(171, 'Prepare delivery TMMIN', '00003', 1, 'Preparation Delivery OEM', '2022-08-26 08:27:00', '2022-08-26 08:27:00'),
(172, 'Prepare delviery IAMI', '00003', 1, 'Preparation Delivery OEM', '2022-08-26 08:27:00', '2022-08-26 08:27:00'),
(173, 'Prepare delivery customer direct', '00003', 1, 'Preparation Delivery OEM', '2022-08-26 08:27:00', '2022-08-26 08:27:00'),
(174, 'Backflush transaction Prepare', '00003', 1, 'Preparation Delivery OEM', '2022-08-26 08:27:00', '2022-08-26 08:27:00'),
(175, 'FIFO Preparation', '00003', 1, 'Preparation Delivery OEM', '2022-08-26 08:27:00', '2022-08-26 08:27:00'),
(176, 'P & S part', '00003', 1, 'Sparepart', '2022-08-26 08:27:00', '2022-08-26 08:27:00'),
(177, 'P & S Sticker', '00003', 1, 'Sparepart', '2022-08-26 08:27:00', '2022-08-26 08:27:00'),
(178, 'Update Stock SPT', '00003', 1, 'Sparepart', '2022-08-26 08:27:00', '2022-08-26 08:27:00'),
(179, 'P & S Plastic', '00003', 1, 'Sparepart', '2022-08-26 08:27:00', '2022-08-26 08:27:00'),
(180, 'Prepare Delivery Sparepart', '00003', 1, 'Sparepart', '2022-08-26 08:27:00', '2022-08-26 08:27:00'),
(181, 'Create, Upload & Print ASN', '00003', 1, 'Sparepart', '2022-08-26 08:27:00', '2022-08-26 08:27:00'),
(182, 'Prepare box for production', '00003', 1, 'Packaging Control', '2022-08-26 08:27:00', '2022-08-26 08:27:00'),
(183, 'Cleaning return Box from customer', '00003', 1, 'Packaging Control', '2022-08-26 08:27:00', '2022-08-26 08:27:00'),
(184, 'Maintenance trolly', '00003', 1, 'Packaging Control', '2022-08-26 08:27:00', '2022-08-26 08:27:00'),
(185, 'Forklift', '00003', 1, 'Packaging Control', '2022-08-26 08:27:00', '2022-08-26 08:27:00'),
(186, 'Control stock packaging', '00003', 1, 'Packaging Control', '2022-08-26 08:27:00', '2022-08-26 08:27:00');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_mos`
--

CREATE TABLE `delivery_mos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sku` varchar(255) NOT NULL,
  `prod_date` date NOT NULL,
  `qty_mo` int(11) NOT NULL,
  `qty_act_prod` int(11) NOT NULL,
  `status_mo` enum('selesai','belum selesai') NOT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_notes`
--

CREATE TABLE `delivery_notes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer` varchar(255) NOT NULL,
  `delivery_note` varchar(255) NOT NULL,
  `out` datetime DEFAULT NULL,
  `in` datetime DEFAULT NULL,
  `days` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delivery_notes`
--

INSERT INTO `delivery_notes` (`id`, `customer`, `delivery_note`, `out`, `in`, `days`, `status`, `created_at`, `updated_at`) VALUES
(1, 'AHM', '77765111', '2022-08-05 14:45:58', '2022-08-05 14:46:06', '0', 2, '2022-08-05 07:45:52', '2022-08-05 07:46:06');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_packagings`
--

CREATE TABLE `delivery_packagings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `packaging_code` varchar(255) NOT NULL,
  `qty_per_pallet` varchar(255) NOT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delivery_packagings`
--

INSERT INTO `delivery_packagings` (`id`, `packaging_code`, `qty_per_pallet`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'KUBOTA', '23', NULL, '2022-07-27 02:16:07', '2022-07-27 02:16:07'),
(2, 'D362', '36', NULL, '2022-07-27 02:16:07', '2022-07-27 02:16:07'),
(3, 'ISEKI', '8', NULL, '2022-07-27 02:16:07', '2022-07-27 02:16:07'),
(4, 'YADIN', '8', NULL, '2022-07-27 02:16:07', '2022-07-27 02:16:07'),
(5, '7033', '15', NULL, '2022-07-27 02:16:07', '2022-07-27 02:16:07'),
(6, '5604', '20', NULL, '2022-07-27 02:16:07', '2022-07-27 02:16:07'),
(7, 'D563', '24', NULL, '2022-07-27 02:16:07', '2022-07-27 02:16:07'),
(8, '6699', '21', NULL, '2022-07-27 02:16:07', '2022-07-27 02:16:07'),
(9, 'D462', '36', NULL, '2022-07-27 02:16:07', '2022-07-27 02:16:07'),
(10, 'D363', '-', NULL, '2022-07-27 02:16:07', '2022-07-27 02:16:07'),
(11, 'D332', '24', NULL, '2022-07-27 02:16:07', '2022-07-27 02:16:07'),
(12, 'D331', '90', NULL, '2022-07-27 02:16:07', '2022-07-27 02:16:07'),
(13, 'D361', '60', NULL, '2022-07-27 02:16:07', '2022-07-27 02:16:07'),
(14, '2066', '36', NULL, '2022-07-27 02:16:07', '2022-07-27 02:16:07'),
(15, '6688', '36', NULL, '2022-07-27 02:16:07', '2022-07-27 02:16:07'),
(16, 'STSL D14', '36', NULL, '2022-07-27 02:16:07', '2022-07-27 02:16:07'),
(17, 'STSL D21', '36', NULL, '2022-07-27 02:16:07', '2022-07-27 02:16:07'),
(18, 'KOJA', '20', NULL, '2022-07-27 02:16:07', '2022-07-27 02:16:07'),
(19, 'AJI - DSO', '36', NULL, '2022-07-27 02:16:07', '2022-07-27 02:16:07'),
(20, 'AJI - AHM', '36', NULL, '2022-07-27 02:16:07', '2022-07-27 02:16:07');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_parts`
--

CREATE TABLE `delivery_parts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sku` varchar(255) NOT NULL,
  `part_no_customer` varchar(255) NOT NULL,
  `part_no_aji` varchar(255) NOT NULL,
  `part_name` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `customer_id` varchar(255) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `cycle_time` varchar(255) DEFAULT NULL,
  `addresing` varchar(255) DEFAULT NULL,
  `color_id` varchar(40) DEFAULT NULL,
  `line_id` varchar(40) DEFAULT NULL,
  `packaging_id` varchar(40) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delivery_parts`
--

INSERT INTO `delivery_parts` (`id`, `sku`, `part_no_customer`, `part_no_aji`, `part_name`, `model`, `customer_id`, `category`, `cycle_time`, `addresing`, `color_id`, `line_id`, `packaging_id`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, '1015', 'T81550-BZ460-001', '11-0G43-00-YM', 'LAMP ASSY, RR COMBINATION, RH', 'D21N SP', 'ADM', 'fg', '45', NULL, 'b', 'glu1', 'iseki', NULL, '2022-07-27 02:16:54', '2022-07-27 02:16:54'),
(2, '1016', 'T81560-BZ460-001', '11-0G44-00-YM', 'LAMP ASSY, RR COMBINATION, LH', 'D21N SP', 'ADM', 'fg', '45', NULL, NULL, NULL, NULL, NULL, '2022-07-27 02:16:54', '2022-07-27 02:16:54'),
(3, '810', 'D81551-BZ230-001', '11-0G33-05-T0', 'LENS & BODY, RR COMBINATION LAMP RH', 'D22D SP', 'ADM', 'fg', '45', NULL, NULL, NULL, NULL, NULL, '2022-07-27 02:16:54', '2022-07-27 02:16:54'),
(4, '732', 'IRM-8976959750', '20-0G39-00-ZG', 'HEAD LAMP ASSY RH (12V)', 'N-Series (700P)', 'IAMI', 'fg', '45', NULL, NULL, NULL, NULL, NULL, '2022-07-27 02:16:54', '2022-07-27 02:16:54'),
(5, '733', 'IRM-8976959760', '20-0G40-00-ZG', 'HEAD LAMP ASSY LH (12V)', 'N-Series (700P)', 'IAMI', 'fg', '45', NULL, NULL, NULL, NULL, NULL, '2022-07-27 02:16:54', '2022-07-27 02:16:54'),
(6, '881', 'IRM-8976960220', '16-0G21-00-ZG', 'LAMP ASM; FRT; SI; R 12V', 'N-Series (700P)', 'IAMI', 'fg', '45', NULL, NULL, NULL, NULL, NULL, '2022-07-27 02:16:54', '2022-07-27 02:16:54'),
(7, '882', 'IRM-8976960230', '16-0G22-00-ZG', 'LAMP ASM; FRT; SI; L 12V', 'N-Series (700P)', 'IAMI', 'fg', '45', NULL, 'h', 'al2', 'yadin', NULL, '2022-07-27 02:16:54', '2022-07-27 02:16:54'),
(8, '811', 'D81561-BZ230-001', '11-0G34-05-T0', 'LENS & BODY, RR COMBINATION LAMP LH', 'D22D SP', 'ADM', 'fg', '45', NULL, NULL, NULL, NULL, NULL, '2022-07-27 02:16:54', '2022-07-27 02:16:54'),
(9, '1009', 'D76803-BZ060-001', '15-0G43-00-T0', 'GARNISH SUB-ASSY, BACK DOOR, OUTS UPR RH', 'D21N SP', 'ADM', 'sfg', '45', NULL, 'o', 'al1', 'kubota', NULL, '2022-07-27 02:16:54', '2022-07-27 02:16:54'),
(10, '1010', 'D76804-BZ040-001', '15-0G44-00-T0', 'GARNISH SUB-ASSY, BACK DOOR, OUTS UPR LH', 'D21N SP', 'ADM', 'fg', '45', NULL, NULL, NULL, NULL, NULL, '2022-07-27 02:16:54', '2022-07-27 02:16:54'),
(11, '921', 'D9004A-81024-001', 'D9004A-81024-001', 'BULB SIDE TURN', 'D22D SP', 'ADM', 'fg', '45', NULL, NULL, NULL, NULL, NULL, '2022-07-27 02:16:54', '2022-07-27 02:16:54'),
(12, '1013', 'D81550-BZ460-001', '11-0G43-00-TM', 'LAMP ASSY, RR COMBINATION, RH', 'D21N SP', 'ADM', 'sfg', '78', NULL, NULL, NULL, NULL, NULL, '2022-07-27 02:16:54', '2022-07-27 02:16:54'),
(13, '1014', 'D81560-BZ460-001', '11-0G44-00-TM', 'LAMP ASSY, RR COMBINATION, LH', 'D21N SP', 'ADM', 'fg', '45', NULL, NULL, NULL, NULL, NULL, '2022-07-27 02:16:54', '2022-07-27 02:16:54'),
(14, '1057', '99132-13050', 'B2W0501S-Y0', 'BULB', '700A', 'TMMIN', 'fg', '45', NULL, NULL, NULL, NULL, NULL, '2022-07-27 02:16:54', '2022-07-27 02:16:54'),
(15, '1017', 'IRM-8982592482', '20-0G49-00-ZG', 'HEAD LAMP ASSY RH (12V)', 'VT01', 'IAMI', 'fg', '45', NULL, NULL, NULL, NULL, NULL, '2022-07-27 02:16:54', '2022-07-27 02:16:54'),
(16, '1018', 'IRM-8982592492', '20-0G50-00-ZG', 'HEAD LAMP ASSY LH (12V)', 'VT01', 'IAMI', 'fg', '45', NULL, NULL, NULL, NULL, NULL, '2022-07-27 02:16:54', '2022-07-27 02:16:54'),
(17, '1019', '81910-BZ260-00', '45-0G51-00-TG', 'REFLECTOR ASSY, REFLEX RH', 'D14N', 'ADM', 'fg', '45', NULL, NULL, NULL, NULL, NULL, '2022-07-27 02:16:54', '2022-07-27 02:16:54'),
(18, '1020', '81920-BZ230-00', '45-0G52-00-TG', 'REFLECTOR ASSY, REFLEX LH', 'D14N', 'ADM', 'fg', '45', NULL, NULL, NULL, NULL, NULL, '2022-07-27 02:16:54', '2022-07-27 02:16:54'),
(19, '1021', '81730-BZ190-00', '16-0G51-00-TG', 'LAMP ASSY SIDE TURN SIGNAL RH', 'D14N', 'ASKI', 'fg', '45', NULL, NULL, NULL, NULL, NULL, '2022-07-27 02:16:54', '2022-07-27 02:16:54'),
(20, '1022', '81740-BZ110-00', '16-0G52-00-TG', 'LAMP ASSY SIDE TURN SIGNAL LH', 'D14N', 'ASKI', 'fg', '45', NULL, NULL, NULL, NULL, NULL, '2022-07-27 02:16:54', '2022-07-27 02:16:54'),
(21, '117', '81570-BZ150', '13-0G07-00-TG', 'LAMP ASSY STOP CENTER', 'D21N', 'FRINA', 'fg', '45', NULL, 'k', 'glu3', 'd331', NULL, '2022-07-27 02:16:54', '2022-07-27 02:16:54'),
(22, '808', 'T81551-BZ230-001', '11-0G33-05-Y0', 'LENS & BODY, RR COMBINATION LAMP RH', 'D22D SP', 'ADM', 'fg', '45', NULL, NULL, NULL, NULL, NULL, '2022-07-27 02:16:54', '2022-07-27 02:16:54'),
(23, '809', 'T81561-BZ230-001', '11-0G34-05-Y0', 'LENS & BODY, RR COMBINATION LAMP LH', 'D22D SP', 'ADM', 'fg', '45', NULL, NULL, NULL, NULL, NULL, '2022-07-27 02:16:54', '2022-07-27 02:16:54'),
(24, '1039', 'T81480-BZ030-001', '29-0G47-00-Y0', 'REAR FOG LAMP ', 'D21N SP', 'ADM', 'fg', '45', NULL, NULL, NULL, NULL, NULL, '2022-07-27 02:16:54', '2022-07-27 02:16:54'),
(25, '1052', 'T9004A-81046-001', 'B2W2120ASE-Y0', 'BULB', 'D21N SP', 'ADM', 'fg', '45', NULL, NULL, NULL, NULL, NULL, '2022-07-27 02:16:54', '2022-07-27 02:16:54'),
(26, '1061', 'T81551-BZ300-001', '11-0G43-A0-YM', 'RR COMBINATION UNIT ASSY, RH', 'D21N SP', 'ADM', 'fg', '45', NULL, NULL, NULL, NULL, NULL, '2022-07-27 02:16:54', '2022-07-27 02:16:54'),
(27, '1062', 'T81561-BZ300-001', '11-0G44-A0-YM', 'RR COMBINATION UNIT ASSY, LH', 'D21N SP', 'ADM', 'fg', '45', NULL, NULL, NULL, NULL, NULL, '2022-07-27 02:16:54', '2022-07-27 02:16:54'),
(28, '920', 'D9004A-81023-001', 'D9004A-81023-001', 'BULB BACK UP', 'D22D SP', 'ADM', 'fg', '45', NULL, NULL, NULL, NULL, NULL, '2022-07-27 02:16:54', '2022-07-27 02:16:54'),
(29, '916', 'D81550-BZ500-001', '11-0G45-00-T0', 'LAMP ASSY, RR COMBINATION RH', 'D37N SP', 'ADM', 'fg', '45', NULL, NULL, NULL, NULL, NULL, '2022-07-27 02:16:54', '2022-07-27 02:16:54'),
(30, '917', 'D81560-BZ500-001', '11-0G46-00-T0', 'LAMP ASSY, RR COMBINATION LH', 'D37N SP', 'ADM', 'fg', '45', NULL, NULL, NULL, NULL, NULL, '2022-07-27 02:16:54', '2022-07-27 02:16:54'),
(31, '1063', 'D81551-BZ300-001', '11-0G43-A0-TM', 'RR COMBINATION UNIT ASSY, RH', 'D21N SP', 'ADM', 'fg', '45', NULL, NULL, NULL, NULL, NULL, '2022-07-27 02:16:54', '2022-07-27 02:16:54'),
(32, '1064', 'D81561-BZ300-001', '11-0G44-A0-TM', 'RR COMBINATION UNIT ASSY, LH', 'D21N SP', 'ADM', 'fg', '45', NULL, NULL, NULL, NULL, NULL, '2022-07-27 02:16:54', '2022-07-27 02:16:54'),
(33, '1065', 'D81551-BZ290-001', '11-0G45-A0-TM', 'RR COMBINATION UNIT ASSY RH', 'D37N SP', 'ADM', 'fg', '45', NULL, NULL, NULL, NULL, NULL, '2022-07-27 02:16:54', '2022-07-27 02:16:54'),
(34, '1066', 'D81561-BZ290-001', '11-0G46-A0-TM', 'RR COMBINATION UNIT ASSY LH', 'D37N SP', 'ADM', 'fg', '45', NULL, NULL, NULL, NULL, NULL, '2022-07-27 02:16:54', '2022-07-27 02:16:54'),
(35, '1040', '81910-BZ150-00', '45-0G51-A0-TG', 'REFLECTOR ASSY, REFLEX RH', 'D14N GCC', 'ADM', 'fg', '45', NULL, NULL, NULL, NULL, NULL, '2022-07-27 02:16:54', '2022-07-27 02:16:54');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_part_cards`
--

CREATE TABLE `delivery_part_cards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `color_code` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `remark_1` varchar(255) NOT NULL,
  `remark_2` varchar(255) NOT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delivery_part_cards`
--

INSERT INTO `delivery_part_cards` (`id`, `color_code`, `description`, `remark_1`, `remark_2`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'B', 'BIRU', 'RH low', 'Tosca', NULL, '2022-07-27 02:16:32', '2022-07-27 02:16:32'),
(2, 'H', 'HIJAU', 'RH high', 'Green', NULL, '2022-07-27 02:16:32', '2022-07-27 02:16:32'),
(3, 'K', 'KUNING', 'LH low', 'Orange 65', NULL, '2022-07-27 02:16:32', '2022-07-27 02:16:32'),
(4, 'M', 'MERAH MUDA', 'RH Mid', 'Red 09', NULL, '2022-07-27 02:16:32', '2022-07-27 02:16:32'),
(5, 'P', 'PUTIH', 'LH High', 'single, tanpa cover', NULL, '2022-07-27 02:16:32', '2022-07-27 02:16:32'),
(6, 'O', 'ORANGE', 'LH Mid', 'Orange 85', NULL, '2022-07-27 02:16:32', '2022-07-27 02:16:32'),
(7, 'x', 'test', 'test', 'test', NULL, '2022-07-27 02:16:32', '2022-07-27 02:16:32');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_pickup_customer`
--

CREATE TABLE `delivery_pickup_customer` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_pickup_code` varchar(255) NOT NULL,
  `cycle` int(11) NOT NULL,
  `cycle_time_preparation` int(11) NOT NULL,
  `help_column` varchar(255) NOT NULL,
  `vendor` varchar(255) DEFAULT NULL,
  `time_pickup` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delivery_pickup_customer`
--

INSERT INTO `delivery_pickup_customer` (`id`, `customer_pickup_code`, `cycle`, `cycle_time_preparation`, `help_column`, `vendor`, `time_pickup`, `created_at`, `updated_at`) VALUES
(1, 'ADM ASSY 1', 1, 60, 'ADM ASSY 1 Cycle 1', 'vendor 1', '03:45:00', '2022-07-26 04:28:08', '2022-07-26 04:28:08'),
(2, 'ADM ASSY 1', 2, 70, 'ADM ASSY 1 Cycle 2', 'vendor 2', '11:45:00', '2022-07-26 04:28:08', '2022-07-26 04:28:08'),
(3, 'ADM ASSY 1', 3, 20, 'ADM ASSY 1 Cycle 3', 'vendor 3', '19:15:00', '2022-07-26 04:28:08', '2022-07-26 04:28:08'),
(4, 'ADM ASSY 1', 4, 70, 'ADM ASSY 1 Cycle 4', 'vendor 4', '19:15:00', '2022-07-26 04:28:08', '2022-07-26 04:28:08'),
(5, 'ADM ASSY 2', 1, 20, 'ADM ASSY 2 Cycle 1', 'vendor 5', '03:25:00', '2022-07-26 04:28:08', '2022-07-26 04:28:08'),
(6, 'ADM ASSY 2', 2, 60, 'ADM ASSY 2 Cycle 2', 'vendor 6', '05:30:00', '2022-07-26 04:28:08', '2022-07-26 04:28:08'),
(7, 'ADM ASSY 2', 3, 30, 'ADM ASSY 2 Cycle 3', 'vendor 7', '10:45:00', '2022-07-26 04:28:08', '2022-07-26 04:28:08'),
(8, 'ADM ASSY 2', 4, 60, 'ADM ASSY 2 Cycle 4', 'vendor 8', '17:30:00', '2022-07-26 04:28:08', '2022-07-26 04:28:08'),
(9, 'ADM ASSY 2', 5, 61, 'ADM ASSY 2 Cycle 5', 'vendor 9', '20:05:00', '2022-07-26 04:28:08', '2022-07-26 04:28:08'),
(10, 'ADM ASSY 2', 6, 62, 'ADM ASSY 2 Cycle 6', 'vendor 10', '20:05:00', '2022-07-26 04:28:08', '2022-07-26 04:28:08'),
(11, 'ADM ASSY 2', 7, 63, 'ADM ASSY 2 Cycle 7', 'vendor 11', '20:05:00', '2022-07-26 04:28:08', '2022-07-26 04:28:08'),
(12, 'ADM ASSY 3', 7, 71, 'ADM ASSY 3 Cycle 7', 'vendor 19', '18:05:00', '2022-07-26 04:28:08', '2022-07-26 04:28:08'),
(13, 'ADM ASSY 3', 1, 65, 'ADM ASSY 3 Cycle 1', 'vendor 13', '03:50:00', '2022-07-26 04:28:08', '2022-07-26 04:28:08'),
(14, 'ADM ASSY 3', 2, 66, 'ADM ASSY 3 Cycle 2', 'vendor 14', '07:15:00', '2022-07-26 04:28:08', '2022-07-26 04:28:08'),
(15, 'ADM ASSY 3', 3, 67, 'ADM ASSY 3 Cycle 3', 'vendor 15', '10:15:00', '2022-07-26 04:28:08', '2022-07-26 04:28:08'),
(16, 'ADM ASSY 3', 4, 68, 'ADM ASSY 3 Cycle 4', 'vendor 16', '13:10:00', '2022-07-26 04:28:08', '2022-07-26 04:28:08'),
(17, 'ADM ASSY 3', 5, 69, 'ADM ASSY 3 Cycle 5', 'vendor 17', '16:05:00', '2022-07-26 04:28:08', '2022-07-26 04:28:08'),
(18, 'ADM ASSY 3', 6, 70, 'ADM ASSY 3 Cycle 6', 'vendor 18', '18:05:00', '2022-07-26 04:28:08', '2022-07-26 04:28:08'),
(19, 'ADM ASSY 3', 8, 72, 'ADM ASSY 3 Cycle 8', 'vendor 20', '18:05:00', '2022-07-26 04:28:08', '2022-07-26 04:28:08'),
(20, 'ADM ASSY 3', 9, 73, 'ADM ASSY 3 Cycle 9', 'vendor 21', '18:05:00', '2022-07-26 04:28:08', '2022-07-26 04:28:08'),
(21, 'AHM', 0, 74, 'AHM', 'vendor 22', '07:30:00', '2022-07-26 04:28:08', '2022-07-26 04:28:08'),
(22, 'ASKI', 0, 75, 'ASKI', 'vendor 23', '18:00:00', '2022-07-26 04:28:08', '2022-07-26 04:28:08'),
(23, 'IAMI', 1, 76, 'IAMI Cycle 1', 'vendor 24', '06:30:00', '2022-07-26 04:28:08', '2022-07-26 04:28:08'),
(24, 'IAMI', 2, 77, 'IAMI Cycle 2', 'vendor 25', '18:30:00', '2022-07-26 04:28:08', '2022-07-26 04:28:08'),
(25, 'KUBOTA', 0, 77, 'KUBOTA', 'vendor 26', '15:00:00', '2022-07-26 04:28:08', '2022-07-26 04:28:08'),
(26, 'TMMIN DOCK 4M', 1, 77, 'TMMIN DOCK 4M Cycle 1', 'vendor 27', '06:46:00', '2022-07-26 04:28:08', '2022-07-26 04:28:08'),
(27, 'TMMIN DOCK 53', 9, 77, 'TMMIN DOCK 53 Cycle 9', 'vendor 28', '00:25:00', '2022-07-26 04:28:08', '2022-07-26 04:28:08'),
(28, 'TMMIN DOCK 53', 1, 77, 'TMMIN DOCK 53 Cycle 1', 'vendor 29', '04:45:00', '2022-07-26 04:28:08', '2022-07-26 04:28:08'),
(29, 'TMMIN DOCK 53', 2, 77, 'TMMIN DOCK 53 Cycle 2', 'vendor 30', '07:30:00', '2022-07-26 04:28:08', '2022-07-26 04:28:08'),
(30, 'TMMIN DOCK 53', 3, 77, 'TMMIN DOCK 53 Cycle 3', 'vendor 31', '08:43:00', '2022-07-26 04:28:08', '2022-07-26 04:28:08'),
(31, 'TMMIN DOCK 53', 4, 77, 'TMMIN DOCK 53 Cycle 4', 'vendor 32', '11:06:00', '2022-07-26 04:28:08', '2022-07-26 04:28:08'),
(32, 'TMMIN DOCK 53', 5, 77, 'TMMIN DOCK 53 Cycle 5', 'vendor 33', '12:50:00', '2022-07-26 04:28:08', '2022-07-26 04:28:08'),
(33, 'TMMIN DOCK 53', 6, 77, 'TMMIN DOCK 53 Cycle 6', 'vendor 34', '18:13:00', '2022-07-26 04:28:08', '2022-07-26 04:28:08'),
(34, 'TMMIN DOCK 53', 7, 77, 'TMMIN DOCK 53 Cycle 7', 'vendor 35', '22:33:00', '2022-07-26 04:28:08', '2022-07-26 04:28:08'),
(35, 'TMMIN DOCK 53', 8, 77, 'TMMIN DOCK 53 Cycle 8', 'vendor 36', '22:46:00', '2022-07-26 04:28:08', '2022-07-26 04:28:08'),
(36, 'TSC CIKARANG', 0, 77, 'TSC CIKARANG', 'vendor 37', '07:30:00', '2022-07-26 04:28:08', '2022-07-26 04:28:08'),
(37, 'TSC TANGERANG', 0, 77, 'TSC TANGERANG', 'vendor 38', '07:30:00', '2022-07-26 04:28:08', '2022-07-26 04:28:08'),
(38, 'FRINA', 0, 77, 'FRINA', 'vendor 39', '08:30:00', '2022-07-26 04:28:08', '2022-07-26 04:28:08'),
(39, 'KTSI', 0, 77, 'KTSI', 'vendor 40', '09:30:00', '2022-07-26 04:28:08', '2022-07-26 04:28:08'),
(40, 'KBI', 0, 77, 'KBI', 'vendor 41', '10:30:00', '2022-07-26 04:28:08', '2022-07-26 04:28:08');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_planning_refreshment`
--

CREATE TABLE `delivery_planning_refreshment` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `training` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `plan_date_time` datetime DEFAULT NULL,
  `actual_date_time` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_preparation`
--

CREATE TABLE `delivery_preparation` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_pickup_id` varchar(255) NOT NULL,
  `cycle` int(11) NOT NULL,
  `cycle_time_preparation` int(11) NOT NULL,
  `help_column` varchar(255) NOT NULL,
  `plan_time_preparation` time NOT NULL,
  `shift` varchar(255) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `time_hour` double(8,2) NOT NULL,
  `plan_date_preparation` date NOT NULL,
  `date_preparation` datetime DEFAULT NULL,
  `start_preparation` datetime DEFAULT NULL,
  `end_preparation` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `delay_time` varchar(255) DEFAULT NULL,
  `start_by` varchar(255) DEFAULT NULL,
  `end_by` varchar(255) DEFAULT NULL,
  `time_preparation` varchar(255) DEFAULT NULL,
  `problem` varchar(255) DEFAULT NULL,
  `remark` mediumtext DEFAULT NULL,
  `arrival_plan` datetime NOT NULL,
  `arrival_actual` datetime DEFAULT NULL,
  `arrival_gap` varchar(255) DEFAULT NULL,
  `arrival_status` varchar(255) DEFAULT NULL COMMENT '3:advance,4:ontime,5:delay,8:advance return,9:ontime return,10:delay return',
  `departure_plan` datetime NOT NULL,
  `departure_actual` datetime DEFAULT NULL,
  `departure_gap` varchar(255) DEFAULT NULL,
  `departure_status` varchar(255) DEFAULT NULL COMMENT '3: advance, 4: ontime, 5: delay, 6: pending belum datang, 7: pending sudah dtg',
  `vendor` varchar(255) NOT NULL,
  `security_name_arrival` varchar(255) DEFAULT NULL,
  `security_name_departure` varchar(255) DEFAULT NULL,
  `driver_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delivery_preparation`
--

INSERT INTO `delivery_preparation` (`id`, `customer_pickup_id`, `cycle`, `cycle_time_preparation`, `help_column`, `plan_time_preparation`, `shift`, `pic`, `time_hour`, `plan_date_preparation`, `date_preparation`, `start_preparation`, `end_preparation`, `status`, `delay_time`, `start_by`, `end_by`, `time_preparation`, `problem`, `remark`, `arrival_plan`, `arrival_actual`, `arrival_gap`, `arrival_status`, `departure_plan`, `departure_actual`, `departure_gap`, `departure_status`, `vendor`, `security_name_arrival`, `security_name_departure`, `driver_name`, `created_at`, `updated_at`) VALUES
(3, 'KBI', 0, 77, 'KBI', '13:00:00', 'SHIFT 1', '00001 TAUFIK RAHMAN', 1.28, '2022-09-20', '2022-09-20 00:00:00', '2022-09-20 14:27:50', '2022-09-20 14:27:51', 5, '1 hour 27 minutes', '00001 TAUFIK RAHMAN', '00001 TAUFIK RAHMAN', '0.016666666666667', 's', 'sss', '2022-09-20 10:30:00', '2023-01-12 10:35:36', '23 Days 0 Hours 5 Minutes', '5', '2022-09-20 10:50:00', '2023-01-12 10:35:42', '23 Days 0 Hours 5 Minutes', '5', 'vendor 41', 'security 1', 'security 1', 'ss', '2022-09-20 07:27:46', '2023-01-12 03:35:42'),
(4, 'ADM ASSY 1', 1, 20, 'ADM ASSY 1 Cycle 1', '17:00:00', 'shift 1', '00001 TAUFIK RAHMAN', 0.30, '2022-09-20', '2022-09-26 10:21:48', '2022-09-20 17:00:00', '2022-09-20 17:00:00', 5, NULL, '00001 TAUFIK RAHMAN', '00001 TAUFIK RAHMAN', NULL, NULL, NULL, '2022-09-20 12:00:00', NULL, NULL, NULL, '2022-09-19 16:00:00', NULL, NULL, NULL, 'milk run 1', NULL, NULL, NULL, '2022-09-20 08:18:10', '2022-09-26 03:21:48'),
(5, 'ADM ASSY 1', 1, 20, 'ADM ASSY 1 Cycle 1', '16:00:00', 'shift 1', '00001 TAUFIK RAHMAN', 0.30, '2022-09-20', '2022-09-23 00:00:00', '2022-09-23 09:32:19', '2022-09-23 09:32:21', 5, '17 hour 32 minutes', '00001 TAUFIK RAHMAN', '00001 TAUFIK RAHMAN', '0.033333333333333', 'test agil', 'test agil', '2022-09-20 12:00:00', NULL, NULL, NULL, '2022-09-19 16:00:00', NULL, NULL, NULL, 'milk run 1', NULL, NULL, NULL, '2022-09-20 08:54:31', '2022-09-23 02:32:31'),
(6, 'ADM ASSY 1', 1, 60, 'ADM ASSY 1 Cycle 1', '09:00:00', 'SHIFT 1', '00001 TAUFIK RAHMAN', 1.00, '2022-09-23', '2022-09-23 00:00:00', '2022-09-23 09:34:16', '2022-09-23 09:34:18', 5, '0 hour 34 minutes', '00001 TAUFIK RAHMAN', '00001 TAUFIK RAHMAN', '0.033333333333333', 'test agil', 'test agil', '2022-09-23 03:45:00', NULL, NULL, NULL, '2022-09-23 04:05:00', NULL, NULL, NULL, 'vendor 1', NULL, NULL, NULL, '2022-09-23 02:31:43', '2022-09-23 02:34:27'),
(7, 'ADM ASSY 1', 3, 20, 'ADM ASSY 1 Cycle 3', '09:00:00', 'SHIFT 1', '00001 TAUFIK RAHMAN', 0.33, '2022-09-23', '2022-09-23 00:00:00', '2022-09-23 09:40:22', '2022-09-23 09:40:26', 5, '0 hour 40 minutes', '00001 TAUFIK RAHMAN', '00001 TAUFIK RAHMAN', '0.066666666666667', 'test agil', 'test', '2022-09-23 19:15:00', NULL, NULL, NULL, '2022-09-23 19:35:00', NULL, NULL, NULL, 'vendor 3', NULL, NULL, NULL, '2022-09-23 02:39:40', '2022-09-23 02:40:37'),
(8, 'KTSI', 0, 77, 'KTSI', '09:29:00', 'SHIFT 1', '00001 TAUFIK RAHMAN', 1.28, '2022-10-14', '2022-10-14 00:00:00', '2022-10-14 09:28:01', '2022-10-14 09:29:21', 5, '0 hour 0 minutes', '00001 TAUFIK RAHMAN', '00001 TAUFIK RAHMAN', '1.3333333333333', NULL, NULL, '2022-10-14 09:30:00', NULL, NULL, NULL, '2022-10-14 09:50:00', NULL, NULL, NULL, 'vendor 40', NULL, NULL, NULL, '2022-10-14 02:27:51', '2022-10-14 02:29:21'),
(9, 'KTSI', 0, 77, 'KTSI', '09:35:00', 'SHIFT 1', '00001 TAUFIK RAHMAN', 1.28, '2022-10-14', '2022-10-14 00:00:00', '2022-10-14 09:35:41', '2022-10-14 09:35:45', 5, '0 hour 0 minutes', '00001 TAUFIK RAHMAN', '00001 TAUFIK RAHMAN', '0.066666666666667', NULL, NULL, '2022-10-14 09:30:00', NULL, NULL, NULL, '2022-10-14 09:50:00', NULL, NULL, NULL, 'vendor 40', NULL, NULL, NULL, '2022-10-14 02:33:14', '2022-10-14 02:35:45'),
(10, 'KTSI', 0, 77, 'KTSI', '09:42:00', 'SHIFT 1', '00001 TAUFIK RAHMAN', 1.28, '2022-10-14', '2022-10-14 00:00:00', '2022-10-14 09:41:19', '2022-10-14 09:42:04', 5, '0 hour 0 minutes', '00001 TAUFIK RAHMAN', '00001 TAUFIK RAHMAN', '0.75', NULL, NULL, '2022-10-14 09:30:00', NULL, NULL, NULL, '2022-10-14 09:50:00', NULL, NULL, NULL, 'vendor 40', NULL, NULL, NULL, '2022-10-14 02:41:14', '2022-10-14 02:42:04'),
(11, 'KTSI', 0, 77, 'KTSI', '09:47:00', 'SHIFT 1', '00001 TAUFIK RAHMAN', 1.28, '2022-10-14', '2022-10-14 00:00:00', '2022-10-14 09:45:33', '2022-10-14 09:47:27', 5, '0 hour 0 minutes', '00001 TAUFIK RAHMAN', '00001 TAUFIK RAHMAN', '1.9', NULL, NULL, '2022-10-14 09:30:00', NULL, NULL, NULL, '2022-10-14 09:50:00', NULL, NULL, NULL, 'vendor 40', NULL, NULL, NULL, '2022-10-14 02:45:28', '2022-10-14 02:47:27'),
(12, 'ADM ASSY 1', 1, 60, 'ADM ASSY 1 Cycle 1', '10:00:00', 'SHIFT 1', '00001 TAUFIK RAHMAN', 1.00, '2023-01-04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-01-04 03:45:00', NULL, NULL, NULL, '2023-01-04 04:05:00', NULL, NULL, NULL, 'vendor 1', NULL, NULL, NULL, '2023-01-04 02:48:21', '2023-01-04 02:48:21');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_skills`
--

CREATE TABLE `delivery_skills` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `skill_code` varchar(255) NOT NULL,
  `skill` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delivery_skills`
--

INSERT INTO `delivery_skills` (`id`, `skill_code`, `skill`, `category`, `created_at`, `updated_at`) VALUES
(1, 'Create MO', 'Create MO', 'PPC', '2022-07-11 12:30:11', '2022-07-11 12:30:11'),
(2, 'Create PRO', 'Create PRO', 'PPC', '2022-07-11 12:30:21', '2022-07-11 12:30:21'),
(3, 'Print Partcard', 'Print Partcard', 'PPC', '2022-07-11 12:30:31', '2022-07-11 12:30:31'),
(4, 'Create RPB', 'Create RPB', 'PPC', '2022-07-11 12:30:40', '2022-07-11 12:30:40'),
(5, 'Pulling FG', 'Pulling FG', 'Pulling FG OEM', '2022-07-11 12:30:53', '2022-07-11 12:30:53'),
(6, 'Backflush transaction', 'Backflush transaction', 'Pulling FG OEM', '2022-07-11 12:31:06', '2022-07-11 12:31:06'),
(7, 'FIFO', 'FIFO', 'Pulling FG OEM', '2022-07-11 12:31:21', '2022-07-11 12:31:21'),
(8, 'Update Stock FG', 'Update Stock FG', 'Pulling FG OEM', '2022-07-11 12:31:30', '2022-07-11 12:31:30'),
(9, 'Compare data', 'Compare data pulling vs system marris', 'Pulling FG OEM', '2022-07-11 12:31:44', '2022-07-19 20:08:22'),
(10, 'Download Kanban Customer email / portal', 'Download Kanban Customer email / portal', 'Delivery Control', '2022-07-11 12:32:00', '2022-07-11 12:32:00'),
(11, 'Print Delivery Noted & Kanban Customer', 'Print Delivery Noted & Kanban Customer', 'Delivery Control', '2022-07-11 12:32:11', '2022-07-11 12:32:31'),
(12, 'Prepare Surat Jalan', 'Prepare Surat Jalan', 'Delivery Control', '2022-07-11 12:32:54', '2022-07-11 12:32:54'),
(13, 'Upload DO', 'Upload data order to customer', 'Delivery Control', '2022-07-11 12:33:05', '2022-07-19 20:09:03'),
(14, 'Prepare delivery ADM SAP', 'Prepare delivery ADM SAP', 'Preparation Delivery OEM', '2022-07-11 12:33:20', '2022-07-11 12:33:20'),
(15, 'Prepare delivery ADM KAP', 'Prepare delivery ADM KAP', 'Preparation Delivery OEM', '2022-07-11 12:33:33', '2022-07-11 12:33:33'),
(16, 'Prepare delivery TMMIN', 'Prepare delivery TMMIN', 'Preparation Delivery OEM', '2022-07-11 12:33:44', '2022-07-11 12:33:44'),
(17, 'Prepare delviery IAMI', 'Prepare delviery IAMI', 'Preparation Delivery OEM', '2022-07-11 12:33:58', '2022-07-11 12:33:58'),
(18, 'Prepare delivery customer direct', 'Prepare delivery customer direct', 'Preparation Delivery OEM', '2022-07-11 12:34:09', '2022-07-11 12:34:09'),
(19, 'Backflush transaction Prepare', 'Backflush transaction Prepare', 'Preparation Delivery OEM', '2022-07-11 12:34:34', '2022-07-11 12:34:34'),
(20, 'FIFO Preparation', 'FIFO Preparation', 'Preparation Delivery OEM', '2022-07-11 12:35:57', '2022-07-11 12:35:57'),
(21, 'P & S part', 'Prepare & supply part for packing', 'Sparepart', '2022-07-11 12:36:12', '2022-07-19 20:10:21'),
(22, 'P & S Sticker', 'Prepare & Supply Sticker for packing', 'Sparepart', '2022-07-11 12:36:25', '2022-07-19 20:10:37'),
(23, 'Update Stock SPT', 'Update Stock SPT', 'Sparepart', '2022-07-11 12:38:15', '2022-07-11 12:38:15'),
(24, 'P & S Plastic', 'Prepare  & Supply Plastic for packing', 'Sparepart', '2022-07-11 12:38:29', '2022-07-19 20:09:53'),
(25, 'Prepare Delivery Sparepart', 'Prepare Delivery Sparepart', 'Sparepart', '2022-07-11 12:38:41', '2022-07-11 12:38:41'),
(26, 'Create, Upload & Print ASN', 'Create, Upload & Print ASN', 'Sparepart', '2022-07-11 12:38:52', '2022-07-11 12:38:52'),
(27, 'Prepare box for production', 'Prepare box for production', 'Packaging Control', '2022-07-11 12:39:07', '2022-07-11 12:39:07'),
(28, 'Cleaning return Box from customer', 'Cleaning return Box from customer', 'Packaging Control', '2022-07-11 12:39:18', '2022-07-11 12:39:18'),
(29, 'Maintenance trolly', 'Maintenance trolly', 'Packaging Control', '2022-07-11 12:39:29', '2022-07-11 12:39:29'),
(30, 'Forklift', 'Forklift', 'Packaging Control', '2022-07-11 12:39:40', '2022-07-11 12:39:40'),
(31, 'Control stock packaging', 'Control stock packaging', 'Packaging Control', '2022-07-11 12:39:49', '2022-07-11 12:39:49');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email_depthead` varchar(255) DEFAULT NULL,
  `email_spv` varchar(255) DEFAULT NULL,
  `email_members` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `code`, `name`, `email_depthead`, `email_spv`, `email_members`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'MKT', 'Marketing', NULL, NULL, NULL, '2024-11-03 19:13:29', '2024-11-03 19:13:29', NULL),
(2, 'PE', 'Process Engineering', NULL, NULL, NULL, '2024-11-03 19:13:29', '2024-11-03 19:13:29', NULL),
(3, 'PRODENG', 'Product Engineering', NULL, NULL, NULL, '2024-11-03 19:13:29', '2024-11-03 19:13:29', NULL),
(4, 'PROD', 'Produksi', NULL, NULL, NULL, '2024-11-03 19:13:29', '2024-11-03 19:13:29', NULL),
(5, 'HRGAEI', 'HRGA EHS IT', NULL, NULL, NULL, '2024-11-03 19:13:29', '2024-11-03 19:13:29', NULL),
(6, 'PUR', 'Purchasing', NULL, NULL, NULL, '2024-11-03 19:13:29', '2024-11-03 19:13:29', NULL),
(7, 'FA', 'Finance', NULL, NULL, NULL, '2024-11-03 19:13:29', '2024-11-03 19:13:29', NULL),
(8, 'QUALITY', 'Quality', NULL, NULL, NULL, '2024-11-03 19:13:29', '2024-11-03 19:13:29', NULL),
(9, 'PPIC', 'Product Plan Inventory Control', NULL, NULL, NULL, '2024-11-03 19:13:29', '2024-11-03 19:13:29', NULL),
(10, 'ME', 'Maintenance Engineering', NULL, NULL, NULL, '2024-11-03 19:13:29', '2024-11-03 19:13:29', NULL),
(11, 'BOD', 'Board Of Director', NULL, NULL, NULL, '2024-11-03 19:13:29', '2024-11-03 19:13:29', NULL),
(12, 'PPM', 'PRODPPICME', NULL, NULL, NULL, '2024-11-03 19:13:29', '2024-11-03 19:13:29', NULL),
(13, 'PEQA', 'PEQUALITY', NULL, NULL, NULL, '2024-11-03 19:13:29', '2024-11-03 19:13:29', NULL),
(14, 'PM', 'PEME', NULL, NULL, NULL, '2024-11-03 19:13:29', '2024-11-03 19:13:29', NULL),
(15, 'QA', 'Quality Assurance', NULL, NULL, NULL, '2024-11-03 19:13:29', '2024-11-03 19:13:29', NULL),
(17, 'ADM', 'Admin', NULL, NULL, NULL, '2024-11-04 18:30:06', '2025-01-14 04:24:46', NULL),
(18, 'EI', 'EHS IT', NULL, NULL, NULL, '2024-11-11 03:25:30', '2024-11-11 03:25:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `detail_departement`
--

CREATE TABLE `detail_departement` (
  `id` int(11) NOT NULL,
  `departement_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(100) NOT NULL,
  `email_depthead` varchar(255) DEFAULT NULL,
  `email_director` varchar(255) DEFAULT NULL,
  `email_spv` varchar(255) DEFAULT NULL,
  `email_members` varchar(255) DEFAULT NULL COMMENT 'lebih dari satu pake '',''',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `detail_departement`
--

INSERT INTO `detail_departement` (`id`, `departement_id`, `name`, `code`, `email_depthead`, `email_director`, `email_spv`, `email_members`, `created_at`, `updated_at`) VALUES
(1, 1, 'Marketing', 'MKT', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', NULL, '2024-11-11 12:42:29'),
(2, 2, 'New Product Development', 'NPD', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', NULL, '2024-11-11 12:42:29'),
(3, 3, 'Research And Development', 'RND', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', NULL, '2024-11-11 12:42:29'),
(4, 3, 'Human Resource', 'HR', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', NULL, '2024-11-11 12:42:29'),
(5, 4, 'General Affair', 'GA', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', NULL, '2024-11-11 12:42:29'),
(6, 4, 'Environtment Health Safety', 'EHS', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', NULL, '2024-11-11 12:42:29'),
(7, 5, 'Information Technology', 'IT', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', NULL, '2024-11-11 12:42:29'),
(8, 5, 'Export Import', 'EXIM', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', NULL, '2024-11-11 12:42:29'),
(9, 5, 'Legal', 'LA', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', NULL, '2024-11-11 12:42:29'),
(10, 5, 'Payroll & Personalia', 'PNP', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', NULL, '2024-11-11 12:42:29'),
(11, 5, 'GA MBT', 'GA MBT', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', NULL, '2024-11-11 12:42:29'),
(12, 5, 'Purchasing', 'PUR', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', NULL, '2024-11-11 12:42:29'),
(13, 6, 'Finance', 'FA', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', NULL, '2024-11-11 12:42:29'),
(14, 7, 'Coasting, General Ledger & Tax', 'CGLT', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', NULL, '2024-11-11 12:42:29'),
(15, 8, 'Production Planning Control', 'PPC', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', NULL, '2024-11-11 12:42:29'),
(16, 8, 'Inventory Control', 'IC', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', NULL, '2024-11-11 12:42:29'),
(17, 9, 'Planning & WHFG', 'PNWHFG', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', NULL, '2024-11-11 12:42:29'),
(18, 9, 'Incoming', 'INC', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', NULL, '2024-11-11 12:42:29'),
(19, 10, 'WHRM & WHRG', 'WHRMNWHFG', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', NULL, '2024-11-11 12:42:29'),
(20, 11, 'Production Assembling', 'PA', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', NULL, '2024-11-25 15:27:30'),
(21, 0, 'Assembling', 'ASMBLI', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', '2024-11-06 07:43:33', '2024-11-11 12:42:29'),
(22, 0, 'Delivery', 'DEL', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', '2024-11-06 07:43:33', '2024-11-11 12:42:29'),
(23, 0, 'Board of Direction', 'BOD', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', '2024-11-06 07:43:33', '2024-11-11 12:42:29'),
(24, 0, 'Warehouse', 'HW', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', '2024-11-06 07:43:33', '2024-11-11 12:42:29'),
(25, 0, 'Process Engineering', 'PE', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', '2024-11-06 07:43:33', '2024-11-11 12:42:29'),
(26, 0, 'Assy Koja', 'ASSY', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', '2024-11-06 07:43:33', '2024-11-11 12:42:29'),
(27, 0, 'Injection Surface', 'INJSUR', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', '2024-11-06 07:43:33', '2024-11-25 15:27:30'),
(28, 0, 'Maintenance Engineering', 'ME', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', '2024-11-06 07:43:33', '2024-11-11 12:42:29'),
(29, 0, 'Mold Maintenance', 'MM', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', '2024-11-06 07:43:33', '2024-11-11 12:42:30'),
(30, 0, 'PE Injection', 'PEINJ', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', '2024-11-06 07:43:33', '2024-11-11 12:42:30'),
(31, 0, 'PE Surface', 'PESUR', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', '2024-11-06 07:43:33', '2024-11-11 12:42:30'),
(32, 0, 'PE Assembling', 'PEASS', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', '2024-11-06 07:43:33', '2024-11-11 12:42:30'),
(33, 0, 'PE Project', 'PEPROJ', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', '2024-11-06 07:43:33', '2024-11-11 12:42:30'),
(34, 0, 'ME Injection', 'MEINJ', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', '2024-11-06 07:43:33', '2024-11-11 12:42:30'),
(35, 0, 'ME Surface', 'MESUR', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', '2024-11-06 07:43:33', '2024-11-11 12:42:30'),
(36, 0, 'ME Assembling', 'MEASS', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', '2024-11-06 07:43:33', '2024-11-11 12:42:30'),
(37, 0, 'ME Utility', 'MEUTY', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', '2024-11-06 07:43:33', '2024-11-11 12:42:30'),
(38, 0, 'Built & Facility', 'BNF', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', '2024-11-06 07:43:33', '2024-11-11 12:42:30'),
(39, 0, 'Quality Control', 'QC', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', '2024-11-06 07:43:34', '2024-11-11 12:42:30'),
(40, 0, 'Quality Assurance', 'QA', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', '2024-11-06 07:43:34', '2024-11-11 12:42:30'),
(41, 0, 'Quality Engineering', 'QE', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', '2024-11-06 07:43:34', '2024-11-11 12:42:30'),
(42, 0, 'Quality Rep. Off', 'QRO', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', '2024-11-06 07:43:34', '2024-11-11 12:42:30'),
(43, 0, 'Product Engineering', 'ProdEng', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', '2024-11-25 08:27:30', '2024-11-25 15:27:30'),
(44, 0, 'Injection', 'INJ', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', '2024-11-06 07:43:34', '2024-11-25 15:27:30'),
(45, 0, 'Surface', 'SUR', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', '2024-11-25 08:27:30', '2024-11-25 15:27:30'),
(46, 0, 'Assembling 2W', 'Assy 2W', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', '2024-11-25 08:27:30', '2024-11-25 15:27:30'),
(47, 0, 'Assembling 4W', 'Assy 4W', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', 'miqdad.amarullah@astra-juoku.com', '2024-11-25 08:27:30', '2024-11-25 15:27:30'),
(48, 0, 'Admin', 'ADM', NULL, NULL, NULL, NULL, '2025-01-14 04:24:46', '2025-01-14 11:24:46');

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
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `doc_number` varchar(255) DEFAULT NULL,
  `doc_name` mediumtext NOT NULL,
  `doc_date` date DEFAULT NULL,
  `doc_date_exp` date DEFAULT NULL,
  `doc_note` mediumtext DEFAULT NULL,
  `doc_type` varchar(255) NOT NULL,
  `doc_size` varchar(255) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `dept_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ga_work_order`
--

CREATE TABLE `ga_work_order` (
  `id` int(11) NOT NULL,
  `machine_detail_id` int(9) DEFAULT NULL,
  `mold_detail_id` int(9) DEFAULT NULL,
  `doc_id` varchar(99) DEFAULT NULL,
  `req_date` datetime DEFAULT NULL,
  `target_date` datetime DEFAULT NULL,
  `close_date` datetime DEFAULT NULL,
  `detail_dept` varchar(10) NOT NULL,
  `dept` varchar(10) NOT NULL,
  `requestor_name` varchar(255) NOT NULL,
  `requestor_email` varchar(255) DEFAULT NULL,
  `jenis_wo` int(1) NOT NULL DEFAULT 0 COMMENT '0. depthead requestor\r\n1. supervisor GA\r\n2. Depthead GA\r\n3. assigned\r\n4. selesai\r\n5. reject\r\n6. supervisor requestor',
  `category` int(1) NOT NULL,
  `skala_prioritas` int(1) NOT NULL DEFAULT 3,
  `wo_dept` varchar(20) NOT NULL,
  `masalah` text NOT NULL,
  `sebab` text NOT NULL,
  `permintaan` text NOT NULL,
  `keterangan` text DEFAULT NULL,
  `approval_status` int(1) NOT NULL DEFAULT 6 COMMENT '0. depthead requestor\r\n1. GA\r\n2. Depthead GA\r\n3. assigned\r\n4. selesai\r\n5. reject',
  `history_approval` text DEFAULT NULL,
  `dokumen` text DEFAULT NULL,
  `evidence` text DEFAULT NULL,
  `progress` int(3) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `last_login_at` datetime DEFAULT NULL,
  `last_login_ip` varchar(255) DEFAULT NULL,
  `last_download_file_at` datetime DEFAULT NULL,
  `last_download_file_id` bigint(20) UNSIGNED DEFAULT NULL,
  `last_delete_file_at` datetime DEFAULT NULL,
  `last_delete_file_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `user_id`, `last_login_at`, `last_login_ip`, `last_download_file_at`, `last_download_file_id`, `last_delete_file_at`, `last_delete_file_id`, `created_at`, `updated_at`) VALUES
(1, 45, '2023-01-17 10:35:50', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-17 03:35:50', '2023-01-17 03:35:50'),
(2, 46, '2023-01-17 10:36:08', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-17 03:36:08', '2023-01-17 03:36:08'),
(3, 53, '2023-01-17 10:36:29', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-17 03:36:29', '2023-01-17 03:36:29'),
(4, 46, '2023-01-17 10:41:16', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-17 03:41:16', '2023-01-17 03:41:16'),
(5, 46, '2023-01-17 10:52:08', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-17 03:52:08', '2023-01-17 03:52:08'),
(6, 45, '2023-01-17 11:23:24', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-17 04:23:24', '2023-01-17 04:23:24'),
(7, 45, '2023-01-17 12:25:38', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-17 05:25:38', '2023-01-17 05:25:38'),
(8, 45, '2023-01-17 12:27:05', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-17 05:27:05', '2023-01-17 05:27:05'),
(9, 45, '2023-01-17 12:28:55', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-17 05:28:55', '2023-01-17 05:28:55'),
(10, 46, '2023-01-17 12:29:12', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-17 05:29:12', '2023-01-17 05:29:12'),
(11, 54, '2023-01-17 12:29:47', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-17 05:29:47', '2023-01-17 05:29:47'),
(12, 45, '2023-01-17 12:43:19', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-17 05:43:19', '2023-01-17 05:43:19'),
(13, 46, '2023-01-17 12:43:33', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-17 05:43:33', '2023-01-17 05:43:33'),
(14, 55, '2023-01-17 12:44:00', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-17 05:44:00', '2023-01-17 05:44:00'),
(15, 46, '2023-01-17 13:09:12', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-17 06:09:12', '2023-01-17 06:09:12'),
(16, 46, '2023-01-17 13:15:09', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-17 06:15:09', '2023-01-17 06:15:09'),
(17, 4, '2023-01-17 13:15:52', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-17 06:15:52', '2023-01-17 06:15:52'),
(18, 45, '2023-01-17 14:38:14', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-17 07:38:14', '2023-01-17 07:38:14'),
(19, 46, '2023-01-17 14:39:27', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-17 07:39:27', '2023-01-17 07:39:27'),
(20, 56, '2023-01-17 14:42:36', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-17 07:42:36', '2023-01-17 07:42:36'),
(21, 45, '2023-01-17 14:47:55', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-17 07:47:55', '2023-01-17 07:47:55'),
(22, 46, '2023-01-17 14:48:13', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-17 07:48:13', '2023-01-17 07:48:13'),
(23, 57, '2023-01-17 14:48:27', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-17 07:48:27', '2023-01-17 07:48:27'),
(24, 45, '2023-01-17 14:52:25', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-17 07:52:25', '2023-01-17 07:52:25'),
(25, 46, '2023-01-17 14:52:39', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-17 07:52:39', '2023-01-17 07:52:39'),
(26, 58, '2023-01-17 14:53:32', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-17 07:53:32', '2023-01-17 07:53:32'),
(27, 58, '2023-01-17 14:54:29', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-17 07:54:29', '2023-01-17 07:54:29'),
(28, 39, '2023-01-17 14:56:40', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-17 07:56:40', '2023-01-17 07:56:40'),
(29, 58, '2023-01-17 14:58:06', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-17 07:58:06', '2023-01-17 07:58:06'),
(30, 45, '2023-01-17 15:01:32', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-17 08:01:32', '2023-01-17 08:01:32'),
(31, 46, '2023-01-17 15:01:46', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-17 08:01:46', '2023-01-17 08:01:46'),
(32, 4, '2023-01-17 15:02:04', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-17 08:02:04', '2023-01-17 08:02:04'),
(33, 4, '2023-01-17 15:08:17', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-17 08:08:17', '2023-01-17 08:08:17'),
(34, 32, '2023-01-17 15:13:31', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-17 08:13:31', '2023-01-17 08:13:31'),
(35, 4, '2023-01-18 11:19:10', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-18 04:19:10', '2023-01-18 04:19:10'),
(36, 44, '2023-01-19 10:04:48', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-19 03:04:48', '2023-01-19 03:04:48'),
(37, 45, '2023-01-19 10:24:48', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-19 03:24:48', '2023-01-19 03:24:48'),
(38, 46, '2023-01-19 10:40:23', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-19 03:40:23', '2023-01-19 03:40:23'),
(39, 46, '2023-01-19 10:42:27', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-19 03:42:27', '2023-01-19 03:42:27'),
(40, 46, '2023-01-19 10:43:00', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-19 03:43:00', '2023-01-19 03:43:00'),
(41, 47, '2023-01-19 10:46:05', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-19 03:46:05', '2023-01-19 03:46:05'),
(42, 4, '2023-01-19 10:46:48', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-19 03:46:48', '2023-01-19 03:46:48'),
(43, 45, '2023-01-19 10:55:20', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-19 03:55:20', '2023-01-19 03:55:20'),
(44, 45, '2023-01-19 11:41:57', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-19 04:41:57', '2023-01-19 04:41:57'),
(45, 45, '2023-01-19 11:50:16', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-19 04:50:16', '2023-01-19 04:50:16'),
(46, 45, '2023-01-23 10:01:28', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-23 03:01:28', '2023-01-23 03:01:28'),
(47, 45, '2023-01-23 10:28:27', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-23 03:28:27', '2023-01-23 03:28:27'),
(48, 45, '2023-01-23 10:45:52', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-23 03:45:52', '2023-01-23 03:45:52'),
(49, 45, '2023-01-23 11:24:07', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-23 04:24:07', '2023-01-23 04:24:07'),
(50, 46, '2023-01-23 11:35:20', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-23 04:35:20', '2023-01-23 04:35:20'),
(51, 45, '2023-01-23 11:44:32', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-23 04:44:32', '2023-01-23 04:44:32'),
(52, 46, '2023-01-23 11:46:47', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-23 04:46:47', '2023-01-23 04:46:47'),
(53, 45, '2023-01-23 11:51:27', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-23 04:51:27', '2023-01-23 04:51:27'),
(54, 46, '2023-01-23 11:52:35', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-23 04:52:35', '2023-01-23 04:52:35'),
(55, 50, '2023-01-23 11:53:00', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-23 04:53:00', '2023-01-23 04:53:00'),
(56, 45, '2023-01-23 11:55:23', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-23 04:55:23', '2023-01-23 04:55:23'),
(57, 45, '2023-01-23 11:58:03', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-23 04:58:03', '2023-01-23 04:58:03'),
(58, 4, '2023-01-23 12:37:59', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-23 05:37:59', '2023-01-23 05:37:59'),
(59, 45, '2023-01-23 13:52:05', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-23 06:52:05', '2023-01-23 06:52:05'),
(60, 46, '2023-01-23 13:53:37', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-23 06:53:37', '2023-01-23 06:53:37'),
(61, 51, '2023-01-23 13:54:41', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-23 06:54:41', '2023-01-23 06:54:41'),
(62, 4, '2023-01-23 13:55:13', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-23 06:55:13', '2023-01-23 06:55:13'),
(63, 51, '2023-01-23 13:57:54', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-23 06:57:54', '2023-01-23 06:57:54'),
(64, 4, '2023-01-23 13:58:17', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-23 06:58:17', '2023-01-23 06:58:17'),
(65, 4, '2023-01-23 14:47:47', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-23 07:47:47', '2023-01-23 07:47:47'),
(66, 4, '2023-01-23 14:59:35', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-23 07:59:35', '2023-01-23 07:59:35'),
(67, 4, '2023-01-24 08:54:38', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-24 01:54:38', '2023-01-24 01:54:38'),
(68, 44, '2023-01-24 09:14:56', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-24 02:14:56', '2023-01-24 02:14:56'),
(69, 4, '2023-01-24 10:59:17', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-24 03:59:17', '2023-01-24 03:59:17'),
(70, 44, '2023-01-24 10:59:53', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-24 03:59:53', '2023-01-24 03:59:53'),
(71, 4, '2023-01-24 15:04:11', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-24 08:04:11', '2023-01-24 08:04:11'),
(72, 45, '2023-01-24 15:06:25', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-24 08:06:25', '2023-01-24 08:06:25'),
(73, 44, '2023-01-25 08:14:09', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-25 01:14:09', '2023-01-25 01:14:09'),
(74, 44, '2023-01-26 12:41:11', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-26 05:41:11', '2023-01-26 05:41:11'),
(75, 4, '2023-01-26 12:52:33', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-26 05:52:33', '2023-01-26 05:52:33'),
(76, 4, '2023-01-30 08:42:23', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-30 01:42:23', '2023-01-30 01:42:23'),
(77, 32, '2023-01-30 08:42:37', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-30 01:42:37', '2023-01-30 01:42:37'),
(78, 39, '2023-01-30 08:53:48', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-30 01:53:48', '2023-01-30 01:53:48'),
(79, 4, '2023-01-30 15:17:19', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-30 08:17:19', '2023-01-30 08:17:19'),
(80, 45, '2023-01-31 13:04:34', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-31 06:04:34', '2023-01-31 06:04:34'),
(81, 4, '2023-01-31 13:22:47', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-01-31 06:22:47', '2023-01-31 06:22:47'),
(82, 51, '2023-02-02 10:47:54', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-02 03:47:54', '2023-02-02 03:47:54'),
(83, 4, '2023-02-02 10:53:13', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-02 03:53:13', '2023-02-02 03:53:13'),
(84, 51, '2023-02-02 10:53:42', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-02 03:53:42', '2023-02-02 03:53:42'),
(85, 4, '2023-02-02 11:21:41', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-02 04:21:41', '2023-02-02 04:21:41'),
(86, 51, '2023-02-02 13:13:15', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-02 06:13:15', '2023-02-02 06:13:15'),
(87, 4, '2023-02-02 13:39:40', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-02 06:39:40', '2023-02-02 06:39:40'),
(88, 51, '2023-02-02 13:42:56', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-02 06:42:56', '2023-02-02 06:42:56'),
(89, 51, '2023-02-03 08:44:58', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-03 01:44:58', '2023-02-03 01:44:58'),
(90, 46, '2023-02-09 13:26:17', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-09 06:26:17', '2023-02-09 06:26:17'),
(91, 4, '2023-02-09 15:39:34', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-09 08:39:34', '2023-02-09 08:39:34'),
(92, 4, '2023-02-09 15:42:15', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-09 08:42:15', '2023-02-09 08:42:15'),
(93, 46, '2023-02-09 15:42:26', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-09 08:42:26', '2023-02-09 08:42:26'),
(94, 4, '2023-02-09 15:49:52', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-09 08:49:52', '2023-02-09 08:49:52'),
(95, 46, '2023-02-09 15:50:22', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-09 08:50:22', '2023-02-09 08:50:22'),
(96, 39, '2023-02-13 13:57:08', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-13 06:57:08', '2023-02-13 06:57:08'),
(97, 45, '2023-02-14 11:55:57', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-14 04:55:57', '2023-02-14 04:55:57'),
(98, 4, '2023-02-14 13:03:57', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-14 06:03:57', '2023-02-14 06:03:57'),
(99, 39, '2023-02-14 13:20:13', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-14 06:20:13', '2023-02-14 06:20:13'),
(100, 41, '2023-02-14 13:25:31', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-14 06:25:31', '2023-02-14 06:25:31'),
(101, 4, '2023-02-14 13:34:27', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-14 06:34:27', '2023-02-14 06:34:27'),
(102, 46, '2023-02-16 10:47:13', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-16 03:47:13', '2023-02-16 03:47:13'),
(103, 4, '2023-02-16 10:58:14', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-16 03:58:14', '2023-02-16 03:58:14'),
(104, 46, '2023-02-16 10:58:49', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-16 03:58:49', '2023-02-16 03:58:49'),
(105, 4, '2023-02-16 11:23:13', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-16 04:23:13', '2023-02-16 04:23:13'),
(106, 46, '2023-02-16 11:24:46', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-16 04:24:46', '2023-02-16 04:24:46'),
(107, 4, '2023-02-17 08:35:17', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-17 01:35:17', '2023-02-17 01:35:17'),
(108, 46, '2023-02-17 08:36:00', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-17 01:36:00', '2023-02-17 01:36:00'),
(109, 4, '2023-02-17 09:06:04', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-17 02:06:04', '2023-02-17 02:06:04'),
(110, 51, '2023-02-17 09:06:39', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-17 02:06:39', '2023-02-17 02:06:39'),
(111, 46, '2023-02-17 09:14:04', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-17 02:14:04', '2023-02-17 02:14:04'),
(112, 45, '2023-02-17 09:57:35', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-17 02:57:35', '2023-02-17 02:57:35'),
(113, 46, '2023-02-17 09:57:50', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-17 02:57:50', '2023-02-17 02:57:50'),
(114, 45, '2023-02-17 09:58:04', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-17 02:58:04', '2023-02-17 02:58:04'),
(115, 46, '2023-02-17 10:01:35', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-17 03:01:35', '2023-02-17 03:01:35'),
(116, 4, '2023-02-17 10:09:22', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-17 03:09:22', '2023-02-17 03:09:22'),
(117, 46, '2023-02-17 10:11:27', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-17 03:11:27', '2023-02-17 03:11:27'),
(118, 52, '2023-02-17 10:12:41', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-17 03:12:41', '2023-02-17 03:12:41'),
(119, 46, '2023-02-17 10:13:28', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-17 03:13:28', '2023-02-17 03:13:28'),
(120, 51, '2023-02-17 12:30:16', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-17 05:30:16', '2023-02-17 05:30:16'),
(121, 51, '2023-02-17 13:24:59', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-17 06:24:59', '2023-02-17 06:24:59'),
(122, 46, '2023-02-17 13:26:00', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-17 06:26:00', '2023-02-17 06:26:00'),
(123, 39, '2023-02-17 14:05:19', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-17 07:05:19', '2023-02-17 07:05:19'),
(124, 36, '2023-02-17 14:20:55', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-17 07:20:55', '2023-02-17 07:20:55'),
(125, 32, '2023-02-17 14:23:48', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-17 07:23:48', '2023-02-17 07:23:48'),
(126, 46, '2023-02-17 14:24:53', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-17 07:24:53', '2023-02-17 07:24:53'),
(127, 45, '2023-02-17 14:27:38', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-17 07:27:38', '2023-02-17 07:27:38'),
(128, 45, '2023-02-17 14:28:57', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-17 07:28:57', '2023-02-17 07:28:57'),
(129, 46, '2023-02-17 14:29:54', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-17 07:29:54', '2023-02-17 07:29:54'),
(130, 51, '2023-02-17 14:30:57', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-17 07:30:57', '2023-02-17 07:30:57'),
(131, 46, '2023-02-17 14:32:30', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-17 07:32:30', '2023-02-17 07:32:30'),
(132, 32, '2023-02-17 14:34:00', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-17 07:34:00', '2023-02-17 07:34:00'),
(133, 46, '2023-02-17 14:34:51', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-17 07:34:51', '2023-02-17 07:34:51'),
(134, 51, '2023-02-17 14:39:16', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-17 07:39:16', '2023-02-17 07:39:16'),
(135, 44, '2023-02-21 12:54:15', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-21 05:54:15', '2023-02-21 05:54:15'),
(136, 44, '2023-02-23 09:45:27', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-23 02:45:27', '2023-02-23 02:45:27'),
(137, 46, '2023-02-23 09:52:04', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-23 02:52:04', '2023-02-23 02:52:04'),
(138, 51, '2023-02-23 13:34:45', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-23 06:34:45', '2023-02-23 06:34:45'),
(139, 4, '2023-02-23 13:37:47', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-23 06:37:47', '2023-02-23 06:37:47'),
(140, 51, '2023-02-23 13:39:02', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-23 06:39:02', '2023-02-23 06:39:02'),
(141, 51, '2023-02-23 13:47:20', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-23 06:47:20', '2023-02-23 06:47:20'),
(142, 45, '2023-02-24 14:49:23', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-24 07:49:23', '2023-02-24 07:49:23'),
(143, 46, '2023-02-24 14:50:49', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-24 07:50:49', '2023-02-24 07:50:49'),
(144, 52, '2023-02-24 14:52:11', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-24 07:52:11', '2023-02-24 07:52:11'),
(145, 46, '2023-02-24 14:53:34', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-02-24 07:53:34', '2023-02-24 07:53:34'),
(146, 32, '2023-03-01 08:47:12', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-01 01:47:12', '2023-03-01 01:47:12'),
(147, 46, '2023-03-06 09:50:46', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-06 02:50:46', '2023-03-06 02:50:46'),
(148, 32, '2023-03-06 10:40:37', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-06 03:40:37', '2023-03-06 03:40:37'),
(149, 32, '2023-03-06 10:47:14', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-06 03:47:14', '2023-03-06 03:47:14'),
(150, 46, '2023-03-06 10:47:31', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-06 03:47:31', '2023-03-06 03:47:31'),
(151, 32, '2023-03-06 10:55:25', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-06 03:55:25', '2023-03-06 03:55:25'),
(152, 46, '2023-03-06 10:59:27', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-06 03:59:27', '2023-03-06 03:59:27'),
(153, 39, '2023-03-06 11:12:22', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-06 04:12:22', '2023-03-06 04:12:22'),
(154, 46, '2023-03-06 11:13:52', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-06 04:13:52', '2023-03-06 04:13:52'),
(155, 45, '2023-03-06 11:26:56', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-06 04:26:56', '2023-03-06 04:26:56'),
(156, 45, '2023-03-06 11:28:32', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-06 04:28:32', '2023-03-06 04:28:32'),
(157, 46, '2023-03-06 11:29:01', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-06 04:29:01', '2023-03-06 04:29:01'),
(158, 4, '2023-03-06 11:39:20', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-06 04:39:20', '2023-03-06 04:39:20'),
(159, 46, '2023-03-06 11:41:48', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-06 04:41:48', '2023-03-06 04:41:48'),
(160, 4, '2023-03-06 11:54:12', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-06 04:54:12', '2023-03-06 04:54:12'),
(161, 4, '2023-03-06 11:57:54', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-06 04:57:54', '2023-03-06 04:57:54'),
(162, 45, '2023-03-06 13:48:04', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-06 06:48:04', '2023-03-06 06:48:04'),
(163, 46, '2023-03-06 13:48:48', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-06 06:48:48', '2023-03-06 06:48:48'),
(164, 4, '2023-03-06 14:42:28', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-06 07:42:28', '2023-03-06 07:42:28'),
(165, 4, '2023-03-06 14:42:41', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-06 07:42:41', '2023-03-06 07:42:41'),
(166, 4, '2023-03-07 08:53:43', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-07 01:53:43', '2023-03-07 01:53:43'),
(167, 46, '2023-03-07 09:03:30', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-07 02:03:30', '2023-03-07 02:03:30'),
(168, 46, '2023-03-07 09:04:44', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-07 02:04:44', '2023-03-07 02:04:44'),
(169, 4, '2023-03-07 09:06:31', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-07 02:06:31', '2023-03-07 02:06:31'),
(170, 46, '2023-03-07 13:10:26', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-07 06:10:26', '2023-03-07 06:10:26'),
(171, 4, '2023-03-07 13:12:44', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-07 06:12:44', '2023-03-07 06:12:44'),
(172, 4, '2023-03-07 13:16:43', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-07 06:16:43', '2023-03-07 06:16:43'),
(173, 4, '2023-03-07 13:17:27', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-07 06:17:27', '2023-03-07 06:17:27'),
(174, 46, '2023-03-07 13:17:52', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-07 06:17:52', '2023-03-07 06:17:52'),
(175, 45, '2023-03-07 13:19:28', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-07 06:19:28', '2023-03-07 06:19:28'),
(176, 4, '2023-03-07 13:20:34', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-07 06:20:34', '2023-03-07 06:20:34'),
(177, 45, '2023-03-07 13:22:27', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-07 06:22:27', '2023-03-07 06:22:27'),
(178, 4, '2023-03-07 13:24:58', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-07 06:24:58', '2023-03-07 06:24:58'),
(179, 46, '2023-03-07 13:26:57', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-07 06:26:57', '2023-03-07 06:26:57'),
(180, 4, '2023-03-07 13:29:47', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-07 06:29:47', '2023-03-07 06:29:47'),
(181, 4, '2023-03-07 13:46:03', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-07 06:46:03', '2023-03-07 06:46:03'),
(182, 45, '2023-03-07 13:47:36', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-07 06:47:36', '2023-03-07 06:47:36'),
(183, 4, '2023-03-07 13:47:55', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-07 06:47:55', '2023-03-07 06:47:55'),
(184, 45, '2023-03-07 14:01:50', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-07 07:01:50', '2023-03-07 07:01:50'),
(185, 4, '2023-03-07 14:02:18', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-07 07:02:18', '2023-03-07 07:02:18'),
(186, 4, '2023-03-07 14:11:18', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-07 07:11:18', '2023-03-07 07:11:18'),
(187, 46, '2023-03-07 14:11:34', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-07 07:11:34', '2023-03-07 07:11:34'),
(188, 46, '2023-03-07 14:19:10', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-07 07:19:10', '2023-03-07 07:19:10'),
(189, 45, '2023-03-07 14:20:04', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-07 07:20:04', '2023-03-07 07:20:04'),
(190, 46, '2023-03-07 14:20:36', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-07 07:20:36', '2023-03-07 07:20:36'),
(191, 39, '2023-03-07 15:58:05', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-07 08:58:05', '2023-03-07 08:58:05'),
(192, 42, '2023-03-07 16:01:14', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-07 09:01:14', '2023-03-07 09:01:14'),
(193, 39, '2023-03-08 09:26:49', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-08 02:26:49', '2023-03-08 02:26:49'),
(194, 42, '2023-03-08 14:05:05', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-08 07:05:05', '2023-03-08 07:05:05'),
(195, 46, '2023-03-08 14:15:15', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-08 07:15:15', '2023-03-08 07:15:15'),
(196, 42, '2023-03-08 14:22:51', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-08 07:22:51', '2023-03-08 07:22:51'),
(197, 39, '2023-03-08 14:48:43', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-08 07:48:43', '2023-03-08 07:48:43'),
(198, 42, '2023-03-08 14:50:43', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-08 07:50:43', '2023-03-08 07:50:43'),
(199, 39, '2023-03-08 14:51:07', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-08 07:51:07', '2023-03-08 07:51:07'),
(200, 42, '2023-03-08 14:54:05', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-08 07:54:05', '2023-03-08 07:54:05'),
(201, 39, '2023-03-08 15:25:07', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-08 08:25:07', '2023-03-08 08:25:07'),
(202, 42, '2023-03-08 15:27:58', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-08 08:27:58', '2023-03-08 08:27:58'),
(203, 39, '2023-03-08 15:31:33', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-08 08:31:33', '2023-03-08 08:31:33'),
(204, 39, '2023-03-08 15:41:34', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-08 08:41:34', '2023-03-08 08:41:34'),
(205, 42, '2023-03-09 13:24:07', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-09 06:24:07', '2023-03-09 06:24:07'),
(206, 39, '2023-03-09 13:30:54', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-09 06:30:54', '2023-03-09 06:30:54'),
(207, 40, '2023-03-09 13:39:45', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-09 06:39:45', '2023-03-09 06:39:45'),
(208, 39, '2023-03-09 13:41:23', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-09 06:41:23', '2023-03-09 06:41:23'),
(209, 39, '2023-03-09 14:41:53', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-09 07:41:53', '2023-03-09 07:41:53'),
(210, 46, '2023-03-10 11:20:22', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-10 04:20:22', '2023-03-10 04:20:22'),
(211, 45, '2023-03-14 09:19:00', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-14 02:19:00', '2023-03-14 02:19:00'),
(212, 4, '2023-03-14 09:19:27', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-14 02:19:27', '2023-03-14 02:19:27'),
(213, 45, '2023-03-14 09:28:49', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-14 02:28:49', '2023-03-14 02:28:49'),
(214, 4, '2023-03-14 09:29:07', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-14 02:29:07', '2023-03-14 02:29:07'),
(215, 45, '2023-03-14 09:35:26', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-14 02:35:26', '2023-03-14 02:35:26'),
(216, 4, '2023-03-14 09:35:44', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-14 02:35:44', '2023-03-14 02:35:44'),
(217, 45, '2023-03-14 09:41:48', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-14 02:41:48', '2023-03-14 02:41:48'),
(218, 4, '2023-03-14 09:42:07', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-14 02:42:07', '2023-03-14 02:42:07'),
(219, 65, '2023-03-14 09:44:54', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-14 02:44:54', '2023-03-14 02:44:54'),
(220, 45, '2023-03-14 09:47:20', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-14 02:47:20', '2023-03-14 02:47:20'),
(221, 4, '2023-03-14 09:47:40', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-14 02:47:40', '2023-03-14 02:47:40'),
(222, 45, '2023-03-14 10:37:47', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-14 03:37:47', '2023-03-14 03:37:47'),
(223, 4, '2023-03-14 10:38:09', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-14 03:38:09', '2023-03-14 03:38:09'),
(224, 45, '2023-03-14 11:00:22', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-14 04:00:22', '2023-03-14 04:00:22'),
(225, 4, '2023-03-14 11:02:48', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-14 04:02:48', '2023-03-14 04:02:48'),
(226, 46, '2023-03-14 12:07:23', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-14 05:07:23', '2023-03-14 05:07:23'),
(227, 46, '2023-03-14 12:10:17', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-14 05:10:17', '2023-03-14 05:10:17'),
(228, 4, '2023-03-14 12:10:54', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-14 05:10:54', '2023-03-14 05:10:54'),
(229, 46, '2023-03-14 12:11:56', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-14 05:11:56', '2023-03-14 05:11:56'),
(230, 42, '2023-03-14 12:44:32', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-14 05:44:32', '2023-03-14 05:44:32'),
(231, 39, '2023-03-14 12:46:22', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-14 05:46:22', '2023-03-14 05:46:22'),
(232, 39, '2023-03-14 12:46:33', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-14 05:46:33', '2023-03-14 05:46:33'),
(233, 39, '2023-03-14 13:19:14', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-14 06:19:14', '2023-03-14 06:19:14'),
(234, 46, '2023-03-14 13:19:30', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-14 06:19:30', '2023-03-14 06:19:30'),
(235, 46, '2023-03-14 13:57:51', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-14 06:57:51', '2023-03-14 06:57:51'),
(236, 4, '2023-03-14 15:31:57', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-14 08:31:57', '2023-03-14 08:31:57'),
(237, 46, '2023-03-14 15:32:40', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-14 08:32:40', '2023-03-14 08:32:40'),
(238, 32, '2023-03-14 16:07:13', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-14 09:07:13', '2023-03-14 09:07:13'),
(239, 46, '2023-03-15 10:29:39', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-15 03:29:39', '2023-03-15 03:29:39'),
(240, 42, '2023-03-16 10:57:56', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-16 03:57:56', '2023-03-16 03:57:56'),
(241, 46, '2023-03-16 10:58:37', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-16 03:58:37', '2023-03-16 03:58:37'),
(242, 46, '2023-03-20 16:43:45', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-20 09:43:45', '2023-03-20 09:43:45'),
(243, 46, '2023-03-20 16:52:12', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-20 09:52:12', '2023-03-20 09:52:12'),
(244, 46, '2023-03-20 16:55:39', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-20 09:55:39', '2023-03-20 09:55:39'),
(245, 46, '2023-03-20 16:57:33', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-20 09:57:33', '2023-03-20 09:57:33'),
(246, 46, '2023-03-21 12:07:11', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-21 05:07:11', '2023-03-21 05:07:11'),
(247, 42, '2023-03-21 12:20:27', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-21 05:20:27', '2023-03-21 05:20:27'),
(248, 46, '2023-03-21 12:24:34', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-21 05:24:34', '2023-03-21 05:24:34'),
(249, 45, '2023-03-21 12:35:54', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-21 05:35:54', '2023-03-21 05:35:54'),
(250, 4, '2023-03-21 12:36:26', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-21 05:36:26', '2023-03-21 05:36:26'),
(251, 47, '2023-03-21 12:37:31', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-21 05:37:31', '2023-03-21 05:37:31'),
(252, 45, '2023-03-21 12:38:48', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-21 05:38:48', '2023-03-21 05:38:48'),
(253, 46, '2023-03-21 12:39:09', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-21 05:39:09', '2023-03-21 05:39:09'),
(254, 46, '2023-03-27 09:56:18', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-27 02:56:18', '2023-03-27 02:56:18'),
(255, 4, '2023-03-27 10:54:01', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-27 03:54:01', '2023-03-27 03:54:01'),
(256, 46, '2023-03-27 10:54:42', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-27 03:54:42', '2023-03-27 03:54:42'),
(257, 4, '2023-03-27 11:12:30', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-27 04:12:30', '2023-03-27 04:12:30'),
(258, 46, '2023-03-27 11:13:10', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-27 04:13:10', '2023-03-27 04:13:10'),
(259, 4, '2023-03-27 11:43:41', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-27 04:43:41', '2023-03-27 04:43:41'),
(260, 46, '2023-03-27 11:44:38', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-27 04:44:38', '2023-03-27 04:44:38'),
(261, 45, '2023-03-28 10:11:20', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-28 03:11:20', '2023-03-28 03:11:20'),
(262, 45, '2023-03-28 10:12:55', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-28 03:12:55', '2023-03-28 03:12:55'),
(263, 4, '2023-03-28 10:13:17', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-28 03:13:17', '2023-03-28 03:13:17'),
(264, 46, '2023-03-28 10:13:36', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-28 03:13:36', '2023-03-28 03:13:36'),
(265, 47, '2023-03-28 10:14:57', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-28 03:14:57', '2023-03-28 03:14:57'),
(266, 45, '2023-03-28 10:21:41', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-28 03:21:41', '2023-03-28 03:21:41'),
(267, 45, '2023-03-28 10:22:51', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-28 03:22:51', '2023-03-28 03:22:51'),
(268, 46, '2023-03-28 10:23:30', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-28 03:23:30', '2023-03-28 03:23:30'),
(269, 45, '2023-03-28 10:23:44', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-28 03:23:44', '2023-03-28 03:23:44'),
(270, 46, '2023-03-28 10:44:05', '10.14.189.243', NULL, NULL, NULL, NULL, '2023-03-28 03:44:05', '2023-03-28 03:44:05'),
(271, 46, '2023-03-28 11:01:44', '10.14.189.243', NULL, NULL, NULL, NULL, '2023-03-28 04:01:44', '2023-03-28 04:01:44'),
(272, 46, '2023-03-28 14:20:55', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-28 07:20:55', '2023-03-28 07:20:55'),
(273, 46, '2023-03-28 15:45:02', '10.14.145.27', NULL, NULL, NULL, NULL, '2023-03-28 08:45:03', '2023-03-28 08:45:03'),
(274, 45, '2023-03-29 10:04:41', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-29 03:04:41', '2023-03-29 03:04:41'),
(275, 46, '2023-03-29 10:06:37', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-29 03:06:37', '2023-03-29 03:06:37'),
(276, 46, '2023-03-29 10:11:25', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-29 03:11:25', '2023-03-29 03:11:25'),
(277, 47, '2023-03-29 10:13:34', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-29 03:13:34', '2023-03-29 03:13:34'),
(278, 4, '2023-03-29 10:15:08', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-29 03:15:08', '2023-03-29 03:15:08'),
(279, 46, '2023-03-29 10:16:25', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-29 03:16:25', '2023-03-29 03:16:25'),
(280, 4, '2023-03-29 15:18:03', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-29 08:18:03', '2023-03-29 08:18:03'),
(281, 46, '2023-03-29 15:18:39', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-29 08:18:39', '2023-03-29 08:18:39'),
(282, 44, '2023-03-30 10:57:59', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-30 03:57:59', '2023-03-30 03:57:59'),
(283, 4, '2023-03-30 11:26:24', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-30 04:26:24', '2023-03-30 04:26:24'),
(284, 48, '2023-03-30 11:32:30', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-30 04:32:30', '2023-03-30 04:32:30'),
(285, 44, '2023-03-30 11:34:09', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-30 04:34:09', '2023-03-30 04:34:09'),
(286, 48, '2023-03-30 11:49:26', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-30 04:49:26', '2023-03-30 04:49:26'),
(287, 46, '2023-03-30 12:36:01', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-30 05:36:01', '2023-03-30 05:36:01'),
(288, 4, '2023-03-30 13:54:36', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-30 06:54:36', '2023-03-30 06:54:36'),
(289, 46, '2023-03-30 13:55:09', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-30 06:55:09', '2023-03-30 06:55:09'),
(290, 4, '2023-03-30 14:08:40', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-30 07:08:40', '2023-03-30 07:08:40'),
(291, 46, '2023-03-30 14:09:42', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-30 07:09:42', '2023-03-30 07:09:42'),
(292, 4, '2023-03-30 14:33:11', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-30 07:33:11', '2023-03-30 07:33:11'),
(293, 46, '2023-03-30 14:33:39', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-03-30 07:33:39', '2023-03-30 07:33:39'),
(294, 4, '2023-04-01 10:43:33', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-04-01 03:43:33', '2023-04-01 03:43:33'),
(295, 46, '2023-04-01 10:44:12', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-04-01 03:44:12', '2023-04-01 03:44:12'),
(296, 44, '2023-04-10 13:29:14', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-04-10 06:29:14', '2023-04-10 06:29:14'),
(297, 46, '2023-04-10 15:11:49', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-04-10 08:11:49', '2023-04-10 08:11:49'),
(298, 4, '2023-04-12 14:08:16', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-04-12 07:08:16', '2023-04-12 07:08:16'),
(299, 46, '2023-04-12 14:08:50', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-04-12 07:08:50', '2023-04-12 07:08:50'),
(300, 4, '2023-04-13 14:09:43', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-04-13 07:09:43', '2023-04-13 07:09:43'),
(301, 46, '2023-04-13 14:10:22', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-04-13 07:10:22', '2023-04-13 07:10:22'),
(302, 44, '2023-04-14 10:39:54', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-04-14 03:39:54', '2023-04-14 03:39:54'),
(303, 48, '2023-04-14 13:24:20', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-04-14 06:24:20', '2023-04-14 06:24:20'),
(304, 48, '2023-04-16 18:51:33', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-04-16 11:51:33', '2023-04-16 11:51:33'),
(305, 4, '2023-04-16 18:57:31', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-04-16 11:57:31', '2023-04-16 11:57:31'),
(306, 44, '2023-04-16 18:58:41', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-04-16 11:58:41', '2023-04-16 11:58:41'),
(307, 44, '2023-04-17 08:55:23', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-04-17 01:55:23', '2023-04-17 01:55:23'),
(308, 4, '2023-04-17 10:54:15', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-04-17 03:54:15', '2023-04-17 03:54:15'),
(309, 48, '2023-04-17 14:22:41', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-04-17 07:22:41', '2023-04-17 07:22:41'),
(310, 44, '2023-04-17 14:46:25', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-04-17 07:46:25', '2023-04-17 07:46:25'),
(311, 44, '2023-04-17 14:49:58', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-04-17 07:49:58', '2023-04-17 07:49:58'),
(312, 46, '2023-05-01 08:38:42', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-01 01:38:42', '2023-05-01 01:38:42'),
(313, 44, '2023-05-01 20:35:40', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-01 13:35:40', '2023-05-01 13:35:40'),
(314, 4, '2023-05-01 20:35:55', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-01 13:35:55', '2023-05-01 13:35:55'),
(315, 44, '2023-05-01 20:36:46', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-01 13:36:46', '2023-05-01 13:36:46'),
(316, 4, '2023-05-01 20:37:44', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-01 13:37:44', '2023-05-01 13:37:44'),
(317, 44, '2023-05-01 20:38:59', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-01 13:38:59', '2023-05-01 13:38:59'),
(318, 4, '2023-05-01 20:40:07', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-01 13:40:07', '2023-05-01 13:40:07'),
(319, 44, '2023-05-01 20:40:36', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-01 13:40:36', '2023-05-01 13:40:36'),
(320, 4, '2023-05-01 20:43:48', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-01 13:43:48', '2023-05-01 13:43:48'),
(321, 46, '2023-05-01 20:44:04', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-01 13:44:04', '2023-05-01 13:44:04'),
(322, 46, '2023-05-01 20:46:18', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-01 13:46:18', '2023-05-01 13:46:18'),
(323, 41, '2023-05-02 12:02:12', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-02 05:02:12', '2023-05-02 05:02:12'),
(324, 46, '2023-05-02 12:10:33', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-02 05:10:33', '2023-05-02 05:10:33'),
(325, 44, '2023-05-02 12:19:20', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-02 05:19:20', '2023-05-02 05:19:20'),
(326, 46, '2023-05-02 12:19:55', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-02 05:19:55', '2023-05-02 05:19:55'),
(327, 41, '2023-05-08 15:36:37', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-08 08:36:37', '2023-05-08 08:36:37'),
(328, 41, '2023-05-09 08:07:36', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-09 01:07:36', '2023-05-09 01:07:36'),
(329, 46, '2023-05-09 08:07:53', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-09 01:07:53', '2023-05-09 01:07:53'),
(330, 41, '2023-05-09 10:25:14', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-09 03:25:14', '2023-05-09 03:25:14'),
(331, 39, '2023-05-09 15:44:10', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-09 08:44:10', '2023-05-09 08:44:10'),
(332, 40, '2023-05-09 16:13:20', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-09 09:13:20', '2023-05-09 09:13:20'),
(333, 39, '2023-05-09 16:17:57', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-09 09:17:57', '2023-05-09 09:17:57'),
(334, 4, '2023-05-09 16:34:39', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-09 09:34:39', '2023-05-09 09:34:39'),
(335, 39, '2023-05-09 16:35:54', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-09 09:35:54', '2023-05-09 09:35:54'),
(336, 46, '2023-05-10 14:16:53', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-10 07:16:53', '2023-05-10 07:16:53'),
(337, 46, '2023-05-10 14:33:37', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-10 07:33:37', '2023-05-10 07:33:37'),
(338, 4, '2023-05-11 15:18:55', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-11 08:18:55', '2023-05-11 08:18:55'),
(339, 46, '2023-05-11 15:21:01', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-11 08:21:01', '2023-05-11 08:21:01'),
(340, 4, '2023-05-11 15:24:16', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-11 08:24:16', '2023-05-11 08:24:16'),
(341, 46, '2023-05-11 15:24:46', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-11 08:24:46', '2023-05-11 08:24:46'),
(342, 4, '2023-05-12 08:36:47', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-12 01:36:47', '2023-05-12 01:36:47'),
(343, 48, '2023-05-12 08:40:16', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-12 01:40:16', '2023-05-12 01:40:16'),
(344, 45, '2023-05-12 08:40:36', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-12 01:40:36', '2023-05-12 01:40:36'),
(345, 44, '2023-05-12 08:40:56', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-12 01:40:56', '2023-05-12 01:40:56'),
(346, 46, '2023-05-12 08:43:04', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-12 01:43:04', '2023-05-12 01:43:04'),
(347, 48, '2023-05-12 09:44:32', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-12 02:44:32', '2023-05-12 02:44:32'),
(348, 46, '2023-05-12 13:01:18', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-12 06:01:18', '2023-05-12 06:01:18'),
(349, 48, '2023-05-12 13:02:05', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-12 06:02:05', '2023-05-12 06:02:05'),
(350, 48, '2023-05-12 13:14:08', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-12 06:14:08', '2023-05-12 06:14:08'),
(351, 46, '2023-05-12 13:14:20', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-12 06:14:20', '2023-05-12 06:14:20'),
(352, 48, '2023-05-12 13:14:50', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-12 06:14:50', '2023-05-12 06:14:50'),
(353, 46, '2023-05-12 13:25:01', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-12 06:25:01', '2023-05-12 06:25:01'),
(354, 48, '2023-05-12 13:25:25', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-12 06:25:25', '2023-05-12 06:25:25'),
(355, 46, '2023-05-12 13:28:39', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-12 06:28:39', '2023-05-12 06:28:39'),
(356, 48, '2023-05-12 13:29:19', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-12 06:29:19', '2023-05-12 06:29:19'),
(357, 46, '2023-05-12 13:45:52', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-12 06:45:52', '2023-05-12 06:45:52'),
(358, 48, '2023-05-12 13:46:20', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-12 06:46:20', '2023-05-12 06:46:20'),
(359, 46, '2023-05-12 14:15:00', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-12 07:15:00', '2023-05-12 07:15:00'),
(360, 44, '2023-05-12 14:19:24', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-12 07:19:24', '2023-05-12 07:19:24'),
(361, 44, '2023-05-12 14:25:41', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-12 07:25:41', '2023-05-12 07:25:41'),
(362, 46, '2023-05-12 14:27:48', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-12 07:27:48', '2023-05-12 07:27:48'),
(363, 46, '2023-05-12 14:38:54', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-12 07:38:54', '2023-05-12 07:38:54'),
(364, 45, '2023-05-12 14:39:09', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-12 07:39:09', '2023-05-12 07:39:09'),
(365, 46, '2023-05-14 18:34:21', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-14 11:34:21', '2023-05-14 11:34:21'),
(366, 4, '2023-05-14 20:44:36', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-14 13:44:36', '2023-05-14 13:44:36'),
(367, 46, '2023-05-14 20:45:07', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-14 13:45:07', '2023-05-14 13:45:07'),
(368, 4, '2023-05-14 20:59:48', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-14 13:59:48', '2023-05-14 13:59:48'),
(369, 46, '2023-05-14 21:00:19', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-14 14:00:19', '2023-05-14 14:00:19'),
(370, 44, '2023-05-15 11:14:53', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-15 04:14:53', '2023-05-15 04:14:53'),
(371, 45, '2023-05-15 11:25:41', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-15 04:25:41', '2023-05-15 04:25:41'),
(372, 44, '2023-05-15 13:08:34', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-15 06:08:34', '2023-05-15 06:08:34'),
(373, 45, '2023-05-15 13:14:12', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-15 06:14:12', '2023-05-15 06:14:12'),
(374, 44, '2023-05-15 13:14:36', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-15 06:14:36', '2023-05-15 06:14:36'),
(375, 4, '2023-05-15 13:26:27', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-15 06:26:27', '2023-05-15 06:26:27'),
(376, 46, '2023-05-15 13:29:47', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-15 06:29:47', '2023-05-15 06:29:47'),
(377, 45, '2023-05-15 13:31:37', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-15 06:31:37', '2023-05-15 06:31:37'),
(378, 44, '2023-05-15 13:31:56', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-15 06:31:56', '2023-05-15 06:31:56'),
(379, 46, '2023-05-16 10:30:09', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-16 03:30:09', '2023-05-16 03:30:09'),
(380, 44, '2023-05-16 10:31:38', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-16 03:31:38', '2023-05-16 03:31:38'),
(381, 45, '2023-05-16 11:31:37', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-16 04:31:37', '2023-05-16 04:31:37'),
(382, 48, '2023-05-16 12:10:59', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-16 05:10:59', '2023-05-16 05:10:59'),
(383, 44, '2023-05-16 14:08:08', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-16 07:08:08', '2023-05-16 07:08:08'),
(384, 46, '2023-05-16 14:12:18', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-16 07:12:18', '2023-05-16 07:12:18'),
(385, 44, '2023-05-16 14:12:55', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-16 07:12:55', '2023-05-16 07:12:55'),
(386, 44, '2023-05-19 08:06:13', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-19 01:06:13', '2023-05-19 01:06:13'),
(387, 4, '2023-05-19 08:17:45', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-19 01:17:45', '2023-05-19 01:17:45'),
(388, 44, '2023-05-19 08:19:31', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-19 01:19:31', '2023-05-19 01:19:31'),
(389, 4, '2023-05-19 08:19:52', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-19 01:19:52', '2023-05-19 01:19:52'),
(390, 44, '2023-05-19 08:20:50', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-19 01:20:50', '2023-05-19 01:20:50'),
(391, 4, '2023-05-19 08:39:30', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-19 01:39:30', '2023-05-19 01:39:30'),
(392, 44, '2023-05-19 08:41:15', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-19 01:41:15', '2023-05-19 01:41:15'),
(393, 46, '2023-05-20 13:38:27', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-20 06:38:27', '2023-05-20 06:38:27'),
(394, 44, '2023-05-20 14:02:14', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-20 07:02:14', '2023-05-20 07:02:14'),
(395, 44, '2023-05-22 14:38:37', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-22 07:38:37', '2023-05-22 07:38:37'),
(396, 49, '2023-05-22 15:15:10', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-22 08:15:10', '2023-05-22 08:15:10'),
(397, 49, '2023-05-23 10:15:51', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-23 03:15:51', '2023-05-23 03:15:51'),
(398, 4, '2023-05-23 12:07:18', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-23 05:07:18', '2023-05-23 05:07:18'),
(399, 46, '2023-05-23 12:08:05', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-23 05:08:05', '2023-05-23 05:08:05'),
(400, 4, '2023-05-23 12:58:27', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-23 05:58:27', '2023-05-23 05:58:27'),
(401, 4, '2023-05-23 14:00:37', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-23 07:00:37', '2023-05-23 07:00:37'),
(402, 4, '2023-05-23 15:08:19', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-23 08:08:19', '2023-05-23 08:08:19'),
(403, 5, '2023-05-25 08:02:26', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-25 01:02:26', '2023-05-25 01:02:26'),
(404, 5, '2023-05-25 08:03:17', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-25 01:03:17', '2023-05-25 01:03:17'),
(405, 4, '2023-05-25 08:03:32', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-25 01:03:32', '2023-05-25 01:03:32'),
(406, 4, '2023-05-25 08:05:35', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-25 01:05:35', '2023-05-25 01:05:35'),
(407, 4, '2023-05-25 08:05:41', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-25 01:05:41', '2023-05-25 01:05:41'),
(408, 5, '2023-05-25 08:05:51', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-25 01:05:51', '2023-05-25 01:05:51'),
(409, 5, '2023-05-25 08:07:42', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-25 01:07:42', '2023-05-25 01:07:42'),
(410, 4, '2023-05-25 08:07:52', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-25 01:07:52', '2023-05-25 01:07:52'),
(411, 5, '2023-05-25 08:13:32', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-25 01:13:32', '2023-05-25 01:13:32'),
(412, 6, '2023-05-25 08:14:39', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-25 01:14:39', '2023-05-25 01:14:39'),
(413, 4, '2023-05-25 08:15:40', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-25 01:15:40', '2023-05-25 01:15:40'),
(414, 6, '2023-05-25 08:16:13', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-25 01:16:13', '2023-05-25 01:16:13'),
(415, 5, '2023-05-25 08:16:52', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-25 01:16:52', '2023-05-25 01:16:52'),
(416, 4, '2023-05-25 08:18:01', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-25 01:18:01', '2023-05-25 01:18:01'),
(417, 6, '2023-05-25 08:19:04', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-25 01:19:04', '2023-05-25 01:19:04'),
(418, 6, '2023-05-25 08:20:29', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-25 01:20:29', '2023-05-25 01:20:29'),
(419, 5, '2023-05-25 08:20:41', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-25 01:20:41', '2023-05-25 01:20:41'),
(420, 6, '2023-05-25 08:26:48', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-25 01:26:48', '2023-05-25 01:26:48'),
(421, 5, '2023-05-25 08:39:06', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-25 01:39:06', '2023-05-25 01:39:06'),
(422, 4, '2023-05-25 08:47:20', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-25 01:47:20', '2023-05-25 01:47:20'),
(423, 7, '2023-05-25 08:48:27', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-25 01:48:27', '2023-05-25 01:48:27'),
(424, 4, '2023-05-25 08:51:30', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-25 01:51:30', '2023-05-25 01:51:30'),
(425, 8, '2023-05-25 08:51:53', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-25 01:51:53', '2023-05-25 01:51:53'),
(426, 4, '2023-05-25 09:00:07', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-25 02:00:07', '2023-05-25 02:00:07'),
(427, 9, '2023-05-25 09:00:45', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-25 02:00:45', '2023-05-25 02:00:45'),
(428, 6, '2023-05-25 09:10:52', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-25 02:10:52', '2023-05-25 02:10:52'),
(429, 6, '2023-05-25 10:33:35', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-25 03:33:35', '2023-05-25 03:33:35'),
(430, 5, '2023-05-25 10:44:31', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-25 03:44:31', '2023-05-25 03:44:31'),
(431, 6, '2023-05-25 12:48:56', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-25 05:48:56', '2023-05-25 05:48:56'),
(432, 6, '2023-05-25 12:50:56', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-25 05:50:56', '2023-05-25 05:50:56'),
(433, 5, '2023-05-27 18:52:15', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-27 11:52:15', '2023-05-27 11:52:15'),
(434, 4, '2023-05-28 17:08:49', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-28 10:08:49', '2023-05-28 10:08:49');
INSERT INTO `logs` (`id`, `user_id`, `last_login_at`, `last_login_ip`, `last_download_file_at`, `last_download_file_id`, `last_delete_file_at`, `last_delete_file_id`, `created_at`, `updated_at`) VALUES
(435, 6, '2023-05-28 17:11:10', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-28 10:11:10', '2023-05-28 10:11:10'),
(436, 4, '2023-05-28 17:15:00', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-28 10:15:00', '2023-05-28 10:15:00'),
(437, 6, '2023-05-28 17:15:36', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-28 10:15:36', '2023-05-28 10:15:36'),
(438, 6, '2023-05-28 17:16:58', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-28 10:16:58', '2023-05-28 10:16:58'),
(439, 4, '2023-05-28 18:25:54', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-28 11:25:54', '2023-05-28 11:25:54'),
(440, 6, '2023-05-28 18:42:28', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-28 11:42:28', '2023-05-28 11:42:28'),
(441, 5, '2023-05-28 18:50:53', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-28 11:50:53', '2023-05-28 11:50:53'),
(442, 4, '2023-05-28 18:56:24', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-28 11:56:24', '2023-05-28 11:56:24'),
(443, 6, '2023-05-28 19:00:40', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-28 12:00:40', '2023-05-28 12:00:40'),
(444, 5, '2023-05-29 08:22:15', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-29 01:22:15', '2023-05-29 01:22:15'),
(445, 5, '2023-05-30 08:29:52', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-05-30 01:29:52', '2023-05-30 01:29:52'),
(446, 6, '2023-06-05 14:23:29', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-06-05 07:23:29', '2023-06-05 07:23:29'),
(447, 5, '2023-06-05 14:34:10', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-06-05 07:34:10', '2023-06-05 07:34:10'),
(448, 5, '2023-06-06 08:02:36', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-06-06 01:02:36', '2023-06-06 01:02:36'),
(449, 4, '2023-06-07 08:27:31', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-06-07 01:27:31', '2023-06-07 01:27:31'),
(450, 12, '2023-06-07 08:30:32', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-06-07 01:30:32', '2023-06-07 01:30:32'),
(451, 6, '2023-06-08 09:33:57', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-06-08 02:33:57', '2023-06-08 02:33:57'),
(452, 5, '2023-06-14 13:00:21', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-06-14 06:00:21', '2023-06-14 06:00:21'),
(453, 5, '2023-06-16 14:44:55', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-06-16 07:44:55', '2023-06-16 07:44:55'),
(454, 5, '2023-06-19 15:43:42', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-06-19 08:43:42', '2023-06-19 08:43:42'),
(455, 5, '2023-06-20 11:20:07', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-06-20 04:20:07', '2023-06-20 04:20:07'),
(456, 4, '2023-06-20 11:53:11', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-06-20 04:53:11', '2023-06-20 04:53:11'),
(457, 11, '2023-06-20 11:53:57', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-06-20 04:53:57', '2023-06-20 04:53:57'),
(458, 5, '2023-06-20 11:56:24', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-06-20 04:56:24', '2023-06-20 04:56:24'),
(459, 11, '2023-06-20 11:56:47', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-06-20 04:56:47', '2023-06-20 04:56:47'),
(460, 6, '2023-06-20 11:58:24', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-06-20 04:58:24', '2023-06-20 04:58:24'),
(461, 5, '2023-06-22 10:42:02', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-06-22 03:42:02', '2023-06-22 03:42:02'),
(462, 4, '2023-06-22 12:23:55', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-06-22 05:23:55', '2023-06-22 05:23:55'),
(463, 5, '2023-06-22 13:12:15', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-06-22 06:12:15', '2023-06-22 06:12:15'),
(464, 4, '2023-06-23 11:30:00', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-06-23 04:30:00', '2023-06-23 04:30:00'),
(465, 6, '2023-06-23 11:30:32', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-06-23 04:30:32', '2023-06-23 04:30:32'),
(466, 6, '2023-06-25 08:08:29', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-06-25 01:08:29', '2023-06-25 01:08:29'),
(467, 6, '2023-06-25 12:01:29', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-06-25 05:01:29', '2023-06-25 05:01:29'),
(468, 5, '2023-07-03 11:11:29', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-03 04:11:29', '2023-07-03 04:11:29'),
(469, 4, '2023-07-03 12:31:34', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-03 05:31:34', '2023-07-03 05:31:34'),
(470, 5, '2023-07-03 15:35:02', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-03 08:35:02', '2023-07-03 08:35:02'),
(471, 5, '2023-07-04 10:29:40', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-04 03:29:40', '2023-07-04 03:29:40'),
(472, 5, '2023-07-04 10:46:45', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-04 03:46:45', '2023-07-04 03:46:45'),
(473, 4, '2023-07-04 11:19:47', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-04 04:19:47', '2023-07-04 04:19:47'),
(474, 6, '2023-07-04 11:23:39', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-04 04:23:39', '2023-07-04 04:23:39'),
(475, 13, '2023-07-04 11:23:58', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-04 04:23:58', '2023-07-04 04:23:58'),
(476, 6, '2023-07-04 15:23:10', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-04 08:23:10', '2023-07-04 08:23:10'),
(477, 6, '2023-07-07 14:18:05', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-07 07:18:05', '2023-07-07 07:18:05'),
(478, 6, '2023-07-07 14:18:12', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-07 07:18:12', '2023-07-07 07:18:12'),
(479, 4, '2023-07-07 14:18:35', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-07 07:18:35', '2023-07-07 07:18:35'),
(480, 6, '2023-07-07 14:20:08', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-07 07:20:08', '2023-07-07 07:20:08'),
(481, 4, '2023-07-07 14:46:01', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-07 07:46:01', '2023-07-07 07:46:01'),
(482, 6, '2023-07-07 14:47:13', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-07 07:47:13', '2023-07-07 07:47:13'),
(483, 4, '2023-07-07 14:48:07', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-07 07:48:08', '2023-07-07 07:48:08'),
(484, 6, '2023-07-07 14:50:56', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-07 07:50:56', '2023-07-07 07:50:56'),
(485, 5, '2023-07-11 10:48:32', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-11 03:48:32', '2023-07-11 03:48:32'),
(486, 4, '2023-07-11 12:33:48', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-11 05:33:48', '2023-07-11 05:33:48'),
(487, 5, '2023-07-11 12:34:44', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-11 05:34:44', '2023-07-11 05:34:44'),
(488, 4, '2023-07-11 13:04:00', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-11 06:04:00', '2023-07-11 06:04:00'),
(489, 5, '2023-07-11 13:04:51', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-11 06:04:51', '2023-07-11 06:04:51'),
(490, 4, '2023-07-11 13:40:27', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-11 06:40:27', '2023-07-11 06:40:27'),
(491, 5, '2023-07-11 13:41:42', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-11 06:41:42', '2023-07-11 06:41:42'),
(492, 6, '2023-07-11 16:07:52', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-11 09:07:52', '2023-07-11 09:07:52'),
(493, 13, '2023-07-12 13:51:34', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-12 06:51:34', '2023-07-12 06:51:34'),
(494, 6, '2023-07-12 14:12:38', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-12 07:12:38', '2023-07-12 07:12:38'),
(495, 13, '2023-07-12 14:13:14', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-12 07:13:14', '2023-07-12 07:13:14'),
(496, 5, '2023-07-12 14:14:57', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-12 07:14:57', '2023-07-12 07:14:57'),
(497, 5, '2023-07-12 14:15:27', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-12 07:15:27', '2023-07-12 07:15:27'),
(498, 5, '2023-07-12 14:15:55', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-12 07:15:55', '2023-07-12 07:15:55'),
(499, 6, '2023-07-12 14:18:03', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-12 07:18:03', '2023-07-12 07:18:03'),
(500, 13, '2023-07-12 14:18:33', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-12 07:18:33', '2023-07-12 07:18:33'),
(501, 6, '2023-07-12 14:28:24', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-12 07:28:24', '2023-07-12 07:28:24'),
(502, 13, '2023-07-12 14:29:19', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-12 07:29:19', '2023-07-12 07:29:19'),
(503, 6, '2023-07-12 14:42:45', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-12 07:42:45', '2023-07-12 07:42:45'),
(504, 13, '2023-07-12 14:43:10', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-12 07:43:10', '2023-07-12 07:43:10'),
(505, 9, '2023-07-12 14:49:56', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-12 07:49:56', '2023-07-12 07:49:56'),
(506, 4, '2023-07-12 14:50:13', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-12 07:50:13', '2023-07-12 07:50:13'),
(507, 6, '2023-07-12 14:50:43', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-12 07:50:43', '2023-07-12 07:50:43'),
(508, 9, '2023-07-12 14:52:03', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-12 07:52:03', '2023-07-12 07:52:03'),
(509, 4, '2023-07-12 14:52:27', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-12 07:52:27', '2023-07-12 07:52:27'),
(510, 9, '2023-07-12 14:53:51', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-12 07:53:51', '2023-07-12 07:53:51'),
(511, 6, '2023-07-12 14:55:24', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-12 07:55:25', '2023-07-12 07:55:25'),
(512, 9, '2023-07-12 14:56:39', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-12 07:56:39', '2023-07-12 07:56:39'),
(513, 6, '2023-07-12 15:02:30', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-12 08:02:30', '2023-07-12 08:02:30'),
(514, 9, '2023-07-12 15:03:11', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-12 08:03:11', '2023-07-12 08:03:11'),
(515, 6, '2023-07-12 15:03:51', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-12 08:03:52', '2023-07-12 08:03:52'),
(516, 9, '2023-07-12 15:05:41', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-12 08:05:41', '2023-07-12 08:05:41'),
(517, 6, '2023-07-12 15:06:31', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-12 08:06:31', '2023-07-12 08:06:31'),
(518, 13, '2023-07-12 15:11:13', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-12 08:11:13', '2023-07-12 08:11:13'),
(519, 9, '2023-07-12 15:17:57', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-12 08:17:57', '2023-07-12 08:17:57'),
(520, 9, '2023-07-13 08:16:17', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-13 01:16:17', '2023-07-13 01:16:17'),
(521, 13, '2023-07-13 08:42:48', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-13 01:42:48', '2023-07-13 01:42:48'),
(522, 6, '2023-07-13 08:44:05', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-13 01:44:05', '2023-07-13 01:44:05'),
(523, 13, '2023-07-13 08:44:38', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-13 01:44:38', '2023-07-13 01:44:38'),
(524, 6, '2023-07-13 10:15:10', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-13 03:15:10', '2023-07-13 03:15:10'),
(525, 6, '2023-07-13 11:00:54', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-13 04:00:54', '2023-07-13 04:00:54'),
(526, 6, '2023-07-13 11:49:06', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-13 04:49:06', '2023-07-13 04:49:06'),
(527, 6, '2023-07-13 11:54:07', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-13 04:54:07', '2023-07-13 04:54:07'),
(528, 6, '2023-07-13 12:21:01', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-13 05:21:01', '2023-07-13 05:21:01'),
(529, 6, '2023-07-13 12:28:46', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-13 05:28:46', '2023-07-13 05:28:46'),
(530, 13, '2023-07-13 12:34:41', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-13 05:34:41', '2023-07-13 05:34:41'),
(531, 6, '2023-07-13 12:35:26', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-13 05:35:26', '2023-07-13 05:35:26'),
(532, 13, '2023-07-13 12:38:12', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-13 05:38:12', '2023-07-13 05:38:12'),
(533, 4, '2023-07-13 12:40:45', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-13 05:40:45', '2023-07-13 05:40:45'),
(534, 13, '2023-07-13 12:43:59', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-13 05:43:59', '2023-07-13 05:43:59'),
(535, 5, '2023-07-13 12:45:45', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-13 05:45:45', '2023-07-13 05:45:45'),
(536, 9, '2023-07-13 12:46:04', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-13 05:46:04', '2023-07-13 05:46:04'),
(537, 6, '2023-07-13 12:47:54', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-13 05:47:54', '2023-07-13 05:47:54'),
(538, 9, '2023-07-13 12:51:42', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-13 05:51:42', '2023-07-13 05:51:42'),
(539, 6, '2023-07-13 12:52:05', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-13 05:52:05', '2023-07-13 05:52:05'),
(540, 13, '2023-07-13 12:53:04', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-13 05:53:04', '2023-07-13 05:53:04'),
(541, 9, '2023-07-13 12:57:02', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-13 05:57:03', '2023-07-13 05:57:03'),
(542, 6, '2023-07-13 13:08:12', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-13 06:08:12', '2023-07-13 06:08:12'),
(543, 9, '2023-07-13 13:08:55', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-13 06:08:55', '2023-07-13 06:08:55'),
(544, 6, '2023-07-13 13:11:59', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-13 06:11:59', '2023-07-13 06:11:59'),
(545, 13, '2023-07-13 14:29:11', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-13 07:29:11', '2023-07-13 07:29:11'),
(546, 4, '2023-07-13 14:36:28', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-13 07:36:28', '2023-07-13 07:36:28'),
(547, 13, '2023-07-13 14:37:24', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-13 07:37:24', '2023-07-13 07:37:24'),
(548, 6, '2023-07-13 14:40:48', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-13 07:40:48', '2023-07-13 07:40:48'),
(549, 4, '2023-07-13 14:48:28', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-13 07:48:28', '2023-07-13 07:48:28'),
(550, 6, '2023-07-13 14:49:40', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-13 07:49:40', '2023-07-13 07:49:40'),
(551, 13, '2023-07-13 15:40:27', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-13 08:40:27', '2023-07-13 08:40:27'),
(552, 6, '2023-07-13 15:41:24', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-13 08:41:24', '2023-07-13 08:41:24'),
(553, 13, '2023-07-13 16:10:26', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-13 09:10:26', '2023-07-13 09:10:26'),
(554, 13, '2023-07-17 08:49:43', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-17 01:49:43', '2023-07-17 01:49:43'),
(555, 6, '2023-07-17 08:52:52', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-17 01:52:52', '2023-07-17 01:52:52'),
(556, 13, '2023-07-17 09:18:55', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-17 02:18:55', '2023-07-17 02:18:55'),
(557, 13, '2023-07-17 10:56:13', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-17 03:56:13', '2023-07-17 03:56:13'),
(558, 6, '2023-07-17 10:56:28', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-17 03:56:28', '2023-07-17 03:56:28'),
(559, 9, '2023-07-17 13:09:43', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-17 06:09:43', '2023-07-17 06:09:43'),
(560, 6, '2023-07-17 13:10:48', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-17 06:10:48', '2023-07-17 06:10:48'),
(561, 13, '2023-07-17 13:56:29', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-17 06:56:29', '2023-07-17 06:56:29'),
(562, 9, '2023-07-17 13:56:49', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-17 06:56:49', '2023-07-17 06:56:49'),
(563, 6, '2023-07-17 13:59:04', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-17 06:59:04', '2023-07-17 06:59:04'),
(564, 13, '2023-07-17 14:00:19', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-17 07:00:19', '2023-07-17 07:00:19'),
(565, 6, '2023-07-17 14:04:45', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-17 07:04:45', '2023-07-17 07:04:45'),
(566, 13, '2023-07-17 14:05:23', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-17 07:05:23', '2023-07-17 07:05:23'),
(567, 6, '2023-07-17 14:09:18', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-17 07:09:18', '2023-07-17 07:09:18'),
(568, 9, '2023-07-17 14:14:34', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-17 07:14:34', '2023-07-17 07:14:34'),
(569, 6, '2023-07-17 14:22:29', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-17 07:22:29', '2023-07-17 07:22:29'),
(570, 9, '2023-07-17 14:23:18', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-17 07:23:18', '2023-07-17 07:23:18'),
(571, 6, '2023-07-17 14:25:28', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-17 07:25:28', '2023-07-17 07:25:28'),
(572, 9, '2023-07-17 14:25:58', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-17 07:25:58', '2023-07-17 07:25:58'),
(573, 6, '2023-07-17 14:41:43', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-17 07:41:43', '2023-07-17 07:41:43'),
(574, 13, '2023-07-17 14:45:18', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-17 07:45:18', '2023-07-17 07:45:18'),
(575, 6, '2023-07-18 10:12:42', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-18 03:12:42', '2023-07-18 03:12:42'),
(576, 13, '2023-07-18 10:46:22', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-18 03:46:22', '2023-07-18 03:46:22'),
(577, 6, '2023-07-18 10:48:04', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-18 03:48:04', '2023-07-18 03:48:04'),
(578, 13, '2023-07-18 14:08:18', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-18 07:08:18', '2023-07-18 07:08:18'),
(579, 6, '2023-07-20 14:55:40', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-20 07:55:40', '2023-07-20 07:55:40'),
(580, 6, '2023-07-20 14:58:00', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-20 07:58:00', '2023-07-20 07:58:00'),
(581, 13, '2023-07-20 14:58:06', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-20 07:58:06', '2023-07-20 07:58:06'),
(582, 6, '2023-07-20 14:59:06', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-20 07:59:06', '2023-07-20 07:59:06'),
(583, 9, '2023-07-21 07:49:13', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-21 00:49:13', '2023-07-21 00:49:13'),
(584, 6, '2023-07-21 07:50:03', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-21 00:50:03', '2023-07-21 00:50:03'),
(585, 9, '2023-07-21 07:51:07', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-21 00:51:07', '2023-07-21 00:51:07'),
(586, 6, '2023-07-21 07:56:16', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-21 00:56:16', '2023-07-21 00:56:16'),
(587, 9, '2023-07-21 08:34:09', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-21 01:34:09', '2023-07-21 01:34:09'),
(588, 6, '2023-07-21 08:39:15', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-21 01:39:15', '2023-07-21 01:39:15'),
(589, 13, '2023-07-21 08:40:58', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-21 01:40:58', '2023-07-21 01:40:58'),
(590, 6, '2023-07-21 08:56:07', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-21 01:56:07', '2023-07-21 01:56:07'),
(591, 9, '2023-07-21 08:57:10', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-21 01:57:10', '2023-07-21 01:57:10'),
(592, 13, '2023-07-21 08:58:34', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-21 01:58:34', '2023-07-21 01:58:34'),
(593, 6, '2023-07-21 09:01:33', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-21 02:01:33', '2023-07-21 02:01:33'),
(594, 13, '2023-07-21 09:54:58', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-21 02:54:58', '2023-07-21 02:54:58'),
(595, 6, '2023-07-21 10:52:42', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-21 03:52:43', '2023-07-21 03:52:43'),
(596, 13, '2023-07-21 10:55:21', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-21 03:55:21', '2023-07-21 03:55:21'),
(597, 6, '2023-07-21 11:23:09', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-21 04:23:09', '2023-07-21 04:23:09'),
(598, 6, '2023-07-21 13:03:27', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-21 06:03:27', '2023-07-21 06:03:27'),
(599, 13, '2023-07-21 13:37:04', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-21 06:37:04', '2023-07-21 06:37:04'),
(600, 6, '2023-07-21 13:47:04', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-21 06:47:04', '2023-07-21 06:47:04'),
(601, 13, '2023-07-21 13:52:05', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-21 06:52:05', '2023-07-21 06:52:05'),
(602, 6, '2023-07-21 13:56:56', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-21 06:56:56', '2023-07-21 06:56:56'),
(603, 13, '2023-07-21 13:59:44', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-21 06:59:44', '2023-07-21 06:59:44'),
(604, 13, '2023-07-21 14:06:43', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-21 07:06:43', '2023-07-21 07:06:43'),
(605, 6, '2023-07-21 14:10:05', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-21 07:10:05', '2023-07-21 07:10:05'),
(606, 13, '2023-07-21 14:13:54', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-21 07:13:54', '2023-07-21 07:13:54'),
(607, 6, '2023-07-30 13:48:38', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-30 06:48:38', '2023-07-30 06:48:38'),
(608, 13, '2023-07-30 18:58:59', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-30 11:58:59', '2023-07-30 11:58:59'),
(609, 6, '2023-07-30 19:17:36', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-30 12:17:36', '2023-07-30 12:17:36'),
(610, 9, '2023-07-30 19:39:48', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-30 12:39:48', '2023-07-30 12:39:48'),
(611, 6, '2023-07-30 19:40:22', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-30 12:40:22', '2023-07-30 12:40:22'),
(612, 13, '2023-07-30 19:42:43', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-30 12:42:43', '2023-07-30 12:42:43'),
(613, 6, '2023-07-30 20:31:47', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-30 13:31:47', '2023-07-30 13:31:47'),
(614, 9, '2023-07-30 21:20:33', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-30 14:20:33', '2023-07-30 14:20:33'),
(615, 13, '2023-07-30 21:21:07', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-30 14:21:07', '2023-07-30 14:21:07'),
(616, 13, '2023-07-31 15:35:40', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-31 08:35:40', '2023-07-31 08:35:40'),
(617, 6, '2023-07-31 15:56:44', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-07-31 08:56:44', '2023-07-31 08:56:44'),
(618, 6, '2023-08-01 07:56:50', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-01 00:56:50', '2023-08-01 00:56:50'),
(619, 13, '2023-08-01 07:57:28', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-01 00:57:28', '2023-08-01 00:57:28'),
(620, 9, '2023-08-01 08:01:42', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-01 01:01:42', '2023-08-01 01:01:42'),
(621, 6, '2023-08-01 08:27:42', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-01 01:27:42', '2023-08-01 01:27:42'),
(622, 13, '2023-08-01 08:28:39', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-01 01:28:39', '2023-08-01 01:28:39'),
(623, 6, '2023-08-01 08:30:01', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-01 01:30:01', '2023-08-01 01:30:01'),
(624, 9, '2023-08-01 08:32:01', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-01 01:32:01', '2023-08-01 01:32:01'),
(625, 13, '2023-08-01 08:38:42', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-01 01:38:42', '2023-08-01 01:38:42'),
(626, 6, '2023-08-01 08:39:20', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-01 01:39:20', '2023-08-01 01:39:20'),
(627, 9, '2023-08-01 08:39:42', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-01 01:39:42', '2023-08-01 01:39:42'),
(628, 6, '2023-08-01 10:02:09', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-01 03:02:09', '2023-08-01 03:02:09'),
(629, 6, '2023-08-01 11:24:06', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-01 04:24:06', '2023-08-01 04:24:06'),
(630, 13, '2023-08-01 12:38:40', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-01 05:38:40', '2023-08-01 05:38:40'),
(631, 13, '2023-08-01 12:53:06', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-01 05:53:06', '2023-08-01 05:53:06'),
(632, 13, '2023-08-01 12:54:52', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-01 05:54:52', '2023-08-01 05:54:52'),
(633, 6, '2023-08-01 12:58:15', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-01 05:58:15', '2023-08-01 05:58:15'),
(634, 13, '2023-08-01 13:00:05', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-01 06:00:05', '2023-08-01 06:00:05'),
(635, 13, '2023-08-01 13:07:58', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-01 06:07:58', '2023-08-01 06:07:58'),
(636, 13, '2023-08-01 13:10:19', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-01 06:10:19', '2023-08-01 06:10:19'),
(637, 9, '2023-08-01 13:14:25', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-01 06:14:25', '2023-08-01 06:14:25'),
(638, 4, '2023-08-01 15:33:05', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-01 08:33:05', '2023-08-01 08:33:05'),
(639, 13, '2023-08-01 15:48:46', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-01 08:48:46', '2023-08-01 08:48:46'),
(640, 6, '2023-08-03 11:03:54', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-03 04:03:54', '2023-08-03 04:03:54'),
(641, 6, '2023-08-03 11:11:13', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-03 04:11:13', '2023-08-03 04:11:13'),
(642, 13, '2023-08-03 11:11:26', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-03 04:11:26', '2023-08-03 04:11:26'),
(643, 6, '2023-08-03 11:12:47', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-03 04:12:47', '2023-08-03 04:12:47'),
(644, 6, '2023-08-03 11:31:51', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-03 04:31:51', '2023-08-03 04:31:51'),
(645, 6, '2023-08-08 07:54:11', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-08 00:54:11', '2023-08-08 00:54:11'),
(646, 13, '2023-08-08 07:59:18', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-08 00:59:18', '2023-08-08 00:59:18'),
(647, 6, '2023-08-08 08:01:33', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-08 01:01:33', '2023-08-08 01:01:33'),
(648, 13, '2023-08-08 08:02:01', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-08 01:02:01', '2023-08-08 01:02:01'),
(649, 6, '2023-08-08 08:02:30', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-08 01:02:30', '2023-08-08 01:02:30'),
(650, 13, '2023-08-08 08:08:10', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-08 01:08:10', '2023-08-08 01:08:10'),
(651, 6, '2023-08-08 08:09:19', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-08 01:09:19', '2023-08-08 01:09:19'),
(652, 13, '2023-08-08 08:09:47', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-08 01:09:47', '2023-08-08 01:09:47'),
(653, 6, '2023-08-08 08:22:29', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-08 01:22:29', '2023-08-08 01:22:29'),
(654, 13, '2023-08-08 08:23:18', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-08 01:23:18', '2023-08-08 01:23:18'),
(655, 6, '2023-08-08 08:23:47', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-08 01:23:47', '2023-08-08 01:23:47'),
(656, 13, '2023-08-08 08:26:14', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-08 01:26:14', '2023-08-08 01:26:14'),
(657, 6, '2023-08-08 08:26:39', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-08 01:26:39', '2023-08-08 01:26:39'),
(658, 4, '2023-08-09 15:05:17', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-09 08:05:17', '2023-08-09 08:05:17'),
(659, 6, '2023-08-09 15:06:28', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-09 08:06:28', '2023-08-09 08:06:28'),
(660, 13, '2023-08-09 15:11:19', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-09 08:11:19', '2023-08-09 08:11:19'),
(661, 6, '2023-08-10 09:59:15', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-10 02:59:15', '2023-08-10 02:59:15'),
(662, 13, '2023-08-10 10:08:10', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-10 03:08:10', '2023-08-10 03:08:10'),
(663, 6, '2023-08-10 10:20:43', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-10 03:20:43', '2023-08-10 03:20:43'),
(664, 13, '2023-08-10 10:22:16', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-10 03:22:16', '2023-08-10 03:22:16'),
(665, 13, '2023-08-10 10:37:35', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-10 03:37:35', '2023-08-10 03:37:35'),
(666, 13, '2023-08-10 10:53:14', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-10 03:53:14', '2023-08-10 03:53:14'),
(667, 13, '2023-08-10 10:57:59', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-10 03:57:59', '2023-08-10 03:57:59'),
(668, 13, '2023-08-10 11:17:49', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-10 04:17:49', '2023-08-10 04:17:49'),
(669, 4, '2023-08-10 11:47:28', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-10 04:47:28', '2023-08-10 04:47:28'),
(670, 13, '2023-08-10 11:50:24', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-10 04:50:24', '2023-08-10 04:50:24'),
(671, 13, '2023-08-10 11:58:41', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-10 04:58:41', '2023-08-10 04:58:41'),
(672, 9, '2023-08-10 12:46:11', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-10 05:46:11', '2023-08-10 05:46:11'),
(673, 13, '2023-08-10 12:50:34', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-10 05:50:34', '2023-08-10 05:50:34'),
(674, 9, '2023-08-10 14:46:19', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-10 07:46:19', '2023-08-10 07:46:19'),
(675, 9, '2023-08-10 15:51:21', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-10 08:51:21', '2023-08-10 08:51:21'),
(676, 13, '2023-08-10 15:51:55', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-10 08:51:55', '2023-08-10 08:51:55'),
(677, 6, '2023-08-10 16:00:12', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-10 09:00:12', '2023-08-10 09:00:12'),
(678, 13, '2023-08-14 10:50:23', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-14 03:50:23', '2023-08-14 03:50:23'),
(679, 6, '2023-08-14 10:54:30', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-14 03:54:30', '2023-08-14 03:54:30'),
(680, 13, '2023-08-14 11:54:20', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-14 04:54:20', '2023-08-14 04:54:20'),
(681, 6, '2023-08-14 12:00:08', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-14 05:00:08', '2023-08-14 05:00:08'),
(682, 9, '2023-08-14 12:42:12', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-14 05:42:12', '2023-08-14 05:42:12'),
(683, 6, '2023-08-14 12:56:52', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-14 05:56:52', '2023-08-14 05:56:52'),
(684, 13, '2023-08-14 13:48:57', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-14 06:48:57', '2023-08-14 06:48:57'),
(685, 6, '2023-08-14 14:27:17', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-14 07:27:17', '2023-08-14 07:27:17'),
(686, 11, '2023-08-14 15:43:53', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-14 08:43:53', '2023-08-14 08:43:53'),
(687, 9, '2023-08-14 15:44:10', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-14 08:44:10', '2023-08-14 08:44:10'),
(688, 13, '2023-08-14 15:44:26', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-14 08:44:26', '2023-08-14 08:44:26'),
(689, 13, '2023-08-15 08:17:43', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-15 01:17:43', '2023-08-15 01:17:43'),
(690, 6, '2023-08-15 08:17:56', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-15 01:17:56', '2023-08-15 01:17:56'),
(691, 6, '2023-08-15 08:26:55', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-15 01:26:55', '2023-08-15 01:26:55'),
(692, 13, '2023-08-15 10:28:16', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-15 03:28:16', '2023-08-15 03:28:16'),
(693, 4, '2023-08-15 11:02:09', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-15 04:02:09', '2023-08-15 04:02:09'),
(694, 6, '2023-08-15 11:02:29', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-15 04:02:29', '2023-08-15 04:02:29'),
(695, 13, '2023-08-15 12:00:25', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-15 05:00:25', '2023-08-15 05:00:25'),
(696, 6, '2023-08-15 12:09:03', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-15 05:09:03', '2023-08-15 05:09:03'),
(697, 13, '2023-08-15 13:46:44', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-15 06:46:44', '2023-08-15 06:46:44'),
(698, 13, '2023-08-22 09:50:20', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-22 02:50:20', '2023-08-22 02:50:20'),
(699, 6, '2023-08-22 09:52:44', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-22 02:52:44', '2023-08-22 02:52:44'),
(700, 13, '2023-08-22 10:03:24', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-22 03:03:24', '2023-08-22 03:03:24'),
(701, 6, '2023-08-22 11:14:14', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-22 04:14:14', '2023-08-22 04:14:14'),
(702, 4, '2023-08-22 11:19:54', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-22 04:19:54', '2023-08-22 04:19:54'),
(703, 6, '2023-08-22 11:20:28', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-22 04:20:28', '2023-08-22 04:20:28'),
(704, 4, '2023-08-22 11:20:50', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-22 04:20:50', '2023-08-22 04:20:50'),
(705, 6, '2023-08-22 11:22:02', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-22 04:22:02', '2023-08-22 04:22:02'),
(706, 4, '2023-08-22 12:22:44', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-22 05:22:44', '2023-08-22 05:22:44'),
(707, 6, '2023-08-22 12:23:30', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-22 05:23:30', '2023-08-22 05:23:30'),
(708, 13, '2023-08-22 13:08:29', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-22 06:08:29', '2023-08-22 06:08:29'),
(709, 6, '2023-08-22 13:09:25', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-22 06:09:25', '2023-08-22 06:09:25'),
(710, 13, '2023-08-22 15:37:37', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-22 08:37:37', '2023-08-22 08:37:37'),
(711, 6, '2023-08-22 15:45:09', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-22 08:45:10', '2023-08-22 08:45:10'),
(712, 6, '2023-08-23 10:42:37', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-23 03:42:37', '2023-08-23 03:42:37'),
(713, 13, '2023-08-23 11:22:57', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-23 04:22:57', '2023-08-23 04:22:57'),
(714, 6, '2023-08-23 11:23:15', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-23 04:23:15', '2023-08-23 04:23:15'),
(715, 6, '2023-08-23 12:45:31', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-23 05:45:31', '2023-08-23 05:45:31'),
(716, 6, '2023-08-23 13:59:43', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-23 06:59:43', '2023-08-23 06:59:43'),
(717, 13, '2023-08-23 15:30:06', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-23 08:30:06', '2023-08-23 08:30:06'),
(718, 6, '2023-08-23 16:08:51', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-23 09:08:51', '2023-08-23 09:08:51'),
(719, 4, '2023-08-24 13:57:17', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-24 06:57:17', '2023-08-24 06:57:17'),
(720, 6, '2023-08-24 13:58:16', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-24 06:58:16', '2023-08-24 06:58:16'),
(721, 4, '2023-08-24 14:56:02', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-24 07:56:02', '2023-08-24 07:56:02'),
(722, 6, '2023-08-24 14:57:18', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-24 07:57:18', '2023-08-24 07:57:18'),
(723, 4, '2023-08-24 14:58:14', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-24 07:58:14', '2023-08-24 07:58:14'),
(724, 6, '2023-08-24 14:59:30', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-24 07:59:30', '2023-08-24 07:59:30'),
(725, 4, '2023-08-24 15:00:24', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-24 08:00:24', '2023-08-24 08:00:24'),
(726, 6, '2023-08-24 15:00:56', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-24 08:00:56', '2023-08-24 08:00:56'),
(727, 13, '2023-08-24 15:02:51', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-24 08:02:51', '2023-08-24 08:02:51'),
(728, 4, '2023-08-24 15:03:40', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-24 08:03:40', '2023-08-24 08:03:40'),
(729, 13, '2023-08-24 15:04:10', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-24 08:04:10', '2023-08-24 08:04:10'),
(730, 6, '2023-08-28 14:32:57', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-28 07:32:57', '2023-08-28 07:32:57'),
(731, 13, '2023-08-28 14:33:40', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-28 07:33:40', '2023-08-28 07:33:40'),
(732, 6, '2023-08-28 14:37:46', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-28 07:37:46', '2023-08-28 07:37:46'),
(733, 13, '2023-08-28 14:40:13', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-28 07:40:13', '2023-08-28 07:40:13'),
(734, 6, '2023-08-30 11:11:05', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-30 04:11:05', '2023-08-30 04:11:05'),
(735, 13, '2023-08-30 11:12:05', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-30 04:12:05', '2023-08-30 04:12:05'),
(736, 6, '2023-08-30 11:13:25', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-30 04:13:25', '2023-08-30 04:13:25'),
(737, 13, '2023-08-30 12:51:47', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-30 05:51:47', '2023-08-30 05:51:47'),
(738, 6, '2023-08-30 12:54:07', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-30 05:54:07', '2023-08-30 05:54:07'),
(739, 6, '2023-08-30 14:23:58', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-30 07:23:58', '2023-08-30 07:23:58'),
(740, 13, '2023-08-30 14:24:53', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-30 07:24:53', '2023-08-30 07:24:53'),
(741, 9, '2023-08-30 14:28:46', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-30 07:28:46', '2023-08-30 07:28:46'),
(742, 6, '2023-08-30 14:30:34', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-30 07:30:34', '2023-08-30 07:30:34'),
(743, 6, '2023-08-30 15:00:25', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-30 08:00:25', '2023-08-30 08:00:25'),
(744, 6, '2023-08-30 15:01:08', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-30 08:01:08', '2023-08-30 08:01:08'),
(745, 6, '2023-08-30 15:01:23', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-30 08:01:23', '2023-08-30 08:01:23'),
(746, 9, '2023-08-30 15:09:34', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-30 08:09:34', '2023-08-30 08:09:34'),
(747, 6, '2023-08-30 15:39:39', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-30 08:39:39', '2023-08-30 08:39:39'),
(748, 13, '2023-08-31 10:21:41', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-31 03:21:41', '2023-08-31 03:21:41'),
(749, 9, '2023-08-31 10:40:29', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-31 03:40:29', '2023-08-31 03:40:29'),
(750, 13, '2023-08-31 11:00:07', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-08-31 04:00:07', '2023-08-31 04:00:07'),
(751, 13, '2023-09-01 10:18:38', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-09-01 03:18:38', '2023-09-01 03:18:38'),
(752, 4, '2023-09-01 14:59:05', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-09-01 07:59:05', '2023-09-01 07:59:05'),
(753, 6, '2023-09-01 15:00:17', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-09-01 08:00:17', '2023-09-01 08:00:17'),
(754, 13, '2023-09-04 18:55:52', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-09-04 11:55:52', '2023-09-04 11:55:52'),
(755, 4, '2023-09-04 19:05:09', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-09-04 12:05:09', '2023-09-04 12:05:09'),
(756, 6, '2023-09-04 19:06:08', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-09-04 12:06:08', '2023-09-04 12:06:08'),
(757, 13, '2023-09-05 11:14:37', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-09-05 04:14:37', '2023-09-05 04:14:37'),
(758, 4, '2023-09-05 11:34:55', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-09-05 04:34:55', '2023-09-05 04:34:55'),
(759, 6, '2023-09-05 11:37:20', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-09-05 04:37:20', '2023-09-05 04:37:20'),
(760, 6, '2023-09-06 09:18:56', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-09-06 02:18:56', '2023-09-06 02:18:56'),
(761, 13, '2023-09-06 09:58:07', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-09-06 02:58:07', '2023-09-06 02:58:07'),
(762, 6, '2023-09-06 10:49:29', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-09-06 03:49:29', '2023-09-06 03:49:29'),
(763, 13, '2023-09-06 10:50:46', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-09-06 03:50:46', '2023-09-06 03:50:46'),
(764, 6, '2023-09-06 10:53:30', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-09-06 03:53:30', '2023-09-06 03:53:30'),
(765, 13, '2023-09-06 11:29:49', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-09-06 04:29:49', '2023-09-06 04:29:49'),
(766, 9, '2023-09-06 11:30:07', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-09-06 04:30:07', '2023-09-06 04:30:07'),
(767, 6, '2023-09-06 15:48:30', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-09-06 08:48:30', '2023-09-06 08:48:30'),
(768, 6, '2023-09-07 16:11:15', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-09-07 09:11:15', '2023-09-07 09:11:15'),
(769, 13, '2023-09-08 16:15:27', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-09-08 09:15:27', '2023-09-08 09:15:27'),
(770, 13, '2023-09-14 09:44:48', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-09-14 02:44:48', '2023-09-14 02:44:48'),
(771, 6, '2023-09-14 09:46:22', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-09-14 02:46:22', '2023-09-14 02:46:22'),
(772, 4, '2023-09-14 09:55:13', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-09-14 02:55:13', '2023-09-14 02:55:13'),
(773, 13, '2023-09-14 09:56:12', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-09-14 02:56:12', '2023-09-14 02:56:12'),
(774, 6, '2023-09-14 09:58:17', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-09-14 02:58:17', '2023-09-14 02:58:17'),
(775, 6, '2023-09-14 10:02:08', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-09-14 03:02:08', '2023-09-14 03:02:08'),
(776, 6, '2023-09-14 11:04:06', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-09-14 04:04:06', '2023-09-14 04:04:06'),
(777, 13, '2023-09-19 10:51:17', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-09-19 03:51:17', '2023-09-19 03:51:17'),
(778, 6, '2023-09-19 13:29:13', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-09-19 06:29:13', '2023-09-19 06:29:13'),
(779, 6, '2023-09-21 08:47:38', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-09-21 01:47:38', '2023-09-21 01:47:38'),
(780, 6, '2023-09-21 08:51:31', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-09-21 01:51:31', '2023-09-21 01:51:31'),
(781, 6, '2023-09-21 08:56:59', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-09-21 01:56:59', '2023-09-21 01:56:59'),
(782, 6, '2023-09-21 09:07:17', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-09-21 02:07:17', '2023-09-21 02:07:17'),
(783, 6, '2023-09-21 09:53:24', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-09-21 02:53:24', '2023-09-21 02:53:24'),
(784, 13, '2023-09-21 09:54:11', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-09-21 02:54:11', '2023-09-21 02:54:11'),
(785, 6, '2023-09-21 10:41:55', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-09-21 03:41:55', '2023-09-21 03:41:55'),
(786, 6, '2023-09-21 10:45:16', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-09-21 03:45:16', '2023-09-21 03:45:16'),
(787, 6, '2023-09-21 10:46:13', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-09-21 03:46:13', '2023-09-21 03:46:13'),
(788, 13, '2023-09-21 10:47:03', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-09-21 03:47:03', '2023-09-21 03:47:03'),
(789, 13, '2023-09-21 10:51:43', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-09-21 03:51:43', '2023-09-21 03:51:43'),
(790, 6, '2023-09-21 10:55:06', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-09-21 03:55:06', '2023-09-21 03:55:06'),
(791, 6, '2023-09-21 13:26:14', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-09-21 06:26:14', '2023-09-21 06:26:14'),
(792, 6, '2023-09-21 13:26:33', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-09-21 06:26:33', '2023-09-21 06:26:33'),
(793, 13, '2023-09-26 09:49:57', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-09-26 02:49:57', '2023-09-26 02:49:57'),
(794, 4, '2023-09-26 10:56:30', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-09-26 03:56:30', '2023-09-26 03:56:30'),
(795, 6, '2023-09-26 10:58:33', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-09-26 03:58:33', '2023-09-26 03:58:33'),
(796, 13, '2023-10-02 11:16:02', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-02 04:16:02', '2023-10-02 04:16:02'),
(797, 13, '2023-10-03 09:28:32', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-03 02:28:32', '2023-10-03 02:28:32'),
(798, 6, '2023-10-05 11:42:48', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-05 04:42:48', '2023-10-05 04:42:48'),
(799, 13, '2023-10-12 08:11:42', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-12 01:11:42', '2023-10-12 01:11:42'),
(800, 4, '2023-10-13 10:59:12', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-13 03:59:12', '2023-10-13 03:59:12'),
(801, 6, '2023-10-13 13:56:08', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-13 06:56:08', '2023-10-13 06:56:08'),
(802, 4, '2023-10-16 07:51:57', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-16 00:51:57', '2023-10-16 00:51:57'),
(803, 4, '2023-10-16 08:08:17', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-16 01:08:17', '2023-10-16 01:08:17'),
(804, 4, '2023-10-16 11:02:25', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-16 04:02:25', '2023-10-16 04:02:25'),
(805, 6, '2023-10-16 11:38:07', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-16 04:38:07', '2023-10-16 04:38:07'),
(806, 13, '2023-10-16 15:42:01', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-16 08:42:01', '2023-10-16 08:42:01'),
(807, 13, '2023-10-17 07:36:00', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-17 00:36:00', '2023-10-17 00:36:00'),
(808, 13, '2023-10-19 11:15:18', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-19 04:15:18', '2023-10-19 04:15:18'),
(809, 14, '2023-10-20 08:57:25', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-20 01:57:25', '2023-10-20 01:57:25'),
(810, 4, '2023-10-20 08:58:47', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-20 01:58:47', '2023-10-20 01:58:47'),
(811, 14, '2023-10-20 09:01:39', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-20 02:01:39', '2023-10-20 02:01:39'),
(812, 4, '2023-10-20 09:04:18', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-20 02:04:18', '2023-10-20 02:04:18'),
(813, 14, '2023-10-20 09:04:46', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-20 02:04:46', '2023-10-20 02:04:46'),
(814, 6, '2023-10-20 09:05:08', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-20 02:05:08', '2023-10-20 02:05:08'),
(815, 4, '2023-10-20 09:09:30', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-20 02:09:30', '2023-10-20 02:09:30'),
(816, 15, '2023-10-20 09:11:07', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-20 02:11:07', '2023-10-20 02:11:07'),
(817, 14, '2023-10-20 09:21:37', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-20 02:21:37', '2023-10-20 02:21:37'),
(818, 6, '2023-10-20 09:21:54', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-20 02:21:54', '2023-10-20 02:21:54'),
(819, 4, '2023-10-20 09:22:15', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-20 02:22:15', '2023-10-20 02:22:15'),
(820, 4, '2023-10-20 10:02:49', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-20 03:02:49', '2023-10-20 03:02:49'),
(821, 4, '2023-10-20 10:07:11', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-20 03:07:11', '2023-10-20 03:07:11'),
(822, 14, '2023-10-20 10:44:19', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-20 03:44:19', '2023-10-20 03:44:19'),
(823, 14, '2023-10-20 13:27:59', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-20 06:27:59', '2023-10-20 06:27:59'),
(824, 6, '2023-10-20 13:40:31', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-20 06:40:31', '2023-10-20 06:40:31'),
(825, 4, '2023-10-20 13:41:16', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-20 06:41:16', '2023-10-20 06:41:16'),
(826, 6, '2023-10-20 13:41:40', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-20 06:41:40', '2023-10-20 06:41:40'),
(827, 4, '2023-10-23 13:46:45', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-23 06:46:45', '2023-10-23 06:46:45'),
(828, 4, '2023-10-23 14:19:42', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-23 07:19:42', '2023-10-23 07:19:42'),
(829, 6, '2023-10-23 14:21:00', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-23 07:21:00', '2023-10-23 07:21:00'),
(830, 6, '2023-10-23 14:21:14', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-23 07:21:14', '2023-10-23 07:21:14'),
(831, 13, '2023-10-23 14:39:01', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-23 07:39:01', '2023-10-23 07:39:01'),
(832, 4, '2023-10-23 14:39:17', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-23 07:39:17', '2023-10-23 07:39:17'),
(833, 13, '2023-10-23 14:40:02', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-23 07:40:02', '2023-10-23 07:40:02'),
(834, 13, '2023-10-24 11:12:19', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-24 04:12:19', '2023-10-24 04:12:19'),
(835, 6, '2023-10-25 10:37:06', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-25 03:37:06', '2023-10-25 03:37:06'),
(836, 6, '2023-10-25 10:59:43', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-25 03:59:43', '2023-10-25 03:59:43'),
(837, 4, '2023-10-26 14:04:03', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-26 07:04:03', '2023-10-26 07:04:03'),
(838, 6, '2023-10-26 14:17:25', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-26 07:17:25', '2023-10-26 07:17:25'),
(839, 4, '2023-10-26 14:21:23', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-26 07:21:23', '2023-10-26 07:21:23'),
(840, 6, '2023-10-26 14:21:57', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-26 07:21:57', '2023-10-26 07:21:57'),
(841, 6, '2023-10-27 10:14:10', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-27 03:14:10', '2023-10-27 03:14:10'),
(842, 6, '2023-10-27 10:16:02', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-27 03:16:02', '2023-10-27 03:16:02'),
(843, 13, '2023-10-27 10:24:17', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-27 03:24:17', '2023-10-27 03:24:17'),
(844, 13, '2023-10-27 14:59:24', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-27 07:59:24', '2023-10-27 07:59:24'),
(845, 9, '2023-10-27 15:00:52', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-27 08:00:52', '2023-10-27 08:00:52'),
(846, 4, '2023-10-31 08:09:23', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-31 01:09:23', '2023-10-31 01:09:23'),
(847, 6, '2023-10-31 08:10:00', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-31 01:10:00', '2023-10-31 01:10:00'),
(848, 4, '2023-10-31 09:05:30', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-31 02:05:30', '2023-10-31 02:05:30'),
(849, 6, '2023-10-31 09:06:36', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-10-31 02:06:36', '2023-10-31 02:06:36'),
(850, 13, '2023-11-01 11:54:31', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-11-01 04:54:31', '2023-11-01 04:54:31'),
(851, 14, '2023-11-01 14:33:48', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-11-01 07:33:48', '2023-11-01 07:33:48'),
(852, 4, '2023-11-01 14:34:03', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-11-01 07:34:03', '2023-11-01 07:34:03'),
(853, 4, '2023-11-01 14:35:40', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-11-01 07:35:40', '2023-11-01 07:35:40'),
(854, 4, '2023-11-01 15:32:08', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-11-01 08:32:08', '2023-11-01 08:32:08'),
(855, 6, '2023-11-02 13:48:15', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-11-02 06:48:15', '2023-11-02 06:48:15'),
(856, 13, '2023-11-08 10:33:02', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-11-08 03:33:02', '2023-11-08 03:33:02'),
(857, 4, '2023-11-08 10:36:12', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-11-08 03:36:12', '2023-11-08 03:36:12'),
(858, 14, '2023-11-08 10:45:28', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-11-08 03:45:28', '2023-11-08 03:45:28'),
(859, 4, '2023-11-08 10:45:44', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-11-08 03:45:44', '2023-11-08 03:45:44'),
(860, 6, '2023-11-10 11:18:08', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-11-10 04:18:08', '2023-11-10 04:18:08'),
(861, 14, '2023-11-10 11:18:27', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-11-10 04:18:27', '2023-11-10 04:18:27'),
(862, 14, '2023-11-10 11:21:28', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-11-10 04:21:28', '2023-11-10 04:21:28'),
(863, 6, '2023-11-10 11:24:04', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-11-10 04:24:04', '2023-11-10 04:24:04'),
(864, 9, '2023-12-12 11:23:59', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-12-12 04:23:59', '2023-12-12 04:23:59'),
(865, 4, '2023-12-12 15:01:47', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-12-12 08:01:47', '2023-12-12 08:01:47'),
(866, 6, '2023-12-12 15:05:54', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-12-12 08:05:54', '2023-12-12 08:05:54'),
(867, 13, '2023-12-12 15:06:05', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-12-12 08:06:05', '2023-12-12 08:06:05'),
(868, 4, '2023-12-12 15:06:19', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-12-12 08:06:19', '2023-12-12 08:06:19'),
(869, 4, '2023-12-12 15:08:23', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-12-12 08:08:23', '2023-12-12 08:08:23');
INSERT INTO `logs` (`id`, `user_id`, `last_login_at`, `last_login_ip`, `last_download_file_at`, `last_download_file_id`, `last_delete_file_at`, `last_delete_file_id`, `created_at`, `updated_at`) VALUES
(870, 9, '2023-12-12 15:08:40', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-12-12 08:08:40', '2023-12-12 08:08:40'),
(871, 14, '2023-12-12 15:11:37', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-12-12 08:11:37', '2023-12-12 08:11:37'),
(872, 4, '2023-12-12 15:11:49', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-12-12 08:11:49', '2023-12-12 08:11:49'),
(873, 14, '2023-12-12 15:12:26', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-12-12 08:12:26', '2023-12-12 08:12:26'),
(874, 6, '2023-12-12 15:13:40', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-12-12 08:13:40', '2023-12-12 08:13:40'),
(875, 14, '2023-12-12 15:13:53', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-12-12 08:13:53', '2023-12-12 08:13:53'),
(876, 9, '2023-12-12 15:14:21', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-12-12 08:14:21', '2023-12-12 08:14:21'),
(877, 4, '2023-12-12 15:20:21', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-12-12 08:20:21', '2023-12-12 08:20:21'),
(878, 9, '2023-12-12 15:21:50', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-12-12 08:21:50', '2023-12-12 08:21:50'),
(879, 6, '2023-12-12 15:22:05', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-12-12 08:22:05', '2023-12-12 08:22:05'),
(880, 4, '2023-12-12 15:25:19', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-12-12 08:25:19', '2023-12-12 08:25:19'),
(881, 7, '2023-12-12 15:26:34', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-12-12 08:26:34', '2023-12-12 08:26:34'),
(882, 4, '2023-12-12 15:42:03', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-12-12 08:42:03', '2023-12-12 08:42:03'),
(883, 4, '2023-12-12 15:57:28', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-12-12 08:57:28', '2023-12-12 08:57:28'),
(884, 9, '2023-12-12 16:07:57', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-12-12 09:07:57', '2023-12-12 09:07:57'),
(885, 6, '2023-12-19 10:47:26', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-12-19 03:47:26', '2023-12-19 03:47:26'),
(886, 7, '2023-12-19 10:48:56', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-12-19 03:48:56', '2023-12-19 03:48:56'),
(887, 7, '2023-12-19 11:36:53', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-12-19 04:36:53', '2023-12-19 04:36:53'),
(888, 4, '2023-12-20 09:02:53', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-12-20 02:02:53', '2023-12-20 02:02:53'),
(889, 7, '2023-12-20 09:04:00', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-12-20 02:04:00', '2023-12-20 02:04:00'),
(890, 4, '2023-12-20 09:04:28', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-12-20 02:04:28', '2023-12-20 02:04:28'),
(891, 7, '2023-12-20 09:06:51', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-12-20 02:06:51', '2023-12-20 02:06:51'),
(892, 7, '2023-12-20 09:16:06', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-12-20 02:16:06', '2023-12-20 02:16:06'),
(893, 4, '2023-12-20 10:35:14', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-12-20 03:35:14', '2023-12-20 03:35:14'),
(894, 7, '2023-12-20 10:36:42', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-12-20 03:36:42', '2023-12-20 03:36:42'),
(895, 4, '2023-12-20 10:49:07', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-12-20 03:49:07', '2023-12-20 03:49:07'),
(896, 7, '2023-12-20 10:51:37', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-12-20 03:51:37', '2023-12-20 03:51:37'),
(897, 4, '2023-12-27 15:48:53', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-12-27 08:48:53', '2023-12-27 08:48:53'),
(898, 7, '2023-12-27 15:49:58', '127.0.0.1', NULL, NULL, NULL, NULL, '2023-12-27 08:49:58', '2023-12-27 08:49:58'),
(899, 7, '2024-01-16 12:53:00', '127.0.0.1', NULL, NULL, NULL, NULL, '2024-01-16 05:53:00', '2024-01-16 05:53:00'),
(900, 6, '2024-01-17 10:51:09', '127.0.0.1', NULL, NULL, NULL, NULL, '2024-01-17 03:51:09', '2024-01-17 03:51:09'),
(901, 7, '2024-01-17 10:52:28', '127.0.0.1', NULL, NULL, NULL, NULL, '2024-01-17 03:52:28', '2024-01-17 03:52:28'),
(902, 6, '2024-01-17 10:52:49', '127.0.0.1', NULL, NULL, NULL, NULL, '2024-01-17 03:52:49', '2024-01-17 03:52:49'),
(903, 7, '2024-01-17 13:50:13', '127.0.0.1', NULL, NULL, NULL, NULL, '2024-01-17 06:50:13', '2024-01-17 06:50:13'),
(904, 6, '2024-01-23 11:42:46', '127.0.0.1', NULL, NULL, NULL, NULL, '2024-01-23 04:42:46', '2024-01-23 04:42:46'),
(905, 6, '2024-01-25 12:51:54', '127.0.0.1', NULL, NULL, NULL, NULL, '2024-01-25 05:51:54', '2024-01-25 05:51:54'),
(906, 6, '2024-01-25 13:17:57', '127.0.0.1', NULL, NULL, NULL, NULL, '2024-01-25 06:17:57', '2024-01-25 06:17:57'),
(907, 6, '2024-01-26 10:43:19', '127.0.0.1', NULL, NULL, NULL, NULL, '2024-01-26 03:43:19', '2024-01-26 03:43:19'),
(908, 13, '2024-01-29 14:56:15', '127.0.0.1', NULL, NULL, NULL, NULL, '2024-01-29 07:56:15', '2024-01-29 07:56:15'),
(909, 9, '2024-01-29 15:03:37', '127.0.0.1', NULL, NULL, NULL, NULL, '2024-01-29 08:03:37', '2024-01-29 08:03:37'),
(910, 9, '2024-01-29 15:04:29', '127.0.0.1', NULL, NULL, NULL, NULL, '2024-01-29 08:04:29', '2024-01-29 08:04:29'),
(911, 9, '2024-01-29 15:05:21', '127.0.0.1', NULL, NULL, NULL, NULL, '2024-01-29 08:05:21', '2024-01-29 08:05:21'),
(912, 4, '2024-01-29 15:05:34', '127.0.0.1', NULL, NULL, NULL, NULL, '2024-01-29 08:05:34', '2024-01-29 08:05:34'),
(913, 6, '2024-01-29 15:09:08', '127.0.0.1', NULL, NULL, NULL, NULL, '2024-01-29 08:09:08', '2024-01-29 08:09:08'),
(914, 9, '2024-01-29 15:10:25', '127.0.0.1', NULL, NULL, NULL, NULL, '2024-01-29 08:10:25', '2024-01-29 08:10:25'),
(915, 4, '2024-01-29 15:24:44', '127.0.0.1', NULL, NULL, NULL, NULL, '2024-01-29 08:24:44', '2024-01-29 08:24:44'),
(916, 9, '2024-01-29 15:25:19', '127.0.0.1', NULL, NULL, NULL, NULL, '2024-01-29 08:25:19', '2024-01-29 08:25:19'),
(917, 10, '2024-01-29 15:31:57', '127.0.0.1', NULL, NULL, NULL, NULL, '2024-01-29 08:31:57', '2024-01-29 08:31:57'),
(918, 4, '2024-01-29 15:32:08', '127.0.0.1', NULL, NULL, NULL, NULL, '2024-01-29 08:32:08', '2024-01-29 08:32:08'),
(919, 10, '2024-01-29 15:32:41', '127.0.0.1', NULL, NULL, NULL, NULL, '2024-01-29 08:32:41', '2024-01-29 08:32:41'),
(920, 6, '2024-01-29 15:34:36', '127.0.0.1', NULL, NULL, NULL, NULL, '2024-01-29 08:34:36', '2024-01-29 08:34:36'),
(921, 10, '2024-01-29 15:37:30', '127.0.0.1', NULL, NULL, NULL, NULL, '2024-01-29 08:37:30', '2024-01-29 08:37:30'),
(922, 11, '2024-01-29 15:39:38', '127.0.0.1', NULL, NULL, NULL, NULL, '2024-01-29 08:39:38', '2024-01-29 08:39:38'),
(923, 4, '2024-01-29 15:40:33', '127.0.0.1', NULL, NULL, NULL, NULL, '2024-01-29 08:40:33', '2024-01-29 08:40:33'),
(924, 11, '2024-01-29 15:40:54', '127.0.0.1', NULL, NULL, NULL, NULL, '2024-01-29 08:40:54', '2024-01-29 08:40:54'),
(925, 4, '2024-01-29 15:41:49', '127.0.0.1', NULL, NULL, NULL, NULL, '2024-01-29 08:41:49', '2024-01-29 08:41:49'),
(926, 6, '2024-01-29 15:42:21', '127.0.0.1', NULL, NULL, NULL, NULL, '2024-01-29 08:42:21', '2024-01-29 08:42:21'),
(927, 4, '2024-01-29 16:11:47', '127.0.0.1', NULL, NULL, NULL, NULL, '2024-01-29 09:11:47', '2024-01-29 09:11:47'),
(928, 11, '2024-01-29 16:15:05', '127.0.0.1', NULL, NULL, NULL, NULL, '2024-01-29 09:15:05', '2024-01-29 09:15:05'),
(929, 4, '2024-01-30 07:48:22', '127.0.0.1', NULL, NULL, NULL, NULL, '2024-01-30 00:48:22', '2024-01-30 00:48:22'),
(930, 6, '2024-01-30 08:18:52', '127.0.0.1', NULL, NULL, NULL, NULL, '2024-01-30 01:18:52', '2024-01-30 01:18:52'),
(931, 11, '2024-01-30 09:31:20', '127.0.0.1', NULL, NULL, NULL, NULL, '2024-01-30 02:31:20', '2024-01-30 02:31:20'),
(932, 6, '2024-01-30 09:33:02', '127.0.0.1', NULL, NULL, NULL, NULL, '2024-01-30 02:33:02', '2024-01-30 02:33:02'),
(933, 6, '2024-01-30 09:34:31', '127.0.0.1', NULL, NULL, NULL, NULL, '2024-01-30 02:34:31', '2024-01-30 02:34:31'),
(934, 13, '2024-01-30 10:00:57', '127.0.0.1', NULL, NULL, NULL, NULL, '2024-01-30 03:00:57', '2024-01-30 03:00:57'),
(935, 6, '2024-01-30 13:27:20', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-01-30 06:27:20', '2024-01-30 06:27:20'),
(936, 4, '2024-01-31 15:17:31', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-01-31 08:17:31', '2024-01-31 08:17:31'),
(937, 15, '2024-02-01 10:46:09', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-02-01 03:46:09', '2024-02-01 03:46:09'),
(938, 4, '2024-02-01 10:46:43', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-02-01 03:46:43', '2024-02-01 03:46:43'),
(939, 15, '2024-02-01 10:47:30', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-02-01 03:47:30', '2024-02-01 03:47:30'),
(940, 4, '2024-02-01 10:58:07', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-02-01 03:58:07', '2024-02-01 03:58:07'),
(941, 6, '2024-02-01 11:06:03', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-02-01 04:06:03', '2024-02-01 04:06:03'),
(942, 7, '2024-02-01 11:06:25', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-02-01 04:06:25', '2024-02-01 04:06:25'),
(943, 4, '2024-02-01 11:08:28', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-02-01 04:08:28', '2024-02-01 04:08:28'),
(944, 16, '2024-02-01 11:11:56', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-02-01 04:11:56', '2024-02-01 04:11:56'),
(945, 4, '2024-02-01 11:13:49', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-02-01 04:13:49', '2024-02-01 04:13:49'),
(946, 17, '2024-02-01 11:24:01', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-02-01 04:24:01', '2024-02-01 04:24:01'),
(947, 4, '2024-02-01 11:36:22', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-02-01 04:36:22', '2024-02-01 04:36:22'),
(948, 18, '2024-02-01 11:37:39', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-02-01 04:37:39', '2024-02-01 04:37:39'),
(949, 4, '2024-02-01 11:38:00', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-02-01 04:38:00', '2024-02-01 04:38:00'),
(950, 18, '2024-02-01 11:38:58', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-02-01 04:38:58', '2024-02-01 04:38:58'),
(951, 8, '2024-02-01 11:39:12', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-02-01 04:39:12', '2024-02-01 04:39:12'),
(952, 4, '2024-02-01 11:39:37', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-02-01 04:39:37', '2024-02-01 04:39:37'),
(953, 19, '2024-02-01 11:41:11', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-02-01 04:41:11', '2024-02-01 04:41:11'),
(954, 4, '2024-02-01 13:17:31', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-02-01 06:17:31', '2024-02-01 06:17:31'),
(955, 4, '2024-02-01 14:01:55', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-02-01 07:01:55', '2024-02-01 07:01:55'),
(956, 21, '2024-02-01 14:03:59', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-02-01 07:03:59', '2024-02-01 07:03:59'),
(957, 4, '2024-02-01 14:06:24', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-02-01 07:06:24', '2024-02-01 07:06:24'),
(958, 25, '2024-02-01 14:33:59', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-02-01 07:33:59', '2024-02-01 07:33:59'),
(959, 4, '2024-02-01 14:34:09', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-02-01 07:34:09', '2024-02-01 07:34:09'),
(960, 25, '2024-02-01 14:34:39', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-02-01 07:34:39', '2024-02-01 07:34:39'),
(961, 4, '2024-02-01 14:36:43', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-02-01 07:36:43', '2024-02-01 07:36:43'),
(962, 6, '2024-02-01 15:15:24', '10.14.189.224', NULL, NULL, NULL, NULL, '2024-02-01 08:15:24', '2024-02-01 08:15:24'),
(963, 13, '2024-02-01 15:38:32', '10.14.189.224', NULL, NULL, NULL, NULL, '2024-02-01 08:38:32', '2024-02-01 08:38:32'),
(964, 6, '2024-02-01 15:41:37', '10.14.189.224', NULL, NULL, NULL, NULL, '2024-02-01 08:41:37', '2024-02-01 08:41:37'),
(965, 13, '2024-02-01 15:55:49', '10.14.189.224', NULL, NULL, NULL, NULL, '2024-02-01 08:55:49', '2024-02-01 08:55:49'),
(966, 13, '2024-02-05 15:39:16', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-02-05 08:39:16', '2024-02-05 08:39:16'),
(967, 4, '2024-02-07 13:59:43', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-02-07 06:59:43', '2024-02-07 06:59:43'),
(968, 6, '2024-02-07 14:03:36', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-02-07 07:03:36', '2024-02-07 07:03:36'),
(969, 6, '2024-02-26 17:03:22', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-02-26 10:03:22', '2024-02-26 10:03:22'),
(970, 4, '2024-02-26 17:04:23', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-02-26 10:04:23', '2024-02-26 10:04:23'),
(971, 6, '2024-02-26 17:05:43', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-02-26 10:05:43', '2024-02-26 10:05:43'),
(972, 13, '2024-02-26 17:06:41', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-02-26 10:06:41', '2024-02-26 10:06:41'),
(973, 4, '2024-02-27 07:59:09', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-02-27 00:59:09', '2024-02-27 00:59:09'),
(974, 4, '2024-02-27 08:02:14', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-02-27 01:02:14', '2024-02-27 01:02:14'),
(975, 15, '2024-02-27 08:06:00', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-02-27 01:06:00', '2024-02-27 01:06:00'),
(976, 6, '2024-02-27 08:06:26', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-02-27 01:06:26', '2024-02-27 01:06:26'),
(977, 13, '2024-02-27 08:08:48', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-02-27 01:08:48', '2024-02-27 01:08:48'),
(978, 15, '2024-02-27 08:09:50', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-02-27 01:09:50', '2024-02-27 01:09:50'),
(979, 6, '2024-02-27 09:36:09', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-02-27 02:36:09', '2024-02-27 02:36:09'),
(980, 5, '2024-02-27 09:38:49', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-02-27 02:38:49', '2024-02-27 02:38:49'),
(981, 7, '2024-02-27 09:40:53', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-02-27 02:40:53', '2024-02-27 02:40:53'),
(982, 25, '2024-02-27 09:41:29', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-02-27 02:41:29', '2024-02-27 02:41:29'),
(983, 9, '2024-02-27 09:45:23', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-02-27 02:45:23', '2024-02-27 02:45:23'),
(984, 19, '2024-02-27 09:47:02', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-02-27 02:47:02', '2024-02-27 02:47:02'),
(985, 22, '2024-02-27 09:47:58', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-02-27 02:47:58', '2024-02-27 02:47:58'),
(986, 24, '2024-02-27 09:49:01', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-02-27 02:49:01', '2024-02-27 02:49:01'),
(987, 16, '2024-02-27 09:58:52', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-02-27 02:58:52', '2024-02-27 02:58:52'),
(988, 20, '2024-02-27 10:07:36', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-02-27 03:07:36', '2024-02-27 03:07:36'),
(989, 6, '2024-02-27 10:08:51', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-02-27 03:08:51', '2024-02-27 03:08:51'),
(990, 15, '2024-02-27 10:14:04', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-02-27 03:14:04', '2024-02-27 03:14:04'),
(991, 5, '2024-02-27 10:27:44', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-02-27 03:27:44', '2024-02-27 03:27:44'),
(992, 4, '2024-02-27 10:27:54', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-02-27 03:27:54', '2024-02-27 03:27:54'),
(993, 5, '2024-02-27 10:28:28', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-02-27 03:28:28', '2024-02-27 03:28:28'),
(994, 15, '2024-02-27 10:41:04', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-02-27 03:41:04', '2024-02-27 03:41:04'),
(995, 25, '2024-02-27 11:16:16', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-02-27 04:16:16', '2024-02-27 04:16:16'),
(996, 6, '2024-02-27 11:33:53', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-02-27 04:33:53', '2024-02-27 04:33:53'),
(997, 6, '2024-02-27 11:58:56', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-02-27 04:58:56', '2024-02-27 04:58:56'),
(998, 6, '2024-02-27 13:00:13', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-02-27 06:00:13', '2024-02-27 06:00:13'),
(999, 6, '2024-02-27 13:45:11', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-02-27 06:45:11', '2024-02-27 06:45:11'),
(1000, 15, '2024-02-27 13:59:33', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-02-27 06:59:33', '2024-02-27 06:59:33'),
(1001, 6, '2024-02-27 15:58:45', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-02-27 08:58:45', '2024-02-27 08:58:45'),
(1002, 6, '2024-04-05 11:40:58', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-04-05 04:40:58', '2024-04-05 04:40:58'),
(1003, 6, '2024-04-22 07:53:48', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-04-22 00:53:48', '2024-04-22 00:53:48'),
(1004, 16, '2024-04-22 07:59:08', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-04-22 00:59:08', '2024-04-22 00:59:08'),
(1005, 6, '2024-04-22 08:03:08', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-04-22 01:03:08', '2024-04-22 01:03:08'),
(1006, 4, '2024-04-23 14:11:15', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-04-23 07:11:15', '2024-04-23 07:11:15'),
(1007, 6, '2024-04-23 14:26:56', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-04-23 07:26:56', '2024-04-23 07:26:56'),
(1008, 15, '2024-04-23 14:28:36', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-04-23 07:28:36', '2024-04-23 07:28:36'),
(1009, 4, '2024-04-23 14:32:57', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-04-23 07:32:57', '2024-04-23 07:32:57'),
(1010, 15, '2024-04-23 14:37:44', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-04-23 07:37:44', '2024-04-23 07:37:44'),
(1011, 4, '2024-04-23 14:38:15', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-04-23 07:38:15', '2024-04-23 07:38:15'),
(1012, 15, '2024-04-23 14:41:17', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-04-23 07:41:17', '2024-04-23 07:41:17'),
(1013, 6, '2024-04-23 14:47:45', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-04-23 07:47:45', '2024-04-23 07:47:45'),
(1014, 14, '2024-04-23 14:48:10', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-04-23 07:48:10', '2024-04-23 07:48:10'),
(1015, 13, '2024-04-23 14:48:23', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-04-23 07:48:23', '2024-04-23 07:48:23'),
(1016, 15, '2024-04-24 08:46:44', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-04-24 01:46:44', '2024-04-24 01:46:44'),
(1017, 13, '2024-04-25 10:17:56', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-04-25 03:17:56', '2024-04-25 03:17:56'),
(1018, 15, '2024-04-25 10:58:18', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-04-25 03:58:18', '2024-04-25 03:58:18'),
(1019, 6, '2024-04-25 11:02:31', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-04-25 04:02:31', '2024-04-25 04:02:31'),
(1020, 4, '2024-04-25 13:36:58', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-04-25 06:36:58', '2024-04-25 06:36:58'),
(1021, 31, '2024-04-25 13:44:37', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-04-25 06:44:37', '2024-04-25 06:44:37'),
(1022, 4, '2024-04-25 13:44:47', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-04-25 06:44:47', '2024-04-25 06:44:47'),
(1023, 31, '2024-04-25 13:45:07', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-04-25 06:45:07', '2024-04-25 06:45:07'),
(1024, 4, '2024-04-25 13:51:38', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-04-25 06:51:38', '2024-04-25 06:51:38'),
(1025, 15, '2024-04-25 13:52:28', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-04-25 06:52:28', '2024-04-25 06:52:28'),
(1026, 4, '2024-04-25 13:53:11', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-04-25 06:53:11', '2024-04-25 06:53:11'),
(1027, 15, '2024-04-25 13:54:19', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-04-25 06:54:19', '2024-04-25 06:54:19'),
(1028, 14, '2024-04-25 13:57:42', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-04-25 06:57:42', '2024-04-25 06:57:42'),
(1029, 31, '2024-04-25 13:58:34', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-04-25 06:58:34', '2024-04-25 06:58:34'),
(1030, 15, '2024-04-25 15:13:04', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-04-25 08:13:04', '2024-04-25 08:13:04'),
(1031, 14, '2024-04-25 15:13:45', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-04-25 08:13:45', '2024-04-25 08:13:45'),
(1032, 31, '2024-04-25 15:15:06', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-04-25 08:15:06', '2024-04-25 08:15:06'),
(1033, 14, '2024-04-25 15:56:32', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-04-25 08:56:32', '2024-04-25 08:56:32'),
(1034, 31, '2024-04-25 16:03:07', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-04-25 09:03:07', '2024-04-25 09:03:07'),
(1035, 14, '2024-04-26 10:38:11', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-04-26 03:38:11', '2024-04-26 03:38:11'),
(1036, 15, '2024-04-26 10:42:18', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-04-26 03:42:18', '2024-04-26 03:42:18'),
(1037, 31, '2024-04-30 14:18:06', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-04-30 07:18:06', '2024-04-30 07:18:06'),
(1038, 15, '2024-04-30 14:18:32', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-04-30 07:18:32', '2024-04-30 07:18:32'),
(1039, 31, '2024-04-30 14:29:12', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-04-30 07:29:12', '2024-04-30 07:29:12'),
(1040, 14, '2024-04-30 14:29:59', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-04-30 07:29:59', '2024-04-30 07:29:59'),
(1041, 31, '2024-05-03 15:08:21', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-05-03 08:08:21', '2024-05-03 08:08:21'),
(1042, 4, '2024-05-07 09:54:35', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-05-07 02:54:35', '2024-05-07 02:54:35'),
(1043, 31, '2024-05-08 07:38:11', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-05-08 00:38:11', '2024-05-08 00:38:11'),
(1044, 15, '2024-05-08 07:40:21', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-05-08 00:40:21', '2024-05-08 00:40:21'),
(1045, 4, '2024-05-08 07:43:51', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-05-08 00:43:51', '2024-05-08 00:43:51'),
(1046, 6, '2024-05-08 07:44:13', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-05-08 00:44:13', '2024-05-08 00:44:13'),
(1047, 4, '2024-05-08 07:44:30', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-05-08 00:44:30', '2024-05-08 00:44:30'),
(1048, 15, '2024-05-08 07:46:54', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-05-08 00:46:54', '2024-05-08 00:46:54'),
(1049, 14, '2024-05-08 07:51:34', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-05-08 00:51:34', '2024-05-08 00:51:34'),
(1050, 31, '2024-05-08 07:52:29', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-05-08 00:52:29', '2024-05-08 00:52:29'),
(1051, 14, '2024-05-08 07:54:29', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-05-08 00:54:29', '2024-05-08 00:54:29'),
(1052, 31, '2024-05-08 07:55:30', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-05-08 00:55:30', '2024-05-08 00:55:30'),
(1053, 15, '2024-05-10 13:19:23', '10.14.207.114', NULL, NULL, NULL, NULL, '2024-05-10 06:19:23', '2024-05-10 06:19:23'),
(1054, 14, '2024-05-10 13:21:58', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-05-10 06:21:58', '2024-05-10 06:21:58'),
(1055, 31, '2024-05-10 13:24:36', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-05-10 06:24:36', '2024-05-10 06:24:36'),
(1056, 14, '2024-05-10 13:26:02', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-05-10 06:26:02', '2024-05-10 06:26:02'),
(1057, 31, '2024-05-10 13:26:47', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-05-10 06:26:47', '2024-05-10 06:26:47'),
(1058, 15, '2024-05-10 13:27:30', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-05-10 06:27:30', '2024-05-10 06:27:30'),
(1059, 31, '2024-05-10 13:27:50', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-05-10 06:27:50', '2024-05-10 06:27:50'),
(1060, 15, '2024-05-10 13:29:10', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-05-10 06:29:10', '2024-05-10 06:29:10'),
(1061, 4, '2024-05-10 13:37:35', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-05-10 06:37:35', '2024-05-10 06:37:35'),
(1062, 14, '2024-05-10 13:38:09', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-05-10 06:38:09', '2024-05-10 06:38:09'),
(1063, 15, '2024-05-10 13:38:51', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-05-10 06:38:51', '2024-05-10 06:38:51'),
(1064, 15, '2024-05-10 13:41:23', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-05-10 06:41:23', '2024-05-10 06:41:23'),
(1065, 15, '2024-05-10 13:41:43', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-05-10 06:41:43', '2024-05-10 06:41:43'),
(1066, 15, '2024-05-20 15:50:55', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-05-20 08:50:55', '2024-05-20 08:50:55'),
(1067, 4, '2024-05-21 09:54:11', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-05-21 02:54:11', '2024-05-21 02:54:11'),
(1068, 30, '2024-05-21 09:55:26', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-05-21 02:55:26', '2024-05-21 02:55:26'),
(1069, 4, '2024-05-21 09:55:49', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-05-21 02:55:49', '2024-05-21 02:55:49'),
(1070, 4, '2024-05-21 10:01:07', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-05-21 03:01:07', '2024-05-21 03:01:07'),
(1071, 31, '2024-05-27 12:54:30', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-05-27 05:54:30', '2024-05-27 05:54:30'),
(1072, 4, '2024-05-28 08:01:37', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-05-28 01:01:37', '2024-05-28 01:01:37'),
(1073, 15, '2024-05-28 08:06:49', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-05-28 01:06:49', '2024-05-28 01:06:49'),
(1074, 14, '2024-05-28 08:13:18', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-05-28 01:13:18', '2024-05-28 01:13:18'),
(1075, 31, '2024-05-28 08:14:27', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-05-28 01:14:27', '2024-05-28 01:14:27'),
(1076, 14, '2024-05-28 08:15:54', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-05-28 01:15:54', '2024-05-28 01:15:54'),
(1077, 31, '2024-05-28 08:16:40', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-05-28 01:16:40', '2024-05-28 01:16:40'),
(1078, 15, '2024-05-28 08:17:45', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-05-28 01:17:45', '2024-05-28 01:17:45'),
(1079, 4, '2024-05-28 13:29:32', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-05-28 06:29:32', '2024-05-28 06:29:32'),
(1080, 4, '2024-05-31 13:56:05', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-05-31 06:56:05', '2024-05-31 06:56:05'),
(1081, 15, '2024-06-03 12:48:54', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-06-03 05:48:54', '2024-06-03 05:48:54'),
(1082, 4, '2024-06-03 12:51:21', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-06-03 05:51:21', '2024-06-03 05:51:21'),
(1083, 4, '2024-06-03 12:52:24', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-06-03 05:52:24', '2024-06-03 05:52:24'),
(1084, 30, '2024-06-03 12:53:52', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-06-03 05:53:52', '2024-06-03 05:53:52'),
(1085, 4, '2024-06-03 12:54:00', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-06-03 05:54:00', '2024-06-03 05:54:00'),
(1086, 30, '2024-06-03 12:54:28', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-06-03 05:54:28', '2024-06-03 05:54:28'),
(1087, 4, '2024-06-03 13:32:30', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-06-03 06:32:30', '2024-06-03 06:32:30'),
(1088, 30, '2024-06-03 13:34:50', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-06-03 06:34:50', '2024-06-03 06:34:50'),
(1089, 32, '2024-06-03 13:38:37', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-06-03 06:38:37', '2024-06-03 06:38:37'),
(1090, 4, '2024-06-03 13:38:47', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-06-03 06:38:47', '2024-06-03 06:38:47'),
(1091, 32, '2024-06-03 13:39:16', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-06-03 06:39:16', '2024-06-03 06:39:16'),
(1092, 30, '2024-06-03 13:49:08', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-06-03 06:49:08', '2024-06-03 06:49:08'),
(1093, 32, '2024-06-03 13:51:14', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-06-03 06:51:14', '2024-06-03 06:51:14'),
(1094, 30, '2024-06-10 11:41:29', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-06-10 04:41:29', '2024-06-10 04:41:29'),
(1095, 15, '2024-06-10 11:49:38', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-06-10 04:49:38', '2024-06-10 04:49:38'),
(1096, 15, '2024-06-10 12:34:26', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-06-10 05:34:26', '2024-06-10 05:34:26'),
(1097, 14, '2024-06-10 12:41:42', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-06-10 05:41:42', '2024-06-10 05:41:42'),
(1098, 31, '2024-06-10 12:43:12', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-06-10 05:43:12', '2024-06-10 05:43:12'),
(1099, 14, '2024-06-10 12:45:50', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-06-10 05:45:50', '2024-06-10 05:45:50'),
(1100, 4, '2024-06-10 12:46:16', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-06-10 05:46:16', '2024-06-10 05:46:16'),
(1101, 31, '2024-06-10 12:46:32', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-06-10 05:46:32', '2024-06-10 05:46:32'),
(1102, 15, '2024-06-11 07:55:28', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-06-11 00:55:28', '2024-06-11 00:55:28'),
(1103, 4, '2024-06-11 08:19:14', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-06-11 01:19:14', '2024-06-11 01:19:14'),
(1104, 33, '2024-06-11 08:20:29', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-06-11 01:20:29', '2024-06-11 01:20:29'),
(1105, 15, '2024-06-11 08:21:25', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-06-11 01:21:25', '2024-06-11 01:21:25'),
(1106, 4, '2024-06-11 08:21:40', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-06-11 01:21:40', '2024-06-11 01:21:40'),
(1107, 15, '2024-06-11 08:22:08', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-06-11 01:22:08', '2024-06-11 01:22:08'),
(1108, 33, '2024-06-11 10:20:17', '10.14.232.38', NULL, NULL, NULL, NULL, '2024-06-11 03:20:17', '2024-06-11 03:20:17'),
(1109, 14, '2024-06-11 10:22:27', '10.14.232.38', NULL, NULL, NULL, NULL, '2024-06-11 03:22:27', '2024-06-11 03:22:27'),
(1110, 31, '2024-06-11 10:33:05', '10.14.232.38', NULL, NULL, NULL, NULL, '2024-06-11 03:33:05', '2024-06-11 03:33:05'),
(1111, 14, '2024-06-11 10:34:20', '10.14.232.38', NULL, NULL, NULL, NULL, '2024-06-11 03:34:20', '2024-06-11 03:34:20'),
(1112, 4, '2024-06-11 10:34:59', '10.14.232.38', NULL, NULL, NULL, NULL, '2024-06-11 03:34:59', '2024-06-11 03:34:59'),
(1113, 4, '2024-06-11 10:35:58', '10.14.232.38', NULL, NULL, NULL, NULL, '2024-06-11 03:35:58', '2024-06-11 03:35:58'),
(1114, 4, '2024-06-11 11:44:34', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-06-11 04:44:34', '2024-06-11 04:44:34'),
(1115, 28, '2024-06-11 11:46:45', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-06-11 04:46:45', '2024-06-11 04:46:45'),
(1116, 32, '2024-06-11 11:47:22', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-06-11 04:47:22', '2024-06-11 04:47:22'),
(1117, 28, '2024-06-11 11:47:39', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-06-11 04:47:39', '2024-06-11 04:47:39'),
(1118, 32, '2024-06-11 11:55:34', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-06-11 04:55:34', '2024-06-11 04:55:34'),
(1119, 32, '2024-06-11 12:05:28', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-06-11 05:05:28', '2024-06-11 05:05:28'),
(1120, 30, '2024-06-11 12:39:48', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-06-11 05:39:48', '2024-06-11 05:39:48'),
(1121, 33, '2024-06-11 12:46:55', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-06-11 05:46:55', '2024-06-11 05:46:55'),
(1122, 30, '2024-06-11 12:47:52', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-06-11 05:47:52', '2024-06-11 05:47:52'),
(1123, 32, '2024-06-11 12:48:51', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-06-11 05:48:51', '2024-06-11 05:48:51'),
(1124, 31, '2024-06-11 12:49:57', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-06-11 05:49:57', '2024-06-11 05:49:57'),
(1125, 14, '2024-06-11 12:50:31', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-06-11 05:50:31', '2024-06-11 05:50:31'),
(1126, 31, '2024-06-11 12:51:09', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-06-11 05:51:09', '2024-06-11 05:51:09'),
(1127, 33, '2024-06-11 12:52:03', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-06-11 05:52:03', '2024-06-11 05:52:03'),
(1128, 30, '2024-06-11 12:52:25', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-06-11 05:52:25', '2024-06-11 05:52:25'),
(1129, 33, '2024-06-11 12:59:31', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-06-11 05:59:31', '2024-06-11 05:59:31'),
(1130, 31, '2024-06-11 13:00:00', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-06-11 06:00:00', '2024-06-11 06:00:00'),
(1131, 15, '2024-06-11 13:00:12', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-06-11 06:00:12', '2024-06-11 06:00:12'),
(1132, 33, '2024-06-11 13:01:44', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-06-11 06:01:44', '2024-06-11 06:01:44'),
(1133, 4, '2024-06-11 13:02:47', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-06-11 06:02:47', '2024-06-11 06:02:47'),
(1134, 33, '2024-06-11 13:02:58', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-06-11 06:02:58', '2024-06-11 06:02:58'),
(1135, 4, '2024-06-11 13:06:44', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-06-11 06:06:44', '2024-06-11 06:06:44'),
(1136, 15, '2024-06-11 13:07:11', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-06-11 06:07:11', '2024-06-11 06:07:11'),
(1137, 14, '2024-06-11 13:45:29', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-06-11 06:45:29', '2024-06-11 06:45:29'),
(1138, 15, '2024-06-11 13:48:25', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-06-11 06:48:25', '2024-06-11 06:48:25'),
(1139, 14, '2024-06-11 14:14:30', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-06-11 07:14:30', '2024-06-11 07:14:30'),
(1140, 31, '2024-06-11 14:17:34', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-06-11 07:17:34', '2024-06-11 07:17:34'),
(1141, 14, '2024-06-11 14:18:52', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-06-11 07:18:52', '2024-06-11 07:18:52'),
(1142, 31, '2024-06-11 14:21:43', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-06-11 07:21:43', '2024-06-11 07:21:43'),
(1143, 4, '2024-06-25 10:28:46', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-06-25 03:28:47', '2024-06-25 03:28:47'),
(1144, 31, '2024-06-25 11:45:45', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-06-25 04:45:45', '2024-06-25 04:45:45'),
(1145, 4, '2024-06-25 11:45:56', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-06-25 04:45:56', '2024-06-25 04:45:56'),
(1146, 31, '2024-06-25 11:48:04', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-06-25 04:48:04', '2024-06-25 04:48:04'),
(1147, 15, '2024-06-25 11:49:19', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-06-25 04:49:19', '2024-06-25 04:49:19'),
(1148, 15, '2024-06-25 13:56:38', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-06-25 06:56:38', '2024-06-25 06:56:38'),
(1149, 6, '2024-06-26 08:14:48', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-06-26 01:14:48', '2024-06-26 01:14:48'),
(1150, 15, '2024-06-26 08:24:42', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-06-26 01:24:42', '2024-06-26 01:24:42'),
(1151, 31, '2024-06-26 08:26:14', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-06-26 01:26:14', '2024-06-26 01:26:14'),
(1152, 15, '2024-06-26 08:26:39', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-06-26 01:26:39', '2024-06-26 01:26:39'),
(1153, 14, '2024-06-26 08:27:15', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-06-26 01:27:15', '2024-06-26 01:27:15'),
(1154, 31, '2024-06-26 08:27:41', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-06-26 01:27:41', '2024-06-26 01:27:41'),
(1155, 14, '2024-06-26 08:28:48', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-06-26 01:28:48', '2024-06-26 01:28:48'),
(1156, 31, '2024-06-26 08:29:33', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-06-26 01:29:33', '2024-06-26 01:29:33'),
(1157, 15, '2024-06-26 08:29:48', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-06-26 01:29:48', '2024-06-26 01:29:48'),
(1158, 4, '2024-06-26 08:31:23', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-06-26 01:31:23', '2024-06-26 01:31:23'),
(1159, 15, '2024-06-26 08:32:19', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-06-26 01:32:19', '2024-06-26 01:32:19'),
(1160, 5, '2024-06-26 08:35:56', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-06-26 01:35:56', '2024-06-26 01:35:56'),
(1161, 15, '2024-06-27 13:05:46', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-06-27 06:05:46', '2024-06-27 06:05:46'),
(1162, 5, '2024-06-27 13:06:11', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-06-27 06:06:11', '2024-06-27 06:06:11'),
(1163, 5, '2024-06-27 13:10:49', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-06-27 06:10:49', '2024-06-27 06:10:49'),
(1164, 6, '2024-06-28 11:10:03', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-06-28 04:10:03', '2024-06-28 04:10:03'),
(1165, 15, '2024-06-28 11:11:33', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-06-28 04:11:33', '2024-06-28 04:11:33'),
(1166, 6, '2024-06-28 14:49:38', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-06-28 07:49:38', '2024-06-28 07:49:38'),
(1167, 4, '2024-07-02 13:58:55', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-07-02 06:58:55', '2024-07-02 06:58:55'),
(1168, 15, '2024-07-02 14:04:07', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-07-02 07:04:07', '2024-07-02 07:04:07'),
(1169, 15, '2024-07-02 15:54:22', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-07-02 08:54:22', '2024-07-02 08:54:22'),
(1170, 4, '2024-07-03 08:19:39', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-07-03 01:19:39', '2024-07-03 01:19:39'),
(1171, 15, '2024-07-08 13:17:14', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-07-08 06:17:14', '2024-07-08 06:17:14'),
(1172, 31, '2024-07-08 13:18:45', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-07-08 06:18:45', '2024-07-08 06:18:45'),
(1173, 15, '2024-07-08 13:19:37', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-07-08 06:19:37', '2024-07-08 06:19:37'),
(1174, 31, '2024-07-08 13:19:57', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-07-08 06:19:57', '2024-07-08 06:19:57'),
(1175, 15, '2024-07-08 13:20:39', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-07-08 06:20:39', '2024-07-08 06:20:39'),
(1176, 15, '2024-07-08 13:23:13', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-07-08 06:23:13', '2024-07-08 06:23:13'),
(1177, 33, '2024-07-09 08:26:57', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-07-09 01:26:57', '2024-07-09 01:26:57'),
(1178, 15, '2024-07-09 10:35:57', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-07-09 03:35:57', '2024-07-09 03:35:57'),
(1179, 4, '2024-07-09 10:38:55', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-07-09 03:38:55', '2024-07-09 03:38:55'),
(1180, 23, '2024-07-09 10:39:20', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-07-09 03:39:20', '2024-07-09 03:39:20'),
(1181, 15, '2024-07-09 11:01:21', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-07-09 04:01:21', '2024-07-09 04:01:21'),
(1182, 4, '2024-07-09 11:52:42', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-07-09 04:52:42', '2024-07-09 04:52:42'),
(1183, 15, '2024-07-17 12:17:13', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-07-17 05:17:13', '2024-07-17 05:17:13'),
(1184, 15, '2024-07-17 13:00:00', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-07-17 06:00:00', '2024-07-17 06:00:00'),
(1185, 6, '2024-07-17 13:00:09', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-07-17 06:00:09', '2024-07-17 06:00:09'),
(1186, 15, '2024-07-17 13:04:27', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-07-17 06:04:27', '2024-07-17 06:04:27'),
(1187, 15, '2024-07-17 13:56:28', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-07-17 06:56:28', '2024-07-17 06:56:28'),
(1188, 4, '2024-07-17 13:58:05', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-07-17 06:58:05', '2024-07-17 06:58:05'),
(1189, 15, '2024-07-17 14:01:34', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-07-17 07:01:34', '2024-07-17 07:01:34'),
(1190, 23, '2024-07-17 14:05:42', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-07-17 07:05:42', '2024-07-17 07:05:42'),
(1191, 35, '2024-07-17 14:06:15', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-07-17 07:06:15', '2024-07-17 07:06:15'),
(1192, 23, '2024-07-17 14:09:30', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-07-17 07:09:30', '2024-07-17 07:09:30'),
(1193, 35, '2024-07-17 14:10:50', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-07-17 07:10:50', '2024-07-17 07:10:50'),
(1194, 36, '2024-07-17 14:12:59', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-07-17 07:12:59', '2024-07-17 07:12:59'),
(1195, 4, '2024-07-17 14:13:08', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-07-17 07:13:08', '2024-07-17 07:13:08'),
(1196, 36, '2024-07-17 14:13:33', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-07-17 07:13:33', '2024-07-17 07:13:33'),
(1197, 15, '2024-07-17 14:15:54', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-07-17 07:15:54', '2024-07-17 07:15:54'),
(1198, 23, '2024-07-17 16:01:15', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-07-17 09:01:15', '2024-07-17 09:01:15'),
(1199, 35, '2024-07-17 16:05:13', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-07-17 09:05:13', '2024-07-17 09:05:13'),
(1200, 31, '2024-07-17 16:13:52', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-07-17 09:13:52', '2024-07-17 09:13:52'),
(1201, 36, '2024-07-17 16:16:23', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-07-17 09:16:23', '2024-07-17 09:16:23'),
(1202, 15, '2024-07-17 16:18:19', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-07-17 09:18:19', '2024-07-17 09:18:19'),
(1203, 15, '2024-07-23 11:09:31', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-07-23 04:09:31', '2024-07-23 04:09:31'),
(1204, 15, '2024-07-25 10:17:39', '10.14.207.114', NULL, NULL, NULL, NULL, '2024-07-25 03:17:39', '2024-07-25 03:17:39'),
(1205, 34, '2024-07-25 13:59:57', '10.14.207.114', NULL, NULL, NULL, NULL, '2024-07-25 06:59:57', '2024-07-25 06:59:57'),
(1206, 15, '2024-07-29 12:54:46', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-07-29 05:54:46', '2024-07-29 05:54:46'),
(1207, 15, '2024-08-05 07:46:09', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-05 00:46:09', '2024-08-05 00:46:09'),
(1208, 35, '2024-08-05 07:51:20', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-05 00:51:20', '2024-08-05 00:51:20'),
(1209, 23, '2024-08-05 07:51:31', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-05 00:51:31', '2024-08-05 00:51:31'),
(1210, 35, '2024-08-05 07:52:08', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-05 00:52:08', '2024-08-05 00:52:08'),
(1211, 23, '2024-08-05 07:54:06', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-05 00:54:06', '2024-08-05 00:54:06'),
(1212, 36, '2024-08-05 08:21:34', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-05 01:21:34', '2024-08-05 01:21:34'),
(1213, 23, '2024-08-05 08:21:51', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-05 01:21:51', '2024-08-05 01:21:51'),
(1214, 15, '2024-08-05 08:23:00', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-05 01:23:00', '2024-08-05 01:23:00'),
(1215, 15, '2024-08-07 08:23:29', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-07 01:23:29', '2024-08-07 01:23:29'),
(1216, 15, '2024-08-08 15:12:53', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-08-08 08:12:53', '2024-08-08 08:12:53'),
(1217, 15, '2024-08-15 13:20:36', '10.14.179.250', NULL, NULL, NULL, NULL, '2024-08-15 06:20:36', '2024-08-15 06:20:36'),
(1218, 4, '2024-08-15 13:24:49', '10.14.179.250', NULL, NULL, NULL, NULL, '2024-08-15 06:24:49', '2024-08-15 06:24:49'),
(1219, 15, '2024-08-16 09:45:37', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-16 02:45:37', '2024-08-16 02:45:37'),
(1220, 34, '2024-08-16 09:49:39', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-16 02:49:39', '2024-08-16 02:49:39'),
(1221, 4, '2024-08-16 09:51:37', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-16 02:51:37', '2024-08-16 02:51:37'),
(1222, 37, '2024-08-16 09:54:09', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-16 02:54:09', '2024-08-16 02:54:09'),
(1223, 4, '2024-08-16 09:54:47', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-16 02:54:47', '2024-08-16 02:54:47'),
(1224, 37, '2024-08-16 09:57:13', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-16 02:57:13', '2024-08-16 02:57:13'),
(1225, 15, '2024-08-16 10:04:19', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-16 03:04:19', '2024-08-16 03:04:19'),
(1226, 15, '2024-08-19 08:48:40', '10.14.179.64', NULL, NULL, NULL, NULL, '2024-08-19 01:48:40', '2024-08-19 01:48:40'),
(1227, 15, '2024-08-19 14:22:39', '10.14.179.250', NULL, NULL, NULL, NULL, '2024-08-19 07:22:39', '2024-08-19 07:22:39'),
(1228, 31, '2024-08-19 14:34:05', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-19 07:34:05', '2024-08-19 07:34:05'),
(1229, 4, '2024-08-19 14:59:25', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-19 07:59:25', '2024-08-19 07:59:25'),
(1230, 31, '2024-08-19 15:00:49', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-19 08:00:49', '2024-08-19 08:00:49'),
(1231, 31, '2024-08-19 15:02:52', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-19 08:02:52', '2024-08-19 08:02:52'),
(1232, 31, '2024-08-20 08:50:04', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-20 01:50:04', '2024-08-20 01:50:04'),
(1233, 15, '2024-08-20 08:51:29', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-20 01:51:29', '2024-08-20 01:51:29'),
(1234, 31, '2024-08-20 08:51:42', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-20 01:51:42', '2024-08-20 01:51:42'),
(1235, 4, '2024-08-20 08:52:21', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-20 01:52:21', '2024-08-20 01:52:21'),
(1236, 31, '2024-08-20 09:54:59', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-20 02:54:59', '2024-08-20 02:54:59'),
(1237, 15, '2024-08-20 10:36:33', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-20 03:36:33', '2024-08-20 03:36:33'),
(1238, 34, '2024-08-20 10:37:33', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-20 03:37:33', '2024-08-20 03:37:33'),
(1239, 4, '2024-08-20 11:26:27', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-20 04:26:27', '2024-08-20 04:26:27'),
(1240, 15, '2024-08-20 12:56:58', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-20 05:56:58', '2024-08-20 05:56:58'),
(1241, 31, '2024-08-20 13:03:35', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-20 06:03:35', '2024-08-20 06:03:35'),
(1242, 15, '2024-08-20 13:16:11', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-20 06:16:11', '2024-08-20 06:16:11'),
(1243, 15, '2024-08-20 13:28:51', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-20 06:28:51', '2024-08-20 06:28:51'),
(1244, 23, '2024-08-20 13:31:17', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-20 06:31:17', '2024-08-20 06:31:17'),
(1245, 15, '2024-08-20 14:08:08', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-20 07:08:08', '2024-08-20 07:08:08'),
(1246, 23, '2024-08-20 14:09:31', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-20 07:09:31', '2024-08-20 07:09:31'),
(1247, 36, '2024-08-20 14:10:18', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-20 07:10:18', '2024-08-20 07:10:18'),
(1248, 15, '2024-08-20 14:10:35', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-20 07:10:35', '2024-08-20 07:10:35'),
(1249, 15, '2024-08-21 09:20:58', '10.14.179.250', NULL, NULL, NULL, NULL, '2024-08-21 02:20:58', '2024-08-21 02:20:58'),
(1250, 4, '2024-08-22 08:13:21', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-08-22 01:13:21', '2024-08-22 01:13:21'),
(1251, 15, '2024-08-22 08:16:42', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-08-22 01:16:42', '2024-08-22 01:16:42'),
(1252, 14, '2024-08-22 08:20:56', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-08-22 01:20:56', '2024-08-22 01:20:56'),
(1253, 15, '2024-08-26 10:58:21', '10.14.179.64', NULL, NULL, NULL, NULL, '2024-08-26 03:58:21', '2024-08-26 03:58:21'),
(1254, 15, '2024-08-27 08:21:46', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-27 01:21:46', '2024-08-27 01:21:46'),
(1255, 35, '2024-08-27 08:23:27', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-27 01:23:27', '2024-08-27 01:23:27'),
(1256, 23, '2024-08-27 08:23:43', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-27 01:23:43', '2024-08-27 01:23:43'),
(1257, 35, '2024-08-27 08:24:11', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-27 01:24:11', '2024-08-27 01:24:11'),
(1258, 36, '2024-08-27 08:32:02', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-27 01:32:02', '2024-08-27 01:32:02'),
(1259, 15, '2024-08-27 08:32:29', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-27 01:32:29', '2024-08-27 01:32:29'),
(1260, 15, '2024-08-27 10:03:13', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-27 03:03:13', '2024-08-27 03:03:13'),
(1261, 23, '2024-08-27 10:06:38', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-27 03:06:38', '2024-08-27 03:06:38'),
(1262, 35, '2024-08-27 10:07:33', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-27 03:07:33', '2024-08-27 03:07:33'),
(1263, 36, '2024-08-27 10:11:16', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-27 03:11:16', '2024-08-27 03:11:16'),
(1264, 15, '2024-08-27 10:13:14', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-27 03:13:14', '2024-08-27 03:13:14'),
(1265, 35, '2024-08-27 10:13:53', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-27 03:13:53', '2024-08-27 03:13:53'),
(1266, 23, '2024-08-27 10:22:22', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-27 03:22:22', '2024-08-27 03:22:22'),
(1267, 15, '2024-08-27 12:30:35', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-27 05:30:35', '2024-08-27 05:30:35'),
(1268, 31, '2024-08-27 12:31:13', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-27 05:31:13', '2024-08-27 05:31:13'),
(1269, 15, '2024-08-29 10:01:41', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-29 03:01:41', '2024-08-29 03:01:41'),
(1270, 23, '2024-08-29 10:53:27', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-29 03:53:27', '2024-08-29 03:53:27'),
(1271, 31, '2024-08-29 10:53:41', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-29 03:53:41', '2024-08-29 03:53:41'),
(1272, 15, '2024-08-29 13:03:11', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-08-29 06:03:11', '2024-08-29 06:03:11'),
(1273, 34, '2024-08-29 13:08:24', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-08-29 06:08:24', '2024-08-29 06:08:24'),
(1274, 23, '2024-08-29 13:28:52', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-08-29 06:28:52', '2024-08-29 06:28:52'),
(1275, 15, '2024-08-29 13:29:59', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-08-29 06:29:59', '2024-08-29 06:29:59'),
(1276, 15, '2024-08-29 13:39:47', '10.14.189.94', NULL, NULL, NULL, NULL, '2024-08-29 06:39:47', '2024-08-29 06:39:47'),
(1277, 15, '2024-08-30 15:28:08', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-30 08:28:08', '2024-08-30 08:28:08'),
(1278, 31, '2024-08-30 15:30:51', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-30 08:30:51', '2024-08-30 08:30:51'),
(1279, 31, '2024-08-30 16:03:17', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-08-30 09:03:17', '2024-08-30 09:03:17'),
(1280, 15, '2024-09-02 11:06:12', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-09-02 04:06:12', '2024-09-02 04:06:12'),
(1281, 31, '2024-09-02 12:36:27', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-09-02 05:36:27', '2024-09-02 05:36:27'),
(1282, 15, '2024-09-03 10:15:20', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-09-03 03:15:20', '2024-09-03 03:15:20'),
(1283, 15, '2024-09-03 10:23:32', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-09-03 03:23:32', '2024-09-03 03:23:32'),
(1284, 15, '2024-09-03 10:30:05', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-09-03 03:30:05', '2024-09-03 03:30:05'),
(1285, 31, '2024-09-03 10:43:50', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-09-03 03:43:50', '2024-09-03 03:43:50'),
(1286, 23, '2024-09-03 10:52:44', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-09-03 03:52:44', '2024-09-03 03:52:44'),
(1287, 4, '2024-09-03 10:52:55', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-09-03 03:52:55', '2024-09-03 03:52:55'),
(1288, 23, '2024-09-03 10:53:34', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-09-03 03:53:34', '2024-09-03 03:53:34'),
(1289, 36, '2024-09-03 10:55:46', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-09-03 03:55:46', '2024-09-03 03:55:46'),
(1290, 23, '2024-09-03 11:34:11', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-09-03 04:34:11', '2024-09-03 04:34:11'),
(1291, 36, '2024-09-03 11:35:20', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-09-03 04:35:20', '2024-09-03 04:35:20'),
(1292, 31, '2024-09-03 12:38:45', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-09-03 05:38:45', '2024-09-03 05:38:45');
INSERT INTO `logs` (`id`, `user_id`, `last_login_at`, `last_login_ip`, `last_download_file_at`, `last_download_file_id`, `last_delete_file_at`, `last_delete_file_id`, `created_at`, `updated_at`) VALUES
(1293, 15, '2024-09-03 12:43:21', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-09-03 05:43:21', '2024-09-03 05:43:21'),
(1294, 15, '2024-09-03 13:43:00', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-09-03 06:43:00', '2024-09-03 06:43:00'),
(1295, 33, '2024-09-03 13:48:05', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-09-03 06:48:05', '2024-09-03 06:48:05'),
(1296, 15, '2024-09-03 13:52:51', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-09-03 06:52:51', '2024-09-03 06:52:51'),
(1297, 31, '2024-09-03 13:54:32', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-09-03 06:54:32', '2024-09-03 06:54:32'),
(1298, 15, '2024-10-15 07:34:40', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-10-15 00:34:40', '2024-10-15 00:34:40'),
(1299, 4, '2024-10-16 13:33:18', '10.14.179.250', NULL, NULL, NULL, NULL, '2024-10-16 06:33:18', '2024-10-16 06:33:18'),
(1300, 4, '2024-10-17 14:13:11', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-10-17 07:13:11', '2024-10-17 07:13:11'),
(1301, 15, '2024-10-17 15:02:05', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-10-17 08:02:05', '2024-10-17 08:02:05'),
(1302, 4, '2024-10-23 11:38:29', '10.14.179.250', NULL, NULL, NULL, NULL, '2024-10-23 04:38:29', '2024-10-23 04:38:29'),
(1303, 34, '2024-11-06 10:32:15', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-11-06 03:32:15', '2024-11-06 03:32:15'),
(1304, 4, '2024-11-06 10:32:25', '10.14.179.8', NULL, NULL, NULL, NULL, '2024-11-06 03:32:25', '2024-11-06 03:32:25'),
(1305, 20, '2024-11-06 14:15:05', '10.14.189.243', NULL, NULL, NULL, NULL, '2024-11-06 07:15:05', '2024-11-06 07:15:05'),
(1306, 20, '2025-07-03 11:08:32', '10.14.189.85', NULL, NULL, NULL, NULL, '2025-07-03 18:08:32', '2025-07-03 18:08:32'),
(1307, 20, '2025-07-03 11:12:22', '10.14.189.85', NULL, NULL, NULL, NULL, '2025-07-03 18:12:22', '2025-07-03 18:12:22'),
(1308, 20, '2025-07-03 11:14:38', '10.14.189.85', NULL, NULL, NULL, NULL, '2025-07-03 18:14:38', '2025-07-03 18:14:38'),
(1309, 18, '2025-07-03 11:14:49', '10.14.189.85', NULL, NULL, NULL, NULL, '2025-07-03 18:14:49', '2025-07-03 18:14:49'),
(1310, 1, '2025-07-03 11:15:15', '10.14.189.85', NULL, NULL, NULL, NULL, '2025-07-03 18:15:15', '2025-07-03 18:15:15'),
(1311, 1, '2025-07-04 08:32:18', '10.14.189.85', NULL, NULL, NULL, NULL, '2025-07-04 15:32:18', '2025-07-04 15:32:18'),
(1312, 20, '2025-07-04 08:48:24', '10.14.189.85', NULL, NULL, NULL, NULL, '2025-07-04 15:48:24', '2025-07-04 15:48:24'),
(1313, 18, '2025-07-04 09:47:02', '10.14.189.85', NULL, NULL, NULL, NULL, '2025-07-04 16:47:02', '2025-07-04 16:47:02'),
(1314, 27, '2025-07-04 14:42:05', '10.14.189.85', NULL, NULL, NULL, NULL, '2025-07-04 21:42:05', '2025-07-04 21:42:05'),
(1315, 27, '2025-07-04 15:02:22', '10.14.189.85', NULL, NULL, NULL, NULL, '2025-07-04 22:02:22', '2025-07-04 22:02:22'),
(1316, 20, '2025-07-04 15:02:36', '10.14.189.85', NULL, NULL, NULL, NULL, '2025-07-04 22:02:36', '2025-07-04 22:02:36'),
(1317, 20, '2025-07-04 15:07:53', '10.14.189.85', NULL, NULL, NULL, NULL, '2025-07-04 22:07:53', '2025-07-04 22:07:53'),
(1318, 20, '2025-07-04 15:09:45', '10.14.189.85', NULL, NULL, NULL, NULL, '2025-07-04 22:09:45', '2025-07-04 22:09:45'),
(1319, 20, '2025-07-04 15:12:11', '10.14.189.85', NULL, NULL, NULL, NULL, '2025-07-04 22:12:11', '2025-07-04 22:12:11'),
(1320, 20, '2025-07-04 15:12:44', '10.14.189.85', NULL, NULL, NULL, NULL, '2025-07-04 22:12:44', '2025-07-04 22:12:44'),
(1321, 20, '2025-07-04 15:13:39', '10.14.189.85', NULL, NULL, NULL, NULL, '2025-07-04 22:13:39', '2025-07-04 22:13:39'),
(1322, 20, '2025-07-07 07:37:38', '10.14.189.85', NULL, NULL, NULL, NULL, '2025-07-07 14:37:38', '2025-07-07 14:37:38'),
(1323, 1, '2025-07-07 07:38:07', '10.14.189.85', NULL, NULL, NULL, NULL, '2025-07-07 14:38:07', '2025-07-07 14:38:07'),
(1324, 20, '2025-07-07 08:26:08', '10.14.189.85', NULL, NULL, NULL, NULL, '2025-07-07 15:26:08', '2025-07-07 15:26:08'),
(1325, 20, '2025-07-07 08:28:56', '10.14.189.85', NULL, NULL, NULL, NULL, '2025-07-07 15:28:56', '2025-07-07 15:28:56'),
(1326, 20, '2025-07-07 08:33:50', '10.14.189.85', NULL, NULL, NULL, NULL, '2025-07-07 15:33:50', '2025-07-07 15:33:50'),
(1327, 20, '2025-07-07 08:56:37', '10.14.189.85', NULL, NULL, NULL, NULL, '2025-07-07 15:56:37', '2025-07-07 15:56:37'),
(1328, 20, '2025-07-07 08:58:47', '10.14.189.85', NULL, NULL, NULL, NULL, '2025-07-07 15:58:47', '2025-07-07 15:58:47'),
(1329, 1, '2025-07-07 10:19:59', '10.14.189.85', NULL, NULL, NULL, NULL, '2025-07-07 17:19:59', '2025-07-07 17:19:59'),
(1330, 20, '2025-07-07 10:21:45', '10.14.189.85', NULL, NULL, NULL, NULL, '2025-07-07 17:21:45', '2025-07-07 17:21:45'),
(1331, 20, '2025-07-07 13:00:12', '10.14.189.85', NULL, NULL, NULL, NULL, '2025-07-07 20:00:12', '2025-07-07 20:00:12'),
(1332, 20, '2025-07-07 14:02:53', '10.14.189.85', NULL, NULL, NULL, NULL, '2025-07-07 21:02:53', '2025-07-07 21:02:53'),
(1333, 20, '2025-07-08 10:50:24', '10.14.189.187', NULL, NULL, NULL, NULL, '2025-07-08 03:50:24', '2025-07-08 03:50:24'),
(1334, 20, '2025-07-09 14:59:22', '10.14.189.187', NULL, NULL, NULL, NULL, '2025-07-09 07:59:22', '2025-07-09 07:59:22'),
(1335, 1, '2025-07-11 07:57:16', '10.14.189.187', NULL, NULL, NULL, NULL, '2025-07-11 00:57:16', '2025-07-11 00:57:16'),
(1336, 1, '2025-07-11 08:22:58', '10.14.189.187', NULL, NULL, NULL, NULL, '2025-07-11 01:22:58', '2025-07-11 01:22:58'),
(1337, 20, '2025-07-14 11:23:35', '10.14.189.187', NULL, NULL, NULL, NULL, '2025-07-14 04:23:35', '2025-07-14 04:23:35'),
(1338, 20, '2025-07-16 07:35:47', '10.14.189.187', NULL, NULL, NULL, NULL, '2025-07-16 00:35:47', '2025-07-16 00:35:47'),
(1339, 20, '2025-07-16 07:37:06', '10.14.189.187', NULL, NULL, NULL, NULL, '2025-07-16 00:37:06', '2025-07-16 00:37:06');

-- --------------------------------------------------------

--
-- Table structure for table `machine`
--

CREATE TABLE `machine` (
  `id` int(20) NOT NULL,
  `machine_id` int(20) NOT NULL,
  `code` varchar(10) NOT NULL,
  `description` text DEFAULT NULL,
  `machine_name` varchar(40) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `machine`
--

INSERT INTO `machine` (`id`, `machine_id`, `code`, `description`, `machine_name`, `created_at`, `updated_at`) VALUES
(5, 1, 'IMM', '-', 'INJECTION MACHINE', '2024-09-13 08:26:38', '2024-09-13 15:26:38'),
(6, 2, 'MTC', '-', 'MOLD TEMPERATURE CONTROL', '2024-09-20 06:31:50', '2024-09-20 13:31:50'),
(7, 3, 'DHD', '-', 'DEHUMIDITY DRYER', '2024-09-20 06:32:44', '2024-09-20 13:32:44'),
(8, 4, 'HD', '-', 'HOPPER DRYER', '2024-09-20 06:33:13', '2024-09-20 13:33:13'),
(9, 5, 'ATL', '-', 'AUTOLOADER', '2024-09-20 08:41:32', '2024-09-20 15:41:32'),
(10, 6, 'ROBOT', '-', 'ROBOT', '2024-09-20 08:41:52', '2024-09-20 15:41:52'),
(11, 7, 'CHL-inj', '-', 'CHILLER INjECTION', '2024-09-20 08:42:57', '2024-11-01 16:12:02'),
(12, 8, 'CB', '-', 'CONTROL BOX', '2024-09-20 08:43:23', '2024-09-20 15:43:23'),
(13, 9, 'DC', '-', 'DUST COLLECTOR', '2024-09-20 08:43:49', '2024-09-20 15:43:49'),
(14, 10, 'AIR', '-', 'AIR LEAKAGE & LIGHTING', '2024-11-01 05:48:38', '2024-11-01 12:48:38'),
(15, 11, 'PRESS', '-', 'PRESSING', '2024-11-01 05:49:04', '2024-11-01 12:49:04'),
(16, 12, 'SCREW', '-', 'AUTO SCREW', '2024-11-01 05:51:15', '2024-11-01 12:51:15'),
(17, 13, 'GLUE', '-', 'ROBOT GLUE', '2024-11-01 05:51:39', '2024-11-01 12:51:39'),
(18, 14, 'RIVET', '-', 'RIVETING', '2024-11-01 05:52:07', '2024-11-01 12:52:07'),
(19, 15, 'HOT', '-', 'HOT MELT GLUE TANK', '2024-11-01 05:52:26', '2024-11-01 12:52:46'),
(20, 16, 'CAULK', '-', 'CAULKING', '2024-11-01 05:53:06', '2024-11-01 12:53:06'),
(21, 17, 'ULTRA', '-', 'ULTRASONIC', '2024-11-01 05:53:19', '2024-11-01 12:53:19'),
(22, 18, 'ANEAL', '-', 'ANEALING OVEN', '2024-11-01 05:55:49', '2024-11-01 12:55:49'),
(23, 19, 'OVEN', '-', 'OVEN HANGING TRAYS TYPE', '2024-11-01 05:56:19', '2024-11-01 12:56:19'),
(24, 20, 'VIB', '-', 'VIBRATION', '2024-11-01 06:07:17', '2024-11-01 13:07:17'),
(25, 21, 'HP', '-', 'HOT PLATE', '2024-11-01 06:07:44', '2024-11-01 13:07:44'),
(26, 22, 'HIS', '-', 'HOT INSERT SINGLE ARM', '2024-11-01 06:08:46', '2024-11-01 13:08:46'),
(27, 23, 'HID', '-', 'HOT INSERT DOUBLE ARM', '2024-11-01 06:09:11', '2024-11-01 13:09:11'),
(28, 24, 'LT', '-', 'LIGHTING TESTER', '2024-11-01 06:09:36', '2024-11-01 13:09:36'),
(29, 25, 'CBHR', '-', 'CONTROL BOX HOT RUNNER', '2024-11-01 08:38:18', '2024-11-01 15:38:18'),
(30, 26, 'TRAFO', '-', 'TRAFO', '2024-11-01 09:05:26', '2024-11-01 16:05:26'),
(31, 27, 'GNST', '-', 'GENSET DIESEL', '2024-11-01 09:05:43', '2024-11-01 16:05:43'),
(32, 28, 'KMPRSR', '-', 'KOMPORESOR', '2024-11-01 09:06:19', '2024-11-01 16:06:19'),
(33, 29, 'CT', '-', 'COOLING TOWER', '2024-11-01 09:06:49', '2024-11-01 16:06:49'),
(34, 30, 'POMPA', '-', 'POMPA', '2024-11-01 09:07:06', '2024-11-01 16:07:06'),
(35, 31, 'CHL', '-', 'CHILLER', '2024-11-01 09:07:29', '2024-11-01 16:07:29'),
(36, 32, 'HYDRANT', '-', 'HYDRANT SYSTEM', '2024-11-01 09:07:46', '2024-11-01 16:07:46'),
(37, 33, 'AHU', '-', 'AIR HANDLING UNIT', '2024-11-01 09:08:04', '2024-11-01 16:08:04'),
(38, 34, 'CRANE', '-', 'CRANE', '2024-11-01 09:08:18', '2024-11-01 16:08:18');

-- --------------------------------------------------------

--
-- Table structure for table `machine_detail`
--

CREATE TABLE `machine_detail` (
  `id` int(11) NOT NULL,
  `machine_id` int(9) NOT NULL,
  `no_mc` varchar(6) NOT NULL,
  `type` varchar(30) DEFAULT NULL,
  `brand` varchar(50) DEFAULT NULL,
  `manufacture_number` varchar(20) DEFAULT NULL,
  `install_date` date DEFAULT NULL,
  `kva` float DEFAULT NULL,
  `kw` float DEFAULT NULL,
  `asset_number` varchar(20) DEFAULT NULL,
  `location` varchar(20) DEFAULT NULL,
  `country_maker` varchar(30) DEFAULT NULL,
  `manufacture_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `machine_detail`
--

INSERT INTO `machine_detail` (`id`, `machine_id`, `no_mc`, `type`, `brand`, `manufacture_number`, `install_date`, `kva`, `kw`, `asset_number`, `location`, `country_maker`, `manufacture_date`, `created_at`, `updated_at`) VALUES
(38, 1, '1', 'NRT-1250D', 'NANRONG', '1409006', NULL, 85.422, 68.3376, 'A20150500049', 'LINE 1', 'Taiwan', '2014-09-01', '2024-10-25 01:36:11', '2024-10-25 08:36:11'),
(39, 1, '2', 'NR-160D', 'HUARONG', '105001', NULL, 31.87, 25.496, 'A20171100009', 'LINE 2', 'Taiwan', '2017-06-01', '2024-10-25 01:36:11', '2024-10-25 08:36:11'),
(40, 1, '3', 'NR-160D', 'HUARONG', '17001', NULL, 31.87, 31.87, 'A20171100010', 'LINE 3', 'Taiwan', '2017-06-01', '2024-10-25 01:36:11', '2024-10-25 08:36:11'),
(41, 1, '4', 'NRT-650SD', 'NANRONG', '1507004', NULL, NULL, 31.85, 'A20151000007', 'LINE 4', 'Taiwan', '2015-07-01', '2024-10-25 01:36:11', '2024-10-25 08:36:11'),
(42, 1, '5', 'NRT-650SD', 'NANRONG', '1507005', NULL, NULL, 90, 'A20151000006', 'LINE 5', 'Taiwan', '2015-07-01', '2024-10-25 01:36:11', '2024-10-25 08:36:11'),
(43, 1, '6', 'NRT-1250D', 'NANRONG', '1409007', NULL, NULL, 107, 'A20150100021', 'LINE 6', 'Taiwan', '2014-09-01', '2024-10-25 01:36:11', '2024-10-25 08:36:11'),
(44, 1, '7', 'NRT-650D/BMC', 'NANRONG', '1409008', NULL, NULL, 33, 'A20150500050', 'LINE 7 - BMC', 'Taiwan', '2014-09-01', '2024-10-25 01:36:11', '2024-10-25 08:36:11'),
(45, 1, '8', 'DC-1490SE', 'HWA CHIN', 'MDT-140BS021', NULL, NULL, 141, 'A5011901001000', 'LINE 8', 'Taiwan', '2018-09-01', '2024-10-25 01:36:11', '2024-10-25 08:36:11'),
(46, 1, '9', 'SI-450-6S/J450HE', 'TOYO', '1957027', NULL, NULL, 121.84, 'A5151802012000', 'LINE 9', 'Taiwan', '2018-08-01', '2024-10-25 01:36:11', '2024-10-25 08:36:11'),
(47, 1, '10', 'SI-450-6S/J450HE', 'TOYO', '1957028', NULL, NULL, 85.422, 'A5151802013000', 'LINE 10', 'Taiwan', '2018-08-01', '2024-10-25 01:36:11', '2024-10-25 08:36:11'),
(48, 1, '11', 'JU14000M', 'HAITIAN', '202012140062250', '2021-02-01', NULL, 185, 'A5012001001000', 'LINE 11', 'Taiwan', '2021-02-02', '2024-10-25 01:36:11', '2024-10-25 08:36:11'),
(49, 1, '12', 'JU18500M/2350/1300/L280', 'HAITIAN', '202012185052068', '2021-02-01', NULL, 210, 'A5012001002000', 'LINE 12', 'Taiwan', '2020-05-27', '2024-10-25 01:36:11', '2024-10-25 08:36:11'),
(50, 1, '13', 'JU18500M/2350/1300/L280', 'HAITIAN', '202212185061980', '2022-02-01', NULL, 210, 'A5012112004000', 'LINE 13', 'Taiwan', '2022-06-22', '2024-10-25 01:36:11', '2024-10-25 08:36:11'),
(184, 3, '1', 'DRG-100Z-KS', 'KAWATA', 'IDR1401050', NULL, NULL, 15, 'IJ/2014/014', 'line 6', 'Jepang', '2014-10-01', '2024-11-01 03:47:14', '2024-11-01 10:47:14'),
(185, 3, '2', 'DRG-100Z-KS', 'KAWATA', 'idr1401070', NULL, NULL, 15, 'IJ/2014/015', 'line 6', 'Jepang', '2014-10-01', '2024-11-01 03:47:14', '2024-11-01 10:47:14'),
(186, 3, '3', 'DRG-100Z-KS', 'KAWATA', 'IDR1401060', NULL, NULL, 15.75, 'IJ/2014/035', 'line 3', 'Jepang', '2014-10-01', '2024-11-01 03:47:14', '2024-11-01 10:47:14'),
(187, 3, '4', 'DF500ZB-KS', 'KAWATA', 'DF15040151AA', NULL, NULL, 174.8, 'IJ/2015/021', 'line 5', 'Jepang', '2015-06-01', '2024-11-01 03:47:14', '2024-11-01 10:47:14'),
(188, 3, '5', 'DF500ZB-KS', 'KAWATA', 'DF15040152AA', NULL, NULL, 17.8, 'IJ/2015/068', 'line 1', 'Jepang', '2015-06-01', '2024-11-01 03:47:14', '2024-11-01 10:47:14'),
(189, 3, '6', 'SDD-450U/200HCE', 'SHINI', '2DD00000191', NULL, NULL, 17.9, 'IJ/2018/050', 'line 8', 'Taiwan', '2018-04-14', '2024-11-01 03:47:14', '2024-11-01 10:47:14'),
(190, 3, '7', 'SDD-450U/200HCE', 'SHINI', '2DD00000189', NULL, NULL, 17.9, 'IJ/2018/049', 'line 8', 'Taiwan', '2018-04-14', '2024-11-01 03:47:14', '2024-11-01 10:47:14'),
(191, 3, '8', 'SDD-450U/200HCE', 'SHINI', '2DD00000251', NULL, NULL, 17.9, 'IJ/2018/078', 'line 9', 'Taiwan', '2018-05-21', '2024-11-01 03:47:14', '2024-11-01 10:47:14'),
(192, 3, '9', 'SDD-450U/200HCE', 'SHINI', '2DD00000252', NULL, NULL, 12.9, 'IJ/2018/086', 'line 4', 'Taiwan', '2018-05-21', '2024-11-01 03:47:14', '2024-11-01 10:47:14'),
(193, 3, '10', 'DFG-150Z-KI', 'KAWATA', NULL, NULL, NULL, 11.6, NULL, 'line 11', 'Taiwan', NULL, '2024-11-01 03:47:14', '2024-11-01 10:47:14'),
(194, 3, '11', 'DFG-150Z-KI', 'KAWATA', NULL, NULL, NULL, 11.6, NULL, 'line 11', 'Taiwan', NULL, '2024-11-01 03:47:14', '2024-11-01 10:47:14'),
(195, 3, '12', 'DFG-150Z-KI', 'KAWATA', NULL, NULL, NULL, 11.6, NULL, 'line 11', NULL, NULL, '2024-11-01 03:47:14', '2024-11-01 10:47:14'),
(196, 3, '13', 'DFG-50Z-KI', 'KAWATA', NULL, NULL, NULL, 5.62, NULL, 'line 13', NULL, NULL, '2024-11-01 03:47:14', '2024-11-01 10:47:14'),
(197, 3, '14', 'DFG-100Z-KI', 'KAWATA', NULL, NULL, NULL, 7.94, NULL, 'line 13', NULL, NULL, '2024-11-01 03:47:14', '2024-11-01 10:47:14'),
(198, 3, '15', 'DFG-150Z-KI', 'KAWATA', NULL, NULL, NULL, 11.6, NULL, 'line 13', 'Taiwan', NULL, '2024-11-01 03:47:14', '2024-11-01 10:47:14'),
(199, 4, '1', 'SHD-200T', 'SHINI', '1HD14070144', NULL, 2, NULL, 'IJ/2014/016', 'line 5', 'Taiwan', '2014-07-21', '2024-11-01 03:51:30', '2024-11-01 10:51:30'),
(200, 4, '2', 'SHD-200T', 'SHINI', '1HD14080161', NULL, 12.4, NULL, 'IJ/2014/020', 'line 5', 'Taiwan', '2014-08-18', '2024-11-01 03:51:30', '2024-11-01 10:51:30'),
(201, 4, '3', 'SHD-200T', 'SHINI', '1HD14070211', NULL, 12.4, NULL, 'IJ/2014/022', 'line 5', 'Taiwan', '2014-07-28', '2024-11-01 03:51:30', '2024-11-01 10:51:30'),
(202, 4, '4', 'SHD-12T', 'SHINI', '1HD14060187', NULL, 2.24, NULL, 'IJ/2014/031', 'line 4', 'Taiwan', '2014-06-26', '2024-11-01 03:51:30', '2024-11-01 10:51:30'),
(203, 4, '5', 'SHD-12T', 'SHINI', '1HD14110145', NULL, 2.29, NULL, 'IJ/2014/023', 'line 5', 'Taiwan', '2014-11-20', '2024-11-01 03:51:30', '2024-11-01 10:51:30'),
(204, 4, '6', 'SHD-200T', 'SHINI', '1HD14070148', NULL, 12.4, NULL, 'IJ/2014/030', 'line 10', 'Taiwan', '2014-07-21', '2024-11-01 03:51:30', '2024-11-01 10:51:30'),
(205, 4, '8', 'SHD-50T', 'SHINI', '1HD14060206', NULL, 4, NULL, 'IJ/2014/017', 'line 6', 'Taiwan', '2014-06-26', '2024-11-01 03:53:55', '2024-11-01 10:53:55'),
(206, 4, '9', 'HD-T-50-3H', 'YANNBANG', '1700403', NULL, 4, NULL, 'IJ/2017/046', 'line 2', 'Taiwan', '2017-03-01', '2024-11-01 03:53:55', '2024-11-01 10:53:55'),
(207, 4, '10', 'HD-T-50-3H', 'YANNBANG', 'TBD-6', NULL, NULL, NULL, NULL, 'line 3', 'Taiwan', '2017-07-19', '2024-11-01 03:53:55', '2024-11-01 10:53:55'),
(208, 4, '11', 'HD-T-100-1214', 'YANNBANG', '171438', NULL, 6.5, NULL, 'IJ/2017/029', 'line 10', 'Taiwan', '2017-08-01', '2024-11-01 03:53:55', '2024-11-01 10:53:55'),
(209, 4, '12', 'HD-T-12-12H', 'YANNBANG', '1800566', NULL, 2.05, NULL, 'IJ/2018/064', 'line 8', 'Taiwan', '2018-06-01', '2024-11-01 03:53:55', '2024-11-01 10:53:55'),
(210, 4, '13', 'HD-T-12-12H', 'YANNBANG', '1800567', NULL, 2.05, NULL, 'IJ/2018/065', 'line 8', 'Taiwan', '2018-06-01', '2024-11-01 03:53:55', '2024-11-01 10:53:55'),
(211, 4, '14', 'SHD200', 'SHINI', NULL, NULL, 12.4, NULL, NULL, 'line 12', 'Taiwan', NULL, '2024-11-01 03:53:55', '2024-11-01 10:53:55'),
(212, 4, '15', 'SHD200', 'SHINI', NULL, NULL, 12.4, NULL, NULL, 'line 12', 'Taiwan', NULL, '2024-11-01 03:53:55', '2024-11-01 10:53:55'),
(213, 4, '16', 'SHD200', 'SHINI', NULL, NULL, 12.4, NULL, NULL, 'line 12', 'Taiwan', NULL, '2024-11-01 03:53:55', '2024-11-01 10:53:55'),
(214, 4, '17', 'SHD-12T', 'SHINI', NULL, NULL, 2.3, NULL, NULL, 'line 12', 'Taiwan', NULL, '2024-11-01 03:53:55', '2024-11-01 10:53:55'),
(215, 4, '18', 'SHD-12T', 'SHINI', NULL, NULL, 2.3, NULL, NULL, 'line 12', 'Taiwan', NULL, '2024-11-01 03:53:55', '2024-11-01 10:53:55'),
(216, 4, '19', 'SHD-12T', 'SHINI', NULL, NULL, 2.3, NULL, NULL, 'line 12', 'Taiwan', NULL, '2024-11-01 03:53:55', '2024-11-01 10:53:55'),
(217, 4, '20', 'ADB-15-KI', 'KAWATA', NULL, NULL, 2.04, NULL, NULL, 'line 13', NULL, NULL, '2024-11-01 03:53:55', '2024-11-01 10:53:55'),
(218, 4, '21', 'ADB-15-KI', 'KAWATA', NULL, NULL, 2.04, NULL, NULL, 'line 13', NULL, NULL, '2024-11-01 03:53:55', '2024-11-01 10:53:55'),
(219, 4, '22', 'ADB-15-KI', 'KAWATA', NULL, NULL, 2.04, NULL, NULL, 'line 13', NULL, NULL, '2024-11-01 03:53:55', '2024-11-01 10:53:55'),
(220, 2, '1', 'JSW-3012E', 'JSW', '142151', NULL, NULL, 18, 'IJ/2014/001', 'line 6', 'Taiwan', '2014-08-08', '2024-11-01 04:06:03', '2024-11-01 11:06:03'),
(221, 2, '2', 'JSW-3012E', 'JSW', '142152', NULL, NULL, 18.2, 'IJ/2014/033', 'line 1', 'Taiwan', '2014-08-08', '2024-11-01 04:06:03', '2024-11-01 11:06:03'),
(222, 2, '1', 'JSW-3012E', 'JSW', '142151', NULL, NULL, 18, 'IJ/2014/001', 'line 6', 'Taiwan', '2014-08-08', '2024-11-01 04:08:47', '2024-11-01 11:08:47'),
(223, 2, '2', 'JSW-3012E', 'JSW', '142152', NULL, NULL, 18.2, 'IJ/2014/033', 'line 1', 'Taiwan', '2014-08-08', '2024-11-01 04:08:47', '2024-11-01 11:08:47'),
(224, 2, '6', 'STM-910W-CE', 'SHINI', '2WH14060009', NULL, NULL, 9.75, 'IJ/2014/047', 'line 1', 'Taiwan', '2014-06-19', '2024-11-01 04:08:47', '2024-11-01 11:08:47'),
(225, 2, '7', 'STM-1220W', 'SHINI', '2WH14070081', NULL, NULL, 13, 'IJ/2014/003', 'line 8', 'Taiwan', '0000-00-00', '2024-11-01 04:08:47', '2024-11-01 11:08:47'),
(226, 2, '8', 'STM-1220W', 'SHINI', '2WH14070080', NULL, NULL, 13, 'IJ/2014/011', 'line 9', 'Taiwan', '2014-07-24', '2024-11-01 04:08:47', '2024-11-01 11:08:47'),
(227, 2, '9', 'STM-1220W', 'SHINI', '2WH14070083', NULL, NULL, 13.5, 'IJ/2014/069', 'line 3', 'Taiwan', '2014-07-24', '2024-11-01 04:08:47', '2024-11-01 11:08:47'),
(228, 2, '12', 'JSW-3012E', 'JSW', '152093', NULL, NULL, 18.2, 'IJ/2015/070', 'line 2', 'Taiwan', '2015-06-13', '2024-11-01 04:08:47', '2024-11-01 11:08:47'),
(229, 2, '13', 'STM-1220W-CE', 'SHINI', '2WH1407083', NULL, NULL, 13.5, 'IJ/2014/071', 'line 5', 'Taiwan', '2014-07-24', '2024-11-01 04:08:47', '2024-11-01 11:08:47'),
(230, 2, '16', 'STM-1220W-CE', 'SHINI', '2WH00003136', NULL, NULL, 13.5, 'IJ/2018/056', 'line 8', 'Taiwan', '2018-05-11', '2024-11-01 04:08:47', '2024-11-01 11:08:47'),
(231, 2, '17', 'STM-1220E-CE', 'SHINI', '2WH16080052', NULL, NULL, 13.5, 'IJ/2016/054', 'line 10', 'Taiwan', '2016-08-29', '2024-11-01 04:08:47', '2024-11-01 11:08:47'),
(232, 2, '18', 'STM-1220W', 'SHINI', '2WH15100060', NULL, NULL, 13.5, 'IJ/2015/053', 'line 4', 'Taiwan', '2015-10-26', '2024-11-01 04:08:47', '2024-11-01 11:08:47'),
(233, 2, '19', 'STM-1220W', 'SHINI', NULL, NULL, NULL, 13.5, 'IJ/2015/053', 'line 12', 'Taiwan', NULL, '2024-11-01 04:08:47', '2024-11-01 11:08:47'),
(234, 2, '20', 'STM-1220W-CE', 'SHINI', '2WH00003135', NULL, NULL, 13.5, 'IJ/2018/075', 'line 1', 'Taiwan', '2018-05-11', '2024-11-01 04:08:47', '2024-11-01 11:08:47'),
(235, 2, '21', 'STM-122OW-CE', 'SHINI', '2WH00002845', NULL, NULL, 13.5, 'IJ/2018/076', 'line 9', 'Taiwan', '2018-04-13', '2024-11-01 04:08:47', '2024-11-01 11:08:47'),
(236, 2, '22', 'STM-1220W-CE', 'SHINI', '2WH00003917', NULL, NULL, 13.5, 'IJ/2018/083', 'line 10', 'Taiwan', '2018-09-12', '2024-11-01 04:08:47', '2024-11-01 11:08:47'),
(237, 2, '23', 'STM-1220-CE', 'SHINI', '2WH00003138', NULL, NULL, 13.5, 'IJ/2018/084', 'line 6', 'Taiwan', '2018-05-11', '2024-11-01 04:08:47', '2024-11-01 11:08:47'),
(238, 2, '24', 'TW-600MA-KI', 'KAWATA', NULL, NULL, NULL, 10.1, NULL, 'line 11', 'Jepang', NULL, '2024-11-01 04:08:47', '2024-11-01 11:08:47'),
(239, 2, '25', 'TW-600MA-KI', 'KAWATA', NULL, NULL, NULL, 10.1, NULL, 'line 11', 'Jepang', NULL, '2024-11-01 04:08:47', '2024-11-01 11:08:47'),
(240, 2, '26', 'TW-600MA-KI', 'KAWATA', NULL, NULL, NULL, 10.1, NULL, 'line 11', 'Jepang', NULL, '2024-11-01 04:08:47', '2024-11-01 11:08:47'),
(241, 2, '27', 'TW-600MA-KI', 'KAWATA', NULL, NULL, NULL, 10.1, NULL, 'line 11', 'Jepang', NULL, '2024-11-01 04:08:47', '2024-11-01 11:08:47'),
(242, 2, '28', 'TW-600MA-KI', 'KAWATA', NULL, NULL, NULL, 10.1, NULL, NULL, 'Jepang', NULL, '2024-11-01 04:08:47', '2024-11-01 11:08:47'),
(243, 2, '29', 'TW-600MA-KI', 'KAWATA', NULL, NULL, NULL, 10.1, NULL, NULL, 'Jepang', NULL, '2024-11-01 04:08:47', '2024-11-01 11:08:47'),
(244, 2, '30', 'KC-326L', NULL, NULL, NULL, NULL, 23, NULL, 'line 12', 'Taiwan', NULL, '2024-11-01 04:08:47', '2024-11-01 11:08:47'),
(245, 2, '31', 'KC-326L', NULL, NULL, NULL, NULL, 23, NULL, 'line 12', 'Taiwan', NULL, '2024-11-01 04:08:47', '2024-11-01 11:08:47'),
(246, 2, '32', 'KC-326L', NULL, NULL, NULL, NULL, 23, NULL, 'line 12', 'Taiwan', NULL, '2024-11-01 04:08:48', '2024-11-01 11:08:48'),
(247, 2, '33', 'KC-326L', NULL, NULL, NULL, NULL, 23, NULL, 'line 12', 'Taiwan', NULL, '2024-11-01 04:08:48', '2024-11-01 11:08:48'),
(248, 2, '34', 'TW-600MA-KI', 'KAWATA', NULL, NULL, NULL, 10.1, NULL, NULL, NULL, NULL, '2024-11-01 04:08:48', '2024-11-01 11:08:48'),
(249, 2, '35', 'TW-600MA-KI', 'KAWATA', NULL, NULL, NULL, 10.1, NULL, 'line 13', NULL, NULL, '2024-11-01 04:08:48', '2024-11-01 11:08:48'),
(250, 2, '36', 'TW-600MA-KI', 'KAWATA', NULL, NULL, NULL, 10.1, NULL, 'line 13', NULL, NULL, '2024-11-01 04:08:48', '2024-11-01 11:08:48'),
(251, 2, '37', 'TW-600MA-KI', 'KAWATA', NULL, NULL, NULL, 10.1, NULL, 'line 13', NULL, NULL, '2024-11-01 04:08:48', '2024-11-01 11:08:48'),
(252, 2, '38', 'TW-600MA-KI', 'KAWATA', NULL, NULL, NULL, 10.1, NULL, 'line 13', NULL, NULL, '2024-11-01 04:08:48', '2024-11-01 11:08:48'),
(253, 2, '39', 'TW-600MA-KI', 'KAWATA', NULL, NULL, NULL, 10.1, NULL, 'line 13', NULL, NULL, '2024-11-01 04:08:48', '2024-11-01 11:08:48'),
(254, 5, '1', 'SAL-800G2', 'SHINI', '1LG14060175', NULL, NULL, 1.5, 'IJ/2014/034', 'line 9', 'Taiwan', '2014-06-30', '2024-11-01 04:22:31', '2024-11-01 11:22:31'),
(255, 5, '2', 'SAL-800G2', 'SHINI', '1LG14050172', NULL, NULL, 1, 'IJ/2014/006', 'standby', 'Taiwan', '2014-05-23', '2024-11-01 04:22:31', '2024-11-01 11:22:31'),
(256, 5, '3', 'SAL-800G2', 'SHINI', '1LG14050170', NULL, NULL, 1.5, 'IJ/2014/051', 'standby', 'Taiwan', '2014-05-23', '2024-11-01 04:22:31', '2024-11-01 11:22:31'),
(257, 5, '4', 'SAL-800G2', 'SHINI', '1LG15030089', NULL, NULL, 1.5, 'IJ/2015/026', 'line 5', 'Taiwan', '2015-03-16', '2024-11-01 04:22:31', '2024-11-01 11:22:31'),
(258, 5, '5', 'TCZ-6L-H12', 'YANNBANG', '1800365', NULL, NULL, 0.75, 'IJ/2018/044', 'line 3', 'Taiwan', '2018-03-01', '2024-11-01 04:22:31', '2024-11-01 11:22:31'),
(259, 5, '6', 'TCZ-6L-H12', 'YANNBANG', '1800257', NULL, NULL, 0.75, 'IJ/2018/045', 'line 2', 'Taiwan', '2018-02-01', '2024-11-01 04:22:31', '2024-11-01 11:22:31'),
(260, 5, '7', 'SAL-800G2', 'SHINI', '1LG15030105', NULL, NULL, 1.5, 'IJ/2015/052', 'line 5', 'Taiwan', '2015-03-16', '2024-11-01 04:22:31', '2024-11-01 11:22:31'),
(261, 5, '8', 'SAL-800G2-CE', 'SHINI', '2LG00005093', NULL, NULL, 1, 'IJ/2018/004', 'standby', 'Taiwan', '2018-04-18', '2024-11-01 04:22:31', '2024-11-01 11:22:31'),
(262, 5, '9', 'SAL-800G2-CE', 'SHINI', '2LG00005092', NULL, NULL, 1, 'IJ/2018/005', 'standby', 'Taiwan', '2018-04-18', '2024-11-01 04:22:31', '2024-11-01 11:22:31'),
(263, 5, '10', 'TCL-6L-H3', 'YANNBANG', '1700983', NULL, NULL, 0.75, 'IJ/2017/039', 'standby', 'Taiwan', '2017-05-05', '2024-11-01 04:22:31', '2024-11-01 11:22:31'),
(264, 5, '11', 'SAL-900G2-CE', 'SHINI', '2LG00005373', NULL, NULL, 1.5, 'IJ/2018/077', 'line 9', 'Taiwan', '2018-05-15', '2024-11-01 04:22:31', '2024-11-01 11:22:31'),
(265, 5, '12', 'SAL-900G2-CE', 'SHINI', '2LG00005374', NULL, NULL, 1.5, 'IJ/2018/085', 'line 10', 'Taiwan', '2018-05-15', '2024-11-01 04:22:31', '2024-11-01 11:22:31'),
(266, 5, '13', 'SAL-900G2', 'SHINI', NULL, NULL, NULL, 1.5, NULL, 'line 12', 'Taiwan', NULL, '2024-11-01 04:22:31', '2024-11-01 11:22:31'),
(267, 5, '14', 'SAL-900G2', 'SHINI', NULL, NULL, NULL, 1.5, NULL, 'line 12', 'Taiwan', NULL, '2024-11-01 04:22:31', '2024-11-01 11:22:31'),
(268, 5, '15', 'SAL-900G2', 'SHINI', NULL, NULL, NULL, 1.5, NULL, 'line 12', 'Taiwan', NULL, '2024-11-01 04:22:31', '2024-11-01 11:22:31'),
(269, 6, '1', 'S1700D', 'APEX', 'SC1407014', NULL, NULL, NULL, 'IJ/2014/073', 'line 1', 'Taiwan', '2014-08-01', '2024-11-01 04:25:20', '2024-11-01 11:25:20'),
(270, 6, '2', 'SC1300', 'APEX', 'SC156005', NULL, NULL, NULL, 'IJ/2015/036', 'line 4', 'Taiwan', '2015-06-16', '2024-11-01 04:25:20', '2024-11-01 11:25:20'),
(271, 6, '3', 'SC1300', 'APEX', 'SC1506006', NULL, NULL, NULL, 'IJ/2015/027', 'line 5', 'Taiwan', '2015-06-18', '2024-11-01 04:25:20', '2024-11-01 11:25:20'),
(272, 6, '4', 'S1700D', 'APEX', 'SC14070211', NULL, NULL, NULL, 'IJ/2014/018', 'line 6', 'Taiwan', '2014-01-07', '2024-11-01 04:25:20', '2024-11-01 11:25:20'),
(273, 6, '5', 'SC-70SLL', 'YUSHIN', '17007150-0020', NULL, NULL, NULL, 'IJ/2017/043', 'line 2', 'Jepang', '2017-05-05', '2024-11-01 04:25:20', '2024-11-01 11:25:20'),
(274, 6, '6', 'SC-70SLL', 'YUSHIN', '17007150-0010', NULL, NULL, NULL, 'IJ/2017/041', 'line 3', 'Jepang', '2017-05-05', '2024-11-01 04:25:20', '2024-11-01 11:25:20'),
(275, 6, '7', 'SAII-1000S', 'YUSHIN', '18012079-0020', NULL, 2.5, NULL, 'IJ/2018/066', 'line 8', 'Jepang', '2018-08-08', '2024-11-01 04:25:20', '2024-11-01 11:25:20'),
(276, 6, '8', 'SC-250SLL', 'YUSHIN', '1801279-0010', NULL, 1.5, NULL, 'IJ/2018/081', 'line 10', 'Jepang', '2018-08-08', '2024-11-01 04:25:20', '2024-11-01 11:25:20'),
(277, 6, '9', 'SAII-1000S', 'YUSHIN', '21000324-0010', NULL, 2.5, NULL, NULL, 'line 11', NULL, '2021-02-02', '2024-11-01 04:25:20', '2024-11-01 11:25:20'),
(280, 7, '1', 'VT-750S', NULL, 'KAWATA', '0000-00-00', NULL, NULL, '7.6', 'BMC', 'Taiwan', NULL, '2024-11-01 04:34:50', '2024-11-01 11:34:50'),
(281, 8, '1', 'TYPE B', 'CHENYI', NULL, NULL, NULL, NULL, NULL, 'line 10', 'Taiwan', NULL, '2024-11-01 04:36:34', '2024-11-01 11:36:34'),
(282, 8, '2', 'TYPE B', 'CHENYI', NULL, NULL, NULL, NULL, NULL, 'line 4', 'Taiwan', NULL, '2024-11-01 04:36:34', '2024-11-01 11:36:34'),
(283, 8, '3', 'TYPE B', 'CHENYI', NULL, NULL, NULL, NULL, NULL, 'line 10', 'Taiwan', NULL, '2024-11-01 04:36:34', '2024-11-01 11:36:34'),
(284, 8, '4', 'TYPE B', 'CHENYI', NULL, NULL, NULL, NULL, NULL, 'line 5', 'Taiwan', NULL, '2024-11-01 04:36:34', '2024-11-01 11:36:34'),
(285, 8, '5', 'TYPE B', 'CHENYI', NULL, NULL, NULL, NULL, NULL, 'line 5', 'Taiwan', NULL, '2024-11-01 04:36:34', '2024-11-01 11:36:34'),
(286, 8, '6', 'TYPE B', 'CHENYI', NULL, NULL, NULL, NULL, NULL, 'line 6', 'Taiwan', NULL, '2024-11-01 04:36:34', '2024-11-01 11:36:34'),
(287, 8, '7', 'TYPE B', 'CHENYI', NULL, NULL, NULL, NULL, NULL, NULL, 'Taiwan', NULL, '2024-11-01 04:36:34', '2024-11-01 11:36:34'),
(288, 8, '8', 'TYPE B', 'CHENYI', NULL, NULL, NULL, NULL, NULL, NULL, 'Taiwan', NULL, '2024-11-01 04:36:34', '2024-11-01 11:36:34'),
(289, 8, '9', 'T8D-6 (B)', 'JODO', 'C1800025', '2018-09-04', NULL, NULL, 'IJ/2018/008', NULL, 'Taiwan', '2018-09-04', '2024-11-01 04:36:34', '2024-11-01 11:36:34'),
(290, 8, '10', 'TBD-6', 'JODO', 'C1800024', '2018-04-09', NULL, NULL, 'IJ/2018/057', NULL, 'Taiwan', NULL, '2024-11-01 04:36:34', '2024-11-01 11:36:34'),
(291, 8, '11', 'TBD-6', 'JODO', 'C1800029', '2018-06-20', NULL, NULL, 'IJ/2018/058', NULL, 'Taiwan', NULL, '2024-11-01 04:36:34', '2024-11-01 11:36:34'),
(292, 8, '12', 'TBD-6', 'JODO', 'C1800032', '2018-06-20', NULL, NULL, 'IJ/2018/059', NULL, 'Taiwan', NULL, '2024-11-01 04:36:34', '2024-11-01 11:36:34'),
(293, 8, '13', 'TBD-6', 'JODO', 'C1800051', '2018-06-24', NULL, NULL, 'IJ/2018/060', NULL, 'Taiwan', NULL, '2024-11-01 04:36:34', '2024-11-01 11:36:34'),
(294, 8, '14', 'TBD-6', 'JODO', 'C1800030', '2018-06-20', NULL, NULL, 'IJ/2018/061', NULL, 'Taiwan', NULL, '2024-11-01 04:36:34', '2024-11-01 11:36:34'),
(295, 8, '15', 'TBD-6', 'JODO', 'C1800054', '2018-06-24', NULL, NULL, 'IJ/2018/062', NULL, 'Taiwan', NULL, '2024-11-01 04:36:34', '2024-11-01 11:36:34'),
(296, 8, '16', 'TBD-6', 'JODO', 'C1800052', '2018-06-24', NULL, NULL, 'IJ/2018/072', 'line 1', 'Taiwan', NULL, '2024-11-01 04:36:34', '2024-11-01 11:36:34'),
(297, 8, '17', 'TBD-6', 'JODO', 'C1800053', '2018-08-24', NULL, NULL, 'IJ/2018/079', NULL, 'Taiwan', NULL, '2024-11-01 04:36:34', '2024-11-01 11:36:34'),
(298, 8, '18', 'TBD-6', 'JODO', 'C1800031', '2018-06-20', NULL, NULL, 'IJ/2018/082', NULL, 'Taiwan', NULL, '2024-11-01 04:36:34', '2024-11-01 11:36:34'),
(299, 9, '0', 'CT-101', 'MAXON', '-', NULL, 0, 0, '-', '1,5', 'IJ/2013/009', '2013-03-01', '2024-11-01 04:37:36', '2024-11-01 11:44:02'),
(300, 10, '1', NULL, 'EA-TECH INDUSTRY', NULL, '2012-11-12', 0.11, 0.108, NULL, 'Ultasonik pos 1', 'IJ/2013/009', '1905-07-04', '2024-11-01 07:31:44', '2024-11-01 14:31:44'),
(301, 10, '2', NULL, 'EA-TECH INDUSTRY', NULL, '2012-11-12', 0.11, 0.108, NULL, 'Ultasonik pos 2', NULL, '1905-07-04', '2024-11-01 07:31:44', '2024-11-01 14:31:44'),
(302, 10, '3', NULL, 'EA-TECH INDUSTRY', NULL, '2014-02-12', 0.11, 0.108, 'A20151100014', 'HPW 2', NULL, '2014-01-12', '2024-11-01 07:31:44', '2024-11-01 14:31:44'),
(303, 10, '4', NULL, 'EA-TECH INDUSTRY', NULL, '2014-10-20', 0.11, 0.108, NULL, 'HPW 1', NULL, '2014-09-20', '2024-11-01 07:31:44', '2024-11-01 14:31:44'),
(304, 10, '5', NULL, 'EA-TECH INDUSTRY', NULL, '2014-11-12', 0.11, 0.108, NULL, 'Glue 2', NULL, '2014-10-12', '2024-11-01 07:31:44', '2024-11-01 14:31:44'),
(305, 10, '6', NULL, 'EA-TECH INDUSTRY', NULL, '2014-11-12', 0.11, 0.108, 'A20150200016', 'Glue 3', NULL, '2014-10-12', '2024-11-01 07:31:44', '2024-11-01 14:31:44'),
(306, 10, '7', NULL, 'EA-TECH INDUSTRY', NULL, '2015-09-06', 0.11, 0.108, 'A20150200015', 'Vibration 2', NULL, '2015-08-06', '2024-11-01 07:31:44', '2024-11-01 14:31:44'),
(307, 10, '8', NULL, 'EA-TECH INDUSTRY', NULL, '2015-11-06', 0.11, 0.108, 'A20151100015', 'Vibration 3', NULL, '2015-10-06', '2024-11-01 07:31:44', '2024-11-01 14:31:44'),
(308, 10, '9', NULL, 'EA-TECH INDUSTRY', NULL, '2018-09-20', 0.11, 0.108, NULL, 'Vibration 1', NULL, '2018-08-20', '2024-11-01 07:31:44', '2024-11-01 14:31:44'),
(309, 10, '10', NULL, 'EA-TECH INDUSTRY', NULL, '2018-12-20', 0.11, 0.108, 'A5021904006000', 'HPW 3', NULL, '2018-11-20', '2024-11-01 07:31:44', '2024-11-01 14:31:44'),
(310, 10, '11', 'AAJI-ALT+LT-A000', 'EA-TECH INDUSTRY', NULL, '2018-08-20', 0.11, 0.108, 'A5161805010000', 'KOJA', NULL, '2018-08-20', '2024-11-01 07:31:44', '2024-11-01 14:31:44'),
(311, 10, '12', 'JMLT-720-01100002', 'NEW JEIN INDUSTRIAL', NULL, '2018-12-20', 0.11, 0.108, NULL, 'Glue 1', NULL, '2011-07-03', '2024-11-01 07:31:44', '2024-11-01 14:31:44'),
(312, 10, '13', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-11-01 07:31:44', '2024-11-01 14:31:44'),
(313, 10, '14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-11-01 07:31:44', '2024-11-01 14:31:44'),
(314, 11, '1', NULL, 'EA-TECH INDUSTRY', NULL, '2012-11-12', 0.044, 0.039, 'A20150200014', 'Vibration 1', NULL, '1905-07-04', '2024-11-01 08:01:33', '2024-11-01 15:01:33'),
(315, 11, '2', NULL, 'EA-TECH INDUSTRY', NULL, '2012-11-12', 0.044, 0.039, 'A2021200002-043', 'Glue 3', NULL, '2012-10-12', '2024-11-01 08:01:33', '2024-11-01 15:01:33'),
(316, 11, '3', NULL, 'EA-TECH INDUSTRY', NULL, '2014-11-12', 0.044, 0.039, 'A20150200006', 'Vibration 2', NULL, '1905-07-06', '2024-11-01 08:01:33', '2024-11-01 15:01:33'),
(317, 11, '4', NULL, 'EA-TECH INDUSTRY', NULL, '2014-11-12', 0.044, 0.039, 'A5021904008000', 'Glue 2', NULL, '2014-10-12', '2024-11-01 08:01:33', '2024-11-01 15:01:33'),
(318, 11, '5', NULL, 'EA-TECH INDUSTRY', NULL, '2014-11-12', 0.044, 0.039, NULL, 'Stanby', NULL, '2014-10-12', '2024-11-01 08:01:33', '2024-11-01 15:01:33'),
(319, 11, '6', NULL, 'EA-TECH INDUSTRY', NULL, '2018-09-20', 0.044, 0.039, 'A5161802004000', 'KOJA', NULL, '2018-08-20', '2024-11-01 08:01:33', '2024-11-01 15:01:33'),
(320, 11, '7', 'JMPL-720-01100001', 'NEW JEIN INDUSTRIAL', NULL, '2018-12-20', 0.044, 0.039, NULL, 'Glue 1', NULL, '1905-07-03', '2024-11-01 08:01:33', '2024-11-01 15:01:33'),
(321, 12, '1', NULL, 'EA-TECH INDUSTRY', NULL, '2014-11-12', 0.286, 0.283, 'A20150200008', 'Glue 3', NULL, '2014-10-12', '2024-11-01 08:03:27', '2024-11-01 15:03:27'),
(322, 12, '2', NULL, 'EA-TECH INDUSTRY', NULL, '2014-11-12', 0.286, 0.283, NULL, 'Stanby', NULL, '2014-10-12', '2024-11-01 08:03:27', '2024-11-01 15:03:27'),
(323, 12, '3', NULL, 'EA-TECH INDUSTRY', NULL, '2014-11-12', 0.286, 0.283, NULL, 'Stanby', NULL, '2014-10-12', '2024-11-01 08:03:27', '2024-11-01 15:03:27'),
(324, 12, '4', NULL, 'EA-TECH INDUSTRY', NULL, '2018-09-20', 0.286, 0.283, 'A5161802002000', 'KOJA', NULL, '2018-08-20', '2024-11-01 08:03:27', '2024-11-01 15:03:27'),
(325, 13, '1', NULL, 'EA-TECH INDUSTRY', NULL, '2012-11-12', 0.461, 0.456, NULL, 'Stanby', NULL, '1905-07-04', '2024-11-01 08:10:53', '2024-11-01 15:10:53'),
(326, 13, '2', NULL, 'EA-TECH INDUSTRY', NULL, '2012-11-12', 0.461, 0.456, NULL, 'Stanby', NULL, '1905-07-04', '2024-11-01 08:10:53', '2024-11-01 15:10:53'),
(327, 13, '3', NULL, 'EA-TECH INDUSTRY', NULL, '2014-11-12', 0.461, 0.456, 'A20150200011', 'Glue 3', NULL, '2014-10-12', '2024-11-01 08:10:53', '2024-11-01 15:10:53'),
(328, 13, '4', NULL, 'EA-TECH INDUSTRY', NULL, '2014-11-12', 0.461, 0.456, NULL, 'Glue 2', NULL, '2014-10-12', '2024-11-01 08:10:53', '2024-11-01 15:10:53'),
(329, 13, '5', NULL, 'EA-TECH INDUSTRY', NULL, '2018-09-20', 0.461, 0.456, 'A516802001000', 'KOJA', NULL, '2018-08-20', '2024-11-01 08:10:53', '2024-11-01 15:10:53'),
(330, 13, '6', 'JM4X-844-0110003', 'NEW JEIN INDUSTRIAL', NULL, '2018-12-20', 0.461, 0.456, NULL, 'Glue 1', NULL, '1905-07-03', '2024-11-01 08:10:53', '2024-11-01 15:10:53'),
(331, 14, '1', NULL, 'EA-TECH INDUSTRY', NULL, '2012-11-12', 0.044, 0.039, 'A20121200002-040', 'Glue 3', NULL, '1905-07-04', '2024-11-01 08:11:52', '2024-11-01 15:11:52'),
(332, 14, '2', NULL, 'EA-TECH INDUSTRY', NULL, '2014-11-12', 0.044, 0.039, 'A20150200018', 'KOJA', NULL, '2014-10-12', '2024-11-01 08:11:52', '2024-11-01 15:11:52'),
(333, 15, '1', NULL, 'NORDSON', NULL, '2014-11-12', 13.822, 13.683, NULL, 'Stanby', NULL, '1905-06-29', '2024-11-01 08:12:45', '2024-11-01 15:12:45'),
(334, 15, '2', 'DURABLUE 8144913', 'NORDSON', 'LUI 4K04323', '2014-11-12', 13.822, 13.683, NULL, 'Glue 2', NULL, '1905-07-06', '2024-11-01 08:12:45', '2024-11-01 15:12:45'),
(335, 15, '3', 'DURABLUE 8144914', 'NORDSON', 'LUI 4K04277', '2014-11-12', 13.822, 13.683, 'A20150200005', 'Glue 3', NULL, '1905-07-06', '2024-11-01 08:12:45', '2024-11-01 15:12:45'),
(336, 15, '4', 'DURABLUE 8144915', 'NORDSON', 'LUI 4K04393', '2014-11-12', 13.822, 13.683, 'A20150200004', 'Glue 2', NULL, '1905-07-06', '2024-11-01 08:12:45', '2024-11-01 15:12:45'),
(337, 15, '5', 'DURABLUE 8144916', 'NORDSON', 'LUI 18F00009', '2018-09-20', 13.822, 13.683, 'A5161803009000', 'KOJA', NULL, '1905-07-10', '2024-11-01 08:12:45', '2024-11-01 15:12:45'),
(338, 15, '6', 'DURABLUE 8144917', 'NORDSON', 'LUI 11C01125', '2018-12-20', 13.822, 13.683, NULL, 'Glue 1', NULL, '1905-07-03', '2024-11-01 08:12:45', '2024-11-01 15:12:45'),
(339, 16, '1', 'JMPH-20000A-01100004', 'NEW JEIN INDUSTRIAL', NULL, '2018-12-20', 0.044, 0.039, NULL, 'Glue 1', NULL, '1905-07-03', '2024-11-01 08:13:44', '2024-11-01 15:13:44'),
(340, 17, '1', NULL, 'EVER GREEN ULTRASONI', NULL, '2012-11-12', 2.42, 2.395, NULL, 'Ultrasonik', NULL, '1905-07-04', '2024-11-01 08:15:12', '2024-11-01 15:15:12'),
(341, 17, '2', NULL, 'EVER GREEN ULTRASONI', NULL, '2012-11-12', 2.42, 2.395, NULL, 'Ultrasonik', NULL, '1905-07-04', '2024-11-01 08:15:12', '2024-11-01 15:15:12'),
(342, 17, '3', 'I001S2600D2', 'MING JILEE ENTERPRIS', NULL, '2014-11-12', 2.42, 2.395, 'A20141000011', 'Ultrasonik', NULL, '1905-07-06', '2024-11-01 08:15:12', '2024-11-01 15:15:12'),
(343, 17, '4', 'I001S2600D2', 'MING JILEE ENTERPRIS', NULL, '2014-11-12', 2.42, 2.395, 'A20140600001', 'Ultrasonik', NULL, '1905-07-06', '2024-11-01 08:15:12', '2024-11-01 15:15:12'),
(344, 17, '5', 'I001S2600D1', 'MING JILEE ENTERPRIS', NULL, '2014-11-12', 2.42, 2.395, 'A20141000010', 'Ultrasonik', NULL, '1905-07-06', '2024-11-01 08:15:12', '2024-11-01 15:15:12'),
(345, 18, '1', NULL, 'TECO ELECTRIC&MACHIN', NULL, '2012-11-12', 16.652, 16.465, 'A20121200001-042', 'Ultrasonik', NULL, '1905-07-04', '2024-11-01 08:16:07', '2024-11-01 15:16:07'),
(346, 19, '1', NULL, 'JADENG MACHINE TECH', NULL, '2015-11-06', 23.036, 22.805, NULL, 'HPW 2', NULL, '1905-07-07', '2024-11-01 08:17:05', '2024-11-01 15:17:05'),
(347, 19, '2', NULL, 'JADENG MACHINE TECH', NULL, '2015-11-06', 23.036, 22.805, 'A20150200002', 'Vibration', NULL, '1905-07-07', '2024-11-01 08:17:05', '2024-11-01 15:17:05'),
(348, 19, '3', NULL, 'JADENG MACHINE TECH', NULL, '2017-02-03', 23.036, 22.805, 'A20170200017', 'HPW 1', NULL, '1905-07-09', '2024-11-01 08:17:05', '2024-11-01 15:17:05'),
(349, 19, '4', NULL, 'KINGLONG', NULL, '2018-08-20', 14.809, 14.643, NULL, 'HPW 3', NULL, '1905-07-10', '2024-11-01 08:17:05', '2024-11-01 15:17:05'),
(350, 19, '5', NULL, 'TRP', NULL, NULL, NULL, NULL, NULL, 'HPW 4', NULL, '1905-07-13', '2024-11-01 08:17:05', '2024-11-01 15:17:05'),
(351, 19, '6', NULL, 'TRP', NULL, NULL, NULL, 18, NULL, 'HPW 5', NULL, '1905-07-14', '2024-11-01 08:17:05', '2024-11-01 15:17:05'),
(352, 19, '7', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-11-01 08:17:05', '2024-11-01 15:17:05'),
(353, 20, '1', NULL, 'BRANSON', 'VWN-06-1605-063', '2014-10-20', 14, 13.86, 'A20150200023', 'Vibration 2', NULL, '1905-07-06', '2024-11-01 08:17:52', '2024-11-01 15:17:52'),
(354, 20, '2', NULL, 'BRANSON', 'VWN-06-1408-595', '2016-07-17', 14, 13.86, 'A20160700002', 'Vibration 1', NULL, '1905-07-08', '2024-11-01 08:17:52', '2024-11-01 15:17:52'),
(355, 20, '3', NULL, 'BRANSON', 'VW-409518073', '2018-09-20', 14, 13.86, 'A5021805007000', 'Vibration 3', NULL, '1905-07-10', '2024-11-01 08:17:52', '2024-11-01 15:17:52'),
(356, 21, '1', NULL, 'EA-TECH INDUSTRY', NULL, '2014-10-12', 29.092, 28.766, 'A20150200022', 'HPW 2', NULL, '1905-07-06', '2024-11-01 08:19:59', '2024-11-01 15:19:59'),
(357, 21, '2', NULL, 'EA-TECH INDUSTRY', NULL, '2017-02-03', 29.092, 28.766, 'A20170400159', 'HPW 1', NULL, '2017-01-03', '2024-11-01 08:19:59', '2024-11-01 15:19:59'),
(358, 21, '3', NULL, 'EA-TECH INDUSTRY', NULL, '2018-09-20', 29.092, 28.766, NULL, 'HPW 3', NULL, '2018-08-20', '2024-11-01 08:19:59', '2024-11-01 15:19:59'),
(359, 21, '4', 'SERVO', 'EA-TECH INDUSTRY', 'EAAJI-3SSVSLHPM-A000', '2021-02-23', 91.1364, 80.2, 'A50022002001000', 'HPW 4', NULL, '2020-07-12', '2024-11-01 08:19:59', '2024-11-01 15:19:59'),
(360, 21, '5', 'SERVO', 'EA-TECH INDUSTRY', 'EAAJI-M3SSHPM-A000', '2022-02-18', 86.8182, 76.4, 'A5022202003000', 'HPW 5', NULL, '2022-01-20', '2024-11-01 08:19:59', '2024-11-01 15:19:59'),
(361, 21, '6', 'SERVO', 'EA-TECH INDUSTRY', 'EAAJI-L3SSHPM-A000', '2022-09-14', 91.1364, 80.2, 'A5022106005000', 'HPW 6', NULL, '2022-08-22', '2024-11-01 08:19:59', '2024-11-01 15:19:59'),
(362, 22, '1', NULL, 'EA-TECH INDUSTRY', NULL, '2014-10-20', 12.505, 12.379, 'A20150200021', 'HPW 1', NULL, '2014-09-20', '2024-11-01 08:19:59', '2024-11-01 15:19:59'),
(363, 23, '1', NULL, 'EA-TECH INDUSTRY', NULL, '2016-07-17', 12.505, 12.379, 'A5021903004000', 'Stanby', NULL, '2016-06-17', '2024-11-01 08:19:59', '2024-11-01 15:19:59'),
(364, 23, '2', NULL, 'EA-TECH INDUSTRY', NULL, '2017-02-03', 12.505, 12.379, 'A20170400160', 'Inject 5', NULL, '2017-01-03', '2024-11-01 08:19:59', '2024-11-01 15:19:59'),
(365, 24, '1', NULL, 'EA-TECH INDUSTRY', NULL, '2018-09-20', 0.11, 0.108, NULL, 'KOJA', NULL, '2018-08-20', '2024-11-01 08:19:59', '2024-11-01 15:19:59'),
(366, 25, '1', 'TYPE B', 'CHENYI', NULL, NULL, NULL, NULL, NULL, 'line 10', 'Taiwan', NULL, '2024-11-01 08:43:24', '2024-11-01 15:43:24'),
(367, 25, '2', 'TYPE B', 'CHENYI', NULL, NULL, NULL, NULL, NULL, 'line 4', 'Taiwan', NULL, '2024-11-01 08:43:24', '2024-11-01 15:43:24'),
(368, 25, '3', 'TYPE B', 'CHENYI', NULL, NULL, NULL, NULL, NULL, 'line 10', 'Taiwan', NULL, '2024-11-01 08:43:24', '2024-11-01 15:43:24'),
(369, 25, '4', 'TYPE B', 'CHENYI', NULL, NULL, NULL, NULL, NULL, 'line 5', 'Taiwan', NULL, '2024-11-01 08:43:24', '2024-11-01 15:43:24'),
(370, 25, '5', 'TYPE B', 'CHENYI', NULL, NULL, NULL, NULL, NULL, 'line 5', 'Taiwan', NULL, '2024-11-01 08:43:24', '2024-11-01 15:43:24'),
(371, 25, '6', 'TYPE B', 'CHENYI', NULL, NULL, NULL, NULL, NULL, 'line 6', 'Taiwan', NULL, '2024-11-01 08:43:24', '2024-11-01 15:43:24'),
(372, 25, '7', 'TYPE B', 'CHENYI', NULL, NULL, NULL, NULL, NULL, NULL, 'Taiwan', NULL, '2024-11-01 08:43:24', '2024-11-01 15:43:24'),
(373, 25, '8', 'TYPE B', 'CHENYI', NULL, NULL, NULL, NULL, NULL, NULL, 'Taiwan', NULL, '2024-11-01 08:43:24', '2024-11-01 15:43:24'),
(374, 25, '9', 'T8D-6 (B)', 'JODO', 'C1800025', '2018-09-04', NULL, NULL, 'IJ/2018/008', NULL, 'Taiwan', '2018-09-04', '2024-11-01 08:43:24', '2024-11-01 15:43:24'),
(375, 25, '10', 'TBD-6', 'JODO', 'C1800024', '2018-04-09', NULL, NULL, 'IJ/2018/057', NULL, 'Taiwan', NULL, '2024-11-01 08:43:24', '2024-11-01 15:43:24'),
(376, 25, '11', 'TBD-6', 'JODO', 'C1800029', '2018-06-20', NULL, NULL, 'IJ/2018/058', NULL, 'Taiwan', NULL, '2024-11-01 08:43:24', '2024-11-01 15:43:24'),
(377, 25, '12', 'TBD-6', 'JODO', 'C1800032', '2018-06-20', NULL, NULL, 'IJ/2018/059', NULL, 'Taiwan', NULL, '2024-11-01 08:43:24', '2024-11-01 15:43:24'),
(378, 25, '13', 'TBD-6', 'JODO', 'C1800051', '2018-06-24', NULL, NULL, 'IJ/2018/060', NULL, 'Taiwan', NULL, '2024-11-01 08:43:24', '2024-11-01 15:43:24'),
(379, 25, '14', 'TBD-6', 'JODO', 'C1800030', '2018-06-20', NULL, NULL, 'IJ/2018/061', NULL, 'Taiwan', NULL, '2024-11-01 08:43:24', '2024-11-01 15:43:24'),
(380, 25, '15', 'TBD-6', 'JODO', 'C1800054', '2018-06-24', NULL, NULL, 'IJ/2018/062', NULL, 'Taiwan', NULL, '2024-11-01 08:43:24', '2024-11-01 15:43:24'),
(381, 25, '16', 'TBD-6', 'JODO', 'C1800052', '2018-06-24', NULL, NULL, 'IJ/2018/072', 'line 1', 'Taiwan', NULL, '2024-11-01 08:43:24', '2024-11-01 15:43:24'),
(382, 25, '17', 'TBD-6', 'JODO', 'C1800053', '2018-08-24', NULL, NULL, 'IJ/2018/079', NULL, 'Taiwan', NULL, '2024-11-01 08:43:24', '2024-11-01 15:43:24'),
(383, 25, '18', 'TBD-6', 'JODO', 'C1800031', '2018-06-20', NULL, NULL, 'IJ/2018/082', NULL, 'Taiwan', NULL, '2024-11-01 08:43:24', '2024-11-01 15:43:24'),
(384, 25, '19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-11-01 08:43:24', '2024-11-01 15:43:24'),
(385, 25, '20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-11-01 08:43:24', '2024-11-01 15:43:24'),
(386, 25, '21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-11-01 08:43:24', '2024-11-01 15:43:24'),
(387, 25, '22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-11-01 08:43:24', '2024-11-01 15:43:24'),
(388, 25, '23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-11-01 08:43:24', '2024-11-01 15:43:24'),
(389, 26, '1', '2000KVA', 'TRAFFINDO', NULL, '1905-07-06', 2000, 1760, 'UT/2014/001', 'Ruang Trafo 1', NULL, '1905-07-06', '2024-11-02 13:24:45', '2024-11-02 20:24:45'),
(390, 26, '2', '1600KVA', 'TRAFFINDO', NULL, '1905-07-12', 1600, 1408, 'UT/2020/001', 'Ruang trafo 2', NULL, '1905-07-12', '2024-11-02 13:24:45', '2024-11-02 20:24:45'),
(391, 27, '1', 'EGS 1200-6', 'KOMATSU', '65692', '1905-07-06', 1200, 1056, 'UT/2014/002', 'Ruang Genset', NULL, '1905-07-06', '2024-11-02 13:24:45', '2024-11-02 20:24:45'),
(392, 27, '2', 'PL1500P', 'PERKINS', NULL, '1905-07-14', 1500, 1320, 'UT/2022/001', 'RUANG NEW GENSET', NULL, '1905-07-05', '2024-11-02 13:24:45', '2024-11-02 20:24:45'),
(393, 27, '3', 'PL1500P', 'PERKINS', NULL, '1905-07-14', 1500, 1320, 'UT/2022/002', 'RUANG NEW GENSET', NULL, '1905-07-05', '2024-11-02 13:24:46', '2024-11-02 20:24:46'),
(394, 28, '1', 'DSP-37AT5I', 'Hitachi', 'U1195213', '1905-07-06', 42.8977, 37.75, 'UT/2014/003', 'Ruang kompresor', NULL, '1905-07-06', '2024-11-02 13:24:46', '2024-11-02 20:24:46'),
(395, 28, '2', 'DSP-37AT5I', 'Hitachi', 'U1195212', '1905-07-06', 42.8977, 37.75, 'UT/2014/004', 'Ruang kompresor', NULL, '1905-07-06', '2024-11-02 13:24:46', '2024-11-02 20:24:46'),
(396, 28, '3', 'ag75A', 'Kobelco', 'D4LB1824', '1905-07-10', 86.0795, 75.75, 'UT/2018/001', 'Ruang kompresor', NULL, '1905-07-10', '2024-11-02 13:24:46', '2024-11-02 20:24:46'),
(397, 29, '1', '3 Basin', 'Liangchi 100', NULL, '1905-07-06', 5.11364, 4.5, 'UT/2014/005', 'Area Cooling', NULL, '1905-07-06', '2024-11-02 13:24:46', '2024-11-02 20:24:46'),
(398, 29, '2', '2 basin', 'Liangchi 100', NULL, '1905-07-06', 3.40909, 3, 'UT/2014/006', 'Area Cooling', NULL, '1905-07-06', '2024-11-02 13:24:46', '2024-11-02 20:24:46'),
(399, 30, '1', 'Pompa suplay', 'EBARA', NULL, '1905-07-06', 187.5, 165, 'UT/2014/007', 'Area Cooling', NULL, '1905-07-06', '2024-11-02 13:24:46', '2024-11-02 20:24:46'),
(400, 30, '2', 'pompa return', 'EBARA', NULL, '1905-07-06', 119.318, 105, 'UT/2014/008', 'area Cooling', NULL, '1905-07-06', '2024-11-02 13:24:46', '2024-11-02 20:24:46'),
(401, 30, '3', 'Pompa CWS', 'EBARA', NULL, '1905-07-06', 6.25, 5.5, 'UT/2014/010', 'Ruang  Chiller 208', NULL, '1905-07-06', '2024-11-02 13:24:46', '2024-11-02 20:24:46'),
(402, 30, '4', 'Pompa RWS', 'EBARA', NULL, '1905-07-06', 8.52273, 7.5, 'UT/2014/012', 'Area Cooling Tower', NULL, '1905-07-06', '2024-11-02 13:24:46', '2024-11-02 20:24:46'),
(403, 30, '5', 'Pompa Booster', 'EBARA', NULL, '1905-07-06', 6.25, 5.5, 'UT/2014/016', 'Ruang Pompa', NULL, '1905-07-06', '2024-11-02 13:24:46', '2024-11-02 20:24:46'),
(404, 30, '6', 'Pompa transfer', 'EBARA', NULL, '1905-07-06', 6.25, 5.5, 'UT/2014/017', 'Ruang Pompa', NULL, '1905-07-06', '2024-11-02 13:24:46', '2024-11-02 20:24:46'),
(405, 30, '4', 'Pompa RWS', 'TECO', NULL, '1905-07-11', 6.25, 5.5, 'UT/2019/002', 'Area VM 2', NULL, '1905-07-11', '2024-11-02 13:24:46', '2024-11-02 20:24:46'),
(406, 30, '6', 'Pompa RWS', 'TECO', NULL, '1905-07-11', 12.5, 11, 'UT/2019/004', 'Area K07A', NULL, '1905-07-11', '2024-11-02 13:24:46', '2024-11-02 20:24:46'),
(407, 31, '1', 'PSF215.1cfst.B', 'MC QUAY / DAIKIN', NULL, '1905-07-06', 176.136, 155, 'UT/2014/009', 'Ruang  Chiller 208', NULL, '1905-07-06', '2024-11-02 13:24:46', '2024-11-02 20:24:46'),
(408, 31, '2', 'YT2500S', 'KAWATA', '14808', '1905-07-06', 17.0455, 15, 'UT/2014/018', 'Area VM1', NULL, '1905-07-06', '2024-11-02 13:24:46', '2024-11-02 20:24:46'),
(409, 31, '3', 'YT1000', 'KAWATA', NULL, '1905-07-06', 8.52273, 7.5, 'UT/2014/019', 'Area Injection', NULL, '1905-07-06', '2024-11-02 13:24:46', '2024-11-02 20:24:46'),
(410, 31, '4', 'YANGFANG', 'YANGFANG', NULL, '1905-07-11', 34.0909, 30, 'UT/2019/001', 'Area VM 2', NULL, '1905-07-11', '2024-11-02 13:24:46', '2024-11-02 20:24:46'),
(411, 31, '5', 'UAA080', 'daikin', NULL, '1905-07-11', 90.9091, 80, 'UT/2019/003', 'Area K07A', NULL, '1905-07-11', '2024-11-02 13:24:46', '2024-11-02 20:24:46'),
(412, 32, '1', 'Jokey Pump', 'EBARA', NULL, '1905-07-06', 4.20455, 3.7, 'UT/2014/013', 'Ruang Pompa', NULL, '1905-07-06', '2024-11-02 13:24:46', '2024-11-02 20:24:46'),
(413, 32, '2', 'Elektrik Pump', 'EBARA', NULL, '1905-07-06', 51.1364, 45, 'UT/2014/014', 'Ruang Pompa', NULL, '1905-07-06', '2024-11-02 13:24:46', '2024-11-02 20:24:46'),
(414, 32, '3', 'Diesel Pump', 'Cummning', NULL, '1905-07-06', 0, 0, 'UT/2014/015', 'Ruang Pompa', NULL, '1905-07-06', '2024-11-02 13:24:46', '2024-11-02 20:24:46'),
(415, 33, '1', 'Ahu 2.2', 'MC QUAY', '1410283', '1905-07-06', 3.40909, 3, 'A20150300018', 'Area VM1', NULL, '1905-07-06', '2024-11-02 13:24:46', '2024-11-02 20:24:46'),
(416, 33, '2', 'Ahu 1.3', 'MC QUAY', '1410284', '1905-07-06', 8.52273, 7.5, 'A20150300019', 'Area VM1', NULL, '1905-07-06', '2024-11-02 13:24:46', '2024-11-02 20:24:46'),
(417, 33, '3', 'Ahu 1.4', 'MC QUAY', '1410285', '1905-07-06', 8.52273, 7.5, 'A20150300021', 'Area VM1', NULL, '1905-07-06', '2024-11-02 13:24:46', '2024-11-02 20:24:46'),
(418, 33, '4', 'Ahu 2.1', 'MC QUAY', '1410288', '1905-07-06', 3.40909, 3, NULL, 'Area VM2', NULL, '1905-07-06', '2024-11-02 13:24:46', '2024-11-02 20:24:46'),
(419, 33, '5', 'Ahu 1.1', 'MC QUAY', '1410287', '1905-07-06', 8.52273, 7.5, 'A20150400039', 'Area VM2', NULL, '1905-07-06', '2024-11-02 13:24:46', '2024-11-02 20:24:46'),
(420, 33, '6', 'Ahu 1.2', 'MC QUAY', '1410286', '1905-07-06', 8.52273, 7.5, 'A20150400038', 'Area VM2', NULL, '1905-07-06', '2024-11-02 13:24:46', '2024-11-02 20:24:46'),
(421, 33, '7', 'Ahu K07A', 'MC QUAY', 'GB/T14294-2008', '1905-07-10', 6.25, 5.5, NULL, 'Area K07A', NULL, '1905-07-10', '2024-11-02 13:24:46', '2024-11-02 20:24:46'),
(422, 34, '1', 'HOIST CRANE 16 T', 'ABUS130,2531,2/2', NULL, '1905-07-05', NULL, NULL, NULL, 'Area Injection', NULL, '1905-07-05', '2024-11-02 13:24:46', '2024-11-02 20:24:46'),
(423, 34, '2', 'HOIST CRANE 16 T', 'demac', NULL, '1905-07-13', NULL, NULL, NULL, 'Area Injection', NULL, '1905-07-13', '2024-11-02 13:24:46', '2024-11-02 20:24:46');

-- --------------------------------------------------------

--
-- Table structure for table `manpower_plannings`
--

CREATE TABLE `manpower_plannings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mpp_number` varchar(255) NOT NULL,
  `period` int(11) NOT NULL,
  `dept_id` bigint(20) UNSIGNED NOT NULL,
  `section_id` bigint(20) UNSIGNED NOT NULL,
  `additional` int(11) NOT NULL,
  `reduce` int(11) NOT NULL,
  `source` enum('internal','external') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2021_09_07_112352_create_permission_tables', 1),
(6, '2021_09_07_112530_create_posts_table', 1),
(7, '2021_11_11_040325_create_demos_table', 2),
(8, '2021_11_16_093637_add_softdeletes_to_users_table', 3),
(9, '2021_11_18_042146_create_departments_table', 4),
(10, '2021_11_18_061502_create_sections_table', 5),
(11, '2021_11_18_032842_create_manpower_plannings_table', 6),
(13, '2021_11_30_062234_create_uploads_table', 7),
(14, '2021_11_30_074221_create_files_table', 7),
(15, '2022_01_07_081253_create_categories_table', 8),
(16, '2022_01_21_092328_create_logs_table', 9),
(74, '2022_04_21_083147_create_parts_table', 10);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1677, 'App\\Models\\User', 60),
(1678, 'App\\Models\\User', 27),
(1678, 'App\\Models\\User', 28),
(1678, 'App\\Models\\User', 30),
(1678, 'App\\Models\\User', 31),
(1678, 'App\\Models\\User', 32),
(1678, 'App\\Models\\User', 33),
(1678, 'App\\Models\\User', 34),
(1679, 'App\\Models\\User', 2),
(1679, 'App\\Models\\User', 11),
(1679, 'App\\Models\\User', 12),
(1679, 'App\\Models\\User', 13),
(1679, 'App\\Models\\User', 103),
(1680, 'App\\Models\\User', 2),
(1681, 'App\\Models\\User', 244),
(1681, 'App\\Models\\User', 258),
(1682, 'App\\Models\\User', 1),
(1682, 'App\\Models\\User', 252),
(1683, 'App\\Models\\User', 14),
(1683, 'App\\Models\\User', 15),
(1683, 'App\\Models\\User', 16),
(1683, 'App\\Models\\User', 245),
(1683, 'App\\Models\\User', 246),
(1684, 'App\\Models\\User', 2),
(1684, 'App\\Models\\User', 3),
(1684, 'App\\Models\\User', 6),
(1684, 'App\\Models\\User', 9),
(1684, 'App\\Models\\User', 10),
(1684, 'App\\Models\\User', 11),
(1684, 'App\\Models\\User', 12),
(1684, 'App\\Models\\User', 13),
(1684, 'App\\Models\\User', 103),
(1684, 'App\\Models\\User', 211),
(1685, 'App\\Models\\User', 4),
(1685, 'App\\Models\\User', 7),
(1685, 'App\\Models\\User', 17),
(1685, 'App\\Models\\User', 18),
(1685, 'App\\Models\\User', 19),
(1685, 'App\\Models\\User', 20),
(1685, 'App\\Models\\User', 21),
(1685, 'App\\Models\\User', 22),
(1685, 'App\\Models\\User', 23),
(1685, 'App\\Models\\User', 24),
(1685, 'App\\Models\\User', 25),
(1685, 'App\\Models\\User', 26),
(1685, 'App\\Models\\User', 27),
(1685, 'App\\Models\\User', 28),
(1685, 'App\\Models\\User', 29),
(1685, 'App\\Models\\User', 30),
(1685, 'App\\Models\\User', 31),
(1685, 'App\\Models\\User', 32),
(1685, 'App\\Models\\User', 33),
(1685, 'App\\Models\\User', 34),
(1685, 'App\\Models\\User', 255),
(1685, 'App\\Models\\User', 262),
(1685, 'App\\Models\\User', 263),
(1686, 'App\\Models\\User', 5),
(1686, 'App\\Models\\User', 8),
(1686, 'App\\Models\\User', 35),
(1686, 'App\\Models\\User', 36),
(1686, 'App\\Models\\User', 37),
(1686, 'App\\Models\\User', 38),
(1686, 'App\\Models\\User', 39),
(1686, 'App\\Models\\User', 40),
(1686, 'App\\Models\\User', 41),
(1686, 'App\\Models\\User', 42),
(1686, 'App\\Models\\User', 43),
(1686, 'App\\Models\\User', 44),
(1686, 'App\\Models\\User', 45),
(1686, 'App\\Models\\User', 46),
(1686, 'App\\Models\\User', 47),
(1686, 'App\\Models\\User', 48),
(1686, 'App\\Models\\User', 49),
(1686, 'App\\Models\\User', 50),
(1686, 'App\\Models\\User', 51),
(1686, 'App\\Models\\User', 52),
(1686, 'App\\Models\\User', 210),
(1686, 'App\\Models\\User', 259),
(1686, 'App\\Models\\User', 260),
(1687, 'App\\Models\\User', 53),
(1687, 'App\\Models\\User', 54),
(1687, 'App\\Models\\User', 55),
(1687, 'App\\Models\\User', 56),
(1687, 'App\\Models\\User', 57),
(1687, 'App\\Models\\User', 58),
(1687, 'App\\Models\\User', 59),
(1687, 'App\\Models\\User', 60),
(1687, 'App\\Models\\User', 61),
(1688, 'App\\Models\\User', 62),
(1688, 'App\\Models\\User', 63),
(1688, 'App\\Models\\User', 64),
(1688, 'App\\Models\\User', 65),
(1688, 'App\\Models\\User', 66),
(1688, 'App\\Models\\User', 67),
(1688, 'App\\Models\\User', 68),
(1688, 'App\\Models\\User', 69),
(1688, 'App\\Models\\User', 70),
(1688, 'App\\Models\\User', 71),
(1688, 'App\\Models\\User', 247),
(1688, 'App\\Models\\User', 248),
(1688, 'App\\Models\\User', 249),
(1688, 'App\\Models\\User', 250),
(1688, 'App\\Models\\User', 251),
(1689, 'App\\Models\\User', 72),
(1689, 'App\\Models\\User', 73),
(1689, 'App\\Models\\User', 74),
(1689, 'App\\Models\\User', 75),
(1689, 'App\\Models\\User', 76),
(1689, 'App\\Models\\User', 77),
(1689, 'App\\Models\\User', 78),
(1689, 'App\\Models\\User', 79),
(1689, 'App\\Models\\User', 80),
(1689, 'App\\Models\\User', 81),
(1689, 'App\\Models\\User', 82),
(1689, 'App\\Models\\User', 83),
(1689, 'App\\Models\\User', 84),
(1689, 'App\\Models\\User', 85),
(1689, 'App\\Models\\User', 86),
(1689, 'App\\Models\\User', 87),
(1689, 'App\\Models\\User', 88),
(1689, 'App\\Models\\User', 89),
(1689, 'App\\Models\\User', 90),
(1689, 'App\\Models\\User', 91),
(1689, 'App\\Models\\User', 92),
(1689, 'App\\Models\\User', 93),
(1689, 'App\\Models\\User', 94),
(1689, 'App\\Models\\User', 95),
(1689, 'App\\Models\\User', 96),
(1689, 'App\\Models\\User', 97),
(1689, 'App\\Models\\User', 98),
(1689, 'App\\Models\\User', 99),
(1689, 'App\\Models\\User', 100),
(1689, 'App\\Models\\User', 101),
(1689, 'App\\Models\\User', 102),
(1689, 'App\\Models\\User', 104),
(1689, 'App\\Models\\User', 105),
(1689, 'App\\Models\\User', 106),
(1689, 'App\\Models\\User', 107),
(1689, 'App\\Models\\User', 108),
(1689, 'App\\Models\\User', 109),
(1689, 'App\\Models\\User', 110),
(1689, 'App\\Models\\User', 111),
(1689, 'App\\Models\\User', 112),
(1689, 'App\\Models\\User', 113),
(1689, 'App\\Models\\User', 114),
(1689, 'App\\Models\\User', 115),
(1689, 'App\\Models\\User', 116),
(1689, 'App\\Models\\User', 117),
(1689, 'App\\Models\\User', 118),
(1689, 'App\\Models\\User', 119),
(1689, 'App\\Models\\User', 120),
(1689, 'App\\Models\\User', 121),
(1689, 'App\\Models\\User', 122),
(1689, 'App\\Models\\User', 123),
(1689, 'App\\Models\\User', 124),
(1689, 'App\\Models\\User', 125),
(1689, 'App\\Models\\User', 126),
(1689, 'App\\Models\\User', 127),
(1689, 'App\\Models\\User', 128),
(1689, 'App\\Models\\User', 129),
(1689, 'App\\Models\\User', 130),
(1689, 'App\\Models\\User', 131),
(1689, 'App\\Models\\User', 132),
(1689, 'App\\Models\\User', 133),
(1689, 'App\\Models\\User', 134),
(1689, 'App\\Models\\User', 135),
(1689, 'App\\Models\\User', 136),
(1689, 'App\\Models\\User', 137),
(1689, 'App\\Models\\User', 138),
(1689, 'App\\Models\\User', 139),
(1689, 'App\\Models\\User', 140),
(1689, 'App\\Models\\User', 141),
(1689, 'App\\Models\\User', 142),
(1689, 'App\\Models\\User', 143),
(1689, 'App\\Models\\User', 144),
(1689, 'App\\Models\\User', 145),
(1689, 'App\\Models\\User', 146),
(1689, 'App\\Models\\User', 147),
(1689, 'App\\Models\\User', 148),
(1689, 'App\\Models\\User', 149),
(1689, 'App\\Models\\User', 150),
(1689, 'App\\Models\\User', 151),
(1689, 'App\\Models\\User', 152),
(1689, 'App\\Models\\User', 153),
(1689, 'App\\Models\\User', 154),
(1689, 'App\\Models\\User', 155),
(1689, 'App\\Models\\User', 156),
(1689, 'App\\Models\\User', 157),
(1689, 'App\\Models\\User', 158),
(1689, 'App\\Models\\User', 159),
(1689, 'App\\Models\\User', 160),
(1689, 'App\\Models\\User', 161),
(1689, 'App\\Models\\User', 162),
(1689, 'App\\Models\\User', 163),
(1689, 'App\\Models\\User', 164),
(1689, 'App\\Models\\User', 165),
(1689, 'App\\Models\\User', 166),
(1689, 'App\\Models\\User', 167),
(1689, 'App\\Models\\User', 168),
(1689, 'App\\Models\\User', 169),
(1689, 'App\\Models\\User', 170),
(1689, 'App\\Models\\User', 171),
(1689, 'App\\Models\\User', 172),
(1689, 'App\\Models\\User', 173),
(1689, 'App\\Models\\User', 174),
(1689, 'App\\Models\\User', 175),
(1689, 'App\\Models\\User', 176),
(1689, 'App\\Models\\User', 177),
(1689, 'App\\Models\\User', 178),
(1689, 'App\\Models\\User', 179),
(1689, 'App\\Models\\User', 180),
(1689, 'App\\Models\\User', 181),
(1689, 'App\\Models\\User', 182),
(1689, 'App\\Models\\User', 183),
(1689, 'App\\Models\\User', 184),
(1689, 'App\\Models\\User', 185),
(1689, 'App\\Models\\User', 186),
(1689, 'App\\Models\\User', 187),
(1689, 'App\\Models\\User', 188),
(1689, 'App\\Models\\User', 189),
(1689, 'App\\Models\\User', 190),
(1689, 'App\\Models\\User', 191),
(1689, 'App\\Models\\User', 192),
(1689, 'App\\Models\\User', 193),
(1689, 'App\\Models\\User', 194),
(1689, 'App\\Models\\User', 195),
(1689, 'App\\Models\\User', 196),
(1689, 'App\\Models\\User', 197),
(1689, 'App\\Models\\User', 198),
(1689, 'App\\Models\\User', 199),
(1689, 'App\\Models\\User', 200),
(1689, 'App\\Models\\User', 201),
(1689, 'App\\Models\\User', 202),
(1689, 'App\\Models\\User', 203),
(1689, 'App\\Models\\User', 204),
(1689, 'App\\Models\\User', 205),
(1689, 'App\\Models\\User', 206),
(1689, 'App\\Models\\User', 207),
(1689, 'App\\Models\\User', 208),
(1689, 'App\\Models\\User', 209),
(1689, 'App\\Models\\User', 212),
(1689, 'App\\Models\\User', 213),
(1689, 'App\\Models\\User', 214),
(1689, 'App\\Models\\User', 215),
(1689, 'App\\Models\\User', 216),
(1689, 'App\\Models\\User', 217),
(1689, 'App\\Models\\User', 218),
(1689, 'App\\Models\\User', 219),
(1689, 'App\\Models\\User', 220),
(1689, 'App\\Models\\User', 221),
(1689, 'App\\Models\\User', 222),
(1689, 'App\\Models\\User', 223),
(1689, 'App\\Models\\User', 224),
(1689, 'App\\Models\\User', 225),
(1689, 'App\\Models\\User', 226),
(1689, 'App\\Models\\User', 227),
(1689, 'App\\Models\\User', 228),
(1689, 'App\\Models\\User', 229),
(1689, 'App\\Models\\User', 230),
(1689, 'App\\Models\\User', 231),
(1689, 'App\\Models\\User', 232),
(1689, 'App\\Models\\User', 233),
(1689, 'App\\Models\\User', 234),
(1689, 'App\\Models\\User', 235),
(1689, 'App\\Models\\User', 236),
(1689, 'App\\Models\\User', 237),
(1689, 'App\\Models\\User', 238),
(1689, 'App\\Models\\User', 239),
(1689, 'App\\Models\\User', 240),
(1689, 'App\\Models\\User', 241),
(1689, 'App\\Models\\User', 242),
(1689, 'App\\Models\\User', 254),
(1689, 'App\\Models\\User', 256),
(1689, 'App\\Models\\User', 257),
(1689, 'App\\Models\\User', 261),
(1690, 'App\\Models\\User', 38),
(1696, 'App\\Models\\User', 20),
(1696, 'App\\Models\\User', 23),
(1696, 'App\\Models\\User', 26),
(1696, 'App\\Models\\User', 210),
(1696, 'App\\Models\\User', 262),
(1697, 'App\\Models\\User', 20),
(1697, 'App\\Models\\User', 23),
(1697, 'App\\Models\\User', 210),
(1697, 'App\\Models\\User', 262),
(1698, 'App\\Models\\User', 20),
(1698, 'App\\Models\\User', 23),
(1698, 'App\\Models\\User', 262),
(1700, 'App\\Models\\User', 20),
(1700, 'App\\Models\\User', 23),
(1700, 'App\\Models\\User', 26),
(1700, 'App\\Models\\User', 210),
(1700, 'App\\Models\\User', 262),
(1702, 'App\\Models\\User', 20),
(1703, 'App\\Models\\User', 4),
(1703, 'App\\Models\\User', 5),
(1703, 'App\\Models\\User', 7),
(1703, 'App\\Models\\User', 8),
(1703, 'App\\Models\\User', 12),
(1703, 'App\\Models\\User', 13),
(1703, 'App\\Models\\User', 18),
(1703, 'App\\Models\\User', 19),
(1703, 'App\\Models\\User', 20),
(1703, 'App\\Models\\User', 21),
(1703, 'App\\Models\\User', 22),
(1703, 'App\\Models\\User', 23),
(1703, 'App\\Models\\User', 24),
(1703, 'App\\Models\\User', 25),
(1703, 'App\\Models\\User', 26),
(1703, 'App\\Models\\User', 27),
(1703, 'App\\Models\\User', 28),
(1703, 'App\\Models\\User', 29),
(1703, 'App\\Models\\User', 30),
(1703, 'App\\Models\\User', 31),
(1703, 'App\\Models\\User', 32),
(1703, 'App\\Models\\User', 33),
(1703, 'App\\Models\\User', 34),
(1703, 'App\\Models\\User', 35),
(1703, 'App\\Models\\User', 36),
(1703, 'App\\Models\\User', 37),
(1703, 'App\\Models\\User', 38),
(1703, 'App\\Models\\User', 39),
(1703, 'App\\Models\\User', 40),
(1703, 'App\\Models\\User', 41),
(1703, 'App\\Models\\User', 42),
(1703, 'App\\Models\\User', 43),
(1703, 'App\\Models\\User', 44),
(1703, 'App\\Models\\User', 45),
(1703, 'App\\Models\\User', 46),
(1703, 'App\\Models\\User', 47),
(1703, 'App\\Models\\User', 48),
(1703, 'App\\Models\\User', 49),
(1703, 'App\\Models\\User', 50),
(1703, 'App\\Models\\User', 51),
(1703, 'App\\Models\\User', 52),
(1703, 'App\\Models\\User', 53),
(1703, 'App\\Models\\User', 54),
(1703, 'App\\Models\\User', 55),
(1703, 'App\\Models\\User', 56),
(1703, 'App\\Models\\User', 57),
(1703, 'App\\Models\\User', 58),
(1703, 'App\\Models\\User', 59),
(1703, 'App\\Models\\User', 60),
(1703, 'App\\Models\\User', 62),
(1703, 'App\\Models\\User', 63),
(1703, 'App\\Models\\User', 64),
(1703, 'App\\Models\\User', 65),
(1703, 'App\\Models\\User', 66),
(1703, 'App\\Models\\User', 67),
(1703, 'App\\Models\\User', 68),
(1703, 'App\\Models\\User', 69),
(1703, 'App\\Models\\User', 71),
(1703, 'App\\Models\\User', 90),
(1703, 'App\\Models\\User', 104),
(1703, 'App\\Models\\User', 209),
(1703, 'App\\Models\\User', 210),
(1703, 'App\\Models\\User', 247),
(1703, 'App\\Models\\User', 248),
(1703, 'App\\Models\\User', 249),
(1703, 'App\\Models\\User', 250),
(1703, 'App\\Models\\User', 251),
(1703, 'App\\Models\\User', 255),
(1703, 'App\\Models\\User', 259),
(1703, 'App\\Models\\User', 260),
(1703, 'App\\Models\\User', 263),
(1704, 'App\\Models\\User', 4),
(1704, 'App\\Models\\User', 5),
(1704, 'App\\Models\\User', 7),
(1704, 'App\\Models\\User', 8),
(1704, 'App\\Models\\User', 18),
(1704, 'App\\Models\\User', 19),
(1704, 'App\\Models\\User', 20),
(1704, 'App\\Models\\User', 22),
(1704, 'App\\Models\\User', 23),
(1704, 'App\\Models\\User', 24),
(1704, 'App\\Models\\User', 25),
(1704, 'App\\Models\\User', 26),
(1704, 'App\\Models\\User', 27),
(1704, 'App\\Models\\User', 28),
(1704, 'App\\Models\\User', 29),
(1704, 'App\\Models\\User', 30),
(1704, 'App\\Models\\User', 31),
(1704, 'App\\Models\\User', 32),
(1704, 'App\\Models\\User', 33),
(1704, 'App\\Models\\User', 34),
(1704, 'App\\Models\\User', 35),
(1704, 'App\\Models\\User', 36),
(1704, 'App\\Models\\User', 37),
(1704, 'App\\Models\\User', 38),
(1704, 'App\\Models\\User', 39),
(1704, 'App\\Models\\User', 40),
(1704, 'App\\Models\\User', 41),
(1704, 'App\\Models\\User', 42),
(1704, 'App\\Models\\User', 43),
(1704, 'App\\Models\\User', 44),
(1704, 'App\\Models\\User', 45),
(1704, 'App\\Models\\User', 46),
(1704, 'App\\Models\\User', 47),
(1704, 'App\\Models\\User', 48),
(1704, 'App\\Models\\User', 49),
(1704, 'App\\Models\\User', 50),
(1704, 'App\\Models\\User', 51),
(1704, 'App\\Models\\User', 52),
(1704, 'App\\Models\\User', 53),
(1704, 'App\\Models\\User', 54),
(1704, 'App\\Models\\User', 55),
(1704, 'App\\Models\\User', 56),
(1704, 'App\\Models\\User', 57),
(1704, 'App\\Models\\User', 58),
(1704, 'App\\Models\\User', 59),
(1704, 'App\\Models\\User', 60),
(1704, 'App\\Models\\User', 62),
(1704, 'App\\Models\\User', 63),
(1704, 'App\\Models\\User', 64),
(1704, 'App\\Models\\User', 65),
(1704, 'App\\Models\\User', 66),
(1704, 'App\\Models\\User', 67),
(1704, 'App\\Models\\User', 68),
(1704, 'App\\Models\\User', 69),
(1704, 'App\\Models\\User', 71),
(1704, 'App\\Models\\User', 90),
(1704, 'App\\Models\\User', 104),
(1704, 'App\\Models\\User', 209),
(1704, 'App\\Models\\User', 210),
(1704, 'App\\Models\\User', 247),
(1704, 'App\\Models\\User', 248),
(1704, 'App\\Models\\User', 249),
(1704, 'App\\Models\\User', 250),
(1704, 'App\\Models\\User', 251),
(1704, 'App\\Models\\User', 255),
(1704, 'App\\Models\\User', 259),
(1704, 'App\\Models\\User', 260),
(1704, 'App\\Models\\User', 263),
(1706, 'App\\Models\\User', 32),
(1708, 'App\\Models\\User', 252),
(1709, 'App\\Models\\User', 5),
(1710, 'App\\Models\\User', 4),
(1710, 'App\\Models\\User', 7),
(1710, 'App\\Models\\User', 18),
(1710, 'App\\Models\\User', 19),
(1710, 'App\\Models\\User', 20),
(1710, 'App\\Models\\User', 21),
(1710, 'App\\Models\\User', 22),
(1710, 'App\\Models\\User', 23),
(1710, 'App\\Models\\User', 25),
(1710, 'App\\Models\\User', 26),
(1710, 'App\\Models\\User', 27),
(1710, 'App\\Models\\User', 28),
(1710, 'App\\Models\\User', 29),
(1710, 'App\\Models\\User', 30),
(1710, 'App\\Models\\User', 31),
(1710, 'App\\Models\\User', 32),
(1710, 'App\\Models\\User', 33),
(1710, 'App\\Models\\User', 34),
(1710, 'App\\Models\\User', 38),
(1710, 'App\\Models\\User', 255),
(1710, 'App\\Models\\User', 263),
(1711, 'App\\Models\\User', 20),
(1712, 'App\\Models\\User', 20);

-- --------------------------------------------------------

--
-- Table structure for table `mold`
--

CREATE TABLE `mold` (
  `id` int(11) NOT NULL,
  `no_mold` varchar(10) NOT NULL,
  `customer` varchar(40) NOT NULL,
  `molding_name` varchar(60) NOT NULL,
  `model` varchar(30) NOT NULL,
  `part_no` varchar(40) NOT NULL,
  `cavity` int(1) DEFAULT NULL,
  `mc_tonase` int(5) DEFAULT NULL,
  `dimensi` varchar(30) DEFAULT NULL,
  `weight` int(9) DEFAULT NULL,
  `ejector_stroke` int(6) DEFAULT NULL,
  `heater` int(6) DEFAULT NULL,
  `thermocouple` varchar(14) DEFAULT NULL,
  `material_resin` varchar(20) DEFAULT NULL,
  `radius_sprue_brush` varchar(15) DEFAULT NULL,
  `diameter_locatering` varchar(9) DEFAULT NULL,
  `mold_maker` varchar(40) DEFAULT NULL,
  `location` varchar(40) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `mold`
--

INSERT INTO `mold` (`id`, `no_mold`, `customer`, `molding_name`, `model`, `part_no`, `cavity`, `mc_tonase`, `dimensi`, `weight`, `ejector_stroke`, `heater`, `thermocouple`, `material_resin`, `radius_sprue_brush`, `diameter_locatering`, `mold_maker`, `location`, `created_at`, `updated_at`) VALUES
(3, 'ADM 01', 'PT ADM', 'RED LENS LAMP RR COMB R/L', 'F SERIES', '220-51459R/L', 2, 150, '350 X 500 X 335', 313, 40, 0, '-', 'ACRYPET', 'R 20', 'Ø 100', 'JUOKU', 'AJI', '2024-11-12 03:07:13', '2024-11-12 10:07:13'),
(4, 'ADM 02', 'PT ADM', 'YELLOW LENS RR COMB R/L', 'F SERIES', '220-51459AR/AL', 2, 150, '350 X 400 X 335', 251, 35, 0, '-', 'ACRYPET', 'R 20', 'Ø 100', 'JUOKU', 'AJI', '2024-11-12 03:07:13', '2024-11-12 10:07:13'),
(5, 'ADM 03', 'PT ADM', 'LENS ASSY RR COMB LH', 'F SERIES', '220-51459AL', 1, 150, '330 X 500 X 335', 368, 40, 0, '-', 'ACRYPET', 'R 20', 'Ø 100', 'JUOKU', 'AJI', '2024-11-12 03:07:13', '2024-11-12 10:07:13'),
(6, 'ADM 04', 'PT ADM', 'LENS ASSY RR COMB RH', 'F SERIES', '220-51459AR', 1, 150, '330 X 500 X 333', 294, 35, 0, '-', 'ACRYPET', 'R 20', 'Ø 100', 'JUOKU', 'AJI', '2024-11-12 03:07:13', '2024-11-12 10:07:13'),
(7, 'ADM 07', 'PT ADM', 'RED LENS ZEBRA', 'S89 ZEBRA', '220-51491R/L', 1, 150, '350 X 300 X 225', 127, 20, 0, '-', 'ACRYPET', 'R 20', 'Ø 100', 'JUOKU', 'AJI', '2024-11-12 03:07:13', '2024-11-12 10:07:13'),
(8, 'ADM 08', 'PT ADM', 'YELLOW LENS RR COMB R/L', 'S89 ZEBRA', '220-51491AR/AL', 2, 150, '300 X 350 X 317', 178, 40, 0, '-', 'ACRYPET', 'R 20', 'Ø 100', 'JUOKU', 'AJI', '2024-11-12 03:07:13', '2024-11-12 10:07:13'),
(9, 'ADM 09', 'PT ADM', 'LENS ASSY RR COMB LH', 'S89 ZEBRA', '220-51491AR/AL', 1, 150, '350 X 450 X 337', 284, 20, 0, '-', 'ACRYPET', 'R 20', 'Ø 100', 'JUOKU', 'AJI', '2024-11-12 03:07:13', '2024-11-12 10:07:13'),
(10, 'ADM 10', 'PT ADM', 'LENS ASSY RR COMB RH', 'S89 ZEBRA', '220-51491AR/AL', 1, 150, '350 X 450 X 337', 284, 25, 0, '-', 'ACRYPET', 'R 20', 'Ø 100', 'JUOKU', 'AJI', '2024-11-12 03:07:13', '2024-11-12 10:07:13'),
(11, 'ADM 28', 'PT ADM', 'BRACKET FOG LAMP RH/LH', 'D88', 'ADM-D88-BFLR-AAPI', 2, 150, '530 X 550 X 510', 812, 50, 4, 'TYPE J', 'PMA3323', 'R 20', 'Ø 100', 'JUOKU', 'AJI', '2024-11-12 03:07:13', '2024-11-12 10:07:13'),
(12, 'ADM 29', 'PT KTB', 'STOP CENTER LENS # 1', 'D01N', '13-0M43L', 2, 150, '520 X 400 X 450', 501, 30, 0, '-', 'PMA 4152R', 'R 20', 'Ø 100', 'JUOKU', 'AJI', '2024-11-12 03:07:13', '2024-11-12 10:07:13'),
(13, 'ADM 36', 'PT ADM', 'LENS RH/LH', 'D22D', '11-OG-33/34L', 2, 650, '880 X 650 X 900', 3290, 20, 14, 'TYPE J', 'PMA-CM11713CS', 'R 20', 'Ø 200', 'JUOKU', 'AJI', '2024-11-12 03:07:13', '2024-11-12 10:07:13'),
(14, 'ADM 37', 'PT ADM', 'HOUSING RH/LH', 'D22D', '11-OG-33/34B', 2, 1250, '850 X 720 X 876', 2871, 50, 4, 'TYPE J', 'ASA 9370', 'R 20', 'Ø 200', 'JUOKU', 'AJI', '2024-11-12 03:07:13', '2024-11-12 10:07:13'),
(15, 'ADM 38', 'PT ADM', 'REFLECTOR RH/LH', 'D22D', '11-OG-33/34B', 2, 1250, '700 X 660 X 650', 1582, 40, 1, 'TYPE J', 'PC-CM110F', 'R 20', 'Ø 200', 'JUOKU', 'AJI', '2024-11-12 03:07:13', '2024-11-12 10:07:13'),
(16, 'ADM 41', 'PT ADM', 'HOUSING RH/LH', 'D17D', '15-OG-37/38B', 2, 650, '600 X 595 X 750', 1434, 30, 2, 'TYPE J', 'ASA DC187D', 'R 20', 'Ø 200', 'JUOKU', 'AJI', '2024-11-12 03:07:14', '2024-11-12 10:07:14'),
(17, 'ADM 42', 'PT ADM', 'LENS RH/LH', 'D30D', '15-0G41/42 L', 2, 650, '652 X 670 X 560', 1892, 20, 11, 'TYPE J', 'PMA CM04302R', 'R 20', 'Ø 200', 'JUOKU', 'AJI', '2024-11-12 03:07:14', '2024-11-12 10:07:14'),
(18, 'ADM 43', 'PT ADM', 'HOUSING RH/LH', 'D30D', '15-0G41/42 B', 2, 650, '620 X670 X 600', 1594, 40, 1, 'TYPE J', 'ASA DC187D', 'R 20', 'Ø 200', 'JUOKU', 'AJI', '2024-11-12 03:07:14', '2024-11-12 10:07:14'),
(19, 'ADM 46', 'PT ADM', 'TAIL STOP LENS RH/LH', 'D37N', '11-0G45/46 L1', 2, 150, '370 X 560 X 375', 450, 20, 0, '-', 'PMA-CM4152R', 'R 20', 'Ø 100', 'JUOKU', 'AJI', '2024-11-12 03:07:14', '2024-11-12 10:07:14'),
(20, 'ADM 48', 'PT ADM', 'LENS', 'D39N', '29-0G47 L', 1, 150, '360 X 330 X 335', 235, 20, 0, '-', 'PC-GE92403R', 'R 20', 'Ø 100', 'JUOKU', 'AJI', '2024-11-12 03:07:14', '2024-11-12 10:07:14'),
(21, 'ADM 52', 'PT ADM', 'LENS ASSY RCL RH/LH', 'D21N/D06N', '11-0G43/44 L2', 2, 600, NULL, 2005, 20, 1, 'TYPE J', 'PMA-SM-4092R', 'R 20', 'Ø 100', 'JUOKU', 'AJI', '2024-11-12 03:07:14', '2024-11-12 10:07:14'),
(22, 'ADM 60', 'PT ADM', 'LENS STOP CENTER', 'D14N', '13-0G51L', 2, 160, '390 X 370 X 416', 359, 35, 0, '-', 'PMA SM-4332R', 'R 20', 'Ø 100', 'JUOKU', 'AJI', '2024-11-12 03:07:14', '2024-11-12 10:07:14'),
(23, 'ADM 67', 'PT ADM', 'LENS REFLEKTOR RH/LH', 'D13L', '45-0G51/52L *1', 2, 160, '455 X 370 X 420', 520, 25, 0, '-', 'PC RED', 'R 20', 'Ø 100', 'JUOKU', 'AJI', '2024-11-12 03:07:14', '2024-11-12 10:07:14'),
(24, 'ADM 74', 'PT ADM', 'LENS RCL RH/LH', 'D12L', '11-AT01/02L', 2, 1480, '1560 X 1020 X 1100', 9000, 50, 26, 'TYPE J', 'PMMA', 'R 20', 'Ø 200', 'JUOKU', 'AJI', '2024-11-12 03:07:14', '2024-11-12 10:07:14'),
(25, 'ADM 75', 'PT ADM', 'REFLEKTOR RCL RH/LH', 'D12L', '11-AT01/02R', 2, 1250, '900 X 900 X 915', 3600, 60, 2, 'TYPE J', 'PC', 'R 20', 'Ø 200', 'JUOKU', 'AJI', '2024-11-12 03:07:14', '2024-11-12 10:07:14'),
(26, 'ADM 77', 'PT ADM', 'LENS BDG RH/LH', 'D12L', '15-AT01/02L', 2, 650, '670 X 510 X 570', 1300, 60, 8, 'TYPE J', 'PMMA', 'R 20', 'Ø 200', 'JUOKU', 'AJI', '2024-11-12 03:07:14', '2024-11-12 10:07:14'),
(27, 'ADM 79', 'PT ADM', 'LENS REFLEKTOR ASSY REFLEX', 'D12L', '45-AT01L', 2, 150, '290 X 380 X 345', 200, 10, 2, 'TYPE J', 'PMA', 'R 20', 'Ø 100', 'JUOKU', 'AJI', '2024-11-12 03:07:14', '2024-11-12 10:07:14'),
(28, 'ADM 85', 'PT ADM', 'RED LENS RH/LH', 'D40L', '11-AT05/06L1 CP', 2, 210, '345 X 370 X 550', 360, 20, 0, '-', 'PMMA', 'R 20', 'Ø 100', 'JUOKU', 'AJI', '2024-11-12 03:07:14', '2024-11-12 10:07:14'),
(29, 'ADM 86', 'PT ADM', 'INNER LENS RH/LH', 'D40L', '11-AT05/06M', 2, 120, '370 X 270 X 410', 300, 15, 0, '-', 'PMMA NAT', 'R 20', 'Ø 100', 'JUOKU', 'AJI', '2024-11-12 03:07:14', '2024-11-12 10:07:14'),
(30, 'ADM 51', 'PT ADM', 'LENS CLEAR RCL RH/LH', 'D21N/D06N', '11-0G43/44 L1', 2, 300, NULL, 770, 20, 0, '-', 'PMA-SM-MH-NAT', 'R 20', 'Ø 100', 'JUOKU', 'AJI', '2024-11-12 03:07:14', '2024-11-12 10:07:14'),
(31, 'ADM 99', 'PT ADM', 'LENS RCL RH/LH', 'D26N', '11-AT11/12LCP', 2, 1400, '1600 X 1200 X1015', 9200, 20, 39, 'TYPE J', 'PMMA', 'R 20', 'Ø 250', 'JUOKU', 'AJI', '2024-11-12 03:07:14', '2024-11-12 10:07:14'),
(32, 'ADM 100', 'PT ADM', 'REFLEKTOR 1  RCL RH/LH', 'D26N', '11-AT11/12R1', 2, 450, '380 X 550 X 455', 600, 20, 2, 'TYPE J', 'PC-TJ0796G', 'R 20', 'Ø 100', 'JUOKU', 'AJI', '2024-11-12 03:07:14', '2024-11-12 10:07:14'),
(33, 'ADM 107', 'PT ADM', 'LENS BDG RH/LH', 'D26N', '15-AT11/12LCP', 2, 1850, '1470 X 910 X885', 5250, 20, 24, 'TYPE J', 'PMMA', 'R 20', 'Ø 250', 'JUOKU', 'AJI', '2024-11-12 03:07:14', '2024-11-12 10:07:14'),
(34, 'ADM 112', 'PT ADM', 'HOUSING BDG RH/LH', 'D26N', '15-AT11/12B', 2, 650, '660 X 730 X 650', 2200, 20, 5, 'TYPE J', 'ASA-LG935D', 'R 20', 'Ø 100', 'JUOKU', 'AJI', '2024-11-12 03:07:14', '2024-11-12 10:07:14'),
(35, 'ADM 113', 'PT ADM', 'LENS CBDG', 'D26N', '15-AT13 LCP', 2, 1850, '1600 X 1750 X 975', 14000, 20, 64, 'TYPE J', 'PMMA', 'R 20', 'Ø 250', 'JUOKU', 'AJI', '2024-11-12 03:07:14', '2024-11-12 10:07:14'),
(36, 'ADM 117', 'PT ADM', 'HOUSING CBDG', 'D26N', '15-AT13B', 1, 1250, '700 X 1500 X 795', 4500, 20, 10, 'TYPE J', 'ASA-LG935D', 'R 20', 'Ø 100', 'JUOKU', 'AJI', '2024-11-12 03:07:14', '2024-11-12 10:07:14'),
(37, 'ADM 118', 'PT ADM', 'LENS RCL RH/LH', 'D74A', '11-AT-15/16LCP', 2, 1850, '1440 X 1200 X 1050', 8064, 55, 40, 'TYPE J', 'PMMA', 'R 20', 'Ø 250', 'JUOKU', 'AJI', '2024-11-12 03:07:14', '2024-11-12 10:07:14'),
(38, 'ADM 119', 'PT ADM', 'HOUSING LOW RH/LH', 'D74A', '11-AT-15/16B1', 2, 1250, '950 X 650 X 935', 3622, 70, 5, 'TYPE J', 'PC', 'R 20', 'Ø 200', 'JUOKU', 'AJI', '2024-11-12 03:07:14', '2024-11-12 10:07:14'),
(39, 'ADM 120', 'PT ADM', 'LENS REFLEKTOR RH/LH', 'D28A', '45-AT19/20 LCP', 2, 160, '400 X 360 X 392', 276, 30, 0, '-', 'PC-GE92403R', 'R 20', 'Ø 100', 'JUOKU', 'AJI', '2024-11-12 03:07:14', '2024-11-12 10:07:14'),
(40, 'ADM 121', 'PT ADM', 'REAR FOG LAMP', 'D28A', '29-AT19L', 2, 160, '350 X 410 X 360', 316, 35, 2, 'TYPE J', 'PC', 'R 20', 'Ø 100', 'JUOKU', 'AJI', '2024-11-12 03:07:14', '2024-11-12 10:07:14'),
(41, 'TAM 03', 'PT TOYOTA', 'LENS DOME', '700A', '31-0G09L', 2, 150, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'JUOKU', 'AJI', '2024-11-12 03:34:54', '2024-11-12 10:34:54'),
(42, 'TAM 04', 'PT TOYOTA', 'HOUSING DOME #1', '700A', '31-0G09B', 2, 150, NULL, NULL, NULL, 0, '-', NULL, 'R 20', 'Ø 100', 'JUOKU', 'AJI', '2024-11-12 03:34:54', '2024-11-12 10:34:54'),
(43, 'TAM 06', 'PT TOYOTA', 'LENS REFLECTOR', '195A', '45-OT01/0L2', 2, 150, '370 X 350 X 345', 240, 15, 0, '-', 'PMMA', 'R 20', 'Ø 100', 'JUOKU', 'AJI', '2024-11-12 03:34:54', '2024-11-12 10:34:54'),
(44, 'TAM 07', 'PT TOYOTA', 'REFLEKTOR UPPER RH/LH', 'NAV 1', '15-OG 27/28 RS', 2, 150, '350 X 350 X 370', NULL, 55, 0, '-', 'PC', 'R 20', 'Ø 120', 'JUOKU', 'AJI', '2024-11-12 03:34:54', '2024-11-12 10:34:54'),
(45, 'TAM 08', 'PT TOYOTA', 'LENS UPPER RH/LH', 'NAV 1', '15-OG 27/28 L', 2, 150, '350 X 350 X 370', 243, 55, 0, '-', 'PMMA', 'R 20', 'Ø 100', 'JUOKU', 'AJI', '2024-11-12 03:34:54', '2024-11-12 10:34:54'),
(46, 'TAM 09', 'PT TOYOTA', 'HOUSING UPPER RH/LH', 'NAV 1', '15-OG 27/28 B', 2, 150, '360 X 330 X 365', NULL, 55, 0, '-', 'ABS UN160D', 'R 20', 'Ø 100', 'JUOKU', 'AJI', '2024-11-12 03:34:54', '2024-11-12 10:34:54'),
(47, 'TAM 10', 'PT TOYOTA', 'HOUSING LOWER RH/LH', 'NAV 1', '15-OG 29/30 B', 2, 150, '370 X 340 X 365', NULL, 55, 0, '-', 'ABS UN160D', 'R 20', 'Ø 100', 'JUOKU', 'AJI', '2024-11-12 03:34:54', '2024-11-12 10:34:54'),
(48, 'TAM 11', 'PT TOYOTA', 'REFLEKTOR LOWER RH/LH', 'NAV 1', '15-OG 29/30 RS', 2, 150, '350 X 350 X 360', NULL, 55, 0, '-', 'PC', 'R 20', 'Ø 100', 'JUOKU', 'AJI', '2024-11-12 03:34:54', '2024-11-12 10:34:54'),
(49, 'TAM 12', 'PT TOYOTA', 'LENS LOWER RH/LH', 'NAV 1', '15-OG 29/30 L', 2, 150, '350 X 350 X 355', 242, 55, 0, '-', 'PMMA', 'R 20', 'Ø 100', 'JUOKU', 'AJI', '2024-11-12 03:34:54', '2024-11-12 10:34:54'),
(50, 'TAM 14', 'PT TOYOTA', 'LENS REFLECTOR', '660A', '45-OG-25/26L', 2, 150, '350 X 400 X 225', 169, 30, 0, '-', 'PMMA', 'R 20', 'Ø 100', 'JUOKU', 'AJI', '2024-11-12 03:34:54', '2024-11-12 10:34:54'),
(51, 'TAM 16', 'PT TOYOTA', 'LENS REFLECTOR', '800A', '45-OG-35/36L', 2, 150, '330 X 300 X 350', 245, 28, 0, '-', 'PMMA', 'R 20', 'Ø 100', 'JUOKU', 'AJI', '2024-11-12 03:34:54', '2024-11-12 10:34:54'),
(52, 'TAM 17', 'PT TOYOTA', 'HOUSING DOME #2', '700A', '31-0G09B*2', 2, 150, NULL, NULL, NULL, 0, '-', 'POM', 'R 20', 'Ø 100', 'DAIJO', 'AJI', '2024-11-12 03:34:54', '2024-11-12 10:34:54'),
(53, 'TAM 18', 'PT TOYOTA', 'LENS REFLECTOR', '560B', '45-AY01/02L', 2, 150, '390 X 400 X 400', 380, 15, 0, '-', 'PMMA', 'R 20', 'Ø 100', 'JUOKU', 'AJI', '2024-11-12 03:34:54', '2024-11-12 10:34:54'),
(54, 'IAMI 03', 'PT IAMI', 'LENS RH/LH', '700P', '20-OG-39/40L', 2, 1250, '920 X 750 X 730', 2618, 25, 1, 'TYPE J', 'PC', 'R 20', 'Ø 200', 'JUOKU', 'AJI', '2024-11-12 03:34:54', '2024-11-12 10:34:54'),
(55, 'IAMI 05', 'PT IAMI', 'HOUSING RH/LH', '700P', '20-OG-39/40B', 2, 1250, '650 X1100 X 742', 3700, 50, 4, 'TYPE J', 'PP', 'R 20', 'Ø 200', 'JUOKU', 'AJI', '2024-11-12 03:34:54', '2024-11-12 10:34:54'),
(56, 'IAMI 06', 'PT IAMI', 'HOUSING RH/LH', 'VT 01', '20-0G 49/50B', 2, 1250, '890 X 1220 X 870', 6000, 50, 5, 'TYPE J', 'PP', 'R 20', 'Ø 200', 'JUOKU', 'AJI', '2024-11-12 03:34:54', '2024-11-12 10:34:54'),
(57, 'IAMI 07', 'PT IAMI', 'LENS RH/LH', 'VT 01', '20-0G 49/50L', 2, 1250, '1240 X 800 X 795', 4400, 40, 5, 'TYPE J', 'PC', 'R 20', 'Ø 200', 'JUOKU', 'AJI', '2024-11-12 03:34:54', '2024-11-12 10:34:54'),
(58, 'ISEKI 01', 'PT ISEKI', 'REFLECTOR TORIKA', '-', '20-ON25R', 1, 1250, '740 X 860 X 876', 2958, 40, 2, 'TYPE J', 'PP', 'R 20', 'Ø 200', 'JUOKU', 'AJI', '2024-11-12 03:34:54', '2024-11-12 10:34:54'),
(59, 'ISEKI 02', 'PT ISEKI', 'LENS TORIKA', '-', '20-ON25L', 1, 1250, '840 X 870 X 875', 2848, 60, 2, 'TYPE J', 'PC', 'R 20', 'Ø 200', 'JUOKU', 'AJI', '2024-11-12 03:34:54', '2024-11-12 10:34:54'),
(60, 'ISEKI 03', 'PT ISEKI', 'LENS YADIN', 'YADIN', '20-AN-47L', 1, 1250, '800 X 560 X 610', 968, 40, 2, 'TYPE J', 'PC', 'R 20', 'Ø 200', 'JUOKU', 'AJI', '2024-11-12 03:34:54', '2024-11-12 10:34:54'),
(61, 'ISEKI 04', 'PT ISEKI', 'HOUSING YADIN', 'YADIN', '20-AN-47B', 1, 650, '570 X 480 X 790', 1200, 60, 2, 'TYPE J', 'PC', 'R 20', 'Ø 200', 'JUOKU', 'AJI', '2024-11-12 03:34:54', '2024-11-12 10:34:54'),
(62, 'AHM 01', 'PT AHM', 'LENS # 1', 'KOJA', '90-AD01L', 2, 450, '520 X 700 X 685', 1750, 35, 2, 'TYPE J', 'PMA', 'R 20', 'Ø 100', 'JUOKU', 'AJI', '2024-11-12 03:34:54', '2024-11-12 10:34:54'),
(63, 'AHM 02', 'PT AHM', 'REFLEKTOR # 1', 'KOJA', '90-AD01R', 2, 450, '600 X 800 X 710', 1750, 40, 2, 'TYPE J', 'PC', 'R 20', 'Ø 100', 'JUOKU', 'AJI', '2024-11-12 03:34:54', '2024-11-12 10:34:54'),
(64, 'AHM 06', 'PT AHM', 'LENS # 2', 'KOJA', '90-AD01L-2', 2, 450, '520 X 700 X 685', 1750, 35, 2, 'TYPE J', 'PMA', 'R 20', 'Ø 100', 'JUOKU', 'AJI', '2024-11-12 03:34:54', '2024-11-12 10:34:54'),
(65, 'AHM 07', 'PT AHM', 'REFLEKTOR # 2', 'KOJA', '90-AD01R-2', 2, 450, '600 X 800 X 710', 1750, 40, 2, 'TYPE J', 'PC', 'R 20', 'Ø 100', 'JUOKU', 'AJI', '2024-11-12 03:34:54', '2024-11-12 10:34:54'),
(66, 'AHM 08', 'PT AHM', 'LENS RH/LH', 'K3VA', '92-AD05/06L', 2, 450, NULL, NULL, NULL, 0, '-', 'PMMA', 'R 20', 'Ø 100', 'YEON TECH', 'AJI', '2024-11-12 03:34:54', '2024-11-12 10:34:54'),
(67, 'AHM 14', 'PT AHM', 'REFLEKTOR HEAD LAMP', 'GJRA', '90-AD09R', 1, 450, '540 X 370 X 390', NULL, NULL, 2, 'TYPE J', 'PC-MA702395F', 'R 20', 'Ø 100', 'JUOKU', 'AJI', '2024-11-12 03:34:54', '2024-11-12 10:34:54'),
(68, 'AHM 15', 'PT AHM', 'EXTENTION HEAD LAMP', 'GJRA', '90-AD09RS', 1, 650, '550 X 460 X 480', 998, 30, 2, 'TYPE J', 'PC-MA901510D', 'R 20', 'Ø 100', 'JUOKU', 'AJI', '2024-11-12 03:34:54', '2024-11-12 10:34:54'),
(69, 'AHM 16', 'PT AHM', 'INNER LENS HEAD LAMP', 'GJRA', '90-AD09M', 1, 650, '550 X 450 X 571', 845, 55, 0, '-', 'PC- DIFFUSION white', 'R 20', 'Ø 100', 'DJM', 'AJI', '2024-11-12 03:34:54', '2024-11-12 10:34:54'),
(70, 'AHM 17', 'PT AHM', 'LENS HEAD LAMP', 'GJRA', '90-AD09L', 1, 650, '610 X 490 X 470', 1016, 25, 2, 'TYPE J', 'PC-TJ1225ZC', 'R 20', 'Ø 100', 'JUOKU', 'AJI', '2024-11-12 03:34:54', '2024-11-12 10:34:54'),
(71, 'AHM 21', 'PT AHM', 'INNER LENS TAIL LAMP', 'GJRA', '91-AD09M', 2, 160, '400 X 400 X 361', 370, 20, 0, '-', 'PC-GE92403R', 'R 20', 'Ø 100', 'DJM', 'AJI', '2024-11-12 03:34:54', '2024-11-12 10:34:54'),
(72, 'KBT 01', 'PT KBT', 'LENS  KUBOTA', 'RD 85', '90-AN01L', 1, 450, '530 X 520 X 560', 2300, 25, 3, 'TYPE J', 'PMMA', 'R 20', 'Ø 100', 'AMPA', 'AJI', '2024-11-12 03:34:54', '2024-11-12 10:34:54');

-- --------------------------------------------------------

--
-- Table structure for table `npp_aji_internal_schedules`
--

CREATE TABLE `npp_aji_internal_schedules` (
  `id` int(13) NOT NULL,
  `project_title` varchar(255) NOT NULL,
  `product` varchar(255) NOT NULL,
  `milestone` varchar(255) NOT NULL,
  `customer` varchar(255) NOT NULL,
  `event` varchar(60) NOT NULL,
  `detail_description` text NOT NULL,
  `pic` varchar(80) NOT NULL,
  `koordinasi` varchar(20) NOT NULL,
  `progress` int(3) DEFAULT NULL,
  `plan_start` datetime DEFAULT NULL,
  `plan_end` datetime DEFAULT NULL,
  `actual_start` datetime DEFAULT NULL,
  `actual_end` datetime DEFAULT NULL,
  `progress_by` varchar(100) DEFAULT NULL,
  `plan_start_by` varchar(100) DEFAULT NULL,
  `plan_end_by` varchar(100) DEFAULT NULL,
  `actual_start_by` varchar(100) DEFAULT NULL,
  `actual_end_by` varchar(100) DEFAULT NULL,
  `urgent` int(1) NOT NULL DEFAULT 1 COMMENT '1.normal\r\n2.urgent\r\n3.top urgent',
  `judge` int(1) DEFAULT NULL COMMENT '1: ok, 0: ng',
  `judge_by` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `npp_aji_internal_schedules`
--

INSERT INTO `npp_aji_internal_schedules` (`id`, `project_title`, `product`, `milestone`, `customer`, `event`, `detail_description`, `pic`, `koordinasi`, `progress`, `plan_start`, `plan_end`, `actual_start`, `actual_end`, `progress_by`, `plan_start_by`, `plan_end_by`, `actual_start_by`, `actual_end_by`, `urgent`, `judge`, `judge_by`, `updated_at`, `created_at`) VALUES
(1, 'K2V', 'Winker', 'Product Design', 'AHM', 'Project Kick-Off', 'Master Schedule', 'NPD', 'QA Team', NULL, '2024-04-08 00:00:00', '2024-04-12 00:00:00', '2025-07-31 00:00:00', NULL, NULL, NULL, NULL, 'ridwan.syarif@astra-juoku.com', NULL, 1, NULL, NULL, '2025-07-31 14:16:45', NULL),
(2, 'K2V', 'Winker', 'Product Design', 'AHM', 'Project Kick-Off', 'Project Document', 'NPD', 'Dev Team', NULL, '2024-04-08 00:00:00', '2024-04-12 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(3, 'K2V', 'Winker', 'Product Design', 'AHM', 'Project Kick-Off', 'Project Target', 'MKT', 'Testing Dept', NULL, '2024-04-08 00:00:00', '2024-04-12 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(4, 'K2V', 'Winker', 'Product Design', 'AHM', 'Early Stage Review', 'Internal Schedule', 'NPD', 'QA Team', NULL, '2024-04-08 00:00:00', '2024-04-12 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(5, 'K2V', 'Winker', 'Product Design', 'AHM', 'Early Stage Review', 'Supplier Product Draft Schedule', 'PUR', 'Dev Team', NULL, '2025-07-01 00:00:00', '2024-07-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(6, 'K2V', 'Winker', 'Product Design', 'AHM', 'Early Stage Review', 'Tooling Supplier Draft Schedule', 'PUR', 'Testing Dept', NULL, '2025-07-01 00:00:00', '2024-07-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(7, 'K2V', 'Winker', 'Product Design', 'AHM', 'Early Stage Review', 'Project Risk Assessment', 'NPD', 'QA Team', NULL, '2025-07-01 00:00:00', '2024-07-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(8, 'K2V', 'Winker', 'Product Design', 'AHM', 'Early Stage Review', 'Portal Update', 'NPD', 'Dev Team', NULL, '2025-07-01 00:00:00', '2024-07-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(9, 'K2V', 'Winker', 'Product Design', 'AHM', 'Early Stage Review', 'Design Data', 'RND', 'Testing Dept', NULL, '2025-07-01 00:00:00', '2024-07-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(10, 'K2V', 'Winker', 'Product Design', 'AHM', 'Product Design Review', 'DR Product 1', 'RND', 'Testing Dept', NULL, '2025-07-01 00:00:00', '2024-07-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(11, 'K2V', 'Winker', 'Product Design', 'AHM', 'Product Design Review', 'DR Product 2', 'RND', 'QA Team', NULL, '2024-08-01 00:00:00', '2024-08-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(12, 'K2V', 'Winker', 'Product Design', 'AHM', 'Product Design Review', 'Product Drawing', 'RND', 'Dev Team', NULL, '2024-10-01 00:00:00', '2024-10-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(13, 'K2V', 'Winker', 'Product Design', 'AHM', 'Product Design Review', 'Product Study', 'RND', 'Testing Dept', NULL, '2024-11-01 00:00:00', '2024-11-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(14, 'K2V', 'Winker', 'Product Design', 'AHM', 'Process Design Review', 'Process Study', 'EHS', 'Testing Dept', NULL, '2024-11-01 00:00:00', '2024-11-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(15, 'K2V', 'Winker', 'Product Design', 'AHM', 'Process Design Review', 'Tooling Spec', 'EXIM', 'Testing Dept', NULL, '2024-12-01 00:00:00', '2024-12-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(16, 'K2V', 'Winker', 'Product Design', 'AHM', 'Process Design Review', 'DR Tooling', 'EXIM', 'QA Team', NULL, '2024-12-01 00:00:00', '2024-12-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(17, 'K2V', 'Winker', 'Product Design', 'AHM', 'Process Design Review', 'DR Process', 'FA', 'Dev Team', NULL, '2024-12-01 00:00:00', '2024-12-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(18, 'K2V', 'Winker', 'Product Design', 'AHM', 'Process Design Review', 'Inspection Plan', 'QE', 'Testing Dept', NULL, '2024-12-01 00:00:00', '2024-12-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(19, 'K2V', 'Winker', 'Product Design', 'AHM', 'Part Supplier Selection', 'RFQ Supplier', 'PUR', 'QA Team', NULL, '2024-12-01 00:00:00', '2024-12-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(20, 'K2V', 'Winker', 'Product Design', 'AHM', 'Part Supplier Selection', 'Supplier Quotation', 'PUR', 'Dev Team', NULL, '2024-12-01 00:00:00', '2024-12-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(21, 'K2V', 'Winker', 'Product Design', 'AHM', 'Part Supplier Selection', 'Price comparison', 'PUR', 'Testing Dept', NULL, '2024-12-01 00:00:00', '2024-12-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(22, 'K2V', 'Winker', 'Product Design', 'AHM', 'Supplier Audit', 'QAV 1', 'PUR', 'QA Team', NULL, '2024-12-01 00:00:00', '2024-12-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(23, 'K2V', 'Winker', 'Product Design', 'AHM', 'Supplier Audit', 'SPTT1', 'PUR', 'Dev Team', NULL, '2024-12-01 00:00:00', '2024-12-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(24, 'K2V', 'Winker', 'Product Design', 'AHM', 'Part Supplier Selection', 'Supplier LOI', 'PUR', 'Testing Dept', NULL, '2024-12-01 00:00:00', '2024-12-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(25, 'K2V', 'Winker', 'Product Design', 'AHM', 'Tooling Supplier Selection', 'Supplier PR', 'QA', 'Dev Team', NULL, '2024-12-01 00:00:00', '2024-12-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(26, 'K2V', 'Winker', 'Product Design', 'AHM', 'Tooling Supplier Selection', 'RFQ Supplier', 'PUR', 'Testing Dept', NULL, '2024-12-01 00:00:00', '2024-12-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(27, 'K2V', 'Winker', 'Product Design', 'AHM', 'Tooling Supplier Selection', 'Supplier Quotation', 'PUR', 'QA Team', NULL, '2024-12-01 00:00:00', '2024-12-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(28, 'K2V', 'Winker', 'Product Design', 'AHM', 'Tooling Supplier Selection', 'Supplier PO', 'PUR', 'Dev Team', NULL, '2024-12-01 00:00:00', '2024-12-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(29, 'K2V', 'Winker', 'Product Design', 'AHM', 'Machine Preparation', 'Auto Machine Ordering', 'QA', 'Testing Dept', NULL, '2024-12-01 00:00:00', '2024-12-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(30, 'K2V', 'Winker', 'Product Design', 'AHM', 'Machine Preparation', 'Annealing Oven Machine Ordering', 'QE', 'QA Team', NULL, '2024-12-01 00:00:00', '2024-12-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(31, 'K2V', 'Winker', 'Product Design', 'AHM', 'Machine Preparation', 'Laser Marking Machine Ordering', 'QE', 'Dev Team', NULL, '2024-12-01 00:00:00', '2024-12-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(32, 'K2V', 'Winker', 'Product Design', 'AHM', 'Machine Preparation', 'CCD Machine Ordering', 'RND', 'Testing Dept', NULL, '2024-12-01 00:00:00', '2024-12-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(33, 'K2V', 'Winker', 'Product Design', 'AHM', 'Design Approval', 'Approval Drawing', 'RND', 'Dev Team', NULL, '2024-12-01 00:00:00', '2024-12-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(34, 'K2V', 'Winker', 'Product Design', 'AHM', 'Design Approval', '1st QA Meeting', 'NPD', 'Testing Dept', NULL, '2024-12-01 00:00:00', '2024-12-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(35, 'K2V', 'Winker', 'Tooling Manufacturing', 'AHM', 'Tooling Start', 'Approval Document', 'PEINJ', 'QA Team', NULL, '2025-01-08 00:00:00', '2025-01-12 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(36, 'K2V', 'Winker', 'Tooling Manufacturing', 'AHM', 'Tooling Start', 'Process Confirmation', 'MM', 'Dev Team', NULL, '2025-02-01 00:00:00', '2025-02-28 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(37, 'K2V', 'Winker', 'Tooling Manufacturing', 'AHM', 'Tooling Start', 'Drawing Sub-assy', 'RND', 'Testing Dept', NULL, '2025-02-01 00:00:00', '2025-02-28 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(38, 'K2V', 'Winker', 'Tooling Manufacturing', 'AHM', 'Tooling Progress', 'TPR Tooling', 'PE', 'QA Team', 100, '2025-02-01 00:00:00', '2025-02-28 00:00:00', '2025-07-31 00:00:00', '2025-07-31 02:00:02', 'I Made Wahyu Karma Yoga', NULL, NULL, 'made.wahyu@astra-juoku.com', NULL, 3, 1, 'Ridwan Syarif', '2025-07-31 13:54:33', NULL),
(39, 'K2V', 'Winker', 'Tooling Manufacturing', 'AHM', 'Tooling Progress', 'TPR Machine', 'PE', 'Dev Team', NULL, '2025-02-01 00:00:00', '2025-02-28 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(40, 'K2V', 'Winker', 'Tooling Manufacturing', 'AHM', 'Material Preparation', 'Material Lens (PMMA Clear)', 'NPD', 'Testing Dept', NULL, '2025-02-01 00:00:00', '2025-02-28 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(41, 'K2V', 'Winker', 'Tooling Manufacturing', 'AHM', 'Material Preparation', 'Material Housing (PMMA Black)', 'NPD', 'QA Team', NULL, '2025-02-01 00:00:00', '2025-02-28 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(42, 'K2V', 'Winker', 'Tooling Manufacturing', 'AHM', 'Material Preparation', 'Tapping Screw', 'NPD', 'Dev Team', NULL, '2025-03-01 00:00:00', '2025-03-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(43, 'K2V', 'Winker', 'Tooling Manufacturing', 'AHM', 'Material Preparation', 'Vent Cloth', 'NPD', 'Testing Dept', NULL, '2025-03-01 00:00:00', '2025-03-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(44, 'K2V', 'Winker', 'Tooling Manufacturing', 'AHM', 'Material Preparation', 'PCB', 'NPD', 'QA Team', NULL, '2025-03-01 00:00:00', '2025-03-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(45, 'K2V', 'Winker', 'Tooling Manufacturing', 'AHM', 'Material Preparation', 'Wire Assy', 'NPD', 'Dev Team', NULL, '2025-03-01 00:00:00', '2025-03-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(46, 'K2V', 'Winker', 'Tooling Manufacturing', 'AHM', 'Material Preparation', 'Insert Nut', 'NPD', 'Testing Dept', NULL, '2025-03-01 00:00:00', '2025-03-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(47, 'K2V', 'Winker', 'Tooling Manufacturing', 'AHM', 'Material Preparation', 'Housing S/A', 'NPD', 'QA Team', NULL, '2025-03-01 00:00:00', '2025-03-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(48, 'K2V', 'Winker', 'Tooling Manufacturing', 'AHM', 'Document for Supplier', 'Schedule', 'NPD', 'Dev Team', NULL, '2025-06-16 00:00:00', '2025-06-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(49, 'K2V', 'Winker', 'Tooling Manufacturing', 'AHM', 'Document for Supplier', 'Drawing', 'RND', 'Testing Dept', NULL, '2025-06-16 00:00:00', '2025-06-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(50, 'K2V', 'Winker', 'Tooling Manufacturing', 'AHM', 'Document for Supplier', 'Forecast', 'WH', 'Dev Team', NULL, '2025-06-16 00:00:00', '2025-06-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(51, 'K2V', 'Winker', 'Tooling Manufacturing', 'AHM', 'Maris System', 'Maris System', 'NPD', 'Testing Dept', NULL, '2025-06-16 00:00:00', '2025-07-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(52, 'K2V', 'Winker', 'Tooling Manufacturing', 'AHM', 'Supplier Document', 'PPAP', 'QE', 'QA Team', NULL, '2025-08-01 00:00:00', '2025-08-29 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(53, 'K2V', 'Winker', 'Tooling Manufacturing', 'AHM', 'Supplier Document', 'Packaging Standard', 'DEL', 'Dev Team', NULL, '2025-04-15 00:00:00', '2025-04-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(54, 'K2V', 'Winker', 'Tooling Manufacturing', 'AHM', 'Supplier Audit', 'SPTT2', 'PUR', 'Testing Dept', NULL, '2025-03-15 00:00:00', '2025-03-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(55, 'K2V', 'Winker', 'Tooling Manufacturing', 'AHM', 'Supplier Audit', 'SPTT3', 'PUR', 'QA Team', NULL, '2025-04-15 00:00:00', '2025-04-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(56, 'K2V', 'Winker', 'Tooling Manufacturing', 'AHM', 'Tooling Trial', 'T0', 'DEL', 'Dev Team', NULL, '2025-03-15 00:00:00', '2025-03-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(57, 'K2V', 'Winker', 'Tooling Manufacturing', 'AHM', 'Tooling Trial', 'T1', 'ASMBLI', 'Testing Dept', NULL, '2025-04-01 00:00:00', '2025-04-15 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(58, 'K2V', 'Winker', 'Tooling Manufacturing', 'AHM', 'Tooling Trial', 'T2', 'ASMBLI', 'QA Team', NULL, '2025-04-15 00:00:00', '2025-04-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(59, 'K2V', 'Winker', 'Tooling Manufacturing', 'AHM', 'Machine Trial', 'T0', 'MEINJ', 'Dev Team', NULL, '2025-03-15 00:00:00', '2025-03-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(60, 'K2V', 'Winker', 'Tooling Manufacturing', 'AHM', 'Machine Trial', 'T1', 'BNF', 'Testing Dept', NULL, '2025-04-01 00:00:00', '2025-04-15 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(61, 'K2V', 'Winker', 'Tooling Manufacturing', 'AHM', 'Machine Trial', 'T2', 'QC', 'Testing Dept', NULL, '2025-04-15 00:00:00', '2025-04-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(62, 'K2V', 'Winker', 'Tooling Manufacturing', 'AHM', 'Part Submition', 'T0 event', 'MKT', 'QA Team', NULL, '2025-05-15 00:00:00', '2025-05-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(63, 'K2V', 'Winker', 'Tooling Manufacturing', 'AHM', 'AJI PPAP', 'Quality Document', 'QE', 'Dev Team', NULL, '2025-05-01 00:00:00', '2025-05-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(64, 'K2V', 'Winker', 'Tooling Manufacturing', 'AHM', 'AJI PPAP', 'Engineering Document', 'QA', 'Testing Dept', NULL, '2025-05-01 00:00:00', '2025-05-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(65, 'K2V', 'Winker', 'Tooling Manufacturing', 'AHM', 'AJI PPAP', 'Design Document', 'RND', 'Dev Team', NULL, '2025-05-01 00:00:00', '2025-05-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(66, 'K2V', 'Winker', 'Tooling Manufacturing', 'AHM', 'Tooling Evaluation', 'Tooling Evaluation', 'QRO', 'Testing Dept', NULL, '2025-05-13 00:00:00', '2025-05-20 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(67, 'K2V', 'Winker', 'Tooling Manufacturing', 'AHM', 'Tooling Evaluation', '1,5 QA Meeting', 'NPD', 'Dev Team', NULL, '2025-05-20 00:00:00', '2025-05-23 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(68, 'K2V', 'Winker', 'Home Line Trial', 'AHM', 'Tooling Shipment', 'Mold Housing', 'INJ', 'Testing Dept', NULL, '2025-05-25 00:00:00', '2025-06-15 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(69, 'K2V', 'Winker', 'Home Line Trial', 'AHM', 'Tooling Shipment', 'Mold Lens', 'SUR', 'QA Team', NULL, '2025-05-25 00:00:00', '2025-06-15 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(70, 'K2V', 'Winker', 'Home Line Trial', 'AHM', 'Tooling Shipment', 'Machine Auto', 'IC', 'Dev Team', NULL, '2025-05-25 00:00:00', '2025-06-15 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(71, 'K2V', 'Winker', 'Home Line Trial', 'AHM', 'Tooling Shipment', 'Machine Hot Insert', 'PUR', 'Testing Dept', NULL, '2025-05-25 00:00:00', '2025-06-15 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(72, 'K2V', 'Winker', 'Home Line Trial', 'AHM', 'Tooling Shipment', 'Machine CCD', 'INC', 'Dev Team', NULL, '2025-09-08 00:00:00', '2025-09-12 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(73, 'K2V', 'Winker', 'Home Line Trial', 'AHM', 'Tooling Shipment', 'Machine Laser Marking', 'PA', 'Testing Dept', NULL, '2025-09-08 00:00:00', '2025-09-12 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(74, 'K2V', 'Winker', 'Home Line Trial', 'AHM', 'Tooling Shipment', 'Machine Annealing Oven', 'IT', 'QA Team', NULL, '2025-09-08 00:00:00', '2025-09-12 00:00:00', '2025-07-21 00:00:00', NULL, NULL, NULL, NULL, 'miqdad.amarullah@astra-juoku.com', NULL, 1, NULL, NULL, '2025-07-21 16:07:50', NULL),
(75, 'K2V', 'Winker', 'Home Line Trial', 'AHM', 'HLT1', 'Lens Injection', 'EXIM', 'Dev Team', NULL, '2025-06-16 00:00:00', '2025-07-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(76, 'K2V', 'Winker', 'Home Line Trial', 'AHM', 'HLT1', 'Housing Injection', 'RND', 'Testing Dept', NULL, '2025-06-16 00:00:00', '2025-07-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(77, 'K2V', 'Winker', 'Home Line Trial', 'AHM', 'HLT1', 'Hot Insert', 'RND', 'Testing Dept', NULL, '2025-06-16 00:00:00', '2025-07-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(78, 'K2V', 'Winker', 'Home Line Trial', 'AHM', 'HLT1', 'Wire Assembling (DEM)', 'IT', 'QA Team', NULL, '2025-06-16 00:00:00', '2025-07-30 00:00:00', '2025-07-21 00:00:00', NULL, NULL, NULL, NULL, 'miqdad.amarullah@astra-juoku.com', NULL, 2, NULL, NULL, '2025-07-21 16:11:23', NULL),
(79, 'K2V', 'Winker', 'Home Line Trial', 'AHM', 'HLT1', 'PCB Soldering & Screwing', 'EHS', 'Dev Team', NULL, '2025-06-16 00:00:00', '2025-07-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(80, 'K2V', 'Winker', 'Home Line Trial', 'AHM', 'HLT1', 'Winker Assy RH Auto Assembling', 'EHS', 'Testing Dept', NULL, '2025-06-16 00:00:00', '2025-07-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(81, 'K2V', 'Winker', 'Home Line Trial', 'AHM', 'HLT1', 'Winker Assy LH Auto Assembling', 'IT', 'Dev Team', NULL, '2025-06-16 00:00:00', '2025-07-30 00:00:00', '2025-07-29 00:00:00', NULL, NULL, NULL, NULL, 'miqdad.amarullah@astra-juoku.com', NULL, 2, NULL, NULL, '2025-07-29 07:14:52', NULL),
(82, 'K2V', 'Winker', 'Home Line Trial', 'AHM', 'HLT1', 'Winker Assy RH Manual Assembling', 'LA', 'Testing Dept', NULL, '2025-06-16 00:00:00', '2025-07-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(83, 'K2V', 'Winker', 'Home Line Trial', 'AHM', 'HLT1', 'Winker Assy LH Manual Assembling', 'EXIM', 'QA Team', NULL, '2025-06-16 00:00:00', '2025-07-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(84, 'K2V', 'Winker', 'Home Line Trial', 'AHM', 'Part Submition', 'PP1 event', 'MKT', 'Dev Team', NULL, '2025-06-16 00:00:00', '2025-06-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(85, 'K2V', 'Winker', 'Home Line Trial', 'AHM', 'System Update', 'Maris System', 'WH', 'Testing Dept', NULL, '2025-08-15 00:00:00', '2025-08-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(86, 'K2V', 'Winker', 'Home Line Trial', 'AHM', 'System Update', 'IMDS', 'QE', 'QA Team', NULL, '2025-09-01 00:00:00', '2025-09-15 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(87, 'K2V', 'Winker', 'Home Line Trial', 'AHM', 'HLT2', 'Winker Assy RH Auto Assembling', 'LA', 'Dev Team', NULL, '2025-08-01 00:00:00', '2025-08-29 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(88, 'K2V', 'Winker', 'Home Line Trial', 'AHM', 'HLT2', 'Winker Assy LH Auto Assembling', 'PPC', 'Testing Dept', NULL, '2025-08-01 00:00:00', '2025-08-29 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(89, 'K2V', 'Winker', 'Home Line Trial', 'AHM', 'HLT2', 'Winker Assy RH Manual Assembling', 'PPC', 'QA Team', NULL, '2025-08-01 00:00:00', '2025-08-29 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(90, 'K2V', 'Winker', 'Home Line Trial', 'AHM', 'HLT2', 'Winker Assy LH Manual Assembling', 'FA', 'Dev Team', NULL, '2025-08-01 00:00:00', '2025-08-29 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(91, 'K2V', 'Winker', 'Home Line Trial', 'AHM', 'HLT2', 'Hot Insert', 'PUR', 'Testing Dept', NULL, '2025-08-01 00:00:00', '2025-08-29 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(92, 'K2V', 'Winker', 'Home Line Trial', 'AHM', 'Part Submition', 'PP2 event', 'MKT', 'QA Team', NULL, '2025-09-29 00:00:00', '2025-09-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(93, 'K2V', 'Winker', 'Home Line Trial', 'AHM', 'Production Preparation', 'Document', 'INC', 'Dev Team', NULL, '2025-08-01 00:00:00', '2025-08-15 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(94, 'K2V', 'Winker', 'Home Line Trial', 'AHM', 'Production Preparation', 'Limit Sample', 'QE', 'Testing Dept', NULL, '2025-08-15 00:00:00', '2025-08-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(95, 'K2V', 'Winker', 'Home Line Trial', 'AHM', 'Production Preparation', 'Packaging Standard', 'DEL', 'QA Team', NULL, '2025-07-21 00:00:00', '2025-08-15 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(96, 'K2V', 'Winker', 'Home Line Trial', 'AHM', 'Production Preparation', 'Chuter', 'ASMBLI', 'Dev Team', NULL, '2025-07-21 00:00:00', '2025-08-15 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(97, 'K2V', 'Winker', 'Home Line Trial', 'AHM', 'Production Preparation', 'WH area', 'WH', 'Testing Dept', NULL, '2025-07-21 00:00:00', '2025-08-15 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(98, 'K2V', 'Winker', 'Home Line Trial', 'AHM', 'Production Preparation', 'MP preparation', 'PROD', 'Dev Team', NULL, '2025-06-04 00:00:00', '2025-08-15 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(99, 'K2V', 'Winker', 'Home Line Trial', 'AHM', 'Supplier Audit', 'SPTT4', 'PUR', 'Testing Dept', NULL, '2025-08-01 00:00:00', '2025-08-15 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(100, 'K2V', 'Winker', 'Home Line Trial', 'AHM', 'Supplier Approval', 'QAV2', 'PUR', 'QA Team', NULL, '2025-08-15 00:00:00', '2025-08-29 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(101, 'K2V', 'Winker', 'Home Line Trial', 'AHM', 'Testing', 'Part Preparation', 'NPD', 'Dev Team', NULL, '2025-05-27 00:00:00', '2025-06-04 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(102, 'K2V', 'Winker', 'Home Line Trial', 'AHM', 'Testing', 'Material test', 'NPD', 'Testing Dept', NULL, '2025-08-01 00:00:00', '2025-08-29 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(103, 'K2V', 'Winker', 'Home Line Trial', 'AHM', 'Testing', 'Testing', 'QE', 'Testing Dept', NULL, '2025-06-04 00:00:00', '2025-09-15 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(104, 'K2V', 'Winker', 'Home Line Trial', 'AHM', 'Material Preparation', 'Vent Cloth', 'WH', 'Dev Team', NULL, '2025-08-29 00:00:00', '2025-09-26 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(105, 'K2V', 'Winker', 'Home Line Trial', 'AHM', 'Material Preparation', 'Lens', 'WH', 'Testing Dept', NULL, '2025-08-29 00:00:00', '2025-09-26 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(106, 'K2V', 'Winker', 'Home Line Trial', 'AHM', 'Material Preparation', 'Housing S/A', 'WH', 'QA Team', NULL, '2025-08-29 00:00:00', '2025-10-03 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(107, 'K2V', 'Winker', 'Home Line Trial', 'AHM', 'HLT3', 'Winker Assy RH Auto Assembling', 'PPC', 'Dev Team', NULL, '2025-10-06 00:00:00', '2025-10-10 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(108, 'K2V', 'Winker', 'Home Line Trial', 'AHM', 'HLT3', 'Winker Assy LH Auto Assembling', 'PPC', 'Testing Dept', NULL, '2025-10-06 00:00:00', '2025-10-10 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(109, 'K2V', 'Winker', 'Home Line Trial', 'AHM', 'HLT3', 'Winker Assy RH Manual Assembling', 'PPC', 'QA Team', NULL, '2025-10-13 00:00:00', '2025-10-17 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(110, 'K2V', 'Winker', 'Home Line Trial', 'AHM', 'HLT3', 'Winker Assy LH Manual Assembling', 'PPC', 'Dev Team', NULL, '2025-10-13 00:00:00', '2025-10-17 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(111, 'K2V', 'Winker', 'Home Line Trial', 'AHM', 'HLT3', 'Hot Insert', 'PPC', 'Testing Dept', NULL, '2025-09-15 00:00:00', '2025-09-19 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(112, 'K2V', 'Winker', 'Home Line Trial', 'AHM', 'Mass-pro Preparation Evaluation', '2nd QA Meeting', 'NPD', 'QA Team', NULL, '2025-10-20 00:00:00', '2025-10-28 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(113, 'K2V v1', 'Winker v1', 'Product Design', 'AHM', 'Project Kick-Off', 'Master Schedule', 'IT', 'QA Team', 100, '2024-04-08 00:00:00', '2024-04-12 00:00:00', '2025-07-22 00:00:00', '2025-08-01 10:11:35', 'Miqdad Agil Amarullah', NULL, NULL, 'miqdad.amarullah@astra-juoku.com', NULL, 1, NULL, NULL, '2025-07-22 08:35:46', NULL),
(114, 'K2V v1', 'Winker v1', 'Product Design', 'AHM', 'Project Kick-Off', 'Project Document', 'NPD', 'Dev Team', NULL, '2024-04-08 00:00:00', '2024-04-12 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(115, 'K2V v1', 'Winker v1', 'Product Design', 'AHM', 'Project Kick-Off', 'Project Target', 'MKT', 'Testing Dept', NULL, '2024-04-08 00:00:00', '2024-04-12 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(116, 'K2V v1', 'Winker v1', 'Product Design', 'AHM', 'Early Stage Review', 'Internal Schedule', 'NPD', 'QA Team', NULL, '2024-04-08 00:00:00', '2024-04-12 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(117, 'K2V v1', 'Winker v1', 'Product Design', 'AHM', 'Early Stage Review', 'Supplier Product Draft Schedule', 'PUR', 'Dev Team', NULL, '2025-07-01 00:00:00', '2024-07-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(118, 'K2V v1', 'Winker v1', 'Product Design', 'AHM', 'Early Stage Review', 'Tooling Supplier Draft Schedule', 'PUR', 'Testing Dept', NULL, '2025-07-01 00:00:00', '2024-07-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(119, 'K2V v1', 'Winker v1', 'Product Design', 'AHM', 'Early Stage Review', 'Project Risk Assessment', 'NPD', 'QA Team', NULL, '2025-07-01 00:00:00', '2024-07-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(120, 'K2V v1', 'Winker v1', 'Product Design', 'AHM', 'Early Stage Review', 'Portal Update', 'NPD', 'Dev Team', NULL, '2025-07-01 00:00:00', '2024-07-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(121, 'K2V v1', 'Winker v1', 'Product Design', 'AHM', 'Early Stage Review', 'Design Data', 'RND', 'Testing Dept', NULL, '2025-07-01 00:00:00', '2024-07-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(122, 'K2V v1', 'Winker v1', 'Product Design', 'AHM', 'Product Design Review', 'DR Product 1', 'RND', 'Testing Dept', NULL, '2025-07-01 00:00:00', '2024-07-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(123, 'K2V v1', 'Winker v1', 'Product Design', 'AHM', 'Product Design Review', 'DR Product 2', 'RND', 'QA Team', NULL, '2024-08-01 00:00:00', '2024-08-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(124, 'K2V v1', 'Winker v1', 'Product Design', 'AHM', 'Product Design Review', 'Product Drawing', 'RND', 'Dev Team', NULL, '2024-10-01 00:00:00', '2024-10-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(125, 'K2V v1', 'Winker v1', 'Product Design', 'AHM', 'Product Design Review', 'Product Study', 'RND', 'Testing Dept', NULL, '2024-11-01 00:00:00', '2024-11-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(126, 'K2V v1', 'Winker v1', 'Product Design', 'AHM', 'Process Design Review', 'Process Study', 'PCE', 'Testing Dept', NULL, '2024-11-01 00:00:00', '2024-11-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(127, 'K2V v1', 'Winker v1', 'Product Design', 'AHM', 'Process Design Review', 'Tooling Spec', 'PCE', 'Testing Dept', NULL, '2024-12-01 00:00:00', '2024-12-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(128, 'K2V v1', 'Winker v1', 'Product Design', 'AHM', 'Process Design Review', 'DR Tooling', 'PCE', 'QA Team', NULL, '2024-12-01 00:00:00', '2024-12-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(129, 'K2V v1', 'Winker v1', 'Product Design', 'AHM', 'Process Design Review', 'DR Process', 'PCE', 'Dev Team', NULL, '2024-12-01 00:00:00', '2024-12-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(130, 'K2V v1', 'Winker v1', 'Product Design', 'AHM', 'Process Design Review', 'Inspection Plan', 'QE', 'Testing Dept', NULL, '2024-12-01 00:00:00', '2024-12-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(131, 'K2V v1', 'Winker v1', 'Product Design', 'AHM', 'Part Supplier Selection', 'RFQ Supplier', 'PUR', 'QA Team', NULL, '2024-12-01 00:00:00', '2024-12-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(132, 'K2V v1', 'Winker v1', 'Product Design', 'AHM', 'Part Supplier Selection', 'Supplier Quotation', 'PUR', 'Dev Team', NULL, '2024-12-01 00:00:00', '2024-12-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(133, 'K2V v1', 'Winker v1', 'Product Design', 'AHM', 'Part Supplier Selection', 'Price comparison', 'PUR', 'Testing Dept', NULL, '2024-12-01 00:00:00', '2024-12-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(134, 'K2V v1', 'Winker v1', 'Product Design', 'AHM', 'Supplier Audit', 'QAV 1', 'PUR', 'QA Team', NULL, '2024-12-01 00:00:00', '2024-12-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(135, 'K2V v1', 'Winker v1', 'Product Design', 'AHM', 'Supplier Audit', 'SPTT1', 'PUR', 'Dev Team', NULL, '2024-12-01 00:00:00', '2024-12-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(136, 'K2V v1', 'Winker v1', 'Product Design', 'AHM', 'Part Supplier Selection', 'Supplier LOI', 'PUR', 'Testing Dept', NULL, '2024-12-01 00:00:00', '2024-12-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(137, 'K2V v1', 'Winker v1', 'Product Design', 'AHM', 'Tooling Supplier Selection', 'Supplier PR', 'PCE', 'Dev Team', NULL, '2024-12-01 00:00:00', '2024-12-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(138, 'K2V v1', 'Winker v1', 'Product Design', 'AHM', 'Tooling Supplier Selection', 'RFQ Supplier', 'PUR', 'Testing Dept', NULL, '2024-12-01 00:00:00', '2024-12-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(139, 'K2V v1', 'Winker v1', 'Product Design', 'AHM', 'Tooling Supplier Selection', 'Supplier Quotation', 'PUR', 'QA Team', NULL, '2024-12-01 00:00:00', '2024-12-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(140, 'K2V v1', 'Winker v1', 'Product Design', 'AHM', 'Tooling Supplier Selection', 'Supplier PO', 'PUR', 'Dev Team', NULL, '2024-12-01 00:00:00', '2024-12-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(141, 'K2V v1', 'Winker v1', 'Product Design', 'AHM', 'Machine Preparation', 'Auto Machine Ordering', 'PCE', 'Testing Dept', NULL, '2024-12-01 00:00:00', '2024-12-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(142, 'K2V v1', 'Winker v1', 'Product Design', 'AHM', 'Machine Preparation', 'Annealing Oven Machine Ordering', 'PCE', 'QA Team', NULL, '2024-12-01 00:00:00', '2024-12-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(143, 'K2V v1', 'Winker v1', 'Product Design', 'AHM', 'Machine Preparation', 'Laser Marking Machine Ordering', 'PCE', 'Dev Team', NULL, '2024-12-01 00:00:00', '2024-12-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(144, 'K2V v1', 'Winker v1', 'Product Design', 'AHM', 'Machine Preparation', 'CCD Machine Ordering', 'PCE', 'Testing Dept', NULL, '2024-12-01 00:00:00', '2024-12-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(145, 'K2V v1', 'Winker v1', 'Product Design', 'AHM', 'Design Approval', 'Approval Drawing', 'RND', 'Dev Team', NULL, '2024-12-01 00:00:00', '2024-12-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(146, 'K2V v1', 'Winker v1', 'Product Design', 'AHM', 'Design Approval', '1st QA Meeting', 'NPD', 'Testing Dept', NULL, '2024-12-01 00:00:00', '2024-12-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(147, 'K2V v1', 'Winker v1', 'Tooling Manufacturing', 'AHM', 'Tooling Start', 'Approval Document', 'PCE', 'QA Team', NULL, '2025-01-08 00:00:00', '2025-01-12 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(148, 'K2V v1', 'Winker v1', 'Tooling Manufacturing', 'AHM', 'Tooling Start', 'Process Confirmation', 'PCE', 'Dev Team', NULL, '2025-02-01 00:00:00', '2025-02-28 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(149, 'K2V v1', 'Winker v1', 'Tooling Manufacturing', 'AHM', 'Tooling Start', 'Drawing Sub-assy', 'RND', 'Testing Dept', NULL, '2025-02-01 00:00:00', '2025-02-28 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(150, 'K2V v1', 'Winker v1', 'Tooling Manufacturing', 'AHM', 'Tooling Progress', 'TPR Tooling', 'PCE', 'QA Team', NULL, '2025-02-01 00:00:00', '2025-02-28 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(151, 'K2V v1', 'Winker v1', 'Tooling Manufacturing', 'AHM', 'Tooling Progress', 'TPR Machine', 'PCE', 'Dev Team', NULL, '2025-02-01 00:00:00', '2025-02-28 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(152, 'K2V v1', 'Winker v1', 'Tooling Manufacturing', 'AHM', 'Material Preparation', 'Material Lens (PMMA Clear)', 'NPD', 'Testing Dept', NULL, '2025-02-01 00:00:00', '2025-02-28 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(153, 'K2V v1', 'Winker v1', 'Tooling Manufacturing', 'AHM', 'Material Preparation', 'Material Housing (PMMA Black)', 'NPD', 'QA Team', NULL, '2025-02-01 00:00:00', '2025-02-28 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(154, 'K2V v1', 'Winker v1', 'Tooling Manufacturing', 'AHM', 'Material Preparation', 'Tapping Screw', 'NPD', 'Dev Team', NULL, '2025-03-01 00:00:00', '2025-03-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(155, 'K2V v1', 'Winker v1', 'Tooling Manufacturing', 'AHM', 'Material Preparation', 'Vent Cloth', 'NPD', 'Testing Dept', NULL, '2025-03-01 00:00:00', '2025-03-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(156, 'K2V v1', 'Winker v1', 'Tooling Manufacturing', 'AHM', 'Material Preparation', 'PCB', 'NPD', 'QA Team', NULL, '2025-03-01 00:00:00', '2025-03-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(157, 'K2V v1', 'Winker v1', 'Tooling Manufacturing', 'AHM', 'Material Preparation', 'Wire Assy', 'NPD', 'Dev Team', NULL, '2025-03-01 00:00:00', '2025-03-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(158, 'K2V v1', 'Winker v1', 'Tooling Manufacturing', 'AHM', 'Material Preparation', 'Insert Nut', 'NPD', 'Testing Dept', NULL, '2025-03-01 00:00:00', '2025-03-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(159, 'K2V v1', 'Winker v1', 'Tooling Manufacturing', 'AHM', 'Material Preparation', 'Housing S/A', 'NPD', 'QA Team', NULL, '2025-03-01 00:00:00', '2025-03-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(160, 'K2V v1', 'Winker v1', 'Tooling Manufacturing', 'AHM', 'Document for Supplier', 'Schedule', 'NPD', 'Dev Team', NULL, '2025-06-16 00:00:00', '2025-06-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(161, 'K2V v1', 'Winker v1', 'Tooling Manufacturing', 'AHM', 'Document for Supplier', 'Drawing', 'RND', 'Testing Dept', NULL, '2025-06-16 00:00:00', '2025-06-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(162, 'K2V v1', 'Winker v1', 'Tooling Manufacturing', 'AHM', 'Document for Supplier', 'Forecast', 'WH', 'Dev Team', NULL, '2025-06-16 00:00:00', '2025-06-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(163, 'K2V v1', 'Winker v1', 'Tooling Manufacturing', 'AHM', 'Maris System', 'Maris System', 'NPD', 'Testing Dept', NULL, '2025-06-16 00:00:00', '2025-07-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(164, 'K2V v1', 'Winker v1', 'Tooling Manufacturing', 'AHM', 'Supplier Document', 'PPAP', 'QE', 'QA Team', NULL, '2025-08-01 00:00:00', '2025-08-29 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(165, 'K2V v1', 'Winker v1', 'Tooling Manufacturing', 'AHM', 'Supplier Document', 'Packaging Standard', 'PCE', 'Dev Team', NULL, '2025-04-15 00:00:00', '2025-04-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(166, 'K2V v1', 'Winker v1', 'Tooling Manufacturing', 'AHM', 'Supplier Audit', 'SPTT2', 'PUR', 'Testing Dept', NULL, '2025-03-15 00:00:00', '2025-03-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(167, 'K2V v1', 'Winker v1', 'Tooling Manufacturing', 'AHM', 'Supplier Audit', 'SPTT3', 'PUR', 'QA Team', NULL, '2025-04-15 00:00:00', '2025-04-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(168, 'K2V v1', 'Winker v1', 'Tooling Manufacturing', 'AHM', 'Tooling Trial', 'T0', 'PCE', 'Dev Team', NULL, '2025-03-15 00:00:00', '2025-03-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(169, 'K2V v1', 'Winker v1', 'Tooling Manufacturing', 'AHM', 'Tooling Trial', 'T1', 'PCE', 'Testing Dept', NULL, '2025-04-01 00:00:00', '2025-04-15 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(170, 'K2V v1', 'Winker v1', 'Tooling Manufacturing', 'AHM', 'Tooling Trial', 'T2', 'PCE', 'QA Team', NULL, '2025-04-15 00:00:00', '2025-04-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(171, 'K2V v1', 'Winker v1', 'Tooling Manufacturing', 'AHM', 'Machine Trial', 'T0', 'PCE', 'Dev Team', NULL, '2025-03-15 00:00:00', '2025-03-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(172, 'K2V v1', 'Winker v1', 'Tooling Manufacturing', 'AHM', 'Machine Trial', 'T1', 'PCE', 'Testing Dept', NULL, '2025-04-01 00:00:00', '2025-04-15 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(173, 'K2V v1', 'Winker v1', 'Tooling Manufacturing', 'AHM', 'Machine Trial', 'T2', 'PCE', 'Testing Dept', NULL, '2025-04-15 00:00:00', '2025-04-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(174, 'K2V v1', 'Winker v1', 'Tooling Manufacturing', 'AHM', 'Part Submition', 'T0 event', 'MKT', 'QA Team', NULL, '2025-05-15 00:00:00', '2025-05-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(175, 'K2V v1', 'Winker v1', 'Tooling Manufacturing', 'AHM', 'AJI PPAP', 'Quality Document', 'QE', 'Dev Team', NULL, '2025-05-01 00:00:00', '2025-05-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(176, 'K2V v1', 'Winker v1', 'Tooling Manufacturing', 'AHM', 'AJI PPAP', 'Engineering Document', 'PCE', 'Testing Dept', NULL, '2025-05-01 00:00:00', '2025-05-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(177, 'K2V v1', 'Winker v1', 'Tooling Manufacturing', 'AHM', 'AJI PPAP', 'Design Document', 'RND', 'Dev Team', NULL, '2025-05-01 00:00:00', '2025-05-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(178, 'K2V v1', 'Winker v1', 'Tooling Manufacturing', 'AHM', 'Tooling Evaluation', 'Tooling Evaluation', 'PCE', 'Testing Dept', NULL, '2025-05-13 00:00:00', '2025-05-20 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(179, 'K2V v1', 'Winker v1', 'Tooling Manufacturing', 'AHM', 'Tooling Evaluation', '1,5 QA Meeting', 'NPD', 'Dev Team', NULL, '2025-05-20 00:00:00', '2025-05-23 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(180, 'K2V v1', 'Winker v1', 'Home Line Trial', 'AHM', 'Tooling Shipment', 'Mold Housing', 'PCE', 'Testing Dept', NULL, '2025-05-25 00:00:00', '2025-06-15 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(181, 'K2V v1', 'Winker v1', 'Home Line Trial', 'AHM', 'Tooling Shipment', 'Mold Lens', 'PCE', 'QA Team', NULL, '2025-05-25 00:00:00', '2025-06-15 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(182, 'K2V v1', 'Winker v1', 'Home Line Trial', 'AHM', 'Tooling Shipment', 'Machine Auto', 'PCE', 'Dev Team', NULL, '2025-05-25 00:00:00', '2025-06-15 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(183, 'K2V v1', 'Winker v1', 'Home Line Trial', 'AHM', 'Tooling Shipment', 'Machine Hot Insert', 'PCE', 'Testing Dept', NULL, '2025-05-25 00:00:00', '2025-06-15 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(184, 'K2V v1', 'Winker v1', 'Home Line Trial', 'AHM', 'Tooling Shipment', 'Machine CCD', 'PCE', 'Dev Team', NULL, '2025-09-08 00:00:00', '2025-09-12 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(185, 'K2V v1', 'Winker v1', 'Home Line Trial', 'AHM', 'Tooling Shipment', 'Machine Laser Marking', 'PCE', 'Testing Dept', NULL, '2025-09-08 00:00:00', '2025-09-12 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(186, 'K2V v1', 'Winker v1', 'Home Line Trial', 'AHM', 'Tooling Shipment', 'Machine Annealing Oven', 'PCE', 'QA Team', NULL, '2025-09-08 00:00:00', '2025-09-12 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(187, 'K2V v1', 'Winker v1', 'Home Line Trial', 'AHM', 'HLT1', 'Lens Injection', 'PCE', 'Dev Team', NULL, '2025-06-16 00:00:00', '2025-07-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(188, 'K2V v1', 'Winker v1', 'Home Line Trial', 'AHM', 'HLT1', 'Housing Injection', 'PCE', 'Testing Dept', NULL, '2025-06-16 00:00:00', '2025-07-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(189, 'K2V v1', 'Winker v1', 'Home Line Trial', 'AHM', 'HLT1', 'Hot Insert', 'PCE', 'Testing Dept', NULL, '2025-06-16 00:00:00', '2025-07-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(190, 'K2V v1', 'Winker v1', 'Home Line Trial', 'AHM', 'HLT1', 'Wire Assembling (DEM)', 'PCE', 'QA Team', NULL, '2025-06-16 00:00:00', '2025-07-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(191, 'K2V v1', 'Winker v1', 'Home Line Trial', 'AHM', 'HLT1', 'PCB Soldering & Screwing', 'PCE', 'Dev Team', NULL, '2025-06-16 00:00:00', '2025-07-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(192, 'K2V v1', 'Winker v1', 'Home Line Trial', 'AHM', 'HLT1', 'Winker Assy RH Auto Assembling', 'PCE', 'Testing Dept', NULL, '2025-06-16 00:00:00', '2025-07-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(193, 'K2V v1', 'Winker v1', 'Home Line Trial', 'AHM', 'HLT1', 'Winker Assy LH Auto Assembling', 'PCE', 'Dev Team', NULL, '2025-06-16 00:00:00', '2025-07-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(194, 'K2V v1', 'Winker v1', 'Home Line Trial', 'AHM', 'HLT1', 'Winker Assy RH Manual Assembling', 'PCE', 'Testing Dept', NULL, '2025-06-16 00:00:00', '2025-07-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(195, 'K2V v1', 'Winker v1', 'Home Line Trial', 'AHM', 'HLT1', 'Winker Assy LH Manual Assembling', 'PCE', 'QA Team', NULL, '2025-06-16 00:00:00', '2025-07-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(196, 'K2V v1', 'Winker v1', 'Home Line Trial', 'AHM', 'Part Submition', 'PP1 event', 'MKT', 'Dev Team', NULL, '2025-06-16 00:00:00', '2025-06-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(197, 'K2V v1', 'Winker v1', 'Home Line Trial', 'AHM', 'System Update', 'Maris System', 'WH', 'Testing Dept', NULL, '2025-08-15 00:00:00', '2025-08-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(198, 'K2V v1', 'Winker v1', 'Home Line Trial', 'AHM', 'System Update', 'IMDS', 'QE', 'QA Team', NULL, '2025-09-01 00:00:00', '2025-09-15 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(199, 'K2V v1', 'Winker v1', 'Home Line Trial', 'AHM', 'HLT2', 'Winker Assy RH Auto Assembling', 'PCE', 'Dev Team', NULL, '2025-08-01 00:00:00', '2025-08-29 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(200, 'K2V v1', 'Winker v1', 'Home Line Trial', 'AHM', 'HLT2', 'Winker Assy LH Auto Assembling', 'PCE', 'Testing Dept', NULL, '2025-08-01 00:00:00', '2025-08-29 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(201, 'K2V v1', 'Winker v1', 'Home Line Trial', 'AHM', 'HLT2', 'Winker Assy RH Manual Assembling', 'PCE', 'QA Team', NULL, '2025-08-01 00:00:00', '2025-08-29 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(202, 'K2V v1', 'Winker v1', 'Home Line Trial', 'AHM', 'HLT2', 'Winker Assy LH Manual Assembling', 'PCE', 'Dev Team', NULL, '2025-08-01 00:00:00', '2025-08-29 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(203, 'K2V v1', 'Winker v1', 'Home Line Trial', 'AHM', 'HLT2', 'Hot Insert', 'PCE', 'Testing Dept', NULL, '2025-08-01 00:00:00', '2025-08-29 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(204, 'K2V v1', 'Winker v1', 'Home Line Trial', 'AHM', 'Part Submition', 'PP2 event', 'MKT', 'QA Team', NULL, '2025-09-29 00:00:00', '2025-09-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(205, 'K2V v1', 'Winker v1', 'Home Line Trial', 'AHM', 'Production Preparation', 'Document', 'PCE', 'Dev Team', NULL, '2025-08-01 00:00:00', '2025-08-15 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(206, 'K2V v1', 'Winker v1', 'Home Line Trial', 'AHM', 'Production Preparation', 'Limit Sample', 'QE', 'Testing Dept', NULL, '2025-08-15 00:00:00', '2025-08-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(207, 'K2V v1', 'Winker v1', 'Home Line Trial', 'AHM', 'Production Preparation', 'Packaging Standard', 'PCE', 'QA Team', NULL, '2025-07-21 00:00:00', '2025-08-15 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(208, 'K2V v1', 'Winker v1', 'Home Line Trial', 'AHM', 'Production Preparation', 'Chuter', 'PCE', 'Dev Team', NULL, '2025-07-21 00:00:00', '2025-08-15 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(209, 'K2V v1', 'Winker v1', 'Home Line Trial', 'AHM', 'Production Preparation', 'WH area', 'WH', 'Testing Dept', NULL, '2025-07-21 00:00:00', '2025-08-15 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(210, 'K2V v1', 'Winker v1', 'Home Line Trial', 'AHM', 'Production Preparation', 'MP preparation', 'PROD', 'Dev Team', NULL, '2025-06-04 00:00:00', '2025-08-15 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(211, 'K2V v1', 'Winker v1', 'Home Line Trial', 'AHM', 'Supplier Audit', 'SPTT4', 'PUR', 'Testing Dept', NULL, '2025-08-01 00:00:00', '2025-08-15 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(212, 'K2V v1', 'Winker v1', 'Home Line Trial', 'AHM', 'Supplier Approval', 'QAV2', 'PUR', 'QA Team', NULL, '2025-08-15 00:00:00', '2025-08-29 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL);
INSERT INTO `npp_aji_internal_schedules` (`id`, `project_title`, `product`, `milestone`, `customer`, `event`, `detail_description`, `pic`, `koordinasi`, `progress`, `plan_start`, `plan_end`, `actual_start`, `actual_end`, `progress_by`, `plan_start_by`, `plan_end_by`, `actual_start_by`, `actual_end_by`, `urgent`, `judge`, `judge_by`, `updated_at`, `created_at`) VALUES
(213, 'K2V v1', 'Winker v1', 'Home Line Trial', 'AHM', 'Testing', 'Part Preparation', 'NPD', 'Dev Team', 100, '2025-05-27 00:00:00', '2025-06-04 00:00:00', '2025-07-31 00:00:00', '2025-07-31 01:49:06', 'Ridwan Syarif', NULL, NULL, 'ridwan.syarif@astra-juoku.com', NULL, 3, NULL, NULL, '2025-07-31 13:40:26', NULL),
(214, 'K2V v1', 'Winker v1', 'Home Line Trial', 'AHM', 'Testing', 'Material test', 'NPD', 'Testing Dept', 100, '2025-08-01 00:00:00', '2025-08-29 00:00:00', '2025-07-31 00:00:00', '2025-07-31 01:38:31', 'Ridwan Syarif', NULL, NULL, 'ridwan.syarif@astra-juoku.com', NULL, 1, 1, 'Ridwan Syarif', '2025-07-31 13:36:09', NULL),
(215, 'K2V v1', 'Winker v1', 'Home Line Trial', 'AHM', 'Testing', 'Testing', 'QE', 'Testing Dept', NULL, '2025-06-04 00:00:00', '2025-09-15 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(216, 'K2V v1', 'Winker v1', 'Home Line Trial', 'AHM', 'Material Preparation', 'Vent Cloth', 'WH', 'Dev Team', NULL, '2025-08-29 00:00:00', '2025-09-26 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(217, 'K2V v1', 'Winker v1', 'Home Line Trial', 'AHM', 'Material Preparation', 'Lens', 'WH', 'Testing Dept', NULL, '2025-08-29 00:00:00', '2025-09-26 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(218, 'K2V v1', 'Winker v1', 'Home Line Trial', 'AHM', 'Material Preparation', 'Housing S/A', 'WH', 'QA Team', NULL, '2025-08-29 00:00:00', '2025-10-03 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(219, 'K2V v1', 'Winker v1', 'Home Line Trial', 'AHM', 'HLT3', 'Winker Assy RH Auto Assembling', 'PPIC', 'Dev Team', NULL, '2025-10-06 00:00:00', '2025-10-10 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(220, 'K2V v1', 'Winker v1', 'Home Line Trial', 'AHM', 'HLT3', 'Winker Assy LH Auto Assembling', 'PPIC', 'Testing Dept', NULL, '2025-10-06 00:00:00', '2025-10-10 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(221, 'K2V v1', 'Winker v1', 'Home Line Trial', 'AHM', 'HLT3', 'Winker Assy RH Manual Assembling', 'PPIC', 'QA Team', NULL, '2025-10-13 00:00:00', '2025-10-17 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(222, 'K2V v1', 'Winker v1', 'Home Line Trial', 'AHM', 'HLT3', 'Winker Assy LH Manual Assembling', 'PPIC', 'Dev Team', NULL, '2025-10-13 00:00:00', '2025-10-17 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
(223, 'K2V v1', 'Winker v1', 'Home Line Trial', 'AHM', 'HLT3', 'Hot Insert', 'PPIC', 'Testing Dept', NULL, '2025-09-15 00:00:00', '2025-09-19 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(224, 'K2V v1', 'Winker v1', 'Home Line Trial', 'AHM', 'Mass-pro Preparation Evaluation', '2nd QA Meeting', 'NPD', 'QA Team', NULL, '2025-10-20 00:00:00', '2025-10-28 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `npp_calendar`
--

CREATE TABLE `npp_calendar` (
  `id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `description` varchar(255) NOT NULL,
  `project` varchar(50) NOT NULL,
  `product` varchar(255) DEFAULT NULL,
  `customer` varchar(100) DEFAULT NULL,
  `date` date NOT NULL,
  `color` varchar(25) NOT NULL,
  `pic` varchar(255) DEFAULT NULL,
  `detail_dept_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `npp_calendar`
--

INSERT INTO `npp_calendar` (`id`, `name`, `description`, `project`, `product`, `customer`, `date`, `color`, `pic`, `detail_dept_id`, `created_at`, `updated_at`) VALUES
(6, 'Part delivery', 'Wire Harness Preparation', 'project 1', 'product 1', 'AHM', '2024-01-27', 'black', 'IT', 'IT', '2025-01-15 07:37:52', '2025-01-15 14:37:52'),
(7, 'QAV2', 'PCB Assy Preparation', 'project 1', 'product 1', 'AHM', '2024-01-14', 'black', 'IT', 'IT', '2025-01-15 07:37:52', '2025-01-15 14:37:52'),
(8, 'Mold Spec', 'Lens Mold Preparation', 'project 1', 'product 1', 'AHM', '2024-01-20', 'black', 'IT', 'IT', '2025-01-15 07:37:52', '2025-01-15 14:37:52'),
(9, 'Part delivery', 'Tapping Screw Preparation', 'project 1', 'product 1', 'AHM', '2024-01-25', 'black', 'IT', 'IT', '2025-01-15 07:37:52', '2025-01-15 14:37:52'),
(10, 'Detail Masspro', 'Event Masspro', 'project 1', 'product 1', 'AHM', '2024-03-03', 'black', 'IT', 'IT', '2025-01-15 07:37:52', '2025-01-15 14:37:52'),
(11, 'Attallah Arelian Naufhal', 'ggg', 'General', 'General', 'FRINA', '2025-07-16', '#2d6bae', 'IT', 'IT', '2025-07-14 04:41:27', '2025-07-14 11:41:27');

-- --------------------------------------------------------

--
-- Table structure for table `npp_category_problem`
--

CREATE TABLE `npp_category_problem` (
  `id` int(11) NOT NULL,
  `category` varchar(30) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `npp_category_problem`
--

INSERT INTO `npp_category_problem` (`id`, `category`, `created_at`, `updated_at`) VALUES
(1, 'Design', '2024-01-30 03:17:03', NULL),
(2, 'Process', '2024-01-30 03:17:03', NULL),
(3, 'Machine', '2024-01-30 03:17:03', NULL),
(4, 'Packaging', '2024-01-30 03:22:38', NULL),
(5, 'Man Power', '2024-01-30 03:22:38', NULL),
(6, 'Material & Component', '2024-01-30 03:22:38', NULL),
(7, 'Supplier Delivery', '2024-01-30 03:22:38', NULL),
(8, 'Supplier Quality', '2024-01-30 03:22:38', NULL),
(9, 'Supplier Others', '2024-01-30 03:22:38', NULL),
(10, 'Customer Issue', '2024-01-30 03:22:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `npp_customer`
--

CREATE TABLE `npp_customer` (
  `id` int(11) NOT NULL,
  `uniq_id` varchar(6) NOT NULL,
  `code` varchar(30) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `npp_customer`
--

INSERT INTO `npp_customer` (`id`, `uniq_id`, `code`, `name`) VALUES
(1, '1110', 'SUGITY', 'PT Sugity Creatives'),
(2, '1111', 'FRINA', 'Frina Lestari Nusantara'),
(3, '1113', 'KTSI', 'Kasai Teck See Indonesia'),
(4, '1117', 'ASKI', 'Astra Komponen Indonesia'),
(5, '1132', 'MMKYSI', 'Mitsubishi Motors Krama Yudha Sales Indonesia'),
(6, '1135', 'MURAKAMI', 'PT Murakami Delloyd Indonesia'),
(7, '1144', 'TSC', 'PT Takagi Sari Multi Utama'),
(8, '1145', 'BINA PERTIWI', 'Bina Pertiwi'),
(9, '0001', 'PENSTONE', 'Penstone Auto Indonesia'),
(10, '0002', 'ADM', 'Astra Daihatsu Motor'),
(11, '0003', 'TMMIN', 'Toyota Motor Manufacturng Indonesia'),
(12, '0004', 'IAMI', 'Isuzu Astra Motor Indonesia'),
(13, '0005', 'NMDI', 'Nissan Motor Distributor Indonesia'),
(14, '0008', 'KBI', 'Kyoraku Blowmolding Indonesia'),
(15, '0014', 'TORICA', 'Torica Indonesia'),
(16, '1120', 'AWP', 'Astra Otoparts Tbk Div Adiwira Plastik'),
(17, '1131', 'AHM', 'Astra Honda Motor'),
(18, '1133', 'DSO', 'PT Astra International TBK DSO'),
(19, '-', 'JUOKU', 'juoku Technology Ltd');

-- --------------------------------------------------------

--
-- Table structure for table `npp_form_event_history`
--

CREATE TABLE `npp_form_event_history` (
  `id` int(11) NOT NULL,
  `project` varchar(255) NOT NULL,
  `product` varchar(255) DEFAULT NULL,
  `form_type` varchar(255) NOT NULL,
  `id_task` int(14) NOT NULL,
  `status` int(1) NOT NULL,
  `file` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `npp_form_event_history`
--

INSERT INTO `npp_form_event_history` (`id`, `project`, `product`, `form_type`, `id_task`, `status`, `file`, `created_at`, `updated_at`) VALUES
(1, 'Project 5', 'Product 5', 'Machine Annealing Oven', 515, 1, '20250721_083906_TULISAN_(2).pdf', '2025-07-21 01:39:06', '2025-07-21 08:39:06'),
(2, 'Project 5', 'Product 5', 'Machine Annealing Oven', 516, 1, NULL, '2025-07-21 04:34:16', '2025-07-21 11:34:16'),
(3, 'K2V v1', 'Winker v1', 'Master Schedule', 1, 1, NULL, '2025-07-22 02:27:33', '2025-07-22 09:27:33'),
(4, 'K2V v1', 'Winker v1', 'Material test', 665, 1, NULL, '2025-07-31 06:38:31', '2025-07-31 13:38:31'),
(5, 'K2V v1', 'Winker v1', 'Part Preparation', 663, 1, NULL, '2025-07-31 06:48:46', '2025-07-31 13:48:46'),
(6, 'K2V v1', 'Winker v1', 'Part Preparation', 664, 1, NULL, '2025-07-31 06:49:06', '2025-07-31 13:49:06'),
(7, 'K2V', 'Winker', 'TPR Tooling', 261, 1, NULL, '2025-07-31 07:00:02', '2025-07-31 14:00:02'),
(8, 'K2V', 'Winker', 'TPR Tooling', 262, 1, NULL, '2025-07-31 07:00:02', '2025-07-31 14:00:02'),
(9, 'K2V', 'Winker', 'TPR Tooling', 263, 1, NULL, '2025-07-31 07:00:02', '2025-07-31 14:00:02'),
(10, 'K2V v1', 'Winker v1', 'Master Schedule', 2, 1, NULL, '2025-08-01 03:11:35', '2025-08-01 10:11:35'),
(11, 'K2V v1', 'Winker v1', 'Master Schedule', 3, 1, NULL, '2025-08-01 03:11:35', '2025-08-01 10:11:35'),
(12, 'K2V v1', 'Winker v1', 'Master Schedule', 4, 1, NULL, '2025-08-01 03:11:35', '2025-08-01 10:11:35');

-- --------------------------------------------------------

--
-- Table structure for table `npp_form_event_project`
--

CREATE TABLE `npp_form_event_project` (
  `id` int(11) NOT NULL,
  `milestone` varchar(255) NOT NULL,
  `event` varchar(255) NOT NULL,
  `form_type` varchar(255) NOT NULL,
  `task_no` int(3) NOT NULL,
  `task` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `npp_form_event_project`
--

INSERT INTO `npp_form_event_project` (`id`, `milestone`, `event`, `form_type`, `task_no`, `task`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Product Design', 'Project Kick-Off', 'Master Schedule', 1, 'Master Schedule Internal', '2025-07-21 08:57:58', '2025-07-21 15:57:58', NULL),
(2, 'Product Design', 'Project Kick-Off', 'Master Schedule', 2, 'MCP', '2025-07-21 08:57:58', '2025-07-21 15:57:58', NULL),
(3, 'Product Design', 'Project Kick-Off', 'Master Schedule', 3, 'Master schedule for vendor', '2025-07-21 08:57:58', '2025-07-21 15:57:58', NULL),
(4, 'Product Design', 'Project Kick-Off', 'Master Schedule', 4, 'Customer Schedule', '2025-07-21 08:57:58', '2025-07-21 15:57:58', NULL),
(5, 'Product Design', 'Project Kick-Off', 'Project Document', 1, 'Tooling list', '2025-07-21 08:57:58', '2025-07-21 15:57:58', NULL),
(6, 'Product Design', 'Project Kick-Off', 'Project Document', 2, 'localization list', '2025-07-21 08:57:58', '2025-07-21 15:57:58', NULL),
(7, 'Product Design', 'Project Kick-Off', 'Project Document', 3, 'Project Risk Assessment', '2025-07-21 08:57:58', '2025-07-21 15:57:58', NULL),
(8, 'Product Design', 'Project Kick-Off', 'Project Document', 4, 'Project Organization structure', '2025-07-21 08:57:58', '2025-07-21 15:57:58', NULL),
(9, 'Product Design', 'Project Kick-Off', 'Project Document', 5, 'Investment List', '2025-07-21 08:57:58', '2025-07-21 15:57:58', NULL),
(10, 'Product Design', 'Project Kick-Off', 'Project Document', 6, 'Loading Capacity', '2025-07-21 08:57:58', '2025-07-21 15:57:58', NULL),
(11, 'Product Design', 'Project Kick-Off', 'Project Target', 1, 'RFQ letter', '2025-07-21 08:57:58', '2025-07-21 15:57:58', NULL),
(12, 'Product Design', 'Project Kick-Off', 'Project Target', 2, 'LOI/PMT', '2025-07-21 08:57:58', '2025-07-21 15:57:58', NULL),
(13, 'Product Design', 'Project Kick-Off', 'Project Target', 3, 'Marketing Project Goals', '2025-07-21 08:57:58', '2025-07-21 15:57:58', NULL),
(14, 'Product Design', 'Project Kick-Off', 'Project Target', 4, 'Marketing Define Scope', '2025-07-21 08:57:58', '2025-07-21 15:57:58', NULL),
(15, 'Product Design', 'Early Stage Review', 'Internal Schedule', 1, 'Design Planning Schedule', '2025-07-21 08:57:58', '2025-07-21 15:57:58', NULL),
(16, 'Product Design', 'Early Stage Review', 'Internal Schedule', 2, 'Quality Planning Schedule', '2025-07-21 08:57:58', '2025-07-21 15:57:58', NULL),
(17, 'Product Design', 'Early Stage Review', 'Internal Schedule', 3, 'Engineering Planning Schedule', '2025-07-21 08:57:58', '2025-07-21 15:57:58', NULL),
(18, 'Product Design', 'Early Stage Review', 'Internal Schedule', 4, 'Production Planning Schedule', '2025-07-21 08:57:58', '2025-07-21 15:57:58', NULL),
(19, 'Product Design', 'Early Stage Review', 'Internal Schedule', 5, 'Suplier Planning Schedule', '2025-07-21 08:57:58', '2025-07-21 15:57:58', NULL),
(20, 'Product Design', 'Early Stage Review', 'Supplier Product Draft Schedule', 1, 'Lens', '2025-07-21 08:57:58', '2025-07-21 15:57:58', NULL),
(21, 'Product Design', 'Early Stage Review', 'Supplier Product Draft Schedule', 2, 'Housing', '2025-07-21 08:57:58', '2025-07-21 15:57:58', NULL),
(22, 'Product Design', 'Early Stage Review', 'Supplier Product Draft Schedule', 3, 'Insert Nut', '2025-07-21 08:57:58', '2025-07-21 15:57:58', NULL),
(23, 'Product Design', 'Early Stage Review', 'Supplier Product Draft Schedule', 4, 'PCB', '2025-07-21 08:57:58', '2025-07-21 15:57:58', NULL),
(24, 'Product Design', 'Early Stage Review', 'Supplier Product Draft Schedule', 5, 'Wire Harness', '2025-07-21 08:57:58', '2025-07-21 15:57:58', NULL),
(25, 'Product Design', 'Early Stage Review', 'Supplier Product Draft Schedule', 6, 'Tapping Screw', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(26, 'Product Design', 'Early Stage Review', 'Supplier Product Draft Schedule', 7, 'Vent Cloth', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(27, 'Product Design', 'Early Stage Review', 'Supplier Product Draft Schedule', 8, 'Housing S/A', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(28, 'Product Design', 'Early Stage Review', 'Supplier Product Draft Schedule', 9, 'Electronic Component', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(29, 'Product Design', 'Early Stage Review', 'Tooling Supplier Draft Schedule', 1, 'Housing Mold', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(30, 'Product Design', 'Early Stage Review', 'Tooling Supplier Draft Schedule', 2, 'Lens Mold', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(31, 'Product Design', 'Early Stage Review', 'Tooling Supplier Draft Schedule', 3, 'Ultrasonic Jig', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(32, 'Product Design', 'Early Stage Review', 'Tooling Supplier Draft Schedule', 4, 'Airleak test jig', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(33, 'Product Design', 'Early Stage Review', 'Tooling Supplier Draft Schedule', 5, 'Hot insert jig', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(34, 'Product Design', 'Early Stage Review', 'Tooling Supplier Draft Schedule', 6, 'Hot Insert Machine', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(35, 'Product Design', 'Early Stage Review', 'Tooling Supplier Draft Schedule', 7, 'Automation Machine', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(36, 'Product Design', 'Early Stage Review', 'Tooling Supplier Draft Schedule', 8, 'CCD machine', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(37, 'Product Design', 'Early Stage Review', 'Tooling Supplier Draft Schedule', 9, 'Oven', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(38, 'Product Design', 'Early Stage Review', 'Tooling Supplier Draft Schedule', 10, 'Laser Marking', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(39, 'Product Design', 'Early Stage Review', 'Project Risk Assessment', 1, 'Sechedule Review', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(40, 'Product Design', 'Early Stage Review', 'Project Risk Assessment', 2, 'Update Project Risk Assessment', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(41, 'Product Design', 'Early Stage Review', 'Project Risk Assessment', 3, 'Approval & Socialization Risk Assessment', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(42, 'Product Design', 'Early Stage Review', 'Project Risk Assessment', 4, 'Kakotora Review', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(43, 'Product Design', 'Early Stage Review', 'Portal Update', 1, 'Detail Schdule .csv', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(44, 'Product Design', 'Early Stage Review', 'Portal Update', 2, 'master task event .csv', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(45, 'Product Design', 'Early Stage Review', 'Design Data', 1, 'A-surface', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(46, 'Product Design', 'Early Stage Review', 'Design Data', 2, 'Drawing Spec', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(47, 'Product Design', 'Early Stage Review', 'Design Data', 3, 'Technical standard', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(48, 'Product Design', 'Product Design Review', 'DR Product 1', 1, 'DR1 Check List', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(49, 'Product Design', 'Product Design Review', 'DR Product 1', 2, 'Materi DR1', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(50, 'Product Design', 'Product Design Review', 'DR Product 1', 3, 'MoM DR1 Feedback', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(51, 'Product Design', 'Product Design Review', 'DR Product 1', 4, 'Draft DFMEA', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(52, 'Product Design', 'Product Design Review', 'DR Product 1', 5, 'Simulation Test Report', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(53, 'Product Design', 'Product Design Review', 'DR Product 1', 6, 'CAE Evaluation', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(54, 'Product Design', 'Product Design Review', 'DR Product 1', 7, 'Design Schedule', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(55, 'Product Design', 'Product Design Review', 'DR Product 1', 8, 'Kakotora Review', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(56, 'Product Design', 'Product Design Review', 'DR Product 2', 1, 'DR2 Check List', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(57, 'Product Design', 'Product Design Review', 'DR Product 2', 2, 'Materi DR2', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(58, 'Product Design', 'Product Design Review', 'DR Product 2', 3, 'MoM DR2 Feedback', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(59, 'Product Design', 'Product Design Review', 'DR Product 2', 4, 'DFMEA', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(60, 'Product Design', 'Product Design Review', 'DR Product 2', 5, 'D-Table', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(61, 'Product Design', 'Product Design Review', 'DR Product 2', 6, 'Simulation Test Report', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(62, 'Product Design', 'Product Design Review', 'DR Product 2', 7, 'CAE Evaluation', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(63, 'Product Design', 'Product Design Review', 'DR Product 2', 8, 'Design BoM', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(64, 'Product Design', 'Product Design Review', 'DR Product 2', 9, 'e-BoM', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(65, 'Product Design', 'Product Design Review', 'DR Product 2', 10, 'Grain Confirmation', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(66, 'Product Design', 'Product Design Review', 'DR Product 2', 11, 'Surface Treatment Analysis', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(67, 'Product Design', 'Product Design Review', 'DR Product 2', 12, 'Kakotora Review', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(68, 'Product Design', 'Product Design Review', 'Product Drawing', 1, 'Lens', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(69, 'Product Design', 'Product Design Review', 'Product Drawing', 2, 'Housing', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(70, 'Product Design', 'Product Design Review', 'Product Drawing', 3, 'PCB', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(71, 'Product Design', 'Product Design Review', 'Product Drawing', 4, 'Wire Assy', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(72, 'Product Design', 'Product Design Review', 'Product Drawing', 5, 'Nut Insert', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(73, 'Product Design', 'Product Design Review', 'Product Drawing', 6, 'Tapping Screw', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(74, 'Product Design', 'Product Design Review', 'Product Drawing', 7, 'Vent Cloth', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(75, 'Product Design', 'Product Design Review', 'Product Drawing', 8, 'Grommet', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(76, 'Product Design', 'Product Design Review', 'Product Drawing', 9, 'Housing + Nut', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(77, 'Product Design', 'Product Design Review', 'Product Drawing', 10, 'Housing S/A', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(78, 'Product Design', 'Product Design Review', 'Product Study', 1, 'DFMEA Review', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(79, 'Product Design', 'Product Design Review', 'Product Study', 2, 'Drawing Review', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(80, 'Product Design', 'Product Design Review', 'Product Study', 3, 'Product Critical Point', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(81, 'Product Design', 'Product Design Review', 'Product Study', 4, 'Kakotora Review', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(82, 'Product Design', 'Process Design Review', 'Process Study', 1, 'Flow Process', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(83, 'Product Design', 'Process Design Review', 'Process Study', 2, 'Loading Capacity', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(84, 'Product Design', 'Process Design Review', 'Process Study', 3, 'Project Layout', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(85, 'Product Design', 'Process Design Review', 'Process Study', 4, 'Draft TSK-TSKK', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(86, 'Product Design', 'Process Design Review', 'Process Study', 5, 'PFMEA Review', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(87, 'Product Design', 'Process Design Review', 'Process Study', 6, 'Process requirement', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(88, 'Product Design', 'Process Design Review', 'Process Study', 7, 'Process Critical Point', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(89, 'Product Design', 'Process Design Review', 'Process Study', 8, 'Tooling list', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(90, 'Product Design', 'Process Design Review', 'Process Study', 9, 'Kakotora Review', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(91, 'Product Design', 'Process Design Review', 'Tooling Spec', 1, 'Mold spec Housing', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(92, 'Product Design', 'Process Design Review', 'Tooling Spec', 2, 'Mold spec Lens', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(93, 'Product Design', 'Process Design Review', 'Tooling Spec', 3, 'Ultrasonic Jig', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(94, 'Product Design', 'Process Design Review', 'Tooling Spec', 4, 'Airleak test jig', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(95, 'Product Design', 'Process Design Review', 'Tooling Spec', 5, 'Hot insert jig', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(96, 'Product Design', 'Process Design Review', 'Tooling Spec', 6, 'Hot Insert Machine', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(97, 'Product Design', 'Process Design Review', 'Tooling Spec', 7, 'Automation Machine', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(98, 'Product Design', 'Process Design Review', 'Tooling Spec', 8, 'CCD machine', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(99, 'Product Design', 'Process Design Review', 'Tooling Spec', 9, 'Oven', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(100, 'Product Design', 'Process Design Review', 'Tooling Spec', 10, 'Laser Marking', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(101, 'Product Design', 'Process Design Review', 'DR Tooling', 1, 'DFM Mold Lens', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(102, 'Product Design', 'Process Design Review', 'DR Tooling', 2, 'DFM Mold Housing', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(103, 'Product Design', 'Process Design Review', 'DR Tooling', 3, 'CAE Analysis Lens', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(104, 'Product Design', 'Process Design Review', 'DR Tooling', 4, 'CAE Analysis Housing', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(105, 'Product Design', 'Process Design Review', 'DR Tooling', 5, 'Materi DR', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(106, 'Product Design', 'Process Design Review', 'DR Tooling', 6, 'Grain Analysis', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(107, 'Product Design', 'Process Design Review', 'DR Tooling', 7, 'Surface Treatment Analysis', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(108, 'Product Design', 'Process Design Review', 'DR Tooling', 8, 'Marking Confirmation', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(109, 'Product Design', 'Process Design Review', 'DR Tooling', 9, 'Kakotora Review', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(110, 'Product Design', 'Process Design Review', 'DR Tooling', 10, 'MoM DR Feedback', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(111, 'Product Design', 'Process Design Review', 'DR Process', 1, 'DFM Process', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(112, 'Product Design', 'Process Design Review', 'DR Process', 2, 'Materi DR', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(113, 'Product Design', 'Process Design Review', 'DR Process', 3, 'Kakotora Review', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(114, 'Product Design', 'Process Design Review', 'DR Process', 4, 'MoM DR Feedback', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(115, 'Product Design', 'Process Design Review', 'DR Process', 5, 'Similarity Product & Process review', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(116, 'Product Design', 'Process Design Review', 'DR Process', 6, 'Pokayoke list', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(117, 'Product Design', 'Process Design Review', 'DR Process', 7, 'Inspection List', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(118, 'Product Design', 'Process Design Review', 'Inspection Plan', 1, 'Draft Control Plan', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(119, 'Product Design', 'Process Design Review', 'Inspection Plan', 2, 'Quality document list-up', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(120, 'Product Design', 'Process Design Review', 'Inspection Plan', 3, 'CF-Design', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(121, 'Product Design', 'Process Design Review', 'Inspection Plan', 4, 'Measuring Tools List', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(122, 'Product Design', 'Part Supplier Selection', 'RFQ Supplier', 1, 'Lens', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(123, 'Product Design', 'Part Supplier Selection', 'RFQ Supplier', 2, 'Housing', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(124, 'Product Design', 'Part Supplier Selection', 'RFQ Supplier', 3, 'Insert Nut', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(125, 'Product Design', 'Part Supplier Selection', 'RFQ Supplier', 4, 'PCB', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(126, 'Product Design', 'Part Supplier Selection', 'RFQ Supplier', 5, 'Wire Harness', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(127, 'Product Design', 'Part Supplier Selection', 'RFQ Supplier', 6, 'Tapping Screw', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(128, 'Product Design', 'Part Supplier Selection', 'RFQ Supplier', 7, 'Vent Cloth', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(129, 'Product Design', 'Part Supplier Selection', 'RFQ Supplier', 8, 'Housing S/A', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(130, 'Product Design', 'Part Supplier Selection', 'RFQ Supplier', 9, 'Electronic Component', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(131, 'Product Design', 'Part Supplier Selection', 'Supplier Quotation', 1, 'Lens', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(132, 'Product Design', 'Part Supplier Selection', 'Supplier Quotation', 2, 'Housing', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(133, 'Product Design', 'Part Supplier Selection', 'Supplier Quotation', 3, 'Insert Nut', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(134, 'Product Design', 'Part Supplier Selection', 'Supplier Quotation', 4, 'PCB', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(135, 'Product Design', 'Part Supplier Selection', 'Supplier Quotation', 5, 'Wire Harness', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(136, 'Product Design', 'Part Supplier Selection', 'Supplier Quotation', 6, 'Tapping Screw', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(137, 'Product Design', 'Part Supplier Selection', 'Supplier Quotation', 7, 'Vent Cloth', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(138, 'Product Design', 'Part Supplier Selection', 'Supplier Quotation', 8, 'Housing S/A', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(139, 'Product Design', 'Part Supplier Selection', 'Supplier Quotation', 9, 'Electronic Component', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(140, 'Product Design', 'Part Supplier Selection', 'Price comparison', 1, 'Lens', '2025-07-21 08:57:59', '2025-07-21 15:57:59', NULL),
(141, 'Product Design', 'Part Supplier Selection', 'Price comparison', 2, 'Housing', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(142, 'Product Design', 'Part Supplier Selection', 'Price comparison', 3, 'Insert Nut', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(143, 'Product Design', 'Part Supplier Selection', 'Price comparison', 4, 'PCB', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(144, 'Product Design', 'Part Supplier Selection', 'Price comparison', 5, 'Wire Harness', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(145, 'Product Design', 'Part Supplier Selection', 'Price comparison', 6, 'Tapping Screw', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(146, 'Product Design', 'Part Supplier Selection', 'Price comparison', 7, 'Vent Cloth', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(147, 'Product Design', 'Part Supplier Selection', 'Price comparison', 8, 'Housing S/A', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(148, 'Product Design', 'Part Supplier Selection', 'Price comparison', 9, 'Electronic Component', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(149, 'Product Design', 'Supplier Audit', 'QAV 1', 1, 'Lens', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(150, 'Product Design', 'Supplier Audit', 'QAV 1', 2, 'Housing', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(151, 'Product Design', 'Supplier Audit', 'QAV 1', 3, 'Insert Nut', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(152, 'Product Design', 'Supplier Audit', 'QAV 1', 4, 'PCB', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(153, 'Product Design', 'Supplier Audit', 'QAV 1', 5, 'Wire Harness', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(154, 'Product Design', 'Supplier Audit', 'QAV 1', 6, 'Tapping Screw', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(155, 'Product Design', 'Supplier Audit', 'QAV 1', 7, 'Vent Cloth', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(156, 'Product Design', 'Supplier Audit', 'QAV 1', 8, 'Housing S/A', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(157, 'Product Design', 'Supplier Audit', 'QAV 1', 9, 'Electronic Component', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(158, 'Product Design', 'Supplier Audit', 'SPTT1', 1, 'Lens', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(159, 'Product Design', 'Supplier Audit', 'SPTT1', 2, 'Housing', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(160, 'Product Design', 'Supplier Audit', 'SPTT1', 3, 'Insert Nut', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(161, 'Product Design', 'Supplier Audit', 'SPTT1', 4, 'PCB', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(162, 'Product Design', 'Supplier Audit', 'SPTT1', 5, 'Wire Harness', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(163, 'Product Design', 'Supplier Audit', 'SPTT1', 6, 'Tapping Screw', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(164, 'Product Design', 'Supplier Audit', 'SPTT1', 7, 'Vent Cloth', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(165, 'Product Design', 'Supplier Audit', 'SPTT1', 8, 'Housing S/A', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(166, 'Product Design', 'Supplier Audit', 'SPTT1', 9, 'Electronic Component', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(167, 'Product Design', 'Part Supplier Selection', 'Supplier LOI', 1, 'Lens', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(168, 'Product Design', 'Part Supplier Selection', 'Supplier LOI', 2, 'Housing', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(169, 'Product Design', 'Part Supplier Selection', 'Supplier LOI', 3, 'Insert Nut', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(170, 'Product Design', 'Part Supplier Selection', 'Supplier LOI', 4, 'PCB', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(171, 'Product Design', 'Part Supplier Selection', 'Supplier LOI', 5, 'Wire Harness', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(172, 'Product Design', 'Part Supplier Selection', 'Supplier LOI', 6, 'Tapping Screw', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(173, 'Product Design', 'Part Supplier Selection', 'Supplier LOI', 7, 'Vent Cloth', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(174, 'Product Design', 'Part Supplier Selection', 'Supplier LOI', 8, 'Housing S/A', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(175, 'Product Design', 'Part Supplier Selection', 'Supplier LOI', 9, 'Electronic Component', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(176, 'Product Design', 'Tooling Supplier Selection', 'Supplier PR', 1, 'Housing Mold', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(177, 'Product Design', 'Tooling Supplier Selection', 'Supplier PR', 2, 'Lens Mold', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(178, 'Product Design', 'Tooling Supplier Selection', 'Supplier PR', 3, 'Ultrasonic Jig', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(179, 'Product Design', 'Tooling Supplier Selection', 'Supplier PR', 4, 'Airleak test jig', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(180, 'Product Design', 'Tooling Supplier Selection', 'Supplier PR', 5, 'Hot insert jig', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(181, 'Product Design', 'Tooling Supplier Selection', 'Supplier PR', 6, 'Hot Insert Machine', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(182, 'Product Design', 'Tooling Supplier Selection', 'Supplier PR', 7, 'Automation Machine', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(183, 'Product Design', 'Tooling Supplier Selection', 'Supplier PR', 8, 'CCD machine', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(184, 'Product Design', 'Tooling Supplier Selection', 'Supplier PR', 9, 'Oven', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(185, 'Product Design', 'Tooling Supplier Selection', 'Supplier PR', 10, 'Laser Marking', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(186, 'Product Design', 'Tooling Supplier Selection', 'RFQ Supplier', 1, 'Housing Mold', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(187, 'Product Design', 'Tooling Supplier Selection', 'RFQ Supplier', 2, 'Lens Mold', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(188, 'Product Design', 'Tooling Supplier Selection', 'RFQ Supplier', 3, 'Ultrasonic Jig', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(189, 'Product Design', 'Tooling Supplier Selection', 'RFQ Supplier', 4, 'Airleak test jig', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(190, 'Product Design', 'Tooling Supplier Selection', 'RFQ Supplier', 5, 'Hot insert jig', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(191, 'Product Design', 'Tooling Supplier Selection', 'RFQ Supplier', 6, 'Hot Insert Machine', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(192, 'Product Design', 'Tooling Supplier Selection', 'RFQ Supplier', 7, 'Automation Machine', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(193, 'Product Design', 'Tooling Supplier Selection', 'RFQ Supplier', 8, 'CCD machine', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(194, 'Product Design', 'Tooling Supplier Selection', 'RFQ Supplier', 9, 'Oven', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(195, 'Product Design', 'Tooling Supplier Selection', 'RFQ Supplier', 10, 'Laser Marking', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(196, 'Product Design', 'Tooling Supplier Selection', 'Supplier Quotation', 1, 'Housing Mold', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(197, 'Product Design', 'Tooling Supplier Selection', 'Supplier Quotation', 2, 'Lens Mold', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(198, 'Product Design', 'Tooling Supplier Selection', 'Supplier Quotation', 3, 'Ultrasonic Jig', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(199, 'Product Design', 'Tooling Supplier Selection', 'Supplier Quotation', 4, 'Airleak test jig', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(200, 'Product Design', 'Tooling Supplier Selection', 'Supplier Quotation', 5, 'Hot insert jig', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(201, 'Product Design', 'Tooling Supplier Selection', 'Supplier Quotation', 6, 'Hot Insert Machine', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(202, 'Product Design', 'Tooling Supplier Selection', 'Supplier Quotation', 7, 'Automation Machine', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(203, 'Product Design', 'Tooling Supplier Selection', 'Supplier Quotation', 8, 'CCD machine', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(204, 'Product Design', 'Tooling Supplier Selection', 'Supplier Quotation', 9, 'Oven', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(205, 'Product Design', 'Tooling Supplier Selection', 'Supplier Quotation', 10, 'Laser Marking', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(206, 'Product Design', 'Tooling Supplier Selection', 'Supplier PO', 1, 'Housing Mold', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(207, 'Product Design', 'Tooling Supplier Selection', 'Supplier PO', 2, 'Lens Mold', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(208, 'Product Design', 'Tooling Supplier Selection', 'Supplier PO', 3, 'Ultrasonic Jig', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(209, 'Product Design', 'Tooling Supplier Selection', 'Supplier PO', 4, 'Airleak test jig', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(210, 'Product Design', 'Tooling Supplier Selection', 'Supplier PO', 5, 'Hot insert jig', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(211, 'Product Design', 'Tooling Supplier Selection', 'Supplier PO', 6, 'Hot Insert Machine', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(212, 'Product Design', 'Tooling Supplier Selection', 'Supplier PO', 7, 'Automation Machine', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(213, 'Product Design', 'Tooling Supplier Selection', 'Supplier PO', 8, 'CCD machine', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(214, 'Product Design', 'Tooling Supplier Selection', 'Supplier PO', 9, 'Oven', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(215, 'Product Design', 'Tooling Supplier Selection', 'Supplier PO', 10, 'Laser Marking', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(216, 'Product Design', 'Machine Preparation', 'Auto Machine Ordering', 1, 'Machine FS', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(217, 'Product Design', 'Machine Preparation', 'Auto Machine Ordering', 2, 'Machine PR', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(218, 'Product Design', 'Machine Preparation', 'Auto Machine Ordering', 3, 'Machine Spec', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(219, 'Product Design', 'Machine Preparation', 'Auto Machine Ordering', 4, 'Machine DFM', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(220, 'Product Design', 'Machine Preparation', 'Auto Machine Ordering', 5, 'Machine Quuotation', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(221, 'Product Design', 'Machine Preparation', 'Auto Machine Ordering', 6, 'Machine Schedule', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(222, 'Product Design', 'Machine Preparation', 'Auto Machine Ordering', 7, 'Machine PO', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(223, 'Product Design', 'Machine Preparation', 'Annealing Oven Machine Ordering', 1, 'Machine FS', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(224, 'Product Design', 'Machine Preparation', 'Annealing Oven Machine Ordering', 2, 'Machine PR', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(225, 'Product Design', 'Machine Preparation', 'Annealing Oven Machine Ordering', 3, 'Machine Spec', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(226, 'Product Design', 'Machine Preparation', 'Annealing Oven Machine Ordering', 4, 'Machine DFM', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(227, 'Product Design', 'Machine Preparation', 'Annealing Oven Machine Ordering', 5, 'Machine Quuotation', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(228, 'Product Design', 'Machine Preparation', 'Annealing Oven Machine Ordering', 6, 'Machine Schedule', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(229, 'Product Design', 'Machine Preparation', 'Annealing Oven Machine Ordering', 7, 'Machine PO', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(230, 'Product Design', 'Machine Preparation', 'Laser Marking Machine Ordering', 1, 'Machine FS', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(231, 'Product Design', 'Machine Preparation', 'Laser Marking Machine Ordering', 2, 'Machine PR', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(232, 'Product Design', 'Machine Preparation', 'Laser Marking Machine Ordering', 3, 'Machine Spec', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(233, 'Product Design', 'Machine Preparation', 'Laser Marking Machine Ordering', 4, 'Machine DFM', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(234, 'Product Design', 'Machine Preparation', 'Laser Marking Machine Ordering', 5, 'Machine Quuotation', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(235, 'Product Design', 'Machine Preparation', 'Laser Marking Machine Ordering', 6, 'Machine Schedule', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(236, 'Product Design', 'Machine Preparation', 'Laser Marking Machine Ordering', 7, 'Machine PO', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(237, 'Product Design', 'Machine Preparation', 'CCD Machine Ordering', 1, 'Machine FS', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(238, 'Product Design', 'Machine Preparation', 'CCD Machine Ordering', 2, 'Machine PR', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(239, 'Product Design', 'Machine Preparation', 'CCD Machine Ordering', 3, 'Machine Spec', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(240, 'Product Design', 'Machine Preparation', 'CCD Machine Ordering', 4, 'Machine DFM', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(241, 'Product Design', 'Machine Preparation', 'CCD Machine Ordering', 5, 'Machine Quuotation', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(242, 'Product Design', 'Machine Preparation', 'CCD Machine Ordering', 6, 'Machine Schedule', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(243, 'Product Design', 'Machine Preparation', 'CCD Machine Ordering', 7, 'Machine PO', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(244, 'Product Design', 'Design Approval', 'Approval Drawing', 1, 'Winker Assy', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(245, 'Product Design', 'Design Approval', 'Approval Drawing', 2, 'RDDP', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(246, 'Product Design', 'Design Approval', 'Approval Drawing', 3, 'Die-Go', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(247, 'Product Design', 'Design Approval', '1st QA Meeting', 1, '1st QA Material', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(248, 'Product Design', 'Design Approval', '1st QA Meeting', 2, '1st QA Check list', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(249, 'Tooling Manufacturing', 'Tooling Start', 'Approval Document', 1, 'Approval DFM Lens', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(250, 'Tooling Manufacturing', 'Tooling Start', 'Approval Document', 2, 'Approval DFM Housing', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(251, 'Tooling Manufacturing', 'Tooling Start', 'Approval Document', 3, 'Approval DFM Tooling', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(252, 'Tooling Manufacturing', 'Tooling Start', 'Approval Document', 4, 'Approval  DFM Machine', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(253, 'Tooling Manufacturing', 'Tooling Start', 'Process Confirmation', 1, 'Approval Flow Process', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(254, 'Tooling Manufacturing', 'Tooling Start', 'Process Confirmation', 2, 'in-plant out-plant form', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(255, 'Tooling Manufacturing', 'Tooling Start', 'Process Confirmation', 3, 'Layout approval', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(256, 'Tooling Manufacturing', 'Tooling Start', 'Process Confirmation', 4, 'MP approval', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(257, 'Tooling Manufacturing', 'Tooling Start', 'Process Confirmation', 5, 'Draft WI', '2025-07-21 08:58:00', '2025-07-21 15:58:00', NULL),
(258, 'Tooling Manufacturing', 'Tooling Start', 'Drawing Sub-assy', 1, 'Drawing B+NT', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(259, 'Tooling Manufacturing', 'Tooling Start', 'Drawing Sub-assy', 2, 'Drawing Bcp+SYN', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(260, 'Tooling Manufacturing', 'Tooling Start', 'Drawing Sub-assy', 3, 'Drawing Bsy+Ecp', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(261, 'Tooling Manufacturing', 'Tooling Progress', 'TPR Tooling', 1, 'TPR Housing Mold', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(262, 'Tooling Manufacturing', 'Tooling Progress', 'TPR Tooling', 2, 'TPR Lens Mold', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(263, 'Tooling Manufacturing', 'Tooling Progress', 'TPR Tooling', 3, 'TPR Jig Vibration', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(264, 'Tooling Manufacturing', 'Tooling Progress', 'TPR Machine', 1, 'TPR Auto machine', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(265, 'Tooling Manufacturing', 'Tooling Progress', 'TPR Machine', 2, 'TPR Hot Insert Machine', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(266, 'Tooling Manufacturing', 'Tooling Progress', 'TPR Machine', 3, 'TPR CCD', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(267, 'Tooling Manufacturing', 'Tooling Progress', 'TPR Machine', 4, 'TPR Laser Marking', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(268, 'Tooling Manufacturing', 'Tooling Progress', 'TPR Machine', 5, 'TPR annealing oven', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(269, 'Tooling Manufacturing', 'Material Preparation', 'Material Lens (PMMA Clear)', 1, 'PR', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(270, 'Tooling Manufacturing', 'Material Preparation', 'Material Lens (PMMA Clear)', 2, 'Qoutation', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(271, 'Tooling Manufacturing', 'Material Preparation', 'Material Lens (PMMA Clear)', 3, 'PO', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(272, 'Tooling Manufacturing', 'Material Preparation', 'Material Lens (PMMA Clear)', 4, 'Supplier delivery confirmation', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(273, 'Tooling Manufacturing', 'Material Preparation', 'Material Lens (PMMA Clear)', 5, 'Material readiness', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(274, 'Tooling Manufacturing', 'Material Preparation', 'Material Lens (PMMA Clear)', 6, 'Material Shipment', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(275, 'Tooling Manufacturing', 'Material Preparation', 'Material Housing (PMMA Black)', 1, 'PR', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(276, 'Tooling Manufacturing', 'Material Preparation', 'Material Housing (PMMA Black)', 2, 'Qoutation', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(277, 'Tooling Manufacturing', 'Material Preparation', 'Material Housing (PMMA Black)', 3, 'PO', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(278, 'Tooling Manufacturing', 'Material Preparation', 'Material Housing (PMMA Black)', 4, 'Supplier delivery confirmation', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(279, 'Tooling Manufacturing', 'Material Preparation', 'Material Housing (PMMA Black)', 5, 'Material readiness', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(280, 'Tooling Manufacturing', 'Material Preparation', 'Material Housing (PMMA Black)', 6, 'Material Shipment', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(281, 'Tooling Manufacturing', 'Material Preparation', 'Tapping Screw', 1, 'PR', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(282, 'Tooling Manufacturing', 'Material Preparation', 'Tapping Screw', 2, 'Qoutation', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(283, 'Tooling Manufacturing', 'Material Preparation', 'Tapping Screw', 3, 'PO', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(284, 'Tooling Manufacturing', 'Material Preparation', 'Tapping Screw', 4, 'Supplier delivery confirmation', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(285, 'Tooling Manufacturing', 'Material Preparation', 'Tapping Screw', 5, 'Material readiness', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(286, 'Tooling Manufacturing', 'Material Preparation', 'Tapping Screw', 6, 'Material Shipment', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(287, 'Tooling Manufacturing', 'Material Preparation', 'Vent Cloth', 1, 'PR', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(288, 'Tooling Manufacturing', 'Material Preparation', 'Vent Cloth', 2, 'Qoutation', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(289, 'Tooling Manufacturing', 'Material Preparation', 'Vent Cloth', 3, 'PO', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(290, 'Tooling Manufacturing', 'Material Preparation', 'Vent Cloth', 4, 'Supplier delivery confirmation', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(291, 'Tooling Manufacturing', 'Material Preparation', 'Vent Cloth', 5, 'Material readiness', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(292, 'Tooling Manufacturing', 'Material Preparation', 'Vent Cloth', 6, 'Material Shipment', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(293, 'Tooling Manufacturing', 'Material Preparation', 'PCB', 1, 'PR', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(294, 'Tooling Manufacturing', 'Material Preparation', 'PCB', 2, 'Qoutation', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(295, 'Tooling Manufacturing', 'Material Preparation', 'PCB', 3, 'PO', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(296, 'Tooling Manufacturing', 'Material Preparation', 'PCB', 4, 'Supplier delivery confirmation', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(297, 'Tooling Manufacturing', 'Material Preparation', 'PCB', 5, 'Material readiness', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(298, 'Tooling Manufacturing', 'Material Preparation', 'PCB', 6, 'Material Shipment', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(299, 'Tooling Manufacturing', 'Material Preparation', 'Wire Assy', 1, 'PR', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(300, 'Tooling Manufacturing', 'Material Preparation', 'Wire Assy', 2, 'Qoutation', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(301, 'Tooling Manufacturing', 'Material Preparation', 'Wire Assy', 3, 'PO', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(302, 'Tooling Manufacturing', 'Material Preparation', 'Wire Assy', 4, 'Supplier delivery confirmation', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(303, 'Tooling Manufacturing', 'Material Preparation', 'Wire Assy', 5, 'Material readiness', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(304, 'Tooling Manufacturing', 'Material Preparation', 'Wire Assy', 6, 'Material Shipment', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(305, 'Tooling Manufacturing', 'Material Preparation', 'Insert Nut', 1, 'PR', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(306, 'Tooling Manufacturing', 'Material Preparation', 'Insert Nut', 2, 'Qoutation', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(307, 'Tooling Manufacturing', 'Material Preparation', 'Insert Nut', 3, 'PO', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(308, 'Tooling Manufacturing', 'Material Preparation', 'Insert Nut', 4, 'Supplier delivery confirmation', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(309, 'Tooling Manufacturing', 'Material Preparation', 'Insert Nut', 5, 'Material readiness', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(310, 'Tooling Manufacturing', 'Material Preparation', 'Insert Nut', 6, 'Material Shipment', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(311, 'Tooling Manufacturing', 'Material Preparation', 'Housing S/A', 1, 'PR', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(312, 'Tooling Manufacturing', 'Material Preparation', 'Housing S/A', 2, 'Qoutation', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(313, 'Tooling Manufacturing', 'Material Preparation', 'Housing S/A', 3, 'PO', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(314, 'Tooling Manufacturing', 'Material Preparation', 'Housing S/A', 4, 'Supplier delivery confirmation', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(315, 'Tooling Manufacturing', 'Material Preparation', 'Housing S/A', 5, 'Material readiness', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(316, 'Tooling Manufacturing', 'Material Preparation', 'Housing S/A', 6, 'Material Shipment', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(317, 'Tooling Manufacturing', 'Document for Supplier', 'Schedule', 1, 'Lens', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(318, 'Tooling Manufacturing', 'Document for Supplier', 'Schedule', 2, 'Housing', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(319, 'Tooling Manufacturing', 'Document for Supplier', 'Schedule', 3, 'Insert Nut', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(320, 'Tooling Manufacturing', 'Document for Supplier', 'Schedule', 4, 'PCB', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(321, 'Tooling Manufacturing', 'Document for Supplier', 'Schedule', 5, 'Wire Harness', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(322, 'Tooling Manufacturing', 'Document for Supplier', 'Schedule', 6, 'Tapping Screw', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(323, 'Tooling Manufacturing', 'Document for Supplier', 'Schedule', 7, 'Vent Cloth', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(324, 'Tooling Manufacturing', 'Document for Supplier', 'Schedule', 8, 'Housing S/A', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(325, 'Tooling Manufacturing', 'Document for Supplier', 'Schedule', 9, 'Electronic Component', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(326, 'Tooling Manufacturing', 'Document for Supplier', 'Drawing', 1, 'Lens', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(327, 'Tooling Manufacturing', 'Document for Supplier', 'Drawing', 2, 'Housing', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(328, 'Tooling Manufacturing', 'Document for Supplier', 'Drawing', 3, 'Insert Nut', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(329, 'Tooling Manufacturing', 'Document for Supplier', 'Drawing', 4, 'PCB', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(330, 'Tooling Manufacturing', 'Document for Supplier', 'Drawing', 5, 'Wire Harness', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(331, 'Tooling Manufacturing', 'Document for Supplier', 'Drawing', 6, 'Tapping Screw', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(332, 'Tooling Manufacturing', 'Document for Supplier', 'Drawing', 7, 'Vent Cloth', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(333, 'Tooling Manufacturing', 'Document for Supplier', 'Drawing', 8, 'Housing S/A', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(334, 'Tooling Manufacturing', 'Document for Supplier', 'Drawing', 9, 'Electronic Component', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(335, 'Tooling Manufacturing', 'Document for Supplier', 'Forecast', 1, 'Lens', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(336, 'Tooling Manufacturing', 'Document for Supplier', 'Forecast', 2, 'Housing', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(337, 'Tooling Manufacturing', 'Document for Supplier', 'Forecast', 3, 'Insert Nut', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(338, 'Tooling Manufacturing', 'Document for Supplier', 'Forecast', 4, 'PCB', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(339, 'Tooling Manufacturing', 'Document for Supplier', 'Forecast', 5, 'Wire Harness', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(340, 'Tooling Manufacturing', 'Document for Supplier', 'Forecast', 6, 'Tapping Screw', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(341, 'Tooling Manufacturing', 'Document for Supplier', 'Forecast', 7, 'Vent Cloth', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(342, 'Tooling Manufacturing', 'Document for Supplier', 'Forecast', 8, 'Housing S/A', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(343, 'Tooling Manufacturing', 'Document for Supplier', 'Forecast', 9, 'Electronic Component', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(344, 'Tooling Manufacturing', 'Maris System', 'Maris System', 1, 'SKU', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(345, 'Tooling Manufacturing', 'Maris System', 'Maris System', 2, 'BoM', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(346, 'Tooling Manufacturing', 'Maris System', 'Maris System', 3, 'CFC', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(347, 'Tooling Manufacturing', 'Supplier Document', 'PPAP', 1, 'Lens', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(348, 'Tooling Manufacturing', 'Supplier Document', 'PPAP', 2, 'Housing', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(349, 'Tooling Manufacturing', 'Supplier Document', 'PPAP', 3, 'Insert Nut', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(350, 'Tooling Manufacturing', 'Supplier Document', 'PPAP', 4, 'PCB', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(351, 'Tooling Manufacturing', 'Supplier Document', 'PPAP', 5, 'Wire Harness', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(352, 'Tooling Manufacturing', 'Supplier Document', 'PPAP', 6, 'Tapping Screw', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(353, 'Tooling Manufacturing', 'Supplier Document', 'PPAP', 7, 'Vent Cloth', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(354, 'Tooling Manufacturing', 'Supplier Document', 'PPAP', 8, 'Housing S/A', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(355, 'Tooling Manufacturing', 'Supplier Document', 'PPAP', 9, 'Electronic Component', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(356, 'Tooling Manufacturing', 'Supplier Document', 'Packaging Standard', 1, 'Lens', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(357, 'Tooling Manufacturing', 'Supplier Document', 'Packaging Standard', 2, 'Housing', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(358, 'Tooling Manufacturing', 'Supplier Document', 'Packaging Standard', 3, 'Insert Nut', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL);
INSERT INTO `npp_form_event_project` (`id`, `milestone`, `event`, `form_type`, `task_no`, `task`, `created_at`, `updated_at`, `deleted_at`) VALUES
(359, 'Tooling Manufacturing', 'Supplier Document', 'Packaging Standard', 4, 'PCB', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(360, 'Tooling Manufacturing', 'Supplier Document', 'Packaging Standard', 5, 'Wire Harness', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(361, 'Tooling Manufacturing', 'Supplier Document', 'Packaging Standard', 6, 'Tapping Screw', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(362, 'Tooling Manufacturing', 'Supplier Document', 'Packaging Standard', 7, 'Vent Cloth', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(363, 'Tooling Manufacturing', 'Supplier Document', 'Packaging Standard', 8, 'Housing S/A', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(364, 'Tooling Manufacturing', 'Supplier Document', 'Packaging Standard', 9, 'Electronic Component', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(365, 'Tooling Manufacturing', 'Supplier Audit', 'SPTT2', 1, 'Lens', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(366, 'Tooling Manufacturing', 'Supplier Audit', 'SPTT2', 2, 'Housing', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(367, 'Tooling Manufacturing', 'Supplier Audit', 'SPTT2', 3, 'Insert Nut', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(368, 'Tooling Manufacturing', 'Supplier Audit', 'SPTT2', 4, 'PCB', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(369, 'Tooling Manufacturing', 'Supplier Audit', 'SPTT2', 5, 'Wire Harness', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(370, 'Tooling Manufacturing', 'Supplier Audit', 'SPTT2', 6, 'Tapping Screw', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(371, 'Tooling Manufacturing', 'Supplier Audit', 'SPTT2', 7, 'Vent Cloth', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(372, 'Tooling Manufacturing', 'Supplier Audit', 'SPTT2', 8, 'Housing S/A', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(373, 'Tooling Manufacturing', 'Supplier Audit', 'SPTT2', 9, 'Electronic Component', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(374, 'Tooling Manufacturing', 'Supplier Audit', 'SPTT3', 1, 'Lens', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(375, 'Tooling Manufacturing', 'Supplier Audit', 'SPTT3', 2, 'Housing', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(376, 'Tooling Manufacturing', 'Supplier Audit', 'SPTT3', 3, 'Insert Nut', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(377, 'Tooling Manufacturing', 'Supplier Audit', 'SPTT3', 4, 'PCB', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(378, 'Tooling Manufacturing', 'Supplier Audit', 'SPTT3', 5, 'Wire Harness', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(379, 'Tooling Manufacturing', 'Supplier Audit', 'SPTT3', 6, 'Tapping Screw', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(380, 'Tooling Manufacturing', 'Supplier Audit', 'SPTT3', 7, 'Vent Cloth', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(381, 'Tooling Manufacturing', 'Supplier Audit', 'SPTT3', 8, 'Housing S/A', '2025-07-21 08:58:01', '2025-07-21 15:58:01', NULL),
(382, 'Tooling Manufacturing', 'Supplier Audit', 'SPTT3', 9, 'Electronic Component', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(383, 'Tooling Manufacturing', 'Tooling Trial', 'T0', 1, 'Machine matching confirmation', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(384, 'Tooling Manufacturing', 'Tooling Trial', 'T0', 2, 'Spare part check list', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(385, 'Tooling Manufacturing', 'Tooling Trial', 'T0', 3, 'Mold part check list', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(386, 'Tooling Manufacturing', 'Tooling Trial', 'T0', 4, 'Mod 3D scan', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(387, 'Tooling Manufacturing', 'Tooling Trial', 'T0', 5, 'Mold assembling report', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(388, 'Tooling Manufacturing', 'Tooling Trial', 'T0', 6, 'Mold 3D data', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(389, 'Tooling Manufacturing', 'Tooling Trial', 'T0', 7, 'Mold 2D drawing', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(390, 'Tooling Manufacturing', 'Tooling Trial', 'T1', 1, 'Parameter setting', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(391, 'Tooling Manufacturing', 'Tooling Trial', 'T1', 2, 'Cycle Confirmation', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(392, 'Tooling Manufacturing', 'Tooling Trial', 'T1', 3, 'Part weight confirmation', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(393, 'Tooling Manufacturing', 'Tooling Trial', 'T1', 4, 'Inspection data', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(394, 'Tooling Manufacturing', 'Tooling Trial', 'T1', 5, '3D scan data', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(395, 'Tooling Manufacturing', 'Tooling Trial', 'T1', 6, 'PFS', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(396, 'Tooling Manufacturing', 'Tooling Trial', 'T1', 7, 'Trial Report', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(397, 'Tooling Manufacturing', 'Tooling Trial', 'T2', 1, 'Parameter setting', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(398, 'Tooling Manufacturing', 'Tooling Trial', 'T2', 2, 'Data Capability', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(399, 'Tooling Manufacturing', 'Tooling Trial', 'T2', 3, 'Cycle Confirmation', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(400, 'Tooling Manufacturing', 'Tooling Trial', 'T2', 4, 'Part weight confirmation', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(401, 'Tooling Manufacturing', 'Tooling Trial', 'T2', 5, 'Inspection data', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(402, 'Tooling Manufacturing', 'Tooling Trial', 'T2', 6, '3D scan data', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(403, 'Tooling Manufacturing', 'Tooling Trial', 'T2', 7, 'PFS', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(404, 'Tooling Manufacturing', 'Tooling Trial', 'T2', 8, 'Trial Report', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(405, 'Tooling Manufacturing', 'Machine Trial', 'T0', 1, 'Machine matching confirmation', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(406, 'Tooling Manufacturing', 'Machine Trial', 'T0', 2, 'Spare part check list', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(407, 'Tooling Manufacturing', 'Machine Trial', 'T0', 3, 'Machine Manual Book', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(408, 'Tooling Manufacturing', 'Machine Trial', 'T0', 4, 'Mold assembling report', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(409, 'Tooling Manufacturing', 'Machine Trial', 'T0', 5, 'Machine 3D data', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(410, 'Tooling Manufacturing', 'Machine Trial', 'T0', 6, 'Machine 2D drawing', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(411, 'Tooling Manufacturing', 'Machine Trial', 'T0', 7, 'Trouble shooting & Alarm List', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(412, 'Tooling Manufacturing', 'Machine Trial', 'T0', 8, 'Machine Training List', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(413, 'Tooling Manufacturing', 'Machine Trial', 'T0', 9, 'Machine Inspection data', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(414, 'Tooling Manufacturing', 'Machine Trial', 'T0', 10, 'Machine Calibration data', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(415, 'Tooling Manufacturing', 'Machine Trial', 'T1', 1, 'Parameter setting', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(416, 'Tooling Manufacturing', 'Machine Trial', 'T1', 2, 'Cycle Confirmation', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(417, 'Tooling Manufacturing', 'Machine Trial', 'T1', 3, 'Inspection data', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(418, 'Tooling Manufacturing', 'Machine Trial', 'T1', 4, 'Trial Report', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(419, 'Tooling Manufacturing', 'Machine Trial', 'T1', 5, 'PFS', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(420, 'Tooling Manufacturing', 'Machine Trial', 'T2', 1, 'Parameter setting', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(421, 'Tooling Manufacturing', 'Machine Trial', 'T2', 2, 'Data Capability', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(422, 'Tooling Manufacturing', 'Machine Trial', 'T2', 3, 'Cycle Confirmation', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(423, 'Tooling Manufacturing', 'Machine Trial', 'T2', 4, 'Inspection data', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(424, 'Tooling Manufacturing', 'Machine Trial', 'T2', 5, 'PFS', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(425, 'Tooling Manufacturing', 'Machine Trial', 'T2', 6, 'Trial Report', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(426, 'Tooling Manufacturing', 'Part Submition', 'T0 event', 1, 'Component Preparation', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(427, 'Tooling Manufacturing', 'Part Submition', 'T0 event', 2, 'Part Assembling', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(428, 'Tooling Manufacturing', 'Part Submition', 'T0 event', 3, 'Quality Check', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(429, 'Tooling Manufacturing', 'Part Submition', 'T0 event', 4, 'Document Completeness', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(430, 'Tooling Manufacturing', 'Part Submition', 'T0 event', 5, 'Part delivery', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(431, 'Tooling Manufacturing', 'AJI PPAP', 'Quality Document', 1, 'Approval QCPC', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(432, 'Tooling Manufacturing', 'AJI PPAP', 'Quality Document', 2, 'PIS', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(433, 'Tooling Manufacturing', 'AJI PPAP', 'Quality Document', 3, 'Check sheet incoming Housing S/A', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(434, 'Tooling Manufacturing', 'AJI PPAP', 'Quality Document', 4, 'Check sheet incoming Lens', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(435, 'Tooling Manufacturing', 'AJI PPAP', 'Quality Document', 5, 'Check sheet incoming Vent cloth', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(436, 'Tooling Manufacturing', 'AJI PPAP', 'Quality Document', 6, 'CF-check sheet', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(437, 'Tooling Manufacturing', 'AJI PPAP', 'Quality Document', 7, 'Ou-going check sheet', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(438, 'Tooling Manufacturing', 'AJI PPAP', 'Quality Document', 8, 'MQS', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(439, 'Tooling Manufacturing', 'AJI PPAP', 'Quality Document', 9, 'QA Matrix', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(440, 'Tooling Manufacturing', 'AJI PPAP', 'Engineering Document', 1, 'Packaging Standard', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(441, 'Tooling Manufacturing', 'AJI PPAP', 'Engineering Document', 2, 'TSK-TSKK', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(442, 'Tooling Manufacturing', 'AJI PPAP', 'Design Document', 1, 'Testing Schedule', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(443, 'Tooling Manufacturing', 'Tooling Evaluation', 'Tooling Evaluation', 1, 'Assembling Confirmation', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(444, 'Tooling Manufacturing', 'Tooling Evaluation', 'Tooling Evaluation', 2, 'Testing Confirmation', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(445, 'Tooling Manufacturing', 'Tooling Evaluation', 'Tooling Evaluation', 3, 'OEE confirmation', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(446, 'Tooling Manufacturing', 'Tooling Evaluation', '1,5 QA Meeting', 1, '1,5 QA Material', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(447, 'Tooling Manufacturing', 'Tooling Evaluation', '1,5 QA Meeting', 2, '1,5 QA Check list', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(448, 'Tooling Manufacturing', 'Tooling Evaluation', '1,5 QA Meeting', 3, 'HLT detail Schedule', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(449, 'Tooling Manufacturing', 'Tooling Evaluation', '1,5 QA Meeting', 4, 'Shipping Judgement', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(450, 'Home Line Trial', 'Tooling Shipment', 'Mold Housing', 1, 'Packaging', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(451, 'Home Line Trial', 'Tooling Shipment', 'Mold Housing', 2, 'Document Completeness', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(452, 'Home Line Trial', 'Tooling Shipment', 'Mold Housing', 3, 'Port Loading', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(453, 'Home Line Trial', 'Tooling Shipment', 'Mold Housing', 4, 'Shipment', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(454, 'Home Line Trial', 'Tooling Shipment', 'Mold Housing', 5, 'Port Unloading', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(455, 'Home Line Trial', 'Tooling Shipment', 'Mold Housing', 6, 'Tax Payment', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(456, 'Home Line Trial', 'Tooling Shipment', 'Mold Housing', 7, 'Custom Clearance', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(457, 'Home Line Trial', 'Tooling Shipment', 'Mold Housing', 8, 'Tranfer to AJI', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(458, 'Home Line Trial', 'Tooling Shipment', 'Mold Housing', 9, 'Unboxing', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(459, 'Home Line Trial', 'Tooling Shipment', 'Mold Housing', 10, 'Mold check', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(460, 'Home Line Trial', 'Tooling Shipment', 'Mold Housing', 11, 'Mold tranfer to Supplier', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(461, 'Home Line Trial', 'Tooling Shipment', 'Mold Lens', 1, 'Packaging', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(462, 'Home Line Trial', 'Tooling Shipment', 'Mold Lens', 2, 'Document Completeness', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(463, 'Home Line Trial', 'Tooling Shipment', 'Mold Lens', 3, 'Port Loading', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(464, 'Home Line Trial', 'Tooling Shipment', 'Mold Lens', 4, 'Shipment', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(465, 'Home Line Trial', 'Tooling Shipment', 'Mold Lens', 5, 'Port Unloading', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(466, 'Home Line Trial', 'Tooling Shipment', 'Mold Lens', 6, 'Tax Payment', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(467, 'Home Line Trial', 'Tooling Shipment', 'Mold Lens', 7, 'Custom Clearance', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(468, 'Home Line Trial', 'Tooling Shipment', 'Mold Lens', 8, 'Tranfer to AJI', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(469, 'Home Line Trial', 'Tooling Shipment', 'Mold Lens', 9, 'Unboxing', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(470, 'Home Line Trial', 'Tooling Shipment', 'Mold Lens', 10, 'Mold check', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(471, 'Home Line Trial', 'Tooling Shipment', 'Mold Lens', 11, 'Mold tranfer to Supplier', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(472, 'Home Line Trial', 'Tooling Shipment', 'Mold Lens', 1, 'Packaging', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(473, 'Home Line Trial', 'Tooling Shipment', 'Mold Lens', 2, 'Document Completeness', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(474, 'Home Line Trial', 'Tooling Shipment', 'Mold Lens', 3, 'Port Loading', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(475, 'Home Line Trial', 'Tooling Shipment', 'Mold Lens', 4, 'Shipment', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(476, 'Home Line Trial', 'Tooling Shipment', 'Mold Lens', 5, 'Port Unloading', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(477, 'Home Line Trial', 'Tooling Shipment', 'Mold Lens', 6, 'Tax Payment', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(478, 'Home Line Trial', 'Tooling Shipment', 'Mold Lens', 7, 'Custom Clearance', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(479, 'Home Line Trial', 'Tooling Shipment', 'Mold Lens', 8, 'Tranfer to AJI', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(480, 'Home Line Trial', 'Tooling Shipment', 'Mold Lens', 9, 'Unboxing', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(481, 'Home Line Trial', 'Tooling Shipment', 'Mold Lens', 10, 'Mold check', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(482, 'Home Line Trial', 'Tooling Shipment', 'Mold Lens', 11, 'Mold tranfer to Supplier', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(483, 'Home Line Trial', 'Tooling Shipment', 'Machine Auto', 1, 'Packaging', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(484, 'Home Line Trial', 'Tooling Shipment', 'Machine Auto', 2, 'Document Completeness', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(485, 'Home Line Trial', 'Tooling Shipment', 'Machine Auto', 3, 'Port Loading', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(486, 'Home Line Trial', 'Tooling Shipment', 'Machine Auto', 4, 'Shipment', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(487, 'Home Line Trial', 'Tooling Shipment', 'Machine Auto', 5, 'Port Unloading', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(488, 'Home Line Trial', 'Tooling Shipment', 'Machine Auto', 6, 'Tax Payment', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(489, 'Home Line Trial', 'Tooling Shipment', 'Machine Auto', 7, 'Custom Clearance', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(490, 'Home Line Trial', 'Tooling Shipment', 'Machine Auto', 8, 'Tranfer to AJI', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(491, 'Home Line Trial', 'Tooling Shipment', 'Machine Auto', 9, 'Unboxing', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(492, 'Home Line Trial', 'Tooling Shipment', 'Machine Auto', 10, 'MC Installment', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(493, 'Home Line Trial', 'Tooling Shipment', 'Machine Hot Insert', 1, 'Packaging', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(494, 'Home Line Trial', 'Tooling Shipment', 'Machine Hot Insert', 2, 'Document Completeness', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(495, 'Home Line Trial', 'Tooling Shipment', 'Machine Hot Insert', 3, 'Port Loading', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(496, 'Home Line Trial', 'Tooling Shipment', 'Machine Hot Insert', 4, 'Shipment', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(497, 'Home Line Trial', 'Tooling Shipment', 'Machine Hot Insert', 5, 'Port Unloading', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(498, 'Home Line Trial', 'Tooling Shipment', 'Machine Hot Insert', 6, 'Tax Payment', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(499, 'Home Line Trial', 'Tooling Shipment', 'Machine Hot Insert', 7, 'Custom Clearance', '2025-07-21 08:58:02', '2025-07-21 15:58:02', NULL),
(500, 'Home Line Trial', 'Tooling Shipment', 'Machine Hot Insert', 8, 'Tranfer to AJI', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(501, 'Home Line Trial', 'Tooling Shipment', 'Machine Hot Insert', 9, 'Unboxing', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(502, 'Home Line Trial', 'Tooling Shipment', 'Machine Hot Insert', 10, 'MC Installment', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(503, 'Home Line Trial', 'Tooling Shipment', 'Machine CCD', 1, 'Packaging', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(504, 'Home Line Trial', 'Tooling Shipment', 'Machine CCD', 2, 'Document Completeness', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(505, 'Home Line Trial', 'Tooling Shipment', 'Machine CCD', 3, 'Port Loading', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(506, 'Home Line Trial', 'Tooling Shipment', 'Machine CCD', 4, 'Shipment', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(507, 'Home Line Trial', 'Tooling Shipment', 'Machine CCD', 5, 'Port Unloading', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(508, 'Home Line Trial', 'Tooling Shipment', 'Machine CCD', 6, 'Tax Payment', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(509, 'Home Line Trial', 'Tooling Shipment', 'Machine CCD', 7, 'Custom Clearance', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(510, 'Home Line Trial', 'Tooling Shipment', 'Machine CCD', 8, 'Tranfer to AJI', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(511, 'Home Line Trial', 'Tooling Shipment', 'Machine CCD', 9, 'Unboxing', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(512, 'Home Line Trial', 'Tooling Shipment', 'Machine CCD', 10, 'MC Installment', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(513, 'Home Line Trial', 'Tooling Shipment', 'Machine Laser Marking', 1, 'Tranfer to AJI', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(514, 'Home Line Trial', 'Tooling Shipment', 'Machine Laser Marking', 2, 'MC Installment', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(515, 'Home Line Trial', 'Tooling Shipment', 'Machine Annealing Oven', 1, 'Tranfer to AJI', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(516, 'Home Line Trial', 'Tooling Shipment', 'Machine Annealing Oven', 2, 'MC Installment', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(517, 'Home Line Trial', 'HLT1', 'Lens Injection', 1, 'Parameter setting', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(518, 'Home Line Trial', 'HLT1', 'Lens Injection', 2, 'Cycle Confirmation', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(519, 'Home Line Trial', 'HLT1', 'Lens Injection', 3, 'Part weight confirmation', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(520, 'Home Line Trial', 'HLT1', 'Lens Injection', 4, 'Inspection data', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(521, 'Home Line Trial', 'HLT1', 'Lens Injection', 5, 'Trial Report', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(522, 'Home Line Trial', 'HLT1', 'Lens Injection', 6, 'Tooling Completeness Check', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(523, 'Home Line Trial', 'HLT1', 'Lens Injection', 7, 'N1 data', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(524, 'Home Line Trial', 'HLT1', 'Lens Injection', 8, 'PFS', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(525, 'Home Line Trial', 'HLT1', 'Housing Injection', 1, 'Parameter setting', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(526, 'Home Line Trial', 'HLT1', 'Housing Injection', 2, 'Cycle Confirmation', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(527, 'Home Line Trial', 'HLT1', 'Housing Injection', 3, 'Part weight confirmation', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(528, 'Home Line Trial', 'HLT1', 'Housing Injection', 4, 'Inspection data', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(529, 'Home Line Trial', 'HLT1', 'Housing Injection', 5, 'Trial Report', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(530, 'Home Line Trial', 'HLT1', 'Housing Injection', 6, 'Tooling Completeness Check', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(531, 'Home Line Trial', 'HLT1', 'Housing Injection', 7, 'N1 data', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(532, 'Home Line Trial', 'HLT1', 'Housing Injection', 8, 'PFS', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(533, 'Home Line Trial', 'HLT1', 'Hot Insert', 1, 'Parameter setting', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(534, 'Home Line Trial', 'HLT1', 'Hot Insert', 2, 'Cycle Confirmation', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(535, 'Home Line Trial', 'HLT1', 'Hot Insert', 3, 'Inspection data', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(536, 'Home Line Trial', 'HLT1', 'Hot Insert', 4, 'Trial Report', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(537, 'Home Line Trial', 'HLT1', 'Hot Insert', 5, 'Tooling Completeness Check', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(538, 'Home Line Trial', 'HLT1', 'Hot Insert', 6, 'N1 data', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(539, 'Home Line Trial', 'HLT1', 'Hot Insert', 7, 'PFS', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(540, 'Home Line Trial', 'HLT1', 'Wire Assembling (DEM)', 1, 'Parameter setting', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(541, 'Home Line Trial', 'HLT1', 'Wire Assembling (DEM)', 2, 'Cycle Confirmation', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(542, 'Home Line Trial', 'HLT1', 'Wire Assembling (DEM)', 3, 'Inspection data', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(543, 'Home Line Trial', 'HLT1', 'Wire Assembling (DEM)', 4, 'Trial Report', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(544, 'Home Line Trial', 'HLT1', 'Wire Assembling (DEM)', 5, 'Tooling Completeness Check', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(545, 'Home Line Trial', 'HLT1', 'Wire Assembling (DEM)', 6, 'N1 data', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(546, 'Home Line Trial', 'HLT1', 'Wire Assembling (DEM)', 7, 'PFS', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(547, 'Home Line Trial', 'HLT1', 'PCB Soldering & Screwing', 1, 'Parameter setting', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(548, 'Home Line Trial', 'HLT1', 'PCB Soldering & Screwing', 2, 'Cycle Confirmation', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(549, 'Home Line Trial', 'HLT1', 'PCB Soldering & Screwing', 3, 'Inspection data', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(550, 'Home Line Trial', 'HLT1', 'PCB Soldering & Screwing', 4, 'Trial Report', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(551, 'Home Line Trial', 'HLT1', 'PCB Soldering & Screwing', 5, 'Tooling Completeness Check', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(552, 'Home Line Trial', 'HLT1', 'PCB Soldering & Screwing', 6, 'N1 data', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(553, 'Home Line Trial', 'HLT1', 'PCB Soldering & Screwing', 7, 'PFS', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(554, 'Home Line Trial', 'HLT1', 'Winker Assy RH Auto Assembling', 1, 'Parameter setting', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(555, 'Home Line Trial', 'HLT1', 'Winker Assy RH Auto Assembling', 2, 'Cycle Confirmation', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(556, 'Home Line Trial', 'HLT1', 'Winker Assy RH Auto Assembling', 3, 'Inspection data', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(557, 'Home Line Trial', 'HLT1', 'Winker Assy RH Auto Assembling', 4, 'Trial Report', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(558, 'Home Line Trial', 'HLT1', 'Winker Assy RH Auto Assembling', 5, 'Tooling Completeness Check', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(559, 'Home Line Trial', 'HLT1', 'Winker Assy RH Auto Assembling', 6, 'N1 data', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(560, 'Home Line Trial', 'HLT1', 'Winker Assy RH Auto Assembling', 7, 'PFS', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(561, 'Home Line Trial', 'HLT1', 'Winker Assy LH Auto Assembling', 1, 'Parameter setting', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(562, 'Home Line Trial', 'HLT1', 'Winker Assy LH Auto Assembling', 2, 'Cycle Confirmation', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(563, 'Home Line Trial', 'HLT1', 'Winker Assy LH Auto Assembling', 3, 'Inspection data', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(564, 'Home Line Trial', 'HLT1', 'Winker Assy LH Auto Assembling', 4, 'Trial Report', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(565, 'Home Line Trial', 'HLT1', 'Winker Assy LH Auto Assembling', 5, 'Tooling Completeness Check', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(566, 'Home Line Trial', 'HLT1', 'Winker Assy LH Auto Assembling', 6, 'N1 data', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(567, 'Home Line Trial', 'HLT1', 'Winker Assy LH Auto Assembling', 7, 'PFS', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(568, 'Home Line Trial', 'HLT1', 'Winker Assy RH Manual Assembling', 1, 'Parameter setting', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(569, 'Home Line Trial', 'HLT1', 'Winker Assy RH Manual Assembling', 2, 'Cycle Confirmation', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(570, 'Home Line Trial', 'HLT1', 'Winker Assy RH Manual Assembling', 3, 'Inspection data', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(571, 'Home Line Trial', 'HLT1', 'Winker Assy RH Manual Assembling', 4, 'Trial Report', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(572, 'Home Line Trial', 'HLT1', 'Winker Assy RH Manual Assembling', 5, 'Tooling Completeness Check', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(573, 'Home Line Trial', 'HLT1', 'Winker Assy RH Manual Assembling', 6, 'N1 data', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(574, 'Home Line Trial', 'HLT1', 'Winker Assy RH Manual Assembling', 7, 'PFS', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(575, 'Home Line Trial', 'HLT1', 'Winker Assy LH Manual Assembling', 1, 'Parameter setting', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(576, 'Home Line Trial', 'HLT1', 'Winker Assy LH Manual Assembling', 2, 'Cycle Confirmation', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(577, 'Home Line Trial', 'HLT1', 'Winker Assy LH Manual Assembling', 3, 'Inspection data', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(578, 'Home Line Trial', 'HLT1', 'Winker Assy LH Manual Assembling', 4, 'Trial Report', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(579, 'Home Line Trial', 'HLT1', 'Winker Assy LH Manual Assembling', 5, 'Tooling Completeness Check', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(580, 'Home Line Trial', 'HLT1', 'Winker Assy LH Manual Assembling', 6, 'N1 data', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(581, 'Home Line Trial', 'HLT1', 'Winker Assy LH Manual Assembling', 7, 'PFS', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(582, 'Home Line Trial', 'Part Submition', 'PP1 event', 1, 'Component Preparation', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(583, 'Home Line Trial', 'Part Submition', 'PP1 event', 2, 'Part Assembling', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(584, 'Home Line Trial', 'Part Submition', 'PP1 event', 3, 'Quality Check', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(585, 'Home Line Trial', 'Part Submition', 'PP1 event', 4, 'Document Completeness', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(586, 'Home Line Trial', 'Part Submition', 'PP1 event', 5, 'Part delivery', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(587, 'Home Line Trial', 'System Update', 'Maris System', 1, 'MRP', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(588, 'Home Line Trial', 'System Update', 'Maris System', 2, 'PRO', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(589, 'Home Line Trial', 'System Update', 'IMDS', 1, 'Component Data', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(590, 'Home Line Trial', 'System Update', 'IMDS', 2, 'Assy Data', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(591, 'Home Line Trial', 'HLT2', 'Winker Assy RH Auto Assembling', 1, 'Parameter setting', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(592, 'Home Line Trial', 'HLT2', 'Winker Assy RH Auto Assembling', 2, 'Data Capability', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(593, 'Home Line Trial', 'HLT2', 'Winker Assy RH Auto Assembling', 3, 'Cycle Confirmation', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(594, 'Home Line Trial', 'HLT2', 'Winker Assy RH Auto Assembling', 4, 'PFS', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(595, 'Home Line Trial', 'HLT2', 'Winker Assy RH Auto Assembling', 5, 'Trial Report', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(596, 'Home Line Trial', 'HLT2', 'Winker Assy LH Auto Assembling', 1, 'Parameter setting', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(597, 'Home Line Trial', 'HLT2', 'Winker Assy LH Auto Assembling', 2, 'Data Capability', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(598, 'Home Line Trial', 'HLT2', 'Winker Assy LH Auto Assembling', 3, 'Cycle Confirmation', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(599, 'Home Line Trial', 'HLT2', 'Winker Assy LH Auto Assembling', 4, 'PFS', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(600, 'Home Line Trial', 'HLT2', 'Winker Assy LH Auto Assembling', 5, 'Trial Report', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(601, 'Home Line Trial', 'HLT2', 'Winker Assy RH Manual Assembling', 1, 'Parameter setting', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(602, 'Home Line Trial', 'HLT2', 'Winker Assy RH Manual Assembling', 2, 'Data Capability', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(603, 'Home Line Trial', 'HLT2', 'Winker Assy RH Manual Assembling', 3, 'Cycle Confirmation', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(604, 'Home Line Trial', 'HLT2', 'Winker Assy RH Manual Assembling', 4, 'PFS', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(605, 'Home Line Trial', 'HLT2', 'Winker Assy RH Manual Assembling', 5, 'Trial Report', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(606, 'Home Line Trial', 'HLT2', 'Winker Assy LH Manual Assembling', 1, 'Parameter setting', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(607, 'Home Line Trial', 'HLT2', 'Winker Assy LH Manual Assembling', 2, 'Data Capability', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(608, 'Home Line Trial', 'HLT2', 'Winker Assy LH Manual Assembling', 3, 'Cycle Confirmation', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(609, 'Home Line Trial', 'HLT2', 'Winker Assy LH Manual Assembling', 4, 'PFS', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(610, 'Home Line Trial', 'HLT2', 'Winker Assy LH Manual Assembling', 5, 'Trial Report', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(611, 'Home Line Trial', 'HLT2', 'Hot Insert', 1, 'Parameter setting', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(612, 'Home Line Trial', 'HLT2', 'Hot Insert', 2, 'Data Capability', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(613, 'Home Line Trial', 'HLT2', 'Hot Insert', 3, 'Cycle Confirmation', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(614, 'Home Line Trial', 'HLT2', 'Hot Insert', 4, 'PFS', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(615, 'Home Line Trial', 'HLT2', 'Hot Insert', 5, 'Trial Report', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(616, 'Home Line Trial', 'Part Submition', 'PP2 event', 1, 'Component Preparation', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(617, 'Home Line Trial', 'Part Submition', 'PP2 event', 2, 'Part Assembling', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(618, 'Home Line Trial', 'Part Submition', 'PP2 event', 3, 'Quality Check', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(619, 'Home Line Trial', 'Part Submition', 'PP2 event', 4, 'Document Completeness', '2025-07-21 08:58:03', '2025-07-21 15:58:03', NULL),
(620, 'Home Line Trial', 'Part Submition', 'PP2 event', 5, 'Part delivery', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(621, 'Home Line Trial', 'Production Preparation', 'Document', 1, 'Work Instruction', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(622, 'Home Line Trial', 'Production Preparation', 'Document', 2, 'Standard Parameter Setting', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(623, 'Home Line Trial', 'Production Preparation', 'Document', 3, 'First Verification Sheet', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(624, 'Home Line Trial', 'Production Preparation', 'Document', 4, 'Dandori Check Sheet', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(625, 'Home Line Trial', 'Production Preparation', 'Limit Sample', 1, 'Appearance Approval Strandard', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(626, 'Home Line Trial', 'Production Preparation', 'Limit Sample', 2, 'Quality Check Point', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(627, 'Home Line Trial', 'Production Preparation', 'Limit Sample', 3, 'Limit sample Airleak RH', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(628, 'Home Line Trial', 'Production Preparation', 'Limit Sample', 4, 'Limit sample Airleak LH', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(629, 'Home Line Trial', 'Production Preparation', 'Limit Sample', 5, 'Limit sample CCD RH', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(630, 'Home Line Trial', 'Production Preparation', 'Limit Sample', 6, 'Limit sample CCD LH', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(631, 'Home Line Trial', 'Production Preparation', 'Packaging Standard', 1, 'Packaging Calculation', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(632, 'Home Line Trial', 'Production Preparation', 'Packaging Standard', 2, 'FG Box Ordering', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(633, 'Home Line Trial', 'Production Preparation', 'Packaging Standard', 3, 'FG Box Readiness', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(634, 'Home Line Trial', 'Production Preparation', 'Chuter', 1, 'Chutter Part', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(635, 'Home Line Trial', 'Production Preparation', 'Chuter', 2, 'Chutter FG', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(636, 'Home Line Trial', 'Production Preparation', 'WH area', 1, 'Housing S/A WH', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(637, 'Home Line Trial', 'Production Preparation', 'WH area', 2, 'Lens WH', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(638, 'Home Line Trial', 'Production Preparation', 'WH area', 3, 'Vent cloth WH', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(639, 'Home Line Trial', 'Production Preparation', 'WH area', 4, 'Winker Assy RH WH', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(640, 'Home Line Trial', 'Production Preparation', 'WH area', 5, 'Winker Assy LH WH', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(641, 'Home Line Trial', 'Production Preparation', 'MP preparation', 1, 'MP Request', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(642, 'Home Line Trial', 'Production Preparation', 'MP preparation', 2, 'MP Recruitment', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(643, 'Home Line Trial', 'Production Preparation', 'MP preparation', 3, 'MP Training', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(644, 'Home Line Trial', 'Production Preparation', 'MP preparation', 4, 'MP Skill Evaluation', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(645, 'Home Line Trial', 'Supplier Audit', 'SPTT4', 1, 'Lens', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(646, 'Home Line Trial', 'Supplier Audit', 'SPTT4', 2, 'Housing', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(647, 'Home Line Trial', 'Supplier Audit', 'SPTT4', 3, 'Insert Nut', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(648, 'Home Line Trial', 'Supplier Audit', 'SPTT4', 4, 'PCB', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(649, 'Home Line Trial', 'Supplier Audit', 'SPTT4', 5, 'Wire Harness', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(650, 'Home Line Trial', 'Supplier Audit', 'SPTT4', 6, 'Tapping Screw', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(651, 'Home Line Trial', 'Supplier Audit', 'SPTT4', 7, 'Vent Cloth', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(652, 'Home Line Trial', 'Supplier Audit', 'SPTT4', 8, 'Housing S/A', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(653, 'Home Line Trial', 'Supplier Audit', 'SPTT4', 9, 'Electronic Component', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(654, 'Home Line Trial', 'Supplier Approval', 'QAV2', 1, 'Lens', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(655, 'Home Line Trial', 'Supplier Approval', 'QAV2', 2, 'Housing', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(656, 'Home Line Trial', 'Supplier Approval', 'QAV2', 3, 'Insert Nut', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(657, 'Home Line Trial', 'Supplier Approval', 'QAV2', 4, 'PCB', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(658, 'Home Line Trial', 'Supplier Approval', 'QAV2', 5, 'Wire Harness', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(659, 'Home Line Trial', 'Supplier Approval', 'QAV2', 6, 'Tapping Screw', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(660, 'Home Line Trial', 'Supplier Approval', 'QAV2', 7, 'Vent Cloth', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(661, 'Home Line Trial', 'Supplier Approval', 'QAV2', 8, 'Housing S/A', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(662, 'Home Line Trial', 'Supplier Approval', 'QAV2', 9, 'Electronic Component', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(663, 'Home Line Trial', 'Testing', 'Part Preparation', 1, 'Part Assembling', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(664, 'Home Line Trial', 'Testing', 'Part Preparation', 2, 'Part shipment', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(665, 'Home Line Trial', 'Testing', 'Material test', 1, 'Material test report', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(666, 'Home Line Trial', 'Testing', 'Testing', 1, 'Midle test report', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(667, 'Home Line Trial', 'Testing', 'Testing', 2, 'Final test report', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(668, 'Home Line Trial', 'Material Preparation', 'Vent Cloth', 1, 'PR', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(669, 'Home Line Trial', 'Material Preparation', 'Vent Cloth', 2, 'PO', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(670, 'Home Line Trial', 'Material Preparation', 'Vent Cloth', 3, 'Supplier delivery confirmation', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(671, 'Home Line Trial', 'Material Preparation', 'Vent Cloth', 4, 'Material readiness', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(672, 'Home Line Trial', 'Material Preparation', 'Vent Cloth', 5, 'Material Shipment', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(673, 'Home Line Trial', 'Material Preparation', 'Lens', 1, 'PR', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(674, 'Home Line Trial', 'Material Preparation', 'Lens', 2, 'PO', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(675, 'Home Line Trial', 'Material Preparation', 'Lens', 3, 'Supplier delivery confirmation', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(676, 'Home Line Trial', 'Material Preparation', 'Lens', 4, 'Material readiness', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(677, 'Home Line Trial', 'Material Preparation', 'Lens', 5, 'Material Shipment', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(678, 'Home Line Trial', 'Material Preparation', 'Housing S/A', 1, 'PR', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(679, 'Home Line Trial', 'Material Preparation', 'Housing S/A', 2, 'PO', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(680, 'Home Line Trial', 'Material Preparation', 'Housing S/A', 3, 'Supplier delivery confirmation', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(681, 'Home Line Trial', 'Material Preparation', 'Housing S/A', 4, 'Material readiness', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(682, 'Home Line Trial', 'Material Preparation', 'Housing S/A', 5, 'Material Shipment', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(683, 'Home Line Trial', 'HLT3', 'Winker Assy RH Auto Assembling', 1, 'NG Rate Evaluation', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(684, 'Home Line Trial', 'HLT3', 'Winker Assy RH Auto Assembling', 2, 'Machine breakdown Evaluation', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(685, 'Home Line Trial', 'HLT3', 'Winker Assy RH Auto Assembling', 3, 'Cycle Evaluation', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(686, 'Home Line Trial', 'HLT3', 'Winker Assy RH Auto Assembling', 4, 'Rework Rate Evaluation', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(687, 'Home Line Trial', 'HLT3', 'Winker Assy RH Auto Assembling', 5, 'PFS', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(688, 'Home Line Trial', 'HLT3', 'Winker Assy RH Auto Assembling', 6, 'Trial Report', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(689, 'Home Line Trial', 'HLT3', 'Winker Assy LH Auto Assembling', 1, 'NG Rate Evaluation', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(690, 'Home Line Trial', 'HLT3', 'Winker Assy LH Auto Assembling', 2, 'Machine breakdown Evaluation', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(691, 'Home Line Trial', 'HLT3', 'Winker Assy LH Auto Assembling', 3, 'Cycle Evaluation', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(692, 'Home Line Trial', 'HLT3', 'Winker Assy LH Auto Assembling', 4, 'Rework Rate Evaluation', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(693, 'Home Line Trial', 'HLT3', 'Winker Assy LH Auto Assembling', 5, 'PFS', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(694, 'Home Line Trial', 'HLT3', 'Winker Assy LH Auto Assembling', 6, 'Trial Report', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(695, 'Home Line Trial', 'HLT3', 'Winker Assy RH Manual Assembling', 1, 'NG Rate Evaluation', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(696, 'Home Line Trial', 'HLT3', 'Winker Assy RH Manual Assembling', 2, 'Machine breakdown Evaluation', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(697, 'Home Line Trial', 'HLT3', 'Winker Assy RH Manual Assembling', 3, 'Cycle Evaluation', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(698, 'Home Line Trial', 'HLT3', 'Winker Assy RH Manual Assembling', 4, 'Rework Rate Evaluation', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(699, 'Home Line Trial', 'HLT3', 'Winker Assy RH Manual Assembling', 5, 'PFS', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(700, 'Home Line Trial', 'HLT3', 'Winker Assy RH Manual Assembling', 6, 'Trial Report', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(701, 'Home Line Trial', 'HLT3', 'Winker Assy LH Manual Assembling', 1, 'NG Rate Evaluation', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(702, 'Home Line Trial', 'HLT3', 'Winker Assy LH Manual Assembling', 2, 'Machine breakdown Evaluation', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(703, 'Home Line Trial', 'HLT3', 'Winker Assy LH Manual Assembling', 3, 'Cycle Evaluation', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(704, 'Home Line Trial', 'HLT3', 'Winker Assy LH Manual Assembling', 4, 'Rework Rate Evaluation', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(705, 'Home Line Trial', 'HLT3', 'Winker Assy LH Manual Assembling', 5, 'PFS', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(706, 'Home Line Trial', 'HLT3', 'Winker Assy LH Manual Assembling', 6, 'Trial Report', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(707, 'Home Line Trial', 'HLT3', 'Hot Insert', 1, 'NG Rate Evaluation', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(708, 'Home Line Trial', 'HLT3', 'Hot Insert', 2, 'Machine breakdown Evaluation', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(709, 'Home Line Trial', 'HLT3', 'Hot Insert', 3, 'Cycle Evaluation', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(710, 'Home Line Trial', 'HLT3', 'Hot Insert', 4, 'Rework Rate Evaluation', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(711, 'Home Line Trial', 'HLT3', 'Hot Insert', 5, 'PFS', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(712, 'Home Line Trial', 'HLT3', 'Hot Insert', 6, 'Trial Report', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(713, 'Home Line Trial', 'Mass-pro Preparation Evaluation', '2nd QA Meeting', 1, '2nd QA Material', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(714, 'Home Line Trial', 'Mass-pro Preparation Evaluation', '2nd QA Meeting', 2, 'PQSO', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL),
(715, 'Initial Masspro', 'Event Masspro', 'Detail Masspro', 1, 'task 1', '2025-07-21 08:58:04', '2025-07-21 15:58:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `npp_pica_aji_internal_schedule`
--

CREATE TABLE `npp_pica_aji_internal_schedule` (
  `id` int(130) NOT NULL,
  `project_title` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `category_problem` varchar(30) NOT NULL,
  `problem` varchar(255) DEFAULT NULL,
  `id_item_schedule` int(11) NOT NULL,
  `root_cause` text DEFAULT NULL,
  `countermeasure` text DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `type_attachment` varchar(7) NOT NULL,
  `pic` varchar(255) DEFAULT NULL,
  `Dept` varchar(255) NOT NULL,
  `due_date` date DEFAULT NULL,
  `progress` int(11) NOT NULL DEFAULT 0 COMMENT '0 => open\r\n1 => close\r\n2 => cancel\r\n3 => postpone\r\n\r\n',
  `remark` text DEFAULT NULL,
  `judge` int(1) DEFAULT NULL COMMENT '0=ng,1=ok',
  `judge_by` varchar(255) DEFAULT NULL,
  `last_edit_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `npp_pica_aji_internal_schedule`
--

INSERT INTO `npp_pica_aji_internal_schedule` (`id`, `project_title`, `type`, `category_problem`, `problem`, `id_item_schedule`, `root_cause`, `countermeasure`, `attachment`, `type_attachment`, `pic`, `Dept`, `due_date`, `progress`, `remark`, `judge`, `judge_by`, `last_edit_by`, `updated_at`, `created_at`) VALUES
(2, 'K2V v1', 'Delay Start', 'General', 'Problem', 113, 'Root Cause', 'Counter Measure', '', '', 'Miqdad Agil Amarullah', 'HRGAEI', '2025-07-31', 1, NULL, NULL, NULL, 'Miqdad Agil Amarullah', '2025-08-01 10:13:16', '2025-08-01 03:13:16'),
(3, 'K2V', 'Delay Start', 'General', 'CG', 68, NULL, NULL, '', '', 'Ridwan Syarif', 'PRODENG', '2025-05-08', 1, NULL, NULL, NULL, 'Ridwan Syarif', '2025-07-31 14:51:06', '2025-07-31 07:51:06'),
(4, 'K2V v1', 'Delay Start', 'Man Power', 'Surii Lelet', 213, 'Bad Mood', 'Healing', '', '', 'Ridwan Syarif', 'PRODENG', '2025-01-08', 1, NULL, NULL, NULL, 'Ridwan Syarif', '2025-07-31 13:42:00', '2025-07-31 06:42:00'),
(5, 'K2V', 'Delay Start', 'Man Power', 'Made lupa', 38, 'banyak pikiran', 'bikin reminder', '', '', 'I Made Wahyu Karma Yoga', 'PM', '2025-07-31', 1, NULL, NULL, NULL, 'I Made Wahyu Karma Yoga', '2025-07-31 13:56:39', '2025-07-31 06:56:39'),
(6, 'K2V', 'Delay Start', '', NULL, 1, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(7, 'K2V', 'Delay Start', '', NULL, 2, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(8, 'K2V', 'Delay Start', '', NULL, 3, NULL, NULL, NULL, '', 'MKT', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(9, 'K2V', 'Delay Start', '', NULL, 4, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(10, 'K2V', 'Delay Start', '', NULL, 5, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(11, 'K2V', 'Delay Start', '', NULL, 6, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(12, 'K2V', 'Delay Start', '', NULL, 7, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(13, 'K2V', 'Delay Start', '', NULL, 8, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(14, 'K2V', 'Delay Start', '', NULL, 9, NULL, NULL, NULL, '', 'RND', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(15, 'K2V', 'Delay Start', '', NULL, 10, NULL, NULL, NULL, '', 'RND', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(16, 'K2V', 'Delay Start', '', NULL, 11, NULL, NULL, NULL, '', 'RND', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(17, 'K2V', 'Delay Start', '', NULL, 12, NULL, NULL, NULL, '', 'RND', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(18, 'K2V', 'Delay Start', '', NULL, 13, NULL, NULL, NULL, '', 'RND', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(19, 'K2V', 'Delay Start', '', NULL, 14, NULL, NULL, NULL, '', 'EHS', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(20, 'K2V', 'Delay Start', '', NULL, 15, NULL, NULL, NULL, '', 'EXIM', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(21, 'K2V', 'Delay Start', '', NULL, 16, NULL, NULL, NULL, '', 'EXIM', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(22, 'K2V', 'Delay Start', '', NULL, 17, NULL, NULL, NULL, '', 'FA', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(23, 'K2V', 'Delay Start', '', NULL, 18, NULL, NULL, NULL, '', 'QE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(24, 'K2V', 'Delay Start', '', NULL, 19, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(25, 'K2V', 'Delay Start', '', NULL, 20, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(26, 'K2V', 'Delay Start', '', NULL, 21, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(27, 'K2V', 'Delay Start', '', NULL, 22, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(28, 'K2V', 'Delay Start', '', NULL, 23, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(29, 'K2V', 'Delay Start', '', NULL, 24, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(30, 'K2V', 'Delay Start', '', NULL, 25, NULL, NULL, NULL, '', 'QA', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(31, 'K2V', 'Delay Start', '', NULL, 26, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(32, 'K2V', 'Delay Start', '', NULL, 27, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(33, 'K2V', 'Delay Start', '', NULL, 28, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(34, 'K2V', 'Delay Start', '', NULL, 29, NULL, NULL, NULL, '', 'QA', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(35, 'K2V', 'Delay Start', '', NULL, 30, NULL, NULL, NULL, '', 'QE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(36, 'K2V', 'Delay Start', '', NULL, 31, NULL, NULL, NULL, '', 'QE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(37, 'K2V', 'Delay Start', '', NULL, 32, NULL, NULL, NULL, '', 'RND', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(38, 'K2V', 'Delay Start', '', NULL, 33, NULL, NULL, NULL, '', 'RND', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(39, 'K2V', 'Delay Start', '', NULL, 34, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(40, 'K2V', 'Delay Start', '', NULL, 35, NULL, NULL, NULL, '', 'PEINJ', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(41, 'K2V', 'Delay Start', '', NULL, 36, NULL, NULL, NULL, '', 'MM', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(42, 'K2V', 'Delay Start', '', NULL, 37, NULL, NULL, NULL, '', 'RND', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(43, 'K2V', 'Delay Start', '', NULL, 39, NULL, NULL, NULL, '', 'PE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(44, 'K2V', 'Delay Start', '', NULL, 40, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(45, 'K2V', 'Delay Start', '', NULL, 41, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(46, 'K2V', 'Delay Start', '', NULL, 42, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(47, 'K2V', 'Delay Start', '', NULL, 43, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(48, 'K2V', 'Delay Start', '', NULL, 44, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(49, 'K2V', 'Delay Start', '', NULL, 45, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(50, 'K2V', 'Delay Start', '', NULL, 46, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(51, 'K2V', 'Delay Start', '', NULL, 47, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(52, 'K2V', 'Delay Start', '', NULL, 48, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(53, 'K2V', 'Delay Start', '', NULL, 49, NULL, NULL, NULL, '', 'RND', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(54, 'K2V', 'Delay Start', '', NULL, 50, NULL, NULL, NULL, '', 'WH', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(55, 'K2V', 'Delay Start', '', NULL, 51, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(56, 'K2V', 'Delay Start', '', NULL, 53, NULL, NULL, NULL, '', 'DEL', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(57, 'K2V', 'Delay Start', '', NULL, 54, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(58, 'K2V', 'Delay Start', '', NULL, 55, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(59, 'K2V', 'Delay Start', '', NULL, 56, NULL, NULL, NULL, '', 'DEL', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(60, 'K2V', 'Delay Start', '', NULL, 57, NULL, NULL, NULL, '', 'ASMBLI', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(61, 'K2V', 'Delay Start', '', NULL, 58, NULL, NULL, NULL, '', 'ASMBLI', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(62, 'K2V', 'Delay Start', '', NULL, 59, NULL, NULL, NULL, '', 'MEINJ', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(63, 'K2V', 'Delay Start', '', NULL, 60, NULL, NULL, NULL, '', 'BNF', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(64, 'K2V', 'Delay Start', '', NULL, 61, NULL, NULL, NULL, '', 'QC', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(65, 'K2V', 'Delay Start', '', NULL, 62, NULL, NULL, NULL, '', 'MKT', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(66, 'K2V', 'Delay Start', '', NULL, 63, NULL, NULL, NULL, '', 'QE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(67, 'K2V', 'Delay Start', '', NULL, 64, NULL, NULL, NULL, '', 'QA', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(68, 'K2V', 'Delay Start', '', NULL, 65, NULL, NULL, NULL, '', 'RND', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(69, 'K2V', 'Delay Start', '', NULL, 66, NULL, NULL, NULL, '', 'QRO', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(70, 'K2V', 'Delay Start', '', NULL, 67, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(71, 'K2V', 'Delay Start', '', NULL, 69, NULL, NULL, NULL, '', 'SUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(72, 'K2V', 'Delay Start', '', NULL, 70, NULL, NULL, NULL, '', 'IC', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(73, 'K2V', 'Delay Start', '', NULL, 71, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(74, 'K2V', 'Delay Start', '', NULL, 75, NULL, NULL, NULL, '', 'EXIM', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(75, 'K2V', 'Delay Start', '', NULL, 76, NULL, NULL, NULL, '', 'RND', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(76, 'K2V', 'Delay Start', '', NULL, 77, NULL, NULL, NULL, '', 'RND', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(77, 'K2V', 'Delay Start', '', NULL, 79, NULL, NULL, NULL, '', 'EHS', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(78, 'K2V', 'Delay Start', '', NULL, 80, NULL, NULL, NULL, '', 'EHS', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(79, 'K2V', 'Delay Start', '', NULL, 82, NULL, NULL, NULL, '', 'LA', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(80, 'K2V', 'Delay Start', '', NULL, 83, NULL, NULL, NULL, '', 'EXIM', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(81, 'K2V', 'Delay Start', '', NULL, 84, NULL, NULL, NULL, '', 'MKT', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(82, 'K2V', 'Delay Start', '', NULL, 95, NULL, NULL, NULL, '', 'DEL', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(83, 'K2V', 'Delay Start', '', NULL, 96, NULL, NULL, NULL, '', 'ASMBLI', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(84, 'K2V', 'Delay Start', '', NULL, 97, NULL, NULL, NULL, '', 'WH', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(85, 'K2V', 'Delay Start', '', NULL, 98, NULL, NULL, NULL, '', 'PROD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(86, 'K2V', 'Delay Start', '', NULL, 101, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(87, 'K2V', 'Delay Start', '', NULL, 103, NULL, NULL, NULL, '', 'QE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(88, 'K2V v1', 'Delay Start', '', NULL, 114, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(89, 'K2V v1', 'Delay Start', '', NULL, 115, NULL, NULL, NULL, '', 'MKT', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(90, 'K2V v1', 'Delay Start', '', NULL, 116, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(91, 'K2V v1', 'Delay Start', '', NULL, 117, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(92, 'K2V v1', 'Delay Start', '', NULL, 118, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(93, 'K2V v1', 'Delay Start', '', NULL, 119, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(94, 'K2V v1', 'Delay Start', '', NULL, 120, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(95, 'K2V v1', 'Delay Start', '', NULL, 121, NULL, NULL, NULL, '', 'RND', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(96, 'K2V v1', 'Delay Start', '', NULL, 122, NULL, NULL, NULL, '', 'RND', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(97, 'K2V v1', 'Delay Start', '', NULL, 123, NULL, NULL, NULL, '', 'RND', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(98, 'K2V v1', 'Delay Start', '', NULL, 124, NULL, NULL, NULL, '', 'RND', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(99, 'K2V v1', 'Delay Start', '', NULL, 125, NULL, NULL, NULL, '', 'RND', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(100, 'K2V v1', 'Delay Start', '', NULL, 126, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(101, 'K2V v1', 'Delay Start', '', NULL, 127, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(102, 'K2V v1', 'Delay Start', '', NULL, 128, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(103, 'K2V v1', 'Delay Start', '', NULL, 129, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(104, 'K2V v1', 'Delay Start', '', NULL, 130, NULL, NULL, NULL, '', 'QE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(105, 'K2V v1', 'Delay Start', '', NULL, 131, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(106, 'K2V v1', 'Delay Start', '', NULL, 132, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(107, 'K2V v1', 'Delay Start', '', NULL, 133, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(108, 'K2V v1', 'Delay Start', '', NULL, 134, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(109, 'K2V v1', 'Delay Start', '', NULL, 135, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(110, 'K2V v1', 'Delay Start', '', NULL, 136, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(111, 'K2V v1', 'Delay Start', '', NULL, 137, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(112, 'K2V v1', 'Delay Start', '', NULL, 138, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(113, 'K2V v1', 'Delay Start', '', NULL, 139, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(114, 'K2V v1', 'Delay Start', '', NULL, 140, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(115, 'K2V v1', 'Delay Start', '', NULL, 141, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(116, 'K2V v1', 'Delay Start', '', NULL, 142, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(117, 'K2V v1', 'Delay Start', '', NULL, 143, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(118, 'K2V v1', 'Delay Start', '', NULL, 144, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(119, 'K2V v1', 'Delay Start', '', NULL, 145, NULL, NULL, NULL, '', 'RND', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(120, 'K2V v1', 'Delay Start', '', NULL, 146, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(121, 'K2V v1', 'Delay Start', '', NULL, 147, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(122, 'K2V v1', 'Delay Start', '', NULL, 148, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(123, 'K2V v1', 'Delay Start', '', NULL, 149, NULL, NULL, NULL, '', 'RND', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(124, 'K2V v1', 'Delay Start', '', NULL, 150, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(125, 'K2V v1', 'Delay Start', '', NULL, 151, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(126, 'K2V v1', 'Delay Start', '', NULL, 152, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(127, 'K2V v1', 'Delay Start', '', NULL, 153, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(128, 'K2V v1', 'Delay Start', '', NULL, 154, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(129, 'K2V v1', 'Delay Start', '', NULL, 155, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(130, 'K2V v1', 'Delay Start', '', NULL, 156, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(131, 'K2V v1', 'Delay Start', '', NULL, 157, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(132, 'K2V v1', 'Delay Start', '', NULL, 158, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(133, 'K2V v1', 'Delay Start', '', NULL, 159, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(134, 'K2V v1', 'Delay Start', '', NULL, 160, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(135, 'K2V v1', 'Delay Start', '', NULL, 161, NULL, NULL, NULL, '', 'RND', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(136, 'K2V v1', 'Delay Start', '', NULL, 162, NULL, NULL, NULL, '', 'WH', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(137, 'K2V v1', 'Delay Start', '', NULL, 163, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(138, 'K2V v1', 'Delay Start', '', NULL, 165, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(139, 'K2V v1', 'Delay Start', '', NULL, 166, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(140, 'K2V v1', 'Delay Start', '', NULL, 167, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(141, 'K2V v1', 'Delay Start', '', NULL, 168, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(142, 'K2V v1', 'Delay Start', '', NULL, 169, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(143, 'K2V v1', 'Delay Start', '', NULL, 170, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(144, 'K2V v1', 'Delay Start', '', NULL, 171, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(145, 'K2V v1', 'Delay Start', '', NULL, 172, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(146, 'K2V v1', 'Delay Start', '', NULL, 173, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(147, 'K2V v1', 'Delay Start', '', NULL, 174, NULL, NULL, NULL, '', 'MKT', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(148, 'K2V v1', 'Delay Start', '', NULL, 175, NULL, NULL, NULL, '', 'QE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(149, 'K2V v1', 'Delay Start', '', NULL, 176, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(150, 'K2V v1', 'Delay Start', '', NULL, 177, NULL, NULL, NULL, '', 'RND', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(151, 'K2V v1', 'Delay Start', '', NULL, 178, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(152, 'K2V v1', 'Delay Start', '', NULL, 179, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(153, 'K2V v1', 'Delay Start', '', NULL, 180, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(154, 'K2V v1', 'Delay Start', '', NULL, 181, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(155, 'K2V v1', 'Delay Start', '', NULL, 182, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(156, 'K2V v1', 'Delay Start', '', NULL, 183, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(157, 'K2V v1', 'Delay Start', '', NULL, 187, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(158, 'K2V v1', 'Delay Start', '', NULL, 188, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(159, 'K2V v1', 'Delay Start', '', NULL, 189, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(160, 'K2V v1', 'Delay Start', '', NULL, 190, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(161, 'K2V v1', 'Delay Start', '', NULL, 191, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(162, 'K2V v1', 'Delay Start', '', NULL, 192, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(163, 'K2V v1', 'Delay Start', '', NULL, 193, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(164, 'K2V v1', 'Delay Start', '', NULL, 194, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(165, 'K2V v1', 'Delay Start', '', NULL, 195, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(166, 'K2V v1', 'Delay Start', '', NULL, 196, NULL, NULL, NULL, '', 'MKT', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(167, 'K2V v1', 'Delay Start', '', NULL, 207, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:25', '2025-07-31 07:07:25'),
(168, 'K2V v1', 'Delay Start', '', NULL, 208, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(169, 'K2V v1', 'Delay Start', '', NULL, 209, NULL, NULL, NULL, '', 'WH', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(170, 'K2V v1', 'Delay Start', '', NULL, 210, NULL, NULL, NULL, '', 'PROD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(171, 'K2V v1', 'Delay Start', '', NULL, 215, NULL, NULL, NULL, '', 'QE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(172, 'K2V', 'Delay End', '', NULL, 1, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(173, 'K2V', 'Delay End', '', NULL, 2, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(174, 'K2V', 'Delay End', '', NULL, 3, NULL, NULL, NULL, '', 'MKT', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(175, 'K2V', 'Delay End', '', NULL, 4, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(176, 'K2V', 'Delay End', '', NULL, 5, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(177, 'K2V', 'Delay End', '', NULL, 6, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(178, 'K2V', 'Delay End', '', NULL, 7, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(179, 'K2V', 'Delay End', '', NULL, 8, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(180, 'K2V', 'Delay End', '', NULL, 9, NULL, NULL, NULL, '', 'RND', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(181, 'K2V', 'Delay End', '', NULL, 10, NULL, NULL, NULL, '', 'RND', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(182, 'K2V', 'Delay End', '', NULL, 11, NULL, NULL, NULL, '', 'RND', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(183, 'K2V', 'Delay End', '', NULL, 12, NULL, NULL, NULL, '', 'RND', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(184, 'K2V', 'Delay End', '', NULL, 13, NULL, NULL, NULL, '', 'RND', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(185, 'K2V', 'Delay End', '', NULL, 14, NULL, NULL, NULL, '', 'EHS', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(186, 'K2V', 'Delay End', '', NULL, 15, NULL, NULL, NULL, '', 'EXIM', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(187, 'K2V', 'Delay End', '', NULL, 16, NULL, NULL, NULL, '', 'EXIM', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(188, 'K2V', 'Delay End', '', NULL, 17, NULL, NULL, NULL, '', 'FA', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(189, 'K2V', 'Delay End', '', NULL, 18, NULL, NULL, NULL, '', 'QE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(190, 'K2V', 'Delay End', '', NULL, 19, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(191, 'K2V', 'Delay End', '', NULL, 20, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(192, 'K2V', 'Delay End', '', NULL, 21, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(193, 'K2V', 'Delay End', '', NULL, 22, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(194, 'K2V', 'Delay End', '', NULL, 23, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(195, 'K2V', 'Delay End', '', NULL, 24, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(196, 'K2V', 'Delay End', '', NULL, 25, NULL, NULL, NULL, '', 'QA', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(197, 'K2V', 'Delay End', '', NULL, 26, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(198, 'K2V', 'Delay End', '', NULL, 27, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(199, 'K2V', 'Delay End', '', NULL, 28, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(200, 'K2V', 'Delay End', '', NULL, 29, NULL, NULL, NULL, '', 'QA', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(201, 'K2V', 'Delay End', '', NULL, 30, NULL, NULL, NULL, '', 'QE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(202, 'K2V', 'Delay End', '', NULL, 31, NULL, NULL, NULL, '', 'QE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(203, 'K2V', 'Delay End', '', NULL, 32, NULL, NULL, NULL, '', 'RND', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(204, 'K2V', 'Delay End', '', NULL, 33, NULL, NULL, NULL, '', 'RND', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(205, 'K2V', 'Delay End', '', NULL, 34, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(206, 'K2V', 'Delay End', '', NULL, 35, NULL, NULL, NULL, '', 'PEINJ', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(207, 'K2V', 'Delay End', '', NULL, 36, NULL, NULL, NULL, '', 'MM', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(208, 'K2V', 'Delay End', '', NULL, 37, NULL, NULL, NULL, '', 'RND', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(209, 'K2V', 'Delay End', '', NULL, 39, NULL, NULL, NULL, '', 'PE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(210, 'K2V', 'Delay End', '', NULL, 40, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(211, 'K2V', 'Delay End', '', NULL, 41, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(212, 'K2V', 'Delay End', '', NULL, 42, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(213, 'K2V', 'Delay End', '', NULL, 43, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(214, 'K2V', 'Delay End', '', NULL, 44, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(215, 'K2V', 'Delay End', '', NULL, 45, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(216, 'K2V', 'Delay End', '', NULL, 46, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(217, 'K2V', 'Delay End', '', NULL, 47, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(218, 'K2V', 'Delay End', '', NULL, 48, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(219, 'K2V', 'Delay End', '', NULL, 49, NULL, NULL, NULL, '', 'RND', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(220, 'K2V', 'Delay End', '', NULL, 50, NULL, NULL, NULL, '', 'WH', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(221, 'K2V', 'Delay End', '', NULL, 51, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(222, 'K2V', 'Delay End', '', NULL, 53, NULL, NULL, NULL, '', 'DEL', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(223, 'K2V', 'Delay End', '', NULL, 54, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(224, 'K2V', 'Delay End', '', NULL, 55, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(225, 'K2V', 'Delay End', '', NULL, 56, NULL, NULL, NULL, '', 'DEL', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(226, 'K2V', 'Delay End', '', NULL, 57, NULL, NULL, NULL, '', 'ASMBLI', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(227, 'K2V', 'Delay End', '', NULL, 58, NULL, NULL, NULL, '', 'ASMBLI', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(228, 'K2V', 'Delay End', '', NULL, 59, NULL, NULL, NULL, '', 'MEINJ', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(229, 'K2V', 'Delay End', '', NULL, 60, NULL, NULL, NULL, '', 'BNF', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(230, 'K2V', 'Delay End', '', NULL, 61, NULL, NULL, NULL, '', 'QC', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(231, 'K2V', 'Delay End', '', NULL, 62, NULL, NULL, NULL, '', 'MKT', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(232, 'K2V', 'Delay End', '', NULL, 63, NULL, NULL, NULL, '', 'QE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(233, 'K2V', 'Delay End', '', NULL, 64, NULL, NULL, NULL, '', 'QA', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(234, 'K2V', 'Delay End', '', NULL, 65, NULL, NULL, NULL, '', 'RND', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(235, 'K2V', 'Delay End', '', NULL, 66, NULL, NULL, NULL, '', 'QRO', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(236, 'K2V', 'Delay End', '', NULL, 67, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(237, 'K2V', 'Delay End', '', NULL, 68, NULL, NULL, NULL, '', 'INJ', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(238, 'K2V', 'Delay End', '', NULL, 69, NULL, NULL, NULL, '', 'SUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(239, 'K2V', 'Delay End', '', NULL, 70, NULL, NULL, NULL, '', 'IC', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(240, 'K2V', 'Delay End', '', NULL, 71, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(241, 'K2V', 'Delay End', '', NULL, 75, NULL, NULL, NULL, '', 'EXIM', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(242, 'K2V', 'Delay End', '', NULL, 76, NULL, NULL, NULL, '', 'RND', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(243, 'K2V', 'Delay End', '', NULL, 77, NULL, NULL, NULL, '', 'RND', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(244, 'K2V', 'Delay End', '', NULL, 78, NULL, NULL, NULL, '', 'IT', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(245, 'K2V', 'Delay End', '', NULL, 79, NULL, NULL, NULL, '', 'EHS', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(246, 'K2V', 'Delay End', '', NULL, 80, NULL, NULL, NULL, '', 'EHS', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(247, 'K2V', 'Delay End', '', NULL, 81, NULL, NULL, NULL, '', 'IT', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(248, 'K2V', 'Delay End', '', NULL, 82, NULL, NULL, NULL, '', 'LA', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(249, 'K2V', 'Delay End', '', NULL, 83, NULL, NULL, NULL, '', 'EXIM', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(250, 'K2V', 'Delay End', '', NULL, 84, NULL, NULL, NULL, '', 'MKT', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(251, 'K2V', 'Delay End', '', NULL, 101, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(252, 'K2V v1', 'Delay End', '', NULL, 113, NULL, NULL, NULL, '', 'IT', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(253, 'K2V v1', 'Delay End', '', NULL, 114, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(254, 'K2V v1', 'Delay End', '', NULL, 115, NULL, NULL, NULL, '', 'MKT', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(255, 'K2V v1', 'Delay End', '', NULL, 116, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(256, 'K2V v1', 'Delay End', '', NULL, 117, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(257, 'K2V v1', 'Delay End', '', NULL, 118, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(258, 'K2V v1', 'Delay End', '', NULL, 119, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(259, 'K2V v1', 'Delay End', '', NULL, 120, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(260, 'K2V v1', 'Delay End', '', NULL, 121, NULL, NULL, NULL, '', 'RND', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(261, 'K2V v1', 'Delay End', '', NULL, 122, NULL, NULL, NULL, '', 'RND', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(262, 'K2V v1', 'Delay End', '', NULL, 123, NULL, NULL, NULL, '', 'RND', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(263, 'K2V v1', 'Delay End', '', NULL, 124, NULL, NULL, NULL, '', 'RND', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(264, 'K2V v1', 'Delay End', '', NULL, 125, NULL, NULL, NULL, '', 'RND', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(265, 'K2V v1', 'Delay End', '', NULL, 126, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(266, 'K2V v1', 'Delay End', '', NULL, 127, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(267, 'K2V v1', 'Delay End', '', NULL, 128, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(268, 'K2V v1', 'Delay End', '', NULL, 129, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(269, 'K2V v1', 'Delay End', '', NULL, 130, NULL, NULL, NULL, '', 'QE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(270, 'K2V v1', 'Delay End', '', NULL, 131, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(271, 'K2V v1', 'Delay End', '', NULL, 132, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(272, 'K2V v1', 'Delay End', '', NULL, 133, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(273, 'K2V v1', 'Delay End', '', NULL, 134, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(274, 'K2V v1', 'Delay End', '', NULL, 135, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(275, 'K2V v1', 'Delay End', '', NULL, 136, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(276, 'K2V v1', 'Delay End', '', NULL, 137, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(277, 'K2V v1', 'Delay End', '', NULL, 138, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(278, 'K2V v1', 'Delay End', '', NULL, 139, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(279, 'K2V v1', 'Delay End', '', NULL, 140, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(280, 'K2V v1', 'Delay End', '', NULL, 141, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(281, 'K2V v1', 'Delay End', '', NULL, 142, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(282, 'K2V v1', 'Delay End', '', NULL, 143, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(283, 'K2V v1', 'Delay End', '', NULL, 144, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(284, 'K2V v1', 'Delay End', '', NULL, 145, NULL, NULL, NULL, '', 'RND', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(285, 'K2V v1', 'Delay End', '', NULL, 146, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(286, 'K2V v1', 'Delay End', '', NULL, 147, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(287, 'K2V v1', 'Delay End', '', NULL, 148, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(288, 'K2V v1', 'Delay End', '', NULL, 149, NULL, NULL, NULL, '', 'RND', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(289, 'K2V v1', 'Delay End', '', NULL, 150, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(290, 'K2V v1', 'Delay End', '', NULL, 151, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(291, 'K2V v1', 'Delay End', '', NULL, 152, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(292, 'K2V v1', 'Delay End', '', NULL, 153, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(293, 'K2V v1', 'Delay End', '', NULL, 154, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(294, 'K2V v1', 'Delay End', '', NULL, 155, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(295, 'K2V v1', 'Delay End', '', NULL, 156, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(296, 'K2V v1', 'Delay End', '', NULL, 157, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(297, 'K2V v1', 'Delay End', '', NULL, 158, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(298, 'K2V v1', 'Delay End', '', NULL, 159, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(299, 'K2V v1', 'Delay End', '', NULL, 160, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(300, 'K2V v1', 'Delay End', '', NULL, 161, NULL, NULL, NULL, '', 'RND', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(301, 'K2V v1', 'Delay End', '', NULL, 162, NULL, NULL, NULL, '', 'WH', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(302, 'K2V v1', 'Delay End', '', NULL, 163, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(303, 'K2V v1', 'Delay End', '', NULL, 165, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(304, 'K2V v1', 'Delay End', '', NULL, 166, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(305, 'K2V v1', 'Delay End', '', NULL, 167, NULL, NULL, NULL, '', 'PUR', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(306, 'K2V v1', 'Delay End', '', NULL, 168, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(307, 'K2V v1', 'Delay End', '', NULL, 169, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(308, 'K2V v1', 'Delay End', '', NULL, 170, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(309, 'K2V v1', 'Delay End', '', NULL, 171, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(310, 'K2V v1', 'Delay End', '', NULL, 172, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(311, 'K2V v1', 'Delay End', '', NULL, 173, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(312, 'K2V v1', 'Delay End', '', NULL, 174, NULL, NULL, NULL, '', 'MKT', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(313, 'K2V v1', 'Delay End', '', NULL, 175, NULL, NULL, NULL, '', 'QE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(314, 'K2V v1', 'Delay End', '', NULL, 176, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(315, 'K2V v1', 'Delay End', '', NULL, 177, NULL, NULL, NULL, '', 'RND', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(316, 'K2V v1', 'Delay End', '', NULL, 178, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(317, 'K2V v1', 'Delay End', '', NULL, 179, NULL, NULL, NULL, '', 'NPD', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(318, 'K2V v1', 'Delay End', '', NULL, 180, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(319, 'K2V v1', 'Delay End', '', NULL, 181, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(320, 'K2V v1', 'Delay End', '', NULL, 182, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(321, 'K2V v1', 'Delay End', '', NULL, 183, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(322, 'K2V v1', 'Delay End', '', NULL, 187, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26');
INSERT INTO `npp_pica_aji_internal_schedule` (`id`, `project_title`, `type`, `category_problem`, `problem`, `id_item_schedule`, `root_cause`, `countermeasure`, `attachment`, `type_attachment`, `pic`, `Dept`, `due_date`, `progress`, `remark`, `judge`, `judge_by`, `last_edit_by`, `updated_at`, `created_at`) VALUES
(323, 'K2V v1', 'Delay End', '', NULL, 188, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(324, 'K2V v1', 'Delay End', '', NULL, 189, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(325, 'K2V v1', 'Delay End', '', NULL, 190, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(326, 'K2V v1', 'Delay End', '', NULL, 191, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(327, 'K2V v1', 'Delay End', '', NULL, 192, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(328, 'K2V v1', 'Delay End', '', NULL, 193, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(329, 'K2V v1', 'Delay End', '', NULL, 194, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(330, 'K2V v1', 'Delay End', '', NULL, 195, NULL, NULL, NULL, '', 'PCE', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(331, 'K2V v1', 'Delay End', '', NULL, 196, NULL, NULL, NULL, '', 'MKT', '', NULL, 0, NULL, NULL, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(332, 'K2V', 'Delay Start', 'General', 'asad', 1, NULL, NULL, '', '', 'Ridwan Syarif', 'PRODENG', '2025-09-09', 0, NULL, NULL, NULL, NULL, '2025-07-31 14:17:03', '2025-07-31 07:17:03');

-- --------------------------------------------------------

--
-- Table structure for table `npp_project_event`
--

CREATE TABLE `npp_project_event` (
  `id` int(130) NOT NULL,
  `project_title` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `problem` varchar(255) DEFAULT NULL,
  `id_item_schedule` int(11) NOT NULL,
  `root_cause` text DEFAULT NULL,
  `countermeasure` text DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `pic` varchar(255) DEFAULT NULL,
  `Dept` varchar(255) NOT NULL,
  `due_date` date DEFAULT NULL,
  `progress` int(11) NOT NULL DEFAULT 0 COMMENT '0 => open\r\n1 => close\r\n2 => cancel\r\n3 => postpone\r\n\r\n',
  `remark` text DEFAULT NULL,
  `last_edit_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `npp_project_event`
--

INSERT INTO `npp_project_event` (`id`, `project_title`, `type`, `problem`, `id_item_schedule`, `root_cause`, `countermeasure`, `attachment`, `pic`, `Dept`, `due_date`, `progress`, `remark`, `last_edit_by`, `updated_at`, `created_at`) VALUES
(1, 'test', 'Near Open', NULL, 12, NULL, NULL, NULL, 'budi.k', '', NULL, 0, NULL, NULL, '2025-07-09 15:04:36', '2025-07-09 08:04:36'),
(2, 'test', 'Near Open', NULL, 13, NULL, NULL, NULL, 'citra.l', '', NULL, 0, NULL, NULL, '2025-07-09 15:04:36', '2025-07-09 08:04:36'),
(3, 'testing', 'Near Open', NULL, 15, NULL, NULL, NULL, 'budi.k', '', NULL, 0, NULL, NULL, '2025-07-09 15:04:36', '2025-07-09 08:04:36'),
(4, 'testing', 'Near Open', NULL, 16, NULL, NULL, NULL, 'citra.l', '', NULL, 0, NULL, NULL, '2025-07-09 15:04:36', '2025-07-09 08:04:36'),
(5, 'test', 'Near Close', NULL, 11, NULL, NULL, NULL, 'andi.w', '', NULL, 0, NULL, NULL, '2025-07-09 15:04:37', '2025-07-09 08:04:37'),
(6, 'test', 'Near Close', NULL, 12, NULL, NULL, NULL, 'budi.k', '', NULL, 0, NULL, NULL, '2025-07-09 15:04:37', '2025-07-09 08:04:37'),
(7, 'test', 'Near Close', NULL, 13, NULL, NULL, NULL, 'citra.l', '', NULL, 0, NULL, NULL, '2025-07-09 15:04:37', '2025-07-09 08:04:37'),
(8, 'testing', 'Near Close', NULL, 14, NULL, NULL, NULL, 'andi.w', '', NULL, 0, NULL, NULL, '2025-07-09 15:04:37', '2025-07-09 08:04:37'),
(9, 'testing', 'Near Close', NULL, 15, NULL, NULL, NULL, 'budi.k', '', NULL, 0, NULL, NULL, '2025-07-09 15:04:37', '2025-07-09 08:04:37'),
(10, 'testing', 'Near Close', NULL, 16, NULL, NULL, NULL, 'citra.l', '', NULL, 0, NULL, NULL, '2025-07-09 15:04:37', '2025-07-09 08:04:37'),
(11, 'Project 1', 'Near Open', NULL, 19, NULL, NULL, NULL, 'citra.l', '', NULL, 0, NULL, NULL, '2025-07-16 08:15:31', '2025-07-16 01:15:31'),
(12, 'Project 2', 'Near Open', NULL, 71, NULL, NULL, NULL, 'QE', '', NULL, 0, NULL, NULL, '2025-07-16 08:15:31', '2025-07-16 01:15:31'),
(13, 'Project 2', 'Near Open', NULL, 104, NULL, NULL, NULL, 'WH', '', NULL, 0, NULL, NULL, '2025-07-16 08:15:31', '2025-07-16 01:15:31'),
(14, 'Project 2', 'Near Open', NULL, 106, NULL, NULL, NULL, 'PCE', '', NULL, 0, NULL, NULL, '2025-07-16 08:15:31', '2025-07-16 01:15:31'),
(15, 'Project 2', 'Near Open', NULL, 107, NULL, NULL, NULL, 'PCE', '', NULL, 0, NULL, NULL, '2025-07-16 08:15:31', '2025-07-16 01:15:31'),
(16, 'Project 2', 'Near Open', NULL, 108, NULL, NULL, NULL, 'PCE', '', NULL, 0, NULL, NULL, '2025-07-16 08:15:31', '2025-07-16 01:15:31'),
(17, 'Project 2', 'Near Open', NULL, 109, NULL, NULL, NULL, 'PCE', '', NULL, 0, NULL, NULL, '2025-07-16 08:15:31', '2025-07-16 01:15:31'),
(18, 'Project 2', 'Near Open', NULL, 110, NULL, NULL, NULL, 'PCE', '', NULL, 0, NULL, NULL, '2025-07-16 08:15:31', '2025-07-16 01:15:31'),
(19, 'Project 2', 'Near Open', NULL, 112, NULL, NULL, NULL, 'PCE', '', NULL, 0, NULL, NULL, '2025-07-16 08:15:31', '2025-07-16 01:15:31'),
(20, 'Project 2', 'Near Open', NULL, 113, NULL, NULL, NULL, 'QE', '', NULL, 0, NULL, NULL, '2025-07-16 08:15:31', '2025-07-16 01:15:31'),
(21, 'Project 2', 'Near Open', NULL, 114, NULL, NULL, NULL, 'PCE', '', NULL, 0, NULL, NULL, '2025-07-16 08:15:31', '2025-07-16 01:15:31'),
(22, 'Project 2', 'Near Open', NULL, 115, NULL, NULL, NULL, 'PCE', '', NULL, 0, NULL, NULL, '2025-07-16 08:15:31', '2025-07-16 01:15:31'),
(23, 'Project 2', 'Near Open', NULL, 116, NULL, NULL, NULL, 'WH', '', NULL, 0, NULL, NULL, '2025-07-16 08:15:31', '2025-07-16 01:15:31'),
(24, 'Project 2', 'Near Open', NULL, 118, NULL, NULL, NULL, 'PUR', '', NULL, 0, NULL, NULL, '2025-07-16 08:15:31', '2025-07-16 01:15:31'),
(25, 'Project 2', 'Near Open', NULL, 119, NULL, NULL, NULL, 'PUR', '', NULL, 0, NULL, NULL, '2025-07-16 08:15:31', '2025-07-16 01:15:31'),
(26, 'Project 2', 'Near Open', NULL, 121, NULL, NULL, NULL, 'NPD', '', NULL, 0, NULL, NULL, '2025-07-16 08:15:31', '2025-07-16 01:15:31'),
(27, 'Project 1', 'Near Close', NULL, 18, NULL, NULL, NULL, 'budi.k', '', NULL, 0, NULL, NULL, '2025-07-16 08:15:31', '2025-07-16 01:15:31'),
(28, 'Project 1', 'Near Close', NULL, 19, NULL, NULL, NULL, 'citra.l', '', NULL, 0, NULL, NULL, '2025-07-16 08:15:31', '2025-07-16 01:15:31'),
(29, 'Project 2', 'Near Close', NULL, 70, NULL, NULL, NULL, 'NPD', '', NULL, 0, NULL, NULL, '2025-07-16 08:15:31', '2025-07-16 01:15:31'),
(30, 'Project 2', 'Near Close', NULL, 94, NULL, NULL, NULL, 'PCE', '', NULL, 0, NULL, NULL, '2025-07-16 08:15:31', '2025-07-16 01:15:31'),
(31, 'Project 2', 'Near Close', NULL, 95, NULL, NULL, NULL, 'PCE', '', NULL, 0, NULL, NULL, '2025-07-16 08:15:31', '2025-07-16 01:15:31'),
(32, 'Project 2', 'Near Close', NULL, 96, NULL, NULL, NULL, 'PCE', '', NULL, 0, NULL, NULL, '2025-07-16 08:15:31', '2025-07-16 01:15:31'),
(33, 'Project 2', 'Near Close', NULL, 97, NULL, NULL, NULL, 'PCE', '', NULL, 0, NULL, NULL, '2025-07-16 08:15:31', '2025-07-16 01:15:31'),
(34, 'Project 2', 'Near Close', NULL, 98, NULL, NULL, NULL, 'PCE', '', NULL, 0, NULL, NULL, '2025-07-16 08:15:31', '2025-07-16 01:15:31'),
(35, 'Project 2', 'Near Close', NULL, 99, NULL, NULL, NULL, 'PCE', '', NULL, 0, NULL, NULL, '2025-07-16 08:15:31', '2025-07-16 01:15:31'),
(36, 'Project 2', 'Near Close', NULL, 100, NULL, NULL, NULL, 'PCE', '', NULL, 0, NULL, NULL, '2025-07-16 08:15:31', '2025-07-16 01:15:31'),
(37, 'Project 2', 'Near Close', NULL, 101, NULL, NULL, NULL, 'PCE', '', NULL, 0, NULL, NULL, '2025-07-16 08:15:31', '2025-07-16 01:15:31'),
(38, 'Project 2', 'Near Close', NULL, 102, NULL, NULL, NULL, 'PCE', '', NULL, 0, NULL, NULL, '2025-07-16 08:15:31', '2025-07-16 01:15:31'),
(39, 'Project 2', 'Near Close', NULL, 112, NULL, NULL, NULL, 'PCE', '', NULL, 0, NULL, NULL, '2025-07-16 08:15:31', '2025-07-16 01:15:31'),
(40, 'Project 2', 'Near Close', NULL, 114, NULL, NULL, NULL, 'PCE', '', NULL, 0, NULL, NULL, '2025-07-16 08:15:31', '2025-07-16 01:15:31'),
(41, 'Project 2', 'Near Close', NULL, 115, NULL, NULL, NULL, 'PCE', '', NULL, 0, NULL, NULL, '2025-07-16 08:15:31', '2025-07-16 01:15:31'),
(42, 'Project 2', 'Near Close', NULL, 116, NULL, NULL, NULL, 'WH', '', NULL, 0, NULL, NULL, '2025-07-16 08:15:31', '2025-07-16 01:15:31'),
(43, 'Project 2', 'Near Close', NULL, 117, NULL, NULL, NULL, 'PROD', '', NULL, 0, NULL, NULL, '2025-07-16 08:15:31', '2025-07-16 01:15:31'),
(44, 'Project 2', 'Near Close', NULL, 118, NULL, NULL, NULL, 'PUR', '', NULL, 0, NULL, NULL, '2025-07-16 08:15:31', '2025-07-16 01:15:31'),
(45, 'K2V', 'Progress', NULL, 74, NULL, NULL, NULL, 'IT', '', NULL, 0, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(46, 'K2V', 'Near Open', NULL, 52, NULL, NULL, NULL, 'QE', '', NULL, 0, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(47, 'K2V', 'Near Open', NULL, 85, NULL, NULL, NULL, 'WH', '', NULL, 0, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(48, 'K2V', 'Near Open', NULL, 87, NULL, NULL, NULL, 'LA', '', NULL, 0, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(49, 'K2V', 'Near Open', NULL, 88, NULL, NULL, NULL, 'PPC', '', NULL, 0, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(50, 'K2V', 'Near Open', NULL, 89, NULL, NULL, NULL, 'PPC', '', NULL, 0, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(51, 'K2V', 'Near Open', NULL, 90, NULL, NULL, NULL, 'FA', '', NULL, 0, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(52, 'K2V', 'Near Open', NULL, 91, NULL, NULL, NULL, 'PUR', '', NULL, 0, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(53, 'K2V', 'Near Open', NULL, 93, NULL, NULL, NULL, 'INC', '', NULL, 0, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(54, 'K2V', 'Near Open', NULL, 94, NULL, NULL, NULL, 'QE', '', NULL, 0, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(55, 'K2V', 'Near Open', NULL, 99, NULL, NULL, NULL, 'PUR', '', NULL, 0, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(56, 'K2V', 'Near Open', NULL, 100, NULL, NULL, NULL, 'PUR', '', NULL, 0, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(57, 'K2V', 'Near Open', NULL, 102, NULL, NULL, NULL, 'NPD', '', NULL, 0, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(58, 'K2V', 'Near Open', NULL, 105, NULL, NULL, NULL, 'WH', '', NULL, 0, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(59, 'K2V v1', 'Near Open', NULL, 164, NULL, NULL, NULL, 'QE', '', NULL, 0, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(60, 'K2V v1', 'Near Open', NULL, 197, NULL, NULL, NULL, 'WH', '', NULL, 0, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(61, 'K2V v1', 'Near Open', NULL, 199, NULL, NULL, NULL, 'PCE', '', NULL, 0, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(62, 'K2V v1', 'Near Open', NULL, 200, NULL, NULL, NULL, 'PCE', '', NULL, 0, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(63, 'K2V v1', 'Near Open', NULL, 201, NULL, NULL, NULL, 'PCE', '', NULL, 0, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(64, 'K2V v1', 'Near Open', NULL, 202, NULL, NULL, NULL, 'PCE', '', NULL, 0, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(65, 'K2V v1', 'Near Open', NULL, 203, NULL, NULL, NULL, 'PCE', '', NULL, 0, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(66, 'K2V v1', 'Near Open', NULL, 205, NULL, NULL, NULL, 'PCE', '', NULL, 0, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(67, 'K2V v1', 'Near Open', NULL, 206, NULL, NULL, NULL, 'QE', '', NULL, 0, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(68, 'K2V v1', 'Near Open', NULL, 211, NULL, NULL, NULL, 'PUR', '', NULL, 0, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(69, 'K2V v1', 'Near Open', NULL, 212, NULL, NULL, NULL, 'PUR', '', NULL, 0, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(70, 'K2V v1', 'Near Open', NULL, 216, NULL, NULL, NULL, 'WH', '', NULL, 0, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(71, 'K2V v1', 'Near Open', NULL, 217, NULL, NULL, NULL, 'WH', '', NULL, 0, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(72, 'K2V v1', 'Near Open', NULL, 218, NULL, NULL, NULL, 'WH', '', NULL, 0, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(73, 'K2V', 'Near Close', NULL, 52, NULL, NULL, NULL, 'QE', '', NULL, 0, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(74, 'K2V', 'Near Close', NULL, 85, NULL, NULL, NULL, 'WH', '', NULL, 0, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(75, 'K2V', 'Near Close', NULL, 87, NULL, NULL, NULL, 'LA', '', NULL, 0, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(76, 'K2V', 'Near Close', NULL, 88, NULL, NULL, NULL, 'PPC', '', NULL, 0, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(77, 'K2V', 'Near Close', NULL, 89, NULL, NULL, NULL, 'PPC', '', NULL, 0, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(78, 'K2V', 'Near Close', NULL, 90, NULL, NULL, NULL, 'FA', '', NULL, 0, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(79, 'K2V', 'Near Close', NULL, 91, NULL, NULL, NULL, 'PUR', '', NULL, 0, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(80, 'K2V', 'Near Close', NULL, 93, NULL, NULL, NULL, 'INC', '', NULL, 0, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(81, 'K2V v1', 'Near Close', NULL, 164, NULL, NULL, NULL, 'QE', '', NULL, 0, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(82, 'K2V v1', 'Near Close', NULL, 197, NULL, NULL, NULL, 'WH', '', NULL, 0, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(83, 'K2V v1', 'Near Close', NULL, 199, NULL, NULL, NULL, 'PCE', '', NULL, 0, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(84, 'K2V v1', 'Near Close', NULL, 200, NULL, NULL, NULL, 'PCE', '', NULL, 0, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(85, 'K2V v1', 'Near Close', NULL, 201, NULL, NULL, NULL, 'PCE', '', NULL, 0, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(86, 'K2V v1', 'Near Close', NULL, 202, NULL, NULL, NULL, 'PCE', '', NULL, 0, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(87, 'K2V v1', 'Near Close', NULL, 203, NULL, NULL, NULL, 'PCE', '', NULL, 0, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(88, 'K2V v1', 'Near Close', NULL, 205, NULL, NULL, NULL, 'PCE', '', NULL, 0, NULL, NULL, '2025-07-31 14:07:26', '2025-07-31 07:07:26'),
(89, 'K2V v1', 'Near Close', NULL, 206, NULL, NULL, NULL, 'QE', '', NULL, 0, NULL, NULL, '2025-07-31 14:07:27', '2025-07-31 07:07:27'),
(90, 'K2V v1', 'Near Close', NULL, 207, NULL, NULL, NULL, 'PCE', '', NULL, 0, NULL, NULL, '2025-07-31 14:07:27', '2025-07-31 07:07:27'),
(91, 'K2V v1', 'Near Close', NULL, 208, NULL, NULL, NULL, 'PCE', '', NULL, 0, NULL, NULL, '2025-07-31 14:07:27', '2025-07-31 07:07:27'),
(92, 'K2V v1', 'Near Close', NULL, 209, NULL, NULL, NULL, 'WH', '', NULL, 0, NULL, NULL, '2025-07-31 14:07:27', '2025-07-31 07:07:27'),
(93, 'K2V v1', 'Near Close', NULL, 210, NULL, NULL, NULL, 'PROD', '', NULL, 0, NULL, NULL, '2025-07-31 14:07:27', '2025-07-31 07:07:27'),
(94, 'K2V v1', 'Near Close', NULL, 211, NULL, NULL, NULL, 'PUR', '', NULL, 0, NULL, NULL, '2025-07-31 14:07:27', '2025-07-31 07:07:27'),
(95, 'K2V v1', 'Near Close', NULL, 212, NULL, NULL, NULL, 'PUR', '', NULL, 0, NULL, NULL, '2025-07-31 14:07:27', '2025-07-31 07:07:27');

-- --------------------------------------------------------

--
-- Table structure for table `npp_project_open_issue`
--

CREATE TABLE `npp_project_open_issue` (
  `id` int(130) NOT NULL,
  `project_title` varchar(255) NOT NULL,
  `product` varchar(255) DEFAULT NULL,
  `customer` varchar(14) NOT NULL,
  `type` varchar(255) NOT NULL,
  `category_problem` varchar(30) NOT NULL,
  `problem` varchar(255) DEFAULT NULL,
  `id_item_schedule` int(11) NOT NULL,
  `root_cause` text DEFAULT NULL,
  `countermeasure` text DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `type_attachment` varchar(7) NOT NULL,
  `pic` varchar(255) DEFAULT NULL,
  `dept` varchar(255) NOT NULL,
  `due_date` date DEFAULT NULL,
  `progress` int(11) NOT NULL DEFAULT 0 COMMENT '0 => open\r\n1 => close\r\n2 => cancel\r\n3 => postpone\r\n\r\n',
  `remark` text DEFAULT NULL,
  `judge` int(1) DEFAULT NULL COMMENT '0=ng,1=ok',
  `judge_by` varchar(255) DEFAULT NULL,
  `last_edit_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `npp_project_open_issue`
--

INSERT INTO `npp_project_open_issue` (`id`, `project_title`, `product`, `customer`, `type`, `category_problem`, `problem`, `id_item_schedule`, `root_cause`, `countermeasure`, `attachment`, `type_attachment`, `pic`, `dept`, `due_date`, `progress`, `remark`, `judge`, `judge_by`, `last_edit_by`, `updated_at`, `created_at`) VALUES
(2, 'K2V', 'Winker', 'AHM', '', 'Supplier Delivery', 'Delivery Delay', 0, 'Salah material', 'Beli baru', '', '', 'Ridwan Syarif', 'PRODENG', '2025-02-08', 1, NULL, NULL, NULL, 'Ridwan Syarif', '2025-07-31 14:03:11', '2025-07-31 07:03:11'),
(3, 'K2V', 'Winker', 'AHM', '', 'General', 'Mesin Rusak', 0, NULL, NULL, '', '', 'Ridwan Syarif', 'PRODENG', '2025-02-09', 0, NULL, NULL, NULL, NULL, '2025-07-31 14:04:18', '2025-07-31 07:04:18');

-- --------------------------------------------------------

--
-- Table structure for table `npp_schedules`
--

CREATE TABLE `npp_schedules` (
  `id` int(11) NOT NULL,
  `customer` varchar(40) NOT NULL,
  `project` varchar(40) NOT NULL,
  `product` varchar(40) NOT NULL,
  `file1` varchar(255) DEFAULT NULL COMMENT '1.Aji Master Schedule 2.Juoku Master Schedule 3.Supplier Master Schedule 4.Customer Schedule 5. Tooling progress report',
  `file2` varchar(255) DEFAULT NULL,
  `file3` varchar(255) DEFAULT NULL,
  `file4` varchar(255) DEFAULT NULL,
  `uploaded_by` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `npp_schedules`
--

INSERT INTO `npp_schedules` (`id`, `customer`, `project`, `product`, `file1`, `file2`, `file3`, `file4`, `uploaded_by`, `created_at`, `updated_at`) VALUES
(3, 'AHM', 'K2V', 'Winker', 'aji_master_schedule_AHM_K2V__2025_07_21_04_06_10_1.pdf', '', '', '', 'Miqdad Agil Amarullah', '2025-07-21 09:06:10', '2025-07-21 16:06:10');

-- --------------------------------------------------------

--
-- Table structure for table `npp_signup`
--

CREATE TABLE `npp_signup` (
  `id` int(255) NOT NULL,
  `email` varchar(200) NOT NULL,
  `name` varchar(255) NOT NULL,
  `dept` int(2) NOT NULL,
  `position_id` int(1) NOT NULL,
  `detail_dept_id` int(1) NOT NULL,
  `npk` varchar(9) NOT NULL,
  `username` varchar(120) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` varchar(255) NOT NULL,
  `approve` int(1) DEFAULT 0 COMMENT 'approval 0= belum, 1= depthead, 2=npd\r\n',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `npp_urgensi`
--

CREATE TABLE `npp_urgensi` (
  `id` int(11) NOT NULL,
  `type` int(1) NOT NULL COMMENT '1. normal\r\n2. urgent\r\n3. top urgent',
  `day_notif_pic` int(11) NOT NULL DEFAULT 0 COMMENT 'qty day',
  `day_notif_spv` int(11) NOT NULL DEFAULT 0 COMMENT 'qty day',
  `day_notif_depthead` int(11) NOT NULL DEFAULT 0 COMMENT 'qty day',
  `day_notif_director` int(2) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `npp_urgensi`
--

INSERT INTO `npp_urgensi` (`id`, `type`, `day_notif_pic`, `day_notif_spv`, `day_notif_depthead`, `day_notif_director`, `updated_at`, `created_at`) VALUES
(1, 1, 1, 1, 7, 8, '2023-11-03 11:35:57', '0000-00-00 00:00:00'),
(3, 2, 0, 1, 4, 8, '2023-06-26 12:44:58', '2023-05-28 11:50:04'),
(4, 3, 0, 1, 2, 8, '2023-06-22 11:47:13', '2023-05-29 06:27:51');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('andra.septian@astra-juoku.com', '3Fv5hf5uZVbNPnSRK6oQimpCjd7sJWENIcbjFmA5mFfQLYjpFVLd5gELa7kZex8D', '2022-07-04 09:14:21'),
('miqdadagilamarullah@gmail.com', '1OvZiFhjKe9URPngj0HWQoC6f19jtEZIfjscNqoOGeiLoPJXQyQni0bfy868mxjG', '2023-04-16 12:13:11');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(22964, 'ehs.edit', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(22965, 'home.index', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(22966, 'register.show', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(22967, 'register.perform', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(22968, 'login.show', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(22969, 'login.perform', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(22970, 'logout.perform', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(22971, 'users.index', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(22972, 'users.create', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(22973, 'users.store', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(22974, 'users.show', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(22975, 'users.edit', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(22976, 'users.update', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(22977, 'users.destroy', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(22978, 'posts.index', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(22979, 'posts.create', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(22980, 'posts.store', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(22981, 'posts.show', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(22982, 'posts.edit', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(22983, 'posts.update', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(22984, 'posts.destroy', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(22985, 'roles.index', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(22986, 'roles.create', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(22987, 'roles.store', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(22988, 'roles.show', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(22989, 'roles.edit', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(22990, 'roles.update', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(22991, 'roles.destroy', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(22992, 'permissions.index', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(22993, 'permissions.create', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(22994, 'permissions.store', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(22995, 'permissions.show', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(22996, 'permissions.edit', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(22997, 'permissions.update', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(22998, 'permissions.destroy', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(22999, 'demo.index', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23000, 'demo.create', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23001, 'demo.store', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23002, 'demo.show', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23003, 'demo.edit', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23004, 'demo.update', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23005, 'demo.destroy', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23006, 'users.restore', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23007, 'users.force-delete', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23008, 'users.restore-all', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23009, 'demo.trash', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23010, 'departments.index', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23011, 'departments.create', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23012, 'departments.store', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23013, 'departments.show', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23014, 'departments.edit', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23015, 'departments.update', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23016, 'departments.destroy', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23017, 'sections.index', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23018, 'sections.create', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23019, 'sections.store', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23020, 'sections.show', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23021, 'sections.edit', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23022, 'sections.update', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23023, 'sections.destroy', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23024, 'files.index', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23025, 'files.create', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23026, 'files.store', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23027, 'files.show', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23028, 'files.edit', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23029, 'files.update', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23030, 'files.destroy', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23031, 'category.index', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23032, 'categories.index', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23033, 'categories.create', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23034, 'categories.store', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23035, 'categories.show', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23036, 'categories.edit', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23037, 'categories.update', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23038, 'categories.destroy', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23039, 'categories.categorytree', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23040, 'files.download', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23041, 'logs.index', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23042, 'logs.create', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23043, 'logs.store', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23044, 'logs.show', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23045, 'logs.edit', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23046, 'logs.update', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23047, 'logs.destroy', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23048, 'files.downloadfile', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23049, 'files.alldept', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23050, 'delivery.edit.master', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23051, 'delivery.edit.role', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23052, 'forget.password.get', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23053, 'forget.password.post', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23054, 'reset.password.get', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23055, 'reset.password.post', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23056, 'home.dashboard', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23057, 'delivery.master.master_part', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23058, 'delivery.master.master_part.edit', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23059, 'delivery.master.master_part.update', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23060, 'delivery.master.master_part.import', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23061, 'delivery.master.master_part.create', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23062, 'delivery.master.master_part.destroy', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23063, 'delivery.master.master_part.insert', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23064, 'delivery.master.master_part.export', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23065, 'delivery.master.master_packaging.import', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23066, 'delivery.master.master_packaging', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23067, 'delivery.master.master_packaging.edit', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23068, 'delivery.master.master_packaging.update', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23069, 'delivery.master.master_packaging.create', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23070, 'delivery.master.master_packaging.insert', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23071, 'delivery.master.packaging.destroy', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23072, 'delivery.master.master_line.import', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23073, 'delivery.master.master_line', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23074, 'delivery.master.master_line.edit', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23075, 'delivery.master.master_line.update', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23076, 'delivery.master.master_line.create', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23077, 'delivery.master.master_line.insert', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23078, 'delivery.master.line.destroy', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23079, 'delivery.master.master_customer.import', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23080, 'delivery.master.master_customer', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23081, 'delivery.master.master_customer.edit', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23082, 'delivery.master.master_customer.update', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23083, 'delivery.master.master_customer.create', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23084, 'delivery.master.master_customer.insert', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23085, 'delivery.master.customer.destroy', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23086, 'delivery.master.master_partcard.import', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23087, 'delivery.master.master_partcard', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23088, 'delivery.master.master_partcard.edit', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23089, 'delivery.master.master_partcard.update', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23090, 'delivery.master.master_partcard.create', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23091, 'delivery.master.master_partcard.insert', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23092, 'delivery.master.partcard.destroy', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23093, 'delivery.master.master_manpower', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23094, 'delivery.master.master_manpower.edit', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23095, 'delivery.master.master_manpower.update', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23096, 'delivery.master.master_manpower.create', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23097, 'delivery.master.master_manpower.insert', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23098, 'delivery.master.manpower.destroy', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23099, 'delivery.pickupcustomer', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23100, 'delivery.pickupcustomer.edit', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23101, 'delivery.pickupcustomer.update', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23102, 'delivery.pickupcustomer.create', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23103, 'delivery.pickupcustomer.insert', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23104, 'delivery.pickupcustomer.destroy', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23105, 'delivery.preparation.create', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23106, 'delivery.preparation', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23107, 'delivery.preparation.member', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23108, 'delivery.preparation.insert', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23109, 'delivery.preparation.get_data_pic', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23110, 'delivery.preparation.get_data_detail_pickup', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23111, 'delivery.preparation.start_preparation', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23112, 'delivery.preparation.end_preparation', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23113, 'delivery.pickupcustomer.import', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23114, 'delivery.preparation.update', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23115, 'delivery.preparation.edit', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23116, 'delivery.preparation.destroy', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23117, 'delivery.preparation.export', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23118, 'delivery.preparation.dashboard', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23119, 'delivery.preparation.arrival', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23120, 'delivery.preparation.departure', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23121, 'delivery.preparation.import', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23122, 'delivery.delivery.import', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23123, 'delivery.delivery.create', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23124, 'delivery.delivery.insert', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23125, 'delivery.delivery.arrival', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23126, 'delivery.delivery.departure', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23127, 'delivery.delivery.edit', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23128, 'delivery.delivery.update', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23129, 'delivery.delivery.destroy', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23130, 'delivery.claim.claim', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23131, 'delivery.claim.create', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23132, 'delivery.claim.insert', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23133, 'delivery.claim.edit', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23134, 'delivery.claim.update', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23135, 'delivery.claim.destroy', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23136, 'delivery.claim.get_data_part', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23137, 'delivery.delivery', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23138, 'delivery.preparation.update_delay', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23139, 'delivery.preparation.security', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23140, 'delivery.claim.dashboard', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23141, 'delivery.delivery_note.import', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23142, 'delivery.delivery_note', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23143, 'delivery.delivery_note.create', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23144, 'delivery.delivery_note.insert', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23145, 'delivery.delivery_note.check', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23146, 'delivery.skills', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23147, 'delivery.skills.create', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23148, 'delivery.skills.insert', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23149, 'delivery.skills.edit', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23150, 'delivery.skills.update', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23151, 'delivery.skills.destroy', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23152, 'delivery.skills.export', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23153, 'delivery.skillmatrix', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23154, 'delivery.skillmatrix.create', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23155, 'delivery.skillmatrix.insert', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23156, 'delivery.skillmatrix.edit', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23157, 'delivery.skillmatrix.update', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23158, 'delivery.skillmatrix.destroy', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23159, 'delivery.skillmatrix.get_data_skillmatrix', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23160, 'delivery.skillmatrix.import', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23161, 'delivery.layout_area.insert', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23162, 'delivery.layout_area.create', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23163, 'delivery.layout_area', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23164, 'delivery.layout_area.edit', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23165, 'delivery.layout_area.update', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23166, 'delivery.layout_area.destroy', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23167, 'delivery.layout_area.get_mp_with_same_position', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23168, 'delivery.layout_area.get_mp_where_area', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23169, 'delivery.layout_area.default', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23170, 'delivery.planning_refreshment.create', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23171, 'delivery.planning_refreshment', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23172, 'delivery.planning_refreshment.edit', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23173, 'delivery.planning_refreshment.update', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23174, 'delivery.planning_refreshment.insert', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23175, 'delivery.planning_refreshment.destroy', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23176, 'delivery.planning_refreshment.update_status', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23177, 'delivery.henkaten_detail', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23178, 'delivery.dashboard', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23179, 'delivery.claim.graph', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23180, 'delivery.henkaten', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23181, 'delivery.all.graph', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23182, 'delivery.preparation.security.history', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23183, 'delivery.preparation.hold', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23184, 'quality.index', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23185, 'quality.area.index', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23186, 'quality.area.create', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23187, 'quality.area.store', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23188, 'quality.area.show', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23189, 'quality.area.edit', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23190, 'quality.area.update', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23191, 'quality.area.destroy', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23192, 'quality.process.index', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23193, 'quality.process.create', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23194, 'quality.process.store', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23195, 'quality.process.show', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23196, 'quality.process.edit', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23197, 'quality.process.update', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23198, 'quality.process.destroy', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23199, 'quality.machine.index', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23200, 'quality.machine.create', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23201, 'quality.machine.store', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23202, 'quality.machine.fetchProcess', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23203, 'quality.machine.show', 'web', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(23204, 'quality.machine.edit', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23205, 'quality.machine.update', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23206, 'quality.machine.destroy', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23207, 'quality.model.index', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23208, 'quality.model.create', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23209, 'quality.model.store', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23210, 'quality.model.fetchProcess', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23211, 'quality.model.fetchMachine', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23212, 'quality.model.fetchModel', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23213, 'quality.model.fetchPart', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23214, 'quality.model.show', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23215, 'quality.model.edit', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23216, 'quality.model.update', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23217, 'quality.model.destroy', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23218, 'quality.part.index', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23219, 'quality.part.create', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23220, 'quality.part.store', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23221, 'quality.part.show', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23222, 'quality.part.edit', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23223, 'quality.part.update', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23224, 'quality.part.destroy', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23225, 'quality.monitor.index', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23226, 'quality.monitor.create', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23227, 'quality.monitor.store', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23228, 'quality.monitor.show', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23229, 'quality.monitor.edit', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23230, 'quality.monitor.update', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23231, 'quality.monitor.destroy', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23232, 'quality.monitor.finish', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23233, 'quality.csqtime.index', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23234, 'quality.csqtime.create', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23235, 'quality.csqtime.store', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23236, 'quality.csqtime.show', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23237, 'quality.csqtime.edit', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23238, 'quality.csqtime.update', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23239, 'quality.csqtime.destroy', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23240, 'quality.ipqc.index', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23241, 'quality.ipqc.leader_approval', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23242, 'quality.ipqc.create', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23243, 'quality.ipqc.store', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23244, 'quality.ipqc.show', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23245, 'quality.ipqc.edit', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23246, 'quality.ipqc.update', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23247, 'quality.ipqc.destroy', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23248, 'quality.ipqc.finish', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23249, 'quality.csipqc.index', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23250, 'quality.csipqc.create', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23251, 'quality.csipqc.store', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23252, 'quality.csipqc.show', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23253, 'quality.csipqc.edit', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23254, 'quality.csipqc.update', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23255, 'quality.csipqc.destroy', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23256, 'quality.ngcategory.index', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23257, 'quality.ngcategory.create', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23258, 'quality.ngcategory.store', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23259, 'quality.ngcategory.show', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23260, 'quality.ngcategory.edit', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23261, 'quality.ngcategory.update', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23262, 'quality.ngcategory.destroy', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23263, 'quality.ngcategory.finish', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23264, 'quality.ipqc.get_count_cycle', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23265, 'quality.ipqc.get_detail_cs_ipqc', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23266, 'quality.ipqc.get_detail_cs_ipqc_shift', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23267, 'quality.csipqc.history.show', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23268, 'scanwi.index', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23269, 'scanwi.index.search', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23270, 'quality.csipqc.graph', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23271, 'quality.csipqc.autook', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23272, 'quality.ipqc.autook', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23273, 'quality.process.import', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23274, 'quality.machine.import', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23275, 'quality.model.import', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23276, 'quality.csipqc.delete', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23277, 'quality.part.import', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23278, 'quality.csipqc.summary', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23279, 'quality.csipqc.graphjson', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23280, 'quality.mpproduksi.index', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23281, 'quality.mpproduksi.create', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23282, 'quality.mpproduksi.store', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23283, 'quality.mpproduksi.edit', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23284, 'quality.mpproduksi.update', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23285, 'quality.mpproduksi.destroy', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23286, 'NewProductPortalSignupController.create', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23287, 'NewProductPortalSignupController.store', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23288, 'NewProductPortalSignupController.index', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23289, 'NewProductPortalSignupController.show', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23290, 'NewProductPortalSignupController.edit', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23291, 'NewProductPortalSignupController.update', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23292, 'NewProductPortalSignupController.destroy', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23293, 'NewProductPortalSignupController.approve', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23294, 'NewProductPortalSignupController.index_npd', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23295, 'NewProductPortalSignupController.approve_dept', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23296, 'NewProductPortalSignupController.approve_npd', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23297, 'scanwi.create', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23298, 'NewProductPortalScheduleController.index', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23299, 'NewProductPortalScheduleController.show', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23300, 'NewProductPortalScheduleController.edit', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23301, 'NewProductPortalScheduleController.update', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23302, 'NewProductPortalScheduleController.destroy', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23303, 'scanwi.store', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23304, 'NewProductPortalScheduleController.upload', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23305, 'NewProductPortalScheduleController.store', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23306, 'NewProductPortalScheduleController.download', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23307, 'NewProductPortalSignupController.edit_npd', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23308, 'NewProductPortalSignupController.update_npd', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23309, 'scanwi.index.all', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23310, 'scanwi.index.delete', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23311, 'NewProductPortalSignupController.approve_admin', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23312, 'NewProductPortalSignupController.index_superadmin', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23313, 'NewProductPortalSignupController.approve_superadmin', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23314, 'NewProductPortalSignupController.edit_superadmin', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23315, 'NewProductPortalScheduleAjiController.upload', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23316, 'NewProductPortalScheduleAjiController.show', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23317, 'NewProductPortalScheduleAjiController.edit', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23318, 'NewProductPortalScheduleAjiController.update', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23319, 'NewProductPortalScheduleAjiController.store', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23320, 'NewProductPortalScheduleAjiController.destroy', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23321, 'NewProductPortalScheduleAjiController.index', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23322, 'NewProductPortalScheduleAjiController.update_progress', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23323, 'NewProductPortalScheduleAjiController.update_plan_start', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23324, 'NewProductPortalScheduleAjiController.update_plan_end', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23325, 'NewProductPortalScheduleAjiController.update_start_time', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23326, 'NewProductPortalScheduleAjiController.update_end_time', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23327, 'NewProductPortalScheduleAjiController.syncToPica', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23328, 'NewProductPortalPicaScheduleAjiController.index', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23329, 'NewProductPortalPicaScheduleAjiController.edit', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23330, 'NewProductPortalPicaScheduleAjiController.destroy', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23331, 'NewProductPortalPicaScheduleAjiController.update', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23332, 'scanwi.edit', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23333, 'scanwi.update', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23334, 'detail_departments.index', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23335, 'detail_departments.create', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23336, 'detail_departments.store', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23337, 'detail_departments.show', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23338, 'detail_departments.edit', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23339, 'detail_departments.update', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23340, 'detail_departments.destroy', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23341, 'position.index', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23342, 'position.create', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23343, 'position.store', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23344, 'position.show', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23345, 'position.edit', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23346, 'position.update', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23347, 'position.destroy', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23348, 'urgensi.index', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23349, 'urgensi.create', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23350, 'urgensi.store', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23351, 'urgensi.show', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23352, 'urgensi.edit', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23353, 'urgensi.update', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23354, 'urgensi.destroy', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23355, 'NewProductPortalScheduleAjiController.dashboard', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23356, 'form_event.index', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23357, 'form_event.create', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23358, 'form_event.store', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23359, 'form_event.show', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23360, 'form_event.edit', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23361, 'form_event.update', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23362, 'form_event.destroy', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23363, 'history_form_event.history', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23364, 'history_form_event.insert', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23365, 'NewProductPortalScheduleAjiController.update_judge', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23366, 'NewProductPortalScheduleAjiController.show_pica_email', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23367, 'NewProductPortalPicaScheduleAjiController.kakotora', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23368, 'NewProductPortalScheduleAjiController.index_notification', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23369, 'NewProductPortalProjectEventController.index', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23370, 'calendar.index', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23371, 'calendar.create', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23372, 'calendar.store', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23373, 'calendar.show', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23374, 'calendar.edit', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23375, 'calendar.update', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23376, 'calendar.destroy', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23377, 'project_performance.index', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23378, 'project_performance.create', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23379, 'project_performance.store', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23380, 'project_performance.show', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23381, 'project_performance.edit', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23382, 'project_performance.update', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23383, 'project_performance.destroy', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23384, 'NewProductPortalProjectEventController.edit', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23385, 'project_open_issue.index', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23386, 'project_open_issue.create', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23387, 'project_open_issue.store', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23388, 'project_open_issue.show', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23389, 'project_open_issue.edit', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23390, 'project_open_issue.update', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23391, 'project_open_issue.destroy', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23392, 'project_reflection.index', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23393, 'project_reflection.create', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23394, 'project_reflection.store', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23395, 'project_reflection.show', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23396, 'project_reflection.edit', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23397, 'project_reflection.update', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23398, 'project_reflection.destroy', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23399, 'NewProductPortalScheduleAjiController.project_summary', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23400, 'generated::GbwpFdzFMcYpdQms', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23401, 'NewProductPortalScheduleAjiController.search_schedule_aji_upload', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23402, 'generated::5fWcp4PE1KLyky4o', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23403, 'project_open_issue_export', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23404, 'generated::twECatFIV4ru7IDa', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23405, 'pica_schedule_aji_internal_export', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23406, 'generated::5M6Mih9SeocjTRIy', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23407, 'box_type.index', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23408, 'box_type.create', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23409, 'box_type.store', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23410, 'box_type.show', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23411, 'box_type.edit', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23412, 'box_type.update', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23413, 'box_type.destroy', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23414, 'box_type.delete', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23415, 'generated::7tvoTBtLxT4p9J2Y', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23416, 'box_packaging.index', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23417, 'box_packaging.create', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23418, 'box_packaging.store', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23419, 'box_packaging.show', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23420, 'box_packaging.edit', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23421, 'box_packaging.update', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23422, 'box_packaging.destroy', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23423, 'generated::phlSpAdAvMbIbCJq', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23424, 'NewProductPortalPicaScheduleAjiController.update_judge', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23425, 'generated::TVAYBr79rjc9BM7C', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23426, 'generated::6XdGri8jQnfGLbpd', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23427, 'NewProductPortalOpenIssueController.update_judge', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23428, 'generated::M85GaSTxQNSBUsfU', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23429, 'work_order_ga.index', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23430, 'work_order_ga.create', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23431, 'work_order_ga.store', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23432, 'work_order_ga.show', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23433, 'work_order_ga.edit', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23434, 'work_order_ga.update', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23435, 'work_order_ga.destroy', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23436, 'generated::Vj3X8zIpShiT2iL6', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23437, 'generated::6uraX4CMXwll9mgc', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23438, 'work_order_ga.download', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23439, 'generated::YHt8NhcIhHCUXg17', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23440, 'generated::jvDFfbA0VspGdIB8', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23441, 'work_order_ga.upload_evidence', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23442, 'generated::z19z0HQrqOnRy5Ev', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23443, 'generated::4trju3D5waMVxb9l', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23444, 'history_form_event.showFile', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23445, 'generated::t5vXQzqweDlkDApQ', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23446, 'generated::zvJapTcV5EyO5pEW', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23447, 'work_order_ga.update_progress_ga_work_order', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23448, 'generated::uScZs7zGdVIPGC5H', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23449, 'work_order_ga.update_target_date', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23450, 'generated::oHvkEkmcO2ppR1G7', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23451, 'machine.index', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23452, 'machine.create', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23453, 'machine.store', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23454, 'machine.show', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23455, 'machine.edit', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23456, 'machine.update', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23457, 'machine.destroy', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23458, 'generated::DUmrF6LxQBqVzu3W', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23459, 'machine_detail.index', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23460, 'machine_detail.create', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23461, 'machine_detail.store', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23462, 'machine_detail.show', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23463, 'machine_detail.edit', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23464, 'machine_detail.update', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23465, 'machine_detail.destroy', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23466, 'generated::JTM1hgqgekOtw4Sa', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23467, 'machine_detail.import', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23468, 'generated::8P35d7u3RR5Kh17S', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23469, 'machine_detail.get_machine_detail', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23470, 'mold.destroy', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23471, 'mold.update', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23472, 'mold.edit', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23473, 'mold.show', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23474, 'mold.store', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23475, 'mold.create', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23476, 'mold.index', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23477, 'mold.import', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23478, 'jig.import', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23479, 'jig.destroy', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23480, 'jig.index', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23481, 'jig.edit', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23482, 'jig.show', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23483, 'jig.create', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23484, 'jig.update', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23485, 'jig.store', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(23486, 'wo.summary', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34');

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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `position` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`id`, `position`, `code`, `created_at`, `updated_at`) VALUES
(1, 'BOD', 'BOD', '2024-11-03 19:13:29', '2024-11-03 19:13:29'),
(2, 'Dept Head', 'DEPT', '2024-11-03 19:13:29', '2024-11-03 19:13:29'),
(3, 'Supervisor', 'SPV', '2024-11-03 19:13:29', '2024-11-03 19:13:29'),
(4, 'Officer', 'OFFICER', '2024-11-03 19:13:30', '2024-11-03 19:13:30'),
(5, 'Staff', 'STAFF', '2024-11-03 19:13:30', '2024-11-03 19:13:30'),
(6, 'Foreman', 'FRM', '2024-11-03 19:13:30', '2024-11-03 19:13:30'),
(7, 'Leader', 'LEAD', '2024-11-03 19:13:30', '2024-11-03 19:13:30'),
(8, 'Member', 'OP', '2024-11-03 19:13:30', '2024-11-03 19:13:30'),
(9, 'SUB', 'SUB', '2024-11-03 19:13:30', '2024-11-03 19:13:30'),
(12, 'Admin', 'ADM', '2024-11-04 18:41:03', '2025-01-14 04:24:46'),
(13, 'Department Head PIC', 'DeptHead PIC', '2024-11-04 18:41:03', '2024-11-04 18:41:03'),
(14, 'Deputy Dept Head', 'DDEPT', '2024-11-25 08:27:31', '2024-11-25 08:27:31'),
(15, 'Deputy BOD', 'DBOD', '2024-11-25 08:27:31', '2024-11-25 08:27:31'),
(16, 'Deputy Dept Head', 'DDEPT', '2024-11-25 08:36:59', '2024-11-25 08:36:59'),
(17, 'Deputy BOD', 'DBOD', '2024-11-25 08:36:59', '2024-11-25 08:36:59'),
(18, 'Deputy Dept Head', 'DDEPT', '2025-01-14 04:24:46', '2025-01-14 04:24:46'),
(19, 'Deputy BOD', 'DBOD', '2025-01-14 04:24:46', '2025-01-14 04:24:46'),
(20, 'Deputy Dept Head', 'DDEPT', '2025-01-14 04:34:29', '2025-01-14 04:34:29'),
(21, 'Deputy BOD', 'DBOD', '2025-01-14 04:34:29', '2025-01-14 04:34:29'),
(22, 'Deputy Dept Head', 'DDEPT', '2025-01-14 04:45:59', '2025-01-14 04:45:59'),
(23, 'Deputy BOD', 'DBOD', '2025-01-14 04:45:59', '2025-01-14 04:45:59'),
(24, 'Deputy Dept Head', 'DDEPT', '2025-01-14 06:18:28', '2025-01-14 06:18:28'),
(25, 'Deputy BOD', 'DBOD', '2025-01-14 06:18:28', '2025-01-14 06:18:28'),
(26, 'Deputy Dept Head', 'DDEPT', '2025-01-14 06:47:28', '2025-01-14 06:47:28'),
(27, 'Deputy BOD', 'DBOD', '2025-01-14 06:47:28', '2025-01-14 06:47:28'),
(28, 'Deputy Dept Head', 'DDEPT', '2025-01-14 06:51:50', '2025-01-14 06:51:50'),
(29, 'Deputy BOD', 'DBOD', '2025-01-14 06:51:50', '2025-01-14 06:51:50'),
(30, 'Deputy Dept Head', 'DDEPT', '2025-01-14 06:58:36', '2025-01-14 06:58:36'),
(31, 'Deputy BOD', 'DBOD', '2025-01-14 06:58:36', '2025-01-14 06:58:36'),
(32, 'Deputy Dept Head', 'DDEPT', '2025-01-14 07:13:39', '2025-01-14 07:13:39'),
(33, 'Deputy BOD', 'DBOD', '2025-01-14 07:13:39', '2025-01-14 07:13:39'),
(34, 'Deputy Dept Head', 'DDEPT', '2025-01-15 07:23:03', '2025-01-15 07:23:03'),
(35, 'Deputy BOD', 'DBOD', '2025-01-15 07:23:03', '2025-01-15 07:23:03'),
(36, 'Deputy Dept Head', 'DDEPT', '2025-01-15 07:27:27', '2025-01-15 07:27:27'),
(37, 'Deputy BOD', 'DBOD', '2025-01-15 07:27:28', '2025-01-15 07:27:28'),
(38, 'Deputy Dept Head', 'DDEPT', '2025-01-15 07:32:15', '2025-01-15 07:32:15'),
(39, 'Deputy BOD', 'DBOD', '2025-01-15 07:32:15', '2025-01-15 07:32:15'),
(40, 'Deputy Dept Head', 'DDEPT', '2025-01-21 06:01:07', '2025-01-21 06:01:07'),
(41, 'Deputy BOD', 'DBOD', '2025-01-21 06:01:07', '2025-01-21 06:01:07'),
(42, 'Deputy Dept Head', 'DDEPT', '2025-01-21 06:03:18', '2025-01-21 06:03:18'),
(43, 'Deputy BOD', 'DBOD', '2025-01-21 06:03:18', '2025-01-21 06:03:18'),
(44, 'Deputy Dept Head', 'DDEPT', '2025-01-21 06:05:18', '2025-01-21 06:05:18'),
(45, 'Deputy BOD', 'DBOD', '2025-01-21 06:05:18', '2025-01-21 06:05:18'),
(46, 'Deputy Dept Head', 'DDEPT', '2025-03-04 08:08:41', '2025-03-04 08:08:41'),
(47, 'Deputy BOD', 'DBOD', '2025-03-04 08:08:41', '2025-03-04 08:08:41'),
(48, 'Deputy Dept Head', 'DDEPT', '2025-05-21 04:29:01', '2025-05-21 04:29:01'),
(49, 'Deputy BOD', 'DBOD', '2025-05-21 04:29:01', '2025-05-21 04:29:01'),
(50, 'Deputy Dept Head', 'DDEPT', '2025-07-16 07:38:35', '2025-07-16 07:38:35'),
(51, 'Deputy BOD', 'DBOD', '2025-07-16 07:38:35', '2025-07-16 07:38:35'),
(52, 'Deputy Dept Head', 'DDEPT', '2025-07-17 00:52:35', '2025-07-17 00:52:35'),
(53, 'Deputy BOD', 'DBOD', '2025-07-17 00:52:35', '2025-07-17 00:52:35'),
(54, 'Deputy Dept Head', 'DDEPT', '2025-07-17 00:53:28', '2025-07-17 00:53:28'),
(55, 'Deputy BOD', 'DBOD', '2025-07-17 00:53:28', '2025-07-17 00:53:28'),
(56, 'Deputy Dept Head', 'DDEPT', '2025-07-17 01:02:22', '2025-07-17 01:02:22'),
(57, 'Deputy BOD', 'DBOD', '2025-07-17 01:02:22', '2025-07-17 01:02:22'),
(58, 'Deputy Dept Head', 'DDEPT', '2025-07-18 00:48:21', '2025-07-18 00:48:21'),
(59, 'Deputy BOD', 'DBOD', '2025-07-18 00:48:21', '2025-07-18 00:48:21'),
(60, 'Deputy Dept Head', 'DDEPT', '2025-07-18 00:49:53', '2025-07-18 00:49:53'),
(61, 'Deputy BOD', 'DBOD', '2025-07-18 00:49:53', '2025-07-18 00:49:53'),
(62, 'Deputy Dept Head', 'DDEPT', '2025-07-18 00:51:31', '2025-07-18 00:51:31'),
(63, 'Deputy BOD', 'DBOD', '2025-07-18 00:51:31', '2025-07-18 00:51:31'),
(64, 'Deputy Dept Head', 'DDEPT', '2025-07-18 00:52:26', '2025-07-18 00:52:26'),
(65, 'Deputy BOD', 'DBOD', '2025-07-18 00:52:26', '2025-07-18 00:52:26'),
(66, 'Deputy Dept Head', 'DDEPT', '2025-07-18 00:54:22', '2025-07-18 00:54:22'),
(67, 'Deputy BOD', 'DBOD', '2025-07-18 00:54:22', '2025-07-18 00:54:22'),
(68, 'Deputy Dept Head', 'DDEPT', '2025-07-18 01:09:43', '2025-07-18 01:09:43'),
(69, 'Deputy BOD', 'DBOD', '2025-07-18 01:09:43', '2025-07-18 01:09:43'),
(70, 'Deputy Dept Head', 'DDEPT', '2025-07-31 03:27:09', '2025-07-31 03:27:09'),
(71, 'Deputy BOD', 'DBOD', '2025-07-31 03:27:09', '2025-07-31 03:27:09'),
(72, 'Deputy Dept Head', 'DDEPT', '2025-07-31 06:50:14', '2025-07-31 06:50:14'),
(73, 'Deputy BOD', 'DBOD', '2025-07-31 06:50:14', '2025-07-31 06:50:14'),
(74, 'Deputy Dept Head', 'DDEPT', '2025-07-31 06:52:33', '2025-07-31 06:52:33'),
(75, 'Deputy BOD', 'DBOD', '2025-07-31 06:52:33', '2025-07-31 06:52:33');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(70) NOT NULL,
  `description` varchar(320) NOT NULL,
  `body` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `title`, `description`, `body`, `created_at`, `updated_at`) VALUES
(4, 4, 'test', 'test', 'test', '2021-11-15 02:19:54', '2021-11-15 02:19:54');

-- --------------------------------------------------------

--
-- Table structure for table `quality_cs_ipqcs`
--

CREATE TABLE `quality_cs_ipqcs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `quality_ipqc_id` bigint(20) NOT NULL,
  `shift` int(11) NOT NULL,
  `cycle` int(11) NOT NULL,
  `destructive_test` tinyint(4) DEFAULT 0,
  `destructive_test_remark` mediumtext DEFAULT NULL,
  `destructive_test_ng_cat` int(4) DEFAULT NULL,
  `destructive_test_photo` varchar(200) DEFAULT NULL,
  `destructive_test_causes` text DEFAULT NULL,
  `destructive_test_repair` text DEFAULT NULL,
  `destructive_test_repair_res` int(1) DEFAULT NULL,
  `destructive_test_hold_status` int(1) DEFAULT NULL,
  `destructive_test_qty` int(11) DEFAULT NULL,
  `destructive_test_hold_cat` tinyint(1) DEFAULT NULL,
  `destructive_test_approval` tinyint(1) DEFAULT NULL,
  `destructive_test_approval_qtyok` int(11) DEFAULT NULL,
  `destructive_test_approval_qtyng` int(11) DEFAULT NULL,
  `appearance_produk` tinyint(4) DEFAULT 0,
  `appearance_produk_remark` mediumtext DEFAULT NULL,
  `appearance_produk_ng_cat` int(4) DEFAULT NULL,
  `appearance_produk_photo` varchar(200) DEFAULT NULL,
  `appearance_produk_causes` text DEFAULT NULL,
  `appearance_produk_repair` text DEFAULT NULL,
  `appearance_produk_repair_res` int(1) DEFAULT NULL,
  `appearance_produk_hold_status` int(1) DEFAULT NULL,
  `appearance_produk_qty` int(11) DEFAULT NULL,
  `appearance_produk_hold_cat` int(1) DEFAULT NULL,
  `appearance_produk_approval` tinyint(1) DEFAULT NULL,
  `appearance_produk_approval_qtyok` int(11) DEFAULT NULL,
  `appearance_produk_approval_qtyng` int(11) DEFAULT NULL,
  `appearance_produk_mp_produksi` varchar(70) DEFAULT NULL,
  `parting_line` tinyint(4) DEFAULT 0,
  `parting_line_remark` mediumtext DEFAULT NULL,
  `parting_line_ng_cat` int(4) DEFAULT NULL,
  `parting_line_photo` varchar(200) DEFAULT NULL,
  `parting_line_causes` text DEFAULT NULL,
  `parting_line_repair` text DEFAULT NULL,
  `parting_line_repair_res` int(1) DEFAULT NULL,
  `parting_line_hold_status` int(1) DEFAULT NULL,
  `parting_line_qty` int(11) DEFAULT NULL,
  `parting_line_hold_cat` int(1) DEFAULT NULL,
  `parting_line_approval` tinyint(1) DEFAULT NULL,
  `parting_line_approval_qtyok` int(11) DEFAULT NULL,
  `parting_line_approval_qtyng` int(11) DEFAULT NULL,
  `parting_line_mp_produksi` varchar(70) DEFAULT NULL,
  `marking_cek_final` tinyint(4) DEFAULT 0,
  `marking_cek_final_remark` mediumtext DEFAULT NULL,
  `marking_cek_final_ng_cat` int(4) DEFAULT NULL,
  `marking_cek_final_photo` varchar(200) DEFAULT NULL,
  `marking_cek_final_causes` text DEFAULT NULL,
  `marking_cek_final_repair` text DEFAULT NULL,
  `marking_cek_final_repair_res` int(1) DEFAULT NULL,
  `marking_cek_final_hold_status` int(11) DEFAULT NULL,
  `marking_cek_final_qty` int(11) DEFAULT NULL,
  `marking_cek_final_hold_cat` int(11) DEFAULT NULL,
  `marking_cek_final_approval` tinyint(1) DEFAULT NULL,
  `marking_cek_final_approval_qtyok` int(11) DEFAULT NULL,
  `marking_cek_final_approval_qtyng` int(11) DEFAULT NULL,
  `marking_cek_final_mp_produksi` varchar(70) DEFAULT NULL,
  `marking_garansi_function` tinyint(4) DEFAULT 0,
  `marking_garansi_function_remark` mediumtext DEFAULT NULL,
  `marking_garansi_function_ng_cat` int(4) DEFAULT NULL,
  `marking_garansi_function_photo` varchar(200) DEFAULT NULL,
  `marking_garansi_function_causes` text DEFAULT NULL,
  `marking_garansi_function_repair` text DEFAULT NULL,
  `marking_garansi_function_repair_res` int(1) DEFAULT NULL,
  `marking_garansi_function_hold_status` int(11) DEFAULT NULL,
  `marking_garansi_function_qty` int(11) DEFAULT NULL,
  `marking_garansi_function_hold_cat` int(1) DEFAULT NULL,
  `marking_garansi_function_approval` tinyint(1) DEFAULT NULL,
  `marking_garansi_function_approval_qtyok` int(11) DEFAULT NULL,
  `marking_garansi_function_approval_qtyng` int(11) DEFAULT NULL,
  `marking_garansi_function_mp_produksi` varchar(70) DEFAULT NULL,
  `marking_identification` tinyint(4) DEFAULT 0,
  `marking_identification_remark` mediumtext DEFAULT NULL,
  `marking_identification_ng_cat` int(4) DEFAULT NULL,
  `marking_identification_photo` varchar(200) DEFAULT NULL,
  `marking_identification_causes` text DEFAULT NULL,
  `marking_identification_repair` text DEFAULT NULL,
  `marking_identification_repair_res` int(1) DEFAULT NULL,
  `marking_identification_hold_status` int(11) DEFAULT NULL,
  `marking_identification_qty` int(11) DEFAULT NULL,
  `marking_identification_hold_cat` int(1) DEFAULT NULL,
  `marking_identification_approval` tinyint(1) DEFAULT NULL,
  `marking_identification_approval_qtyok` int(11) DEFAULT NULL,
  `marking_identification_approval_qtyng` int(11) DEFAULT NULL,
  `marking_identification_mp_produksi` varchar(70) DEFAULT NULL,
  `kelengkapan_komponen` tinyint(4) DEFAULT 0,
  `kelengkapan_komponen_remark` mediumtext DEFAULT NULL,
  `kelengkapan_komponen_ng_cat` int(4) DEFAULT NULL,
  `kelengkapan_komponen_photo` varchar(200) DEFAULT NULL,
  `kelengkapan_komponen_causes` text DEFAULT NULL,
  `kelengkapan_komponen_repair` text DEFAULT NULL,
  `kelengkapan_komponen_repair_res` int(1) DEFAULT NULL,
  `kelengkapan_komponen_hold_status` tinyint(1) DEFAULT NULL,
  `kelengkapan_komponen_qty` int(11) DEFAULT NULL,
  `kelengkapan_komponen_hold_cat` tinyint(1) DEFAULT NULL,
  `kelengkapan_komponen_approval` tinyint(1) DEFAULT NULL,
  `kelengkapan_komponen_approval_qtyok` int(11) DEFAULT NULL,
  `kelengkapan_komponen_approval_qtyng` int(11) DEFAULT NULL,
  `kelengkapan_komponen_mp_produksi` varchar(70) DEFAULT NULL,
  `housing` tinyint(4) DEFAULT 0,
  `lens` tinyint(4) DEFAULT 0,
  `extension` tinyint(4) DEFAULT 0,
  `extension_rs_1` tinyint(4) DEFAULT 0,
  `reflector_1` tinyint(4) DEFAULT 0,
  `reflector_2` tinyint(4) DEFAULT 0,
  `light_guide` tinyint(4) DEFAULT 0,
  `base` tinyint(4) DEFAULT 0,
  `ldm` tinyint(4) DEFAULT 0,
  `wire_harness_1` tinyint(4) DEFAULT 0,
  `wire_harness_2` tinyint(4) DEFAULT 0,
  `wire_harness_3` tinyint(4) DEFAULT 0,
  `wire_harness_4` tinyint(4) DEFAULT 0,
  `wire_harness_5` tinyint(4) DEFAULT 0,
  `pcb_assy_2` tinyint(4) DEFAULT 0,
  `pcb_assy_3` tinyint(4) DEFAULT 0,
  `gore_tag` tinyint(4) DEFAULT 0,
  `tapping_screw` tinyint(4) DEFAULT 0,
  `tapping_screw_assy` tinyint(4) DEFAULT 0,
  `screw_pin` tinyint(4) DEFAULT 0,
  `non_woven_tape` tinyint(4) DEFAULT 0,
  `vent_cap_assy` tinyint(4) DEFAULT 0,
  `kondisi_jig` tinyint(4) DEFAULT 0,
  `kondisi_pokayoke` tinyint(4) DEFAULT 0,
  `operator_wi_qpoint` tinyint(4) DEFAULT 0,
  `childpart_identitas` tinyint(4) DEFAULT 0,
  `kondisi_parameter` tinyint(4) DEFAULT 0,
  `judge` tinyint(4) DEFAULT 0,
  `approval_status` tinyint(1) DEFAULT 0,
  `created_by` int(11) DEFAULT 0,
  `updated_by` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quality_cs_ipqcs`
--

INSERT INTO `quality_cs_ipqcs` (`id`, `quality_ipqc_id`, `shift`, `cycle`, `destructive_test`, `destructive_test_remark`, `destructive_test_ng_cat`, `destructive_test_photo`, `destructive_test_causes`, `destructive_test_repair`, `destructive_test_repair_res`, `destructive_test_hold_status`, `destructive_test_qty`, `destructive_test_hold_cat`, `destructive_test_approval`, `destructive_test_approval_qtyok`, `destructive_test_approval_qtyng`, `appearance_produk`, `appearance_produk_remark`, `appearance_produk_ng_cat`, `appearance_produk_photo`, `appearance_produk_causes`, `appearance_produk_repair`, `appearance_produk_repair_res`, `appearance_produk_hold_status`, `appearance_produk_qty`, `appearance_produk_hold_cat`, `appearance_produk_approval`, `appearance_produk_approval_qtyok`, `appearance_produk_approval_qtyng`, `appearance_produk_mp_produksi`, `parting_line`, `parting_line_remark`, `parting_line_ng_cat`, `parting_line_photo`, `parting_line_causes`, `parting_line_repair`, `parting_line_repair_res`, `parting_line_hold_status`, `parting_line_qty`, `parting_line_hold_cat`, `parting_line_approval`, `parting_line_approval_qtyok`, `parting_line_approval_qtyng`, `parting_line_mp_produksi`, `marking_cek_final`, `marking_cek_final_remark`, `marking_cek_final_ng_cat`, `marking_cek_final_photo`, `marking_cek_final_causes`, `marking_cek_final_repair`, `marking_cek_final_repair_res`, `marking_cek_final_hold_status`, `marking_cek_final_qty`, `marking_cek_final_hold_cat`, `marking_cek_final_approval`, `marking_cek_final_approval_qtyok`, `marking_cek_final_approval_qtyng`, `marking_cek_final_mp_produksi`, `marking_garansi_function`, `marking_garansi_function_remark`, `marking_garansi_function_ng_cat`, `marking_garansi_function_photo`, `marking_garansi_function_causes`, `marking_garansi_function_repair`, `marking_garansi_function_repair_res`, `marking_garansi_function_hold_status`, `marking_garansi_function_qty`, `marking_garansi_function_hold_cat`, `marking_garansi_function_approval`, `marking_garansi_function_approval_qtyok`, `marking_garansi_function_approval_qtyng`, `marking_garansi_function_mp_produksi`, `marking_identification`, `marking_identification_remark`, `marking_identification_ng_cat`, `marking_identification_photo`, `marking_identification_causes`, `marking_identification_repair`, `marking_identification_repair_res`, `marking_identification_hold_status`, `marking_identification_qty`, `marking_identification_hold_cat`, `marking_identification_approval`, `marking_identification_approval_qtyok`, `marking_identification_approval_qtyng`, `marking_identification_mp_produksi`, `kelengkapan_komponen`, `kelengkapan_komponen_remark`, `kelengkapan_komponen_ng_cat`, `kelengkapan_komponen_photo`, `kelengkapan_komponen_causes`, `kelengkapan_komponen_repair`, `kelengkapan_komponen_repair_res`, `kelengkapan_komponen_hold_status`, `kelengkapan_komponen_qty`, `kelengkapan_komponen_hold_cat`, `kelengkapan_komponen_approval`, `kelengkapan_komponen_approval_qtyok`, `kelengkapan_komponen_approval_qtyng`, `kelengkapan_komponen_mp_produksi`, `housing`, `lens`, `extension`, `extension_rs_1`, `reflector_1`, `reflector_2`, `light_guide`, `base`, `ldm`, `wire_harness_1`, `wire_harness_2`, `wire_harness_3`, `wire_harness_4`, `wire_harness_5`, `pcb_assy_2`, `pcb_assy_3`, `gore_tag`, `tapping_screw`, `tapping_screw_assy`, `screw_pin`, `non_woven_tape`, `vent_cap_assy`, `kondisi_jig`, `kondisi_pokayoke`, `operator_wi_qpoint`, `childpart_identitas`, `kondisi_parameter`, `judge`, `approval_status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 3, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, 3, 'appearance_produk20230510133723quality teguh 1.png', 'pi', 'ca', 1, 0, 5, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 3, 0, 39, 39, '2023-05-10 06:37:23', '2023-05-10 06:37:23', NULL),
(2, 3, 1, 2, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, '2023-05-10 07:16:21', '2023-05-10 07:16:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `quality_cs_ipqcs_history`
--

CREATE TABLE `quality_cs_ipqcs_history` (
  `id` int(12) NOT NULL,
  `cs_ipqc_id` bigint(20) NOT NULL,
  `approval_status` text DEFAULT NULL,
  `judge` tinyint(4) DEFAULT NULL,
  `user_approver` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `quality_cs_ipqcs_history`
--

INSERT INTO `quality_cs_ipqcs_history` (`id`, `cs_ipqc_id`, `approval_status`, `judge`, `user_approver`, `updated_at`, `created_at`) VALUES
(1, 2, ' appearance_produk approved', 1, 'leader quality', '2023-05-09 09:13:42', '2023-05-09 09:13:42');

-- --------------------------------------------------------

--
-- Table structure for table `quality_cs_qtimes`
--

CREATE TABLE `quality_cs_qtimes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `quality_monitor_id` bigint(20) NOT NULL,
  `shift` int(11) NOT NULL,
  `cycle` int(11) NOT NULL,
  `destructive_test` tinyint(4) DEFAULT 0,
  `destructive_test_remark` mediumtext DEFAULT NULL,
  `appearance_produk` tinyint(4) DEFAULT 0,
  `appearance_produk_remark` mediumtext DEFAULT NULL,
  `parting_line` tinyint(4) DEFAULT 0,
  `parting_line_remark` mediumtext DEFAULT NULL,
  `marking_cek_final` tinyint(4) DEFAULT 0,
  `marking_cek_final_remark` mediumtext DEFAULT NULL,
  `marking_garansi_function` tinyint(4) DEFAULT 0,
  `marking_garansi_function_remark` mediumtext DEFAULT NULL,
  `marking_identification` tinyint(4) DEFAULT 0,
  `marking_identification_remark` mediumtext DEFAULT NULL,
  `kelengkapan_komponen` tinyint(4) DEFAULT 0,
  `kelengkapan_komponen_remark` mediumtext DEFAULT NULL,
  `housing` tinyint(4) DEFAULT 0,
  `lens` tinyint(4) DEFAULT 0,
  `extension` tinyint(4) DEFAULT 0,
  `extension_rs_1` tinyint(4) DEFAULT 0,
  `reflector_1` tinyint(4) DEFAULT 0,
  `reflector_2` tinyint(4) DEFAULT 0,
  `light_guide` tinyint(4) DEFAULT 0,
  `base` tinyint(4) DEFAULT 0,
  `ldm` tinyint(4) DEFAULT 0,
  `wire_harness_1` tinyint(4) DEFAULT 0,
  `wire_harness_2` tinyint(4) DEFAULT 0,
  `wire_harness_3` tinyint(4) DEFAULT 0,
  `wire_harness_4` tinyint(4) DEFAULT 0,
  `wire_harness_5` tinyint(4) DEFAULT 0,
  `pcb_assy_2` tinyint(4) DEFAULT 0,
  `pcb_assy_3` tinyint(4) DEFAULT 0,
  `gore_tag` tinyint(4) DEFAULT 0,
  `tapping_screw` tinyint(4) DEFAULT 0,
  `tapping_screw_assy` tinyint(4) DEFAULT 0,
  `screw_pin` tinyint(4) DEFAULT 0,
  `non_woven_tape` tinyint(4) DEFAULT 0,
  `vent_cap_assy` tinyint(4) DEFAULT 0,
  `kondisi_jig` tinyint(4) DEFAULT 0,
  `kondisi_pokayoke` tinyint(4) DEFAULT 0,
  `operator_wi_qpoint` tinyint(4) DEFAULT 0,
  `childpart_identitas` tinyint(4) DEFAULT 0,
  `kondisi_parameter` tinyint(4) DEFAULT 0,
  `judge` tinyint(4) DEFAULT 0,
  `approval_status` tinyint(1) DEFAULT 0,
  `created_by` int(11) DEFAULT 0,
  `updated_by` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quality_ipqcs`
--

CREATE TABLE `quality_ipqcs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `lot_produksi` varchar(45) DEFAULT NULL,
  `judgement` int(1) DEFAULT 0,
  `quality_process_id` varchar(20) NOT NULL,
  `quality_machine_id` varchar(20) NOT NULL,
  `quality_model_id` varchar(20) NOT NULL,
  `quality_part_id` varchar(20) NOT NULL,
  `cs_status` tinyint(1) DEFAULT 0,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quality_ipqcs`
--

INSERT INTO `quality_ipqcs` (`id`, `user_id`, `lot_produksi`, `judgement`, `quality_process_id`, `quality_machine_id`, `quality_model_id`, `quality_part_id`, `cs_status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 39, '3E9', 0, '1', 'PIMC01', 'D22D', '4', 2, 39, 39, '2023-05-09 08:51:34', '2023-05-09 09:22:07', NULL),
(3, 39, '3E9', 0, '1', 'PIMC01', 'D22D', '4', 2, 39, 39, '2023-05-09 08:53:10', '2023-05-10 06:37:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `quality_machines`
--

CREATE TABLE `quality_machines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `machine_id` varchar(9) NOT NULL,
  `process_id` varchar(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(320) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quality_machines`
--

INSERT INTO `quality_machines` (`id`, `machine_id`, `process_id`, `name`, `description`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'PIMC01', '1', 'Injection MC 1', 'Machine Plastic Injection Single Color 1250 Ton', 42, 0, '2023-05-09 04:16:46', '2023-05-09 04:16:46'),
(2, 'PIMC02', '1', 'Injection MC 2', 'Machine Plastic Injection Single Color 160 Ton', 42, 0, '2023-05-09 04:16:46', '2023-05-09 04:16:46'),
(3, 'PIMC03', '1', 'Injection MC 3', 'Machine Plastic Injection Single Color 160 Ton', 42, 0, '2023-05-09 04:16:46', '2023-05-09 04:16:46'),
(4, 'PIMC04', '1', 'Injection MC 4', 'Machine Plastic Injection Single Color 650 Ton', 42, 0, '2023-05-09 04:16:46', '2023-05-09 04:16:46'),
(5, 'PIMC05', '1', 'Injection MC 5', 'Machine Plastic Injection Single Color 650 Ton', 42, 0, '2023-05-09 04:16:46', '2023-05-09 04:16:46'),
(6, 'PIMC06', '1', 'Injection MC 6', 'Machine Plastic Injection Single Color 1250 Ton', 42, 0, '2023-05-09 04:16:46', '2023-05-09 04:16:46'),
(7, 'PIMC07', '1', 'Injection MC 7', 'Machine Plastic Injection BMC', 42, 0, '2023-05-09 04:16:46', '2023-05-09 04:16:46'),
(8, 'PIMC08', '1', 'Injection MC 8', 'Machine Plastic Injection Two Color 1250 Ton', 42, 0, '2023-05-09 04:16:46', '2023-05-09 04:16:46'),
(9, 'PIMC09', '1', 'Injection MC 9', 'Machine Plastic Injection Single Color 450 Ton', 42, 0, '2023-05-09 04:16:46', '2023-05-09 04:16:46'),
(10, 'PIMC10', '1', 'Injection MC 10', 'Machine Plastic Injection Single Color 450 Ton', 42, 0, '2023-05-09 04:16:46', '2023-05-09 04:16:46'),
(11, 'PIMC11', '1', 'Injection MC 11', 'Machine Plastic Injection Three Color 1400 Ton', 42, 0, '2023-05-09 04:16:46', '2023-05-09 04:16:46'),
(12, 'PIMC12', '1', 'Injection MC 12', 'Machine Plastic Injection Three Color 1850 Ton', 42, 0, '2023-05-09 04:16:46', '2023-05-09 04:16:46'),
(13, 'PIMC13', '1', 'Injection MC 13', 'Machine Plastic Injection Three Color 1850 Ton', 42, 0, '2023-05-09 04:16:46', '2023-05-09 04:16:46'),
(14, 'ALVM01', '2', 'Vacuum Metallizing 1', 'Alluminium Vacuum Metallizing Machine Dahyong', 42, 0, '2023-05-09 04:16:46', '2023-05-09 04:16:46'),
(15, 'ALVM02', '2', 'Vacuum Metallizing 2', 'Alluminium Vacuum Metallizing Machine Chen Li', 42, 0, '2023-05-09 04:16:46', '2023-05-09 04:16:46'),
(16, 'STAP01', '2', 'Auto Painting', 'Automatic Robot Painting Machine', 42, 0, '2023-05-09 04:16:46', '2023-05-09 04:16:46'),
(17, 'STHC01', '2', 'Hard Coating', 'Hardcoating Line', 42, 0, '2023-05-09 04:16:46', '2023-05-09 04:16:46'),
(18, 'USWA01', '3', 'Ultrasonic Welding 1', 'Ultrasonic Welding MC1', 42, 0, '2023-05-09 04:16:46', '2023-05-09 04:16:46'),
(19, 'USWA02', '3', 'Ultrasonic Welding 2', 'Ultrasonic Welding MC2', 42, 0, '2023-05-09 04:16:46', '2023-05-09 04:16:46'),
(20, 'USWA03', '3', 'Ultrasonic Welding 3', 'Ultrasonic Welding MC3', 42, 0, '2023-05-09 04:16:46', '2023-05-09 04:16:46'),
(21, 'USWA04', '3', 'Ultrasonic Welding 4', 'Ultrasonic Welding MC4', 42, 0, '2023-05-09 04:16:46', '2023-05-09 04:16:46'),
(22, 'USWA05', '3', 'Ultrasonic Welding 5', 'Ultrasonic Welding MC5', 42, 0, '2023-05-09 04:16:46', '2023-05-09 04:16:46'),
(23, 'USWA06', '3', 'Ultrasonic Welding 6', 'Ultrasonic Welding MC6', 42, 0, '2023-05-09 04:16:46', '2023-05-09 04:16:46'),
(24, 'USWA07', '3', 'Ultrasonic Welding 7', 'Ultrasonic Welding MC7', 42, 0, '2023-05-09 04:16:46', '2023-05-09 04:16:46'),
(25, 'ALVIB1', '3', 'Air Leak Vibration 1', 'Airleak test MC1 for after Vibration Welding', 42, 0, '2023-05-09 04:16:46', '2023-05-09 04:16:46'),
(26, 'ALVIB2', '3', 'Air Leak Vibration 2', 'Airleak test MC2 for after Vibration Welding', 42, 0, '2023-05-09 04:16:46', '2023-05-09 04:16:46'),
(27, 'ALVIB3', '3', 'Air Leak Vibration 3', 'Airleak test MC3 for after Vibration Welding', 42, 0, '2023-05-09 04:16:46', '2023-05-09 04:16:46'),
(28, 'POSM01', '3', 'Pos Manual', 'Process Assembling Manual', 42, 0, '2023-05-09 04:16:46', '2023-05-09 04:16:46'),
(29, 'ALUSW1', '3', 'Air Leak Ultrasonic (Pos) 1', 'Airleak test MC1 for after Ultrasonic Welding', 42, 0, '2023-05-09 04:16:46', '2023-05-09 04:16:46'),
(30, 'ALUSW2', '3', 'Air Leak Ultrasonic (Pos) 2', 'Airleak test MC2 for after Ultrasonic Welding', 42, 0, '2023-05-09 04:16:46', '2023-05-09 04:16:46'),
(31, 'VIBW01', '3', 'Vibration Welding 1', 'Vibration Welding MC1', 42, 0, '2023-05-09 04:16:46', '2023-05-09 04:16:46'),
(32, 'VIBW02', '3', 'Vibration Welding 2', 'Vibration Welding MC2', 42, 0, '2023-05-09 04:16:46', '2023-05-09 04:16:46'),
(33, 'VIBW03', '3', 'Vibration Welding 3', 'Vibration Welding MC3', 42, 0, '2023-05-09 04:16:46', '2023-05-09 04:16:46'),
(34, 'VIBW04', '3', 'Vibration Welding 4', 'Vibration Welding MC4', 42, 0, '2023-05-09 04:16:46', '2023-05-09 04:16:46'),
(35, 'HPA001', '3', 'Hot Press', 'Hot Press', 42, 0, '2023-05-09 04:16:46', '2023-05-09 04:16:46'),
(36, 'GLUE01', '3', 'Glue Line 1', 'Assembling Glue Line 1', 42, 0, '2023-05-09 04:16:46', '2023-05-09 04:16:46'),
(37, 'GLUE02', '3', 'Glue Line 2', 'Assembling Glue Line 2', 42, 0, '2023-05-09 04:16:46', '2023-05-09 04:16:46'),
(38, 'GLUE03', '3', 'Glue Line 3', 'Assembling Glue Line 3', 42, 0, '2023-05-09 04:16:46', '2023-05-09 04:16:46'),
(39, 'HPWA01', '3', 'Hot Plate Welding 1', 'Hot Plate Welding Line 1', 42, 0, '2023-05-09 04:16:46', '2023-05-09 04:16:46'),
(40, 'HPWA02', '3', 'Hot Plate Welding 2', 'Hot Plate Welding Line 2', 42, 0, '2023-05-09 04:16:46', '2023-05-09 04:16:46'),
(41, 'HPWA03', '3', 'Hot Plate Welding 3', 'Hot Plate Welding Line 3', 42, 0, '2023-05-09 04:16:46', '2023-05-09 04:16:46'),
(42, 'HPWA04', '3', 'Hot Plate Welding 4', 'Hot Plate Welding Line 4', 42, 0, '2023-05-09 04:16:46', '2023-05-09 04:16:46'),
(43, 'HPWA05', '3', 'Hot Plate Welding 5', 'Hot Plate Welding Line 5', 42, 0, '2023-05-09 04:16:46', '2023-05-09 04:16:46'),
(44, 'HPWA06', '3', 'Hot Plate Welding 6', 'Hot Plate Welding Line 6', 42, 0, '2023-05-09 04:16:46', '2023-05-09 04:16:46');

-- --------------------------------------------------------

--
-- Table structure for table `quality_models`
--

CREATE TABLE `quality_models` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `model_id` varchar(9) NOT NULL,
  `process_id` int(11) NOT NULL,
  `machine_id` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(320) DEFAULT NULL,
  `created_by` int(11) DEFAULT 0,
  `updated_by` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quality_models`
--

INSERT INTO `quality_models` (`id`, `model_id`, `process_id`, `machine_id`, `name`, `description`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'D22D', 1, 'PIMC01', 'D22D', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(2, 'ISEK', 1, 'PIMC01', 'Iseki', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(3, '700P', 1, 'PIMC01', '700P', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(4, 'VT01', 1, 'PIMC01', 'VT01', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(5, 'VT02', 1, 'PIMC01', 'VT02', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(6, 'YADN', 1, 'PIMC01', 'Yadin', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(7, '800A', 1, 'PIMC02', '800A', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(8, '660A', 1, 'PIMC02', '660A', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(9, 'D12L', 1, 'PIMC02', 'D12L', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(10, 'D40L', 1, 'PIMC02', 'D40L', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(11, '560B', 1, 'PIMC02', '560B', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(12, 'D14N', 1, 'PIMC02', 'D14N', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(13, 'D55L', 1, 'PIMC03', 'D55L', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(14, 'D39N', 1, 'PIMC03', 'D39N', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(15, 'D28A', 1, 'PIMC03', 'D28A', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(16, 'D13L', 1, 'PIMC03', 'D13L', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(17, 'D06A', 1, 'PIMC04', 'D06A', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(18, 'D21N', 1, 'PIMC04', 'D21N', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(19, 'KUBO', 1, 'PIMC04', 'Kubota', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(20, 'D30D', 1, 'PIMC04', 'D30D', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(21, 'D22D', 1, 'PIMC04', 'D22D', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(22, 'D17D', 1, 'PIMC05', 'D17D', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(23, 'D26A', 1, 'PIMC05', 'D26A', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(24, 'D30D', 1, 'PIMC05', 'D30D', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(25, 'YADI', 1, 'PIMC05', 'Yadin', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(26, 'D22D', 1, 'PIMC06', 'D22D', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(27, 'ISEK', 1, 'PIMC06', 'Iseki', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(28, '700P', 1, 'PIMC06', '700P', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(29, 'D26A', 1, 'PIMC06', 'D26A', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(30, 'VT01', 1, 'PIMC06', 'VT01', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(31, 'VT02', 1, 'PIMC06', 'VT02', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(32, 'D12L', 1, 'PIMC06', 'D12L', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(33, 'D12L', 1, 'PIMC08', 'D12L', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(34, 'D12L', 1, 'PIMC08', 'D12L', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(35, 'D06A', 1, 'PIMC09', 'D06A', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(36, 'D26A', 1, 'PIMC10', 'D26A', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(37, 'D26A', 1, 'PIMC11', 'D26A', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(38, 'D26A', 1, 'PIMC12', 'D26A', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(39, 'D22D', 2, 'ALVM01', 'D22D', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(40, 'ISEK', 2, 'ALVM01', 'Iseki', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(41, 'D17D', 2, 'ALVM01', 'D17D', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(42, '700P', 2, 'ALVM01', '700P', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(43, 'ALMK', 2, 'ALVM01', 'ALMK', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(44, 'D21N', 2, 'ALVM01', 'D21N', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(45, 'VT01', 2, 'ALVM01', 'VT01', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(46, 'VT02', 2, 'ALVM01', 'VT02', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(47, 'D12L', 2, 'ALVM01', 'D12L', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(48, 'YADI', 2, 'ALVM01', 'Yadin', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(49, 'D40L', 2, 'ALVM01', 'D40L', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(50, 'KUBO', 2, 'ALVM01', 'Kubota', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(51, 'D06A', 2, 'ALVM01', 'D06A', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(52, 'D26A', 2, 'ALVM02', 'D26A', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(53, 'D40D', 2, 'STAP01', 'D40D', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(54, 'D30D', 2, 'STAP01', 'D30D', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(55, 'YADI', 2, 'STAP01', 'Yadin', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(56, 'D06A', 2, 'STAP01', 'D06A', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(57, 'D40L', 2, 'STAP01', 'D40L', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(58, 'D28A', 2, 'STHC01', 'D28A', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(59, 'ISEK', 2, 'STHC01', 'Iseki', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(60, '700P', 2, 'STHC01', '700P', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(61, 'D05A', 2, 'STHC01', 'D05A', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(62, 'D21N', 2, 'STHC01', 'D21N', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(63, 'D13L', 2, 'STHC01', 'D13L', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(64, 'ALMK', 2, 'STHC01', 'ALMK', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(65, 'D55L', 2, 'STHC01', 'D55L', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(66, 'D39N', 2, 'STHC01', 'D39N', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(67, 'VT01', 2, 'STHC01', 'VT01', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(68, 'YADI', 2, 'STHC01', 'Yadin', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(69, 'D91L', 3, 'USWA03', 'D91L/92L', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(70, 'D41N', 3, 'USWA03', 'D41N', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(71, '800A', 3, 'USWA03', '800A', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(72, 'D99B', 3, 'USWA03', 'D99B/D01N/D26A', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(73, '195A', 3, 'USWA03', '195A', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(74, 'D40D', 3, 'USWA03', 'D40D', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(75, 'NSER', 3, 'USWA03', 'N-Series (700P)', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(76, 'D99B', 3, 'USWA03', 'D99B/D41N', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(77, 'D12L', 3, 'USWA03', 'D12L', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(78, 'D99B', 3, 'USWA04', 'D99B/D01N/D26A', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(79, 'D41N', 3, 'USWA05', 'D41N', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(80, 'D40L', 3, 'USWA05', 'D40L', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(81, '560B', 3, 'USWA05', '560B', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(82, 'D14N', 3, 'USWA05', 'D14N', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(83, 'D26A', 3, 'USWA05', 'D26A', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(84, 'D01N', 3, 'USWA05', 'D01N', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(85, 'D28A', 3, 'USWA06', 'D28A', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(86, 'D55L', 3, 'USWA06', 'D55L', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(87, 'D30D', 3, 'ALVIB1', 'D30D', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(88, 'D14N', 3, 'ALVIB1', 'D14N', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(89, 'D17D', 3, 'ALVIB1', 'D17D', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(90, 'D14N', 3, 'ALVIB2', 'D14N GCC', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(91, 'D14N', 3, 'ALVIB2', 'D14N', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(92, 'D12L', 3, 'ALVIB2', 'D12L', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(93, '660A', 3, 'ALVIB2', '660A', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(94, 'D28A', 3, 'ALVIB2', 'D28A', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(95, 'D14N', 3, 'ALVIB3', 'D14N GCC', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(96, 'D14N', 3, 'ALVIB3', 'D14N', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(97, 'D55L', 3, 'ALVIB3', 'D55L', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(98, 'D21N', 3, 'ALVIB3', 'D21N', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(99, 'D58A', 3, 'POSM01', 'D58A', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(100, 'D12L', 3, 'POSM01', 'D12L', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(101, 'XXXX', 3, 'POSM01', 'XXXX', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(102, 'D99B', 3, 'POSM01', 'D99B/D41N', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(103, 'X11M', 3, 'POSM01', 'X11M', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(104, 'D40L', 3, 'POSM01', 'D40L', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(105, '560B', 3, 'ALUSW1', '560B', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(106, 'D40D', 3, 'ALUSW1', 'D40D', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(107, 'D55L', 3, 'ALUSW1', 'D55L', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(108, 'NSER', 3, 'ALUSW1', 'N-Series (700P)', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(109, 'NSER', 3, 'ALUSW1', 'N-Series (100P)', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(110, 'D99B', 3, 'ALUSW1', 'D99B/D41N', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(111, 'D12L', 3, 'ALUSW1', 'D12L', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(112, '700A', 3, 'ALUSW1', '700A', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(113, 'D88D', 3, 'ALUSW1', 'D88D SP', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(114, 'D88D', 3, 'ALUSW1', 'D88D', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(115, 'D40L', 3, 'ALUSW2', 'D40L', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(116, 'D14N', 3, 'ALUSW2', 'D14N', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(117, 'D16B', 3, 'ALUSW2', 'D16B', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(118, 'D80B', 3, 'ALUSW2', 'D80B', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(119, 'D55L', 3, 'ALUSW2', 'D55L', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(120, 'D26A', 3, 'ALUSW2', 'D26A', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(121, 'D01N', 3, 'ALUSW2', 'D01N', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(122, 'D12L', 3, 'ALUSW2', 'D12L', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(123, 'D39N', 3, 'ALUSW2', 'D39N', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(124, 'D28A', 3, 'ALUSW2', 'D28A', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(125, 'D30D', 3, 'VIBW01', 'D30D', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(126, 'D14N', 3, 'VIBW01', 'D14N', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(127, 'D17D', 3, 'VIBW01', 'D17D', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(128, 'D14N', 3, 'VIBW02', 'D14N GCC', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(129, 'D14N', 3, 'VIBW02', 'D14N', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(130, 'D12L', 3, 'VIBW02', 'D12L', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(131, 'D28A', 3, 'VIBW02', 'D28A', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(132, '660A', 3, 'VIBW02', '660A', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(133, 'D14N', 3, 'VIBW03', 'D14N GCC', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(134, 'D14N', 3, 'VIBW03', 'D14N', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(135, 'D55L', 3, 'VIBW03', 'D55L', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(136, 'D21N', 3, 'VIBW03', 'D21N', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(137, 'D05A', 3, 'VIBW03', 'D05A', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(138, 'D12L', 3, 'VIBW03', 'D12L', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(139, 'D39N', 3, 'VIBW03', 'D39N', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(140, 'D30D', 3, 'HPA001', 'D30D', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(141, 'D06A', 3, 'HPA001', 'D06A', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(142, 'NSER', 3, 'HPA001', 'N-Series (700P)', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(143, 'RD85', 3, 'GLUE01', 'RD85', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(144, 'RK70', 3, 'GLUE01', 'RK70', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(145, 'RD65', 3, 'GLUE01', 'RD65', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(146, 'D40L', 3, 'GLUE02', 'D40L', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(147, 'D40D', 3, 'GLUE02', 'D40D', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(148, 'TRC1', 3, 'GLUE02', 'TRC', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(149, 'YMR1', 3, 'GLUE02', 'YMR-01', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(150, 'AMK1', 3, 'GLUE02', 'AMK-01', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(151, 'D37N', 3, 'GLUE02', 'D37N', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(152, 'NSER', 3, 'GLUE03', 'N-Series (700P)', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(153, 'VT01', 3, 'GLUE03', 'VT01', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(154, 'VT02', 3, 'GLUE03', 'VT02', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(155, 'D06A', 3, 'HPWA01', 'D06A', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(156, 'D21N', 3, 'HPWA01', 'D21N', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(157, 'D06A', 3, 'HPWA02', 'D06A', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(158, 'D12L', 3, 'HPWA02', 'D12L', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(159, 'D22D', 3, 'HPWA02', 'D22D', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(160, 'D40L', 3, 'HPWA02', 'D40L', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(161, 'D26A', 3, 'HPWA02', 'D26A', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(162, 'D06A', 3, 'HPWA03', 'D06A', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(163, 'D12L', 3, 'HPWA03', 'D12L', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(164, 'D40L', 3, 'HPWA03', 'D40L', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(165, 'D26A', 3, 'HPWA03', 'D26A', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(166, 'D26A', 3, 'HPWA04', 'D26A', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30'),
(167, 'D26A', 3, 'HPWA05', 'D26A', NULL, 42, 0, '2023-05-09 04:41:30', '2023-05-09 04:41:30');

-- --------------------------------------------------------

--
-- Table structure for table `quality_monitors`
--

CREATE TABLE `quality_monitors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `doc_number` varchar(50) NOT NULL,
  `judgement` int(1) DEFAULT 0,
  `quality_area_id` bigint(20) NOT NULL,
  `quality_process_id` bigint(20) NOT NULL,
  `quality_model_id` bigint(20) NOT NULL,
  `quality_part_id` bigint(20) NOT NULL,
  `quality_cs_qtime` tinyint(4) DEFAULT 0,
  `quality_cs_accuracy` tinyint(4) DEFAULT 0,
  `cs_status` tinyint(1) DEFAULT 0,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quality_monitors`
--

INSERT INTO `quality_monitors` (`id`, `user_id`, `doc_number`, `judgement`, `quality_area_id`, `quality_process_id`, `quality_model_id`, `quality_part_id`, `quality_cs_qtime`, `quality_cs_accuracy`, `cs_status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(16, 27, 'AJI/QA/224182', 2, 10, 6, 3, 2, 1, 0, 3, 27, 29, '2022-07-05 09:09:35', '2022-07-19 16:13:14', NULL),
(17, 29, 'AJI/QA/259273', 1, 10, 6, 3, 2, 1, 0, 3, 29, 29, '2022-07-05 13:50:26', '2022-07-19 16:10:46', NULL),
(18, 29, 'AJI/QA/162700', 2, 10, 6, 3, 2, 1, 0, 3, 29, 29, '2022-07-06 13:58:29', '2022-07-19 16:35:41', NULL),
(19, 29, 'AJI/QA/279345', 0, 10, 6, 3, 2, 1, 0, 2, 29, 29, '2022-07-07 14:55:39', '2022-07-19 15:03:08', NULL),
(20, 29, 'AJI/QA/780411', 0, 10, 6, 3, 2, 1, 0, 1, 29, 29, '2022-07-08 17:25:09', '2022-07-19 13:29:36', NULL),
(21, 29, 'AJI/QA/344070', 0, 10, 6, 3, 2, 1, 0, 0, 29, 0, '2022-07-20 10:04:16', '2022-07-20 10:04:38', NULL),
(22, 29, 'AJI/QA/906242', 0, 10, 6, 3, 2, 1, 0, 1, 29, 29, '2022-07-20 13:17:45', '2022-07-20 13:23:14', NULL),
(23, 29, 'AJI/QA/786723', 0, 10, 6, 3, 6, 1, 0, 0, 29, 0, '2022-07-20 13:36:01', '2022-07-20 13:36:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `quality_mp_produksi`
--

CREATE TABLE `quality_mp_produksi` (
  `id` int(11) NOT NULL,
  `npk` varchar(8) NOT NULL,
  `name` varchar(70) NOT NULL,
  `departemen` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `quality_mp_produksi`
--

INSERT INTO `quality_mp_produksi` (`id`, `npk`, `name`, `departemen`, `created_at`, `updated_at`) VALUES
(1, '0615', 'ACHMAD RAMDANI PRAYOGA', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(2, '0780', 'SYIFA SALSABILA', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(3, '0785', 'FAISAL RIZKY NUGRAHA', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(4, '0786', 'YOFFI SOPIANDI', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(5, '0787', 'AULIA RINDU AHYAR DIPUTRI', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(6, '0788', 'SARYONO CATUR SAPUTRO', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(7, '0790', 'EMIN ANDRIAN', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(8, '0791', 'RESSA RIPALDI HIDAYAT', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(9, '0803', 'SARIP HIDAYAT', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(10, '0804', 'ALVIN HENDRIANTO', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(11, '0805', 'HERMANSYAH', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(12, '0806', 'IBNU AZIS WICAKSONO', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(13, '0816', 'LUTFIAH', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(14, '0817', 'MOHAMAD RIDWAN FAUZI', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(15, '0818', 'YOGI TAHROZI', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(16, '0819', 'ASIM', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(17, '0820', 'GUGUN FIRMANSYAH', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(18, '0821', 'BAGAS HARI WICAKSONO', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(19, '0629', 'AMIR MAHMUD', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(20, '0630', 'HASAN BISRI', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(21, '0632', 'RAFIANAS ZUHROH', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(22, '0633', 'ALDI PRASEPTIO', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(23, '0636', 'DIAN ARIFIANTO', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(24, '0637', 'AKMAL ADI YOGA', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(25, '0639', 'ZIKRI ROZAKI', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(26, '0640', 'SYAFRIZAL', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(27, '0641', 'MUHAMMAD ALI NUR HAKIM', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(28, '0642', 'ADITYA ARDY FERDIAN', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(29, '0643', 'MUHAMMAD FAHMI ALIMMUDIN', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(30, '0645', 'ALLESIO OKTAVALDO CASAMAYOR FIBIANTO', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(31, '0646', 'ENDRIAWAN APRIYANTO', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(32, '0648', 'TORIQ HADAD', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(33, '0673', 'M SUBEHAN SIDIK', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(34, '0709', 'RIAN NURSIDDIQ', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(35, '0737', 'NAZAR TIONO', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(36, '0750', 'SUHENDRA', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(37, '0751', 'NAFRI IRFANGI', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(38, '0753', 'ADE YANA JUNI PRIATNA', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(39, '0754', 'MOHAMMAD ABDUL BASIR', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(40, '0756', 'RATIH PUSPA SARI', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(41, '0758', 'CASMITA WIJAYA', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(42, '0759', 'DEDE KOMAR', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(43, '0760', 'M. ATABIQ', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(44, '0761', 'ADHI PRASETYO', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(45, '0762', 'IKMALLUNUHA', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(46, '0763', 'TRIO ADIYANTO', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(47, '0764', 'ANJAR SUGANDA', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(48, '0765', 'ALI ROMADIYANTO', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(49, '0766', 'HARI ANGGORO', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(50, '0769', 'KASMURI', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(51, '0770', 'ANGGA ADIANSYAH', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(52, '0771', 'MULYADI', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(53, '0772', 'M.ERICK FAHMILANSYAH', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(54, '0775', 'ABDUL FAQIH', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(55, '0776', 'HERY KURNIAWAN', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(56, '0777', 'OKTAFIANA MUKTI', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(57, '0778', 'SUPRIYADI PRASETYA', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(58, '0792', 'ILLA FATMAWATI', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(59, '0616', 'GIGIH PRAYOGA', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(60, '0618', 'MIPTAHUL FARID', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(61, '0619', 'IIK IGHFIRLI', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(62, '0621', 'SYAHRUL RAMADHAN', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(63, '0623', 'SARNAH', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(64, '0624', 'SAHRUL MUAFID', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(65, '0625', 'ROYAN ADITIA ', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(66, '0626', 'GATOT PURNOMO', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(67, '0628', 'ROULINA PURBA', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(68, '0653', 'MOCHAMAD ALIEF FIKRI NUGROHO', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(69, '0654', 'INDRA PUJIANTO', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(70, '0661', 'RIFAI TRI SAFRIYANTO', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(71, '0666', 'BAYU TOSIN PRATAMA', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(72, '0672', 'RIZKY FIRDAUS', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(73, '0681', 'YUNI PUSPITANINGRUM', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(74, '0682', 'DENISA FITRIA', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(75, '0684', 'DANDI MAULANA', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(76, '0686', 'RAYNALDI', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(77, '0687', 'AHMAD YEHIYA AYYASH MUBAAROK', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(78, '0688', 'MUHAMMAD ZHAFAR LUTFIANSYAH', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(79, '0689', 'RAFKI MUHAINDRA KURNIAWAN', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(80, '0690', 'JOUSRAF FRANCOIS ANDREANO', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(81, '0692', 'BUDIANYSAH', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(82, '0693', 'NURUL YASIN', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(83, '0698', 'MUHAMMAD SYAHRI', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(84, '0699', 'RIKI', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(85, '0701', 'RAHMAT AGUS WAHYUDI', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(86, '0704', 'SUMIYATI', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(87, '0705', 'OO SUNARTO', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(88, '0707', 'ENANG BURHANUDIN', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(89, '0708', 'EKA ARIYONO', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(90, '0710', 'SUNANDAR', 'Production', '2023-01-09 04:00:58', '2023-01-09 04:00:58'),
(91, '0711', 'JENI HENDRIATNA SULISTIAN', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(92, '0715', 'AGUSTIAN', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(93, '0716', 'NDOKO DWI SAPUTRO', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(94, '0717', 'AJI SURYA PRATAMA', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(95, '0718', 'ADANG MULYANA', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(96, '0719', 'AFIFUDIN AZIZATULLAH', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(97, '0723', 'ILHAM SURURI', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(98, '0724', 'RAFIF JUN ISWANTORO', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(99, '0725', 'MOHAMMAD MIFTAKHUL ROZA FAZRI', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(100, '0727', 'YUSTI NURHAMIDAH', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(101, '0729', 'SUPRAPTO', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(102, '0730', 'TOMY REZA PERDANA', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(103, '0732', 'NUR HIDAYAT ', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(104, '0733', 'TONY FERDIANSYAH', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(105, '0735', 'RISTYA DAMAYANTI', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(106, '0738', 'M. MIPTAH YUSRON', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(107, '0739', 'RIDHO SULISTYO', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(108, '0740', 'AKHMAD FADILL', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(109, '0744', 'IRFAN APRIYADI', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(110, '0746', 'ZULVA AISYA KHARISKA', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(111, '0747', 'RENANDA REIZIA FAHIRA', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(112, '0755', 'DIKA INDRA WIDIARSA', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(113, '0649', 'CUCU FATIMAH', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(114, '0650', 'IIS SUMIATI', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(115, '0652', 'RISKI IRVAN NUDIN', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(116, '0656', 'MUHAMMAD FAISHAL RAHMAN', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(117, '0657', 'YOGA MUHAMMAD FAUZAN', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(118, '0659', 'RUDIANTO', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(119, '0662', 'PARAMITA RAHAYU NINGTYAS', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(120, '0712', 'RENI AFRIANI', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(121, '0713', 'SITI REHANIA', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(122, '0714', 'MUHAJIRIN', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(123, '0720', 'RIRIN ROHAYATI', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(124, '0015', 'MAKHFUD ANWAR', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(125, '0020', 'ENDANG AMINUDIN', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(126, '0022', 'UMU TOHAROH', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(127, '0027', 'UBAIDILLAH', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(128, '0031', 'MUHAMAD HILMAN', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(129, '0033', 'AFRIANTI', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(130, '0036', 'ISKANDAR', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(131, '0037', 'MARDIANSYAH', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(132, '0041', 'RATNO FEBRIYANTO', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(133, '0055', 'ARI AGUS SETYANTO', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(134, '0069', 'WASITO', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(135, '0085', 'AGIL HENDI SAPUTRO', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(136, '0115', 'NOVI ARI SEPTIAWAN', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(137, '0141', 'SUPARLAN', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(138, '0151', 'ARIES KOMARA', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(139, '0157', 'GUNTUR HERMAWAN', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(140, '0208', 'RIFQI NURYASIN', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(141, '0222', 'AGUS TRIWIBOWO', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(142, '0269', 'DWI CAHYADI', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(143, '0288', 'SUTANTO', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(144, '0301', 'TAOPIK SUBHAN', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(145, '0310', 'DONI DWI APRIYANTO', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(146, '0675', 'HERMA MARDIAN FITRIYANSAH', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59'),
(147, '0807', 'JAKARIA', 'Production', '2023-01-09 04:00:59', '2023-01-09 04:00:59');

-- --------------------------------------------------------

--
-- Table structure for table `quality_ng_categories`
--

CREATE TABLE `quality_ng_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(320) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `updated_by` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quality_ng_categories`
--

INSERT INTO `quality_ng_categories` (`id`, `name`, `description`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Scratch', NULL, 25, 25, '2022-08-09 10:11:26', '2022-08-09 10:12:16'),
(3, 'Black', NULL, 25, 0, '2022-08-09 10:12:22', '2022-08-09 10:12:22');

-- --------------------------------------------------------

--
-- Table structure for table `quality_parts`
--

CREATE TABLE `quality_parts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `part_number` varchar(13) DEFAULT NULL,
  `area_id` varchar(20) NOT NULL DEFAULT '0',
  `process_id` varchar(20) NOT NULL DEFAULT '0',
  `machine_id` varchar(20) NOT NULL DEFAULT '0',
  `model_id` varchar(20) NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL,
  `description` varchar(320) DEFAULT NULL,
  `low` tinyint(4) DEFAULT 0,
  `mid` tinyint(4) DEFAULT 0,
  `high` tinyint(4) DEFAULT 0,
  `left` tinyint(4) DEFAULT 0,
  `center` tinyint(4) DEFAULT 0,
  `right` tinyint(4) DEFAULT 0,
  `photo` varchar(200) DEFAULT NULL,
  `created_by` int(11) NOT NULL DEFAULT 0,
  `updated_by` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quality_parts`
--

INSERT INTO `quality_parts` (`id`, `part_number`, `area_id`, `process_id`, `machine_id`, `model_id`, `name`, `description`, `low`, `mid`, `high`, `left`, `center`, `right`, `photo`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(4, 'testpartnumbe', '0', '1', 'PIMC01', 'D22D', 'test part', 'test part', NULL, 1, NULL, NULL, 1, NULL, '20230509133338WhatsApp Image 2023-05-05 at 9.43.09 AM.jpeg', 41, 0, '2023-05-09 06:33:38', '2023-05-09 06:33:38');

-- --------------------------------------------------------

--
-- Table structure for table `quality_processes`
--

CREATE TABLE `quality_processes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `process_id` varchar(9) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(320) DEFAULT NULL,
  `created_by` int(11) NOT NULL DEFAULT 0,
  `updated_by` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quality_processes`
--

INSERT INTO `quality_processes` (`id`, `process_id`, `name`, `description`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, '1', 'Injection', 'Plastic Injection Line', 42, 0, '2023-05-08 10:27:49', '2023-05-08 10:27:49'),
(2, '2', 'Surface Threatment', 'Surface treatment Line', 42, 0, '2023-05-08 10:27:49', '2023-05-08 10:27:49'),
(3, '3', 'Assy', 'Assembling Line', 42, 0, '2023-05-08 10:27:49', '2023-05-08 10:27:49');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1677, 'AdminLS', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(1678, 'PIC', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(1679, 'Departement Head PIC', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(1680, 'Departement Head EHS', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(1681, 'guest', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(1682, 'Admin', 'web', '2025-07-31 06:52:34', '2025-07-31 06:52:34'),
(1683, 'Board of Directors', 'web', '2025-07-31 06:52:35', '2025-07-31 06:52:35'),
(1684, 'Department Head', 'web', '2025-07-31 06:52:35', '2025-07-31 06:52:35'),
(1685, 'Supervisor', 'web', '2025-07-31 06:52:35', '2025-07-31 06:52:35'),
(1686, 'Staff', 'web', '2025-07-31 06:52:35', '2025-07-31 06:52:35'),
(1687, 'Foreman', 'web', '2025-07-31 06:52:35', '2025-07-31 06:52:35'),
(1688, 'Leader', 'web', '2025-07-31 06:52:35', '2025-07-31 06:52:35'),
(1689, 'Member', 'web', '2025-07-31 06:52:35', '2025-07-31 06:52:35'),
(1690, 'EHS', 'web', '2025-07-31 06:52:35', '2025-07-31 06:52:35'),
(1691, 'User', 'web', '2025-07-31 06:52:35', '2025-07-31 06:52:35'),
(1692, 'HRGA', 'web', '2025-07-31 06:52:35', '2025-07-31 06:52:35'),
(1693, 'Scanner', 'web', '2025-07-31 06:52:35', '2025-07-31 06:52:35'),
(1694, 'Dept Head Approver', 'web', '2025-07-31 06:52:35', '2025-07-31 06:52:35'),
(1695, 'User Approver', 'web', '2025-07-31 06:52:35', '2025-07-31 06:52:35'),
(1696, 'APQP Viewer', 'web', '2025-07-31 06:52:35', '2025-07-31 06:52:35'),
(1697, 'APQP Uploader', 'web', '2025-07-31 06:52:35', '2025-07-31 06:52:35'),
(1698, 'APQP Approver', 'web', '2025-07-31 06:52:35', '2025-07-31 06:52:35'),
(1699, 'Scanner Viewer', 'web', '2025-07-31 06:52:35', '2025-07-31 06:52:35'),
(1700, 'New Model Management User', 'web', '2025-07-31 06:52:35', '2025-07-31 06:52:35'),
(1701, 'IPQC User', 'web', '2025-07-31 06:52:35', '2025-07-31 06:52:35'),
(1702, 'Delivery User', 'web', '2025-07-31 06:52:35', '2025-07-31 06:52:35'),
(1703, 'WorkOrderGA', 'web', '2025-07-31 06:52:35', '2025-07-31 06:52:35'),
(1704, 'WorkOrderGARequestor', 'web', '2025-07-31 06:52:36', '2025-07-31 06:52:36'),
(1705, 'AdminMachine', 'web', '2025-07-31 06:52:36', '2025-07-31 06:52:36'),
(1706, 'AdminMold', 'web', '2025-07-31 06:52:36', '2025-07-31 06:52:36'),
(1707, 'AdminJig', 'web', '2025-07-31 06:52:36', '2025-07-31 06:52:36'),
(1708, 'AdminLearning', 'web', '2025-07-31 06:52:37', '2025-07-31 06:52:37'),
(1709, 'AdminDRC', 'web', '2025-07-31 06:52:37', '2025-07-31 06:52:37'),
(1710, 'MemberDRC', 'web', '2025-07-31 06:52:37', '2025-07-31 06:52:37'),
(1711, 'Foreman Delivery', 'web', '2025-07-31 06:52:37', '2025-07-31 06:52:37'),
(1712, 'Admin Open Issue', 'web', '2025-07-31 06:52:37', '2025-07-31 06:52:37');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(22971, 1682),
(22972, 1682),
(22973, 1682),
(22974, 1682),
(22975, 1682),
(22985, 1682),
(22986, 1682),
(22987, 1682),
(22988, 1682),
(22989, 1682),
(22990, 1682),
(22991, 1682),
(22992, 1682),
(22993, 1682),
(22994, 1682),
(22995, 1682),
(22996, 1682),
(22997, 1682),
(22998, 1682),
(23286, 1697),
(23287, 1697),
(23288, 1697),
(23289, 1697),
(23290, 1697),
(23291, 1697),
(23292, 1697),
(23293, 1697),
(23294, 1697),
(23296, 1697),
(23298, 1696),
(23298, 1697),
(23299, 1697),
(23300, 1697),
(23301, 1696),
(23301, 1697),
(23302, 1697),
(23304, 1697),
(23305, 1697),
(23306, 1697),
(23307, 1697),
(23308, 1697),
(23311, 1697),
(23312, 1697),
(23313, 1697),
(23314, 1697),
(23315, 1697),
(23316, 1696),
(23316, 1697),
(23317, 1696),
(23317, 1697),
(23318, 1696),
(23318, 1697),
(23319, 1696),
(23319, 1697),
(23320, 1697),
(23321, 1696),
(23321, 1697),
(23322, 1696),
(23322, 1697),
(23323, 1696),
(23323, 1697),
(23324, 1696),
(23324, 1697),
(23325, 1696),
(23325, 1697),
(23326, 1696),
(23326, 1697),
(23327, 1696),
(23327, 1697),
(23328, 1696),
(23328, 1697),
(23329, 1696),
(23329, 1697),
(23330, 1697),
(23331, 1696),
(23331, 1697),
(23348, 1697),
(23349, 1697),
(23350, 1697),
(23351, 1697),
(23352, 1697),
(23353, 1697),
(23354, 1697),
(23355, 1696),
(23355, 1697),
(23356, 1696),
(23356, 1697),
(23357, 1697),
(23358, 1697),
(23359, 1696),
(23359, 1697),
(23360, 1697),
(23361, 1696),
(23361, 1697),
(23362, 1697),
(23363, 1697),
(23364, 1697),
(23365, 1697),
(23366, 1697),
(23367, 1696),
(23367, 1697),
(23368, 1696),
(23368, 1697),
(23369, 1696),
(23369, 1697),
(23370, 1696),
(23371, 1696),
(23371, 1697),
(23372, 1696),
(23372, 1697),
(23373, 1696),
(23373, 1697),
(23374, 1696),
(23374, 1697),
(23375, 1696),
(23375, 1697),
(23376, 1696),
(23376, 1697),
(23377, 1696),
(23377, 1697),
(23378, 1697),
(23379, 1697),
(23380, 1696),
(23380, 1697),
(23381, 1696),
(23381, 1697),
(23382, 1696),
(23382, 1697),
(23383, 1697),
(23384, 1697),
(23385, 1696),
(23385, 1697),
(23386, 1697),
(23387, 1697),
(23388, 1696),
(23388, 1697),
(23389, 1696),
(23389, 1697),
(23390, 1696),
(23390, 1697),
(23391, 1697),
(23392, 1696),
(23392, 1697),
(23393, 1697),
(23394, 1697),
(23395, 1696),
(23395, 1697),
(23396, 1696),
(23396, 1697),
(23397, 1696),
(23397, 1697),
(23398, 1697),
(23399, 1696),
(23399, 1697),
(23401, 1697),
(23403, 1697),
(23405, 1697),
(23429, 1703),
(23429, 1704),
(23430, 1703),
(23430, 1704),
(23431, 1703),
(23431, 1704),
(23432, 1703),
(23432, 1704),
(23433, 1703),
(23433, 1704),
(23434, 1703),
(23434, 1704),
(23435, 1703),
(23435, 1704),
(23438, 1703),
(23438, 1704),
(23441, 1703),
(23441, 1704),
(23447, 1703),
(23449, 1703),
(23451, 1704),
(23459, 1704),
(23469, 1704),
(23470, 1706),
(23471, 1706),
(23472, 1706),
(23473, 1706),
(23474, 1706),
(23475, 1706),
(23476, 1706),
(23477, 1706),
(23478, 1707),
(23479, 1707),
(23480, 1707),
(23481, 1707),
(23482, 1707),
(23483, 1707),
(23484, 1707),
(23485, 1707),
(23486, 1704);

-- --------------------------------------------------------

--
-- Table structure for table `scanwi`
--

CREATE TABLE `scanwi` (
  `id` int(11) NOT NULL,
  `part_code` varchar(200) NOT NULL,
  `file` text DEFAULT NULL,
  `file2` text DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `keterangan2` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `scanwi`
--

INSERT INTO `scanwi` (`id`, `part_code`, `file`, `file2`, `keterangan`, `keterangan2`, `created_at`, `updated_at`) VALUES
(11, '11-AT11-A0-TG', '81550-BZ600-00.pdf', '81550-BZ600-00.pdf', 'test ket', 'ket 2', NULL, NULL),
(12, '15-AT12-A1-TG', '81590-BZ100-00.pdf', '81590-BZ100-00.pdf', NULL, NULL, NULL, NULL),
(15, '1920-BZ090-00', '81920-BZ090-00.pdf', '81920-BZ090-00.pdf', NULL, NULL, NULL, NULL),
(16, '1910-BZ090-00', '81910-BZ090-00.pdf', '81910-BZ090-00.pdf', NULL, NULL, NULL, NULL),
(17, '11-AT11-B0-TG', '81550-BZ610-00.pdf', '81550-BZ610-00.pdf', NULL, NULL, NULL, NULL),
(18, '11-AT12-B0-TG', '81560-BZ610-00.pdf', '81560-BZ610-00.pdf', NULL, NULL, NULL, NULL),
(19, '15-AT11-A0-TG', '81580-BZ130-00.pdf', '81580-BZ130-00.pdf', NULL, NULL, NULL, NULL),
(20, '14-AT11-00-TG', '81270-BZ100-00.pdf', '81270-BZ100-00.pdf', NULL, NULL, NULL, NULL),
(21, '13-AT11-00-TG', '81570-BZ290-00.pdf', '81570-BZ290-00.pdf', NULL, NULL, NULL, NULL),
(22, '11-AT12-B0-TG', '81560-BZ610-00.pdf\n', '81560-BZ610-00.pdf\n', NULL, NULL, NULL, NULL),
(23, '15-AT12-A0-TG', '81590-BZ130-00.pdf', '81590-BZ130-00.pdf', NULL, NULL, NULL, NULL),
(24, '15-AT13-00-TG', '81580-BZ150-00.pdf\r\n', '81580-BZ150-00.pdf\n', NULL, NULL, NULL, NULL),
(25, '11-AT12-A0-TG', '81560-BZ600-00.pdf', '81560-BZ600-00.pdf', NULL, NULL, NULL, NULL),
(41, '8806092930018', 'test.pdf', 'PAYMENT PIB AJU - 004584-signed.pdf', NULL, NULL, '2023-01-25 07:05:40', '2023-01-25 07:05:40'),
(42, '8482475808034', 'test.pdf', 'PAYMENT PIB AJU - 004584-signed.pdf', NULL, NULL, '2023-01-25 08:22:43', '2023-01-25 08:22:43'),
(43, '15262727', 'test.pdf', 'PAYMENT PIB AJU - 004584-signed.pdf', NULL, NULL, '2023-01-25 09:09:54', '2023-01-25 09:09:54'),
(44, '1234567890123', '48 Penawaran Harga AGCD LJ (L14 i5 16 512) 28 Feb (2).pdf', 'rizki.pdf', 'test keterangan spis 1', 'test keterangan spps 1', '2023-04-17 07:47:01', '2023-05-19 04:12:52'),
(45, '1234567', 'INV SURGA TINTA OKTOBER 2023.pdf', 'INV SURGA TINTA OKTOBER 2023.pdf', 'update', 'update', '2023-10-13 04:01:34', '2023-10-13 04:01:34');

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `dept_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `npk` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `tgl_masuk` date DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `dept_id` bigint(20) UNSIGNED DEFAULT NULL,
  `position_id` bigint(20) UNSIGNED DEFAULT NULL,
  `detail_dept_id` bigint(20) UNSIGNED DEFAULT NULL,
  `golongan` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `is_logged_in` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `npk`, `username`, `gender`, `tgl_masuk`, `tgl_lahir`, `dept_id`, `position_id`, `detail_dept_id`, `golongan`, `email_verified_at`, `password`, `is_logged_in`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin Portal AJI', 'admin@gmail.com', '0000', 'ajisatu', 'Perempuan', NULL, NULL, 17, 12, 48, '1', NULL, '$2y$10$vRNQGaegzFafCepIkGDuHuMBNFzQduX5FiLK/vpA9gas9uW2LlAeK', 1, NULL, '2024-11-03 12:13:30', '2025-07-31 06:52:37', NULL),
(2, 'Pandu Azaria Ginzel', 'pandu.ginzel@astra-juoku.com', '0797', 'pandu.a', 'Laki-Laki', '2022-03-01', '1987-12-02', 5, 2, 4, '2', NULL, '$2y$10$qoG2DkwPHV1W9FVeS6iaweRmzX6LY8rKdHJ1jhr7c.eEnWbYLffK6', 0, NULL, '2024-11-03 12:13:30', '2025-07-31 06:52:37', NULL),
(3, 'Wahyu Rahayu Irawan', 'iqbalpamungkas397@gmail.com', '0012', 'wahyu.r', 'Laki-Laki', '2012-12-01', '1982-02-26', 1, 2, 1, '2', NULL, '$2y$10$BD0SBmCJiZRIyOnP1VDWjOwBjJrPZQpU//O/dsrKJCxG2o7hMfHPS', 0, NULL, '2024-11-03 12:13:31', '2025-07-31 06:52:37', NULL),
(4, 'Rizky Ayu Puspitasari', 'rizky.puspitasari@astra-juoku.com', '0295', 'rizky.ayu', 'Perempuan', '2017-08-03', '1989-05-02', 3, 3, 2, '3', NULL, '$2y$10$tZb60vjCC3DiqiaTiudlGeWCeABmGMHi0c3Un0TN1Baqbjmx/v5FW', 0, NULL, '2024-11-03 12:13:31', '2025-07-31 06:52:37', NULL),
(5, 'Dini Septiani Permatasari', 'dini.permatasari@astra-juoku.com', '0677', 'dini.s', 'Perempuan', '2021-06-14', '1994-09-06', 1, 5, 1, '5', NULL, '$2y$10$LOXWq7E2FLH0CW63/2hrS.94OM9EYR3nLRdihHugFG3TY1U37xoA6', 0, NULL, '2024-11-03 12:13:31', '2025-07-31 06:52:37', NULL),
(6, 'Ardan', 'ardan@gmail.com', '0066', 'ardan', 'Laki-Laki', '2008-08-01', '1987-04-30', 7, 2, 13, '2', NULL, '$2y$10$GDrD5tx4/5BaZ2anb8sBke4MBd5FyvxR3tolfxHA7NW7f0xA18BWe', 0, NULL, '2024-11-03 12:13:31', '2025-07-31 06:52:37', NULL),
(7, 'Dealiftian Sandy', 'dealiftian.sandy@astra-juoku.com', '0811', 'dealiftian', 'Laki-Laki', '2022-05-17', '1987-10-13', 7, 3, 13, '3', NULL, '$2y$10$KNJ1KUhpBuXpk8BPnz84y.z95BuY3FJVeQUAETtewpcntMzvRsNGq', 0, NULL, '2024-11-03 12:13:31', '2025-07-31 06:52:37', NULL),
(8, 'G.A Zahwania Senkliani Rahmandani', 'zahwania.rahmandani@astra-juoku.com', '0795', 'zahwania', 'Perempuan', '2022-01-06', '2001-03-05', 7, 5, 13, '8', NULL, '$2y$10$6jGQpzI0vQvV1wgNAwHyJ.8iK7AxqHP9QmJcvhSWdwcEiIQy6M6dK', 0, NULL, '2024-11-03 12:13:31', '2025-07-31 06:52:37', NULL),
(9, 'Antony', 'antony@gmail.com', '0049', 'antony', 'Laki-Laki', '2013-07-01', '1984-10-18', 3, 2, 3, '2', NULL, '$2y$10$GPEwtaSUnDir0kyvRX/e2.5dK9k0ALa2Pp/eEo4P3AA5sfyRoxc1m', 0, NULL, '2024-11-03 12:13:31', '2025-07-31 06:52:37', NULL),
(10, 'Ellys Yuniar Sidauruk', 'ellys@gmail.com', '0059', 'ellys.y', 'Perempuan', '2013-11-01', '1984-06-23', 6, 2, 12, '2', NULL, '$2y$10$ourZ.sMEploqwgt06dTx9eIO2.bf2c/gus05zRqqFJvY1bsu5FdF6', 0, NULL, '2024-11-03 12:13:32', '2025-07-31 06:52:38', NULL),
(11, 'Fera Setiawati', 'fera@gmail.com', '0450', 'fera.s', 'Perempuan', '2019-04-15', '1986-09-08', 9, 2, 15, '2', NULL, '$2y$10$oz0erEq2fgbycUHpx/gj5.YBvc9UKJiJefQ5OA8miZfImxsw2Ln2m', 0, NULL, '2024-11-03 12:13:32', '2025-07-31 06:52:38', NULL),
(12, 'Siswanto', 'siswanto@astra-juoku.com', '0305', 'siswanto', 'Laki-Laki', '2002-11-01', '1981-03-09', 4, 2, 20, '2', NULL, '$2y$10$5/n1jh90iH2PJ1/KpwfzWuM0a3X2O7DVXp9jVwTtQmhLE2ac7y.Gq', 0, NULL, '2024-11-03 12:13:44', '2025-07-31 06:52:38', NULL),
(13, 'Agung Budiyanto', 'agung.budiyanto@astra-juoku.com', '0844', 'agung.b', 'Laki-Laki', '2012-04-30', '1973-08-01', 15, 2, 40, '2', NULL, '$2y$10$SAdE9zJw1ZkXuENkui/NgeC7Q/7bHR6mcMoJ8eJTeclmRxOainskC', 0, NULL, '2024-11-03 12:13:45', '2025-07-31 06:52:38', NULL),
(14, 'Wu Chi Chen', 'wu@gmail.com', '0810', 'wu.c', 'Laki-Laki', '2022-05-07', '1979-05-31', 11, 1, 23, '1', NULL, '$2y$10$H5fj9wXlrRZfy8u1kFY7geRenbwX1STL8/ngDCgra.Rd5urjx5qqu', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:38', NULL),
(15, 'Felix Rikantara', 'felix@gmail.com', '0303', 'felix.r', 'Laki-Laki', '1996-07-01', '1972-06-22', 11, 1, 23, '1', NULL, '$2y$10$w6fL75I4fffO.uQtb2xdJuuMtObfm4u65d7nzlARKtSwbpKu8IhuK', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:38', NULL),
(16, 'Cindy Tirta', 'cindy@gmail.com', '0830', 'cindy.t', 'Perempuan', '2021-09-01', '1982-06-17', 11, 1, 23, '1', NULL, '$2y$10$F7Q751iBfeFdCRfzKfFDcOyfuesG5BAZlCvGlhEROCDvjI8SYGWkG', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:38', NULL),
(17, 'Iwan Muhdi', 'iwan@gmail.com', '0013', 'iwan.m', 'Laki-Laki', '2012-12-01', '1972-02-29', 5, 4, 11, '4', NULL, '$2y$10$zwdl/uWg6Zod73CHtc1XIua2C2FYCt7fabZ1ryQqx4xByRxgVCuay', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:39', NULL),
(18, 'Tanya Mutia', 'tanya.mutia@astra-juoku.com', '0051', 'tanya.m', 'Perempuan', '2013-06-17', '1990-09-06', 5, 4, 4, '4', NULL, '$2y$10$vqoGpZ3ubXxQ3Ofkb1q2o.Ij0uvGDcXj3Exv.Nb/t3B6Vxxe.Bwde', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:39', NULL),
(19, 'Septin Kisriani', 'septin.kisriyani@astra-juoku.com', '0179', 'septin.k', 'Perempuan', '2015-10-12', '1993-09-11', 5, 4, 4, '4', NULL, '$2y$10$XidDqIH8V75.LYmG2DhUd.696ABMWcD6CDolGcPdwKj9G8vs7BLzG', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:39', NULL),
(20, 'Miqdad Agil Amarullah', 'miqdad.amarullah@astra-juoku.com', '0801', 'miqdad.a', 'Laki-Laki', '2022-03-01', '1995-07-20', 5, 3, 7, '3', NULL, '$2y$10$55c6JOuBHjZRpejui0RndO18Lc/z6bh6sttd.918Vi8G3QQ58bI12', 0, NULL, '2024-11-03 12:13:49', '2025-08-08 04:16:23', NULL),
(21, 'Dewi Kartika', 'iqbaltesting70@gmail.com', '0828', 'dewi.k', 'Perempuan', '2023-02-06', '1991-03-03', 5, 3, 5, '4', NULL, '$2y$10$kMGxxuJSmNlqSLSVZ593iOhBsHOXfyVKDByGE3P5a8dDaTlKzLwku', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:39', NULL),
(22, 'Ferri Firdaus', 'ferri.firdaus@astra-juoku.com', '0415', 'ferri.f', 'Laki-Laki', '2014-05-08', '1974-12-13', 14, 3, 25, '3', NULL, '$2y$10$iLTE1nLTdM8sQuAU4ncNXOo638NPC3RXC0KciRm6tp9mnu0wPgDGO', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:39', NULL),
(23, 'Ridwan Syarif', 'ridwan.syarif@astra-juoku.com', '0320', 'ridwan.s', 'Laki-Laki', '2018-01-24', '1985-03-30', 3, 4, 2, '4', NULL, '$2y$10$U7c9dfA2QuejKcD9Kep6IOSN9R6VnZbzROJS3z4MgBEHZqaaezcBe', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:39', NULL),
(24, 'Muhammad Andaru Dwi Diva', 'muhammad.diva@astra-juoku.com', '0834', 'andaru.d', 'Laki-Laki', '2023-11-13', '1998-11-07', 3, 4, 3, '4', NULL, '$2y$10$zmXf5OouVjCzIvpROYPyZOtUjf/wgFOCAtS72QCM.heAb6f5PtSxm', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:39', NULL),
(25, 'Surianto Farip', 'surianto.farip@astra-juoku.com', '0812', 'surianto.f', 'Laki-Laki', '2022-05-24', '1995-02-17', 3, 4, 2, '4', NULL, '$2y$10$Ltn3e/wjYplTHtXlqzGMPuNu6MinzX3gmNS6gwAP2mv3CPj/i2VWW', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:39', NULL),
(26, 'Muhammad Ridwan', 'muhamad.ridwan@astra-juoku.com', '0813', 'ridwan.m', 'Laki-Laki', '2022-07-11', '1992-02-27', 3, 3, 3, '4', NULL, '$2y$10$60FO9wtS3aFVttrwMYb3wew/zCHqDQSxUR4If0SIkkM.z38OKAhlu', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:40', NULL),
(27, 'Riky Sutriadi Putra', 'riky.putra@astra-juoku.com', '0347', 'riky.s', 'Laki-Laki', '2018-06-21', '1992-08-19', 9, 3, 15, '3', NULL, '$2y$10$/vryyZmGwANUAVmd8xzU0u9Av5jPJW0/2f9GP7MwTMX8Yezgj08fq', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:40', NULL),
(28, 'Maya Lestari', 'maya.lestari@astra-juoku.com', '0026', 'maya.l', 'Perempuan', '2012-12-01', '1993-02-28', 9, 3, 16, '3', NULL, '$2y$10$CeXOp9MeI0m8XqmzivNnG.37b2u3.wBLhWVvEZvSfN6kVrvze7KRW', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:40', NULL),
(29, 'Jakaria', 'jakaria@astra-juoku.com', '0807', 'jakaria', 'Laki-Laki', '2022-03-08', '1990-03-27', 4, 3, 20, '3', NULL, '$2y$10$KfBlBgHJi/XNQr9o3XFij.fsm.GFw.M/gH0zDvYKsC/m73MVItdGy', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:40', NULL),
(30, 'Imam Fazri Patar Marimbun', 'imam.marimbun@astra-juoku.com', '0808', 'imam.f', 'Laki-Laki', '2022-05-09', '1990-06-03', 4, 3, 27, '3', NULL, '$2y$10$gAKzPOXEV4IS5rpsdc6Nt.KfHlQzCHQcfQviAzqPtCM/OzAOL9w9q', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:40', NULL),
(31, 'Zuraida Rochman', 'zuraida.rochman@astra-juoku.com', '0540', 'zuraida.r', 'Laki-Laki', '1995-02-28', '1974-09-05', 14, 3, 37, '3', NULL, '$2y$10$agP53lqbq.jGC2uXGa/APOh4AHZaQhmSEJun0cHRibbCWi98rGpy.', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:40', NULL),
(32, 'Dicky Kusworo Setiawan', 'dicky.kusworo@astra-juoku.com', '0559', 'dicky.k', 'Laki-Laki', '2013-10-01', '1991-07-31', 14, 3, 28, '3', NULL, '$2y$10$Bf/3t1w4vpG9BAgAPGyXdO3fbvMTjPjDqHXf.J36npvkRSQmHysYq', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:40', NULL),
(33, 'Dwi Cahyadi', 'dwi.cahyadi@astra-juoku.com', '0269', 'dwi.c', 'Laki-Laki', '2017-04-11', '1986-05-03', 15, 3, 39, '3', NULL, '$2y$10$KoSCypSgw8b65ZF2vHRwE.3pXpgzUCeKakNAi06qmC1PJKR6Z4xky', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:40', NULL),
(34, 'Teguh Nur Tolib', 'teguh.tolib@astra-juoku.com', '0299', 'teguh.n', 'Laki-Laki', '2017-09-25', '1989-03-15', 15, 3, 40, '3', NULL, '$2y$10$75kVp0oPnJJuq5u5uXeZa.dBySx4FTS9Uv4L9Kcv7bwvLPBUA9kke', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:40', NULL),
(35, 'Isna Rahmawati', 'isna.rahmawati@astra-juoku.com', '0176', 'isna.r', 'Perempuan', '2015-09-14', '1994-06-13', 7, 5, 13, '5', NULL, '$2y$10$oRW2QDbGwbS2WOPwiG583eZwPBdDEo8WnA8Wwe8bExFaFFwbpLnuG', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:40', NULL),
(36, 'Kartika Pratiwi', 'kartika.pratiwi@astra-juoku.com', '0053', 'kartika.p', 'Perempuan', '2013-07-22', '1988-11-20', 7, 5, 13, '5', NULL, '$2y$10$IBc76O/LXMYLvkZy3yLXsuX5hg3Piw9HtDqBLGvAYx8ycwC23Ov8m', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:40', NULL),
(37, 'Susilo Hendro Nugroho', 'iqbalpamungkas725@gmail.com', '0293', 'susilo.n', 'Laki-Laki', '2017-08-01', '1983-01-25', 5, 5, 5, '5', NULL, '$2y$10$WkXyXbWGM3HalwDv5b.Rxu8r5udkBvqvhyskDZW4480N07/ciLb0u', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:41', NULL),
(38, 'Adela Rosya Ainunnisa', 'adela.ainunnisa@astra-juoku.com', '0831', 'adela.r', 'Perempuan', '2023-07-03', '2000-05-28', 5, 5, 6, '5', NULL, '$2y$10$V/Z/aHRYlBWdWambCvnBpe344ladbBOlvwlAeLR2jnvywBn4oOsXa', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:41', NULL),
(39, 'Andreas Adhi Purnawan', 'andreas.purnawan@astra-juoku.com', '0178', 'andreas.a', 'Laki-Laki', '2015-10-05', '1993-05-10', 3, 5, 3, '5', NULL, '$2y$10$.HREQ2DdxFNFqHcSuZUdae1c89jKHW0/jTpPSbX4yAKPJ0I3ga4B.', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:41', NULL),
(40, 'Yohanes Yerusalem Iskandar', 'yohanes.iskandar@astra-juoku.com', '0276', 'yohanes.y', 'Laki-Laki', '2017-04-25', '1986-11-23', 3, 5, 3, '5', NULL, '$2y$10$3EC1uPmlnhsBHN1vOWkbPOnnGN0jy83ziHCf3PozNf61X1uE2v8l2', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:41', NULL),
(41, 'Lesti Farida', 'lesti.farida@astra-juoku.com', '0337', 'lesti.f', 'Perempuan', '2018-04-23', '1990-05-12', 6, 5, 12, '5', NULL, '$2y$10$cVOvS.Ft7n0k7SVXNsQhmuM2kXn7h7j02pJ7CWPBzTROD4PBo5lnW', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:41', NULL),
(42, 'Ahmad Hudori', 'ahmad.hudori@astra-juoku.com', '0148', 'ahmad.h', 'Laki-Laki', '2015-04-20', '1985-11-17', 1, 5, 1, '5', NULL, '$2y$10$jK0niiwUswQahmLVxwAhwONeMnQ.NkBZsp9KYhF9qI.bYgAqkrjL2', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:41', NULL),
(43, 'Resty Harianti', 'resty.harianti@astra-juoku.com', '0369', 'resty.h', 'Perempuan', '2018-10-02', '1994-12-18', 6, 5, 12, '5', NULL, '$2y$10$.wwDcxjasQr1xGRmahix2.H15JGCE4MCSIuOs46j5hbreUTAXU0Oy', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:41', NULL),
(44, 'Isman Ismail Marzuki', 'isman.ismail@astra-juoku.com', '0798', 'isman.i', 'Laki-Laki', '2022-02-10', '1990-02-06', 14, 5, 37, '5', NULL, '$2y$10$bXANEpjBela.8lHF9THFA.UYBphAAosdJdrZ0PSuWiyu/ZGPM.Q3u', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:41', NULL),
(45, 'Fajar Akbar', 'fajar.akbar@astra-juoku.com', '0824', 'fajar.a', 'Laki-Laki', '2022-11-11', '1995-12-23', 14, 5, 37, '5', NULL, '$2y$10$PxyB9s7xZsUfq5OCrfTsrO2yiBnd1JXDZhdIuezdUi3YGIbc3OWMW', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:41', NULL),
(46, 'Hadiid Putra Lokananta', 'hadiid.lokananta@astra-juoku.com', '0833', 'hadiid.p', 'Laki-Laki', '2023-10-23', '2002-05-01', 14, 5, 25, '5', NULL, '$2y$10$jzSzOUQ3MJNk/FjBV32d0ea6Upd0tsQxKV2vmVt92yPDZL.G5gxtO', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:41', NULL),
(47, 'Mgs Rendy Meifriansyah', 'rendy.meifriansyah@astra-juoku.com', '0065', 'rendy.m', 'Laki-Laki', '2013-12-11', '1982-05-30', 14, 5, 28, '5', NULL, '$2y$10$bO7Ueag8LbS8WU3ZR.1ojuPAfLuGWWfjxwwFd0gWkkckCk4lfv7e6', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:41', NULL),
(48, 'Dedy Sukma Saputra', 'dedi.saputra@astra-juoku.com', '0139', 'dedy.s', 'Laki-Laki', '2015-02-10', '1992-08-11', 14, 5, 25, '5', NULL, '$2y$10$BPYtKJMZts335BXPpEECjeSewgrERflKi7BiYBvVlQH4WhG1gvT7O', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:41', NULL),
(49, 'Achmad Edy Ismera Sesary Ramadhani', 'achmad.ramadhani@astra-juoku.com', '0510', 'achmad.e', 'Laki-Laki', '2019-10-01', '1998-01-02', 14, 5, 25, '5', NULL, '$2y$10$Gu.4xN5I0y9SH4J7DJGI1eJtANjJcqA6mI/3ezlu2H45nJg6cMbV2', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:42', NULL),
(50, 'Maulana Ahve Yunas', 'maulana.ahve@astra-juoku.com', '0742', 'maulana.a', 'Laki-Laki', '2021-10-01', '1993-08-29', 15, 5, 40, '5', NULL, '$2y$10$9ayLUj0XkoRqAPSgWfA3SOAatiW2aJs0BRCXwZfSAvQqmfg13f69q', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:42', NULL),
(51, 'Ghradika Asmara Wrahat Sangka', 'ghradika.sangka@astra-juoku.com', '0836', 'ghradika.a', 'Laki-Laki', '2024-04-17', '2001-09-27', 15, 5, 40, '5', NULL, '$2y$10$KFsocxuvFxnA6zf9jIAV/.3E7/N1QYDybcEPDufoF2JDGh/c0J2nC', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:42', NULL),
(52, 'Fernanda Vebryan Syah', 'fernanda.syah@astra-juoku.com', '0837', 'fernanda.v', 'Laki-Laki', '2024-04-17', '2002-05-01', 15, 5, 39, '5', NULL, '$2y$10$acXnSBokDz0yeAK4Kw1jo.dMzHEzPwsCkwLXYN9SoihF9lXTec5ka', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:42', NULL),
(53, 'Novan Tri Harwiyanto', 'novan.harwiyanto@astra-juoku.com', '0825', 'novan.t', 'Laki-Laki', '2022-12-05', '1992-11-09', 9, 6, 15, '6', NULL, '$2y$10$.kHob0HUILAFailsH9phVuUMoABaguuTKrXYSknocU9eVThmTa31O', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:42', NULL),
(54, 'Makhfud Anwar', 'makhfud.anwar@astra-juoku.com', '0015', 'makhfud.a', 'Laki-Laki', '2012-12-01', '1983-05-12', 4, 6, 20, '6', NULL, '$2y$10$zDk0BbXLZgnCSI/DVewkZOep8gZro8qvbQSR6iOcibtsYQjB7WoBW', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:42', NULL),
(55, 'Endang Aminudin', 'endang.aminudin@astra-juoku.com', '0020', 'endang.a', 'Laki-Laki', '2012-12-01', '1982-02-18', 4, 6, 20, '6', NULL, '$2y$10$qiPOkNM.0a7UD80MABsfSO8LBX1oeyRYE/CCSZdv0gARmFZdL561S', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:42', NULL),
(56, 'Wasito', 'wasito@astra-juoku.com', '0069', 'wasito', 'Laki-Laki', '2014-01-13', '1990-09-22', 4, 6, 27, '6', NULL, '$2y$10$xWMY89doNHlHaT6sff0gd.KPauON.5t10Var4OzPA.6t35/cB2T5e', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:42', NULL),
(57, 'Herma Mardian Fitriyansah', 'herma.fitriyansah@astra-juoku.com', '0675', 'herma.m', 'Laki-Laki', '2021-06-14', '1996-03-25', 4, 6, 27, '6', NULL, '$2y$10$pWbasPCw8iDanJPWKhmc6OqBevQnSmyIXnE1lU.IXQHXGfHoFDKRe', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:42', NULL),
(58, 'Kristino Budiarto', 'kristino.budiarto@astra-juoku.com', '0095', 'kristino.b', 'Laki-Laki', '2014-10-27', '1993-05-30', 14, 6, 28, '6', NULL, '$2y$10$VEqthpEOIecpT54gEBy9wevVT3h8v3NHLQY59/RYRQYdr5zqx3wZa', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:42', NULL),
(59, 'Wawan Edy Santoso', 'wawan.santoso@astra-juoku.com', '0145', 'wawan.e', 'Laki-Laki', '2015-03-02', '1990-07-02', 14, 6, 25, '6', NULL, '$2y$10$8KFAbgn3ewgFaPxOAslDVOx5pbyiWErZibyi/smZSpINmgxqvX.1y', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:42', NULL),
(60, 'Muhammad Rizki Marsudi', 'rizki.marsudi@astra-juoku.com', '0800', 'muhammad.r', 'Laki-Laki', '2022-03-01', '1992-10-01', 15, 6, 39, '6', NULL, '$2y$10$/K3laZeEr1h5.uOUjhi9y.mKeKtieCIPeANWL30gAdvrhR6FLWhky', 1, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:43', NULL),
(61, 'Didit Aditya', 'didit@gmail.com', '0839', 'didit.a', 'Laki-Laki', '2024-05-20', '2000-02-13', 15, 6, 39, '6', NULL, '$2y$10$oP2lpVpPkMkY02bQZCPGWuC6FUDAA0nKMIOaE0hr3delJ386Ix0PK', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:43', NULL),
(62, 'Ubaidillah', 'ubaidillah@gmail.com', '0027', 'ubaidillah', 'Laki-Laki', '2012-12-01', '1988-11-21', 4, 7, 27, '7', NULL, '$2y$10$WstNvfxTaZWyiwdKvi5/TOHCl9A0lV3B2.Krj.7vz7ZWTf12wMLee', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:43', NULL),
(63, 'Iskandar', 'iskandar@astra-juoku.com', '0036', 'iskandar', 'Laki-Laki', '2012-12-01', '1990-10-28', 4, 7, 20, '7', NULL, '$2y$10$0nbFyl9PZpW9hNR7tvDelet4stoQJsBoL9SIwIqI.irTOWHSX1BkS', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:43', NULL),
(64, 'Agil Hendi Saputro', 'agil@gmail.com', '0085', 'agil.h', 'Laki-Laki', '2014-08-15', '1991-02-04', 4, 7, 27, '7', NULL, '$2y$10$pITaTYGPVXw7.enwf19Zcugb3AdswvyZN/rO.bCEZUza2OEXD106O', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:43', NULL),
(65, 'Novi Ari Septiawan', 'novi.ari@astra-juoku.com', '0115', 'novi.a', 'Laki-Laki', '2014-12-04', '1993-09-05', 4, 7, 20, '7', NULL, '$2y$10$6RBXskLv2vGuZITupQkileDRIf.lxlj71wlvOantAQ2OTjlzYE08K', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:43', NULL),
(66, 'Suparlan', 'suparlan@gmail.com', '0141', 'suparlan', 'Laki-Laki', '2015-02-24', '1993-10-21', 4, 7, 27, '7', NULL, '$2y$10$h/pSFMf34lU0LRsaElE2j.HlaNzPkQaeDt7GELlh.DVokjT9ez1rW', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:43', NULL),
(67, 'Aries Komara', 'aries@gmail.com', '0151', 'aries.k', 'Laki-Laki', '2015-04-30', '1996-09-10', 4, 7, 20, '7', NULL, '$2y$10$zmHls0d0vp0A79lEoq.bPuwD4lanX7mr/ulQALPHXAa8dJZrDWTXe', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:43', NULL),
(68, 'Rifqi Nuryasin', 'rifqi@gmail.com', '0208', 'rifqi.n', 'Laki-Laki', '2016-06-16', '1994-08-28', 4, 7, 20, '7', NULL, '$2y$10$QoRzfW5yX51M7Ykl/3vev.926XHUfdLrHWFq34pfWlCVKBwTdhzjG', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:43', NULL),
(69, 'Sutanto', 'sutanto@gmail.com', '0288', 'sutanto', 'Laki-Laki', '2017-05-26', '1995-02-16', 4, 7, 27, '7', NULL, '$2y$10$7Qsf9/SYH7zvLmLQMQ9WXePtjfzb3FPBe2mqc83CXsorSr8nsXUzK', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:43', NULL),
(70, 'Agung Reksa Negara', 'agungreksa@gmail.com', '0034', 'agung.r', 'Laki-Laki', '2012-12-01', '1989-08-01', 15, 7, 39, '7', NULL, '$2y$10$QL7qfm7LiKob60wMqr1wt.OMSikkcGRoGA.86lbcY5.cG6rQiXPoi', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:43', NULL),
(71, 'Fajar Dwiyan Kusuma', 'fajar@gmail.com', '0142', 'fajar.d', 'Perempuan', '2015-02-24', '1992-12-18', 15, 7, 39, '7', NULL, '$2y$10$PAGihvOkwVR9d2U9EaUwouKS/VhvQ0N48yj66vuWXQhzvyxWTrHYO', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:44', NULL),
(72, 'Galih Sudarsono', 'galih.sudarsono@astra-juoku.com', '0029', 'galih.s', 'Laki-Laki', '2012-12-01', '1993-12-12', 9, 8, 16, '8', NULL, '$2y$10$fY0JojPXHb9HrU9blDqyG.m09bjrYga6Ng.rHWF.kUA9kvifmnbly', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:44', NULL),
(73, 'Ade Arif Setiawan', 'ade@gmail.com', '0070', 'ade.a', 'Laki-Laki', '2014-01-13', '1991-05-30', 9, 8, 19, '8', NULL, '$2y$10$4gk.XHJhV0HwdUdBI6xBqOY60aZucprWMjEKGASVnQ9ySN6sEURCu', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:44', NULL),
(74, 'Heri Ismanto', 'heriis@gmail.com', '0256', 'heri.i', 'Laki-Laki', '2017-02-01', '1994-06-16', 9, 8, 17, '8', NULL, '$2y$10$EIH3uRpozHnAeiip7qBAY.AD2TPH/hYa09YXNfd3r0oRLVcHfcHPm', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:44', NULL),
(75, 'Sultonik', 'sultonik@gmail.com', '0627', 'sultonik', 'Laki-Laki', '2021-01-25', '1995-04-13', 9, 8, 19, '8', NULL, '$2y$10$R.VQVE.vsE3H4wgOVftnbOX51xlkiwn9IBBOvncPn572cPsqRb/B2', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:44', NULL),
(76, 'Hadi Utama Putra', 'hadi@gmail.com', '0631', 'hadi.u', 'Laki-Laki', '2021-02-09', '1997-05-02', 9, 8, 17, '8', NULL, '$2y$10$Lh7ERV/e5.LwJB1g4397dOUea1ExGwQIK/hAbf13bI7ftozQbjwWi', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:45', NULL),
(77, 'Aldi Praseptio', 'aldi@gmail.com', '0633', 'aldi.p', 'Laki-Laki', '2021-02-22', '2002-09-22', 9, 8, 17, '8', NULL, '$2y$10$kxr2MK/fXJMp4mhWDvwiZOwCEl9iR09rBJeQ3Qb9dRNfH3wfkCTRm', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:45', NULL),
(78, 'Heri Siswanto', 'herisis@gmail.com', '0694', 'heri.s', 'Laki-Laki', '2021-07-01', '1993-09-18', 9, 8, 19, '8', NULL, '$2y$10$ydf1txCPMiCgpptxKD3XwOnfEcGpi5zJnxzRpmK.cgU5C5EcTmmWq', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:45', NULL),
(79, 'Ibnu Syafa\'at', 'ibnu@gmail.com', '0741', 'ibnu.s', 'Laki-Laki', '2021-09-29', '2003-03-10', 9, 8, 15, '8', NULL, '$2y$10$1fbKvtC/UNElJt5fV7LAVurk.mT0wVoF0F1EhGL1xUnRKIpuzAQwi', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:45', NULL),
(80, 'Muhamad Rohendi', 'muhamad@gmail.com', '0743', 'muhamad.r', 'Laki-Laki', '2021-10-04', '1998-11-04', 9, 8, 17, '8', NULL, '$2y$10$MvXZVKGhGH86zaRLCVMe6.p/e.eWsCMrXF/VxpRC493KDqanu6aBC', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:45', NULL),
(81, 'Risqi Sumarwanto', 'risqi@gmail.com', '0781', 'risqi.s', 'Laki-Laki', '2021-12-28', '1994-04-15', 9, 8, 22, '8', NULL, '$2y$10$oZtpFkikHrAlzVOUyZmvi.sC3Idu4ilqRwyoJuT6ifmosEF4FgG7K', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:45', NULL),
(82, 'Ekham Husen Atamimi', 'ekam@gmail.com', '0783', 'ekam.h', 'Laki-Laki', '2021-12-28', '1997-09-06', 9, 8, 19, '8', NULL, '$2y$10$mWfkNwEmNxJ7saqZ/hFpYO1zuElXzgXJzLgASvG0yc6UVD0MRs0Xi', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:45', NULL),
(83, 'Pranata Alfa Apriansyah', 'pranata@gmail.com', '0784', 'pranata.a', 'Laki-Laki', '2021-12-28', '2002-04-09', 9, 8, 18, '8', NULL, '$2y$10$6CqiLtW8oGvQULGgQ.JUZu2EjZELcLLs0885f9jiOSgGWAnDZRFFS', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:45', NULL),
(84, 'Aulia Rindu Ahyar Diputri', 'aulia@gmail.com', '0787', 'aulia.r', 'Perempuan', '2021-12-28', '1999-09-08', 9, 8, 15, '8', NULL, '$2y$10$zDvuJXE7BTdvyTP50GsYHudJ.3uDGeGcphUkZqjLKEyPZMVl2PTea', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:45', NULL),
(85, 'Ilham Dwi Nur Rohman', 'ilham@gmail.com', '0789', 'ilham.d', 'Laki-Laki', '2021-12-28', '2000-05-06', 9, 8, 18, '8', NULL, '$2y$10$7ZxwnKV4DebnXEhGnLl0cOS3JoLdZslaLy3z8bkiYm7GRGg4mYDFm', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:45', NULL),
(86, 'Nur Rohim', 'nur@gmail.com', '0814', 'nur.r', 'Laki-Laki', '2022-08-01', '1993-05-17', 9, 8, 19, '8', NULL, '$2y$10$XNJWzfDFZJ3u5elXZrMtO.LBatoURVavxSN6w/aGybWmftpvg2MW6', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:45', NULL),
(87, 'Silma Fitria', 'silma@gmail.com', '0822', 'silma.f', 'Perempuan', '2022-10-01', '2000-07-03', 9, 8, 22, '8', NULL, '$2y$10$zNu72xdIESmqP6btps6n5.8VjUlrebBqa4vIkIwVZeRd9BsEnixgC', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:46', NULL),
(88, 'Alji Maulana', 'alji@gmail.com', '0840', 'alji.m', 'Laki-Laki', '2024-07-01', '1998-02-10', 9, 8, 22, '8', NULL, '$2y$10$KZsmr6Wgzq/OMnbWPEaMseUz26RMB5W8obOuyH.cHA0dkpDIP6j7i', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:46', NULL),
(89, 'Yuni Puspitaningrum', 'yuni@gmail.com', '0681', 'yuni.p', 'Perempuan', '2021-06-18', '2001-06-08', 4, 8, 47, '8', NULL, '$2y$10$W6PMd.H5OajFuXskuSc8OOhkEU0u4wVuA5g9sicdLucVWXwKpnGN2', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:46', NULL),
(90, 'Denisa Fitria', 'denisa.fitria@astra-juoku.com', '0682', 'denisa.f', 'Perempuan', '2021-06-18', '2001-12-17', 4, 8, 20, '8', NULL, '$2y$10$17Xtu029L8cMv4w3PAm4Q.0RdjqYTVCToyxS0vEIb0ao13/g4abqO', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:46', NULL),
(91, 'Dandi Maulana', 'dandi@gmail.com', '0684', 'dandi.m', 'Laki-Laki', '2021-06-18', '1997-02-14', 4, 8, 47, '8', NULL, '$2y$10$VCTXgmWRzurdpANjZx.xGeMtcEDo7PBajJS7cTRRHiTnallPCy1o6', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:46', NULL),
(92, 'Raynaldi', 'raynaldi@gmail.com', '0686', 'raynaldi', 'Laki-Laki', '2021-06-18', '1994-05-04', 4, 8, 47, '8', NULL, '$2y$10$2NuBJGG9Qwyb9XptGXiB9ODbtMWe6zK9Y9GLvQvO0s.yUZnA5vGf.', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:46', NULL),
(93, 'Ahmad Yehiya Ayyash Mubaarok', 'ahmadyehiya@gmail.com', '0687', 'ahmad.y', 'Laki-Laki', '2021-06-18', '1999-04-22', 4, 8, 47, '8', NULL, '$2y$10$3CfTIz84yP0FL6mdbrVglOVYZiV.Zt05wspTlklR5biiFEgMdrzgm', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:46', NULL),
(94, 'Muhammad Zhafar Lutfiansyah', 'zhafar@gmail.com', '0688', 'muhamad.z', 'Laki-Laki', '2021-06-24', '2002-07-14', 4, 8, 47, '8', NULL, '$2y$10$pfaQvjZtgL62PXg4KYcZB.88Eny2L5g5MmFrQvNkKi4uzfCjsyPs2', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:46', NULL),
(95, 'Rafki Muhaindra Kurniawan', 'rafki@gmail.com', '0689', 'rafki.m', 'Laki-Laki', '2021-06-24', '2003-08-01', 4, 8, 47, '8', NULL, '$2y$10$nAWo5hcYmHrZwBryin9YXObKzBb7gOoV06/Cx8mYuE9HJc.2asT02', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:46', NULL),
(96, 'Budiansyah', 'budiansyah@gmail.com', '0692', 'budiany.s', 'Laki-Laki', '2021-06-28', '2003-03-25', 4, 8, 47, '8', NULL, '$2y$10$YMPFrDijNEyQvXIif4rYnebFod1c38.9WGAe5kxx2kEEF9y19khVe', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:46', NULL),
(97, 'Nurul Yasin', 'nurul@gmail.com', '0693', 'nurul.y', 'Laki-Laki', '2021-07-01', '1995-08-04', 4, 8, 44, '8', NULL, '$2y$10$I88wWRnU.VhRJ72Q9w2J2es1WPM4kQ1bQx/x8KYAg/tqNgxydjZyy', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:46', NULL),
(98, 'Muhammad Syahri', 'syahri@gmail.com', '0698', 'muhamad.s', 'Laki-Laki', '2021-07-01', '1996-01-19', 4, 8, 47, '8', NULL, '$2y$10$I.zjpouy4HGTzJtC9oIyVOto6zaV1gCHWKDf93O4EivFEmllgqwg.', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:46', NULL),
(99, 'Riki', 'riki@gmail.com', '0699', 'riki', 'Laki-Laki', '2021-07-01', '1994-05-14', 4, 8, 45, '8', NULL, '$2y$10$lG/sb00iwlBDYaUUoyuI/.XwubnMZu0ThXNDp2L6c2xWDS6dAq3.G', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:46', NULL),
(100, 'Rahmat Agus Wahyudi', 'rahmat@gmail.com', '0701', 'rahmat.a', 'Laki-Laki', '2021-07-01', '1993-08-29', 4, 8, 47, '8', NULL, '$2y$10$zb2ut8s1TdEHwWrtvZbK8OXcBNWkG7JIqOFLXpF9v5TCjk.IprfW6', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:47', NULL),
(101, 'Sumiyati', 'sumiyati@gmail.com', '0704', 'sumiyati', 'Perempuan', '2021-07-02', '1997-04-20', 4, 8, 47, '8', NULL, '$2y$10$ASYwRtvjGgvTHkW75ii6JuvinbOHSzfmapD.uo2FHUU8T5RxY9ixO', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:47', NULL),
(102, 'Oo Sunarto', 'sunarto@gmail.com', '0705', 'sunarto', 'Laki-Laki', '2021-07-02', '1996-11-17', 4, 8, 47, '8', NULL, '$2y$10$B85k5iwhtVHgPXZ.CALVDeaFxfydO6U9o9cRhbNammfqd9GNf2fve', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:47', NULL),
(103, 'Agus Triwibowo', 'agustri@gmail.com', '0222', 'agus.t', 'Laki-Laki', '1995-01-03', '1970-08-01', 4, 2, 20, '8', NULL, '$2y$10$RI5fKqJJhPKgvRd6EPEpV.5Li5OBEYLbzkxLB6aWQZK6pxFGWWLt2', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:38', NULL),
(104, 'Umu Toharoh', 'umu@gmail.com', '0022', 'umu.t', 'Perempuan', '2012-12-01', '1989-04-13', 4, 8, 20, '8', NULL, '$2y$10$clj6tvdpNVS/d4atDn793OESA7RYOY0U2swri7gp1eft5jDPsKXya', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:47', NULL),
(105, 'Muhamad Hilman', 'hilman@gmail.com', '0031', 'muhamad.h', 'Laki-Laki', '2012-12-01', '1990-11-03', 4, 8, 47, '8', NULL, '$2y$10$fKwimjpNrdVPjhjcWOCYT.VsKYLgYyTkZoCpHqLu3VLxZ7f6WD04i', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:47', NULL),
(106, 'Afrianti', 'apriyanti@astra-juoku.com', '0033', 'afrianti', 'Perempuan', '2012-12-01', '1992-04-09', 4, 8, 27, '8', NULL, '$2y$10$yRMXCawHj43eRYAQE9gn7.M5Z1i9VRlmX4MVH/85W2fKtxREQ9ZLy', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:47', NULL),
(107, 'Mardiansyah', 'mardi@gmail.com', '0037', 'mardi.f', 'Laki-Laki', '2012-12-01', '1988-05-11', 4, 8, 44, '8', NULL, '$2y$10$Z/PYwb5Y2gJrG0Y7TNG6Xu3r6w0S/RGfhqDLixQYvljk9F7oV9cgi', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:47', NULL),
(108, 'Ratno Febriyanto', 'ratno@gmail.com', '0041', 'ratno.f', 'Laki-Laki', '2013-02-01', '1990-06-21', 4, 8, 47, '8', NULL, '$2y$10$owdsBlh2y.oBkbnqJMUY3e4Ahm8Phf5pHLNKsIy6wZHbtWZGnxggW', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:47', NULL),
(109, 'Ari Agus Setyanto', 'ari@gmail.com', '0055', 'ari.a', 'Laki-Laki', '2013-09-02', '1985-04-28', 4, 8, 45, '8', NULL, '$2y$10$q8nre9aMeZXd0MGDshzgbeeo6aRlcYa08/gB7i4koTJM13x9MF9Ee', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:47', NULL),
(110, 'Taopik Subhan', 'taopik@gmail.com', '0301', 'taopik.s', 'Laki-Laki', '2017-10-19', '1991-03-24', 4, 8, 46, '8', NULL, '$2y$10$/nP7PNCDlNlvUEh6JNh0L.PjAskynpmGIojmHKKr75dmoWMfQ2fIW', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:48', NULL),
(111, 'Gigih Prayoga', 'gigih@gmail.com', '0616', 'gigih.p', 'Laki-Laki', '2021-01-06', '2000-10-25', 4, 8, 45, '8', NULL, '$2y$10$nDD1mzlZyM.KrI/nQgh8du52H4TnK1jm9D31BAM1gP.ek8qcULSPS', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:48', NULL),
(112, 'Miftahul Farid', 'miftahul@gmail.com', '0618', 'miftahul.f', 'Laki-Laki', '2021-01-11', '2001-05-11', 4, 8, 45, '8', NULL, '$2y$10$bUp0v./phzDc15GwGsxDAuH4MObt3rtPP90wf.UtFzfSUxnp88FI6', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:48', NULL),
(113, 'Iik Ighfirli', 'iik@gmail.com', '0619', 'iik.i', 'Laki-Laki', '2021-01-11', '2002-06-09', 4, 8, 45, '8', NULL, '$2y$10$hDvMNW0CNf3OJrr11d5uq.EgmZcZYEJcA1buiypETHoT1IU6plRxG', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:48', NULL),
(114, 'Sarnah', 'sarnah@gmail.com', '0623', 'sarnah', 'Perempuan', '2021-01-18', '1998-07-28', 4, 8, 47, '8', NULL, '$2y$10$BhPzWLl5xdkEk7aV3dLRBONR3vk8HpIS0nlvAaweHYLhKZQf/HgY2', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:48', NULL),
(115, 'Sahrul Muafid', 'sahrul@gmail.com', '0624', 'sahrul.m', 'Laki-Laki', '2021-01-18', '1997-04-17', 4, 8, 47, '8', NULL, '$2y$10$rfwAHbQamr3zepi8hghF0Oa.GSTRQcPkzN7ngQULiqvKvHpKOVFkm', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:48', NULL),
(116, 'Gatot Purnomo', 'gatot@gmail.com', '0626', 'gatot.p', 'Laki-Laki', '2021-01-25', '1996-06-05', 4, 8, 47, '8', NULL, '$2y$10$O7CRvrRLaSnafl.r4te7nuE9fqsv6naOrxVkrNX5FX.opTI5Bud0u', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:48', NULL),
(117, 'Amir Mahmud', 'amir@gmail.com', '0629', 'amir.m', 'Laki-Laki', '2021-02-09', '2002-09-04', 4, 8, 45, '8', NULL, '$2y$10$XtkkNWUSf/B0n4rfiCgNEex27.IyLzAhzpW4oSYUzkZetTIIk.4/i', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:48', NULL),
(118, 'Rafianas Zuhroh', 'rafianas@gmail.com', '0632', 'rafianas.z', 'Laki-Laki', '2021-02-22', '2002-07-25', 4, 8, 47, '8', NULL, '$2y$10$FJfMXQOeWNvsM5bjtjRNlOHm8LJF5KQ6pba.tD6nriFbUB9vkuXmy', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:48', NULL),
(119, 'Dian Arifianto', 'dian@gmail.com', '0636', 'dian.a', 'Laki-Laki', '2021-02-24', '2002-06-24', 4, 8, 45, '8', NULL, '$2y$10$KFR./iMv25EFXiiSd9bdEe8mnsmuLSixApIWALfLDF97VkeccYuly', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:48', NULL),
(120, 'Akmal Adi Yoga', 'akmal@gmail.com', '0637', 'akmal.a', 'Laki-Laki', '2021-02-24', '2001-05-19', 4, 8, 45, '8', NULL, '$2y$10$Mzq/wbFpthBYQaM3Jw8EP.SIO5Rr3bXk9IytH6lYjJ7q2Zz2iTcCm', 0, NULL, '2024-11-03 12:13:49', '2025-07-31 06:52:48', NULL),
(121, 'Aditya Ardy Ferdian', 'aditya@gmail.com', '0642', 'aditya.a', 'Laki-Laki', '2021-03-03', '2002-02-21', 4, 8, 45, '8', NULL, '$2y$10$Bk216suPjbr7gjahaMvgL.m4Byz.ZvNXGZI8YSnCMa5qBhEjAMItC', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:49', NULL),
(122, 'Muhammad Fahmi Alimmudin', 'fahmi@gmail.com', '0643', 'muhamad.f', 'Laki-Laki', '2021-03-03', '2002-05-14', 4, 8, 47, '8', NULL, '$2y$10$ceYVdfUAu0doE3P5UCitX.cviWXXrRZRcPeKXLQckkF7ydLjmS9.e', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:49', NULL),
(123, 'Allesio Oktavaldo Casamayor Fibianto', 'allesio@gmail.com', '0645', 'allesio.o', 'Laki-Laki', '2021-03-10', '2001-10-25', 4, 8, 47, '8', NULL, '$2y$10$IAwyfF5byDJiwpBxWiENvusJVx.AVS0x1f5zeRGFvLoGGT/aTHHbK', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:49', NULL),
(124, 'Toriq Hadad', 'toriq@gmail.com', '0648', 'toriq.h', 'Laki-Laki', '2021-03-15', '2001-10-27', 4, 8, 45, '8', NULL, '$2y$10$hYX2701yE0ZMgVrT24lXROKgqm25a21I8CY5eV1aNYpzYCFzfHKq.', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:49', NULL),
(125, 'Cucu Fatimah', 'cucu@gmail.com', '0649', 'cucu.f', 'Perempuan', '2021-03-15', '1998-08-14', 4, 8, 45, '8', NULL, '$2y$10$Eo0IwGMLhWij/Vw59putUOTQ.7Nm4Q3xKc1X5HPCzYCPgK3kKXllO', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:49', NULL),
(126, 'Iis Sumiati', 'iis@gmail.com', '0650', 'iis.s', 'Perempuan', '2021-03-15', '2000-11-01', 4, 8, 45, '8', NULL, '$2y$10$4LCuVwLguDaAVVTiXwZ2wugan.EyhJEj9XLTrful8r5Q/Buw6n14S', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:49', NULL),
(127, 'Riski Irvan Nudin', 'riski@gmail.com', '0652', 'riski.i', 'Laki-Laki', '2021-03-16', '2002-01-10', 4, 8, 45, '8', NULL, '$2y$10$Zpzi0F1AmbeCgsN5V1hzNebTgV0rr42phzVLWOJhom44Z1kJ4iD1W', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:49', NULL),
(128, 'Mochamad Alief Fikri Nugroho', 'alief@gmail.com', '0653', 'mochamad.a', 'Laki-Laki', '2021-03-16', '2002-11-22', 4, 8, 47, '8', NULL, '$2y$10$owmdPg4Rl5llrU1lcWSH5Op7aKaaj8tB1UJPRI7FqsY490SnHhAVa', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:49', NULL),
(129, 'Muhammad Faishal Rahman', 'faishal@gmail.com', '0656', 'faishal.r', 'Laki-Laki', '2021-03-16', '2002-01-17', 4, 8, 47, '8', NULL, '$2y$10$Wvj6d4121L4PAoffPQmPMOpzVNuTDKVEP6xXx66h9rmTftMBJBPRG', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:49', NULL),
(130, 'Yoga Muhammad Fauzan', 'yoga@gmail.com', '0657', 'yoga.m', 'Laki-Laki', '2021-03-16', '2002-02-25', 4, 8, 45, '8', NULL, '$2y$10$GKetzYJzqsl12MxQJzlUMeKF3kAYFRDIE5j4MXw.0cCAr1/tjaZ4q', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:49', NULL),
(131, 'Rudianto', 'rudianto@gmail.com', '0659', 'rudianto', 'Laki-Laki', '2021-03-16', '2002-02-03', 4, 8, 44, '8', NULL, '$2y$10$RxF88pfUD8rnbvmjT9swnuruOGn5yA8pOV6UufZUpzCIIjYrBO1sS', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:49', NULL),
(132, 'Rifai Tri Safriyanto', 'rifai@gmail.com', '0661', 'rifai.t', 'Laki-Laki', '2021-03-16', '2002-05-09', 4, 8, 47, '8', NULL, '$2y$10$hxaltnDnxspNkyHbeGLXc.q9I0DBNCdhXc8LsYloMLh3CKzgE7DfC', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:50', NULL),
(133, 'Paramita Rahayu Ningtyas', 'paramita@gmail.com', '0662', 'paramita.r', 'Perempuan', '2021-03-23', '2002-04-01', 4, 8, 47, '8', NULL, '$2y$10$AWNUUcbbWXHgE15DaYpnNeKLPcbg8qlgmTsQ7AM30JUKfpz/8cg6y', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:50', NULL),
(134, 'Bayu Tosin Pratama', 'bayu@gmail.com', '0666', 'bayu.t', 'Laki-Laki', '2021-04-22', '2001-01-18', 4, 8, 47, '8', NULL, '$2y$10$QJrgnoTR2L9.dTkqS.rUDu20w1zmZK5DcZzB5i55mV4RBB3LEW2ke', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:50', NULL),
(135, 'Rizky Firdaus', 'rizkyfirdaus@gmail.com', '0672', 'rizky.f', 'Laki-Laki', '2021-06-10', '2002-09-02', 9, 8, 22, '8', NULL, '$2y$10$H3qbbkfFgzoZet4rUkqwzO0qPCJvipJfPUWb7OKiv25/6.7GTVjkK', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:50', NULL),
(136, 'M Subehan Sidik', 'subehan@gmail.com', '0673', 'm.subehan', 'Laki-Laki', '2021-06-11', '2003-02-04', 4, 8, 47, '8', NULL, '$2y$10$FE2IFevYrPZkuzJF8xPI/.k2FBd3eya18O.2Cb0OHmyHrk/Wr7iw2', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:50', NULL),
(137, 'Enang Burhanudin', 'enang@gmail.com', '0707', 'enang.b', 'Laki-Laki', '2021-07-02', '1993-07-26', 4, 8, 45, '8', NULL, '$2y$10$.BPl2c4h6Qwg7M7JB2B8PONpkFJPdyfiNQIaL3mqXdlJUJc29xWtC', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:50', NULL),
(138, 'Eka Ariyono', 'eka@gmail.com', '0708', 'eka.a', 'Laki-Laki', '2021-07-02', '1995-01-18', 4, 8, 47, '8', NULL, '$2y$10$xLPG3Nm3QZIdc9vFxaKww.brqfmPplcfQiuAYgx8SOWSQrKMZx23S', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:50', NULL),
(139, 'Rian Nursiddiq', 'rian@gmail.com', '0709', 'rian.n', 'Laki-Laki', '2021-06-28', '1993-11-18', 4, 8, 46, '8', NULL, '$2y$10$IURdGGmqAaG/gVcwQEVTFueXNnOHuYQnXyk2zqhCtsNTUsbJ4fhTO', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:50', NULL),
(140, 'Sunandar', 'sunandar@gmail.com', '0710', 'sunandar', 'Laki-Laki', '2021-06-28', '1994-05-19', 4, 8, 45, '8', NULL, '$2y$10$kwqBcgS3vjzLhfHxmaqBdesQOGyW8iuaK1jHE82GN7.XROFcG5f9W', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:50', NULL),
(141, 'Jeni Hendriatna Sulistian', 'jeni@gmail.com', '0711', 'jeni.h', 'Laki-Laki', '2021-06-28', '1992-01-27', 4, 8, 46, '8', NULL, '$2y$10$WA6veFWiJUgAWqezwS6MIuNuvlzFEj5INpC5FOSNgjWuZt2oyqORq', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:50', NULL),
(142, 'Reni Afriani', 'reni@gmail.com', '0712', 'reni.a', 'Perempuan', '2021-06-28', '1995-04-14', 4, 8, 47, '8', NULL, '$2y$10$G9p/hLuLHUchK4x7FAEEcuvniixEggs0Uonou9E2GzNAuSYKkn8ny', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:50', NULL),
(143, 'Siti Rehania', 'siti@gmail.com', '0713', 'siti.r', 'Perempuan', '2021-06-28', '1997-11-20', 4, 8, 47, '8', NULL, '$2y$10$xiPTXyYD6QYuJVjlMbjTDe6VaCwU1njGNmFm1dNMjSb5ta/tsFzqe', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:50', NULL),
(144, 'Agustian', 'agustian@gmail.com', '0715', 'agustian', 'Laki-Laki', '2021-06-28', '1996-08-11', 4, 8, 47, '8', NULL, '$2y$10$.EDL4CA1UxvBqLLaw5f.3O8oAKHtDdOemqGhng02SxjCztF4d2qy6', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:51', NULL),
(145, 'Ndoko Dwi Saputro', 'ndoko@gmail.com', '0716', 'ndoko.d', 'Laki-Laki', '2021-06-28', '1991-02-08', 4, 8, 44, '8', NULL, '$2y$10$Bapq89LpPKSz07rDYr0hPOgvisWtcELAzd8VRZCEn.H3xsJTWlI0a', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:51', NULL),
(146, 'Aji Surya Pratama', 'aji@gmail.com', '0717', 'aji.s', 'Laki-Laki', '2021-06-28', '1996-12-12', 4, 8, 46, '8', NULL, '$2y$10$DVN3cEDpkZ6ds.EZxrf8J.EPjOdcBsgqAmplLfpkBGQ5jJaWw1Z/G', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:51', NULL),
(147, 'Adang Mulyana', 'adang@gmail.com', '0718', 'adang.m', 'Laki-Laki', '2021-06-28', '1993-11-21', 4, 8, 45, '8', NULL, '$2y$10$3fTcBRPevPUbm7bPme7eZOwlNJ3R4MHsNil5bzcyAl1svNAyNyBaW', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:51', NULL),
(148, 'Afifudin Azizatullah', 'afifudin@gmail.com', '0719', 'afifudin.a', 'Laki-Laki', '2021-07-05', '1994-12-23', 4, 8, 47, '8', NULL, '$2y$10$A39Yq1MnuiIWUhKErrbjm.Iqke/VgwsXTqaAhT7TYjhxgVtFZUbUK', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:51', NULL),
(149, 'Rafif Jun Iswantoro', 'rafif@gmail.com', '0724', 'rafif.j', 'Laki-Laki', '2021-07-06', '2002-06-19', 4, 8, 47, '8', NULL, '$2y$10$FkCTcUzbHxgjLgZNRI74wOyByCuMluZ522hC4YmvTKUH019qexnb2', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:51', NULL),
(150, 'Yusti Nurhamidah', 'yusti@gmail.com', '0727', 'yusti.n', 'Perempuan', '2021-07-06', '2002-01-02', 4, 8, 47, '8', NULL, '$2y$10$RLW7HjA5huIjgtkHV0Y71eVYGzy5LniFvJs3pXCESKhECRPBvMd3K', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:51', NULL),
(151, 'Suprapto', 'suprapto@gmail.com', '0728', 'suprapto', 'Laki-Laki', '2021-07-06', '2002-02-21', 4, 8, 47, '8', NULL, '$2y$10$YNvFYJ552hJ89ixRYzHDSOYTFNIalxesSJwylyDRrjJjnNeU/9qF2', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:51', NULL),
(152, 'Tomy Reza Perdana', 'tomy@gmail.com', '0730', 'tomy.r', 'Laki-Laki', '2021-07-06', '2001-03-22', 4, 8, 47, '8', NULL, '$2y$10$YOQTLRsdXEjAvnecHS7JQ.HW4QvK5LuY.Cwirrck3N9.7bowtuI22', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:51', NULL),
(153, 'Nur Hidayat', 'nurhidayat@gmail.com', '0732', 'nur.h', 'Laki-Laki', '2021-09-20', '2003-04-22', 4, 8, 47, '8', NULL, '$2y$10$9ZmCAY0iBvIXJOT/Rhx9fe7gr1k2uz9iF21GjmINqWvmRcDCGWT/6', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:51', NULL),
(154, 'Tony Ferdiansyah', 'tony@gmail.com', '0733', 'tony.f', 'Laki-Laki', '2021-09-20', '2003-05-18', 4, 8, 47, '8', NULL, '$2y$10$ScldCosAFEY5zXKjoaVd8eEApKqs6Moc3prsbQNNVYU.ecd6dYT4K', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:51', NULL),
(155, 'Ristya Damayanti', 'ristya@gmail.com', '0735', 'ristya.d', 'Perempuan', '2021-09-20', '2003-02-24', 4, 8, 47, '8', NULL, '$2y$10$w4kgzpzxm/lM1eqQ6tPhqemqn.y2rwQdTYeHuJyZcfSXxTQheKuqG', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:51', NULL),
(156, 'Nazar Tiono', 'nazar@gmail.com', '0737', 'nazar.t', 'Laki-Laki', '2021-09-27', '1995-07-12', 4, 8, 46, '8', NULL, '$2y$10$hIS5xpevOoDCEnCHOM7CaOCAUH9zOZl8J7RgajkDquFrNhXNsFNWi', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:51', NULL),
(157, 'M. Miftah Yusron', 'miftah@gmail.com', '0738', 'miftah.y', 'Laki-Laki', '2021-09-29', '2003-01-25', 4, 8, 44, '8', NULL, '$2y$10$MINV1So/xoEaJOP4YZaxGuHkYhX6kUJeBIpUQ3CXNDrRXij8alXRm', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:52', NULL),
(158, 'Ridho Sulistyo', 'ridho@gmail.com', '0739', 'ridho.s', 'Laki-Laki', '2021-09-29', '2003-03-27', 4, 8, 44, NULL, NULL, '$2y$10$2KMLBzN.1e/38GWsV2Aaz.2G8TbTZVkBXYtgOgZJj6fK5mpPAIBiC', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:52', NULL),
(159, 'Irfan Apriyadi', 'irfan@gmail.com', '0744', 'irfan.a', 'Laki-Laki', '2021-10-13', '2002-04-06', 4, 8, 44, NULL, NULL, '$2y$10$kPT8vZsJRkDrtd4NyesLkul8QFJXs63Q0mR2QNpNt/wu/K7cGmmUK', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:52', NULL),
(160, 'Zulva Aisya Khariska', 'zulva@gmail.com', '0746', 'zulva.a', 'Perempuan', '2021-10-13', '2002-11-23', 4, 8, 47, NULL, NULL, '$2y$10$hL65P.0BfvifVoL/YazuHuvPjDoe0z59n8fjljF4OYyTr5CFMUPHC', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:52', NULL),
(161, 'Renanda Reizia Fahira', 'renanda@gmail.com', '0747', 'renanda.r', 'Perempuan', '2021-10-13', '2002-12-13', 4, 8, 47, NULL, NULL, '$2y$10$6a320ksTmLzL8MKzXIIeaeoEEjKBah.l2KoKiM.dVRFOd0tzug9gW', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:52', NULL),
(162, 'Suhendra', 'suhendra@gmail.com', '0750', 'suhendra', 'Laki-Laki', '2021-10-26', '1997-08-15', 4, 8, 44, NULL, NULL, '$2y$10$rtCf77kdIro/BDn5f8ONF.MuKvasdrcd9vFnp3Fmklz04.5O4ulzG', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:52', NULL),
(163, 'Nafri Irfangi', 'nafri@gmail.com', '0751', 'nafri.i', 'Laki-Laki', '2021-10-27', '1995-12-15', 4, 8, 46, NULL, NULL, '$2y$10$bh19QK4TA7DjVd1pKSXh/uCqzZVucgiMP56aDRt80kHxkWdGscKR.', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:52', NULL),
(164, 'Ade Yana Juni Priatna', 'adeyana@gmail.com', '0753', 'ade.y', 'Laki-Laki', '2021-11-01', '1995-06-04', 4, 8, 47, NULL, NULL, '$2y$10$au1.kMUk4EoWQnOAJQAqweLjSe6sYBsHxmHNHbEO/krinZ6/8dU2i', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:52', NULL),
(165, 'Mohammad Abdul Basir', 'abdul@gmail.com', '0754', 'mohammad.a', 'Laki-Laki', '2021-11-01', '1994-01-10', 4, 8, 47, NULL, NULL, '$2y$10$eMcGsVNTFjm1Jixa9pKfzOyjtEFwdB/675YtM4bag.L5kafiOMcwW', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:52', NULL),
(166, 'Dika Indra Widiarsa', 'dika@gmail.com', '0755', 'dika.i', 'Laki-Laki', '2021-11-01', '1994-02-21', 4, 8, 47, NULL, NULL, '$2y$10$zfU0wTjveQJodO8NbComZOHT0gr/4txmp9yf7UqHG4Dso.77461Qy', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:52', NULL),
(167, 'Ratih Puspa Sari', 'ratih@gmail.com', '0756', 'ratih.p', 'Perempuan', '2021-11-05', '2003-02-27', 4, 8, 47, NULL, NULL, '$2y$10$YNexvyZXXXf.VOs6retTyO9nxnXOM5mEP7AQx9oIDFiNt9tiUYlsi', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:52', NULL),
(168, 'Casimita Wijaya', 'casmita@gmail.com', '0758', 'casmita.w', 'Laki-Laki', '2021-11-09', '1998-07-28', 4, 8, 47, NULL, NULL, '$2y$10$6wJHEwlKUjjbuOIcCCgcOOQhQw8hjghNgLlujXsFVSye8y9VXbZnm', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:52', NULL),
(169, 'Dede Komar', 'dede@gmail.com', '0759', 'dede.k', 'Laki-Laki', '2021-11-09', '1998-01-02', 4, 8, 47, NULL, NULL, '$2y$10$OjzcD14w3ah0WlyF1fbPXeGYiJEx3clfUXwXUWsz631tGmLDEQhQ.', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:52', NULL),
(170, 'M. Atabiq', 'atabiq@gmail.com', '0760', 'atabiq', 'Laki-Laki', '2021-11-11', '1998-03-23', 4, 8, 47, NULL, NULL, '$2y$10$z/K550e16ulmoyoCDWuiiO6W5IfPJLpsKLk.ybGcq1.2XA9KKVmTy', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:53', NULL),
(171, 'Adhi Prasetyo', 'adhi@gmail.com', '0761', 'adhi.p', 'Laki-Laki', '2021-11-12', '1995-11-27', 4, 8, 45, NULL, NULL, '$2y$10$tzzPlGpZHFhKzzhfcHAJaOtpTwukPVx84Bu1FrCzQQlZ0hLWw7QRG', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:53', NULL),
(172, 'Ikmallunuha', 'ikmallunuha@gmail.com', '0762', 'ikmallunuha', 'Laki-Laki', '2021-11-17', '2003-05-17', 4, 8, 44, NULL, NULL, '$2y$10$cpDq8ZKPLtXgFEXpWan8c.5tIiJf1vvJRdvT.YcK/QmawXhW7f6Tu', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:53', NULL),
(173, 'Trio Adiyanto', 'trio@gmail.com', '0763', 'trio.a', 'Laki-Laki', '2021-11-17', '2003-08-07', 4, 8, 47, NULL, NULL, '$2y$10$67A4X0eZ9SeNm9VLAGnqr.Q7yqjd8hiO4j.x3yknFsj1Zh66Bhdfe', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:53', NULL),
(174, 'Anjar Suganda', 'anjar@gmail.com', '0764', 'anjar.s', 'Laki-Laki', '2021-11-17', '1996-03-08', 4, 8, 47, NULL, NULL, '$2y$10$ryv76gGxLEaFY2UBhspjTu7pbL1/H/rIezXEhIamenOr2IvqYPPnS', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:53', NULL),
(175, 'Ali Romadiyanto', 'ali@gmail.com', '0765', 'ali.r', 'Laki-Laki', '2021-11-22', '1997-01-10', 4, 8, 45, NULL, NULL, '$2y$10$6fh/IYDk5n9iyuEFFNXtS.pcxk5naGxsbAPbnSz03O4CrginIBOei', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:53', NULL),
(176, 'Hari Anggoro', 'hari@gmail.com', '0766', 'hari.a', 'Laki-Laki', '2021-11-22', '1998-08-19', 4, 8, 47, NULL, NULL, '$2y$10$v.Hn02DK6VMf45KltYFuduKOGp2lipnnF.46OYCTNFr3.9UP4ZuZm', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:53', NULL),
(177, 'Kasmuri', 'kasmuri@gmail.com', '0769', 'kasmuri', 'Laki-Laki', '2021-11-23', '1996-08-11', 4, 8, 47, NULL, NULL, '$2y$10$.wK7fDWYONFgtK7Ggqv4cewQdSl0kcxQAZVqNItbgNfI0ne3IVyv.', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:53', NULL),
(178, 'Angga Adiansyah', 'angga@gmail.com', '0770', 'angga.a', 'Laki-Laki', '2021-11-26', '2003-04-15', 4, 8, 47, NULL, NULL, '$2y$10$IB9LyohihabRe1jRFgFNw./54sgMuslXqsigNwiD8G3trjFHLvx/.', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:53', NULL),
(179, 'Mulyadi', 'mulyadi@gmail.com', '0771', 'mulyadi', 'Laki-Laki', '2021-11-26', '2003-07-02', 4, 8, 46, NULL, NULL, '$2y$10$5lzlIgsdsBta9mF/1bZ5IuUfTJgRO0yXqfbBGtD.skf9PWa0NEiUa', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:53', NULL),
(180, 'M. Erick Fahmilansyah', 'erick@gmail.com', '0772', 'erick.f', 'Laki-Laki', '2021-11-26', '2003-06-02', 4, 8, 47, NULL, NULL, '$2y$10$rVaVyI.Ry6QPixUyHz2OKO6XZd3065/avhjWpR9f5TVo0TM9oWH1O', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:53', NULL),
(181, 'Abdul Faqih', 'abdulfaqih@gmail.com', '0775', 'abdul.f', 'Laki-Laki', '2021-11-29', '1999-03-09', 4, 8, 45, NULL, NULL, '$2y$10$u..hEFC6tRRhe6WfYVYQauu5e/DoHiKh30Zqs89Vm0GBb5sArmDRO', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:53', NULL),
(182, 'Hery Kurniawan', 'hery@gmail.com', '0776', 'hery.k', 'Laki-Laki', '2021-11-30', '1996-08-21', 4, 8, 46, NULL, NULL, '$2y$10$.j4CrgC4M2pA9qCi3L7qleIWna5./Q2ntzCo51v9qlMaIlXK0saH.', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:54', NULL),
(183, 'Oktafiana Mukti', 'oktafiana@gmail.com', '0777', 'oktafiana.m', 'Perempuan', '2021-12-06', '2003-10-03', 4, 8, 44, NULL, NULL, '$2y$10$R.Dc/Y3RalQ20G9FSwZM2.c588elpjfhziCpOjhPsSivNoNQDXSGq', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:54', NULL),
(184, 'Supriyadi Prasetya', 'supri@gmail.com', '0778', 'supri.p', 'Laki-Laki', '2021-12-08', '1997-03-04', 4, 8, 47, NULL, NULL, '$2y$10$z/9L3t3V1FMoKhXXoa2pfOwyTJOquXeM2VqSgNdPXPyKqlIKWQ1vK', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:54', NULL),
(185, 'Syifa Salsabila', 'syifa@gmail.com', '0780', 'syifa.s', 'Perempuan', '2021-12-24', '2001-06-25', 4, 8, 47, NULL, NULL, '$2y$10$s5/J50xJkIDmx24yO7XPkeYRgca.3OLEL81ziktSlRS48kr4QtT7C', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:54', NULL),
(186, 'Faisal Rizky Nugraha', 'faisal@gmail.com', '0785', 'faisal.r', 'Laki-Laki', '2021-12-28', '2002-04-26', 4, 8, 47, NULL, NULL, '$2y$10$hwrAiUWoeeIrFQJCs5al9.umZ6lX3FmHzFQzIysbhfnnP0YGLXxyG', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:54', NULL),
(187, 'Yoffi Sopiandi', 'yoffi@gmail.com', '0786', 'yoffi.s', 'Laki-Laki', '2021-12-28', '1995-10-11', 4, 8, 47, NULL, NULL, '$2y$10$UjQ1v09essag8aTf2zoheO/SdjAfoRXQcGbfM.ocru3pWJxMt7UCe', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:54', NULL),
(188, 'Saryono Catur Saputro', 'saryono@gmail.com', '0788', 'saryono.c', 'Laki-Laki', '2021-12-28', '1998-10-03', 4, 8, 47, NULL, NULL, '$2y$10$EHSXiBBwl6Zuja7fbzlw/OeS/rGC.FKkQ77Fmq8AvZAZwcqifL8tu', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:54', NULL),
(189, 'Emin Andrian', 'emin@gmail.com', '0790', 'emin.a', 'Laki-Laki', '2021-12-28', '1997-05-08', 4, 8, 47, NULL, NULL, '$2y$10$qpH93Kimfey6orcowEC3B.53W6K9cxQj8WAbupPeWlT0Tf4XV0Cs2', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:54', NULL),
(190, 'Ressa Ripaldi Hidayat', 'ressa@gmail.com', '0791', 'ressa.r', 'Laki-Laki', '2021-12-28', '1994-04-16', 4, 8, 47, NULL, NULL, '$2y$10$567Zp0qOiHigV5qPTvdMbui2u3HiReJnoAYVDFh2aTEB6aQAsClzG', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:54', NULL),
(191, 'Illa Fatmawati', 'illa@gmail.com', '0792', 'illa.f', 'Perempuan', '2021-12-29', '2000-06-26', 4, 8, 47, NULL, NULL, '$2y$10$R/u2gi3B.kkYGL.3hLsCOe7vq3MHC9pdJSI3k2CF8gwaOeejVmk.C', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:54', NULL),
(192, 'Hermansyah', 'herman@gmail.com', '0805', 'hermansyah', 'Laki-Laki', '2022-03-07', '2001-07-29', 4, 8, 47, NULL, NULL, '$2y$10$vEBrEo4XFuzNiyQxCa3kx.gVtGzFHG6.Myln6S78LynQRnGuLLf0u', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:54', NULL),
(193, 'Ibnu Azis Wicaksono', 'ibnuazis@gmail.com', '0806', 'ibnu.a', 'Laki-Laki', '2022-03-07', '2003-02-11', 4, 8, 47, NULL, NULL, '$2y$10$udtcPEVFmhGL7U6cGMC8xOJBtWPEd2OS14p59p7L7NBp9Ur85yoBG', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:54', NULL),
(194, 'Lutfiah', 'lutfiah@gmail.com', '0816', 'lutfiah', 'Perempuan', '2022-09-01', '2003-05-05', 4, 8, 47, NULL, NULL, '$2y$10$21MgnQ1Uw7.M3P18Et8S9e5bDVn2R7M7P8kHUNBHaa35N1yZexdYG', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:55', NULL),
(195, 'Mohamad Ridwan Fauzi', 'ridwanfauzi@gmail.com', '0817', 'mohamad.r', 'Laki-Laki', '2022-09-01', '1998-03-17', 4, 8, 47, NULL, NULL, '$2y$10$TO9Xz7MmFXSjTnGXKsTwieeDbLvH733T9SH43758//bdAPEPhEJXu', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:55', NULL);
INSERT INTO `users` (`id`, `name`, `email`, `npk`, `username`, `gender`, `tgl_masuk`, `tgl_lahir`, `dept_id`, `position_id`, `detail_dept_id`, `golongan`, `email_verified_at`, `password`, `is_logged_in`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(196, 'Yogi Tahrozi', 'yogi@gmail.com', '0818', 'yogi.t', 'Laki-Laki', '2022-09-01', '1998-09-23', 4, 8, 47, NULL, NULL, '$2y$10$QepIkSyPxWQW7uvuPOGqZ.hKFVxSmq5BxQ9RdXpQOhV0Adlu61EwG', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:55', NULL),
(197, 'Asim', 'asim@gmail.com', '0819', 'asim', 'Laki-Laki', '2022-09-01', '1995-05-30', 4, 8, 47, NULL, NULL, '$2y$10$qo7BBOieGA.ShMP4oAi2Zei6LoTT.DNbv3Ie6uX2hSHzwdfYFqnyK', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:55', NULL),
(198, 'Gugun Firmansyah', 'gugun@gmail.com', '0820', 'gugun.f', 'Laki-Laki', '2022-09-01', '1999-07-25', 4, 8, 44, NULL, NULL, '$2y$10$SOwLmmYls6sccFbU/ZDeCu87CE432eI19EIYGHCQ1/MXYRSx8GAwq', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:55', NULL),
(199, 'Bagas Hari Wicaksono', 'bagas@gmail.com', '0821', 'bagas.h', 'Laki-Laki', '2022-09-01', '2003-03-20', 4, 8, 44, NULL, NULL, '$2y$10$02iHG.yumyBXumV5yw53jOWWPThZFkMzVL3HWhrUQIoPc/yNLK1zO', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:55', NULL),
(200, 'Reza Indriyanto', 'rezaindriyanto@gmail.com', '0832', 'reza.i', 'Laki-Laki', '2023-09-01', '2001-09-27', 4, 8, 44, NULL, NULL, '$2y$10$Q7tRUSWf9zys3yKTV6.8zuUV59skySYyGaV2Ve0B9WTHYiTB/n8wy', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:55', NULL),
(201, 'Widya Sukma Utami', 'widya@gmail.com', '0841', 'widya.s', 'Perempuan', '2024-07-01', '2000-06-10', 4, 8, 46, NULL, NULL, '$2y$10$p.Dlqt/y3qy88ueg92lNseeiELLMz3xDO6ByZbVE8swIBrcf3OK8S', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:55', NULL),
(202, 'Mohammad Miftakhul Roza Fazri', 'miftakhul@gmail.com', '0725', 'Miftakhul.r', 'Laki-Laki', '2021-07-06', '2002-09-04', 4, 8, 47, NULL, NULL, '$2y$10$e4QNDARKPVi6gnr7nDf1w.3OJEDXO0lbTAFZt9ELFWTnbgG1ou.Ui', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:55', NULL),
(203, 'Doni Dwi Apriyanto', 'doni@gmail.com', '0310', 'doni.d', 'Laki-Laki', '2017-11-28', '1993-04-11', 14, 8, 28, NULL, NULL, '$2y$10$ck/p2QSrBcqYbhxNVTpqJOxM8qg8ZYSPdWtu6M/thF5DOYwsjL4Q2', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:55', NULL),
(204, 'Guntur Hermawan', 'guntur@gmail.com', '0157', 'guntur.h', 'Laki-Laki', '2015-06-03', '1992-06-23', 14, 8, 28, NULL, NULL, '$2y$10$mRxKEv58g71e8QGbnRpYqeNFd7CLclJ6ZpzXMxH/IWDjAV7lhR07K', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:55', NULL),
(205, 'Eri Hermawan', 'eri@gmail.com', '0183', 'eri.h', 'Laki-Laki', '2015-10-19', '1990-03-29', 14, 8, 28, '8', NULL, '$2y$10$Xm5NcXs4Hts7NRmXySrU7.RqEiLNTq6es3m7ZaDI/u6LxeWPStHFi', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:56', NULL),
(206, 'Naufal Galang Prakoso', 'naufal@gmail.com', '0112', 'naufal.g', 'Laki-Laki', '2014-12-04', '1993-11-03', 14, 8, 30, '8', NULL, '$2y$10$S5HqxPfNe/PlfNz7/OlfH.CPxD8HXxNZAzakMUyM8fczvXEJ0OXse', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:56', NULL),
(207, 'Andri Dwi Yatmoko', 'andri@gmail.com', '0084', 'andri.d', 'Laki-Laki', '2014-08-15', '1994-02-25', 14, 8, 30, '8', NULL, '$2y$10$6QzO/yXZLfBotpNYFF1U9.ZP8WwXkP1N01zJDtk1Wx5Hz3F1Cn0I.', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:56', NULL),
(208, 'Imam Joko Susilo', 'imamjoko@gmail.com', '0091', 'imam.j', 'Laki-Laki', '2014-10-06', '1993-09-21', 14, 8, 30, '8', NULL, '$2y$10$MeMi3HctzzDwJKckXlDrbeKThy4ZChHphM2obdU1mpBUjDmbBE3Hq', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:56', NULL),
(209, 'Arief Rachman', 'arief@gmail.com', '0028', 'arief.r', 'Laki-Laki', '2012-12-01', '1992-06-30', 14, 5, 28, '8', NULL, '$2y$10$qXLe4Dh4CGPvYbASAgPZouxDVe93FfQpc50GYV82KlGGptsz1xN5a', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:56', NULL),
(210, 'I Made Wahyu Karma Yoga', 'made.wahyu@astra-juoku.com', '0030', 'made.w', 'Laki-Laki', '2012-12-01', '1992-04-21', 14, 5, 25, '8', NULL, '$2y$10$tbnBvudyqBvoJSCjWsMBm.NZcroPOxDbpvo/9ZeXAYfN.W9JNsifW', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:56', NULL),
(211, 'Irfina Febianti', 'irfina.febianti@astra-juoku.com', '0060', 'irfina.f', 'Perempuan', '2013-05-01', '1990-02-26', 14, 2, 25, NULL, NULL, '$2y$10$79zx2TEuuk/8oQyF7bXFCuSqVl3y1x13I9IRkaPcqkXfWrflmJmqa', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:38', NULL),
(212, 'Dinar Permana', 'dinar@gmail.com', '0842', 'dinar.p', 'Laki-Laki', '2024-07-01', '1999-09-29', 15, 8, 39, NULL, NULL, '$2y$10$T372d9jIQx1CIZbhenUCYOtL3zsdru/tUrxysJeJTF5beGetT2Tti', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:56', NULL),
(213, 'Adhitiya', 'adhitiya@gmail.com', '0678', 'adhitiya', 'Laki-Laki', '2021-06-18', '2002-05-03', 15, 8, 42, '8', NULL, '$2y$10$f/OIgKqBbaBFGskYyCuj4eJGZ6vNItRFk4DtS57XrweIXTC0xfM06', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:56', NULL),
(214, 'Mochamad Surya Ali Imron', 'mochamad@gmail.com', '0679', 'mochamad.s', 'Laki-Laki', '2021-06-18', '2002-01-11', 15, 8, 42, '8', NULL, '$2y$10$WY5Sy8bBKY5Fi5pZpr3x3ezymPJz9pl/rhh4yrrDBKwLMmsI5Uby6', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:56', NULL),
(215, 'Alif Budi Prakoso', 'alif@gmail.com', '0683', 'alif.b', 'Laki-Laki', '2021-06-18', '2002-12-30', 15, 8, 39, '8', NULL, '$2y$10$yqd5ctqHqdSW8eUMHJfSEe5kPRBfxXRyDwwmKGkvYUN186TLWspzO', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:56', NULL),
(216, 'Endra Nur Haryanto', 'endra@gmail.com', '0691', 'endra.n', 'Laki-Laki', '2021-06-28', '2003-04-09', 15, 8, 39, '8', NULL, '$2y$10$zE0w3qSjfcUa9PC2rHoFqe/g0ZgnZZvulFTU7PQ/WsTuVF4cL15fS', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:56', NULL),
(217, 'Reza Aldian Fauzi', 'reza@gmail.com', '0695', 'reza.a', 'Laki-Laki', '2021-07-01', '1998-06-20', 15, 8, 39, '8', NULL, '$2y$10$ku6W0n6tMMIdUqJ41E9YoOLNdA/y/7G5iiSH5MzG3JN24QTr3Msm.', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:57', NULL),
(218, 'Teguh Triono', 'teguhtriono@gmail.com', '0702', 'teguh.t', 'Laki-Laki', '2021-07-01', '1993-10-01', 15, 8, 39, '8', NULL, '$2y$10$W9en7vEPaNACfG0kGz3O8evpQlzWn3.UgeDx4z4pauRZaqgxa.Yry', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:57', NULL),
(219, 'Agus', 'agus@gmail.com', '0706', 'agus', 'Laki-Laki', '2021-07-02', '1994-08-13', 15, 8, 39, '8', NULL, '$2y$10$8bIA/hxWqDEKJwgg7BCip.PXuZNgM1VB.uPa2oC6D5hvdozacuC62', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:57', NULL),
(220, 'Muhajirin', 'muhajirin@gmail.com', '0714', 'muhajirin', 'Laki-Laki', '2021-06-28', '1994-04-20', 15, 8, 39, '8', NULL, '$2y$10$h2V4.d0BjGVAjRpLuOginOGd/BvqvQ17RqIKu7aDLJ77adVwC2Ge6', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:57', NULL),
(221, 'Hendri Setyo Budi', 'hendri@gmail.com', '0721', 'hendri.s', 'Laki-Laki', '2021-07-05', '1995-06-19', 15, 8, 39, '8', NULL, '$2y$10$JfnmeyX1BYw/mYtRECD3Pek45T/QmAowqdbNGgfQz6/iecyif2i5K', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:57', NULL),
(222, 'Ilham Sururi', 'ilhamsururi@gmail.com', '0723', 'ilham.s', 'Laki-Laki', '2021-07-06', '2003-04-05', 15, 8, 39, '8', NULL, '$2y$10$Fc0ZfyKPQ5mI1QL.uD7Xt.EYyJb0vrc/Byh7Y4jOrHyeBEB11bhPW', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:57', NULL),
(223, 'Doris Maulana Pakpahan', 'doris@gmail.com', '0745', 'doris.m', 'Laki-Laki', '2021-10-13', '2002-01-24', 15, 8, 39, '8', NULL, '$2y$10$C/ZFAKO1bI6MsUG9NPxS6u2kt8JngPNeZepjPVxc64TPhtaFzMEuS', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:57', NULL),
(224, 'Rio Raharjo', 'rio@gmail.com', '0748', 'rio.r', 'Laki-Laki', '2021-10-13', '2002-11-18', 15, 8, 39, '8', NULL, '$2y$10$2K560djwNMw0PHW4b3905..8BxfVqhwX4H5UAaBdG/sjM21LG8woS', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:57', NULL),
(225, 'Sarip Hidayat', 'sarip@gmail.com', '0803', 'sarip.h', 'Laki-Laki', '2022-03-07', '1998-12-02', 15, 8, 39, '8', NULL, '$2y$10$ZSAFp7EOKvLqwxEu9eecLePbu76radcoM2.DBhBHhQIrDH93u6xxq', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:57', NULL),
(226, 'Alvin Hendrianto', 'alvin@gmail.com', '0804', 'alvin.h', 'Laki-Laki', '2022-03-07', '2003-01-02', 15, 8, 39, '8', NULL, '$2y$10$huhA2mfSsDGaH71dkk4Lzu4mG6HNnsiE12y/8gs6i0FKAc8Lif.4C', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:58', NULL),
(227, 'Zaenul Fatah', 'zaenul@gmail.com', '0768', 'zaenul.f', 'Laki-Laki', '2021-11-23', '1996-07-12', 15, 8, 39, '8', NULL, '$2y$10$MiBuPLrf1pVxrYbtn2KRIuG7IDSDVcvpyVXKqDhqknLqtIH730hqa', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:58', NULL),
(228, 'Yogi Saputra', 'yogisaputra@gmail.com', '0793', 'yogi.s', 'Laki-Laki', '2022-01-03', '1995-05-19', 15, 8, 39, '8', NULL, '$2y$10$ixNTGf.aYINa5.8qVHSyl.cg3ZQLidyMYfNqlviTDoCExf63Wn9Pq', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:58', NULL),
(229, 'Tomi Suhada', 'tomi@gmail.com', '0794', 'tomi.s', 'Laki-Laki', '2022-01-03', '2001-09-22', 15, 8, 39, '8', NULL, '$2y$10$Kvawp4vdMXKxqxyFM0g85OXGRZyDhUMSNX68vMCz4TkQYh8VP7y2m', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:58', NULL),
(230, 'Muhammad Nasai', 'nasai@gmail.com', '0796', 'muhammad.n', 'Laki-Laki', '2022-01-11', '1995-02-08', 15, 8, 39, '8', NULL, '$2y$10$lD4KnMaX3omsFUBOQCIND.wM6HWJWP2UH.1hEt8fn6SbnnFovuUDy', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:58', NULL),
(231, 'Kurniawan Sandy', 'sandi.kurniawan@astra-juoku.com', '0779', 'kurniawan.s', 'Laki-Laki', '2021-12-20', '1996-04-02', 15, 8, 40, '8', NULL, '$2y$10$.K8TGpza5fzEyZRVxw1blOrtZozqw5ssKq6ZTzCXwYq9nPq.mGUJS', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:58', NULL),
(232, 'Septy Andriani', 'septy@gmail.com', '0045', 'septy.a', 'Laki-Laki', '2013-05-07', '1992-09-22', 15, 8, 39, '8', NULL, '$2y$10$sRElHqXIRFIOsyqYE0Fs/eZ5m4QLyeX0yRpRkMDZyu.HOoUN4oYn.', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:58', NULL),
(233, 'Novrianto', 'novrianto@gmail.com', '0081', 'novrianto', 'Laki-Laki', '2014-07-10', '1987-11-02', 15, 8, 39, '8', NULL, '$2y$10$U1zpPkXa2FqryUB6RPKIwuYizxaNSjRv0K7SsiAY1jjReOgrKDoqa', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:58', NULL),
(234, 'Juju Juhana', 'juju.juhana@astra-juoku.com', '0144', 'juju.j', 'Laki-Laki', '2015-02-24', '1992-01-04', 15, 8, 40, '8', NULL, '$2y$10$IGM9d8czmqGx2YE8vmtg/uTEqMBkNfaBpZuIHUGpme/P6X4lF30z.', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:58', NULL),
(235, 'Sumarsono', 'sumarsono@gmail.com', '0147', 'sumarsono', 'Laki-Laki', '2015-03-09', '1990-06-21', 15, 8, 42, '8', NULL, '$2y$10$oBYgRlVHzYEESTCmT57Rh.3hYb.6kH546fPQIth2zqT9XUcFHTSG2', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:58', NULL),
(236, 'Jangkung Antoko', 'jangkung@gmail.com', '0244', 'jangkung.a', 'Laki-Laki', '2016-12-06', '1996-01-06', 15, 8, 39, '8', NULL, '$2y$10$TccYlaJs96xqjL7mcV1L1ODdFuIG0b9khyfNAHqUeEilzm7tCCfj6', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:58', NULL),
(237, 'Adji Pratama', 'adji@gmail.com', '0246', 'adji.p', 'Laki-Laki', '2016-12-19', '1996-01-06', 15, 8, 39, '8', NULL, '$2y$10$Lqcbt7ip/LDeXpHgwzFFi.psk7ecUfVbFGLEKgOCW17AGtxWj196u', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:59', NULL),
(238, 'M. Andika', 'muhamad.andika@astra-juoku.com', '0617', 'm.andika', 'Laki-Laki', '2021-01-06', '1999-08-07', 15, 8, 40, '8', NULL, '$2y$10$HT2uXYzGJ2s18aICN9DIzek/eMNgvEm0LqOel2vqXgFb1hQbm54Om', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:59', NULL),
(239, 'Syahrul Ramadhan', 'syahrul@gmail.com', '0621', 'syahrul', 'Laki-Laki', '2021-01-13', '1999-01-05', 15, 8, 39, '8', NULL, '$2y$10$1h0Vhnp33m9wWe3Ck7ryOOL7lDV7aJisCxPsg4kiOxasTBBCn5BkC', 0, NULL, '2024-11-03 12:13:50', '2025-07-31 06:52:59', NULL),
(240, 'Endriawan Apriyanto', 'endriawan@gmail.com', '0646', 'endriawan.a', 'Laki-Laki', '2021-03-10', '2001-04-09', 15, 8, 42, '8', NULL, '$2y$10$Cp5D06n4IbCdl95tOYLHy.n.Nr3V1DXnQuV49YgApLGgUFCLn3/D.', 0, NULL, '2024-11-03 12:13:51', '2025-07-31 06:52:59', NULL),
(241, 'Syahrul Ramdani', 'syahrulramdani@gmail.com', '0651', 'syahrul.r', 'Laki-Laki', '2021-03-15', '1998-01-29', 15, 8, 42, '8', NULL, '$2y$10$ESF9F60IUknbuH7bRtgOa.5fx.9semAcNjaKACeK1QMugZLXAxKOW', 0, NULL, '2024-11-03 12:13:51', '2025-07-31 06:52:59', NULL),
(242, 'Indra Pujianto', 'indra@gmail.com', '0654', 'indra.p', 'Laki-Laki', '2021-03-16', '2001-06-20', 15, 8, 39, '8', NULL, '$2y$10$UcYmVHVUU3wNmJUe7LM1wenfUUB1SridrOhuA1he2J9BRCMO1jxk6', 0, NULL, '2024-11-03 12:13:51', '2025-07-31 06:52:59', NULL),
(243, 'mahsun', 'mahsun@gmail.com', '1232', 'mahsun.b', 'laki-laki', '2024-10-09', '2004-10-09', 15, 5, 40, '3', NULL, '$2y$10$nD16ZttSvYMLLWCSbhooWOVCIvlVoSHRFwswhvHJuYvjG3pxHELBm', 0, NULL, '2024-11-03 13:02:18', '2024-11-13 07:56:49', NULL),
(244, 'guest', 'guest@gmail.com', '00000', 'guest', 'Perempuan', NULL, NULL, 17, 12, 48, '1', NULL, '$2y$10$jizEwXJ85YSmma2AKyUt2uSiEjMfmAZAn0TejU3Qg7R886FHVWR2a', 0, NULL, NULL, '2025-07-31 06:52:38', NULL),
(245, 'Mien Mien Shih', 'mien@gmail.com', '0845', 'mien.m', '', NULL, NULL, 11, 1, 23, NULL, NULL, '$2y$10$r0M8.gjDffiJLrj52wgeq.s0iZLh2dOssO4lBd98yg8J6m/rlk7Lq', 0, NULL, '2024-11-25 08:27:42', '2025-07-31 06:52:38', NULL),
(246, 'Chou Mei Fen', 'chou@gmail.com', '0843', 'chou.m', '', NULL, NULL, 11, 1, 23, NULL, NULL, '$2y$10$VzyDCHd7xJ.EygxJ3NofbugicI5/t60r44gNOUpHk2tLVC5NaupzO', 0, NULL, '2024-11-25 08:27:42', '2025-07-31 06:52:38', NULL),
(247, 'Nurhasan', 'nur.hasan@astra-juoku.com', '0032', 'nurhasan', '', NULL, NULL, 9, 7, 15, NULL, NULL, '$2y$10$SJzdxildXiDai0KvtFzDUuYMJngTrN2y7QJ/FuSGOLffbNl3ULW/q', 0, NULL, '2024-11-25 08:27:55', '2025-07-31 06:52:44', NULL),
(248, 'Untung Setiyadi', 'untung.setiyadi@astra-juoku.com', '0067', 'untung.s', '', NULL, NULL, 9, 7, 15, NULL, NULL, '$2y$10$RoaqnzY1ZguNtV3Ve2PvtuEwTw1bgxrGjH.qC88cV7hI7S.ADIp8i', 0, NULL, '2024-11-25 08:27:55', '2025-07-31 06:52:44', NULL),
(249, 'Adi Hermawan', 'adi.hermawan@astra-juoku.com', '0071', 'adi.h', '', NULL, NULL, 9, 7, 16, NULL, NULL, '$2y$10$pft1J1J.cXqTHZFfCN14p.KPrXECcLJcZa1GMp1qC6jKukpK8zGxm', 0, NULL, '2024-11-25 08:27:56', '2025-07-31 06:52:44', NULL),
(250, 'Acam Mulyanto', 'acam.mulyanto@astra-juoku.com', '0125', 'acam.m', '', NULL, NULL, 9, 7, 15, NULL, NULL, '$2y$10$pzRq7pCCm5GdHd1k7fpmrOXcxuR0Ftx5fprM3myuR8Ot0S6n2B2ei', 0, NULL, '2024-11-25 08:27:56', '2025-07-31 06:52:44', NULL),
(251, 'Mohammad Ramdhan', 'mohammad.ramdhan@astra-juoku.com', '0135', 'ramdhan', '', NULL, NULL, 9, 7, 16, NULL, NULL, '$2y$10$MYF.Lk.wfqrbDZ/vej95IuGleu68GOYqrZsxNpVHtuUtzGItxIBzm', 0, NULL, '2024-11-25 08:27:56', '2025-07-31 06:52:44', NULL),
(252, 'Admin Learning', 'miqbalnp15@gmail.com', '00', 'admin.l', '', NULL, NULL, 17, 12, 48, NULL, NULL, '$2y$10$FHy.zSkUw2KN.JPiGqY.O.fejTeA80lRX0NTPu9qhFq.d1jbbSVUa', 0, NULL, '2024-11-25 08:28:34', '2025-07-31 06:52:59', NULL),
(253, 'Rizqy Indhiyanto', 'Rizqy.Indhiyanto@astra-juoku.com', '0846', 'rizqy.i', '', NULL, NULL, 5, 3, 6, NULL, NULL, '$2y$10$pCtspASJxG3BBkm.ioi6PuD2uUPPwUMQmIT7iQ0UyJtNzkcT8836C', 0, NULL, '2025-01-14 04:25:52', '2025-07-16 07:39:11', '2025-07-16 07:39:11'),
(254, 'dadan hardiansyah', 'dadan@gmail.com', '0850', 'dadan.h', '', NULL, NULL, 9, 8, 15, NULL, NULL, '$2y$10$y7qxZbZirR15oLu8mt4c7elR8SsAOL/dvYtrn8yv5EfMKS0KY3IvK', 0, NULL, '2025-01-15 07:24:11', '2025-07-31 06:52:59', NULL),
(255, 'Attallah Arelian', 'attallah.naufal@astra-juoku.com', '0847', 'attallah', '', NULL, NULL, 5, 4, 7, NULL, NULL, '$2y$10$mzvJLhj0EYYCOni0YDEcMOvtH10/oN6fNMV7ZB0JKpV5rnPzt9yYC', 0, NULL, '2025-01-21 06:02:18', '2025-07-31 06:52:59', NULL),
(256, 'Muhammad Aldiansyah', 'aldi2@gmail.com', '0849', 'm.aldi', '', NULL, NULL, 4, 8, 21, NULL, NULL, '$2y$10$wCCtJ751SAgf3D4tLm9WYu/JOAm.XsGijaSiOvfJ2lqesRmIo23/2', 0, NULL, '2025-03-04 08:09:50', '2025-07-31 06:52:59', NULL),
(257, 'Agus Lesmana', 'agus1@gmail.com', '0848', 'agus.l', '', NULL, NULL, 4, 8, 20, NULL, NULL, '$2y$10$Gu5IL9zUe.T9TVcObZ0Rq.MtIsAMwyRGSIpYg5EWihCyQ1oUj6OxC', 0, NULL, '2025-03-04 08:09:51', '2025-07-31 06:53:00', NULL),
(258, 'sample', 'sample@gmail.com', '0001', 'sample', '', NULL, NULL, 15, 8, 39, NULL, NULL, '$2y$10$wODzeVwrh.AQsPd8nwk9ruvhxRLtEBzcIUJA0Y.uUwknckRmQhZLO', 0, NULL, '2025-05-21 04:30:08', '2025-07-31 06:53:00', NULL),
(259, 'ZAKA FADHLILLAH', 'zaka.fadhlillah@astra-juoku.com', '0851', 'zaka.f', '', NULL, NULL, 15, 5, 39, NULL, NULL, '$2y$10$xwmsH5pf3pgTDhGYQQItWOlmcXS/VvhPrlds9xGEeuh4E3DB7aH4e', 0, NULL, '2025-05-21 04:30:08', '2025-07-31 06:53:00', NULL),
(260, 'MILA RESA ROSANTI', 'mila.rosanti@astra-juoku.com', '0852', 'mila.r', '', NULL, NULL, 15, 5, 40, NULL, NULL, '$2y$10$b3lLwzmQS3vnUDb8xBkIueGJT.Y3F01btHnTuP1L8vjsRMvw2Uf22', 0, NULL, '2025-05-21 04:30:09', '2025-07-31 06:53:00', NULL),
(261, 'DIRA PUTRI ARINI', 'dira@gmail.com', '853', 'dira.p', '', NULL, NULL, 4, 8, 21, NULL, NULL, '$2y$10$eNMXomQrBx3vvpfcS0mWROuRPUcjxJZ5.t83xoF2nZG7qV6XU7KMe', 0, NULL, '2025-05-21 04:30:09', '2025-07-31 06:53:00', NULL),
(262, 'Fadil Hidayat', 'fadil@gmail.com', '0854', 'fadil.h', '', NULL, NULL, 3, 4, 2, NULL, NULL, '$2y$10$MSR/0A4qyEPaN9yAjsMTHe9DjjGZx/ewqVum6BxzT.lSOUO658ts.', 0, NULL, '2025-05-21 04:30:09', '2025-07-31 06:53:00', NULL),
(263, 'Johan Kurniawan', 'Johan.Kurniawan@astra-juoku.com', '0855', 'johan.k', '', NULL, NULL, 6, 3, 12, NULL, NULL, '$2y$10$nlQ2h3pXfsQSH5KrKR73WOg4UM41EQCrxw7P2/r5Ntqr/iffTFbN6', 0, NULL, '2025-07-16 07:39:12', '2025-07-31 06:53:00', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_box_packaging`
--
ALTER TABLE `delivery_box_packaging`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_box_type`
--
ALTER TABLE `delivery_box_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_claim`
--
ALTER TABLE `delivery_claim`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_customers`
--
ALTER TABLE `delivery_customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `delivery_customers_customer_code_index` (`customer_code`);

--
-- Indexes for table `delivery_henkaten`
--
ALTER TABLE `delivery_henkaten`
  ADD PRIMARY KEY (`id`),
  ADD KEY `delivery_henkaten_user_id_foreign` (`user_id`);

--
-- Indexes for table `delivery_henkaten_detail`
--
ALTER TABLE `delivery_henkaten_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_lines`
--
ALTER TABLE `delivery_lines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `delivery_lines_line_code_index` (`line_code`);

--
-- Indexes for table `delivery_log_truck`
--
ALTER TABLE `delivery_log_truck`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_man_powers`
--
ALTER TABLE `delivery_man_powers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `delivery_man_powers_npk_index` (`npk`);

--
-- Indexes for table `delivery_matrix_skills`
--
ALTER TABLE `delivery_matrix_skills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `delivery_matrix_skills_skill_id_foreign` (`skill_id`),
  ADD KEY `delivery_matrix_skills_user_id_foreign` (`user_id`);

--
-- Indexes for table `delivery_mos`
--
ALTER TABLE `delivery_mos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `delivery_mos_sku_foreign` (`sku`);

--
-- Indexes for table `delivery_notes`
--
ALTER TABLE `delivery_notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_packagings`
--
ALTER TABLE `delivery_packagings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `delivery_packagings_packaging_code_index` (`packaging_code`);

--
-- Indexes for table `delivery_parts`
--
ALTER TABLE `delivery_parts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `delivery_parts_sku_index` (`sku`),
  ADD KEY `delivery_parts_customer_id_foreign` (`customer_id`),
  ADD KEY `delivery_parts_color_id_foreign` (`color_id`),
  ADD KEY `delivery_parts_packaging_id_foreign` (`packaging_id`),
  ADD KEY `delivery_parts_line_id_foreign` (`line_id`);

--
-- Indexes for table `delivery_part_cards`
--
ALTER TABLE `delivery_part_cards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `delivery_part_cards_color_code_index` (`color_code`);

--
-- Indexes for table `delivery_pickup_customer`
--
ALTER TABLE `delivery_pickup_customer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `delivery_pickup_customer_customer_pickup_code_index` (`customer_pickup_code`);

--
-- Indexes for table `delivery_planning_refreshment`
--
ALTER TABLE `delivery_planning_refreshment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `delivery_planning_refreshment_user_id_foreign` (`user_id`);

--
-- Indexes for table `delivery_preparation`
--
ALTER TABLE `delivery_preparation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_skills`
--
ALTER TABLE `delivery_skills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `delivery_skills_skill_code_index` (`skill_code`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `detail_departement`
--
ALTER TABLE `detail_departement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `ga_work_order`
--
ALTER TABLE `ga_work_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `machine`
--
ALTER TABLE `machine`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `machine_detail`
--
ALTER TABLE `machine_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manpower_plannings`
--
ALTER TABLE `manpower_plannings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `manpower_plannings_mpp_number_unique` (`mpp_number`),
  ADD KEY `manpower_plannings_dept_id_foreign` (`dept_id`),
  ADD KEY `manpower_plannings_section_id_foreign` (`section_id`);

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
-- Indexes for table `mold`
--
ALTER TABLE `mold`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `npp_aji_internal_schedules`
--
ALTER TABLE `npp_aji_internal_schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `npp_calendar`
--
ALTER TABLE `npp_calendar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `npp_category_problem`
--
ALTER TABLE `npp_category_problem`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `npp_customer`
--
ALTER TABLE `npp_customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `npp_form_event_history`
--
ALTER TABLE `npp_form_event_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `npp_form_event_project`
--
ALTER TABLE `npp_form_event_project`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `npp_pica_aji_internal_schedule`
--
ALTER TABLE `npp_pica_aji_internal_schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `npp_project_event`
--
ALTER TABLE `npp_project_event`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `npp_project_open_issue`
--
ALTER TABLE `npp_project_open_issue`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `npp_schedules`
--
ALTER TABLE `npp_schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `npp_signup`
--
ALTER TABLE `npp_signup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `npp_urgensi`
--
ALTER TABLE `npp_urgensi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

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
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posts_user_id_foreign` (`user_id`);

--
-- Indexes for table `quality_cs_ipqcs`
--
ALTER TABLE `quality_cs_ipqcs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quality_cs_ipqcs_history`
--
ALTER TABLE `quality_cs_ipqcs_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quality_cs_qtimes`
--
ALTER TABLE `quality_cs_qtimes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quality_ipqcs`
--
ALTER TABLE `quality_ipqcs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quality_machines`
--
ALTER TABLE `quality_machines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quality_models`
--
ALTER TABLE `quality_models`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quality_monitors`
--
ALTER TABLE `quality_monitors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quality_mp_produksi`
--
ALTER TABLE `quality_mp_produksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quality_ng_categories`
--
ALTER TABLE `quality_ng_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quality_parts`
--
ALTER TABLE `quality_parts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `model_id_foreign` (`model_id`);

--
-- Indexes for table `quality_processes`
--
ALTER TABLE `quality_processes`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `scanwi`
--
ALTER TABLE `scanwi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sections_dept_id_foreign` (`dept_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery_box_packaging`
--
ALTER TABLE `delivery_box_packaging`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `delivery_box_type`
--
ALTER TABLE `delivery_box_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `delivery_claim`
--
ALTER TABLE `delivery_claim`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `delivery_customers`
--
ALTER TABLE `delivery_customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `delivery_henkaten`
--
ALTER TABLE `delivery_henkaten`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `delivery_henkaten_detail`
--
ALTER TABLE `delivery_henkaten_detail`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `delivery_lines`
--
ALTER TABLE `delivery_lines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `delivery_log_truck`
--
ALTER TABLE `delivery_log_truck`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `delivery_man_powers`
--
ALTER TABLE `delivery_man_powers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `delivery_matrix_skills`
--
ALTER TABLE `delivery_matrix_skills`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=187;

--
-- AUTO_INCREMENT for table `delivery_mos`
--
ALTER TABLE `delivery_mos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery_notes`
--
ALTER TABLE `delivery_notes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `delivery_packagings`
--
ALTER TABLE `delivery_packagings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `delivery_parts`
--
ALTER TABLE `delivery_parts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `delivery_part_cards`
--
ALTER TABLE `delivery_part_cards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `delivery_pickup_customer`
--
ALTER TABLE `delivery_pickup_customer`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `delivery_planning_refreshment`
--
ALTER TABLE `delivery_planning_refreshment`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery_preparation`
--
ALTER TABLE `delivery_preparation`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `delivery_skills`
--
ALTER TABLE `delivery_skills`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `detail_departement`
--
ALTER TABLE `detail_departement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ga_work_order`
--
ALTER TABLE `ga_work_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1340;

--
-- AUTO_INCREMENT for table `machine`
--
ALTER TABLE `machine`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `machine_detail`
--
ALTER TABLE `machine_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=424;

--
-- AUTO_INCREMENT for table `manpower_plannings`
--
ALTER TABLE `manpower_plannings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `mold`
--
ALTER TABLE `mold`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `npp_aji_internal_schedules`
--
ALTER TABLE `npp_aji_internal_schedules`
  MODIFY `id` int(13) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=225;

--
-- AUTO_INCREMENT for table `npp_calendar`
--
ALTER TABLE `npp_calendar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `npp_category_problem`
--
ALTER TABLE `npp_category_problem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `npp_customer`
--
ALTER TABLE `npp_customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `npp_form_event_history`
--
ALTER TABLE `npp_form_event_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `npp_form_event_project`
--
ALTER TABLE `npp_form_event_project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=716;

--
-- AUTO_INCREMENT for table `npp_pica_aji_internal_schedule`
--
ALTER TABLE `npp_pica_aji_internal_schedule`
  MODIFY `id` int(130) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=333;

--
-- AUTO_INCREMENT for table `npp_project_event`
--
ALTER TABLE `npp_project_event`
  MODIFY `id` int(130) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `npp_project_open_issue`
--
ALTER TABLE `npp_project_open_issue`
  MODIFY `id` int(130) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `npp_schedules`
--
ALTER TABLE `npp_schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `npp_signup`
--
ALTER TABLE `npp_signup`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `npp_urgensi`
--
ALTER TABLE `npp_urgensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23487;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `quality_cs_ipqcs`
--
ALTER TABLE `quality_cs_ipqcs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `quality_cs_ipqcs_history`
--
ALTER TABLE `quality_cs_ipqcs_history`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `quality_cs_qtimes`
--
ALTER TABLE `quality_cs_qtimes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quality_ipqcs`
--
ALTER TABLE `quality_ipqcs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `quality_machines`
--
ALTER TABLE `quality_machines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `quality_models`
--
ALTER TABLE `quality_models`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=168;

--
-- AUTO_INCREMENT for table `quality_monitors`
--
ALTER TABLE `quality_monitors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `quality_mp_produksi`
--
ALTER TABLE `quality_mp_produksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=148;

--
-- AUTO_INCREMENT for table `quality_ng_categories`
--
ALTER TABLE `quality_ng_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `quality_parts`
--
ALTER TABLE `quality_parts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `quality_processes`
--
ALTER TABLE `quality_processes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1713;

--
-- AUTO_INCREMENT for table `scanwi`
--
ALTER TABLE `scanwi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=264;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `delivery_henkaten`
--
ALTER TABLE `delivery_henkaten`
  ADD CONSTRAINT `delivery_henkaten_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `delivery_man_powers` (`npk`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `delivery_matrix_skills`
--
ALTER TABLE `delivery_matrix_skills`
  ADD CONSTRAINT `delivery_matrix_skills_skill_id_foreign` FOREIGN KEY (`skill_id`) REFERENCES `delivery_skills` (`skill_code`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `delivery_matrix_skills_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `delivery_man_powers` (`npk`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `delivery_mos`
--
ALTER TABLE `delivery_mos`
  ADD CONSTRAINT `delivery_mos_sku_foreign` FOREIGN KEY (`sku`) REFERENCES `delivery_parts` (`sku`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `delivery_parts`
--
ALTER TABLE `delivery_parts`
  ADD CONSTRAINT `delivery_parts_color_id_foreign` FOREIGN KEY (`color_id`) REFERENCES `delivery_part_cards` (`color_code`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `delivery_parts_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `delivery_customers` (`customer_code`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `delivery_parts_line_id_foreign` FOREIGN KEY (`line_id`) REFERENCES `delivery_lines` (`line_code`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `delivery_parts_packaging_id_foreign` FOREIGN KEY (`packaging_id`) REFERENCES `delivery_packagings` (`packaging_code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `delivery_planning_refreshment`
--
ALTER TABLE `delivery_planning_refreshment`
  ADD CONSTRAINT `delivery_planning_refreshment_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `delivery_man_powers` (`npk`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

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
