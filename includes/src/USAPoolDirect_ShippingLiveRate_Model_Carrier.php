<?php

class USAPoolDirect_ShippingLiveRate_Model_carrier extends Mage_Shipping_Model_Carrier_Abstract implements Mage_Shipping_Model_Carrier_Interface {

    protected $_code = 'usapooldirect_shippingliverate';

    public function collectRates(Mage_Shipping_Model_Rate_Request $request ) {
		return false;

    }

    

    
    public function getAllowedMethods() {
        return array(
            'standard' => 'Standard',
            'express' => 'Express',
        );
    }

}
