<?php

/*
 * @author: Kevin (ndotrong@pentalog.fr)
 */

class Pentalog_Blog_Helper_Category extends Mage_Core_Helper_Abstract
{
    /*
     * Return blog category url
     */
    public function getCategoryUrl($category)
    {
        return rtrim(Mage::getUrl().$category->getUrl(), '/');
        //return Mage::getUrl('blog/category/view', array('id' => $category->getId()));
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
    public function renderPage(Mage_Core_Controller_Front_Action $action, $categoryId = null)
    {
        $category = Mage::getSingleton('blog/category');
        //Set store id for filter category avaible for current store or not
        $category->setStoreId(Mage::app()->getStore()->getStoreId());
        $category->load($categoryId);
        //If not exists category
        if (!$category->getId()) {
            return false;
        }
        Mage::register('current_category', $category);
        $configs = Mage::helper('blog/configs')->getAllConfigs();
        $pageTitle = $category->getName();
        $blogTitle = $configs->getBlogTitle() . " | " . $pageTitle;
        $action->loadLayout();
        $action->getLayout()->getBlock('head')->setTitle($blogTitle);
        $action->getLayout()->getBlock('root')->setTemplate($configs->getBlogLayout());
        $action->renderLayout();

        return true;
    }
}
