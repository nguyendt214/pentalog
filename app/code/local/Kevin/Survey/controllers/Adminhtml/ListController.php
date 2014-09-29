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
        $this->_initAction()
            ->renderLayout();
    }


    protected function setTitle($title)
    {
        $this->_title($title);
        return $this;
    }

    public function viewAction()
    {
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('survey/list')->load($id);

        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }
            $this->setTitle(Mage::helper('krewrite')->__("Survey detail"));

            Mage::register('survey_data', $model);

            $this->loadLayout();
            $this->_setActiveMenu('customer/survey');

            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

            $this->_addContent($this->getLayout()->createBlock('survey/adminhtml_list_edit'));

            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('survey')->__('Item does not exist'));
            $this->_redirect('*/*/');
        }
    }


    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('admin/customer/survey/list');
    }
}