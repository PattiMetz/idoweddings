RENAME TABLE `knowledgebases` TO `knowledgebase`;
RENAME TABLE `knowledgebases_entries` TO `knowledgebase_entry`;
ALTER TABLE `knowledgebase_entry` CHANGE `kb_id` `knowledgebase_id` INT(10) UNSIGNED NOT NULL;