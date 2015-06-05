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
class USAPoolDirect_Producttype_Model_Resource_Producttype_Product extends Mage_Core_Model_Resource_Db_Abstract{
/**
	 * initialize resource model
	 * @access protected
	 * @return void
	 * @see Mage_Core_Model_Resource_Abstract::_construct()
	 * @author Ultimate Module Creator
	 */
	protected function  _construct(){
		$this->_init('producttype/producttype_product', 'rel_id');
	}
	/**
	 * Save producttype - product relations
	 * @access public
	 * @param USAPoolDirect_Producttype_Model_Producttype $producttype
	 * @param array $data
	 * @return USAPoolDirect_Producttype_Model_Resource_Producttype_Product
	 * @author Ultimate Module Creator
	 */
	public function saveProducttypeRelation($producttype, $data){
		if (!is_array($data)) {
			$data = array();
		}
		$deleteCondition = $this->_getWriteAdapter()->quoteInto('producttype_id=?', $producttype->getId());
		$this->_getWriteAdapter()->delete($this->getMainTable(), $deleteCondition);

		foreach ($data as $productId => $info) {
			$this->_getWriteAdapter()->insert($this->getMainTable(), array(
				'producttype_id'  	=> $producttype->getId(),
				'product_id' 	=> $productId,
				'position'  	=> @$info['position']
			));
		}
		return $this;
	}
	/**
	 * Save  product - producttype relations
	 * @access public
	 * @param Mage_Catalog_Model_Product $prooduct
	 * @param array $data
	 * @return USAPoolDirect_Producttype_Model_Resource_Producttype_Product
	 * @@author Ultimate Module Creator
	 */
	public function saveProductRelation($product, $data){
		if (!is_array($data)) {
			$data = array();
		}
		$deleteCondition = $this->_getWriteAdapter()->quoteInto('product_id=?', $product->getId());
		$this->_getWriteAdapter()->delete($this->getMainTable(), $deleteCondition);
		
		foreach ($data as $producttypeId => $info) {
			$this->_getWriteAdapter()->insert($this->getMainTable(), array(
				'producttype_id' => $producttypeId,
				'product_id' => $product->getId(),
				'position'   => @$info['position']
			));
		}
		return $this;
	}
	
	/**
	 * code for add key in db for related prdouct by jems
	 *
	 */
	public function saveProductKey($product, $data){
		if (!is_array($data)) {
			$data = array();
		}
	
		$resource = Mage::getSingleton('core/resource');
		$tableName = $resource->getTableName('producttype_producttype_product_related');
	
		$deleteCondition = $this->_getWriteAdapter()->quoteInto('product_id=?', $product->getId());
		$this->_getWriteAdapter()->delete($tableName, $deleteCondition);
	
		foreach ($data as $producttypeId => $info) {
			if(isset($info['prodkey'])){
	
	
	
				$this->_getWriteAdapter()->insert($tableName, array(
						'related_product_id' => $producttypeId,
						'product_id' => $product->getId(),
						'product_key'   => $info['prodkey']
				));
			}
		}
		return $this;
	
	}
}