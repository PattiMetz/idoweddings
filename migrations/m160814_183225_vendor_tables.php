<?php

use yii\db\Migration;

class m160814_183225_vendor_tables extends Migration
{
    public function up()
    {
        $this->execute('CREATE TABLE IF NOT EXISTS `vendor` (
  `organization_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `tax_rate` double DEFAULT NULL,
  `tax_service_rate` double DEFAULT NULL,
  `comm_prices` tinyint(4) NOT NULL DEFAULT \'1\',
  `comm_rate` double DEFAULT NULL,
  `comm_note` varchar(255) DEFAULT NULL,
  `admin_notes` varchar(255) DEFAULT NULL,
  `payment_notes` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT \'1\',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`organization_id`),
  KEY `organization_id` (`organization_id`),
  CONSTRAINT `vendor_ibfk_1` FOREIGN KEY (`organization_id`) REFERENCES `organization` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `vendor_destination` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_id` int(11) NOT NULL,
  `region` varchar(255) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `vendor_id` (`vendor_id`),
  CONSTRAINT `vendor_destination_ibfk_1` FOREIGN KEY (`vendor_id`) REFERENCES `vendor` (`organization_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `vendor_doc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT \'1\',
  PRIMARY KEY (`id`),
  KEY `vendor_id` (`vendor_id`),
  CONSTRAINT `vendor_doc_ibfk_1` FOREIGN KEY (`vendor_id`) REFERENCES `vendor` (`organization_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `vendor_has_type` (
  `vendor_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  PRIMARY KEY (`vendor_id`,`type_id`),
  KEY `vendor_id` (`vendor_id`),
  KEY `type_id` (`type_id`),
  CONSTRAINT `vendor_has_type_ibfk_1` FOREIGN KEY (`vendor_id`) REFERENCES `vendor` (`organization_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `vendor_has_type_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `vendor_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `vendor_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
');
    }

    public function down()
    {
        echo "m160814_183225_vendor_tables cannot be reverted.\n";

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
