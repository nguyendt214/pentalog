<?php

/*
 * @author: Kevin (ndotrong@pentalog.fr)
 */

class Pentalog_Blog_Model_Mysql4_Comment extends Mage_Core_Model_Mysql4_Abstract {

    public function _construct() {
        $this->_init('blog/comment', 'comment_id');
    }
}
