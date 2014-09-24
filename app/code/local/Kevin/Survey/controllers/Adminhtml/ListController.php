<?php

/**
 * Created by PhpStorm.
 * Date: 9/24/14
 */
class Kevin_Survey_Adminhtml_ListController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('customer/survey');
        $this->setTitle(Mage::helper('survey')->__("Survey List"));
        return $this;
    }

    public function indexAction()
    {
//        $order = Mage::getModel('sales/order')->load(189);
//        Mage::helper('survey')->createSurveySchedule($order);
        Mage::helper('survey')->checkSendSurvey();
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
        return Mage::getSingleton('admin/session')->isAllowed('admin/customer/survey/list');
    }
}