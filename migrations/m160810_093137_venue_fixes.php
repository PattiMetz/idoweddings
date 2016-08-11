<?php

use yii\db\Migration;

class m160810_093137_venue_fixes extends Migration
{
    public function up()
    {
        $this->execute("ALTER TABLE `venue_website` CHANGE `font_settings` `font_settings` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL;ALTER TABLE `venue_website` CHANGE `logo` `logo` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL;
            CREATE TABLE IF NOT EXISTS `venue_page_has_location` (
                `page_id` int(11) NOT NULL,
                `location_id` int(11) NOT NULL
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ALTER TABLE  `venue_page` CHANGE  `content`  `content` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL ;
        ALTER TABLE `venue_page` CHANGE `settings` `settings` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL;
        CREATE TABLE IF NOT EXISTS `venue_page_setting` (
            `page_id` int(11) NOT NULL,
            `top_type` varchar(15) DEFAULT NULL,
            `venue_name` varchar(255) DEFAULT NULL,
            `button` varchar(255) DEFAULT NULL,
            `slogan` varchar(255) DEFAULT NULL,
            `h1` varchar(255) DEFAULT NULL,
            `h2` varchar(255) DEFAULT NULL,
            `text1` text,
            `text2` text,
            `video` varchar(255) DEFAULT NULL,
            `default_slideshow` varchar(10) DEFAULT NULL,
            `default_image` varchar(10) DEFAULT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");
    }

    public function down()
    {
        echo "m160810_093137_venue_fixes cannot be reverted.\n";

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
