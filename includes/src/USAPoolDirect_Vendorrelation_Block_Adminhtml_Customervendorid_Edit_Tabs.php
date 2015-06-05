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
 * Customervendorid admin edit tabs
 *
 * @category    USAPoolDirect
 * @package     USAPoolDirect_Vendorrelation
 * @author      Ultimate Module Creator
 */
class USAPoolDirect_Vendorrelation_Block_Adminhtml_Customervendorid_Edit_Tabs
    extends Mage_Adminhtml_Block_Widget_Tabs {
    /**
     * Initialize Tabs
     * @access public
     * @author Ultimate Module Creator
     */
    public function __construct() {
        parent::__construct();
        $this->setId('customervendorid_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('usapooldirect_vendorrelation')->__('Customervendorid'));
    }
    /**
     * before render html
     * @access protected
     * @return USAPoolDirect_Vendorrelation_Block_Adminhtml_Customervendorid_Edit_Tabs
     * @author Ultimate Module Creator
     */
    protected function _beforeToHtml(){
        $this->addTab('form_customervendorid', array(
            'label'        => Mage::helper('usapooldirect_vendorrelation')->__('Customervendorid'),
            'title'        => Mage::helper('usapooldirect_vendorrelation')->__('Customervendorid'),
            'content'     => $this->getLayout()->createBlock('usapooldirect_vendorrelation/adminhtml_customervendorid_edit_tab_form')->toHtml(),
        ));
        if (!Mage::app()->isSingleStoreMode()){
            $this->addTab('form_store_customervendorid', array(
                'label'        => Mage::helper('usapooldirect_vendorrelation')->__('Store views'),
                'title'        => Mage::helper('usapooldirect_vendorrelation')->__('Store views'),
                'content'     => $this->getLayout()->createBlock('usapooldirect_vendorrelation/adminhtml_customervendorid_edit_tab_stores')->toHtml(),
            ));
        }
        return parent::_beforeToHtml();
    }
    /**
     * Retrieve customervendorid entity
     * @access public
     * @return USAPoolDirect_Vendorrelation_Model_Customervendorid
     * @author Ultimate Module Creator
     */
    public function getCustomervendorid(){
        return Mage::registry('current_customervendorid');
    }
}
