<?php 

class Vendor_Vendors_Block_Adminhtml_Managevendors_Renderer_Vendorrole
extends Mage_Adminhtml_Block_Abstract
implements Varien_Data_Form_Element_Renderer_Interface
{
	public function render(Varien_Data_Form_Element_Abstract $element)
	{
		
		$paramid =  $this->getRequest()->getParam('id');
		$collection = Mage::getModel('vendors/managevendors')
		->getCollection()
		->addFieldToFilter('entity_id',$paramid);
		
		foreach($collection as $data){
			$selected_manufacturer = ($data->getManufacturer()==1?'checked="checked"':'');
			$selected_supplier = ($data->getSupplier()==1?'checked="checked"':'');
			$selected_subcontractor = ($data->getSubcontractor()==1?'checked="checked"':'');
			$selected_courier = ($data->getCourier()==1?'checked="checked"':'');
		}
		
		
		
		$html .= '<tr>';
		$html .= '<td class="label"><label for="managevendors_active">Role <span class="required">*</span></label></td>';
		$html .= '<td class="value"  style="width:400px;">';
		$html .= '<input type="checkbox" value="1" '.$selected_manufacturer.' name="managevendors[manufacturer]" id="managevendors_manufacturer_1"> <label style="padding-right:20px;"  for="managevendors_manufacturer_1">Manufacturer</label>';
		$html .= '<input type="checkbox" value="1" '.$selected_supplier.' name="managevendors[supplier]" id="managevendors_supplier_1"> <label style="padding-right:20px;"  for="managevendors_supplier_1">Distributor</label>';
		$html .= '<input type="checkbox" value="1" '.$selected_subcontractor.' onclick="javascript:showhide(this);" name="managevendors[subcontractor]" id="managevendors_subcontractor_1"> <label style="padding-right:20px;"  for="managevendors_subcontractor_1">Subcontractor</label>';
		$html .= '<input type="checkbox" value="1" '.$selected_courier.' name="managevendors[courier]" id="managevendors_courier_1"> <label for="managevendors_courier_1">Courier</label>';
		$html .= '</td>';
		$html .= '</tr>';

		return $html;
	}
	
}
?>