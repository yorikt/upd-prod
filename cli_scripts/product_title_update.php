<?php

	/**
	*
	* Data Migration :: Product Title Update
	* Version : 1.0
	* Author : Ankit Patel
	* Company : Elitech Systems Pvt Ltd.
 	* URL : www.elitechsystems.com
	*
	* Description : This script updates product title. 
	* It removes Manufacture name and SKU name from Product title
	* 
	* Note: This is very specific customization, Not generalize.
	* 
	*/
    set_time_limit(3600);
    ini_set("memory_limit","1000M");
    require_once "../app/Mage.php";
    umask(0);
    Mage::app();


     /**
     * Get the resource model
     */
    $resource = Mage::getSingleton('core/resource');
     
    /**
     * Retrieve the read connection
     */
    $readConnection = $resource->getConnection('core_read');
    $writeConnection = $resource->getConnection('core_write');	
 
  
   
	Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
	$product_collection = Mage::getModel('catalog/product')->getCollection();
	$product_collection->addAttributeToFilter('attribute_set_id','17');
	$product_collection->addAttributeToSelect('*');

try{
	
	foreach($product_collection as $key => $product){
		$name = $product->getName();
		$sku = $product->getSku();
		$manufacturer = $product->getAttributeText('manufacturer');
		
		if(preg_match("/".$sku."/i",$name)){
		
			$new_name = str_replace($manufacturer, "",$name);
			$new_name = str_replace($sku, "",$new_name);
			$new_name = trim($new_name);
			echo "============="."\r\n";
			echo "SKU : ".$sku."\r\n";
			echo "============="."\r\n";
			
			echo $name."\r\n";
			echo $new_name."\r\n";
			
			$product->setName((string)$new_name);
			$product->save();
			
			echo "----------------------------------"."\r\n";
		}
		
		

	} // End Foreach
}catch(Exception $e){
	print_r($e->getMessage());
	Mage::log($e->getMessage());
	exit;
}   	
?>
