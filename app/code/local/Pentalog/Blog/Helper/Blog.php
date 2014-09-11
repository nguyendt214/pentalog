<?php

class Pentalog_Blog_Helper_Blog extends Mage_Core_Helper_Abstract {

    public function getBlogUrl($blog) {
        return Mage::getUrl('blog/article/view', array('id' => $blog->getId()));
    }

    /**
     * Renders Category page on front end
     *
     * Call from controller action
     *
     * @param Mage_Core_Controller_Front_Action $action
     * @param integer $categoryId
     * @return boolean
     */
    public function renderPage(Mage_Core_Controller_Front_Action $action, $blogId = null) {
        $blog = Mage::getSingleton('blog/blog');
        //Set store id for filter blog avaible for current store or not
        $blog->setStoreId(Mage::app()->getStore()->getStoreId());
        $blog->load($blogId);
        //If not exists category
        if (!$blog->getId()) {
            return false;
        }
        Mage::register('current_blog', $blog);
        $configs = Mage::helper('blog/configs')->getAllConfigs();
        $pageTitle = $blog->getTitle();
        $blogTitle = $configs->getBlogTitle() . " | " . $pageTitle;
        $action->loadLayout();
        $action->getLayout()->getBlock('head')->setTitle($blogTitle);
        $action->getLayout()->getBlock('root')->setTemplate($configs->getBlogLayout());
        $action->renderLayout();
        return true;
    }

}
