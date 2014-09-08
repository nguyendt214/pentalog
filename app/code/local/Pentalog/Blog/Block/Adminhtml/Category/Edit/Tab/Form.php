<?php

/*
  @author: Kevin (ndotrong@pentalog.fr)
 */

class Pentalog_Blog_Block_Adminhtml_Category_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm() {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('category_form', array('legend' => Mage::helper('blog')->__('Category information')));
        //Name
        $fieldset->addField('name', 'text', array(
            'label' => Mage::helper('blog')->__('Name'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'name',
        ));
//        //Identifier
        $identifierUniqueText = Mage::helper('blog')->__("This value need unique");
        $identifierErrorMess = addslashes(Mage::helper('blog')->__("Please use only character: a-z, A-Z, 0-9, '-', '_' on this field."));
        $fieldset->addField(
                'identifier', 'text', array(
            'label' => Mage::helper('blog')->__('Identifier'),
            'class' => 'required-entry pentalog-blog-validate-identifier',
            'required' => true,
            'name' => 'identifier',
            'after_element_html' => '<span class="hint">' . $identifierUniqueText . '</span>'
            . "<script>
                        Validation.add(
                            'pentalog-blog-validate-identifier',
                            '" . $identifierErrorMess . "',
                            function(v, elm) {
                                var regex = new RegExp(/^[a-zA-Z0-9_-]+$/);
                                return v.match(regex);
                            }
                        );
                        </script>",
                )
        );
        //URL
        $urlUniqueText = Mage::helper('blog')->__("This value need unique");
        $urlErrorMess = addslashes(Mage::helper('blog')->__("Please use only character: a-z, A-Z, 0-9, '-', '_', '.' on this field."));
        $fieldset->addField(
                'url', 'text', array(
            'label' => Mage::helper('blog')->__('URL'),
            'class' => '',
            'name' => 'url',
            'after_element_html' => '<span class="hint">' . $urlUniqueText . '</span>',
                )
        );

        //Type
        $types = Mage::helper('blog')->getTypes();
        $typeList = array();
        if (count($types)) {
            foreach ($types as $type) {
                $typeList[] = array(
                    'label' => $type->getTitle(),
                    'value' => $type->getId()
                );
            }
            $fieldset->addField('type', 'select', array(
                'label' => Mage::helper('blog')->__('Display Type'),
                'name' => 'type',
                'values' => $typeList,
            ));
        }
        //Store view
        if (!Mage::app()->isSingleStoreMode()) {
            $fieldset->addField(
                    'store_id', 'multiselect', array(
                'name' => 'store_id[]',
                'label' => Mage::helper('cms')->__('Display On'),
                'title' => Mage::helper('cms')->__('Display On'),
                'required' => true,
                'values' => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
                    )
            );
        }
        //Image
        $fieldset->addField('image', 'image', array(
            'label' => Mage::helper('blog')->__('Image'),
            'required' => false,
            'name' => 'image',
            'note' => '(*.jpg, *.png, *.gif, *.png)',
        ));
        $config = Mage::getSingleton('cms/wysiwyg_config')->getConfig();
        //Description
        $fieldset->addField(
                'description', 'editor', array(
            'name' => 'description',
            'label' => Mage::helper('blog')->__('Description'),
            'title' => Mage::helper('blog')->__('Description'),
            'style' => 'width:550px; height:200px;',
            'config' => $config
                )
        );

        //Status
        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('blog')->__('Status'),
            'name' => 'status',
            'values' => array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('blog')->__('Enabled'),
                ),
                array(
                    'value' => 2,
                    'label' => Mage::helper('blog')->__('Disabled'),
                ),
            ),
        ));
        if (Mage::getSingleton('adminhtml/session')->getCategoryData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getCategoryData());
            Mage::getSingleton('adminhtml/session')->setCategoryData(null);
        } elseif (Mage::registry('category_data')) {
            $data = Mage::registry('category_data');
            $form->setValues($data);
        }
        return parent::_prepareForm();
    }

}
