<?php
class USAPoolDirect_Orderstatus_Block_Sales_Order_View extends Mage_Adminhtml_Block_Sales_Order_View
{
	public function  __construct() {

        parent::__construct();

        $this->_removeButton('order_invoice');
    }
}
	