<?php 
/**
 * USAPoolDirect_Producttype extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category   	USAPoolDirect
 * @package		USAPoolDirect_Producttype
 * @copyright  	Copyright (c) 2014
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * ProductTypes - product relation model
 *
 * @category	USAPoolDirect
 * @package		USAPoolDirect_Producttype
 * @author Ultimate Module Creator
 */
class USAPoolDirect_Producttype_Model_Resource_Producttype_Productrule extends Mage_Core_Model_Resource_Db_Abstract{
/**
	 * initialize resource model
	 * @access protected
	 * @return void
	 * @see Mage_Core_Model_Resource_Abstract::_construct()
	 * @author Ultimate Module Creator
	 */
	protected function  _construct(){
		$this->_init('producttype/producttype_productrule', 'rel_id');
	}
	
	
/**
	 * Save producttype - product relations
	 * @access public
	 * @param USAPoolDirect_Producttype_Model_Producttype $producttype
	 * @param array $data
	 * @return USAPoolDirect_Producttype_Model_Resource_Producttype_Product
	 * @author Ultimate Module Creator
	 */
	public function saveProductruleRelation($data){

		
		//echo "<pre>data=";print_r($data);//exit;
		if (!is_array($data)) {
			$data = array();
		}
		
		$productId =  Mage::app()->getRequest()->getParam('id');
		$product_table = Mage::getSingleton("core/resource")->getTableName('catalog_product_entity');
		
		// general product data
			
		if($productId==''){
			$product = Mage::getModel('catalog/product');
			$product_entity_table = $product->getResource()->getEntityTable();    
			$resource = Mage::getSingleton('core/resource');
			$connection = $resource->getConnection('core_read');
			$result = $connection->showTableStatus($product_entity_table);
			$productId = $result['Auto_increment'];
		
		}

		if(!isset($_POST['product']['settings']))
		{
			$settings_data = $this->getProductCustomerSettings($productId);	
			if(empty($settings_data)){
				$data['product']['settings'] = '1';
			}
		}
	
		if(isset($data['product']['settings']) && $data['product']['settings']!='')
		{
			$tablename_group =  Mage::getSingleton("core/resource")->getTableName('productrule_productrule_customer_groups');
			$tablename_setting =  Mage::getSingleton("core/resource")->getTableName('productrule_productrule_customer_settings');
			$tablename_regions =  Mage::getSingleton("core/resource")->getTableName('productrule_productrule_regions');
		
			//for customer setting
			$deleteConditionSetting = $this->_getWriteAdapter()->quoteInto('product_id=?', $productId);
			$this->_getWriteAdapter()->delete($tablename_setting, $deleteConditionSetting);
		
		
			$this->_getWriteAdapter()->insert($tablename_setting, array(
				'settings_id'  	=> (int)$data['product']['settings'],
				'product_id' 	=> (int)$productId
			
			));
			//end for customer setting
		
			$deleteConditionGroup = $this->_getWriteAdapter()->quoteInto('product_id=?', $productId);
			$this->_getWriteAdapter()->delete($tablename_group, $deleteConditionGroup);
		
		
			$deleteConditionRegions = $this->_getWriteAdapter()->quoteInto('product_id=?', $productId);
			$this->_getWriteAdapter()->delete($tablename_regions, $deleteConditionRegions);
		
			// when product rule = all customer delete all data in group,settings  and region table
			//Insert groupId and regions_id =0
			if($data['product']['settings']=='1'){
				$this->_getWriteAdapter()->insert($tablename_group, array(
						'group_id'   => '0',
						'product_id'  => (int)$productId
				));
				$this->_getWriteAdapter()->insert($tablename_regions, array(
						'regions_id'   => '0',
						'product_id'  => (int)$productId
				));
			}
			//end			

			//for customer group
			if(!empty($data['product']['customer_ids'])){
			
				foreach($data['product']['customer_ids'] as $group_id){
					$this->_getWriteAdapter()->insert($tablename_group, array(
							'group_id'  	=> (int)$group_id,
							'product_id' 	=> (int)$productId
							
					));
				}
			}
			//end for customer group
		
			//for regions
			if(!empty($data['product']['regions'])){
			
				foreach($data['product']['regions'] as $regions_id){
					$this->_getWriteAdapter()->insert($tablename_regions, array(
							'regions_id'  	=> (int)$regions_id,
							'product_id' 	=> (int)$productId
			
					));
				}
			}
			//end for regions
		}
		return $this;
	}
	
	function getProductCustomerSettings($product_id){
		
		$tablename_setting =  Mage::getSingleton("core/resource")->getTableName('productrule_productrule_customer_settings');
		
		$connection = Mage::getSingleton('core/resource')
		->getConnection('core_read');
		$select = $connection->select()
		->from($tablename_setting, array('settings_id')) // select * from tablename or use array('id','name') selected values
		->where('product_id=?',$product_id);        
		$rowsArray = $connection->fetchAll($select); // return all rows
		
		return $rowsArray; 
	}
	
	function getProductCustomerGroup($product_id){
		
		$tablename =  Mage::getSingleton("core/resource")->getTableName('productrule_productrule_customer_groups');
		
		$connection = Mage::getSingleton('core/resource')
		->getConnection('core_read');
		$select = $connection->select()
		->from($tablename, array('group_id')) // select * from tablename or use array('id','name') selected values
		->where('product_id=?',$product_id);
		$rowsArray = $connection->fetchAll($select); // return all rows
		$data = array();
		foreach($rowsArray as $value){
			$data[] = $value['group_id'];
		}
		
		return $data;
		
	}
	
	function getProductRegions($product_id){
		
		$tablename =  Mage::getSingleton("core/resource")->getTableName('productrule_productrule_regions');
	
		$connection = Mage::getSingleton('core/resource')
		->getConnection('core_read');
		
		$select = $connection->select()
		->from($tablename, array('regions_id')) // select * from tablename or use array('id','name') selected values
		->where('product_id=?',$product_id);
		$rowsArray = $connection->fetchAll($select); // return all rows
		$data = array();
		foreach($rowsArray as $value){
			$data[] = $value['regions_id'];
		}
		
		return $data;
	
	}
}
