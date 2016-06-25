CREATE TABLE IF NOT EXISTS `knowledgebase_entry_file` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `knowledgebase_entry_id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;