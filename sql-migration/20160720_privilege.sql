--
-- Table structure for table `privilege`
--

CREATE TABLE IF NOT EXISTS `privilege` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(128) NOT NULL,
  `display_name` varchar(128) NOT NULL,
  `ord` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `privilege`
--

INSERT INTO `privilege` (`id`, `parent_id`, `name`, `display_name`, `ord`) VALUES
(1, 0, 'knowledgebases', 'Manage knowledge bases', 20),
(2, 1, 'knowledgebases:entries', 'Manage entries', 10),
(3, 0, 'usermanager', 'User manager', 10),
(4, 3, 'usermanager:roles', 'View roles', 10),
(5, 1, 'knowledgebase:permissions', 'Give permissions', 20);

-- --------------------------------------------------------

--
-- Table structure for table `role_privilege`
--

CREATE TABLE IF NOT EXISTS `role_privilege` (
  `role_id` int(10) unsigned NOT NULL,
  `privilege_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`privilege_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_privilege`
--

CREATE TABLE IF NOT EXISTS `user_privilege` (
  `user_id` int(10) unsigned NOT NULL,
  `privilege_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`privilege_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_privilege`
--

INSERT INTO `user_privilege` (`user_id`, `privilege_id`) VALUES
(1, 3);
