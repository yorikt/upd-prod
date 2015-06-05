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
 * ProductTypes - product relation resource model collection
 *
 * @category	USAPoolDirect
 * @package		USAPoolDirect_Producttype
 * @author Ultimate Module Creator
 */
class USAPoolDirect_Producttype_Model_Resource_Producttype_Product_Collection extends Mage_Catalog_Model_Resource_Product_Collection{
	/**
	 * remember if fields have been joined
	 * @var bool
	 */
	protected $_joinedFields = false;
	/**
	 * join the link table
	 * @access public
	 * @return USAPoolDirect_Producttype_Model_Resource_Producttype_Product_Collection
	 * @author Ultimate Module Creator
	 */
	public function joinFields(){
		if (!$this->_joinedFields){
			$this->getSelect()->join(
				array('related' => $this->getTable('producttype/producttype_product')),
				'related.product_id = e.entity_id',
				array('position')
			);
			$this->_joinedFields = true;
		}
		return $this;
	}
	/**
	 * add producttype filter
	 * @access public
	 * @param USAPoolDirect_Producttype_Model_Producttype | int $producttype
	 * @return USAPoolDirect_Producttype_Model_Resource_Producttype_Product_Collection
	 * @author Ultimate Module Creator
	 */
	public function addProducttypeFilter($producttype){
		if ($producttype instanceof USAPoolDirect_Producttype_Model_Producttype){
			$producttype = $producttype->getId();
		}
		if (!$this->_joinedFields){
			$this->joinFields();
		}
		$this->getSelect()->where('related.producttype_id = ?', $producttype);
		return $this;
	}
}