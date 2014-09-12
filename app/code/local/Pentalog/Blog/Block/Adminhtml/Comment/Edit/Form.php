<?php

/*
  @author: Kevin (ndotrong@pentalog.fr)
 */

class Pentalog_Blog_Block_Adminhtml_Comment_Edit_Form extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm() {
        $form = new Varien_Data_Form(
                array(
            'id' => 'edit_form',
            'action' => $this->getUrl(
                    '*/*/save', array('id' => $this->getRequest()->getParam('id'))
            ),
            'method' => 'post',
                )
        );
        $form->setUseContainer(true);
        $this->setForm($form);

        $fieldset = $form->addFieldset('comment_form', array('legend' => Mage::helper('blog')->__('Comment information')));
        //Title
        $fieldset->addField('title', 'text', array(
            'label' => Mage::helper('blog')->__('Title'),
            'name' => 'title',
        ));
        $fieldset->addField('blog_id', 'text', array(
            'label' => Mage::helper('blog')->__('Article ID'),
            'name' => 'blog_id',
            'disabled' => 'disabled'
        ));

        $fieldset->addField('user_name', 'text', array(
            'label' => Mage::helper('blog')->__('User Name'),
            'name' => 'user_name',
            'disabled' => 'disabled'
        ));

        $fieldset->addField('user_email', 'text', array(
            'label' => Mage::helper('blog')->__('User Name'),
            'name' => 'user_email',
            'disabled' => 'disabled'
        ));

        $fieldset->addField('user_telephone', 'text', array(
            'label' => Mage::helper('blog')->__('User Telephone'),
            'name' => 'user_telephone',
            'disabled' => 'disabled'
        ));

        //content
        $fieldset->addField(
            'content', 'editor', array(
                'name' => 'content',
                'label' => Mage::helper('blog')->__('Content'),
                'title' => Mage::helper('blog')->__('Content'),
                'style' => 'width:550px; height:200px;',
            )
        );

        //Status
        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('blog')->__('Status'),
            'name' => 'status',
            'values' => array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('blog')->__('Approved'),
                ),
                array(
                    'value' => 2,
                    'label' => Mage::helper('blog')->__('Pending'),
                ),
            ),
        ));

        if (Mage::getSingleton('adminhtml/session')->getCommentData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getCommentData());
            Mage::getSingleton('adminhtml/session')->getCommentData(null);
        } elseif (Mage::registry('comment_data')) {
            $data = Mage::registry('comment_data');
            $form->setValues($data);
        }
        return parent::_prepareForm();
    }

}
