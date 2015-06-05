<?php
class USAPoolDirect_Purchaseorder_Block_Adminhtml_Purchaseorder_Renderer_State extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
	public function render(Varien_Object $row)
	{
		
		$regionId = $row->getData($this->getColumn()->getIndex());
		$region = Mage::getModel('directory/region')->load($regionId);
		
		return $region->getName();		
	}
}
?>