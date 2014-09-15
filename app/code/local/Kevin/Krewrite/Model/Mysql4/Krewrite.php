<?php

class Kevin_Krewrite_Model_Mysql4_Krewrite extends Kevin_All_Model_Mysql4_Abstract
{
    public function _construct()
    {
        $this->_init('krewrite/krewrite', 'krewrite_id');
    }

    /*
    * _beforeSave
    */
    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {

        //Check request path and target path is unique
        if (!$this->isUniqueField($object, $this->getTable('krewrite/krewrite'), 'request_path', 'krewrite_id')) {
            $message = Mage::helper('krewrite')->__("Request path already exist.");
            Mage::throwException($message);
        }

        if (!$this->isUniqueField($object, $this->getTable('krewrite/krewrite'), 'target_path', 'krewrite_id')) {
            $message = Mage::helper('krewrite')->__("Target path already exist.");
            Mage::throwException($message);
        }
        return $this;
    }

    /*
     * _afterSave
     * Need save article store, article category
     */

    protected function _afterSave(Mage_Core_Model_Abstract $object)
    {
        //Save url rewrite store
        $condition = $this->_getReadAdapter()->quoteInto('krewrite_id = ?', $object->getId());
        $this->_getWriteAdapter()->delete($this->getTable('krewrite/store'), $condition);

        if (!$object->getData('store_id')) {
            $storeArray = array();
            $storeArray['krewrite_id'] = $object->getId();
            $storeArray['store_id'] = '0';
            $this->_getWriteAdapter()->insert($this->getTable('krewrite/store'), $storeArray);
        } else {
            foreach ((array)$object->getData('store_id') as $store) {
                $storeArray = array();
                $storeArray['krewrite_id'] = $object->getId();
                $storeArray['store_id'] = $store;
                $this->_getWriteAdapter()->insert($this->getTable('krewrite/store'), $storeArray);
            }
        }

        return parent::_afterSave($object);
    }

    /*
     * After Delete Article
     */

    protected function _afterDelete(Mage_Core_Model_Abstract $object)
    {
        //remove data in Kevin Store View table
        $condition = $this->_getReadAdapter()->quoteInto('krewrite_id = ?', $object->getId());
        $this->_getWriteAdapter()->delete($this->getTable('krewrite/store'), $condition);
        return parent::_afterDelete($object);
    }

    /*
     * Load data to display when edit article
     */

    protected function _afterLoad(Mage_Core_Model_Abstract $object)
    {
        $select = $this->_getReadAdapter()->select()
            ->from($this->getTable('krewrite/store'))
            ->where('krewrite_id = ?', $object->getId());
        if ($data = $this->_getReadAdapter()->fetchAll($select)) {
            $storesArray = array();
            foreach ($data as $row) {
                $storesArray[] = $row['store_id'];
            }
            $object->setData('store_id', $storesArray);
        }

        return parent::_afterLoad($object);
    }

    /*
        * Check this custom URL available on current store view or not
        */
    protected function _getLoadSelect($field, $value, $object)
    {
        $select = parent::_getLoadSelect($field, $value, $object);
        if ($object->getStoreId() and !Mage::app()->isSingleStoreMode()) {
            $select
                ->join(array('krewriteStore' => $this->getTable('krewrite/store')), $this->getMainTable() . '.krewrite_id = `krewriteStore`.krewrite_id')
                ->where('`krewriteStore`.store_id in (0, ?) ', $object->getStoreId())
                ->order('store_id DESC')
                ->limit(1);
        }
        return $select;
    }
}