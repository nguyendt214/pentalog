<?php
/*
@author: Kevin (ndotrong@pentalog.fr)
*/
class Kevin_All_Helper_Data extends Mage_Core_Helper_Abstract{
    
    /*
     * return configuration value
     */
    public function getConfigValue($path, $store){
        return Mage::getStoreConfig($path, $store);
    }
    
    /*
     * Redirect to home function
     */
    public function redirectToHomePage(Mage_Core_Controller_Front_Action $action){
        Mage::app()->getFrontController()->getResponse()->setRedirect(Mage::helper('core/url')->getHomeUrl());
    }
    
    /*
     * Return string
     * Return image path
     */
    public function imageSrc($path){
        return Mage::getBaseUrl('media').$path;
    }
    /*
     * Check site is multi store view or not
     * Return boolean
     */
    public function multiStoreView(){
        return !Mage::app()->isSingleStoreMode();
    }
    
}

