<?php
include('../../app/Mage.php');
Mage::app();

require_once('uspoolpdf_include.php');
error_reporting(E_ALL | E_STRICT);
 
$ponumber=$_GET['ponumbercust'];
$orderid=$_GET['orderid'];


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    var $htmlHeader = array();

    public function setHtmlHeader($htmlHeader) {
        $this->htmlHeader = $htmlHeader;
    }

    public function Header() {
    	//print_r($this->htmlHeader); exit;
    	$image_file = 'images/'.$this->htmlHeader['logoimage']; // *** Very IMP: make sure this image is available on given path on your server
    	//$this->SetFont('dejavusans');
    	$headerhtml = '<table style="border-bottom:1px solid black;">
    						<tr>
    							<td rowspan="3" style="width:18%;">'.$this->Image($image_file,15,15,30).'</td>
    							<td style="width:62%;"><span style="font-weight:bold;font-size:14px;">'.$this->htmlHeader['site_tittle'].'</span></td>
    							<td rowspan="3" style="width:20%;padding-right:10px;text-align:right;"><span style="font-weight:bold;font-size:18px;">Purchase Order</span><br/><span style="font-weight:bold;">PO No. </span><span style="color:red;">'.$this->htmlHeader['ponumber'].'</span></td>
    						</tr>
    						<tr>
    								<td>'.$this->htmlHeader['site_address'].' '.$this->htmlHeader['city'].'</td>
    							
    						</tr>
    						<tr>
    								<td><span style="font-size:12px;">'.$this->htmlHeader['state'].', '.$this->htmlHeader['merchant_country'].' '.$this->htmlHeader['zip'].' - '.$this->htmlHeader['site_phone'].'</span></td>
    						</tr>
    										<tr ><td colspan="3" style="line-height:8px;"></td></tr>
    			</table>'; 
    	
    	$this->writeHTML( $headerhtml, true, false, true, false, '');
    }

}




$connection = Mage::getSingleton('core/resource')->getConnection('core_write');
$order = Mage::getModel("sales/order")->load($orderid);
$ordered_items = $order->getAllItems();
//print_r($ordered_items);

// Get Current Currency Of Current Store
$currency=Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol();

$table_item = Mage::getSingleton("core/resource")->getTableName('purchaseorderitem_purchaseorderitem');
$qty_table = '';
$query = 'SELECT * FROM '.$table_item.' WHERE po_order_no = '.$ponumber.' AND order_id ='.$orderid;	
$item_data = $connection->fetchAll($query);
foreach ($item_data as $item_data)
{	 
	 $order_sku = $item_data['item_sku'];
	 $entity_id=$item_data['entity_id'];	 	 
	 $order_desc =$item_data['vendor_descritption'];	 	 
	 $qty_table .= '<tr style="border-bottom: 1px solid red;">
	 <td style="border-left:solid 0px black;  text-align:center;line-height:15px;"> '.$item_data['requested_qty'].'
	 </td>
	 <td style="border-left:solid 1px black;  text-align:left;line-height:10px;">'.$order_sku.'
	 </td>
	 <td style="border-left:solid 1px black; text-align:left;line-height:10px;">'.$order_desc.'
	 </td>
	 <td style="border-left:solid 1px black;line-height:10px; text-align:right;">'.$currency.number_format($item_data['item_cost'],2).'</td>
	 <td align="right" style=" border-left:solid 1px black; border-right:solid 0px black;  line-height:10px;">'.$currency.number_format($item_data['item_cost']*$item_data['requested_qty'],2).'
	 </td>
	 </tr>';	 
}

$purchase_order = Mage::getSingleton("core/resource")->getTableName('purchaseorder_purchaseorder');
$qty_purchase_order = '';
$purchase_order_query = 'SELECT * FROM '.$purchase_order.' WHERE po_number = '.$ponumber.' AND order_id ='.$orderid;
$purchase_order_data = $connection->fetchAll($purchase_order_query);
//echo"<pre>"; print_r($purchase_order_data); exit; 
//print_r($purchase_order_data);
foreach ($purchase_order_data as $purchase_order_data)
{
	$vendor_id = $purchase_order_data['vendor_id'];
	$ship_to = $purchase_order_data['ship_to'];
	$address = $purchase_order_data['address'];
	$address2 = $purchase_order_data['address2'];
	$city = $purchase_order_data['city'];
	$phone = $purchase_order_data['phone'];
	$post_code = $purchase_order_data['post_code'];
	$pos_issued_date = $purchase_order_data['pos_issued_date'];
	$terms = $purchase_order_data['terms'];
	$statename = $purchase_order_data['statename'];
	$delivery_method = $purchase_order_data['delivery_method'];
	
	$sub_total = (float)$purchase_order_data['sub_total'];
	$grand_total = (float)$purchase_order_data['grand_total'];
	$tax = (float)$purchase_order_data['tax'];
	$freight = (float)$purchase_order_data['freight'];
	$other_fee = (float)$purchase_order_data['other_fee'];
	$adjustment = (float)$purchase_order_data['adjustment'];
	
	$sub_total = $currency.number_format($sub_total,2);
	$grand_total = $currency.number_format($grand_total,2);
	$tax = $currency.number_format($tax,2);
	$freight = $currency.number_format($freight,2);
	$other_fee = $currency.number_format($other_fee,2);
	$adjustment = $currency.number_format($adjustment,2);
	
	$note = $purchase_order_data['note'];
}

