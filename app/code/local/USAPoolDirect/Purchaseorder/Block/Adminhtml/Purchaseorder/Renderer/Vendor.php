<?php
class USAPoolDirect_Purchaseorder_Block_Adminhtml_Purchaseorder_Renderer_Vendor extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
	public function render(Varien_Object $row)
	{
		
		$vendor_id = $row->getData($this->getColumn()->getIndex());
		$tableName = Mage::getSingleton("core/resource")->getTableName('vendors_managevendors');
		
		
		$connection = Mage::getSingleton('core/resource')
		->getConnection('core_write');
		
		$query = "SELECT * FROM  $tableName  as ven
		WHERE ven.entity_id = '$vendor_id'";
		$vendor_data = $connection->fetchAll($query);
		
		$vendorname = '';
		if(!empty($vendor_data)){
			$vendorname = $vendor_data['0']['vendorname'];
		}
		
		
		return $vendorname;		
	}
}
?>