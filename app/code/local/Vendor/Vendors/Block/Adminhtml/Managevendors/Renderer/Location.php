<?php
class Vendor_Vendors_Block_Adminhtml_Managevendors_Renderer_Location extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

	public function render(Varien_Object $row) // get vender latitude/Longitude  Using Vender ID
	{
		//$vendor_id = $row->getData();//$this->getColumn()->getIndex());
		$vendor_id =  $this->getRequest()->getParam('id');
		$resource = Mage::getSingleton('core/resource');
		$connection_read = $resource->getConnection('core_read');		
		
		$tableName =$resource->getTableName('vendors_managevendors');		
	if(isset($vendor_id)){
		$query = "SELECT latitude, longitude FROM ".$tableName." WHERE entity_id = ".$vendor_id;
		$item_data = $connection_read->fetchAll($query);
		
		//print_r($item_data[0]['latitude']);
		
		if(!empty($item_data)){
			$latitude_data = $item_data['latitude'];
			$longitude_data = $item_data['longitude'];
		} 
	}		

/* Below script run when page is load first time and also trigger button Map has been display   */
?>
<meta name='viewport' content='initial-scale=1.0, user-scalable=no' />
<script type='text/javascript' src='http://maps.google.com/maps/api/js?sensor=false'></script>
		<script type='text/javascript'>
			var geocoder = new google.maps.Geocoder();
			//var updateflag=0;  // Flag Set for location update button Action
			

			function geocodePosition(pos) {
			  geocoder.geocode({
				latLng: pos
			  }, function(responses) {
				if (responses && responses.length > 0) {
				  updateMarkerAddress(responses[0].formatted_address);
				} else {
				  updateMarkerAddress('Cannot determine address at this location.');
				}
			  });
			}
			function updateMarkerStatus(str) {
			  document.getElementById('markerStatus').innerHTML = str;
			}

			function updateMarkerPosition(latLng) {
			 
			document.getElementById('managevendors_latitude').value=latLng.lat();
				document.getElementById('managevendors_longitude').value=latLng.lng();
			}

			function updateMarkerAddress(str) {
			  document.getElementById('address').innerHTML = str;
			}

// Map Location trigger action Function
			function initialize() {
			//alert("Hello Tester");
			
				var managevendors_address = document.getElementById('managevendors_address').value;
				var managevendors_address2= document.getElementById('managevendors_address2').value;
				var managevendors_city = document.getElementById('managevendors_city').value;
				var state= document.getElementById('managevendors_state');
				var managevendors_state =state.options[state.selectedIndex].text;
				var managevendors_zipcode = document.getElementById('managevendors_zipcode').value;
				
				var address1 = managevendors_address+', '+managevendors_address2+managevendors_city+','+managevendors_state;//document.getElementById("address").value;
				
			//	alert(address1 );
				document.getElementById('managevendors_latitudeaddress').value=address1;
				//managevendors_latitude						
				var managevendors_latitude = document.getElementById('managevendors_latitudeaddress').value;
			
			
				var geocoder = new google.maps.Geocoder();

				geocoder.geocode( { 'address': managevendors_latitude}, function(results, status) {
					var location = results[0].geometry.location;
					
					
				<?php if(!empty($item_data[0]['latitude'])) {  ?>
							if(document.getElementById('managevendors_updateflag').value=='1')
							{
								var firstlatitude= location.lat();
								var firstlongitude= location.lng();
								//alert(firstlatitude);
							}
							else 
							{
								var firstlatitude= '<?php echo $item_data[0]['latitude']; ?>';
								var firstlongitude= '<?php echo $item_data[0]['longitude']; ?>';	
							}
				<?php  }  else  {  ?>

									if(document.getElementById('managevendors_updateflag').value=='1'){ 
										var firstlatitude=location.lat();										 
										var firstlongitude=location.lng();
									
										
									}else{
									
										var firstlatitude= '<?php echo $item_data[0]['latitude']; ?>';
										var firstlongitude= '<?php echo $item_data[0]['longitude']; ?>';
										
									}
				<?php } ?>
				
				document.getElementById('managevendors_updateflag').value='0';	
				
					document.getElementById('latitude').value=firstlatitude;
					document.getElementById('longitude').value=firstlongitude;
	   
					var latLng = new google.maps.LatLng(firstlatitude, firstlongitude);
					var map = new google.maps.Map(document.getElementById('mapCanvas'), {
							zoom: 8,
							center: latLng,
							mapTypeId: google.maps.MapTypeId.ROADMAP
					});
					var marker = new google.maps.Marker({
							position: latLng,
							title: 'Point A',
							map: map,
							draggable: true
					});
			
					updateMarkerPosition(latLng); 
					geocodePosition(latLng);
					google.maps.event.addListener(marker, 'dragstart', function() {
					updateMarkerAddress('Dragging...');
			  });
		  
			google.maps.event.addListener(marker, 'drag', function() {
				updateMarkerStatus('Dragging...');
				updateMarkerPosition(marker.getPosition());
			  });
		  
			google.maps.event.addListener(marker, 'dragend', function() {
				updateMarkerStatus('Drag ended');
				geocodePosition(marker.getPosition());
			});
		});		
		
		}	
		// Onload handler to fire off the app.
		google.maps.event.addDomListener(window, 'load', initialize);
		
		 var mapDiv = document.getElementById('latlangbtn');
		
		function showAlert() {
		  document.getElementById('managevendors_updateflag').value = '1' ;
		  //alert(document.getElementById('managevendors_updateflag').value);
		  initialize();		  
		}
		</script>

<?php 
		
//		return $tablename_vendor_cotact;		
// For Show Map and set Update Location Button
$locationmap="
		<style>			
		
			#mainmapcanvas {height: 400px;margin-top: 50px;position: absolute;right: 33px; width: 34%;}
			#mapCanvas {width: 100%;height: 400px;float: left;	}
			#infoPanel {float: left;margin-left: 10px; display: none;	}
			#infoPanel div {margin-bottom: 5px; }
		</style>
	  <div id='mainmapcanvas'>
	  <div id='mapCanvas'></div>
	  <div id='infoPanel'>
		<b>Marker status:</b>
		<div id='markerStatus'><i>Click and drag the marker.</i></div>
		<b>Current position:</b>
		<div id='info'></div>
			<input name='latitude' class='latitude' id='latitude' type='text' >
			<input name='longitude' class='longitude' id='longitude' type='text' >
		<b>Closest matching address:</b>
		<div id='address'></div>
	  </div><!--<span style='position: relative; top: 20px;'><input type='button' class='latlang form-button' id='latlangbtn' value='Update Location' onclick='showAlert();' /></span>--></div>";
	return $locationmap ;
	
	}
	
	
}
?>