<?php

/**
 * Url rewrite request model
 *
 * @category Mage
 * @package Mage_Core
 * @author Kevin <ndotrong@pentalog.fr>
 */
class Kevin_Krewrite_Model_Url_Rewrite_Request extends Mage_Core_Model_Url_Rewrite_Request
{
    /**
     * Implement logic of custom rewrites
     *
     * @return bool
     */
    protected function _rewriteDb()
    {
        if (null === $this->_rewrite->getStoreId() || false === $this->_rewrite->getStoreId()) {
            $this->_rewrite->setStoreId($this->_app->getStore()->getId());
        }
        $requestCases = $this->_getRequestCases();
        $moduleName = Mage::app()->getRequest();
        $kevinRewrite = Mage::getModel('krewrite/krewrite')->getCollection()
            ->addFieldToFilter('is_active', 1)
            ->addStoreFilter($this->_rewrite->getStoreId())
            ->addRequestFilter($requestCases)
            ->getFirstItem();

        if (isset($kevinRewrite) and $kevinRewrite->getId() > 0) {
            try {
                $this->kevinRewriteUrl($kevinRewrite);
            } catch (Exception $e) {
                Mage::log($e->getMessage(), null, 'kevinRedirectError.log');
                return parent::_rewriteDb();
            }
        } else {
            return parent::_rewriteDb();
        }
    }

    /*
     * My custom redirect or load content
     *
     */
    public function kevinRewriteUrl($url)
    {
        //Redirect type: None, R: Temporary (302), RP: Permanent (301)
        $isPermanentRedirectOption = $url->getOptions();
        if ($url->getIsExternalLink() == 1) {
            $targetUrl = $url->getTargetPath();
            $this->_sendRedirectHeaders($targetUrl, $isPermanentRedirectOption);
        }
        if ($url->getIsSecure() == 1) {
            $targetUrl = Mage::getUrl($url->getTargetPath(), array('_secure' => true));
        } else {
            $targetUrl = Mage::getUrl($url->getTargetPath());
        }
        if ($isPermanentRedirectOption == 'R' || $isPermanentRedirectOption == 'RP') {
            $this->_sendRedirectHeaders($targetUrl, $isPermanentRedirectOption);
        }

        $this->_request->setRequestUri($targetUrl);
        $this->_request->setPathInfo($url->getTargetPath());
        return true;
    }
}
