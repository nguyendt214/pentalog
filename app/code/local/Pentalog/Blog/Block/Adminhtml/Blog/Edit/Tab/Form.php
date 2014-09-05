<?php

class Pentalog_Blog_Block_Adminhtml_Blog_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('blog_form', array('legend'=>Mage::helper('blog')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('blog')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('blog')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('blog')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('blog')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('blog')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('blog')->__('Content'),
          'title'     => Mage::helper('blog')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getBlogData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getBlogData());
          Mage::getSingleton('adminhtml/session')->setBlogData(null);
      } elseif ( Mage::registry('blog_data') ) {
          $form->setValues(Mage::registry('blog_data')->getData());
      }
      return parent::_prepareForm();
  }
}