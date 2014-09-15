<?php

class Kevin_Krewrite_Model_Krewrite extends Mage_Core_Model_Abstract {

  public function _construct() {
    parent::_construct();
    $this->_init('krewrite/krewrite');
  }

}