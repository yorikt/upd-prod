<?php
/**
 * USAPoolDirect_Vendorrelation extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       USAPoolDirect
 * @package        USAPoolDirect_Vendorrelation
 * @copyright      Copyright (c) 2014
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Customervendorid admin controller
 *
 * @category    USAPoolDirect
 * @package     USAPoolDirect_Vendorrelation
 * @author      Ultimate Module Creator
 */
class USAPoolDirect_Vendorrelation_Adminhtml_Vendorrelation_CustomervendoridController
    extends USAPoolDirect_Vendorrelation_Controller_Adminhtml_Vendorrelation {
    /**
     * init the customervendorid
     * @access protected
     * @return USAPoolDirect_Vendorrelation_Model_Customervendorid
     */
    protected function _initCustomervendorid(){
        $customervendoridId  = (int) $this->getRequest()->getParam('id');
        $customervendorid    = Mage::getModel('usapooldirect_vendorrelation/customervendorid');
        if ($customervendoridId) {
            $customervendorid->load($customervendoridId);
        }
        Mage::register('current_customervendorid', $customervendorid);
        return $customervendorid;
    }
     /**
     * default action
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function indexAction() {
        $this->loadLayout();
        $this->_title(Mage::helper('usapooldirect_vendorrelation')->__('Vendor relation'))
             ->_title(Mage::helper('usapooldirect_vendorrelation')->__('Customervendorids'));
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
     * edit customervendorid - action
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function editAction() {
        $customervendoridId    = $this->getRequest()->getParam('id');
        $customervendorid      = $this->_initCustomervendorid();
        if ($customervendoridId && !$customervendorid->getId()) {
            $this->_getSession()->addError(Mage::helper('usapooldirect_vendorrelation')->__('This customervendorid no longer exists.'));
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getCustomervendoridData(true);
        if (!empty($data)) {
            $customervendorid->setData($data);
        }
        Mage::register('customervendorid_data', $customervendorid);
        $this->loadLayout();
        $this->_title(Mage::helper('usapooldirect_vendorrelation')->__('Vendor relation'))
             ->_title(Mage::helper('usapooldirect_vendorrelation')->__('Customervendorids'));
        if ($customervendorid->getId()){
            $this->_title($customervendorid->getCustomervendorId());
        }
        else{
            $this->_title(Mage::helper('usapooldirect_vendorrelation')->__('Add customervendorid'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }
    public function vendorlistAction(){
           
		$paramId = $this->getRequest()->getParam('id');
       
		Mage:: register  ('paramId',$paramId);
		Mage:: register('assignvendor',$this->getUrl('*/Vendorrelation_Customervendorid/vendorlist/id/'.$paramId.'/type/assignvendor'));
                Mage:: register('nearbyvendor',$this->getUrl('*/Vendorrelation_Customervendorid/vendorlist/id/'.$paramId.'/type/nearbyvendor'));
                Mage:: register('allvendor',$this->getUrl('*/Vendorrelation_Customervendorid/vendorlist/id/'.$paramId.'/type/allvendor'));
                //$block = $this->getLayout()->createBlock('USAPoolDirect_Vendorrelation_Block_Adminhtml_Vendorlist')->toHtml();
				 $block = $this->getLayout()->createBlock('USAPoolDirect_Vendorrelation_Block_Adminhtml_Vendorlist')->setTemplate('vendorrelation/vendorlist.phtml');
                $this->getResponse()->setBody($block->toHtml());
	
        }
    /**
     * new customervendorid action
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function newAction() {
        $this->_forward('edit');
    }
    /**
     * save customervendorid - action
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function saveAction() {
        if ($data = $this->getRequest()->getPost('customervendorid')) {
            try {
                $customervendorid = $this->_initCustomervendorid();
                $customervendorid->addData($data);
                $customervendorid->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('usapooldirect_vendorrelation')->__('Customervendorid was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $customervendorid->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setCustomervendoridData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
            catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('usapooldirect_vendorrelation')->__('There was a problem saving the customervendorid.'));
                Mage::getSingleton('adminhtml/session')->setCustomervendoridData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('usapooldirect_vendorrelation')->__('Unable to find customervendorid to save.'));
        $this->_redirect('*/*/');
    }
    /**
     * delete customervendorid - action
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function deleteAction() {
        if( $this->getRequest()->getParam('id') > 0) {
            try {
                $customervendorid = Mage::getModel('usapooldirect_vendorrelation/customervendorid');
                $customervendorid->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('usapooldirect_vendorrelation')->__('Customervendorid was successfully deleted.'));
                $this->_redirect('*/*/');
                return;
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('usapooldirect_vendorrelation')->__('There was an error deleting customervendorid.'));
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('usapooldirect_vendorrelation')->__('Could not find customervendorid to delete.'));
        $this->_redirect('*/*/');
    }
    /**
     * mass delete customervendorid - action
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function massDeleteAction() {
        $customervendoridIds = $this->getRequest()->getParam('customervendorid');
        if(!is_array($customervendoridIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('usapooldirect_vendorrelation')->__('Please select customervendorids to delete.'));
        }
        else {
            try {
                foreach ($customervendoridIds as $customervendoridId) {
                    $customervendorid = Mage::getModel('usapooldirect_vendorrelation/customervendorid');
                    $customervendorid->setId($customervendoridId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('usapooldirect_vendorrelation')->__('Total of %d customervendorids were successfully deleted.', count($customervendoridIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('usapooldirect_vendorrelation')->__('There was an error deleting customervendorids.'));
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
        $customervendoridIds = $this->getRequest()->getParam('customervendorid');
        if(!is_array($customervendoridIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('usapooldirect_vendorrelation')->__('Please select customervendorids.'));
        }
        else {
            try {
                foreach ($customervendoridIds as $customervendoridId) {
                $customervendorid = Mage::getSingleton('usapooldirect_vendorrelation/customervendorid')->load($customervendoridId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess($this->__('Total of %d customervendorids were successfully updated.', count($customervendoridIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('usapooldirect_vendorrelation')->__('There was an error updating customervendorids.'));
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
        $fileName   = 'customervendorid.csv';
        $content    = $this->getLayout()->createBlock('usapooldirect_vendorrelation/adminhtml_customervendorid_grid')->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }
    /**
     * export as MsExcel - action
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function exportExcelAction(){
        $fileName   = 'customervendorid.xls';
        $content    = $this->getLayout()->createBlock('usapooldirect_vendorrelation/adminhtml_customervendorid_grid')->getExcelFile();
        $this->_prepareDownloadResponse($fileName, $content);
    }
    /**
     * export as xml - action
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function exportXmlAction(){
        $fileName   = 'customervendorid.xml';
        $content    = $this->getLayout()->createBlock('usapooldirect_vendorrelation/adminhtml_customervendorid_grid')->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }
    /**
     * Check if admin has permissions to visit related pages
     * @access protected
     * @return boolean
     * @author Ultimate Module Creator
     */
    protected function _isAllowed() {
        return Mage::getSingleton('admin/session')->isAllowed('usapooldirect_vendorrelation/customervendorid');
    }
}
