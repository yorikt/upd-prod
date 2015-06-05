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
 * Contact edit form tab
 *
 * @category	Vendor
 * @package		Vendor_Vendors
 * @author Ultimate Module Creator
 */
class Vendor_Vendors_Block_Adminhtml_Contact_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form{	
	/**
	 * prepare the form
	 * @access protected
	 * @return Vendors_Contact_Block_Adminhtml_Contact_Edit_Tab_Form
	 * @author Ultimate Module Creator
	 */
	protected function _prepareForm(){
		$form = new Varien_Data_Form();
		$form->setHtmlIdPrefix('contact_');
		$form->setFieldNameSuffix('contact');
		$this->setForm($form);
		$fieldset = $form->addFieldset('contact_form', array('legend'=>Mage::helper('vendors')->__('Contact')));

		$fieldset->addField('firstname', 'text', array(
			'label' => Mage::helper('vendors')->__('First Name'),
			'name'  => 'firstname',
			'required'  => true,
			'class' => 'required-entry',

		));

		$fieldset->addField('lastname', 'text', array(
			'label' => Mage::helper('vendors')->__('Last Name'),
			'name'  => 'lastname',
			'required'  => true,
			'class' => 'required-entry',

		));

		$fieldset->addField('title', 'text', array(
			'label' => Mage::helper('vendors')->__('Title'),
			'name'  => 'title',

		));

		$fieldset->addField('officeno', 'text', array(
			'label' => Mage::helper('vendors')->__('Office #'),
			'name'  => 'officeno',

		));

		$fieldset->addField('mobileno', 'text', array(
			'label' => Mage::helper('vendors')->__('Mobile #'),
			'name'  => 'mobileno',

		));

		$fieldset->addField('email', 'text', array(
			'label' => Mage::helper('vendors')->__('Email'),
			'name'  => 'email',

		));

		$fieldset->addField('primary', 'select', array(
			'label' => Mage::helper('vendors')->__('Primary'),
			'name'  => 'primary',
			'required'  => true,
			'class' => 'required-entry',

			'values'=> array(
				array(
					'value' => 1,
					'label' => Mage::helper('vendors')->__('Yes'),
				),
				array(
					'value' => 0,
					'label' => Mage::helper('vendors')->__('No'),
				),
			),
		));
		$fieldset->addField('status', 'select', array(
			'label' => Mage::helper('vendors')->__('Status'),
			'name'  => 'status',
			'values'=> array(
				array(
					'value' => 1,
					'label' => Mage::helper('vendors')->__('Enabled'),
				),
				array(
					'value' => 0,
					'label' => Mage::helper('vendors')->__('Disabled'),
				),
			),
		));
		if (Mage::app()->isSingleStoreMode()){
			$fieldset->addField('store_id', 'hidden', array(
                'name'      => 'stores[]',
                'value'     => Mage::app()->getStore(true)->getId()
            ));
            Mage::registry('current_contact')->setStoreId(Mage::app()->getStore(true)->getId());
		}
		if (Mage::getSingleton('adminhtml/session')->getContactData()){
			$form->setValues(Mage::getSingleton('adminhtml/session')->getContactData());
			Mage::getSingleton('adminhtml/session')->setContactData(null);
		}
		elseif (Mage::registry('current_contact')){
			$form->setValues(Mage::registry('current_contact')->getData());
		}
		return parent::_prepareForm();
	}
}