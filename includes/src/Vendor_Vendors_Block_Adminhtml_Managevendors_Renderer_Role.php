<?php
class Vendor_Vendors_Block_Adminhtml_Managevendors_Renderer_Role extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
	public function render(Varien_Object $row)
	{
		$value = array();
		if($row->getData('manufacturer')){
			$value[] .= 'Manufacturer';
		}
		if($row->getData('supplier')){
			$value[] .= 'Supplier';
		}
		if($row->getData('subcontractor')){
			$value[] .= 'Subcontractor';
		}
		if($row->getData('courier')){
			$value[] .= 'Courier';
		}
		
		$final_value =implode('<br/>',$value);
		return $final_value;		
	}
}
?>