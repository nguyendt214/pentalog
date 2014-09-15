<?php

class Kevin_Krewrite_Block_Adminhtml_Krewrite_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'krewrite';
        $this->_controller = 'adminhtml_krewrite';
        
        $this->_updateButton('save', 'label', Mage::helper('krewrite')->__('Save URL Rewtite'));
        $this->_updateButton('delete', 'label', Mage::helper('krewrite')->__('Delete URL Rewtite'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('krewrite_data') && Mage::registry('krewrite_data')->getId() ) {
            return Mage::helper('krewrite')->__("Edit URL Rewrite");
        } else {
            return Mage::helper('krewrite')->__('Add New URL Rewrite');
        }
    }
}