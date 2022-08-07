-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 29, 2022 at 03:58 AM
-- Server version: 8.0.17
-- PHP Version: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `easylots`
--

-- --------------------------------------------------------

--
-- Table structure for table `bill_detail`
--

CREATE TABLE `bill_detail` (
  `bill_detail_id` int(11) NOT NULL,
  `bill_id` int(11) NOT NULL,
  `lotto_id` int(11) NOT NULL,
  `lotto_list_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `child_id` int(11) NOT NULL,
  `huay_type` varchar(8) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `huay_value` varchar(6) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `huay_price` double NOT NULL,
  `huay_rate` double NOT NULL,
  `head_rate` double NOT NULL,
  `huay_commission` double NOT NULL,
  `bill_price` double NOT NULL,
  `bill_check` tinyint(1) NOT NULL,
  `bill_process` tinyint(1) NOT NULL,
  `bill_summary` tinyint(1) NOT NULL,
  `downline_amount` double NOT NULL,
  `downline_commission` double NOT NULL,
  `downline_reward` double NOT NULL,
  `user_amount` double NOT NULL,
  `user_commission` double NOT NULL,
  `user_reward` double NOT NULL,
  `upline_amount` double NOT NULL,
  `upline_commission` double NOT NULL,
  `upline_reward` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bill_detail`
--
ALTER TABLE `bill_detail`
  ADD PRIMARY KEY (`bill_detail_id`),
  ADD KEY `lotto_list_id` (`lotto_list_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `child_id` (`child_id`),
  ADD KEY `bill_detail_id` (`bill_detail_id`),
  ADD KEY `bill_id` (`bill_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bill_detail`
--
ALTER TABLE `bill_detail`
  MODIFY `bill_detail_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
