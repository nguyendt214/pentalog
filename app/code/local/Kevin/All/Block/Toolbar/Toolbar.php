<?php

/**
 * Description of Toolbar
 *
 * @author ndotrong
 */
class Kevin_All_Block_Toolbar_Toolbar extends Mage_Catalog_Block_Product_List_Toolbar {

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
        $order = $this->getRequest()->getParam($this->getOrderVarName());
        if (!$order) {
            return $this->_orderField;
        }
        if (array_key_exists($order, $this->getAvailableOrders())) {
            return $order;
        }
        return $this->_orderField;
    }

    public function getCurrentMode() {
        return null;
    }

    public function getCurrentDirection() {
        $dir = $this->getRequest()->getParam($this->getDirectionVarName());
        if (in_array($dir, array('asc', 'desc'))) {
            return $dir;
        }
        return Mage::helper('all')->getAllConfigs()->getToolbarDefaultDirection();
    }

    public function setDefaultOrder($field) {
        $this->_orderField = $field;
    }

    /*
     * Create new function suppott set Number item show per page
     */
    public function setAvailableLimit($limit){
        $this->_defaultAvailableLimit = $limit;
    }

}
