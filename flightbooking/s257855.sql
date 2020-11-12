-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 19, 2019 at 08:50 PM
-- Server version: 10.1.40-MariaDB
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `s257855`
--

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `username` text NOT NULL,
  `seat` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`username`, `seat`) VALUES
('u1@p.it', 'A4'),
('u1@p.it', 'D4'),
('u2@p.it', 'F4');

-- --------------------------------------------------------

--
-- Table structure for table `seat`
--

CREATE TABLE `seat` (
  `name` varchar(4) NOT NULL,
  `absnum` int(11) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `seat`
--

INSERT INTO `seat` (`name`, `absnum`, `status`) VALUES
('A1', 1, 'free'),
('A10', 55, 'free'),
('A2', 7, 'free'),
('A3', 13, 'free'),
('A4', 19, 'reserved'),
('A5', 25, 'free'),
('A6', 31, 'free'),
('A7', 37, 'free'),
('A8', 43, 'free'),
('A9', 49, 'free'),
('B1', 2, 'free'),
('B10', 56, 'free'),
('B2', 8, 'purchased'),
('B3', 14, 'purchased'),
('B4', 20, 'purchased'),
('B5', 26, 'free'),
('B6', 32, 'free'),
('B7', 38, 'free'),
('B8', 44, 'free'),
('B9', 50, 'free'),
('C1', 3, 'free'),
('C10', 57, 'free'),
('C2', 9, 'free'),
('C3', 15, 'free'),
('C4', 21, 'free'),
('C5', 27, 'free'),
('C6', 33, 'free'),
('C7', 39, 'free'),
('C8', 45, 'free'),
('C9', 51, 'free'),
('D1', 4, 'free'),
('D10', 58, 'free'),
('D2', 10, 'free'),
('D3', 16, 'free'),
('D4', 22, 'reserved'),
('D5', 28, 'free'),
('D6', 34, 'free'),
('D7', 40, 'free'),
('D8', 46, 'free'),
('D9', 52, 'free'),
('E1', 5, 'free'),
('E10', 59, 'free'),
('E2', 11, 'free'),
('E3', 17, 'free'),
('E4', 23, 'free'),
('E5', 29, 'free'),
('E6', 35, 'free'),
('E7', 41, 'free'),
('E8', 47, 'free'),
('E9', 53, 'free'),
('F1', 6, 'free'),
('F10', 60, 'free'),
('F2', 12, 'free'),
('F3', 18, 'free'),
('F4', 24, 'reserved'),
('F5', 30, 'free'),
('F6', 36, 'free'),
('F7', 42, 'free'),
('F8', 48, 'free'),
('F9', 54, 'free');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`) VALUES
('u1@p.it', '$2y$10$7UeYq8VLhEkze933x50Qi.rW0YFucFVmyr6khO/gBbCJIgRguKKGG'),
('u2@p.it', '$2y$10$QzuBU8HQnyZuXjMBct6zm.gnX80CtKB/tF3UmArQ772B68.uMy.6.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`seat`);

--
-- Indexes for table `seat`
--
ALTER TABLE `seat`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
