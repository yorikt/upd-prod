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
 * Contact collection resource model
 *
 * @category	Vendor
 * @package		Vendor_Vendors
 * @author Ultimate Module Creator
 */
class Vendor_Vendors_Model_Resource_Contact_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract{
	protected $_joinedFields = array();
	/**
	 * constructor
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function _construct(){
		parent::_construct();
		$this->_init('vendors/contact');
		$this->_map['fields']['store'] = 'store_table.store_id';
	}
	/**
	 * get contacts as array
	 * @access protected
	 * @param string $valueField
	 * @param string $labelField
	 * @param array $additional
	 * @return array
	 * @author Ultimate Module Creator
	 */
	protected function _toOptionArray($valueField='entity_id', $labelField='firstname', $additional=array()){
		return parent::_toOptionArray($valueField, $labelField, $additional);
	}
	/**
	 * get options hash
	 * @access protected
	 * @param string $valueField
	 * @param string $labelField
	 * @return array
	 * @author Ultimate Module Creator
	 */
	protected function _toOptionHash($valueField='entity_id', $labelField='firstname'){
		return parent::_toOptionHash($valueField, $labelField);
	}
	/**
	 * Add filter by store
	 * @access public
	 * @param int|Mage_Core_Model_Store $store
	 * @param bool $withAdmin
	 * @return Vendor_Vendors_Model_Resource_Contact_Collection
	 * @author Ultimate Module Creator
	 */
	public function addStoreFilter($store, $withAdmin = true){
		if (!isset($this->_joinedFields['store'])){
			if ($store instanceof Mage_Core_Model_Store) {
				$store = array($store->getId());
			}
			if (!is_array($store)) {
				$store = array($store);
			}
			if ($withAdmin) {
				$store[] = Mage_Core_Model_App::ADMIN_STORE_ID;
			}
			$this->addFilter('store', array('in' => $store), 'public');
			$this->_joinedFields['store'] = true;
		}
		return $this;
	}
	/**
	 * Join store relation table if there is store filter
	 * @access protected
	 * @return Vendor_Vendors_Model_Resource_Contact_Collection
	 * @author Ultimate Module Creator
	 */
	protected function _renderFiltersBefore(){
		if ($this->getFilter('store')) {
			$this->getSelect()->join(
				array('store_table' => $this->getTable('vendors/contact_store')),
				'main_table.entity_id = store_table.contact_id',
				array()
			)->group('main_table.entity_id');
			/*
			 * Allow analytic functions usage because of one field grouping
			 */
			$this->_useAnalyticFunction = true;
		}
		return parent::_renderFiltersBefore();
	}
	/**
	 * Get SQL for get record count.
	 * Extra GROUP BY strip added.
	 * @access public
	 * @return Varien_Db_Select
	 * @author Ultimate Module Creator
	 */
	public function getSelectCountSql(){
		$countSelect = parent::getSelectCountSql();
		$countSelect->reset(Zend_Db_Select::GROUP);
		return $countSelect;
	}
	/**
	 * add the managevendors filter to collection
	 * @access public
	 * @param mixed (Vendor_Vendors_Model_Managevendors|int) $managevendors
	 * @return Vendor_Vendors_Model_Resource_Contact_Collection
	 * @author Ultimate Module Creator
	 */
	public function addManagevendorsFilter($managevendors){
		if ($managevendors instanceof Vendor_Vendors_Model_Managevendors){
			$managevendors = $managevendors->getId();
		}
		if (!isset($this->_joinedFields['managevendors'])){
			$this->getSelect()->join(
				array('related_managevendors' => $this->getTable('vendors/contact_managevendors')),
				'related_managevendors.contact_id = main_table.entity_id',
				array('position')
			);
			$this->getSelect()->where('related_managevendors.managevendors_id = ?', $managevendors);
			$this->_joinedFields['managevendors'] = true;
		}
		return $this;
	}
}