$vendor_order_details = '';
$tableName = Mage::getSingleton("core/resource")->getTableName('vendors_managevendors');
$vendor_query = 'SELECT * FROM '.$tableName.' WHERE entity_id = '.$vendor_id;

$vendor_data = $connection->fetchAll($vendor_query);
//echo"<pre>"; print_r($vendor_data); exit;
foreach ($vendor_data as $vendor_data)
{
	$vendorname = $vendor_data['vendorname'];	
	$vendor_address = $vendor_data['address'];
	$vendor_address2 = $vendor_data['address2'];
	$vendor_city = $vendor_data['city'];
	$vendor_phone = $vendor_data['phoneno'];
	$vendor_post_code = $vendor_data['zipcode'];
	$vendor_statename = $vendor_data['statename'];
	$vendor_accountnumber = $vendor_data['accountnumber'];
	
	
}

// Get shipping address data using the id
/*$address = Mage::getModel('sales/order_address')->load($order->shipping_address_id);*/


// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('MyPDF');

//$htmlheader['site_tittle']= Mage::getStoreConfig('general/store_information/name')."                                                                              Purchase Order";
$htmlheader['site_tittle']= Mage::getStoreConfig('general/store_information/name');
$htmlheader['site_address'] =  Mage::getStoreConfig('general/store_information/address');
$htmlheader['site_phone'] =  Mage::getStoreConfig('general/store_information/phone');
$htmlheader['merchant_country'] =  Mage::getStoreConfig('general/store_information/merchant_country');
$htmlheader['state'] =  Mage::getStoreConfig('general/store_information/state');
$htmlheader['city'] =  Mage::getStoreConfig('general/store_information/city');
$htmlheader['zip'] =  Mage::getStoreConfig('general/store_information/zip');
$htmlheader['logoimage'] =  'logo.png';
$htmlheader['ponumber'] =  $ponumber;


$pdf->setHtmlHeader($htmlheader);

$pdf->SetTitle($site_tittle); 
$pdf->SetSubject('PDF ');

$pdf->SetKeywords('My, PDF, example, test, guide');
//$headerstring="2801 Youngfield St. Suit 260                                                                                                            Purchase Order\nGolden, CO 80401 . 303.420.7321                                                                                             PO No. ".$ponumber;

//$headerstring=$site_address.'                                                                         PO No. '.$ponumber.' '.$city.', '.$state.', '.$merchant_country.'-'.$zip.'-'.$site_phone; 

// set default header data
//$pdf->SetHeaderData('logo.png','30',$site_tittle, $headerstring);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP+7, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER+10);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// set font
//$pdf->SetFont('dejavusans', '', 10);
// add a page	
$pdf->AddPage();

// reset pointer to the last page
//$pdf->lastPage();
//$pdf->SetFont('dejavusans', '', 8);
$pdf->SetFont('', '', 10);
$html='<table><tr><td><span style="font-size:14px;font-weight:bold;">Account No. <span style="color:red;font-weight:normal;"> '.$vendor_accountnumber.'</span></span></td></tr></table>';

$html.='<br/><br/><table cellspacing="" cellpadding="1">';
$html.='<tr>
		<td colspan="4" style="border-top:solid 1px black;border-left:solid 1px black;border-bottom:solid 1px black;width:75%;padding-left:10px;">
			<h1 style="padding-left:5px; padding-top:2px; padding-bottom:2px; font-size:12px; font-weight:normal;"> VENDOR</h1></td>
        <td  style="border-right:solid 1px black;border-left:solid 1px black;border-top:solid 1px black;border-bottom:solid 1px black;width:25%;"><h1 style="padding-top:2px; padding-bottom:2px; font-size:12px; font-weight:normal;"> PO Details</h1></td></tr>';
$html.= '<tr>
			<td style="border-left:solid 1px black;width:10%;padding-left:10px;"> Name:</td>
			<td colspan="3" style="width:65%">'.$vendorname.'</td>
			<td style="border-left:solid 1px black;border-right:solid 1px black;"> Date: '.date('d/m/Y',strtotime($pos_issued_date)).'</td>
		</tr>
		<tr>
			<td style="border-left:solid 1px black;"> Address:</td>
			<td colspan="3">'.$vendor_address.$vendor_address2.'</td>
			<td style="border-left:solid 1px black;border-right:solid 1px black;"> Terms: '.$terms.'</td>
		</tr>
		<tr>
			<td style="border-left:solid 1px black;"> City:</td>
			<td>'.$vendor_city.'</td><td>State: '.$vendor_statename.'</td>
			<td>Zip: '.$vendor_post_code.'</td>
			<td style="border-left:solid 1px black;border-right:solid 1px black;">&nbsp;</td>
		</tr>
		<tr>
			<td style="border-left:solid 1px black;"> Phone:</td>
			<td colspan="3">'.$vendor_phone.'</td>
			<td style="border-left:solid 1px black;border-right:solid 1px black;"></td>
		</tr>';

