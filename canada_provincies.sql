-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 20, 2012 at 10:12 AM
-- Server version: 5.1.36
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cheque_wp`
--

-- --------------------------------------------------------

--
-- Table structure for table `canada_provincies`
--

CREATE TABLE IF NOT EXISTS `canada_provincies` (
  `name` varchar(26) NOT NULL,
  `abv` char(2) NOT NULL,
  PRIMARY KEY (`abv`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `canada_provincies`
--

INSERT INTO `canada_provincies` (`name`, `abv`) VALUES
('Alberta', 'AB'),
('British Columbia', 'BC'),
('Manitoba', 'MB'),
('New Brunswick', 'NB'),
('Newfoundland and Labrador', 'NL'),
('Northwest Territories', 'NT'),
('Nova Scotia', 'NS'),
('Nunavut', 'NU'),
('Ontario', 'ON'),
('Prince Edward Island', 'PE'),
('Quebec', 'QC'),
('Saskatchewan', 'SK'),
('Yukon', 'YT');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
