-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 16, 2018 at 07:07 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.0.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `currency`
--

-- --------------------------------------------------------

--
-- Table structure for table `currency_trans`
--

CREATE TABLE `currency_trans` (
  `currencytrans_id` int(11) NOT NULL,
  `currency_from` varchar(11) NOT NULL,
  `currency_to` varchar(11) NOT NULL,
  `currency_rate` float NOT NULL,
  `currency_date` date NOT NULL,
  `currencytrans_status` int(2) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `currency_trans`
--
ALTER TABLE `currency_trans`
  ADD PRIMARY KEY (`currencytrans_id`),
  ADD UNIQUE KEY `currency_from` (`currency_from`,`currency_to`,`currency_date`),
  ADD KEY `currency_idfrom` (`currency_from`),
  ADD KEY `currency_idto` (`currency_to`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `currency_trans`
--
ALTER TABLE `currency_trans`
  MODIFY `currencytrans_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
