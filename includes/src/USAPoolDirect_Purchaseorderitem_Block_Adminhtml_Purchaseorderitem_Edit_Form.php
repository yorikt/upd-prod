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
 * Purchase Order Item edit form
 *
 * @category	USAPoolDirect
 * @package		USAPoolDirect_Purchaseorderitem
 * @author Ultimate Module Creator
 */
class USAPoolDirect_Purchaseorderitem_Block_Adminhtml_Purchaseorderitem_Edit_Form extends Mage_Adminhtml_Block_Widget_Form{
	/**
	 * prepare form
	 * @access protected
	 * @return USAPoolDirect_Purchaseorderitem_Block_Adminhtml_Purchaseorderitem_Edit_Form
	 * @author Ultimate Module Creator
	 */
	protected function _prepareForm(){
		$form = new Varien_Data_Form(array(
						'id' 		=> 'edit_form',
						'action' 	=> $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
						'method' 	=> 'post',
						'enctype'	=> 'multipart/form-data'
					)
		);
		$form->setUseContainer(true);
		$this->setForm($form);
		return parent::_prepareForm();
	}
}