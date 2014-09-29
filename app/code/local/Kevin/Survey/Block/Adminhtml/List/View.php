<?php
/**
 * Created by ndotrong@pentalog.fr.
 */
class Kevin_Survey_Block_Adminhtml_List_View extends Mage_Core_Block_Template{

    protected function _construct(){
        parent::_construct();
        $this->setTemplate('kevin/survey/list.phtml');
    }
}