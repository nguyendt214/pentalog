<?php

class Pentalog_Blog_Block_Adminhtml_Blog_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'blog';
        $this->_controller = 'adminhtml_blog';
        
        $this->_updateButton('save', 'label', Mage::helper('blog')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('blog')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('blog_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'blog_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'blog_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('blog_data') && Mage::registry('blog_data')->getId() ) {
            return Mage::helper('blog')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('blog_data')->getTitle()));
        } else {
            return Mage::helper('blog')->__('Add Item');
        }
    }
}