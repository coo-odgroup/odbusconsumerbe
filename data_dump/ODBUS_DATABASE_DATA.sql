-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 12, 2021 at 07:36 AM
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
(1, 'tv', 0x6956424f5277304b47676f414141414e53556845556741414145414141414241434149414141416c432b614a41414141475852465748525462325a30643246795a5142425a4739695a53424a6257466e5a564a6c5957523563636c6c504141414157704a52454655654e72736d727471416b45556870316864334146556641534254734c6e30414c536232514e3944477774494873676f574e745a57415773723877517037455446474243454b4375344f524a525362774e47724e482f722b626859482f32334f5a67545043645630665a306b66637745414142664b2b4c48757644753174316d724e7839384c68644c623957334b555579494f325576357978636a48312f56467375744230345662616b305a3378754c4846394e57395445634e4d5561674e7a624c782b7649346452386d546a71765555576463412f587465376b6c6b6d477976496b42356e322b4f47586368716c7265625a5236446d3841367069387a3446442f623562654167703452327630667277394547324b33496656704a4243754575424141414141414141414141414141414141414141414141414141414141414141414141414143347256597a4d717332384e7049574338437959446b6e554a32797338626f4a79786541506b597171595a736c4174752f6c71554851464c526746416579536f61336a7a303259767a633572636d6a743441664f386339346830353942375a373647376f59723669707a614e7946764841583074316a5050662f314e4f346c44672f745a424341506948476b4145414c436a4c774547414c596b687754486e5a314d4141414141456c46546b5375516d4343, '2021-06-10 10:51:32', '2021-06-10 10:59:18', 'Admin', 'null', 1),
(2, 'wifi', 0x6956424f5277304b47676f414141414e5355684555674141414541414141424143414d414141436474344873414141416831424d5645582f2f2f2f392f762f362f6637322f5037792b7637762b6633742b50336e3976336a39507a67382f7a6338667a57372f76523766724a36766e4536506d2f357669773450656b322f61663266575a312f5750302f534a30664f467a2f4f417a664a39792f4a3379664677787646727866426e772f426376753557764f35517575314e7565314974757841744f77347365737872756f73712b6b6e71656b68702b6761704f67556f75634e6e2b59496e6559446d2b586f4c2b644b414141426b556c45515652343275335579354b434d42414630465a4251523779307143436f49684530762f2f66654e436b4943514944576247632b536f6d386c36553767362b7550307830535a30574a443257527863525a677a7a566a536c32304e685651634c6353526e32594b6b7a6832484c48635642644c6363576a73705561676b6654755a2b52536c55483847627867586c4a595a304f47584f454c70413038356458354a39353574614b717147626133547a76784a7755617443747962735361743770726b52747972687255544d70314f374c674c53746933466d6139646a656d30732f724b445836744463796c32767668396648784d6442756b4a316f344137515471674a4244582f587468504d4b4a4b7a4f56583037495a79426c466c5931664d4a586d7533586e536835654e55365358795769666a50656f37754e3570327877352b56626a667836307268724f6a3466736f375167724f633949517551594f62594b7a6442794330486236454c416c73554347445945515832494a33416b6d436a7136712b43524c577152636e3047445a654b7944357755345145575545433561765130623879394f6f445a30324c537146794d36764b45542b4965737147437369437a346a424c6a55367a414235514d61396b6e4354453278444361685a7a78357841684a344b78437551554d425a44446f4f3258772b597649584a687a69356a5a4d4861666f6f5437354d30362f7a6c365166656c6d6535374a4967373041414141415355564f524b35435949493d, '2021-06-10 10:52:20', '2021-06-10 10:59:12', 'Admin', 'null', 1),
(3, 'WIFI', 0x6956424f5277304b47676f414141414e5355684555674141414541414141424143414d414141436474344873414141416831424d5645582f2f2f2f392f762f362f6637322f5037792b7637762b6633742b50336e3976336a39507a67382f7a6338667a57372f76523766724a36766e4536506d2f357669773450656b322f61663266575a312f5750302f534a30664f467a2f4f417a664a39792f4a3379664677787646727866426e772f426376753557764f35517575314e7565314974757841744f77347365737872756f73712b6b6e71656b68702b6761704f67556f75634e6e2b59496e6559446d2b586f4c2b644b414141426b556c45515652343275335579354b434d42414630465a4251523779307143436f49684530762f2f66654e436b4943514944576247632b536f6d386c36553767362b7550307830535a30574a443257527863525a677a7a566a536c32304e685651634c6353526e32594b6b7a6832484c48635642644c6363576a73705561676b6654755a2b52536c55483847627867586c4a595a304f47584f454c70413038356458354a39353574614b717147626133547a76784a7755617443747962735361743770726b52747972687255544d70314f374c674c53746933466d6139646a656d30732f724b445836744463796c32767668396648784d6442756b4a316f344137515471674a4244582f587468504d4b4a4b7a4f56583037495a79426c466c5931664d4a586d7533586e536835654e55365358795769666a50656f37754e3570327877352b56626a667836307268724f6a3466736f375167724f633949517551594f62594b7a6442794330486236454c416c73554347445945515832494a33416b6d436a7136712b43524c577152636e3047445a654b7944357755345145575545433561765130623879394f6f445a30324c537146794d36764b45542b4965737147437369437a346a424c6a55367a414235514d61396b6e4354453278444361685a7a78357841684a344b78437551554d425a44446f4f3258772b597649584a687a69356a5a4d4861666f6f5437354d30362f7a6c365166656c6d6535374a4967373041414141415355564f524b35435949493d, '2021-06-10 10:58:21', '2021-06-10 10:59:07', 'Admin', 'null', 1),
(4, 'Fan', 0x6956424f5277304b47676f414141414e5355684555674141414541414141424143414d41414143647434487341414141636c424d5645582f2f2f2f392f762f362f6637792b7637762b6633742b50336a39507a67382f7a6338667a57372f76523766724e362f724a36766e4536506d2f35766934342f69773450656f3350616b322f615a312f563379664677787646727866426e772f426a7765394e7565314974757841744f77347365737872756f73712b6b6e71656b68702b6761704f67556f75634e6e2b59496e6559446d2b567a756630744141414230556c45515652343273325832354b434d41794741785952564f5367466c42775166722b72376a547941785941734b47326647374b675039535a4d305457454d2f366c365048315953713765794745707a627441413074524267494d766c33674b4530426559445a5746476843497249676c6b454f4a32554f4d4a6e4e6c4a4e4944667741652b686b49455650776f70505a6a6b39457267657a434967684f2b4e4a386e6d4344452f4b746a4d6f7857556d4e4f6868502f782f6d333756676575486455474c5842512f7454617a79523742525834593334763952767a394f5a654e626a4278304c69662f2f6c4d706f6779537a4639317674395a63545947302f617431303038426b622b4639722f625a59504a6f3133355673656947475a317044394b41446e554f4b57533864353139374773384c467574314f73487949774b5470647238627069513074646c4b68516d76445458384b4267663952666861503971664f64444479587265442f54593346666161575533564e4a5970495578756e6257646f48773830594e794b79426b7a4d316f4d6c39725039444b6763474f4a557977664d695677514a4543534b494965474d734147417073796f51464b56674c4a52524751416a4751684c4d46396b43796d793367416f6e34507748324574684f58424a4766694b7855356d396d646a6257534f456b4c72674f454b546a6865555643426c4f317931704c474c4b6c6e574c2b464f694631346f6372362b67634c2b326a6a4836373834353364595042624848365478572f7a2b49306d7639586c4e39737274507638433863615635357645474266504e6c58582f626c753339654e506b6635732f6c463273762f6679696c6f5a4e4141414141456c46546b5375516d4343, '2021-06-10 10:58:54', '2021-06-10 10:59:01', 'Admin', 'null', 1);

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
(6, 1294, 'Hirakud', '2020-11-04 02:37:10', '2020-11-05 02:37:10', 'Admin', 1),
(9, 1345, 'Bus stand', '2021-06-11 15:14:51', '2021-06-11 15:14:51', 'Admin', 0),
(10, 1345, 'Atharanala', '2021-06-11 15:14:51', '2021-06-11 15:14:51', 'Admin', 0),
(11, 1292, 'Badambadi', '2021-06-11 15:15:36', '2021-06-11 15:15:36', 'Admin', 0),
(12, 1292, 'Link road', '2021-06-11 15:15:36', '2021-06-11 15:15:36', 'Admin', 0),
(13, 1292, 'OMP', '2021-06-11 15:15:36', '2021-06-11 15:15:36', 'Admin', 0),
(14, 1292, 'Jagtpur', '2021-06-11 15:15:36', '2021-06-11 15:15:36', 'Admin', 0),
(15, 1292, 'Manguli', '2021-06-11 15:15:36', '2021-06-11 15:15:36', 'Admin', 0),
(16, 1297, 'Bus stand', '2021-06-11 15:16:56', '2021-06-11 15:16:56', 'Admin', 0),
(17, 1297, 'New Bazar', '2021-06-11 15:16:56', '2021-06-11 15:16:56', 'Admin', 0);

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
(1, 1, 2, 'Khambeswari', 'Anugul', 'OD A 1808', NULL, 315, 3, 7, 6, 0, NULL, NULL, 0, NULL, NULL, '2021-06-11 15:23:50', '2021-06-11 15:29:48', 'Admin', 1, 1000),
(2, 1, 2, 'Jagakalia', 'Anugul', 'OD B 8657', NULL, 316, 3, 4, 6, 0, NULL, NULL, 0, NULL, NULL, '2021-06-11 15:38:37', '2021-06-11 15:43:21', 'Admin', 1, 1000),
(3, 1, 5, 'Sonax', 'Anugul', 'OD B 3456', NULL, 316, 1, 6, 6, 2, NULL, NULL, 0, NULL, NULL, '2021-06-11 15:43:18', '2021-06-11 15:55:17', 'Admin', 1, 1000);

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
(1, 1, 1, '2021-06-11 15:23:50', '2021-06-11 15:23:50', 'Admin', 1),
(2, 1, 2, '2021-06-11 15:23:50', '2021-06-11 15:23:50', 'Admin', 1),
(3, 2, 2, '2021-06-11 15:38:37', '2021-06-11 15:38:37', 'Admin', 1),
(4, 2, 4, '2021-06-11 15:38:37', '2021-06-11 15:38:37', 'Admin', 1),
(5, 3, 4, '2021-06-11 15:43:18', '2021-06-11 15:43:18', 'Admin', 1),
(6, 3, 1, '2021-06-11 15:43:18', '2021-06-11 15:43:18', 'Admin', 1);

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

--
-- Dumping data for table `bus_contacts`
--

