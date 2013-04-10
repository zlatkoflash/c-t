-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 24, 2012 at 08:59 PM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE IF NOT EXISTS `states` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `abbreviation` varchar(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=67 ;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `name`, `abbreviation`) VALUES
(1, 'Alberta', 'AB'),
(2, 'British Columbia', 'BC'),
(3, 'Manitoba', 'MB'),
(4, 'New Brunswick', 'NB'),
(5, 'Newfoundland and Labrador', 'NL'),
(6, 'Northwest Territories', 'NT'),
(7, 'Nova Scotia', 'NS'),
(8, 'Nunavut', 'NU'),
(9, 'Ontario', 'ON'),
(10, 'Prince Edward Island', 'PE'),
(11, 'Québec', 'QC'),
(12, 'Saskatchewan', 'SK'),
(13, 'Yukon Territory', 'YT'),
(14, 'Alaska', 'AK'),
(15, 'Alabama', 'AL'),
(16, 'Arizona', 'AZ'),
(17, 'Arkansas', 'AR'),
(18, 'California', 'CA'),
(19, 'Colorado', 'CO'),
(20, 'Connecticut', 'CT'),
(21, 'Delaware', 'DE'),
(22, 'District of Columbia', 'DC'),
(23, 'Florida', 'FL'),
(24, 'Georgia', 'GA'),
(25, 'Hawaii', 'HI'),
(26, 'Idaho', 'ID'),
(27, 'Illinois', 'IL'),
(28, 'Indiana', 'IN'),
(29, 'Iowa', 'IA'),
(30, 'Kansas', 'KS'),
(31, 'Kentucky', 'KY'),
(32, 'Louisiana', 'LA'),
(33, 'Maine', 'ME'),
(34, 'Maryland', 'MD'),
(35, 'Massachusetts', 'MA'),
(36, 'Michigan', 'MI'),
(37, 'Minnesota', 'MN'),
(38, 'Mississippi', 'MS'),
(39, 'Missouri', 'MO'),
(40, 'Montana', 'MT'),
(41, 'Nebraska', 'NE'),
(42, 'Nevada', 'NV'),
(43, 'New Hampshire', 'NH'),
(44, 'New Jersey', 'NJ'),
(45, 'New Mexico', 'NM'),
(46, 'New York', 'NY'),
(47, 'North Carolina', 'NC'),
(48, 'North Dakota', 'ND'),
(49, 'Ohio', 'OH'),
(50, 'Oklahoma', 'OK'),
(51, 'Oregon', 'OR'),
(52, 'Pennsylvania', 'PA'),
(53, 'Puerto Rico', 'PR'),
(54, 'Rhode Island', 'RI'),
(55, 'South Carolina', 'SC'),
(56, 'South Dakota', 'SD'),
(57, 'Tennessee', 'TN'),
(58, 'Texas', 'TX'),
(59, 'Utah', 'UT'),
(60, 'Vermont', 'VT'),
(61, 'Virginia', 'VA'),
(62, 'Washington', 'WA'),
(63, 'West Virginia', 'WV'),
(64, 'Wisconsin', 'WI'),
(65, 'Wyoming', 'WY'),
(66, 'Outside U.S./Canada', '--');
