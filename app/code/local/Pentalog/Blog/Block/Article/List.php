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
        if (!$this->hasData('article')) {
            $category = $this->getCategory();
            $article = Mage::getSingleton('blog/blog')->getCollection();
            $article->addCategoryFilter($category);
            if (Mage::helper('all')->multiStoreView()) {
                $article->addStoreFilter(Mage::app()->getStore()->getStoreId());
            }
            $this->setData('article', $article);
        }
        return $this->getData('article');
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
        /*
         * init toolbar
         */
        Mage::helper('all/toolbar')->initToolbar(
                $this, array(
            'orders' => Mage::helper('blog/configs')->getAllConfigs()->getToolbarOrderList(),
            'default_order' => Mage::helper('blog/configs')->getAllConfigs()->getToolbarDefaultSortBy(),
            'dir' => Mage::helper('blog/configs')->getAllConfigs()->getToolbarDefaultDirection(),
            'defaultAvailbleLimit' => Mage::helper('blog/configs')->getAllConfigs()->getToolbarShowPerPage(),
            'method' => 'getArticles',
                )
        );
        return parent::_beforeToHtml();
    }

}
