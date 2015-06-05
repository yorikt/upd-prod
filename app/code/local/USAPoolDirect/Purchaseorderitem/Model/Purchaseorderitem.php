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
 * Purchase Order Item model
 *
 * @category	USAPoolDirect
 * @package		USAPoolDirect_Purchaseorderitem
 * @author Ultimate Module Creator
 */
class USAPoolDirect_Purchaseorderitem_Model_Purchaseorderitem extends Mage_Core_Model_Abstract{
	/**
	 * Entity code.
	 * Can be used as part of method name for entity processing
	 */
	const ENTITY= 'purchaseorderitem_purchaseorderitem';
	const CACHE_TAG = 'purchaseorderitem_purchaseorderitem';
	/**
	 * Prefix of model events names
	 * @var string
	 */
	protected $_eventPrefix = 'purchaseorderitem_purchaseorderitem';
	
	/**
	 * Parameter name in event
	 * @var string
	 */
	protected $_eventObject = 'purchaseorderitem';
	/**
	 * constructor
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function _construct(){
		parent::_construct();
		$this->_init('purchaseorderitem/purchaseorderitem');
	}
	/**
	 * before save purchase order item
	 * @access protected
	 * @return USAPoolDirect_Purchaseorderitem_Model_Purchaseorderitem
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
	 * save purchaseorderitem relation
	 * @access public
	 * @return USAPoolDirect_Purchaseorderitem_Model_Purchaseorderitem
	 * @author Ultimate Module Creator
	 */
	protected function _afterSave() {
		return parent::_afterSave();
	}
}