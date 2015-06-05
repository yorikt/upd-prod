<?php
/**
 * Sanjay_Helloworld extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category   	Sanjay
 * @package		Sanjay_Helloworld
 * @copyright  	Copyright (c) 2014
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * HelloIndia admin block
 *
 * @category	cumstomer group
 * @package		cumstomer group
 * @author Ultimate Module Creator
 */
class Inchoo_CumstomLinkedProducts_Block_Catalog_CustomergroupController extends Mage_Adminhtml_Block_Widget_Grid_Container{
	/**
	 * constructor
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function __construct(){
		$this->_controller 		= 'adminhtml_customergroup';
		$this->_blockGroup 		= 'customergroup';
		$this->_headerText 		= Mage::helper('customergroup')->__('Customer Group');
		$this->_addButtonLabel 	= Mage::helper('customergroup')->__('Add customergroup');
		parent::__construct();
	}
}