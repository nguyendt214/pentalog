<?php
/*
@author: Kevin (ndotrong@pentalog.fr)
*/
class Pentalog_Blog_Block_Article_List extends Mage_Core_Block_Template{
    public function _prepareLayout() {
        return parent::_prepareLayout();
    }
    
    
    
    public function getCategory(){
        return $category = Mage::registry('current_category');
    }
    
    public function getArticles(){
        $category = $this->getCategory();
        $article = Mage::getSingleton('blog/blog')->getCollection();
        $article->addCategoryFilter($category);
        if(Mage::helper('all')->multiStoreView()){
            $article->addStoreFilter(Mage::app()->getStore()->getStoreId());
        }
    }
}

