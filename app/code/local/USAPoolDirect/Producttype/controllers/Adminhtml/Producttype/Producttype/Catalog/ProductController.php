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
 * Producttype product admin controller
 *
 * @category	USAPoolDirect
 * @package		USAPoolDirect_Producttype
 * @author Ultimate Module Creator
 */
require_once ("Mage/Adminhtml/controllers/Catalog/ProductController.php");
class USAPoolDirect_Producttype_Adminhtml_Producttype_Producttype_Catalog_ProductController extends Mage_Adminhtml_Catalog_ProductController{
	/**
	 * construct
	 * @access protected
	 * @return void
	 * @author Ultimate Module Creator
	 */
	protected function _construct(){
		// Define module dependent translate
		$this->setUsedModuleName('USAPoolDirect_Producttype');
	}
	/**
	 * producttypes in the catalog page
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function producttypesAction(){
		$this->_initProduct();
		$this->loadLayout();
		$this->getLayout()->getBlock('product.edit.tab.producttype')
			->setProductProducttypes($this->getRequest()->getPost('product_producttypes', null));
		$this->renderLayout();
	}
	/**
	 * producttypes grid in the catalog page
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function producttypesGridAction(){
		$this->_initProduct();
		$this->loadLayout();
		$this->getLayout()->getBlock('product.edit.tab.producttype')
			->setProductProducttypes($this->getRequest()->getPost('product_producttypes', null));
		$this->renderLayout();
	}
}