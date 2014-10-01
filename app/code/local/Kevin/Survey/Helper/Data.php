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
                //Survey config
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
            'send_survey_date' => date('Y-m-d', strtotime(date("Y-m-d", strtotime($today)) . " +" . $config->getDays() . " day")),
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
                    $this->sendSurveyEmail($survey);
                }
            }
        }
    }

    public function sendSurveyEmail($survey)
    {
        $configs = $this->getAllConfigs();
        try {
            $order = Mage::getModel('sales/order')->load($survey->getOrderId());
            $templateId = $configs->getEmailTemplate();
            $sender = $configs->getSenderEmailIdentity();
            $sendTo = array(
                'name' => $order->getCustomerFirstname() . ' ' . $order->getCustomerLastname(),
                'email' => $order->getCustomerEmail(),
            );
            $order->setSurveyLink(Mage::getUrl('survey/index', array('id' => $order->getId())));
            $params = array(
                'order' => $order
            );

            $storeId = Mage::app()->getStore()->getStoreId();

            Mage::helper('all/email')->sendEmail($templateId, $sender, $sendTo, null, null, $params, $storeId);
            //Change survey schedule status
            $survey->setStatus(1);
            $survey->save();

        } catch (Exception $e) {
            Mage::log("Send survey to customer error: " . $e->getMessage() . " Survey ID: " . $survey->getId());
        }
    }

    /*
     * Send survey email
     */
    public function sendSurvey($survey, $configs = null)
    {
        if ($configs === null)
            $configs = $this->getAllConfigs();
        try {
            $order = Mage::getModel('sales/order')->load($survey->getOrderId());
            $templateId = $configs->getEmailTemplate();
            $sender = $configs->getSenderEmailIdentity();
            $sendTo = array(
                'name' => '',
                'email' => $configs->getTestEmail(),
            );
            $order->setSurveyLink(Mage::getUrl('survey/index', array('id' => $order->getId())));
            $params = array(
                'order' => $order
            );

            $storeId = Mage::app()->getStore()->getStoreId();

            Mage::helper('all/email')->sendEmail($templateId, $sender, $sendTo, null, null, $params, $storeId);

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /*
     * Send email to admin when customer create new survey
     */
    public function sendEmailAfterCustomerCreateSurvey($surveyList)
    {
        try {
            $configs = $this->getAllConfigs();
            $order = Mage::getModel('sales/order')->load($surveyList->getOrderId());
            $templateId = $configs->getEmailTemplateAdmin();
            $sender = $configs->getSenderEmailIdentity();
            $sendTo = array(
                'name' => 'Administrator',
                'email' => $configs->getTestEmail(),
            );
            $surveyList->setGoodCondition(($surveyList->getGoodCondition()) ? 'Yes' : 'No');
            $surveyList->setLikeInfo(($surveyList->getLikeInfo()) ? 'Yes' : 'No');
            $surveyList->setUseTestimonial(($surveyList->getUseTestimonial()) ? 'Yes' : 'No');
            $params = array(
                'survey' => $surveyList,
                'order' => $order,
            );
            $storeId = Mage::app()->getStore()->getStoreId();
            Mage::helper('all/email')->sendEmail($templateId, $sender, $sendTo, null, null, $params, $storeId);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function saveProductReview($survey)
    {
        if($survey->getUseTestimonial() == 0)
            return;
        try {
            $order = Mage::getModel('sales/order')->load($survey->getOrderId());
            $data = array(
                'ratings' => array(
                    '1' => 5,
                    '2' => 10,
                    '3' => 15
                ),
                'detail' => $survey->getComment(),
                'title' => 'Customer survey',
                'nickname' => $order->getCustomerFirstname() . ' ' . $order->getCustomerLastname()
            );

            $ratings = $data['ratings'];
            $items = $order->getAllVisibleItems();
            foreach ($items as $item) {
                $product = Mage::getModel('catalog/product')->load($item->getProductId());
                $review = Mage::getModel('review/review')->setData($data);
                $validate = $review->validate();
                if ($validate === true) {
                    $review->setEntityId($review->getEntityIdByCode(Mage_Review_Model_Review::ENTITY_PRODUCT_CODE))
                        ->setEntityPkValue($product->getId())
                        ->setStatusId(Mage_Review_Model_Review::STATUS_PENDING)
                        ->setCustomerId(Mage::getSingleton('customer/session')->getCustomerId())
                        ->setStoreId(Mage::app()->getStore()->getId())
                        ->setStores(array(Mage::app()->getStore()->getId()))
                        ->save();

                    foreach ($ratings as $ratingId => $optionId) {
                        Mage::getModel('rating/rating')
                            ->setRatingId($ratingId)
                            ->setReviewId($review->getId())
                            ->setCustomerId(Mage::getSingleton('customer/session')->getCustomerId())
                            ->addOptionVote($optionId, $product->getId());
                    }

                    $review->aggregate();
                }
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function autoLoggedCustomer($order)
    {
        return;
        $customer = Mage::helper('customer')->getCustomer();
        if (isset($customer) and $customer->getId() > 0) {
            $customerIdInOrder = $order->getCustomerId();
            if($customerIdInOrder == $customer->getId())
                return true;
            return false;
        } else {
            $customer = Mage::getModel('customer/customer')
                ->setWebsiteId(Mage::app()->getStore()->getWebsiteId())
                ->loadByEmail($order->getCustomerEmail());

            if ($customer->getId()) {
                $_session = Mage::getSingleton('customer/session');
                $_session->setCustomerAsLoggedIn($customer);
                $_session->renewSession();
                return true;
            } else {
                return false;
            }
        }
    }
}