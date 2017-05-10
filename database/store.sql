-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2017 at 08:01 AM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `store`
--

-- --------------------------------------------------------

--
-- Table structure for table `suppiers_image`
--

CREATE TABLE `suppiers_image` (
  `img_id` mediumint(8) UNSIGNED NOT NULL,
  `sup_id` mediumint(8) UNSIGNED DEFAULT NULL,
  `img_content` mediumblob
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `sup_id` mediumint(8) UNSIGNED NOT NULL,
  `sup_name` varchar(250) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `sup_password` varchar(50) NOT NULL,
  `sub_accname` varchar(100) NOT NULL,
  `sub_email` varchar(100) NOT NULL,
  `sup_accnum` int(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `sub_brand` varchar(100) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`sup_id`, `sup_name`, `address`, `phone`, `sup_password`, `sub_accname`, `sub_email`, `sup_accnum`, `status`, `sub_brand`) VALUES
(1, 'tanawut', '80/1', '0950166861', '12345', 'tanawut1', 'tanawut913@gmail.com', 123456789, 'yes', 'SCB'),
(1002, 'tanawut1', '08/2', '0876262913', '', 'tanawut1', 'tanawut1@gmail.com', 123456789, 'no', 'ธนาคารกรุงเทพ'),
(1003, 'tanawut1', '08/2', '0876262913', '0876262913', 'tanawut1', 'tanawut1@gmail.com', 123456789, 'no', 'ธนาคารกรุงเทพ');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `suppiers_image`
--
ALTER TABLE `suppiers_image`
  ADD PRIMARY KEY (`img_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`sup_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `suppiers_image`
--
ALTER TABLE `suppiers_image`
  MODIFY `img_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `sup_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1005;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
