<?php
/**
 * Created by nguyendt214@gmail.com.
 * Date: 9/26/14
 */

class Kevin_Survey_Block_Survey extends Mage_Sales_Block_Order_Email_Items {

    public function getSurveyInfo(){
        $orderId = $this->getRequest()->getParam('id');
        return Mage::getModel('sales/order')->load($orderId);
    }

    public function getFormAction(){
        return $this->getUrl('survey/index/surveyPost');
    }
} 