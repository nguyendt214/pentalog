<?php

/**
 * Description of Toolbar
 *
 * @author ndotrong
 */
class Kevin_All_Helper_Toolbar extends Mage_Core_Block_Abstract {

    //put your code here

    /*
     * Declare Toolbar
     */

    public function initToolbar($block, $params = array()) {

        $toolbar = $this->getToolbarBlock();
        if (isset($params['orders'])) {
            $toolbar->setAvailableOrders($params['orders']);
        }
        if (isset($params['default_order'])) {
            $toolbar->setDefaultOrder($params['default_order']);
        }

        if (isset($params['dir'])) {
            $toolbar->setDefaultDirection($params['dir']);
        } else {
            $toolbar->setDefaultDirection('ASC');
        }

        if (isset($params['method'])) {
            $toolbar->setCollection($block->{$params['method']}());
        } else {
            $toolbar->setCollection($block->getPreparedCollection());
        }

        $toolbar->disableViewSwitcher();
        $block->setChild('kevin_toolbar', $toolbar);
    }

    public function getToolbarBlock() {
        return Mage::app()->getLayout()->createBlock('all/toolbar/toolbar', microtime());
    }

}
