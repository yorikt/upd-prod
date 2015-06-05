<?php 
class USAPoolDirect_Orderstatus_Block_Sales_Order_View_Orderstatus extends Mage_Core_Block_Template
{
    function invoice_create_direct($order_id,$payment_status) // Create Invoice Dynamically by Order ID
{ 
	$order = Mage::getModel("sales/order")->load($order_id);  // Get Order Details using Order ID
	try 
	{
		if(!$order->canInvoice())
		{
			Mage::throwException(Mage::helper('core')->__('Cannot create an invoice.'));
		}
		$invoice = Mage::getModel('sales/service_order', $order)->prepareInvoice();
		if (!$invoice->getTotalQty()) 
		{
			Mage::throwException(Mage::helper('core')->__('Cannot create an invoice without products.'));
		}
		
		$invoice->setRequestedCaptureCase(Mage_Sales_Model_Order_Invoice::CAPTURE_ONLINE);	// Set Invoice Record Request
		
	// Comment For Only Invoice 
	$commentbyme="Status Updated by Admin";
	if (!empty($commentbyme)) { Mage::getSingleton('adminhtml/session')->setCommentText($commentbyme); }		
        if (!empty($commentbyme)) 
		{
			$invoice->addComment(
				$commentbyme,
				isset($data['comment_customer_notify']),
				isset($data['is_visible_on_front'])
			);
        }			
			
		$invoice->register();					// Invoice Register for new Invoice 
		$transactionSave = Mage::getModel('core/resource_transaction')
			->addObject($invoice)
			->addObject($invoice->getOrder());
		$transactionSave->save();				  
				
		$order->setData('state', "processing");		 // Set Order State Update
		$order->setStatus($payment_status);			// Set Order Status
		//$order->addStatusToHistory($order->getStatus(),$commentbyme, false);
        $order->save();				// Set Order Save Data of invoice
	}
	catch (Mage_Core_Exception $e) 	{	}
	$invoice->setRequestedCaptureCase( Mage_Sales_Model_Order_Invoice::CAPTURE_OFFLINE );	
	//$order->_redirect('*/sales_order/view', array('order_id' => $order_id));
}
// End Invoice Create Function

// Start Comment Add after Change Status
function comment_create_dynamically($order_comment_id)
{
	$user = Mage::getSingleton('admin/session'); // get current logged in user Collection
	$current_userFirstname = $user->getUser()->getFirstname();
	$current_userLastname = $user->getUser()->getLastname();
	$current_Username = $user->getUser()->getUsername();
	
	$commentbyme="Order status updated by ".$current_userFirstname." ".$current_userLastname." [".$current_Username."] ";
	$order = Mage::getModel("sales/order")->load($order_comment_id);  // Set Order Details using Order ID
	$order->addStatusToHistory($order->getStatus(),$commentbyme, false);       //  Add/Set Order Comment for status 
	$order->save();
}
// End Comment Add after Change Status

}
?>