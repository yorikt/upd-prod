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
 * ProductTypes product model
 *
 * @category	USAPoolDirect
 * @package		USAPoolDirect_Producttype
 * @author Ultimate Module Creator
 */
class USAPoolDirect_Producttype_Model_Producttype_Product extends Mage_Core_Model_Abstract{
	/**
	 * Initialize resource
	 * @access protected
	 * @return void
	 * @author Ultimate Module Creator
	 */
	protected function _construct(){
		$this->_init('producttype/producttype_product');
	}
	/**
	 * Save data for producttype-product relation
	 * @access public
	 * @param  USAPoolDirect_Producttype_Model_Producttype $producttype
	 * @return USAPoolDirect_Producttype_Model_Producttype_Product
	 * @author Ultimate Module Creator
	 */
	public function saveProducttypeRelation($producttype){
		$data = $producttype->getProductsData();
		if (!is_null($data)) {
			$this->_getResource()->saveProducttypeRelation($producttype, $data);
		}
		return $this;
	}
	/**
	 * get products for producttype
	 * @access public
	 * @param USAPoolDirect_Producttype_Model_Producttype $producttype
	 * @return USAPoolDirect_Producttype_Model_Resource_Producttype_Product_Collection
	 * @author Ultimate Module Creator
	 */
	public function getProductCollection($producttype){
		$collection = Mage::getResourceModel('producttype/producttype_product_collection')
			->addProducttypeFilter($producttype);
		return $collection;
	}
}