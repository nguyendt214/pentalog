<?php

/*
 * @author: Kevin (ndotrong@pentalog.fr)
 */

class Pentalog_Blog_Model_Mysql4_Type extends Mage_Core_Model_Mysql4_Abstract {

    public function _construct() {
        $this->_init('blog/type', 'type_id');
    }
}
