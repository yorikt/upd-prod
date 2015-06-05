<?php
/**
 * USAPoolDirect_Purchaseorderitem extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category   	USAPoolDirect
 * @package		USAPoolDirect_Purchaseorderitem
 * @copyright  	Copyright (c) 2014
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Purchase Order Item admin controller
 *
 * @category	USAPoolDirect
 * @package		USAPoolDirect_Purchaseorderitem
 * @author Ultimate Module Creator
 */
class USAPoolDirect_Purchaseorderitem_Adminhtml_Purchaseorderitem_PurchaseorderitemController extends USAPoolDirect_Purchaseorderitem_Controller_Adminhtml_Purchaseorderitem{
	/**
	 * init the purchaseorderitem
	 * @access protected
	 * @return USAPoolDirect_Purchaseorderitem_Model_Purchaseorderitem
	 */
	protected function _initPurchaseorderitem(){
		$purchaseorderitemId  = (int) $this->getRequest()->getParam('id');
		$purchaseorderitem	= Mage::getModel('purchaseorderitem/purchaseorderitem');
		if ($purchaseorderitemId) {
			$purchaseorderitem->load($purchaseorderitemId);
		}
		Mage::register('current_purchaseorderitem', $purchaseorderitem);
		return $purchaseorderitem;
	}
 	/**
	 * default action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function indexAction() {
		$this->loadLayout();
		$this->_title(Mage::helper('purchaseorderitem')->__('Purchaseorderitem'))
			 ->_title(Mage::helper('purchaseorderitem')->__('Purchase Order Items'));
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
	 * edit purchase order item - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function editAction() {
		$purchaseorderitemId	= $this->getRequest()->getParam('id');
		$purchaseorderitem  	= $this->_initPurchaseorderitem();
		if ($purchaseorderitemId && !$purchaseorderitem->getId()) {
			$this->_getSession()->addError(Mage::helper('purchaseorderitem')->__('This purchase order item no longer exists.'));
			$this->_redirect('*/*/');
			return;
		}
		$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
		if (!empty($data)) {
			$purchaseorderitem->setData($data);
		}
		Mage::register('purchaseorderitem_data', $purchaseorderitem);
		$this->loadLayout();
		$this->_title(Mage::helper('purchaseorderitem')->__('Purchaseorderitem'))
			 ->_title(Mage::helper('purchaseorderitem')->__('Purchase Order Items'));
		if ($purchaseorderitem->getId()){
			$this->_title($purchaseorderitem->getQty());
		}
		else{
			$this->_title(Mage::helper('purchaseorderitem')->__('Add purchase order item'));
		}
		if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) { 
			$this->getLayout()->getBlock('head')->setCanLoadTinyMce(true); 
		}
		$this->renderLayout();
	}
	/**
	 * new purchase order item action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function newAction() {
		$this->_forward('edit');
	}
	/**
	 * save purchase order item - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function saveAction() {
		if ($data = $this->getRequest()->getPost('purchaseorderitem')) {
			try {
				$purchaseorderitem = $this->_initPurchaseorderitem();
				$purchaseorderitem->addData($data);
				$purchaseorderitem->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('purchaseorderitem')->__('Purchase Order Item was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);
				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $purchaseorderitem->getId()));
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
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('purchaseorderitem')->__('There was a problem saving the purchase order item.'));
				Mage::getSingleton('adminhtml/session')->setFormData($data);
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
			}
		}
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('purchaseorderitem')->__('Unable to find purchase order item to save.'));
		$this->_redirect('*/*/');
	}
	/**
	 * delete purchase order item - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0) {
			try {
				$purchaseorderitem = Mage::getModel('purchaseorderitem/purchaseorderitem');
				$purchaseorderitem->setId($this->getRequest()->getParam('id'))->delete();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('purchaseorderitem')->__('Purchase Order Item was successfully deleted.'));
				$this->_redirect('*/*/');
				return; 
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('purchaseorderitem')->__('There was an error deleteing purchase order item.'));
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				Mage::logException($e);
				return;
			}
		}
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('purchaseorderitem')->__('Could not find purchase order item to delete.'));
		$this->_redirect('*/*/');
	}
	/**
	 * mass delete purchase order item - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function massDeleteAction() {
		$purchaseorderitemIds = $this->getRequest()->getParam('purchaseorderitem');
		if(!is_array($purchaseorderitemIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('purchaseorderitem')->__('Please select purchase order items to delete.'));
		}
		else {
			try {
				foreach ($purchaseorderitemIds as $purchaseorderitemId) {
					$purchaseorderitem = Mage::getModel('purchaseorderitem/purchaseorderitem');
					$purchaseorderitem->setId($purchaseorderitemId)->delete();
				}
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('purchaseorderitem')->__('Total of %d purchase order items were successfully deleted.', count($purchaseorderitemIds)));
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('purchaseorderitem')->__('There was an error deleteing purchase order items.'));
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
		$purchaseorderitemIds = $this->getRequest()->getParam('purchaseorderitem');
		if(!is_array($purchaseorderitemIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('purchaseorderitem')->__('Please select purchase order items.'));
		} 
		else {
			try {
				foreach ($purchaseorderitemIds as $purchaseorderitemId) {
				$purchaseorderitem = Mage::getSingleton('purchaseorderitem/purchaseorderitem')->load($purchaseorderitemId)
							->setStatus($this->getRequest()->getParam('status'))
							->setIsMassupdate(true)
							->save();
				}
				$this->_getSession()->addSuccess($this->__('Total of %d purchase order items were successfully updated.', count($purchaseorderitemIds)));
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('purchaseorderitem')->__('There was an error updating purchase order items.'));
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
		$fileName   = 'purchaseorderitem.csv';
		$content	= $this->getLayout()->createBlock('purchaseorderitem/adminhtml_purchaseorderitem_grid')->getCsv();
		$this->_prepareDownloadResponse($fileName, $content);
	}
	/**
	 * export as MsExcel - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function exportExcelAction(){
		$fileName   = 'purchaseorderitem.xls';
		$content	= $this->getLayout()->createBlock('purchaseorderitem/adminhtml_purchaseorderitem_grid')->getExcelFile();
		$this->_prepareDownloadResponse($fileName, $content);
	}
	/**
	 * export as xml - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function exportXmlAction(){
		$fileName   = 'purchaseorderitem.xml';
		$content	= $this->getLayout()->createBlock('purchaseorderitem/adminhtml_purchaseorderitem_grid')->getXml();
		$this->_prepareDownloadResponse($fileName, $content);
	}
}