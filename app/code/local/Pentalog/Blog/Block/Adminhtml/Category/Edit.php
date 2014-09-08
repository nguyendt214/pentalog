<?php

class Pentalog_Blog_Block_Adminhtml_Category_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {

    public function __construct() {
        parent::__construct();

        $this->_objectId = 'category_id';
        $this->_blockGroup = 'blog';
        $this->_controller = 'adminhtml_category';

        $this->_updateButton('save', 'label', Mage::helper('blog')->__('Save Category'));
        $this->_updateButton('delete', 'label', Mage::helper('blog')->__('Delete Category'));

        $this->_addButton('saveandcontinue', array(
            'label' => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class' => 'save',
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

    public function getHeaderText() {
        if (Mage::registry('category_data') && Mage::registry('category_data')->getId()) {
            return Mage::helper('blog')->__("Edit Category '%s'", $this->htmlEscape(Mage::registry('category_data')->getName()));
        } else {
            return Mage::helper('blog')->__('Add Category');
        }
    }

}
