-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2022 at 04:20 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eventprod`
--

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `ID` int(11) NOT NULL,
  `Event` int(11) DEFAULT NULL,
  `Categories` longtext DEFAULT NULL,
  `Inclussions` longtext DEFAULT NULL,
  `Images` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`ID`, `Event`, `Categories`, `Inclussions`, `Images`) VALUES
(1, 1, '[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"7\",\"9\"]', '[\"1\",\"2\",\"4\",\"8\",\"34\",\"5\",\"6\",\"7\",\"9\",\"10\",\"11\",\"12\",\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\",\"20\",\"21\",\"22\",\"23\",\"24\",\"25\",\"26\",\"27\",\"28\",\"29\",\"30\",\"31\",\"32\",\"33\",\"35\",\"36\",\"37\",\"38\",\"39\",\"40\",\"41\",\"42\"]', NULL),
(2, 2, '[\"1\",\"3\",\"5\",\"6\",\"7\",\"9\",\"10\",\"11\"]', '[\"1\",\"2\",\"4\",\"8\",\"9\",\"10\",\"11\",\"12\",\"13\",\"14\",\"15\",\"22\",\"23\",\"24\",\"25\",\"51\",\"52\",\"26\",\"27\",\"28\",\"29\",\"30\",\"31\",\"32\",\"35\",\"38\",\"39\",\"40\",\"41\",\"53\",\"43\",\"44\",\"45\",\"46\",\"47\",\"48\",\"49\",\"50\"]', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