//$html .= $vendor_order_details;

$html .= '<tr>
			<td colspan="4" style="border-left:solid 1px black;border-right:solid 1px black;"></td>
			<td  style="border-left:solid 1px black;border-right:solid 1px black;"></td>
		  </tr>';

$html.='<tr><td colspan="4" style="border:solid 1px black;width:75%;">
			<h1 style="padding-left:5px; padding-top:2px; padding-bottom:2px; font-size:12px; font-weight:normal;"> SHIP TO</h1></td>
<td style="border:solid 1px black;width:25%;"><h1 style="padding-top:2px; padding-bottom:2px; font-size:12px; font-weight:normal;"> DELIVERY</h1></td></tr>';
$html.= '<tr>
			<td style="border-left:solid 1px black;width:10%"> Name:</td>
			<td colspan="3" style="width:65%">'.$ship_to.'</td>
			<td style="border-left:solid 1px black;border-right:solid 1px black;"> Method: '.$delivery_method.'</td>
		</tr>
			<tr>
				<td style="border-left:solid 1px black;"> Address:</td>
				<td colspan="3">'.$address.$address2.'</td>
				<td style="border-left:solid 1px black;border-right:solid 1px black;"></td>
			</tr>
			<tr>
				<td style="border-left:solid 1px black;"> City:</td>
				<td>'.$city.'</td>
				<td>State: '.$statename.'</td>
				<td>Zip: '.$post_code.'</td>
				<td style="border-left:solid 1px black;border-right:solid 1px black;">&nbsp;</td>
			</tr>
			<tr>
				<td style="border-left:solid 1px black;border"> Phone:</td>
				<td colspan="3 ">'.$phone.'</td>
				<td style="border-left:solid 1px black;border-right:solid 1px black;"></td>
			</tr>';

//$html .= $purchase_vendor_details;

$html .= '<tr><td colspan="4" style="border-left:solid 1px black;border-bottom:solid 1px black;border-right:solid 1px black;"></td>
<td  style="border-left:solid 1px black;border-right:solid 1px black;border-bottom:solid 1px black;"></td></tr>';

$html .= '</table>&nbsp;<br/>';
if($note!=''){
	$html .= '<table cellpadding="8">';
	$html .= '<tr><td colspan="5" style="border:solid 1px black; "><p style="color:red"><b>NOTE</b>: '.$note.'</p></td></tr>';
	$html .= '</table>&nbsp;<br/>';
}
$html .= '<table cellpadding="3">';
$html .= '
		<tr style="font-size:12px;">
			<th style="border:solid 1px black;width:8%;" align="center">QTY</th>
			<th style="border:solid 1px black;width:17%;" align="left">SKU</th>
			<th style="border:solid 1px black;width:45%;">Description</th>
			<th style="border:solid 1px black;width:15%;" align="center">Unit Price</th>
			<th style="border:solid 1px black;width:15%;" align="center">Total</th>
		</tr>';
$html .= $qty_table;

$html .= '<tr align="right">
			<td colspan="4" style="border-right:solid 1px black;border-top:solid 1px black;" >SubTotal:</td>
			<td style="border-top:solid 1px black;border-right:solid 1px black;">'.$sub_total.'</td>
		  </tr>
		  <tr align="right">
			<td colspan="4" style="border-right:solid 1px black;" align="right">Tax:</td>
			<td style="border-top:solid 1px black;border-right:solid 1px black;">'.$tax.'</td>
		  </tr>
		  <tr align="right">
			<td colspan="4" style="border-right:solid 1px black;" align="right">Freight:</td>
			<td style="border-top:solid 1px black;border-right:solid 1px black;">'.$freight.'</td>
		  </tr>
		  <tr align="right">
			<td colspan="4" style="border-right:solid 1px black;" align="right">Other Fees:</td>
			<td style="border-top:solid 1px black;border-right:solid 1px black;">'.$other_fee.'</td>
		  </tr>
		  <tr align="right">
			<td colspan="4" style="border-right:solid 1px black;" align="right">Adjustment:</td>
			<td style="border-top:solid 1px black;border-right:solid 1px black;">'.$adjustment.'</td>
		  </tr>
		  <tr align="right">
			<td colspan="4" style="border-right:solid 1px black; font-weight:bold" align="right"><h3>Total:</h3></td>
			<td style="border-top:solid 1px black;border-right:solid 1px black;border-bottom:solid 1px black;">'.$grand_total.'</td>
		  </tr>
			';

$html .= '</table>';


// output the HTML content
	$pdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('usapoolpdf_007.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
