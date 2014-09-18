<?php

class Pentalog_Blog_Model_Commentstatus extends Varien_Object
{
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 2;
    /*
     * Return status of comment
     */
    static public function getOptionArray()
    {
        return array(
            self::STATUS_ENABLED => Mage::helper('blog')->__('Approved'),
            self::STATUS_DISABLED => Mage::helper('blog')->__('Pending')
        );
    }

}