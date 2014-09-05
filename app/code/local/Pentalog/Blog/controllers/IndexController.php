<?php
/*
 * @author: Kevin (ndotrong@pentalog.fr)
 * @return: Frontend controller
 */

class Pentalog_Blog_IndexController extends Mage_Core_Controller_Front_Action {

    public function indexAction() {
        $this->loadLayout();
        $this->renderLayout();
    }
}
