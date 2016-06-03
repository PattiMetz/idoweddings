ALTER TABLE `knowledgebases_entries` ADD `status` VARCHAR(20) NOT NULL;
UPDATE `knowledgebases_entries` SET `status` = 'published' WHERE ! is_category;