<?php
/**
 * User: ndotrong
 */
class Kevin_Survey_Model_Observer{

    public function createSurveySchedule(Varien_Event_Observer $observer){
//        Mage::log($observer->getData(), null, 'kevin.log');
        $orderIds = $observer->getOrderIds();
        if(sizeof($orderIds)){

        }
    }
    /*
     * Check every day to send survey to customer
     */
    public function checkSendSurvey(){
        Mage::helper('survey')->checkSendSurvey();
    }

}