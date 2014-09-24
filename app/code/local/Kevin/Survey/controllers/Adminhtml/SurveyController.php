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

    public function sendEmailPreviewAction()
    {
        try {
            $configs = Mage::helper('survey')->getAllConfigs();
            $survey = Mage::getModel('survey/survey')->load($this->getRequest()->getParam('id'));
            $orderId = Mage::getModel('sales/order')->load($survey->getId());
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('survey')->__('Email has sent to: ') . $configs->getTestEmail());
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
        $this->_redirect('*/*/');
        return;
    }


    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('admin/customer/survey/survey');
    }
}