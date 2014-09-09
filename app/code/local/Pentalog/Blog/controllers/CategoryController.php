<?php

/*
 * @author: Kevin (ndotrong@pentalog.fr)
 * @return: Frontend controller
 */

class Pentalog_Blog_CategoryController extends Mage_Core_Controller_Front_Action {

    public function preDispatch() {
        parent::preDispatch();
        if (!(int) Mage::helper('blog/configs')->getAllConfigs()->getBlogActive()) {
            $this->_redirectUrl(Mage::helper('core/url')->getHomeUrl());
        }
    }

    public function indexAction() {
        $this->_forward('list');
    }

    public function listAction() {
        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setTitle($this->__("Category list"));
        $this->getLayout()->getBlock('root')->setTemplate(Mage::helper('blog/configs')->getAllConfigs()->getBlogLayout());
        $this->renderLayout();
    }

    /*
     * View category
     */

    public function viewAction() {
        $id = (int) $this->getRequest()->getParam('id', false);
        
        if (!Mage::helper('blog/category')->renderPage($this, $id)) {
            Mage::helper('all')->redirectToHomePage($this);
        }
        
    }

}
