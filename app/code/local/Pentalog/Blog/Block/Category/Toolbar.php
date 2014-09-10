<?php

/**
 * Description of Toolbar
 *
 * @author ndotrong
 */
class Pentalog_Blog_Block_Category_Toolbar extends Mage_Catalog_Block_Product_List_Toolbar {

    public function setCollection($collection) {
        parent::setCollection($collection);
       
        if ($this->getCurrentOrder() && $this->getCurrentDirection()) {
            $this->_collection->setOrder($this->getCurrentOrder(), $this->getCurrentDirection());
        }
        return $this;
    }

    /**
     * Return products collection instance
     *
     * @return Mage_Core_Model_Mysql4_Collection_Abstract
     */
    public function getCollection() {
        return parent::getCollection();
    }

    public function getCurrentOrder() {
        return Mage::helper('blog/configs')->getAllConfigs()->getToolbarDefaultSortBy();
    }

    public function getCurrentMode() {
        return null;
    }

    public function getAvailableLimit() {
        return parent::getAvailableLimit();
    }

    public function getCurrentDirection() {
        $dir = $this->getRequest()->getParam($this->getDirectionVarName());
        if (in_array($dir, array('asc', 'desc'))) {
            return $dir;
        }
        return Mage::helper('blog/configs')->getAllConfigs()->getToolbarDefaultDirection();
    }

    public function setDefaultOrder($field) {
        $this->_orderField = $field;
    }

    public function getLimit() {
        return $this->getRequest()->getParam($this->getLimitVarName());
    }

}
