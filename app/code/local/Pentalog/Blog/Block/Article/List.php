<?php

/*
  @author: Kevin (ndotrong@pentalog.fr)
 */

class Pentalog_Blog_Block_Article_List extends Mage_Core_Block_Template {

    public function _prepareLayout() {
        return parent::_prepareLayout();
    }

    public function getCategory() {
        return $category = Mage::registry('current_category');
    }

    public function getArticles() {
        $category = $this->getCategory();
        $article = Mage::getSingleton('blog/blog')->getCollection();

        $article->addCategoryFilter($category);
        if (Mage::helper('all')->multiStoreView()) {
            $article->addStoreFilter(Mage::app()->getStore()->getStoreId());
        }
        return $article;
    }

    /**
     * Retrieve list toolbar HTML
     *
     * @return string
     */
    public function getToolbarHtml() {
        return $this->getChildHtml('kevin_toolbar');
    }

    /**
     * Need use as _prepareLayout - but problem in declaring collection from
     * another block (was problem with search result)
     */
    protected function _beforeToHtml() {
        
        Mage::helper('all/toolbar')->initToolbar(
            $this,
            array(
                 'orders'        => array('created_time' => $this->__('Created At'), 'email' => $this->__('Added By')),
                 'default_order' => 'created_time',
                 'dir'           => 'desc',
                 'limits'        => 3,
                 'method'        => 'getArticles'
            )
        );
        return parent::_beforeToHtml();
        
//        $toolbar = $this->getToolbarBlock();
//        // called prepare sortable parameters
//        $collection = $this->getArticles();
//        // use sortable parameters
//        if ($sort = Mage::helper('blog/configs')->getAllConfigs()->getToolbarDefaultSortBy()) {
//            $toolbar->setDefaultOrder($sort);
//        }
//        if ($dir = Mage::helper('blog/configs')->getAllConfigs()->getToolbarDefaultDirection()) {
//            $toolbar->setDefaultDirection($dir);
//        }
//        //Disable view model: List, Grid
//        $toolbar->disableViewSwitcher();
//        
//        if($orderList = Mage::helper('blog/configs')->getAllConfigs()->getToolbarOrderList()){
//            $toolbar->setAvailableOrders($orderList);
//        }
//        // set collection to toolbar and apply sort
//        $toolbar->setCollection($collection);
//        $this->setChild('toolbar', $toolbar);
//
//        return parent::_beforeToHtml();
    }

    /**
     * Retrieve Toolbar block
     *
     * @return Mage_Catalog_Block_Product_List_Toolbar
     */
    public function getToolbarBlock() {
        if ($blockName = $this->getToolbarBlockName()) {
            if ($block = $this->getLayout()->getBlock($blockName)) {
                return $block;
            }
        }
        $block = $this->getLayout()->createBlock('blog/category_toolbar', microtime());
        return $block;
    }

}
