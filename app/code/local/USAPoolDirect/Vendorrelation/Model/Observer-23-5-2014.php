<?php
class USAPoolDirect_Vendorrelation_Model_Observer {

    public function customer_save_after($observer) {
        
        $this->customer_save_latlong($observer);
        $vendor_array = Mage::app()->getRequest()->getPost('vendor_id');
       
            $address = $observer->getCustomer()->getData();
            $customer_id=$address['entity_id'];
            $model = Mage::getModel('usapooldirect_vendorrelation/custvendorrelation');
            $collections = Mage::getModel('usapooldirect_vendorrelation/custvendorrelation')->getCollection();
            $customer_data = $collections->getData();

            $core_resource = Mage::getSingleton('core/resource');
            $table_name=$core_resource->getTableName('usapooldirect_vendorrelation_custvendorrelation');
           
            $write = $core_resource->getConnection('core_write');
           
            $delete=$write->query("delete from $table_name where cust_id = '$customer_id'");
            if ($vendor_array) {
            $sql_value = array();
            for ($i = 0; $i < sizeof($_POST['vendor_id']); $i++) {
                $sql_value[] = "('" . $customer_id . "','" . $_POST['vendor_id'][$i] . "')";
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
			  
				  $delete=$write->query("delete from $table_name where customer_id = '$customer_id'");
				  $write->query("insert into $table_name (customer_id,latitude,longitude,address_id) value ".$latlong_values);
			 
		 }
	 }

}
