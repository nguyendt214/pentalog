<?php

/*
  @author: Kevin (ndotrong@pentalog.fr)
 */

class Pentalog_Blog_Model_Layouts extends Varien_Object {

    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 2;

    static public function toOptionArray() {

        $pages = Mage::getSingleton('page/config')->getPageLayouts();
        $layouts = array();
        foreach($pages as $page){
            $layouts[] = array(
                'label' => $page->getLabel(),
                'value' => $page->getTemplate(),
            );
        }
        return $layouts;
    }

}
