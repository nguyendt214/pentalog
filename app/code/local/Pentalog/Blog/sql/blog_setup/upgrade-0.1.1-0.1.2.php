<?php
/* 
 * Insert Default value to Category and Type table
 */

$installer = $this;
$installer->startSetup();
//Not need this table
$installer->run("DROP TABLE IF EXISTS {$this->getTable('blog/blogcomment')}");
$installer->run("ALTER TABLE {$this->getTable('blog/comment')} ADD `blog_id` INT(11) AFTER `comment_id`");
//Add blog_id to comment table

$installer->endSetup(); 