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
 * Manage Vendors model
 *
 * @category	Vendor
 * @package		Vendor_Vendors
 * @author Ultimate Module Creator
 */
class Vendor_Vendors_Model_Managevendors extends Mage_Core_Model_Abstract{
	/**
	 * Entity code.
	 * Can be used as part of method name for entity processing
	 */
	const ENTITY= 'vendors_managevendors';
	const CACHE_TAG = 'vendors_managevendors';
	/**
	 * Prefix of model events names
	 * @var string
	 */
	protected $_eventPrefix = 'vendors_managevendors';
	
	/**
	 * Parameter name in event
	 * @var string
	 */
	protected $_eventObject = 'managevendors';
	protected $_contactInstance = null;
	/**
	 * constructor
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function _construct(){
		parent::_construct();
		$this->_init('vendors/managevendors');
	}
	/**
	 * before save manage vendors
	 * @access protected
	 * @return Vendor_Vendors_Model_Managevendors
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
	 * save managevendors relation
	 * @access public
	 * @return Vendor_Vendors_Model_Managevendors
	 * @author Ultimate Module Creator
	 */
	protected function _afterSave() {
		$this->getContactInstance()->saveManagevendorsRelation($this);
		return parent::_afterSave();
	}
	/**
	 * get contact relation model
	 * @access public
	 * @return Vendor_Vendors_Model_Managevendors_Contact
	 * @author Ultimate Module Creator
	 */
	public function getContactInstance(){
		if (!$this->_contactInstance) {
			$this->_contactInstance = Mage::getSingleton('vendors/managevendors_contact');
		}
		return $this->_contactInstance;
	}
	/**
	 * get selected contacts array
	 * @access public
	 * @return array
	 * @author Ultimate Module Creator
	 */
	public function getSelectedContacts(){
		if (!$this->hasSelectedContacts()) {
			$contacts = array();
			foreach ($this->getSelectedContactsCollection() as $contact) {
				$contacts[] = $contact;
			}
			$this->setSelectedContacts($contacts);
		}
		return $this->getData('selected_contacts');
	}
	/**
	 * Retrieve collection selected contacts
	 * @access public
	 * @return Vendor_Vendors_Model_Managevendors_Contact_Collection
	 * @author Ultimate Module Creator
	 */
	public function getSelectedContactsCollection(){
		$collection = $this->getContactInstance()->getContactsCollection($this);
		return $collection;
	}
	
	/**
	 * function for save contact
	 */
	
	public function saveContact($vendor_id){
		
		
		$tablename_contact = Mage::getSingleton("core/resource")->getTableName('vendors_contact');
		$tablename_manager_contact = Mage::getSingleton("core/resource")->getTableName('vendors_managevendors_contact');
		
		$connection = Mage::getSingleton('core/resource')->getConnection('core_write');
		
		if($_POST['primary']=='1'){
			$this->updateContactPrimary($vendor_id);
		}
		
		$fields = array(
				'firstname'    	  => $_POST['firstname'],
				'lastname'  	  => $_POST['lastname'],
				'title'   		  => $_POST['title'],
				'officeno' 		  => $_POST['officeno'],
				'mobileno' 		  => $_POST['mobileno'],
				'email' 		  => $_POST['email'],
				'primary'	      => $_POST['primary'],
				'status' 		  => $_POST['status'],
				'created_at' 	  => date("Y-m-d H:i:s"),
				'updated_at' 	  => date("Y-m-d H:i:s")
		);
			
		$connection->insert($tablename_contact, $fields);
		$lastInsertId  = $connection->fetchOne('SELECT last_insert_id()');
		
		$fields_vendor_contact = array(
				'contact_id'    	  => $lastInsertId,
				'managevendors_id'  	  => $vendor_id
				
		);
			
		$connection->insert($tablename_manager_contact, $fields_vendor_contact);
		
	}
	
	/**
	 * function for edit contact
	 */
	
	public function editContact($vendor_id){
	
	
		$tablename_contact = Mage::getSingleton("core/resource")->getTableName('vendors_contact');
		
		$connection = Mage::getSingleton('core/resource')->getConnection('core_write');
	
		if($_POST['primary']=='1'){
			$this->updateContactPrimary($vendor_id);
		}
	
		$fields = array(
				'firstname'    	  => $_POST['firstname'],
				'lastname'  	  => $_POST['lastname'],
				'title'   		  => $_POST['title'],
				'officeno' 		  => $_POST['officeno'],
				'mobileno' 		  => $_POST['mobileno'],
				'email' 		  => $_POST['email'],
				'primary'	      => $_POST['primary'],
				'status' 		  => $_POST['status'],
				'updated_at' 	  => date("Y-m-d H:i:s")
		);
			
		$where = $connection->quoteInto('entity_id =?', $_POST['entity_id']);
		$connection->update($tablename_contact, $fields,$where);
	
	}
	
	public function updateContactPrimary($vendor_id){
		
		$tableName = Mage::getSingleton("core/resource")->getTableName('vendors_managevendors_contact');
		$tablename_vendor_cotact = Mage::getSingleton("core/resource")->getTableName('vendors_contact');
		
		$connection = Mage::getSingleton('core/resource')
		->getConnection('core_write');
		
		$query = "SELECT * FROM  $tableName  as ven
		LEFT JOIN  $tablename_vendor_cotact as ven_con
		ON ven_con.entity_id = ven.contact_id
		WHERE ven.managevendors_id = '$vendor_id'";
		$contact_data = $connection->fetchAll($query);
		
		if(!empty($contact_data)){
			foreach($contact_data as $contact_val){
				
				$fields = array(
						'primary'      => '0',
						'updated_at' => date("Y-m-d H:i:s")
				);
				$where = $connection->quoteInto('entity_id =?', $contact_val['entity_id']);
				$connection->update($tablename_vendor_cotact, $fields,$where);
			}
		}
	}
	
	public function getContact($vendor_id){
		$tableName = Mage::getSingleton("core/resource")->getTableName('vendors_contact');
		
		
		$connection = Mage::getSingleton('core/resource')
		->getConnection('core_write');
		
		$contact_id = $_POST['contact_id'];
		
		$query = "SELECT * FROM  $tableName  as ven
		WHERE ven.entity_id = '$contact_id'";
		$contact_data = $connection->fetchAll($query);
		return json_encode($contact_data[0]);
	}
	
	public function getVendorDropDwondata(){
		$tableName = Mage::getSingleton("core/resource")->getTableName('vendors_managevendors');
		 $connection = Mage::getSingleton('core/resource')
		->getConnection('core_write');
		
		$query = "SELECT * FROM  $tableName Where active ='1' AND vendor_parent_id = '0'";
		$vendor_data = $connection->fetchAll($query);
		
		
		$final_vendor_data['0']['value'] = '0';
		$final_vendor_data['0']['label'] = 'Parent';
		$counter = '1';
		foreach($vendor_data as $key =>  $vendor_value){
			
			$final_vendor_data[$counter]['value'] = $vendor_value['entity_id'];
			$final_vendor_data[$counter]['label'] = ucfirst($vendor_value['vendorname']);
			$counter++;
		}
		return $final_vendor_data;
	}
}