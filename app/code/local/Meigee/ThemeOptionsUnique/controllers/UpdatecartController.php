<?php
/**
 * Magento
 *
 * @author    Meigeeteam http://www.meaigeeteam.com <nick@meaigeeteam.com>
 * @copyright Copyright (C) 2010 - 2012 Meigeeteam
 *
 */
class Meigee_ThemeOptionsUnique_UpdatecartController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
		$this->loadLayout();
		echo Mage::app()->getLayout()->createBlock('checkout/cart_sidebar')->setTemplate('checkout/cart/topcart.phtml')->toHtml();
    }
}