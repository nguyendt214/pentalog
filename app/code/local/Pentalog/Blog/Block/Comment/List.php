<?php

/*
  @author: Kevin (ndotrong@pentalog.fr)
 */

class Pentalog_Blog_Block_Comment_List extends Pentalog_Blog_Block_Comment_Abstract
{
    protected $_commentList = null;

    public function getCommentList()
    {
        if (!$this->hasData('comment')) {
            $article = $this->getArticle();
            $comments = Mage::getModel('blog/comment')->getCollection()
                ->addFieldToFilter('blog_id', $article->getId())
                ->addFieldToFilter('status', 1)
                ->setOrder('comment_id', 'DESC');
            $this->setData('comment', $comments);
        }
        return $this->getData('comment');
//        if ($this->_commentList === null) {
//            $article = $this->getArticle();
//            $comments = Mage::getModel('blog/comment')->getCollection()
//                ->addFieldToFilter('blog_id', $article->getId())
//                ->addFieldToFilter('status', 1)
//                ->setOrder('comment_id', 'DESC');
//            $this->_commentList = $comments;
//        }
//        return $this->_commentList;
    }

    /**
     * Need use as _prepareLayout - but problem in declaring collection from
     * another block (was problem with search result)
     */
    protected function _beforeToHtml()
    {
        /*
         * init toolbar
         */
        Mage::helper('all/toolbar')->initToolbar(
            $this, array(
                'orders' => array(
                    'comment_id' => 'Newest',
                ),
                'default_order' => 'comment_id',
                'dir' => 'Desc',
                'defaultAvailbleLimit' => array(2 => 2, 4 => 4, 6 => 6),
                'method' => 'getCommentList',
            )
        );
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve list toolbar HTML
     *
     * @return string
     */
    public function getToolbarHtml()
    {
        return $this->getChildHtml('kevin_toolbar');
    }
}
