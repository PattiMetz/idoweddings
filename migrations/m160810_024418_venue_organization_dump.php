<?php

use yii\db\Migration;

class m160810_024418_venue_organization_dump extends Migration
{
    public function up()
    {

    }

    public function down()
    {
        $this->execute(file_get_contents('organizations_venue_dump.sql')); ;

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
