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
 * Adminhtml observer
 *
 * @category	USAPoolDirect
 * @package		USAPoolDirect_Producttype
 * @author Ultimate Module Creator
 */
class USAPoolDirect_Producttype_Model_Adminhtml_Observer{
	/**
	 * check if tab can be added
	 * @access protected
	 * @param Mage_Catalog_Model_Product $product
	 * @return bool
	 * @author Ultimate Module Creator
	 */
	protected function _canAddTab($product){
		if ($product->getId()){
			return true;
		}
		if (!$product->getAttributeSetId()){
			return false;
		}
		$request = Mage::app()->getRequest();
		if ($request->getParam('type') == 'configurable'){
			if ($request->getParam('attribtues')){
				return true;
			}
		}
		return true;
	}
	/**
	 * add the producttype tab to products
	 * @access public
	 * @param Varien_Event_Observer $observer
	 * @return USAPoolDirect_Producttype_Model_Adminhtml_Observer
	 * @author Ultimate Module Creator
	 */
	public function addProducttypeBlock($observer){
		$block = $observer->getEvent()->getBlock();
		$product = Mage::registry('product');
		if ($block instanceof Mage_Adminhtml_Block_Catalog_Product_Edit_Tabs && $this->_canAddTab($product)){
			$block->addTab('producttypes', array(
				'label' => Mage::helper('producttype')->__('Product Types'),
				'url'   => Mage::helper('adminhtml')->getUrl('adminhtml/producttype_producttype_catalog_product/producttypes', array('_current' => true)),
				'class' => 'ajax',
			));
		}
		return $this;
	}
	/**
	 * save producttype - product relation
	 * @access public
	 * @param Varien_Event_Observer $observer
	 * @return USAPoolDirect_Producttype_Model_Adminhtml_Observer
	 * @author Ultimate Module Creator
	 */
	public function saveProducttypeData($observer){
		
		//this code add for add ket for realted product
		$post_links = Mage::app()->getRequest()->getPost('links');
		if(isset($post_links['related']) && !empty($post_links['related'])){
			$product = Mage::registry('product');
			$post_related = Mage::helper('adminhtml/js')->decodeGridSerializedInput($post_links['related']);
			Mage::getResourceSingleton('producttype/producttype_product')->saveProductKey($product, $post_related);
		}
		//end this code add for add ket for realted product
		
		
		$post = Mage::app()->getRequest()->getPost('producttypes', -1);
		if ($post != '-1') {
			$post = Mage::helper('adminhtml/js')->decodeGridSerializedInput($post);
			$product = Mage::registry('product');
			//set code for radio buttom
			
			if(Mage::app()->getRequest()->getPost('in_producttypes')){
				$type_post = Mage::app()->getRequest()->getPost('in_producttypes');
		
				foreach($post as $post_val){
					$post_data[$type_post['0']] = $post_val; 
				}
			}else{
				$post_data = $post;
			}
			
			
			$producttypeProduct = Mage::getResourceSingleton('producttype/producttype_product')->saveProductRelation($product, $post_data);
		}
		return $this;
	}}