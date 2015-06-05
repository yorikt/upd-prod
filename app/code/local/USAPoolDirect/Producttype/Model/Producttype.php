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
 * ProductTypes model
 *
 * @category	USAPoolDirect
 * @package		USAPoolDirect_Producttype
 * @author Ultimate Module Creator
 */
class USAPoolDirect_Producttype_Model_Producttype extends Mage_Core_Model_Abstract{
	/**
	 * Entity code.
	 * Can be used as part of method name for entity processing
	 */
	const ENTITY= 'producttype_producttype';
	const CACHE_TAG = 'producttype_producttype';
	/**
	 * Prefix of model events names
	 * @var string
	 */
	protected $_eventPrefix = 'producttype_producttype';
	
	/**
	 * Parameter name in event
	 * @var string
	 */
	protected $_eventObject = 'producttype';
	protected $_productInstance = null;
	/**
	 * constructor
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function _construct(){
		parent::_construct();
		$this->_init('producttype/producttype');
	}
	/**
	 * before save producttypes
	 * @access protected
	 * @return USAPoolDirect_Producttype_Model_Producttype
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
	 * save producttype relation
	 * @access public
	 * @return USAPoolDirect_Producttype_Model_Producttype
	 * @author Ultimate Module Creator
	 */
	protected function _afterSave() {
		$this->getProductInstance()->saveProducttypeRelation($this);
		return parent::_afterSave();
	}
	/**
	 * get product relation model
	 * @access public
	 * @return USAPoolDirect_Producttype_Model_Producttype_Product
	 * @author Ultimate Module Creator
	 */
	public function getProductInstance(){
		if (!$this->_productInstance) {
			$this->_productInstance = Mage::getSingleton('producttype/producttype_product');
		}
		return $this->_productInstance;
	}
	/**
	 * get selected products array
	 * @access public
	 * @return array
	 * @author Ultimate Module Creator
	 */
	public function getSelectedProducts(){
		if (!$this->hasSelectedProducts()) {
			$products = array();
			foreach ($this->getSelectedProductsCollection() as $product) {
				$products[] = $product;
			}
			$this->setSelectedProducts($products);
		}
		return $this->getData('selected_products');
	}
	/**
	 * Retrieve collection selected products
	 * @access public
	 * @return USAPoolDirect_Producttype_Resource_Producttype_Product_Collection
	 * @author Ultimate Module Creator
	 */
	public function getSelectedProductsCollection(){
		$collection = $this->getProductInstance()->getProductCollection($this);
		return $collection;
	}
}