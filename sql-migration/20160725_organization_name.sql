ALTER TABLE `organization` ADD `name` VARCHAR(40) NOT NULL;
UPDATE `idoweddings`.`organization` SET `name` = 'WOMI' WHERE `organization`.`id` = 1;