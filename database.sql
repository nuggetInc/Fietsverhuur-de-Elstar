-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2022 at 10:23 AM
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

-- --------------------------------------------------------

--
-- Table structure for table `action`
--

CREATE TABLE `action` (
  `employee_name` varchar(64) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `action` enum('Klantenpas aangemaakt','Klantenpas verwijderd','Klantenpas aangepast','Fiets verhuurd','Fiets naar reparatie','Factuur aangemaakt') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `action`
--

INSERT INTO `action` (`employee_name`, `date`, `action`) VALUES
('test', '2022-04-02 10:56:21', ''),
('test', '2022-04-02 10:56:44', ''),
('test', '2022-04-02 10:56:53', ''),
('test', '2022-04-02 10:57:00', ''),
('test', '2022-04-02 10:57:04', ''),
('test', '2022-04-02 10:57:11', ''),
('test', '2022-04-02 10:57:18', ''),
('test', '2022-04-02 10:57:20', ''),
('test', '2022-04-02 10:57:22', ''),
('test', '2022-04-02 10:57:24', ''),
('test', '2022-04-02 10:57:27', ''),
('test', '2022-04-02 10:57:29', ''),
('test', '2022-04-02 10:57:31', ''),
('test', '2022-04-02 10:57:33', ''),
('test', '2022-04-02 10:57:35', ''),
('test', '2022-04-02 10:57:36', ''),
('test', '2022-04-02 10:57:38', ''),
('test', '2022-04-02 10:57:40', ''),
('test', '2022-04-02 10:57:42', ''),
('test', '2022-04-02 10:57:43', ''),
('test', '2022-04-02 10:57:45', ''),
('test', '2022-04-02 10:57:47', ''),
('test', '2022-04-02 10:57:49', ''),
('test', '2022-04-02 10:57:50', ''),
('test', '2022-04-02 10:57:58', ''),
('test', '2022-04-02 10:58:01', ''),
('test', '2022-04-02 10:58:03', ''),
('test', '2022-04-02 10:58:04', '');

-- --------------------------------------------------------

--
-- Table structure for table `bike`
--

CREATE TABLE `bike` (
  `framenumber` varchar(30) NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bike`
--

INSERT INTO `bike` (`framenumber`, `comment`) VALUES
('', 'Niet bestaande fiets'),
('FR128421734', 'trtu\r\n\r\n\r\n'),
('FR141142734', ''),
('FR1431434', 'w'),
('FR143341734', ''),
('FR143348734', ''),
('FR143371344', ''),
('FR143421134', ''),
('FR14381214734', ''),
('FR1438423734', ''),
('FR143843734', ''),
('FR1438734', 'sakfdhkuyoredufigjfdkgdutuieyti8erituritiudytuieriutriuieuugfuiudgufgiufdgiudughdufghuidf\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `bike_rental`
--

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
(1, 'admin', 2, 'FR1431434', '2022-03-16', '2022-03-18', 0, 'reserved', ''),
(2, 'admin', 2, 'FR143348734', '2022-03-16', '2022-03-18', 0, 'reserved', ''),
(3, 'admin', 2, 'FR143341734', '2022-03-17', '2022-03-19', 0, 'reserved', ''),
(4, 'admin', 2, 'FR143341734', '2022-03-17', '2022-03-19', 0, 'returned', ''),
(5, 'admin', 3, 'FR141142734', '2022-03-18', '2022-03-21', 0, 'reserved', ''),
(6, 'admin', 3, 'FR1438734', '2022-03-19', '2022-03-21', 0, 'reserved', '');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

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
(2, 'Dhr.', 'Dustin', 'van de Veerboot', 'Veerboot@gmail.com', '0657830576', '5374NN', 'Papilaan 31', 'Houd vaar vla'),
(3, 'Dhr.', 'Henk', 'de Tank', 'Tanking@gmail.com', '0657830576', '5374NN', 'Papilaan 31', 'Houd vaar vla'),
(4, 'Dhr.', 'Justin', 'van de Veerbal', 'Veerbal@gmail.com', '0657830576', '1234AB', 'Papilaan 31', 'Houd vaar pudding');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `name` varchar(64) NOT NULL,
  `hash` varchar(100) NOT NULL,
  `permission` enum('user','admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`name`, `hash`, `permission`) VALUES
('abc', '$2y$10$ZooFlF4uClS1OiXYExjTYO.sXAWPwFm5YxBUmHJWtu199fCK5mzIC', 'user'),
('admin', '$2y$10$syhj07sBklR8l7ZupaeAn..Vs9gDsArAutTtLDWxgEQzfoQcjSmmW', 'admin'),
('test', '$2y$10$t1Yq.ROKddW1UtI6MiUnC.Om3Lzumr/LjOzfxEPpxHTIOxGx.JOqO', 'user'),
('test2', '$2y$10$hGaBYgWhoneOVkuz7vwQzu/SvP/AM6MTwcFtHP2Ny0ieUC8WtzIKa', 'admin'),
('testt', '$2y$10$2IhtMoO1HMJoccv7hzFjpO1BWqXmgPZPIpBsUKChQlx74UENtJupq', 'user'),
('user', '$2y$10$b3aU.oswV7EqMSvOk3F00u59fseZp6mT1PAKFrUR8kI8a.ve0Ll.a', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `page`
--

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
('bikes', '', 'Fietsen', 6, 'user'),
('bikes/create', 'bikes', 'Creëer', 2, 'admin'),
('bikes/search', 'bikes', 'Zoeken', 1, 'admin'),
('customers', '', 'Klanten', 3, 'user'),
('customers/search', 'customers', 'Zoeken', 0, 'user'),
('developer', '', 'Ontwikkelaar', 11, 'admin'),
('developer/pages', 'developer', 'Pagina\'s', 8, 'admin'),
('developer/pages/add', 'developer/pages', 'Toevoegen', 8, 'admin'),
('developer/pages/remove', 'developer/pages', 'Verwijderen', 8, 'admin'),
('employees', '', 'Werknemers', 9, 'admin'),
('employees/register', 'employees', 'Registreren', 9, 'admin'),
('employees/search', 'employees', 'Zoeken', 8, 'admin'),
('logout', '', 'Uitloggen', 10, 'user'),
('reserve', '', 'Reserveren', 5, 'user'),
('reserve/create_reserve', 'reserve', 'Aanmaken', 7, 'user'),
('reserve/reserve', 'reserve', 'Bekijken', 4, 'user');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

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
