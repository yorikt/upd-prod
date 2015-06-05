<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
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
 * @category    Mage
 * @package     Mage_Shipping
 * @copyright   Copyright (c) 2013 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/** 
 * Fields:
 * - carrier: ups
 * - carrierTitle: United Parcel Service
 * - method: 2day
 * - methodTitle: UPS 2nd Day Priority
 * - price: $9.40 (cost+handling)
 * - cost: $8.00
 */
class USAPoolDirect_ShippingLiveRate_Model_Rate_Result_Method extends Mage_Shipping_Model_Rate_Result_Method
{     
    /**
     * Round shipping carrier's method price
     *
     * @param string|float|int $price
     * @return Mage_Shipping_Model_Rate_Result_Method
     */
    public function setPrice($price)
    {
        /*$this->setData('price', Mage::app()->getStore()->roundPrice($price));
        return $this;*/
    	//echo "adssdfsdjghgyr"; exit;
    	$final_price = Mage::app()->getStore()->roundPrice($price);
    	
    	if (Mage::getStoreConfigFlag('carriers/USAPoolDirect_ShippingLiveRate/active')) {
    		if($this->getData('method')!='freeshipping'){
    			$flat_fee_value = Mage::getStoreConfig('carriers/USAPoolDirect_ShippingLiveRate/flat_fee');
    			$flat_fee_percentage = Mage::getStoreConfig('carriers/USAPoolDirect_ShippingLiveRate/percentage');
    			$percent_value = ($final_price*$flat_fee_percentage/100);
    			$final_price =$final_price+$flat_fee_value+$percent_value;
    		}	
    	}
    	
    	$this->setData('price', $final_price);
    	return $this;
    	
    }
}
