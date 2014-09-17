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
                'blog_list_image_width' => ($this->getConfig('blog_section/blog_config/blog_list_image_width'))? $this->getConfig('blog_section/blog_config/blog_list_image_width') : '150px',
                'blog_list_image_height' => ($this->getConfig('blog_section/blog_config/blog_list_image_height'))? $this->getConfig('blog_section/blog_config/blog_list_image_height') : '150px',
                'column_article' => ($this->getConfig('blog_section/blog_config/column_article'))? $this->getConfig('blog_section/blog_config/column_article') : 4,
                'toolbar_default_direction' => ($this->getConfig('blog_section/blog_config/toolbar_default_direction'))? $this->getConfig('blog_section/blog_config/toolbar_default_direction') : 'DESC',
                'toolbar_default_sort_by' => ($this->getConfig('blog_section/blog_config/toolbar_default_sort_by'))? $this->getConfig('blog_section/blog_config/toolbar_default_sort_by') : 'blog_id',
                'toolbar_order_list' => array(
                    'blog_id' => 'Newest',
                    'title' => 'Title',
                ),
//                'toolbar_show_per_page' => array(4 => 4, 8 => 8, 12 => 12),
                //Blog Detail config
                'blog_detail_image_width' => ($this->getConfig('blog_section/blog_config/blog_detail_image_width'))? $this->getConfig('blog_section/blog_config/blog_detail_image_width') : '350px',
                'blog_detail_image_height' => ($this->getConfig('blog_section/blog_config/blog_detail_image_height'))? $this->getConfig('blog_section/blog_config/blog_detail_image_height') : '350px',
                'default_article_image' => ($this->getConfig('blog_section/blog_config/default_article_image'))? $this->getConfig('blog_section/blog_config/default_article_image') : 'xpentalog/blog/defaultImage.jpg',
                //Blog comment config
                'allow_not_login_write_comment' => ($this->getConfig('blog_section/comment/allow_not_login_write_comment'))? $this->getConfig('blog_section/comment/allow_not_login_write_comment') : 1,
                'comment_recipient_email' => ($this->getConfig('blog_section/comment/comment_recipient_email'))? $this->getConfig('blog_section/comment/comment_recipient_email') : 'ndotrong@pentalog.fr',
                'comment_sender_email_identity' => ($this->getConfig('blog_section/comment/comment_sender_email_identity'))? $this->getConfig('blog_section/comment/comment_sender_email_identity') : 'general',
                'comment_email_template' => ($this->getConfig('blog_section/comment/comment_email_template'))? $this->getConfig('blog_section/comment/comment_email_template') : 'blog_section_comment_comment_email_template',
                //Blog Category List
                'blog_category_list_image_width' => ($this->getConfig('blog_section/blog_category/blog_category_list_image_width'))? $this->getConfig('blog_section/blog_category/blog_category_list_image_width') : '150px',
                'blog_category_list_image_height' => ($this->getConfig('blog_section/blog_category/blog_category_list_image_height'))? $this->getConfig('blog_section/blog_category/blog_category_list_image_height') : '150px',
                'blog_category_view_image_width' => ($this->getConfig('blog_section/blog_category/blog_category_view_image_width'))? $this->getConfig('blog_section/blog_category/blog_category_view_image_width') : '150px',
                'blog_category_view_image_height' => ($this->getConfig('blog_section/blog_category/blog_category_view_image_height'))? $this->getConfig('blog_section/blog_category/blog_category_view_image_height') : '150px',
                //Blog general
                'blog_title' => ($this->getConfig('blog_section/general/blog_title'))? $this->getConfig('blog_section/general/blog_title') : 'Pentalog Blog',
                'blog_active' => ($this->getConfig('blog_section/general/blog_active'))? $this->getConfig('blog_section/general/blog_active') : 1,
                'blog_layout' => ($this->getConfig('blog_section/general/blog_layout'))? $this->getConfig('blog_section/general/blog_layout') : 'page/1column.phtml',
            );

            if($this->getConfig('blog_section/blog_config/toolbar_show_per_page')){
                $this->_configs['toolbar_show_per_page'] = explode(",", $this->getConfig('blog_section/blog_config/toolbar_show_per_page'));
            }else{
                $this->_configs['toolbar_show_per_page'] = array(4 => 4, 8 => 8, 12 => 12);
            }

            //Convert configs to Object
            $config = new Varien_Object();
            $this->_configs = $config->addData($this->_configs);
        }
        return $this->_configs;
    }

    public function getHelper($type = 'all') {
        return Mage::helper($type);
    }
    /*
     * Return configuration data
     */
    public function getConfig($path){
        $storeId = Mage::app()->getStore()->getStoreId();
        return $this->getHelper()->getConfigValue($path, $storeId);
    }

}
