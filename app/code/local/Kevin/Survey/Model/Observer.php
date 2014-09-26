<?php
/**
 * User: ndotrong
 */
class Kevin_Survey_Model_Observer{

    public function createSurveySchedule(Varien_Event_Observer $observer){
        $orderIds = $observer->getOrderIds();
        if(sizeof($orderIds)){
            foreach($orderIds as $orderId){
                Mage::helper('survey')->createSurveySchedule(Mage::getModel('sales/order')->load($orderId));
            }
        }
    }
    /*
     * Check every day to send survey to customer
     */
    public function checkSendSurvey(){
        Mage::helper('survey')->checkSendSurvey();
    }

}