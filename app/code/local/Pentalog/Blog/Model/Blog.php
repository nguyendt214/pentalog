<?php
/*
 * @author: Kevin (ndotrong@pentalog.fr)
 */
class Pentalog_Blog_Model_Blog extends Mage_Core_Model_Abstract {

    public function _construct() {
        parent::_construct();
        $this->_init('blog/blog');
    }

}
