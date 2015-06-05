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
 * Manage Vendors admin edit tabs
 *
 * @category	Vendor
 * @package		Vendor_Vendors
 * @author Ultimate Module Creator
 */
class Vendor_Vendors_Block_Adminhtml_Managevendors_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs{
	/**
	 * constructor
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function __construct(){
		parent::__construct();
		$this->setId('managevendors_tabs');
		$this->setDestElementId('edit_form');
		$this->setTitle(Mage::helper('vendors')->__('Vendor Information'));
	}
	/**
	 * before render html
	 * @access protected
	 * @return Vendor_Vendors_Block_Adminhtml_Managevendors_Edit_Tabs
	 * @author Ultimate Module Creator
	 */
	protected function _beforeToHtml(){
		$this->addTab('form_managevendors', array(
			'label'		=> Mage::helper('vendors')->__('Account Information'),
			'title'		=> Mage::helper('vendors')->__('Manage Vendors'),
			'content' 	=> $this->getLayout()->createBlock('vendors/adminhtml_managevendors_edit_tab_form')->toHtml(),
		));
		
		
		//comment tab
		$befor_forward_info = $this->getRequest()->getBeforeForwardInfo();
		if($befor_forward_info['action_name']!='new'){
			
			$this->addTab('contacts', array(
					'label' => Mage::helper('vendors')->__('Contacts'),
					'url'   => $this->getUrl('*/*/contacts', array('_current' => true)),
					'class'	=> 'ajax'
			));
			
			
			$this->addTab('comment_section', array(
					'label'     => Mage::helper('comment')->__('Comments History'),
					'title'     => Mage::helper('comment')->__('Comments History'),
					'content'   => $this->getLayout()->createBlock('vendors/adminhtml_managevendors_edit_tab_commentgrid')->toHtml(),
					'class' =>'ajax only notloaded hide',
					'url' => Mage::helper('adminhtml')->getUrl('/vendors_managevendors/commentsHistory/id/'.$this->getRequest()->getParam('id'))
			));
			
			$this->addTab('form_vendorpricing', array(
					'label'		=> Mage::helper('vendorpricing')->__('Vendor Pricing'),
					'title'		=> Mage::helper('vendorpricing')->__('Vendor Pricing'),
					'content' 	=> $this->getLayout()->createBlock('vendorpricing/adminhtml_vendorpricing_grid')->toHtml(),
			));
			
			$this->addTab('form_vendorpricing_import', array(
					'label'		=> Mage::helper('vendorpricing')->__('Vendor Pricing Import'),
					'title'		=> Mage::helper('vendorpricing')->__('Vendor Pricing Import'),
					'content' 	=> $this->getLayout()->createBlock('vendorpricing/adminhtml_vendorpricing_edit_tab_import')->toHtml(),
					
			));
		}
		if (!Mage::app()->isSingleStoreMode()){
			$this->addTab('form_store_managevendors', array(
					'label'		=> Mage::helper('vendors')->__('Store views'),
					'title'		=> Mage::helper('vendors')->__('Store views'),
					'content' 	=> $this->getLayout()->createBlock('vendors/adminhtml_managevendors_edit_tab_stores')->toHtml(),
			));
		}
		
		return parent::_beforeToHtml();
	}
}