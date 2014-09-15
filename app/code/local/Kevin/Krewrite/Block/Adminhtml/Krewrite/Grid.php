<?php

class Kevin_Krewrite_Block_Adminhtml_Krewrite_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct() {
        parent::__construct();
        $this->setId('kevinRewriteGrid');
        $this->setDefaultSort('krewrite_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection() {
        $collection = Mage::getModel('krewrite/krewrite')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _getStore() {
        $storeId = (int) $this->getRequest()->getParam('store', 0);
        return Mage::app()->getStore($storeId);
    }

    protected function _prepareColumns() {
        $this->addColumn('krewrite_id', array(
            'header' => Mage::helper('krewrite')->__('ID'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'krewrite_id',
        ));

        $this->addColumn('request_path', array(
            'header' => Mage::helper('krewrite')->__('URL Request'),
            'align' => 'left',
            'index' => 'request_path',
        ));

        $this->addColumn('target_path', array(
            'header' => Mage::helper('krewrite')->__('URL Target'),
            'align' => 'left',
            'index' => 'target_path',
        ));

        $this->addColumn('options', array(
            'header'    => $this->__('Options'),
            'width'     => '50px',
            'index'     => 'options'
        ));

//        if (!Mage::app()->isSingleStoreMode()) {
//            $this->addColumn('store_id', array(
//                'header'    => $this->__('Store View'),
//                'width'     => '200px',
//                'index'     => 'store_id',
//                'type'      => 'store',
//                'store_view' => true,
//            ));
//        }

        $this->addColumn('is_external_link', array(
            'header' => Mage::helper('krewrite')->__('Link to external site'),
            'align' => 'left',
            'width' => '80px',
            'index' => 'is_external_link',
            'type' => 'options',
            'options' => Mage::getSingleton('krewrite/option_status')->getLinkArray(),
        ));

        $this->addColumn('is_secure', array(
            'header' => Mage::helper('krewrite')->__('Target link secure (https)'),
            'align' => 'left',
            'width' => '80px',
            'index' => 'is_secure',
            'type' => 'options',
            'options' => Mage::getSingleton('krewrite/option_status')->getLinkArray(),
        ));

        $this->addColumn('is_active', array(
            'header' => Mage::helper('krewrite')->__('Status'),
            'align' => 'left',
            'width' => '80px',
            'index' => 'is_active',
            'type' => 'options',
            'options' => Mage::getSingleton('krewrite/option_status')->getOptionArray(),
        ));

        $this->addColumn('action', array(
            'header' => Mage::helper('krewrite')->__('Action'),
            'width' => '100',
            'type' => 'action',
            'getter' => 'getId',
            'actions' => array(
                array(
                    'caption' => Mage::helper('krewrite')->__('Edit'),
                    'url' => array('base' => '*/*/edit'),
                    'field' => 'id'
                )
            ),
            'filter' => false,
            'sortable' => false,
            'index' => 'stores',
            'is_system' => true,
        ));
        return parent::_prepareColumns();
    }

    protected function _prepareMassaction() {
        $this->setMassactionIdField('krewrite_id');
        $this->getMassactionBlock()->setFormFieldName('krewrite');

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('krewrite')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('krewrite')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('krewrite/option_status')->getOptionArray();

        array_unshift($statuses, array('label' => '', 'value' => ''));
        $this->getMassactionBlock()->addItem('is_active', array(
            'label' => Mage::helper('krewrite')->__('Change status'),
            'url' => $this->getUrl('*/*/massStatus', array('_current' => true)),
            'additional' => array(
                'visibility' => array(
                    'name' => 'is_active',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('krewrite')->__('Status'),
                    'values' => $statuses
                )
            )
        ));
        return $this;
    }

    public function getRowUrl($row) {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

}