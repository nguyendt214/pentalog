<?php

/*
 * @author: Kevin (ndotrong@pentalog.fr)
 * @return: Blog controller
 */

class Pentalog_Blog_Adminhtml_BlogController extends Mage_Adminhtml_Controller_action {

    protected function _initAction() {
        $this->loadLayout()
                ->_setActiveMenu('xpentalog/blog')
                ->_addBreadcrumb(Mage::helper('adminhtml')->__('Article Manager'), Mage::helper('adminhtml')->__('Article Manager'));

        return $this;
    }

    public function indexAction() {
        $this->setTitle(__("Article Management"));
        $this->_initAction()
                ->renderLayout();
    }

    public function editAction() {
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('blog/blog')->load($id);

        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }
            if ($model->getId()) {
                $this->setTitle(__("Edit Article"));
            } else {
                $this->setTitle(__("Add new Article"));
            }

            Mage::register('blog_data', $model);

            $this->loadLayout();
            $this->_setActiveMenu('xpentalog/blog');

            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

            $this->_addContent($this->getLayout()->createBlock('blog/adminhtml_blog_edit'))
                    ->_addLeft($this->getLayout()->createBlock('blog/adminhtml_blog_edit_tabs'));

            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('blog')->__('Article does not exist'));
            $this->_redirect('*/*/');
        }
    }

    public function newAction() {
        $this->_forward('edit');
    }

    public function saveAction() {
        if ($data = $this->getRequest()->getPost()) {
            //Delete image
            if (isset($data['image']['delete']) and $data['image']['delete'] == 1) {
                $data['image'] = '';
            } elseif (isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
                try {
                    $mediaDir = Mage::getBaseDir('media');
                    if (!is_dir($xpentalogDir = $mediaDir . DS . 'xpentalog')) {
                        mkdir($xpentalogDir);
                        @chmod($xpentalogDir, 0777);
                    }
                    if (!is_dir($xpentalogBlogDir = $mediaDir . DS . 'xpentalog' . DS . 'blog')) {
                        mkdir($xpentalogBlogDir);
                        @chmod($xpentalogBlogDir, 0777);
                    }
                    /* Starting upload */
                    $uploader = new Varien_File_Uploader('image');
                    // Any extention would work
                    $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
                    $uploader->setAllowRenameFiles(false);
                    $uploader->setFilesDispersion(false);
                    // We set media as the upload dir
                    $path = $mediaDir . DS . 'xpentalog' . DS . 'blog';
                    $uploader->save($path, $_FILES['image']['name']);

                    //init data to save in database
                    $data['image'] = 'xpentalog/blog/' . $_FILES['image']['name'];
                } catch (Exception $e) {
                    Mage::helper('blog')->pentalogLog("System don't support this file: " . $e->getMessage());
                }
            } else {
                unset($data['image']);
            }

            $model = Mage::getModel('blog/blog');
            $model->setData($data)
                    ->setId($this->getRequest()->getParam('id'));

            try {
                if ((int)$this->getRequest()->getParam('id') > 0) {
                    $model->setUpdateTime(Mage::getModel('core/date')->gmtDate());
                } else {
                    $model->setCreatedTime(Mage::getModel('core/date')->gmtDate());
                    $model->setUpdateTime(Mage::getModel('core/date')->gmtDate());
                }
                
                $model->save();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('blog')->__('Article was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('blog')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
    }

    public function deleteAction() {
        if ($this->getRequest()->getParam('id') > 0) {
            try {
                $model = Mage::getModel('blog/blog');

                $model->setId($this->getRequest()->getParam('id'))
                        ->delete();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Article was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }

    public function massDeleteAction() {
        $blogIds = $this->getRequest()->getParam('blog');
        if (!is_array($blogIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select article(s)'));
        } else {
            try {
                foreach ($blogIds as $blogId) {
                    $blog = Mage::getModel('blog/blog')->load($blogId);
                    $blog->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                        Mage::helper('adminhtml')->__(
                                'Total of %d record(s) were successfully deleted', count($blogIds)
                        )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function massStatusAction() {
        $blogIds = $this->getRequest()->getParam('blog');
        if (!is_array($blogIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select article(s)'));
        } else {
            try {
                foreach ($blogIds as $blogId) {
                    $blog = Mage::getSingleton('blog/blog')
                            ->load($blogId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                        $this->__('Total of %d record(s) were successfully updated', count($blogIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function exportCsvAction() {
        $fileName = 'article.csv';
        $content = $this->getLayout()->createBlock('blog/adminhtml_blog_grid')
                ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction() {
        $fileName = 'article.xml';
        $content = $this->getLayout()->createBlock('blog/adminhtml_blog_grid')
                ->getXml();

        $this->_sendUploadResponse($fileName, $content);
    }

    protected function _sendUploadResponse($fileName, $content, $contentType = 'application/octet-stream') {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK', '');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename=' . $fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }

    protected function setTitle($title) {
        $this->_title($title);
        return $this;
    }

    protected function _isAllowed() {
        return Mage::getSingleton('admin/session')->isAllowed('admin/xpentalog/blog/blog');
    }

}
