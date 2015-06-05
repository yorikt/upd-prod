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
 * Contact - Manage Vendors relation model
 *
 * @category	Vendor
 * @package		Vendor_Vendors
 * @author Ultimate Module Creator
 */
class Vendor_Vendors_Model_Resource_Contact_Managevendors extends Mage_Core_Model_Resource_Db_Abstract{
	/**
	 * initialize resource model
	 * @access protected
	 * @return void
	 * @see Mage_Core_Model_Resource_Abstract::_construct()
	 * @author Ultimate Module Creator
	 */
	protected function  _construct(){
		$this->_init('vendors/contact_managevendors', 'rel_id');
	}
	/**
	 * Save contact - managevendors relations
	 * @access public
	 * @param Vendor_Vendors_Model_Contact $contact
	 * @param array $data
	 * @return Vendor_Vendors_Model_Resource_Contact_Managevendors
	 * @author Ultimate Module Creator
	 */
	public function saveContactRelation($contact, $data){
		if (!is_array($data)) {
			$data = array();
		}
		$deleteCondition = $this->_getWriteAdapter()->quoteInto('contact_id=?', $contact->getId());
		$this->_getWriteAdapter()->delete($this->getMainTable(), $deleteCondition);

		foreach ($data as $managevendorsId => $info) {
			$this->_getWriteAdapter()->insert($this->getMainTable(), array(
				'contact_id'  	=> $contact->getId(),
				'managevendors_id' 	=> $managevendorsId,
				'position'  	=> @$info['position']
			));
		}
		return $this;
	}
}