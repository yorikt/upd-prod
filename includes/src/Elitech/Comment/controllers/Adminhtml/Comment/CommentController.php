<?php
/**
 * Elitech_Comment extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category   	Elitech
 * @package		Elitech_Comment
 * @copyright  	Copyright (c) 2014
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Comment admin controller
 *
 * @category	Elitech
 * @package		Elitech_Comment
 * @author Ultimate Module Creator
 */
class Elitech_Comment_Adminhtml_Comment_CommentController extends Elitech_Comment_Controller_Adminhtml_Comment{
	/**
	 * init the comment
	 * @access protected
	 * @return Elitech_Comment_Model_Comment
	 */
	protected function _initComment(){
		$commentId  = (int) $this->getRequest()->getParam('id');
		$comment	= Mage::getModel('comment/comment');
		if ($commentId) {
			$comment->load($commentId);
		}
		Mage::register('current_comment', $comment);
		return $comment;
	}
 	/**
	 * default action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function indexAction() {
		$this->loadLayout();
		$this->_title(Mage::helper('comment')->__('Comment'))
			 ->_title(Mage::helper('comment')->__('Comments'));
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
	 * edit comment - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function editAction() {
		$commentId	= $this->getRequest()->getParam('id');
		$comment  	= $this->_initComment();
		if ($commentId && !$comment->getId()) {
			$this->_getSession()->addError(Mage::helper('comment')->__('This comment no longer exists.'));
			$this->_redirect('*/*/');
			return;
		}
		$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
		if (!empty($data)) {
			$comment->setData($data);
		}
		Mage::register('comment_data', $comment);
		$this->loadLayout();
		$this->_title(Mage::helper('comment')->__('Comment'))
			 ->_title(Mage::helper('comment')->__('Comments'));
		if ($comment->getId()){
			$this->_title($comment->getAddress());
		}
		else{
			$this->_title(Mage::helper('comment')->__('Add comment'));
		}
		if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) { 
			$this->getLayout()->getBlock('head')->setCanLoadTinyMce(true); 
		}
		$this->renderLayout();
	}
	/**
	 * new comment action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function newAction() {
		$this->_forward('edit');
	}
	/**
	 * save comment - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function saveAction() {
		if ($data = $this->getRequest()->getPost('comment')) {
			try {
				$comment = $this->_initComment();
				$comment->addData($data);
				$comment->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('comment')->__('Comment was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);
				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $comment->getId()));
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
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('comment')->__('There was a problem saving the comment.'));
				Mage::getSingleton('adminhtml/session')->setFormData($data);
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
			}
		}
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('comment')->__('Unable to find comment to save.'));
		$this->_redirect('*/*/');
	}
	/**
	 * delete comment - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0) {
			try {
				$comment = Mage::getModel('comment/comment');
				$comment->setId($this->getRequest()->getParam('id'))->delete();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('comment')->__('Comment was successfully deleted.'));
				$this->_redirect('*/*/');
				return; 
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('comment')->__('There was an error deleteing comment.'));
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				Mage::logException($e);
				return;
			}
		}
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('comment')->__('Could not find comment to delete.'));
		$this->_redirect('*/*/');
	}
	/**
	 * mass delete comment - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function massDeleteAction() {
		$commentIds = $this->getRequest()->getParam('comment');
		if(!is_array($commentIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('comment')->__('Please select comments to delete.'));
		}
		else {
			try {
				foreach ($commentIds as $commentId) {
					$comment = Mage::getModel('comment/comment');
					$comment->setId($commentId)->delete();
				}
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('comment')->__('Total of %d comments were successfully deleted.', count($commentIds)));
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('comment')->__('There was an error deleteing comments.'));
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
		$commentIds = $this->getRequest()->getParam('comment');
		if(!is_array($commentIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('comment')->__('Please select comments.'));
		} 
		else {
			try {
				foreach ($commentIds as $commentId) {
				$comment = Mage::getSingleton('comment/comment')->load($commentId)
							->setStatus($this->getRequest()->getParam('status'))
							->setIsMassupdate(true)
							->save();
				}
				$this->_getSession()->addSuccess($this->__('Total of %d comments were successfully updated.', count($commentIds)));
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('comment')->__('There was an error updating comments.'));
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
		$fileName   = 'comment.csv';
		$content	= $this->getLayout()->createBlock('comment/adminhtml_comment_grid')->getCsv();
		$this->_prepareDownloadResponse($fileName, $content);
	}
	/**
	 * export as MsExcel - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function exportExcelAction(){
		$fileName   = 'comment.xls';
		$content	= $this->getLayout()->createBlock('comment/adminhtml_comment_grid')->getExcelFile();
		$this->_prepareDownloadResponse($fileName, $content);
	}
	/**
	 * export as xml - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function exportXmlAction(){
		$fileName   = 'comment.xml';
		$content	= $this->getLayout()->createBlock('comment/adminhtml_comment_grid')->getXml();
		$this->_prepareDownloadResponse($fileName, $content);
	}
}