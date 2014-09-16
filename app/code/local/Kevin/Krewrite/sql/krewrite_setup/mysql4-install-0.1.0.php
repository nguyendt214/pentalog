<?php
/*
 * Script create table for URL rewrite module
 */
$installer = $this;

$installer->startSetup();
//Create Main rewrite table
$table = $installer->getConnection()
    ->newTable($installer->getTable('krewrite/krewrite'))
    ->addColumn('krewrite_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Id')
    ->addColumn('request_path', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
        'nullable'  => false,
    ), 'Request Path')
    ->addColumn('target_path', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
        'nullable'  => false,
    ), 'Target Path')
    ->addColumn('type', Varien_Db_Ddl_Table::TYPE_VARCHAR, 30, array(
        'nullable'  => true,
    ), 'Type of URL rewrite')
    ->addColumn('type_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
    ), 'Secure URL')
    ->addColumn('options', Varien_Db_Ddl_Table::TYPE_VARCHAR, 10, array(
        'nullable'  => false,
    ), 'Redirect Option: Null, R, RP')
    ->addColumn('is_secure', Varien_Db_Ddl_Table::TYPE_INTEGER, 4, array(
        'nullable'  => false,
        'default' => 2
    ), 'Secure URL')
    ->addColumn('is_external_link', Varien_Db_Ddl_Table::TYPE_INTEGER, 4, array(
        'nullable'  => false,
        'default' => 2
    ), 'Link to another')
    ->addColumn('is_active', Varien_Db_Ddl_Table::TYPE_INTEGER, 4, array(
        'nullable'  => false,
        'default' => 2
    ), 'Active')
    ->addColumn('description', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable'  => false,
    ), 'Description');
$installer->getConnection()->createTable($table);

//Create URL rewrite store
$table = $installer->getConnection()
    ->newTable($installer->getTable('krewrite/store'))
    ->addColumn('krewrite_store_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Id')
    ->addColumn('krewrite_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
    ), 'Rewrite URL ID')
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 4, array(
        'nullable'  => false,
        'default' => 2
    ), 'Store View Id');
$installer->getConnection()->createTable($table);

//$installer->run("
//-- DROP TABLE IF EXISTS {$this->getTable('krewrite/krewrite')};
//CREATE TABLE {$this->getTable('krewrite/krewrite')} (
//  `krewrite_id` int(11) unsigned NOT NULL auto_increment,
//  `request_path` varchar(255) NOT NULL default '',
//  `target_path` varchar(255) NOT NULL default '',
//  `options` varchar(30) NOT NULL default '',
//  `is_secure` smallint(5) NOT NULL default 2,
//  `is_external_link` varchar(255) NOT NULL default 2,
//  `description` varchar(255) NOT NULL default '',
//  `is_active` smallint(5) NOT NULL default 2,
//  PRIMARY KEY (`krewrite_id`)
//) ENGINE=InnoDB DEFAULT CHARSET=utf8;
//    ");

//$installer->run("
//-- DROP TABLE IF EXISTS {$this->getTable('krewrite/store')};
//CREATE TABLE {$this->getTable('krewrite/store')} (
//  `krewrite_store_id` int(11) unsigned NOT NULL auto_increment,
//  `krewrite_id` smallint(5),
//  `store_id` smallint(5),
//  PRIMARY KEY (`krewrite_store_id`)
//) ENGINE=InnoDB DEFAULT CHARSET=utf8;
//    ");
$installer->endSetup();