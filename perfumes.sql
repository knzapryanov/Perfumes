-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 13, 2016 at 02:41 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `perfumes`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE IF NOT EXISTS `brands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand_name` varchar(255) NOT NULL,
  `global_sale` int(11) NOT NULL,
  `sale_price` double NOT NULL,
  `global_off` int(11) NOT NULL,
  `off_price` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `brand_name`, `global_sale`, `sale_price`, `global_off`, `off_price`) VALUES
(1, 'new brand', 0, 0, 0, 0),
(2, 'kamari', 0, 0, 0, 0),
(3, 'mega men', 0, 0, 0, 0),
(4, 'Koka kola', 0, 0, 0, 0),
(5, 'CICI', 0, 0, 0, 0),
(6, 'Armani', 0, 0, 0, 0),
(7, 'Benetton', 0, 0, 0, 0),
(8, 'Burberry', 0, 0, 0, 0),
(9, 'Azzaro', 0, 0, 0, 0),
(11, 'Bruno Banani', 0, 0, 0, 0),
(12, 'Bvlgari', 0, 0, 0, 0),
(13, 'Calvin Klein', 0, 0, 0, 0),
(14, 'Carolina Herrera', 0, 0, 0, 0),
(15, 'Cartier', 0, 0, 0, 0),
(16, 'Cerruti', 0, 0, 0, 0),
(17, 'Chanel', 0, 0, 0, 0),
(18, 'Davidoff', 0, 0, 0, 0),
(19, 'Diesel', 0, 0, 0, 0),
(20, 'Dolce & Gabbana', 0, 0, 0, 0),
(21, 'Dsquared', 0, 0, 0, 0),
(22, 'test brand', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`) VALUES
(1, 'men'),
(2, 'women'),
(3, 'unisex');

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('02189d67956b40dd94532cb1f59129497698a226', '::1', 1468412424, 0x5f5f63695f6c6173745f726567656e65726174657c693a313436383431323139353b69647c733a313a2232223b66697273745f6e616d657c733a353a2244616e656c223b6c6173745f6e616d657c733a383a224275636876617461223b66756c6c4e616d657c733a31343a2244616e656c204275636876617461223b656d61696c7c733a31313a2264616e406d61696c2e6267223b726f6c657c733a313a2231223b70617373776f72647c733a323a223131223b),
('0612ffefea26dbfdde5dc423f1a2f3673ab292c8', '::1', 1468402188, 0x5f5f63695f6c6173745f726567656e65726174657c693a313436383430323135363b69647c733a313a2232223b66697273745f6e616d657c733a353a2244616e656c223b6c6173745f6e616d657c733a383a224275636876617461223b66756c6c4e616d657c733a31343a2244616e656c204275636876617461223b656d61696c7c733a31313a2264616e406d61696c2e6267223b726f6c657c733a313a2231223b70617373776f72647c733a323a223131223b),
('0aca0f63af63a95e80018aefbbb87ee4a8e65445', '::1', 1468402656, 0x5f5f63695f6c6173745f726567656e65726174657c693a313436383430323438313b69647c733a313a2232223b66697273745f6e616d657c733a353a2244616e656c223b6c6173745f6e616d657c733a383a224275636876617461223b66756c6c4e616d657c733a31343a2244616e656c204275636876617461223b656d61696c7c733a31313a2264616e406d61696c2e6267223b726f6c657c733a313a2231223b70617373776f72647c733a323a223131223b),
('0e03bffaf59056e4e2dc39aaed2cd9df848d5b07', '::1', 1468409529, 0x5f5f63695f6c6173745f726567656e65726174657c693a313436383430393234393b69647c733a313a2232223b66697273745f6e616d657c733a353a2244616e656c223b6c6173745f6e616d657c733a383a224275636876617461223b66756c6c4e616d657c733a31343a2244616e656c204275636876617461223b656d61696c7c733a31313a2264616e406d61696c2e6267223b726f6c657c733a313a2231223b70617373776f72647c733a323a223131223b),
('13a626b41185cc710b2792cdaccb8662cf6cfa7c', '::1', 1468402034, 0x5f5f63695f6c6173745f726567656e65726174657c693a313436383430313736363b69647c733a313a2232223b66697273745f6e616d657c733a353a2244616e656c223b6c6173745f6e616d657c733a383a224275636876617461223b66756c6c4e616d657c733a31343a2244616e656c204275636876617461223b656d61696c7c733a31313a2264616e406d61696c2e6267223b726f6c657c733a313a2231223b70617373776f72647c733a323a223131223b),
('18316832608d877f0e527c4115c6f5184becdeea', '::1', 1468400946, 0x5f5f63695f6c6173745f726567656e65726174657c693a313436383430303732333b),
('1bb7574b921301f332746ec760374c9cd526728f', '::1', 1468411360, 0x5f5f63695f6c6173745f726567656e65726174657c693a313436383431313333313b69647c733a313a2232223b66697273745f6e616d657c733a353a2244616e656c223b6c6173745f6e616d657c733a383a224275636876617461223b66756c6c4e616d657c733a31343a2244616e656c204275636876617461223b656d61696c7c733a31313a2264616e406d61696c2e6267223b726f6c657c733a313a2231223b70617373776f72647c733a323a223131223b),
('21b3b3db6bfa5c1df7924fdcd3bc30e260d5f8e9', '::1', 1468410105, 0x5f5f63695f6c6173745f726567656e65726174657c693a313436383430393933313b69647c733a313a2232223b66697273745f6e616d657c733a353a2244616e656c223b6c6173745f6e616d657c733a383a224275636876617461223b66756c6c4e616d657c733a31343a2244616e656c204275636876617461223b656d61696c7c733a31313a2264616e406d61696c2e6267223b726f6c657c733a313a2231223b70617373776f72647c733a323a223131223b),
('3933cf467d709ba8a612e79a0171f8a5766f85c0', '::1', 1468412003, 0x5f5f63695f6c6173745f726567656e65726174657c693a313436383431313736373b69647c733a313a2232223b66697273745f6e616d657c733a353a2244616e656c223b6c6173745f6e616d657c733a383a224275636876617461223b66756c6c4e616d657c733a31343a2244616e656c204275636876617461223b656d61696c7c733a31313a2264616e406d61696c2e6267223b726f6c657c733a313a2231223b70617373776f72647c733a323a223131223b),
('3cede584d6b0cc76fcaa82c79092e49711ed723a', '::1', 1468405713, 0x5f5f63695f6c6173745f726567656e65726174657c693a313436383430353233393b69647c733a313a2232223b66697273745f6e616d657c733a353a2244616e656c223b6c6173745f6e616d657c733a383a224275636876617461223b66756c6c4e616d657c733a31343a2244616e656c204275636876617461223b656d61696c7c733a31313a2264616e406d61696c2e6267223b726f6c657c733a313a2231223b70617373776f72647c733a323a223131223b),
('54f42c3d6077fd693bf67720e41a1600b8dabf88', '::1', 1468411013, 0x5f5f63695f6c6173745f726567656e65726174657c693a313436383431303932343b69647c733a313a2232223b66697273745f6e616d657c733a353a2244616e656c223b6c6173745f6e616d657c733a383a224275636876617461223b66756c6c4e616d657c733a31343a2244616e656c204275636876617461223b656d61696c7c733a31313a2264616e406d61696c2e6267223b726f6c657c733a313a2231223b70617373776f72647c733a323a223131223b),
('59734b5e3574d93283a93845768886d2932b9854', '::1', 1468408249, 0x5f5f63695f6c6173745f726567656e65726174657c693a313436383430373937363b69647c733a313a2232223b66697273745f6e616d657c733a353a2244616e656c223b6c6173745f6e616d657c733a383a224275636876617461223b66756c6c4e616d657c733a31343a2244616e656c204275636876617461223b656d61696c7c733a31313a2264616e406d61696c2e6267223b726f6c657c733a313a2231223b70617373776f72647c733a323a223131223b),
('5fe83fb8200ccf2fa4b52a49606a93cc045fce7b', '::1', 1468407343, 0x5f5f63695f6c6173745f726567656e65726174657c693a313436383430373239343b69647c733a313a2232223b66697273745f6e616d657c733a353a2244616e656c223b6c6173745f6e616d657c733a383a224275636876617461223b66756c6c4e616d657c733a31343a2244616e656c204275636876617461223b656d61696c7c733a31313a2264616e406d61696c2e6267223b726f6c657c733a313a2231223b70617373776f72647c733a323a223131223b),
('77553bbcdd8726117d942c8660c290c0f16fa31c', '::1', 1468410764, 0x5f5f63695f6c6173745f726567656e65726174657c693a313436383431303535383b69647c733a313a2232223b66697273745f6e616d657c733a353a2244616e656c223b6c6173745f6e616d657c733a383a224275636876617461223b66756c6c4e616d657c733a31343a2244616e656c204275636876617461223b656d61696c7c733a31313a2264616e406d61696c2e6267223b726f6c657c733a313a2231223b70617373776f72647c733a323a223131223b),
('894d78561bad398ec8c5d6f92eb5a5d1a921431c', '::1', 1468406901, 0x5f5f63695f6c6173745f726567656e65726174657c693a313436383430363735383b69647c733a313a2232223b66697273745f6e616d657c733a353a2244616e656c223b6c6173745f6e616d657c733a383a224275636876617461223b66756c6c4e616d657c733a31343a2244616e656c204275636876617461223b656d61696c7c733a31313a2264616e406d61696c2e6267223b726f6c657c733a313a2231223b70617373776f72647c733a323a223131223b),
('8e566057f795b2aa8d69f2dcaa1a10b5b3beb7a2', '::1', 1468403218, 0x5f5f63695f6c6173745f726567656e65726174657c693a313436383430323937383b69647c733a313a2232223b66697273745f6e616d657c733a353a2244616e656c223b6c6173745f6e616d657c733a383a224275636876617461223b66756c6c4e616d657c733a31343a2244616e656c204275636876617461223b656d61696c7c733a31313a2264616e406d61696c2e6267223b726f6c657c733a313a2231223b70617373776f72647c733a323a223131223b),
('9837ca01549779414381a9e8be7eaad4e758fd8c', '::1', 1468408576, 0x5f5f63695f6c6173745f726567656e65726174657c693a313436383430383238393b69647c733a313a2232223b66697273745f6e616d657c733a353a2244616e656c223b6c6173745f6e616d657c733a383a224275636876617461223b66756c6c4e616d657c733a31343a2244616e656c204275636876617461223b656d61696c7c733a31313a2264616e406d61696c2e6267223b726f6c657c733a313a2231223b70617373776f72647c733a323a223131223b),
('9ac515faff2486f90bbc1d5235a6680bb1d54570', '::1', 1468405208, 0x5f5f63695f6c6173745f726567656e65726174657c693a313436383430343932393b69647c733a313a2232223b66697273745f6e616d657c733a353a2244616e656c223b6c6173745f6e616d657c733a383a224275636876617461223b66756c6c4e616d657c733a31343a2244616e656c204275636876617461223b656d61696c7c733a31313a2264616e406d61696c2e6267223b726f6c657c733a313a2231223b70617373776f72647c733a323a223131223b),
('a6cf14781abed33653082c28827f2e46c870f50f', '::1', 1468404621, 0x5f5f63695f6c6173745f726567656e65726174657c693a313436383430343432383b69647c733a313a2232223b66697273745f6e616d657c733a353a2244616e656c223b6c6173745f6e616d657c733a383a224275636876617461223b66756c6c4e616d657c733a31343a2244616e656c204275636876617461223b656d61696c7c733a31313a2264616e406d61696c2e6267223b726f6c657c733a313a2231223b70617373776f72647c733a323a223131223b),
('b5dd71cf73550dc78b0c9dd8468b699f2da4a06e', '::1', 1468405940, 0x5f5f63695f6c6173745f726567656e65726174657c693a313436383430353735353b69647c733a313a2232223b66697273745f6e616d657c733a353a2244616e656c223b6c6173745f6e616d657c733a383a224275636876617461223b66756c6c4e616d657c733a31343a2244616e656c204275636876617461223b656d61696c7c733a31313a2264616e406d61696c2e6267223b726f6c657c733a313a2231223b70617373776f72647c733a323a223131223b),
('c5bced6bcc9dbe88e3b064e8c8d7d2cda0d93d05', '::1', 1468171277, 0x5f5f63695f6c6173745f726567656e65726174657c693a313436383137313136393b),
('d36607a37941366ad4a98de82e2c7a8fd4b2b1f8', '::1', 1468413171, 0x5f5f63695f6c6173745f726567656e65726174657c693a313436383431323930303b69647c733a313a2232223b66697273745f6e616d657c733a353a2244616e656c223b6c6173745f6e616d657c733a383a224275636876617461223b66756c6c4e616d657c733a31343a2244616e656c204275636876617461223b656d61696c7c733a31313a2264616e406d61696c2e6267223b726f6c657c733a313a2231223b70617373776f72647c733a323a223131223b),
('d8344c55ce8d2b7c28fa810efe410e0c5c2672e8', '::1', 1468409136, 0x5f5f63695f6c6173745f726567656e65726174657c693a313436383430383931303b69647c733a313a2232223b66697273745f6e616d657c733a353a2244616e656c223b6c6173745f6e616d657c733a383a224275636876617461223b66756c6c4e616d657c733a31343a2244616e656c204275636876617461223b656d61696c7c733a31313a2264616e406d61696c2e6267223b726f6c657c733a313a2231223b70617373776f72647c733a323a223131223b),
('da2e60f23472d859636c5477bb00f951078e9b79', '::1', 1468406361, 0x5f5f63695f6c6173745f726567656e65726174657c693a313436383430363036313b69647c733a313a2232223b66697273745f6e616d657c733a353a2244616e656c223b6c6173745f6e616d657c733a383a224275636876617461223b66756c6c4e616d657c733a31343a2244616e656c204275636876617461223b656d61696c7c733a31313a2264616e406d61696c2e6267223b726f6c657c733a313a2231223b70617373776f72647c733a323a223131223b),
('e1929056ab77c968894c82464eff7b355c1d700b', '::1', 1468408889, 0x5f5f63695f6c6173745f726567656e65726174657c693a313436383430383630323b69647c733a313a2232223b66697273745f6e616d657c733a353a2244616e656c223b6c6173745f6e616d657c733a383a224275636876617461223b66756c6c4e616d657c733a31343a2244616e656c204275636876617461223b656d61696c7c733a31313a2264616e406d61696c2e6267223b726f6c657c733a313a2231223b70617373776f72647c733a323a223131223b),
('e3443c32163681a07afd09f8a860a458f461f0c5', '::1', 1468412512, 0x5f5f63695f6c6173745f726567656e65726174657c693a313436383431323530363b69647c733a313a2232223b66697273745f6e616d657c733a353a2244616e656c223b6c6173745f6e616d657c733a383a224275636876617461223b66756c6c4e616d657c733a31343a2244616e656c204275636876617461223b656d61696c7c733a31313a2264616e406d61696c2e6267223b726f6c657c733a313a2231223b70617373776f72647c733a323a223131223b),
('ea04840b07c62d07e5d7f2ae49e2283f464ce239', '::1', 1468171799, 0x5f5f63695f6c6173745f726567656e65726174657c693a313436383137313437353b),
('eace9932b66fe4f58b9763e6483ea249f68f684a', '::1', 1468406754, 0x5f5f63695f6c6173745f726567656e65726174657c693a313436383430363336323b69647c733a313a2232223b66697273745f6e616d657c733a353a2244616e656c223b6c6173745f6e616d657c733a383a224275636876617461223b66756c6c4e616d657c733a31343a2244616e656c204275636876617461223b656d61696c7c733a31313a2264616e406d61696c2e6267223b726f6c657c733a313a2231223b70617373776f72647c733a323a223131223b),
('eaed3374182e2f7322c61ecb320816911b070f89', '::1', 1468401069, 0x5f5f63695f6c6173745f726567656e65726174657c693a313436383430313032373b),
('fcd530ad7ba1db502ff2665cf2d388aff80cc821', '::1', 1468413494, 0x5f5f63695f6c6173745f726567656e65726174657c693a313436383431333235363b69647c733a313a2232223b66697273745f6e616d657c733a353a2244616e656c223b6c6173745f6e616d657c733a383a224275636876617461223b66756c6c4e616d657c733a31343a2244616e656c204275636876617461223b656d61696c7c733a31313a2264616e406d61696c2e6267223b726f6c657c733a313a2231223b70617373776f72647c733a323a223131223b),
('fe13b14d953ef6691cc7d017d424e703380d11e0', '::1', 1468403447, 0x5f5f63695f6c6173745f726567656e65726174657c693a313436383430333238303b69647c733a313a2232223b66697273745f6e616d657c733a353a2244616e656c223b6c6173745f6e616d657c733a383a224275636876617461223b66756c6c4e616d657c733a31343a2244616e656c204275636876617461223b656d61696c7c733a31313a2264616e406d61696c2e6267223b726f6c657c733a313a2231223b70617373776f72647c733a323a223131223b),
('fe6de05d0e77dbf0b2b70e2ff014f650f4be8f28', '::1', 1468171903, 0x5f5f63695f6c6173745f726567656e65726174657c693a313436383137313830323b);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `version` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`version`) VALUES
(0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `order_ml` int(11) NOT NULL,
  `option_price` double NOT NULL,
  `order_date` int(11) NOT NULL,
  `image_src` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `total_price_ml` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pictures`
--

CREATE TABLE IF NOT EXISTS `pictures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `source` varchar(255) NOT NULL,
  `is_cover` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=188 ;

--
-- Dumping data for table `pictures`
--

INSERT INTO `pictures` (`id`, `product_id`, `source`, `is_cover`) VALUES
(71, 1, 'perfume1.jpg', 1),
(84, 69, 'perfume1.jpg', 1),
(126, 82, 'g1.png', 1),
(127, 83, 'b2.jpg', 1),
(128, 84, 'b7.jpg', 1),
(129, 85, 'b4.jpg', 1),
(130, 86, 'g1.png', 1),
(131, 87, 'c1.jpg', 1),
(132, 88, 'b1.jpg', 1),
(134, 89, 'g2.png', 1),
(135, 90, 'si.jpg', 1),
(138, 91, 'b1.jpg', 1),
(139, 92, 'p2.png', 1),
(140, 93, 'b2.jpg', 1),
(141, 94, 'c1.jpg', 1),
(142, 95, 'g2.png', 1),
(143, 96, 'b4.jpg', 1),
(144, 97, 'b5.jpg', 1),
(145, 71, 'urbane.jpg', 1),
(146, 72, 'Obsession-Perfume.jpg', 1),
(147, 72, 'perfumes-for-autumn-014.jpg', 0),
(148, 73, 'Obsession-Perfume.jpg', 1),
(150, 77, 'b3.jpg', 1),
(152, 80, 'b5.jpg', 1),
(155, 98, 'perfume1.jpg', 1),
(158, 100, 'b3.jpg', 1),
(163, 78, 'c1.jpg', 1),
(168, 99, 'g1.png', 1),
(173, 74, 'perfume1.jpg', 1),
(174, 79, 'b6.jpg', 1),
(175, 101, 'b1.jpg', 1),
(176, 101, 'b2.jpg', 0),
(177, 101, 'b3.jpg', 0),
(178, 101, 'b4.jpg', 0),
(183, 70, 'g2.png', 1),
(184, 70, 'g222222.png', 0),
(185, 76, 'perfume1.jpg', 1),
(186, 75, 'perfume1.jpg', 1),
(187, 81, 'p2.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `is_sale` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `created_time` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `is_newest` int(1) NOT NULL,
  `description` longtext NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=102 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `is_sale`, `cat_id`, `brand_id`, `created_time`, `product_name`, `slug`, `is_newest`, `description`) VALUES
(70, 1, 1, 6, 1465587069, 'Product 2', 'product-2', 0, ''),
(71, 0, 3, 2, 1465587146, 'Product 3', 'product-3', 1, ''),
(72, 0, 3, 3, 1465592819, 'Product 5', 'product-5', 1, ''),
(73, 0, 3, 2, 1465592916, 'Product 6', 'product-6', 1, ''),
(74, 1, 1, 6, 1465593983, 'Product textarea', 'product-textarea', 1, ''),
(75, 0, 1, 6, 1465594063, 'prdicfa2', 'prdicfa2', 1, ''),
(76, 0, 1, 6, 1465594247, 'name 2', 'name-2', 1, 'test\ntest1\n'),
(77, 1, 1, 6, 1465633849, 'Product 7', 'product-7', 1, 'Product 7 Description'),
(78, 1, 2, 4, 1465634070, 'Product 8', 'product-8', 1, 'Product 8 Description'),
(79, 1, 3, 6, 1465634442, 'Product 9.1', 'product-91', 1, 'Product 9 Description'),
(80, 1, 1, 6, 1465635731, 'Product 9', 'product-9', 1, 'Product 9 Description'),
(81, 1, 1, 6, 1465636464, 'Product 10', 'product-10', 1, 'Product 10 Description'),
(82, 0, 2, 13, 1465636496, 'Product 11', 'product-11', 1, 'Product 11 Description'),
(83, 0, 3, 15, 1465636533, 'Product 12', 'product-12', 1, 'Product 12 Description'),
(84, 0, 1, 18, 1465636622, 'Product 13', 'product-13', 1, 'Product 13 Description'),
(85, 1, 3, 16, 1465636664, 'Product 14', 'product-14', 1, 'Product 14 Decription'),
(86, 0, 1, 19, 1465636721, 'Product 15', 'product-15', 1, 'Product 15 Description'),
(87, 1, 2, 9, 1465636779, 'Product 16', 'product-16', 1, 'Product 16 Description'),
(88, 1, 1, 3, 1465636835, 'Product 17', 'product-17', 1, 'Product 17 Description'),
(89, 1, 3, 20, 1465636872, 'Product 18', 'product-18', 1, 'Product 18 Description'),
(90, 0, 2, 8, 1465636923, 'Product 19', 'product-19', 1, 'Product 19 Description'),
(91, 0, 2, 17, 1465636952, 'Product 20', 'product-20', 1, 'Product 20 Description'),
(92, 1, 1, 21, 1465637001, 'Product 21', 'product-21', 1, 'Product 21 Description'),
(93, 0, 3, 11, 1465637042, 'Product 22', 'product-22', 1, 'Product 22 Description'),
(94, 0, 2, 6, 1465637081, 'Product 23', 'product-23', 1, 'Product 23 Description'),
(95, 0, 1, 18, 1465637114, 'Product 24', 'product-24', 1, 'Product 24 Description'),
(96, 0, 3, 16, 1465637143, 'Product 25', 'product-25', 1, 'Product 25 Description'),
(97, 0, 2, 16, 1465637181, 'Product 26', 'product-26', 1, 'Product 26 Description'),
(98, 1, 2, 4, 1465673344, 'Promotion 1', 'promotion-1', 0, 'asdasd'),
(99, 1, 2, 7, 1465673367, 'Promotions 2', 'promotions-2', 0, 'asdasd'),
(100, 1, 1, 9, 1466157497, 'Product 27', 'product-27', 1, 'Product 27 Description'),
(101, 1, 3, 3, 1466160369, 'Test product', 'test-product', 1, 'Test product description');

-- --------------------------------------------------------

--
-- Table structure for table `product_options`
--

CREATE TABLE IF NOT EXISTS `product_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `ml` int(11) NOT NULL,
  `price` double NOT NULL,
  `sale_price` double NOT NULL,
  `off_percentage` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=214 ;

--
-- Dumping data for table `product_options`
--

INSERT INTO `product_options` (`id`, `product_id`, `ml`, `price`, `sale_price`, `off_percentage`, `quantity`) VALUES
(63, 1, 44, 100, 78, 22, 123),
(64, 1, 44, 100, 78, 22, 123),
(65, 1, 44, 100, 78, 22, 123),
(84, 69, 44, 100, 0, 0, 123),
(132, 82, 11, 11, 0, 0, 0),
(133, 83, 123, 123, 0, 0, 0),
(134, 84, 1233, 100, 0, 0, 0),
(135, 85, 212, 222, 173, 22, 0),
(136, 86, 111, 111, 0, 0, 0),
(137, 87, 32, 22, 20, 10, 2),
(138, 88, 232, 222, 22, 91, 22),
(140, 89, 33, 33, 31, 7, 2),
(141, 90, 212, 22, 0, 0, 123),
(144, 91, 222, 222, 0, 0, 0),
(145, 92, 22, 100, 78, 22, 222),
(146, 92, 100, 55, 23, 59, 23),
(147, 93, 22, 22, 0, 0, 0),
(148, 94, 22, 22, 0, 0, 0),
(149, 95, 22, 22, 0, 0, 0),
(150, 96, 123, 123, 0, 0, 0),
(151, 97, 111, 111, 0, 0, 0),
(152, 71, 11, 220, 0, 0, 0),
(153, 72, 100, 100, 0, 0, 0),
(154, 73, 11, 222, 0, 0, 0),
(156, 77, 100, 120, 80, 34, 20),
(158, 80, 111, 100, 22, 78, 21),
(162, 98, 11, 100, 25, 75, 123),
(165, 100, 100, 100, 76, 24, 10),
(169, 78, 122, 33, 16.5, 50, 22),
(170, 78, 100, 100, 0, 0, 10),
(183, 99, 44, 444, 123, 73, 0),
(184, 99, 200, 200, 80, 60, 0),
(194, 74, 11, 111, 0, 0, 0),
(195, 74, 120, 80, 60, 25, 0),
(196, 79, 112, 80, 32, 60, 44),
(197, 79, 112, 70, 30, 58, 44),
(198, 79, 150, 100, 0, 0, 0),
(199, 101, 100, 100, 55, 45, 10),
(200, 101, 200, 200, 0, 0, 20),
(201, 101, 300, 300, 40, 87, 0),
(206, 70, 220, 100, 20, 80, 123),
(207, 70, 2200, 80, 60, 25, 12),
(208, 76, 111, 111, 0, 0, 0),
(209, 75, 11, 222, 0, 0, 0),
(210, 81, 111, 100, 0, 0, 22),
(211, 81, 60, 50, 40, 20, 22),
(212, 81, 40, 20, 19, 5, 30),
(213, 81, 140, 120, 60, 50, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_newsletter` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `first_name`, `last_name`, `email`, `password`, `is_newsletter`) VALUES
(1, 2, 'Petko', 'Hristata', 'skotovadec@mail.bg', '123', 0),
(2, 1, 'Danel', 'Buchvata', 'dan@mail.bg', '11', 0),
(13, 2, 'petka', 'ta', 'pro@mail.bg', '123', 1),
(14, 2, 'Danka', 'Petrova', 'peturhristozovps@gmail.com', '123', 1),
(15, 2, 'Koc', 'Z', 'knzapryanov@gmail.com', '123', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
