<?php
class Kevin_Krewrite_Block_Adminhtml_Krewrite extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_krewrite';
    $this->_blockGroup = 'krewrite';
    $this->_headerText = Mage::helper('krewrite')->__('URL Rewrite Manager');
    $this->_addButtonLabel = Mage::helper('krewrite')->__('Add New Rewrite');
    parent::__construct();
  }
}