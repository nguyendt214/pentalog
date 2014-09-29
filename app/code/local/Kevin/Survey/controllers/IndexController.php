<?php

/**
 * Created by nguyendt214@gmail.com.
 */
class Kevin_Survey_IndexController extends Mage_Core_Controller_Front_Action
{

    public function indexAction()
    {
        $this->loadLayout();
        $order = Mage::getModel('sales/order')->load($this->getRequest()->getParam('id'));
        if ($order->getId()) {
            $loginCustomer = Mage::helper('survey')->autoLoggedCustomer($order);
            if ($loginCustomer) {
                $this->_title(__("Survey Page"));
                $this->renderLayout();
            } else {
                //Redirect to homepage
                $this->_redirect('');
            }
        } else {
            //Redirect to homepage
            $this->_redirect('');
        }
    }

    public function surveyPostAction()
    {
        $post = $this->getRequest()->getPost();
        try {
            //Save survey list
            $surveyList = Mage::getModel('survey/list');
            $surveyList->addData($post);
            $surveyList->save();
            //integrate survey with product review
            Mage::helper('survey')->saveProductReview($surveyList);
            //Send email notify to administrator
            Mage::helper('survey')->sendEmailAfterCustomerCreateSurvey($surveyList);
        } catch (Exception $e) {
            Mage::log($e->getMessage(), null, 'survey_error.log');
        }
        $this->_redirect('survey_success.html');
    }

    public function testAction()
    {
        $surveyList = Mage::getModel('survey/list')->load(1);
        Mage::helper('survey')->saveProductReview($surveyList);
        echo "DONE";
        die;
    }
}