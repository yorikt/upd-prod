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
 * Purchase Order model
 *
 * @category	USAPoolDirect
 * @package		USAPoolDirect_Purchaseorder
 * @author Ultimate Module Creator
 */
class USAPoolDirect_Purchaseorder_Model_Purchaseorder extends Mage_Core_Model_Abstract{
	/**
	 * Entity code.
	 * Can be used as part of method name for entity processing
	 */
	const ENTITY= 'purchaseorder_purchaseorder';
	const CACHE_TAG = 'purchaseorder_purchaseorder';
	/**
	 * Prefix of model events names
	 * @var string
	 */
	protected $_eventPrefix = 'purchaseorder_purchaseorder';
	
	/**
	 * Parameter name in event
	 * @var string
	 */
	protected $_eventObject = 'purchaseorder';
	/**
	 * constructor
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function _construct(){
		parent::_construct();
		$this->_init('purchaseorder/purchaseorder');
	}
	/**
	 * before save purchase order
	 * @access protected
	 * @return USAPoolDirect_Purchaseorder_Model_Purchaseorder
	 * @author Ultimate Module Creator
	 */
	protected function _beforeSave(){
		parent::_beforeSave();
		$now = Mage::getSingleton('core/date')->gmtDate();
		if ($this->isObjectNew()){
			$this->setCreatedAt($now);
		}
		$this->setUpdatedAt($now);
		return $this;
	}
	/**
	 * save purchaseorder relation
	 * @access public
	 * @return USAPoolDirect_Purchaseorder_Model_Purchaseorder
	 * @author Ultimate Module Creator
	 */
	protected function _afterSave() {
		return parent::_afterSave();
	}
	
	/**
	 * function for save purchase order
	 */
	public function savePurchaseOrder(){
		
		$post_data = $_POST['po_order_qty'];
		$order_id = $_POST['order_id'];
		$po_status = (int)$_POST['po_status'];
		$post_po_number = $_POST['po_status'];
		$order = Mage::getModel("sales/order")->load($order_id);
		
		$ordered_items = $order->getAllItems();
		
		//=====================================================================
		// if it is first po order then change order status to processing
		// 13th June 2014
		$count_po_generated = $this->countGeneratedPo($order_id);
		
		if($count_po_generated == '0')
		{
			$order_status = Mage_Sales_Model_Order::STATE_PROCESSING;
			$this->invoice_create_direct($order_id,$order_status);
		}
		//=====================================================================
		
		//echo $billing_address_id=$order->billing_address_id;
		
		// Get shipping address data using the id
		$address = Mage::getModel('sales/order_address')->load($order->shipping_address_id);
		
		$tablename_po = Mage::getSingleton("core/resource")->getTableName('purchaseorder_purchaseorder');
		
		$connection_po = Mage::getSingleton('core/resource')->getConnection('core_write');
		//$connection->beginTransaction();
		if($po_status=='0'){
			
			$po_number = '0';
			
			//query for generate po number
			$query = 'SELECT po_number,entity_id FROM ' . $tablename_po . ' ORDER BY entity_id desc LIMIT 1';
			$po_number = $connection_po->fetchOne($query);
			
			if($po_number!=''){
				$final_po_number = $this->generatePoUniqueNumbe((int)$po_number);
			}else{
				$final_po_number = $this->generatePoUniqueNumbe((int)$po_number);
			}
			
			$address_data = $address->getStreet();
			
			
			$fields_po = array(
					'order_id'    	  => $order_id,
					'po_number'  	  => $final_po_number,
					'order_status'    => 'open',
					'address' 		  => $address_data['0'].' '.$address->getRegion(),
					'pos_issued_date' => date('Y-m-d H:i:s',strtotime($order->getCreatedAt())),
					'order_number'	  => $order->getIncrementId(),
					'phone' 		  => $address->getTelephone(),
					'country_id' 	  => $address->getCountryId(),
					'post_code' 	  => $address->getPostcode(),
					'region_id' 	  => $address->getRegionId(),
					'city' 			  => $address->getCity(),
					'created_at' 	  => date("Y-m-d H:i:s"),
					'updated_at' 	  => date("Y-m-d H:i:s")
			);
			
			$connection_po->insert($tablename_po, $fields_po);
		}else{
			$final_po_number = $post_po_number;
		}	
		
		/***
		 * end code for inset product
		 */
		
		/***
		 * code for inset product item
		 */
		
		$tableName = Mage::getSingleton("core/resource")->getTableName('purchaseorderitem_purchaseorderitem');
		
		$connection = Mage::getSingleton('core/resource')
		->getConnection('core_write');
		//$connection->beginTransaction();
		
		
		foreach ($post_data as $post_data_key => $post_data_val) {
			if ($post_data_val!='0'){
				
				$query = "SELECT * FROM  $tableName  WHERE order_id = '$order_id' AND po_order_no = '$final_po_number' AND item_id = '$post_data_key'";
				$item_data = $connection->fetchAll($query);
				if(count($item_data) == '0'){
					
					$fields = array(
							'order_id'    => $order_id,
							'item_id'  => $post_data_key,
							'item_cost'      => $_POST['po_item_cost'][$post_data_key],
							'order_qty' =>   $_POST['po_total_qty'][$post_data_key],
							'item_sku' => $_POST['po_item_sku'][$post_data_key],
							'item_name' => $_POST['po_item_name'][$post_data_key],
							'requested_qty' =>$post_data_val,
							'po_order_no' =>$final_po_number,
							'created_at' => date("Y-m-d H:i:s"),
							'updated_at' => date("Y-m-d H:i:s")
					);
					$connection->insert($tableName, $fields);
				}else{
					
					$fields = array(
							'item_cost'      => $_POST['po_item_cost'][$post_data_key]*($item_data['0']['order_qty']+$post_data_val),
							'order_qty' =>   $item_data['0']['order_qty']+$post_data_val,
							'requested_qty' => $item_data['0']['order_qty']+$post_data_val,
							'updated_at' => date("Y-m-d H:i:s")
					);
					$where = $connection_po->quoteInto('entity_id =?', $item_data['0']['entity_id']);
					$connection->update($tableName, $fields,$where);
				}
				
				
			}
		}
		//$connection->commit();
		
		/***
		 * end code for inset product item
		 */
		
		return $final_po_number;
		
	}
	/**
	 * function for generate po unique number
	 */
	
