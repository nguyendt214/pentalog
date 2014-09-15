<?php

/**
 * Adminhtml urlrewrite grid block
 *
 * @category   Mage
 * @package    Kevin Rewrite URL
 * @author     ndotrong@pentalog.fr
 * @purpose :  add new function allow admin delete url reqrite 
 */
class Kevin_Krewrite_Block_Adminhtml_Urlrewrite_Grid extends Mage_Adminhtml_Block_Urlrewrite_Grid {

    public function __construct() {
        parent::__construct();
        $this->setId('urlrewriteGrid');
        $this->setDefaultSort('url_rewrite_id');
        $this->setSaveParametersInSession(false);
    }

    protected function _prepareCollection() {
        $collection = Mage::getResourceModel('core/url_rewrite_collection');
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {
        $this->addColumn('url_rewrite_id', array(
            'header' => $this->__('ID'),
            'width' => '50px',
            'index' => 'url_rewrite_id'
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('store_id', array(
                'header' => $this->__('Store View'),
                'width' => '200px',
                'index' => 'store_id',
                'type' => 'store',
                'store_view' => true,
            ));
        }

        $this->addColumn('is_system', array(
            'header' => $this->__('Type'),
            'width' => '50px',
            'index' => 'is_system',
            'type' => 'options',
            'options' => array(
                1 => $this->__('System'),
                0 => $this->__('Custom')
            ),
        ));

        $this->addColumn('id_path', array(
            'header' => $this->__('ID Path'),
            'width' => '50px',
            'index' => 'id_path'
        ));
        $this->addColumn('request_path', array(
            'header' => $this->__('Request Path'),
            'width' => '50px',
            'index' => 'request_path'
        ));
        $this->addColumn('target_path', array(
            'header' => $this->__('Target Path'),
            'width' => '50px',
            'index' => 'target_path'
        ));
        $this->addColumn('options', array(
            'header' => $this->__('Options'),
            'width' => '50px',
            'index' => 'options'
        ));
        $this->addColumn('actions', array(
            'header' => $this->__('Action'),
            'width' => '15px',
            'sortable' => false,
            'filter' => false,
            'type' => 'action',
            'actions' => array(
                array(
                    'url' => $this->getUrl('*/*/edit') . 'id/$url_rewrite_id',
                    'caption' => $this->__('Edit'),
                ),
            )
        ));
        return $this;
    }

    public function getRowUrl($row) {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
        //return $this->getUrl('*/*/view', array('id' => $row->getId()));
    }

    protected function _prepareMassaction() {
        parent::_prepareMassaction();
        $this->setMassactionIdField('url_rewrite_id'); 
        $this->getMassactionBlock()->setFormFieldName('kevin_url'); 
        // Append new mass action option
        $this->getMassactionBlock()->addItem(
            'krewrite',
            array('label' => $this->__('Delete'),
                  'url'   => $this->getUrl('*/*/massDelete'), //this should be the url where there will be mass operation
                 'confirm' => Mage::helper('krewrite')->__('Are you sure?')
            )
        );
        return $this;
    }

}

