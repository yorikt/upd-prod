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

class Inchoo_CustomLinkedProducts_Block_Adminhtml_Catalog_Product_Edit_Tab
extends Mage_Adminhtml_Block_Widget
implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    public function canShowTab() 
    {
    	if(Mage::app()->getRequest()->getParam('set')!='' || Mage::app()->getRequest()->getParam('id')!='' ){
        	return true;
    	}
    }

    public function getTabLabel() 
    {
    	if(Mage::app()->getRequest()->getParam('set')!='' || Mage::app()->getRequest()->getParam('id')!='' ){
        	return $this->__('Product Rules');
    	}
    }
	
    public function getTabTitle()        
    {
    	if(Mage::app()->getRequest()->getParam('set')!='' || Mage::app()->getRequest()->getParam('id')!='' ){
        	return $this->__('Product Rules');
    	}
    }

    public function isHidden()
    {
    	if(Mage::app()->getRequest()->getParam('set')!='' || Mage::app()->getRequest()->getParam('id')!='' ){
        return false;
    	}
    }
    
	
    public function getTabUrl() 
    {
    	if(Mage::app()->getRequest()->getParam('set')!='' || Mage::app()->getRequest()->getParam('id')!='' ){
        	return $this->getUrl('*/*/custom', array('_current' => true));
    	}
    }
    
    public function getTabClass()
    {
    	if(Mage::app()->getRequest()->getParam('set')!='' || Mage::app()->getRequest()->getParam('id')!='' ){
        return 'ajax';
    	}
    }

}
