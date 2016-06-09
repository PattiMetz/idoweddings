ALTER TABLE `knowledgebase_entry` ADD `tree_path` VARCHAR(255) NOT NULL AFTER `parent_id`;
ALTER TABLE `knowledgebase_entry` CHANGE `parent_id` `category_id` BIGINT(20) UNSIGNED NOT NULL;