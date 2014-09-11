<?php

/**
 * Description of Comment
 *
 * @author ndotrong
 */
class Pentalog_Blog_Block_Comment_Abstract extends Mage_Core_Block_Template {

    protected $_article = null;

    public function getArticle() {
        if ($this->_article === null) {
            $this->_article = Mage::registry('current_blog');
        }
        return $this->_article;
    }

    /*
     * Return all configs of this module
     */

    public function getAllConfigs() {
        return Mage::helper('blog/configs')->getAllConfigs();
    }

    /*
     * Check customer loggin or not
     */

    public function customerLogged() {
        $customer = $this->getCustomer();
        if (isset($customer) and $customer->getId() > 0) {
            return true;
        }
        return false;
    }

    protected function getCustomer() {
        return Mage::helper('customer')->getCustomer();
    }

    public function allowWriteComment() {
        $configs = $this->getAllConfigs();
        $customer = $this->getCustomer();
        if ($configs->getAllowNotLoginWriteComment()) {
            return true;
        } else if (isset($customer) and $customer->getId() > 0) {
            return true;
        }
        return false;
    }

}
