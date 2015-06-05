<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE_AFL.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    design
 * @package     default_default
 * @copyright   Copyright (c) 2013 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */
class USAPoolDirect_Vendorrelation_Block_Adminhtml_Vendorlist extends Mage_Adminhtml_Block_Template{}

$customer_id = (int) Mage::app()->getRequest()->getParam('id');
$address_id=(int) Mage::app()->getRequest()->getParam('address_id');
$type = Mage::app()->getRequest()->getParam('type');
$nearby_config=Mage::getStoreConfig('usapooldirect_vendorrelation/mycustom_group/nearby_distance');

if(!$type){
    $type="nearbyvendor";
}


$customer = Mage::getModel('customer/customer')->load($customer_id); //insert cust ID
$customerData= $customer->getData();

if($customerData['default_billing']!=''){
    $customer_add_id=$customerData['default_billing'];
}else{
    $customer_add_id=$customerData['default_shipping'];
}
$customer_address=Mage::getModel('customer/address')->load($customer_add_id)->getData();
$customer_marker="<h4>".$customer_address['firstname']." ".$customer_address['lastname']."</h4>".$customer_address['street'].",<br/>".$customer_address['region']."-".$customer_address['postcode'];

$custvendorrelation = Mage::getModel('usapooldirect_vendorrelation/custvendorrelation')->getCollection();
$customer_vendor=$custvendorrelation->getData();

$assignvendor_url =Mage:: registry ('assignvendor');
$nearbyvendor_url =Mage:: registry ('nearbyvendor');
$allvendor_url =Mage:: registry ('allvendor');

$core_resource=Mage::getSingleton("core/resource");
$table_name=$core_resource->getTableName('vendors_managevendors');
$table_cust_latlong=$core_resource->getTableName('usapooldirect_customer_latilong');
$table_vendorrelation=$core_resource->getTableName('usapooldirect_vendorrelation_custvendorrelation');

$connection = Mage::getSingleton('core/resource')->getConnection('core_write');

if($address_id){
    $add_id=$address_id;
    
}else{
    $add_id=$customerData['default_shipping'];
    
}

$cust_query="select * from $table_cust_latlong where customer_id=$customer_id and address_id=$add_id";
$cust_data=$connection->fetchAll($cust_query);


$cust_lat=(float)$cust_data[0]['latitude'];
$cust_lang=(float)$cust_data[0]['longitude'];

$join="LEFT";
$having="";
$no_record_message = '';
$url='';

//Button class
$assigned_button_class = 'back';
$nearbyvendor_button_class = 'back';
$allvendor_button_class = 'back';


switch ($type) {
    case "assignvendor":
        $join="INNER";
		$no_record_message = " assigned to this customer.";
		$assigned_button_class = '';
                $url=$assignvendor_url;
                $c="COUNT(*) AS total,";
        break;
    case "nearbyvendor":
        $join="LEFT";
        $having="Having distance < $nearby_config";
		$no_record_message = " near by $nearby_config miles.";
		$nearbyvendor_button_class = '';
                $url=$nearbyvendor_url;
                $c="";
        break;
    case "allvendor":
        $join="LEFT";
        $having="";
		$allvendor_button_class = '';
                $url=$allvendor_url;
                $c="COUNT(*) AS total,";
		break;
}

if(Mage::app()->getRequest()->getParam('page')){
    $page=Mage::app()->getRequest()->getParam('page');
}else{
    $page=1;
}

if(Mage::app()->getRequest()->getParam('per_page')){
   $per_page= Mage::app()->getRequest()->getParam('per_page');
}else{
$per_page = 20; // Records per page.
}
$startpoint = ($page * $per_page) - $per_page;


$query="(SELECT DISTINCT a.entity_id,a.vendorname,a.city,a.state,a.zipcode,a.address,a.poemail,a.primary_contact,a.active,a.address2,a.latitude,a.longitude,IF(b.vendor_id,1,0) AS Flag,( 3959 * acos( cos( radians(".$cust_lat.") ) * cos( radians( latitude ) ) * cos( radians( longitude) - radians(".$cust_lang.") ) + sin( radians(".$cust_lat.") ) * sin( radians( latitude ) ) ) ) AS distance FROM"
        . " $table_name As a $join JOIN $table_vendorrelation As b on a.entity_id=b.vendor_id and b.cust_id='".$customer_id."' $having ORDER BY distance ASC LIMIT {$startpoint},{$per_page})";
//echo $query;


$nearest=$connection->fetchAll($query);


