<?php
/**
* Inchoo
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
* Please do not edit or add to this file if you wish to upgrade
* Magento or this extension to newer versions in the future.
** Inchoo *give their best to conform to
* "non-obtrusive, best Magento practices" style of coding.
* However,* Inchoo *guarantee functional accuracy of
* specific extension behavior. Additionally we take no responsibility
* for any possible issue(s) resulting from extension usage.
* We reserve the full right not to provide any kind of support for our free extensions.
* Thank you for your understanding.
*
* @category Inchoo
* @package CustomLinkedProducts
* @author Marko Martinović <marko.martinovic@inchoo.net>
* @copyright Copyright (c) Inchoo (http://inchoo.net/)
* @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
*/

class Inchoo_CustomLinkedProducts_Model_Observer extends Varien_Object
{
    public function catalogProductPrepareSave($observer)
    {
        $event = $observer->getEvent();

        $product = $event->getProduct();
        $request = $event->getRequest();


			
		
		

        $links = $request->getPost('links');
        if (isset($links['custom']) && !$product->getCustomReadonly()) {
            $product->setCustomLinkData(Mage::helper('adminhtml/js')->decodeGridSerializedInput($links['custom']));
        }
		

        Mage::getResourceSingleton('producttype/producttype_productrule')
        ->saveProductruleRelation($_POST);





		
    }

    public function catalogModelProductDuplicate($observer)
    {
        $event = $observer->getEvent();

        $currentProduct = $event->getCurrentProduct();
        $newProduct = $event->getNewProduct();

        $data = array();
        $currentProduct->getLinkInstance()->useCustomLinks();
        $attributes = array();
        foreach ($currentProduct->getLinkInstance()->getAttributes() as $_attribute) {
            if (isset($_attribute['code'])) {
                $attributes[] = $_attribute['code'];
            }
        }
        foreach ($currentProduct->getCustomLinkCollection() as $_link) {
            $data[$_link->getLinkedProductId()] = $_link->toArray($attributes);
        }
        $newProduct->setCustomLinkData($data);
    }

}
