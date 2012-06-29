-- phpMyAdmin SQL Dump
-- version 3.4.5deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 29, 2012 at 08:21 AM
-- Server version: 5.5.22
-- PHP Version: 5.3.10-1ubuntu3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ragnagear`
--

-- --------------------------------------------------------

--
-- Table structure for table `cp_confirmation`
--

CREATE TABLE IF NOT EXISTS `cp_confirmation` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `confirmed` tinyint(4) NOT NULL,
  `confirm_code` varchar(64) NOT NULL,
  `confirm_created` datetime NOT NULL,
  `confirm_expire` datetime NOT NULL,
  `confirmed_on` datetime NOT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `cp_confirmation`
--

INSERT INTO `cp_confirmation` (`cid`, `account_id`, `confirmed`, `confirm_code`, `confirm_created`, `confirm_expire`, `confirmed_on`) VALUES
(1, 2000063, 1, '2bad2f67cda63b64c12f993359619970', '2012-06-28 22:18:02', '2012-06-30 22:18:02', '2012-06-28 22:18:32'),
(2, 2000000, 0, '827fcac3794c5542b23955599ea44c7b', '2012-06-28 23:44:41', '2012-06-28 23:44:41', '0000-00-00 00:00:00'),
(3, 2000000, 0, '11e1ca423bc99f389369e5e6b36af018', '2012-06-28 23:45:20', '2012-06-30 23:45:20', '0000-00-00 00:00:00'),
(4, 2000000, 0, 'd6842b9fade15445c42c4095eaeb108a', '2012-06-28 23:45:45', '2012-06-30 23:45:45', '0000-00-00 00:00:00'),
(5, 2000000, 0, '66355b4de9c32d7e851bb94c3f6f6941', '2012-06-28 23:46:27', '2012-06-30 23:46:27', '0000-00-00 00:00:00'),
(6, 2000000, 0, '68014c755427c1bf9f77507cfaf7c677', '2012-06-28 23:50:56', '2012-06-30 23:50:56', '0000-00-00 00:00:00'),
(7, 2000000, 1, '2f5e9795ccd453dbdf0527a6537ba1d2', '2012-06-28 23:51:31', '2012-06-30 23:51:31', '2012-06-29 00:10:03'),
(8, 2000000, 0, 'eb38711bd27f083f3acfbaf8e51dbeac', '2012-06-28 23:52:05', '2012-06-30 23:52:05', '2012-06-29 00:17:38'),
(10, 2000000, 1, '18517140a60871fdd7861677ba8d3bf5', '2012-06-29 00:25:37', '2012-07-01 00:25:37', '2012-06-29 00:26:52');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
