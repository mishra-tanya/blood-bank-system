-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql204.ezyro.com
-- Generation Time: Mar 21, 2024 at 10:39 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ezyro_36191154_db_bbs`
--

-- --------------------------------------------------------

--
-- Table structure for table `add_blood`
--

CREATE TABLE `add_blood` (
  `blood_info_id` int(11) NOT NULL,
  `hospital_id` int(11) DEFAULT NULL,
  `blood_type` varchar(10) DEFAULT NULL,
  `expiration_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `add_blood`
--

INSERT INTO `add_blood` (`blood_info_id`, `hospital_id`, `blood_type`, `expiration_date`) VALUES
(1, 1, 'B+', '2024-03-28'),
(2, 2, 'B-', '2024-03-27'),
(3, 2, 'O+', '2024-03-30'),
(4, 2, 'A+', '2024-03-27'),
(5, 2, 'AB+', '2024-03-26'),
(6, 1, 'O-', '2024-03-27'),
(7, 1, 'B-', '2024-03-28'),
(8, 1, 'AB-', '2024-03-23'),
(9, 1, 'B+', '2024-03-27'),
(10, 3, 'B+', '2024-03-27'),
(11, 3, 'A-', '2024-03-28'),
(12, 3, 'O+', '2024-03-26'),
(13, 3, 'O-', '2024-03-28'),
(14, 4, 'O-', '2024-03-27'),
(15, 4, 'A-', '2024-03-28'),
(16, 4, 'AB+', '2024-03-28');

-- --------------------------------------------------------

--
-- Table structure for table `hospital`
--

CREATE TABLE `hospital` (
  `hospital_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `hospital_name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hospital`
--

INSERT INTO `hospital` (`hospital_id`, `user_id`, `hospital_name`, `address`, `phone_number`) VALUES
(1, 1, 'Artemis Hospital', 'Gurugram, Haryana ', '9876543210'),
(2, 2, 'Star Hospital', 'Bhiwadi, Rajasthan', '9753212468'),
(3, 4, 'Fortis Research Institute', 'Gurugram, Haryana ', '7776626262'),
(4, 5, 'Bansal Hospital', 'Bhiwadi, Rajasthan', '9999999999');

-- --------------------------------------------------------

--
-- Table structure for table `receiver`
--

CREATE TABLE `receiver` (
  `receiver_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `blood_group` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `receiver`
--

INSERT INTO `receiver` (`receiver_id`, `user_id`, `full_name`, `address`, `phone_number`, `blood_group`) VALUES
(1, 3, 'Rose', 'Alwar, Rajasthan', '8765432190', 'A+'),
(2, 6, 'Tanya', 'Bhiwadi, Rajasthan', '8888888888', 'O+');

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `request_id` int(11) NOT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `blood_info_id` int(11) DEFAULT NULL,
  `request_date` date DEFAULT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`request_id`, `receiver_id`, `blood_info_id`, `request_date`, `status`) VALUES
(1, 1, 3, '2024-03-20', ''),
(2, 1, 11, '2024-03-20', ''),
(3, 1, 6, '2024-03-20', ''),
(4, 2, 14, '2024-03-21', 'Transferred'),
(5, 2, 12, '2024-03-21', ''),
(6, 2, 13, '2024-03-21', '');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `user_type` enum('Hospital','Receiver') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `email`, `password`, `user_type`) VALUES
(1, 'a@gmail.com', '123', 'Hospital'),
(2, 'star@gmail.com', '123', 'Hospital'),
(3, 'rose@gmail.com', '123', 'Receiver'),
(4, 'f@gmail.com', '123', 'Hospital'),
(5, 'ba@gmail.com', '123', 'Hospital'),
(6, 'ta@gmail.com', '123', 'Receiver');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `add_blood`
--
ALTER TABLE `add_blood`
  ADD PRIMARY KEY (`blood_info_id`),
  ADD KEY `hospital_id` (`hospital_id`);

--
-- Indexes for table `hospital`
--
ALTER TABLE `hospital`
  ADD PRIMARY KEY (`hospital_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `receiver`
--
ALTER TABLE `receiver`
  ADD PRIMARY KEY (`receiver_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `receiver_id` (`receiver_id`),
  ADD KEY `blood_info_id` (`blood_info_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `add_blood`
--
ALTER TABLE `add_blood`
  MODIFY `blood_info_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `hospital`
--
ALTER TABLE `hospital`
  MODIFY `hospital_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `receiver`
--
ALTER TABLE `receiver`
  MODIFY `receiver_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `add_blood`
--
ALTER TABLE `add_blood`
  ADD CONSTRAINT `add_blood_ibfk_1` FOREIGN KEY (`hospital_id`) REFERENCES `hospital` (`hospital_id`);

--
-- Constraints for table `hospital`
--
ALTER TABLE `hospital`
  ADD CONSTRAINT `hospital_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `receiver`
--
ALTER TABLE `receiver`
  ADD CONSTRAINT `receiver_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `request`
--
ALTER TABLE `request`
  ADD CONSTRAINT `request_ibfk_1` FOREIGN KEY (`receiver_id`) REFERENCES `receiver` (`receiver_id`),
  ADD CONSTRAINT `request_ibfk_2` FOREIGN KEY (`blood_info_id`) REFERENCES `add_blood` (`blood_info_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
