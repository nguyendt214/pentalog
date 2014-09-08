<?php
/*
 * @author: Kevin (ndotrong@pentalog.fr)
 * @return: Installation script
 */
$installer = $this;

$installer->startSetup();
//Blog table
$installer->run("
-- DROP TABLE IF EXISTS {$this->getTable('blog/blog')};
CREATE TABLE {$this->getTable('blog/blog')} (
  `blog_id` int(11) unsigned NOT NULL auto_increment,
  `identifier` varchar(255) NOT NULL default '',
  `url` varchar(255) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `short_description` varchar(255) NOT NULL default '',
  `description` text NOT NULL default '',
  `author` varchar(100) NOT NULL default '',
  `image` varchar(255) NOT NULL default '',
  `status` tinyint(4) NOT NULL default 2,  
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  `data_json` text default '',
  PRIMARY KEY (`blog_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Blog table';
    ");
//category table

$installer->run("
-- DROP TABLE IF EXISTS {$this->getTable('blog/category')};
CREATE TABLE {$this->getTable('blog/category')} (
  `category_id` int(11) unsigned NOT NULL auto_increment,
  `identifier` varchar(255) NOT NULL default '',
  `url` varchar(255) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `short_description` varchar(255) NOT NULL default '',
  `description` text NOT NULL default '',
  `image` varchar(255) NOT NULL default '',
  `status` tinyint(4) NOT NULL default 2,  
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  `data_json` text default '',
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Blog Category table';
    ");
//Reference between Blog and Categoy
$installer->run("
-- DROP TABLE IF EXISTS {$this->getTable('blog/blogcategory')};
CREATE TABLE {$this->getTable('blog/blogcategory')} (
  `blog_category_id` int(11) unsigned NOT NULL auto_increment,
  `category_id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  PRIMARY KEY (`blog_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");
//Reference between Blog and Store View
$installer->run("
-- DROP TABLE IF EXISTS {$this->getTable('blog/blogstore')};
CREATE TABLE {$this->getTable('blog/blogstore')} (
  `blog_store_id` int(11) unsigned NOT NULL auto_increment,
  `store_id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  PRIMARY KEY (`blog_store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");

//Reference between Category and Store View
$installer->run("
-- DROP TABLE IF EXISTS {$this->getTable('blog/categorystore')};
CREATE TABLE {$this->getTable('blog/categorystore')} (
  `category_store_id` int(11) unsigned NOT NULL auto_increment,
  `store_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`category_store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Relationship between category and store view';
    ");
//Comments table
$installer->run("
-- DROP TABLE IF EXISTS {$this->getTable('blog/comment')};
CREATE TABLE {$this->getTable('blog/comment')} (
  `comment_id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `user_name` varchar(255),
  `user_email` varchar(255),
  `user_telephone` varchar(255),
  `content` text,
  `status` tinyint(4) NOT NULL default 2,  
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  `data_json` text default '',
  PRIMARY KEY (`comment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table store all Comments';
    ");
//Reference between Blog and Comment
$installer->run("
-- DROP TABLE IF EXISTS {$this->getTable('blog/blogcomment')};
CREATE TABLE {$this->getTable('blog/blogcomment')} (
  `blog_comment_id` int(11) unsigned NOT NULL auto_increment,
  `blog_id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  PRIMARY KEY (`blog_comment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");
//Type table
$installer->run("
-- DROP TABLE IF EXISTS {$this->getTable('blog/type')};
CREATE TABLE {$this->getTable('blog/type')} (
  `type_id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `style_name` varchar(255),
  `data_json` text default '',
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Display follow types';
    ");
//Type and Category relationship
$installer->run("
-- DROP TABLE IF EXISTS {$this->getTable('blog/categorytype')};
CREATE TABLE {$this->getTable('blog/categorytype')} (
  `category_type_id` int(11) unsigned NOT NULL auto_increment,
  `category_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  PRIMARY KEY (`category_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");

$installer->endSetup(); 