-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 11, 2017 at 08:22 AM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `store11`
--

-- --------------------------------------------------------

--
-- Table structure for table `order_tran`
--

CREATE TABLE `order_tran` (
  `ort_id` mediumint(8) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `tran_id` mediumint(8) DEFAULT NULL,
  `quantity` smallint(5) NOT NULL,
  `order_id` mediumint(8) DEFAULT NULL,
  `sup_id` mediumint(8) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_tran`
--

INSERT INTO `order_tran` (`ort_id`, `name`, `price`, `tran_id`, `quantity`, `order_id`, `sup_id`) VALUES
(5, 'MOUSE PAD NEOLUTION E-SPORT LOGO EDITION MINI', 190, 1, 10, 1000193, 4),
(6, 'MOUSE PAD CORSAIR MM300 SMALL', 690, 2, 1, 1000194, 4),
(7, 'HEADSET RAZER KRAKEN MOBILE PURPLE', 3390, 2, 1, 1000196, 1);

-- --------------------------------------------------------

--
-- Table structure for table `transfer`
--

CREATE TABLE `transfer` (
  `tran_id` mediumint(8) UNSIGNED NOT NULL,
  `tran_date` date NOT NULL,
  `account` varchar(10) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `tran_amount` int(11) NOT NULL,
  `tran_status` varchar(100) NOT NULL,
  `sup_id` mediumint(8) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transfer`
--

INSERT INTO `transfer` (`tran_id`, `tran_date`, `account`, `name`, `tran_amount`, `tran_status`, `sup_id`) VALUES
(1, '2017-04-08', '8516281581', 'tanawut', 3220, 'no', 1),
(2, '2017-04-07', '5618452114', 'tanawut1', 2460, 'yes', 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `order_tran`
--
ALTER TABLE `order_tran`
  ADD PRIMARY KEY (`ort_id`);

--
-- Indexes for table `transfer`
--
ALTER TABLE `transfer`
  ADD PRIMARY KEY (`tran_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `order_tran`
--
ALTER TABLE `order_tran`
  MODIFY `ort_id` mediumint(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `transfer`
--
ALTER TABLE `transfer`
  MODIFY `tran_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