$query_count="(SELECT $c a.entity_id,a.vendorname,a.city,a.state,a.zipcode,a.address,a.poemail,a.primary_contact,a.active,a.address2,a.latitude,a.longitude,IF(b.vendor_id,1,0) AS Flag,( 3959 * acos( cos( radians(".$cust_lat.") ) * cos( radians( latitude ) ) * cos( radians( longitude) - radians(".$cust_lang.") ) + sin( radians(".$cust_lat.") ) * sin( radians( latitude ) ) ) ) AS distance FROM"
        . " $table_name As a $join JOIN $table_vendorrelation As b on a.entity_id=b.vendor_id and b.cust_id='".$customer_id."' $having ORDER BY distance ASC)";

//echo $query_count;
$nearest_count=$connection->fetchAll($query_count);
$near_count=count($nearest_count);
if($type=="nearbyvendor"){
$total=$near_count;
}else{
$total=$nearest_count[0]['total'];
}
$lastpage = ceil($total/$per_page);



$data=array();
//$data[]="['".$customer_marker."','".$cust_lat."','".$cust_lang."']";

for($j=0;$j<sizeof($nearest);$j++){
    $address = "<h4>".$nearest[$j]['vendorname']."</h4>";
    
    if($nearest[$j]['address']!=''){
      $address .= $nearest[$j]['address'];
    }
    
    if($nearest[$j]['address2']!=''){
      $address .= "<br/>".$nearest[$j]['address2'];
    }
    if($nearest[$j]['distance']<=$nearby_config && $nearest[$j]['distance']!=0){
      $data[]="['".$address."','".$nearest[$j]['latitude']."','".$nearest[$j]['longitude']."']";
    }
 }
    $insertvalues = implode(',', $data);

ob_start("callback");

?>
<?php //  Dropdown Box for Customer Addresses Display
//echo Mage::getDesign()->getSkinUrl('images/pager_arrow_right.gif');  ?>

<div id="vendorlist_container">
    
    <p>
         <span class="customer-addresses">
            
<?php 

 $shipping_address= $customerData['default_shipping']; // Get Shipping Address ID
 $data1 = array();
 echo "Addresses : <select class='customer-addresselect' id='address_dropdown' style='width:300px;' url='$url'>";
 foreach ($customer->getAddresses() as $address)
 {
  $data1 = $address->toArray();
  $selectid='';
  if($add_id==$data1['entity_id']) { $selectid= "selected=selected"; } 
  
  echo "<option value=".$data1['entity_id']." ".$selectid.">".$data1['street'].", ".$data1['city'].", ".$data1['region'].", ".$data1['country_id']."</option>";

 } 
  echo "</select>";



?>
 <!--src="<?php //echo Mage::getDesign()->getSkinUrl('images/pager_arrow_right.gif');?>"-->
</span>
<span style="float:right;">
<?php if($page==1){ echo '<img style="margin: 0 3px;vertical-align: middle;" src='.Mage::getDesign()->getSkinUrl("images/pager_arrow_left_off.gif").'></img>';}else{?> 
<a href="#" type="button" id="prev" value="<?php if($page<=$lastpage){echo $page-1;} ?>" name="Prev"  url="<?php echo $url; ?>"><img src="<?php echo Mage::getDesign()->getSkinUrl('images/pager_arrow_left.gif');?>" /></a><?php } ?>
&nbsp;<input type="text" style="width: 2em;" name="page" value="<?php echo $page;?>" id="page" url="<?php echo $url; ?>" />
<?php if($page>=$lastpage){
    echo '<img  style="margin: 0 3px;vertical-align: middle;" src='.Mage::getDesign()->getSkinUrl("images/pager_arrow_right_off.gif").'></img>';
}else{?>
<a href="#" id="next" value="<?php if($page<=$lastpage){echo $page+1;} ?>" name="Next"  url="<?php echo $url; ?>"><img src="<?php echo Mage::getDesign()->getSkinUrl('images/pager_arrow_right.gif');?>" /></a><?php } ?>
        Of <?php echo $lastpage;?> Pages &nbsp;&nbsp;|&nbsp;View &nbsp;&nbsp;<select name="list"  id="list" url="<?php echo $url; ?>">
        <option value="20" <?php if($per_page=="20"){echo "selected";}?>>20</option>
        <option value="30" <?php if($per_page=="30"){echo "selected";}?>>30</option>
        <option value="50" <?php if($per_page=="50"){echo "selected";}?>>50</option>
         <option value="100" <?php if($per_page=="100"){echo "selected";}?>>100</option>
          <option value="200" <?php if($per_page=="200"){echo "selected";}?>>200</option>
    </select>&nbsp;&nbsp;Per Page&nbsp;&nbsp|&nbsp;&nbsp Total <?php echo $total;?> records found</span></p>
