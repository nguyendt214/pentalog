<?php

/*
 * @author: Kevin (ndotrong@pentalog.fr)
 */

class Pentalog_Blog_Model_Mysql4_Category extends Kevin_All_Model_Mysql4_Abstract
{

    public function _construct()
    {
        $this->_init('blog/category', 'category_id');
    }

    /*
     * _beforeSave
     */

    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        $message = '';
        //Check Idendifier is unique
        if (!$this->isUniqueField($object, $this->getTable('blog/category'), 'identifier', 'category_id')) {
            Mage::throwException($message);
        }
        //Check URL is unique
        if (!$this->isUniqueField($object, $this->getTable('blog/category'), 'url', 'category_id')) {
            $message = Mage::helper('blog')->__("Category URL already exist.");
        }

        if (!Mage::getResourceModel('krewrite/krewrite')->isUniqueUrl($object)) {
            $message = Mage::helper('blog')->__("Blog Category Rewrite URL already exist.");
        }
        if ($message)
            Mage::throwException($message);
        return $this;
    }

    /*
     * _afterSave
     * Need save category store, category type
     */

    protected function _afterSave(Mage_Core_Model_Abstract $object)
    {
        //Save category store
        $condition = $this->_getReadAdapter()->quoteInto('category_id = ?', $object->getId());
        $this->_getWriteAdapter()->delete($this->getTable('blog/categorystore'), $condition);

        if (!$object->getData('store_id')) {
            $storeArray = array();
            $storeArray['category_id'] = $object->getId();
            $storeArray['store_id'] = '0';
            $this->_getWriteAdapter()->insert($this->getTable('blog/categorystore'), $storeArray);
        } else {
            foreach ((array)$object->getData('store_id') as $store) {
                $storeArray = array();
                $storeArray['category_id'] = $object->getId();
                $storeArray['store_id'] = $store;
                $this->_getWriteAdapter()->insert($this->getTable('blog/categorystore'), $storeArray);
            }
        }
        //Save article and URL rewrite
        $condition = $this->_getWriteAdapter()->quoteInto("`type` = ?", 'blog_category');
        $condition .= $this->_getWriteAdapter()->quoteInto(" AND type_id = ? ", $object->getId());
        $this->_getWriteAdapter()->delete($this->getTable('krewrite/krewrite'), $condition);

        $articleRewrite = array(
            'request_path' => $object->getUrl(),
            'target_path' => 'blog/category/view/id/'.$object->getId(),
            'store_id' => $object->getStoreId(),
            'options' => '',
            'is_active' => 1,
            'description' => "Rewrite URL for Blog Category ID: ".$object->getId(),
            'type' => 'blog_category',
            'type_id' => $object->getId(),
            'is_external_link' => 2,
            'is_secure' => 2,

        );
        $rewrite = Mage::getModel('krewrite/krewrite');
        $rewrite->addData($articleRewrite);
        $rewrite->save();
        return parent::_afterSave($object);
    }
    /*
     * After Delete Article
     */
    protected function _afterDelete(Mage_Core_Model_Abstract $object)
    {
        //remove data in Store View table
        $condition = $this->_getReadAdapter()->quoteInto('category_id = ?', $object->getId());
        $this->_getWriteAdapter()->delete($this->getTable('blog/categorystore'), $condition);
        //remove data in category blog table
        $condition = $this->_getReadAdapter()->quoteInto('category_id = ?', $object->getId());
        $this->_getWriteAdapter()->delete($this->getTable('blog/blogcategory'), $condition);
        //Delete data in URL rewrite table
        $condition = $this->_getReadAdapter()->quoteInto('type_id = ?', $object->getId());
        $condition = $this->_getReadAdapter()->quoteInto(' AND `type` = ?', 'blog_category');
        $this->_getWriteAdapter()->delete($this->getTable('krewrite/krewrite'), $condition);
        return parent::_afterDelete($object);
    }

    /*
     * Load data to display when edit article
     */

    protected function _afterLoad(Mage_Core_Model_Abstract $object)
    {
        //Load category store view
        $select = $this->_getReadAdapter()->select()
            ->from($this->getTable('blog/categorystore'))
            ->where('category_id = ?', $object->getId());
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
     * Check this category avaiable on current store view or not
     */
    protected function _getLoadSelect($field, $value, $object)
    {
        $select = parent::_getLoadSelect($field, $value, $object);
        if ($object->getStoreId() and !Mage::app()->isSingleStoreMode()) {
            $select
                ->join(array('categoryStore' => $this->getTable('blog/categorystore')), $this->getMainTable() . '.category_id = `categoryStore`.category_id')
                ->where('`categoryStore`.store_id in (0, ?) ', $object->getStoreId())
                ->order('store_id DESC')
                ->limit(1);
        }
        return $select;
    }
}
