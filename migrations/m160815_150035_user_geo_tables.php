<?php

use yii\db\Migration;

class m160815_150035_user_geo_tables extends Migration
{
    public function up()
    {
	$this->execute('CREATE TABLE IF NOT EXISTS `user_destination` ( `user_id` int(10) unsigned NOT NULL, `destination_id` int(10) unsigned NOT NULL, `all_locations` tinyint(1) unsigned NOT NULL, PRIMARY KEY (`user_id`,`destination_id`) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
INSERT INTO `user_destination` (`user_id`, `destination_id`, `all_locations`) VALUES (1, 62, 0);
CREATE TABLE IF NOT EXISTS `user_location` ( `user_id` int(10) unsigned NOT NULL, `location_id` int(10) unsigned NOT NULL, PRIMARY KEY (`user_id`,`location_id`) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
INSERT INTO `user_location` (`user_id`, `location_id`) VALUES (1, 189);
CREATE TABLE IF NOT EXISTS `user_region` ( `user_id` int(10) unsigned NOT NULL, `region_id` int(10) unsigned NOT NULL, `all_destinations` tinyint(1) unsigned NOT NULL, PRIMARY KEY (`user_id`,`region_id`) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
INSERT INTO `user_region` (`user_id`, `region_id`, `all_destinations`) VALUES (1, 3, 0);');

    }

    public function down()
    {
        echo "m160815_150035_user_geo_tables cannot be reverted.\n";

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
