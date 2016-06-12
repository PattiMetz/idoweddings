ALTER TABLE `location` ADD `active` ENUM('0','1') NOT NULL ;
UPDATE `location` SET `active`='1';