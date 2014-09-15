<?php

class Kevin_Krewrite_Model_Mysql4_Krewrite_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{

    public function _construct()
    {
        parent::_construct();
        $this->_init('krewrite/krewrite');
    }

    public function addStoreFilter($storeId)
    {
        $this->getSelect()
            ->joinInner(array('krewriteStore' => $this->getTable('krewrite/store')), '`main_table`.krewrite_id = `krewriteStore`.krewrite_id', array('store_id'))
            ->where('store_id in (?)', array(0, $storeId));
        return $this;
    }

    public function addRequestFilter($requests)
    {
        if (is_array($requests)) {
            $count = 0;
            foreach ($requests as $request) {
                if ($count++ == 0) {
                    $this->getSelect()
                        ->where('`request_path` = ?', $request);
                } else {
                    $this->getSelect()
                        ->orWhere('`request_path` = ?', $request);
                }
            }
            return $this;
        }
        return null;
    }
}