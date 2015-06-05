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
 * store selection tab
 *
 * @category	USAPoolDirect
 * @package		USAPoolDirect_Purchaseorder
 * @author Ultimate Module Creator
 */

class USAPoolDirect_Purchaseorder_Block_Adminhtml_Purchaseorder_Edit_Tab_Order extends Mage_Adminhtml_Block_Template implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    protected $_chat = null;

    protected function _construct()
    {
    	parent::_construct();
    }
    
    public function getTabLabel() {
        return $this->__('Purchase Order');
    }

    public function getTabTitle() {
        return $this->__('Purchase Order');
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

    public function getAfter()
    {
    return 'order_info';
    }

    public function getTabUrl()
    {
         return $this->getUrl('/purchaseorder_purchaseorder/grid/',array('order_id'=>$this->getRequest()->getParam('order_id')));
    }
}