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
 * Manage Vendors resource model
 *
 * @category	Vendor
 * @package		Vendor_Vendors
 * @author Ultimate Module Creator
 */
class Vendor_Vendors_Model_Resource_Managevendors extends Mage_Core_Model_Resource_Db_Abstract{
	/**
	 * constructor
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function _construct(){
		$this->_init('vendors/managevendors', 'entity_id');
	}
	
	/**
	 * Get store ids to which specified item is assigned
	 * @access public
	 * @param int $managevendorsId
	 * @return array
	 * @author Ultimate Module Creator
	 */
	public function lookupStoreIds($managevendorsId){
		$adapter = $this->_getReadAdapter();
		$select  = $adapter->select()
			->from($this->getTable('vendors/managevendors_store'), 'store_id')
			->where('managevendors_id = ?',(int)$managevendorsId);
		return $adapter->fetchCol($select);
	}
	/**
	 * Perform operations after object load
	 * @access public
	 * @param Mage_Core_Model_Abstract $object
	 * @return Vendor_Vendors_Model_Resource_Managevendors
	 * @author Ultimate Module Creator
	 */
	protected function _afterLoad(Mage_Core_Model_Abstract $object){
		if ($object->getId()) {
			$stores = $this->lookupStoreIds($object->getId());
			$object->setData('store_id', $stores);
		}
		return parent::_afterLoad($object);
	}

	/**
	 * Retrieve select object for load object data
	 *
	 * @param string $field
	 * @param mixed $value
	 * @param Vendor_Vendors_Model_Managevendors $object
	 * @return Zend_Db_Select
	 */
	protected function _getLoadSelect($field, $value, $object){
		$select = parent::_getLoadSelect($field, $value, $object);
		if ($object->getStoreId()) {
			$storeIds = array(Mage_Core_Model_App::ADMIN_STORE_ID, (int)$object->getStoreId());
			$select->join(
				array('vendors_managevendors_store' => $this->getTable('vendors/managevendors_store')),
				$this->getMainTable() . '.entity_id = vendors_managevendors_store.managevendors_id',
				array()
			)
			->where('vendors_managevendors_store.store_id IN (?)', $storeIds)
			->order('vendors_managevendors_store.store_id DESC')
			->limit(1);
		}
		return $select;
	}
	/**
	 * Assign manage vendors to store views
	 * @access protected
	 * @param Mage_Core_Model_Abstract $object
	 * @return Vendor_Vendors_Model_Resource_Managevendors
	 * @author Ultimate Module Creator
	 */
	protected function _afterSave(Mage_Core_Model_Abstract $object){
		$oldStores = $this->lookupStoreIds($object->getId());
		$newStores = (array)$object->getStores();
		if (empty($newStores)) {
			$newStores = (array)$object->getStoreId();
		}
		$table  = $this->getTable('vendors/managevendors_store');
		$insert = array_diff($newStores, $oldStores);
		$delete = array_diff($oldStores, $newStores);
		if ($delete) {
			$where = array(
				'managevendors_id = ?' => (int) $object->getId(),
				'store_id IN (?)' => $delete
			);
			$this->_getWriteAdapter()->delete($table, $where);
		}
		if ($insert) {
			$data = array();
			foreach ($insert as $storeId) {
				$data[] = array(
					'managevendors_id'  => (int) $object->getId(),
					'store_id' => (int) $storeId
				);
			}
			$this->_getWriteAdapter()->insertMultiple($table, $data);
		}
		return parent::_afterSave($object);
	}}