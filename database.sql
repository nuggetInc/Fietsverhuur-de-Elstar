-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 18, 2022 at 09:35 AM
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
-- Database: `fietsverhuur_de_elstar`
--
CREATE DATABASE IF NOT EXISTS `fietsverhuur_de_elstar` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `fietsverhuur_de_elstar`;

-- --------------------------------------------------------

--
-- Table structure for table `action`
--

DROP TABLE IF EXISTS `action`;
CREATE TABLE `action` (
  `employee_name` varchar(64) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `action` enum('Klantenpas aangemaakt','Klantenpas verwijderd','Klantenpas aangepast','Fiets verhuurd','Fiets naar reparatie','Factuur aangemaakt') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bike`
--

DROP TABLE IF EXISTS `bike`;
CREATE TABLE `bike` (
  `framenumber` varchar(30) NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bike`
--

INSERT INTO `bike` (`framenumber`, `comment`) VALUES
('FR128421734', ''),
('FR141142734', ''),
('FR1431434', ''),
('FR143341734', ''),
('FR143348734', ''),
('FR143371344', ''),
('FR143421134', ''),
('FR14381214734', ''),
('FR1438423734', ''),
('FR143843734', ''),
('FR1438734', '');

-- --------------------------------------------------------

--
-- Table structure for table `bike_rental`
--

DROP TABLE IF EXISTS `bike_rental`;
CREATE TABLE `bike_rental` (
  `id` int(11) NOT NULL,
  `employee_name` varchar(64) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `framenumber` varchar(30) NOT NULL,
  `date_from` date NOT NULL DEFAULT current_timestamp(),
  `date_to` date NOT NULL,
  `child_seat` tinyint(1) NOT NULL,
  `status` enum('reserved','rented_out','returned') NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bike_rental`
--

INSERT INTO `bike_rental` (`id`, `employee_name`, `customer_id`, `framenumber`, `date_from`, `date_to`, `child_seat`, `status`, `comment`) VALUES
(1, 'admin', 2, 'FR1431434', '2022-03-16', '2022-03-18', 0, 'reserved', '');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `salutation` varchar(20) NOT NULL,
  `name` varchar(45) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phonenumber` varchar(20) NOT NULL,
  `postalcode` varchar(8) NOT NULL,
  `address` varchar(100) NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `salutation`, `name`, `surname`, `email`, `phonenumber`, `postalcode`, `address`, `comment`) VALUES
(2, 'Dhr.', 'Dustin', 'van de Veerboot', 'Veerboot@gmail.com', '0657830576', '5374NN', 'Papilaan 31', 'Houd vaar vla');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
CREATE TABLE `employee` (
  `name` varchar(64) NOT NULL,
  `hash` varchar(100) NOT NULL,
  `permission` enum('user','admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`name`, `hash`, `permission`) VALUES
('admin', '$2y$10$syhj07sBklR8l7ZupaeAn..Vs9gDsArAutTtLDWxgEQzfoQcjSmmW', 'admin'),
('test', '$2y$10$t1Yq.ROKddW1UtI6MiUnC.Om3Lzumr/LjOzfxEPpxHTIOxGx.JOqO', 'user'),
('test2', '$2y$10$hGaBYgWhoneOVkuz7vwQzu/SvP/AM6MTwcFtHP2Ny0ieUC8WtzIKa', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `page`
--

DROP TABLE IF EXISTS `page`;
CREATE TABLE `page` (
  `name` varchar(64) NOT NULL,
  `parent` varchar(64) NOT NULL,
  `display` varchar(64) NOT NULL,
  `order` int(8) NOT NULL DEFAULT 0,
  `permission` enum('user','admin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `page`
--

INSERT INTO `page` (`name`, `parent`, `display`, `order`, `permission`) VALUES
('developer', '', 'Ontwikkelaar', 4, 'admin'),
('developer/pages', 'developer', 'Pagina\'s', 0, 'admin'),
('developer/pages/add', 'developer/pages', 'Toevoegen', 0, 'admin'),
('developer/pages/remove', 'developer/pages', 'Verwijderen', 1, 'admin'),
('employees', '', 'Werknemers', 2, 'admin'),
('employees/register', 'employees', 'Registreren', 2, 'admin'),
('employees/search', 'employees', 'Zoeken', 0, 'admin'),
('logout', '', 'Uitloggen', 3, 'user'),
('reserve', '', 'Reserveren', 0, 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `action`
--
ALTER TABLE `action`
  ADD PRIMARY KEY (`employee_name`,`date`,`action`);

--
-- Indexes for table `bike`
--
ALTER TABLE `bike`
  ADD PRIMARY KEY (`framenumber`);

--
-- Indexes for table `bike_rental`
--
ALTER TABLE `bike_rental`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bike_id` (`framenumber`),
  ADD KEY `custommer_id` (`customer_id`),
  ADD KEY `employee_id` (`employee_name`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`name`),
  ADD KEY `parent` (`parent`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bike_rental`
--
ALTER TABLE `bike_rental`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `action`
--
ALTER TABLE `action`
  ADD CONSTRAINT `action_ibfk_1` FOREIGN KEY (`employee_name`) REFERENCES `employee` (`name`);

--
-- Constraints for table `bike_rental`
--
ALTER TABLE `bike_rental`
  ADD CONSTRAINT `bike_rental_ibfk_1` FOREIGN KEY (`employee_name`) REFERENCES `employee` (`name`),
  ADD CONSTRAINT `bike_rental_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`),
  ADD CONSTRAINT `bike_rental_ibfk_3` FOREIGN KEY (`framenumber`) REFERENCES `bike` (`framenumber`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
