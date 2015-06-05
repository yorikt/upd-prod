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
 * Purchase Order admin edit tabs
 *
 * @category	USAPoolDirect
 * @package		USAPoolDirect_Purchaseorder
 * @author Ultimate Module Creator
 */
class USAPoolDirect_Purchaseorder_Block_Adminhtml_Purchaseorder_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs{
	/**
	 * constructor
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function __construct(){
		parent::__construct();
		$this->setId('purchaseorder_tabs');
		$this->setDestElementId('edit_form');
		$this->setTitle(Mage::helper('purchaseorder')->__('Purchase Order'));
	}
	/**
	 * before render html
	 * @access protected
	 * @return USAPoolDirect_Purchaseorder_Block_Adminhtml_Purchaseorder_Edit_Tabs
	 * @author Ultimate Module Creator
	 */
	protected function _beforeToHtml(){
		$this->addTab('form_purchaseorder', array(
			'label'		=> Mage::helper('purchaseorder')->__('Purchase Order'),
			'title'		=> Mage::helper('purchaseorder')->__('Purchase Order'),
			'content' 	=> $this->getLayout()->createBlock('purchaseorder/adminhtml_purchaseorder_edit_tab_form')->toHtml(),
		));
		if (!Mage::app()->isSingleStoreMode()){
			$this->addTab('form_store_purchaseorder', array(
				'label'		=> Mage::helper('purchaseorder')->__('Store views'),
				'title'		=> Mage::helper('purchaseorder')->__('Store views'),
				'content' 	=> $this->getLayout()->createBlock('purchaseorder/adminhtml_purchaseorder_edit_tab_stores')->toHtml(),
			));
		}
		return parent::_beforeToHtml();
	}
}