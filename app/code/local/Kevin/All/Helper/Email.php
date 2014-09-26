<?php

/**
 * User: ndotrong
 */
class Kevin_All_Helper_Email extends Mage_Core_Helper_Abstract
{
    /*
     * Send email function
     * sender: array(), sendTo = array('name', 'email')
     */
    public function sendEmail($templateId, $sender = array(), $sendTo = array(), $copyTo = array(), $bccTo = array(), $params = null, $storeId)
    {
        try {
            $mailer = Mage::getModel('core/email_template_mailer');
            $emailInfo = Mage::getModel('core/email_info');
            $emailInfo->addTo($sendTo['email'], $sendTo['name']);

            if (sizeof($copyTo)) {
                foreach ($copyTo as $email) {
                    $emailInfo = Mage::getModel('core/email_info');
                    $emailInfo->addTo($email);
                    $mailer->addEmailInfo($emailInfo);
                }
            }

            if (sizeof($bccTo)) {
                // Add bcc to customer email
                foreach ($bccTo as $email) {
                    $emailInfo->addBcc($emailInfo);
                }
            }
            $mailer->addEmailInfo($emailInfo);

            // Set all required params and send emails
            $mailer->setSender($sender);
            $mailer->setStoreId($storeId);
            $mailer->setTemplateId($templateId);
            $mailer->setTemplateParams($params);
            $mailer->send();

            return true;
        } catch (Exception $e) {
            die($e->getMessage());
            Mage::log("General email error: " . $e->getMessage(), null, 'kevin_send_email_error.log');
        }
    }

    public function getEmailStore($group)
    {
        return array(
            'name' => Mage::getStoreConfig('trans_email/' . $group . '/name'),
            'email' => Mage::getStoreConfig('trans_email/' . $group . '/email'),
        );
    }

    /*
     * public function sendEmailAction()
    {
        try {
            $configs = Mage::helper('blog/configs')->getAllConfigs();
            $templateId = $configs->getCommentEmailTemplate();
            //$templateId = Mage::getStoreConfig('contacts/email/email_template');
            $sender = $configs->getCommentSenderEmailIdentity();
            $sendTo = array(
                'name' => '',
                'email' => $configs->getCommentRecipientEmail(),
            );
            $params = array(
                'user_name' => 'Name',
                'user_email' => 'abc@gmail.com',
                'user_telephone' => '123456',
                'title' => 'Title',
                'content' => 'Comment Content',
                'comment_id' => 1
            );

            $postObject = new Varien_Object();
            $postObject->setData($params);

            $params = array(
                'customer' => $postObject
            );

            $storeId = Mage::app()->getStore()->getStoreId();

            Mage::helper('all/email')->sendEmail($templateId, $sender, $sendTo, null, null, $params, $storeId);

            echo "DONE";
            die;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
     */
}