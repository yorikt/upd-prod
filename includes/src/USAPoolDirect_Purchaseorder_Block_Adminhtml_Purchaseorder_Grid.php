<?php
/**
 * USAPoolDirect_Purchaseorder extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category   	USAPoolDirect
 * @package		USAPoolDirect_Purchaseorder
 * @copyright  	Copyright (c) 2014
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Purchase Order admin grid block
 *
 * @category	USAPoolDirect
 * @package		USAPoolDirect_Purchaseorder
 * @author Ultimate Module Creator
 */
class USAPoolDirect_Purchaseorder_Block_Adminhtml_Purchaseorder_Grid extends Mage_Adminhtml_Block_Widget_Grid{
	/**
	 * constructor
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function __construct(){
		parent::__construct();
		$this->setId('purchaseorderGrid');
		$this->setDefaultSort('entity_id');
		$this->setDefaultDir('ASC');
		$this->setSaveParametersInSession(true);
		$this->setUseAjax(true);
	}
	/**
	 * prepare collection
	 * @access protected
	 * @return USAPoolDirect_Purchaseorder_Block_Adminhtml_Purchaseorder_Grid
	 * @author Ultimate Module Creator
	 */
	protected function _prepareCollection(){
		
		
		
		$collection = Mage::getModel('purchaseorder/purchaseorder')->getCollection();
		$select = $collection->getSelect();
		$select->where("order_id = ?", $this->getRequest()->getParam('order_id'));
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}
	/**
	 * prepare grid collection
	 * @access protected
	 * @return USAPoolDirect_Purchaseorder_Block_Adminhtml_Purchaseorder_Grid
	 * @author Ultimate Module Creator
	 */
	protected function _prepareColumns(){
		/*$this->addColumn('entity_id', array(
			'header'	=> Mage::helper('purchaseorder')->__('Id'),
			'index'		=> 'entity_id',
			'type'		=> 'number'
		));*/
		$this->addColumn('po_number', array(
			'header'=> Mage::helper('purchaseorder')->__('PO Number'),
			'index' => 'po_number',
			'type'  => 'action',
			'renderer'  => 'USAPoolDirect_Purchaseorder_Block_Adminhtml_Purchaseorder_Renderer_Editpolink'
				
		));
		/*$this->addColumn('club', array(
			'header'=> Mage::helper('purchaseorder')->__('Club'),
			'index' => 'club',
			'type'	 	=> 'text',

		));*/
		$this->addColumn('order_status', array(
			'header'=> Mage::helper('purchaseorder')->__('Status'),
			'index' => 'order_status',
			'type'		=> 'options',
			'options'	=> array(
					'cancelled' => Mage::helper('purchaseorder')->__('Cancelled'),
					'issued' => Mage::helper('purchaseorder')->__('Issued'),
					'open' => Mage::helper('purchaseorder')->__('Open'),
					'completed' => Mage::helper('purchaseorder')->__('Completed'),
			)

		));
		
		$this->addColumn('vendor_id', array(
				'header'=> Mage::helper('purchaseorder')->__('Vendor'),
				'index' => 'vendor_id',
				'type'	 	=> 'text',
				'renderer'  => 'USAPoolDirect_Purchaseorder_Block_Adminhtml_Purchaseorder_Renderer_Vendor',
		
		));
		
		$this->addColumn('ship_to', array(
			'header'=> Mage::helper('purchaseorder')->__('Ship To'),
			'index' => 'ship_to',
			'type'	 	=> 'text',

		));
		$this->addColumn('city', array(
				'header'=> Mage::helper('purchaseorder')->__('City'),
				'index' => 'city',
				'type'	 	=> 'text',
		
		));
		$this->addColumn('region_id', array(
				'header'=> Mage::helper('purchaseorder')->__('State'),
				'index' => 'region_id',
				'type'	 	=> 'text',
				'renderer'  => 'USAPoolDirect_Purchaseorder_Block_Adminhtml_Purchaseorder_Renderer_State',
		
		));
		$this->addColumn('order_number', array(
			'header'=> Mage::helper('purchaseorder')->__('Order Number'),
			'index' => 'order_number',
			'type'	 	=> 'text',

		));
		$this->addColumn('grand_total', array(
				'header'=> Mage::helper('purchaseorder')->__('PO Total'),
				'index' => 'grand_total',
				'type'	 	=> 'text',
		
		));
		
		$this->addColumn('pos_issued_date', array(
			'header'=> Mage::helper('purchaseorder')->__('PO Date'),
			'index' => 'pos_issued_date',
			'type'	 	=> 'date',
				

		));
		
		/*$this->addColumn('deliver_date', array(
			'header'=> Mage::helper('purchaseorder')->__('Deliver Date'),
			'index' => 'deliver_date',
			'type'	 	=> 'text',

		));*/
		$this->addColumn('delivery_method', array(
			'header'=> Mage::helper('purchaseorder')->__('Delivery Method'),
			'index' => 'delivery_method',
			'type'	 	=> 'text',

		));
		/*$this->addColumn('status', array(
			'header'	=> Mage::helper('purchaseorder')->__('Status'),
			'index'		=> 'status',
			'type'		=> 'options',
			'options'	=> array(
				'1' => Mage::helper('purchaseorder')->__('Enabled'),
				'0' => Mage::helper('purchaseorder')->__('Disabled'),
			)
		));*/
		/*if (!Mage::app()->isSingleStoreMode()) {
			$this->addColumn('store_id', array(
				'header'=> Mage::helper('purchaseorder')->__('Store Views'),
				'index' => 'store_id',
				'type'  => 'store',
				'store_all' => true,
				'store_view'=> true,
				'sortable'  => false,
				'filter_condition_callback'=> array($this, '_filterStoreCondition'),
			));
		}*/
		/*$this->addColumn('created_at', array(
			'header'	=> Mage::helper('purchaseorder')->__('Created at'),
			'index' 	=> 'created_at',
			'width' 	=> '120px',
			'type'  	=> 'datetime',
		));
		$this->addColumn('updated_at', array(
			'header'	=> Mage::helper('purchaseorder')->__('Updated at'),
			'index' 	=> 'updated_at',
			'width' 	=> '120px',
			'type'  	=> 'datetime',
		));*/
		$this->addColumn('action',
			array(
				'header'=>  Mage::helper('purchaseorder')->__('Action'),
				'width' => '10',
									
				'type'  => 'action',
				'filter'=> false,
				'is_system'	=> true,
				'sortable'  => false,
				'renderer'  => 'USAPoolDirect_Purchaseorder_Block_Adminhtml_Purchaseorder_Renderer_Pdf',
				'align' => 'center',
				'header_css_class'=>'custom-center',
		));
// 		$this->addExportType('*/*/exportCsv', Mage::helper('purchaseorder')->__('CSV'));
// 		$this->addExportType('*/*/exportExcel', Mage::helper('purchaseorder')->__('Excel'));
// 		$this->addExportType('*/*/exportXml', Mage::helper('purchaseorder')->__('XML'));
		return parent::_prepareColumns();
	}
	/**
	 * prepare mass action
	 * @access protected
	 * @return USAPoolDirect_Purchaseorder_Block_Adminhtml_Purchaseorder_Grid
	 * @author Ultimate Module Creator
	 */
	protected function _prepareMassaction(){
		// $this->setMassactionIdField('entity_id');
		// $this->getMassactionBlock()->setFormFieldName('purchaseorder');
		// $this->getMassactionBlock()->addItem('delete', array(
		// 	'label'=> Mage::helper('purchaseorder')->__('Delete'),
		// 	'url'  => $this->getUrl('*/*/massDelete'),
		// 	'confirm'  => Mage::helper('purchaseorder')->__('Are you sure?')
		// ));
		// $this->getMassactionBlock()->addItem('status', array(
		// 	'label'=> Mage::helper('purchaseorder')->__('Change status'),
		// 	'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
		// 	'additional' => array(
		// 		'status' => array(
		// 				'name' => 'status',
		// 				'type' => 'select',
		// 				'class' => 'required-entry',
		// 				'label' => Mage::helper('purchaseorder')->__('Status'),
		// 				'values' => array(
		// 						'1' => Mage::helper('purchaseorder')->__('Enabled'),
		// 						'0' => Mage::helper('purchaseorder')->__('Disabled'),
		// 				)
		// 		)
		// 	)
		// ));
		// return $this;
	}
	/**
	 * get the row url
	 * @access public
	 * @param USAPoolDirect_Purchaseorder_Model_Purchaseorder
	 * @return string
	 * @author Ultimate Module Creator
	 */
	public function getRowUrl($row){
		return $this->getUrl('*/purchaseorder_purchaseorder/editpo', array('po_number' => $row->getPoNumber(),'order_id'=>$this->getRequest()->getParam('order_id')));
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
	 * @return USAPoolDirect_Purchaseorder_Block_Adminhtml_Purchaseorder_Grid
	 * @author Ultimate Module Creator
	 */
	protected function _afterLoadCollection(){
		$this->getCollection()->walk('afterLoad');
		parent::_afterLoadCollection();
	}
	/**
	 * filter store column
	 * @access protected
	 * @param USAPoolDirect_Purchaseorder_Model_Resource_Purchaseorder_Collection $collection
	 * @param Mage_Adminhtml_Block_Widget_Grid_Column $column
	 * @return USAPoolDirect_Purchaseorder_Block_Adminhtml_Purchaseorder_Grid
	 * @author Ultimate Module Creator
	 */
	protected function _filterStoreCondition($collection, $column){
		if (!$value = $column->getFilter()->getValue()) {
        	return;
		}
		$collection->addStoreFilter($value);
		return $this;
    }
    
    public function getOrderUrl($po_number){
    	return $this->getUrl('*/purchaseorder_purchaseorder/editpo/',array('po_number'=>$po_number,'order_id'=>$this->getRequest()->getParam('order_id')));
    }
    
    public function getMainButtonsHtml()
    {
    	$html = parent::getMainButtonsHtml();//get the parent class buttons
    	$addButton = $this->getLayout()->createBlock('adminhtml/widget_button') //create the add button
    	->setData(array(
    			'label'     => Mage::helper('adminhtml')->__('Add Purchase Order'),
    			'onclick'   => "setLocation('".$this->getUrl('*/*/purchaseorder/',array('order_id'=>$this->getRequest()->getParam('order_id')))."')",
    			'class'   => 'scalable scalable add'
    	))->toHtml();
    	return $addButton.$html;
    }
    
}