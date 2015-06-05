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
 * Manage Vendors contact model
 *
 * @category	Vendor
 * @package		Vendor_Vendors
 * @author Ultimate Module Creator
 */
class Vendor_Vendors_Model_Managevendors_Contact extends Mage_Core_Model_Abstract{
	/**
	 * Initialize resource
	 * @access protected
	 * @return void
	 * @author Ultimate Module Creator
	 */
	protected function _construct(){
		$this->_init('vendors/managevendors_contact');
	}
	/**
	 * Save data for managevendors - contact relation
	 * @access public
	 * @param  Vendor_Vendors_Model_Managevendors $managevendors
	 * @return Vendor_Vendors_Model_Managevendors_Contact
	 * @author Ultimate Module Creator
	 */
	public function saveManagevendorsRelation($managevendors){
		$data = $managevendors->getContactsData();
		if (!is_null($data)) {
			$this->_getResource()->saveManagevendorsRelation($managevendors, $data);
		}
		return $this;
	}
	/**
	 * get contacts for managevendors
	 * @access public
	 * @param Vendor_Vendors_Model_Managevendors $managevendors
	 * @return Vendor_Vendors_Model_Resource_Managevendors_Contact_Collection
	 * @author Ultimate Module Creator
	 */
	public function getContactsCollection($managevendors){
		$collection = Mage::getResourceModel('vendors/managevendors_contact_collection')
			->addManagevendorsFilter($managevendors);
		return $collection;
	}
}