<?php
class USAPoolDirect_Purchaseorder_Block_Adminhtml_Purchaseorder_Renderer_Editpolink extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
	public function render(Varien_Object $row)
	{	
		
	
		//$po_custval="?ponumbercust=".$row->getData('po_number');		
		//$orderid_cust="&orderid=".$this->getRequest()->getParam('order_id');
		
		$make_view_link = '<a href="'.$this->getUrl('*/purchaseorder_purchaseorder/editpo', array('po_number' => $row->getData('po_number'),'order_id'=>$this->getRequest()->getParam('order_id'))).'">'.$row->getData('po_number').'</a>';
		
		return $make_view_link;		
	}
}
?>