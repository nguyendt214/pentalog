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

    public function getHelper($type = 'all')
    {
        return Mage::helper($type);
    }

    public function createSurveySchedule($order)
    {
        $config = $this->getAllConfigs();
        $today = Mage::getModel('core/date')->date('Y-m-d');
        $data = array(
            'order_id' => $order->getId(),
            'order_increment' => $order->getIncrementId(),
            'status' => 2,
            'purchased_date' => $today,
            //'send_survey_date' => date('Y-m-d', strtotime(date("Y-m-d", strtotime($today)) . " +".$config->getDays()." day")),
            'send_survey_date' => $today,
        );

        $survey = Mage::getModel('survey/survey');
        $survey->addData($data);
        $survey->save();
    }

    /*
     * Check survey by day -> send email to customer
     */
    public function checkSendSurvey()
    {

        $today = Mage::getModel('core/date')->date('Y-m-d');
        $surveys = Mage::getModel('survey/survey')
            ->getCollection()
            ->addFieldToFilter('status', 2);
        if (sizeof($surveys) > 0) {
            foreach ($surveys as $survey) {
                //If send_survey_date === today: send survey and update status = 1
                if (strtotime($today) == strtotime($survey->getSendSurveyDate())) {
                    print "<pre>";
                    print_r($survey->getData());
                    die();
                }
            }
        }
    }

    /*
     * Send survey email
     */
    public function sendSurvey($survey, $configs = null){
        if($configs === null)
            $configs = $this->_configs;
        try{
            $order = Mage::getModel('sales/order')->load($survey->getOrderId());
            $templateId = $configs->getEmailTemplate();
            $sender = $configs->getSenderEmailIdentity();
            $sendTo = array(
                'name' => '',
                'email' => $configs->getTestEmail(),
            );

            $params = array(
                'order' => $order
            );

            $storeId = Mage::app()->getStore()->getStoreId();

            Mage::helper('all/email')->sendEmail($templateId,$sender, $sendTo, null, null, $params, $storeId);

        }catch (Exception $e){
            throw new Exception($e->getMessage());
        }
    }
}