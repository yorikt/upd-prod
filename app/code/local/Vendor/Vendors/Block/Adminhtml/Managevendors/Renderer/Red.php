<?php
class Vendor_Vendors_Block_Adminhtml_Managevendors_Renderer_Red extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
	public function render(Varien_Object $row)
	{
		
		if($row->getData($this->getColumn()->getIndex()) == '1') 	{	$label = 'Yes';	}
		elseif($row->getData($this->getColumn()->getIndex()) == '2'){	$label = 'N/A';	}
		else														{	$label = 'No';	}

		$curr_date = date("m/d/Y", Mage::getModel('core/date')->timestamp(time()));
		
		$curr_date = strtotime(date("Y-m-d"));
		$insu_date = strtotime(date("Y-m-d", strtotime($row->getData('insuranceexpires'))));

		if($insu_date < $curr_date && $row->getData('insuranceonfile') == '1')	
		{
			$date_insurance = $row->getData('insuranceexpires');
			$value =  '<span style="color:red;">'.$label.'</span>';
			
		}
		else {
			$value = $label;
			}
		return $value;		
	}
}
?>