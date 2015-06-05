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
 * Contact admin edit tabs
 *
 * @category	Vendor
 * @package		Vendor_Vendors
 * @author Ultimate Module Creator
 */
class Vendor_Vendors_Block_Adminhtml_Contact_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs{
	/**
	 * constructor
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function __construct(){
		parent::__construct();
		$this->setId('contact_tabs');
		$this->setDestElementId('edit_form');
		$this->setTitle(Mage::helper('vendors')->__('Contact'));
	}
	/**
	 * before render html
	 * @access protected
	 * @return Vendor_Vendors_Block_Adminhtml_Contact_Edit_Tabs
	 * @author Ultimate Module Creator
	 */
	protected function _beforeToHtml(){
		$this->addTab('form_contact', array(
			'label'		=> Mage::helper('vendors')->__('Contact'),
			'title'		=> Mage::helper('vendors')->__('Contact'),
			'content' 	=> $this->getLayout()->createBlock('vendors/adminhtml_contact_edit_tab_form')->toHtml(),
		));
		if (!Mage::app()->isSingleStoreMode()){
			$this->addTab('form_store_contact', array(
				'label'		=> Mage::helper('vendors')->__('Store views'),
				'title'		=> Mage::helper('vendors')->__('Store views'),
				'content' 	=> $this->getLayout()->createBlock('vendors/adminhtml_contact_edit_tab_stores')->toHtml(),
			));
		}
		$this->addTab('managevendorss', array(
			'label' => Mage::helper('vendors')->__('Manage Vendors'),
			'url'   => $this->getUrl('*/*/managevendorss', array('_current' => true)),
   			'class'	=> 'ajax'
		));
		return parent::_beforeToHtml();
	}
}