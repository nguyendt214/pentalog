<?php

/*
  @author: Kevin (ndotrong@pentalog.fr)
 */

class Pentalog_Blog_Helper_Configs extends Mage_Core_Helper_Abstract {

    protected $_configs = null;

    /*
     * Return all configuration of this module
     */

    public function getAllConfigs() {
        $store = Mage::app()->getStore()->getStoreId();
        if ($this->_configs === null) {
            $this->_configs = array(
                //Blog Listing config
                'blog_list_image_width' => '150px',
                'blog_list_image_height' => '150px',
                'column_article' => 4,
                'toolbar_default_direction' => 'desc',
                'toolbar_default_sort_by' => 'blog_id',
                'toolbar_order_list' => array(
                    'blog_id' => 'Newest',
                    'title' => 'Title',
                ),
                'toolbar_show_per_page' => array(2 => 2, 4 => 4, 6 => 6),
                //Blog Detail config
                'blog_detail_image_width' => '350px',
                'blog_detail_image_height' => '350px',
                'default_article_image' => 'xpentalog/blog/defaultImage.jpg',
                //Blog comment config
                'allow_not_login_write_comment' => true,
                //Blog Category List
                'blog_category_list_image_width' => '150px',
                'blog_category_list_image_height' => '150px',
                'blog_category_view_image_width' => '100%',
                'blog_category_view_image_height' => '200px',
                //Blog general
                'blog_title' => 'Pentalog Blog',
                'blog_active' => $this->getHelper()->getConfigValue('blog_section/blog_config/active', $store),
                'blog_layout' => $this->getHelper()->getConfigValue('blog_section/blog_config/layout', $store),
            );
            //Convert configs to Object
            $config = new Varien_Object();
            $this->_configs = $config->addData($this->_configs);
        }
        return $this->_configs;
    }

    public function getHelper($type = 'all') {
        return Mage::helper($type);
    }

}
