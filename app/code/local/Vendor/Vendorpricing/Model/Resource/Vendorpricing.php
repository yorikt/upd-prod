<?php
/**
 * Vendor_Vendorpricing extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category   	Vendor
 * @package		Vendor_Vendorpricing
 * @copyright  	Copyright (c) 2014
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Vendor Pricing resource model
 *
 * @category	Vendor
 * @package		Vendor_Vendorpricing
 * @author Ultimate Module Creator
 */
class Vendor_Vendorpricing_Model_Resource_Vendorpricing extends Mage_Core_Model_Resource_Db_Abstract{
	/**
	 * constructor
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function _construct(){
		$this->_init('vendorpricing/vendorpricing', 'entity_id');
	}
	
	/**
	 * Get store ids to which specified item is assigned
	 * @access public
	 * @param int $vendorpricingId
	 * @return array
	 * @author Ultimate Module Creator
	 */
	public function lookupStoreIds($vendorpricingId){
		$adapter = $this->_getReadAdapter();
		$select  = $adapter->select()
			->from($this->getTable('vendorpricing/vendorpricing_store'), 'store_id')
			->where('vendorpricing_id = ?',(int)$vendorpricingId);
		return $adapter->fetchCol($select);
	}
	/**
	 * Perform operations after object load
	 * @access public
	 * @param Mage_Core_Model_Abstract $object
	 * @return Vendor_Vendorpricing_Model_Resource_Vendorpricing
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
	 * @param Vendor_Vendorpricing_Model_Vendorpricing $object
	 * @return Zend_Db_Select
	 */
	protected function _getLoadSelect($field, $value, $object){
		$select = parent::_getLoadSelect($field, $value, $object);
		if ($object->getStoreId()) {
			$storeIds = array(Mage_Core_Model_App::ADMIN_STORE_ID, (int)$object->getStoreId());
			$select->join(
				array('vendorpricing_vendorpricing_store' => $this->getTable('vendorpricing/vendorpricing_store')),
				$this->getMainTable() . '.entity_id = vendorpricing_vendorpricing_store.vendorpricing_id',
				array()
			)
			->where('vendorpricing_vendorpricing_store.store_id IN (?)', $storeIds)
			->order('vendorpricing_vendorpricing_store.store_id DESC')
			->limit(1);
		}
		return $select;
	}
	/**
	 * Assign vendor pricing to store views
	 * @access protected
	 * @param Mage_Core_Model_Abstract $object
	 * @return Vendor_Vendorpricing_Model_Resource_Vendorpricing
	 * @author Ultimate Module Creator
	 */
	protected function _afterSave(Mage_Core_Model_Abstract $object){
		$oldStores = $this->lookupStoreIds($object->getId());
		$newStores = (array)$object->getStores();
		if (empty($newStores)) {
			$newStores = (array)$object->getStoreId();
		}
		$table  = $this->getTable('vendorpricing/vendorpricing_store');
		$insert = array_diff($newStores, $oldStores);
		$delete = array_diff($oldStores, $newStores);
		if ($delete) {
			$where = array(
				'vendorpricing_id = ?' => (int) $object->getId(),
				'store_id IN (?)' => $delete
			);
			$this->_getWriteAdapter()->delete($table, $where);
		}
		if ($insert) {
			$data = array();
			foreach ($insert as $storeId) {
				$data[] = array(
					'vendorpricing_id'  => (int) $object->getId(),
					'store_id' => (int) $storeId
				);
			}
			$this->_getWriteAdapter()->insertMultiple($table, $data);
		}
		return parent::_afterSave($object);
	}

	public function saveUplodedData($data_array,$vendor_id){
	
		$resource = Mage::getSingleton('core/resource');
		$tableName = $resource->getTableName('vendorpricing_vendorpricing');
		
		$select = $this->_getWriteAdapter()->select()
            ->from($tableName, 'part_number')
            ->where('vendor_id=?', $vendor_id);
        $sku_data = $this->_getWriteAdapter()->fetchAll($select);
        $sku_arr = array();
        if(!empty($sku_data)){
			foreach($sku_data as $sku_val){
				$sku_arr[] = $sku_val['part_number'];
			}
        }
		
        //get only simple product data
        $product_data = array();
        $collection = Mage::getModel('catalog/product')->getCollection()->addAttributeToSelect('*')->addAttributeToFilter('type_id', Mage_Catalog_Model_Product_Type::TYPE_SIMPLE)->setOrder('name', 'ASC');
        foreach($collection as $key=>$simpleProduct){
        	
        		$product_data[] = $simpleProduct->getSku();
        		
        }
        //end get only simple product data
		
		$product = array();
		foreach ($data_array as $producttypeId => $info) {
			
			$product = Mage::getModel('catalog/product')->loadByAttribute('sku',$info['0']);
			
			//product not empty
			if(!empty($product)){
				//check prodcut is simple or not
				if(in_array($product->getSku(),$product_data)){
					//sku exists or not
					if(in_array($product->getSku(),$sku_arr)){
						
						$where = array();
						$where[] = $this->_getWriteAdapter()->quoteInto('vendor_id = ?', $vendor_id);
						$where[] = $this->_getWriteAdapter()->quoteInto('products = ?', $product->getId());
						$query = $this->_getWriteAdapter()->update($tableName, array(
										'products' => $product->getId(),
										'vendor_id' => $vendor_id,
										'products_name' => $product->getId().'@@@'.$product->getSku(),
										'part_number' => $product->getSku(),
										'part_cost' => ($product->getCost()=='')?'0':$product->getCost(),
										'part_description' => $product->getDescription(),
										'vendor_cost' => $info['1'],
										'vendor_descritption' => $info['2'],
										'vendor_part_number'   => $info['3'],
										'updated_at' => date('Y-m-d H:i:s'),
								),$where);
						
						Mage::getSingleton('adminhtml/session')->addNotice(Mage::helper('vendorpricing')->__('Product SKU '.$info['0'].' is updated successfully.'));
						
					}else{
						
						$this->_getWriteAdapter()->insert($tableName, array(
								'products' => $product->getId(),
								'vendor_id' => $vendor_id,
								'products_name' => $product->getId().'@@@'.$product->getSku(),
								'part_number' => $product->getSku(),
								'part_cost' => ($product->getCost()=='')?'0':$product->getCost(),
								'part_description' => $product->getDescription(),
								'vendor_cost' => $info['1'],
								'vendor_descritption' => $info['2'],
								'vendor_part_number'   => $info['3'],
								'status' => '1',
								'created_at' => date('Y-m-d H:i:s'),
								'updated_at' => date('Y-m-d H:i:s'),
						));
						Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('vendorpricing')->__('Product SKU '.$info['0'].' is added successfully.'));
						
					}//end sku exists or not
				}else{
					Mage::getSingleton('adminhtml/session')->addWarning(Mage::helper('vendorpricing')->__('Product SKU '.$info['0'].' is not a simple product.'));
				}//end check prodcut is simple or not
				
			}else{
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('vendorpricing')->__('Product SKU '.$info['0'].' is skipped.'));
			}//end if product not empty
				
		}
	
	
	}
}
	
	