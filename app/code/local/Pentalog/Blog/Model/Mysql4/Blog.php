<?php

/*
 * @author: Kevin (ndotrong@pentalog.fr)
 */

class Pentalog_Blog_Model_Mysql4_Blog extends Kevin_All_Model_Mysql4_Abstract {

    public function _construct() {
        $this->_init('blog/blog', 'blog_id');
    }

    /*
     * _beforeSave
     */
    protected function _beforeSave(Mage_Core_Model_Abstract $object) {

        $message = '';
        //Check Idendifier is unique
        if(!$this->isUniqueField($object, $this->getTable('blog/blog'), 'identifier', 'blog_id')){
            $message = Mage::helper('blog')->__("Article Identifier already exist.");
        }
        
        if(!$this->isUniqueField($object, $this->getTable('blog/blog'), 'url', 'blog_id')){
            $message = Mage::helper('blog')->__("Article URL already exist.");
        }

        if(!Mage::getResourceModel('krewrite/krewrite')->isUniqueUrl($object)){
            $message = Mage::helper('blog')->__("Article Rewrite URL already exist.");
        }
        if($message)
            Mage::throwException($message);
        return $this;
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

        //Save article and URL rewrite
        $condition = $this->_getWriteAdapter()->quoteInto("`type` = ?", 'blog_article');
        $condition .= $this->_getWriteAdapter()->quoteInto(" AND type_id = ? ", $object->getId());
        $this->_getWriteAdapter()->delete($this->getTable('krewrite/krewrite'), $condition);

        $articleRewrite = array(
            'request_path' => $object->getUrl(),
            'target_path' => 'blog/article/view/id/'.$object->getId(),
            'store_id' => $object->getStoreId(),
            'options' => '',
            'is_active' => 1,
            'description' => "Rewrite URL for Blog Article ID: ".$object->getId(),
            'type' => 'blog_article',
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
        $condition = $this->_getReadAdapter()->quoteInto('blog_id = ?', $object->getId());
        $this->_getWriteAdapter()->delete($this->getTable('blog/blogstore'), $condition);
        //remove data in comment table
        $condition = $this->_getReadAdapter()->quoteInto('blog_id = ?', $object->getId());
        $this->_getWriteAdapter()->delete($this->getTable('blog/comment'), $condition);
        //delete data on table kevin rewrite
        $condition = $this->_getReadAdapter()->quoteInto('type_id = ?', $object->getId());
        $condition = $this->_getReadAdapter()->quoteInto(' AND `type` = ?', 'blog_article');
        $this->_getWriteAdapter()->delete($this->getTable('krewrite/krewrite'), $condition);

        return parent::_afterDelete($object);
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
    /*
     * Check this blog available on current store view or not
     */
    protected function _getLoadSelect($field, $value, $object) {
        $select = parent::_getLoadSelect($field, $value, $object);
        if ($object->getStoreId() and !Mage::app()->isSingleStoreMode()) {
            $select
                    ->join(array('blogStore' => $this->getTable('blog/blogstore')), $this->getMainTable() . '.blog_id = `blogStore`.blog_id')
                    ->where('`blogStore`.store_id in (0, ?) ', $object->getStoreId())
                    ->order('store_id DESC')
                    ->limit(1)
            ;
        }
        return $select;
    }

}
