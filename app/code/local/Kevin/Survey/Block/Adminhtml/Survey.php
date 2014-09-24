<?php

class Kevin_Survey_Block_Adminhtml_Survey extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_survey';
        $this->_blockGroup = 'survey';
        $this->_headerText = Mage::helper('survey')->__('Survey Schedule');
        parent::__construct();
        $this->_removeButton('add');
    }
}