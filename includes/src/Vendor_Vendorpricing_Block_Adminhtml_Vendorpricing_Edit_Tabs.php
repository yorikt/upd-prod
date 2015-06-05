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
 * Vendor Pricing admin edit tabs
 *
 * @category	Vendor
 * @package		Vendor_Vendorpricing
 * @author Ultimate Module Creator
 */
class Vendor_Vendorpricing_Block_Adminhtml_Vendorpricing_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs{
	/**
	 * constructor
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function __construct(){
		parent::__construct();
		$this->setId('vendorpricing_tabs');
		$this->setDestElementId('edit_form');
		$this->setTitle(Mage::helper('vendorpricing')->__('Vendor Information'));
	}
	/**
	 * before render html
	 * @access protected
	 * @return Vendor_Vendorpricing_Block_Adminhtml_Vendorpricing_Edit_Tabs
	 * @author Ultimate Module Creator
	 */
	protected function _beforeToHtml(){
		$this->addTab('form_managevendors', array(
				'label'		=> Mage::helper('vendors')->__('Account Information'),
				'title'		=> Mage::helper('vendors')->__('Manage Vendors'),
				'url' 	=> $this->getUrl('/vendors_managevendors/edit/id/'.$this->getRequest()->getParam('vendor_id')),
		));
		//comment tab
		$this->addTab('form_store_managevendors', array(
					'label'		=> Mage::helper('vendors')->__('Store views'),
					'title'		=> Mage::helper('vendors')->__('Store views'),
					'url' 	=> $this->getUrl('/vendors_managevendors/edit/id/'.$this->getRequest()->getParam('vendor_id')),
			));
		
		$this->addTab('contacts', array(
				'label' => Mage::helper('vendors')->__('Contacts'),
				'title' => Mage::helper('vendors')->__('Contacts'),
				'url'   => $this->getUrl('/vendors_managevendors/edit/id/'.$this->getRequest()->getParam('vendor_id')),
				
		));
		//comment tab
		
			$this->addTab('comment_section', array(
					'label'     => Mage::helper('comment')->__('Comments History'),
					'title'     => Mage::helper('comment')->__('Comments History'),
					'url' => $this->getUrl('/vendors_managevendors/edit/id/'.$this->getRequest()->getParam('vendor_id'))
			));
			
			$this->addTab('form_vendorpricing', array(
					'label'		=> Mage::helper('vendorpricing')->__('Vendor Pricing'),
					'title'		=> Mage::helper('vendorpricing')->__('Vendor Pricing'),
					'content' 	=> $this->getLayout()->createBlock('vendorpricing/adminhtml_vendorpricing_edit_tab_form')->toHtml(),
					'active'    => true
			));
		
		return parent::_beforeToHtml();
	}
}