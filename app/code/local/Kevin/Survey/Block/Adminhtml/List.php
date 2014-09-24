<?php

class Kevin_Survey_Block_Adminhtml_List extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_list';
        $this->_blockGroup = 'survey';
        $this->_headerText = Mage::helper('survey')->__('Survey List');
        parent::__construct();
        $this->_removeButton('add');
    }
}