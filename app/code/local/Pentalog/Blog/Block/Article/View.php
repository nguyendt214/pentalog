<?php
/**
 * Description of View
 *
 * @author ndotrong
 */
class Pentalog_Blog_Block_Article_View extends Mage_Core_Block_Template{
    
    public function getArticle(){
        return Mage::getSingleton('blog/blog');
    }
    
    public function getAllConfigs(){
        return Mage::helper('blog/configs')->getAllConfigs();
    }
}
