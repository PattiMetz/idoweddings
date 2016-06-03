RENAME TABLE `idoweddings`.`knowledgebases` TO `idoweddings`.`knowledgebase`;
RENAME TABLE `idoweddings`.`knowledgebases_entries` TO `idoweddings`.`knowledgebase_entry`;
ALTER TABLE `knowledgebase_entry` CHANGE `kb_id` `knowledgebase_id` INT(10) UNSIGNED NOT NULL;