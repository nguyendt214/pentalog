<?php
/**
 * User: Kevin
 */
class Kevin_Survey_Helper_Data extends Mage_Core_Helper_Abstract
{
    protected $_configs = null;
    /*
     * Return all configuration of this module
     */

    public function getAllConfigs()
    {
        $store = Mage::app()->getStore()->getStoreId();
        if ($this->_configs === null) {
            $this->_configs = array(
                //Blog Listing config
                'days' => ((int)$this->getConfig('kevin_survey/survey/days')) ? (int)$this->getConfig('kevin_survey/survey/days') : 21,
                'test_email' => ($this->getConfig('kevin_survey/survey/test_email')) ? $this->getConfig('kevin_survey/survey/test_email') : 'nguyendt214@gmail.com',
                'sender_email_identity' => ($this->getConfig('kevin_survey/survey/sender_email_identity')) ? $this->getConfig('kevin_survey/survey/sender_email_identity') : 'general',
                'email_template' => ($this->getConfig('kevin_survey/survey/email_template')) ? $this->getConfig('kevin_survey/survey/email_template') : 'kevin_survey_survey_email_template',
                'email_template_admin' => ($this->getConfig('kevin_survey/survey/email_template_admin')) ? $this->getConfig('kevin_survey/survey/email_template_admin') : 'kevin_survey_survey_email_template_admin',
            );

            //Convert configs to Object
            $config = new Varien_Object();
            $this->_configs = $config->addData($this->_configs);
        }
        return $this->_configs;
    }

    /*
     * Return configuration data
     */
    public function getConfig($path)
    {
        $storeId = Mage::app()->getStore()->getStoreId();
        return $this->getHelper()->getConfigValue($path, $storeId);
    }

    public function getHelper($type = 'all') {
        return Mage::helper($type);
    }

    public function createSurveySchedule($order)
    {
        $config = $this->getAllConfigs();
        $data = array(
            'order_id' => $order->getId(),
            'order_increment' => $order->getIncrementId(),
            'status' => 2,
            'purchased_date' => Mage::getModel('core/date')->gmtDate(),
            //'send_survey_date' => date('Y-m-d', strtotime(date("Y-m-d", strtotime(Mage::getModel('core/date')->gmtDate())) . " +".$config->getDays()." day")),
            'send_survey_date' => Mage::getModel('core/date')->gmtDate(),
        );

        $survey = Mage::getModel('survey/survey');
        $survey->addData($data);
        $survey->save();
    }
    /*
     * Check survey by day -> send email to customer
     */
    public function checkSendSurvey(){

    }
}