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
 * Manage Vendors admin grid block
 *
 * @category	Vendor
 * @package		Vendor_Vendors
 * @author Ultimate Module Creator
 */
class Vendor_Vendors_Block_Adminhtml_Managevendors_Grid extends Mage_Adminhtml_Block_Widget_Grid{
	/**
	 * constructor
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function __construct(){
		parent::__construct();
		$this->setId('managevendorsGrid');
		$this->setDefaultSort('entity_id');
		$this->setDefaultDir('ASC');
		$this->setSaveParametersInSession(true);
		$this->setUseAjax(true);
	}
	/**
	 * prepare collection
	 * @access protected
	 * @return Vendor_Vendors_Block_Adminhtml_Managevendors_Grid
	 * @author Ultimate Module Creator
	 */
	protected function _prepareCollection(){
		$collection = Mage::getModel('vendors/managevendors')->getCollection();
		/*$select = $collection->getSelect();
		$select->where("order_id = ?", $this->getRequest()->getParam('order_id'));*/
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}
	/**
	 * prepare grid collection
	 * @access protected
	 * @return Vendor_Vendors_Block_Adminhtml_Managevendors_Grid
	 * @author Ultimate Module Creator
	 */
	protected function _prepareColumns(){
		
		$this->addColumn('vendorname', array(
			'header'=> Mage::helper('vendors')->__('Vendor Name'),
			'index' => 'vendorname',
			'type'	 	=> 'text',

		));
		/*$this->addColumn('address', array(
			'header'=> Mage::helper('vendors')->__('Address'),
			'index' => 'address',
			'type'	 	=> 'text',

		));*/
		$this->addColumn('city', array(
			'header'=> Mage::helper('vendors')->__('City'),
			'index' => 'city',
			'type'	 	=> 'text',

		));
		$this->addColumn('statename', array(
				'header'=> Mage::helper('vendors')->__('State/Province'),
				'index' => 'statename',
				'type'	 	=> 'text',
		
		));
		$this->addColumn('zipcode', array(
			'header'=> Mage::helper('vendors')->__('Zip Code'),
			'index' => 'zipcode',
			'type'	 	=> 'text',

		));
		$this->addColumn('phoneno', array(
			'header'=> Mage::helper('vendors')->__('Phone'),
			'index' => 'phoneno',
			'type'	 	=> 'text',

		));
		
		$this->addColumn('primary_contact', array(
				'header'=> Mage::helper('vendors')->__('Primary Contact'),
				'index' => 'entity_id',
				'type'	 	=> 'text',
				'renderer'  => 'Vendor_Vendors_Block_Adminhtml_Managevendors_Renderer_Primarycontact',
		
		));
		
		$this->addColumn('primary_contact_office', array(
				'header'=> Mage::helper('vendors')->__('Primary Contact Office #'),
				'index' => 'entity_id',
				'type'	 	=> 'text',
				'renderer'  => 'Vendor_Vendors_Block_Adminhtml_Managevendors_Renderer_Primarycontactoffice',
		
		));
		
		$this->addColumn('primary_contact_cell', array(
				'header'=> Mage::helper('vendors')->__('Primary Contact Mobile #'),
				'index' => 'entity_id',
				'type'	 	=> 'text',
				'renderer'  => 'Vendor_Vendors_Block_Adminhtml_Managevendors_Renderer_Primarycontactmob',
		
		));
		
		$this->addColumn('insuranceonfile', array(
			'header'=> Mage::helper('vendors')->__('Insurance'),
			'index' => 'insuranceonfile',
			'type'		=> 'options',
			'options'	=> array(
				'1' => Mage::helper('vendors')->__('Yes'),
				'0' => Mage::helper('vendors')->__('No'),
				'2' => Mage::helper('vendors')->__('N/A'),
			),
			'renderer'  => 'Vendor_Vendors_Block_Adminhtml_Managevendors_Renderer_Red',

		));
		
		/*$this->addColumn('specialty', array(
			'header'=> Mage::helper('vendors')->__('Specialty'),
			'index' => 'specialty',
			'type'	 	=> 'text',

		));*/
		/*$this->addColumn('status', array(
			'header'	=> Mage::helper('vendors')->__('Status'),
			'index'		=> 'status',
			'type'		=> 'options',
			'options'	=> array(
				'1' => Mage::helper('vendors')->__('Enabled'),
				'0' => Mage::helper('vendors')->__('Disabled'),
			)
		));*/
		$this->addColumn('manufacturer', array(
				'header'=> Mage::helper('vendors')->__('Role'),
				'index' => 'manufacturer',
				'type'	 	=> 'text',
				'renderer'  => 'Vendor_Vendors_Block_Adminhtml_Managevendors_Renderer_Role',
		
		));
		$this->addColumn('active', array(
				'header'=> Mage::helper('vendors')->__('Status'),
				'index' => 'active',
				'type'		=> 'options',
				'options'	=> array(
						'1' => Mage::helper('vendors')->__('Enabled'),
						'0' => Mage::helper('vendors')->__('Disabled'),
				)
		
		));
		
		$this->addColumn('action',
			array(
				'header'=>  Mage::helper('vendors')->__('Action'),
				'width' => '10',
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
				'align' => 'center',
				'header_css_class'=>'custom-center',	
		));
		$this->addExportType('*/*/exportCsv', Mage::helper('vendors')->__('CSV'));
		$this->addExportType('*/*/exportExcel', Mage::helper('vendors')->__('Excel'));
		$this->addExportType('*/*/exportXml', Mage::helper('vendors')->__('XML'));
		return parent::_prepareColumns();
	}
	/**
	 * prepare mass action
	 * @access protected
	 * @return Vendor_Vendors_Block_Adminhtml_Managevendors_Grid
	 * @author Ultimate Module Creator
	 */
	protected function _prepareMassaction(){
		$this->setMassactionIdField('entity_id');
		$this->getMassactionBlock()->setFormFieldName('managevendors');
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
		$this->getMassactionBlock()->addItem('active', array(
			'label'=> Mage::helper('vendors')->__('Change Active'),
			'url'  => $this->getUrl('*/*/massActive', array('_current'=>true)),
			'additional' => array(
				'flag_active' => array(
						'name' => 'flag_active',
						'type' => 'select',
						'class' => 'required-entry',
						'label' => Mage::helper('vendors')->__('Active'),
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
	 * @param Vendor_Vendors_Model_Managevendors
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
	 * @return Vendor_Vendors_Block_Adminhtml_Managevendors_Grid
	 * @author Ultimate Module Creator
	 */
	protected function _afterLoadCollection(){
		$this->getCollection()->walk('afterLoad');
		parent::_afterLoadCollection();
	}
	/**
	 * filter store column
	 * @access protected
	 * @param Vendor_Vendors_Model_Resource_Managevendors_Collection $collection
	 * @param Mage_Adminhtml_Block_Widget_Grid_Column $column
	 * @return Vendor_Vendors_Block_Adminhtml_Managevendors_Grid
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