<?php
/**
 * USAPoolDirect_Vendorrelation extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       USAPoolDirect
 * @package        USAPoolDirect_Vendorrelation
 * @copyright      Copyright (c) 2014
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Customervendorid admin grid block
 *
 * @category    USAPoolDirect
 * @package     USAPoolDirect_Vendorrelation
 * @author      Ultimate Module Creator
 */
class USAPoolDirect_Vendorrelation_Block_Adminhtml_Customervendorid_Grid
    extends Mage_Adminhtml_Block_Widget_Grid {
    /**
     * constructor
     * @access public
     * @author Ultimate Module Creator
     */
    public function __construct(){
        parent::__construct();
        $this->setId('customervendoridGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }
    /**
     * prepare collection
     * @access protected
     * @return USAPoolDirect_Vendorrelation_Block_Adminhtml_Customervendorid_Grid
     * @author Ultimate Module Creator
     */
    protected function _prepareCollection(){
        $collection = Mage::getModel('usapooldirect_vendorrelation/customervendorid')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    /**
     * prepare grid collection
     * @access protected
     * @return USAPoolDirect_Vendorrelation_Block_Adminhtml_Customervendorid_Grid
     * @author Ultimate Module Creator
     */
    protected function _prepareColumns(){
        $this->addColumn('entity_id', array(
            'header'    => Mage::helper('usapooldirect_vendorrelation')->__('Id'),
            'index'        => 'entity_id',
            'type'        => 'number'
        ));
        $this->addColumn('customervendor_id', array(
            'header'    => Mage::helper('usapooldirect_vendorrelation')->__('customervendor id'),
            'align'     => 'left',
            'index'     => 'customervendor_id',
        ));
        $this->addColumn('status', array(
            'header'    => Mage::helper('usapooldirect_vendorrelation')->__('Status'),
            'index'        => 'status',
            'type'        => 'options',
            'options'    => array(
                '1' => Mage::helper('usapooldirect_vendorrelation')->__('Enabled'),
                '0' => Mage::helper('usapooldirect_vendorrelation')->__('Disabled'),
            )
        ));
        if (!Mage::app()->isSingleStoreMode() && !$this->_isExport) {
            $this->addColumn('store_id', array(
                'header'=> Mage::helper('usapooldirect_vendorrelation')->__('Store Views'),
                'index' => 'store_id',
                'type'  => 'store',
                'store_all' => true,
                'store_view'=> true,
                'sortable'  => false,
                'filter_condition_callback'=> array($this, '_filterStoreCondition'),
            ));
        }
        $this->addColumn('created_at', array(
            'header'    => Mage::helper('usapooldirect_vendorrelation')->__('Created at'),
            'index'     => 'created_at',
            'width'     => '120px',
            'type'      => 'datetime',
        ));
        $this->addColumn('updated_at', array(
            'header'    => Mage::helper('usapooldirect_vendorrelation')->__('Updated at'),
            'index'     => 'updated_at',
            'width'     => '120px',
            'type'      => 'datetime',
        ));
        $this->addColumn('action',
            array(
                'header'=>  Mage::helper('usapooldirect_vendorrelation')->__('Action'),
                'width' => '100',
                'type'  => 'action',
                'getter'=> 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('usapooldirect_vendorrelation')->__('Edit'),
                        'url'   => array('base'=> '*/*/edit'),
                        'field' => 'id'
                    )
                ),
                'filter'=> false,
                'is_system'    => true,
                'sortable'  => false,
        ));
        $this->addExportType('*/*/exportCsv', Mage::helper('usapooldirect_vendorrelation')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('usapooldirect_vendorrelation')->__('Excel'));
        $this->addExportType('*/*/exportXml', Mage::helper('usapooldirect_vendorrelation')->__('XML'));
        return parent::_prepareColumns();
    }
    /**
     * prepare mass action
     * @access protected
     * @return USAPoolDirect_Vendorrelation_Block_Adminhtml_Customervendorid_Grid
     * @author Ultimate Module Creator
     */
    protected function _prepareMassaction(){
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('customervendorid');
        $this->getMassactionBlock()->addItem('delete', array(
            'label'=> Mage::helper('usapooldirect_vendorrelation')->__('Delete'),
            'url'  => $this->getUrl('*/*/massDelete'),
            'confirm'  => Mage::helper('usapooldirect_vendorrelation')->__('Are you sure?')
        ));
        $this->getMassactionBlock()->addItem('status', array(
            'label'=> Mage::helper('usapooldirect_vendorrelation')->__('Change status'),
            'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
            'additional' => array(
                'status' => array(
                        'name' => 'status',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => Mage::helper('usapooldirect_vendorrelation')->__('Status'),
                        'values' => array(
                                '1' => Mage::helper('usapooldirect_vendorrelation')->__('Enabled'),
                                '0' => Mage::helper('usapooldirect_vendorrelation')->__('Disabled'),
                        )
                )
            )
        ));
        return $this;
    }
    /**
     * get the row url
     * @access public
     * @param USAPoolDirect_Vendorrelation_Model_Customervendorid
     * @return string
     * @author Ultimate Module Creator
     */
    public function getRowUrl($row){
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
    /**
     * get the grid url
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function getGridUrl(){
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }
    /**
     * after collection load
     * @access protected
     * @return USAPoolDirect_Vendorrelation_Block_Adminhtml_Customervendorid_Grid
     * @author Ultimate Module Creator
     */
    protected function _afterLoadCollection(){
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
    /**
     * filter store column
     * @access protected
     * @param USAPoolDirect_Vendorrelation_Model_Resource_Customervendorid_Collection $collection
     * @param Mage_Adminhtml_Block_Widget_Grid_Column $column
     * @return USAPoolDirect_Vendorrelation_Block_Adminhtml_Customervendorid_Grid
     * @author Ultimate Module Creator
     */
    protected function _filterStoreCondition($collection, $column){
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }
        $collection->addStoreFilter($value);
        return $this;
    }
}
