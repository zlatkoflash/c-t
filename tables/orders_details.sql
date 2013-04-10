-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 13, 2012 at 03:13 PM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_xml`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders_details`
--

CREATE TABLE IF NOT EXISTS `orders_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderNumber` varchar(100) NOT NULL,
  `CICompanyName` varchar(300) NOT NULL DEFAULT '',
  `CIContactName` varchar(300) NOT NULL DEFAULT '',
  `CIPhone` varchar(300) NOT NULL DEFAULT '',
  `CIEmail` varchar(300) NOT NULL DEFAULT '',
  `CIQuestionsAndCommentsTA` varchar(300) NOT NULL DEFAULT '',
  `CIQuestionsAndComments` varchar(300) NOT NULL DEFAULT '',
  `compInfoQuantity` varchar(300) NOT NULL DEFAULT '',
  `quantityINPUT` varchar(300) NOT NULL DEFAULT '',
  `quantityINPUTIndex` varchar(300) NOT NULL DEFAULT '',
  `chequePosition` varchar(300) NOT NULL DEFAULT '',
  `chequeColor` varchar(300) NOT NULL DEFAULT '',
  `backgroundINdex` varchar(300) NOT NULL DEFAULT '',
  `compInfoName` varchar(300) NOT NULL DEFAULT '',
  `compInfoSecondName` varchar(300) NOT NULL DEFAULT '',
  `compInfoAddressLine1` varchar(300) NOT NULL DEFAULT '',
  `compInfoAddressLine2` varchar(300) NOT NULL DEFAULT '',
  `compInfoAddressLine3` varchar(300) NOT NULL DEFAULT '',
  `compInfoAddressLine4` varchar(300) NOT NULL DEFAULT '',
  `comInfoIsSecondCompanyName` varchar(300) NOT NULL DEFAULT '',
  `compInfoBankName` varchar(300) NOT NULL DEFAULT '',
  `compInfoBankAddress1` varchar(300) NOT NULL DEFAULT '',
  `compInfoBankAddress2` varchar(300) NOT NULL DEFAULT '',
  `compInfoBankAddress3` varchar(300) NOT NULL DEFAULT '',
  `compInfoBankAddress4` varchar(300) NOT NULL DEFAULT '',
  `isCurrencyINPUT` varchar(300) NOT NULL DEFAULT '',
  `add45AfterAcountNumberInput` varchar(300) NOT NULL DEFAULT '',
  `compInfoSoftware` varchar(300) NOT NULL DEFAULT '',
  `compInfoSecondSignatur` varchar(300) NOT NULL DEFAULT '',
  `compInfoShowStartNumber` varchar(300) NOT NULL DEFAULT '',
  `compInfoStartAt` varchar(300) NOT NULL DEFAULT '',
  `compInfoBrunchNumber` varchar(300) NOT NULL DEFAULT '',
  `compInfoTransitNumber` varchar(300) NOT NULL DEFAULT '',
  `compInfoAccountNumber` varchar(300) NOT NULL DEFAULT '',
  `compInfoStartAtTrueOrFalse` varchar(300) NOT NULL DEFAULT '',
  `isThereSecondSignature` varchar(300) NOT NULL DEFAULT '',
  `softwareINPUT` varchar(300) NOT NULL DEFAULT '',
  `boxingType` varchar(300) NOT NULL DEFAULT '',
  `compInfoDepositBooks` varchar(300) NOT NULL DEFAULT '',
  `compInfoDWE` varchar(300) NOT NULL DEFAULT '',
  `compInfoSSDWE` varchar(300) NOT NULL DEFAULT '',
  `compInfoSelfLinkingStamp` varchar(300) NOT NULL DEFAULT '',
  `depositBooksINPUT` varchar(300) NOT NULL DEFAULT '',
  `compInfoChequeBinder` varchar(300) NOT NULL DEFAULT '',
  `depositBooksINPUT_VARs` varchar(300) NOT NULL DEFAULT '',
  `DWEINPUT` varchar(300) NOT NULL DEFAULT '',
  `SSDWEINPUT` varchar(300) NOT NULL DEFAULT '',
  `chequeBinderINPUT` varchar(300) NOT NULL DEFAULT '',
  `SelfLinkStampINPUT` varchar(300) NOT NULL DEFAULT '',
  `deliveryINPUT` varchar(300) NOT NULL DEFAULT '',
  `companyName_TYPE_BILLING` varchar(300) NOT NULL DEFAULT '',
  `contactName_TYPE_BILLING` varchar(300) NOT NULL DEFAULT '',
  `address_1_TYPE_BILLING` varchar(300) NOT NULL DEFAULT '',
  `address_2_TYPE_BILLING` varchar(300) NOT NULL DEFAULT '',
  `address_3_TYPE_BILLING` varchar(300) NOT NULL DEFAULT '',
  `city_TYPE_BILLING` varchar(300) NOT NULL DEFAULT '',
  `province_TYPE_BILLING` varchar(300) NOT NULL DEFAULT '',
  `postalCode_TYPE_BILLING` varchar(300) NOT NULL DEFAULT '',
  `phone_TYPE_BILLING` varchar(300) NOT NULL DEFAULT '',
  `email_TYPE_BILLING` varchar(300) NOT NULL DEFAULT '',
  `isBillToAlternativeName` varchar(300) NOT NULL DEFAULT '',
  `residentialAddressBSM` varchar(300) NOT NULL DEFAULT '',
  `noSignatureRequiredBSM` varchar(300) NOT NULL DEFAULT '',
  `companyName_TYPE_SHIPING` varchar(300) NOT NULL DEFAULT '',
  `contactName_TYPE_SHIPING` varchar(300) NOT NULL DEFAULT '',
  `address_1_TYPE_SHIPING` varchar(300) NOT NULL DEFAULT '',
  `address_2_TYPE_SHIPING` varchar(300) NOT NULL DEFAULT '',
  `address_3_TYPE_SHIPING` varchar(300) NOT NULL DEFAULT '',
  `city_TYPE_SHIPING` varchar(300) NOT NULL DEFAULT '',
  `province_TYPE_SHIPING` varchar(300) NOT NULL DEFAULT '',
  `postalCode_TYPE_SHIPING` varchar(300) NOT NULL DEFAULT '',
  `phone_TYPE_SHIPING` varchar(300) NOT NULL DEFAULT '',
  `email_TYPE_SHIPING` varchar(300) NOT NULL DEFAULT '',
  `isShipToDifferentAddress` varchar(300) NOT NULL DEFAULT '',
  `MOP_directDebit_signature` varchar(300) NOT NULL DEFAULT '',
  `MOP_cardNum` varchar(300) NOT NULL DEFAULT '',
  `MOPcsv` varchar(300) NOT NULL DEFAULT '',
  `mopINPUT` varchar(300) NOT NULL DEFAULT '',
  `mopExpirtyMonthINPUT` varchar(300) NOT NULL DEFAULT '',
  `mopExpirtyYearINPUT` varchar(300) NOT NULL DEFAULT '',
  `mopCallMe` varchar(300) NOT NULL DEFAULT '',
  `AIRMILES_cardNumber` varchar(300) NOT NULL DEFAULT '',
  `chequeType` varchar(300) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `orders_details`
--

