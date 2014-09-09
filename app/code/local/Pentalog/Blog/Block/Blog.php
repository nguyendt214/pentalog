<?php

class Pentalog_Blog_Block_Blog extends Mage_Core_Block_Template {

    public function _prepareLayout() {
        return parent::_prepareLayout();
    }

    public function getBlog() {
        if (!$this->hasData('blog')) {
            $this->setData('blog', Mage::registry('blog'));
        }
        return $this->getData('blog');
    }

}
