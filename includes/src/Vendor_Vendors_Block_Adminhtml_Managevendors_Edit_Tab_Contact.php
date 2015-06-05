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
 * managevendors - contact relation edit block
 *
 * @category	Vendor
 * @package		Vendor_Vendors
 * @author Ultimate Module Creator
 */
class Vendor_Vendors_Block_Adminhtml_Managevendors_Edit_Tab_Contact extends Mage_Adminhtml_Block_Widget_Grid{
	/**
	 * Set grid params
	 * @access protected
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function __construct(){
		parent::__construct();
		$this->setId('contact_grid');
		$this->setDefaultSort('position');
		$this->setDefaultDir('ASC');
		$this->setUseAjax(true);
		if ($this->getManagevendors()->getId()) {
			$this->setDefaultFilter(array('in_contacts'=>1));
		}
		
	}
	/**
	 * prepare the contact collection
	 * @access protected 
	 * @return Vendor_Vendors_Block_Adminhtml_Managevendors_Edit_Tab_Contact
	 * @author Ultimate Module Creator
	 */
	protected function _prepareCollection() {
		$collection = Mage::getResourceModel('vendors/contact_collection');
		if ($this->getManagevendors()->getId()){
			$constraint = 'related.managevendors_id='.$this->getManagevendors()->getId();
		}
		else{
			$constraint = 'related.managevendors_id=0';
		}
		$collection->getSelect()->joinLeft(
			array('related'=>$collection->getTable('vendors/managevendors_contact')),
			'related.contact_id=main_table.entity_id AND '.$constraint,
			array('position'));
		$this->setCollection($collection);
		parent::_prepareCollection();
		return $this;
	}
	/**
	 * prepare mass action grid
	 * @access protected
	 * @return Vendor_Vendors_Block_Adminhtml_Managevendors_Edit_Tab_Contact
	 * @author Ultimate Module Creator
	 */ 
	protected function _prepareMassaction(){
		return $this;
	}
	/**
	 * prepare the grid columns
	 * @access protected
	 * @return Vendor_Vendors_Block_Adminhtml_Managevendors_Edit_Tab_Contact
	 * @author Ultimate Module Creator
	 */
	protected function _prepareColumns(){
		$this->addColumn('in_contacts', array(
			'header_css_class'  => 'a-center',
			'type'  => 'checkbox',
			'name'  => 'in_contacts',
			'values'=> $this->_getSelectedContacts(),
			'align' => 'center',
			'index' => 'entity_id'
		));
		$this->addColumn('firstname', array(
			'header'=> Mage::helper('vendors')->__('First Name'),
			'align' => 'left',
			'index' => 'firstname',
		));
		$this->addColumn('lastname', array(
				'header'=> Mage::helper('vendors')->__('Last Name'),
				'align' => 'left',
				'index' => 'lastname',
		));
		$this->addColumn('title', array(
				'header'=> Mage::helper('vendors')->__('Title'),
				'align' => 'left',
				'index' => 'title',
		));
		$this->addColumn('officeno', array(
				'header'=> Mage::helper('vendors')->__('Office #'),
				'align' => 'left',
				'index' => 'officeno',
		));
		$this->addColumn('mobileno', array(
				'header'=> Mage::helper('vendors')->__('Mobile #'),
				'align' => 'left',
				'index' => 'mobileno',
		));
		$this->addColumn('email', array(
				'header'=> Mage::helper('vendors')->__('Email'),
				'align' => 'left',
				'index' => 'email',
		));
		
		$this->addColumn('primary', array(
				'header'=> Mage::helper('vendors')->__('Primary'),
				'index' => 'primary',
				'align' => 'left',
				'type'		=> 'options',
				'options'	=> array(
						'1' => Mage::helper('vendors')->__('Yes'),
						'0' => Mage::helper('vendors')->__('No'),
				)
		
		));
		
		$this->addColumn('status', array(
				'header'=> Mage::helper('vendors')->__('Status'),
				'index' => 'status',
				'align' => 'left',
				'type'		=> 'options',
				'options'	=> array(
						'1' => Mage::helper('vendors')->__('Enabled'),
						'0' => Mage::helper('vendors')->__('Disabled'),
				)
		
		));
		/*$this->addColumn('position', array(
			'header'=> Mage::helper('vendors')->__('title'),
			'name'  => 'position',
			'width' => 60,
			'type'  => 'number',
			'validate_class'=> 'validate-number',
			'index' => 'position',
			'editable'  => true,
		));*/
	}
	/**
	 * Retrieve selected contacts
	 * @access protected
	 * @return array
	 * @author Ultimate Module Creator
	 */
	protected function _getSelectedContacts(){
		$contacts = $this->getManagevendorsContacts();
		if (!is_array($contacts)) {
			$contacts = array_keys($this->getSelectedContacts());
		}
		return $contacts;
	}
 	/**
	 * Retrieve selected contacts
	 * @access protected
	 * @return array
	 * @author Ultimate Module Creator
	 */
	public function getSelectedContacts() {
		$contacts = array();
		$selected = Mage::registry('current_managevendors')->getSelectedContacts();
		if (!is_array($selected)){
			$selected = array();
		}
		foreach ($selected as $contact) {
			$contacts[$contact->getId()] = array('position' => $contact->getPosition());
		}
		return $contacts;
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
		return $this->getUrl('*/*/contactsGrid', array(
			'id'=>$this->getManagevendors()->getId()
		));
	}
	/**
	 * get the current managevendors
	 * @access public
	 * @return Vendor_Vendors_Model_Managevendors
	 * @author Ultimate Module Creator
	 */
	public function getManagevendors(){
		return Mage::registry('current_managevendors');
	}
	/**
	 * Add filter
	 * @access protected
	 * @param object $column
	 * @return Vendor_Vendors_Block_Adminhtml_Managevendors_Edit_Tab_Contact
	 * @author Ultimate Module Creator
	 */
	protected function _addColumnFilterToCollection($column){
		// Set custom filter for in product flag
		if ($column->getId() == 'in_contacts') {
			$contactIds = $this->_getSelectedContacts();
			if (empty($contactIds)) {
				$contactIds = 0;
			}
			if ($column->getFilter()->getValue()) {
				$this->getCollection()->addFieldToFilter('entity_id', array('in'=>$contactIds));
			} 
			else {
				if($contactIds) {
					$this->getCollection()->addFieldToFilter('entity_id', array('nin'=>$contactIds));
				}
			}
		} 
		else {
			parent::_addColumnFilterToCollection($column);
		}
		return $this;
	}
}?>