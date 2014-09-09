<?php

class Pentalog_Blog_Model_Mysql4_Category_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract {

    public function _construct() {
        parent::_construct();
        $this->_init('blog/category');
    }

    public function addFilterByStore($collection, $storeId) {
        $collection->getSelect()
                ->joinLeft(array('category_store' => $this->getTable('blog/categorystore')), 'main_table.category_id = category_store.category_id', array('store_id'))
                ->where('store_id in (?)', array(0, $storeId))
                ;
        return $collection;
    }

}
