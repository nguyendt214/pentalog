<?php
/*
  @author: Kevin (ndotrong@pentalog.fr)
 */

class Pentalog_Blog_Block_Comment_List extends Pentalog_Blog_Block_Comment_Abstract
{
    protected $_commentList = null;

    public function getCommentList()
    {
        if ($this->_commentList === null) {
            $article = $this->getArticle();
            $comments = Mage::getModel('blog/comment')->getCollection()
                ->addFieldToFilter('blog_id', $article->getId())
                ->addFieldToFilter('status', 1)
                ->setOrder('comment_id', 'DESC')
            ;
            $this->_commentList = $comments;
        }
        return $this->_commentList;
    }
}