INSERT INTO `bus_contacts` (`id`, `bus_id`, `type`, `phone`, `booking_sms_send`, `cancel_sms_send`, `created_at`, `updated_at`, `created_by`, `status`) VALUES
(1, 1, 2, '2345678767', 1, 1, '2021-06-11 15:23:50', '2021-06-11 15:23:50', 'Admin', 1),
(2, 1, 1, '3498765432', 1, 1, '2021-06-11 15:23:50', '2021-06-11 15:23:50', 'Admin', 1),
(3, 1, 0, '1234567898', 1, 1, '2021-06-11 15:23:50', '2021-06-11 15:23:50', 'Admin', 1),
(4, 2, 2, '2345678987', 1, 1, '2021-06-11 15:38:37', '2021-06-11 15:38:37', 'Admin', 1),
(5, 2, 1, '4356767898', 1, 1, '2021-06-11 15:38:37', '2021-06-11 15:38:37', 'Admin', 1),
(6, 2, 0, '3423456789', 1, 1, '2021-06-11 15:38:37', '2021-06-11 15:38:37', 'Admin', 1),
(7, 3, 2, '3434565676', 1, 1, '2021-06-11 15:43:18', '2021-06-11 15:43:18', 'Admin', 1),
(8, 3, 1, '6767656545', 1, 1, '2021-06-11 15:43:18', '2021-06-11 15:43:18', 'Admin', 1),
(9, 3, 0, '4567898765', 1, 1, '2021-06-11 15:43:18', '2021-06-11 15:43:18', 'Admin', 1);

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

--
-- Dumping data for table `bus_safety`
--

INSERT INTO `bus_safety` (`id`, `bus_id`, `safety_id`, `created_at`, `updated_at`, `created_by`) VALUES
(1, 1, 1, '2021-06-11 15:23:50', '2021-06-11 15:23:50', 'Admin'),
(2, 1, 2, '2021-06-11 15:23:50', '2021-06-11 15:23:50', 'Admin'),
(3, 2, 2, '2021-06-11 15:38:37', '2021-06-11 15:38:37', 'Admin'),
(4, 2, 3, '2021-06-11 15:38:37', '2021-06-11 15:38:37', 'Admin'),
(5, 2, 1, '2021-06-11 15:38:37', '2021-06-11 15:38:37', 'Admin'),
(6, 3, 1, '2021-06-11 15:43:18', '2021-06-11 15:43:18', 'Admin'),
(7, 3, 2, '2021-06-11 15:43:18', '2021-06-11 15:43:18', 'Admin');

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
(2, 2, '2021-05-31 08:42:06', '2021-05-31 08:42:06', 'admin', 0),
(4, 3, '2021-06-11 15:55:17', '2021-06-11 15:55:17', 'Admin', 0);

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
(60, 2, '2021-08-03', 'admin', '2021-05-31 08:42:06', '2021-05-31 08:42:06', 1),
(61, 4, '2021-05-08', 'Admin', '2021-06-11 15:55:17', '2021-06-11 15:55:17', 1),
(62, 4, '2021-05-10', 'Admin', '2021-06-11 15:55:17', '2021-06-11 15:55:17', 1),
(63, 4, '2021-05-12', 'Admin', '2021-06-11 15:55:18', '2021-06-11 15:55:18', 1),
(64, 4, '2021-05-14', 'Admin', '2021-06-11 15:55:18', '2021-06-11 15:55:18', 1),
(65, 4, '2021-05-16', 'Admin', '2021-06-11 15:55:18', '2021-06-11 15:55:18', 1),
(66, 4, '2021-05-18', 'Admin', '2021-06-11 15:55:18', '2021-06-11 15:55:18', 1),
(67, 4, '2021-05-20', 'Admin', '2021-06-11 15:55:18', '2021-06-11 15:55:18', 1),
(68, 4, '2021-05-22', 'Admin', '2021-06-11 15:55:18', '2021-06-11 15:55:18', 1),
(69, 4, '2021-05-24', 'Admin', '2021-06-11 15:55:18', '2021-06-11 15:55:18', 1),
(70, 4, '2021-05-26', 'Admin', '2021-06-11 15:55:18', '2021-06-11 15:55:18', 1),
(71, 4, '2021-05-28', 'Admin', '2021-06-11 15:55:18', '2021-06-11 15:55:18', 1),
(72, 4, '2021-05-30', 'Admin', '2021-06-11 15:55:18', '2021-06-11 15:55:18', 1),
(73, 4, '2021-06-01', 'Admin', '2021-06-11 15:55:18', '2021-06-11 15:55:18', 1),
(74, 4, '2021-06-03', 'Admin', '2021-06-11 15:55:18', '2021-06-11 15:55:18', 1),
(75, 4, '2021-06-05', 'Admin', '2021-06-11 15:55:18', '2021-06-11 15:55:18', 1),
(76, 4, '2021-06-07', 'Admin', '2021-06-11 15:55:18', '2021-06-11 15:55:18', 1),
(77, 4, '2021-06-09', 'Admin', '2021-06-11 15:55:18', '2021-06-11 15:55:18', 1),
(78, 4, '2021-06-11', 'Admin', '2021-06-11 15:55:18', '2021-06-11 15:55:18', 1),
(79, 4, '2021-06-13', 'Admin', '2021-06-11 15:55:18', '2021-06-11 15:55:18', 1),
(80, 4, '2021-06-15', 'Admin', '2021-06-11 15:55:18', '2021-06-11 15:55:18', 1),
(81, 4, '2021-06-17', 'Admin', '2021-06-11 15:55:18', '2021-06-11 15:55:18', 1),
(82, 4, '2021-06-19', 'Admin', '2021-06-11 15:55:18', '2021-06-11 15:55:18', 1),
(83, 4, '2021-06-21', 'Admin', '2021-06-11 15:55:18', '2021-06-11 15:55:18', 1),
(84, 4, '2021-06-23', 'Admin', '2021-06-11 15:55:18', '2021-06-11 15:55:18', 1),
(85, 4, '2021-06-25', 'Admin', '2021-06-11 15:55:18', '2021-06-11 15:55:18', 1),
(86, 4, '2021-06-27', 'Admin', '2021-06-11 15:55:18', '2021-06-11 15:55:18', 1),
(87, 4, '2021-06-29', 'Admin', '2021-06-11 15:55:18', '2021-06-11 15:55:18', 1),
(88, 4, '2021-07-01', 'Admin', '2021-06-11 15:55:18', '2021-06-11 15:55:18', 1),
(89, 4, '2021-07-03', 'Admin', '2021-06-11 15:55:18', '2021-06-11 15:55:18', 1),
(90, 4, '2021-07-05', 'Admin', '2021-06-11 15:55:18', '2021-06-11 15:55:18', 1);

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
(1, 1, 1, 31, 0, 0, '0', 0.00, '2021-06-11 15:23:51', '2021-06-11 15:23:51', 'Admin', 0),
(2, 1, 1, 36, 0, 0, '0', 0.00, '2021-06-11 15:23:51', '2021-06-11 15:23:51', 'Admin', 0),
(3, 1, 1, 37, 0, 0, '0', 0.00, '2021-06-11 15:23:52', '2021-06-11 15:23:52', 'Admin', 0),
(4, 1, 1, 39, 0, 0, '0', 0.00, '2021-06-11 15:23:52', '2021-06-11 15:23:52', 'Admin', 0),
(5, 1, 1, 40, 0, 0, '0', 0.00, '2021-06-11 15:23:52', '2021-06-11 15:23:52', 'Admin', 0),
(6, 1, 1, 42, 0, 0, '0', 0.00, '2021-06-11 15:23:53', '2021-06-11 15:23:53', 'Admin', 0),
(7, 1, 1, 43, 0, 0, '0', 0.00, '2021-06-11 15:23:53', '2021-06-11 15:23:53', 'Admin', 0),
(8, 1, 1, 45, 0, 0, '0', 0.00, '2021-06-11 15:23:54', '2021-06-11 15:23:54', 'Admin', 0),
(9, 1, 1, 46, 0, 0, '0', 0.00, '2021-06-11 15:23:54', '2021-06-11 15:23:54', 'Admin', 0),
(10, 1, 1, 48, 0, 0, '0', 0.00, '2021-06-11 15:23:54', '2021-06-11 15:23:54', 'Admin', 0),
(11, 1, 1, 49, 0, 0, '0', 0.00, '2021-06-11 15:23:54', '2021-06-11 15:23:54', 'Admin', 0),
(12, 1, 1, 54, 0, 0, '0', 0.00, '2021-06-11 15:23:54', '2021-06-11 15:23:54', 'Admin', 0),
(13, 1, 1, 56, 0, 0, '0', 0.00, '2021-06-11 15:23:54', '2021-06-11 15:23:54', 'Admin', 0),
(14, 1, 1, 57, 0, 0, '0', 0.00, '2021-06-11 15:23:54', '2021-06-11 15:23:54', 'Admin', 0),
(15, 1, 1, 60, 0, 0, '0', 0.00, '2021-06-11 15:23:54', '2021-06-11 15:23:54', 'Admin', 0),
(16, 1, 1, 61, 0, 0, '0', 0.00, '2021-06-11 15:23:54', '2021-06-11 15:23:54', 'Admin', 0),
(17, 2, 2, 1, 0, 0, '0', 0.00, '2021-06-11 15:38:37', '2021-06-11 15:38:37', 'Admin', 0),
(18, 2, 2, 5, 0, 0, '0', 0.00, '2021-06-11 15:38:37', '2021-06-11 15:38:37', 'Admin', 0),
(19, 2, 2, 6, 0, 0, '0', 0.00, '2021-06-11 15:38:37', '2021-06-11 15:38:37', 'Admin', 0),
(20, 2, 2, 8, 0, 0, '0', 0.00, '2021-06-11 15:38:37', '2021-06-11 15:38:37', 'Admin', 0),
(21, 2, 2, 10, 0, 0, '0', 0.00, '2021-06-11 15:38:37', '2021-06-11 15:38:37', 'Admin', 0),
(22, 2, 2, 11, 0, 0, '0', 0.00, '2021-06-11 15:38:37', '2021-06-11 15:38:37', 'Admin', 0),
(23, 2, 2, 13, 0, 0, '0', 0.00, '2021-06-11 15:38:37', '2021-06-11 15:38:37', 'Admin', 0),
(24, 2, 2, 15, 0, 0, '0', 0.00, '2021-06-11 15:38:37', '2021-06-11 15:38:37', 'Admin', 0),
(25, 2, 2, 16, 0, 0, '0', 0.00, '2021-06-11 15:38:37', '2021-06-11 15:38:37', 'Admin', 0),
(26, 2, 2, 20, 0, 0, '0', 0.00, '2021-06-11 15:38:37', '2021-06-11 15:38:37', 'Admin', 0),
(27, 3, 3, 21, 0, 0, '0', 0.00, '2021-06-11 15:43:18', '2021-06-11 15:43:18', 'Admin', 0),
(28, 3, 3, 23, 0, 0, '0', 0.00, '2021-06-11 15:43:18', '2021-06-11 15:43:18', 'Admin', 0),
(29, 3, 3, 25, 0, 0, '0', 0.00, '2021-06-11 15:43:18', '2021-06-11 15:43:18', 'Admin', 0),
(30, 3, 3, 26, 0, 0, '0', 0.00, '2021-06-11 15:43:18', '2021-06-11 15:43:18', 'Admin', 0),
(31, 3, 3, 30, 0, 0, '0', 0.00, '2021-06-11 15:43:18', '2021-06-11 15:43:18', 'Admin', 0);

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
(4, '20 Seater', '2021-06-08 10:49:10', '2021-06-08 14:02:19', 'Admin', 1),
(6, '10 Sleepers', '2021-06-08 13:57:45', '2021-06-08 14:02:18', 'Admin', 1),
(7, '24 Seaters 8 Sleepers', '2021-06-08 14:00:34', '2021-06-08 14:02:16', 'Admin', 1);

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
(1, 1, 1291, 1, 'null', '20:00:00', '2021-06-11 15:23:50', '2021-06-11 15:23:50', 'Admin', 0),
(2, 1, 1291, 4, 'null', '20:40:00', '2021-06-11 15:23:50', '2021-06-11 15:23:50', 'Admin', 0),
(3, 1, 1294, 5, 'null', '07:00:00', '2021-06-11 15:23:51', '2021-06-11 15:23:51', 'Admin', 0),
(4, 2, 1291, 1, 'Null', '21:00:00', '2021-06-11 15:38:37', '2021-06-11 15:38:37', 'Admin', 0),
(5, 2, 1291, 2, 'Null', '21:20:00', '2021-06-11 15:38:37', '2021-06-11 15:38:37', 'Admin', 0),
(6, 2, 1291, 4, 'Null', '21:40:00', '2021-06-11 15:38:37', '2021-06-11 15:38:37', 'Admin', 0),
(7, 2, 1294, 5, 'Null', '06:00:00', '2021-06-11 15:38:37', '2021-06-11 15:38:37', 'Admin', 0),
(8, 2, 1294, 6, 'Null', '06:30:00', '2021-06-11 15:38:37', '2021-06-11 15:38:37', 'Admin', 0),
(9, 3, 1291, 1, 'Null', '22:00:00', '2021-06-11 15:43:18', '2021-06-11 15:43:18', 'Admin', 0),
(10, 3, 1291, 3, 'Null', '22:30:00', '2021-06-11 15:43:18', '2021-06-11 15:43:18', 'Admin', 0),
(11, 3, 1294, 5, 'Null', '05:00:00', '2021-06-11 15:43:18', '2021-06-11 15:43:18', 'Admin', 0);

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
-- Table structure for table `customer_notification`
--

