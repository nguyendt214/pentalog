<?php
/*
  @author: Kevin (ndotrong@pentalog.fr)
 */
class Pentalog_Blog_Model_Mysql4_Blog_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract {

    public function _construct() {
        parent::_construct();
        $this->_init('blog/blog');
    }
    
    public function addCategoryFilter($category){
        $this->getSelect()
                ->joinInner(array('blogcategory' => $this->getTable('blog/blogcategory')),'`main_table`.blog_id = `blogcategory`.blog_id', array('category_id'))
                ->where('category_id = ?', $category->getId())
                ;
        return $this;
    }
    
    public function addStoreFilter($storeId){
        $this->getSelect()
                ->joinInner(array('blogstore' => $this->getTable('blog/blogstore')),'`main_table`.blog_id = `blogstore`.blog_id', array('store_id'))
                ->where('store_id in (?)', array(0, $storeId))
                ;
        return $this;
    }

}
