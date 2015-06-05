<?php 
/**
 * USAPoolDirect_Purchaseorder extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category   	USAPoolDirect
 * @package		USAPoolDirect_Purchaseorder
 * @copyright  	Copyright (c) 2014
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Purchase Order helper
 *
 * @category	USAPoolDirect
 * @package		USAPoolDirect_Purchaseorder
 * @author Ultimate Module Creator
 */
class USAPoolDirect_Purchaseorder_Helper_Purchaseorder extends Mage_Core_Helper_Abstract{
	/**
	 * check if breadcrumbs can be used
	 * @access public
	 * @return bool
	 * @author Ultimate Module Creator
	 */
	public function getUseBreadcrumbs(){
		return Mage::getStoreConfigFlag('purchaseorder/purchaseorder/breadcrumbs');
	}
}