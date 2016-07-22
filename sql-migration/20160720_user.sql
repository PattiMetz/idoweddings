--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(128) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `password_hash` varchar(128) NOT NULL,
  `password_reset_token` varchar(128) NOT NULL,
  `display_name` varchar(40) NOT NULL,
  `email` varchar(128) NOT NULL,
  `company_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `display_name`, `email`, `company_id`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 'admin', '', '$2y$13$xwSkbMYSinQOxJInPJ/CmOSptwWBpTHciVBvt13PXiAtR6GSRv1Am', '', 'Patti Metzger', '', 0, 0, '2016-07-14 01:47:18', '0000-00-00 00:00:00'),
(2, 'manager', '', '$2y$13$xwSkbMYSinQOxJInPJ/CmOSptwWBpTHciVBvt13PXiAtR6GSRv1Am', '', 'Менеджер', '', 0, 0, '2016-03-15 15:39:11', '0000-00-00 00:00:00');
