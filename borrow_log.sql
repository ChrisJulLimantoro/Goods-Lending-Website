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
-- Table structure for table `borrow_log`
--

CREATE TABLE `borrow_log` (
  `id_item` varchar(6) NOT NULL,
  `id_user` varchar(25) NOT NULL,
  `start_date` date NOT NULL,
  `expired_date` date NOT NULL,
  `return_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `borrow_log`
--
ALTER TABLE `borrow_log`
  ADD KEY `ITEM_FK` (`id_item`),
  ADD KEY `USER_FK` (`id_user`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `borrow_log`
--
ALTER TABLE `borrow_log`
  ADD CONSTRAINT `ITEM_FK` FOREIGN KEY (`id_item`) REFERENCES `item` (`Id`),
  ADD CONSTRAINT `USER_FK` FOREIGN KEY (`id_user`) REFERENCES `user` (`Username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
