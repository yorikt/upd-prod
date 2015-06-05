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
 * Contact model
 *
 * @category	Vendor
 * @package		Vendor_Vendors
 * @author Ultimate Module Creator
 */
class Vendor_Vendors_Model_Contact extends Mage_Core_Model_Abstract{
	/**
	 * Entity code.
	 * Can be used as part of method name for entity processing
	 */
	const ENTITY= 'vendors_contact';
	const CACHE_TAG = 'vendors_contact';
	/**
	 * Prefix of model events names
	 * @var string
	 */
	protected $_eventPrefix = 'vendors_contact';
	
	/**
	 * Parameter name in event
	 * @var string
	 */
	protected $_eventObject = 'contact';
	protected $_managevendorsInstance = null;
	/**
	 * constructor
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function _construct(){
		parent::_construct();
		$this->_init('vendors/contact');
	}
	/**
	 * before save contact
	 * @access protected
	 * @return Vendor_Vendors_Model_Contact
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
	 * save contact relation
	 * @access public
	 * @return Vendor_Vendors_Model_Contact
	 * @author Ultimate Module Creator
	 */
	protected function _afterSave() {
		$this->getManagevendorsInstance()->saveContactRelation($this);
		return parent::_afterSave();
	}
	/**
	 * get managevendors relation model
	 * @access public
	 * @return Vendor_Vendors_Model_Contact_Managevendors
	 * @author Ultimate Module Creator
	 */
	public function getManagevendorsInstance(){
		if (!$this->_managevendorsInstance) {
			$this->_managevendorsInstance = Mage::getSingleton('vendors/contact_managevendors');
		}
		return $this->_managevendorsInstance;
	}
	/**
	 * get selected managevendorss array
	 * @access public
	 * @return array
	 * @author Ultimate Module Creator
	 */
	public function getSelectedManagevendorss(){
		if (!$this->hasSelectedManagevendorss()) {
			$managevendorss = array();
			foreach ($this->getSelectedManagevendorssCollection() as $managevendors) {
				$managevendorss[] = $managevendors;
			}
			$this->setSelectedManagevendorss($managevendorss);
		}
		return $this->getData('selected_managevendorss');
	}
	/**
	 * Retrieve collection selected managevendorss
	 * @access public
	 * @return Vendor_Vendors_Model_Contact_Managevendors_Collection
	 * @author Ultimate Module Creator
	 */
	public function getSelectedManagevendorssCollection(){
		$collection = $this->getManagevendorsInstance()->getManagevendorssCollection($this);
		return $collection;
	}
}