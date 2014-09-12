<?php

/**
 * User: ndotrong
 */
class Pentalog_Blog_CommentController extends Mage_Core_Controller_Front_Action
{
    /*
     * postComment action
     */
    public function commentPostAction()
    {
        $data = $this->getRequest()->getPost();
        try {
            if ($data) {
                $comment = Mage::getModel('blog/comment');
                $comment->setData($data);
                $comment->save();
                Mage::getSingleton('core/session')->addSuccess(Mage::helper('blog')->__('Comment was sent.'));
            }
        } catch (Exception $e) {
            Mage::log("Add comment error: " . $e->getMessage());
            Mage::getSingleton('core/session')->addError(Mage::helper('blog')->__('System error: '.$e->getMessage()));
        }
        $this->_redirect('blog/article/view', array('id' => $this->getRequest()->getPost('blog_id')));
    }
}