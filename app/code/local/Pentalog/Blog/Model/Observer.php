<?php

/**
 * User: ndotrong
 */
class Pentalog_Blog_Model_Observer
{
    /*
     * send email to administrator after customer write new comment
     */
    public function afterSaveComment($observer)
    {
        try {
            $comment = $observer->getComment();
            $configs = Mage::helper('blog/configs')->getAllConfigs();

            $sendTo = array(
                'name' => '',
                'email' => $configs->getCommentRecipientEmail(),
            );
            $params = array(
                'comment' => $comment
            );

            Mage::helper('all/email')->sendEmail(
                $configs->getCommentEmailTemplate(),
                $configs->getCommentSenderEmailIdentity(),
                $sendTo,
                null,
                null,
                $params,
                Mage::app()->getStore()->getStoreId()
            );
        } catch (Exception $e) {
            Mage::log("Send email after customer write comment error: " . $e->getMessage(), null, 'pentalog_blog_comment_error.log');
        }
    }
}