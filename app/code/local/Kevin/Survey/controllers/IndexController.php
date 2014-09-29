<?php
/**
 * Created by nguyendt214@gmail.com.
 */
class Kevin_Survey_IndexController extends Mage_Core_Controller_Front_Action{

    public function indexAction(){
        $this->loadLayout();
        $this->_title(__("Survey Page"));
        $this->renderLayout();
    }

    public function surveyPostAction(){
        $post = $this->getRequest()->getPost();
        try{

        }catch (Exception $e){
            $this->_redirect("*/*/");
        }
    }
}