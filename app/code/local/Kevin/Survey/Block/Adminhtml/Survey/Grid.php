<?php

class Kevin_Survey_Block_Adminhtml_Survey_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct() {
        parent::__construct();
        $this->setId('kevinSurveyGrid');
        $this->setDefaultSort('survey_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection() {
        $collection = Mage::getModel('survey/survey')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _getStore() {
        $storeId = (int) $this->getRequest()->getParam('store', 0);
        return Mage::app()->getStore($storeId);
    }

    protected function _prepareColumns() {
        $this->addColumn('survey_id', array(
            'header' => Mage::helper('survey')->__('ID'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'survey_id',
        ));

        $this->addColumn('status', array(
            'header' => Mage::helper('survey')->__('Status'),
            'align' => 'left',
            'width' => '80px',
            'index' => 'status',
            'type' => 'options',
            'options' => Mage::getSingleton('all/status')->getOptionArray(),
        ));

        $this->addColumn('action', array(
            'header' => Mage::helper('survey')->__('Action'),
            'width' => '100',
            'type' => 'action',
            'getter' => 'getId',
            'actions' => array(
                array(
                    'caption' => Mage::helper('survey')->__('Edit'),
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
        return $this;
    }

    public function getRowUrl($row) {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

}