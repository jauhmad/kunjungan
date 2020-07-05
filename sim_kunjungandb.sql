-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 05, 2020 at 04:09 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sim_kunjungandb`
--

-- --------------------------------------------------------

--
-- Table structure for table `gp_checkinout`
--

CREATE TABLE `gp_checkinout` (
  `id` int(11) NOT NULL,
  `userid` varchar(50) NOT NULL,
  `checktime` timestamp NOT NULL DEFAULT current_timestamp(),
  `checktype` varchar(1) DEFAULT NULL,
  `verifycode` int(11) NOT NULL,
  `SN` text DEFAULT NULL,
  `sensorid` text DEFAULT NULL,
  `WorkCode` varchar(20) DEFAULT NULL,
  `Reserved` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `log_akses`
--

CREATE TABLE `log_akses` (
  `id` int(11) NOT NULL,
  `aktifitas` varchar(50) NOT NULL,
  `response` text NOT NULL,
  `username` varchar(50) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `useragent` text NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `log_akses`
--

INSERT INTO `log_akses` (`id`, `aktifitas`, `response`, `username`, `ip`, `useragent`, `tanggal`) VALUES
(1, 'cekin', '{\"error\":true,\"error_msg\":\"Parameter ada yang kurang\"}', '', '', '', '2020-07-03 01:24:28');

-- --------------------------------------------------------

--
-- Table structure for table `lokasi`
--

CREATE TABLE `lokasi` (
  `sensorid` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lokasi`
--

INSERT INTO `lokasi` (`sensorid`, `nama`) VALUES
('123', 'Dinas Kominfo');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gp_checkinout`
--
ALTER TABLE `gp_checkinout`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_akses`
--
ALTER TABLE `log_akses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lokasi`
--
ALTER TABLE `lokasi`
  ADD UNIQUE KEY `sensorid` (`sensorid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gp_checkinout`
--
ALTER TABLE `gp_checkinout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log_akses`
--
ALTER TABLE `log_akses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
