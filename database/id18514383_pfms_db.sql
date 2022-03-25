-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 05, 2022 at 03:43 AM
-- Server version: 10.5.12-MariaDB
-- PHP Version: 7.3.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id18514383_pfms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_t`
--

CREATE TABLE `account_t` (
  `emp_id` int(11) NOT NULL,
  `username` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accpass` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `account_t`
--

INSERT INTO `account_t` (`emp_id`, `username`, `accpass`, `account_type`) VALUES
(1, 'admin', '123456', 'Admin'),
(2, 'aaph', '123450', 'Employee'),
(3, 'gilbert', '123456', 'Employee'),
(15, 'ljlopez', '123456', 'Employee'),
(16, 'juandelacruz', '123456', 'Employee'),
(17, 'sibarra', '123456', 'Employee'),
(18, 'miguel1', '123456', 'Employee');

-- --------------------------------------------------------

--
-- Table structure for table `activity_t`
--

CREATE TABLE `activity_t` (
  `act_id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `activity` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `act_datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_t`
--

INSERT INTO `activity_t` (`act_id`, `emp_id`, `activity`, `act_datetime`) VALUES
(1, 1, 'Login', '2022-02-24 12:59:29'),
(2, 1, 'Add new bird batch values = (101, Polymouth, 230, 2022-02-24 05:00:55)', '2022-02-24 13:00:55'),
(3, 1, 'Add new egg reading values = (101, 2022-02-24T13:01, 2022-04-14T13:01, 90, 5, 4, 95)', '2022-02-24 13:01:35'),
(4, 1, 'Add new Chicken Supply values = (101, 101, Polymouth, 30, 1000, 2022-02-24 05:03:35)', '2022-02-24 13:03:35'),
(5, 1, 'Logout', '2022-02-24 13:12:57'),
(6, 1, 'Login', '2022-02-24 13:13:04'),
(7, 1, 'Logout', '2022-02-24 13:15:49'),
(8, 1, 'Login', '2022-02-24 13:15:53'),
(9, 1, 'Add new resources values = (1,Crumbles Feeds, Crumbly, 50, kg, 2022-02-24, 2023-10-04)', '2022-02-24 14:09:55'),
(10, 1, 'Add new Resource consumption values = (1,1, 5, kg, 5, 45, 2022-02-24T14:10)', '2022-02-24 14:10:40'),
(11, 1, 'Search keyword \'add\'', '2022-02-24 14:11:13'),
(12, 1, 'Add new egg reading values = (102, 2022-02-25T14:19, 2022-04-29T14:19, 200, 5, 7, 205)', '2022-02-24 14:19:45'),
(13, 1, 'Add new egg sales values = (2, 2022-02-24, 1, 2022-02-24, Egg, 102, 10, 90)', '2022-02-24 14:20:26'),
(14, 1, 'Login', '2022-02-24 14:24:20'),
(15, 1, 'Login', '2022-02-24 14:57:16'),
(16, 1, 'Login', '2022-02-24 14:57:53'),
(17, 1, 'Login', '2022-02-24 14:58:38'),
(18, 1, 'Add new bird batch values = (0110, Broilers, 125, 2022-02-24 06:59:19)', '2022-02-24 14:59:19'),
(19, 1, 'Add new egg reading values = (0119, 2021-12-24T15:04, 2022-03-30T15:00, 1245, 12, 42, 1257)', '2022-02-24 15:00:28'),
(20, 1, 'Add new Chicken Supply values = (0112, 101, Polymouth, 50, 220, 2022-02-24 07:01:06)', '2022-02-24 15:01:06'),
(21, 1, 'Delete suply_id = 112. Values = (112, 101, Polymouth, 50, 220)', '2022-02-24 15:01:20'),
(22, 1, 'Add new resources values = (00212,Whole Grain Feeds, Starter, 200, kg, 2021-12-24, 2025-02-24)', '2022-02-24 15:02:30'),
(23, 1, 'Add new Resource consumption values = (0211,212, 122, kg, 23, 455, 2022-02-24T15:03)', '2022-02-24 15:03:26'),
(24, 1, 'Add new bird sales values = (1223, 2022-02-22, , 2022-03-04, Bird, 101, 12, 3040)', '2022-02-24 15:05:06'),
(25, 1, 'Add new egg sales values = (1223, 2022-02-22, , 2022-03-04, Egg, 102, 100, 3040)', '2022-02-24 15:05:06'),
(26, 1, 'Logout', '2022-02-24 16:45:17'),
(27, 1, 'Login', '2022-02-25 12:36:02'),
(28, 1, 'Add new user values = (Alex Angelo, Hervosa, PC-HM, Male, 2001-09-26, 09299704461, 123 Kalye 2, aaph, 123450)', '2022-02-25 12:37:39'),
(29, 1, 'Logout', '2022-02-25 12:37:42'),
(30, 10, 'Login', '2022-02-25 12:37:50'),
(31, 10, 'Logout', '2022-02-25 12:38:07'),
(32, 0, 'Add new user values = (GILBERT, GUTIERREZ, PC-HM, male, 2001-03-01, 09997502986, ZUNIGA, gilbert, 123456)', '2022-02-28 00:09:03'),
(33, 11, 'Login', '2022-02-28 00:11:16'),
(34, 11, 'Logout', '2022-02-28 00:12:21'),
(35, 1, 'Login', '2022-02-28 00:12:31'),
(36, 1, 'Logout', '2022-02-28 00:17:57'),
(37, 3, 'Login', '2022-02-28 00:18:07'),
(38, 3, 'Logout', '2022-02-28 00:18:18'),
(39, 1, 'Login', '2022-02-28 00:18:23'),
(40, 1, 'Add new user values = (LJ, Lopez, PC-OOM, Female, 2022-02-22, 09123456789, Marikina City, Metro Manila, ljlopez, 123456)', '2022-02-28 00:18:51'),
(41, 1, 'Delete emp_id = 4. Values = (LJ, Lopez, PC-OOM, Female, 2022-02-22, 9123456789, Marikina City, Metro Manila, , )', '2022-02-28 00:22:32'),
(42, 1, 'Add new user values = (LJ, Lopezz, PC-S, Male, 2022-02-09, 09123456789, Marikina City, Metro Manila, ljlopez, 123456)', '2022-02-28 00:24:03'),
(43, 1, 'Delete emp_id = 5. Values = (LJ, Lopezz, PC-S, Male, 2022-02-09, 9123456789, Marikina City, Metro Manila, , )', '2022-02-28 00:27:11'),
(44, 1, 'Add new user values = (LJ, Lopez, PC-QC, Male, 2022-02-02, 09123456789, Marikina City, Metro Manila, ljlopez, 123456)', '2022-02-28 00:28:09'),
(45, 1, 'Delete emp_id = 6. Values = (LJ, Lopez, PC-QC, Male, 2022-02-02, 9123456789, Marikina City, Metro Manila, , )', '2022-02-28 00:32:05'),
(46, 1, 'Logout', '2022-02-28 00:36:19'),
(47, 0, 'Add new user values = (LJ, Lopez, PC-S, male, 2022-02-02, 09123456789, ZUNIGA, ljlopez, 123456)', '2022-02-28 00:39:25'),
(48, 15, 'Login', '2022-02-28 00:39:33'),
(49, 15, 'Logout', '2022-02-28 00:39:42'),
(50, 1, 'Login', '2022-03-01 17:41:16'),
(51, 1, 'Login', '2022-03-01 17:42:31'),
(52, 1, 'Logout', '2022-03-01 17:43:47'),
(53, 1, 'Logout', '2022-03-01 17:44:49'),
(54, 1, 'Login', '2022-03-01 17:45:23'),
(55, 0, 'Add new user values = (Juan, Dela Cruz, PC-IT, male, 2022-03-01, 09123456789, Blk. Ligaya St. Mandaluyong City, juandelacruz, 123456)', '2022-03-01 17:50:27'),
(56, 16, 'Login', '2022-03-01 17:50:37'),
(57, 16, 'Logout', '2022-03-01 17:51:21'),
(58, 1, 'Login', '2022-03-01 17:51:29'),
(59, 1, 'Logout', '2022-03-01 17:52:29'),
(60, 16, 'Login', '2022-03-01 17:53:22'),
(61, 16, 'Login', '2022-03-01 17:57:33'),
(62, 16, 'Add new Chicken Supply values = (1000, 0110, Broilers, 10, 1000, 2022-03-01 10:05:35)', '2022-03-01 18:05:35'),
(63, 16, 'Add new resources values = (1001,Crumbles Feeds, Thunderbird, 50, kg, 2022-02-27, 2023-02-28)', '2022-03-01 18:09:19'),
(64, 16, 'Add new Resource consumption values = (1001,1001, 50, kg, 20, 30, 2022-03-01T18:00)', '2022-03-01 18:12:23'),
(65, 16, 'Add new bird sales values = (1001, 2022-03-01, , 2022-03-01, Bird, 1000, 1, 1000)', '2022-03-01 18:17:20'),
(66, 16, 'Logout', '2022-03-01 18:19:41'),
(67, 1, 'Login', '2022-03-01 18:19:48'),
(68, 1, 'Logout', '2022-03-01 18:28:20'),
(69, 16, 'Login', '2022-03-01 18:28:28'),
(70, 16, 'Logout', '2022-03-01 18:30:26'),
(71, 1, 'Login', '2022-03-01 18:30:33'),
(72, 1, 'Add new bird sales values = (1001, 2022-03-01, , 2022-03-01, Bird, 1000, 1, 0)', '2022-03-01 18:33:45'),
(73, 1, 'Add new bird sales values = (1001, 2022-03-01, 4, 2022-03-01, Bird, 1000, 1, 1000)', '2022-03-01 18:35:09'),
(74, 1, 'Search keyword \'juan dela cruz\'', '2022-03-01 18:38:30'),
(75, 1, 'Search keyword \'Juan Dela Cruz\'', '2022-03-01 18:38:58'),
(76, 1, 'Search keyword \'Juan\'', '2022-03-01 18:39:09'),
(77, 1, 'Search keyword \'1001\'', '2022-03-01 18:39:26'),
(78, 1, 'Search keyword \'juandelacruz\'', '2022-03-01 18:39:38'),
(79, 1, 'Update emp_id = 2. Old values = (Alex Angelo, Hervosa, PC-HM, Male, 2001-09-26, 9299704461, 123 Kalye 2, aaph, 123450). New values = (Alex Angelo, Hervosa, PC-HM, Male, 2001-09-26, 9299704461, 1234 Kalye 3, aaph, 123450)', '2022-03-01 18:42:17'),
(80, 1, 'Logout', '2022-03-01 18:44:57'),
(81, 1, 'Login', '2022-03-02 13:52:42'),
(82, 1, 'Add new bird sales values = (4, 2022-03-02, 1, 2022-03-02, Bird, 1000, 7, 7000)', '2022-03-02 13:53:29'),
(83, 1, 'Update supply_id = 1000. Old values = (110, Broilers, 0, 1000). New values = (110, Broilers, 100, 1000)', '2022-03-02 13:57:35'),
(84, 1, 'Add new bird sales values = (5, 2022-03-02, 2, 2022-03-02, Bird, 1000, 10, 10000)', '2022-03-02 13:58:08'),
(85, 1, 'Logout', '2022-03-02 14:01:52'),
(86, 1, 'Login', '2022-03-02 14:02:15'),
(87, 1, 'Add new bird sales values = (6, 2022-03-02, 1, 2022-03-02, Bird, 1000, 10, 10070)', '2022-03-02 14:03:02'),
(88, 1, 'Add new egg sales values = (6, 2022-03-02, 1, 2022-03-02, Egg, 102, 10, 10070)', '2022-03-02 14:03:02'),
(89, 1, 'Add new egg sales values = (7, 2022-03-02, 1, 2022-03-02, Egg, 102, 10, 100)', '2022-03-02 14:05:33'),
(90, 1, 'Add new bird sales values = (8, 2022-03-02, 2, 2022-03-02, Bird, 1000, 10, 10200)', '2022-03-02 14:08:57'),
(91, 1, 'Add new egg sales values = (8, 2022-03-02, 2, 2022-03-02, Egg, 102, 20, 10200)', '2022-03-02 14:08:57'),
(92, 1, 'Logout', '2022-03-02 14:13:24'),
(93, 16, 'Login', '2022-03-04 17:18:48'),
(94, 16, 'Add new bird batch values = (1002, Brahma, 20, 2022-03-04 09:20:34)', '2022-03-04 17:20:34'),
(95, 16, 'Add new egg reading values = (1002, 2022-03-04T17:21, 2022-03-14T17:21, 40, 7, 2, 47)', '2022-03-04 17:22:39'),
(96, 16, 'Add new Chicken Supply values = (1002, 1002, Brahma, 5, 1100, 2022-03-04 09:24:54)', '2022-03-04 17:24:54'),
(97, 16, 'Add new resources values = (1002,Medicine, BirdGO, 100, capsules, 2022-03-04, 2022-04-30)', '2022-03-04 17:27:17'),
(98, 1, 'Login', '2022-03-04 17:28:18'),
(99, 16, 'Add new resources values = (200,Medicine, Phillips, 100, capsules, 2022-03-04, 2022-04-30)', '2022-03-04 17:28:52'),
(100, 1, 'Add new resources values = (123,Medicine, Ambroxitil, 120, ml, 2022-03-04, 2025-03-04)', '2022-03-04 17:29:35'),
(101, 16, 'Add new resources values = (201,Medicine, Birdy, 50, capsules, 2022-03-04, 2022-04-30)', '2022-03-04 17:31:52'),
(102, 16, 'Add new Resource consumption values = (210,201, 50, capsules, 25, 25, 2022-03-04T17:33)', '2022-03-04 17:34:10'),
(103, 16, 'Add new egg sales values = (500, 2022-03-04, 5, 2022-03-04, Egg, 0119, 30, 240)', '2022-03-04 17:38:12'),
(104, 16, 'Logout', '2022-03-04 17:39:40'),
(105, 1, 'Login', '2022-03-04 17:39:48'),
(106, 15, 'Login', '2022-03-04 17:39:48'),
(107, 1, 'Update batch_id = 1002. Old values = (Brahma, 20, 2022-03-04 09:20:34). New values = (Brahma, 30, 2022-03-04 17:42:53)', '2022-03-04 17:42:53'),
(108, 1, 'Update reading_id = 1002. Old values = (2022-03-04 17:21:00, 2022-03-14 17:21:00, 40, 7, 2, 47). New values = (2022-03-04T17:21, 2022-03-04T17:21, 2022-04-30T17:00, 40, 7, 2, )', '2022-03-04 17:44:29'),
(109, 1, 'Update reading_id = 1002. Old values = (2022-03-04 17:21:00, 2022-03-14 17:21:00, 40, 7, 2, 47). New values = (2022-03-04T17:21, 2022-03-04T17:21, 2022-04-30T17:00, 39, 8, 2, 47)', '2022-03-04 17:47:32'),
(110, 1, 'Update reading_id = 1002. Old values = (2022-03-04 17:21:00, 2022-03-14 17:21:00, 40, 7, 2, 47). New values = (2022-03-04T17:48, 2022-03-04T17:48, 2022-03-04T17:48, 41, 7, 2, 48)', '2022-03-04 17:48:33'),
(111, 1, 'Update reading_id = 1002. Old values = (2022-03-04 17:21:00, 2022-03-14 17:21:00, 40, 7, 2, 47). New values = (2022-03-04T17:48, 2022-03-04T17:48, 2022-03-04T17:48, 41, 7, 2, 48)', '2022-03-04 17:48:39'),
(112, 1, 'Delete suply_id = 101. Values = (101, 101, Polymouth, -12, 1000)', '2022-03-04 17:49:12'),
(113, 1, 'Update supply_id = 1000. Old values = (110, Broilers, 70, 1000). New values = (110, Broilers, 90, 245)', '2022-03-04 17:49:29'),
(114, 1, 'Update resource_id = 1001. Old values = (Crumbles Feeds, Thunderbird, 50, kg, 2022-02-27, 2023-02-28) New values = (Crumbles Feeds, Thunderbird, 120, kg, 2022-02-27, 2023-02-28)', '2022-03-04 17:49:57'),
(115, 1, 'Update reading_id = 1002. Old values = (2022-03-04 17:21:00, 2022-03-14 17:21:00, 40, 7, 2, 47). New values = (2022-03-04T17:21, 2022-03-04T17:21, 2022-04-30T17:21, 39, 8, 2, 47)', '2022-03-04 17:50:07'),
(116, 1, 'Update resource_id = 1. Old values = (Crumbles Feeds, Crumbly, 50, kg, 2022-02-24, 2023-10-04) New values = (Crumbles Feeds, Crumbly, 70, kg, 2022-02-24, 2023-10-04)', '2022-03-04 17:50:22'),
(117, 1, 'Update reading_id = 1002. Old values = (2022-03-04 17:21:00, 2022-03-14 17:21:00, 40, 7, 2, 47). New values = (2022-03-04T17:21, 2022-03-04T17:21, 2022-03-14T17:21, 39, 8, 2, 47)', '2022-03-04 17:50:49'),
(118, 1, 'Update consumption_id = 210. Old values = (201, 50, capsules, 25, 25, 2022-03-04). New values = (1, 50, capsules, 20, 30, 2022-03-04)', '2022-03-04 17:50:50'),
(119, 1, 'Update reading_id = 1002. Old values = (2022-03-04 17:21:00, 2022-03-14 17:21:00, 40, 7, 2, 47). New values = (2022-03-04T17:21, 2022-03-04T17:21, 2022-03-14T17:21, 39, 8, 2, 47)', '2022-03-04 17:51:50'),
(120, 1, 'Update reading_id = 101. Old values = (2022-02-24 13:01:00, 2022-04-14 13:01:00, 0, 5, 4, 5). New values = (2022-02-20T13:01, 2022-02-20T13:01, 2022-03-17T17:52, 30, 5, 2, 35)', '2022-03-04 17:52:04'),
(121, 1, 'Update reading_id = 101. Old values = (2022-02-24 13:01:00, 2022-04-14 13:01:00, 0, 5, 4, 5). New values = (2022-02-20T13:01, 2022-02-20T13:01, 2022-03-17T17:52, 30, 5, 2, 35)', '2022-03-04 17:52:13'),
(122, 1, 'Update reading_id = 101. Old values = (2022-02-24 13:01:00, 2022-04-14 13:01:00, 0, 5, 4, 5). New values = (2022-02-20T13:01, 2022-02-20T13:01, 2022-03-17T17:52, 30, 5, 2, 35)', '2022-03-04 17:52:28'),
(123, 1, 'Update reading_id = 101. Old values = (2022-02-24 13:01:00, 2022-04-14 13:01:00, 0, 5, 4, 5). New values = (2022-03-11T17:53, 2022-03-11T17:53, 2022-03-04T17:53, 10, 5, 1, 15)', '2022-03-04 17:53:15'),
(124, 1, 'Update reading_id = 101. Old values = (2022-02-24 13:01:00, 2022-04-14 13:01:00, 0, 5, 4, 5). New values = (2022-03-11T17:53, 2022-03-11T17:53, 2022-03-04T17:53, 10, 5, 1, 15)', '2022-03-04 17:53:29'),
(125, 1, 'Update reading_id = 1002. Old values = (2022-03-04 17:21:00, 2022-03-14 17:21:00, 40, 7, 2, 47). New values = (2022-03-04T17:21, 2022-03-04T17:21, 2022-03-14T17:21, 39, 8, 2, 47)', '2022-03-04 17:53:32'),
(126, 1, 'Update reading_id = 101. Old values = (2022-02-24 13:01:00, 2022-04-14 13:01:00, 0, 5, 4, 5). New values = (2022-03-11T17:53, 2022-03-11T17:53, 2022-03-04T17:53, 10, 5, 1, 15)', '2022-03-04 17:53:32'),
(127, 1, 'Update reading_id = 1002. Old values = (2022-03-04 17:21:00, 2022-03-14 17:21:00, 40, 7, 2, 47). New values = (2022-03-04T17:21, 2022-03-04T17:21, 2022-03-14T17:21, 39, 8, 2, 47)', '2022-03-04 17:53:35'),
(128, 1, 'Update reading_id = 101. Old values = (2022-02-24 13:01:00, 2022-04-14 13:01:00, 0, 5, 4, 5). New values = (2022-02-24T17:53, 2022-02-24T17:53, 2022-03-04T17:53, 12, 5, 1, 17)', '2022-03-04 17:53:53'),
(129, 1, 'Update reading_id = 1002. Old values = (2022-03-04 17:21:00, 2022-03-14 17:21:00, 40, 7, 2, 47). New values = (2022-03-04T17:21, 2022-03-04T17:21, 2022-03-14T17:21, 39, 8, 2, 47)', '2022-03-04 17:54:05'),
(130, 1, 'Update reading_id = 1002. Old values = (2022-03-04 17:21:00, 2022-03-14 17:21:00, 40, 7, 2, 47). New values = (2022-03-04T17:21, 2022-03-04T17:21, 2022-03-14T17:21, 39, 8, 2, 47)', '2022-03-04 17:54:50'),
(131, 1, 'Update reading_id = 1002. Old values = (2022-03-04 17:21:00, 2022-03-14 17:21:00, 39, 8, 2, 47). New values = (2022-03-04T17:21, 2022-03-04T17:21, 2022-03-14T17:21, 39, 8, 2, 47)', '2022-03-04 17:54:53'),
(132, 1, 'Update reading_id = 101. Old values = (2022-02-24 13:01:00, 2022-04-14 13:01:00, 0, 5, 4, 5). New values = (2022-02-24T17:53, 2022-02-24T17:53, 2022-03-04T17:53, 12, 5, 1, 17)', '2022-03-04 17:55:07'),
(133, 1, 'Update reading_id = 1002. Old values = (2022-03-04 17:21:00, 2022-03-14 17:21:00, 39, 8, 2, 47). New values = (2022-03-04T17:21, 2022-03-04T17:21, 2022-03-14T17:21, 38, 9, 2, 47)', '2022-03-04 17:55:32'),
(134, 1, 'Update supply_id = 1002. Old values = (1002, Brahma, 5, 1100). New values = (1002, Brahma, 4, 1200)', '2022-03-04 17:56:49'),
(135, 1, 'Delete resource_id = 201. Values = (201,Medicine, Birdy, 50, capsules, 2022-03-04, 2022-04-30)', '2022-03-04 17:57:49'),
(136, 1, 'Update resource_id = 1001. Old values = (Crumbles Feeds, Thunderbird, 120, kg, 2022-02-27, 2023-02-28) New values = (Crumbles Feeds, Thunderbird, 130, kg, 2022-02-27, 2023-02-28)', '2022-03-04 17:58:10'),
(137, 1, 'Update consumption_id = 210. Old values = (1, 50, capsules, 20, 30, 2022-03-04). New values = (1, 50, capsules, 25, 25, 2022-03-04)', '2022-03-04 17:59:15'),
(138, 1, 'Logout', '2022-03-04 18:11:21'),
(139, 15, 'Logout', '2022-03-04 18:13:55'),
(140, 1, 'Login', '2022-03-05 08:13:44'),
(141, 1, 'Add new Resource consumption values = (1002,123, 120, ml, 5, 115, 2022-03-05T08:15)', '2022-03-05 08:15:36'),
(142, 1, 'Update consumption_id = 1002. Old values = (123, 120, ml, 5, 115, 2022-03-05). New values = (1, 120, kg, 10, 110, 2022-03-05)', '2022-03-05 08:16:49'),
(143, 1, 'Delete emp_id = 1002. Values = (1002,1, 120, kg, 10, 110, 2022-03-05)', '2022-03-05 08:17:19'),
(144, 1, 'Search keyword \'sales\'', '2022-03-05 08:17:40'),
(145, 1, 'Search keyword \'sale\'', '2022-03-05 08:17:47'),
(146, 1, 'Search keyword \'sales\'', '2022-03-05 08:19:45'),
(147, 1, 'Add new resources values = (2,Vitamins, Durvet, 500, g, 2022-03-05, 2028-10-24)', '2022-03-05 08:22:34'),
(148, 1, 'Add new Resource consumption values = (2,2, 500, g, 100, 400, 2022-03-05T08:23)', '2022-03-05 08:23:25'),
(149, 1, 'Login', '2022-03-05 08:36:29'),
(150, 0, 'Add new user values = (Simoun, Ibarra, PC-QC, male, 1980-11-21, 09278595465, 123 Kalye Anluwage, sibarra, 123456)', '2022-03-05 08:39:21'),
(151, 17, 'Login', '2022-03-05 08:39:25'),
(152, 17, 'Add new bird batch values = (0012, Native, 125, 2022-03-05 00:40:08)', '2022-03-05 08:40:08'),
(153, 17, 'Add new egg reading values = (01121, 2022-03-05T08:40, 2022-03-19T08:40, 110, 10, 4, 120)', '2022-03-05 08:40:55'),
(154, 17, 'Add new Chicken Supply values = (00121, 0012, Native, 10, 235, 2022-03-05 00:41:14)', '2022-03-05 08:41:14'),
(155, 17, 'Add new resources values = (1021,Mash Feeds, Mesh, 250, kg, 2022-03-05, 2025-03-12)', '2022-03-05 08:42:01'),
(156, 17, 'Add new Resource consumption values = (1121,1021, 250, kg, 10, 240, 2022-03-04T08:42)', '2022-03-05 08:42:39'),
(157, 17, 'Add new bird sales values = (10211, 2022-03-05, 6, 2022-03-06, Bird, 121, 5, 1175)', '2022-03-05 08:44:00'),
(158, 17, 'Logout', '2022-03-05 08:45:22'),
(159, 1, 'Login', '2022-03-05 08:45:26'),
(160, 1, 'Update batch_id = 0012. Old values = (Native, 120, 2022-03-05 00:40:08). New values = (Native, 85, 2022-03-05 08:46:03)', '2022-03-05 08:46:03'),
(161, 1, 'Update reading_id = 01121. Old values = (2022-03-05 08:40:00, 2022-03-19 08:40:00, 110, 10, 4, 120). New values = (2022-03-05T08:46, 2022-03-05T08:46, 2022-03-19T08:46, 120, 10, 5, 130)', '2022-03-05 08:46:39'),
(162, 1, 'Delete reading_id = 01121. Values = (01121, 2022-03-05 08:46:00, 2022-03-19 08:46:00, 120, 10, 5, 130)', '2022-03-05 08:46:45'),
(163, 1, 'Update supply_id = 121. Old values = (12, Native, 5, 235). New values = (12, Native, 10, 275)', '2022-03-05 08:47:05'),
(164, 1, 'Delete batch_id = 0012. Values = (Native, 85, 2022-03-05 08:46:03)', '2022-03-05 08:47:37'),
(165, 1, 'Delete suply_id = 121. Values = (121, 12, Native, 10, 275)', '2022-03-05 08:48:22'),
(166, 1, 'Update supply_id = 1002. Old values = (1002, Brahma, 4, 1200). New values = (1002, Brahma, 5, 180)', '2022-03-05 08:49:10'),
(167, 1, 'Logout', '2022-03-05 08:50:37'),
(168, 16, 'Login', '2022-03-05 09:53:58'),
(169, 16, 'Add new bird batch values = (500, Leghorn, 20, 2022-03-05 01:55:54)', '2022-03-05 09:55:54'),
(170, 16, 'Add new egg reading values = (500, 2022-03-05T09:56, 2022-03-26T09:56, 40, 5, 2, 45)', '2022-03-05 09:57:18'),
(171, 16, 'Add new Chicken Supply values = (500, 500, Leghorn, 5, 1000, 2022-03-05 01:58:05)', '2022-03-05 09:58:05'),
(172, 16, 'Add new resources values = (600,Crumbles Feeds, B-MEG, 500, kg, 2022-03-05, 2022-03-31)', '2022-03-05 09:59:50'),
(173, 16, 'Add new Resource consumption values = (601,600, 500, kg, 200, 300, 2022-03-05T10:00)', '2022-03-05 10:00:56'),
(174, 16, 'Add new bird sales values = (700, 2022-03-05, 7, 2022-03-05, Bird, 500, 2, 2000)', '2022-03-05 10:03:30'),
(175, 16, 'Logout', '2022-03-05 10:04:06'),
(176, 0, 'Add new user values = (Miguel, Cartera, PC-IT, male, 2022-03-05, 09123456789, 7 North Sikap St., miguel1, 123456)', '2022-03-05 10:07:17'),
(177, 18, 'Login', '2022-03-05 10:07:28'),
(178, 18, 'Logout', '2022-03-05 10:07:40'),
(179, 1, 'Login', '2022-03-05 10:07:59'),
(180, 1, 'Update batch_id = 500. Old values = (Leghorn, 18, 2022-03-05 01:55:54). New values = (Leghorn, 15, 2022-03-05 10:08:57)', '2022-03-05 10:08:57'),
(181, 1, 'Delete batch_id = 500. Values = (Leghorn, 15, 2022-03-05 10:08:57)', '2022-03-05 10:09:07'),
(182, 1, 'Delete reading_id = 500. Values = (500, 2022-03-05 09:56:00, 2022-03-26 09:56:00, 40, 5, 2, 45)', '2022-03-05 10:09:26'),
(183, 1, 'Search keyword \'add birds\'', '2022-03-05 10:11:12'),
(184, 1, 'Search keyword \'add bird\'', '2022-03-05 10:11:22'),
(185, 1, 'Update emp_id = 18. Old values = (Miguel, Cartera, PC-IT, male, 2022-03-05, 9123456789, 7 North Sikap St., miguel1, 123456). New values = (Migz, Carter, PC-PL, Male, 2022-03-05, 9123456789, 7 North Sikap St., miguel1, 123456)', '2022-03-05 10:13:29'),
(186, 1, 'Delete emp_id = 17. Values = (Simoun, Ibarra, PC-QC, male, 1980-11-21, 9278595465, 123 Kalye Anluwage, sibarra, 123456)', '2022-03-05 10:13:42'),
(187, 1, 'Logout', '2022-03-05 10:15:00'),
(188, 1, 'Login', '2022-03-05 11:10:50');

-- --------------------------------------------------------

--
-- Table structure for table `birds_t`
--

CREATE TABLE `birds_t` (
  `batch_id` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bird_breed` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `update_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `birds_t`
--

INSERT INTO `birds_t` (`batch_id`, `bird_breed`, `quantity`, `update_date`) VALUES
('0110', 'Broilers', 85, '2022-02-24 06:59:19'),
('1002', 'Brahma', 30, '2022-03-04 17:42:53'),
('101', 'Polymouth', 188, '2022-02-24 05:00:55');

-- --------------------------------------------------------

--
-- Table structure for table `consumption_t`
--

CREATE TABLE `consumption_t` (
  `consumption_id` int(11) NOT NULL,
  `resource_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `unit` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `used` int(11) NOT NULL,
  `remaining` int(11) NOT NULL,
  `date_used` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `consumption_t`
--

INSERT INTO `consumption_t` (`consumption_id`, `resource_id`, `amount`, `unit`, `used`, `remaining`, `date_used`) VALUES
(1, 1, 5, 'kg', 5, 45, '2022-02-24'),
(2, 2, 500, 'g', 100, 400, '2022-03-05'),
(210, 1, 50, 'capsules', 25, 25, '2022-03-04'),
(211, 212, 122, 'kg', 23, 455, '2022-02-24'),
(601, 600, 500, 'kg', 200, 300, '2022-03-05'),
(1001, 1001, 50, 'kg', 20, 30, '2022-03-01'),
(1121, 1021, 250, 'kg', 10, 240, '2022-03-04');

-- --------------------------------------------------------

--
-- Table structure for table `customer_t`
--

CREATE TABLE `customer_t` (
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` bigint(11) NOT NULL,
  `address` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_t`
--

INSERT INTO `customer_t` (`customer_id`, `customer_name`, `contact`, `address`) VALUES
(1, 'John Doe', 9123456789, 'Marikina City, Metro Manila'),
(2, 'Mark Twain', 9123456789, 'Marikina City, Metro Manila'),
(3, 'Edson Hermosa', 9123456789, 'ASHDJKSAD'),
(4, 'Edson Jr.', 9123456789, '#8 States View, Taguig'),
(5, 'Miguel Cartera', 9987654321, 'No. 7 Balikbayan, Mandaluyong City'),
(6, 'Simoun Ibarra', 9278595465, '123 Kalye Anluwage'),
(7, 'Juan', 9123456789, 'No. 7 Mabuhay St. Manila');

-- --------------------------------------------------------

--
-- Table structure for table `egg_reading_t`
--

CREATE TABLE `egg_reading_t` (
  `reading_id` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `collection_date` datetime DEFAULT NULL,
  `expiration_date` datetime DEFAULT NULL,
  `good_condition` int(11) NOT NULL,
  `cracked` int(11) NOT NULL,
  `tray` int(11) NOT NULL,
  `total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `egg_reading_t`
--

INSERT INTO `egg_reading_t` (`reading_id`, `collection_date`, `expiration_date`, `good_condition`, `cracked`, `tray`, `total`) VALUES
('0119', '2021-12-24 15:04:00', '2022-03-30 15:00:00', 1215, 12, 42, 1227),
('1002', '2022-03-04 17:21:00', '2022-03-14 17:21:00', 38, 9, 2, 47),
('101', '2022-02-24 17:53:00', '2022-03-04 17:53:00', 12, 5, 1, 17),
('102', '2022-02-25 14:19:00', '2022-04-29 14:19:00', 50, 5, 7, 55);

-- --------------------------------------------------------

--
-- Table structure for table `employee_t`
--

CREATE TABLE `employee_t` (
  `emp_id` int(11) NOT NULL,
  `position_code` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sex` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `contact_no` bigint(20) NOT NULL,
  `address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_t`
--

INSERT INTO `employee_t` (`emp_id`, `position_code`, `first_name`, `last_name`, `sex`, `birthdate`, `contact_no`, `address`) VALUES
(1, 'PC-OOM', 'Raphael', 'Gutierrez', 'Male', '1974-12-21', 299837464, '31 P. Burgos, Poblacion, Batangas, 4200 Batangas, Philippines'),
(2, 'PC-HM', 'Alex Angelo', 'Hervosa', 'Male', '2001-09-26', 9299704461, '1234 Kalye 3'),
(3, 'PC-HM', 'GILBERT', 'GUTIERREZ', 'male', '2001-03-01', 9997502986, 'ZUNIGA'),
(15, 'PC-S', 'LJ', 'Lopez', 'male', '2022-02-02', 9123456789, 'ZUNIGA'),
(16, 'PC-IT', 'Juan', 'Dela Cruz', 'male', '2022-03-01', 9123456789, 'Blk. Ligaya St. Mandaluyong City'),
(18, 'PC-PL', 'Migz', 'Carter', 'Male', '2022-03-05', 9123456789, '7 North Sikap St.');

-- --------------------------------------------------------

--
-- Table structure for table `otp_t`
--

CREATE TABLE `otp_t` (
  `username` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `otp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `otp_t`
--

INSERT INTO `otp_t` (`username`, `email`, `otp`) VALUES
('ljlopez', 'gutierrez.raphael.17@gmail.com', 108826),
('juandelacruz', 'migz_cartera1@gmail.com', 617350),
('sibarra', 'apinetha@gmail.com', 112716),
('miguel1', 'migz.cartera@gmail.com', 623983);

-- --------------------------------------------------------

--
-- Table structure for table `position_t`
--

CREATE TABLE `position_t` (
  `position_code` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `salary` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `position_t`
--

INSERT INTO `position_t` (`position_code`, `position`, `salary`) VALUES
('PC-BM', 'Breeding Manager', 35234),
('PC-HM', 'Hatchery Manager', 35823),
('PC-IT', 'IT SUPPORT', 25238),
('PC-MM', 'Marketing Manager', 30934),
('PC-N', 'Nutritionist', 35239),
('PC-OOM', 'Over-all Operations Manager', 42182),
('PC-PL', 'Poultry Laborer', 12890),
('PC-QC', 'Quality Control', 28034),
('PC-S', 'Supervisor', 30287);

-- --------------------------------------------------------

--
-- Table structure for table `resources_t`
--

CREATE TABLE `resources_t` (
  `resource_id` int(11) NOT NULL,
  `resource_type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` int(11) NOT NULL,
  `unit` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `procurement_date` date DEFAULT NULL,
  `expiration_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `resources_t`
--

INSERT INTO `resources_t` (`resource_id`, `resource_type`, `name`, `amount`, `unit`, `procurement_date`, `expiration_date`) VALUES
(1, 'Crumbles Feeds', 'Crumbly', 70, 'kg', '2022-02-24', '2023-10-04'),
(2, 'Vitamins', 'Durvet', 500, 'g', '2022-03-05', '2028-10-24'),
(123, 'Medicine', 'Ambroxitil', 120, 'ml', '2022-03-04', '2025-03-04'),
(212, 'Whole Grain Feeds', 'Starter', 200, 'kg', '2021-12-24', '2025-02-24'),
(600, 'Crumbles Feeds', 'B-MEG', 500, 'kg', '2022-03-05', '2022-03-31'),
(1001, 'Crumbles Feeds', 'Thunderbird', 130, 'kg', '2022-02-27', '2023-02-28'),
(1021, 'Mash Feeds', 'Mesh', 250, 'kg', '2022-03-05', '2025-03-12');

-- --------------------------------------------------------

--
-- Table structure for table `sales_t`
--

CREATE TABLE `sales_t` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `invoice_date` date DEFAULT NULL,
  `customer_id` int(11) NOT NULL,
  `payment_date` date DEFAULT NULL,
  `type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` int(11) NOT NULL,
  `item_sold` int(11) NOT NULL,
  `total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales_t`
--

INSERT INTO `sales_t` (`id`, `invoice_id`, `invoice_date`, `customer_id`, `payment_date`, `type`, `item`, `item_sold`, `total`) VALUES
(1, 1, '2022-02-24', 1, '2022-02-24', 'Egg', 101, 20, 200),
(2, 2, '2022-02-24', 1, '2022-02-24', 'Egg', 102, 10, 90),
(3, 1001, '2022-03-01', 4, '2022-03-01', 'Bird', 1000, 1, 1000),
(4, 4, '2022-03-02', 1, '2022-03-02', 'Bird', 1000, 7, 7000),
(5, 5, '2022-03-02', 2, '2022-03-02', 'Bird', 1000, 10, 10000),
(6, 6, '2022-03-02', 1, '2022-03-02', 'Bird', 1000, 10, 10070),
(7, 6, '2022-03-02', 1, '2022-03-02', 'Egg', 102, 10, 10070),
(8, 7, '2022-03-02', 1, '2022-03-02', 'Egg', 102, 10, 100),
(9, 8, '2022-03-02', 2, '2022-03-02', 'Bird', 1000, 10, 10200),
(10, 8, '2022-03-02', 2, '2022-03-02', 'Egg', 102, 20, 10200),
(11, 500, '2022-03-04', 5, '2022-03-04', 'Egg', 119, 30, 240),
(12, 10211, '2022-03-05', 6, '2022-03-06', 'Bird', 121, 5, 1175),
(13, 700, '2022-03-05', 7, '2022-03-05', 'Bird', 500, 2, 2000);

-- --------------------------------------------------------

--
-- Table structure for table `supply_t`
--

CREATE TABLE `supply_t` (
  `supply_id` int(11) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `bird_breed` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` double NOT NULL,
  `date_added` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `supply_t`
--

INSERT INTO `supply_t` (`supply_id`, `batch_id`, `bird_breed`, `quantity`, `price`, `date_added`) VALUES
(500, 500, 'Leghorn', 3, 1000, '2022-03-05'),
(1000, 110, 'Broilers', 90, 245, '2022-03-01'),
(1002, 1002, 'Brahma', 5, 180, '2022-03-04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_t`
--
ALTER TABLE `account_t`
  ADD PRIMARY KEY (`emp_id`);

--
-- Indexes for table `activity_t`
--
ALTER TABLE `activity_t`
  ADD PRIMARY KEY (`act_id`);

--
-- Indexes for table `birds_t`
--
ALTER TABLE `birds_t`
  ADD PRIMARY KEY (`batch_id`);

--
-- Indexes for table `consumption_t`
--
ALTER TABLE `consumption_t`
  ADD PRIMARY KEY (`consumption_id`),
  ADD KEY `consumption_t_ibfk_1` (`resource_id`);

--
-- Indexes for table `customer_t`
--
ALTER TABLE `customer_t`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `egg_reading_t`
--
ALTER TABLE `egg_reading_t`
  ADD PRIMARY KEY (`reading_id`);

--
-- Indexes for table `employee_t`
--
ALTER TABLE `employee_t`
  ADD PRIMARY KEY (`emp_id`),
  ADD KEY `position_code` (`position_code`);

--
-- Indexes for table `position_t`
--
ALTER TABLE `position_t`
  ADD PRIMARY KEY (`position_code`);

--
-- Indexes for table `resources_t`
--
ALTER TABLE `resources_t`
  ADD PRIMARY KEY (`resource_id`);

--
-- Indexes for table `sales_t`
--
ALTER TABLE `sales_t`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_t_ibfk_1` (`customer_id`);

--
-- Indexes for table `supply_t`
--
ALTER TABLE `supply_t`
  ADD PRIMARY KEY (`supply_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_t`
--
ALTER TABLE `account_t`
  MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `activity_t`
--
ALTER TABLE `activity_t`
  MODIFY `act_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=189;

--
-- AUTO_INCREMENT for table `customer_t`
--
ALTER TABLE `customer_t`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `employee_t`
--
ALTER TABLE `employee_t`
  MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `sales_t`
--
ALTER TABLE `sales_t`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `consumption_t`
--
ALTER TABLE `consumption_t`
  ADD CONSTRAINT `consumption_t_ibfk_1` FOREIGN KEY (`resource_id`) REFERENCES `resources_t` (`resource_id`);

--
-- Constraints for table `employee_t`
--
ALTER TABLE `employee_t`
  ADD CONSTRAINT `employee_t_ibfk_1` FOREIGN KEY (`position_code`) REFERENCES `position_t` (`position_code`);

--
-- Constraints for table `sales_t`
--
ALTER TABLE `sales_t`
  ADD CONSTRAINT `sales_t_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer_t` (`customer_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
