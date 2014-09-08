<?php
/* 
 * Insert Default value to Category and Type table
 */

$installer = $this;
$installer->startSetup();
//Insert default value to Category table
$installer->run("
    INSERT INTO {$this->getTable('blog/category')} (`category_id`, `identifier`, `name`, `status`) VALUES (NULL, 'Pentalog', 'pentalog', '1');
");
//Insert default value to Type table
$installer->run("
    INSERT INTO {$this->getTable('blog/type')} (`type_id`, `title`) VALUES (NULL, 'Pentalog Type');
");


$installer->endSetup(); 