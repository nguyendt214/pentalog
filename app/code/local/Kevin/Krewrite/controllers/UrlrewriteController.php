<?php

/**
 *
 * @category   Mage
 * @package    Kevin Rewrite URL
 * @author     ndotrong@pentalog.fr
 * @purpose :  add new function allow admin delete url rewrite
 */
include_once 'Mage' .DS. 'Adminhtml' .DS. 'controllers' .DS. 'UrlrewriteController.php';

class Kevin_Krewrite_UrlrewriteController extends Mage_Adminhtml_UrlrewriteController {
    /*
     *
     * Mass action Delete
     */
    public function massDeleteAction() {
        $this->_initRegistry();
        $urlIds = $this->getRequest()->getParam('kevin_url');
        if (!is_array($urlIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($urlIds as $urlId) {
                    $model = Mage::getModel('core/url_rewrite')->load($urlId);
                    $model->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                        Mage::helper('adminhtml')->__(
                                'Total of %d record(s) were successfully deleted', count($urlIds)
                        )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/');
    }

}
