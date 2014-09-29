<?php

class Kevin_Survey_Block_Adminhtml_List_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'survey';
        $this->_controller = 'adminhtml_list';
        $this->removeButton('save');
        $this->removeButton('delete');
        $this->removeButton('reset');
    }

    public function getHeaderText()
    {
        if( Mage::registry('survey_data') && Mage::registry('survey_data')->getId() ) {
            return Mage::helper('survey')->__("View survey detail");
        }
    }
}