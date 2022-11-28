-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2022 at 12:59 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `proyek`
--

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `Id` varchar(8) NOT NULL,
  `Nama_Barang` varchar(30) NOT NULL,
  `Deskripsi` varchar(500) NOT NULL,
  `Status` int(1) NOT NULL,
  `Location` varchar(5) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`Id`, `Nama_Barang`, `Deskripsi`, `Status`, `Location`, `image`) VALUES
('MIC001', 'Microphone', 'Microphone ini wireless dan tanpa kabel', 1, 'P', 'item/mic.jfif'),
('MIC002', 'Microphone', 'Microphone ini wireless dan tanpa kabel', 1, 'P', 'item/mic.jfif'),
('MIC003', 'Microphone', 'Microphone ini wireless dan tanpa kabel', 1, 'P', 'item/mic.jfif'),
('MIC004', 'Microphone', 'Microphone ini wireless dan tanpa kabel', 1, 'T', 'item/mic.jfif'),
('MIC005', 'Microphone', 'Microphone ini wireless dan tanpa kabel', 1, 'T', 'item/mic.jfif'),
('MIC006', 'Microphone', 'Microphone ini wireless dan tanpa kabel', 1, 'C', 'item/mic.jfif'),
('MIC007', 'Microphone', 'Microphone ini wireless dan tanpa kabel', 1, 'C', 'item/mic.jfif'),
('MIC008', 'Microphone', 'Microphone ini wireless dan tanpa kabel', 1, 'C', 'item/mic.jfif'),
('SPK001', 'Speaker', 'Speaker ukuran besar sekitar 50 cm x 50 cm', 1, 'P', 'item/speaker.jfif'),
('SPK002', 'Speaker', 'Speaker ukuran besar sekitar 50 cm x 50 cm', 1, 'P', 'item/speaker.jfif'),
('SPK003', 'Speaker', 'Speaker ukuran besar sekitar 50 cm x 50 cm', 1, 'T', 'item/speaker.jfif'),
('SPK004', 'Speaker', 'Speaker ukuran besar sekitar 50 cm x 50 cm', 1, 'T', 'item/speaker.jfif'),
('SPK005', 'Speaker', 'Speaker ukuran besar sekitar 50 cm x 50 cm', 1, 'P', 'item/speaker.jfif'),
('WTY001', 'Walkie Talkie', 'Walkie Talkie yang wireless memiliki maksimal 10 channel', 1, 'P', 'item/WT.jfif'),
('WTY002', 'Walkie Talkie', 'Walkie Talkie yang wireless memiliki maksimal 10 channel', 1, 'T', 'item/WT.jfif'),
('WTY003', 'Walkie Talkie', 'Walkie Talkie yang wireless memiliki maksimal 10 channel', 1, 'T', 'item/WT.jfif'),
('WTY004', 'Walkie Talkie', 'Walkie Talkie yang wireless memiliki maksimal 10 channel', 1, 'C', 'item/WT.jfif'),
('WTY005', 'Walkie Talkie', 'Walkie Talkie yang wireless memiliki maksimal 10 channel', 1, 'C', 'item/WT.jfif'),
('WTY006', 'Walkie Talkie', 'Walkie Talkie yang wireless memiliki maksimal 10 channel', 1, 'P', 'item/WT.jfif'),
('WTY007', 'Walkie Talkie', 'Walkie Talkie yang wireless memiliki maksimal 10 channel', 1, 'C', 'item/WT.jfif');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
