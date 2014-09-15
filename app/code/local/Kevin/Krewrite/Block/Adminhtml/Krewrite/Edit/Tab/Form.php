<?php

class Kevin_Krewrite_Block_Adminhtml_Krewrite_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('krewrite_form', array('legend' => Mage::helper('krewrite')->__('URL Rewrite  information')));

        $fieldset->addField('request_path', 'text', array(
            'label' => Mage::helper('krewrite')->__('Request Path'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'request_path',
        ));
        $fieldset->addField('target_path', 'text', array(
            'label' => Mage::helper('krewrite')->__('Target Path'),
            'required' => true,
            'name' => 'target_path',
//            'after_element_html' => '<small>Input absolute link when link to external site</small>'
        ));
        $fieldset->addField('options', 'select', array(
            'label' => Mage::helper('krewrite')->__('Redirect'),
            'title' => Mage::helper('krewrite')->__('Redirect'),
            'name' => 'options',
            'options' => array(
                '' => Mage::helper('krewrite')->__('No'),
                'R' => Mage::helper('krewrite')->__('Temporary (302)'),
                'RP' => Mage::helper('krewrite')->__('Permanent (301)'),
            ),
//            'value'     => $formValues['options']
        ));

        //Store view
        if (!Mage::app()->isSingleStoreMode()) {
            $fieldset->addField(
                'store_id', 'multiselect', array(
                    'name' => 'store_id[]',
                    'label' => Mage::helper('cms')->__('Store view'),
                    'title' => Mage::helper('cms')->__('Store view'),
                    'required' => true,
                    'values' => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
                )
            );
        }

        $fieldset->addField('description', 'textarea', array(
            'label' => Mage::helper('adminhtml')->__('Description'),
            'title' => Mage::helper('adminhtml')->__('Description'),
            'name' => 'description',
            'cols' => 20,
            'rows' => 5,
//            'value'     => $formValues['description'],
            'wrap' => 'soft'
        ));
        $fieldset->addField('is_external_link', 'select', array(
            'label' => Mage::helper('krewrite')->__('Link to external site'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'is_external_link',
            'values' => array(
                array('value' => 2, 'label' => 'No'),
                array('value' => 1, 'label' => 'Yes'),
            ),
        ));
        $fieldset->addField('is_secure', 'select', array(
            'label' => Mage::helper('krewrite')->__('Target link secure (https)'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'is_secure',
            'values' => array(
                array('value' => 2, 'label' => 'No'),
                array('value' => 1, 'label' => 'Yes'),
            ),
        ));

        $fieldset->addField('is_active', 'select', array(
            'label' => Mage::helper('krewrite')->__('Status'),
            'name' => 'is_active',
            'values' => array(
                array('value' => 1, 'label' => 'Enable'),
                array('value' => 2, 'label' => 'Disable'),
            ),
        ));

        if (Mage::getSingleton('adminhtml/session')->getKrewriteData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getKrewriteData());
            Mage::getSingleton('adminhtml/session')->setKrewriteData(null);
        } elseif (Mage::registry('krewrite_data')) {
            $form->setValues(Mage::registry('krewrite_data')->getData());
        }
        return parent::_prepareForm();
    }

}