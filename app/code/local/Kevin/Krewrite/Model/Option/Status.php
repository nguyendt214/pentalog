<?php

class Kevin_Krewrite_Model_Option_Status extends Varien_Object {
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 2;

    static public function getOptionArray() {
        return array(
            self::STATUS_ENABLED => Mage::helper('krewrite')->__('Enable'),
            self::STATUS_DISABLED => Mage::helper('krewrite')->__('Disable')
        );
    }

    static public function getOptionArrayEdit() {
        return array(
            array('value' => self::STATUS_DISABLED, 'label' => Mage::helper('krewrite')->__('Disable')),
            array('value' => self::STATUS_ENABLED, 'label' => Mage::helper('krewrite')->__('Enable')),
        );
    }
    
    static public function getLinkArray() {
        return array(
            self::STATUS_ENABLED => Mage::helper('krewrite')->__('Yes'),
            self::STATUS_DISABLED => Mage::helper('krewrite')->__('No')
        );
    }

}