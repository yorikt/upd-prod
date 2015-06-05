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
 * Purchase Order Item edit form tab
 *
 * @category	USAPoolDirect
 * @package		USAPoolDirect_Purchaseorderitem
 * @author Ultimate Module Creator
 */
class USAPoolDirect_Purchaseorderitem_Block_Adminhtml_Purchaseorderitem_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form{	
	/**
	 * prepare the form
	 * @access protected
	 * @return Purchaseorderitem_Purchaseorderitem_Block_Adminhtml_Purchaseorderitem_Edit_Tab_Form
	 * @author Ultimate Module Creator
	 */
	protected function _prepareForm(){
		$form = new Varien_Data_Form();
		$form->setHtmlIdPrefix('purchaseorderitem_');
		$form->setFieldNameSuffix('purchaseorderitem');
		$this->setForm($form);
		$fieldset = $form->addFieldset('purchaseorderitem_form', array('legend'=>Mage::helper('purchaseorderitem')->__('Purchase Order Item')));

		$fieldset->addField('qty', 'text', array(
			'label' => Mage::helper('purchaseorderitem')->__('Qty'),
			'name'  => 'qty',
			'required'  => true,
			'class' => 'required-entry',

		));

		$fieldset->addField('item_cost', 'text', array(
			'label' => Mage::helper('purchaseorderitem')->__('Item Cost'),
			'name'  => 'item_cost',
			'required'  => true,
			'class' => 'required-entry',

		));

		$fieldset->addField('receive_qty', 'text', array(
			'label' => Mage::helper('purchaseorderitem')->__('Receive Qty.'),
			'name'  => 'receive_qty',
			'required'  => true,
			'class' => 'required-entry',

		));

		$fieldset->addField('cost_order_no', 'text', array(
			'label' => Mage::helper('purchaseorderitem')->__('Cost Order No.'),
			'name'  => 'cost_order_no',
			'required'  => true,
			'class' => 'required-entry',

		));
		$fieldset->addField('status', 'select', array(
			'label' => Mage::helper('purchaseorderitem')->__('Status'),
			'name'  => 'status',
			'values'=> array(
				array(
					'value' => 1,
					'label' => Mage::helper('purchaseorderitem')->__('Enabled'),
				),
				array(
					'value' => 0,
					'label' => Mage::helper('purchaseorderitem')->__('Disabled'),
				),
			),
		));
		if (Mage::app()->isSingleStoreMode()){
			$fieldset->addField('store_id', 'hidden', array(
                'name'      => 'stores[]',
                'value'     => Mage::app()->getStore(true)->getId()
            ));
            Mage::registry('current_purchaseorderitem')->setStoreId(Mage::app()->getStore(true)->getId());
		}
		if (Mage::getSingleton('adminhtml/session')->getPurchaseorderitemData()){
			$form->setValues(Mage::getSingleton('adminhtml/session')->getPurchaseorderitemData());
			Mage::getSingleton('adminhtml/session')->setPurchaseorderitemData(null);
		}
		elseif (Mage::registry('current_purchaseorderitem')){
			$form->setValues(Mage::registry('current_purchaseorderitem')->getData());
		}
		return parent::_prepareForm();
	}
}