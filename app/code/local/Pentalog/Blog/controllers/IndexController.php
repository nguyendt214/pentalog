<?php

/*
 * @author: Kevin (ndotrong@pentalog.fr)
 * @return: Frontend controller
 */

class Pentalog_Blog_IndexController extends Mage_Core_Controller_Front_Action
{

    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function sendEmailAction()
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
}
