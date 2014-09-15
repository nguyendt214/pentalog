<?php
/* 
 * Insert Default value to Category and Type table
 */

$installer = $this;
$installer->startSetup();

$installer->getConnection()->addColumn($installer->getTable('krewrite/krewrite'), 'type_id',
    'int(11) AFTER `krewrite_id`'
);
//Type = product, category, blog, customModule,...
$installer->getConnection()->addColumn($installer->getTable('krewrite/krewrite'), 'type',
    'varchar(30) AFTER `type_id`'
);

$installer->endSetup();