<div id="contact_list">
    <div><button type="button" url="<?php echo $assignvendor_url;?>" class="scalable vendor <?php echo $assigned_button_class; ?>" value="Assigned" id="assign" style="float:right;margin: 5px;" >Assigned</button>
    <button type="button" url="<?php echo $nearbyvendor_url;?>" class="scalable vendor <?php echo $nearbyvendor_button_class; ?>"  value="Nearby" id="nearby" style="float:right;margin: 5px;">Near by</button>
    <button type="button" url="<?php echo $allvendor_url;?>" class="scalable vendor <?php echo $allvendor_button_class; ?>" value="All" id="all" style="float:right;margin: 5px;">All</button>
    </div>
	
	<div style="" id="managevendors_tabs_contacts_content">
		<div class="entry-edit-head">
			<h4 class="icon-head head-edit-form fieldset-legend">Suppliers</h4>
			<div class="form-buttons"></div>
		</div>
		<div id="contact_grid">
			<div class="grid">
				<div class="hor-scroll">
					<table cellspacing="0" id="contact_grid_table" class="data">
						
						<thead>
							<tr class="headings">
								<th style="text-align: center;"><span class="nobr"><span>Select</span></span></th>
								<th><span class="nobr"><span>Suppliers Name</span></span></th>
								<th><span class="nobr"><span>City</span></span></th>
								<th><span class="nobr"><span>State</span></span></th>
								<th><span class="nobr"><span>Zip</span></span></th>
								<th><span class="nobr"><span>Distance (In Miles)</span></span></th>
                                                                <th><span class="nobr"><span>Address</span></span></th>
								<th><span class="nobr"><span>Email</span></span></th>
								<th><span class="nobr"><span>Primary</span></span></th>
								<th><span class="nobr"><span>Status</span></span></th>
								
							</tr>
							
						</thead>
						<tbody>
							<?php if(!empty($nearest)){
                                $check_val='';
								foreach($nearest as $contact_val){
                                                                    
							 ?>
								<tr title="#" <?php echo ($contact_val['primary']=='1')?'style="background-color: #E7EFEF;cursor: pointer;"':'style="cursor: pointer;"' ?>>
                                    <td class="a-left last ajax" style="text-align:center !important;"><input type="checkbox" value="<?php echo $contact_val['entity_id'];?>" name="vendor_id[]" <?php if($contact_val['Flag']=='1'){echo "checked"; $check_val.="'".$contact_val['entity_id']."',";}?>/></td>	
									<td class="a-left "><?php echo $contact_val['vendorname'];?></td>
									<td class="a-left "><?php echo $contact_val['city'];?></td>
									<td class="a-left "><?php $region=Mage::getModel('directory/region')->load($contact_val['state']); echo $region->getName(); ?></td>
									<td class="a-left "><?php echo $contact_val['zipcode'];?></td>
                                                                        <td class="a-left "><?php echo round($contact_val['distance'], 2);?></td>
									<td class="a-left "><?php echo $contact_val['address']."".$contact_val['address2'];?></td>
									<td class="a-left "><?php echo $contact_val['poemail'];?></td>
									<td class="a-left "><?php echo $contact_val['primary_contact'];?></td>
									<td class="a-left"><?php echo ($contact_val['active']=='0')?'Disabled':'Enabled';?></td>
									
								</tr>
							<?php  }?>
                                                        <input type="hidden" name="uncheck_id" id="uncheck_id"/>
                                                        <?php }else{?>
									<tr><td colspan="10">No suppliers found <?php echo $no_record_message; ?></td></tr>
							<?php								
									}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	
	
	
	</div>
</div>
<?php 
$check= rtrim($check_val,",");
if($cust_lat=='0' && $cust_lang=='0' || $cust_lat=='' && $cust_lang==''){ ?>
<div style="color:red;">Customer Lat Long Not Found</div>
<?php    
}
?>
<?php if(!empty($nearest)){?>
<div id="map" style="width: 100%; height: 400px;"></div>

<script type="text/javascript">

  // Define your locations: HTML content for the info window, latitude, longitude

  var locations = [<?php echo $insertvalues; ?>];
       
  // Setup the different icons and shadows
  var iconURLPrefix = 'http://maps.google.com/mapfiles/ms/icons/';
    
  var icons = [
    iconURLPrefix + 'green-dot.png',
    iconURLPrefix + 'red-dot.png'
  ]
  var icons_length = icons.length;
 
  var shadow = {
    anchor: new google.maps.Point(15,33),
    url: iconURLPrefix + 'msmarker.shadow.png'
  };

  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 10,
    center: new google.maps.LatLng(-37.92, 151.25),
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    mapTypeControl: false,
    streetViewControl: false,
    panControl: false,
    zoomControlOptions: {
       position: google.maps.ControlPosition.LEFT_BOTTOM
    }
  });

  var infowindow = new google.maps.InfoWindow({
    maxWidth: 160
  });