	function generatePoUniqueNumbe($number){
		// Add Zeros to number
		++$number;
		$new_number = str_pad($number,'9','0',STR_PAD_LEFT);
		
		return $new_number;
	}
	
	/**
	 * function for edit purchase order
	 */
	function editPurchaseOrder(){

		$tablename_po = Mage::getSingleton("core/resource")->getTableName('purchaseorder_purchaseorder');
		$tablename_po_item = Mage::getSingleton("core/resource")->getTableName('purchaseorderitem_purchaseorderitem');
		
		$connection_po = Mage::getSingleton('core/resource')->getConnection('core_write');
		//$connection->beginTransaction();
		
		$post_data = $_POST;
		
		$pos_issued_date = '';
		if($post_data['pos_issued_date']!=''){
			list($m, $d, $y) = preg_split('/\-/', $post_data['pos_issued_date']);
			$pos_issued_date = sprintf('%4d-%02d-%02d', $y, $m, $d);
		}
		
		$deliver_date = '';
		if($post_data['deliver_date']!=''){
			
			list($m, $d, $y) = preg_split('/\-/', $post_data['deliver_date']);
			$deliver_date = sprintf('%4d-%02d-%02d', $y, $m, $d);
		}
		

		//echo $deliver_date;exit;
		$fields_po = array(
				'order_status'    => $post_data['order_status'],
				'vendor_id'		  => $post_data['vendor_id'],
				'ship_to' 		  => $post_data['ship_to'],
				'company' 		  => $post_data['company'],
				'address' 		  => $post_data['address'],
				'address2' 		  => $post_data['address2'],
				'pos_issued_date' => $pos_issued_date,
				'deliver_date'    => $deliver_date,
				'delivery_method' => $post_data['delivery_method'],
				'terms'		      => $post_data['terms'],
				'note'		      => $post_data['note'],
				'phone' 		  => $post_data['phone'],
				'country_id' 	  => $post_data['country_id'],
				'post_code' 	  => $post_data['post_code'],
				'region_id' 	  => $post_data['region_id'],
				'city' 			  => $post_data['city'],
				'sub_total' 			  => $post_data['sub_total'],
				'grand_total'     => $post_data['grand_total'],
				'tax' 			  => $post_data['tax'],
				'freight' 			  => $post_data['freight'],
				'other_fee' 			  => $post_data['other_fee'],
				'adjustment' 			  => $post_data['adjustment'],
				'updated_at' 	  => date("Y-m-d H:i:s")
		);
		
		
		$where = $connection_po->quoteInto('po_number =?', $post_data['po_number']);
		$connection_po->update($tablename_po, $fields_po,$where);
		
		//code for item update
		if(!empty($post_data['po_item_cost'])){
			$this->udpdatePOItem();
		}
		//end of update order item
		
		//code for back order
		if($post_data['set_back_order']=='1'){
			//update qty for back order
			$this->setBackOrderData();
			//check all border staus is 0 or not then update status
			$this->updateOrderSatus();
		}
		//end code for back order
		
		//code for send email
		if($post_data['send_mail'] =='1' && $post_data['order_status']=='issued'){
			$this->sendMailToVendor();
		} 
		//end code for send email
		
		//=========================================================================
		// change main order status after all po are dilivered
		//13th June 2014
		
		//get the total qty of order
		$order = Mage::getModel("sales/order")->load($post_data['order_id']);
		$ordered_all_items = $order->getAllItems();
		$main_order_qty_sum = 0;
		foreach($ordered_all_items as $new_item){
			switch($new_item->getProductType()){
			        
			        		case "simple":
			        		case "grouped":
								$main_order_qty_sum +=  $new_item->getQtyOrdered();
							break;
			}
		}
		
		//$main_ordered_total_qty = $order->getTotalQtyOrdered();
		$main_ordered_total_qty  = $main_order_qty_sum;
		
		$is_compelete = '0';
		if(isset($post_data['back_order_qty']) && !empty($post_data['back_order_qty'])){
			$is_compelete = '1'; 
			$count_completed_po = $this->countGeneratedPo($post_data['order_id'],array('completed'));
				
			if(round($main_ordered_total_qty)==$count_completed_po)
			{
				$main_order_status = Mage_Sales_Model_Order::STATE_COMPLETE;
				$this->changeMainOrderStatus($post_data['order_id'],$main_order_status);
			}
		}
		//=========================================================================
		
		
		//=========================================================================
		// if it is last po order then change order status to ship
		// 13th June 2014
		
		if($post_data['order_status']=='issued' && $is_compelete=='0'){
			
			$count_po_generated = $this->countGeneratedPo($post_data['order_id'],array('completed','issued'));
			
			if(round($main_ordered_total_qty)==$count_po_generated)
			{
				$this->shipment_create_direct($post_data['order_id']);
					
			}
		}
		//=========================================================================
		
		//code to update main order if all purchase order completed
		//	$this->updateMainOrderStatus();
		//end of update main order
		
		
		return $this;
		/***
		 * end code for inset product
		*/
		
	}
	
	/**
	 * function for create invoice when first po generated
	 * @param int $order_id
	 * @param string $payment_status
	 * // 13th June 2014
	 */
	public function invoice_create_direct($order_id,$payment_status) // Create Invoice Dynamically by Order ID
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
			$order->setStatus($payment_status,true);			// Set Order Status
			$order->addStatusHistoryComment('Invoice Generated.', false);
			
