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
 * Purchase Order admin block
 *
 * @category	USAPoolDirect
 * @package		USAPoolDirect_Purchaseorder
 * @author Ultimate Module Creator
 */
class USAPoolDirect_Purchaseorder_Block_Adminhtml_Purchaseorder extends Mage_Adminhtml_Block_Widget_Grid_Container{
	/**
	 * constructor
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function __construct(){
		$this->_controller 		= 'adminhtml_purchaseorder';
		$this->_blockGroup 		= 'purchaseorder';
		$this->_headerText 		= Mage::helper('purchaseorder')->__('Purchase Order');
		$this->_addButtonLabel 	= Mage::helper('purchaseorder')->__('Add Purchase Order');
		$back_url = $this->getUrl('/sales_order/index/');
		$this->_addButton('back', array(
				'label'     => Mage::helper('purchaseorder')->__('Back'),
				'onclick'   => "setLocation('$back_url')",
				'class'     => 'scalable back'
		), 0, 100, 'header', 'header');
		
		
		parent::__construct();
		
		$this->removeButton('add');
		
		$add_url = $this->getUrl('/purchaseorder_purchaseorder/purchaseorder/',array('order_id'=>$this->getRequest()->getParam('order_id')));
		$this->_addButton('add', array(
				'label'     => Mage::helper('purchaseorder')->__('Add Purchase Order'),
				'onclick'   => "setLocation('$add_url')",
				'class'     => 'scalable add'
		));
		
	}
}