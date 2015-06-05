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
 * Vendor Pricing model
 *
 * @category	Vendor
 * @package		Vendor_Vendorpricing
 * @author Ultimate Module Creator
 */
class Vendor_Vendorpricing_Model_Vendorpricing extends Mage_Core_Model_Abstract{
	/**
	 * Entity code.
	 * Can be used as part of method name for entity processing
	 */
	const ENTITY= 'vendorpricing_vendorpricing';
	const CACHE_TAG = 'vendorpricing_vendorpricing';
	/**
	 * Prefix of model events names
	 * @var string
	 */
	protected $_eventPrefix = 'vendorpricing_vendorpricing';
	
	/**
	 * Parameter name in event
	 * @var string
	 */
	protected $_eventObject = 'vendorpricing';
	/**
	 * constructor
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function _construct(){
		parent::_construct();
		$this->_init('vendorpricing/vendorpricing');
	}
	/**
	 * before save vendor pricing
	 * @access protected
	 * @return Vendor_Vendorpricing_Model_Vendorpricing
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
	 * save vendorpricing relation
	 * @access public
	 * @return Vendor_Vendorpricing_Model_Vendorpricing
	 * @author Ultimate Module Creator
	 */
	protected function _afterSave() {
		return parent::_afterSave();
	}
	
	/**
	 * get product array assigned for vendor pricing
	 */
	
	public function getProductVendorPricing($vendor_id){
		
		$collection = Mage::getModel('catalog/product')->getCollection()->addAttributeToSelect('*')->addAttributeToFilter('type_id', Mage_Catalog_Model_Product_Type::TYPE_SIMPLE)->setOrder('name', 'ASC');
		
		
		$vendor_pricing = Mage::getModel('vendorpricing/vendorpricing')->getCollection()->addFieldToFilter(array('vendor_id'),array($vendor_id));
		$vendor_pricing_arr = array();
		foreach($vendor_pricing as $key=>$value){
			$vendor_data = $value->getData();
			$vendor_pricing_arr[] = $vendor_data['products'];
		}
		
		
		$product_data = array();
		$counter = '0';
		foreach($collection as $key=>$simpleProduct){
				
			if($counter=='0'){
				$product_data[$counter] = '';
		
			}else{
				$product =  $simpleProduct->getData();
				if(!in_array($product['entity_id'],$vendor_pricing_arr)){
		
					$product_cost = ($simpleProduct->getCost()=='')?'0':$simpleProduct->getCost();
					$product_data[$counter]['value'] = $simpleProduct->getId().'@@@'.$simpleProduct->getSku().'@@@'.$simpleProduct->getName().'@@@'.$product_cost;
					$product_data[$counter]['label'] = $simpleProduct->getName();
				}
			}
			$counter++;
		}
		
		return $product_data;
		
	}
	
}