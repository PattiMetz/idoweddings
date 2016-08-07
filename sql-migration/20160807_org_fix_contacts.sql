CREATE TABLE `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `organization_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `skype` varchar(255) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `phone` int(11) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `phone` (`phone`),
  KEY `organization_id` (`organization_id`),
  CONSTRAINT `contact_ibfk_1` FOREIGN KEY (`organization_id`) REFERENCES `organization` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `contact_phone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_id` int(11) NOT NULL,
  `type` varchar(30) NOT NULL,
  `phone` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_id` (`contact_id`),
  CONSTRAINT `contact_phone_ibfk_1` FOREIGN KEY (`contact_id`) REFERENCES `contact` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE  `organization` CHANGE  `id`  `id` INT NOT NULL AUTO_INCREMENT ;

ALTER TABLE  `organization` CHANGE  `type_id`  `type_id` INT NOT NULL ;

ALTER TABLE  `contact` ADD FOREIGN KEY (  `organization_id` ) REFERENCES  `idoweddings`.`organization` (
  `id`
) ON DELETE CASCADE ON UPDATE CASCADE ;

ALTER TABLE  `organization` ADD  `country_id` INT NULL ,
ADD  `state` VARCHAR( 100 ) NULL ,
ADD  `zip` VARCHAR( 20 ) NULL ,
ADD  `city` VARCHAR( 100 ) NULL ,
ADD  `address` VARCHAR( 255 ) NULL ,
ADD  `timezone` INT NULL ,
ADD  `email` VARCHAR( 255 ) NULL ,
ADD  `site` VARCHAR( 255 ) NULL ,
ADD  `status` TINYINT NOT NULL DEFAULT  '1';