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
 * Purchase Order Item admin edit block
 *
 * @category	USAPoolDirect
 * @package		USAPoolDirect_Purchaseorderitem
 * @author Ultimate Module Creator
 */
class USAPoolDirect_Purchaseorderitem_Block_Adminhtml_Purchaseorderitem_Edit extends Mage_Adminhtml_Block_Widget_Form_Container{
	/**
	 * constuctor
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function __construct(){
		parent::__construct();
		$this->_blockGroup = 'purchaseorderitem';
		$this->_controller = 'adminhtml_purchaseorderitem';
		$this->_updateButton('save', 'label', Mage::helper('purchaseorderitem')->__('Save Purchase Order Item'));
		$this->_updateButton('delete', 'label', Mage::helper('purchaseorderitem')->__('Delete Purchase Order Item'));
		$this->_addButton('saveandcontinue', array(
			'label'		=> Mage::helper('purchaseorderitem')->__('Save And Continue Edit'),
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
		if( Mage::registry('purchaseorderitem_data') && Mage::registry('purchaseorderitem_data')->getId() ) {
			return Mage::helper('purchaseorderitem')->__("Edit Purchase Order Item '%s'", $this->htmlEscape(Mage::registry('purchaseorderitem_data')->getQty()));
		} 
		else {
			return Mage::helper('purchaseorderitem')->__('Add Purchase Order Item');
		}
	}
}