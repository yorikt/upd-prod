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
 * ProductTypes edit form tab
 *
 * @category	USAPoolDirect
 * @package		USAPoolDirect_Producttype
 * @author Ultimate Module Creator
 */
class USAPoolDirect_Producttype_Block_Adminhtml_Producttype_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form{	
	/**
	 * prepare the form
	 * @access protected
	 * @return Producttype_Producttype_Block_Adminhtml_Producttype_Edit_Tab_Form
	 * @author Ultimate Module Creator
	 */
	protected function _prepareForm(){
		$form = new Varien_Data_Form();
		$form->setHtmlIdPrefix('producttype_');
		$form->setFieldNameSuffix('producttype');
		$this->setForm($form);
		$fieldset = $form->addFieldset('producttype_form', array('legend'=>Mage::helper('producttype')->__('ProductTypes')));

		$fieldset->addField('product_type', 'text', array(
			'label' => Mage::helper('producttype')->__('Product Type'),
			'name'  => 'product_type',
			'required'  => true,
			'class' => 'required-entry',

		));
		$fieldset->addField('status', 'select', array(
			'label' => Mage::helper('producttype')->__('Status'),
			'name'  => 'status',
			'values'=> array(
				array(
					'value' => 1,
					'label' => Mage::helper('producttype')->__('Enabled'),
				),
				array(
					'value' => 0,
					'label' => Mage::helper('producttype')->__('Disabled'),
				),
			),
		));
		if (Mage::app()->isSingleStoreMode()){
			$fieldset->addField('store_id', 'hidden', array(
                'name'      => 'stores[]',
                'value'     => Mage::app()->getStore(true)->getId()
            ));
            Mage::registry('current_producttype')->setStoreId(Mage::app()->getStore(true)->getId());
		}
		if (Mage::getSingleton('adminhtml/session')->getProducttypeData()){
			$form->setValues(Mage::getSingleton('adminhtml/session')->getProducttypeData());
			Mage::getSingleton('adminhtml/session')->setProducttypeData(null);
		}
		elseif (Mage::registry('current_producttype')){
			$form->setValues(Mage::registry('current_producttype')->getData());
		}
		return parent::_prepareForm();
	}
}