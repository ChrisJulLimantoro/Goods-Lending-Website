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
  `profile` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`Username`, `Password`, `first_name`, `last_name`, `phone_number`, `email`, `join_date`, `profile`) VALUES
('ChrisJul02', '*0602F59A0C4745C3EE610B9179F5565BD00CAE85', 'CHRISTOPHER', 'JULIUS', '08123948321', 'ChrisJul02@gmail.com', '2022-11-18', 'profile/GALAXY.png'),
('leoNick01', '*199C1DB1D0EC353830F17988643384A565BD48AC', 'LEONARDO', 'NICKHOLAS', '08192749234', 'leoNick01@gmail.com', '2022-11-22', 'profile/actor-pubg.png'),
('sidiP01', '*72639C0B8E1D0740964DD2CE1B34E4580845CA1B', 'SIDI', 'PRAPTAMA', '08299491724', 'SidiP01@gmail.com', '2022-11-23', 'profile/bisndo1.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`Username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
