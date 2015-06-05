<?php
class USAPoolDirect_Vendorrelation_Model_Observer {

    public function customer_save_after($observer) {
        
        $this->customer_save_latlong($observer);
        $vendor_array = Mage::app()->getRequest()->getPost('vendor_id');
	$vendor_uncheck= Mage::app()->getRequest()->getPost('uncheck_id');
	$vendor_uncheck=rtrim($vendor_uncheck,",");

       
            $address = $observer->getCustomer()->getData();

            $customer_id=$address['entity_id'];
            $model = Mage::getModel('usapooldirect_vendorrelation/custvendorrelation');
            $collections = Mage::getModel('usapooldirect_vendorrelation/custvendorrelation')->getCollection();
            $customer_data = $collections->getData();

            $core_resource = Mage::getSingleton('core/resource');
            $table_name=$core_resource->getTableName('usapooldirect_vendorrelation_custvendorrelation');
           
            $write = $core_resource->getConnection('core_write');
            $read = $core_resource->getConnection('core_read');
	  if($vendor_uncheck){
		$delete=$write->query("delete from $table_name where cust_id = '$customer_id' AND vendor_id IN($vendor_uncheck)");
	   }

           $result = $read->fetchAll("select vendor_id from $table_name where cust_id = '$customer_id'");
           $temp=array();
           foreach($result as $key=>$data){
                    $temp[$key]=$data['vendor_id'];
           }
           $diff=array_diff($vendor_array,$temp);
           if ($vendor_array) {
            $sql_value = array();
		foreach($diff as $insert_value){
		$sql_value[] = "('" . $customer_id . "','" . $insert_value . "')";
		}

            if (!empty($sql_value)) {
                $insertvalues = implode(',', $sql_value);
                $write->query("insert into $table_name (cust_id, vendor_id) values " . $insertvalues);
            
            }
        }
    }
     public function customer_save_latlong($observer){
       if(Mage::app()->getRequest()->getPost('calc_latlong')){
		  $address = $observer->getCustomer()->getData();
		  $customer_id=$address['entity_id'];
		  $values_arr = array();
		  foreach(Mage::app()->getRequest()->getPost('calc_latlong') as $address_id){
			
			
			$cust_lat = Mage::app()->getRequest()->getPost('latitude_'.$address_id);
			$cust_lang = Mage::app()->getRequest()->getPost('longitude_'.$address_id);
		  
			$values_arr[] =  "('".$customer_id."','".$cust_lat."','".$cust_lang."','".$address_id."')";
		  }
		  
		  $latlong_values = implode(',',$values_arr);
		  
		$core_resource = Mage::getSingleton('core/resource');
		$table_name=$core_resource->getTableName('usapooldirect_customer_latilong');
		  
		$write = $core_resource->getConnection('core_write');
		// exit;
		$delete=$write->query("delete from $table_name where customer_id = '$customer_id'");
		$write->query("insert into $table_name (customer_id,latitude,longitude,address_id) value ".$latlong_values);
			 
		 }
        
     }
     
     public function customerRegisterSuccess($observer)
    {
     //echo "<pre>";
            $customer=$observer->getEvent()->getCustomerAddress()->getCustomer()->getData();
            $customer_id=$customer['entity_id'];
            
                $address = $observer->getCustomerAddress();
                $address_id=$address['entity_id'];
		$countryName = Mage::getModel('directory/country')->load($address['country_id'])->getName();
		$addressget= $address['street'].",".$address['city'].",".$address['region'].",".$address['postcode'].",".$countryName;
                $result=$this->Get_lat_lang($addressget);
                $latlong=explode(",",$result);

		$core_resource = Mage::getSingleton('core/resource');
		$table_name=$core_resource->getTableName('usapooldirect_customer_latilong');
		$write = $core_resource->getConnection('core_write');
//                echo "insert into $table_name (customer_id,latitude,longitude,address_id) value ('".$customer_id."','".$latlong[0]."','".$latlong[1]."','".$address_id."')"; 
                $delete=$write->query("delete from $table_name where customer_id = '$customer_id'");
                $write->query("insert into $table_name (customer_id,latitude,longitude,address_id) value ('".$customer_id."','".$latlong[0]."','".$latlong[1]."','".$address_id."')");
    }
    public function Get_lat_lang($get_address){
		$map_url='http://maps.googleapis.com/maps/api/geocode/json?sensor=false&address='.urlencode($get_address);

		$add_lat_long = file_get_contents($map_url);
		$result=json_decode($add_lat_long);

		$lat_long=$result->results[0]->geometry->location->lat.",".$result->results[0]->geometry->location->lng;
			return $lat_long;
		}

}
