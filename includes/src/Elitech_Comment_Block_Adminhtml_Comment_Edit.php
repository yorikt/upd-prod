<?php
/**
 * Elitech_Comment extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category   	Elitech
 * @package		Elitech_Comment
 * @copyright  	Copyright (c) 2014
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Comment admin edit block
 *
 * @category	Elitech
 * @package		Elitech_Comment
 * @author Ultimate Module Creator
 */
class Elitech_Comment_Block_Adminhtml_Comment_Edit extends Mage_Adminhtml_Block_Widget_Form_Container{
	/**
	 * constuctor
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function __construct(){
		parent::__construct();
		$this->_blockGroup = 'comment';
		$this->_controller = 'adminhtml_comment';
		$this->_updateButton('save', 'label', Mage::helper('comment')->__('Save Comment'));
		$this->_updateButton('delete', 'label', Mage::helper('comment')->__('Delete Comment'));
		$this->_addButton('saveandcontinue', array(
			'label'		=> Mage::helper('comment')->__('Save And Continue Edit'),
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
		if( Mage::registry('comment_data') && Mage::registry('comment_data')->getId() ) {
			return Mage::helper('comment')->__("Edit Comment '%s'", $this->htmlEscape(Mage::registry('comment_data')->getAddress()));
		} 
		else {
			return Mage::helper('comment')->__('Add Comment');
		}
	}
}