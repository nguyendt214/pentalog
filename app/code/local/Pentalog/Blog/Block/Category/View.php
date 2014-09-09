<?php

/*
  @author: Kevin (ndotrong@pentalog.fr)
 */

class Pentalog_Blog_Block_Category_View extends Mage_Core_Block_Template {

    public function _prepareLayout() {
        return parent::_prepareLayout();
    }

    /*
     * Return all category
     */

    public function getCategories() {
        $categories = Mage::helper('blog')->getCategories(array('status' => 1), 'category_id', 'desc', Mage::app()->getStore()->getStoreId());
        return $categories;
    }

    public function getCategory() {
        return Mage::getSingleton('blog/category');
    }

}
