<?php
/**
 * Vendor_Vendorpricing extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category   	Vendor
 * @package		Vendor_Vendorpricing
 * @copyright  	Copyright (c) 2014
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Vendor Pricing admin grid block
 *
 * @category	Vendor
 * @package		Vendor_Vendorpricing
 * @author Ultimate Module Creator
 */
class Vendor_Vendorpricing_Block_Adminhtml_Vendorpricing_Grid extends Mage_Adminhtml_Block_Widget_Grid{
	/**
	 * constructor
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function __construct(){
		parent::__construct();
		/*$this->setPagerVisibility(false);
		$this->setFilterVisibility(false);*/
		$this->setId('vendorpricingGrid');
		$this->setDefaultSort('entity_id');
		$this->setDefaultDir('ASC');
		$this->setSaveParametersInSession(true);
		$this->setUseAjax(true);
		
	}
	/**
	 * prepare collection
	 * @access protected
	 * @return Vendor_Vendorpricing_Block_Adminhtml_Vendorpricing_Grid
	 * @author Ultimate Module Creator
	 */
	protected function _prepareCollection(){
		
		$collection = Mage::getModel('vendorpricing/vendorpricing')->getCollection();
		$select = $collection->getSelect();
		$select->where("vendor_id = ?", $this->getRequest()->getParam('id'));
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}
	/**
	 * prepare grid collection
	 * @access protected
	 * @return Vendor_Vendorpricing_Block_Adminhtml_Vendorpricing_Grid
	 * @author Ultimate Module Creator
	 */
	protected function _prepareColumns(){
		$this->addColumn('entity_id', array(
			'header'	=> Mage::helper('vendorpricing')->__('Id'),
			'index'		=> 'entity_id',
			'type'		=> 'number',
			'sortable'  => false,
		));
		$this->addColumn('part_number', array(
			'header'=> Mage::helper('vendorpricing')->__('Part Number'),
			'index' => 'part_number',
			'type'	 	=> 'text',
			'sortable'  => false,

		));
		$this->addColumn('part_description', array(
				'header'=> Mage::helper('vendorpricing')->__('Part Description'),
				'index' => 'part_description',
				'type'	 	=> 'textarea',
				'sortable'  => false,
		
		));
		$this->addColumn('vendor_part_number', array(
				'header'=> Mage::helper('vendorpricing')->__('Vendor Part Number'),
				'index' => 'vendor_part_number',
				'type'	 	=> 'text',
				'sortable'  => false,
		
		));
		$this->addColumn('vendor_cost', array(
				'header'=> Mage::helper('vendorpricing')->__('Vendor Cost'),
				'index' => 'vendor_cost',
				'type'	 	=> 'textarea',
				'sortable'  => false,
		
		));
		$this->addColumn('vendor_descritption', array(
				'header'=> Mage::helper('vendorpricing')->__('Vendor Descritption'),
				'index' => 'vendor_descritption',
				'type'	 	=> 'textarea',
				'sortable'  => false,
		
		));
		
		$this->addColumn('action',
			array(
				'header'=>  Mage::helper('vendorpricing')->__('Action'),
				'width' => '10',
				'type'  => 'action',
				'getter'=> 'getId',
				'actions'   => array(
					array(
						'caption'   => Mage::helper('vendorpricing')->__('Edit'),
						'url'   => array('base'=> '/vendorpricing_vendorpricing/edit/vendor_id/'.$this->getRequest()->getParam('id')),
						'field' => 'id'
					)
				),
				'filter'=> false,
				'is_system'	=> true,
				'sortable'  => false,
				'align' => 'center',
				'header_css_class'=>'custom-center',		
		));
		/*$redirectBack   = $this->getRequest()->getParam('back', false);
		
		if ($redirectBack) {
			$this->_redirect('edit', array(
					'id'    => $productId,
					'_current'=>true
			));
		}*/
		$this->addExportType('/vendorpricing_vendorpricing/exportCsv', Mage::helper('vendorpricing')->__('CSV'));
		$this->addExportType('/vendorpricing_vendorpricing/exportExcel', Mage::helper('vendorpricing')->__('Excel'));
		$this->addExportType('/vendorpricing_vendorpricing/exportXml', Mage::helper('vendorpricing')->__('XML'));
		return parent::_prepareColumns();
	}
	/**
	 * prepare mass action
	 * @access protected
	 * @return Vendor_Vendorpricing_Block_Adminhtml_Vendorpricing_Grid
	 * @author Ultimate Module Creator
	 */
	protected function _prepareMassaction(){
		/*$this->setMassactionIdField('entity_id');
		$this->getMassactionBlock()->setFormFieldName('vendorpricing');
		$this->getMassactionBlock()->addItem('delete', array(
			'label'=> Mage::helper('vendorpricing')->__('Delete'),*/
			//'url'  => $this->getUrl('*/*/massDelete'),
			/*'confirm'  => Mage::helper('vendorpricing')->__('Are you sure?')
		));
		$this->getMassactionBlock()->addItem('status', array(
			'label'=> Mage::helper('vendorpricing')->__('Change status'),*/
			//'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
			/*'additional' => array(
				'status' => array(
						'name' => 'status',
						'type' => 'select',
						'class' => 'required-entry',
						'label' => Mage::helper('vendorpricing')->__('Status'),
						'values' => array(
								'1' => Mage::helper('vendorpricing')->__('Enabled'),
								'0' => Mage::helper('vendorpricing')->__('Disabled'),
						)
				)
			)
		));
		$this->getMassactionBlock()->addItem('products', array(
			'label'=> Mage::helper('vendorpricing')->__('Change Product'),*/
			//'url'  => $this->getUrl('*/*/massProducts', array('_current'=>true)),
			/*'additional' => array(
				'flag_products' => array(
						'name' => 'flag_products',
						'type' => 'select',
						'class' => 'required-entry',
						'label' => Mage::helper('vendorpricing')->__('Product'),
						'values' => array(
								'1' => Mage::helper('vendorpricing')->__('Yes'),
								'0' => Mage::helper('vendorpricing')->__('No'),
						)
				)
			)
		));*/
		return $this;
	}
	/**
	 * get the row url
	 * @access public
	 * @param Vendor_Vendorpricing_Model_Vendorpricing
	 * @return string
	 * @author Ultimate Module Creator
	 */
	public function getRowUrl($row){
		return $this->getUrl('/vendorpricing_vendorpricing/edit', array('id' => $row->getId(),'vendor_id'=>$this->getRequest()->getParam('id')));
	}
	/**
	 * get the grid url
	 * @access public
	 * @return string
	 * @author Ultimate Module Creator
	 */
	public function getGridUrl(){
		return $this->getUrl('/vendorpricing_vendorpricing/grid', array('_current'=>true));
	}
	/**
	 * after collection load
	 * @access protected
	 * @return Vendor_Vendorpricing_Block_Adminhtml_Vendorpricing_Grid
	 * @author Ultimate Module Creator
	 */
	protected function _afterLoadCollection(){
		$this->getCollection()->walk('afterLoad');
		parent::_afterLoadCollection();
	}
	/**
	 * filter store column
	 * @access protected
	 * @param Vendor_Vendorpricing_Model_Resource_Vendorpricing_Collection $collection
	 * @param Mage_Adminhtml_Block_Widget_Grid_Column $column
	 * @return Vendor_Vendorpricing_Block_Adminhtml_Vendorpricing_Grid
	 * @author Ultimate Module Creator
	 */
	protected function _filterStoreCondition($collection, $column){
		if (!$value = $column->getFilter()->getValue()) {
        	return;
		}
		$collection->addStoreFilter($value);
		return $this;
    }
    
    public function getMainButtonsHtml()
    {
    	$html = parent::getMainButtonsHtml();//get the parent class buttons
    	$addButton = $this->getLayout()->createBlock('adminhtml/widget_button') //create the add button
    	->setData(array(
    			'label'     => Mage::helper('adminhtml')->__('Add Vendor Pricing'),
    			'onclick'   => "setLocation('".$this->getUrl('/vendorpricing_vendorpricing/new/vendor_id/'.$this->getRequest()->getParam('id'))."')",
    			'class'   => 'task'
    	))->toHtml();
    	return $addButton.$html;
    }
}