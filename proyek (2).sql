-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 19, 2022 at 01:08 PM
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
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `Username` varchar(25) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `profile` varchar(100) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`Username`, `Password`, `profile`, `status`) VALUES
('Chris_Jul02', '*2D72B499529876BC115375796B8B89A51581C0D2', 'profile/profileDefault.jpg', 1),
('sidi_P01', '*0A7EA496DAD9B02CD598AB2EB676679097644B41', 'profile/profileDefault.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `borrow`
--

CREATE TABLE `borrow` (
  `id_borrow` varchar(10) NOT NULL,
  `id_user` varchar(30) NOT NULL,
  `start_date` date NOT NULL,
  `expired_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `status_pinjam` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `borrow`
--

INSERT INTO `borrow` (`id_borrow`, `id_user`, `start_date`, `expired_date`, `return_date`, `status_pinjam`) VALUES
('B0001', 'ChrisJul02', '2022-12-03', '2022-12-17', NULL, 2),
('B0002', 'LeoNick01', '2022-12-08', '2022-12-10', NULL, 2),
('B0003', 'SidiP01', '2022-12-10', '2022-12-14', NULL, 2),
('B0004', 'ChrisJul02', '2022-12-10', '2022-12-17', NULL, 2),
('B0005', 'LeoNick01', '2022-12-17', '2022-12-24', NULL, 2),
('B0006', 'sidiP01', '2022-12-01', '2022-12-10', NULL, 2),
('B0007', 'leoNick01', '2022-12-10', '2022-12-12', '2022-12-12', 2),
('B0008', 'sidiP01', '2022-12-14', '2022-12-15', '2022-12-15', 2),
('B0009', 'ChrisJul02', '2022-12-17', '2022-12-19', '2022-12-19', 2);

--
-- Triggers `borrow`
--
DELIMITER $$
CREATE TRIGGER `onDeleteBorrow` AFTER DELETE ON `borrow` FOR EACH ROW UPDATE `user`
SET `status` = 0
WHERE `username` = OLD.id_user
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `onInsertBorrow` AFTER INSERT ON `borrow` FOR EACH ROW UPDATE `user` SET `status` = 1 WHERE `Username` = NEW.ID_USER
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `borrow_detail`
--

CREATE TABLE `borrow_detail` (
  `id_borrow` varchar(10) NOT NULL,
  `id_item` varchar(10) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `borrow_detail`
--

INSERT INTO `borrow_detail` (`id_borrow`, `id_item`, `status`) VALUES
('B0001', NULL, 2),
('B0001', 'C0001', 2),
('B0001', 'T0003', 2),
('B0003', 'P0001', 2),
('B0003', 'T0001', 2),
('B0004', NULL, 2),
('B0005', 'T0003', 2),
('B0005', 'P0001', 2),
('B0006', NULL, 2),
('B0007', 'C0001', 4),
('B0007', 'T0001', 4),
('B0008', 'T0003', 4),
('B0009', 'C0001', 4),
('B0009', NULL, 4),
('B0009', 'T0003', 4);

--
-- Triggers `borrow_detail`
--
DELIMITER $$
CREATE TRIGGER `onInsertItem` AFTER INSERT ON `borrow_detail` FOR EACH ROW UPDATE `item` SET `status` = 0 WHERE `Id` = NEW.id_item
$$
DELIMITER ;

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
  `image` varchar(250) NOT NULL DEFAULT 'assets/no-image.png',
  `image2` varchar(250) NOT NULL DEFAULT 'assets/no-image.png',
  `image3` varchar(250) NOT NULL DEFAULT 'assets/no-image.png',
  `image4` varchar(250) NOT NULL DEFAULT 'assets/no-image.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`Id`, `Nama_Barang`, `Deskripsi`, `Status`, `Location`, `image`, `image2`, `image3`, `image4`) VALUES
('C0001', 'Walkie Talkie', 'Walkie Talkie', 1, 'C', 'item/WT.jfif', 'item/WT.jfif', 'item/WT.jfif', 'assets/no-image.png'),
('P0001', 'Mic + Speaker', 'Spekaer portable lengkap dengan Mic', 1, 'P', 'item/mic.jfif', 'item/speaker.jfif', 'item/mic.jfif', 'assets/no-image.png'),
('T0001', 'Walkie Talkie', 'Walkie Talkie', 1, 'T', 'item/WT.jfif', 'item/WT.jfif', 'assets/no-image.png', 'assets/no-image.png'),
('T0003', 'Speaker Portable', 'Speaker yang Portable', 1, 'T', 'item/speaker.jfif', 'assets/no-image.png', 'assets/no-image.png', 'assets/no-image.png');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `Username` varchar(25) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `join_date` date NOT NULL DEFAULT current_timestamp(),
  `profile` varchar(100) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`Username`, `Password`, `first_name`, `last_name`, `phone_number`, `email`, `join_date`, `profile`, `status`) VALUES
('ChrisJul02', '*0602F59A0C4745C3EE610B9179F5565BD00CAE85', 'CHRISTOPHER', 'JULIUS', '08123948321', 'ChrisJul02@gmail.com', '2022-11-18', 'profile/GALAXY.png', 0),
('hallo', '*84AAC12F54AB666ECFC2A83C676908C8BBC381B1', 'HALLO', 'BYEE', '08133294935', 'halloBye@gmail.com', '2022-12-01', 'profile/profileDefault.jpg', 0),
('leoNick01', '*199C1DB1D0EC353830F17988643384A565BD48AC', 'LEONARDO', 'NICKHOLAS', '08192749234', 'leoNick01@gmail.com', '2022-11-22', 'profile/actor-pubg.png', 0),
('sidiP01', '*72639C0B8E1D0740964DD2CE1B34E4580845CA1B', 'SIDI', 'PRAPTAMA', '08299491724', 'SidiP01@gmail.com', '2022-11-23', 'profile/bisndo1.png', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`Username`);

--
-- Indexes for table `borrow`
--
ALTER TABLE `borrow`
  ADD PRIMARY KEY (`id_borrow`),
  ADD KEY `user_fk` (`id_user`);

--
-- Indexes for table `borrow_detail`
--
ALTER TABLE `borrow_detail`
  ADD KEY `borrow_fk` (`id_borrow`),
  ADD KEY `item_fk` (`id_item`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`Username`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `borrow`
--
ALTER TABLE `borrow`
  ADD CONSTRAINT `user_fk` FOREIGN KEY (`id_user`) REFERENCES `user` (`Username`) ON UPDATE CASCADE;

--
-- Constraints for table `borrow_detail`
--
ALTER TABLE `borrow_detail`
  ADD CONSTRAINT `borrow_fk` FOREIGN KEY (`id_borrow`) REFERENCES `borrow` (`id_borrow`) ON DELETE CASCADE,
  ADD CONSTRAINT `item_fk` FOREIGN KEY (`id_item`) REFERENCES `item` (`Id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
