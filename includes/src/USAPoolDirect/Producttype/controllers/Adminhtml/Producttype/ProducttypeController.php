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
 * ProductTypes admin controller
 *
 * @category	USAPoolDirect
 * @package		USAPoolDirect_Producttype
 * @author Ultimate Module Creator
 */
class USAPoolDirect_Producttype_Adminhtml_Producttype_ProducttypeController extends USAPoolDirect_Producttype_Controller_Adminhtml_Producttype{
	/**
	 * init the producttype
	 * @access protected
	 * @return USAPoolDirect_Producttype_Model_Producttype
	 */
	protected function _initProducttype(){
		$producttypeId  = (int) $this->getRequest()->getParam('id');
		$producttype	= Mage::getModel('producttype/producttype');
		if ($producttypeId) {
			$producttype->load($producttypeId);
		}
		Mage::register('current_producttype', $producttype);
		return $producttype;
	}
 	/**
	 * default action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function indexAction() {
		$this->loadLayout();
		$this->_title(Mage::helper('producttype')->__('Producttype'))
			 ->_title(Mage::helper('producttype')->__('ProductTypes'));
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
	 * edit producttypes - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function editAction() {
		$producttypeId	= $this->getRequest()->getParam('id');
		$producttype  	= $this->_initProducttype();
		if ($producttypeId && !$producttype->getId()) {
			$this->_getSession()->addError(Mage::helper('producttype')->__('This producttypes no longer exists.'));
			$this->_redirect('*/*/');
			return;
		}
		$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
		if (!empty($data)) {
			$producttype->setData($data);
		}
		Mage::register('producttype_data', $producttype);
		$this->loadLayout();
		$this->_title(Mage::helper('producttype')->__('Producttype'))
			 ->_title(Mage::helper('producttype')->__('ProductTypes'));
		if ($producttype->getId()){
			$this->_title($producttype->getProductType());
		}
		else{
			$this->_title(Mage::helper('producttype')->__('Add producttypes'));
		}
		if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) { 
			$this->getLayout()->getBlock('head')->setCanLoadTinyMce(true); 
		}
		$this->renderLayout();
	}
	/**
	 * new producttypes action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function newAction() {
		$this->_forward('edit');
	}
	/**
	 * save producttypes - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function saveAction() {
		if ($data = $this->getRequest()->getPost('producttype')) {
			try {
				$producttype = $this->_initProducttype();
				$producttype->addData($data);
				$products = $this->getRequest()->getPost('products', -1);
				if ($products != -1) {
					$producttype->setProductsData(Mage::helper('adminhtml/js')->decodeGridSerializedInput($products));
				}
				$producttype->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('producttype')->__('ProductTypes was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);
				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $producttype->getId()));
					return;
				}
				$this->_redirect('*/*/');
				return;
			} 
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				Mage::getSingleton('adminhtml/session')->setFormData($data);
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
			}
			catch (Exception $e) {
				Mage::logException($e);
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('producttype')->__('There was a problem saving the producttypes.'));
				Mage::getSingleton('adminhtml/session')->setFormData($data);
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
			}
		}
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('producttype')->__('Unable to find producttypes to save.'));
		$this->_redirect('*/*/');
	}
	/**
	 * delete producttypes - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0) {
			try {
				$producttype = Mage::getModel('producttype/producttype');
				$producttype->setId($this->getRequest()->getParam('id'))->delete();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('producttype')->__('ProductTypes was successfully deleted.'));
				$this->_redirect('*/*/');
				return; 
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('producttype')->__('There was an error deleteing producttypes.'));
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				Mage::logException($e);
				return;
			}
		}
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('producttype')->__('Could not find producttypes to delete.'));
		$this->_redirect('*/*/');
	}
	/**
	 * mass delete producttypes - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function massDeleteAction() {
		$producttypeIds = $this->getRequest()->getParam('producttype');
		if(!is_array($producttypeIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('producttype')->__('Please select producttypes to delete.'));
		}
		else {
			try {
				foreach ($producttypeIds as $producttypeId) {
					$producttype = Mage::getModel('producttype/producttype');
					$producttype->setId($producttypeId)->delete();
				}
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('producttype')->__('Total of %d producttypes were successfully deleted.', count($producttypeIds)));
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('producttype')->__('There was an error deleteing producttypes.'));
				Mage::logException($e);
			}
		}
		$this->_redirect('*/*/index');
	}
	/**
	 * mass status change - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function massStatusAction(){
		$producttypeIds = $this->getRequest()->getParam('producttype');
		if(!is_array($producttypeIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('producttype')->__('Please select producttypes.'));
		} 
		else {
			try {
				foreach ($producttypeIds as $producttypeId) {
				$producttype = Mage::getSingleton('producttype/producttype')->load($producttypeId)
							->setStatus($this->getRequest()->getParam('status'))
							->setIsMassupdate(true)
							->save();
				}
				$this->_getSession()->addSuccess($this->__('Total of %d producttypes were successfully updated.', count($producttypeIds)));
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('producttype')->__('There was an error updating producttypes.'));
				Mage::logException($e);
			}
		}
		$this->_redirect('*/*/index');
	}
	/**
	 * get grid of products action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function productsAction(){
		$this->_initProducttype();
		$this->loadLayout();
		$this->getLayout()->getBlock('producttype.edit.tab.product')
			->setProducttypeProducts($this->getRequest()->getPost('producttype_products', null));
		$this->renderLayout();
	}
	/**
	 * get grid of products action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function productsgridAction(){
		$this->_initProducttype();
		$this->loadLayout();
		$this->getLayout()->getBlock('producttype.edit.tab.product')
			->setProducttypeProducts($this->getRequest()->getPost('producttype_products', null));
		$this->renderLayout();
	}
	/**
	 * export as csv - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function exportCsvAction(){
		$fileName   = 'producttype.csv';
		$content	= $this->getLayout()->createBlock('producttype/adminhtml_producttype_grid')->getCsv();
		$this->_prepareDownloadResponse($fileName, $content);
	}
	/**
	 * export as MsExcel - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function exportExcelAction(){
		$fileName   = 'producttype.xls';
		$content	= $this->getLayout()->createBlock('producttype/adminhtml_producttype_grid')->getExcelFile();
		$this->_prepareDownloadResponse($fileName, $content);
	}
	/**
	 * export as xml - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function exportXmlAction(){
		$fileName   = 'producttype.xml';
		$content	= $this->getLayout()->createBlock('producttype/adminhtml_producttype_grid')->getXml();
		$this->_prepareDownloadResponse($fileName, $content);
	}
}