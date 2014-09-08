<?php
/*
 * @author: Kevin (ndotrong@pentalog.fr)
 */

class Pentalog_Blog_Block_Adminhtml_Type_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct() {
        parent::__construct();
        $this->setId('typeGrid');
        $this->setDefaultSort('type_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection() {
        $collection = Mage::getModel('blog/type')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {
        $this->addColumn('type_id', array(
            'header' => Mage::helper('blog')->__('ID'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'type_id',
        ));
        $this->addColumn('title', array(
            'header' => Mage::helper('blog')->__('Title'),
            'align' => 'left',
            'index' => 'title',
        ));
        $this->addColumn('style_name', array(
            'header' => Mage::helper('blog')->__('Style file name'),
            'align' => 'left',
            'index' => 'style_name',
        ));

        $this->addColumn('action', array(
            'header' => Mage::helper('blog')->__('Action'),
            'width' => '100',
            'type' => 'action',
            'getter' => 'getId',
            'actions' => array(
                array(
                    'caption' => Mage::helper('blog')->__('Edit'),
                    'url' => array('base' => '*/*/edit'),
                    'field' => 'id'
                )
            ),
            'filter' => false,
            'sortable' => false,
            'index' => 'stores',
            'is_system' => true,
        ));

        $this->addExportType('*/*/exportCsv', Mage::helper('blog')->__('CSV'));
        $this->addExportType('*/*/exportXml', Mage::helper('blog')->__('XML'));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction() {
        $this->setMassactionIdField('type_id');
        $this->getMassactionBlock()->setFormFieldName('type');

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('blog')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('blog')->__('Are you sure?')
        ));
        return $this;
    }

    public function getRowUrl($row) {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

}
