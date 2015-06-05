<?php
/**
 * Vendor_Vendors extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category   	Vendor
 * @package		Vendor_Vendors
 * @copyright  	Copyright (c) 2014
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * contact - managevendors relation edit block
 *
 * @category	Vendor
 * @package		Vendor_Vendors
 * @author Ultimate Module Creator
 */
class Vendor_Vendors_Block_Adminhtml_Contact_Edit_Tab_Managevendors extends Mage_Adminhtml_Block_Widget_Grid{
	/**
	 * Set grid params
	 * @access protected
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function __construct(){
		parent::__construct();
		$this->setId('managevendors_grid');
		$this->setDefaultSort('position');
		$this->setDefaultDir('ASC');
		$this->setUseAjax(true);
		if ($this->getContact()->getId()) {
			$this->setDefaultFilter(array('in_managevendorss'=>1));
		}
	}
	/**
	 * prepare the managevendors collection
	 * @access protected 
	 * @return Vendor_Vendors_Block_Adminhtml_Contact_Edit_Tab_Managevendors
	 * @author Ultimate Module Creator
	 */
	protected function _prepareCollection() {
		$collection = Mage::getResourceModel('vendors/managevendors_collection');
		if ($this->getContact()->getId()){
			$constraint = 'related.contact_id='.$this->getContact()->getId();
		}
		else{
			$constraint = 'related.contact_id=0';
		}
		$collection->getSelect()->joinLeft(
			array('related'=>$collection->getTable('vendors/contact_managevendors')),
			'related.managevendors_id=main_table.entity_id AND '.$constraint,
			array('position'));
		$this->setCollection($collection);
		parent::_prepareCollection();
		return $this;
	}
	/**
	 * prepare mass action grid
	 * @access protected
	 * @return Vendor_Vendors_Block_Adminhtml_Contact_Edit_Tab_Managevendors
	 * @author Ultimate Module Creator
	 */ 
	protected function _prepareMassaction(){
		return $this;
	}
	/**
	 * prepare the grid columns
	 * @access protected
	 * @return Vendor_Vendors_Block_Adminhtml_Contact_Edit_Tab_Managevendors
	 * @author Ultimate Module Creator
	 */
	protected function _prepareColumns(){
		$this->addColumn('in_managevendorss', array(
			'header_css_class'  => 'a-center',
			'type'  => 'checkbox',
			'name'  => 'in_managevendorss',
			'values'=> $this->_getSelectedManagevendorss(),
			'align' => 'center',
			'index' => 'entity_id'
		));
		$this->addColumn('vendorname', array(
			'header'=> Mage::helper('vendors')->__('Vendor Name'),
			'align' => 'left',
			'index' => 'vendorname',
		));
		$this->addColumn('position', array(
			'header'=> Mage::helper('vendors')->__('Position'),
			'name'  => 'position',
			'width' => 60,
			'type'  => 'number',
			'validate_class'=> 'validate-number',
			'index' => 'position',
			'editable'  => true,
		));
	}
	/**
	 * Retrieve selected managevendorss
	 * @access protected
	 * @return array
	 * @author Ultimate Module Creator
	 */
	protected function _getSelectedManagevendorss(){
		$managevendorss = $this->getContactManagevendorss();
		if (!is_array($managevendorss)) {
			$managevendorss = array_keys($this->getSelectedManagevendorss());
		}
		return $managevendorss;
	}
 	/**
	 * Retrieve selected managevendorss
	 * @access protected
	 * @return array
	 * @author Ultimate Module Creator
	 */
	public function getSelectedManagevendorss() {
		$managevendorss = array();
		$selected = Mage::registry('current_contact')->getSelectedManagevendorss();
		if (!is_array($selected)){
			$selected = array();
		}
		foreach ($selected as $managevendors) {
			$managevendorss[$managevendors->getId()] = array('position' => $managevendors->getPosition());
		}
		return $managevendorss;
	}
	/**
	 * get row url
	 * @access public
	 * @return string
	 * @author Ultimate Module Creator
	 */
	public function getRowUrl($item){
		return '#';
	}
	/**
	 * get grid url
	 * @access public
	 * @return string
	 * @author Ultimate Module Creator
	 */
	public function getGridUrl(){
		return $this->getUrl('*/*/managevendorssGrid', array(
			'id'=>$this->getContact()->getId()
		));
	}
	/**
	 * get the current contact
	 * @access public
	 * @return Vendor_Vendors_Model_Contact
	 * @author Ultimate Module Creator
	 */
	public function getContact(){
		return Mage::registry('current_contact');
	}
	/**
	 * Add filter
	 * @access protected
	 * @param object $column
	 * @return Vendor_Vendors_Block_Adminhtml_Contact_Edit_Tab_Managevendors
	 * @author Ultimate Module Creator
	 */
	protected function _addColumnFilterToCollection($column){
		// Set custom filter for in product flag
		if ($column->getId() == 'in_managevendorss') {
			$managevendorsIds = $this->_getSelectedManagevendorss();
			if (empty($managevendorsIds)) {
				$managevendorsIds = 0;
			}
			if ($column->getFilter()->getValue()) {
				$this->getCollection()->addFieldToFilter('entity_id', array('in'=>$managevendorsIds));
			} 
			else {
				if($managevendorsIds) {
					$this->getCollection()->addFieldToFilter('entity_id', array('nin'=>$managevendorsIds));
				}
			}
		} 
		else {
			parent::_addColumnFilterToCollection($column);
		}
		return $this;
	}
}