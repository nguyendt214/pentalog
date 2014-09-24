<?php

class Kevin_All_Model_Status extends Varien_Object
{
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 2;
    protected $_optionArray = null;

    public function getOptionArray()
    {
        if ($this->_optionArray === null) {
            $array = array(
                self::STATUS_ENABLED => Mage::helper('all')->__('Enabled'),
                self::STATUS_DISABLED => Mage::helper('all')->__('Disabled')
            );
            $this->_optionArray = $array;
        }
        return $this->_optionArray;
    }
}