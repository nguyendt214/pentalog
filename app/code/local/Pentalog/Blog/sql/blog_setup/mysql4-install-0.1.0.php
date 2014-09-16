<?php
/*
 * @author: Kevin (ndotrong@pentalog.fr)
 * @return: Installation script
 */
$installer = $this;

$installer->startSetup();
//Blog table
//$installer->run("
//-- DROP TABLE IF EXISTS {$this->getTable('blog/blog')};
//CREATE TABLE {$this->getTable('blog/blog')} (
//  `blog_id` int(11) unsigned NOT NULL auto_increment,
//  `identifier` varchar(255) NOT NULL default '',
//  `url` varchar(255) NOT NULL default '',
//  `title` varchar(255) NOT NULL default '',
//  `short_description` varchar(255) NOT NULL default '',
//  `description` text NOT NULL default '',
//  `author` varchar(100) NOT NULL default '',
//  `image` varchar(255) NOT NULL default '',
//  `status` tinyint(4) NOT NULL default 2,
//  `created_time` datetime NULL,
//  `update_time` datetime NULL,
//  `data_json` text default '',
//  PRIMARY KEY (`blog_id`)
//) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Blog table';
//    ");

$table = $installer->getConnection()
    ->newTable($installer->getTable('blog/blog'))
    ->addColumn('blog_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Id')
    ->addColumn('identifier', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
    ), 'identifier')
    ->addColumn('url', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
    ), 'url')
    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
    ), 'title')
    ->addColumn('short_description', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
    ), 'short_description')
    ->addColumn('description', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
    ), 'description')
    ->addColumn('author', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
    ), 'author')
    ->addColumn('image', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
    ), 'image')
    ->addColumn('type_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
    ), 'Display Type')
    ->addColumn('status', Varien_Db_Ddl_Table::TYPE_INTEGER, 4, array(
        'default' => 2
    ), 'status')
    ->addColumn('created_time', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
    ), 'created_time')
    ->addColumn('update_time', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
    ), 'update_time')
    ->addColumn('data_json', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
    ), 'data_json')
    ;
$installer->getConnection()->createTable($table);
//category table

//$installer->run("
//-- DROP TABLE IF EXISTS {$this->getTable('blog/category')};
//CREATE TABLE {$this->getTable('blog/category')} (
//  `category_id` int(11) unsigned NOT NULL auto_increment,
//  `identifier` varchar(255) NOT NULL default '',
//  `url` varchar(255) NOT NULL default '',
//  `name` varchar(255) NOT NULL default '',
//  `short_description` varchar(255) NOT NULL default '',
//  `description` text NOT NULL default '',
//  `image` varchar(255) NOT NULL default '',
//  `status` tinyint(4) NOT NULL default 2,
//  `created_time` datetime NULL,
//  `update_time` datetime NULL,
//  `data_json` text default '',
//  PRIMARY KEY (`category_id`)
//) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Blog Category table';
//    ");
$table = $installer->getConnection()
    ->newTable($installer->getTable('blog/category'))
    ->addColumn('category_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Id')
    ->addColumn('identifier', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
    ), 'identifier')
    ->addColumn('url', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
    ), 'url')
    ->addColumn('name', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
    ), 'name - title')
    ->addColumn('short_description', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
    ), 'short_description')
    ->addColumn('description', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
    ), 'description')
    ->addColumn('image', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
    ), 'image')
    ->addColumn('status', Varien_Db_Ddl_Table::TYPE_INTEGER, 4, array(
        'default' => 2
    ), 'status')
    ->addColumn('type_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
    ), 'Display Type')
    ->addColumn('created_time', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
    ), 'created_time')
    ->addColumn('update_time', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
    ), 'update_time')
    ->addColumn('data_json', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
    ), 'data_json')
;
$installer->getConnection()->createTable($table);
//Reference between Blog and Categoy
//$installer->run("
//-- DROP TABLE IF EXISTS {$this->getTable('blog/blogcategory')};
//CREATE TABLE {$this->getTable('blog/blogcategory')} (
//`blog_category_id` int(11) unsigned NOT NULL auto_increment,
//  `category_id` int(11) NOT NULL,
//  `blog_id` int(11) NOT NULL,
//  PRIMARY KEY (`blog_category_id`)
//) ENGINE=InnoDB DEFAULT CHARSET=utf8;
//    ");

