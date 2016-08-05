ALTER TABLE `organization` ADD `name` VARCHAR(40) NOT NULL;
UPDATE `organization` SET `name` = 'WOMI' WHERE `id` = 1;