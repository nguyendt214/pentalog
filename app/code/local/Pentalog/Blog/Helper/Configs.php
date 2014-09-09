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
