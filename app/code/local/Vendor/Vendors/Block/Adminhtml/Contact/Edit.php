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
 * Contact admin edit block
 *
 * @category	Vendor
 * @package		Vendor_Vendors
 * @author Ultimate Module Creator
 */
class Vendor_Vendors_Block_Adminhtml_Contact_Edit extends Mage_Adminhtml_Block_Widget_Form_Container{
	/**
	 * constuctor
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function __construct(){
		parent::__construct();
		$this->_blockGroup = 'vendors';
		$this->_controller = 'adminhtml_contact';
		$this->_updateButton('save', 'label', Mage::helper('vendors')->__('Save Contact'));
		$this->_updateButton('delete', 'label', Mage::helper('vendors')->__('Delete Contact'));
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
		if( Mage::registry('contact_data') && Mage::registry('contact_data')->getId() ) {
			return Mage::helper('vendors')->__("Edit Contact '%s'", $this->htmlEscape(Mage::registry('contact_data')->getFirstname()));
		} 
		else {
			return Mage::helper('vendors')->__('Add Contact');
		}
	}
}