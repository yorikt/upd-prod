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
 * Vendor Pricing admin edit block
 *
 * @category	Vendor
 * @package		Vendor_Vendorpricing
 * @author Ultimate Module Creator
 */
class Vendor_Vendorpricing_Block_Adminhtml_Vendorpricing_Edit extends Mage_Adminhtml_Block_Widget_Form_Container{
	/**
	 * constuctor
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function __construct(){
		parent::__construct();
		$this->_blockGroup = 'vendorpricing';
		$this->_controller = 'adminhtml_vendorpricing';
		$this->_updateButton('save', 'label', Mage::helper('vendorpricing')->__('Save Vendor Pricing'));
		$this->_updateButton('delete', 'label', Mage::helper('vendorpricing')->__('Delete Vendor Pricing'));
		$delete_back_url = $this->getUrl('/vendorpricing_vendorpricing/delete/id/'.$this->getRequest()->getParam('id').'/vendor_id/'.$this->getRequest()->getParam('vendor_id'));
		$this->_updateButton('delete', 'onclick',"deleteConfirm('Are you sure you want to do this?','$delete_back_url')");
		
		$delete_back_url = $this->getUrl('/vendors_managevendors/edit/id/'.$this->getRequest()->getParam('vendor_id'));
		$this->_updateButton('back', 'onclick',"setLocation('$delete_back_url')");
		
		/*$this->_addButton('saveandcontinue', array(
			'label'		=> Mage::helper('vendorpricing')->__('Save And Continue Edit'),
			'onclick'	=> 'saveAndContinueEdit()',
			'class'		=> 'save',
		), -100);
		$this->_formScripts[] = "
			function saveAndContinueEdit(){
				editForm.submit($('edit_form').action+'back/edit/');
			}
		";*/
		//$this->removeButton('back');
	}
	/**
	 * get the edit form header
	 * @access public
	 * @return string
	 * @author Ultimate Module Creator
	 */
	public function getHeaderText(){
		if( Mage::registry('vendorpricing_data') && Mage::registry('vendorpricing_data')->getId() ) {
			return Mage::helper('vendorpricing')->__("Edit Vendor Pricing '%s'", $this->htmlEscape(Mage::registry('vendorpricing_data')->getPartNumber()));
		} 
		else {
			return Mage::helper('vendorpricing')->__('Add Vendor Pricing');
		}
	}
}