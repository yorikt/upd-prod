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
 * Contact manage vendors model
 *
 * @category	Vendor
 * @package		Vendor_Vendors
 * @author Ultimate Module Creator
 */
class Vendor_Vendors_Model_Contact_Managevendors extends Mage_Core_Model_Abstract{
	/**
	 * Initialize resource
	 * @access protected
	 * @return void
	 * @author Ultimate Module Creator
	 */
	protected function _construct(){
		$this->_init('vendors/contact_managevendors');
	}
	/**
	 * Save data for contact - managevendors relation
	 * @access public
	 * @param  Vendor_Vendors_Model_Contact $contact
	 * @return Vendor_Vendors_Model_Contact_Managevendors
	 * @author Ultimate Module Creator
	 */
	public function saveContactRelation($contact){
		$data = $contact->getManagevendorssData();
		if (!is_null($data)) {
			$this->_getResource()->saveContactRelation($contact, $data);
		}
		return $this;
	}
	/**
	 * get managevendorss for contact
	 * @access public
	 * @param Vendor_Vendors_Model_Contact $contact
	 * @return Vendor_Vendors_Model_Resource_Contact_Managevendors_Collection
	 * @author Ultimate Module Creator
	 */
	public function getManagevendorssCollection($contact){
		$collection = Mage::getResourceModel('vendors/contact_managevendors_collection')
			->addContactFilter($contact);
		return $collection;
	}
}