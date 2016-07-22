DROP TABLE `company_type`;

--
-- Table structure for table `organization_type`
--

CREATE TABLE IF NOT EXISTS `organization_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `organization_type`
--

INSERT INTO `organization_type` (`id`, `name`) VALUES
(1, 'Own company'),
(2, 'Venue'),
(3, 'Travel agency'),
(4, 'Vendor');

ALTER TABLE `user` CHANGE `company_id` `organization_id` INT(10) UNSIGNED NOT NULL;

--
-- Table structure for table `organization`
--

CREATE TABLE IF NOT EXISTS `organization` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `organization`
--

INSERT INTO `organization` (`id`, `type_id`) VALUES
(1, 1);

UPDATE `user` SET `organization_id` = '1', `role_id` = '1' WHERE `id` = 1;
