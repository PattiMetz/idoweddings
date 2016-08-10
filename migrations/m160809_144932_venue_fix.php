<?php

use yii\db\Migration;

class m160809_144932_venue_fix extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE `venue` ADD `organization_id` INT NOT NULL AFTER `id`, ADD INDEX (`organization_id`) ;
UPDATE `venue` SET `organization_id`=`id`;
ALTER TABLE `venue` ADD FOREIGN KEY (`organization_id`) REFERENCES `organization`(`id`) ON DELETE CASCADE ON UPDATE RESTRICT;
ALTER TABLE venue_tax DROP index `venue_id`;
ALTER TABLE venue_tax DROP FOREIGN KEY venue_tax_ibfk_1;
ALTER TABLE venue_tax CHANGE venue_id organization_id INT;
ALTER TABLE `venue_tax` ADD PRIMARY KEY(`organization_id`);
ALTER TABLE `venue_tax` CHANGE `event_deposit` `event_deposit` INT(11) NULL;
DROP IF EXISTS TABLE venue_contact;
DROP IF EXISTS TABLE venue_address;');
    }

    public function down()
    {
        echo "m160809_144932_venue_fix cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
