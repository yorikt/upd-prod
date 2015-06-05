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
 * Vendor Pricing admin controller
 *
 * @category	Vendor
 * @package		Vendor_Vendorpricing
 * @author Ultimate Module Creator
 */
class Vendor_Vendorpricing_Adminhtml_Vendorpricing_VendorpricingController extends Vendor_Vendorpricing_Controller_Adminhtml_Vendorpricing{
	/**
	 * init the vendorpricing
	 * @access protected
	 * @return Vendor_Vendorpricing_Model_Vendorpricing
	 */
	protected function _initVendorpricing(){
		$vendorpricingId  = (int) $this->getRequest()->getParam('id');
		$vendorpricing	= Mage::getModel('vendorpricing/vendorpricing');
		if ($vendorpricingId) {
			$vendorpricing->load($vendorpricingId);
		}
		Mage::register('current_vendorpricing', $vendorpricing);
		return $vendorpricing;
	}
 	/**
	 * default action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function indexAction() {
		$this->loadLayout();
		$this->_title(Mage::helper('vendorpricing')->__('Vendorpricing'))
			 ->_title(Mage::helper('vendorpricing')->__('Vendor Pricings'));
		$this->renderLayout();
	}
	/**
	 * grid action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function gridAction() {
		$this->loadLayout()->renderLayout();
	}
	/**
	 * edit vendor pricing - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function editAction() {
		$vendorpricingId	= $this->getRequest()->getParam('id');
		$vendorpricing  	= $this->_initVendorpricing();
		if ($vendorpricingId && !$vendorpricing->getId()) {
			$this->_getSession()->addError(Mage::helper('vendorpricing')->__('This vendor pricing no longer exists.'));
			$this->_redirect('/vendors_managevendors/index/');
			return;
		}
		$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
		if (!empty($data)) {
			$vendorpricing->setData($data);
		}
		Mage::register('vendorpricing_data', $vendorpricing);
		$this->loadLayout();
		$this->_title(Mage::helper('vendorpricing')->__('Vendorpricing'))
			 ->_title(Mage::helper('vendorpricing')->__('Vendor Pricings'));
		if ($vendorpricing->getId()){
			$this->_title($vendorpricing->getPartNumber());
		}
		else{
			$this->_title(Mage::helper('vendorpricing')->__('Add vendor pricing'));
		}
		if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) { 
			$this->getLayout()->getBlock('head')->setCanLoadTinyMce(true); 
		}
		$this->renderLayout();
	}
	/**
	 * new vendor pricing action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function newAction() {
		$this->_forward('edit');
	}
	/**
	 * save vendor pricing - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function saveAction() {
		if ($data = $this->getRequest()->getPost('vendorpricing')) {
			//code for match sku
			$collection = $_product = Mage::getModel('catalog/product')->load($data['products']);
			try {
				
				if($collection->getsku()!=$data['part_number']){
					throw new Exception('');
				}
				//end code for match sku
				
				$vendorpricing = $this->_initVendorpricing();
				$vendorpricing->addData($data);
				$vendorpricing->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('vendorpricing')->__('Vendor Pricing was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);
				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('/vendors_managevendors/edit/id/'.$data['vendor_id']);
					return;
				}
				$this->_redirect('/vendors_managevendors/edit/id/'.$data['vendor_id']);
				return;
			} 
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				//Mage::getSingleton('adminhtml/session')->setFormData($data);
				$this->_redirect('/vendors_managevendors/edit/id/'.$data['vendor_id']);
				return;
			}
			catch (Exception $e) {
				Mage::logException($e);
				if($collection->getsku()!=$data['part_number']){
					Mage::getSingleton('adminhtml/session')->addError(Mage::helper('vendorpricing')->__('Part number must be same as SKU.'));
				}else{
					Mage::getSingleton('adminhtml/session')->addError(Mage::helper('vendorpricing')->__('There was a problem saving the vendor pricing.'));
					//Mage::getSingleton('adminhtml/session')->setFormData($data);
				}
				$this->_redirect('/vendors_managevendors/edit/id/'.$data['vendor_id']);
				return;
			}
		}
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('vendorpricing')->__('Unable to find vendor pricing to save.'));
		$this->_redirect('/vendors_managevendors/edit/id/'.$data['vendor_id']);
	}
	/**
	 * delete vendor pricing - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function deleteAction() {
		
		
		if( $this->getRequest()->getParam('id') > 0) {
			try {
				$vendorpricing = Mage::getModel('vendorpricing/vendorpricing');
				$vendorpricing->setId($this->getRequest()->getParam('id'))->delete();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('vendorpricing')->__('Vendor Pricing was successfully deleted.'));
				$this->_redirect('/vendors_managevendors/edit/id/'.$this->getRequest()->getParam('vendor_id'));
				return; 
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('/vendors_managevendors/edit/id/'.$this->getRequest()->getParam('vendor_id'));
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('vendorpricing')->__('There was an error deleteing vendor pricing.'));
				$this->_redirect('/vendors_managevendors/edit/id/'.$this->getRequest()->getParam('vendor_id'));
				Mage::logException($e);
				return;
			}
		}
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('vendorpricing')->__('Could not find vendor pricing to delete.'));
		$this->_redirect('*/*/');
	}
	/**
	 * mass delete vendor pricing - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function massDeleteAction() {
		$vendorpricingIds = $this->getRequest()->getParam('vendorpricing');
		if(!is_array($vendorpricingIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('vendorpricing')->__('Please select vendor pricings to delete.'));
		}
		else {
			try {
				foreach ($vendorpricingIds as $vendorpricingId) {
					$vendorpricing = Mage::getModel('vendorpricing/vendorpricing');
					$vendorpricing->setId($vendorpricingId)->delete();
				}
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('vendorpricing')->__('Total of %d vendor pricings were successfully deleted.', count($vendorpricingIds)));
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('vendorpricing')->__('There was an error deleteing vendor pricings.'));
				Mage::logException($e);
			}
		}
		$this->_redirect('/vendors_managevendors/index/');
	}
	/**
	 * mass status change - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function massStatusAction(){
		$vendorpricingIds = $this->getRequest()->getParam('vendorpricing');
		if(!is_array($vendorpricingIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('vendorpricing')->__('Please select vendor pricings.'));
		} 
		else {
			try {
				foreach ($vendorpricingIds as $vendorpricingId) {
				$vendorpricing = Mage::getSingleton('vendorpricing/vendorpricing')->load($vendorpricingId)
							->setStatus($this->getRequest()->getParam('status'))
							->setIsMassupdate(true)
							->save();
				}
				$this->_getSession()->addSuccess($this->__('Total of %d vendor pricings were successfully updated.', count($vendorpricingIds)));
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('vendorpricing')->__('There was an error updating vendor pricings.'));
				Mage::logException($e);
			}
		}
		$this->_redirect('*/*/index');
	}
	/**
	 * mass Product change - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function massProductsAction(){
		$vendorpricingIds = $this->getRequest()->getParam('vendorpricing');
		if(!is_array($vendorpricingIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('vendorpricing')->__('Please select vendor pricings.'));
		} 
		else {
			try {
				foreach ($vendorpricingIds as $vendorpricingId) {
				$vendorpricing = Mage::getSingleton('vendorpricing/vendorpricing')->load($vendorpricingId)
							->setProducts($this->getRequest()->getParam('flag_products'))
							->setIsMassupdate(true)
							->save();
				}
				$this->_getSession()->addSuccess($this->__('Total of %d vendor pricings were successfully updated.', count($vendorpricingIds)));
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('vendorpricing')->__('There was an error updating vendor pricings.'));
				Mage::logException($e);
			}
		}
		$this->_redirect('*/*/index');
	}
	/**
	 * export as csv - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function exportCsvAction(){
		$fileName   = 'vendorpricing.csv';
		$content	= $this->getLayout()->createBlock('vendorpricing/adminhtml_vendorpricing_grid')->getCsv();
		$this->_prepareDownloadResponse($fileName, $content);
	}
	/**
	 * export as MsExcel - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function exportExcelAction(){
		$fileName   = 'vendorpricing.xls';
		$content	= $this->getLayout()->createBlock('vendorpricing/adminhtml_vendorpricing_grid')->getExcelFile();
		$this->_prepareDownloadResponse($fileName, $content);
	}
	/**
	 * export as xml - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function exportXmlAction(){
		$fileName   = 'vendorpricing.xml';
		$content	= $this->getLayout()->createBlock('vendorpricing/adminhtml_vendorpricing_grid')->getXml();
		$this->_prepareDownloadResponse($fileName, $content);
	}
}