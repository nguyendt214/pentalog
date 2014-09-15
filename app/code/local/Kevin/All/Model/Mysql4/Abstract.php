<?php

/**
 * User: ndotrong
 * Date: 9/15/14
 * Time: 3:21 PM
 */
class Kevin_All_Model_Mysql4_Abstract extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {
        return parent::_construct();
    }

    /*
     * Check field unique or not
     */

    public function isUniqueField(Mage_Core_Model_Abstract $object, $tableName, $fieldUnique, $tablePrimaryKey)
    {
        $select = $this->_getWriteAdapter()->select()
            ->from($tableName)
            ->where("`{$fieldUnique}` = ?", $object->getData($fieldUnique));
        if ($object->getId()) {
            $select->where("`{$tablePrimaryKey}` <> ?", $object->getId());
        }
        if ($this->_getWriteAdapter()->fetchRow($select)) {
            return false;
        }
        return true;
    }
}