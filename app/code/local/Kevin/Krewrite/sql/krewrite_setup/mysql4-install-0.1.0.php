<?php

$installer = $this;

$installer->startSetup();

$installer->run("
-- DROP TABLE IF EXISTS {$this->getTable('krewrite/krewrite')};
CREATE TABLE {$this->getTable('krewrite/krewrite')} (
  `krewrite_id` int(11) unsigned NOT NULL auto_increment,
  `request_path` varchar(255) NOT NULL default '',
  `target_path` varchar(255) NOT NULL default '',
  `options` varchar(30) NOT NULL default '',
  `is_secure` smallint(5) NOT NULL default 2,
  `is_external_link` varchar(255) NOT NULL default '',
  `description` varchar(255) NOT NULL default '',
  `is_active` smallint(5) NOT NULL default 0,
  PRIMARY KEY (`krewrite_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");

$installer->run("
-- DROP TABLE IF EXISTS {$this->getTable('krewrite/store')};
CREATE TABLE {$this->getTable('krewrite/store')} (
  `krewrite_store_id` int(11) unsigned NOT NULL auto_increment,
  `krewrite_id` smallint(5),
  `store_id` smallint(5),
  PRIMARY KEY (`krewrite_store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");
$installer->endSetup();