-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2016 at 03:39 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `idoweddings`
--

-- --------------------------------------------------------

--
-- Table structure for table `knowledgebases`
--

CREATE TABLE IF NOT EXISTS `knowledgebases` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `knowledgebases`
--

INSERT INTO `knowledgebases` (`id`, `name`) VALUES
(1, 'General'),
(9, '10віаі'),
(25, '11'),
(27, 'Template2');

-- --------------------------------------------------------

--
-- Table structure for table `knowledgebases_entries`
--

CREATE TABLE IF NOT EXISTS `knowledgebases_entries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kb_id` int(10) unsigned NOT NULL,
  `parent_id` bigint(20) unsigned NOT NULL,
  `is_category` int(1) NOT NULL,
  `order` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `knowledgebases_entries`
--

INSERT INTO `knowledgebases_entries` (`id`, `kb_id`, `parent_id`, `is_category`, `order`, `title`, `content`) VALUES
(1, 1, 0, 1, 0, 'Category 1.', ''),
(2, 1, 0, 0, 0, 'Article 1', ''),
(4, 1, 0, 0, 0, 'Article 2', ''),
(5, 0, 0, 0, 0, 'Category 1', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
