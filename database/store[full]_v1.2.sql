-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2017 at 08:34 AM
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
-- Table structure for table `order_tran`
--

CREATE TABLE `order_tran` (
  `ort_id` mediumint(8) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `tran_id` mediumint(8) DEFAULT NULL,
  `quantity` smallint(5) NOT NULL,
  `order_id` mediumint(8) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_tran`
--

INSERT INTO `order_tran` (`ort_id`, `name`, `price`, `tran_id`, `quantity`, `order_id`) VALUES
(5, 'MOUSE PAD NEOLUTION E-SPORT LOGO EDITION MINI', 190, 1, 10, 1000193),
(6, 'MOUSE PAD CORSAIR MM300 SMALL', 690, 2, 1, 1000194),
(7, 'HEADSET RAZER KRAKEN MOBILE PURPLE', 3390, 2, 1, 1000196),
(8, 'KEYBOARD RAZER BLACKWIDOW CHROMA V.2 ENG', 13180, 0, 2, 1000198);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `order_tran`
--
ALTER TABLE `order_tran`
  ADD PRIMARY KEY (`ort_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `order_tran`
--
ALTER TABLE `order_tran`
  MODIFY `ort_id` mediumint(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
