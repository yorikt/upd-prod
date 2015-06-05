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
 * Manage Vendors - Contact relation model
 *
 * @category	Vendor
 * @package		Vendor_Vendors
 * @author Ultimate Module Creator
 */
class Vendor_Vendors_Model_Resource_Managevendors_Contact extends Mage_Core_Model_Resource_Db_Abstract{
	/**
	 * initialize resource model
	 * @access protected
	 * @return void
	 * @see Mage_Core_Model_Resource_Abstract::_construct()
	 * @author Ultimate Module Creator
	 */
	protected function  _construct(){
		$this->_init('vendors/managevendors_contact', 'rel_id');
	}
	/**
	 * Save managevendors - contact relations
	 * @access public
	 * @param Vendor_Vendors_Model_Managevendors $managevendors
	 * @param array $data
	 * @return Vendor_Vendors_Model_Resource_Managevendors_Contact
	 * @author Ultimate Module Creator
	 */
	public function saveManagevendorsRelation($managevendors, $data){
		if (!is_array($data)) {
			$data = array();
		}
		$deleteCondition = $this->_getWriteAdapter()->quoteInto('managevendors_id=?', $managevendors->getId());
		$this->_getWriteAdapter()->delete($this->getMainTable(), $deleteCondition);

		foreach ($data as $contactId => $info) {
			$this->_getWriteAdapter()->insert($this->getMainTable(), array(
				'managevendors_id'  	=> $managevendors->getId(),
				'contact_id' 	=> $contactId,
				'position'  	=> @$info['position']
			));
		}
		return $this;
	}
}