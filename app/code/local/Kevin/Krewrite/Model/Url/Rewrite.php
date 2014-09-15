<?php

/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Core
 * @copyright   Copyright (c) 2011 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Url rewrite model class
 *
 * @method Mage_Core_Model_Resource_Url_Rewrite _getResource()
 * @method Mage_Core_Model_Resource_Url_Rewrite getResource()
 * @method Mage_Core_Model_Url_Rewrite setStoreId(int $value)
 * @method int getCategoryId()
 * @method Mage_Core_Model_Url_Rewrite setCategoryId(int $value)
 * @method int getProductId()
 * @method Mage_Core_Model_Url_Rewrite setProductId(int $value)
 * @method string getIdPath()
 * @method Mage_Core_Model_Url_Rewrite setIdPath(string $value)
 * @method string getRequestPath()
 * @method Mage_Core_Model_Url_Rewrite setRequestPath(string $value)
 * @method string getTargetPath()
 * @method Mage_Core_Model_Url_Rewrite setTargetPath(string $value)
 * @method int getIsSystem()
 * @method Mage_Core_Model_Url_Rewrite setIsSystem(int $value)
 * @method string getOptions()
 * @method Mage_Core_Model_Url_Rewrite setOptions(string $value)
 * @method string getDescription()
 * @method Mage_Core_Model_Url_Rewrite setDescription(string $value)
 *
 * @category    Mage
 * @package     Mage_Core
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Kevin_Krewrite_Model_Url_Rewrite extends Mage_Core_Model_Url_Rewrite {

    protected function _construct() {
        $this->_init('core/url_rewrite');
        $request = Mage::app()->getFrontController()->getRequest();
        $pathInfo = $request->getPathInfo();
        $requestUrlRewrite = substr($pathInfo, 0, 1);
        if ($requestUrlRewrite == '/')
            $requestUrlRewrite = substr($pathInfo, 1, strlen($pathInfo) - 1);
        $targetUrlRedirect = Mage::getResourceModel('krewrite/url')->getTargetUrl($requestUrlRewrite);
        if ($targetUrlRedirect) {
            $targetUrlRedirect = Mage::getModel('krewrite/url')->load($targetUrlRedirect);
            $targetUrl = '';
            if ($targetUrlRedirect->getExternalLink() == 1) {
                $targetUrl = $targetUrlRedirect->getUrlTarget();
            } else {
                if ($targetUrlRedirect->getIsSecure() == 1) {
                    $targetUrl = Mage::getUrl('', array('_secure' => true)) . $targetUrlRedirect->getUrlTarget();
                } else {
                    $targetUrl = Mage::getUrl('', array('_secure' => false)) . $targetUrlRedirect->getUrlTarget();
                }
            }
            header("Location: " . $targetUrl, TRUE, 302);
            exit;
        }
    }

    /**
     * Implement logic of custom rewrites
     *
     * @param   Zend_Controller_Request_Http $request
     * @param   Zend_Controller_Response_Http $response
     * @return  Mage_Core_Model_Url
     */
    public function rewrite(Zend_Controller_Request_Http $request = null, Zend_Controller_Response_Http $response = null) {
        if (!Mage::isInstalled()) {
            return false;
        }
        if (is_null($request)) {
            $request = Mage::app()->getFrontController()->getRequest();
        }
        if (is_null($response)) {
            $response = Mage::app()->getFrontController()->getResponse();
        }
        if (is_null($this->getStoreId()) || false === $this->getStoreId()) {
            $this->setStoreId(Mage::app()->getStore()->getId());
        }

        /**
         * We have two cases of incoming paths - with and without slashes at the end ("/somepath/" and "/somepath").
         * Each of them matches two url rewrite request paths - with and without slashes at the end ("/somepath/" and "/somepath").
         * Choose any matched rewrite, but in priority order that depends on same presence of slash and query params.
         */
        $requestCases = array();
        $pathInfo = $request->getPathInfo();
        $origSlash = (substr($pathInfo, -1) == '/') ? '/' : '';
        $requestPath = trim($pathInfo, '/');

        $altSlash = $origSlash ? '' : '/'; // If there were final slash - add nothing to less priority paths. And vice versa.
        $queryString = $this->_getQueryString(); // Query params in request, matching "path + query" has more priority
        if ($queryString) {
            $requestCases[] = $requestPath . $origSlash . '?' . $queryString;
            $requestCases[] = $requestPath . $altSlash . '?' . $queryString;
        }
        $requestCases[] = $requestPath . $origSlash;
        $requestCases[] = $requestPath . $altSlash;
        $this->loadByRequestPath($requestCases);
        /**
         * Try to find rewrite by request path at first, if no luck - try to find by id_path
         */
        if (!$this->getId() && isset($_GET['___from_store'])) {
            try {
                $fromStoreId = Mage::app()->getStore($_GET['___from_store'])->getId();
            } catch (Exception $e) {
                Mage::log($e->getMessage());
                return false;
            }

            $this->setStoreId($fromStoreId)->loadByRequestPath($requestCases);
            if (!$this->getId()) {
                return false;
            }
            $this->setStoreId(Mage::app()->getStore()->getId())->loadByIdPath($this->getIdPath());
        }

        if (!$this->getId()) {
            return false;
        }

        $storeId = Mage::app()->getStore()->getId();
        $kevinRewrite = Mage::getResourceModel('krewrite/krewrite')->getTargetPath($requestPath, $storeId);
        if ($kevinRewrite) {
            //get target Path rewrite
            $targetPath = Mage::getModel('krewrite/krewrite')->load($kevinRewrite)->getTargetPath();

            $request->setAlias(self::REWRITE_REQUEST_PATH_ALIAS, $this->getRequestPath());
            $external = substr($this->getTargetPath(), 0, 6);
            $isPermanentRedirectOption = $this->hasOptionRewrite('RP', $requestPath, $storeId);
            if ($external === 'http:/' || $external === 'https:') {
                if ($isPermanentRedirectOption) {
                    header('HTTP/1.1 301 Moved Permanently');
                }
                header("Location: " . $targetPath);
                exit;
            } else {

                $targetUrl = $request->getBaseUrl() . '/' . $this->getTargetPath();
            }
            $isRedirectOption = $this->hasOptionRewrite('R', $requestPath, $storeId);

            if ($isRedirectOption || $isPermanentRedirectOption) {
                if (Mage::getStoreConfig('web/url/use_store') && $storeCode = Mage::app()->getStore()->getCode()) {
                    $targetUrl = $request->getBaseUrl() . '/' . $storeCode . '/' . $this->getTargetPath();
                }
                if ($isPermanentRedirectOption) {
                    header('HTTP/1.1 301 Moved Permanently');
                }
                header('Location: ' . $targetPath);
                exit;
            }

            if (Mage::getStoreConfig('web/url/use_store') && $storeCode = Mage::app()->getStore()->getCode()) {
                $targetUrl = $request->getBaseUrl() . '/' . $storeCode . '/' . $this->getTargetPath();
            }

            $queryString = $this->_getQueryString();
            if ($queryString) {
                $targetUrl .= '?' . $queryString;
            }

            $this->redicrectProduct($targetUrl, $request->getRequestString());

            $request->setPathInfo($targetPath);
            return true;
        } else {
            //use default function of Magento
            $request->setAlias(self::REWRITE_REQUEST_PATH_ALIAS, $this->getRequestPath());
            $external = substr($this->getTargetPath(), 0, 6);
            $isPermanentRedirectOption = $this->hasOption('RP');
            if ($external === 'http:/' || $external === 'https:') {
                if ($isPermanentRedirectOption) {
                    header('HTTP/1.1 301 Moved Permanently');
                }
                header("Location: " . $this->getTargetPath());
                exit;
            } else {
                $targetUrl = $request->getBaseUrl() . '/' . $this->getTargetPath();
            }
            $isRedirectOption = $this->hasOption('R');
            if ($isRedirectOption || $isPermanentRedirectOption) {
                if (Mage::getStoreConfig('web/url/use_store') && $storeCode = Mage::app()->getStore()->getCode()) {
                    $targetUrl = $request->getBaseUrl() . '/' . $storeCode . '/' . $this->getTargetPath();
                }
                if ($isPermanentRedirectOption) {
                    header('HTTP/1.1 301 Moved Permanently');
                }
                header('Location: ' . $targetUrl);
                exit;
            }

            if (Mage::getStoreConfig('web/url/use_store') && $storeCode = Mage::app()->getStore()->getCode()) {
                $targetUrl = $request->getBaseUrl() . '/' . $storeCode . '/' . $this->getTargetPath();
            }

            $queryString = $this->_getQueryString();
            if ($queryString) {
                $targetUrl .= '?' . $queryString;
            }
            $this->redicrectProduct($targetUrl, $request->getRequestString());

            $request->setRequestUri($targetUrl);

            $request->setPathInfo($this->getTargetPath());

            return true;
        }
    }

    /*
     * Check redirect funtion 
     */

    public function hasOptionRewrite($value, $requestPath, $storeId) {
        return Mage::getResourceModel('krewrite/krewrite')->hasOptionRewrite($value, $requestPath, $storeId);
    }

    /*
     * Function redirect from product detail page
     */

    public function redicrectProduct($targetUrl, $pathInfo) {
        $isProductPage = strpos($targetUrl, "catalog/product/view");
        if ($isProductPage) {
            if (strpos($targetUrl, "category")) {
                $urlTemp = str_replace("/", "*", $pathInfo);
                $slash = strrpos($urlTemp, "*");
                $productTarget = substr($pathInfo, $slash + 1);
                $baseUrl = Mage::getBaseUrl();
                $targetUrlFinal = $baseUrl . $productTarget;
                header('HTTP/1.1 301 Moved Permanently');
                header("Location: " . $targetUrlFinal);
                exit;
            }
        }
    }

}
