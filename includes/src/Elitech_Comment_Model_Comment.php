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
 * Comment model
 *
 * @category	Elitech
 * @package		Elitech_Comment
 * @author Ultimate Module Creator
 */
class Elitech_Comment_Model_Comment extends Mage_Core_Model_Abstract{
	/**
	 * Entity code.
	 * Can be used as part of method name for entity processing
	 */
	const ENTITY= 'comment_comment';
	const CACHE_TAG = 'comment_comment';
	/**
	 * Prefix of model events names
	 * @var string
	 */
	protected $_eventPrefix = 'comment_comment';
	
	/**
	 * Parameter name in event
	 * @var string
	 */
	protected $_eventObject = 'comment';
	/**
	 * constructor
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function _construct(){
		parent::_construct();
		$this->_init('comment/comment');
	}
	/**
	 * before save comment
	 * @access protected
	 * @return Elitech_Comment_Model_Comment
	 * @author Ultimate Module Creator
	 */
	protected function _beforeSave(){
		parent::_beforeSave();
		$now = Mage::getSingleton('core/date')->gmtDate();
		if ($this->isObjectNew()){
			$this->setCreatedAt($now);
		}
		$this->setUpdatedAt($now);
		return $this;
	}
	/**
	 * get the comment Comment
	 * @access public
	 * @return string
	 * @author Ultimate Module Creator
	 */
	public function getComment(){
		$comment = $this->getData('comment');
		$helper = Mage::helper('cms');
		$processor = $helper->getBlockTemplateProcessor();
		$html = $processor->filter($comment);
		return $html;
	}
	/**
	 * save comment relation
	 * @access public
	 * @return Elitech_Comment_Model_Comment
	 * @author Ultimate Module Creator
	 */
	protected function _afterSave() {
		return parent::_afterSave();
	}
}