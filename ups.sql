-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 30, 2021 at 02:20 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ups`
--

-- --------------------------------------------------------

--
-- Table structure for table `retailcenter`
--

CREATE TABLE `retailcenter` (
  `retail_id` int(11) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `retail_type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `retailcenter`
--

INSERT INTO `retailcenter` (`retail_id`, `address`, `retail_type`) VALUES
(1, 'egypt,alexandria', 'retail'),
(2, 'egypt,cairo', 'retail');

-- --------------------------------------------------------

--
-- Table structure for table `shippeditem`
--

CREATE TABLE `shippeditem` (
  `shipped_id` int(11) NOT NULL,
  `retailcenter_id` int(11) DEFAULT NULL,
  `destination` varchar(255) DEFAULT NULL,
  `wieght` int(11) DEFAULT NULL,
  `deminsion` int(11) DEFAULT NULL,
  `insurance` varchar(255) DEFAULT NULL,
  `deliverydate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `shippeditem`
--

INSERT INTO `shippeditem` (`shipped_id`, `retailcenter_id`, `destination`, `wieght`, `deminsion`, `insurance`, `deliverydate`) VALUES
(1, 1, 'egypt,cairo', 300, 100, '100', '2021-10-01'),
(2, 2, 'egypt, tanta', 400, 20, '123', '2021-10-02');

-- --------------------------------------------------------

--
-- Table structure for table `transevents`
--

CREATE TABLE `transevents` (
  `schedulenumber` int(11) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `deliveryroute` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transevents`
--

INSERT INTO `transevents` (`schedulenumber`, `type`, `deliveryroute`) VALUES
(1, 'truck', 'start shipping'),
(2, 'flight', 'recived');

-- --------------------------------------------------------

--
-- Table structure for table `transport`
--

CREATE TABLE `transport` (
  `item_id` int(11) NOT NULL,
  `transevents_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transport`
--

INSERT INTO `transport` (`item_id`, `transevents_id`) VALUES
(1, 1),
(2, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `retailcenter`
--
ALTER TABLE `retailcenter`
  ADD PRIMARY KEY (`retail_id`);

--
-- Indexes for table `shippeditem`
--
ALTER TABLE `shippeditem`
  ADD PRIMARY KEY (`shipped_id`),
  ADD KEY `retailcenter_id` (`retailcenter_id`);

--
-- Indexes for table `transevents`
--
ALTER TABLE `transevents`
  ADD PRIMARY KEY (`schedulenumber`);

--
-- Indexes for table `transport`
--
ALTER TABLE `transport`
  ADD PRIMARY KEY (`item_id`,`transevents_id`),
  ADD KEY `transevents_id` (`transevents_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `retailcenter`
--
ALTER TABLE `retailcenter`
  MODIFY `retail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `shippeditem`
--
ALTER TABLE `shippeditem`
  MODIFY `shipped_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transevents`
--
ALTER TABLE `transevents`
  MODIFY `schedulenumber` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `shippeditem`
--
ALTER TABLE `shippeditem`
  ADD CONSTRAINT `shippeditem_ibfk_1` FOREIGN KEY (`retailcenter_id`) REFERENCES `retailcenter` (`retail_id`);

--
-- Constraints for table `transport`
--
ALTER TABLE `transport`
  ADD CONSTRAINT `transport_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `shippeditem` (`shipped_id`),
  ADD CONSTRAINT `transport_ibfk_2` FOREIGN KEY (`transevents_id`) REFERENCES `transevents` (`schedulenumber`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
