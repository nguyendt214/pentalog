<?php

/*
 * @author: Kevin (ndotrong@pentalog.fr)
 */

class Pentalog_Blog_Model_Mysql4_Blog extends Mage_Core_Model_Mysql4_Abstract {

    public function _construct() {
        $this->_init('blog/blog', 'blog_id');
    }

    /*
     * _beforeSave
     */
    protected function _beforeSave(Mage_Core_Model_Abstract $object) {

        //Check Idendifier is unique
        if(!$this->isUniqueField($object, $this->getTable('blog/blog'), 'identifier', 'blog_id')){
            $message = Mage::helper('blog')->__("Article Identifier already exist.");
            Mage::throwException($message);
        }
        
        if(!$this->isUniqueField($object, $this->getTable('blog/blog'), 'url', 'blog_id')){
            $message = Mage::helper('blog')->__("Article URL already exist.");
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
     * Need save article store, article category
     */

    protected function _afterSave(Mage_Core_Model_Abstract $object) {
        //Save article store
        $condition = $this->_getReadAdapter()->quoteInto('blog_id = ?', $object->getId());
        $this->_getWriteAdapter()->delete($this->getTable('blog/blogstore'), $condition);

        if (!$object->getData('store_id')) {
            $storeArray = array();
            $storeArray['blog_id'] = $object->getId();
            $storeArray['store_id'] = '0';
            $this->_getWriteAdapter()->insert($this->getTable('blog/blogstore'), $storeArray);
        } else {
            foreach ((array) $object->getData('store_id') as $store) {
                $storeArray = array();
                $storeArray['blog_id'] = $object->getId();
                $storeArray['store_id'] = $store;
                $this->_getWriteAdapter()->insert($this->getTable('blog/blogstore'), $storeArray);
            }
        }

        //Save article categories
        $condition = $this->_getWriteAdapter()->quoteInto('blog_id = ?', $object->getId());
        $this->_getWriteAdapter()->delete($this->getTable('blog/blogcategory'), $condition);
        if (sizeof((array) $object->getData('category_id')) > 0) {
            foreach ((array) $object->getData('category_id') as $store) {
                $storeArray = array();
                $storeArray['blog_id'] = $object->getId();
                $storeArray['category_id'] = $store;
                $this->_getWriteAdapter()->insert($this->getTable('blog/blogcategory'), $storeArray);
            }
        }

        return parent::_afterSave($object);
    }

    /*
     * Load data to display when edit article
     */

    protected function _afterLoad(Mage_Core_Model_Abstract $object) {
        $select = $this->_getReadAdapter()->select()
                ->from($this->getTable('blog/blogstore'))
                ->where('blog_id = ?', $object->getId())
        ;
        if ($data = $this->_getReadAdapter()->fetchAll($select)) {
            $storesArray = array();
            foreach ($data as $row) {
                $storesArray[] = $row['store_id'];
            }
            $object->setData('store_id', $storesArray);
        }

        $select = $this->_getReadAdapter()->select()
                ->from($this->getTable('blog/blogcategory'))
                ->where('blog_id = ?', $object->getId())
        ;
        if ($data = $this->_getReadAdapter()->fetchAll($select)) {
            $categories = array();
            foreach ($data as $row) {
                $categories[] = $row['category_id'];
            }
            $object->setData('category_id', $categories);
        }
        return parent::_afterLoad($object);
    }

}
