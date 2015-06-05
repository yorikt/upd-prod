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
 * Product helper
 *
 * @category	USAPoolDirect
 * @package		USAPoolDirect_Producttype
 * @author Ultimate Module Creator
 */
class USAPoolDirect_Producttype_Helper_Product extends USAPoolDirect_Producttype_Helper_Data{
	/**
	 * get the selected producttypes for a product
	 * @access public
	 * @param Mage_Catalog_Model_Product $product
	 * @return array()
	 * @author Ultimate Module Creator
	 */
	public function getSelectedProducttypes(Mage_Catalog_Model_Product $product){
		if (!$product->hasSelectedProducttypes()) {
			$producttypes = array();
			foreach ($this->getSelectedProducttypesCollection($product) as $producttype) {
				$producttypes[] = $producttype;
			}
			$product->setSelectedProducttypes($producttypes);
		}
		return $product->getData('selected_producttypes');
	}
	/**
	 * get producttype collection for a product
	 * @access public
	 * @param Mage_Catalog_Model_Product $product
	 * @return USAPoolDirect_Producttype_Model_Resource_Producttype_Collection
	 */
	public function getSelectedProducttypesCollection(Mage_Catalog_Model_Product $product){
		$collection = Mage::getResourceSingleton('producttype/producttype_collection')
			->addProductFilter($product);
		return $collection;
	}
}