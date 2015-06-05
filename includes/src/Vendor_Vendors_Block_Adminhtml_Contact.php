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
 * Contact admin block
 *
 * @category	Vendor
 * @package		Vendor_Vendors
 * @author Ultimate Module Creator
 */
class Vendor_Vendors_Block_Adminhtml_Contact extends Mage_Adminhtml_Block_Widget_Grid_Container{
	/**
	 * constructor
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function __construct(){
		$this->_controller 		= 'adminhtml_contact';
		$this->_blockGroup 		= 'vendors';
		$this->_headerText 		= Mage::helper('vendors')->__('Contact');
		$this->_addButtonLabel 	= Mage::helper('vendors')->__('Add Contact');
		parent::__construct();
	}
}