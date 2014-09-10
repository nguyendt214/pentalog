<?php

class Pentalog_Blog_Block_Adminhtml_Blog_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm() {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('blog_form', array('legend' => Mage::helper('blog')->__('Article information')));
        //Title
        $fieldset->addField('title', 'text', array(
            'label' => Mage::helper('blog')->__('Title'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'title',
        ));
        //Identifier
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
            'class' => 'pentalog-blog-validate-url',
            'required' => true,
            'name' => 'url',
            'after_element_html' => '<span class="hint">' . $urlUniqueText . '</span>'
            . "<script>
                        Validation.add(
                            'pentalog-blog-validate-url',
                            '" . $urlErrorMess . "',
                            function(v, elm) {
                                var regex = new RegExp(/^[.a-zA-Z0-9_-]+$/);
                                return v.match(regex);
                            }
                        );
                        </script>",
                )
        );
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
        //Category
        $categoriesCollection = Mage::helper('blog')->getCategories();
        $categories = array();
        if (count($categoriesCollection)) {
            foreach ($categoriesCollection as $catogory) {
                $categories[] = array(
                    'label' => $catogory->getName(),
                    'value' => $catogory->getId()
                );
            }
            $fieldset->addField(
                    'category_id', 'multiselect', array(
                'name' => 'category_id[]',
                'label' => Mage::helper('blog')->__('Category'),
                'title' => Mage::helper('blog')->__('Category'),
                'required' => true,
                'style' => 'height: 120px;',
                'values' => $categories,
                    )
            );
        }
        //Short Description
        $config = Mage::getSingleton('cms/wysiwyg_config')->getConfig();
        $fieldset->addField(
                'short_description', 'editor', array(
            'name' => 'short_description',
            'label' => Mage::helper('blog')->__('Short Description'),
            'title' => Mage::helper('blog')->__('Short Description'),
            'style' => 'width:550px; height:100px;',
            'config' => $config,
                )
        );
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
        //Author
        $fieldset->addField('author', 'text', array(
            'label' => Mage::helper('blog')->__('Author'),
            'name' => 'author',
        ));
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
        if (Mage::getSingleton('adminhtml/session')->getBlogData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getBlogData());
            Mage::getSingleton('adminhtml/session')->setBlogData(null);
        } elseif (Mage::registry('blog_data')) {
            $data = Mage::registry('blog_data');
            if (empty($data->getAuthor())) {
                $data->setAuthor(Mage::getSingleton('admin/session')->getUser()->getName());
            }
            $form->setValues($data);
        }
        return parent::_prepareForm();
    }

}
