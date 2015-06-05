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
 * Comment admin edit tabs
 *
 * @category	Elitech
 * @package		Elitech_Comment
 * @author Ultimate Module Creator
 */
class Elitech_Comment_Block_Adminhtml_Comment_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs{
	/**
	 * constructor
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function __construct(){
		parent::__construct();
		$this->setId('comment_tabs');
		$this->setDestElementId('edit_form');
		$this->setTitle(Mage::helper('comment')->__('Comment'));
	}
	/**
	 * before render html
	 * @access protected
	 * @return Elitech_Comment_Block_Adminhtml_Comment_Edit_Tabs
	 * @author Ultimate Module Creator
	 */
	protected function _beforeToHtml(){
		$this->addTab('form_comment', array(
			'label'		=> Mage::helper('comment')->__('Comment'),
			'title'		=> Mage::helper('comment')->__('Comment'),
			'content' 	=> $this->getLayout()->createBlock('comment/adminhtml_comment_edit_tab_form')->toHtml(),
		));
		if (!Mage::app()->isSingleStoreMode()){
			$this->addTab('form_store_comment', array(
				'label'		=> Mage::helper('comment')->__('Store views'),
				'title'		=> Mage::helper('comment')->__('Store views'),
				'content' 	=> $this->getLayout()->createBlock('comment/adminhtml_comment_edit_tab_stores')->toHtml(),
			));
		}
		return parent::_beforeToHtml();
	}
}