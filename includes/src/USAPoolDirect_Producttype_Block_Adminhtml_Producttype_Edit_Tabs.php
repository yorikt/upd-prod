<?php
/**
 * USAPoolDirect_Producttype extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category   	USAPoolDirect
 * @package		USAPoolDirect_Producttype
 * @copyright  	Copyright (c) 2014
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * ProductTypes admin edit tabs
 *
 * @category	USAPoolDirect
 * @package		USAPoolDirect_Producttype
 * @author Ultimate Module Creator
 */
class USAPoolDirect_Producttype_Block_Adminhtml_Producttype_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs{
	/**
	 * constructor
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function __construct(){
		parent::__construct();
		$this->setId('producttype_tabs');
		$this->setDestElementId('edit_form');
		$this->setTitle(Mage::helper('producttype')->__('ProductTypes'));
	}
	/**
	 * before render html
	 * @access protected
	 * @return USAPoolDirect_Producttype_Block_Adminhtml_Producttype_Edit_Tabs
	 * @author Ultimate Module Creator
	 */
	protected function _beforeToHtml(){
		$this->addTab('form_producttype', array(
			'label'		=> Mage::helper('producttype')->__('ProductTypes'),
			'title'		=> Mage::helper('producttype')->__('ProductTypes'),
			'content' 	=> $this->getLayout()->createBlock('producttype/adminhtml_producttype_edit_tab_form')->toHtml(),
		));
		if (!Mage::app()->isSingleStoreMode()){
			$this->addTab('form_store_producttype', array(
				'label'		=> Mage::helper('producttype')->__('Store views'),
				'title'		=> Mage::helper('producttype')->__('Store views'),
				'content' 	=> $this->getLayout()->createBlock('producttype/adminhtml_producttype_edit_tab_stores')->toHtml(),
			));
		}
		$this->addTab('products', array(
			'label' => Mage::helper('producttype')->__('Associated products'),
			'url'   => $this->getUrl('*/*/products', array('_current' => true)),
   			'class'	=> 'ajax'
		));
		return parent::_beforeToHtml();
	}
}