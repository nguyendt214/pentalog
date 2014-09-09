<?php

/*
 * @author: Kevin (ndotrong@pentalog.fr)
 */

class Pentalog_Blog_Helper_Data extends Mage_Core_Helper_Abstract {
    /*
     * Return category collection
     */

    public function getCategories($filter = null, $sortField = 'category_id', $sort = 'asc', $storeId = null) {
        try {
            $categories = Mage::getModel('blog/category')->getCollection()
                    ->setOrder($sortField, $sort)
            ;
            if (isset($filter) and is_array($filter)) {
                foreach ($filter as $key => $value) {
                    $categories->addFieldToFilter($key, $value);
                }
            }
            if($storeId){
                $categories->addFilterByStore($categories, $storeId);
            }
            return $categories;
        } catch (Exception $e) {
            $message = Mage::helper('blog')->__("Get Category Error: ".$e->getMessage());
            $this->pentalogLog($message);
            return null;
        }
    }
    
    /*
     * Log function
     */
    public function pentalogLog($message, $fileName = 'pentalog_blog.log'){
        Mage::log($message, null, $fileName);
    }
    
    /*
     * Return category collection
     */

    public function getTypes($filter = null, $sortField = 'type_id', $sort = 'asc') {
        try {
            $types = Mage::getModel('blog/type')->getCollection()
                    ->setOrder($sortField, $sort)
            ;
            if (isset($filter) and is_array($filter)) {
                foreach ($filter as $key => $value) {
                    $types->addFieldToFilter($key, $value);
                }
            }
            return $types;
        } catch (Exception $e) {
            $message = Mage::helper('blog')->__("Get Type Error: ".$e->getMessage());
            $this->pentalogLog($message);
            return null;
        }
    }

}
