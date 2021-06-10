-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 10, 2021 at 11:13 AM
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
(1, 1, 1, '2021-06-10 15:34:21', '2021-06-10 15:34:21', 'Admin', 1),
(2, 1, 2, '2021-06-10 15:34:21', '2021-06-10 15:34:21', 'Admin', 1),
(3, 4, 1, '2021-06-10 15:34:21', '2021-06-10 15:34:21', 'Admin', 1);

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
(36, 1, 1294, 6, 'Null', '07:30:00', '2021-06-03 18:54:17', '2021-06-03 18:54:17', 'Admin', 0),
(37, 1, 1291, 3, NULL, '22:50:00', '2021-06-03 19:58:55', '2021-06-03 19:58:55', 'Admin', 0),
(38, 1, 1291, 4, NULL, '22:50:00', '2021-06-03 20:00:08', '2021-06-03 20:00:08', 'Admin', 0);

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

--
-- Dumping data for table `safety`
--

INSERT INTO `safety` (`id`, `name`, `icon`, `created_at`, `updated_at`, `created_by`, `status`) VALUES
(1, 'staff with mask', 0xffd8ffdb0043000302020302020303030304030304050805050404050a070706080c0a0c0c0b0a0b0b0d0e12100d0e110e0b0b1016101113141515150c0f171816141812141514ffdb00430103040405040509050509140d0b0d1414141414141414141414141414141414141414141414141414141414141414141414141414141414141414141414141414ffc00011080118018603012200021101031101ffc4001e0001000300020301010000000000000000000708090506010204030affc400571000010303020304040410080b090000000100020304050607110812210913314114225161151932711617183842525657768182919495b4d223627292a5b1d3e3242533374353547475a1d12739636473a3b2c3c4ffc4001b01010002030101000000000000000000000003040102070506ffc400331101000102030406080700000000000000000102030405111321415106121631a1d114525361718191f122324254b1c1e1ffda000c03010002110311003f00d534444044440444404444044440444404444044440444404444044440444404444044440444404444044440444404444044440444404444044440444404444044440444404444044440444404444044440444404444044440444404444044440444404444044440444404444044440444404444044440444404444044440444404444044440444404444044440444404444044440444404444044440444404444044440444404444044440444404444044440444404444044440444404444044440444404444044440444404444044440444404455ef8d0e2f6c5c2469afc2d531c774ca6e5cf0592cce7ede9128039a4936ea2266e0b88ea496b46c5db8094b54758b0bd15c71f7dcdf24a0c6ed8370d96b65d9d2b87d8c6c1bba477f15809f72a519df6d069658eae48318c5723ca5b19dbd2a41150c0ff007b79cb9fb7cec0aa8e87f0b5ac1da419b546a3ea0e43536cc51f2ba3f866a62e632b5aeeb4f4106e1ad634ee0bba301dfe5b8382d19d34ecdcd00d35a08626e0b4d93563000fafc91e6ba590fb4b5db46dfc96041577e3c2b3fde92bbf5fc7fd827c78567fbd2577ebf8ff00b057a7ea4ed16fbd4619fa8a9bf713ea4ed16fbd4619fa8a9bf710516f8f0acff7a4aefd7f1ff609f1e159fef495dfafe3fec15e9fa93b45bef51867ea2a6fdc4fa93b45bef51867ea2a6fdc414bf1bedb6c2aaeadadbee9bdfedb4c4ece9682ba0ab7347b795c22feb56f741b8c5d27e23da21c2f2a82a2ec1bcf2596b5a69ab980789ee9fd5e079b985c07b57c596f02ba079a513e9abf4af1c8039bb77b6da4f4295bef0f84b08fcea84f149d9417bd308a4ce7432ed73b98b73bd2dd629a5ff18d3f2fadcf493b394c85bb6e18767f4e8e79e8835b5167a7671f68654eb25443a61a9954c6e730c645b2ed200c3756b012e8a41d00a86804ee36e700f40e079b42d011110111101111011110111101111011110111101111011110111101111011110111101111011110111101111011110782760b11b236d7f69076854b687554df4194955253b1d1bba53d9e91c79dccfb574ce24eff006d30f62d89d65bc4f8ee9166f75a6716545058ebaaa370f10e653bdc3fe602cc4ec43c7e0aaccf552faf68355496fa0a28de7c43669257bff39859f9906ad6378ddb310b05bec965a182d969b7c0ca6a5a3a6672c70c4d1b358d1e4000b925d0b5af5c30fe1f703abcbb35bab6d96a8088d8d68e79aa6520f2c50b0757bcec7a79004920024672e5ddb7538bb3d98ce97466d8d3ea4b78bb164f237da591b0b587ddccef9d06aba2cf0d20ed99d3bcaeae0a3cf718b9e0d249b37e10a693e11a369f6b8b5ad91a3e66395ebc0f52716d50b0c57ac4b20b76476a93c2aadb52d9980fb1dca7d53ed0ed88f3083b222fce4a88e189d23e46b23602e73dc766b40f124f92abbae1da4da1fa24e9e8e4c93e8baf916e0db3180dab735dec7cbb8899d7c417ee3d882d32f046e165ad676e042dbc0652e914afb607005d35f836770f6f2880b41f76e7e7574b85ce33f4f38afb44efc5eae6a0bf51b03eb71fb906b2ae06efb7380091247bf4e7693b6e39834901067af6a9f0f8fd06d5bc6b5b3030eb232f35e1f54fa4f5052dda3fe1593b761b0ef434b88fb68de7ec969d70e1abd06bc68761b9dc2d6c6fbcdbd92d444cf9315437764ec1ee6c8d781ee01427da9d8dc17fe0a736a895a1d2daa6a1af81c47c978aa8e3247e4caf1f8d74eec76bd4d73e132a292571732db91d6d3440f8358e6432ec3f2a471fc682f3222202222022220222202222022220222202222022220222202222022220222202222022220222202222022220222208ff00884ff309a95f83373fd96459d1d87676a8d62fe45a3ffd4b45f884ff00309a95f83373fd96459b5d8b17586c36cd72b9d41da0a2a3b654c87f8ac6d5b8ff00c820e8dc71e5b7fe32f8e9b468ee3d5ae6da2cd5e2c54a3aba38e7d83abaa9cd1e2581ae6ff261f795a83a4fc28e95e8de1f498fe3f865a0c514419356d651473d555bb6eaf9a57b4b9c49ebb780df6000d82ccaec8db1cba93c58e699f5cc77b53436ca9ade723722aab2700bb7f6f21987e35b2482ae6b7766e687eb4c13cc7178f0fbdbc1e5bae301b46e0ef6ba203ba7f5f1dd9bfbc2a2d94f65a7107a1f90cb77d22cc99786827baa8b5dc5f67b86dbefb3dae7061fc521dfd816c6220c61a8e0b38d8d742cb6e737cb953dadc795df44b94896980f698617c85dfcd5637437b1bf02c4c415da977dacce2b9bb38db68b9a86ded3ec3ca7bd93e7e6603f6ab440003c06cbca08a29f84fd19a4c6a4b043a5d89b2d5246637c3f04404b81f32f2de7e6fe36fbfbd64d7163a3377ece4e27f15ce74e2a2a20c6ab64757da6396473fbb2c2054d048f3d5ec2d78009ea5920dc92ddd6de2a41daf981c594709b2df3bae6aac6af1495ac940f59b1c8e34ef1f31ef584ff002420ec5c74e6f6ed4aece6cc72bb43fbcb65eacf6db8539277219255d33c03ef1bec7de0ae89d8c7f5aee41f85555fb3d328630dcd65cbbb16331a59a4ef64b0cc6d3cc4f5e56dca9e560fc4d99a3e60a67ec63fad7720fc2aaafd9e9905f8444404444044440444404444044440444404444044440444404444044440444404444044440444404444044440445f05fefd6fc5ac95f78bb56436fb5d040faaaaaba8772c70c4c6973dee3e40004a0e9dc427f984d4afc19b9fecb22ca0eccfb8bed3c3f7163591f4921c5237b48f23e8b5db297b5f7b60b08c871ccbf10c5b09bbde6df74b755dae3bcd655328da4cb13a312b61e57b8b7d6dc0716923c40503f65ff123a65a155ba8b62d4fac36fb6e59051d2c725451bea291ec609db2b26e50486b84c07569046fb90826bec3cb5b3d1f57ae240ef39ad54e0fbb6a977fd16a7289f872d3ed22c130b965d1da4b2458e5d27f4a92aacb55e951cf26db0de52f713b0e81a4fabd4003aa96101111011110157ee3f2ce2f9c1c6abd339bcc196592ab6f7c2f64a3ff0082b02be1bdd9a8322b3d6daae9490d7db6ba07d354d254303e39a27b4b5ec734f882090420c57e1f2ece9bb2eb891b61712da6bc505406fb3bc96907ff0052b7dd8c7f5aee41f85555fb3d32e95c6ae6dc39e82f0afa85a35a735966b7e477b92090d9acaf7d649df36a617bcd44dbbc308646406bdfb8e80055b7824ed1ab77091a595d86d660b57923eb2f12dc8d64172653f235f1c4ce50c31bb723bb277dc78a0dbf450770b3c5f60bc59e335971c564a9a2b9db8b1b70b35c5ad6d4d3736fcaef5496bd8ed9db39a7c88201e8a7140444404444044440444404444044440444404444044440444404444044440444404444044440444404444055cbb446db72baf05faa70dab9fd25b6d64cf11f898639e27cdf8bbb6bf7f76eac6af8eef69a4bf5aab6db70a7655d05642fa7a8a7906ed9637b4b5ed3ee2091f8d065ef645697e92ea9e9466d064d85e3f9365943771dfcb78a18aae46d1c90b7b90c1203cade764dbf2edb91d7c958bd60ecadd0bd4da69a4b45927c0aeee1bb2b31e94b22e6f2e6a77f34647b9a1a7de167fdbeab24ecb4e35a78e786aabf09ac25876dff00c636895fbb5edf2334240fcb8c8f07f5d3db4f1eba357fd5cc7b4ead7933ae57abed3c33515552d3b9f46e74d1f7914465fb191cd23d5dba13ca48774419af9cf06bc49f0257ca8cbf4d2f95d7cb1427bc9ae58d87177763aff85d0bb9b99be24f491a3c490acaf0a5dae78de6cc86c1ac515361f7b6b7665fe983be0ea9207fa46f5740f3f94c277eade8168b48f6b232f710d681b924ec07bd604f1115763e2d38d5bc41805a686cd8f4d55e8a6b6dd03636d4450efdfd7bc346c5cf3cc41d86e3bbdfa9256637a3bb728b345572b9d2223596be7d5ebc3e7df671bfd24feea7d5ebc3e7df671bfd24feeacc8f8bfb0ff2c9effb7bd907eea7c5fd87fdd3dfff009907eea936753e63b4f96faf3f4969bfd5ebc3e7df671bfd24feea7d5ebc3e7df671bfd24feeacc8f8bfb0ff00ba7bff00f320fdd4f8bfb0ff00ba7bff00f320fdd4d9d4769f2df5e7e92d19ce7b47b4030bc5ebaef167f4190cd4ecde3b659499eaaa1de4d6376007cee200f32b3af3fe2bb88ced04cb6a70ed34b4d7d971879e592d56394c6d6c24ec1d5d5a797a1ebeaeec61f00d71f18b7883e0fa974bb0476498edcee3768a92502be1ac63378e2774123790793b6077f2703e4569b7656eabe29a83c335059ac969b7586fb8d3c50de68e82211f7f211bc756edbab8cad1d5c77f598f1e002d2699a67497b982c758c7dadae1e758d7443ba01d8cf8d59a9a9ee3ab7904d9157901ceb258deea7a38cf9b5f3102493e7688ff001ab5776e133875d32d3fbcd557e976234b60b7d14b535953576e8e69590c6c2e7b8cd26efdc007af36fbae57883e30f4d7864bb63b6dce6e7554b577c738c0ca4a474fdd44d706ba6976f92c05c07993d760762a87f6a371ad1e7337d22f4dea9d7564f511c77daeb71327a54bcc0c743096fcbf5b94bf6f13cacf2705aafba576355b2b2bf895ce2ed6c8e4a5c7a9ec12c72c45c5c1a65aa88c0c71f32031e7afda95b24ab2767ef0aff52de8753d05d238ce657d7b6e37b91877eee4e5da3a707cc44d247b0b9cf23a10acda02222022220222202222022220222202222022220222202222022220222202222022220222202222022220222208278c1e13f1ee2cf4c24c7ee4e6dbafb445d5166bcb59ccfa39c8d8823c5d13f601edf30011d5a0ac61d16d3ec87879e3a74ef17cce84daef16acb2df0cece6e663daf99819231de0e639af041f61f23b85fd0a2c71ed71b2d4e9cf1638267b48d2c1596da5a8649b78d451d49dff00335d0a0b71da97c4efd23b429f8ad9ab3b9cb7326c943098ddb3e9a880daa66e87704822369f6bc91f25533e09b487e833047e57708792ef7f6830870eb15183bb07bb9cfaff0030628c731cc2e5c7ef17d5b7fad8e7871585c3bba690f5a4b5c2ed99174e81f238f5dbeca471f00ae95c2e76dc6edc27adaaa4b55045cb1092a256c3133c9ad05c401ec014f6a9fd52e7bd2acc269a69c05aefab7cfc3847ce77fdd1ceb9f1016dd0a6599d71b455dd45cccc19e8b2b19c9ddf2efbf378efce3f328a7e304c6bee46effa5c3ff453066153a4da8229064970c5ef42939bb81577188f77cdb736db483c7947e65d6fe97dc3e7fb0e15fa7c7fdaa967adaee97cb61232fa2cd34e270f5d55f198d74efddc6383a1fc6098d7dc8ddff4b87fe8bda2ed00c6a5958c188ddc17383773550f99dbd8bbd7d2fb87cff61c2bf4f8ff00b55e5b8070fcc70736870b0e0770457c7d3ff7563f1f35bd728fdadcfacf9a64b8dbe9aef6fa9a1ad81953475513a19a0906ed918e1b39a7e704854d742751ae1c00f17f17a6cd33f0cae70a4af3b122a2d92bb764c079be2700ef9d8f6fd92b6b6fcfb18bb56c5474391da2b2ae53cb1c14f5f14923cedbec1a1c49e80f828978bed1efa6669cbae96f83bdbfd85afa980346ee9a0db7962f7f41ce07b5a47d92574f5a35845d1fc7d59762e2d5edd457ba75e13c27fafb3e5ed9dbe53def5af4ee9e82665630e342a627c0ee70f6cd5327216ede20866e36f1dd582ece2ecec3a4428b53f52e85aecd6467796ab34c0385a5ae1fe564f235041e83fd1827ec8fab9b7a2f5190f10dc40e8de3179ab75cdb47536eb153ba41b98edf0ce65e427cc31864fc400f25fd19b7c1547653c17944404444044440444404444044440444404444044440444404444044440444404444044440444404444044440444405453b5f346e4d40e1c2972da280cd70c36b855bf946eef439b68a7dbe67772f3ee6157ad71794e356eccb1bbad86ef4cdacb55ce965a3aba77f849148d2c7b7f18250632700d4d646e9b5ee6a36ff8f5d71e4b839fb737206ef001fc5d8bff002b994c9ad9a61f4e0d3faac67e11f82bbf9e19bd27b9ef76e476fb72f30f1f9d5558ed775e03b8afbde1f90ba5763d24829df525bd2a281eee6a6ab6f912df3dbc0891be2af143347510c72c523258a4687b248ddccd7348dc10478820820ab744c554e8e3b9fd9bf80ccbd2a99fcd3d6a67df1c3e5fc68a71f1780fbbafe8afef53e2f01f775fd15fdeab948b3b3a7929f68f34f6be14f929afc5e03eeebfa2bfbd4f8bc07ddd7f457f7aae5226ce9e4768f34f6be14f92b0e94f05834cb50ac9940cbbe11f836632fa2fc1dddf79bb1cddb9bbc3b7cadfc0f82b039be5d4780e1f77c8abc814b6da675439a4fcb701eab07bdce2d6fe35ceaa55c69eaecb96dfa8b4cb1cef2b5d0d4b0d7b29817ba7ab27962a7681e25a5dd47db380f16a4e9453b8c3462ba418da29bf575b4ef9d2234a627dde1ef9497d8ffa4b367dc435ff00522b6958ca1c66924309647b462b6ab99a1ad1e00362ef8ec3c376ad9a500703dc3847c31f0fd63c62a638fe88aaf7b95ee566c79ab24039980f988da1918f6f213e6a7f54ddb62348d20444464444404444044440444404444044440444404444044440444404444044440444404444044440444404444044440444419f7db23a6360bce81da7379a903725b2dd20a2a6ad8f60e753cfcdcf13fed9bbb5ae1ec3bede277a15c2c715b1e174f4d87e6550ef809a79282e6eddc68b73fe4e4f3317b0f8b3f93e1a41daf5f5a0d4ff00c7683fae455df862e02b08e2cf81dc52e3338e379cd354dc62a5c829620e32345549cb1d447d3bd60f23b8737c8edb83b5354d33ac3cfc7606ce61666cdf8dde313ce12652d5435d4b0d4d34d1d453ccd0f8e689e1ec91a7c0b5c3a11ef0bf554a333d19e24f81caea86bedf59578ab1e5de9d4319b85a251f6c46dbc24ff1846ef9d7b58bb42ae0c898cbc61949552edeb4b415ae881fc97b5fb7e75662e533dee5f8ae8b63acd53b0d2b8f8e93f389f395d540092001b93e002a7371ed0c6b612287062253e0eabb97aa3f136304fe75d568f50f5ff8b3ae7d8309b157cb4731eee5a7c7699d142d07fd7d538faadf6f33da3dc9372984587e8c6617aad2e53144739989f08d52cf12dc58d160747578d621571d764f20314d5d0b83e2b7791d8f83a5f60f06f89ebd174deca6c76df95f1916a9ef548db8cf6fb7d6dca0355bb8b2a9a1a1b2f5f170e77104f81ebe201571b838eca3b3e9757dbf31d57969726c9a9ded9e92c507af6fa278208748481dfbc1f2d8301f27f422bc76718dbb45b2ff00e45f7f680abd554d53bdd3b2dcb2c6596b676b7ccf7cf19ff394366911168f5c44440444404444044440444404444044440444404444044440444404444044440444404444044440444404444044440445c564f95d9b0ab1d5de6ff75a3b2da691bcf3d757ced86189bed73dc400829df6bd7d68353ff1da0feb9172dd93df59662bfeff0071fda9eaa1f6917683e09aef81cba6981d255de69197186aea323981829dc62e6d990c6e1cef04bbe5bb9474e81dbeeade764f7d6598affbfdc7f6a7a0b82e635ed21c01046c41f3516e61c2be8f67b50ea9bfe99e2b72ab7925d532da616caedfdaf6b438fe752a220852c7c14e8463d54ca9a3d26c4c4cc3ccd74f6c8e7d8fbbbce652fdaacd4162a18a8adb454f414710da3a7a589b146c1ee6b4003f32fb1107abbc3f18feb58cfd9c9ff78be5ff00c8befed016cc3bc3f18feb5807a1dc475270b5c65e519b5c6cb3df6de2e175a0a9a6a59847336396a1dbc8ce61b39cde51ea9201f68f141bfc8a28d06e28b4df891b27a7e0d9253dc676343aa6d937f035b4bffa90bbd6037e9cc3769f27152b78a0f2888808888088880888808888088880888808888088880888808888088880888808888088880888808888088bc13b0dca0f2bf0acada7b752cd53553c74d4d0b0c924d2bc358c681b97389e8001e65545e273b4db4b7407d2ed168a919ee6116ec36cb44cdf47a778f29ea7ab5bb1df76b03dc08d881e2a80d4df78a2ed37bebe968e29a8b086cdcae8a173e86c549b1ff48f3bbaa1e3d9fc2387935a105c6e26fb5b301d2ef4bb2e9bc31ea0e48cde335ac7965aa9dded328f5a7dbd91ecd3f6e153ec6f46389ced25bfd3643955c2a2dd869939e0b85d5aea6b640dff00ca52b76329dba7301d76d9d22bc3c327658699e8a7a25e72e647a899647b3c4b71800a0a67ff00e1531dc388fb690b8f40406abad1c4c8636b18d0c634001ad1b003d810677ea0f64e60f8970c397dab11a6a9c97539d4acaaa5be5c08ef659617890c10c63d48848d6b9807577ac37715197650f18962c0a82ab45b39ab658a492be4a8b1d6d69eee332c840969242760c7f382e6efd09739bb83ca0eb02a1dc6bf6605935fae75d9a60355498ae73504cb594d3b48a0b9bfcdefe504c529f37b410e3f29bb92e417c01dd79589768d76e2fb810e4b364b6bb9d76334879228322a675c6dfc83a010d5c6eddaddbc1a24d87da853062bdb7ae6c0d6647a541f38f9535aaf5b34fccc922247f38a0d544598974edbdb0c54eef40d2ab94d3edd0555e628dbbfe4c4e2a22c9fb537882d73aa763fa63894163a9a8f55adb0d0cb74b875e9d1ee05adf9c4636f6a0d18e30f8bcc5b853d39abb8d7d5c15796d5c0f6d96c4d783354cdb10d7b9be2d85a7ab9e7a74d86ee202cececcde0f6d9c48cf9f675a9f64f86b18ab89f6ea475497c6e9eb64904b35444f6ec5ae8c003981f1948ebb10b9bd07ecb5d4bd6bcb9b9b6bfdeebad94d51209ea28aa2b7d2aef5dec6c9212e10348e9e25c0740d6f42357f0ec3acba7f8bdb31dc76db4f67b25b616d3d25152b39638983c80fce493b92492492494193faf1d94fa87a2f7b199e83e435f7a6513ccf050b6a7d16f347b7faa95a5ad9b61bf87238f872b97d9c3e76b6e5fa73751886bbd82aee5e8927a3cd77a7a6f47b9d2b874daa29c86b64dbcc8e477b9c56b6a86b883e11f4cb898b59a7ccf1e8a5b9319c94f7ba3da1b853fb3966037207da3c39bee41dc74a759b0ad6ec663bfe0f91d0e456c76c1d252bfd785c7ec658cece8ddfc5780577458c7aadd9f5aefc1e64d2673a377eb96456ca5ddfe9761de2b94318ea5b3d28dc4ecf6f2f383b1258d0a5de1a3b61e92a65a7c7f5b2d26d756d7084e4d6981c61e61d09a8a61bb987dae8f71bfd835069fa2e130ecdac1a858f525f719bc515facf54de686badf3b6689ff00339a4f51e60f51e6b9b4044440444404444044440444404444044440444404444044440444404444044440444404444050ff00167a45926ba68264f85e27908c6af7728e36c558f7bd91bdad91ae7c32399eb359234169237e87c08dc29811067870d1d90586e04ea5bd6ab57479c5e9843db68a5e68ed709fe36fb3e7fcae56f91695a0768b3d0d82db4d6eb6d1d3dbe829982382969626c5144c1e0d6b1a00681ec017d88808888088883d25859346e63da1cc70d9cd237047bc79a8e324e1a749b3091d2def4d713b9cce3bba6a9b2d3ba43f3bb937ff009a9291043f6ce0f743ecf5026a5d25c363941dc38d9607edfce69526d8b19b4e2f46292cf6ca3b5520f082869d90463f258005c9a20f006de0bca22022220f046eab6f12dc01e957130ca8afbada8d832b783cb91599ad8aa1cef2ef9bb72cc3c3e58e6dba070564d10519e03780bce7848d4fcb2e976cde86ed8b5751fa252dbedc2567a4bfbc6b9b513c6f1cb1bd8d6b9a394b8faeef5b6f1bcc888088880888808888088880888808888088880888808888088880888808888088880888808888088880888808888088880888808888088880888808888088880888808888088880888808888088880888808888088880888808888088880888808888088880888808888088880888808888088880888808888088880888808888088880888808888088880888808888088883aa693e75f4d0d2cc3732f41f833e88acb4577f42ef7bdf47f488192f77cfcade6e5e7db9b946fb6fb0f05dad455c277d6b1a37f81966fd86152aa022220222202222022220222202222022fc2bab23b75154554dcddd411ba57f234b9dcad1b9d80ea4f4f00a0bb8f1095f7a6e9adef1ec7ef8fb5df6e9534eeb531b432d4dc6116f9e68dd1b84ee8d8de76b1c4ba48c8e47076dd4109ed14516ee24b16bae3d70bcd352dd1d49454b6dab95ae818d7ed5b2ba28d8017fca63d8e0f076036e85cba7d1712f94557c0dff00671777fa76635f8dfa92d00ef2383d33a337ade92b7d1473176cc3cb272efbb370b0e8a086719fa733d6e514d054d455bac349575b27a24b4b33ea23a57864fc90b2632b0827a09991f38eace61d576cb6eb732e9951c6e3c3b228af31d07a7cf4b31a163a06bbbdee9ae1e93d4c9dd1d8b7998d2f687b98edc0092d140f85f142fbbe9ee3379ba6177f7deae96975e67b7dae3a693bba363585f563fc2481113200d61777cee576d1f45eba95c45b2a34d739ba6134d73922b45b259a2cad90406df14e29db3b5bb48fe7710d7b373dd1602794bb704209e91755c47526cf9ae355791d019998f42e90c3749c35b0d5c2c1eb5445b389316e1c039c1bcdca5cd05a5ae3d4e9f882a5abb4da6b21c33297cf7b91a2cd4060a56d45ca2313a533461d501b1b031bb9ef9d1b8733472eee0084ac8a14938afc60b5b2d258f23b852b62a37d4545351c5cb4b2554d253c1048d74ad7f78ea889d0ecd690d791b90dddc3b8daf58ec157a7976cc6e2cacb05b2cefaa8ee905c210e9e89f4ef73266bdb09903882d2418cbc104104ee83bd228eb5db3dc8300d20c872ac4edb4375afb75be7b80f84a57474f145140f99cf735beb3fa303431a4125e377346e4705a87c40d16199ee3d8d1963a563e28ebef9749e86a6a296df4b212c858e7c439629259010d7cae6b1ad8de5db92d0e0989155da9e2baf54770bfb47d0e56d4d2d25ee618d87494f5f693425c227d74af90b0326d983e447b1959cae78f5978a4e2772475bcc35d5762b2b4de23b73b2abe596b2d9454cc7d19a81df50cf3366638b80898e7cac63f9b769e81a42d1a2add6ce22f20be3b0cac9ea6dd89d8ee96da6aca8b9d663570b851d5492d5490b5b155472c5152b5ed8daf6ba7dfa5447d0f9f67ba6a265f856a60a1bfe498c56e2d476ea9bcddcd2d86a69aa28297731d2b7bd35b287c9249cc00110e710cbb00794209a91577a9d74cedf8e5ee796cb0592e54d95c5686b5963adbd3adf4325b61ae6bea69e964123e51df08ddc8e0c6b9c0750399dd90eace446f3a4eda0758efd8ce5152692b720a7649077f21a2aba868a6a6323cc401a51cdde3dc473f2804ee5a13222220222202222022220222202222022220222208ab84efad6346ff032cdfb0c2a554440444404444044440444404444044441f9d443e914f2c5de3e2e7696f7919d9cddc6db83e4546b8c68159b1abe51de9d77bbdd6ef4f7596f0fabac753b4d44cfa3347b3d91431b36111f16b5ae2e00b9ceebb910709f52ae371d2c5494d7ec8a8e84d3d2d3d5d2c151006568a6a87d440e94984b8398f91c3d42c0e1b07076c17312e80db4f3fa3e477fa2e4c864c9a8fb89298fa0d54bdff7ed8b9a03bb24f499b7127391cfea96ec36220f59b87cb5cd60c8b1ff00a24c85b8cde20aa80595b3c1e8f442a1e6491d0130f79bf31772891ef6b43886803a2e7efba5d4791e7b64c9ebaed7390d9e4351496b06114ac98c4f8bbcdfbaef81e591c0b448187a12d3b2220ea14dc31da2df61b65ae872bc9e81b6fa19ad115553cf4cd98dba4e4ff03713010636f20e57ec256ee76937257ed57c3463f25aefb66a1bd5f6cd8cde69dd054582867845235c606c1deb39e27481dc8c6fabcfc9cc398b0bbaa220ed566d2db7581b72a5a1aeae86c970ada8ada8b21ee5d487bf8cb6689a0c65ec8dd239d316b5c3f8473baf292d3d6a9787aa5a2b55a6921cd32b6d4d95edf81ae0e9e95f3db62113a2ee63e6a72c91858f20999b238f2b4976ed690441ed6ee1b315b55baa28a96a6e91c350eb4c92175431ce73edf5aead8de5c584974933dc6427c438f2f21eabbc62386d16190dd63a296795b71b9545d25350e692d9667f3bc376036683e00ee7da4a220f8f53f0066a861175c5ea2f372b1d0dd209292b26b5083be960918e64916f3452340735c4121a1c3c9c1753bb70f76fbf070b8e539155b2b2921a1bcc7de52c6dbd43139e636d48653b4376123984c1dd1734ecedf64441ce5f3472c593bf2d7de24adb94991d3368667cb306ba9299a3d58a9cb5a3bb6879749bf57179dc92034378c8341e80dab22a6afc9f22bb56643e8f15cee95351032a6a29a1dc369778a16319116ba46bb91ad79123cf3ee770441c965da4747994f4b054deeef498f44c8639b1ba27411d054b62787b1af1dd191a370016c723038000823a2fadba538e54bb2af85a862c8e3c96a639ee305e618ea617b63631b142232de5eed9c80b5a41f59ce7124b894441d6ed3c3963387fc3afc2269f4f67bc57c55d51363349454e408e9d903606b5d4ef6775eaba4e52d24492c8e0417257f0ff00452c185d35af2bc871fa2c4e6f4aa1a6a13472896a0c7346f9a6754534af7bdcca8983b6701eb93b070041104a88888088880888808888088880888808888088883fffd9, '2021-06-09 12:41:54', '2021-06-09 12:41:54', 'admin', 1),
(2, 'sanitizer', 0x89504e470d0a1a0a0000000d494844520000012d000000a708030000007361fad60000006c504c5445ffffff5d5d5d5656565a5a5a555555a7a7a7fcfcfc525252f7f7f7fafafa606060686868e6e6e6f2f2f2727272dedede909090c0c0c0c6c6c6eeeeee848484e8e8e8d2d2d2a0a0a06464647e7e7eaeaeaed6d6d66c6c6cb5b5b5969696c4c4c48a8a8a7979794a4a4a93939336d9f24100000b9049444154789ced5d8992a33a0c0c96c184fb0a370999fcff3f3e20101c1f648ebc0d57d7d6d6ee844c814a925b2dd91c0e3b76ecd8b163c78e1dab826b7dfa0e16033d0742d2f8d3b7b10c843556140594e2d337b200683e02a50594e1a7ef65f6b0cf703796a2e0f3a76f66ee080ca43c80fc4fdfceaca1250fc7ea62d1dc63518ea2c4ca1350a67dfa9e668bdc008501049fbea999c2bd62d6568db5bce3a7ef6b96b8a49c63b5d68af44fdfd81c1183c8580a4af6c4c5433b2391b100ede58f00f6551887c64eb844d02381b548e97efabe668a8a270f8abae72c090a833116de151b29028698029cf583b5b307212e0c7f404a93de8334f9f47dcd12156158561d1e420fc15ef70810f4ea5f4fb90057daa1709a3a081cfbd3f7363bf4341e45b9d2fe0347d6414bc8fd67f5a76f6e6eb0cbce30380b0f152284a88d3fe9d7c1cff6587c425ff360af5d00f522beaf8356bf4642da75ca743776f705b241d1190b5d990c55f5ce85b3e63f56d4385db477180f87ae4004e7c4fedcebcc05657038def3194a77d9b9e8228ef0e9e9d4c422908e4af4fc029d375f0925a8b383e093404166c3512fca83b8e2ea9fdfdebc603bad2d52a1d670bbba07fd4cb17c30b878dd16ac36cac0137ea66987b87c1209b7ae3b07449cb53a1c55567ec6f9bfbdbd99c16ffb3c445cdfb80eaf3ec3a6274982af962508bb6015df5d6caecdb61c8bb66728a52810ed080b9b40ec2489b62956712c62e14297085ab177735192aa5b25b773526d5ebdb765c61a69bfee9b8050f3078179d9727c365e4364d66aeaeffb15d918aa80af9b2e2243b9b53ac2d1d78ea3c7a55b9676b448d8bbeefc28b10f96c75a13d096b3972b1c22694a4aa7615cbe6068029c2d0723dbd9b89b849cc3867520912537ad4a6b1e6f12d452b3a0940429d9f2d0846532e602529f0eba2a66adede7e696633178e65c90fadac195395677c5f5d3b7fc493ccd7491ac59f418dec0c5e296e5c2701cea02436d09e984637530b63c69120feb222e5bde20122598582c37556433503bfb00348434ac85bc8101def2a089dec62232a778038b2d5740160078f6c13e7fc7b13a3f34b63c685241c3390b81e62cc3a6bb8e7ad810d269dec07ad77a29bd7b797d4934a1dedced03980a5480b5761d3507bda856b4eaa56321d3cb9372bc0ad52b55527384eac96d4fa75a5a160eae44a2d697c2db5827a175761ddb91113455ad5ccc57e91d0cbfcfead46e0ebc4665506b87204091c6a2a692575148b2473b96d20f215b218dc8ef836e9164c997ec947a722c9abafbe36a80d647e9dd615a52b2e40bd5531a5df54881d2f2c9eacaebac8f1c100ffd151265fee1586df5f8849333c6223f6cb86cf80f4f109ffb709b8ec36e148e414cc5a278ca69a9081dca750471739a8c43805a94c8a94cb72e959e1e74808cffbc92f6f63b63f9c2a581da14ba2a95de7a7a7a8123d413590b49a7c18bd1b940b6d62e0f0c3b106ce8116e1dee1d6b629ba73abae47a54fa82b105c7e87547da087306a6ee660e372aa88f3e09e95a060933b657983295f051622d20036fd07c0030b92ad3a262d159c7d11bac6b09c286b567ef83cea02487dd05940e5fa8779fab4673ad43a517d4345ce612953d40bc81c80ef5f6b0c9ec586162768c54f3a86fae81d25b29670893dd5b17f37c0bd2cb90def5a1de06a5b3f2a95d1420ea3eb3a9f2da5c4179cd57801039f5f342a7b363100aae4721e6f8984942b7e67bd5dd403d1109a8585cc1f1707c0687a862a7e62b261441a53fbd8cfee387b7e1a4c17e0b4c4265fac553fa5030abe6595f4c8ed19f19173019fbfc2056c6d86a04a773507dd49d41597a791df3d6c2b99daacc65eef365cc53eb54761a2fea4d5e8c3f41f5c2297d202007b15e72cb7d4ec762ca7e1af3bf4441d0af9939a5d22f9cd2f3be05d7a3adb0be7538d2a3ba29e7222a3fa95b3fea472a8c61d92afd89e7a6c1c1fae227182c2ac880a74e4c29090ad5eba155faebb23b662c39686574f54ba0a0fa94b5f8ce84ca54e64fc204b5a422ce6b1705153fa9c8c4d31b7a251458285e4e98bc767a9e992739e341ab51e92de39c3d7af14849f4362d0b47894253168b0123db73bcea44d10867d1dbfd73b3a81c82114204bc565789650b7d4087daf8ccdc8812d4dc57a903d0d0ed7f7a907f83cc3c1ddd2a39ab97b0b55291a632124929d2636722be7235372fbfd2f22c7e3d9d3263d819153a5a05a67495a765c1e199e32f4135c0fd8ad3d3a78b56e9f51b64bead1f8fba5d5d4936519e5067e40dcf9c53f99d220acc179f48302c9cd2c7d1d79713454ef3b7b8813380b20dba3787ec71ba198f53e1e479b48639e672e92afdd1aa6e5956e7af4e3f3a52326a5fc60cb91f203f8e828341ebf03ad3348272d1b1f87d503b7ea0b7c83df7e36bdca6c0e15370c6ef04dca8ea66ce92a0a6677a4de6d89029805be7958f5dc5600e5fb005a3aa92831456088ad2e37b195328e32b6c7aada2db09d4c1bd8ac602c84642919e9e193a1345fe5847f51a75233743fecbc5d339eb9a8c9802d5d380942baf4304d81c3ccdad2513859b495c4f52bbe0ccf9a03cf79ea6894ff5efbeb76c29e227a08f549f78714de8c9475537e45b8762ac17c190490a3c6fa0f3d696364c512abd64c8de9e9e81268b966d7e08ba921176265ce958cedd23d733cff51d58d49919fcfe018d3b088eb5d6a2459b9f8392f720626884554f4d5e2a1b3ce74c93aaf48fb708ca8db5f03ed92f1052fbd0112538d85343aabdb13643e44750021fa5d2fbaff74e6d73bbb540a5b79317e9bd3d337b2d13a83fc391dab5d99d44cfbf45501085c956b41a1631f5261b7012357a79a406988beebdfe0d4f1d0cf4f2e08371067a93d0e4db0e0440e6748764f570b981d40963d54b9f0cfc335eeef27c4421545b4def14eaef9d3c42a2cdd17711acf21bb1084ab2b1c25006c1ce031688df30357f68ffcf19ddaf76f3033a2f48fad34e6e7cc9933aba5eaf911ab8efa63ce2179f8e8e552e44cbd2b430c8bdcc490163041d1036af5eeebe75792a266211503477c73a865611fb6a7d054230b0752e00262852e3f7994c95c6e24c5faddbe4244d3f15819f27b728734a03089a92030083999d7deb2d99cc16ef5f6c479466c81bfcab53a60af9228d2bf5213795491e3e86c8575a57f1e9cf26b384ced59df4393fa8e47bf6119a0c839325c11f533fbbc7ac05924f647e14f2bcf14d8b2142ccb35ffc3e1f6b09b77305ab3325a47fb4d6fde910369c5a8d7ff9881ad3e6e94efa9c27de61adce62ad93452ff53a3bcebd3a67c24cab80dab6d99ef43957bccb5afd934e2efa9a9b5c9b5c0798cb4aaed758bba574089c78c642d65badd594c0d2aa2e8c1383f412a9e0fcc4939f78753df777fabcd75ae23728365e159f1da037298ac4bda33ed3dc3ee2cdd6e2ce1a69700ace409e8577326f1792e2cdd652803d9925f01cc49fb1b1d041db77fb96495bcb0a3c4c446fa159eadb26df9db76e8f154df7bd52dcf802345b42f5027fb216af51187d42b2fc8888bcaa053617a25af1f88bb5522f2b8d9697a2ae1c6ffe751f65b7abda941d34dcac8cc9dc552b39fe622de356c5451cb7eaaa1739a651dedc868156592b8c49be824d75be4cfd35fe16896d8198ddd4c0d5f5f0740ab5b08a52f9f1d5cbf6ab167fcef2d05588c4acd52a71c8c449df80cb7cc97ed5e28d55359e1afd0064a8cbf6ab162fadf54ba990f925d8618f79582426ba08f7b5ae34befb9a14b9ad90912fdfaf5a88ad058071592755dc269ae0acbc1adb9bb415765633f4c159ab73a9d4abdcd3183aae0abf7530c069b5f4dc3ee2c95a0dbd84ab970bfa125a1029bf580f005f67d914fc2d066b752e65de2e6e28912e75f7f65307036cfaebf1ab169db50023c753e35799f85845bcf83261ab6c557ed54225082b7593a5be9588f5e23cc9aa9efceab22ebf6ae127fecf9439fd524f143783ad50b654516612bf58db8f565e4ef3765c066be0a26f839b678ac4c30045abf4ab3fc1b6f2f69c32d662409cdff6acd70e3b48a2148f6a16340bc686b797bc866d156a9476f34c84942fcf49dad122b45cf7efb35c3b76ecd8b163c78e1d3b76ecd8b1e31df80fd80588750775d9800000000049454e44ae426082, '2021-06-09 12:44:03', '2021-06-09 12:44:03', 'admin', 1),
(3, 'thermal check', 0x89504e470d0a1a0a0000000d49484452000000c8000000c80806000000ad58ae9e0000000473424954080808087c086488000000097048597300000b1300000b1301009a9c18000015e649444154789ced9d79901dd57587bf9106a11142a00523b18a55200b5002060c189b00364b4c48621c8760c722c638c42405b189a11c03860a8e17128ce30d3b204aa1486cc086128b00636344426ccc0e426c62d36863d08624a491267f9cf7a2eed3cbebeed7dbed395f55d7ccedf7baef9d79fd7be72ee79c0b866118866118866118866118866118866118866118866118869188915537c0e8c8b6c08780cf02b380d1c06bc0bb15b6298eb1c005c04780678177aa6d8ed1347a8099c017807b8075c0903a3602f380f3805dab69662847022fb2b59d4f54db1ca329ec8658879b80a5040511776c01fe17b804786fd90d6fd10b5c0e0c86b46f5c456d321c661c701a702db0807482e8742c04be011c0d8c28e16fd917f89f88b6cc2ba17ea301f4220fec65c07c6013e91efa57801f025701cfa4b86e09701d702a3296c99b7380b511755f0bf41550a7d1100e00ce076e0756914e106f03b7007f8d7c436bf6032e021e46ba5849ee39001c91d3df3609f859443dfdc04939d5633488f7006702d703af934e101b815f015f461ee234b38b93817381bb9099ad4ee395d9ad6bb272322282b0fbdf8688c730e843a632bf013c4ef26ff2f6f134f02fc029c07639b5691cf009e066e2add66ac4028d4a71ef3ee0bb11f75b03fc552e7f81e12c238043812f01f7031b482788c5c08dc027812925b47714f04287362d44c6279d3814782ee21eff0dec9373db0d47988a0c44ff0b58413a41ac05e6228b66334a6e779b873ab4b17dc40da6cf43ba80fa9a4dc0a5d862f3b06247e04f80efe15ff04a7abc085c097c9074dd97a2f839fef6dd0abc45b0dd518b8de3099f717b015914341ace28e461be127884f085ae34c74a643ab72e5c8fbf7de70013906963eff98323ae1f4ff07ff223c49dc4682833906ecf5ca2e7f0a38eb7809f20b3465f019687bc6725d5ad686bbe89bf6d5f6a9d7f409d3f2ee61ee72383f05781d30b6ba9511953804f2103e4c5a413c4bbc02f808b81c308ae4cef807ca3eaeb9ea59885b9b45c82bf5d5f6f9dffa93affb14a5ae700bd5537a000b643bc5f4f004e24ddb7f910f014706febf835e22c18c52ae033c0f36c7df8000e042e4456beabe42d559ed8e1bcd14046228b6b5f4616dbc2665ce28e3790befa99c0ce5db4e3fbeabe2ba8ded5e20cfc6dbaad75fe2a75fe924a5a6714ce2710b78c3482588db87f9c8fb883e4c53882334455775dfe007f7b1e6c9dff823affcd4a5ae700ae77b18e41a666e31844dcc1ef05ee433c4f070b68cb6ac48de302cfb90f23fdfdaa1850e509ad9f4576b17a114b3c05d8a5f5d3fb7bfbe768e06a6406b1b6b82e9030473e9031415b100f200f6f19dc8d5f20334baa378aa2c620870047112e809d48ee667f05e294f95ccafa8d84e8c5bc2f02bb57d89e3d547b1657d81690090b3d2b07b256e33d3f3fc53d4f053693ae5b1b771c94f58f33e2e925b8ca3ba6d2164977cfdb9eb7ab6d0e10f4191b8b8cbdbce716a4b8df6cf211c626a48b556b5cee624dc5dffe7ee2a764cb400b744325adf03380df397202dd75b17e83ac2b4531d4baff62e433e9f7fcee3dd74f7d134ffc3f2e0b448f3f5e4c797d2f32459ce78734559597e478efacbc855f201381279107b9a7756e7cebf7a104f7fb37642afd50601941012c41ac4323184e02e943a6854f070e676bd0d03b486cc6ddc00dc0a22edab4972abfd0c5bdf2226c266b333271b143ebdcc8d6ef2b13dc6f0809ff1d169411d45f146904f249e065e0df916409de88baed9085c64b9107fa3bc0f619dba4e33cdecc789f3cb1d5f42e68ba40b64156c96f245998692ff037c06f81bd33b449d7b134c33df2a68ab590c6d07481cc063e1d71fd20d183e8fd815f923ef24f0ba42e63102f664152e0aa404610ecef6b81fc2df0e7eadc3ae09f91b9f76d9171c9ae88fbfa4beabdbb23b1dd3d24470baa0e02310b320c998a7f4e5d776576426218bcef5988a4cb8962343087e07c7ddc94a6e65975ed2129ae2d8acfe06fd30dadf3d7a8f37f5745e3ea8eab16a453f7eaf3f8a3de0610f7f7b859a50d88187436c08b52b44b87ae56bd920e6641baa2a902f93355be0cc988de892d4877cb3b8fff5e92255d188b3f0fed46c4e5bd6a928e412610cfce48cccbd7e82e2cc0299a289089c0344f79235bbb154958846455f79224ce7c17556e472f564d9405d1e73b59909f21be6eff803817ceeabe69f5c75581e8b1c48b31af3d838c47d2f0882a2799f2d54e926fa4acb328f29ac53accf3fb78644de95e8293258dc25581c45910fda026e95a6956a97292c8c0ba0a24cc82f4905e2037859c3b01f142b89086e6c77251203d04bfd1bd83efddd46b591e54fdb068c184a1ebcd22cc22d880df8973245ba31fbd7412c82c4408da21740cf02d24c362e35cd75d14c86ec8946c9b01fc3e44fa41cde2eea1ad41927beca9caaf67a8b728c2c61b6905b205c9253c03e95a69de073c8a0441d521a34b2eb828904e33587958107d8f240ffb1eaa5c170b02e133566bf0cfd68d255936c8579050e2590485b70d923ce371ea95402f33269070b2dc430be4d50cf51645d48c55daa95e2f3700d391bcc59a03909449dd387ed682260a248fc1725a81f4108c055994a1dea208eb4e9d4170db85b48b854b9135a73f22d80ded411c3f9f41b678304ae216fc2e1267795e1b41300c376d6eaaedd5f549a21427ab6bea106aebe507f8db3740d0a5660838b68b3ac621b9c1a2f649b9b08b7b5746d32cc864fc416003c0fa94f7cf6281f45ac02b29eb2c1a6d41c687bc671ddd8508af063e8764b55c18f2fa395ddcbb325c1488deacc52b90aac61f5a202f67a8b72846121c1f791944bef9f741f28775cb838893e655f8f38f3d9dc3bd8d0e4c21be2bf3a7eaf5b919ea385bdde3c604d77c455df3f5f8b797c634c42b202ab3c84f90d897a23804f8311262b04387f7d612d762d275f74ac770546541ba4d2091373d483ccc55848fc17e89f854e56131e27802c7f72e745d20fa41d40e83590492650ca2db15d6072f8b3d9130e3b03d3f96215b4bdf5a6a8b1cc6b5314827818c53653d384d42964542dd4da94a206723297dc2c4712bb20a6ee24841d32cc83baa1c365bd389b42e2313f1af1faca5fc40a9c9c075c01f86bcb612c9643fa7d4161995f028fe41e631eaf5cfa9d7ef4a79fff7e0cf3bbb99ce7b981fa5eafc6dca3abbe50ca277e0bd87a045341acc4afc0f80ce22325dbd3e487c1cba46cf46fd26c1355966bdf2603ce2821e268cb5c858c31846ec84ff2188dad2e071f5be5f214e749d3808592cf35e7b41ec15c2b7d4351727b8a65b4e465c3bc2c4f110c1b5226318f07efc0fc26311effb38c187e60ee2e7e18f4072cb7aaf594e70d01fc63deabad3125c9395b148dacf30616c40124cb836f162e4c4a7092e72457137c107a81fd906790632ae98886c517603e1fba39fa56f1a81fe262f2a04f55864853e4c1cbf23596209a3c15c8dffa1b83ce6bd93905da6a256903b1dd7246cd34475dd2ad2259a4bc268a41b17b669cd26e0ab24eb421a0de73efc0f47a70d32a720334a69c5f135923fe427aa6b1f4afcd724e350c45d3cac9dcf21517c860104bb32d3e2df0e4884dc65c8ac4e27613c8b44caa5e122758f6fa7bc3e8a5ea4ddda757f88ada1afa3a32e36861fdbe0ef626c21dd22e7042478e7762490692de2e8f824b2c0760ad906b737e37f78d3a4298d623ad196ef15c49ddc307c4cc5ffa0d4615b0190b8736fbb0eece25e2380bf47e257c2c4711d8e87af1ac57124c9a678cb6457fc6d5a49f629d6bd90f59a30612c467696358c484ec0ffd0fca2dae600c1f5963b33dee76c8299e8dbc7cda44ba460e48c2bce8ada1f6aa32a1f0d1c4ff437f86664414fc73f64bd8ed6755e7e1d718f383e06fc88e0acd900701ef09f19ee690c434ec7ffcd7a87e7b56348b6b1fd2664dab4dbebdabca4de7754cabf691ae196632ee977b6320ac215b7049d78c16b51e22c80975e64e5bcdbeb401c20bde94f57124c781dc73688a3e15875fe0a64bcd19fe25e86c1d1f8bf657fe779ed28c25d45f4b111f8bd1cae037148f4bee7a729ff1eed35dc3ef64c791fa360f2768b288abdf1c79f2fc3bf89cb91c8aa765486f1412436e451753eeb758f01333de5bf24b99bfb3424565be7af5d8ec4a318466a46111c2fec58515b7480d47ad2ad4f68efdff6715fbecd34861b0bf03f506171d76570bb6a479c57b1e654a2bb7279b9a918c394ffc0ff40c579f316c5b9041fec0f24bc7604923c2d4a209fcfbbb146f7b8b20e02703f70a6a7fcc7c0a51daee9669d43731c70ad3a379fe4eb1f7f816c081a45d5b9b40cc79942701cf2fb31efef769dc3cbe14888af762d491ada3a12d9052bae1d456638348609f3f03f54712bcd97d2591cede38b31f7f9001208a54575528a769fd9a1fe2d98fbba91037a457d0bd12bd8ddac73b4390b89f5d675a6dd02f909750f9d58a22edec986c2a53108c0cf81a7d8ba59640fb21df1fb086ef5fc30d2cd4ab2cea1bd83fb807f053eabce0f217125d7a768f3f1c0c1eadc1c24b1739bbaec886b3480e3095a813bc92f2efb64827e566d4b9325204a4f0b3f86442e7acfdd1179b56164202cf5cd3cba730d3f0e7820e4be43488e5fedbd9b843d084e14cc4256debde77ed845bb0d23401f92f5503fc88b91f4a34966977a90b1c7c5041721bdc7c3c46f4013c7150485d6876c3de03d7f45c6fb1b05e3da18a4cd7a2451f303f8c35ca700df6bfdbe1ce9cef4b78ecdc84cd18ec894ea74e237ad5c8fcc845dddba362d23080ee6af6fdd57fb5c2dc9707fc3e8c82464a12ee9746e9263333288d6fb84a4458f3386d82ae639eafc195dd6651891f422fb71772b8c35486284bc16ecb408bcabf53af3e38772aad3c81957bb585e06c9be41e452c485e54ee036926df99c843e64ef702fb33dbf4f52afadc8a95e23679a201008a6dbb91c79e0f743b665db111913ac4556c5172199098b5a7f38057fb4e0209280a18d1648969db00c2331f7e2efb27cb4dae60412cacd53af6bbfae51a5b6ce18769495613d09a308fa6e9deb79bd57bda6b78d338c5cd981e060bbca50623d7bb519ffb4aede08c8dc4c6a8c2b594de2d0e38ff6b60755a1bb77f39118fa367a63d195c536c7e886260864ba2a57b94739c04754596f24aa63e94d2035c604922f7b11dc34d404e2304d1088de3bbd4a819ca8cafd48ec8717bd57a209a4c6344120da91f0e54a5a21e80c8c7a7a178202d1712c468d688240b4cfd4a22a1ad1e283aa7c7fc87b740eada8edac8d1ae0ba40faf0af4aafa73acfd80380c9ea5c58c613bdb5b409a4c6b82e90dd54f9d54a5a211cadca6f106ecdb405595b486b8c5c705d20ba7bf56625ad10deafca51f9b27446771b83d41813487e1ca1ca5102310be210ae0b44cf60552590ed09aec744ed17a277cb3281d418d705a2c7208b2b69856c85e0fd5f6e243a464577b1cc59b1c6b82e909d547959e8bb8a47279e7b9ae03e8a6db4053181d418d705a2d3fcd445207ac31d2f635439af2846a3004c20f9305395e3046216c4219a2690e515b46104b248e845fb5f79d116446f506a18b9b10e7ff0511531f6fbaa360c115c2df7f2b67aaf1eb41b35c2650b321a713569b316498e50363a606b31f1ee237daa6c16a4c6b82c109d15f1ed4a5a1114c88298f7f6e0dfdd7613d9b2361a25e1b240f4f8635525ad08269a8b1388defa7943ce6d3172c66581d4c5654327ca8e1388ee5e99406a8ecb02d10f5b554e7f5a20cfc7bcd704e2182690ee1805ecaace2d8a79bfee62d900bde6b82c10bde965150fdb54fcffc321e0b598f7eb36bf9b77838c7c71592075e8ae6867c9651ddaa12d8809a4e6b82c10fd6d5c0781748a6834813886cb02a9a305492b90288f5fa326b82c106d413655d0063d40370bd2305c16887ed8aa10c81455eeeff07ebdcd8159909ae3b24074dbabf0c3d29b7176f226d602a942d4460a5c1688a60a81e888c6b402310b52739a24902ab63c481bf2bb8d2a9b05a9394d1248d9f412ccd4dec98298401cc304929d090477b2b23148c3308164272c4b7ba7b518b3208ed12481941d6eabc36a93ecf3a10552c5c48291029705a207e5234bae5f5b9024f12866411cc36581e829d2b205a22d481281682b6702a9392e0b44bb69e80170d1648968d402b12e56cd7159207a40ac5d4f8a46e7b74a22106de52c6143cd715920da82942d10ed2c6916a481b82c90aa2d8876b7cf2210b32035a74902d15d9ea2d1024992635777b1cc82d41c9705a2bb58650b244b3c8a8d411cc36581e8240d650b44cf9a2579d84d208ee1b240749a1fbdad40d1e8ff9d09a481b82c109d205aaf4b144d96802d2d902d39b5c528089705a273f1962d902cd6208bd5312ac46581680b12b7274711e4d1c5320b52735c16c83afcdd9a7104e3338a248b40f43526909ae3b240c03f501f41d0c3b648b437b1599006e2ba40f4384487c016891e94278947d116ce0452735c1788de554a6faa53245a203ad6230cfdffae22d1849102d705a263c0279558b7ee5265118859909ae3ba4056a8b2deb7b048cc820c035c17489516440b2449c0961e8398406a4ed304a25381168976964c62416c90ee18ae0b4477b174a6c32259a7ca59046216a4e6b82e106d41762eb16eed4d9ca58b65d41cd705b25495279758b7b62049221acd823886eb02d1fb715429902cce9226909ae3ba4016ab729902d15dac24ce9266411cc375816cc0bf9a3e9af256d3759286b2dded8d12705d2010b422bb9454aff6032bdbddde2881260a446fac591455076c1925d00481bca9ca7b9454af599061401304f29a2aef5e52bd5a2063283f81b651304d1088de9bbc2c0bf22e417793b4dd2c5b38ac394d14c89e25d6ad37cdb16e56c3308174c7802a77f226b6750fc76882405ec7ffe0ed4e796381b4dec42610c7688240dec5ef72d24b7903f56edded6d0c52739a201080975579ef92ead502e9e46eaf2d4853feff8da5291fd08baabc6f49f576dbc5320b52739a2a907d4aaa57076c99401a465304f2922aef5f52bd66411a4e5304a22d48590259a2ca69c72026909ad314812c54e57d28e76fd38e929d2c884ed2d094ff7f6369ca07b41aff54efb6c05e25d49b5620368be5184dfa8016a8f20125d4b9067f02ed3ee293d79905718c267d405a20d34baa575b91b8454ab3208ed1a40fe83955ae4a2071dec466411ca3491fd033aa3ca3a47a4d200da6491fd0d3aa3c9d72febed75539ae8b6502718c267d40cbf02fdc8da19c15f534015b2610c768da07f4942a1f5c429d8b5439ca821c079caece35edffdf389af6013da1ca334ba8b39305e905be0adc4770a57d53518d328c303e854ca5b68fb925d4d9a7ea1c646bc0d661c063eaf5f67113c932c21b466e1c84ff215c41397e594b55bd8703d721dbb469616c06fe11f3c3322a6024f00efe077213f2b0161944f508412b126635fa81130b6c876174e441c21fce41e016e004f21d7bf5007745d4a9bb5465eea16818a11c02cc27fe617d03b806f830321d9c9671c0a9c07790cc8e71753d0f9c94f9af312aa5c9fde08f035702fb7578df20b2c8f824f002f2c00f20db1bf420029a884cdfee8f8c730ea4b315ea07fe09f801365b65d49491c059c8f46fa72e505ec7f3c0b9c8560c86e10cc702b311f7f4bc45b11a98832c0636d92a1bc380d1c069c0f7916ffb2c82d88274cbbe0d7c14b3168dc5beed6447aa994880d554641bb71d90877e33326dbc06199bbc8ab8d53f41708729c3300cc3300cc3300cc3300cc3300cc3300cc3300ca309fc1ff4a1ebe8d4e329dc0000000049454e44ae426082, '2021-06-02 12:53:39', '2021-06-09 12:53:39', 'admin', 1);

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
(4, 1, 2, '1', 'ST3', 1, 4, '2021-06-07 12:36:11', '2021-06-07 12:36:11', 'ADMIN', 1),
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
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
