<?php

/*
  @author: Kevin (ndotrong@pentalog.fr)
 */

class Pentalog_Blog_Block_Comment_Form extends Pentalog_Blog_Block_Comment_Abstract {

    protected $_formData = null;

    public function getActionForm() {
        return Mage::getUrl('blog/comment/commentPost', array('_secure' => false));
    }

    public function getFormData() {
        if ($this->_formData === null) {
            if ($this->customerLogged()) {
                $customer = $this->getCustomer();
                $formData = array(
                    'user_name' => $customer->getName(),
                    'user_email' => $customer->getEmail(),
                    'user_telephone' => $customer->getTelephone(),
                    'title' => '',
                    'content' => '',
                );
                $obj = new Varien_Object();
                $this->_formData = $obj->addData($formData);
            }else{
                $this->_formData = new Varien_Object();
            }
        }

        return $this->_formData;
    }

    public function setFormData() {
        
    }

}

?>
