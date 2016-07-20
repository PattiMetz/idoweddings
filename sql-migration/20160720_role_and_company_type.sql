--
-- Table structure for table `company_type`
--

CREATE TABLE IF NOT EXISTS `company_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `company_type`
--

INSERT INTO `company_type` (`id`, `name`) VALUES
(1, 'Own company'),
(2, 'Venues'),
(3, 'Travel agencies'),
(4, 'Vendors');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_type_id` int(10) unsigned NOT NULL,
  `company_id` int(10) unsigned NOT NULL,
  `display_name` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `company_type_id`, `company_id`, `display_name`) VALUES
(1, 1, 0, 'Super Administrator'),
(2, 1, 0, 'Administrator'),
(3, 2, 0, 'Administrator'),
(4, 3, 0, 'Administrator'),
(5, 4, 0, 'Administrator');