//alert(infowindow);
  var marker;
  var markers = new Array();
    
  var iconCounter = 0;
    
  // Add the markers and infowindows to the map
  for (var i = 0; i < locations.length; i++) {  
    marker = new google.maps.Marker({
      position: new google.maps.LatLng(locations[i][1], locations[i][2]),
      map: map,
      icon : icons[iconCounter],
      shadow: shadow
    });

    markers.push(marker);

    google.maps.event.addListener(marker, 'click', (function(marker, i) {
      return function() {
        infowindow.setContent(locations[i][0]);
        infowindow.open(map, marker);
      }
    })(marker, i));
      
    iconCounter++;
    // We only have a limited number of possible icon colors, so we may have to restart the counter
    if(iconCounter == 0){
      iconCounter = 0;
    }
  }

  function AutoCenter() {
    //  Create a new viewpoint bound
    var bounds = new google.maps.LatLngBounds();
    //  Go through each...
      
    markers.each(function (marker) {
    bounds.extend(marker.position);
     //alert(index+"=="+index.position);
    });
    //  Fit these bounds to the map
    map.fitBounds(bounds);
  }
  AutoCenter();
  
  
</script> 
<?php } ?>
<script>

    jQuery('#address_dropdown').change(function(event){
       jQuery('#loading-mask').show();
       jQuery.ajax({
			type:"GET",
			url:jQuery(this).attr("url"),
			data:{'address_id':jQuery(this).val()},
			success: function(data){
                                    if(data){
                                        jQuery('#vendorlist_container').html(data);
                                      //  jQuery('#address_id').val(jQuery(this).val());
                                        jQuery('#loading-mask').hide();
                                    }
                        }
		});
       
    });
jQuery('#prev').click(function(event){
//    alert("prev");
	jQuery('#loading-mask').show();
    jQuery.ajax({
			type:"GET",
			url:jQuery(this).attr("url"),
			data:{'page':jQuery(this).val(),'per_page':<?php echo $per_page;?>},
			success: function(data){
                                    if(data){
                                        jQuery('#vendorlist_container').html(data);  
                                        jQuery('#loading-mask').hide();
                                    }
                        }
		});
});
jQuery('#next').click(function(event){
    
	jQuery('#loading-mask').show();
    jQuery.ajax({
			type:"GET",
			url:jQuery(this).attr("url"),
			data:{'page':jQuery(this).val(),'per_page':<?php echo $per_page;?>},
			success: function(data){
                            //alert(data);
                                    if(data){
                                        jQuery('#vendorlist_container').html(data);  
                                        jQuery('#loading-mask').hide();
                                    }
                        }
		});
});
    jQuery('#page').change(function(event){
    var page=jQuery(this).val();
    if(page>=<?php echo $lastpage;?>){
        page=<?php echo $lastpage;?>;
    }
    jQuery.ajax({
			type:"GET",
			url:jQuery(this).attr("url"),
			data:{'page':page,'per_page':<?php echo $per_page;?>},
			success: function(data){
                                    if(data){
                                        jQuery('#vendorlist_container').html(data);  
                                        jQuery('#loading-mask').hide();
                                    }
                        }
		});
});
    
    jQuery('#list').change(function(event){
    jQuery('#loading-mask').show();
    jQuery.ajax({
			type:"GET",
			url:jQuery(this).attr("url"),
			data:{'per_page':jQuery(this).val(),'page':<?php echo $page;?>},
			success: function(data){
                                    if(data){
                                        jQuery('#vendorlist_container').html(data);  
                                        jQuery('#loading-mask').hide();
                                    }
                        }
		});
});

    jQuery('input[type="checkbox"]').change(function(event) {
        var check = [<?php echo $check;?>];
        var vals=jQuery("#uncheck_id").val();
        if(jQuery(this).is(':checked')){
       vals=vals.replace(jQuery(this).val()+","," ")
         jQuery("#uncheck_id").val(vals);

          }else{
        var a=jQuery.inArray(jQuery(this).val(),check );
              if(a!=-1){
               vals = jQuery(this).val()+","+vals;
		jQuery("#uncheck_id").val(vals);
              }
        
          }
      });
    
    jQuery('document').ready(function(){


       var temp ='1';
            jQuery('.vendor').each(function(ele){
            
            jQuery(this).click(function(){
            
            jQuery('#loading-mask').show();
            jQuery.ajax({
			type:"GET",
			url:jQuery(this).attr("url"),
			data:{'per_page':<?php echo $per_page;?>},
			success: function(data){
                                    if(data){
                                        jQuery('#vendorlist_container').html(data);  
                                        jQuery('#loading-mask').hide();
                                    }
                        }
		});  
        });
          
      });
    });    

</script>
</div>
<?php 
ob_end_flush();
?>