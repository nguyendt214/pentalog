<?php

class Kevin_Survey_Model_Mysql4_List extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {
        $this->_init('survey/list', 'survey_comment_id');
    }
}