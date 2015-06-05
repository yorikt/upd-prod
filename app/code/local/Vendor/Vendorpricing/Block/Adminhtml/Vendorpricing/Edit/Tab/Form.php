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
class Vendor_Vendorpricing_Block_Adminhtml_Vendorpricing_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form{	
	/**
	 * prepare the form
	 * @access protected
	 * @return Vendorpricing_Vendorpricing_Block_Adminhtml_Vendorpricing_Edit_Tab_Form
	 * @author Ultimate Module Creator
	 */
	protected function _prepareForm(){
		$form = new Varien_Data_Form();
		$form->setHtmlIdPrefix('vendorpricing_');
		$form->setFieldNameSuffix('vendorpricing');
		
		$this->setForm($form);
		$fieldset = $form->addFieldset('vendorpricing_form', array('legend'=>Mage::helper('vendorpricing')->__('Vendor Pricing')));
		
		$vendor_id =  $this->getRequest()->getParam('vendor_id');
		
		$fieldset->addField('vendor_id', 'hidden', array(
				'label' => Mage::helper('vendorpricing')->__('Vendor Id'),
				'name'  => 'vendor_id',
				
		));
		
		
		$fieldset->addField('products_name', 'select', array(
			'label' => Mage::helper('vendorpricing')->__('Product'),
			'name'  => 'products_name',
			'required'  => true,
			'class' => 'required-entry',
			'values'=> Mage::getModel('vendorpricing/vendorpricing')->getProductVendorPricing($vendor_id),
			'onchange'=> 'getProdcut(this.value)',
			'style'=>'width:624px'
		));
		
		$fieldset->addField('products', 'hidden', array(
				'label' => Mage::helper('vendorpricing')->__('products'),
				'name'  => 'products',
				'maxlength'=>'100'
		
		));

		$fieldset->addField('part_number', 'hidden', array(
			'label' => Mage::helper('vendorpricing')->__('Part Number'),
			'name'  => 'part_number',
			'maxlength'=>'100'	

		));

		$fieldset->addField('part_description', 'hidden', array(
			'label' => Mage::helper('vendorpricing')->__('Part Description'),
			'name'  => 'part_description',
			'maxlength'=>'255'

		));

		$fieldset->addField('part_cost', 'hidden', array(
			'label' => Mage::helper('vendorpricing')->__('Part Cost'),
			'name'  => 'part_cost',
			'required'  => true,
			'class' => 'required-entry',

		));
		
				
		$fieldset->addField('vendor_part_number', 'text', array(
				'label' => Mage::helper('vendorpricing')->__('Vendor Part Number'),
				'name'  => 'vendor_part_number',
				'style'=>'width:620px'
		));
		
		$fieldset->addField('vendor_descritption', 'text', array(
				'label' => Mage::helper('vendorpricing')->__('Vendor Description'),
				'name'  => 'vendor_descritption',
				'maxlength'=>'255',
				'style'=>'width:620px'		
				
		));
		
		$fieldset->addField('vendor_cost', 'text', array(
				'label' => Mage::helper('vendorpricing')->__('Vendor Cost'),
				'name'  => 'vendor_cost',
				'required'  => true,
				'class' => 'required-entry',
		));
		
		
		
		

		
		$fieldset->addField('status', 'select', array(
			'label' => Mage::helper('vendorpricing')->__('Status'),
			'name'  => 'status',
			'values'=> array(
				array(
					'value' => 1,
					'label' => Mage::helper('vendorpricing')->__('Enabled'),
				),
				array(
					'value' => 0,
					'label' => Mage::helper('vendorpricing')->__('Disabled'),
				),
			),
			'value' => '1'
				
		));
		if (Mage::app()->isSingleStoreMode()){
			$fieldset->addField('store_id', 'hidden', array(
                'name'      => 'stores[]',
                'value'     => Mage::app()->getStore(true)->getId()
            ));
            Mage::registry('current_vendorpricing')->setStoreId(Mage::app()->getStore(true)->getId());
		}
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

<script type="text/javascript">
init = function (){ 
	
	if(document.getElementById('vendorpricing_vendor_cost').value==''){
		document.getElementById('vendorpricing_status').value = '1';
	}
		
}// Attach the onload function 
Event.observe(window, 'load', init, false);

function getProdcut(value_name){
	var name_string = value_name.split('@@@');
	
	document.getElementById('vendorpricing_products').value = name_string['0'];
	document.getElementById('vendorpricing_part_number').value = name_string['1'];
	document.getElementById('vendorpricing_part_description').value = name_string['2'];
	document.getElementById('vendorpricing_part_cost').value = name_string['3'];
	
}
</script>