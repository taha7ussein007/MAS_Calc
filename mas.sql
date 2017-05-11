-- phpMyAdmin SQL Dump
-- version 4.4.3
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2015 at 02:05 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mas`
--

-- --------------------------------------------------------

--
-- Table structure for table `swe`
--

CREATE TABLE IF NOT EXISTS `swe` (
  `period` int(11) NOT NULL COMMENT 'Month, Year, etc.',
  `quantity` double DEFAULT NULL COMMENT 'Demand, Supply, etc.',
  `sma_forecast` double DEFAULT NULL,
  `wma_forecast` double DEFAULT NULL,
  `esm_forecast` double DEFAULT NULL,
  `sma_abserr` double DEFAULT NULL,
  `wma_abserr` double DEFAULT NULL,
  `esm_abserr` double DEFAULT NULL,
  `year` int(4) DEFAULT NULL,
  `month` varchar(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trend`
--

CREATE TABLE IF NOT EXISTS `trend` (
  `id` int(11) NOT NULL,
  `x` double NOT NULL,
  `y` double NOT NULL,
  `xx` double DEFAULT NULL,
  `xy` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `weights`
--

CREATE TABLE IF NOT EXISTS `weights` (
  `period` int(11) NOT NULL COMMENT 'Last(Month, Year, etc)',
  `weight` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `swe`
--
ALTER TABLE `swe`
  ADD PRIMARY KEY (`period`);

--
-- Indexes for table `trend`
--
ALTER TABLE `trend`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `weights`
--
ALTER TABLE `weights`
  ADD PRIMARY KEY (`period`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `swe`
--
ALTER TABLE `swe`
  MODIFY `period` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Month, Year, etc.';
--
-- AUTO_INCREMENT for table `trend`
--
ALTER TABLE `trend`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `weights`
--
ALTER TABLE `weights`
  MODIFY `period` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Last(Month, Year, etc)';
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
