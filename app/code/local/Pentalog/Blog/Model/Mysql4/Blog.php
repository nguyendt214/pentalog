<?php
/*
 * @author: Kevin (ndotrong@pentalog.fr)
 */
class Pentalog_Blog_Model_Mysql4_Blog extends Mage_Core_Model_Mysql4_Abstract {
    public function _construct() {
        // Note that the blog_id refers to the key field in your database table.
        $this->_init('blog/blog', 'blog_id');
    }

}
