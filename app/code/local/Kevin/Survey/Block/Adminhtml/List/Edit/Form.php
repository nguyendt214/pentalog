<?php

/*
  @author: Kevin (nguyendt214@gmail.com)
 */

class Kevin_Survey_Block_Adminhtml_List_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareForm()
    {
        parent::_prepareForm();
        $this->setTemplate('kevin/survey/list.phtml');
    }

    public function getSurvey(){
        return Mage::registry('survey_data');
    }

}
