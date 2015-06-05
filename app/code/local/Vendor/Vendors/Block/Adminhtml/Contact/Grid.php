<?php
/**
 * Vendor_Vendors extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category   	Vendor
 * @package		Vendor_Vendors
 * @copyright  	Copyright (c) 2014
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Contact admin grid block
 *
 * @category	Vendor
 * @package		Vendor_Vendors
 * @author Ultimate Module Creator
 */
class Vendor_Vendors_Block_Adminhtml_Contact_Grid extends Mage_Adminhtml_Block_Widget_Grid{
	/**
	 * constructor
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function __construct(){
		parent::__construct();
		$this->setId('contactGrid');
		$this->setDefaultSort('entity_id');
		$this->setDefaultDir('ASC');
		$this->setSaveParametersInSession(true);
		$this->setUseAjax(true);
	}
	/**
	 * prepare collection
	 * @access protected
	 * @return Vendor_Vendors_Block_Adminhtml_Contact_Grid
	 * @author Ultimate Module Creator
	 */
	protected function _prepareCollection(){
		$collection = Mage::getModel('vendors/contact')->getCollection();
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}
	/**
	 * prepare grid collection
	 * @access protected
	 * @return Vendor_Vendors_Block_Adminhtml_Contact_Grid
	 * @author Ultimate Module Creator
	 */
	protected function _prepareColumns(){
		$this->addColumn('entity_id', array(
			'header'	=> Mage::helper('vendors')->__('Id'),
			'index'		=> 'entity_id',
			'type'		=> 'number'
		));
		$this->addColumn('firstname', array(
			'header'=> Mage::helper('vendors')->__('First Name'),
			'index' => 'firstname',
			'type'	 	=> 'text',

		));
		$this->addColumn('lastname', array(
			'header'=> Mage::helper('vendors')->__('Last Name'),
			'index' => 'lastname',
			'type'	 	=> 'text',

		));
		$this->addColumn('title', array(
			'header'=> Mage::helper('vendors')->__('Title'),
			'index' => 'title',
			'type'	 	=> 'text',

		));
		$this->addColumn('officeno', array(
			'header'=> Mage::helper('vendors')->__('Office #'),
			'index' => 'officeno',
			'type'	 	=> 'text',

		));
		$this->addColumn('mobileno', array(
			'header'=> Mage::helper('vendors')->__('Mobile #'),
			'index' => 'mobileno',
			'type'	 	=> 'text',

		));
		$this->addColumn('email', array(
			'header'=> Mage::helper('vendors')->__('Email'),
			'index' => 'email',
			'type'	 	=> 'text',

		));
		$this->addColumn('primary', array(
			'header'=> Mage::helper('vendors')->__('Primary'),
			'index' => 'primary',
			'type'		=> 'options',
			'options'	=> array(
				'1' => Mage::helper('vendors')->__('Yes'),
				'0' => Mage::helper('vendors')->__('No'),
			)

		));
		$this->addColumn('status', array(
			'header'	=> Mage::helper('vendors')->__('Status'),
			'index'		=> 'status',
			'type'		=> 'options',
			'options'	=> array(
				'1' => Mage::helper('vendors')->__('Enabled'),
				'0' => Mage::helper('vendors')->__('Disabled'),
			)
		));
		if (!Mage::app()->isSingleStoreMode()) {
			$this->addColumn('store_id', array(
				'header'=> Mage::helper('vendors')->__('Store Views'),
				'index' => 'store_id',
				'type'  => 'store',
				'store_all' => true,
				'store_view'=> true,
				'sortable'  => false,
				'filter_condition_callback'=> array($this, '_filterStoreCondition'),
			));
		}
		$this->addColumn('created_at', array(
			'header'	=> Mage::helper('vendors')->__('Created at'),
			'index' 	=> 'created_at',
			'width' 	=> '120px',
			'type'  	=> 'datetime',
		));
		$this->addColumn('updated_at', array(
			'header'	=> Mage::helper('vendors')->__('Updated at'),
			'index' 	=> 'updated_at',
			'width' 	=> '120px',
			'type'  	=> 'datetime',
		));
		$this->addColumn('action',
			array(
				'header'=>  Mage::helper('vendors')->__('Action'),
				'width' => '100',
				'type'  => 'action',
				'getter'=> 'getId',
				'actions'   => array(
					array(
						'caption'   => Mage::helper('vendors')->__('Edit'),
						'url'   => array('base'=> '*/*/edit'),
						'field' => 'id'
					)
				),
				'filter'=> false,
				'is_system'	=> true,
				'sortable'  => false,
		));
		$this->addExportType('*/*/exportCsv', Mage::helper('vendors')->__('CSV'));
		$this->addExportType('*/*/exportExcel', Mage::helper('vendors')->__('Excel'));
		$this->addExportType('*/*/exportXml', Mage::helper('vendors')->__('XML'));
		return parent::_prepareColumns();
	}
	/**
	 * prepare mass action
	 * @access protected
	 * @return Vendor_Vendors_Block_Adminhtml_Contact_Grid
	 * @author Ultimate Module Creator
	 */
	protected function _prepareMassaction(){
		$this->setMassactionIdField('entity_id');
		$this->getMassactionBlock()->setFormFieldName('contact');
		$this->getMassactionBlock()->addItem('delete', array(
			'label'=> Mage::helper('vendors')->__('Delete'),
			'url'  => $this->getUrl('*/*/massDelete'),
			'confirm'  => Mage::helper('vendors')->__('Are you sure?')
		));
		$this->getMassactionBlock()->addItem('status', array(
			'label'=> Mage::helper('vendors')->__('Change status'),
			'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
			'additional' => array(
				'status' => array(
						'name' => 'status',
						'type' => 'select',
						'class' => 'required-entry',
						'label' => Mage::helper('vendors')->__('Status'),
						'values' => array(
								'1' => Mage::helper('vendors')->__('Enabled'),
								'0' => Mage::helper('vendors')->__('Disabled'),
						)
				)
			)
		));
		$this->getMassactionBlock()->addItem('primary', array(
			'label'=> Mage::helper('vendors')->__('Change Primary'),
			'url'  => $this->getUrl('*/*/massPrimary', array('_current'=>true)),
			'additional' => array(
				'flag_primary' => array(
						'name' => 'flag_primary',
						'type' => 'select',
						'class' => 'required-entry',
						'label' => Mage::helper('vendors')->__('Primary'),
						'values' => array(
								'1' => Mage::helper('vendors')->__('Yes'),
								'0' => Mage::helper('vendors')->__('No'),
						)
				)
			)
		));
		return $this;
	}
	/**
	 * get the row url
	 * @access public
	 * @param Vendor_Vendors_Model_Contact
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
	 * @return Vendor_Vendors_Block_Adminhtml_Contact_Grid
	 * @author Ultimate Module Creator
	 */
	protected function _afterLoadCollection(){
		$this->getCollection()->walk('afterLoad');
		parent::_afterLoadCollection();
	}
	/**
	 * filter store column
	 * @access protected
	 * @param Vendor_Vendors_Model_Resource_Contact_Collection $collection
	 * @param Mage_Adminhtml_Block_Widget_Grid_Column $column
	 * @return Vendor_Vendors_Block_Adminhtml_Contact_Grid
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