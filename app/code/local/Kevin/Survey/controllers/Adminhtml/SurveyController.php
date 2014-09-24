<?php

/**
 * Created by PhpStorm.
 * Date: 9/24/14
 */
class Kevin_Survey_Adminhtml_SurveyController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('customer/survey');
        $this->setTitle(Mage::helper('survey')->__("Survey Schedule"));
        return $this;
    }

    public function indexAction()
    {
        $this->_initAction()
            ->renderLayout();
    }


    protected function setTitle($title)
    {
        $this->_title($title);
        return $this;
    }


    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('admin/customer/survey/survey');
    }
}