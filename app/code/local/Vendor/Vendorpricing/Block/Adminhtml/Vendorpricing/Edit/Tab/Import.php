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
 * Vendor Pricing edit form tab
 *
 * @category	Vendor
 * @package		Vendor_Vendorpricing
 * @author Ultimate Module Creator
 */
class Vendor_Vendorpricing_Block_Adminhtml_Vendorpricing_Edit_Tab_Import extends Mage_Adminhtml_Block_Widget_Form{	
	/**
	 * prepare the form
	 * @access protected
	 * @return Vendorpricing_Vendorpricing_Block_Adminhtml_Vendorpricing_Edit_Tab_Form
	 * @author Ultimate Module Creator
	 */
	protected function _prepareForm(){
		$form = new Varien_Data_Form();
		$form->setHtmlIdPrefix('vendorpricing_');
		$form->setFieldNameSuffix('docname');
		
		$this->setForm($form);
		$fieldset = $form->addFieldset('vendorpricing_form', array('legend'=>Mage::helper('vendorpricing')->__('Vendor Pricing')));
		
		$vendor_id =  $this->getRequest()->getParam('vendor_id');
		
		/*$fieldset->addField('vendor_id', 'hidden', array(
				'label' => Mage::helper('vendorpricing')->__('Vendor Id'),
				'name'  => 'vendor_id',
				
		));*/
		
		
		
		$fieldset->addField('docname', 'file', array(
          'label'     => Mage::helper('vendorpricing')->__('Upload Document'),
          'value'  => '',
          'disabled' => false,
          'readonly' => true,
          //'after_element_html' => '<small>Comments</small>',
          'tabindex' => 1
        ));
		
		
		if (Mage::getSingleton('adminhtml/session')->getVendorpricingData()){
			$form->setValues(Mage::getSingleton('adminhtml/session')->getVendorpricingData());
			Mage::getSingleton('adminhtml/session')->setVendorpricingData(null);
		}
		elseif (Mage::registry('current_vendorpricing')){
			$form->setValues(Mage::registry('current_vendorpricing')->getData());
			
		} 
		
		//comment tab
		$befor_forward_info = $this->getRequest()->getBeforeForwardInfo();
		if($befor_forward_info['action_name']=='new'){
			$data['vendor_id'] = $vendor_id;
			$form->setValues($data);
		}
        
        
		
        return parent::_prepareForm();
	}
}?>