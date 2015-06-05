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
 * ProductTypes list on product page block
 *
 * @category	USAPoolDirect
 * @package		USAPoolDirect_Producttype
 * @author Ultimate Module Creator
 */
class USAPoolDirect_Producttype_Block_Catalog_Product_List_Producttype extends Mage_Catalog_Block_Product_Abstract{
	/**
	 * get the list of producttypes
	 * @access protected
	 * @return USAPoolDirect_Producttype_Model_Resource_Producttype_Collection 
	 * @author Ultimate Module Creator
	 */
	public function getProducttypeCollection(){
		if (!$this->hasData('producttype_collection')){
			$product = Mage::registry('product');
			$collection = Mage::getResourceSingleton('producttype/producttype_collection')
				->addStoreFilter(Mage::app()->getStore())

				->addFilter('status', 1)
				->addProductFilter($product);
			$collection->getSelect()->order('related_product.position', 'ASC');
			$this->setData('producttype_collection', $collection);
		}
		return $this->getData('producttype_collection');
	}
}
