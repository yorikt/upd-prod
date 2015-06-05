<?php
class Vendor_Vendors_Block_Adminhtml_Managevendors_Renderer_Primarycontactmob extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
	public function render(Varien_Object $row)
	{
		$vendor_id = $row->getData($this->getColumn()->getIndex());
		$tableName = Mage::getSingleton("core/resource")->getTableName('vendors_managevendors_contact');
		$tablename_vendor_cotact = Mage::getSingleton("core/resource")->getTableName('vendors_contact');
		
		$connection = Mage::getSingleton('core/resource')
		->getConnection('core_write');

		$query = "SELECT * FROM  $tableName  as ven
				  LEFT JOIN  $tablename_vendor_cotact as ven_con
				  ON ven_con.entity_id = ven.contact_id
				  WHERE ven.managevendors_id = '$vendor_id' AND ven_con.primary = '1'";
		$item_data = $connection->fetchAll($query);
		$contact_data = '';
		if(!empty($item_data)){
			$contact_data = $item_data['0']['mobileno'];
		}
		return $contact_data;		
	}
}
?>