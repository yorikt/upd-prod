<?php
/**
 * Vendor_Vendors extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category   	Vendor
 * @package		Vendor_Vendors
 * @copyright  	Copyright (c) 2014
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Manage Vendors admin controller
 *
 * @category	Vendor
 * @package		Vendor_Vendors
 * @author Ultimate Module Creator
 */
class Vendor_Vendors_Adminhtml_Vendors_ManagevendorsController extends Vendor_Vendors_Controller_Adminhtml_Vendors{
	/**
	 * init the managevendors
	 * @access protected
	 * @return Vendor_Vendors_Model_Managevendors
	 */
	protected function _initManagevendors(){
		$managevendorsId  = (int) $this->getRequest()->getParam('id');
		$managevendors	= Mage::getModel('vendors/managevendors');
		if ($managevendorsId) {
			$managevendors->load($managevendorsId);
		}
		Mage::register('current_managevendors', $managevendors);
		return $managevendors;
	}
 	/**
	 * default action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function indexAction() {
		$this->loadLayout();
		$this->_title(Mage::helper('vendors')->__('Vendors'))
			 ->_title(Mage::helper('vendors')->__('Manage Vendors'));
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
	 * edit manage vendors - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function editAction() {
		$managevendorsId	= $this->getRequest()->getParam('id');
		$managevendors  	= $this->_initManagevendors();
		if ($managevendorsId && !$managevendors->getId()) {
			$this->_getSession()->addError(Mage::helper('vendors')->__('This vendor no longer exists.'));
			$this->_redirect('*/*/');
			return;
		}
		$data = Mage::getSingleton('adminhtml/session')->getFormData(true);

		if (!empty($data)) {
			$managevendors->setData($data);
		}
		Mage::register('managevendors_data', $managevendors);
		$this->loadLayout();
		$this->_title(Mage::helper('vendors')->__('Vendors'))
			 ->_title(Mage::helper('vendors')->__('Manage Vendors'));
		if ($managevendors->getId()){
			$this->_title($managevendors->getVendorname());
		}
		else{
			$this->_title(Mage::helper('vendors')->__('Manage vendors'));
		}
		if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) { 
			$this->getLayout()->getBlock('head')->setCanLoadTinyMce(true); 
		}
		$this->renderLayout();
	}
	/**
	 * new manage vendors action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function newAction() {
		$this->_forward('edit');
	}
	/**
	 * save manage vendors - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function saveAction() {
		if ($data = $this->getRequest()->getPost('managevendors')) {
		$data['manufacturer'] = (isset($data['manufacturer']))?$data['manufacturer']:'0';
		$data['supplier'] = (isset($data['supplier']))?$data['supplier']:'0';
		$data['subcontractor'] = (isset($data['subcontractor']))?$data['subcontractor']:'0';
		$data['courier'] = (isset($data['courier']))?$data['courier']:'0';
		
		
			try {
				
				//code for upload import file 
				$this->_uploadImportFile();
				//code for upload import file
				$managevendors = $this->_initManagevendors();
				$managevendors->addData($data);
				$contacts = $this->getRequest()->getPost('contacts', -1);
				if ($contacts != -1) {
					$managevendors->setContactsData(Mage::helper('adminhtml/js')->decodeGridSerializedInput($contacts));
				}
				$managevendors->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('vendors')->__('Vendor was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);
				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $managevendors->getId()));
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
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('vendors')->__('There was a problem saving the vendor.'));
				Mage::getSingleton('adminhtml/session')->setFormData($data);
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
			}
		}
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('vendors')->__('Unable to find vendor to save.'));
		$this->_redirect('*/*/');
	}
	/**
	 * delete manage vendors - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0) {
			try {
				$managevendors = Mage::getModel('vendors/managevendors');
				$managevendors->setId($this->getRequest()->getParam('id'))->delete();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('vendors')->__('Vendor was successfully deleted.'));
				$this->_redirect('*/*/');
				return; 
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('vendors')->__('There was an error deleteing vendor.'));
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				Mage::logException($e);
				return;
			}
		}
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('vendors')->__('Could not find vendor to delete.'));
		$this->_redirect('*/*/');
	}
	/**
	 * mass delete manage vendors - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function massDeleteAction() {
		$managevendorsIds = $this->getRequest()->getParam('managevendors');
		if(!is_array($managevendorsIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('vendors')->__('Please select vendor to delete.'));
		}
		else {
			try {
				foreach ($managevendorsIds as $managevendorsId) {
					$managevendors = Mage::getModel('vendors/managevendors');
					$managevendors->setId($managevendorsId)->delete();
				}
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('vendors')->__('Total of %d vendor were successfully deleted.', count($managevendorsIds)));
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('vendors')->__('There was an error deleteing vendor.'));
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
		$managevendorsIds = $this->getRequest()->getParam('managevendors');
		if(!is_array($managevendorsIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('vendors')->__('Please select vendor.'));
		} 
		else {
			try {
				foreach ($managevendorsIds as $managevendorsId) {
				$managevendors = Mage::getSingleton('vendors/managevendors')->load($managevendorsId)
							->setStatus($this->getRequest()->getParam('status'))
							->setIsMassupdate(true)
							->save();
				}
				$this->_getSession()->addSuccess($this->__('Total of %d vendor were successfully updated.', count($managevendorsIds)));
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('vendors')->__('There was an error updating vendor.'));
				Mage::logException($e);
			}
		}
		$this->_redirect('*/*/index');
	}
	/**
	 * mass Active change - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function massActiveAction(){
		$managevendorsIds = $this->getRequest()->getParam('managevendors');
		if(!is_array($managevendorsIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('vendors')->__('Please select vendor.'));
		} 
		else {
			try {
				foreach ($managevendorsIds as $managevendorsId) {
				$managevendors = Mage::getSingleton('vendors/managevendors')->load($managevendorsId)
							->setActive($this->getRequest()->getParam('flag_active'))
							->setIsMassupdate(true)
							->save();
				}
				$this->_getSession()->addSuccess($this->__('Total of %d vendor were successfully updated.', count($managevendorsIds)));
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('vendors')->__('There was an error updating vendor.'));
				Mage::logException($e);
			}
		}
		$this->_redirect('*/*/index');
	}
	/**
	 * get contacts action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function contactsAction(){
		/*$this->_initManagevendors();
		$this->loadLayout();
		$this->getLayout()->getBlock('managevendors.edit.tab.contact')
			->setManagevendorsContacts($this->getRequest()->getPost('managevendors_contacts', null));
		$this->renderLayout();*/
		$paramId = $this->getRequest()->getParam('id');
		Mage:: register  ('paramId',$paramId);
		Mage:: register('form_save_url',$this->getUrl('*/vendors_managevendors/savecontact',array('vendor_id'=>$this->getRequest()->getParam('id'))));
		Mage:: register('form_get_url',$this->getUrl('*/vendors_managevendors/getcontact'));
		Mage:: register('form_edit_url',$this->getUrl('*/vendors_managevendors/editcontact',array('vendor_id'=>$this->getRequest()->getParam('id'))));
		$block = $this->getLayout()->createBlock('vendors/adminhtml_managevendors_contactlist')->toHtml();
	}
	
	
	/**
	 * get contacts grid  action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function contactsgridAction(){
		$this->_initManagevendors();
		$this->loadLayout();
		$this->getLayout()->getBlock('managevendors.edit.tab.contact')
			->setManagevendorsContacts($this->getRequest()->getPost('managevendors_contacts', null));
		$this->renderLayout();
	}	/**
	 * export as csv - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function exportCsvAction(){
		$fileName   = 'managevendors.csv';
		$content	= $this->getLayout()->createBlock('vendors/adminhtml_managevendors_grid')->getCsv();
		$this->_prepareDownloadResponse($fileName, $content);
	}
	/**
	 * export as MsExcel - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function exportExcelAction(){
		$fileName   = 'managevendors.xls';
		$content	= $this->getLayout()->createBlock('vendors/adminhtml_managevendors_grid')->getExcelFile();
		$this->_prepareDownloadResponse($fileName, $content);
	}
	/**
	 * export as xml - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function exportXmlAction(){
		$fileName   = 'managevendors.xml';
		$content	= $this->getLayout()->createBlock('vendors/adminhtml_managevendors_grid')->getXml();
		$this->_prepareDownloadResponse($fileName, $content);
	}
	
	/**
	 * Generate comment history for ajax request
	 */
	public function commentsHistoryAction()
	{
	
		$user = Mage::getSingleton('admin/session');
		$userId = $user->getUser()->getUserId();
		Mage:: register  ('admin_id',$userId);
	
		$paramId = $this->getRequest()->getParam('id');
		Mage:: register  ('paramId',$paramId);
	
		
		
		$block = $this->getLayout()->createBlock('vendors/adminhtml_managevendors_historylist')->toHtml();
	
		// 		$block->setData('var',$paramId);
	
		/*echo "here";exit;
			$html = $this->getLayout()->createBlock('helloworld/adminhtml_helloworld_historylist')->toHtml();
		*/
		/*$translate = Mage::getModel('core/translate_inline');
			if ($translate->isAllowed()) {
		$translate->processResponseBody($html);
		}
		$this->getResponse()->setBody($html);*/
	}
	
	/**
	 * function for add contact
	 */
	function savecontactAction(){
		
		Mage::getModel('vendors/managevendors')->saveContact($this->getRequest()->getParam('vendor_id'));
	}
	
	/**
	 * get contacts
	 * @access public
	 * @return void
	 * @author jems
	 */
	public function getcontactAction(){
		echo Mage::getModel('vendors/managevendors')->getContact($this->getRequest()->getParam('vendor_id'));exit;
	}
	
	/**
	 * function for add contact
	 */
	function editcontactAction(){
	
		Mage::getModel('vendors/managevendors')->editContact($this->getRequest()->getParam('vendor_id'));
	}
	
	
	/**
	 * this function for upload file in to folder
	 */
	function _uploadImportFile(){
		if(isset($_FILES['docname']['name']) && $_FILES['docname']['name'] != '')
		{
			try
			{
				$path = Mage::getBaseDir().DS.'var/vendor_import'.DS;  //desitnation directory
				$fname = $this->getRequest()->getParam('id').'_'.$_FILES['docname']['name']; //file name
				$uploader = new Varien_File_Uploader('docname'); //load class
				$uploader->setAllowedExtensions(array('doc','pdf','txt','docx','csv')); //Allowed extension for file
				$uploader->setAllowCreateFolders(true); //for creating the directory if not exists
				$uploader->setAllowRenameFiles(false); //if true, uploaded file's name will be changed, if file with the same name already exists directory.
				$uploader->setFilesDispersion(false);
				$uploader->save($path,$fname); //save the file on the specified path
				
				
				$row = 1;
				if (($handle = fopen($path.$fname, "r")) !== FALSE) {
					
					while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
						$num = count($data);
						//echo "<p> $num fields in line $row: <br /></p>\n";
						$row++;
						for ($c=0; $c < $num; $c++) {
						//echo $data[$c] . "<br />\n";
							if($row!='2'){
								$data_array = array();
								if(array_key_exists($row,$data_array)){
									$data_array[$row] .= $data;
								}else{
									$data_array[$row] = $data;
									
								}
								
							}
							
						}
						Mage::getResourceSingleton('vendorpricing/vendorpricing')->saveUplodedData($data_array,$this->getRequest()->getParam('id'));
					}
					//Mage::getResourceSingleton('vendorpricing/vendorpricing_collection')->saveUplodedData($data_array);
					fclose($handle);
				}
				
			}
			catch (Exception $e)
			{
				echo 'Error Message: '.$e->getMessage();exit;
			}
			
		}
		
		return $this;
	}
}