CREATE TABLE `customer_notification` (
  `id` int NOT NULL,
  `sender` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `receiver` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `contents` varchar(120) NOT NULL,
  `channel_type` int DEFAULT NULL COMMENT 'channel | 0-sms 1-email',
  `acknowledgement` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customer_notification`
--

INSERT INTO `customer_notification` (`id`, `sender`, `receiver`, `contents`, `channel_type`, `acknowledgement`, `created_at`, `updated_at`) VALUES
(1, 'odbus', '9437112909', 'hello', 0, '0', '2021-06-11 04:48:58', '2021-06-11 04:48:58'),
(2, 'swagatikasahu.seofied@gmail.com', 'testing', 'sahu.swagatika@gmail.com', 1, '0', '2021-06-11 06:17:09', '2021-06-11 06:17:09'),
(3, 'odbus', '9437112909', 'hello', 0, '0', '2021-06-11 07:07:42', '2021-06-11 07:07:42'),
(4, 'odbus', '9437112909', 'hello', 0, '0', '2021-06-11 16:05:14', '2021-06-11 16:05:14');

-- --------------------------------------------------------

--
-- Table structure for table `customer_payment`
--

CREATE TABLE `customer_payment` (
  `id` int NOT NULL,
  `sender` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `amount` int NOT NULL,
  `contents` text NOT NULL,
  `acknowledgement` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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

--
-- Dumping data for table `safety`
--

INSERT INTO `safety` (`id`, `name`, `icon`, `created_at`, `updated_at`, `created_by`, `status`) VALUES
(1, 'staff with mask', 0x2f396a2f3277424441414d4341674d4341674d4441774d4541774d45425167464251514542516f484277594944416f4d4441734b4377734e44684951445134524467734c4542595145524d55465255564441385847425955474249554652542f3277424441514d454241554542516b4642516b554451734e464251554642515546425155464251554642515546425155464251554642515546425155464251554642515546425155464251554642515546425155464251554642542f7741415243414559415959444153494141684542417845422f3851414867414241414d4141674d424151414141414141414141414141634943515547415149454177722f784142584541414241774d43417751454242414943776b41414141424141494442415547427845494569454a457a464246434a525952555a4d6e455746786734516c4a5756336142677047556c62545349324a796b715778302b4d6b4a544d3351314e5564485768305363355932527a6f374c4478502f454142734241514143417745424141414141414141414141414141414442414543427755472f3851414d7845424141454341775147434163414141414141414141414145434177514645524d6851564547456859786f644555556c4e686359475238534979516c53787765482f3267414d41774541416845444551412f414e55305245424552415245514552454245524152455145524542455241524551455245424552415245514552454245524152455145524542455241524551455245424552415245514552454245524152455145524542455241524551455245424552415245514552454245524152455145524542455241524551455245424552415245514552454245524152455145524542455241524551455245424552415245514552454245524152455145524542455241524551455245424552415245514552454245524152455145524542455241524551455245424552415245514552454245524152455145524542455241524551455245424552415245514552454245524152455145524542455241524551455245424552415245514552563734304f4c3278634a476d76777455787833544b626c7a7757537a4f667436524b414f6153546271496d62677549366b6c7252735862674a533152316977765258484833334e386b6f4d62746733445a6132585a307268396a477762756b642f465943666371555a333230476c6c6a7135494d5978584938706247647653704246517750384165336e4c6e37664f774b714f682f43317242326b476256476f2b6f4f51314e73785238726f2f686d7069356a4b31727574505151626872574e4f344c756a41642f6c7544677447644e4f7a63304130316f49596d344c545a4e574d4144362f4a486d756c6b50744c586252742f4a59454658666a777250393653752f58386639676e7834566e2b394a5866722b5038417346656e366b3752623731474766714b6d2f6354366b3752623731474766714b6d2f635155572b5043732f33704b373966782f3243664868576637306c642b76342f374258702b704f30572b3952686e3669707633452b704f30572b3952686e366970763345464c38623762624371757261322b3662332b3230784f7a706143756771334e48743558434c2b74573930473478644a2b49396f6877764b6f4b69374276504a5a6131707071356748696536663165423575595841653166466c7641726f486d6c452b6d72394b386367446d376437626154304b567676443453776a38366f547853646c4265394d49704d35304d75317a7559747a765333574b61582f474e50792b747a306b374f55794675323459646e394f6a6e6e6f673174525a36646e4832686c54724a55513659616d565447357a444752624c744941773356724153364b5164414b686f424f34323577443044676562517441524551455245424552415245514552454245524152455145524542455241524551455245424552415245514552454245524152455145524542455241524551654364677352736a6258397042326855746f64565466515a5356556c4f783062756c505a36527835334d2b31644d346b372f414730773969324a316c76452b4f36525a7664615a785a5555466a7271714e773851356c4f39772f35674c4d54735138666771737a31557672326731564a623643696a6566454e6d6b6c652f3835685a2b5a4271316a654e327a454c4262374a5a61474332576d33774d7071576a706d6373634d545273316a523541414c6b6c304c57765844442b48334136764c73317572625a616f4349324e614f6561706c49504c4643776458764f78366551424a49414a476375586474314f4c73396d4d3658526d324e507153336937466b386a66615752734c574833637a766e5161726f73384e494f325a3037797572676f3839786935344e4a4a7333345170705068476a61666134746132526f2b5a6a6c657641395363573151734d5636784c494c646b64716b384b7132314c5a6d412b78334b66565074447469504d494f7949767a6b714934596e53506b61794e674c6e5063646d7441385354354b7275754861546148364a4f6e6f354d6b2b69362b526267327a4741327263313373664c75496d646645462b343969433079384562685a61316e6267517476415a533652537674676341585458344e6e63506279694174423932352b64585334584f4d2f547a69767445373858713571432f5562412b74782b3542724b7542752b334f4143524a48763035326b37626a6d44535145476576617038506a3942745738613173774d4f736a4c7a586839552b6b39515574326a2f6857547432477737304e4c6950746f336e374a6164634f477230477647683247353343317362377a623253314554506b78564464325473487562493134487541554a3971646a63462f344b6332714a57683074716d6f612b427848795869716a6a4a48354d72782b4e644f37486139545850684d714b5356786379323548573030515067316a6d51793744387152782f4767764d6949674969494349694169496749694943496941694967496949434969416949674969494349694169496749694943496941694967496949434969416949676a2f4149685038776d7058344d3350396c6b57644859646e616f31692f6b576a2f3953305834685038414d4a71562b444e7a2f5a5a466d31324c463168734e733179756451646f4b4b6a746c54496634724731626a2f414d6767364e78783562662b4d766a7074476a755056726d32697a563473564b4f726f343539673675716e4e48695742726d2f795966655671447050776f3656364e346653592f6a2b475767785252426b316257555563395656753236766d6c6530756353657533674e3967414e67737975794e7363757050466a6d6d66584d643755304e737161336e493349717179634175333976495a682b4e624a494b756133646d356f66725442504d63586a772b3976423562726a41625275447661364944756e396648646d2f76436f746c505a61635165682b51793366534c4d6d58686f4a37716f746478665a37687476767339726e42682f4649642f59467359694447476f344c4f4e6a58517374756333793555397263655633305335534a615944326d47463868642f4e566a6444657876774c45784258616c3332737a697562733432326935714733745073504b65396b2b666d59443971744541415041624c796769696e34543947615447704c4244706469624c564a475933772f4245424c67664d764c65666d2f6a62372b395a4e63574f6a4e33374f54696678584f644f4b696f677871746b6458326d4f57527a2b374c43425530456a7a3165777465414365705a494e7953336462654b6b48612b5948466c4843624c664f363571724772785356724a5150576248493430377838783731685038414a4344735848546d3975314b374f624d637274442b38746c3673397475464f536479475356644d38412b386237483367726f6e59782f577535422b4656562b7a3079686a4463316c793773574d78705a704f396b734d7874504d54313557334b6e6c5950784e6d61506d436d6673592f725863672f4371712f5a365a426668455241524551455245424552415245514552454245524152455145524542455241524551455245424552415245514552454245524152455145524542455877582b2f572f46724a58336937566b4e76746442412b717171756f64797877784d61585065342b5141424b447033454a2f6d45314b2f426d352f7373697967374d2b3476745044397859316b665353484649337449386a364c58624b587466653243776a496363792f454d57776d37336d333353335664726a764e5a564d6f326b79784f6a457259655637693331747748467049385146412f5a6638534f6d57685662714c5974543677322b32355a42523073636c525276714b523747436473724a7555456872684d4231615152767551676d7673504c577a30665636346b44764f61315534507532715866394671636f6e34637450744973457775575852326b736b574f58536630715371737456365648504a74734e355339784f7736427050713951414f716c684152455145524542562b342f4c4f4c3577636172307a6d38775a5a5a4b72623377765a4b502f41494b774b2b4739326167794b7a317471756c4a4458323275676654564e4a554d4434356f6e744c587363302b49494a42434446666838757a70757936346b625958457470727851564162374f386c70422f3841557266646a483961376b48345656583750544c705847726d33446e6f4c77723668614e6163316c6d742b5233755343513261797666575364383270686538314532377777686b5a4161392b343641425674344a4f306174334352705a58596257594c5635492b73764574794e5a42636d552f49313863544f554d4d6274794f374a3333486967322f5251647773385832433857654d316c78785753706f726e6269787477733178613174545463322f4b373153577659375a327a6d6e79494942364b635542455241524551455245424552415245514552454245524152455145524542455241524551455245424552415245514552454245524152455146584c74456262637272775836707732726e394a6262575450456669595935346e7a6669377472392f64757247723437766161532f57717474747770325664425751767036696e6b47375a5933744c58745075494a4834304758765a4661583653367036555a74426b3246342f6b3257554e334866793369686971354730636b4c65354442494479743532546238753235485879566939594f7974304c314e7070704c525a4a3843753768757973783655736935764c6d703338305a487561476e33685a2f322b71795473744f4e61654f65477172384a7243574862663841786a614a5837746533794d304a412f4c6a49384839645062547836364e582f567a48744f72586b7a726c65723754777a5556565330376e30626e5452393546455a66735a484e493958626f54796b683352426d766e504272784a38435638714d763030766c64664c464365386d75574e6878643359362f3458517535755a766954306b6150456b4b7976436c3275654e3573794777617852553248337472646d582b6d447667367049482b6b62316441382f6c4d4a3336743642614c535061794d766351316f47354a4f7748765742504552563250693034316278426746706f624e6a303156364b613233514e6a6255525137392f58764452735850504d516468754f3733366b6c5a6a656a75334b4c4e465679756449694e5a612b66563638506e333263622f53542b366e316576443539396e472f306b2f75724d6a347637442f4c4a372f74373251667570385839682f3354332f38416d51667571545a31506d4f302b572b7650306c7076395872772b66665a7876394a50377166563638506e333263622f53542b36737950692f73503841756e762f41504d672f6454347637442f414c70372f77447a49503355326452326e793331352b6b744763353752375144433858727276466e39426b4d314f7a654f3257556d657171486554574e3241487a75494138797336382f347275497a74424d7471634f3030744e665a63596565575331574f557874624354734856316165586f65767137735966414e6366474c654950672b70644c7345646b6d4f334f3433614b6b6c41723461786a4e34346e644249336b486b3759486679634435466162646c627176696d6f50444e51576179576d3357472b343038554e356f36434952392f4952764856753236754d72523163642f575938654143306d6d615a306c376d4378316a483274726835316a585244756748597a34315a71616e754f726551545a46586b427a724a59337570364f4d2b62587a454353543532695038414772563362684d3464644d7450377a56562b6c32493074677439464c55316c545632364f61566b4d624335376a4e4a752f634148727a6237726c6549506a443031345a4c746a74747a6d3531564c5633787a6a41796b70485439314531776136615862354c415841655a505859485971682f616a63613065637a66534c3033716e58566b39524848666136334579656c5338774d644443572f4c39626c4c3976453872504a7757712b3656324e5673724b2f69567a693757794f536c78366e734573637352635842706c716f6a4178783879417835362f616c624a4b736e5a2b384b2f314c656831505158534f4d356c665874754e376b59642b376b35646f3663487a455453523743357a794f6843733267496949434969416949674969494349694169496749694943496941694967496949434969416949674969494349694169496749694943496941694967676e6a42345438653473394d4a4d6675546d32362b30526455576138745a7a506f35794e694350463054396748743877415231614373596446745073683465654f6e547646387a6f5461377861737374384d374f626d593972356d426b6a4865446d4f613845483248794f3458394369787837584779314f6e50466a676d65306a5377566c747061686b6d336a55556453642f77417a58516f4c63647158784f2f534f304b6669746d724f3579334d6d79554d4a6a64732b6d6f674e716d626f6477534349326e32764a4879565450676d30682b677a42483558634965533733396f4d49634f73564744757765376e50722f414442696a484d637775584837786656742f72593534635668634f3770704431704c5843375a6b58546f48794f505862374b52783841727058433532334737634a363271704c5651526373516b714a5777784d386d74426351423741465061702f564c6e7653724d4a7070707746727671337a384f45664f642f33527a726e7841573351706c6d64636252563355584d7a426e6f737247636e6438752b2f4e343738342f4d6f702b4d457872376b62762b6c772f39464d4759564f6b326f4970426b6c77786539436b357534465863596a33664e747a626253447835522b5a64622b6c39772b66374468583666482f617157657472756c38746849792b697a5454696350585658786d4e644f2f64786a67364838594a6a5833493366394c682f364c326937514447705a574d47493363467a6733633155506d647659753966532b3466503968777239506a2f414c5665573442772f4d63484e6f634c4467647752587839502f64575078383176584b5032747a367a35706b754e7670727662366d68725947564e4856524f686d676b47375a474f477a6d6e357753465458516e556134634150462f4636624e4d2f444b3577704b383745696f746b72743254416562346e414f2b646a322f5a4b3274767a37474c7457785564446b646f724b7555387363465058785353504f322b776148456e6f44344b4a654c375237365a6d6e4c727062344f39763968612b70674452753661446265574c3339427a67653170483253563039614e595264483866566c324c6931653355563770313454776e2b76732b58746e6235543376577654756e6f4a6d566a446a5171596e774f3577397331544a79467533694347626a6278335667757a69374f77365243693150314c6f57757a57526e6557717a54414f4670613466355754794e515165672f30594a2b7950713574364c31475138513345446f336a46357133584e7448553236785537704275593766444f5a65516e7a44474754385141386c2f526d337756523255384635524542455241524551455245424552415245514552454245524152455145524542455241524551455245424552415245514552454245524152455145524542555537587a527554554468777063746f6f444e634d4e7268567635527537304f62614b6662356e6479382b35685636317865553431627379787536324737307a617931584f6c6c6f36756e66345352534e4c48742f474355474d6e414e545752756d31376d6f322f343964636553344f66747a6367627641422f46324c2f7741726d557961326159665467302f71735a2b456667727635345a765365353733626b64767479387738666e56565937586465413769767665483543365632505353436e66556c76536f6f4875357161726235457438397641695276697278517a5231454d6373556a4a59704768374a4933637a584e493342424869434343437264457856546f34376e396d2f674d79394b706e383039616d666648443566786f70783858675075362f6f722b39543476416664312f52583936726c4973374f6e6b70396f3830397234552b536d767865412b37722b69763731506938423933583946663371755569624f6e6b646f3830397234552b53734f6c5042594e4d7451724a6c41793734522b445a6a4c364c38486433336d37484e323575384f3379742f412b4373446d2b5855654134666438697279425332326d64554f61543874774871734876633474622b4e63367156636165727375573336693079787a764b31304e537731374b5946377036736e6c69703267654a615864523973344478616b365555376a445269756b474e6f707631646254766e5349307069666434652b556c396a2f704c4e6e33454e66384155697470574d6f635a704a444357523752697471755a6f613065414459752b4f77384e32725a7051427750634f45664448772f5750474b6d4f503649717665355875566d7835717951446d594435694e6f5a47506279452b616e39553362596a534e494552455a455245424552415245514552454245524152455145524542455241524551455245424552415245514552454245524152455145524542455241524551455245476666624936593243383642326e4e3571514e7957793353436970713250594f64547a383350452f375a7537577548734f2b3369643646634c484662486864505459666d56513734436165536775627433476933502b546b387a46374434732f6b2b476b486139665767315038417832672f726b56642b474c674b776a697a34486355754d7a6a6a656330315463597158494b57494f4d6a525653637364524830373167386a75484e386a7475447454564e4d3677382f4859477a6d466d624e2b4e336a453834535a5331554e645377314e4e4e485555387a512b4f614a346579527038433177364565384c3956536a4d3947654a5067637271687237665756654b736558656e554d5a75466f6c4832784732384a50385952752b64653169375171344d69597938595a53565575337253304661364948386c375837666e566d4c6c4d39376c2b4b364c59367a564f7730726a34365438346e7a6c64564143534142755434414b6e4e783751787259534b4842694a54344f71376c366f2f45324d452f6e585661505550582f697a726e324443624658793063783775576e78326d64464330482f5831546a367266627a506150636b334b595259666f786d463672533554464563356d4a384931537a784c63574e4667644856343169465848585a504944464e585175443472643548592b4470665950427669657652644e374b624862666c66475261703731534e754d3976743962636f445662754c4b706f61477939664677353345452b42362b4942567875446a736f3750706458322f4d64563561584a736d7033746e704c46423639766f6e676768306849486676423874677748796630497278326359323752624c2f414f52666632674b7656564e5537335473747979786c6c725a3274387a337a786e2f4f554e6d6b52466f3963524551455245424552415245514552454245524152455145524542455241524551455245424552415245514552454245524152455145524542455241524551455263566b2b56326243724856336d2f33576a737470704738383964587a7468686962375850635141677033327658316f4e542f7832672f726b584c646b39395a5a69762b2f7742782f616e716f666152646f50676d752b42793661594853566435704758474772714d6a6d42677033474c6d325a444734633777533735627555644f676476757265646b39395a5a69762b2f3348397165677543356a587449634151527351664e52626d4843766f396e74513670762b6d654b334b72655358564d747068624b3766327661304f5035314b69494955736642546f526a315579706f394a7354457a447a4e6450624935396a377538356c4c39717331425971474b6974744654304648454e6f36656c69624647776535725141507a4c3745516572764438592f72574d2f5a79663934766c2f7744497676375146737737772f4750363167486f647848556e4331786c35526d31787373393974347546316f4b6d6d705a68484d324f576f6476497a6d477a6e4e355236704942396f3855472f794b4b4e42754b4c54666952736e702b445a4a543347646a513670746b3338445730762f71517539594466707a446470386e465374346f504b4969416949674969494349694169496749694943496941694967496949434969416949674969494349694169496749694943496941694967496938453744636f504b2f4373726165335573315456547830314e4377795354537644574d614275584f4a364141655a5652654a7a744e744c644166533752614b6b5a376d45573744624c524d3330656e65504b657036746273643932734433416a5967654b6f4455333369693754652b7670614f4b6169776873334b364b467a364778556d782f306a7a75366f65505a2f434f486b316f515847346d2b31737748533730757936627778366735497a654d3172486c6c7170336530796a317039765a4873302f6268552b7876526a69633753572f3032513556634b693359615a4f654334585672716132514e2f77444b5572646a4b64756e4d4231323264497277384d6e5a59615a364b6569586e4c6d5236695a5a487338533347414367706e2f774468557833446950747043343941514771363063544959327359304d593041427252734150594547642b6f505a4f5950695844446c397178476d71636c314f6453737171572b58416a765a5a595869517751786a3149684931726d41645865734e3346526c325550474a5973436f4b7252624f61746c696b6b72354b697831746165376a4d7368416c704a436467782f4f4335752f516c7a6d3767386f4f73436f647872396d425a4e66726e585a70674e565359726e4e51544c57553037534b433576383376355154464b664e375151342f4b62755335426641486465566958614e64754c376751354c4e6b74727564646a4e4965534b4449715a3178742f494f67454e58473764726476426f6b3248326f557759723233726d774e5a6b656c51664f506c54577139624e507a4d6b694a4838346f4e564557596c303762327778553776514e4b726c4e507430465665596f32372f6b784f4b694c4a2b314e34677463367032503659346c4259366d6f3956726244517933533464656e52376757742b63526a62326f4e474f4d50693878626854303571376a58316346586c74584139746c735458677a564d3278445875623474686165726e6e7030324737694173374f7a4e3450625a78497a35396e5770396b2b47735971346e32366b64556c38627036325351537a564554323746726f77414f5948786c493637454c6d39422b7931314c317279357562612f337575746c4e555343656f6f716974394b7539643747795345754544534f6e69584164413176516a562f44734f73756e2b4c327a4863647474505a374a62595730394a5255724f574f4a673867507a6b6b376b6b6b6b6b6b6c426b2f727832552b6f65693937475a364435445833706c45387a77554c616e3057383065332b716c6157746d32472f68794f50687975583263506e61323566707a6452694775396771376c364a4a36504e6436656d394875644b34644e71696e49613254627a493548653578577471687269443452394d754a69316d6e7a50486f70626b786e4a5433756a3268754650374f5759446367666150446d2b35423348536e5762437462735a6a762b44354851354662486242306c4b2f313458483747574d374f6a642f46654156335259783672646e31727677655a4e4a6e4f6a642b75575257796c33663658596434726c44474f706250536a63547339764c7a6737456c6a51706434614f3248704b6d576e782f5779306d313162584345354e61594847486d48516d6f706875356839726f39787639673142702b69345444733273476f5750556c39786d3855562b733955336d687272664f32614a2f77417a6d6b39523567395235726d30424552415245514552454245524152455145524542455241524551455245424552415245514552454245524152455145524542512f774157656b5753613661435a5068654a35434d617664796a6a6246575065396b6232746b6135384d6a6d6573316b6a51576b6a666f66416a634b5945515a34634e485a4259626754715739617256306563587068443232696c356f3758436634322b7a352f797556766b576c614232697a304e6774744e627262523039766f4b5a676a677061574a7355555442344e61786f41614237414639694943496941694967394a595754527559396f6378773263306a6345653865616a6a4a4f476e53624d4a48533376545845376e4d3437756d71624c54756b507a75354e2f38416d704b52424439733450644437505543616c306c77324f5548634f4e6c6766742f4f61564a7469786d30347652696b7339736f3756534477676f61646b45592f4a5941467961495041473367764b4967496949504247367262784c6341656c584577796f723772616a594d7265447935465a6d746971484f38752b6274797a44772b574f62626f484257545242526e674e3443383534534e543873756c327a656875324c563148364a53322b3343566e704c2b3861357452504738637362324e61356f3553342b75373174764738794967496949434969416949674969494349694169496749694943496941694967496949434969416949674969494349694169496749694943496941694967496949434969416949674969494349694169496749694943496941694967496949434969416949674969494349694169496749694943496941694967496949434969416949674969494349694169496749694943496941694967496949434969416949674969494349694169496749694943496941694967496949434969416949674969494f7161543531394e44537a44637939422b44506f69737446642f517539373330663069426b7664382f4b336d356566626d355276747673504264725556634a333172476a663447576239686855716f4349694169496749694943496941694967496949434c384b36736a743146555655334e335545627058386a5335334b30626e594471543038416f4c7550454a583370756d743778374837342b31333236564e4f36314d625179314e786846766e6d6a64473454756a59336e6178784c7049794f5277647431424365305555573769537861363439634c7a54557430645355564c62617556726f474e6674577975696a5941582f4b59396a6738485944626f584c703946784c3552566641332f41476358642f703259312b4e2b704c514476493450544f6a4e3633704b333055637864737738736e4c76757a634c446f6f495a786e36637a317555553046545556627244535664624a364a4c537a5071493656345a507951736d4d72434365676d5a487a6a717a6d485664737475747a4c706c5278755044736969764d6442366650537a4768593642727539377072683654314d6e64485974356d4e4c3268376d4f334143533055443458785176752b6e754d336d3659586633337136576c31356e7439726a70704f376f324e595831592f776b67524579414e59586438376c6474483058727156784673714e4e6335756d4530317a6b697446736c6d6979746b45427438553470327a746274492f6e635131374e7a3352594365557533424343656b58566352314a732b61343156354851475a6d5051756b4d4e306e44577731634c423631524673346b78626877446e42764e796c7a51576c726a314f6e3467715772744e707249634d796c3839376b614c4e5147436c6255584b49784f6c4d305964554273624178753537353062687a4e484c753441684b794b464a4f4b2f47433173744a59386a75464b324b6a665556464e527863744c4a565453553845456a58537466336a71694a304f7a576b4e65527551336477376a613959374256366558624d62697973734673733736714f36515843454f6e6f6e3037334d6d6139734a6b446943306b474d76424242424f364476534b4f746473397944414e494d687972453762513357767431766e75412b45705852303855555544356e506331767250364d44517870424a654e334e47354842616838514e46686d6534396a526c6a705750696a723735644a364770714b57333073684c49574f66454f574b535751454e664b357247746a6558626b7444676d4a46563270347272315233432f7448304f56745453306c376d474e68306c5058326b304a63496e3130723543774d6d3259506b523747566e4b3534395a654b546964795231764d4e6456324b79744e346a747a7371766c6c724c5a52557a48305a7142333144504d325a6a6934434a6a6e7973592f6d3361656761517447697264624f4976494c3437444b79657074324a324f3657326d724b6935316d4e5843345564564a4c5653517462465652797852557258746a61397270392b6c524830506e32653661695a66685770676f622f6b6d4d56754c55647571627a647a533247707071696770647a485374373031736f664a4a4a7a414152446e454d7577423551676d704658657031307a742b4f5875655779775753355532567857687257574f7476547266517957324775612b707036575153506c4866434e3349344d6135774855446d64325136733545627a704f3267645937396a4f55564a704b33494b646b6b48667947697136686f70715979504d514270527a643439784850796745376c6f54496949674969494349694169496749694943496941694967496949497134547672574e472f774d733337444370565245424552415245514552454245524152455145524548353145507046504c46336a3475647062336b5a326333636262672b52556134786f465a7361766c48656e5865373357373039316c76443675736454744e524d2b6a4e4873396b554d624e684566467257754c6743357a7575354548436655713433485378556c4e6673696f364530394c5431644c425551426c614b616f6655514f6c4a684c67356a3548443143774f47776348624263784c6f4462547a2b6a354866364c6b7947544a7150754a4b592b6731557666392b324c6d674f374a50535a74784a7a6b632f716c7577324967395a754879317a574449736638416f6b7946754d3369437167466c625042365052436f655a4a485145773935767a46334b4a487661304f4961414f69352b2b365855655235375a4d6e7272746335445a354455556c724268464b7959785069377a6675752b42355a48417445675965684c547369494f6f55334448614c6659625a6136484b386e6f47322b686d74455656547a307a5a6a62704f542f4133457745474e76494f562b776c627564704e79562b31587730592f4a6137375a71473958327a597a656164304652594b476545556a5847427348657335346e53423349787671382f4a7a446d4c43377169494f3157625332335742747970614775726f624a634b326f726169794875585568372b4d746d6961444758736a64493530786131772f68484f3638704c5431716c346571576974567070496330797474545a58742b42726736656c665062596845364c75592b616e4c4a47466a79435a6d794f504b306c3237576b455165317534624d56745675714b4b6c7162704844554f744d6b6864554d63357a376657757259336c78595358535450635a4366454f504c7948717538596a687446686b4e316a6f705a35573347355646306c4e5135704c5a5a6e3837773359445a6f506744756661536949506a315077426d714745585846366938334b78304e30676b704b79613143447670594a474f5a4a46764e464930427a584545686f63504a77585537747739322b2f4277754f5535465673724b534768764d66655573626231444535356a6255686c4f304e32456a6d45776430584e4f7a74396b52427a6c38306373575476793139346b72626c4a6b644d32686d664c4d4775704b5a6f39574b6e4c576a75326835644a763163586e636b674e44654d6730486f4461736970712f4a386975315a6b506f38567a756c5455514d7161696d6833446158654b466a4752467270477535477465524938382b35334245484a5a64704852356c505377564e3775394a6a305449593573626f6e5152304653324a346578727833526b614e77415778794d44674143434f692b74756c4f4f564c73712b4671474c4934386c715935376a42655959366d463759324d6246434979336c37746e4943317042395a7a6e456b754a5245485737547735597a682f77362f434a7039505a377858785631524e6a4e4a525535416a7032514e676131314f396e64657136546c4c53524a4c4934454679562f442f41455573474630317279764963666f73546d394b6f6161684e484b4a6167787a52766d6d6455553072337663796f6d44746e41657554734841454551536f6949674969494349694169496749694943496941694967496949502f2f5a, '2021-06-10 11:30:38', '2021-06-10 11:30:44', 'Admin', 1),
(2, 'sanitizer', 0x6956424f5277304b47676f414141414e5355684555674141415330414141436e43414d414141427a59667257414141416246424d5645582f2f2f396458563157566c5a61576c70565656576e703666382f507853556c4c33392f66362b7670675947426f61476a6d3575627938764a79636e4c65337436516b4a4441774d444778736275377536456849546f364f6a5330744b676f4b426b5a47522b666e36757271375731745a7362477931746257576c706245784d534b696f703565586c4b536b71546b354d3232664a424141414c6b456c45515652346e4f3164695a4b6a4f67774d6c7347452b776f33435a6e382f7a382b494241634832534f7641315831396257376f524d675571535779335a4841343764757a59735750486a683272676d74392b673457417a304851744c343037657844495131566851466c4f4c544e3749416144344370515755346166765a6661777a3341336c714c67383664765a753449444b513867507850333836736f535550782b70693064786a55593669784d6f54554b5a392b70356d69397741685145456e3736706d634b3959745a576a6257383436667661356134704a786a7464614b39452f663242775267386859436b7232784d56444f794f527351447435593841396c555968385a4f7545545149344731534f6c2b2b72356d696f6f6e443471363579774a436f4d784674345647796b43687067436e50574474624d484953344d6630424b6b3936444e506e3066633053465746595668306551672f42587663494550547158302b35414666616f5843614f6767632b3950334e6a76304e42354675644c2b41306657515576492f576631703239756272444c7a6a413443773856496f536f6a542f7031384850396c6838516c2f7a594b39644150556976712b445672394751747031796e513364766346736b4852475174646d51785639633646732b592f567451345862523347412b48726b41453538542b334f764d425756774f4e377a4755703332626e6f496f377736656e5578434b516a6b72302f414b644e31384a4a61697a672b43545145466d77314576796f4f343475716633393638594475744c564b68316e433775676639544c46384d4c6834335261734e7372414533366d615965346642494a743634374230536374546f6356565a2b78766d2f7662325a77572f37504552633337674f727a37447069644a67712b574a51693759425866585779757a62596369375a6e4b4b556f454f3049433574413743534a74696c576353786934554b584346717864334e526b7170624a62647a556d31657662646c78687070762b36626746447a4234463532584a384e6c35445a4e5a7136752f3746646b59716f43766d79346951376d314f734c523134366a783656626c6e6130534e69373776776f73512b5778316f54304a617a6c797363496d6c4b53716468584c356761414b634c51636a32396d346d34536377345a31494a456c4e36314b61783576457452537336435542436e5a387443455a544c6d416c4b6644726f715a713374352b6157597a4634356c79512b7472426c546c57643858313037663853547a4e644a477357665159337344463470626c776e416336674a4462516e7068474e314d4c593861524950367949755739346745695759574377335657517a55447637414453454e4b79467649454233764b6769643747496a4b6e65414f4c4c566441466742343973452b663865784f6a3830746a786f556b48444f51754235697a447072754f65746751306d6e657748725865696d3965336c395354536833747a744135674b56494331646830314237326f5672547170574d68303875546372774b31537456556e4f4536736c74543664615768594f726b5369317066433231676e6f585632486475524554525672567a4d562b6b64444c2f5036745275447278475a564272687942416b63616970704a5855556979527a7557306738685779474e794f2b446270466b795a66736c4870794c4a71362b2b4e71674e5a4836643168576c4b7935417656557870643955694230764c4a367372727249386345412f3946524a6c2f75465962665834684a4d7a7869492f624c68732b413950454a2f37634a754f773234556a6b464d78614a34796d6d704342334b645152786335714d513442616c4d6970544c63756c5a34656449434d2f37795339765937592f6e4370594861464c6f716c643536656e7142493951545751744a7038474c30626c41747459754477773745477a6f45573464376831725970756e4f72726b656c543667724546782b683152396f496377616d376d594f4e79716f6a7a344a36566f4743544f32563567796c6642525969306741322f5166414177755372546f6d4c52576366524736787243634b4774576676673836674a496664425a514f583668336e36744763363144705266554e467a6d45705539514c7942794137313972444a37466868596e614d56504f6f62363642306c73705a776954335673583833774c30737551337657683367616c732f4b7058525167366a367a71664c61584546357a56654145446e3138304b6e73324d5143713548496562346d456c43742b5a37316431415052454a71466863776646776641614871474b6e3569736d4645476c5037324d2f754f48742b476b7758344c54454a6c2b7356542b6c4177712b5a5a5830794f305a385a467a415a2b2f7767567362596167536e63314239314a3142575870354866505777726d647173786c37764e6c7a465072564859614c2b704e586f772f516658434b58306749416578586e4c4c665537485973702b47764f2f5245485172356b35706449766e4e4c7a766758586f363277766e553430714f364b6563694b6a2b70577a2f715279714d59646b712f596e6e707348422b75496e474377717949436e546b777043517256363646562b7575794f3259734f57686c6450564c6f4b44366c4c58347a6f544b564f5a507767533170434c4f6178634646542b70794d545447336f6c4646676f586b365976485a366e706b6e4f654e42713148704c654f635058727853456e304e69304c52346c435578614c4153506263377a71524e45495a3948622f584f7a714279434555494576465a586957554c6655434832766a4d33496753314e785871515051304f312f6570422f67387738486430714f617558734c56536b615979456b6b70306d4e6e497235794e54637676394c794c4834396e544a6a32426b564f6c6f46706e535670325842345a6e6a4c3045317750324b30394f6e693162703952746b767130666a37706458556b32555a35515a2b514e7a3578542b5a3069437377586e3067774c4a7a53783948586c784e4654764f337549457a674c494e756a654837484736475939543465523574495935356e4c704b763352716d355a56756576546a3836556a4a715838594d755238675034364367304872384472544e494a793062483466564137667143337944333334327663707344685533444737775463714f706d7a704b67706d6436546562596b436d41572b65566a313346594135667341576a71704b444646594969744c6a65786c544b4f4d72624871746f74734a314d47396973594379455a436b5a366547546f5452663559522f556164534d33512f374c78644d353635714d6d414c56303443554b363944424e6763504d32744a524f466d306c6354314b37344d7a356f447a336e71614a542f5876767264734b65496e6f4939556e33687854656a4a523155333546754859717758775a424a436a78766f5050576c6a5a4d555371395a4d6a656e7036424a6f7557625834497570495264695a6336566a4f335350584d382f3148566a556d526e382f67474e4f77694f74646169525a756667354c3349474a6f6846565054563471477a7a6e544a4f7139492b33434d714e7466412b32533851557676514553553432464e44717232784e6b506b52314143483658532b362f33546d317a7537564170626554462b6d3950544e374c524f6f50384f523272585a6e555450763056514549584a56725161466a48314a687477456a5636656151476d4976757666344e5478304d39504c676733454765705051354e734f4245446d6449646b395843356764514a5939564c6e777a384d313775386e7845495652625465385536752b6450454b697a64463345617a794737454953724b78776c414777633444466f6a664d44562f61502f504764327664764d444f6939492b744e4f626e7a4a6b7a713658712b5247726a76706a7a6946352b4f6a6c5575524d7653744444497663784a41574d454852413272313775766e56354b695a694556413064386336686c59522b32703942554977734855754143596f557550336d55795678754a4d583633623543524e507857426e7965334b484e4b417769616b674d4167356d64666573746d637757373139735235526d7942763871314f6d43766b696a537631495465565352342b68736858576c66783663386d7334544f315a33304f542b6f35487632455a6f4d67354d6c7752395450377648724157535432522b46504b383855324c49554c4d73312f38506839724362647a4261737a4a61522f744e6239365241326e46714e662f6d494774506d365537366e4366655961334f5971325452532f314f6a764f7654706e776b7972674e7132325a37304f566538793172396b3034752b707162584a746342356a4c53713758574c756c64416963654d5a43316c7574315a544130716f756a424f4439424b7034507a456b35393464543333642f7138313172694e79673258685766486141334b59724576614d2b3039772b34733357347334616158414b7a6b4365685863796278655334733357556f41396d535877484d536673624851516474332b355a4a5738734b504578456236465a3674736d33353233626f38565466653955747a34416a526251765543663749577231455966554b792f496949764b6f464e68656957764834693756534c79754e6c706569726878762f6e55665a626572327051644e4e79736a4d6e63565373352f6d4974343162465252793336716f584f615a523374794767565a5a4b34784a766f4a4e6462354d2f54582b466f6c74675a6a64314d44563966423043725777696c4c353864584c397173576638377930465749784b7a564b6e484978456e66674d743879583756346f31564e5a34612f51426b714d7632717859767266564c715a44354a6468686a336c594a43613643506531726a532b2b356f55756132516b532f66723171497251574163566b6e5664776d6d754373764272626d375156646c597a394d465a71334f70314b7663307867367267712f64544441616258303344376979566f4e765953726c777636456c6f514b623959447742665a396b552f433047613355755a643475626969524c6e5833396c4d4841327a36362f47724670323141435048552b4e586d66685952627a344d6d47726246562b3155496c434374316b36572b6c596a31346a7a4a7170373836724975763272684a2f37506c446e39556b38554e344f74554c5a555557595376316a626a315a6554764e3258415a72344b4a766735746e6973544441455772394b732f7762627939707779316d4a416e4e2f32724e634f4f30696946493971466a514c786f61336c377947625256716c48627a544953554c38394a3274456974467a3337374e634f336273324c466a783434644f336273324c486a48666750324157496451643132594141414141415355564f524b35435949493d, '2021-06-10 11:30:59', '2021-06-10 11:30:59', 'Admin', 0),
(3, 'thermal check', 0x6956424f5277304b47676f414141414e5355684555674141414d6741414144494341594141414374574b36654141414142484e4353565149434167496641686b6941414141416c7753466c7a4141414c4577414143784d42414a71634741414146655a4a52454655654a7a746e586d514864563168372b5242714552517141464937474b5653414c554149474442696241445a4c544568694849646778794c474f4d516b4262474a6f5277446867714f46784b4d347730374945716853477a4168684b4c41474e6a52454a737a41354362474c54614750516869536b6b535a2f6e5065693774504c362b3758322b3035583158587a4f333375752b64656631373579376e6e41754759526947595269475952694759526947595269475952694759526947595269476b59695256546641364d6932774965417a774b7a674e484161384337466259706a7248414263424867476542643670746a744530656f435a7742654165344231774a41364e674c7a67504f41586174705a69684841692b79745a3150564e73636f796e73686c69486d34436c42415552643277422f68653442486876325131763051746344677947744739635257307948475963634270774c62434164494c6f64437745766745634459776f34572f5a462f6966694c624d4b36462b6f77483049672f735a63423859425070487670586742384356774850704c68754358416463436f796c736d626334433145585666432f5156554b6652454134417a676475423161525468427641376341663431385132763241793443486b613657456e754f5141636b6450664e676e34575551392f63424a4f64566a4e496a334147634331774f766b3034514734466641563947487549307334755467584f427535435a7255376a6c646d7461374a794d694b4373507666686f6a484d4f6844706a4b2f4154784f386d2f793976453038432f414b6342324f6256704850414a3447626972645a7178414b4e536e48765075433745666462412f78564c6e2b423453776a67454f424c774833417874494a346a46774933414a3445704a62523346504243687a5974524d596e6e546755654337694876384e374a4e7a327731486d496f4d5250384c574545365161774635694b4c5a6a4e4b626e6562687a71307358334544616250513771412b70704e774b585959764f77596b66675434447634562f77536e71384346774a664a4230335a65692b446e2b3974304b764557773356474c6a654d4a6e33463741566b554e42724f4b4f526876684a3468504346726a5448536d5136747935636a373939357741546b476c6a372f6d4449363466542f422f386950456e63526f4b444f51627339636f7566776f343633674a386773305a66415a61487647636c3161316f6137364a763231666170312f514a302f4c75596535794f4438466542307774727156455a553442504951506b78615154784c76414c34434c67634d49726b7a766748796a36757565705a6946756252636772396458322b642f366b362f37464b57756341765655336f414332513778665477424f4a4e32332b52447746484276362f673134697759785372674d38447a62483334414134454c6b52577671766b4c565765324f473830554247496f74725830595732384a6d584f4b4f4e35432b2b706e417a6c3230342f76717669756f3374586944507874757131312f6970312f704a4b576d63557a69635174347730676c694e75482b636a376944354d5534676a4e45565864642f67422f657835736e662b434f762f4e536c726e414b353373593542706d626a4745546377653846376b4d385477634c614d74717849336a41732b35447950392f616f59554f554a725a394664724636455573384264696c39645037652f766e614f42715a416178747267756b44424850704178515673514479415062786e636a5638674d3075714e34716978694348414563524c6f4364534f356d667758696c506c637976714e684f6a4676433843753166596e6a315565785a5832426151435173394b77657956754d39507a2f46505538464e704f7557787433484a54316a7a506936535734796a756d30685a4a64382f626e7265726251345139426b6269347939764f6357704c6a66625049527869616b69315672584f3569546358662f6e37697032544c514174305179577438444f41337a6c794174313173583644724374464d6453362f324c6b4d2b6e332f4f34393130393945302f385079344c5249382f586b783566533879525a7a6e687a52566c5a666b654f2b737649566649424f424a35454875616431626e7a7239364545392f73335a4372395547415a51514573516178444978684f41756c44706f56504277356e613944514f30687378743341446343694c7471306c79712f304d573938694a734a6d737a4d6e4778512b7663794e62764b7850636277674a2f7830576c4248555878527042504a4a344758673335466b436436497575325168635a4c6b5166364f3844324764756b347a7a657a486966504c48563943356f756b43325156624a6279525a6d476b7638446641623447394d37524a31374530777a3379706f71316b4d62516449484d426a3464636630673059506f2f5946666b6a37795477756b4c6d4d514c325a425575437151455951374f397267667774384f6671334472676e3547353932325263636d7569507636532b713975794f783354306b5277757144674978437a494d6d59702f546c31335a585a435968693837316d49704d754a596a5177682b42386664795570755a5a646530684b61347469732f6762394d4e7266505871504e2f5630586a366f367246715254392b727a2b4b5065426844333937685a70513249474851327749745374457548726c61396b67356d5162716971514c354d31572b444d6d49336f6b745348664c4f342f2f5870496c5852694c50772f745273546c765771536a6b456d454d2f4f534d7a4c312b67754c4d41706d6969516963413054336b6a57377356535669455a4658336b69544f66426456626b6376566b32554264486e4f316d516e79472b62762b414f42664f36723570396364566765697878497378727a32446a456653384967714a356e79315536536236537373796a796d7355367a5050376547524e365636436b79574e776c574278466b512f61416d3656707056716c796b736a4175676f6b7a494c306b4634674e3457634f7748785172695168756248636c45675051532f306232443739335561316b6556503277614d47456f65764e497377693249446669584d6b57364d667658515379437845434e6f6864417a774c53544459754e6331313055794737496c4779624166772b525070427a654c756f6131426b6e7673716371765a3669334b4d4c4747326b467367584a4a5477443656707033676338696752423153476a537936344b4a424f4d316835574242396a7951502b7836715842634c4175457a566d76777a39614e4a566b3279466551554f4a5a42495733445a4938343348716c5541764d796151634c4c635177766b31517a31466b58556a465861715634764e7744546b627a466d674f516c456e644f4837576769594b4a492f42636c71423942434d42566d556f643669434f744f6e554677323457306934564c6b54576e50794c594465314248442b6651625a344d45726946767775456d6435586874424d4177336257367137645831536149554a36747236684271362b55482b4e7333514e436c5a676734746f73367869473577614c3253626d776933745852744d7379475438515741447750715539383969676652617743737036797761625548476837786e48643246434b3847506f646b7456775938766f35586479374d6c7755694e36737853755171735966576941765a3669334b455953484239354755532b2b666442386f643179344f496b2b5a562b504f50505a33447659304f5443472b4b2f4f6e3676573547656f345739336a7867545866455664382f5834743566474e4d51724943717a79452b51324a65694f4154344d524a6973454f483939595331324c536466644b783342555a554736545343524e7a3149504d785668492f42666f6e34564f56684d654a34417366334c6e52644950704231413644575153535a5179693278585742792b4c505a4577343741395035596857307666576d714c484d61314d55676e675978545a54303454554b5752554c6454616c4b4947636a4b5833437848457273677075346b684230797a494f366f634e6c7654696251754978507872782b737066784171636e41646341666872793245736c6b5036665546686d5638436a2b516559783676585071646676536e6e2f392b44504f37755a7a6e7559483658712f47334b4f72766c444b4a33344c32486f4555304773784b2f412b417a6949795862302b53487763756b62505276306d7754565a5a72337959447a696768346d6a4c5849574d4d59527579452f79474932744c676366572b5879464f644a303443466b733831353751657756777266554e52636e754b5a62546b5a634f384c453852444274534a6a4750422b2f412f43597848762b7a6a42682b594f347566686a304279793371765755357730422f475065713630784a636b355778534e72504d47467351424a4d754462785975544570776b75636b56784e38454871422f5a426e6b474d71365969477852646750682b364f66705738616766346d4c796f453956686b6854354d484c386a5757494a6f3846636a662b6875447a6d765a4f5158616169567041374864636b624e4e45646430713069576153384a6f70427358746d6e4e4a7543724a4f74434767336e507677505236634e4d7163674d307070786645316b6a2f6b4a367072483072383179546a554d5264504b79647a79465266495942424c7379302b4c66446b6945334758497245346e5954794c524d716c34534a316a322b6e7644364b58715464326e562f694b326872364f6a4c6a61474839766737324a73496430693577516b654f64324a4a42704c654c6f2b4353797748594b325161334e2b4e2f654e4f6b4b5931694f744757377858456e64777766457a462f364455595673426b4c687a6237734f374f4a654934432f522b4a587773527848593648727872466353544a706e6a4c5a4666386256704a39696e57765a44316d6a42684c455a326c6a574d534537412f3944386f74726d414d48316c6a737a3375647367706e6f3238664e7045756b594f534d4b38364b326839716f796f6644527850394466345a6d52425438632f5a4c324f316e5665666831786a7a672b42767949344b7a5a41484165384a385a376d6b4d513037482f383136682b6531593069327366306d5a4e7130322b7661764b54656431544b76326b61345a5a6a4c756c33746a494b77685733424a313477577452346979416c31356b35627a6236304163494c33705431635354486764787a61496f2b46596466344b5a4c7a526e2b4a65687348522b4c396c662b643537536a4358555830735248347652797541334649394c376e70796e2f487530313344373254486b666f324479646f736f697233787835387677372b4a79354849716e5a55687646424a44626b5558552b3633575041544d393562386b755a76374e435257572b6576585937456f786847616b595248432f73574646626449445565744b7454326a76332f5a785837374e4e495962432f412f5547467831325677753270486e466578356c536975334a3575616b597735542f7750394178586e7a4673573542422f7344795338646753535043314b494a2f50753746473937697944674a775033436d702f7a48774b556472756c6d6e554e7a484843744f6a6566354f7366663446734342704631626d30444d655a516e416338767378372b39326e63504c3455694972335974535272614f684c5a425375754855566d4f44534743665077503152784b383258306c6b6337654f4c4d6666354142494970555631556f70326e396d682f6932592b37715241337046665176524b396a6472484f304f51754a39645a31707430432b516c31443531596f6937657959624370544549774d2b427039693657575150736833782b776875396677773073314b7373366876595037674838465071764f447946784a64656e61505078774d48713342776b73584f6275757949617a534134776c616754764a4c7937375a494a2b566d314c6b795567536b384c50345a454c6e7250335246357457466b49437a317a5479366377302f446e6767354c35445349356637623262684430495468544d516c62657665642b3245573744534e4148354c3155442f49693548306f306c6d6c337151736366464242636876636644784739414538635642495857683277393444312f526362374777586a3268696b7a586f6b55664d442b4d4e6370774466612f322b484f6e4f394c654f7a63684d305937496c4f7030346a657458492f4d68463364756a59744977674f35713976335666375843334a63482f44364d676b5a4b4575365852756b6d4d7a4d6f6a572b34536b5259387a68746771356a6e712f426c64316d55596b6651692b3346334b34773153474b457642627374416938712f5536382b4f486371725479426c587531686542736d2b516552537849586c547541326b6d33356e49512b5a4f39774c374d3976303953723633497156346a5a356f674541696d32376b636565443351375a6c3278455a4536784656735558495a6b4a6931702f4f41562f744f41676b6f43686a525a496c70327744434d78392b4c76736e7930327559454573724e55363972763635527062624f474861556c57453943614d492b6d366436336d395637326d7434307a6a467a5a6765426775387051596a313774526e2f744b3765434d6a635447714d4b316c4e3474446a6a2f6132423157687533667a6b526a364e6e706a305a58464e73666f686959495a4c6f7156376c484f63424856466c764a4b706a365530674e6359456b69393745647730314154694d453051694e3437765571426e4b6a4b2f556a73687865395636494a704d5930515344616b66446c536c6f683641794d656e6f5867674c52635378476a576943514c5450314b497147744869673670386638683764413674714f32736a527267756b4436384b394b723663367a396744674d6e7158466a474537323174416d6b787267756b4e31552b64564b57694563726370764547374e7441565a573068726a46787758534336652f566d4a61305133712f4b55666d7964455a334734505547424e4966687968796c45434d517669454b344c524d39675653575137516d757830547446364a33797a4b4231426a5842614c484949737261595673686544395832346b4f6b5a466437484d57624847754336516e56523557656937696b636e6e6e75613444364b626251464d594855474e63466f7450383145556765734d644c324e554f61386f52714d41544344354d464f5634775269467351686d6961513552573059515379534f68462b31393530525a4562314271474c6d78446e2f7755525578397675714e6777525843333338725a3672783630477a58435a517379476e453161624d57535935514e6a7067617a487837694e39716d7757704d61344c42436446664874536c6f52464d69436d506632344e2f646468505a736a59614a654779515054345931556c7251676d6d6f7354694e37366555504f62544679786d5742314d566c5179664b6a684f49376c365a5147714f79774c5244317456546e3961494d2f48764e63453468676d6b4f3459426579717a69324b65622f7559746b41766561344c42433936575556443974552f502f44496543316d5066724e722b6264344f4d6648465a4948586f726d686e795755643271457469416d6b3572677345503174584165426449706f4e4945346873734371614d46535375514b4939666f7961344c42427451545a56304159395144634c306a4263466f682b324b6f517942525637752f776672334e67566d516d754f7951485462712f4444307074786476496d31674b7051745247436c7757694b594b67656949787251434d51745363356f6b6b437132504567623872754e4b70734671546c4e456b6a5a39424c4d314e374a67706841484d4d456b70304a42486579736a4649777a43425a4363735333756e7452697a494937524a494755485736727732715437504f6842564c4678494b52417063466f67666c49307575583175514a50456f5a6b45637732574236436e53736757694c556753675767725a774b704f53344c524c7470364146773057534a614e5143735335577a58465a4948704172463150696b626e74306f694547336c4c4746447a58465a494e71436c43305137537870467153427543795171693249647266504968437a4944576e53514c52585a366930514a4a6b6d4e586437484d677451636c7757697531686c4379524c5049714e51527a445a59486f4a41316c433054506d695635324530676a7547795148536148373274514e486f2f35304a704947344c424364494671765378524e6c6f41744c5a41744f6258464b41695842614a7a385a59746b437a57494976564d5372455a59466f43784b334a306352354e48464d6774536331775779447238335a7078424f4d7a6969534c515051314a70436134374a41774439514830485177375a4974446578575a4147347270413944684568384157695236554a346c483052624f42464a7a58426549336c564b623670544a466f674f74596a4450332f72694c52684a4543317757695938416e6c566933376c4a6c4559685a6b4a726a756b4257714c4c65743742497a49494d41317758534a55575241736b53634357486f4f595147704f30775369553445576958615754474a42624a4475474b344c52486578644b6244496c6d6e796c6b455968616b3572677545473142646936786275314e6e4b574c5a64516331775779564a556e6c3169337469424a4968724e676a694736774c522b3346554b5a41737a70496d6b4a726a756b415771334b5a417446647243544f6b6d5a42484d4e3167577a4176356f2b6d764a573033575368724c643759305363463067454c516975355255722f59444b397664336969424a6770456236785a4646554862426b6c30415342764b6e4b6535525572316d515955415442504b614b7539655572316149474d6f503447325554424e45496a656d377773432f497551586554744e3073577a69734f553055794a346c317130337a62467556734d7767585448674370333869613264512f4861494a415873662f344f314f65574f42744e37454a68444861494a413373587663744a4c65515031627433746251785363356f674549435856586e766b75725641756e6b627138745346502b2f34326c4b522f516936713862306e31647476464d67745363356f716b48314b716c6348624a6c41476b5a5442504b534b7539665572316d5152704f557753694c55685a416c6d69796d6e48494361516d744d55675378553558306f35322f546a704b644c49684f307443552f33396a61636f487442722f564f2b327746346c314a74574944614c3552684e2b6f4157715049424a645335426e3843375437696b39655a4258474d4a6e31415769445453367058573547345255717a4949375270412f6f4f565775536942783373526d5152796a53522f514d366f386f3652365453414e706b6b66304e4f71504a31792f72375856546d75693255436359776d6655444c38432f636a614763466655304156736d454d646f326766306c436f6658454b6469315135796f4963423579757a6a58742f3938346d7659425061484b4d30756f73354d463651572b43747848634b56395531474e4d6f7777506f564d70626150755358553261667148475272774e5a687747507139665a7845386b7977687447626879452f79466351546c2b57557456765963443179486274476c686241622b456650444d6970674a50414f2f676479452f4b7746686c45395168424b784a6d4e667142457774736832463035454843483835423442626742504964652f554164305855716274555a6536686142696848414c4d4a2f356866514f34427667774d6832636c6e4841716342336b4d794f63585539443579552b6138784b71584a2f654350413163432b335634337943797950676b38414c79774138673278763049414b6169457a66376f2b4d6377366b73785871422f344a2b414532573258556c4a484157636a306236637555463748383843357946594d6875454d78774b7a4566663076455778477069444c41593232536f627734445277476e41393546762b79794332494a307937344e6642537a466f33467675316b5236715a5349445656475162747832516833347a4d6d323842686d62764971343154394263496370777a414d777a414d777a414d777a414d777a414d777a414d777a414d6f776e38482f5368362b6a5534796e634141414141456c46546b5375516d4343, '2021-06-10 11:31:17', '2021-06-10 11:31:17', 'Admin', 0);

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
(1, 4, 1, '1', '1', 0, 0, '2021-06-08 10:49:10', '2021-06-08 10:49:10', NULL, 1),
(2, 4, 1, '1', '2', 0, 1, '2021-06-08 10:49:10', '2021-06-08 10:49:10', NULL, 1),
(3, 4, 1, '1', '3', 0, 2, '2021-06-08 10:49:10', '2021-06-08 10:49:10', NULL, 1),
(4, 4, 1, '1', '4', 0, 3, '2021-06-08 10:49:10', '2021-06-08 10:49:10', NULL, 1),
(5, 4, 1, '1', '5', 0, 4, '2021-06-08 10:49:10', '2021-06-08 10:49:10', NULL, 1),
(6, 4, 1, '1', '6', 1, 0, '2021-06-08 10:49:10', '2021-06-08 10:49:10', NULL, 1),
(7, 4, 1, '1', '7', 1, 1, '2021-06-08 10:49:10', '2021-06-08 10:49:10', NULL, 1),
(8, 4, 1, '1', '8', 1, 2, '2021-06-08 10:49:10', '2021-06-08 10:49:10', NULL, 1),
(9, 4, 1, '1', '9', 1, 3, '2021-06-08 10:49:10', '2021-06-08 10:49:10', NULL, 1),
(10, 4, 1, '1', '10', 1, 4, '2021-06-08 10:49:10', '2021-06-08 10:49:10', NULL, 1),
(11, 4, 1, '1', '11', 2, 0, '2021-06-08 10:49:10', '2021-06-08 10:49:10', NULL, 1),
(12, 4, 1, '1', '12', 2, 1, '2021-06-08 10:49:10', '2021-06-08 10:49:10', NULL, 1),
(13, 4, 1, '1', '13', 2, 2, '2021-06-08 10:49:10', '2021-06-08 10:49:10', NULL, 1),
(14, 4, 1, '1', '14', 2, 3, '2021-06-08 10:49:10', '2021-06-08 10:49:10', NULL, 1),
(15, 4, 1, '1', '15', 2, 4, '2021-06-08 10:49:10', '2021-06-08 10:49:10', NULL, 1),
(16, 4, 1, '1', '16', 3, 0, '2021-06-08 10:49:10', '2021-06-08 10:49:10', NULL, 1),
(17, 4, 1, '1', '17', 3, 1, '2021-06-08 10:49:10', '2021-06-08 10:49:10', NULL, 1),
(18, 4, 1, '1', '18', 3, 2, '2021-06-08 10:49:10', '2021-06-08 10:49:10', NULL, 1),
(19, 4, 1, '1', '19', 3, 3, '2021-06-08 10:49:11', '2021-06-08 10:49:11', NULL, 1),
(20, 4, 1, '1', '20', 3, 4, '2021-06-08 10:49:11', '2021-06-08 10:49:11', NULL, 1),
(21, 6, 2, '2', 'SL1', 0, 0, '2021-06-08 13:57:45', '2021-06-08 13:57:45', NULL, 1),
(22, 6, 2, '2', 'SL2', 0, 1, '2021-06-08 13:57:45', '2021-06-08 13:57:45', NULL, 1),
(23, 6, 2, '2', 'SL3', 0, 2, '2021-06-08 13:57:45', '2021-06-08 13:57:45', NULL, 1),
(24, 6, 2, '2', 'SL4', 0, 3, '2021-06-08 13:57:45', '2021-06-08 13:57:45', NULL, 1),
(25, 6, 2, '2', 'SL5', 0, 4, '2021-06-08 13:57:45', '2021-06-08 13:57:45', NULL, 1),
(26, 6, 2, '2', 'SL6', 1, 0, '2021-06-08 13:57:46', '2021-06-08 13:57:46', NULL, 1),
(27, 6, 2, '2', 'SL7', 1, 1, '2021-06-08 13:57:46', '2021-06-08 13:57:46', NULL, 1),
(28, 6, 2, '2', 'SL8', 1, 2, '2021-06-08 13:57:46', '2021-06-08 13:57:46', NULL, 1),
(29, 6, 2, '2', 'SL9', 1, 3, '2021-06-08 13:57:46', '2021-06-08 13:57:46', NULL, 1),
(30, 6, 2, '2', 'SL10', 1, 4, '2021-06-08 13:57:46', '2021-06-08 13:57:46', NULL, 1),
(31, 7, 1, '1', '1', 0, 0, '2021-06-08 14:00:35', '2021-06-08 14:00:35', NULL, 1),
(32, 7, 1, '1', '5', 0, 1, '2021-06-08 14:00:35', '2021-06-08 14:00:35', NULL, 1),
(33, 7, 1, '1', '9', 0, 2, '2021-06-08 14:00:35', '2021-06-08 14:00:35', NULL, 1),
(34, 7, 1, '1', '13', 0, 3, '2021-06-08 14:00:35', '2021-06-08 14:00:35', NULL, 1),
(35, 7, 1, '1', '17', 0, 4, '2021-06-08 14:00:35', '2021-06-08 14:00:35', NULL, 1),
(36, 7, 1, '1', '21', 0, 5, '2021-06-08 14:00:35', '2021-06-08 14:00:35', NULL, 1),
(37, 7, 1, '1', '2', 1, 0, '2021-06-08 14:00:35', '2021-06-08 14:00:35', NULL, 1),
(38, 7, 1, '1', '6', 1, 1, '2021-06-08 14:00:35', '2021-06-08 14:00:35', NULL, 1),
(39, 7, 1, '1', '10', 1, 2, '2021-06-08 14:00:35', '2021-06-08 14:00:35', NULL, 1),
(40, 7, 1, '1', '14', 1, 3, '2021-06-08 14:00:35', '2021-06-08 14:00:35', NULL, 1),
(41, 7, 1, '1', '18', 1, 4, '2021-06-08 14:00:35', '2021-06-08 14:00:35', NULL, 1),
(42, 7, 1, '1', '22', 1, 5, '2021-06-08 14:00:35', '2021-06-08 14:00:35', NULL, 1),
(43, 7, 1, '1', '3', 2, 0, '2021-06-08 14:00:35', '2021-06-08 14:00:35', NULL, 1),
(44, 7, 1, '1', '7', 2, 1, '2021-06-08 14:00:35', '2021-06-08 14:00:35', NULL, 1),
(45, 7, 1, '1', '11', 2, 2, '2021-06-08 14:00:35', '2021-06-08 14:00:35', NULL, 1),
(46, 7, 1, '1', '15', 2, 3, '2021-06-08 14:00:35', '2021-06-08 14:00:35', NULL, 1),
(47, 7, 1, '1', '19', 2, 4, '2021-06-08 14:00:35', '2021-06-08 14:00:35', NULL, 1),
(48, 7, 1, '1', '23', 2, 5, '2021-06-08 14:00:35', '2021-06-08 14:00:35', NULL, 1),
(49, 7, 1, '1', '4', 3, 0, '2021-06-08 14:00:35', '2021-06-08 14:00:35', NULL, 1),
(50, 7, 1, '1', '8', 3, 1, '2021-06-08 14:00:35', '2021-06-08 14:00:35', NULL, 1),
(51, 7, 1, '1', '12', 3, 2, '2021-06-08 14:00:35', '2021-06-08 14:00:35', NULL, 1),
(52, 7, 1, '1', '16', 3, 3, '2021-06-08 14:00:35', '2021-06-08 14:00:35', NULL, 1),
(53, 7, 1, '1', '20', 3, 4, '2021-06-08 14:00:35', '2021-06-08 14:00:35', NULL, 1),
(54, 7, 1, '1', '24', 3, 5, '2021-06-08 14:00:35', '2021-06-08 14:00:35', NULL, 1),
(55, 7, 2, '2', 'SL1', 0, 0, '2021-06-08 14:00:35', '2021-06-08 14:00:35', NULL, 1),
(56, 7, 2, '2', 'SL2', 0, 1, '2021-06-08 14:00:35', '2021-06-08 14:00:35', NULL, 1),
(57, 7, 2, '2', 'SL3', 0, 2, '2021-06-08 14:00:35', '2021-06-08 14:00:35', NULL, 1),
(58, 7, 2, '2', 'SL4', 0, 3, '2021-06-08 14:00:35', '2021-06-08 14:00:35', NULL, 1),
(59, 7, 2, '2', 'SL5', 1, 0, '2021-06-08 14:00:35', '2021-06-08 14:00:35', NULL, 1),
(60, 7, 2, '2', 'SL6', 1, 1, '2021-06-08 14:00:35', '2021-06-08 14:00:35', NULL, 1),
(61, 7, 2, '2', 'SL7', 1, 2, '2021-06-08 14:00:35', '2021-06-08 14:00:35', NULL, 1),
(62, 7, 2, '2', 'SL8', 1, 3, '2021-06-08 14:00:35', '2021-06-08 14:00:35', NULL, 1);

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
  `arr_time` datetime DEFAULT NULL,
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
(1, 1, 2, 1, 1291, 1294, 400.00, 450.00, '2021-06-11 20:00:00', '2021-06-12 07:00:00', 1, 2, '2021-06-11 15:23:51', '2021-06-11 15:23:51', 'Admin', 0),
(2, 1, 2, 2, 1291, 1294, 350.00, 400.00, '2021-06-11 21:00:00', '2021-06-12 06:30:00', 1, 2, '2021-06-11 15:38:37', '2021-06-11 15:38:37', 'Admin', 0),
(3, 1, 5, 3, 1291, 1294, 420.00, 490.00, '2021-06-11 22:00:00', '2021-06-12 05:00:00', 1, 2, '2021-06-11 15:43:18', '2021-06-11 15:43:18', 'Admin', 0);

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
-- Indexes for table `customer_notification`
--
ALTER TABLE `customer_notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_payment`
--
ALTER TABLE `customer_payment`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

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
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bus_amenities`
--
ALTER TABLE `bus_amenities`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bus_closing_hours`
--
ALTER TABLE `bus_closing_hours`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bus_contacts`
--
ALTER TABLE `bus_contacts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `bus_schedule`
--
ALTER TABLE `bus_schedule`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bus_schedule_date`
--
ALTER TABLE `bus_schedule_date`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `bus_seats`
--
ALTER TABLE `bus_seats`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `bus_seat_layout`
--
ALTER TABLE `bus_seat_layout`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
-- AUTO_INCREMENT for table `customer_notification`
--
ALTER TABLE `customer_notification`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customer_payment`
--
ALTER TABLE `customer_payment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `safety`
--
ALTER TABLE `safety`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `seats`
--
ALTER TABLE `seats`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

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
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
