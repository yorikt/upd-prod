<?php 
/**
 * USAPoolDirect_Vendorrelation extension
 * 
 */

class USAPoolDirect_Vendorrelation_Block_Adminhtml_Customervendorid_Edit_Tab_Vendorlist extends Mage_Adminhtml_Block_Template implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    protected $_chat = null;

    protected function _construct()
    {
    	parent::_construct();
    }
    
    public function getTabLabel() {
        return $this->__('Vendor List');
    }

    public function getTabTitle() {
        return $this->__('Vendor List');
    }
    public function getTabClass()
    {
    	return 'ajax only';
    }
    public function canShowTab() {
        return true;
    }

    public function isHidden() {
        return false;
    }

    public function getOrder(){
        return Mage::registry('customer');
    }
    
    public function getAfter()
    {
    return 'addresses';
    }
    
    public function getTabUrl()
    {
         return $this->getUrl('*/Vendorrelation_Customervendorid/vendorlist', array('_current' => true));
    }
}