<?php
/*
  @author: Kevin (ndotrong@pentalog.fr)
 */ 
class Pentalog_Blog_Block_Adminhtml_Blog_Edit_Tab_Meta extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm() {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('blog_form', array('legend' => Mage::helper('blog')->__('Meta information')));

        $fieldset->addField(
                'meta_title', 'text', array(
            'name' => 'meta_title',
            'label' => Mage::helper('blog')->__('Meta Title'),
            'title' => Mage::helper('blog')->__('Meta Title'),
                )
        );
        $fieldset->addField(
            'meta_description',
            'editor',
            array(
                 'name'  => 'meta_description',
                 'label' => Mage::helper('blog')->__('Meta Description'),
                 'title' => Mage::helper('blog')->__('Meta Description'),
                 'style' => 'width: 520px;',
            )
        );
        
        if (Mage::getSingleton('adminhtml/session')->getBlogData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getBlogData());
            Mage::getSingleton('adminhtml/session')->setBlogData(null);
        } elseif (Mage::registry('blog_data')) {
            $form->setValues(Mage::registry('blog_data')->getData());
        }
        return parent::_prepareForm();
    }

}
