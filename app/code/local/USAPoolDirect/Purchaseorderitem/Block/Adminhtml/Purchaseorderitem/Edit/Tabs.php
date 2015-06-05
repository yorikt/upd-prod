<?php
/**
 * USAPoolDirect_Purchaseorderitem extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category   	USAPoolDirect
 * @package		USAPoolDirect_Purchaseorderitem
 * @copyright  	Copyright (c) 2014
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Purchase Order Item admin edit tabs
 *
 * @category	USAPoolDirect
 * @package		USAPoolDirect_Purchaseorderitem
 * @author Ultimate Module Creator
 */
class USAPoolDirect_Purchaseorderitem_Block_Adminhtml_Purchaseorderitem_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs{
	/**
	 * constructor
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function __construct(){
		parent::__construct();
		$this->setId('purchaseorderitem_tabs');
		$this->setDestElementId('edit_form');
		$this->setTitle(Mage::helper('purchaseorderitem')->__('Purchase Order Item'));
	}
	/**
	 * before render html
	 * @access protected
	 * @return USAPoolDirect_Purchaseorderitem_Block_Adminhtml_Purchaseorderitem_Edit_Tabs
	 * @author Ultimate Module Creator
	 */
	protected function _beforeToHtml(){
		$this->addTab('form_purchaseorderitem', array(
			'label'		=> Mage::helper('purchaseorderitem')->__('Purchase Order Item'),
			'title'		=> Mage::helper('purchaseorderitem')->__('Purchase Order Item'),
			'content' 	=> $this->getLayout()->createBlock('purchaseorderitem/adminhtml_purchaseorderitem_edit_tab_form')->toHtml(),
		));
		if (!Mage::app()->isSingleStoreMode()){
			$this->addTab('form_store_purchaseorderitem', array(
				'label'		=> Mage::helper('purchaseorderitem')->__('Store views'),
				'title'		=> Mage::helper('purchaseorderitem')->__('Store views'),
				'content' 	=> $this->getLayout()->createBlock('purchaseorderitem/adminhtml_purchaseorderitem_edit_tab_stores')->toHtml(),
			));
		}
		return parent::_beforeToHtml();
	}
}