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
 * Purchase Order admin edit block
 *
 * @category	USAPoolDirect
 * @package		USAPoolDirect_Purchaseorder
 * @author Ultimate Module Creator
 */
class USAPoolDirect_Purchaseorder_Block_Adminhtml_Purchaseorder_Edit extends Mage_Adminhtml_Block_Widget_Form_Container{
	/**
	 * constuctor
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function __construct(){
		parent::__construct();
		$this->_blockGroup = 'purchaseorder';
		$this->_controller = 'adminhtml_purchaseorder';
		$this->_updateButton('save', 'label', Mage::helper('purchaseorder')->__('Save Purchase Order'));
		$this->_updateButton('delete', 'label', Mage::helper('purchaseorder')->__('Delete Purchase Order'));
		$delete_back_url = $this->getUrl('/purchaseorder_purchaseorder/delete/id/'.$this->getRequest()->getParam('id').'/order_id/'.$this->getRequest()->getParam('order_id'));
		$this->_updateButton('delete', 'onclick',"deleteConfirm('Are you sure you want to do this?','$delete_back_url')");
		
		$back_url = $this->getUrl('/purchaseorder_purchaseorder/index/order_id'.$this->getRequest()->getParam('order_id'));
		$this->_updateButton('back', 'onclick',"setLocation('$back_url')");
		
		/*$this->_addButton('saveandcontinue', array(
			'label'		=> Mage::helper('purchaseorder')->__('Save And Continue Edit'),
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
		if( Mage::registry('purchaseorder_data') && Mage::registry('purchaseorder_data')->getId() ) {
			return Mage::helper('purchaseorder')->__("Edit Purchase Order '%s'", $this->htmlEscape(Mage::registry('purchaseorder_data')->getPoNumber()));
		} 
		else {
			return Mage::helper('purchaseorder')->__('Add Purchase Order');
		}
	}
}