			$order->save();				// Set Order Save Data of invoice
		}
		catch (Mage_Core_Exception $e) 	{	}
		//$invoice->setRequestedCaptureCase( Mage_Sales_Model_Order_Invoice::CAPTURE_OFFLINE );
		
	}
	// End Invoice Create Function


	/**
	 * generate ship order when all po issued
	 * @param int $ordered_id
	 * // 13th June 2014
	 */
	function shipment_create_direct($ordered_id)
	{
		$order = Mage::getModel('sales/order')->load($ordered_id);
		
		try {
		
			if($order->getStatus()!='complete'){
				
				//create shipment
				$shipment = $order->prepareShipment();
		        $shipment->register();
		        $order->setIsInProcess(true);
		        $order->setData('state', Mage_Sales_Model_Order::STATE_COMPLETE);
		        $order->setStatus('shipped',true);
		       // $order->save();
		       
		        $transactionSave = Mage::getModel('core/resource_transaction')
		                    ->addObject($shipment)
		                    ->addObject($shipment->getOrder())
		                    ->save();
		        $order->addStatusHistoryComment('Order Shipped.', false);
		        $order->save();
	        	//END Handle Shipment
			}	
		
		}
		catch (Exception $e) {
			$order->addStatusHistoryComment('Exception occurred during shipment action. Exception message: '.$e->getMessage(), false);
			$order->save();
		}
	}
	// End Shipmet Create Function


	/**
	 * count number of po generated for current order
	 * @param int $order_id
	 * @param string $payment_status
	 * // 13th June 2014 
	 */
	function countGeneratedPo($order_id,$orderstatus = array())
	{
		//$post_data = $_POST; 
		$po_count = '0';
		$connection_po = Mage::getSingleton('core/resource')->getConnection('core_write');
		
		//get all purchase order which are completed or issued
		$connection_purchase = Mage::getSingleton("core/resource")->getConnection('core_write');
		$tablename_purchase = Mage::getSingleton("core/resource")->getTableName('purchaseorder_purchaseorder');
		$tablename_purchaseitems = Mage::getSingleton("core/resource")->getTableName('purchaseorderitem_purchaseorderitem');
		
		$query = "SELECT SUM(poi.requested_qty) as total_qty FROM ".$tablename_purchase." as po
				  LEFT JOIN ".$tablename_purchaseitems." as poi ON poi.po_order_no = po.po_number
				WHERE po.order_id = '".$order_id."'";
		
		if(!empty($orderstatus)){
			$query .= " AND ( ";
			foreach($orderstatus as $po_status)
			{
				$query .= " po.order_status = '".$po_status."' OR "; 
			}
			$query = preg_replace('/ OR $/', '', $query);
			$query .= " ) ";
		}
		
		$ordered_items_array = $connection_purchase->fetchAll($query);
		
		if($ordered_items_array[0]['total_qty'] != ''){
			$po_count = $ordered_items_array[0]['total_qty'];
		}
	
		return $po_count;
	}
	// End countGeneratedPo Function
	
	/**
	 * change the main order status
	 * @param int $order_id
	 * @param string $payment_status
	 * // 13th June 2014 
	 */
	public function changeMainOrderStatus($order_id,$status= '')
	{
		if($order_id!='')
		{
			$order = Mage::getModel("sales/order")->load($order_id);
			$order->setData('state', Mage_Sales_Model_Order::STATE_COMPLETE);
			$order->setStatus($status,true);
			$order->addStatusHistoryComment('Order Compeleted.', false);
			$order->save();
		}
	}
	// End changeMainOrderStatus Function



	/**
	 * update status of main ordre status to completed if
	 * all purchase orders are completed 
	 */
	function updateMainOrderStatus(){
		
		$post_data = $_POST;
		$connection_po = Mage::getSingleton('core/resource')->getConnection('core_write');
		
		//get the total qty of order
		$order = Mage::getModel("sales/order")->load($post_data['order_id']);
		$ordered_total_qty = $order->getTotalQtyOrdered();
		
		
		//get all purchase order which are completed
		$connection_purchase = Mage::getSingleton("core/resource")->getConnection('core_write');
		$tablename_purchase = Mage::getSingleton("core/resource")->getTableName('purchaseorder_purchaseorder');
		$tablename_purchaseitems = Mage::getSingleton("core/resource")->getTableName('purchaseorderitem_purchaseorderitem');
		
		$query = "SELECT SUM(poi.requested_qty) as total_qty FROM ".$tablename_purchase." as po
				  LEFT JOIN ".$tablename_purchaseitems." as poi ON poi.po_order_no = po.po_number
				WHERE po.order_id = '".$post_data['order_id']."' AND po.order_status = 'completed'";
		
		$ordered_items_array = $connection_purchase->fetchAll($query);
		
		if($ordered_items_array[0]['total_qty'] != ''){
			if(round($ordered_total_qty)==$ordered_items_array[0]['total_qty'])
			{
				$order = Mage::getModel('sales/order')->loadByIncrementID($post_data['order_id']);
				$order->setState(Mage_Sales_Model_Order::STATE_COMPLETE, true);
				$order->save();
			 //$order->setState(Mage_Sales_Model_Order::STATE_COMPLETE, true)->save(); exit;
			}
		}echo "=="; exit;
	}// end of updateMainOrder
	
	
	
	/**
	 * function for update po item
	 */
	function udpdatePOItem(){
		
		$tablename_po_item = Mage::getSingleton("core/resource")->getTableName('purchaseorderitem_purchaseorderitem');
		$tablename_po = Mage::getSingleton("core/resource")->getTableName('purchaseorder_purchaseorder');
		$connection_po = Mage::getSingleton('core/resource')->getConnection('core_write');
		//$connection->beginTransaction();
		$post_data = $_POST;
		

		

		//end get qty for po order generate

		
		$sub_total = '0';
		foreach($post_data['po_item_cost'] as $item_id => $po_item_cost){
		
			//$query = "SELECT order_qty FROM  $tablename_po_item  WHERE po_order_no = ".$post_data['po_number']." AND item_id ='$item_id' AND order_id=".$post_data['order_id']."";
			 $query = 'SELECT SUM(poi.requested_qty) as total_qty , order_qty, poi.requested_qty as requested_qty   FROM '.$tablename_po.' as po
			INNER JOIN '.$tablename_po_item.' as poi ON poi.po_order_no = po.po_number
			WHERE po.order_id = '.$post_data['order_id'].' AND po.order_status != "cancelled"  AND item_id ='.$item_id;
			$item_qty = $connection_po->fetchAll($query);
			$item_order_qty = $item_qty['0']['order_qty'];
			$item_total_qty = $item_qty['0']['total_qty'];


			$get_requested_qty = 'SELECT requested_qty from '.$tablename_po_item.' as po where entity_id="'.$post_data['po_entity_id'][$item_id].'"';
			
			$get_requested_qty_arr = $connection_po->fetchAll($get_requested_qty);


			$item_requested_qty = $get_requested_qty_arr['0']['requested_qty'];
			
			//set condition for qty = 0
			if($post_data['po_qty'][$item_id]=='0'){
					
				$this->deletePurchaseOrderItem($post_data['po_number'],$item_id,$post_data['order_id']);
					
			}else{
				//echo "total - ".$item_order_qty;
				//	echo "order - ".$item_total_qty;
				
		
				//echo "remining".
				$total_remaining_items = $item_order_qty - $item_total_qty;
				
				// echo "inseted".$item_requested_qty;

				if($post_data['po_qty'][$item_id] > $total_remaining_items){


					if(($total_remaining_items==0 && $post_data['po_qty'][$item_id]<$item_order_qty)){
						if($post_data['po_qty'][$item_id] <= ($total_remaining_items+$item_requested_qty)){
							$po_qty = $post_data['po_qty'][$item_id];
						}else{
							$po_qty = $total_remaining_items+$item_requested_qty;
						}

					}elseif($post_data['po_qty'][$item_id] === $item_requested_qty){
						$po_qty = $post_data['po_qty'][$item_id];
					}else{
						if($post_data['po_qty'][$item_id] <= ($total_remaining_items+$item_requested_qty)){
							$po_qty = $post_data['po_qty'][$item_id];
						}else{
							$po_qty = $total_remaining_items+$item_requested_qty;
						}
					}
				}else{

					$po_qty = $post_data['po_qty'][$item_id];
				}
				
				$fields = array(
						'requested_qty' => $po_qty,
						'vendor_descritption' => $post_data['vendor_descritption'][$item_id],
						'vendor_part_number' => $post_data['vendor_part_number'][$item_id],
						'item_cost'      => $po_item_cost,
						'item_save_flag' => '1',
						'updated_at' => date("Y-m-d H:i:s")
				);
					
				$where_item = array();
				$where_item[] = $connection_po->quoteInto('order_id =?', $post_data['order_id']);
				$where_item[] = $connection_po->quoteInto('item_id =?', $item_id);
				$where_item[] = $connection_po->quoteInto('po_order_no =?', $post_data['po_number']);
				$connection_po->update($tablename_po_item, $fields,$where_item);
				
				$sub_total +=$po_item_cost*$po_qty;
				
			}
		}
		
		
		//echo $deliver_date;exit;

		$fields_po = array(
				'sub_total' => $sub_total,

				'grand_total'     => $sub_total + $post_data['tax'] + $post_data['freight'] + $post_data['other_fee'] + $post_data['adjustment'],

		);
		
		$where = $connection_po->quoteInto('po_number =?', $post_data['po_number']);

		$connection_po->update($tablename_po, $fields_po,$where);
		
		
	}
	
	/**
	 * function for set back order data
	 */
	function setBackOrderData(){
		
		// Get Table name for Purchase order Item
		$tableName = Mage::getSingleton("core/resource")->getTableName('purchaseorderitem_purchaseorderitem');
		
		// Create DB Connection object
		$connection_po = Mage::getSingleton('core/resource')->getConnection('core_write');
		
		// Set POST data to Variable further proceeding.
		$post_data = $_POST;
		
		// Go further if Back order item is updated 
		if(isset($post_data['back_order_qty'])){
			
			// There may be more than one item in PO, We need to calculate Back order Qty and Delivered Qty for each item.
			foreach ($post_data['back_order_qty'] as $item_id => $post_val){
				
				// If all items are delivered, we don't need to do any calculations.
				if($post_data['delivered_qty'][$item_id] != $post_data['po_qty'][$item_id] ){
					
					$back_order_qty = $post_val;
					
					$new_backorder_qty = $post_data['db_back_order_qty'][$item_id]-$post_val;
					
					/** 
					 * 
					 * If post back order quantity is larger than acutall order quantity,
					 * Then, we set back order quantity to it's maximum value,
					 * -----------------------------------------------------------------------
					 * e.g. Item-1 Order quantity is 10, So maximum delivered quantity can be 10 only.
					 * If you add more than 10 qunatity in back order, It'll set to maximum quantity which is 10 in above case.
					 * 
				 	*/
					
					if($post_val>=$post_data['po_qty'][$item_id]-$post_data['delivered_qty'][$item_id]){
							$back_order_qty = $post_data['po_qty'][$item_id] - ($post_data['delivered_qty'][$item_id]);
							
							$new_backorder_qty = 0;
					}
				
					
					$fields = array(
							'delivered_qty' =>  $back_order_qty+$post_data['delivered_qty'][$item_id],
							'back_order_qty' => $new_backorder_qty,
							'updated_at' => date("Y-m-d H:i:s")
					);
			
				
					$where_item = array();
					$where_item[] = $connection_po->quoteInto('order_id =?', $post_data['order_id']);
					$where_item[] = $connection_po->quoteInto('item_id =?', $item_id);
					$where_item[] = $connection_po->quoteInto('po_order_no =?', $post_data['po_number']);
					$connection_po->update($tableName, $fields,$where_item);
				
				}else{
					Mage::getSingleton('adminhtml/session')->addWarning(Mage::helper('purchaseorder')->__('All items are delivered.'));
				} // End If 

			} // End Foreach
			
		} // End If

	} // End Function
	
	/**
	 * function for update order data
	 */
	function updateOrderSatus(){
		$post_data = $_POST;
		
		$tableName = Mage::getSingleton("core/resource")->getTableName('purchaseorder_purchaseorder');
		$connection = Mage::getSingleton('core/resource')->getConnection('core_write');
		
		if($this->checkBackOrderQty()=='0'){
			
			$fields_po = array(
					
					'order_status'    => 'completed',
					'updated_at' 	  => date("Y-m-d H:i:s")
			);
			$where_po = array();
			$where_po[] = $connection->quoteInto('order_id =?', $post_data['order_id']);
			$where_po[] = $connection->quoteInto('po_number =?', $post_data['po_number']);
			$connection->update($tableName, $fields_po,$where_po);
		}
		
	}
	
	/**
	 * function for check back order order qty
	 */
	function checkBackOrderQty(){
		$post_data = $_POST;
		$tableName = Mage::getSingleton("core/resource")->getTableName('purchaseorderitem_purchaseorderitem');
		$connection = Mage::getSingleton('core/resource')
		->getConnection('core_write');
		
		$query_po = 'SELECT SUM(back_order_qty) as total_qty FROM '.$tableName.'
		WHERE order_id = '.$post_data['order_id'].' AND po_order_no ='.$post_data['po_number'];
		
		return $connection->fetchOne($query_po);
	}
	
	/**
	 * function for send email to vendor list
	 */
	/**
	 * function for send email to vendor list
	 */
	function sendMailToVendor(){
		/**
		 * 	Collect data for Purchase order
		 */
		
		
		
		//echo "<pre>";print_r($_POST);
		$post_data = $_POST;
		$connection = Mage::getSingleton('core/resource')
		->getConnection('core_write');
		
		$currency_symbol = Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol();
		
		//get item detail
		$table_item = Mage::getSingleton("core/resource")->getTableName('purchaseorderitem_purchaseorderitem');
		$qty_table = '';
		foreach($post_data['po_qty'] as $item_id => $item_value){
			$query = 'SELECT * FROM '.$table_item.'
			WHERE item_id = '.$item_id.' AND po_order_no = '.$post_data['po_number'].' AND order_id ='.$post_data['order_id'];
			
			$item_data = $connection->fetchAll($query);
			
			
			$order_sku = $item_data['0']['item_sku'];
			if($item_data['0']['vendor_part_number']!=''){
				$order_sku = $item_data['0']['vendor_part_number'];
			}
			
			$order_desc = $item_data['0']['item_name'];
			if($item_data['0']['vendor_descritption']!=''){
				$order_desc = $item_data['0']['vendor_descritption'];
			}
			
			$qty_table .= '<tr>
			<td style="font-size:12px; padding:2px; border-right:solid 1px black;text-align:center;line-height:15px;" width="50"> '.$item_data['0']['requested_qty'].'
			</td>
			<td style="font-size:12px; padding:2px; border-right:solid 1px black;text-align:left;line-height:10px;"width="70"> '.$order_sku.'
			</td>
			<td style="font-size:12px; padding:2px; border-right:solid 1px black;text-align:left;line-height:10px;"width="260"> '.$order_desc.'
			</td>
			<td align="right" style="font-size:12px; padding:2px;line-height:10px;"width="100">'.$currency_symbol.number_format($item_data['0']['item_cost'],2).'
			</td>
			<td align="right" style="font-size:12px;padding:2px; border-left:solid 1px black; border-right:solid 0px black;line-height:10px;"width="100">'.$currency_symbol.number_format($item_data['0']['item_cost']*$item_data['0']['requested_qty'],2).'
			</td>
			</tr>';
		}
		
		//get vendor data
		$tableName = Mage::getSingleton("core/resource")->getTableName('vendors_managevendors');
		
		
		$query = 'SELECT * FROM '.$tableName.'
		WHERE entity_id = '.$post_data['vendor_id'];
		
		$vendor_data = $connection->fetchAll($query);
		
		if($vendor_data['0']['poemail']==''){
			Mage::getSingleton('adminhtml/session')->addWarning('Email not send.');
			return true;
		}
		$region = Mage::getModel('directory/region')->load($vendor_data['0']['state']);
		$customer_region = Mage::getModel('directory/region')->load($post_data['region_id']);
		//end for vendor data
		
		
		$pos_issued_date = '';
		if($post_data['pos_issued_date']!=''){
			list($m, $d, $y) = preg_split('/\-/', $post_data['pos_issued_date']);
			$pos_issued_date = sprintf('%4d-%02d-%02d', $y, $m, $d);
		}
		
		$emailTemplate  = Mage::getModel('core/email_template');
		$emailTemplate->loadDefault('usapool_po_email_template');
		
		//Create an array of variables to assign to template
		
		$logourl =   Mage::getDesign()->getSkinUrl('images',array('_area'=>'frontend'))."/logo.png";
		$emailTemplateVariables = array(
				"store_name"=>Mage::getStoreConfig('general/store_information/name'),
				"store_add"=>Mage::getStoreConfig('general/store_information/address'),
				"store_city"=>Mage::getStoreConfig('general/store_information/city'),
				"store_state"=>Mage::getStoreConfig('general/store_information/state'),
				"store_zip"=>Mage::getStoreConfig('general/store_information/zip'),
				"store_country"=>Mage::getStoreConfig('general/store_information/merchant_country'),
				"store_phone"=>Mage::getStoreConfig('general/store_information/phone'),
				"logo_url"=>$logourl,
				"vendor_name"=>$vendor_data['0']['vendorname'],
				"vendor_address"=>$vendor_data['0']['address'].''.$vendor_data['0']['address2'],
				"vendor_city"=>$vendor_data['0']['city'],
				"vendor_state"=>$region->getName(),
				"vendor_zip"=>$vendor_data['0']['zipcode'],
				"vendor_phone"=>$vendor_data['0']['primary_contact'],
				"purchase_orderno"=>$post_data['po_number'],
				"account_number"=>$vendor_data['0']['accountnumber'],
				"po_date"=>date("j F Y",strtotime($pos_issued_date)),
				"customer_name"=>$post_data['ship_to'],
				"customer_address"=>$post_data['address']."&nbsp;".$post_data['address2'],
				"customer_city"=>$post_data['city'],
				"customer_phone"=>$post_data['phone'],
				"customer_zip"=>$post_data['post_code'],
				"customer_state"=>$customer_region->getName(),
				"shipping_method"=>$post_data['delivery_method'],
				"terms"=>$post_data['terms'],
				"notes"=>$post_data['note'],
				"qty_table"=>$qty_table,
				"subtotal"=>$post_data['sub_total'],
				"tax"=>$post_data['tax'],
				"frieght"=>$post_data['freight'],
				"otherfees"=>$post_data['other_fee'],
				"adjustment"=>$post_data['adjustment'],
				"total"=>$post_data['grand_total'],
				"currency_symbol"=>$currency_symbol
		
		);
		$user = Mage::getSingleton('admin/session');
		$user_send_name = $user->getUser()->getFirstname()." ".$user->getUser()->getLastname();
		$userEmail = $user->getUser()->getEmail();
		
		$emailTemplate->setSenderName(Mage::getStoreConfig('trans_email/ident_general/name'));
		$emailTemplate->setSenderEmail(Mage::getStoreConfig('trans_email/ident_general/email'));
		$emailTemplate->setType('html');
		$emailTemplate->setTemplateSubject('Purchase Order No'.'  '.$post_data['po_number']);
		$emailTemplate->send($vendor_data['0']['poemail'], $vendor_data['0']['vendorname'], $emailTemplateVariables);

		//$processedTemplate =  $emailTemplate->getProcessedTemplate($emailTemplateVariables);
		
	}
	
	/**
	 * function for delete  item from po
	 */
	function deletePurchaseOrderItem($po_number,$item_id,$order_id){
		
		$tableName = Mage::getSingleton("core/resource")->getTableName('purchaseorderitem_purchaseorderitem');
		$tablePOName = Mage::getSingleton("core/resource")->getTableName('purchaseorder_purchaseorder');
		

		$connection_po = Mage::getSingleton('core/resource')->getConnection('core_write');
		
		$deleteCondition = array(); 
		$deleteCondition[] = $connection_po->quoteInto('order_id=?', $order_id);
		$deleteCondition[] = $connection_po->quoteInto('po_order_no=?', $po_number);
		$deleteCondition[] = $connection_po->quoteInto('item_id=?', $item_id);
		
		$connection_po->delete($tableName, $deleteCondition);


		$po_item_query  = 'SELECT * from '.$tableName.' where po_order_no="'.$po_number.'"';
		$item_arr = $connection_po->fetchAll($po_item_query);
		
		if(count($item_arr)<=0){
			$deletePOCondition = array(); 
			$deletePOCondition[] = $connection_po->quoteInto('order_id=?', $order_id);
			$deletePOCondition[] = $connection_po->quoteInto('po_number=?', $po_number);
			$connection_po->delete($tablePOName, $deletePOCondition);
			
		}
		


	}
	
	/**
	 * function for get vendor item
	 */
	function getvendoritemdataAction($po_number,$order_id){
		// Get Vendor Id
		$vendor_id = $_GET['vendor_id'];

		// Get Vendor Pricing table name
		$tableName = Mage::getSingleton("core/resource")->getTableName('vendorpricing_vendorpricing');
		
		// Get Vendor Pricing table name

		$vendor_tableName = Mage::getSingleton("core/resource")->getTableName('vendors_managevendors');

		// Get Purchase order item table name
		$tablename_po_item = Mage::getSingleton("core/resource")->getTableName('purchaseorderitem_purchaseorderitem');

		// Initilize DB resource
		$connection = Mage::getSingleton('core/resource')
		->getConnection('core_write');

		/**
		 * 
		 * To manage parent child relation get vendor parent id from db and set as per condition 
		 */
		$query = "SELECT vendor_parent_id FROM  $vendor_tableName Where active ='1' AND entity_id = $vendor_id";
		$vendor_parent_id = (int)$connection->fetchOne($query);
		//if vendor parent id = '0' set selected vendor id
		if($vendor_parent_id=='0'){
			$vendor_id = $vendor_id; 
		}else{
			$vendor_id = $vendor_parent_id;
		}
		
		/**
		*	Logic ::
		*	1. Fetch Purchase order items for selected Purchase order
		*	2. Get Vendor pricing for fetched Items (as per point 1)
		*	3. If Function call onchange of vendor get item which is not store in our table set orignal item cost 
		*   4. If Function call on load of vendor update item as per vendor data which are get from purchase po
		*   5. Update data into table and return     
		*/
		
		//get purchase order item
		$get_po_item_details = "select * from $tablename_po_item where po_order_no = '$po_number' AND order_id = '$order_id'";
		$get_po_item_details_arr = $connection->fetchAll($get_po_item_details);
		//echo "<pre>";
		foreach ($get_po_item_details_arr as $key => $value) {
			
			
			$get_po_item_details_arr_final[$value['item_id']] = $value;

			# code...
			//get vendor pricing

			$query = "SELECT * FROM  $tableName  WHERE vendor_id = '$vendor_id' and products='".$value['item_id']."' limit 1 ";

			$item_data = $connection->fetchAll($query);
			$final_item_data = array();
			foreach($item_data as $item_val){
				$final_item_data[$item_val['products']] = $item_val;
			}

		}
		
		//if onchange set data
		if(isset($_GET['onchange']) && $_GET['onchange']=='1'){
			//Update Vendor terms to purchase order
			$terms = $this->updateTermsForPOVendor($po_number,$vendor_id,$order_id);
			
			//get remaining item 
			$item_data_arr = array_diff_key($get_po_item_details_arr_final,$final_item_data);
			
			//foreach for set default item cost and sku
			foreach($item_data_arr as $item_key => $item_data_val){
				
				$item_details = Mage::getModel('catalog/product')->load($item_key);
				$final_item_arr[$item_key]['part_number'] = $item_details->getSku();
				$final_item_arr[$item_key]['vendor_cost'] = ($item_details->getCost()=='')?'0.00':number_format($item_details->getCost(),2,'.','');
				$final_item_arr[$item_key]['vendor_descritption'] = '';
				$final_item_arr[$item_key]['vendor_part_number'] = '';
				$final_item_arr[$item_key]['item_save_flag']=0;
			}
			
			//foreach for set vendor item and it's detail 
			foreach($final_item_data as $key => $value_item){
				$final_item_arr[$key]['part_number'] = $value_item['part_number'];
				$final_item_arr[$key]['vendor_cost'] = $value_item['vendor_cost'];
				$final_item_arr[$key]['vendor_descritption'] = $value_item['vendor_descritption'];
				$final_item_arr[$key]['vendor_part_number'] = $value_item['vendor_part_number'];
				$final_item_arr[$key]['item_save_flag']=0;
			}
		}else{
			foreach ($get_po_item_details_arr as $key => $value_item_details) {
				foreach($final_item_data as $item_val){
					if($value_item_details['item_save_flag']==1){
						$final_item_arr[$item_val['products']]['part_number'] = $item_val['part_number'];
						$final_item_arr[$item_val['products']]['vendor_cost'] = $value_item_details['vendor_cost'];
						$final_item_arr[$item_val['products']]['vendor_descritption'] = $value_item_details['vendor_descritption'];
						$final_item_arr[$item_val['products']]['vendor_part_number'] = $value_item_details['vendor_part_number'];
					}else{
						$final_item_arr[$item_val['products']]['part_number'] = $item_val['part_number'];
						$final_item_arr[$item_val['products']]['vendor_cost'] = $item_val['vendor_cost'];
						$final_item_arr[$item_val['products']]['vendor_descritption'] = $item_val['vendor_descritption'];
						$final_item_arr[$item_val['products']]['vendor_part_number'] = $item_val['vendor_part_number'];
						$final_item_arr[$item_val['products']]['item_save_flag']=0;

					}
				}
			}	
			
		}
		
		

		/*foreach ($get_po_item_details_arr as $key => $value) {
					# code...
						
						$query = "SELECT * FROM  $tableName  WHERE vendor_id = '$vendor_id' and products='".$value['item_id']."' limit 1 ";
						$item_data = $connection->fetchAll($query);
						
						foreach($item_data as $item_val){
							if($value['item_save_flag']==1){
								
								$final_item_arr[$item_val['products']]['part_number'] = $item_val['part_number'];
								$final_item_arr[$item_val['products']]['vendor_cost'] = $value['vendor_cost'];
								$final_item_arr[$item_val['products']]['vendor_descritption'] = $value['vendor_descritption'];
								$final_item_arr[$item_val['products']]['vendor_part_number'] = $value['vendor_part_number'];

								if(isset($_GET['onchange']) && $_GET['onchange']=='1'){
									$final_item_arr[$item_val['products']]['part_number'] = $item_val['part_number'];
									$final_item_arr[$item_val['products']]['vendor_cost'] = $item_val['vendor_cost'];
									$final_item_arr[$item_val['products']]['vendor_descritption'] = $item_val['vendor_descritption'];
									$final_item_arr[$item_val['products']]['vendor_part_number'] = $item_val['vendor_part_number'];	
									$final_item_arr[$item_val['products']]['item_save_flag']=0;
								}

							}else{

								$final_item_arr[$item_val['products']]['part_number'] = $item_val['part_number'];
								$final_item_arr[$item_val['products']]['vendor_cost'] = $item_val['vendor_cost'];
								$final_item_arr[$item_val['products']]['vendor_descritption'] = $item_val['vendor_descritption'];
								$final_item_arr[$item_val['products']]['vendor_part_number'] = $item_val['vendor_part_number'];
								$final_item_arr[$item_val['products']]['item_save_flag']=0;
							}
							
							
						
						}
						

					
				}		*/
	
		$this->updateVendorItemForOrder($final_item_arr,$po_number,$order_id,$vendor_id);
		
		$terms = $this->getTermsForVendor($vendor_id);
		
		$email = $this->getEmailForVendor($vendor_id);
		
		return json_encode(array($final_item_arr,$terms,$email));
// 		return json_encode($final_item_arr);
		
	}
	/**
	 * function for update vendor item for order
	 */
	function updateVendorItemForOrder($final_item_arr,$po_number,$order_id,$vendor_id){
		
		$tablename_po = Mage::getSingleton("core/resource")->getTableName('purchaseorder_purchaseorder');
		$tablename_po_item = Mage::getSingleton("core/resource")->getTableName('purchaseorderitem_purchaseorderitem');
		$connection_po = Mage::getSingleton('core/resource')->getConnection('core_write');
		
		if($final_item_arr!=''){
			
			
			
			$query_item = 'SELECT * FROM ' . $tablename_po_item .'
						   WHERE po_order_no = '.$po_number.' AND order_id = '.$order_id;
			$po_item_data = $connection_po->fetchAll($query_item);
			
			foreach($po_item_data as $po_val){
				
				if($final_item_arr[$po_val['item_id']]!='')
				{
					$final_arr = array_merge($po_val,$final_item_arr[$po_val['item_id']]);
					if(isset($_GET['onchange']) && $_GET['onchange']=='1'){
						
						$fields = array(
								'item_save_flag'      => '0',
								'updated_at' => date("Y-m-d H:i:s")
						);
						$where = array();
						
						$where[] = $connection_po->quoteInto('po_order_no =?', $po_number);
						$where[] = $connection_po->quoteInto('order_id =?', $order_id);
						$connection_po->update($tablename_po_item, $fields,$where);
						
					}
					//print_r($final_arr);
					if($final_arr['item_save_flag']=='0'){
						$fields = array(
							'item_cost'      => $final_arr['vendor_cost'],
							'vendor_descritption'      => $final_arr['vendor_descritption'],
							'vendor_part_number'      => $final_arr['vendor_part_number'],
							'updated_at' => date("Y-m-d H:i:s")
						);
						$where = array();
						$where[] = $connection_po->quoteInto('item_id =?', $final_arr['item_id']);
						$where[] = $connection_po->quoteInto('po_order_no =?', $po_number);
						$where[] = $connection_po->quoteInto('order_id =?', $order_id);
						$connection_po->update($tablename_po_item, $fields,$where);
						
						
					}	
				}
			}
		}
		
		$fields_po = array(
				'vendor_id'      => $vendor_id,
				'updated_at' => date("Y-m-d H:i:s")
		);
		$where_po = array();
		$where_po[] = $connection_po->quoteInto('po_number =?', $po_number);
		$where_po[] = $connection_po->quoteInto('order_id =?', $order_id);
		$connection_po->update($tablename_po, $fields_po,$where_po);
	}
	
	/**
	 * function for genrate pdf
	 */
	function generatePdf($po_number,$order_id){
		
		/**
		 * 	Collect data for Purchase order
		 */
		
		
		
		//echo "<pre>";print_r($_POST);
		$post_data = $_POST;
		$connection = Mage::getSingleton('core/resource')
		->getConnection('core_write');
		//get item detail
		$table_item = Mage::getSingleton("core/resource")->getTableName('purchaseorderitem_purchaseorderitem');
		$qty_table = '';
		foreach($post_data['po_qty'] as $item_id => $item_value){
			$query = 'SELECT * FROM '.$table_item.'
			WHERE item_id = '.$item_id.' AND po_order_no = '.$po_number.' AND order_id ='.$order_id;
				
			$item_data = $connection->fetchAll($query);
				
				
			$order_sku = $item_data['0']['item_sku'];
			if($item_data['0']['vendor_part_number']!=''){
				$order_sku = $item_data['0']['vendor_part_number'];
			}
				
			$order_desc = $item_data['0']['item_name'];
			if($item_data['0']['vendor_descritption']!=''){
				$order_desc = $item_data['0']['vendor_descritption'];
			}
				
			$qty_table .= '<tr>
			<td style="font-size:12px; padding:2px; border-left:solid 0px black; border-top:solid 1px black; text-align:left;line-height:15px;"> '.$item_data['0']['requested_qty'].'
			</td>
			<td style="font-size:12px; padding:2px; border-left:solid 1px black; border-top:solid 1px black; text-align:left;line-height:10px;"> '.$order_sku.'
			</td>
			<td style="font-size:12px; padding:2px; border-left:solid 1px black; border-top:solid 1px black; text-align:left;line-height:10px;"> '.$order_desc.'
			</td>
			<td  align="right" style="font-size:12px; padding:2px; border-left:solid 1px black; border-top:solid 1px black; text-align:left;line-height:10px;">'.$item_data['0']['item_cost'].'
			</td>
			<td align="right" style="font-size:12px;padding:2px; border-left:solid 1px black; border-right:solid 0px black; border-top:solid 1px black; line-height:10px;">'.$item_data['0']['item_cost']*$item_data['0']['requested_qty'].'
			</td>
			</tr>';
		}
		
		//get vendor data
		$tableName = Mage::getSingleton("core/resource")->getTableName('vendors_managevendors');
		
		
		$query = 'SELECT * FROM '.$tableName.'
		WHERE entity_id = 1';
		
		$vendor_data = $connection->fetchAll($query);
		
		/*if($vendor_data['0']['poemail']==''){
			Mage::getSingleton('adminhtml/session')->addWarning('Email not send.');
			return true;
		}*/
		$region = Mage::getModel('directory/region')->load($vendor_data['0']['state']);
		//end for vendor data
		
		
		$pos_issued_date = '';
		if($post_data['pos_issued_date']!=''){
			list($m, $d, $y) = preg_split('/\-/', $post_data['pos_issued_date']);
			$pos_issued_date = sprintf('%4d-%02d-%02d', $y, $m, $d);
		}
		
		$emailTemplate  = Mage::getModel('core/email_template');
		$emailTemplate->loadDefault('usapool_po_email_template');
		
		//Create an array of variables to assign to template
		
		
			
		$emailTemplateVariables = array(
				"logo_url"=>"http://localhost/local.usapooldirect.com/skin/adminhtml/default/default/images/logo.gif",
				"vendor_name"=>$vendor_data['0']['vendorname'],
				"vendor_address"=>$vendor_data['0']['address'],
				"vendor_address2"=>$vendor_data['0']['address2'],
				"vendor_city"=>$vendor_data['0']['city']." ".$region->getName(),
				"vendor_phone"=>$vendor_data['0']['primary_contact'],
				"purchase_orderno"=>$post_data['po_number'],
				"account_number"=>$vendor_data['0']['accountnumber'],
				"po_date"=>date("j F Y",strtotime($pos_issued_date)),
				"po_term"=>"distributor looks",
				"customer_name"=>$post_data['ship_to'],
				"customer_address"=>$post_data['address']."<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$post_data['address2'],
				"customer_city"=>$post_data['city'],
				"customer_phone"=>$post_data['phone'],
				"shipping_method"=>$post_data['delivery_method'],
				"terms"=>$post_data['terms'],
				"notes"=>$post_data['note'],
				"qty_table"=>$qty_table,
				"subtotal"=>$post_data['sub_total'],
				"tax"=>$post_data['tax'],
				"frieght"=>$post_data['freight'],
				"otherfees"=>$post_data['other_fee'],
				"adjustment"=>$post_data['adjustment'],
				"total"=>$post_data['grand_total']
		
		);
		
		return $emailTemplate->getProcessedTemplate($emailTemplateVariables);
		
	}
	
	/*****************************
	 ******** COmmment ************
	*****************************
	*/
	
	//fucntion for add comment
	function addComment($po_number,$order_id){
		
		$tablename = Mage::getSingleton("core/resource")->getTableName('purchaseorder_comment_comment');
		$connection = Mage::getSingleton('core/resource')->getConnection('core_write');
		
		$user = Mage::getSingleton('admin/session');
		$user_id = $user->getUser()->getUserId();
		$user_firstname = $user->getUser()->getFirstname();
		$user_lastname = $user->getUser()->getLastname();

		$fields = array(
				'order_id' => $order_id,
				'admin_id' => $user_id,
				'admin_first_name' => $user_firstname,
				'admin_last_name' => $user_lastname,
				'comment'  => $_POST['comment'],
				'po_number' => $po_number,
				'status' =>'1',
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
		);
		
		$connection->insert($tablename, $fields);
	}
	
	//function for get all comment
	function getAllComment($po_number,$order_id){
		$tablename = Mage::getSingleton("core/resource")->getTableName('purchaseorder_comment_comment');
		$connection = Mage::getSingleton('core/resource')->getConnection('core_write');
		
		$user = Mage::getSingleton('admin/session');
		$user_id = $user->getUser()->getUserId();
		
		$query = 'SELECT * FROM ' . $tablename .'
		WHERE admin_id = '.$user_id.' AND order_id = '.$order_id.' AND po_number='.$po_number;
		$comment_data = $connection->fetchAll($query);
		return $comment_data; 
	}
	
	/*****************************
	 *****END COmmment ************
	*****************************
	*/
	
	/**
	 * Get Terms From Manage Vendor
	 * @param unknown $vendor_id
	 */
	public function getTermsForVendor($vendor_id){
		$vendor_collection = Mage::getModel('vendors/managevendors')->getCollection()->addFieldToFilter(array('entity_id'),array($vendor_id));
		
		$terms = $vendor_collection->getData('terms');
		
		if(!empty($terms)){
			return $terms[0]['terms'];
		}
		
		return '';
	}
	
	/**
	 * Update Terms for PO
	 */
	public function updateTermsForPOVendor($po_number,$vendor_id,$order_id){
		$terms =  $this->getTermsForVendor($vendor_id);
		
		// Purchase Order Table
		$tablename_po = Mage::getSingleton("core/resource")->getTableName('purchaseorder_purchaseorder');
		$connection_po = Mage::getSingleton('core/resource')->getConnection('core_write');
		
		$fields_po = array(
				'terms'      => $terms,
		);
		
		$where_po = array();
		$where_po[] = $connection_po->quoteInto('po_number =?', $po_number);
		$where_po[] = $connection_po->quoteInto('order_id =?', $order_id);
		
		$connection_po->update($tablename_po, $fields_po,$where_po);
		
		
	}
	
	/**
	 * get the email of vendor
	 * 
	 */
	public function getEmailForVendor($vendor_id){
		$vendor_collection = Mage::getModel('vendors/managevendors')->getCollection()->addFieldToFilter(array('entity_id'),array($vendor_id));
	
		$terms = $vendor_collection->getData('poemail');
	
		if(!empty($terms)){
			return $terms[0]['poemail'];
		}
	
		return '';
	}
	
	
}