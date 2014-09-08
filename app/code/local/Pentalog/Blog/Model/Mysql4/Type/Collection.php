<?php
/*
  @author: Kevin (ndotrong@pentalog.fr)
 */
class Pentalog_Blog_Model_Mysql4_Type_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract {

    public function _construct() {
        parent::_construct();
        $this->_init('blog/type');
    }

}
