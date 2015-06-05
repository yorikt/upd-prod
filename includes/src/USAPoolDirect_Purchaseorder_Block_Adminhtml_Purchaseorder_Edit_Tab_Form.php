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
 * Purchase Order edit form tab
 *
 * @category	USAPoolDirect
 * @package		USAPoolDirect_Purchaseorder
 * @author Ultimate Module Creator
 */
class USAPoolDirect_Purchaseorder_Block_Adminhtml_Purchaseorder_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form{	
	/**
	 * prepare the form
	 * @access protected
	 * @return Purchaseorder_Purchaseorder_Block_Adminhtml_Purchaseorder_Edit_Tab_Form
	 * @author Ultimate Module Creator
	 */
	protected function _prepareForm(){
		$form = new Varien_Data_Form();
		$form->setHtmlIdPrefix('purchaseorder_');
		$form->setFieldNameSuffix('purchaseorder');
		$this->setForm($form);
		$fieldset = $form->addFieldset('purchaseorder_form', array('legend'=>Mage::helper('purchaseorder')->__('Purchase Order')));
		
		$order_id =  $this->getRequest()->getParam('order_id');
		
		$fieldset->addField('order_id', 'hidden', array(
				'label' => Mage::helper('purchaseorder')->__('Order Id'),
				'name'  => 'order_id',
		
		));
		
		$fieldset->addField('po_number', 'text', array(
			'label' => Mage::helper('purchaseorder')->__('PO Number'),
			'name'  => 'po_number',
			'required'  => true,
			'class' => 'required-entry',

		));

		$fieldset->addField('club', 'text', array(
			'label' => Mage::helper('purchaseorder')->__('Club'),
			'name'  => 'club',
			'required'  => true,
			'class' => 'required-entry',

		));

		$fieldset->addField('order_status', 'text', array(
			'label' => Mage::helper('purchaseorder')->__('Order Status'),
			'name'  => 'order_status',
			'required'  => true,
			'class' => 'required-entry',

		));

		$fieldset->addField('ship_to', 'text', array(
			'label' => Mage::helper('purchaseorder')->__('Ship To'),
			'name'  => 'ship_to',
			'required'  => true,
			'class' => 'required-entry',

		));

		$fieldset->addField('address', 'text', array(
			'label' => Mage::helper('purchaseorder')->__('Address'),
			'name'  => 'address',
			'required'  => true,
			'class' => 'required-entry',

		));

		$fieldset->addField('address2', 'text', array(
			'label' => Mage::helper('purchaseorder')->__('Address 2'),
			'name'  => 'address2',
			'required'  => true,
			'class' => 'required-entry',

		));

		$fieldset->addField('phone', 'text', array(
			'label' => Mage::helper('purchaseorder')->__('Phone'),
			'name'  => 'phone',
			'required'  => true,
			'class' => 'required-entry',

		));
		$dateFormatIso = Mage::app()->getLocale()->getDateFormat(
			Mage_Core_Model_Locale::FORMAT_TYPE_SHORT
		);

		$fieldset->addField('pos_issued_date', 'date', array(
			'label' => Mage::helper('purchaseorder')->__('PO Issued Date'),
			'name'  => 'pos_issued_date',
			'required'  => true,
			'class' => 'required-entry',

		'image'	 => $this->getSkinUrl('images/grid-cal.gif'),
		'format'	=> $dateFormatIso,
		));

		$fieldset->addField('deliver_date', 'text', array(
			'label' => Mage::helper('purchaseorder')->__('Deliver Date'),
			'name'  => 'deliver_date',
			'required'  => true,
			'class' => 'required-entry',

		));

		$fieldset->addField('delivery_method', 'text', array(
			'label' => Mage::helper('purchaseorder')->__('Delivery Method'),
			'name'  => 'delivery_method',
			'required'  => true,
			'class' => 'required-entry',

		));

		$fieldset->addField('terms', 'text', array(
			'label' => Mage::helper('purchaseorder')->__('Terms'),
			'name'  => 'terms',

		));

		$fieldset->addField('note', 'textarea', array(
			'label' => Mage::helper('purchaseorder')->__('Note'),
			'name'  => 'note',

		));

		$fieldset->addField('sub_tota', 'text', array(
			'label' => Mage::helper('purchaseorder')->__('Sub Total'),
			'name'  => 'sub_tota',
			'required'  => true,
			'class' => 'required-entry',

		));

		$fieldset->addField('tax', 'text', array(
			'label' => Mage::helper('purchaseorder')->__('Tax'),
			'name'  => 'tax',
			'required'  => true,
			'class' => 'required-entry',

		));

		$fieldset->addField('freight', 'text', array(
			'label' => Mage::helper('purchaseorder')->__('Freight'),
			'name'  => 'freight',

		));

		$fieldset->addField('other_fee', 'text', array(
			'label' => Mage::helper('purchaseorder')->__('Other Fee'),
			'name'  => 'other_fee',

		));

		$fieldset->addField('adjustment', 'text', array(
			'label' => Mage::helper('purchaseorder')->__('Adjustment'),
			'name'  => 'adjustment',
			'required'  => true,
			'class' => 'required-entry',

		));
		$fieldset->addField('status', 'select', array(
			'label' => Mage::helper('purchaseorder')->__('Status'),
			'name'  => 'status',
			'values'=> array(
				array(
					'value' => 1,
					'label' => Mage::helper('purchaseorder')->__('Enabled'),
				),
				array(
					'value' => 0,
					'label' => Mage::helper('purchaseorder')->__('Disabled'),
				),
			),
		));
		if (Mage::app()->isSingleStoreMode()){
			$fieldset->addField('store_id', 'hidden', array(
                'name'      => 'stores[]',
                'value'     => Mage::app()->getStore(true)->getId()
            ));
            Mage::registry('current_purchaseorder')->setStoreId(Mage::app()->getStore(true)->getId());
		}
		if (Mage::getSingleton('adminhtml/session')->getPurchaseorderData()){
			$form->setValues(Mage::getSingleton('adminhtml/session')->getPurchaseorderData());
			Mage::getSingleton('adminhtml/session')->setPurchaseorderData(null);
		}
		elseif (Mage::registry('current_purchaseorder')){
			$form->setValues(Mage::registry('current_purchaseorder')->getData());
		}
		
		//comment tab
		$befor_forward_info = $this->getRequest()->getBeforeForwardInfo();
		if($befor_forward_info['action_name']=='new'){
			$data['order_id'] = $order_id;
			$form->setValues($data);
		}
		
		return parent::_prepareForm();
	}
}