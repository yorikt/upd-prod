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
 * Contact - Manage Vendors relation resource model collection
 *
 * @category	Vendor
 * @package		Vendor_Vendors
 * @author Ultimate Module Creator
 */
class Vendor_Vendors_Model_Resource_Contact_Managevendors_Collection extends Vendor_Vendors_Model_Resource_Managevendors_Collection{
	/**
	 * remember if fields have been joined
	 * @var bool
	 */
	protected $_joinedFields = false;
	/**
	 * join the link table
	 * @access public
	 * @return Vendor_Vendors_Model_Resource_Contact_Managevendors_Collection
	 * @author Ultimate Module Creator
	 */
	public function joinFields(){
		if (!$this->_joinedFields){
			$this->getSelect()->join(
				array('related' => $this->getTable('vendors/contact_managevendors')),
				'related.managevendors_id = main_table.entity_id',
				array('position')
			);
			$this->_joinedFields = true;
		}
		return $this;
	}
	/**
	 * add contact filter
	 * @access public
	 * @param Vendor_Vendors_Model_Contact | int $contact
	 * @return Vendor_Vendors_Model_Resource_Contact_Managevendors_Collection
	 * @author Ultimate Module Creator
	 */
	public function addContactFilter($contact){
		if ($contact instanceof Vendor_Vendors_Model_Contact){
			$contact = $contact->getId();
		}
		if (!$this->_joinedFields){
			$this->joinFields();
		}
		$this->getSelect()->where('related.contact_id = ?', $contact);
		return $this;
	}
}