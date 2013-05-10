-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 10, 2013 at 08:28 PM
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
-- Table structure for table `orders_details`
--

CREATE TABLE IF NOT EXISTS `orders_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderNumber` varchar(100) NOT NULL,
  `orderNumberEdited` varchar(100) NOT NULL,
  `CICompanyName` varchar(300) NOT NULL DEFAULT '',
  `order_creator` varchar(300) NOT NULL DEFAULT 'client' COMMENT 'client/admin',
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
  `date_modify` double NOT NULL DEFAULT '1345804571000',
  `sub_total_products_INPUT` varchar(300) NOT NULL DEFAULT '0',
  `shipping_price_INPUT` varchar(300) NOT NULL DEFAULT '0',
  `sub_total_taxes_INPUT` varchar(300) NOT NULL DEFAULT '0',
  `grand_total_INPUT` varchar(300) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=544 ;

--
-- Dumping data for table `orders_details`
--

INSERT INTO `orders_details` (`id`, `orderNumber`, `orderNumberEdited`, `CICompanyName`, `order_creator`, `CIContactName`, `CIPhone`, `CIEmail`, `CIQuestionsAndCommentsTA`, `CIQuestionsAndComments`, `compInfoQuantity`, `quantityINPUT`, `quantityINPUTIndex`, `chequePosition`, `chequeColor`, `backgroundINdex`, `compInfoName`, `compInfoSecondName`, `compInfoAddressLine1`, `compInfoAddressLine2`, `compInfoAddressLine3`, `compInfoAddressLine4`, `comInfoIsSecondCompanyName`, `compInfoBankName`, `compInfoBankAddress1`, `compInfoBankAddress2`, `compInfoBankAddress3`, `compInfoBankAddress4`, `isCurrencyINPUT`, `add45AfterAcountNumberInput`, `compInfoSoftware`, `compInfoSecondSignatur`, `compInfoShowStartNumber`, `compInfoStartAt`, `compInfoBrunchNumber`, `compInfoTransitNumber`, `compInfoAccountNumber`, `compInfoStartAtTrueOrFalse`, `isThereSecondSignature`, `softwareINPUT`, `boxingType`, `compInfoDepositBooks`, `compInfoDWE`, `compInfoSSDWE`, `compInfoSelfLinkingStamp`, `depositBooksINPUT`, `compInfoChequeBinder`, `depositBooksINPUT_VARs`, `DWEINPUT`, `SSDWEINPUT`, `chequeBinderINPUT`, `SelfLinkStampINPUT`, `deliveryINPUT`, `companyName_TYPE_BILLING`, `contactName_TYPE_BILLING`, `address_1_TYPE_BILLING`, `address_2_TYPE_BILLING`, `address_3_TYPE_BILLING`, `city_TYPE_BILLING`, `province_TYPE_BILLING`, `postalCode_TYPE_BILLING`, `phone_TYPE_BILLING`, `email_TYPE_BILLING`, `isBillToAlternativeName`, `residentialAddressBSM`, `noSignatureRequiredBSM`, `companyName_TYPE_SHIPING`, `contactName_TYPE_SHIPING`, `address_1_TYPE_SHIPING`, `address_2_TYPE_SHIPING`, `address_3_TYPE_SHIPING`, `city_TYPE_SHIPING`, `province_TYPE_SHIPING`, `postalCode_TYPE_SHIPING`, `phone_TYPE_SHIPING`, `email_TYPE_SHIPING`, `isShipToDifferentAddress`, `MOP_directDebit_signature`, `MOP_cardNum`, `MOPcsv`, `mopINPUT`, `mopExpirtyMonthINPUT`, `mopExpirtyYearINPUT`, `mopCallMe`, `AIRMILES_cardNumber`, `chequeType`, `date_modify`, `sub_total_products_INPUT`, `shipping_price_INPUT`, `sub_total_taxes_INPUT`, `grand_total_INPUT`) VALUES
(499, 'T_L5840', 'T_L5840-AG', 'asdasd', 'client', 'asdfsdf', 'asdasd', 'zlatkoflash@yahoo.com', '', '', '250 + 75 FREE $149.00', 'is not set', 'is not set', '3', '1;http://localhost/muhamed/cheque/wp_cheque_appi/wp-content/themes/c-t/images/backgrounds/1.jpg;DARK BLUE', '1', 'company name 1', 'company name 2', 'address 1 ', 'address 2', 'address 3', 'address 4', 'company name 2', '', '', '', '', '', 'true', 'true', '2', 'x1', 'on', '000000', '', '', '', 'true', 'SIGNATURE_x1', 'Buisiness Visions;2', 'Low %23 on top, face down', '1', '0', '0', '0', 'is not set', 'is not set', 'is not set', 'is not set', 'is not set', 'is not set', 'is not set', 'Standard 8-10 Business Days', 'asdasd', 'asdfsdf', 'asdasd', 'asdasd', 'asdas', 'asdfsdf', 'BC', 'asd', 'asdasd', 'asdasd', 'asdfsdf', 'false', 'false', 'asdasd', 'asdfsdf', 'asdasd', 'asdasd', 'asdas', 'asdfsdf', 'BC', 'asd', 'asdasd', 'asdasd', 'asdfsdf', '', '3423423423423423', '234', 'No Payment Method Selected.', 'Jan', '2011', 'false', '', 'laser', 1368200603000, '179', '0', '7.16', '186.16'),
(543, 'T_L6221', 'T_L6221-B', 'asdasd', 'admin', 'asdfsdf', 'asdasd', 'zlatkoflash@yahoo.com', '', '', '250 + 75 FREE $149.00', 'is not set', 'is not set', '3', '1;http://localhost/muhamed/cheque/wp_cheque_appi/wp-content/themes/c-t/images/backgrounds/1.jpg;DARK BLUE', '1', 'company name 1', 'company name 2', 'address 1 ', 'address 2', 'address 3', 'address 4', 'company name 2', '', '', '', '', '', 'true', 'true', '2', 'x1', 'on', '000000', '', '', '', 'true', 'SIGNATURE_x1', 'Buisiness Visions;2', 'Low %23 on top, face down', '1', '0', '0', '0', 'is not set', 'is not set', 'is not set', 'is not set', 'is not set', 'is not set', 'is not set', 'Standard 8-10 Business Days', 'asdasd', 'asdfsdf', 'asdasd', 'asdasd', 'asdas', 'asdfsdf', 'BC', 'asd', 'asdasd', 'asdasd', 'asdfsdf', 'false', 'false', 'asdasd', 'asdfsdf', 'asdasd', 'asdasd', 'asdas', 'asdfsdf', 'BC', 'asd', 'asdasd', 'asdasd', 'asdfsdf', '', '3423423423423423', '234', 'No Payment Method Selected.', 'Jan', '2011', 'false', '', 'laser', 1368200576000, '179', '0', '8.95', '187.95');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
