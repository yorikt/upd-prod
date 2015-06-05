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
 * Customervendorid admin edit form
 *
 * @category    USAPoolDirect
 * @package     USAPoolDirect_Vendorrelation
 * @author      Ultimate Module Creator
 */
class USAPoolDirect_Vendorrelation_Block_Adminhtml_Customervendorid_Edit
    extends Mage_Adminhtml_Block_Widget_Form_Container {
    /**
     * constructor
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function __construct(){
        parent::__construct();
        $this->_blockGroup = 'usapooldirect_vendorrelation';
        $this->_controller = 'adminhtml_customervendorid';
        $this->_updateButton('save', 'label', Mage::helper('usapooldirect_vendorrelation')->__('Save Customervendorid'));
        $this->_updateButton('delete', 'label', Mage::helper('usapooldirect_vendorrelation')->__('Delete Customervendorid'));
        $this->_addButton('saveandcontinue', array(
            'label'        => Mage::helper('usapooldirect_vendorrelation')->__('Save And Continue Edit'),
            'onclick'    => 'saveAndContinueEdit()',
            'class'        => 'save',
        ), -100);
        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }
    /**
     * get the edit form header
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function getHeaderText(){
        if( Mage::registry('current_customervendorid') && Mage::registry('current_customervendorid')->getId() ) {
            return Mage::helper('usapooldirect_vendorrelation')->__("Edit Customervendorid '%s'", $this->escapeHtml(Mage::registry('current_customervendorid')->getCustomervendorId()));
        }
        else {
            return Mage::helper('usapooldirect_vendorrelation')->__('Add Customervendorid');
        }
    }
}
