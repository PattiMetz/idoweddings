ALTER TABLE `venue_tax` ADD `commission_note` TEXT NOT NULL AFTER `commission_items`;
ALTER TABLE `venue_tax` ADD `accommodation_note` TEXT NOT NULL AFTER `accomodation_wholesale`;
ALTER TABLE `venue_tax` ADD `event_deposit` INT NOT NULL , ADD `deposit_currency` INT NOT NULL , ADD `note` TEXT NOT NULL , ADD INDEX (`deposit_currency`) ;