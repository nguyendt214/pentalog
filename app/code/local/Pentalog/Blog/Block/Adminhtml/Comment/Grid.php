<?php
/*
 * @author: Kevin (ndotrong@pentalog.fr)
 */

class Pentalog_Blog_Block_Adminhtml_Comment_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct() {
        parent::__construct();
        $this->setId('commentGrid');
        $this->setDefaultSort('comment_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection() {
        $collection = Mage::getModel('blog/comment')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {
        $this->addColumn('comment_id', array(
            'header' => Mage::helper('blog')->__('ID'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'comment_id',
        ));

        $this->addColumn('blog_id', array(
            'header' => Mage::helper('blog')->__('Blog ID'),
            'align' => 'left',
            'index' => 'blog_id',
        ));

        $this->addColumn('title', array(
            'header' => Mage::helper('blog')->__('Title'),
            'align' => 'left',
            'index' => 'title',
        ));
        $this->addColumn('user_name', array(
            'header' => Mage::helper('blog')->__('User Name'),
            'align' => 'left',
            'index' => 'user_name',
        ));
        $this->addColumn('user_email', array(
            'header' => Mage::helper('blog')->__('User Email'),
            'align' => 'left',
            'index' => 'user_email',
        ));
        $this->addColumn('user_telephone', array(
            'header' => Mage::helper('blog')->__('User Telephone'),
            'align' => 'left',
            'index' => 'user_telephone',
        ));

        $this->addColumn(
                'created_time', array(
            'header' => Mage::helper('blog')->__('Created at'),
            'index' => 'created_time',
            'type' => 'datetime',
            'width' => '120px',
            'gmtoffset' => true,
            'default' => ' -- '
                )
        );
        $this->addColumn(
                'update_time', array(
            'header' => Mage::helper('blog')->__('Updated at'),
            'index' => 'update_time',
            'width' => '120px',
            'type' => 'datetime',
            'gmtoffset' => true,
            'default' => ' -- '
                )
        );
        $this->addColumn('status', array(
            'header' => Mage::helper('blog')->__('Status'),
            'align' => 'left',
            'width' => '80px',
            'index' => 'status',
            'type' => 'options',
            'options' => array(
                1 => 'Approved',
                2 => 'Pending',
            ),
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
        $this->setMassactionIdField('comment_id');
        $this->getMassactionBlock()->setFormFieldName('blog');

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('blog')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('blog')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('blog/commentstatus')->getOptionArray();

        array_unshift($statuses, array('label' => '', 'value' => ''));
        $this->getMassactionBlock()->addItem('status', array(
            'label' => Mage::helper('blog')->__('Change status'),
            'url' => $this->getUrl('*/*/massStatus', array('_current' => true)),
            'additional' => array(
                'visibility' => array(
                    'name' => 'status',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('blog')->__('Status'),
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
