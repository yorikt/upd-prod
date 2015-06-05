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
 * Customervendorid edit form tab
 *
 * @category    USAPoolDirect
 * @package     USAPoolDirect_Vendorrelation
 * @author      Ultimate Module Creator
 */
class USAPoolDirect_Vendorrelation_Block_Adminhtml_Customervendorid_Edit_Tab_Form
    extends Mage_Adminhtml_Block_Widget_Form {
    /**
     * prepare the form
     * @access protected
     * @return Vendorrelation_Customervendorid_Block_Adminhtml_Customervendorid_Edit_Tab_Form
     * @author Ultimate Module Creator
     */
    protected function _prepareForm(){
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('customervendorid_');
        $form->setFieldNameSuffix('customervendorid');
        $this->setForm($form);
        $fieldset = $form->addFieldset('customervendorid_form', array('legend'=>Mage::helper('usapooldirect_vendorrelation')->__('Customervendorid')));

        $fieldset->addField('customervendor_id', 'text', array(
            'label' => Mage::helper('usapooldirect_vendorrelation')->__('customervendor id'),
            'name'  => 'customervendor_id',

        ));
        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('usapooldirect_vendorrelation')->__('Status'),
            'name'  => 'status',
            'values'=> array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('usapooldirect_vendorrelation')->__('Enabled'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('usapooldirect_vendorrelation')->__('Disabled'),
                ),
            ),
        ));
        if (Mage::app()->isSingleStoreMode()){
            $fieldset->addField('store_id', 'hidden', array(
                'name'      => 'stores[]',
                'value'     => Mage::app()->getStore(true)->getId()
            ));
            Mage::registry('current_customervendorid')->setStoreId(Mage::app()->getStore(true)->getId());
        }
        $formValues = Mage::registry('current_customervendorid')->getDefaultValues();
        if (!is_array($formValues)){
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getCustomervendoridData()){
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getCustomervendoridData());
            Mage::getSingleton('adminhtml/session')->setCustomervendoridData(null);
        }
        elseif (Mage::registry('current_customervendorid')){
            $formValues = array_merge($formValues, Mage::registry('current_customervendorid')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
