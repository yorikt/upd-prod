<?php
class USAPoolDirect_Purchaseorder_Block_Adminhtml_Purchaseorder_Renderer_Pdf extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
	public function render(Varien_Object $row)
	{
		
		//$make_view_link = '<a href="'.$this->getUrl('*/purchaseorder_purchaseorder/generatepdf', array('po_number' => $row->getData('po_number'),'order_id'=>$this->getRequest()->getParam('order_id'))).'">Download Pdf</a>';
		$po_custval="?ponumbercust=".$row->getData('po_number');		
		$orderid_cust="&orderid=".$this->getRequest()->getParam('order_id');
		
		$order_status = $row->getData('order_status');
			 
		if($order_status == 'issued' || $order_status == 'completed')
		{
			$make_view_link = '<a href="/uspoolpdf/uspoolpdf/uspoolpdf.php'.$po_custval.$orderid_cust.'" target="_blank" >PDF</a>';
		}
		
		//$make_view_link.='/magento_latest/mypdf/mypdf/mypdf.php'.$po_custval.$orderid_cust;
		return $make_view_link;		
	}
}
?>