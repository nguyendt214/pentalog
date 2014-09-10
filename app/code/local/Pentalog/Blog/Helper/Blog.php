<?php

class Pentalog_Blog_Helper_Blog extends Mage_Core_Helper_Abstract{
    
    public function getBlogUrl($blog){
        return Mage::getUrl('blog/article/view', array('id' => $blog->getId()));
    }
}

