-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 18, 2021 at 07:44 AM
-- Server version: 5.7.19
-- PHP Version: 7.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spotkaster`
--

-- --------------------------------------------------------

--
-- Table structure for table `face`
--

CREATE TABLE `face` (
  `id_face_table` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `face_id` int(11) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `telp` varchar(50) NOT NULL,
  `del_face_id` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `id_log` int(11) NOT NULL,
  `id_face_table` int(11) NOT NULL,
  `log_masuk` int(11) NOT NULL,
  `suhu` varchar(50) NOT NULL,
  `masker` varchar(50) NOT NULL,
  `presensi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `waktu_operasional`
--

CREATE TABLE `waktu_operasional` (
  `id_waktu_operasional` int(11) NOT NULL,
  `waktu_operasional` varchar(20) NOT NULL,
  `keterangan` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `waktu_operasional`
--

INSERT INTO `waktu_operasional` (`id_waktu_operasional`, `waktu_operasional`, `keterangan`) VALUES
(1, '06:00-09:30', 'masuk');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `face`
--
ALTER TABLE `face`
  ADD PRIMARY KEY (`id_face_table`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id_log`);

--
-- Indexes for table `waktu_operasional`
--
ALTER TABLE `waktu_operasional`
  ADD PRIMARY KEY (`id_waktu_operasional`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `face`
--
ALTER TABLE `face`
  MODIFY `id_face_table` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `waktu_operasional`
--
ALTER TABLE `waktu_operasional`
  MODIFY `id_waktu_operasional` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
