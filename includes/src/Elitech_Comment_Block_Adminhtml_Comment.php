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
 * Comment admin block
 *
 * @category	Elitech
 * @package		Elitech_Comment
 * @author Ultimate Module Creator
 */
class Elitech_Comment_Block_Adminhtml_Comment extends Mage_Adminhtml_Block_Widget_Grid_Container{
	/**
	 * constructor
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function __construct(){
		$this->_controller 		= 'adminhtml_comment';
		$this->_blockGroup 		= 'comment';
		$this->_headerText 		= Mage::helper('comment')->__('Comment');
		$this->_addButtonLabel 	= Mage::helper('comment')->__('Add Comment');
		parent::__construct();
	}
}