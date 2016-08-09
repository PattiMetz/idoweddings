<?php

use yii\db\Migration;

class m160807_041009_organization_address extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE  `organization` CHANGE  `city`  `city`
            VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ;');
    }

    public function down()
    {
        echo "m160807_041009_organization_address cannot be reverted.\n";

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
