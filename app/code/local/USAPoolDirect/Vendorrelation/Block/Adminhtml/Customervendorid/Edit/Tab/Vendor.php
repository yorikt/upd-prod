<?php 
/**
 * USAPoolDirect_Purchaseorder extension

 */

class USAPoolDirect_Vendorrelation_Block_Adminhtml_Customervendorid_Edit_Tab_Vendor extends Mage_Adminhtml_Block_Template implements Mage_Adminhtml_Block_Widget_Tab_Interface
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
        return Mage::registry('current_order');
    }
    public function getBefore()
    {
    return 'order_info';
    }
    public function getTabUrl()
    {
         return $this->getUrl('*/Vendorrelation_Customervendorid/vendorlist',array('order_id'=>$this->getRequest()->getParam('order_id')));
    }
}