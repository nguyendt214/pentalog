<?php

class Pentalog_Blog_Block_Adminhtml_Blog_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {

    public function __construct() {
        parent::__construct();
        $this->setId('blog_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('blog')->__('Article Information'));
    }

    protected function _beforeToHtml() {
        $this->addTab('form_section', array(
            'label' => Mage::helper('blog')->__('Article Information'),
            'title' => Mage::helper('blog')->__('Article Information'),
            'content' => $this->getLayout()->createBlock('blog/adminhtml_blog_edit_tab_form')->toHtml(),
        ));

        $this->addTab(
                'meta_section', array(
            'label' => Mage::helper('blog')->__('Meta Information'),
            'title' => Mage::helper('blog')->__('Meta Information'),
            'content' => $this->getLayout()->createBlock('blog/adminhtml_blog_edit_tab_meta')->toHtml(),
                )
        );

        return parent::_beforeToHtml();
    }

}
