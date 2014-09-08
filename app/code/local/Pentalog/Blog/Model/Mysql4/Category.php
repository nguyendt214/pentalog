<?php
/*
 * @author: Kevin (ndotrong@pentalog.fr)
 */

class Pentalog_Blog_Model_Mysql4_Category extends Mage_Core_Model_Mysql4_Abstract {

    public function _construct() {
        $this->_init('blog/category', 'category_id');
    }

    /*
     * _beforeSave
     */

    protected function _beforeSave(Mage_Core_Model_Abstract $object) {
        //Check Idendifier is unique
        if (!$this->isUniqueField($object, $this->getTable('blog/category'), 'identifier', 'category_id')) {
            $message = Mage::helper('blog')->__("Category Identifier already exist.");
            Mage::throwException($message);
        }
        //Check URL is unique
        if (!$this->isUniqueField($object, $this->getTable('blog/category'), 'url', 'category_id')) {
            $message = Mage::helper('blog')->__("Category URL already exist.");
            Mage::throwException($message);
        }
        return $this;
    }

    /*
     * Check field unique or not
     */

    public function isUniqueField(Mage_Core_Model_Abstract $object, $tableName, $fieldUnique, $fieldKey) {
        $select = $this->_getWriteAdapter()->select()
                ->from($tableName)
                ->where("`{$fieldUnique}` = ?", $object->getData($fieldUnique))
        ;
        if ($object->getId()) {
            $select->where("`{$fieldKey}` <> ?", $object->getId());
        }
        if ($this->_getWriteAdapter()->fetchRow($select)) {
            return false;
        }
        return true;
    }

    /*
     * _afterSave
     * Need save category store, category type
     */

    protected function _afterSave(Mage_Core_Model_Abstract $object) {
        //Save category store
        $condition = $this->_getReadAdapter()->quoteInto('category_id', $object->getId());
        $this->_getWriteAdapter()->delete($this->getTable('blog/categorystore'), $condition);

        if (!$object->getData('store_id')) {
            $storeArray = array();
            $storeArray['category_id'] = $object->getId();
            $storeArray['store_id'] = '0';
            $this->_getWriteAdapter()->insert($this->getTable('blog/categorystore'), $storeArray);
        } else {
            foreach ((array) $object->getData('store_id') as $store) {
                $storeArray = array();
                $storeArray['category_id'] = $object->getId();
                $storeArray['store_id'] = $store;
                $this->_getWriteAdapter()->insert($this->getTable('blog/categorystore'), $storeArray);
            }
        }

        //Save category type
        $condition = $this->_getWriteAdapter()->quoteInto('category_id = ?', $object->getId());
        $this->_getWriteAdapter()->delete($this->getTable('blog/categorytype'), $condition);
        if (sizeof((array) $object->getData('type')) > 0) {
            $storeArray = array();
            $storeArray['category_id'] = $object->getId();
            $storeArray['type_id'] = $object->getData('type');
            $this->_getWriteAdapter()->insert($this->getTable('blog/categorytype'), $storeArray);
        }
        return parent::_afterSave($object);
    }

    /*
     * Load data to display when edit article
     */

    protected function _afterLoad(Mage_Core_Model_Abstract $object) {
        //Load category store view
        $select = $this->_getReadAdapter()->select()
                ->from($this->getTable('blog/categorystore'))
                ->where('category_id = ?', $object->getId())
        ;
        if ($data = $this->_getReadAdapter()->fetchAll($select)) {
            $storesArray = array();
            foreach ($data as $row) {
                $storesArray[] = $row['store_id'];
            }
            $object->setData('store_id', $storesArray);
        }
        //Load category type
        $select = $this->_getReadAdapter()->select()
                ->from($this->getTable('blog/categorytype'))
                ->where('category_id = ?', $object->getId())
        ;
        if ($data = $this->_getReadAdapter()->fetchRow($select)) {
            $categories = array();
            $object->setData('type', $data['type_id']);
        }
        return parent::_afterLoad($object);
    }

}
