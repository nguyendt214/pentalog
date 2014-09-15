<?php

class Kevin_Krewrite_Block_Adminhtml_Krewrite_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {

    public function __construct() {
        parent::__construct();
        $this->setId('krewrite_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('krewrite')->__('URL Rewrite Information'));
    }

    protected function _beforeToHtml() {
        $this->addTab('form_section', array(
            'label' => Mage::helper('krewrite')->__('URL Rewrite Information'),
            'title' => Mage::helper('krewrite')->__('URL Rewrite Information'),
            'content' => $this->getLayout()->createBlock('krewrite/adminhtml_krewrite_edit_tab_form')->toHtml(),
            
        ));
        return parent::_beforeToHtml();
    }

}