<?php
/**
 * USAPoolDirect_Purchaseorder extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category   	USAPoolDirect
 * @package		USAPoolDirect_Purchaseorder
 * @copyright  	Copyright (c) 2014
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Purchase Order admin controller
 *
 * @category	USAPoolDirect
 * @package		USAPoolDirect_Purchaseorder
 * @author Ultimate Module Creator
 */
class USAPoolDirect_Purchaseorder_Adminhtml_Purchaseorder_PurchaseorderController extends USAPoolDirect_Purchaseorder_Controller_Adminhtml_Purchaseorder{
	/**
	 * init the purchaseorder
	 * @access protected
	 * @return USAPoolDirect_Purchaseorder_Model_Purchaseorder
	 */
	protected function _initPurchaseorder(){
		$purchaseorderId  = (int) $this->getRequest()->getParam('id');
		$purchaseorder	= Mage::getModel('purchaseorder/purchaseorder');
		if ($purchaseorderId) {
			$purchaseorder->load($purchaseorderId);
		}
		Mage::register('current_purchaseorder', $purchaseorder);
		return $purchaseorder;
	}
 	/**
	 * default action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function indexAction() {
		
		$this->loadLayout();
		$this->_title(Mage::helper('purchaseorder')->__('Purchaseorder'))
			 ->_title(Mage::helper('purchaseorder')->__('Purchase Orders'));
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
	 * edit purchase order - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function editAction() {
		$purchaseorderId	= $this->getRequest()->getParam('id');
		$purchaseorder  	= $this->_initPurchaseorder();
		if ($purchaseorderId && !$purchaseorder->getId()) {
			$this->_getSession()->addError(Mage::helper('purchaseorder')->__('This purchase order no longer exists.'));
			$this->_redirect('*/*/');
			return;
		}
		$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
		if (!empty($data)) {
			$purchaseorder->setData($data);
		}
		Mage::register('purchaseorder_data', $purchaseorder);
		$this->loadLayout();
		$this->_title(Mage::helper('purchaseorder')->__('Purchaseorder'))
			 ->_title(Mage::helper('purchaseorder')->__('Purchase Orders'));
		if ($purchaseorder->getId()){
			$this->_title($purchaseorder->getPoNumber());
		}
		else{
			$this->_title(Mage::helper('purchaseorder')->__('Add purchase order'));
		}
		if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) { 
			$this->getLayout()->getBlock('head')->setCanLoadTinyMce(true); 
		}
		$this->renderLayout();
	}
	/**
	 * new purchase order action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function newAction() {
		$this->_forward('edit');
	}
	/**
	 * save purchase order - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function saveAction() {
		
		if($this->getRequest()->getPost('po_status')!=''){
			
			Mage::getModel('purchaseorder/purchaseorder')->savePurchaseOrderItem();
			
		}
		
		if ($data = $this->getRequest()->getPost('purchaseorder')) {
			try {
				
				$purchaseorder = $this->_initPurchaseorder();
				$purchaseorder->addData($data);
				$purchaseorder->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('purchaseorder')->__('Purchase Order was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);
				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $purchaseorder->getId(),'order_id' => $data['order_id']));
					return;
				}
				$this->_redirect('*/*/', array('order_id' => $data['order_id']));
				return;
			} 
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				Mage::getSingleton('adminhtml/session')->setFormData($data);
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id'),'order_id' => $data['order_id']));
				return;
			}
			catch (Exception $e) {
				Mage::logException($e);
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('purchaseorder')->__('There was a problem saving the purchase order.'));
				Mage::getSingleton('adminhtml/session')->setFormData($data);
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id'),'order_id' => $data['order_id']));
				return;
			}
		}
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('purchaseorder')->__('Unable to find purchase order to save.'));
		$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id'),'order_id' => $data['order_id']));
	}
	/**
	 * delete purchase order - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0) {
			try {
				$purchaseorder = Mage::getModel('purchaseorder/purchaseorder');
				$purchaseorder->setId($this->getRequest()->getParam('id'))->delete();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('purchaseorder')->__('Purchase Order was successfully deleted.'));
				$this->_redirect('*/*/', array('order_id' => $this->getRequest()->getParam('order_id')));
				return; 
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id'),'order_id' => $this->getRequest()->getParam('order_id')));
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('purchaseorder')->__('There was an error deleteing purchase order.'));
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id'),'order_id' => $this->getRequest()->getParam('order_id')));
				Mage::logException($e);
				return;
			}
		}
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('purchaseorder')->__('Could not find purchase order to delete.'));
		$this->_redirect('*/*/');
	}
	/**
	 * mass delete purchase order - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function massDeleteAction() {
		$purchaseorderIds = $this->getRequest()->getParam('purchaseorder');
		if(!is_array($purchaseorderIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('purchaseorder')->__('Please select purchase orders to delete.'));
		}
		else {
			try {
				foreach ($purchaseorderIds as $purchaseorderId) {
					$purchaseorder = Mage::getModel('purchaseorder/purchaseorder');
					$purchaseorder->setId($purchaseorderId)->delete();
				}
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('purchaseorder')->__('Total of %d purchase orders were successfully deleted.', count($purchaseorderIds)));
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('purchaseorder')->__('There was an error deleteing purchase orders.'));
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
		$purchaseorderIds = $this->getRequest()->getParam('purchaseorder');
		if(!is_array($purchaseorderIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('purchaseorder')->__('Please select purchase orders.'));
		} 
		else {
			try {
				foreach ($purchaseorderIds as $purchaseorderId) {
				$purchaseorder = Mage::getSingleton('purchaseorder/purchaseorder')->load($purchaseorderId)
							->setStatus($this->getRequest()->getParam('status'))
							->setIsMassupdate(true)
							->save();
				}
				$this->_getSession()->addSuccess($this->__('Total of %d purchase orders were successfully updated.', count($purchaseorderIds)));
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('purchaseorder')->__('There was an error updating purchase orders.'));
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
		$fileName   = 'purchaseorder.csv';
		$content	= $this->getLayout()->createBlock('purchaseorder/adminhtml_purchaseorder_grid')->getCsv();
		$this->_prepareDownloadResponse($fileName, $content);
	}
	/**
	 * export as MsExcel - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function exportExcelAction(){
		$fileName   = 'purchaseorder.xls';
		$content	= $this->getLayout()->createBlock('purchaseorder/adminhtml_purchaseorder_grid')->getExcelFile();
		$this->_prepareDownloadResponse($fileName, $content);
	}
	/**
	 * export as xml - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function exportXmlAction(){
		$fileName   = 'purchaseorder.xml';
		$content	= $this->getLayout()->createBlock('purchaseorder/adminhtml_purchaseorder_grid')->getXml();
		$this->_prepareDownloadResponse($fileName, $content);
	}
	
	/**
	 * Generate comment history for ajax request
	 */
	public function purchaseorderAction()
	{
		$this->loadLayout();
		$this->_title(Mage::helper('purchaseorder')->__('Purchaseorder'))
		->_title(Mage::helper('purchaseorder')->__('Purchase Orders'));
		
		//set form url
		Mage:: register('form_save_url',$this->getUrl('*/purchaseorder_purchaseorder/savepo',array('order_id'=>$this->getRequest()->getParam('order_id'))));
		Mage:: register('form_back_url',$this->getUrl('*/sales_order/view',array('order_id'=>$this->getRequest()->getParam('order_id'))));
		Mage:: register('order_url',$this->getUrl('*/sales_order/view',array('order_id'=>$this->getRequest()->getParam('order_id'))));
		$this->renderLayout();
		
	}
	
	/**
	 * Generate comment history for ajax request
	 */
	public function savepoAction()
	{
		
		
		
		if($this->getRequest()->getPost('po_status')=='') {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('purchaseorder')->__('Please select purchase orders.'));
			$this->_redirect('*/purchaseorder_purchaseorder/purchaseorder',array('order_id'=>$this->getRequest()->getParam('order_id')));
		}
		else {
			if(isset($_POST['po_order_qty'])){
				$po_number = Mage::getModel('purchaseorder/purchaseorder')->savePurchaseOrder();
				$this->_redirect('*/purchaseorder_purchaseorder/editpo',array('order_id'=>$this->getRequest()->getParam('order_id'),'po_number'=>$po_number));
			}else{
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('purchaseorder')->__('Please select purchase orders item not found.'));
				$this->_redirect('*/purchaseorder_purchaseorder/purchaseorder',array('order_id'=>$this->getRequest()->getParam('order_id')));
			}
		}		
		
		
	}
	
	/**
	 * function for edit po 
	 * */
	public function editpoAction(){
		if(empty($_POST)){
			$this->loadLayout();
			 $this->_title(Mage::helper('purchaseorder')->__('Generate Purchaseorder'))
			->_title(Mage::helper('purchaseorder')->__('Generate Purchase Orders'));
			 Mage:: register('form_back_url',$this->getUrl('*/purchaseorder_purchaseorder/purchaseorder',array('order_id'=>$this->getRequest()->getParam('order_id'))));
			Mage:: register('form_save_url',$this->getUrl('*/purchaseorder_purchaseorder/editpo',array('order_id'=>$this->getRequest()->getParam('order_id'),'po_number'=>$this->getRequest()->getParam('po_number'))));
			Mage:: register('delete_url',$this->getUrl('*/purchaseorder_purchaseorder/deletepoitem',array('order_id'=>$this->getRequest()->getParam('order_id'),'po_number'=>$this->getRequest()->getParam('po_number'))));
			Mage:: register('ajax_vendor_url',$this->getUrl('*/purchaseorder_purchaseorder/getvendoritemdata',array('order_id'=>$this->getRequest()->getParam('order_id'),'po_number'=>$this->getRequest()->getParam('po_number'))));
			Mage:: register('comment_url',$this->getUrl('*/purchaseorder_purchaseorder/addcomment',array('order_id'=>$this->getRequest()->getParam('order_id'),'po_number'=>$this->getRequest()->getParam('po_number'))));
			Mage:: register('comment_list_url',$this->getUrl('*/purchaseorder_purchaseorder/getallcomment',array('order_id'=>$this->getRequest()->getParam('order_id'),'po_number'=>$this->getRequest()->getParam('po_number'))));
			Mage:: register('order_url',$this->getUrl('*/sales_order/view',array('order_id'=>$this->getRequest()->getParam('order_id'))));
			$this->renderLayout();
		}else{
			
			Mage::getModel('purchaseorder/purchaseorder')->editPurchaseOrder();
			$this->_redirect('*/purchaseorder_purchaseorder/editpo',array('order_id'=>$this->getRequest()->getParam('order_id'),'po_number'=>$this->getRequest()->getParam('po_number')));
		}
		
	}
	
	/**
	 * function for delete item from po
	 * */
	
	public function deletepoitemAction(){
		$return_var = Mage::getModel('purchaseorder/purchaseorder')->deletePurchaseOrderItem($this->getRequest()->getParam('po_number'),$this->getRequest()->getParam('item_id'),$this->getRequest()->getParam('order_id'));
		
		$this->_redirect('*/purchaseorder_purchaseorder/editpo',array('order_id'=>$this->getRequest()->getParam('order_id'),'po_number'=>$this->getRequest()->getParam('po_number')));	
	}
	
	/**
	 * function for get vedor item data
	 */
	public function getvendoritemdataAction(){
		echo Mage::getModel('purchaseorder/purchaseorder')->getvendoritemdataAction($this->getRequest()->getParam('po_number'),$this->getRequest()->getParam('order_id'));exit;
	}
	
	/**
	 * function for generate pdf
	 */
	function generatepdfAction(){
		$content = Mage::getModel('purchaseorder/purchaseorder')->generatePdf($this->getRequest()->getParam('po_number'),$this->getRequest()->getParam('order_id'));
		echo $fileName = Mage::getBaseDir().'/customers.pdf';
		//$fileName = Mage::getBaseUrl().'customers.pdf';
		file_put_contents($fileName,$content);
		exit;
		$this->_prepareDownloadResponse($fileName,$content);
	}
	
	/*****************************
	 ******** COmmment ***********
	 *****************************
	 */
	
	//function for add comment 
	public function addcommentAction(){
		Mage::getModel('purchaseorder/purchaseorder')->addComment($this->getRequest()->getParam('po_number'),$this->getRequest()->getParam('order_id'));
	}
	
	//function for get comment
	public function getallcommentAction(){
		$po_number = $this->getRequest()->getParam('po_number');
		Mage:: register  ('po_number',$po_number);
		
		$order_id = $this->getRequest()->getParam('order_id');
		Mage:: register  ('order_id',$order_id);
		/*/$comment_data = Mage::getModel('purchaseorder/purchaseorder')->getAllComment($this->getRequest()->getParam('po_number'),$this->getRequest()->getParam('order_id'));*/
		Mage::app()->getLayout()->createBlock('purchaseorder/adminhtml_purchaseorder_commmetlist')->toHtml();
	}
	
	/*****************************
	 ******** END COmmment *******
	******************************
	*/


	

	
}