$table = $installer->getConnection()
    ->newTable($installer->getTable('blog/blogcategory'))
    ->addColumn('blog_category_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Id')
    ->addColumn('category_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
    ), 'category_id')
    ->addColumn('blog_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
    ), 'blog_id')
;
$installer->getConnection()->createTable($table);
//Reference between Blog and Store View
//$installer->run("
//-- DROP TABLE IF EXISTS {$this->getTable('blog/blogstore')};
//CREATE TABLE {$this->getTable('blog/blogstore')} (
//  `blog_store_id` int(11) unsigned NOT NULL auto_increment,
//  `store_id` int(11) NOT NULL,
//  `blog_id` int(11) NOT NULL,
//  PRIMARY KEY (`blog_store_id`)
//) ENGINE=InnoDB DEFAULT CHARSET=utf8;
//    ");
$table = $installer->getConnection()
    ->newTable($installer->getTable('blog/blogstore'))
    ->addColumn('blog_store_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Id')
    ->addColumn('blog_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
    ), 'blog_id')
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
    ), 'store_id')
;
$installer->getConnection()->createTable($table);
//Reference between Category and Store View
//$installer->run("
//-- DROP TABLE IF EXISTS {$this->getTable('blog/categorystore')};
//CREATE TABLE {$this->getTable('blog/categorystore')} (
//  `category_store_id` int(11) unsigned NOT NULL auto_increment,
//  `store_id` int(11) NOT NULL,
//  `category_id` int(11) NOT NULL,
//  PRIMARY KEY (`category_store_id`)
//) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Relationship between category and store view';
//    ");
$table = $installer->getConnection()
    ->newTable($installer->getTable('blog/categorystore'))
    ->addColumn('category_store_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Id')
    ->addColumn('category_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
    ), 'category_id')
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
    ), 'store_id')
;
$installer->getConnection()->createTable($table);
//Comments table
//$installer->run("
//-- DROP TABLE IF EXISTS {$this->getTable('blog/comment')};
//CREATE TABLE {$this->getTable('blog/comment')} (
//  `comment_id` int(11) unsigned NOT NULL auto_increment,
//  `blog_id` int(11) NOT NULL,
//  `title` varchar(255) NOT NULL,
//  `user_name` varchar(255),
//  `user_email` varchar(255),
//  `user_telephone` varchar(255),
//  `content` text,
//  `status` tinyint(4) NOT NULL default 2,
//  `created_time` datetime NULL,
//  `update_time` datetime NULL,
//  `data_json` text default '',
//  PRIMARY KEY (`comment_id`)
//) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table store all Comments';
//    ");
$table = $installer->getConnection()
    ->newTable($installer->getTable('blog/comment'))
    ->addColumn('comment_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Id')
    ->addColumn('blog_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
    ), 'blog_id')
    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
    ), 'title')
    ->addColumn('user_name', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
    ), 'user_name')
    ->addColumn('user_email', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
    ), 'user_email')
    ->addColumn('user_telephone', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
    ), 'user_telephone')
    ->addColumn('content', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
    ), 'content')
    ->addColumn('status', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'default' => 2
    ), 'status')
    ->addColumn('created_time', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
    ), 'created_time')
    ->addColumn('update_time', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
    ), 'update_time')
    ->addColumn('data_json', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
    ), 'data_json')
;
$installer->getConnection()->createTable($table);
//Type table
//$installer->run("
//-- DROP TABLE IF EXISTS {$this->getTable('blog/type')};
//CREATE TABLE {$this->getTable('blog/type')} (
//  `type_id` int(11) unsigned NOT NULL auto_increment,
//  `title` varchar(255) NOT NULL,
//  `style_name` varchar(255),
//  `data_json` text default '',
//  PRIMARY KEY (`type_id`)
//) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Display follow types';
//    ");
$table = $installer->getConnection()
    ->newTable($installer->getTable('blog/type'))
    ->addColumn('type_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Id')
    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
    ), 'title')
    ->addColumn('style_name', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
    ), 'style_name')
    ->addColumn('data_json', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
    ), 'data_json')
;
$installer->getConnection()->createTable($table);

$installer->endSetup(); 