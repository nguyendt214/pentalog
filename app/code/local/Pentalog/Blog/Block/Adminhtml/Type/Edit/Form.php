<?php

/*
  @author: Kevin (ndotrong@pentalog.fr)
 */

class Pentalog_Blog_Block_Adminhtml_Type_Edit_Form extends Mage_Adminhtml_Block_Widget_Form {

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

        $fieldset = $form->addFieldset('type_form', array('legend' => Mage::helper('blog')->__('Type information')));
        //Title
        $fieldset->addField('title', 'text', array(
            'label' => Mage::helper('blog')->__('Title'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'title',
        ));

        //Title
        $fieldset->addField('style_name', 'text', array(
            'label' => Mage::helper('blog')->__('Style file name'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'style_name',
        ));
        if (Mage::getSingleton('adminhtml/session')->getTypeData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getTypeData());
            Mage::getSingleton('adminhtml/session')->setTypeData(null);
        } elseif (Mage::registry('type_data')) {
            $data = Mage::registry('type_data');
            $form->setValues($data);
        }
        return parent::_prepareForm();
    }

}
