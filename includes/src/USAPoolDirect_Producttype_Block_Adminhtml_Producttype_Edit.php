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
 * ProductTypes admin edit block
 *
 * @category	USAPoolDirect
 * @package		USAPoolDirect_Producttype
 * @author Ultimate Module Creator
 */
class USAPoolDirect_Producttype_Block_Adminhtml_Producttype_Edit extends Mage_Adminhtml_Block_Widget_Form_Container{
	/**
	 * constuctor
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function __construct(){
		parent::__construct();
		$this->_blockGroup = 'producttype';
		$this->_controller = 'adminhtml_producttype';
		$this->_updateButton('save', 'label', Mage::helper('producttype')->__('Save ProductTypes'));
		$this->_updateButton('delete', 'label', Mage::helper('producttype')->__('Delete ProductTypes'));
		$this->_addButton('saveandcontinue', array(
			'label'		=> Mage::helper('producttype')->__('Save And Continue Edit'),
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
		if( Mage::registry('producttype_data') && Mage::registry('producttype_data')->getId() ) {
			return Mage::helper('producttype')->__("Edit ProductTypes '%s'", $this->htmlEscape(Mage::registry('producttype_data')->getProductType()));
		} 
		else {
			return Mage::helper('producttype')->__('Add ProductTypes');
		}
	}
}