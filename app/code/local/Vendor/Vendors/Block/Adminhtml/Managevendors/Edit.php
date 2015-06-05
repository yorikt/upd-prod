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
 * Manage Vendors admin edit block
 *
 * @category	Vendor
 * @package		Vendor_Vendors
 * @author Ultimate Module Creator
 */
class Vendor_Vendors_Block_Adminhtml_Managevendors_Edit extends Mage_Adminhtml_Block_Widget_Form_Container{
	/**
	 * constuctor
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function __construct(){
		parent::__construct();
		$this->_blockGroup = 'vendors';
		$this->_controller = 'adminhtml_managevendors';
		$this->_updateButton('save', 'label', Mage::helper('vendors')->__('Save Vendor'));
		$this->_updateButton('delete', 'label', Mage::helper('vendors')->__('Delete Vendor'));
		$this->_addButton('saveandcontinue', array(
			'label'		=> Mage::helper('vendors')->__('Save And Continue Edit'),
			'onclick'	=> 'saveAndContinueEdit()',
			'class'		=> 'save',
		), -100);
		$this->_formScripts[] = "
			function saveAndContinueEdit(){
				editForm.submit($('edit_form').action+'back/edit/');
			}
		";
	}
	/**
	 * get the edit form header
	 * @access public
	 * @return string
	 * @author Ultimate Module Creator
	 */
	public function getHeaderText(){
		if( Mage::registry('managevendors_data') && Mage::registry('managevendors_data')->getId() ) {
			return Mage::helper('vendors')->__("Edit Vendor '%s'", $this->htmlEscape(Mage::registry('managevendors_data')->getVendorname()));
		} 
		else {
			return Mage::helper('vendors')->__('New Vendor');
		}
	}
}