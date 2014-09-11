<?php

/**
 * Description of Toolbar
 *
 * @author ndotrong
 */
class Kevin_All_Helper_Toolbar extends Mage_Core_Helper_Abstract {
    /*
     * Declare Toolbar
     */

    public function initToolbar($block, $params = array()) {
        $toolbar = $this->getToolbarBlock($block);
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
        if (isset($params['defaultAvailbleLimit'])) {
            $toolbar->setAvailableLimit($params['defaultAvailbleLimit']);
        }
        if (isset($params['method'])) {
            $toolbar->setCollection($block->{$params['method']}());
        } else {
            $toolbar->setCollection($block->getPreparedCollection());
        }
        $toolbar->disableViewSwitcher();
        $block->setChild('kevin_toolbar', $toolbar);
    }

    /*
     * Return toolbar block
     * Set toolbar custom template
     */

    public function getToolbarBlock($block) {
        $toolbarBlock = $block->getLayout()->createBlock('all/toolbar_toolbar', microtime())->setTemplate('kevin/all/toolbar.phtml');
        $pager = $block->getLayout()->createBlock('page/html_pager', microtime())->setTemplate('kevin/all/pager.phtml');
        $toolbarBlock->setChild('product_list_toolbar_pager', $pager);
        return $toolbarBlock;
    }

}
