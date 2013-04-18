-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 17, 2013 at 11:41 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `muhamed_cheque_wp`
--

-- --------------------------------------------------------

--
-- Table structure for table `taxes`
--

CREATE TABLE IF NOT EXISTS `taxes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `AB` float NOT NULL DEFAULT '5',
  `BC` float NOT NULL DEFAULT '5',
  `MB` float NOT NULL DEFAULT '5',
  `NB` float NOT NULL DEFAULT '13',
  `NL` float NOT NULL DEFAULT '13',
  `NS` float NOT NULL DEFAULT '15',
  `NT` float NOT NULL DEFAULT '5',
  `NU` float NOT NULL DEFAULT '5',
  `ON` float NOT NULL DEFAULT '13',
  `PE` float NOT NULL DEFAULT '5',
  `QC` float NOT NULL DEFAULT '5',
  `SK` float NOT NULL DEFAULT '5',
  `YT` float NOT NULL DEFAULT '5',
  `order_number` varchar(20) NOT NULL DEFAULT 'universal',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `taxes`
--

INSERT INTO `taxes` (`id`, `AB`, `BC`, `MB`, `NB`, `NL`, `NS`, `NT`, `NU`, `ON`, `PE`, `QC`, `SK`, `YT`, `order_number`) VALUES
(1, 5, 5, 5, 100, 13, 15, 5, 5, 13, 5, 5, 5, 5, 'universal');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
