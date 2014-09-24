<?php
/*
 * Script create table for Survey module
 */
$installer = $this;

$installer->startSetup();
//Create schedule
$table = $installer->getConnection()
    ->newTable($installer->getTable('survey/survey'))
    ->addColumn('survey_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity' => true,
        'unsigned' => true,
        'nullable' => false,
        'primary' => true,
    ), 'Id')
    ->addColumn('order_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'nullable' => false,
    ), 'Order ID')
    ->addColumn('order_increment', Varien_Db_Ddl_Table::TYPE_VARCHAR, 50, array(
        'nullable' => false,
    ), 'Order Increment')
    ->addColumn('status', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'default' => 2
    ), 'status')
    ->addColumn('purchased_date', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(), 'Day made purchase')
    ->addColumn('send_survey_date', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(), 'Date system send survey')
    ->addColumn('data_json', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(), 'data_json');
$installer->getConnection()->createTable($table);

//create table with detail survey
$table = $installer->getConnection()
    ->newTable($installer->getTable('survey/list'))
    ->addColumn('survey_comment_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity' => true,
        'unsigned' => true,
        'nullable' => false,
        'primary' => true,
    ), 'Id')
    ->addColumn('order_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'nullable' => false,
    ), 'Order ID')
    ->addColumn('order_increment', Varien_Db_Ddl_Table::TYPE_VARCHAR, 50, array(
        'nullable' => false,
    ), 'Order Increment')
    ->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_VARCHAR, 50, array(
        'nullable' => false,
    ), 'Product Id')
    ->addColumn('good_condition', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'default' => 0
    ), 'Condition')
    ->addColumn('good_condition_content', Varien_Db_Ddl_Table::TYPE_VARCHAR, 300, array(
    ), 'Condition content')
    ->addColumn('find_out', Varien_Db_Ddl_Table::TYPE_VARCHAR, 300, array(
    ), 'find_out')
    ->addColumn('find_out_other', Varien_Db_Ddl_Table::TYPE_VARCHAR, 300, array(
    ), 'find_out_other')
    ->addColumn('like_info', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'default' => 0
    ), 'like_info')
    ->addColumn('comment', Varien_Db_Ddl_Table::TYPE_VARCHAR, 300, array(
    ), 'comment')
    ->addColumn('use_testimonial', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'default' => 0
    ), 'use_testimonial')
    ->addColumn('created_date', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(), 'Day made purchase')
    ->addColumn('data_json', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(), 'data_json');
$installer->getConnection()->createTable($table);

$installer->endSetup();