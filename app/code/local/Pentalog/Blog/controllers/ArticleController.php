<?php

/*
 * @author: Kevin (ndotrong@pentalog.fr)
 * @return: Frontend controller
 */

class Pentalog_Blog_ArticleController extends Mage_Core_Controller_Front_Action {

    public function preDispatch() {
        parent::preDispatch();
        if (!(int) Mage::helper('blog/configs')->getAllConfigs()->getBlogActive()) {
            $this->_redirectUrl(Mage::helper('core/url')->getHomeUrl());
        }
    }
    /*
     * View category
     */

    public function viewAction() {
        $id = (int) $this->getRequest()->getParam('id', false);
        
        if (!Mage::helper('blog/blog')->renderPage($this, $id)) {
            Mage::helper('all')->redirectToHomePage($this);
        }
    }
}
