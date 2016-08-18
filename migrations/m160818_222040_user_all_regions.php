<?php

use yii\db\Migration;

class m160818_222040_user_all_regions extends Migration
{
    public function up()
    {
	$this->execute('
		ALTER TABLE `user` ADD `all_regions` INT(1) NOT NULL AFTER `role_id`;
		UPDATE `user` SET `all_regions` = 1;
	');
    }

    public function down()
    {
        echo "m160818_222040_user_all_regions cannot be reverted.\n";

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
