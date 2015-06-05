<?php
/**
 * USAPoolDirect_Producttype extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category   	USAPoolDirect
 * @package		USAPoolDirect_Producttype
 * @copyright  	Copyright (c) 2014
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * ProductTypes tab on product edit form
 *
 * @category	USAPoolDirect
 * @package		USAPoolDirect_Producttype
 * @author Ultimate Module Creator
 */
class USAPoolDirect_Producttype_Block_Adminhtml_Catalog_Product_Edit_Tab_Producttype extends Mage_Adminhtml_Block_Widget_Grid{
	/**
	 * Set grid params
	 * @access protected
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function __construct(){
		parent::__construct();
		$this->setPagerVisibility(false);
		$this->setFilterVisibility(false);
		$this->setId('producttype_grid');
		$this->setDefaultSort('position');
		$this->setDefaultDir('ASC');
		$this->setUseAjax(true);
		/*if ($this->getProduct()->getId()) {
			$this->setDefaultFilter(array('in_producttypes'=>1));
		}*/
	}
	/**
	 * prepare the producttype collection
	 * @access protected 
	 * @return USAPoolDirect_Producttype_Block_Adminhtml_Catalog_Product_Edit_Tab_Producttype
	 * @author Ultimate Module Creator
	 */
	protected function _prepareCollection() {
		$collection = Mage::getResourceModel('producttype/producttype_collection');
		if ($this->getProduct()->getId()){
			$constraint = 'related.product_id='.$this->getProduct()->getId();
			}
			else{
				$constraint = 'related.product_id=0';
			}
		$collection->getSelect()->joinLeft(
			array('related'=>$collection->getTable('producttype/producttype_product')),
			'related.producttype_id=main_table.entity_id AND '.$constraint,
			array('position')
		);
		$this->setCollection($collection);
		parent::_prepareCollection();
		return $this;
	}
	/**
	 * prepare mass action grid
	 * @access protected
	 * @return USAPoolDirect_Producttype_Block_Adminhtml_Catalog_Product_Edit_Tab_Producttype
	 * @author Ultimate Module Creator
	 */ 
	protected function _prepareMassaction(){
		return $this;
	}
	/**
	 * prepare the grid columns
	 * @access protected
	 * @return USAPoolDirect_Producttype_Block_Adminhtml_Catalog_Product_Edit_Tab_Producttype
	 * @author Ultimate Module Creator
	 */
	protected function _prepareColumns(){
		$this->addColumn('in_producttypes', array(
			'header_css_class'  => 'a-center',
			'type'  => 'radio',
			'html_name'  => 'in_producttypes[]',
			'value'    => array('3'),
			'class'             => 'required-entry',
			'values'=> $this->_getSelectedProducttypes(),
			'align' => 'center',
			'index' => 'entity_id',
				'filter'    => false,
				'sortable'  => false
		));
		$this->addColumn('product_type', array(
			'header'=> Mage::helper('producttype')->__('Product Type'),
			'align' => 'left',
			'index' => 'product_type',
		));
		/*$this->addColumn('position', array(
			'header'		=> Mage::helper('producttype')->__('Position'),
			'name'  		=> 'position',
			'width' 		=> 60,
			'type'		=> 'hidden',
			'validate_class'=> 'validate-number',
			'index' 		=> 'position',
			'editable'  	=> false,
		));*/
	}
	/**
	 * Retrieve selected producttypes
	 * @access protected
	 * @return array
	 * @author Ultimate Module Creator
	 */
	protected function _getSelectedProducttypes(){
		$producttypes = $this->getProductProducttypes();
		if (!is_array($producttypes)) {
			$producttypes = array_keys($this->getSelectedProducttypes());
		}
		return $producttypes;
	}
 	/**
	 * Retrieve selected producttypes
	 * @access protected
	 * @return array
	 * @author Ultimate Module Creator
	 */
	public function getSelectedProducttypes() {
		$producttypes = array();
		//used helper here in order not to override the product model
		$selected = Mage::helper('producttype/product')->getSelectedProducttypes(Mage::registry('current_product'));
		if (!is_array($selected)){
			$selected = array();
		}
		foreach ($selected as $producttype) {
			$producttypes[$producttype->getId()] = array('position' => $producttype->getPosition());
		}
		
		if(empty($producttypes)){
			$producttypes = array('3'=>array('position'=>'0'));
		}else{
			$producttypes = $producttypes;
		}
		
		return $producttypes;
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
		return $this->getUrl('*/*/producttypesGrid', array(
			'id'=>$this->getProduct()->getId()
		));
	}
	/**
	 * get the current product
	 * @access public
	 * @return Mage_Catalog_Model_Product
	 * @author Ultimate Module Creator
	 */
	public function getProduct(){
		return Mage::registry('current_product');
	}
	/**
	 * Add filter
	 * @access protected
	 * @param object $column
	 * @return USAPoolDirect_Producttype_Block_Adminhtml_Catalog_Product_Edit_Tab_Producttype
	 * @author Ultimate Module Creator
	 */
	protected function _addColumnFilterToCollection($column){
	/*	if ($column->getId() == 'in_producttypes') {
			$producttypeIds = $this->_getSelectedProducttypes();
			if (empty($producttypeIds)) {
				$producttypeIds = 0;
			}
			if ($column->getFilter()->getValue()) {
				$this->getCollection()->addFieldToFilter('entity_id', array('in'=>$producttypeIds));
			} 
			else {
				if($producttypeIds) {
					$this->getCollection()->addFieldToFilter('entity_id', array('nin'=>$producttypeIds));
				}
			}
		} 
		else {
			parent::_addColumnFilterToCollection($column);
		}
		return $this;*/
	}
}