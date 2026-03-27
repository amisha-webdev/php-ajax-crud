-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 27, 2026 at 09:37 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dropdown_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `district`
--

CREATE TABLE `district` (
  `id` int(11) NOT NULL,
  `state_id` int(11) DEFAULT NULL,
  `district_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `district`
--

INSERT INTO `district` (`id`, `state_id`, `district_name`) VALUES
(1, 1, 'Lucknow'),
(2, 1, 'Kanpur'),
(3, 1, 'Prayagraj'),
(4, 1, 'Varanasi'),
(5, 1, 'Agra'),
(6, 2, 'New Delhi'),
(7, 2, 'South Delhi'),
(8, 2, 'North Delhi'),
(9, 2, 'Dwarka'),
(10, 3, 'Mumbai'),
(11, 3, 'Pune'),
(12, 3, 'Nagpur'),
(13, 3, 'Nashik'),
(14, 4, 'Jaipur'),
(15, 4, 'Jodhpur'),
(16, 4, 'Udaipur'),
(17, 4, 'Kota'),
(18, 5, 'Bhopal'),
(19, 5, 'Indore'),
(20, 5, 'Gwalior'),
(21, 5, 'Jabalpur');

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

CREATE TABLE `state` (
  `id` int(11) NOT NULL,
  `state_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `state`
--

INSERT INTO `state` (`id`, `state_name`) VALUES
(1, 'Uttar Pradesh'),
(2, 'Delhi'),
(3, 'Maharashtra'),
(4, 'Rajasthan'),
(5, 'Madhya Pradesh');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone_no` varchar(15) NOT NULL,
  `address` varchar(50) NOT NULL,
  `state_id` int(40) NOT NULL,
  `district_id` int(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `name`, `email`, `phone_no`, `address`, `state_id`, `district_id`) VALUES
(3, 'Arpita', 'arpita@gmail.com', '3456789456', 'Lucknow', 1, 4),
(4, 'Amu', 'amu@gmail.com', '5657879876', 'Lucknow', 4, 17),
(5, 'Anchal', 'anchal@gmail.com', '7678798767', 'Lucknow', 2, 8),
(8, 'Emily', 'emily@gmail.com', '4567890787', 'Lucknow', 3, 12);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `district`
--
ALTER TABLE `district`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `state`
--
ALTER TABLE `state`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `district`
--
ALTER TABLE `district`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `state`
--
ALTER TABLE `state`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
