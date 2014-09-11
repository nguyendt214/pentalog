<?php

/*
  @author: Kevin (ndotrong@pentalog.fr)
 */

class Kevin_All_Helper_Data extends Mage_Core_Helper_Abstract {

    protected $_configs = null;

    /*
     * return configuration value
     */

    public function getConfigValue($path, $store) {
        return Mage::getStoreConfig($path, $store);
    }

    /*
     * Redirect to home function
     */

    public function redirectToHomePage(Mage_Core_Controller_Front_Action $action) {
        Mage::app()->getFrontController()->getResponse()->setRedirect(Mage::helper('core/url')->getHomeUrl());
    }

    /*
     * Return string
     * Return image path
     */

    public function imageSrc($path) {
        return Mage::getBaseUrl('media') . $path;
    }

    /*
     * Check site is multi store view or not
     * Return boolean
     */

    public function multiStoreView() {
        return !Mage::app()->isSingleStoreMode();
    }

    /*
     * return all configuration 
     */

    public function getAllConfigs() {
        $store = Mage::app()->getStore()->getStoreId();
        if ($this->_configs === null) {
            $this->_configs = array(
                'toolbar_default_direction' => 'desc',
                'toolbar_default_sort_by' => 'created_date',
            );
            //Convert configs to Object
            $config = new Varien_Object();
            $this->_configs = $config->addData($this->_configs);
        }
        return $this->_configs;
    }

}
