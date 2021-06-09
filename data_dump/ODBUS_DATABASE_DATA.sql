-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 09, 2021 at 06:36 AM
-- Server version: 8.0.21
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `odbusbackend`
--

-- --------------------------------------------------------

--
-- Table structure for table `amenities`
--

CREATE TABLE `amenities` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` blob,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reason` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `amenities`
--

INSERT INTO `amenities` (`id`, `name`, `icon`, `created_at`, `updated_at`, `created_by`, `reason`, `status`) VALUES
(15, 'music system', 0x6956424f5277304b47676f414141414e5355684555674141414541414141424143414d414141436474344873414141416756424d5645582f2f2f2f392f762f362f6637322f5037792b7637762b6633742b50336e3976336a39507a67382f7a6338667a523766724e362f724536506d2f35766934342f69773450656f3350616b322f61663266574a30664f467a2f4f417a664a39792f4a33796646777876466a7765396376753557764f35517575314e7565314974757841744f77347365737872756f73712b6b6e71656b68702b6761704f67556f75634e6e2b59496e6559446d2b554654697231414141426c556c455156523432753356323361434d424146304b6b53704771396f42537046537059534f622f503743326d7043724358317932653758435964686b696738734e464c746a3932464a462b317674734f595a42787575536f6f4b5761586a47704f6a516f747646454949554642316f4874444671735562546775344c64716a782b735433444274304b754b77476e575959446a78506d384f72326d534f634a49636b384c64544761754c6f763558334c4a387174567875376d4e736e5a2f3047706f5a5338615a314e386257456a7a4c784f7753456f554e7062395279454468367876305868464c416241317543305a6e7a564154513735506a7a3967546b6c7472396f56722f33712b6f515647492b5947486d4f524b32614f7548343548776e7574514a4c793243313462666c612b615164384b4b4e774374717a5a654e65467335424d6a3570514a6830586356594d705878385a6e4e52436b3466746758494d436768544742396657512b67396a752f415865664b596767534d2f3077557573703970376e446a6a3864747041734d337070324d6c59414b446a50424d4353415172482f6d502b417541325956777a4e577a634451313977422f62387256524f306d6a4f67517145436d565a7a426a4155474d69306d6a4d414f58326f65753142417a68506750426f416551714e4f435a5849426930433563334748416b4d746b476e696454514e2f55457a4466744c63794e6c76616e2f5a463567757a7233504d524a704141414141456c46546b5375516d4343, '2021-06-04 06:55:45', '2021-06-04 06:57:26', 'Admin', 'null', 1),
(16, 'wifi', 0x6956424f5277304b47676f414141414e5355684555674141414541414141424143414d414141436474344873414141416831424d5645582f2f2f2f392f762f362f6637322f5037792b7637762b6633742b50336e3976336a39507a67382f7a6338667a57372f76523766724a36766e4536506d2f357669773450656b322f61663266575a312f5750302f534a30664f467a2f4f417a664a39792f4a3379664677787646727866426e772f426376753557764f35517575314e7565314974757841744f77347365737872756f73712b6b6e71656b68702b6761704f67556f75634e6e2b59496e6559446d2b586f4c2b644b414141426b556c45515652343275335579354b434d42414630465a4251523779307143436f49684530762f2f66654e436b4943514944576247632b536f6d386c36553767362b7550307830535a30574a443257527863525a677a7a566a536c32304e685651634c6353526e32594b6b7a6832484c48635642644c6363576a73705561676b6654755a2b52536c55483847627867586c4a595a304f47584f454c70413038356458354a39353574614b717147626133547a76784a7755617443747962735361743770726b52747972687255544d70314f374c674c53746933466d6139646a656d30732f724b445836744463796c32767668396648784d6442756b4a316f344137515471674a4244582f587468504d4b4a4b7a4f56583037495a79426c466c5931664d4a586d7533586e536835654e55365358795769666a50656f37754e3570327877352b56626a667836307268724f6a3466736f375167724f633949517551594f62594b7a6442794330486236454c416c73554347445945515832494a33416b6d436a7136712b43524c577152636e3047445a654b7944357755345145575545433561765130623879394f6f445a30324c537146794d36764b45542b4965737147437369437a346a424c6a55367a414235514d61396b6e4354453278444361685a7a78357841684a344b78437551554d425a44446f4f3258772b597649584a687a69356a5a4d4861666f6f5437354d30362f7a6c365166656c6d6535374a4967373041414141415355564f524b35435949493d, '2021-06-04 06:57:13', '2021-06-04 06:57:20', 'Admin', 'null', 1);

-- --------------------------------------------------------

--
-- Table structure for table `appdownload`
--

CREATE TABLE `appdownload` (
  `id` bigint UNSIGNED NOT NULL,
  `mobileno` bigint UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `appversion`
--

CREATE TABLE `appversion` (
  `id` int NOT NULL,
  `info` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mandatory` int NOT NULL DEFAULT '1' COMMENT '0-not mandatory 1- manadatory',
  `version` int NOT NULL,
  `new_version_names` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `new_version_codes` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `allowed_days` int DEFAULT NULL,
  `has_issues` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `boarding_droping`
--

CREATE TABLE `boarding_droping` (
  `id` int NOT NULL,
  `location_id` int UNSIGNED NOT NULL,
  `boarding_point` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `boarding_droping`
--

INSERT INTO `boarding_droping` (`id`, `location_id`, `boarding_point`, `created_at`, `updated_at`, `created_by`, `status`) VALUES
(1, 1291, 'Bermunda', '2020-11-04 02:37:10', '2020-11-05 02:37:10', 'Admin', 1),
(2, 1291, 'CRPF', '2020-11-04 02:37:10', '2020-11-05 02:37:10', 'Admin', 1),
(3, 1291, 'Rasulgarh', '2020-11-04 02:37:10', '2020-11-05 02:37:10', 'Admin', 1),
(4, 1291, 'Palasuni', '2020-11-04 02:37:10', '2020-11-05 02:37:10', 'Admin', 1),
(5, 1294, 'Sambalpur Town', '2020-11-04 02:37:10', '2020-11-05 02:37:10', 'Admin', 1),
(6, 1294, 'Hirakud', '2020-11-04 02:37:10', '2020-11-05 02:37:10', 'Admin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id` int UNSIGNED NOT NULL,
  `transaction_id` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pnr` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `booking_customer_id` int NOT NULL COMMENT 'Customers ID',
  `bus_operator_id` int NOT NULL COMMENT 'Operator Id',
  `bus_id` int UNSIGNED NOT NULL,
  `source_id` int UNSIGNED NOT NULL,
  `destination_id` int UNSIGNED NOT NULL,
  `j_day` int NOT NULL DEFAULT '0' COMMENT 'journey day | 0-same day 1-nxt day',
  `journey_dt` date NOT NULL,
  `boardingPoint_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `droppingPoint_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `boarding_time` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dropping_time` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_fare` double(8,2) UNSIGNED NOT NULL,
  `ownr_fare` double(8,2) DEFAULT NULL,
  `is_coupon` int NOT NULL DEFAULT '0' COMMENT '0-no 1-yes',
  `coupon_code` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coupon_discount` decimal(9,2) DEFAULT NULL,
  `discounted_fare` decimal(9,2) DEFAULT NULL,
  `origin` enum('ODBUS','RPBOA','GRANDBUS','JANARDANBUS','KHAMBESWARI','MOBUS') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `app_type` set('WEB','MOB','ANDROID','CLNTWEB','CLNTMOB','ASSNWEB','ASSNMOB','CONDUCTOR','AGENT','MANAGER','OPERATOR') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `typ_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Type of Users booking Ticket',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL,
  `created_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking_customer`
--

CREATE TABLE `booking_customer` (
  `id` int NOT NULL,
  `first_name` varchar(120) NOT NULL,
  `last_name` varchar(120) NOT NULL,
  `age` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(120) NOT NULL,
  `phone` varchar(40) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `status` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking_detail`
--

CREATE TABLE `booking_detail` (
  `id` int NOT NULL,
  `booking_id` int UNSIGNED NOT NULL,
  `pnr` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jrny_dt` date NOT NULL,
  `j_day` int NOT NULL DEFAULT '0' COMMENT 'journey day | 0-same day 1-nxt day journey day | 0-same day 1-nxt day',
  `bus_id` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `seat_no` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `passenger_name` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `passenger_gender` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `passenger_age` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bus`
--

CREATE TABLE `bus` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `bus_operator_id` int NOT NULL DEFAULT '1',
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `via` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bus_number` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bus_description` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bus_type_id` int UNSIGNED NOT NULL,
  `bus_sitting_id` int UNSIGNED NOT NULL,
  `bus_seat_layout_id` int UNSIGNED NOT NULL,
  `cancellationslabs_id` int NOT NULL DEFAULT '2',
  `running_cycle` int UNSIGNED NOT NULL,
  `popularity` int UNSIGNED DEFAULT NULL COMMENT 'Higher the number higher will be posotioning in buslist',
  `admin_notes` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `has_return_bus` int NOT NULL COMMENT '0-no 1-yes',
  `return_bus_id` int DEFAULT NULL,
  `cancelation_points` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int UNSIGNED NOT NULL DEFAULT '0',
  `sequence` int NOT NULL DEFAULT '1000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bus`
--

INSERT INTO `bus` (`id`, `user_id`, `bus_operator_id`, `name`, `via`, `bus_number`, `bus_description`, `bus_type_id`, `bus_sitting_id`, `bus_seat_layout_id`, `cancellationslabs_id`, `running_cycle`, `popularity`, `admin_notes`, `has_return_bus`, `return_bus_id`, `cancelation_points`, `created_at`, `updated_at`, `created_by`, `status`, `sequence`) VALUES
(1, 1, 1, 'Khambeswari', 'Angul', 'OD 02 BE 1002', 'Luxury AC', 315, 3, 1, 6, 0, 1, NULL, 0, NULL, NULL, '2021-05-27 13:39:14', '2021-05-27 14:25:37', 'Admin', 2, 1000),
(2, 1, 1, 'Banadurga', 'Angul', 'OD 02 BE 1002', 'Luxury AC', 315, 1, 2, 6, 0, 1, NULL, 0, NULL, NULL, '2021-05-27 13:40:25', '2021-05-27 14:25:46', 'Admin', 2, 1000),
(3, 1, 1, 'Ajay & Ajay', 'Angul', 'OD 02 BE 1002', 'Luxury AC', 315, 3, 2, 6, 0, 1, NULL, 0, NULL, NULL, '2021-05-27 14:22:53', '2021-05-27 14:25:40', 'Admin', 2, 1000),
(4, 1, 1, 'JagaKalia', 'Angul', 'OD 02 BE 1002', 'Luxury AC', 316, 3, 1, 6, 0, 1, NULL, 0, NULL, NULL, '2021-05-27 14:23:20', '2021-05-27 14:25:43', 'Admin', 2, 1000);

-- --------------------------------------------------------

--
-- Table structure for table `bus_amenities`
--

CREATE TABLE `bus_amenities` (
  `id` int UNSIGNED NOT NULL,
  `bus_id` int UNSIGNED NOT NULL,
  `amenities_id` int UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bus_amenities`
--

INSERT INTO `bus_amenities` (`id`, `bus_id`, `amenities_id`, `created_at`, `updated_at`, `created_by`, `status`) VALUES
(3, 1, 15, '2021-06-08 10:52:57', '2021-06-16 10:52:57', '', 0),
(4, 1, 16, '2021-05-03 17:29:24', '2021-05-04 17:29:24', 'Admin', 0),
(5, 4, 15, '2021-05-03 17:30:49', '2021-05-03 17:30:49', 'Admin', 0),
(10, 4, 16, '2020-11-04 02:37:10', '2020-11-05 02:37:10', 'Admin', 0);

-- --------------------------------------------------------

--
-- Table structure for table `bus_cancelled`
--

CREATE TABLE `bus_cancelled` (
  `id` int UNSIGNED NOT NULL,
  `bus_id` int UNSIGNED NOT NULL,
  `bus_operator_id` int NOT NULL,
  `month` varchar(50) DEFAULT NULL,
  `year` varchar(50) DEFAULT NULL,
  `reason` varchar(200) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `cancelled_by` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `status` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bus_cancelled_date`
--

CREATE TABLE `bus_cancelled_date` (
  `id` int UNSIGNED NOT NULL,
  `bus_cancelled_id` int UNSIGNED NOT NULL,
  `cancelled_date` date NOT NULL,
  `created_by` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bus_class`
--

CREATE TABLE `bus_class` (
  `id` int NOT NULL,
  `class_name` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bus_class`
--

INSERT INTO `bus_class` (`id`, `class_name`, `created_at`, `updated_at`, `created_by`) VALUES
(1, 'AC', '2021-06-03 18:23:22', '2021-06-03 18:23:22', 'Admin'),
(2, 'NON AC', '2021-06-03 18:23:22', '2021-06-03 18:23:22', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `bus_closing_hours`
--

CREATE TABLE `bus_closing_hours` (
  `id` int NOT NULL,
  `bus_id` int NOT NULL,
  `city_id` int NOT NULL,
  `dep_time` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `closing_hours` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bus_contacts`
--

CREATE TABLE `bus_contacts` (
  `id` int NOT NULL,
  `bus_id` int UNSIGNED NOT NULL,
  `type` int NOT NULL COMMENT '0-operator 1-manager 2-conductor',
  `phone` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `booking_sms_send` int NOT NULL DEFAULT '0' COMMENT '0-dontsend 1-send',
  `cancel_sms_send` int NOT NULL DEFAULT '0' COMMENT '0-dontsend 1-send',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bus_extra_fare`
--

CREATE TABLE `bus_extra_fare` (
  `id` bigint UNSIGNED NOT NULL,
  `bus_id` int UNSIGNED NOT NULL,
  `type` int UNSIGNED NOT NULL COMMENT '1 - Operator, 2 - ODBUS',
  `journey_date` date DEFAULT NULL,
  `seat_fare` int NOT NULL COMMENT 'extra 30rs.. added to all seaters',
  `sleeper_fare` int NOT NULL COMMENT 'extra 70rs.. added to all sleapers',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bus_gallery`
--

CREATE TABLE `bus_gallery` (
  `id` int UNSIGNED NOT NULL,
  `bus_id` int UNSIGNED NOT NULL,
  `image` mediumblob NOT NULL,
  `alt_tag` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bus_operator`
--

CREATE TABLE `bus_operator` (
  `id` int NOT NULL,
  `email_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `operator_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_number` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `organisation_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `location_name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `additional_email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `additional_contact` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_account_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_ifsc` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_account_number` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Bus Operators';

--
-- Dumping data for table `bus_operator`
--

INSERT INTO `bus_operator` (`id`, `email_id`, `password`, `operator_name`, `contact_number`, `organisation_name`, `location_name`, `address`, `additional_email`, `additional_contact`, `bank_account_name`, `bank_name`, `bank_ifsc`, `bank_account_number`, `created_at`, `updated_at`, `created_by`, `status`) VALUES
(1, 'deesasd@ss.com', 'Admin@2010', 'GPM Travels', '9692424122', 'SEOFIED', 'Bhubaneswar', 'Station Bazar Road', NULL, NULL, 'Chandrakanta Rath', 'IOBS', 'IO5287', '123654785412', '2021-02-01 09:37:56', '2021-03-13 13:02:04', 'Admin', 1),
(2, 'deepak@gmail.com', '25425', 'DD BUS Service', '9875486547', 'DD', 'bargarh', 'Lane 1,  Patia', NULL, NULL, 'Deepak Das', 'Punjab National Bank', 'PUB25415', '22552254125', '2021-02-01 11:57:18', '2021-02-10 09:08:13', 'Admin', 1),
(3, 'deepaks@gmail.com', 'KK@123', 'KK', '1236547890', 'KK INT', 'bhubaneswar', 'Bhubaneswar', NULL, NULL, NULL, NULL, NULL, NULL, '2021-02-01 13:13:36', '2021-02-25 14:10:44', 'Admin', 0),
(4, 'aasss@gmaill.com', 'abcd', 'SAS services', '1234569870', 'ABCDS', 'ATRE', 'TYHR', NULL, NULL, NULL, NULL, NULL, NULL, '2021-02-01 13:17:58', '2021-02-26 13:59:29', 'Admin', 2),
(5, 'Chandra@gmail.com', '123456', 'NEXO Travels', '5454545459', 'Test', 'BBSR', 'BBSR', NULL, NULL, NULL, NULL, NULL, NULL, '2021-02-26 13:59:20', '2021-02-26 13:59:20', 'Admin', 1),
(6, 'pdsir@gmail.com', '111111', 'demo', '2154545454', 'NEW OD', 'BBSR', 'BBS', NULL, NULL, NULL, NULL, NULL, NULL, '2021-02-27 06:26:28', '2021-02-27 06:26:28', 'Admin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bus_owner_fare`
--

CREATE TABLE `bus_owner_fare` (
  `id` int NOT NULL,
  `bus_id` int UNSIGNED NOT NULL,
  `owner_fare_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bus_safety`
--

CREATE TABLE `bus_safety` (
  `id` int NOT NULL,
  `bus_id` int UNSIGNED NOT NULL,
  `safety_id` int NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bus_schedule`
--

CREATE TABLE `bus_schedule` (
  `id` int UNSIGNED NOT NULL,
  `bus_id` int UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Admin',
  `status` int UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bus_schedule`
--

INSERT INTO `bus_schedule` (`id`, `bus_id`, `created_at`, `updated_at`, `created_by`, `status`) VALUES
(1, 1, '2021-05-15 10:38:49', '2021-05-15 10:38:49', 'Admin', 0),
(2, 4, '2021-05-31 08:42:06', '2021-05-31 08:42:06', 'admin', 0);

-- --------------------------------------------------------

--
-- Table structure for table `bus_schedule_date`
--

CREATE TABLE `bus_schedule_date` (
  `id` int UNSIGNED NOT NULL,
  `bus_schedule_id` int UNSIGNED NOT NULL,
  `entry_date` date NOT NULL,
  `created_by` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bus_schedule_date`
--

INSERT INTO `bus_schedule_date` (`id`, `bus_schedule_id`, `entry_date`, `created_by`, `created_at`, `updated_at`, `status`) VALUES
(1, 1, '2021-05-08', 'Admin', '2021-05-15 10:38:49', '2021-05-15 10:38:49', 1),
(2, 1, '2021-05-10', 'Admin', '2021-05-15 10:38:49', '2021-05-15 10:38:49', 1),
(3, 1, '2021-05-12', 'Admin', '2021-05-15 10:38:49', '2021-05-15 10:38:49', 1),
(4, 1, '2021-05-14', 'Admin', '2021-05-15 10:38:49', '2021-05-15 10:38:49', 1),
(5, 1, '2021-05-16', 'Admin', '2021-05-15 10:38:49', '2021-05-15 10:38:49', 1),
(6, 1, '2021-05-18', 'Admin', '2021-05-15 10:38:49', '2021-05-15 10:38:49', 1),
(7, 1, '2021-05-20', 'Admin', '2021-05-15 10:38:49', '2021-05-15 10:38:49', 1),
(8, 1, '2021-05-22', 'Admin', '2021-05-15 10:38:50', '2021-05-15 10:38:50', 1),
(9, 1, '2021-05-24', 'Admin', '2021-05-15 10:38:50', '2021-05-15 10:38:50', 1),
(10, 1, '2021-05-26', 'Admin', '2021-05-15 10:38:50', '2021-05-15 10:38:50', 1),
(11, 1, '2021-05-28', 'Admin', '2021-05-15 10:38:50', '2021-05-15 10:38:50', 1),
(12, 1, '2021-05-30', 'Admin', '2021-05-15 10:38:50', '2021-05-15 10:38:50', 1),
(13, 1, '2021-06-01', 'Admin', '2021-05-15 10:38:50', '2021-05-15 10:38:50', 1),
(14, 1, '2021-06-03', 'Admin', '2021-05-15 10:38:50', '2021-05-15 10:38:50', 1),
(15, 1, '2021-06-05', 'Admin', '2021-05-15 10:38:50', '2021-05-15 10:38:50', 1),
(16, 1, '2021-06-07', 'Admin', '2021-05-15 10:38:50', '2021-05-15 10:38:50', 1),
(17, 1, '2021-06-09', 'Admin', '2021-05-15 10:38:50', '2021-05-15 10:38:50', 1),
(18, 1, '2021-06-11', 'Admin', '2021-05-15 10:38:50', '2021-05-15 10:38:50', 1),
(19, 1, '2021-06-13', 'Admin', '2021-05-15 10:38:50', '2021-05-15 10:38:50', 1),
(20, 1, '2021-06-15', 'Admin', '2021-05-15 10:38:50', '2021-05-15 10:38:50', 1),
(21, 1, '2021-06-17', 'Admin', '2021-05-15 10:38:50', '2021-05-15 10:38:50', 1),
(22, 1, '2021-06-19', 'Admin', '2021-05-15 10:38:50', '2021-05-15 10:38:50', 1),
(23, 1, '2021-06-21', 'Admin', '2021-05-15 10:38:50', '2021-05-15 10:38:50', 1),
(24, 1, '2021-06-23', 'Admin', '2021-05-15 10:38:50', '2021-05-15 10:38:50', 1),
(25, 1, '2021-06-25', 'Admin', '2021-05-15 10:38:50', '2021-05-15 10:38:50', 1),
(26, 1, '2021-06-27', 'Admin', '2021-05-15 10:38:50', '2021-05-15 10:38:50', 1),
(27, 1, '2021-06-29', 'Admin', '2021-05-15 10:38:50', '2021-05-15 10:38:50', 1),
(28, 1, '2021-07-01', 'Admin', '2021-05-15 10:38:50', '2021-05-15 10:38:50', 1),
(29, 1, '2021-07-03', 'Admin', '2021-05-15 10:38:50', '2021-05-15 10:38:50', 1),
(30, 1, '2021-07-05', 'Admin', '2021-05-15 10:38:50', '2021-05-15 10:38:50', 1),
(31, 2, '2021-05-08', 'admin', '2021-05-31 08:42:06', '2021-05-31 08:42:06', 1),
(32, 2, '2021-05-11', 'admin', '2021-05-31 08:42:06', '2021-05-31 08:42:06', 1),
(33, 2, '2021-05-14', 'admin', '2021-05-31 08:42:06', '2021-05-31 08:42:06', 1),
(34, 2, '2021-05-17', 'admin', '2021-05-31 08:42:06', '2021-05-31 08:42:06', 1),
(35, 2, '2021-05-20', 'admin', '2021-05-31 08:42:06', '2021-05-31 08:42:06', 1),
(36, 2, '2021-05-23', 'admin', '2021-05-31 08:42:06', '2021-05-31 08:42:06', 1),
(37, 2, '2021-05-26', 'admin', '2021-05-31 08:42:06', '2021-05-31 08:42:06', 1),
(38, 2, '2021-05-29', 'admin', '2021-05-31 08:42:06', '2021-05-31 08:42:06', 1),
(39, 2, '2021-06-01', 'admin', '2021-05-31 08:42:06', '2021-05-31 08:42:06', 1),
(40, 2, '2021-06-04', 'admin', '2021-05-31 08:42:06', '2021-05-31 08:42:06', 1),
(41, 2, '2021-06-07', 'admin', '2021-05-31 08:42:06', '2021-05-31 08:42:06', 1),
(42, 2, '2021-06-10', 'admin', '2021-05-31 08:42:06', '2021-05-31 08:42:06', 1),
(43, 2, '2021-06-13', 'admin', '2021-05-31 08:42:06', '2021-05-31 08:42:06', 1),
(44, 2, '2021-06-16', 'admin', '2021-05-31 08:42:06', '2021-05-31 08:42:06', 1),
(45, 2, '2021-06-19', 'admin', '2021-05-31 08:42:06', '2021-05-31 08:42:06', 1),
(46, 2, '2021-06-22', 'admin', '2021-05-31 08:42:06', '2021-05-31 08:42:06', 1),
(47, 2, '2021-06-25', 'admin', '2021-05-31 08:42:06', '2021-05-31 08:42:06', 1),
(48, 2, '2021-06-28', 'admin', '2021-05-31 08:42:06', '2021-05-31 08:42:06', 1),
(49, 2, '2021-07-01', 'admin', '2021-05-31 08:42:06', '2021-05-31 08:42:06', 1),
(50, 2, '2021-07-04', 'admin', '2021-05-31 08:42:06', '2021-05-31 08:42:06', 1),
(51, 2, '2021-07-07', 'admin', '2021-05-31 08:42:06', '2021-05-31 08:42:06', 1),
(52, 2, '2021-07-10', 'admin', '2021-05-31 08:42:06', '2021-05-31 08:42:06', 1),
(53, 2, '2021-07-13', 'admin', '2021-05-31 08:42:06', '2021-05-31 08:42:06', 1),
(54, 2, '2021-07-16', 'admin', '2021-05-31 08:42:06', '2021-05-31 08:42:06', 1),
(55, 2, '2021-07-19', 'admin', '2021-05-31 08:42:06', '2021-05-31 08:42:06', 1),
(56, 2, '2021-07-22', 'admin', '2021-05-31 08:42:06', '2021-05-31 08:42:06', 1),
(57, 2, '2021-07-25', 'admin', '2021-05-31 08:42:06', '2021-05-31 08:42:06', 1),
(58, 2, '2021-07-28', 'admin', '2021-05-31 08:42:06', '2021-05-31 08:42:06', 1),
(59, 2, '2021-07-31', 'admin', '2021-05-31 08:42:06', '2021-05-31 08:42:06', 1),
(60, 2, '2021-08-03', 'admin', '2021-05-31 08:42:06', '2021-05-31 08:42:06', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bus_seats`
--

CREATE TABLE `bus_seats` (
  `id` int UNSIGNED NOT NULL,
  `bus_id` int UNSIGNED NOT NULL,
  `ticket_price_id` int UNSIGNED NOT NULL,
  `seats_id` int NOT NULL,
  `category` int UNSIGNED NOT NULL COMMENT '0-odbus 1-conductor',
  `bookStatus` int NOT NULL DEFAULT '0' COMMENT '0=Not Booked,\r\n1= Booked,\r\n2=Reserved',
  `duration` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT 'if grater than 0 its additional seats/ sleepers in minutes THE  gap after which full seats will be given to odbus',
  `new_fare` double(8,2) NOT NULL DEFAULT '0.00',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bus_seats`
--

INSERT INTO `bus_seats` (`id`, `bus_id`, `ticket_price_id`, `seats_id`, `category`, `bookStatus`, `duration`, `new_fare`, `created_at`, `updated_at`, `created_by`, `status`) VALUES
(1, 1, 1, 1, 0, 1, '0', 0.00, '2021-04-30 09:42:46', '2021-05-24 12:02:27', 'Admin', 0),
(2, 1, 2, 2, 0, 1, '0', 0.00, '2021-06-06 23:08:17', '2021-06-06 23:08:17', 'Admin', 1),
(3, 4, 1, 5, 0, 1, '0', 0.00, '2021-06-06 23:08:17', '2021-06-06 23:08:17', 'Admin', 1),
(4, 1, 1, 3, 0, 1, '0', 0.00, '2021-06-07 14:01:36', '2021-06-07 14:01:36', 'Admin', 0),
(5, 1, 1, 6, 0, 0, '0', 0.00, '2021-06-07 14:02:51', '2021-06-07 14:02:51', 'Admin', 0),
(9, 4, 2, 4, 0, 1, '0', 0.00, '2021-06-08 17:46:33', '2021-06-08 17:46:33', 'Admin', 0);

-- --------------------------------------------------------

--
-- Table structure for table `bus_seats_extra`
--

CREATE TABLE `bus_seats_extra` (
  `id` int UNSIGNED NOT NULL,
  `bus_id` int UNSIGNED NOT NULL,
  `journey_dt` date NOT NULL,
  `type` int UNSIGNED NOT NULL COMMENT '1 - Block, 2 - Open',
  `seat_type` int UNSIGNED NOT NULL COMMENT '0-seater 1-sleeper',
  `seat_number` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bus_seat_layout`
--

CREATE TABLE `bus_seat_layout` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(254) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bus_seat_layout`
--

INSERT INTO `bus_seat_layout` (`id`, `name`, `created_at`, `updated_at`, `created_by`, `status`) VALUES
(1, 'Demo 1', '2021-04-29 11:40:07', '2021-04-29 11:40:16', 'Admin', 1),
(2, 'Demo 2', '2021-04-29 12:10:30', '2021-04-29 12:29:13', 'Admin', 1),
(3, 'Demo3', '2021-04-29 11:40:07', '2021-04-29 11:40:16', 'Admin', 1),
(4, 'Demo4', '2021-04-29 12:10:30', '2021-04-29 12:29:13', 'Admin', 1),
(5, 'Demo5', '2021-04-29 12:30:14', '2021-04-29 12:30:21', 'Admin', 1),
(6, 'Demo6', '2021-04-29 12:36:38', '2021-04-29 12:39:58', 'Admin', 2);

-- --------------------------------------------------------

--
-- Table structure for table `bus_sitting`
--

CREATE TABLE `bus_sitting` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(254) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bus_sitting`
--

INSERT INTO `bus_sitting` (`id`, `name`, `created_at`, `updated_at`, `created_by`, `status`) VALUES
(1, '2+3', '2021-02-16 11:01:14', '2021-05-08 06:26:32', 'Admin', 1),
(2, 'sss', '2021-02-16 11:04:07', '2021-02-24 11:33:50', 'Admin', 1),
(3, '2+2', '2021-02-16 11:06:05', '2021-02-24 11:33:48', 'Admin', 1),
(4, '6+2', '2021-02-16 11:07:25', '2021-02-26 13:53:32', 'Admin', 1),
(5, '3/2', '2021-02-25 13:58:46', '2021-02-25 13:58:50', 'Admin', 1),
(6, '6+2+2', '2021-02-26 13:53:41', '2021-02-26 13:54:05', 'Admin', 2),
(7, '7-2', '2021-02-27 06:19:52', '2021-02-27 06:46:03', 'Admin', 2),
(8, '5+2+1', '2021-02-27 06:44:50', '2021-02-27 06:45:31', 'Admin', 2),
(9, '5+9', '2021-02-27 09:18:20', '2021-02-27 12:43:15', 'Admin', 2),
(10, '5+99', '2021-02-27 09:19:01', '2021-02-27 12:43:20', 'Admin', 2),
(11, 'New Demo 5/6', '2021-05-08 06:26:43', '2021-05-08 06:26:48', 'Admin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bus_slots`
--

CREATE TABLE `bus_slots` (
  `id` int UNSIGNED NOT NULL,
  `bus_id` int UNSIGNED NOT NULL,
  `name` varchar(254) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` int NOT NULL DEFAULT '0' COMMENT '0- ODBUS    1- conductor ',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bus_special_fare`
--

CREATE TABLE `bus_special_fare` (
  `id` int NOT NULL,
  `bus_id` int UNSIGNED NOT NULL,
  `special_fare_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bus_stoppage_additional_fare`
--

CREATE TABLE `bus_stoppage_additional_fare` (
  `id` int UNSIGNED NOT NULL,
  `ticket_price_id` int UNSIGNED NOT NULL,
  `bus_seats_id` int UNSIGNED NOT NULL,
  `additional_fare` double(8,2) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bus_stoppage_timing`
--

CREATE TABLE `bus_stoppage_timing` (
  `id` int UNSIGNED NOT NULL,
  `bus_id` int UNSIGNED NOT NULL,
  `location_id` int UNSIGNED NOT NULL,
  `boarding_droping_id` int NOT NULL,
  `stoppage_name` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stoppage_time` time NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Admin',
  `status` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bus_stoppage_timing`
--

INSERT INTO `bus_stoppage_timing` (`id`, `bus_id`, `location_id`, `boarding_droping_id`, `stoppage_name`, `stoppage_time`, `created_at`, `updated_at`, `created_by`, `status`) VALUES
(33, 1, 1291, 1, 'Null', '22:00:00', '2021-06-21 18:49:45', '2021-06-09 18:49:45', 'Admin', 0),
(34, 4, 1291, 4, 'Null', '22:50:00', '2021-06-03 18:51:37', '2021-06-03 18:51:37', 'Admin', 0),
(35, 1, 1294, 5, 'Null', '07:00:00', '2021-06-03 18:53:24', '2021-06-03 18:53:24', 'Admin', 0),
(36, 4, 1294, 6, 'Null', '07:30:00', '2021-06-03 18:54:17', '2021-06-03 18:54:17', 'Admin', 0),
(37, 1, 1291, 3, NULL, '22:50:00', '2021-06-03 19:58:55', '2021-06-03 19:58:55', 'Admin', 0),
(38, 1, 1294, 4, NULL, '22:50:00', '2021-06-03 20:00:08', '2021-06-03 20:00:08', 'Admin', 0);

-- --------------------------------------------------------

--
-- Table structure for table `bus_type`
--

CREATE TABLE `bus_type` (
  `id` int UNSIGNED NOT NULL,
  `bus_class_id` int NOT NULL DEFAULT '0',
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int UNSIGNED DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bus_type`
--

INSERT INTO `bus_type` (`id`, `bus_class_id`, `name`, `created_at`, `updated_at`, `created_by`, `status`) VALUES
(1, 1, 'Delux', '2021-06-06 21:27:35', '2021-06-06 21:27:35', 'Admin', 1),
(315, 1, 'VOLVO', '2018-07-28 10:38:59', '2021-02-06 06:39:49', 'ty6754yt', 2),
(316, 2, 'DELUX', '2017-10-05 13:17:21', '2021-02-10 10:55:53', 'ty6754yt', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cancellationslabs`
--

CREATE TABLE `cancellationslabs` (
  `id` int NOT NULL,
  `api_id` int DEFAULT NULL,
  `rule_name` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deduction` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cancellationslabs`
--

INSERT INTO `cancellationslabs` (`id`, `api_id`, `rule_name`, `duration`, `deduction`, `status`, `created_at`, `updated_at`, `created_by`) VALUES
(1, 1, '1', '24-99#$18-23#$7-17#$0-6', '40#$70#$80#$100', 1, '2021-02-03 09:14:33', '2021-02-26 13:57:00', NULL),
(3, 1, 'ddd', 'sss#$eeess', 'sssddd#$gggdddd', 1, '2021-02-16 05:51:41', '2021-02-16 05:51:41', NULL),
(4, 1, 'New Slot', '25-999#$18-24#$0-17', '20#$40#$100', 2, '2021-02-26 13:57:38', '2021-02-26 14:24:20', NULL),
(5, 1, '1', '24-999#$18-23#$0-17', '45#$50#$100', 1, '2021-02-27 06:24:18', '2021-02-27 06:24:51', NULL),
(6, 1, 'OD Rule 2', '25-999#$18-24#$8-17#$0-7', '30#$50#$80#$100', 1, '2021-02-27 06:58:31', '2021-02-27 06:58:31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `city_closing`
--

CREATE TABLE `city_closing` (
  `id` int UNSIGNED NOT NULL,
  `bus_id` int UNSIGNED NOT NULL,
  `location_id` int UNSIGNED NOT NULL,
  `closing_hours` int UNSIGNED DEFAULT NULL COMMENT 'Time in minutes',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Admin',
  `status` int UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `city_closing_extended`
--

CREATE TABLE `city_closing_extended` (
  `id` int NOT NULL,
  `bus_id` int UNSIGNED NOT NULL,
  `location_id` int UNSIGNED DEFAULT NULL,
  `journey_date` date NOT NULL,
  `closing_hours` int UNSIGNED DEFAULT NULL COMMENT 'Time in minutes',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupon`
--

CREATE TABLE `coupon` (
  `id` int UNSIGNED NOT NULL,
  `coupon_title` varchar(254) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coupon_code` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('Percent','CutOff') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double(8,2) DEFAULT NULL COMMENT 'in % or in cash',
  `max_discount_price` double(8,2) DEFAULT NULL COMMENT 'incase of % deduction',
  `min_tran_amount` double(8,2) DEFAULT NULL,
  `max_redeem` int DEFAULT NULL,
  `max_use_limit` int DEFAULT NULL,
  `category` int DEFAULT NULL COMMENT '0-booking date 1-journey date',
  `from_date` datetime DEFAULT NULL,
  `to_date` datetime DEFAULT NULL,
  `short_desc` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_desc` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupon_assigned_bus`
--

CREATE TABLE `coupon_assigned_bus` (
  `id` int UNSIGNED NOT NULL,
  `bus_id` int UNSIGNED NOT NULL,
  `coupon_id` int UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_query`
--

CREATE TABLE `customer_query` (
  `id` int NOT NULL,
  `email` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `query_typ` enum('RESERVATION','CONTACT') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'json_data',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_query_category`
--

CREATE TABLE `customer_query_category` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(254) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_query_category_issues`
--

CREATE TABLE `customer_query_category_issues` (
  `id` int UNSIGNED NOT NULL,
  `customer_query_category_id` int UNSIGNED NOT NULL,
  `name` varchar(254) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `custom_pages`
--

CREATE TABLE `custom_pages` (
  `id` int NOT NULL,
  `origin` int DEFAULT '0' COMMENT '0-odbus 1-rpboa 2-janardana ',
  `type` int DEFAULT '0' COMMENT '0-custom pages  1-route pages 2-news',
  `source_id` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'only for route pages',
  `destination_id` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'only for route pages',
  `name` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `meta_title` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_keyword` varchar(600) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_descriptiom` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `extended_bus_closing_hours`
--

CREATE TABLE `extended_bus_closing_hours` (
  `id` int NOT NULL,
  `bus_id` int NOT NULL,
  `city_id` int NOT NULL,
  `dep_time` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `closing_hours` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(254) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `synonym` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`id`, `name`, `synonym`, `created_at`, `updated_at`, `created_by`, `status`) VALUES
(1291, 'Bhubaneswar', 'BBSR,bbs, bhobneswar', '2017-10-05 13:01:12', '2021-02-22 05:39:37', '', 1),
(1292, 'Cuttack', 'katak,CTC', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(1293, 'Dhenkanal', 'DNKL', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(1294, 'Sambalpur', 'SBP', '2017-10-05 13:01:12', '2018-09-17 12:18:41', '', 1),
(1295, 'Jharsuguda', '', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(1296, 'Sora', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1297, 'Bargarh', '', '2017-10-05 13:01:12', '2018-09-17 12:18:40', '', 1),
(1298, 'Khurda', 'Khordha,Khurdha', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1299, 'JajpurTown', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1300, 'Talcher', 'TLHR', '2017-10-05 13:01:12', '2021-02-26 13:53:16', 'Admin', 1),
(1301, 'Baripada', 'BPO', '2017-10-05 13:01:12', '2018-09-17 12:18:40', '', 1),
(1302, 'Sundargarh', 'Sundergarh', '2017-10-05 13:01:12', '2018-09-17 12:18:41', '', 1),
(1303, 'Balasore', 'BLS,Baleswar', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1304, 'Kolkata', 'KOL', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(1305, 'Durg', '', '2017-10-05 13:01:12', '2018-09-17 12:18:41', '', 1),
(1306, 'Nayagarh', 'NYG', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1307, 'Birmitrapur', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1308, 'Banharpali', 'Banaharpali', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1309, 'Rourkela', 'ROU, RKL, RAURKELA', '2017-10-05 13:01:12', '2018-09-17 12:18:41', '', 1),
(1310, 'Balisankara', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1311, 'Parlakhemundi', 'Paralakhemundi', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1312, 'Phulbani', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1313, 'Angul', 'ANGL,Anugul', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(1314, 'Padmapur-Rayagada', 'Padampur', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1315, 'Gunupur', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1316, 'Rayagada', 'RGDA', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1317, 'Madhabpur', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1318, 'Umerkote', '', '2017-10-05 13:01:12', '2018-09-17 12:18:41', '', 1),
(1319, 'Kuchinda', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1320, 'Deogarh', '', '2017-10-05 13:01:12', '2018-09-17 12:18:41', '', 1),
(1321, 'Bundia', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1322, 'Dabugaon', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1323, 'Papadahandi', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1324, 'Mahidalpur', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1325, 'Bhawanipatna', 'bwip', '2017-10-05 13:01:12', '2018-09-17 12:18:40', '', 1),
(1326, 'Daspalla', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1327, 'Brajaraj Nagar', 'Brajaraj Nagar', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1328, 'Gandhi Chak', 'Gandhi Chak', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1329, 'IBThermal', 'Thermal,IB Thermal', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1330, 'Nalda', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1331, 'Chandikhole', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1332, 'Kuakhia', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1333, 'Panikoili', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1334, 'JajpurRoad', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1335, 'Barbil', '', '2017-10-05 13:01:12', '2018-09-17 12:18:40', '', 1),
(1336, 'Joda', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1337, 'Keonjhar', '', '2017-10-05 13:01:12', '2018-09-17 12:18:41', '', 1),
(1338, 'Anandpur', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1339, 'Tikabali', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1340, 'Choudwar', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1341, 'Nakhara', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1342, 'Gunupur ByPass', 'Gunupur ByPass', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1343, 'Sambalpur ByPass', 'Sambalpur ByPass', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1344, 'Junagarh', 'Junagad,Junagadh', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1345, 'Puri', 'PURI', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(1346, 'Bhitarkanika', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1347, 'Betanati', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1348, 'Bhusan', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1349, 'Manguli ', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1350, 'Jeypore', 'Jaypore,Jeypure,JYP', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1351, 'Nabarangpur', 'NBG,Nawarangpur', '2017-10-05 13:01:12', '2018-09-17 12:18:41', '', 1),
(1352, 'Berhampur', 'BAM', '2017-10-05 13:01:12', '2018-09-17 12:18:40', '', 1),
(1353, 'Chhatrapur', 'CAP', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1354, 'Rambha', 'RBA', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1355, 'Kespur', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1356, 'Balugaon', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1357, 'Tangi', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1358, 'Banei', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1359, 'Chandanpur', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1360, 'Sakhigopal', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1361, 'Pipili', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1362, 'Barkote', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1363, 'Rengali', 'RGL', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1364, 'Asika', 'Aska', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(1365, 'Digapahandi', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1366, 'Mohana', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1367, 'Hinjilikatu', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1368, 'Koraput', 'KRPU', '2017-10-05 13:01:12', '2018-09-17 12:18:41', '', 1),
(1369, 'Indravati', '', '2017-10-05 13:01:12', '2018-09-17 12:18:41', '', 1),
(1370, 'Lakshmipur', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1371, 'Tentulikhunti', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1372, 'Adaba', '', '2017-10-05 13:01:12', '2021-02-04 04:58:31', '', 2),
(1373, 'Belpahar', 'BPH', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1374, 'Bhadrak', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1375, 'Kiakata', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1376, 'Bhanjanagar', '', '2017-10-05 13:01:12', '2018-09-17 12:18:40', '', 1),
(1377, 'Kalinga', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1378, 'Rajgangpur', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1379, 'Kansbahal', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1380, 'Badagaon', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1381, 'Burla', '', '2017-10-05 13:01:12', '2018-09-17 12:18:41', '', 1),
(1383, 'Khatiguda', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1384, 'Sunabeda', '', '2017-10-05 13:01:12', '2018-09-17 12:18:41', '', 1),
(1385, 'Birmaharajpur', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1386, 'Balangir', 'BLGR,Bolangir', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1387, 'Sonepur', '', '2017-10-05 13:01:12', '2018-09-17 12:18:41', '', 1),
(1388, 'Semiliguda', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1389, 'Gurundia', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1390, 'Koida', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1391, 'Rajamunda', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1392, 'Tata-Nagar', 'Tata', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(1393, 'Rajkanika', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1394, 'Kendrapara', '', '2017-10-05 13:01:12', '2018-09-17 12:18:41', '', 1),
(1395, 'Salepur', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1396, 'Pattamundai', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1397, 'Aul', '', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(1398, 'Olaver', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1399, 'Jagatpur', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1400, 'Champua', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1401, 'Bolani', 'Balani', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1402, 'Kiriburu', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1403, 'Tensa', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1404, 'Paradip', 'Paradip', '2017-10-05 13:01:12', '2018-09-17 12:18:41', '', 1),
(1405, 'Rairakhol', 'Redhakhol', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1406, 'Asureswar', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1407, 'Bhilai', '', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(1408, 'Raipur-chhattisgarh', '', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(1409, 'Hirakud', 'HKG', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1410, 'Kakatpur', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1412, 'Chakradharpur', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1413, 'Ranchi', '', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(1414, 'Kantabanji', 'KBJ', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1415, 'RajaKhadial', 'Raj khariar, Raj Khadial', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1416, 'Patnagarh', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1417, 'Jaleswar', 'JER', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1418, 'Karanjia', '', '2017-10-05 13:01:12', '2018-09-17 12:18:41', '', 1),
(1419, 'Kaptipada', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1420, 'Udala', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1421, 'Rairangpur', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1422, 'Sarat', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1423, 'Patsanipur', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1424, 'Malkangiri', '', '2017-10-05 13:01:12', '2018-09-17 12:18:41', '', 1),
(1428, 'Nalco', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1429, 'Padampur-Bargarh', 'Padmapur, Padamapur', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1430, 'Kaipadar', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1431, 'Charampa', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1432, 'Bhandaripokhari', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1433, 'Dhamanagar', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1434, 'Khordha', 'Khurda,Khurdha', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1435, 'Mukhiguda', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1436, 'Kesinga', 'KSNG', '2017-10-05 13:01:12', '2018-09-17 12:18:41', '', 1),
(1437, 'Jaipatna', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1438, 'Kotapada', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1439, 'Kodala', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1440, 'Polasara', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1441, 'Buguda', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1442, 'Odagaon', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1443, 'Luhagudi', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1444, 'Raygad', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1445, 'Khajuripada', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1446, 'R.Udayagiri', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1447, 'Cheligarh', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1448, 'Mahendragarh', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1449, 'Chandragiri', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1450, 'Chandiput', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1451, 'Bramhanigaon', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1453, 'Raighar-Umerkote', 'Raigarh', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1454, 'Gorumahisani', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1455, 'Jagatsinghpur', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1456, 'Sohela', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1457, 'Nuapada', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1458, 'Komna', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1459, 'Jashipur', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1460, 'Rimuli', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1461, 'Deulia', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1462, 'Santragachhi', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1463, 'Kalighat', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1464, 'Singhpur', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1465, 'Duharia', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1466, 'Rugudi', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1467, 'Baisinga', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1468, 'Betnoti', 'BTQ', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1469, 'Bisoi', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1470, 'Ghatagaon', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1471, 'Dhenkikote', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1472, 'chowringhee', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1473, 'Bangamunda', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1474, 'Machagaon', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1475, 'Paikamala', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1476, 'Godbhaga', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1477, 'Daringbadi', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1478, 'Raikia', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1479, 'Bombay Chawk', 'Bombay Chawk', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1481, 'Tiring', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1482, 'Dhenkikot', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1483, 'Jagannathprasad', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1484, 'Belaguntha', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1485, 'Benisagar', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1486, 'Thakarmunda', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1489, 'Bijatala', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1490, 'Kanaktura', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1491, 'Kalampur', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1493, 'Gangpur', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1494, 'Balia', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1497, 'Bhutamundi', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1498, 'Kujanga', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1499, 'Rahama', 'RHMA', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1500, 'Jeypure', 'Jeypore,Jaypore', '2018-07-21 10:36:32', '0000-00-00 00:00:00', '', 0),
(1501, 'Tarpur', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1502, 'Raghunathpur', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1503, 'Sinapali', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1504, 'Dharamgarh', 'Dharamgarh', '2019-03-18 11:20:12', '0000-00-00 00:00:00', '', 1),
(1505, 'Purusottampur', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1506, 'Asansol', '', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(1507, 'Bankura', '', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(1508, 'Durgapur', '', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(1509, 'Jamshedpur', '', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(1510, 'Khallikot', 'KIT', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(1511, 'Korba', '', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(1512, 'Patamundai', '', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(1513, 'Barpali', 'BRPL', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1514, 'Boudha', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1515, 'Khariar Road', 'KRAR,Khariar Road', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1516, 'Konark', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1517, 'Lanjigarh', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1518, 'Rajkot', '', '2017-10-05 13:01:12', '2018-09-17 12:18:41', '', 1),
(1519, 'Rampur', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1520, 'Saintala', 'SFC', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1521, 'Sunakhala', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1522, 'Titilagarh', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1523, 'Ambapani', '', '2017-10-05 13:01:12', '2021-02-04 05:08:28', '', 2),
(1524, 'Baipariguda', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1525, 'Bilaspur', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1526, 'Binika', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1527, 'Borigumma', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1528, 'Chatia', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1529, 'Dharmagarh', 'Dharamgarh', '2019-03-18 11:54:58', '2018-09-17 12:18:41', '', 0),
(1530, 'J K ROAD', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1531, 'J.I.T.M. Parlakhemundi', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1532, 'Jarka', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1533, 'Junagad', 'Junagarh,Junagadh', '2019-03-18 11:19:46', '0000-00-00 00:00:00', '', 0),
(1534, 'Junagadh', 'Junagarh,Junagad', '2019-03-18 11:19:35', '2018-09-17 12:18:41', '', 0),
(1535, 'Karsingh', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1536, 'Kenduguda', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1537, 'Kiribur', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1538, 'Kotagarh', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1539, 'Motu', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1540, 'Muniguda', 'MNGD', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1541, 'Orissajharkhand Border', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1542, 'Purunapani', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1543, 'Sarankul', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1544, 'Tangi Chandpur', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1545, 'Utkella', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1546, 'Chaibasa', '', '2017-10-05 13:01:12', '2018-09-17 12:18:41', '', 1),
(1547, 'Noamundi', '', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1548, 'Panposh', 'PPO', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1549, 'Chandabali', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1550, 'Thidi', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1551, 'Pirhat', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1552, 'Balikuda', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1553, 'Kandarpur', 'KDRP', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1554, 'Simdega', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1555, 'Jharpokharia', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1556, 'Raj khariar', 'Raja Khariar', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1557, 'Chatiguda', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1558, 'Narla', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1559, 'Kashipur', '', '0000-00-00 00:00:00', '2018-09-17 12:18:41', '', 1),
(1560, 'Tikiri', 'TKRI', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1561, 'JK Pur', 'J.K. Pur', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1562, 'Tumudibandha', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1563, 'Baliguda', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1564, 'Therubali', 'THV,Terubali', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1565, 'Bisam Cuttack', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1566, 'Athagarh', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1567, 'Narasingpur', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1568, 'Barsuan', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1569, 'Jhumpura', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1570, 'Palashpanga', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1571, 'Padmapur-Keonjhar', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1572, 'Palahada', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1573, 'Lahunipada', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1574, 'Jharadi', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1575, 'Bahalada', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1576, 'Nuagaon', 'NXN', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1577, 'Udayagiri', '', '2018-03-01 13:03:25', '2018-09-17 12:18:41', '', 1),
(1578, 'Moter', '', '2018-03-01 15:43:49', '0000-00-00 00:00:00', '', 1),
(1579, 'Gumuda', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1580, 'Podamari', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1581, 'Thelkoloi ', 'Telkoi', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1582, 'Damonjodi', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1583, 'Chipilima', 'Cipilima', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1584, 'Raigarh-Paralakhemundi', 'Raighar', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1585, 'Raighar-chhattisgarh', 'Raigarh', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1586, 'Kantamal', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1587, 'Palsaguda', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1588, 'Manmunda', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1589, 'Bausuni', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1590, 'Madhapur', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1591, 'Athamallick', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1592, 'Bhanjakia', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1593, 'Raruan', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1594, 'Sikuli', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1595, 'Thakurmunda', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1596, 'Anandapur', 'Anandpur', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1597, 'Jasbantapur', 'Jasabantapur', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1598, 'Laxmipur', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1599, 'Rakhukana-Rayagada', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1600, 'Narayanpatna-Rayagada', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1601, 'Demo', '', '2019-06-13 17:11:04', '0000-00-00 00:00:00', '', 0),
(1602, 'Dhanbad', '', '0000-00-00 00:00:00', '2018-09-17 12:18:41', '', 1),
(1603, 'Purulia', '', '0000-00-00 00:00:00', '2018-09-17 12:18:41', '', 1),
(1604, 'Jamda', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1605, 'Jagannathpur', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1606, 'Koksora', 'Kokasara', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1607, 'Ampani', 'Amapani,Ambapani', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1608, 'Maidalpur', 'Maidalpur', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1609, 'Ambikapur', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1610, 'Baghicha', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1611, 'Kunkuri', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1612, 'Tapkera', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1613, 'Bheden', 'Veden', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1614, 'Rengali Camp', 'Rengali Camp', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1615, 'Khetamundali', 'Khetamundali', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1616, 'Gereda', 'Gereda', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1617, 'Hyderabad', 'Hyd', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1618, 'Bengaluru', 'Bangalore', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1619, 'Ghens', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1620, 'Mandosil', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1621, 'Dunguripali', 'Dunguripaly, Dunguripalli', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1622, 'S Rampur', 'S.Rampur,S Rampur', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1623, 'Ulunda', 'Ulunda', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1624, 'Binka', 'binika', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1625, 'Kinjirkela', 'Kin', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1626, 'Vijayawada', 'Bijayawada', '2018-11-10 13:01:12', '2018-11-10 13:01:12', '', 1),
(1627, 'Visakhapatnam', 'Vizag', '2018-11-10 13:01:12', '2018-11-10 13:01:12', '', 1),
(1628, 'Balimela', 'Balimela', '2018-11-10 13:01:12', '2018-11-10 13:01:12', '', 1),
(1629, 'Chennai', 'Madras', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(1630, 'Coimbatore', 'Coimbatore', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(1631, 'Madurai', '', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(1632, 'Ghatsila', '', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(1633, 'Baharaguda', '', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(1634, 'Jamsola', '', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(1635, 'Basudevpur', '', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(1636, 'CenturionUniversity-Parlakhemundi', 'Paralakhemundi', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1637, 'Balichandrapur', '', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(1638, 'Rajnagar', '', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(1639, 'Kundei-Umerkot', '', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(1640, 'Laxmisagar', '', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(1641, 'Nayapalli', '', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(1648, 'Bomikhal', '', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(1649, 'DASARATHPUR', '', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(1650, 'Balipatpur', '', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(1651, 'JHUMPURI', '', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(1652, 'BHUSANDPUR', '', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(1654, 'Uttara', '', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(1655, 'Salapada', '', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(1657, 'Rameswar-Khurdha', '', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(1658, 'Nirakarpur', '', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(1659, 'Tapang', '', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(1660, 'Gobindabali', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1661, 'Siliguri', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1662, 'M Rampur', 'M. Rampur,M Rampur', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1663, 'Yungthan', '', '2019-06-13 17:04:02', '0000-00-00 00:00:00', '', 0),
(1664, 'Lachung', '', '2019-06-13 17:16:33', '0000-00-00 00:00:00', '', 0),
(1665, 'Siphong', '', '2019-06-13 17:06:28', '0000-00-00 00:00:00', '', 0),
(1666, 'Syber', '', '2019-06-13 17:05:31', '0000-00-00 00:00:00', '', 0),
(1667, 'Tumba', 'Tumba', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1668, 'Chikiti', 'Chikiti', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1669, 'Bhismagiri', 'Bhismagiri', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1670, 'Sheragada', 'Seragada', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1671, 'Aska', 'aska,asika', '2019-06-13 18:11:28', '0000-00-00 00:00:00', '', 0),
(1672, 'Tikarpada', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1673, 'Dengaosta', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1674, 'Singipur', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1675, 'Simanbadi', 'Simanbadi', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1676, 'Pabuaria', 'Pabuaria', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1677, 'Ruchida-Bargarh', 'Ruchida', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1678, 'Banspal', 'Banspal', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1679, 'Oupada', 'Oupada', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1680, 'Kupari', 'Kupari', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1681, 'Khaira', 'Khaira', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1682, 'Khajuripada-Phulbani', 'Khajuripada', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1683, 'Ramjibanpur-WB', 'Ramjibanpur', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1684, 'Kharar-WB', 'Kharar', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1685, 'Ghatal-WB', 'Ghatal', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1686, 'MechoGram-WB', 'MechoGram', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1687, 'Jharigaon', 'jharigaon', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1688, 'Hatabharandi', 'Hatabharandi', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1689, 'Kantilo', 'Kantilo', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1690, 'Khandapada', 'Khandapada', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1691, 'Bokaro', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1692, 'Digha', 'Udaipur Beach, Digha Border', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1693, 'Agalpuraa', 'Agalpura', '0000-00-00 00:00:00', '2021-02-10 12:22:57', 'Admin', 1),
(1694, 'K Nuagaon', 'K.Nuagaon, K Nuagaon,', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1695, 'Gutingia', 'Gutingia', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1696, 'G Udayagiri', 'G.Udayagiri, G Udayagiri', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1697, 'Sarangada', 'Sarangada', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1698, 'Budaguda', 'Budaguda', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1699, 'Ramgiri', 'Ramgiri', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1700, 'Jiranga', 'Jiranga', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1701, 'Mandalsahi', 'Mandalsahi', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1702, 'Saramuli', 'SARAMULI', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1703, 'Gadapur', 'GADAPUR', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1704, 'Gajalbarhi', 'Gajalbadi', '2019-10-29 13:28:20', '0000-00-00 00:00:00', '', 1),
(1705, 'Asurabandha', 'ASURABANDHA', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1706, 'Gajalbadi', 'Gajalbarhi', '2019-10-29 13:29:44', '0000-00-00 00:00:00', '', 0),
(1707, 'Seragarh-Ganjam', 'Seragarh (Ganjam)', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1708, 'Paniganda', 'Paniganda', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1709, 'Sorada', 'Sorada', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1710, 'Madhapur-Kantilo', 'Madhapur-Kantilo', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1711, 'Rajkiari', 'Rajkiari', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1712, 'Gania', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1713, 'Jalespata', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1714, 'Bataguda', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1715, 'Kurtamgarh', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1716, 'Kalapathar', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1717, 'Phiringia', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1718, 'Boipariguda', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1719, 'Hyderabad-City', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1720, 'Bhadrachalam', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1721, 'Khammam', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1722, 'Kothagudam', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1723, 'MV79-Malkangiri', 'MV 79, Malkangiri', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1724, 'Kalimela-Malkangiri', 'Kalimela', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1725, 'Chandili-Kotapad', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1726, 'Kakiriguma', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1727, 'Pune', 'Pune', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1728, 'Mumbai', 'Bombay', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1729, 'SHIRIDI SAI TEMPLE', 'shiridi,sai,siridi', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1730, 'Govinda Palli-Malkangiri', 'Gobinda Palli-Malkangiri,Govindpali', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1731, 'Badagada', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1732, 'Balipadar', 'BALIPADAR', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(1733, 'Keonjhar Bypass', '', '2020-03-12 13:17:55', '0000-00-00 00:00:00', '', 0),
(1734, 'Chandaneswar', 'Chandaneswar', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1735, 'Kamarda-Baleswar', 'Kamarda', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1736, 'Thanachak-Baleswar', 'Thanachak', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1737, 'Baliapal', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1738, 'Bamur', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1739, 'Boinda', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1740, 'Rafukana', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1741, 'Khairaput', 'Khairaput-Malkangiri', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1742, 'Guma', 'Gumma', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1743, 'Chandahandi', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1744, 'Haladiagada', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1745, 'Nalco Colony', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1746, 'FCI', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1747, 'Samal', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1748, 'Khamar', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1749, 'Remuli', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1750, 'Gopili', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1751, 'Gurandi', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1752, 'Garabandha', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1753, 'Adaspur', '', '0000-00-00 00:00:00', '2021-02-04 05:08:21', '', 2),
(1754, 'Niali', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1755, 'Mathili', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1756, 'Udaypur-Balasore', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1757, 'Chitrada-Baripada', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1758, 'AmardaRoad-Baripada', 'Amarda Road', '0000-00-00 00:00:00', '2021-02-06 06:39:33', '', 1),
(1759, 'GandhiChhak-Balasore', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1760, 'Kansabahal', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1761, 'Tirupati', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1762, 'Padmapur-Gunupur', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1764, 'Tusura-Balangir', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1765, 'Gudvela', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1766, 'Jamut', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1767, 'Khuntigora', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1768, 'Saraipali-Chhattisgarh', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1769, 'Basna-Chhattisgarh', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1770, 'Sankara-Chhattisgarh', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1771, 'Pithora-Chhattisgarh', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1772, 'Jhalap-Chhattisgarh', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1773, 'Patewa-Chhattisgarh', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1774, 'Arang-Chhattisgarh', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(1775, 'DumaDuma', 'DumDum', '2021-02-10 12:04:15', '2021-02-10 12:04:24', 'Admin', 1),
(1776, 'demo_datas', NULL, '2021-02-25 13:46:10', '2021-02-25 13:46:18', 'Admin', 0),
(1777, 'chandrakanta', NULL, '2021-02-27 06:15:15', '2021-02-27 06:15:15', 'Admin', 0),
(1778, 'Rourkela 12', 'RKL12', '2021-02-27 06:39:20', '2021-02-27 06:41:20', 'Admin', 1),
(1779, 'Demo 001', NULL, '2021-03-13 07:19:59', '2021-03-13 07:20:15', 'Admin', 1),
(1780, 'fffff', 'holi', '2021-04-10 14:20:58', '2021-04-10 14:20:58', 'admin', 0),
(1781, 'fffff', 'holi', '2021-04-12 05:40:56', '2021-04-12 05:40:56', 'admin', 0),
(1782, 'examp2', 'fty', '2021-05-08 09:33:35', '2021-05-08 10:01:40', 'admin', 0);

-- --------------------------------------------------------

--
-- Table structure for table `locationcode`
--

CREATE TABLE `locationcode` (
  `id` int UNSIGNED NOT NULL,
  `location_id` int UNSIGNED NOT NULL,
  `type` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '0-Odbus 1- red bus 2-dolphin 3-bus india',
  `providerid` varchar(254) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `locationcode`
--

INSERT INTO `locationcode` (`id`, `location_id`, `type`, `providerid`, `created_at`, `updated_at`, `created_by`, `status`) VALUES
(1, 1291, 1, '501', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(2, 1292, 1, '502', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(3, 1293, 1, '516', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(4, 1294, 1, '541', '2017-10-05 13:01:12', '2018-09-17 12:18:41', '', 1),
(5, 1295, 1, '2567', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(6, 1297, 1, '28689', '2017-10-05 13:01:12', '2018-09-17 12:18:40', '', 1),
(7, 1300, 1, '2569', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(8, 1301, 1, '2566', '2017-10-05 13:01:12', '2018-09-17 12:18:40', '', 1),
(9, 1302, 1, '2568', '2017-10-05 13:01:12', '2018-09-17 12:18:41', '', 1),
(10, 1303, 1, '504', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(11, 1304, 1, '1308', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(12, 1305, 1, '1121', '2017-10-05 13:01:12', '2018-09-17 12:18:41', '', 1),
(13, 1309, 1, '544', '2017-10-05 13:01:12', '2018-09-17 12:18:41', '', 1),
(14, 1313, 1, '511', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(15, 1318, 1, '27301', '2017-10-05 13:01:12', '2018-09-17 12:18:41', '', 1),
(16, 1320, 1, '27442', '2017-10-05 13:01:12', '2018-09-17 12:18:41', '', 1),
(17, 1325, 1, '534', '2017-10-05 13:01:12', '2018-09-17 12:18:40', '', 1),
(18, 1335, 1, '27300', '2017-10-05 13:01:12', '2018-09-17 12:18:40', '', 1),
(19, 1337, 1, '24707', '2017-10-05 13:01:12', '2018-09-17 12:18:41', '', 1),
(20, 1345, 1, '503', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(21, 1350, 1, '24744', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(22, 1351, 1, '25305', '2017-10-05 13:01:12', '2018-09-17 12:18:41', '', 1),
(23, 1352, 1, '500', '2017-10-05 13:01:12', '2018-09-17 12:18:40', '', 1),
(24, 1368, 1, '3941', '2017-10-05 13:01:12', '2018-09-17 12:18:41', '', 1),
(25, 1369, 1, '25307', '2017-10-05 13:01:12', '2018-09-17 12:18:41', '', 1),
(26, 1376, 1, '25285', '2017-10-05 13:01:12', '2018-09-17 12:18:40', '', 1),
(27, 1381, 1, '540', '2017-10-05 13:01:12', '2018-09-17 12:18:41', '', 1),
(28, 1384, 1, '24748', '2017-10-05 13:01:12', '2018-09-17 12:18:41', '', 1),
(29, 1386, 1, '537', '2017-10-05 13:01:12', '0000-00-00 00:00:00', '', 1),
(30, 1387, 1, '539', '2017-10-05 13:01:12', '2018-09-17 12:18:41', '', 1),
(31, 1392, 1, '1896', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(32, 1394, 1, '523', '2017-10-05 13:01:12', '2018-09-17 12:18:41', '', 1),
(33, 1404, 1, '530', '2017-10-05 13:01:12', '2018-09-17 12:18:41', '', 1),
(34, 1407, 1, '1118', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(35, 1408, 1, '1116', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(36, 1413, 1, '1401', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(37, 1418, 1, '25230', '2017-10-05 13:01:12', '2018-09-17 12:18:41', '', 1),
(38, 1424, 1, '3945', '2017-10-05 13:01:12', '2018-09-17 12:18:41', '', 1),
(39, 1436, 1, '535', '2017-10-05 13:01:12', '2018-09-17 12:18:41', '', 1),
(40, 1504, 1, '546', '2019-03-18 11:20:12', '0000-00-00 00:00:00', '', 1),
(41, 1506, 0, '1062', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(42, 1507, 1, '26251', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(43, 1508, 1, '1060', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(44, 1509, 1, '1402', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(45, 1511, 1, '27096', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(46, 1518, 1, '1158', '2017-10-05 13:01:12', '2018-09-17 12:18:41', '', 1),
(47, 1534, 1, '1199', '2019-03-18 11:19:35', '2018-09-17 12:18:41', '', 0),
(48, 1546, 1, '27766', '2017-10-05 13:01:12', '2018-09-17 12:18:41', '', 1),
(49, 1559, 1, '27328', '0000-00-00 00:00:00', '2018-09-17 12:18:41', '', 1),
(50, 1577, 1, '2414', '2018-03-01 13:03:25', '2018-09-17 12:18:41', '', 1),
(51, 1602, 1, '1890', '0000-00-00 00:00:00', '2018-09-17 12:18:41', '', 1),
(52, 1603, 1, '26254', '0000-00-00 00:00:00', '2018-09-17 12:18:41', '', 1),
(53, 1617, 0, '6', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(54, 1618, 0, '3', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(55, 1626, 0, '11', '2018-11-10 13:01:12', '2018-11-10 13:01:12', '', 1),
(56, 1627, 0, '17', '2018-11-10 13:01:12', '2018-11-10 13:01:12', '', 1),
(57, 1628, 1, '27299', '2018-11-10 13:01:12', '2018-11-10 13:01:12', '', 1),
(58, 1629, 0, '102', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(59, 1630, 0, '109', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(60, 1631, 1, '104', '2017-10-05 13:01:12', '2018-09-19 11:12:29', '', 1),
(61, 1661, 1, '1293', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1),
(62, 1780, 4, '122', '2021-04-10 14:20:58', '2021-04-10 14:20:58', 'admin', 0),
(63, 1780, 5, '123', '2021-04-10 14:20:58', '2021-04-10 14:20:58', 'admin', 0),
(64, 1781, 4, '122', '2021-04-12 05:40:57', '2021-04-12 05:40:57', 'admin', 0),
(65, 1781, 5, '123', '2021-04-12 05:40:57', '2021-04-12 05:40:57', 'admin', 0);

-- --------------------------------------------------------

--
-- Table structure for table `owner_fare`
--

CREATE TABLE `owner_fare` (
  `id` int UNSIGNED NOT NULL,
  `bus_operator_id` int DEFAULT NULL,
  `source_id` int DEFAULT NULL,
  `destination_id` int DEFAULT NULL,
  `date` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `seater_price` double NOT NULL,
  `sleeper_price` double NOT NULL,
  `reason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `owner_fare`
--

INSERT INTO `owner_fare` (`id`, `bus_operator_id`, `source_id`, `destination_id`, `date`, `seater_price`, `sleeper_price`, `reason`, `created_at`, `updated_at`, `created_by`, `status`) VALUES
(1, 1, NULL, NULL, '2021-03-30', 44, 55, 'null', '2021-03-30 08:03:58', '2021-04-03 06:41:55', 'Admin', 2),
(3, 1, NULL, NULL, '2021-03-31', 66, 99, 'mmm', '2021-03-31 03:24:51', '2021-04-03 01:35:53', 'Admin', 2),
(5, 1, NULL, NULL, '2021-04-02', 1, 2, 'null', '2021-04-02 12:11:34', '2021-04-02 12:11:34', 'Admin', 0),
(6, 1, NULL, NULL, '2021-04-12', 555, 777, 'null', '2021-04-03 01:34:23', '2021-04-03 01:34:23', 'Admin', 0),
(7, NULL, 1291, 1304, '2021-04-06', 333, 444, 'null', '2021-04-06 08:46:27', '2021-04-06 08:46:27', 'Admin', 0),
(8, NULL, 1291, 1304, '2021-04-28', 333, 444, 'null', '2021-04-06 08:47:25', '2021-04-06 08:47:25', 'Admin', 0),
(9, 1, NULL, NULL, '2021-04-30', 111, 222, 'null', '2021-04-06 08:57:42', '2021-04-06 08:57:42', 'Admin', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pre_booking`
--

CREATE TABLE `pre_booking` (
  `id` int UNSIGNED NOT NULL,
  `transaction_id` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int NOT NULL,
  `bus_id` int UNSIGNED NOT NULL,
  `j_day` int NOT NULL DEFAULT '0' COMMENT 'journey day | 0-same day 1-nxt day',
  `journey_dt` date NOT NULL,
  `bus_info` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'json data',
  `customer_info` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'json data',
  `total_fare` double(8,2) UNSIGNED NOT NULL,
  `is_coupon` int NOT NULL DEFAULT '0' COMMENT '0-no 1-yes',
  `coupon_code` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coupon_discount` decimal(9,2) DEFAULT NULL,
  `discounted_fare` decimal(9,2) DEFAULT NULL,
  `customer_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pre_booking_detail`
--

CREATE TABLE `pre_booking_detail` (
  `id` int NOT NULL,
  `pre_booking_id` int UNSIGNED NOT NULL,
  `journey_date` date NOT NULL,
  `j_day` int NOT NULL DEFAULT '0' COMMENT 'journey day | 0-same day 1-nxt day',
  `bus_id` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `seat_name` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reason`
--

CREATE TABLE `reason` (
  `id` int NOT NULL,
  `name` varchar(254) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `id` int UNSIGNED NOT NULL,
  `pnr` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bus_id` int UNSIGNED NOT NULL,
  `customer_id` int NOT NULL,
  `reference_key` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'link for email',
  `rating_overall` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'out of 5',
  `rating_comfort` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'out of 5',
  `rating_clean` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'out of 5',
  `rating_behavior` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'out of 5',
  `rating_timing` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'out of 5',
  `comments` varchar(2500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `safety`
--

CREATE TABLE `safety` (
  `id` int NOT NULL,
  `name` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` mediumblob,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seats`
--

CREATE TABLE `seats` (
  `id` int NOT NULL,
  `bus_seat_layout_id` int UNSIGNED NOT NULL,
  `seat_class_id` int NOT NULL,
  `berthType` enum('1','2') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1=Lower Berth\r\n2=Upper Berth',
  `seatText` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rowNumber` int NOT NULL,
  `colNumber` int NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `seats`
--

INSERT INTO `seats` (`id`, `bus_seat_layout_id`, `seat_class_id`, `berthType`, `seatText`, `rowNumber`, `colNumber`, `created_at`, `updated_at`, `created_by`, `status`) VALUES
(1, 1, 1, '1', 'ST1', 1, 1, '2021-06-07 12:36:11', '2021-06-07 12:36:11', 'ADMIN', 1),
(2, 1, 1, '1', 'ST2', 1, 2, '2021-06-07 12:36:11', '2021-06-07 12:36:11', 'ADMIN', 1),
(3, 1, 3, '1', 'st', 1, 3, '2021-06-07 12:36:11', '2021-06-07 12:36:11', 'ADMIN', 1),
(4, 1, 1, '1', 'ST3', 1, 4, '2021-06-07 12:36:11', '2021-06-07 12:36:11', 'ADMIN', 1),
(5, 1, 1, '1', 'ST4', 1, 5, '2021-06-07 12:36:11', '2021-06-07 12:36:11', 'ADMIN', 1),
(6, 1, 2, '1', 'ST5', 2, 1, '2021-06-07 12:36:11', '2021-06-07 12:36:11', 'ADMIN', 1),
(7, 1, 1, '1', 'ST6', 2, 2, '2021-06-07 12:36:11', '2021-06-07 12:36:11', 'ADMIN', 1),
(8, 1, 3, '1', 'vip', 2, 3, '2021-06-07 12:36:11', '2021-06-07 12:36:11', 'ADMIN', 1),
(9, 1, 1, '1', 'ST7', 2, 4, '2021-06-07 12:36:11', '2021-06-07 12:36:11', 'ADMIN', 1),
(10, 1, 1, '1', 'ST8', 2, 5, '2021-06-08 14:43:54', '2021-06-08 14:43:54', 'admin', 1),
(11, 1, 2, '2', 'SL1', 1, 1, '2021-06-08 14:44:49', '2021-06-08 14:44:49', 'admin', 1),
(12, 1, 2, '2', 'SL2', 1, 2, '2021-06-08 14:48:34', '2021-06-08 14:48:34', 'admin', 1),
(13, 4, 2, '2', 'SL3', 1, 3, '2021-06-08 14:48:34', '2021-06-08 14:48:34', 'admin', 1),
(14, 1, 2, '2', 'SL4', 1, 4, '2021-06-08 14:48:34', '2021-06-08 14:48:34', 'admin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `seat_class`
--

CREATE TABLE `seat_class` (
  `id` int NOT NULL,
  `name` varchar(120) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `seat_class`
--

INSERT INTO `seat_class` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'seater', '2021-06-16 06:06:03', '2021-06-16 06:06:03'),
(2, 'sleeper', '2021-06-16 06:06:29', '2021-06-16 06:06:29'),
(3, 'vertical Sleeper', '2021-06-16 06:06:29', '2021-06-16 06:06:29'),
(4, 'blanck', '2021-06-16 06:12:11', '2021-06-16 06:12:11');

-- --------------------------------------------------------

--
-- Table structure for table `site_master`
--

CREATE TABLE `site_master` (
  `id` int UNSIGNED NOT NULL,
  `site_live` int UNSIGNED NOT NULL DEFAULT '0',
  `live_at` datetime NOT NULL,
  `extra_price` double(8,2) UNSIGNED NOT NULL,
  `calender_days` int UNSIGNED NOT NULL,
  `service_charge` int UNSIGNED NOT NULL,
  `per_trasaction` double(8,2) UNSIGNED NOT NULL,
  `max_seat_booked` int UNSIGNED NOT NULL,
  `support_email` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `booking_email` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `request_email` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `other_email` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_no1` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_no2` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_no3` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_no4` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `facebook_url` varchar(254) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `twitter_url` varchar(254) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `linkedin_url` varchar(254) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `instagram_url` varchar(254) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `googleplus_url` varchar(254) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `min_fare_amt` int NOT NULL,
  `earned_pts` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE `slider` (
  `id` int UNSIGNED NOT NULL,
  `occassion` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` int DEFAULT NULL COMMENT '0-main slider 1-adv-slider1 2-adv-slider 2, 3-adv-slider-3',
  `url` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slider_img` varchar(254) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alt_tag` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `special_fare`
--

CREATE TABLE `special_fare` (
  `id` int UNSIGNED NOT NULL,
  `bus_operator_id` int DEFAULT NULL,
  `source_id` int UNSIGNED DEFAULT NULL,
  `destination_id` int UNSIGNED DEFAULT NULL,
  `date` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `seater_price` double(8,2) NOT NULL,
  `sleeper_price` double(8,2) NOT NULL,
  `reason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `special_fare`
--

INSERT INTO `special_fare` (`id`, `bus_operator_id`, `source_id`, `destination_id`, `date`, `seater_price`, `sleeper_price`, `reason`, `created_at`, `updated_at`, `created_by`, `status`) VALUES
(1, 1, NULL, NULL, 'check', 40.00, 60.00, 'null', '2021-05-08 11:21:04', '2021-05-08 11:21:04', 'Admin', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ticket_cancelation`
--

CREATE TABLE `ticket_cancelation` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ticket_cancelation`
--

INSERT INTO `ticket_cancelation` (`id`, `name`, `created_at`, `updated_at`, `created_by`, `status`) VALUES
(1, 'Master Rule', '2020-11-01 13:17:28', '2020-11-01 13:17:28', 'Admin ', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ticket_cancelation_rule`
--

CREATE TABLE `ticket_cancelation_rule` (
  `id` int UNSIGNED NOT NULL,
  `ticket_cancelation_id` int UNSIGNED NOT NULL,
  `hour_lag_start` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hour_lag_end` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cancelation_percentage` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ticket_cancelation_rule`
--

INSERT INTO `ticket_cancelation_rule` (`id`, `ticket_cancelation_id`, `hour_lag_start`, `hour_lag_end`, `cancelation_percentage`, `created_at`, `updated_at`, `created_by`, `status`) VALUES
(1, 1, '0', '11', '100', '2020-11-01 14:08:00', '2020-11-01 14:08:00', 'Admin ', 1),
(2, 1, '12', '18', '35', '2020-11-01 14:08:00', '2020-11-01 14:08:00', 'Admin ', 1),
(3, 1, '19', '24', '25', '2020-11-01 14:08:00', '2020-11-01 14:08:00', 'Admin ', 1),
(4, 1, '25', '999', '20', '2020-11-01 14:08:00', '2020-11-01 14:08:00', 'Admin ', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ticket_price`
--

CREATE TABLE `ticket_price` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `bus_operator_id` int NOT NULL,
  `bus_id` int UNSIGNED NOT NULL,
  `source_id` int UNSIGNED NOT NULL,
  `destination_id` int UNSIGNED NOT NULL,
  `base_seat_fare` double(8,2) UNSIGNED NOT NULL,
  `base_sleeper_fare` double(8,2) UNSIGNED NOT NULL,
  `dep_time` datetime DEFAULT NULL,
  `arr_time` timestamp NULL DEFAULT NULL,
  `start_j_days` int NOT NULL DEFAULT '0',
  `j_day` int NOT NULL DEFAULT '0' COMMENT '0-same day 1- next day so on.. ',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ticket_price`
--

INSERT INTO `ticket_price` (`id`, `user_id`, `bus_operator_id`, `bus_id`, `source_id`, `destination_id`, `base_seat_fare`, `base_sleeper_fare`, `dep_time`, `arr_time`, `start_j_days`, `j_day`, `created_at`, `updated_at`, `created_by`, `status`) VALUES
(1, 1, 1, 1, 1291, 1294, 320.00, 450.00, '2021-06-04 22:00:00', '2021-06-05 10:02:15', 0, 1, '2021-03-24 06:55:16', '2021-03-24 06:55:16', 'Admin', 0),
(2, 1, 1, 2, 1291, 1301, 340.00, 470.00, '2021-06-04 20:00:00', '2021-06-04 02:30:00', 0, 1, '2021-03-24 06:55:17', '2021-03-24 08:19:09', 'Admin', 0),
(3, 1, 1, 3, 1291, 1303, 360.00, 490.00, '2021-06-04 20:00:00', '2021-06-04 01:30:00', 0, 1, '2021-03-27 07:52:07', '2021-03-27 07:52:07', 'Admin', 0),
(4, 1, 1, 4, 1291, 1294, 380.00, 500.00, '2021-06-04 21:00:00', '2021-06-04 03:30:00', 0, 1, '2021-03-27 07:52:07', '2021-03-27 07:52:07', 'Admin', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `user_pin` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `middle_name` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumbnail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `org_name` varchar(254) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(600) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alternate_phone` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'additional phone',
  `alternate_email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'additional email',
  `password` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_role` int DEFAULT NULL,
  `rand_key` varchar(254) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_login` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `user_pin`, `first_name`, `middle_name`, `last_name`, `thumbnail`, `email`, `location`, `org_name`, `address`, `phone`, `alternate_phone`, `alternate_email`, `password`, `user_role`, `rand_key`, `last_login`, `created_at`, `updated_at`, `created_by`, `status`) VALUES
(1, '756051', 'Arun', 'Kumar ', 'Lakhani', 'nopic.jpg', 'jagakalia@gmail.com', 'Bhadrak', 'Jagakalia', 'Bhadrak', '9040799050', NULL, NULL, 'Admin@2020', 1, 'sdfwegtb55rety43563456', '2020-11-01 14:12:29', '2020-11-01 14:12:29', '2020-11-01 14:12:29', 'Admin ', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_bank_details`
--

CREATE TABLE `user_bank_details` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `banking_name` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ifsc_code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_number` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `amenities`
--
ALTER TABLE `amenities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appdownload`
--
ALTER TABLE `appdownload`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appversion`
--
ALTER TABLE `appversion`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `boarding_droping`
--
ALTER TABLE `boarding_droping`
  ADD PRIMARY KEY (`id`),
  ADD KEY `location_id` (`location_id`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bus_id` (`bus_id`),
  ADD KEY `user_id` (`bus_operator_id`),
  ADD KEY `booking_customer_id` (`booking_customer_id`);

--
-- Indexes for table `booking_customer`
--
ALTER TABLE `booking_customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking_detail`
--
ALTER TABLE `booking_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `bus`
--
ALTER TABLE `bus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bus_operator_FK` (`bus_operator_id`),
  ADD KEY `bus_type_fk` (`bus_type_id`),
  ADD KEY `bus_sitting_fk` (`bus_sitting_id`),
  ADD KEY `cancellation_slab_fk` (`cancellationslabs_id`),
  ADD KEY `bus_seatlayout_id_fk` (`bus_seat_layout_id`);

--
-- Indexes for table `bus_amenities`
--
ALTER TABLE `bus_amenities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bus_id` (`bus_id`),
  ADD KEY `amenities_id` (`amenities_id`);

--
-- Indexes for table `bus_cancelled`
--
ALTER TABLE `bus_cancelled`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bus_id` (`bus_id`),
  ADD KEY `bus_operator_for_cancelled_FK` (`bus_operator_id`);

--
-- Indexes for table `bus_cancelled_date`
--
ALTER TABLE `bus_cancelled_date`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bus_cancelled_id` (`bus_cancelled_id`);

--
-- Indexes for table `bus_class`
--
ALTER TABLE `bus_class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bus_closing_hours`
--
ALTER TABLE `bus_closing_hours`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bus_contacts`
--
ALTER TABLE `bus_contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bus_id` (`bus_id`);

--
-- Indexes for table `bus_extra_fare`
--
ALTER TABLE `bus_extra_fare`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bus_id` (`bus_id`);

--
-- Indexes for table `bus_gallery`
--
ALTER TABLE `bus_gallery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bus_id` (`bus_id`);

--
-- Indexes for table `bus_operator`
--
ALTER TABLE `bus_operator`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bus_owner_fare`
--
ALTER TABLE `bus_owner_fare`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bus_id` (`bus_id`),
  ADD KEY `owner_fare_id` (`owner_fare_id`);

--
-- Indexes for table `bus_safety`
--
ALTER TABLE `bus_safety`
  ADD PRIMARY KEY (`id`),
  ADD KEY `safety_bus_id_fk` (`bus_id`),
  ADD KEY `safety_id_fk` (`safety_id`);

--
-- Indexes for table `bus_schedule`
--
ALTER TABLE `bus_schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bus_id` (`bus_id`);

--
-- Indexes for table `bus_schedule_date`
--
ALTER TABLE `bus_schedule_date`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bus_schedule_id` (`bus_schedule_id`);

--
-- Indexes for table `bus_seats`
--
ALTER TABLE `bus_seats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bus_seats_ibfk_1` (`bus_id`),
  ADD KEY `ticket_price_FK` (`ticket_price_id`),
  ADD KEY `seats_id_fk` (`seats_id`);

--
-- Indexes for table `bus_seats_extra`
--
ALTER TABLE `bus_seats_extra`
  ADD KEY `bus_id` (`bus_id`);

--
-- Indexes for table `bus_seat_layout`
--
ALTER TABLE `bus_seat_layout`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bus_sitting`
--
ALTER TABLE `bus_sitting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bus_slots`
--
ALTER TABLE `bus_slots`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bus_id` (`bus_id`);

--
-- Indexes for table `bus_special_fare`
--
ALTER TABLE `bus_special_fare`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bus_id` (`bus_id`),
  ADD KEY `special_fare_id` (`special_fare_id`);

--
-- Indexes for table `bus_stoppage_additional_fare`
--
ALTER TABLE `bus_stoppage_additional_fare`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bus_stoppage_id` (`ticket_price_id`),
  ADD KEY `bus_seats_id` (`bus_seats_id`);

--
-- Indexes for table `bus_stoppage_timing`
--
ALTER TABLE `bus_stoppage_timing`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stoppage_timing_bus_id_fk` (`bus_id`),
  ADD KEY `location_timing_fk` (`location_id`),
  ADD KEY `boardin_droping_id_fk` (`boarding_droping_id`);

--
-- Indexes for table `bus_type`
--
ALTER TABLE `bus_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_type_fk` (`bus_class_id`);

--
-- Indexes for table `cancellationslabs`
--
ALTER TABLE `cancellationslabs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `city_closing`
--
ALTER TABLE `city_closing`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bus_id` (`bus_id`),
  ADD KEY `location_closing_ibfk_1` (`location_id`);

--
-- Indexes for table `city_closing_extended`
--
ALTER TABLE `city_closing_extended`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bus_id` (`bus_id`),
  ADD KEY `city_closing_extended_location_fk` (`location_id`);

--
-- Indexes for table `coupon`
--
ALTER TABLE `coupon`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupon_assigned_bus`
--
ALTER TABLE `coupon_assigned_bus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bus_id` (`bus_id`),
  ADD KEY `coupon_assigned_id_fk` (`coupon_id`);

--
-- Indexes for table `customer_query`
--
ALTER TABLE `customer_query`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_query_category`
--
ALTER TABLE `customer_query_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_query_category_issues`
--
ALTER TABLE `customer_query_category_issues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_query_category_id` (`customer_query_category_id`);

--
-- Indexes for table `custom_pages`
--
ALTER TABLE `custom_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `extended_bus_closing_hours`
--
ALTER TABLE `extended_bus_closing_hours`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locationcode`
--
ALTER TABLE `locationcode`
  ADD PRIMARY KEY (`id`),
  ADD KEY `location_id` (`location_id`);

--
-- Indexes for table `owner_fare`
--
ALTER TABLE `owner_fare`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pre_booking`
--
ALTER TABLE `pre_booking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bus_id` (`bus_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pre_booking_detail`
--
ALTER TABLE `pre_booking_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pre_booking_id` (`pre_booking_id`);

--
-- Indexes for table `reason`
--
ALTER TABLE `reason`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bus_id` (`bus_id`);

--
-- Indexes for table `safety`
--
ALTER TABLE `safety`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seats_ibfk_1` (`bus_seat_layout_id`),
  ADD KEY `seats_ibfk_12` (`seat_class_id`);

--
-- Indexes for table `seat_class`
--
ALTER TABLE `seat_class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_master`
--
ALTER TABLE `site_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `special_fare`
--
ALTER TABLE `special_fare`
  ADD PRIMARY KEY (`id`),
  ADD KEY `special_fare_operator_fk` (`bus_operator_id`),
  ADD KEY `special_fare_source_fk` (`source_id`),
  ADD KEY `special_fare_destination_fk` (`destination_id`);

--
-- Indexes for table `ticket_cancelation`
--
ALTER TABLE `ticket_cancelation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket_cancelation_rule`
--
ALTER TABLE `ticket_cancelation_rule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_cancelation_id` (`ticket_cancelation_id`);

--
-- Indexes for table `ticket_price`
--
ALTER TABLE `ticket_price`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `bus_id` (`bus_id`),
  ADD KEY `ticket_price_bus_operator_fk` (`bus_operator_id`),
  ADD KEY `ticket_price_source_fk` (`source_id`),
  ADD KEY `ticket_price_destination_fk` (`destination_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_bank_details`
--
ALTER TABLE `user_bank_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `amenities`
--
ALTER TABLE `amenities`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `appdownload`
--
ALTER TABLE `appdownload`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `appversion`
--
ALTER TABLE `appversion`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `boarding_droping`
--
ALTER TABLE `boarding_droping`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `booking_customer`
--
ALTER TABLE `booking_customer`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bus`
--
ALTER TABLE `bus`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bus_amenities`
--
ALTER TABLE `bus_amenities`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `bus_cancelled`
--
ALTER TABLE `bus_cancelled`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bus_cancelled_date`
--
ALTER TABLE `bus_cancelled_date`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bus_class`
--
ALTER TABLE `bus_class`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bus_closing_hours`
--
ALTER TABLE `bus_closing_hours`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bus_contacts`
--
ALTER TABLE `bus_contacts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bus_extra_fare`
--
ALTER TABLE `bus_extra_fare`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bus_gallery`
--
ALTER TABLE `bus_gallery`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bus_operator`
--
ALTER TABLE `bus_operator`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `bus_owner_fare`
--
ALTER TABLE `bus_owner_fare`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bus_safety`
--
ALTER TABLE `bus_safety`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bus_schedule`
--
ALTER TABLE `bus_schedule`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bus_schedule_date`
--
ALTER TABLE `bus_schedule_date`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `bus_seats`
--
ALTER TABLE `bus_seats`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `bus_seat_layout`
--
ALTER TABLE `bus_seat_layout`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `bus_sitting`
--
ALTER TABLE `bus_sitting`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `bus_slots`
--
ALTER TABLE `bus_slots`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bus_special_fare`
--
ALTER TABLE `bus_special_fare`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bus_stoppage_additional_fare`
--
ALTER TABLE `bus_stoppage_additional_fare`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bus_stoppage_timing`
--
ALTER TABLE `bus_stoppage_timing`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `bus_type`
--
ALTER TABLE `bus_type`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=339;

--
-- AUTO_INCREMENT for table `cancellationslabs`
--
ALTER TABLE `cancellationslabs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `city_closing`
--
ALTER TABLE `city_closing`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `city_closing_extended`
--
ALTER TABLE `city_closing_extended`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupon`
--
ALTER TABLE `coupon`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupon_assigned_bus`
--
ALTER TABLE `coupon_assigned_bus`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_query`
--
ALTER TABLE `customer_query`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_query_category`
--
ALTER TABLE `customer_query_category`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_query_category_issues`
--
ALTER TABLE `customer_query_category_issues`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `custom_pages`
--
ALTER TABLE `custom_pages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `extended_bus_closing_hours`
--
ALTER TABLE `extended_bus_closing_hours`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1783;

--
-- AUTO_INCREMENT for table `locationcode`
--
ALTER TABLE `locationcode`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `owner_fare`
--
ALTER TABLE `owner_fare`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pre_booking`
--
ALTER TABLE `pre_booking`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pre_booking_detail`
--
ALTER TABLE `pre_booking_detail`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reason`
--
ALTER TABLE `reason`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `safety`
--
ALTER TABLE `safety`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `seats`
--
ALTER TABLE `seats`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `seat_class`
--
ALTER TABLE `seat_class`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `site_master`
--
ALTER TABLE `site_master`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `special_fare`
--
ALTER TABLE `special_fare`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ticket_cancelation`
--
ALTER TABLE `ticket_cancelation`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ticket_cancelation_rule`
--
ALTER TABLE `ticket_cancelation_rule`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ticket_price`
--
ALTER TABLE `ticket_price`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_bank_details`
--
ALTER TABLE `user_bank_details`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `boarding_droping`
--
ALTER TABLE `boarding_droping`
  ADD CONSTRAINT `boarding_droping_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `location` (`id`);

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`bus_id`) REFERENCES `bus` (`id`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`bus_operator_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `booking_ibfk_3` FOREIGN KEY (`booking_customer_id`) REFERENCES `booking_customer` (`id`),
  ADD CONSTRAINT `booking_ibfk_4` FOREIGN KEY (`booking_customer_id`) REFERENCES `booking_customer` (`id`);

--
-- Constraints for table `bus`
--
ALTER TABLE `bus`
  ADD CONSTRAINT `bus_operator_FK` FOREIGN KEY (`bus_operator_id`) REFERENCES `bus_operator` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `bus_seatlayout_id_fk` FOREIGN KEY (`bus_seat_layout_id`) REFERENCES `bus_seat_layout` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `bus_sitting_fk` FOREIGN KEY (`bus_sitting_id`) REFERENCES `bus_sitting` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `bus_type_id_fk` FOREIGN KEY (`bus_type_id`) REFERENCES `bus_type` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `cancellation_slab_fk` FOREIGN KEY (`cancellationslabs_id`) REFERENCES `cancellationslabs` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `bus_amenities`
--
ALTER TABLE `bus_amenities`
  ADD CONSTRAINT `bus_amenities_ibfk_1` FOREIGN KEY (`bus_id`) REFERENCES `bus` (`id`),
  ADD CONSTRAINT `bus_amenities_ibfk_2` FOREIGN KEY (`amenities_id`) REFERENCES `amenities` (`id`);

--
-- Constraints for table `bus_cancelled`
--
ALTER TABLE `bus_cancelled`
  ADD CONSTRAINT `bus_operator_for_cancelled_FK` FOREIGN KEY (`bus_operator_id`) REFERENCES `bus_operator` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `bus_cancelled_date`
--
ALTER TABLE `bus_cancelled_date`
  ADD CONSTRAINT `bus_cancelled_date_ibfk_1` FOREIGN KEY (`bus_cancelled_id`) REFERENCES `bus_cancelled` (`id`);

--
-- Constraints for table `bus_contacts`
--
ALTER TABLE `bus_contacts`
  ADD CONSTRAINT `bus_contacts_ibfk_1` FOREIGN KEY (`bus_id`) REFERENCES `bus` (`id`);

--
-- Constraints for table `bus_extra_fare`
--
ALTER TABLE `bus_extra_fare`
  ADD CONSTRAINT `bus_extra_fare_ibfk_1` FOREIGN KEY (`bus_id`) REFERENCES `bus` (`id`);

--
-- Constraints for table `bus_gallery`
--
ALTER TABLE `bus_gallery`
  ADD CONSTRAINT `bus_gallery_ibfk_1` FOREIGN KEY (`bus_id`) REFERENCES `bus` (`id`);

--
-- Constraints for table `bus_safety`
--
ALTER TABLE `bus_safety`
  ADD CONSTRAINT `safety_bus_id_fk` FOREIGN KEY (`bus_id`) REFERENCES `bus` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `safety_id_fk` FOREIGN KEY (`safety_id`) REFERENCES `safety` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `bus_schedule_date`
--
ALTER TABLE `bus_schedule_date`
  ADD CONSTRAINT `bus_schedule_date_ibfk_1` FOREIGN KEY (`bus_schedule_id`) REFERENCES `bus_schedule` (`id`);

--
-- Constraints for table `bus_seats`
--
ALTER TABLE `bus_seats`
  ADD CONSTRAINT `bus_seats_ibfk_1` FOREIGN KEY (`bus_id`) REFERENCES `bus` (`id`),
  ADD CONSTRAINT `seats_id_fk` FOREIGN KEY (`seats_id`) REFERENCES `seats` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `ticket_price_FK` FOREIGN KEY (`ticket_price_id`) REFERENCES `ticket_price` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `bus_seats_extra`
--
ALTER TABLE `bus_seats_extra`
  ADD CONSTRAINT `bus_seats_extra_ibfk_1` FOREIGN KEY (`bus_id`) REFERENCES `bus` (`id`);

--
-- Constraints for table `bus_slots`
--
ALTER TABLE `bus_slots`
  ADD CONSTRAINT `bus_slots_ibfk_1` FOREIGN KEY (`bus_id`) REFERENCES `bus` (`id`);

--
-- Constraints for table `bus_stoppage_additional_fare`
--
ALTER TABLE `bus_stoppage_additional_fare`
  ADD CONSTRAINT `bus_seats_id_fk` FOREIGN KEY (`bus_seats_id`) REFERENCES `bus_seats` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `bus_stoppage_additional_fare_ibfk_1` FOREIGN KEY (`ticket_price_id`) REFERENCES `ticket_price` (`id`);

--
-- Constraints for table `bus_stoppage_timing`
--
ALTER TABLE `bus_stoppage_timing`
  ADD CONSTRAINT `boardin_droping_id_fk` FOREIGN KEY (`boarding_droping_id`) REFERENCES `boarding_droping` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `location_timing_fk` FOREIGN KEY (`location_id`) REFERENCES `location` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `stoppage_timing_bus_id_fk` FOREIGN KEY (`bus_id`) REFERENCES `bus` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `bus_type`
--
ALTER TABLE `bus_type`
  ADD CONSTRAINT `class_type_fk` FOREIGN KEY (`bus_class_id`) REFERENCES `bus_class` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `city_closing`
--
ALTER TABLE `city_closing`
  ADD CONSTRAINT `city_closing_ibfk_1` FOREIGN KEY (`bus_id`) REFERENCES `bus` (`id`),
  ADD CONSTRAINT `location_closing_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `location` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `city_closing_extended`
--
ALTER TABLE `city_closing_extended`
  ADD CONSTRAINT `city_closing_extended_ibfk_1` FOREIGN KEY (`bus_id`) REFERENCES `bus` (`id`),
  ADD CONSTRAINT `city_closing_extended_location_fk` FOREIGN KEY (`location_id`) REFERENCES `location` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `coupon_assigned_bus`
--
ALTER TABLE `coupon_assigned_bus`
  ADD CONSTRAINT `coupon_assigned_bus_ibfk_1` FOREIGN KEY (`bus_id`) REFERENCES `bus` (`id`),
  ADD CONSTRAINT `coupon_assigned_id_fk` FOREIGN KEY (`coupon_id`) REFERENCES `coupon` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `customer_query_category_issues`
--
ALTER TABLE `customer_query_category_issues`
  ADD CONSTRAINT `customer_query_category_issues_ibfk_1` FOREIGN KEY (`customer_query_category_id`) REFERENCES `customer_query_category` (`id`);

--
-- Constraints for table `locationcode`
--
ALTER TABLE `locationcode`
  ADD CONSTRAINT `locationcode_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `location` (`id`);

--
-- Constraints for table `pre_booking`
--
ALTER TABLE `pre_booking`
  ADD CONSTRAINT `pre_booking_ibfk_1` FOREIGN KEY (`bus_id`) REFERENCES `bus` (`id`),
  ADD CONSTRAINT `pre_booking_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `pre_booking_detail`
--
ALTER TABLE `pre_booking_detail`
  ADD CONSTRAINT `pre_booking_detail_ibfk_1` FOREIGN KEY (`pre_booking_id`) REFERENCES `pre_booking` (`id`);

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`bus_id`) REFERENCES `bus` (`id`);

--
-- Constraints for table `seats`
--
ALTER TABLE `seats`
  ADD CONSTRAINT `seats_ibfk_1` FOREIGN KEY (`bus_seat_layout_id`) REFERENCES `bus_seat_layout` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `seats_ibfk_12` FOREIGN KEY (`seat_class_id`) REFERENCES `seat_class` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `special_fare`
--
ALTER TABLE `special_fare`
  ADD CONSTRAINT `special_fare_destination_fk` FOREIGN KEY (`destination_id`) REFERENCES `location` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `special_fare_operator_fk` FOREIGN KEY (`bus_operator_id`) REFERENCES `bus_operator` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `special_fare_source_fk` FOREIGN KEY (`source_id`) REFERENCES `location` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `ticket_cancelation_rule`
--
ALTER TABLE `ticket_cancelation_rule`
  ADD CONSTRAINT `ticket_cancelation_rule_ibfk_1` FOREIGN KEY (`ticket_cancelation_id`) REFERENCES `ticket_cancelation` (`id`);

--
-- Constraints for table `ticket_price`
--
ALTER TABLE `ticket_price`
  ADD CONSTRAINT `ticket_price_bus_operator_fk` FOREIGN KEY (`bus_operator_id`) REFERENCES `bus_operator` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `ticket_price_destination_fk` FOREIGN KEY (`destination_id`) REFERENCES `location` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `ticket_price_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `ticket_price_ibfk_2` FOREIGN KEY (`bus_id`) REFERENCES `bus` (`id`),
  ADD CONSTRAINT `ticket_price_source_fk` FOREIGN KEY (`source_id`) REFERENCES `location` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `user_bank_details`
--
ALTER TABLE `user_bank_details`
  ADD CONSTRAINT `user_bank_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
