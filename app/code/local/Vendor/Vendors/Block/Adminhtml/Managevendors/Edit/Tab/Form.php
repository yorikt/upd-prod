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
 * Manage Vendors edit form tab
 *
 * @category	Vendor
 * @package		Vendor_Vendors
 * @author Ultimate Module Creator
 */
class Vendor_Vendors_Block_Adminhtml_Managevendors_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form{	
	/**
	 * prepare the form
	 * @access protected
	 * @return Vendors_Managevendors_Block_Adminhtml_Managevendors_Edit_Tab_Form
	 * @author Ultimate Module Creator
	 */
	protected function _prepareForm(){
		$form = new Varien_Data_Form();
		$form->setHtmlIdPrefix('managevendors_');
		$form->setFieldNameSuffix('managevendors');
		$this->setForm($form);
		$fieldset = $form->addFieldset('managevendors_form', array('legend'=>Mage::helper('vendors')->__('Manage Vendors')));
		
		
		/**
		 * Add renderer to line up checkboxes
		 */
		$role_reder = $fieldset->addField('myrole', 'hidden', array(
				'label' => Mage::helper('vendors')->__('Role'),
				'name'  => 'mytext',
				'maxlength' => "50"
		));
		$getrole_block = $this->getLayout()->createBlock('vendors/adminhtml_managevendors_renderer_vendorrole');		
		$role_reder->setRenderer($getrole_block);
		
		// Add Map Location Block 
		
		$location_reder = $fieldset->addField('mylocation', 'text', array(
				'label' => Mage::helper('vendors')->__('Location'),
				'name'  => 'mylocation',
				'maxlength' => "50"
		));
		$getlocation_block = $this->getLayout()->createBlock('vendors/adminhtml_managevendors_renderer_location');		
		$location_reder->setRenderer($getlocation_block);
		/**
		 * We've put render function to manage custome UI for checkboxes
		 * below fieldset array is commented. We don't require now.
		 *
		 */
		/*
		$fieldset->addField('manufacturer', 'checkboxes' , array(
				'label'     => $this->__('Role'),
				'name'      => 'manufacturer',
				'values'    => array('1'=>'Manufacturer'),
				'onclick'   => "",
				'required'  => true,
				'class' => 'validate-one-required chkmanu',
				
					
		));
		
		$fieldset->addField('supplier', 'checkboxes', array(
					
				'name'      => 'supplier',
				'values'    => array('1'=>'Distributor'),
				'onclick'   => "",
				'required'  => true,
				'class' => 'validate-one-required',
		
		));
		
		$fieldset->addField('subcontractor', 'checkboxes', array(
					
				'name'      => 'subcontractor',
				'values'    => array('1'=>'Subcontractor'),
				'onclick'   => "javascript:showhide(this);",
				'required'  => true,'class' => 'validate-one-required',
		
		));
		
		$fieldset->addField('courier', 'checkboxes', array(
					
				'name'      => 'courier',
				'values'    => array('1'=>'Courier'),
				'onclick'   => "",
				'required'  => true,'class' => 'validate-one-required',
		
		));
		*/
		
		$fieldset->addField('active', 'select', array(
			'label' => Mage::helper('vendors')->__('Status'),
			'name'  => 'active',
			'required'  => true,
			'class' => 'required-entry',
			'values'=> array(
				array(
					'value' => '0',
					'label' => Mage::helper('vendors')->__('Disabled'),
				),
				array(
					'value' => '1',
					'label' => Mage::helper('vendors')->__('Enabled'),
				),
			),
			
		));
		
		
		$getvendor_combo_block = Mage::getModel('vendors/managevendors')->getVendorDropDwondata();
		//$fieldset->setRenderer($getvendor_combo_block);
		$fieldset->addField('vendor_parent_id', 'select', array(
				'label' => Mage::helper('vendors')->__('Primary Location'),
				'name'  => 'vendor_parent_id',
				'values'=> $getvendor_combo_block
		));
		

		$fieldset->addField('vendorname', 'text', array(
			'label' => Mage::helper('vendors')->__('Vendor Name'),
			'name'  => 'vendorname',
			'required'  => true,
			'class' => 'required-entry',
			'maxlength' => "100"
		));

		$fieldset->addField('address', 'text', array(
			'label' => Mage::helper('vendors')->__('Address'),
			'name'  => 'address',
			'maxlength' => "100"
		));

		$fieldset->addField('address2', 'text', array(
			'label' => Mage::helper('vendors')->__('Address2'),
			'name'  => 'address2',
			'maxlength' => "100"
		));

		$fieldset->addField('city', 'text', array(
			'label' => Mage::helper('vendors')->__('City'),
			'name'  => 'city',
			'maxlength' => "50"
		));

		$states = Mage::getModel('directory/country')->load('US')->getRegions();
	  
		$state_list = array();
		//state names
		// $counter = 0;
		$state_list['0'] = "";
		foreach ($states as $state)
	 	{       //$counter++;
			$state_list[$state->getId()] = $state->getName();
		}
		
		$fieldset->addField('state', 'select', array(
			'label'     => $this->__('State'),
			'name'      => 'state',
			'value'     => '1',
			'values'    => $state_list,
			'disabled'  => false,
			'readonly'  => false,
			'onclick'   => "",
			'onchange'  => "getState('state')"
		));
		
		$fieldset->addField('statename', 'hidden', array(
				'label' => Mage::helper('vendors')->__('State Name'),
				'name'  => 'statename',
				'maxlength' => "20"
		
		));
		
		$fieldset->addField('zipcode', 'text', array(
			'label' => Mage::helper('vendors')->__('Zip Code'),
			'name'  => 'zipcode',
			'maxlength' => "20"

		));
		
		$fieldset->addField('latlangbtn', 'button', array(
			'label' => Mage::helper('vendors')->__(''),
			'name'  => 'latlangbtn',
			'value' => 'Click Here', 
			'onclick'=>'javascript:showAlert();',
			'class'=>'latlang form-button'

		));
	
		

		$fieldset->addField('phoneno', 'text', array(
			'label' => Mage::helper('vendors')->__('Phone #'),
			'name'  => 'phoneno',
			'maxlength' => "30"
		));
		
		/*$fieldset->addField('primary_contact', 'text', array(
				'label' => Mage::helper('vendors')->__('Primary Contact #'),
				'name'  => 'primary_contact',
				'maxlength' => "30"
		));
		
		$fieldset->addField('primary_contact_office', 'text', array(
				'label' => Mage::helper('vendors')->__('Primary Contact Office #'),
				'name'  => 'primary_contact_office',
				'maxlength' => "30"
		));
		
		$fieldset->addField('primary_contact_cell', 'text', array(
				'label' => Mage::helper('vendors')->__('Primary Contact Cell #'),
				'name'  => 'primary_contact_cell',
				'maxlength' => "30"
		));*/
		
		

		$fieldset->addField('faxno', 'text', array(
			'label' => Mage::helper('vendors')->__('Fax #'),
			'name'  => 'faxno',
			'maxlength' => "30"
		));

		$fieldset->addField('website', 'text', array(
			'label' => Mage::helper('vendors')->__('Website'),
			'name'  => 'website',
			'maxlength' => "255"
		));

		$fieldset->addField('poemail', 'text', array(
			'label' => Mage::helper('vendors')->__('PO Email'),
			'name'  => 'poemail',
			'maxlength' => "100"
		));

		$fieldset->addField('insuranceonfile', 'select', array(
			'label' => Mage::helper('vendors')->__('Insurance On File'),
			'name'  => 'insuranceonfile',
			'required'  => true,
			'class' => 'required-entry',
			'values'=> array(
				array(
					'value' => 0,
					'label' => Mage::helper('vendors')->__('No'),
				),
				array(
					'value' => 1,
					'label' => Mage::helper('vendors')->__('Yes'),
				),
				array(
					'value' => 2,
					'label' => Mage::helper('vendors')->__('N/A'),
				),
				
			),
			'onchange'  => "makerequired(this);",
		));

		
		$fieldset->addField('insuranceexpires', 'date', array(
          'label'     => Mage::helper('core')->__('Insurance Expires'),
          'tabindex' => 1,
		  'name' => 'insuranceexpires',
          'image' => $this->getSkinUrl('images/grid-cal.gif'),
          'format' => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT)
        ));

		$fieldset->addField('accountnumber', 'text', array(
			'label' => Mage::helper('vendors')->__('Account Number'),
			'name'  => 'accountnumber',
			'maxlength' => "100"
		));
		
		$fieldset->addField('terms', 'text', array(
				'label' => Mage::helper('vendors')->__('Terms'),
				'name'  => 'terms',
				'maxlength' => "50"
		));
		
		$fieldset->addField('rating', 'select', array(
			'label' => Mage::helper('vendors')->__('Rating'),
			'name'  => 'rating',
			'required'  => true,
			'class' => 'required-entry',
			'values'=> array(
				array(
					'value' => '',
					'label' => Mage::helper('vendors')->__(''),
				),
				array(
					'value' => 1,
					'label' => Mage::helper('vendors')->__('Best'),
				),
				array(
					'value' => 2,
					'label' => Mage::helper('vendors')->__('Good'),
				),
				array(
					'value' => 3,
					'label' => Mage::helper('vendors')->__('Average'),
				),
				array(
					'value' => 4,
					'label' => Mage::helper('vendors')->__('Last Resort'),
				),
				array(
					'value' => 5,
					'label' => Mage::helper('vendors')->__('Do Not Use'),
				)
				
			),
		));

		$fieldset->addField('specialty', 'text', array(
			'label' => Mage::helper('vendors')->__('Specialty'),
			'name'  => 'specialty',
			'maxlength' => "255"
		));
		
		$fieldset->addField('tripcharge', 'text', array(
			'label' => Mage::helper('vendors')->__('Trip Charge'),
			'name'  => 'tripcharge',
			'maxlength' => "20",
			'class' => 'subcontract_field', 
			'after_element_html' =>'<label for="managevendors_tripcharge">'. Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol().'</label>',
		));

		$fieldset->addField('laborratefirsthour', 'text', array(
			'label' => Mage::helper('vendors')->__('Labor Rate First Hour'),
			'name'  => 'laborratefirsthour',
			'maxlength' => "20",
			'class' => 'subcontract_field',
			'after_element_html' => '<label for="managevendors_tripcharge">'.Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol().'</label>',

		));
		$fieldset->addField('laborrateadditionalhours', 'text', array(
			'label' => Mage::helper('vendors')->__('Labor Rate Additional Hours '),
			'name'  => 'laborrateadditionalhours',
			'maxlength' => "20",
			'class' => 'subcontract_field',
			'after_element_html' => '<label for="managevendors_tripcharge">'.Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol().'</label>',

		)); 
		 
		$fieldset->addField('latitudeaddress', 'hidden', array(
			'label' => Mage::helper('vendors')->__('Latitudeaddress'),
			'name'  => 'latitudeaddress',
			'maxlength' => "120",
			'class' => 'latitudeaddress_field',
		//	'after_element_html' => '<label for="managevendors_tripcharge">LBL</label>',

		)); 
		$fieldset->addField('latitude', 'hidden', array(
			'label' => Mage::helper('vendors')->__('Latitude'),
			'name'  => 'latitude',
			'maxlength' => "120",
			'class' => 'latitude_field',
		//	'after_element_html' => '<label for="managevendors_tripcharge">LBL</label>',

		)); 
		$fieldset->addField('longitude', 'hidden', array(
			'label' => Mage::helper('vendors')->__('Longitude'),
			'name'  => 'longitude',
			'maxlength' => "120",
			'class' => 'longitude_field',
		//	'after_element_html' => '<label for="managevendors_tripcharge">LBL</label>',

		)); 
		
		
		$fieldset->addField('updateflag', 'hidden', array(
			'label' => Mage::helper('vendors')->__('updateflag'),
			'name'  => 'updateflag',
			'maxlength' => "120",
			'class' => 'updatefield_field',
			'value' => '0',
		)); 
		
		 
		
		$fieldset->addField('ajax_load', 'hidden', array(
				'label' => Mage::helper('vendors')->__('Specialty'),
				'name'  => 'ajax_load',
		));
		
		
		if (Mage::getSingleton('adminhtml/session')->getManagevendorsData()){
			$form->setValues(Mage::getSingleton('adminhtml/session')->getManagevendorsData());
			Mage::getSingleton('adminhtml/session')->setManagevendorsData(null);
		}
		elseif (Mage::registry('current_managevendors')){
			$form->setValues(Mage::registry('current_managevendors')->getData());
		}
		return parent::_prepareForm();
	}
}
?>

<script>
//function to hide the three field of subcontractor
init = function (){ 

	document.getElementById('managevendors_latlangbtn').value ="Click here to update location as per above address";


	if($('managevendors_subcontractor_1').readAttribute('checked') == 'checked')
	{
	}
	else{	
		$$('.subcontract_field').each(
			   function (e) {
				  e.toggle();
			   } 
			);
			
			$$('label').each(
				function(e){
					if(e.readAttribute('for') == "managevendors_tripcharge" ||
					   e.readAttribute('for') == "managevendors_laborratefirsthour" ||
					   e.readAttribute('for') == "managevendors_laborrateadditionalhours"
						)						
					{
						e.toggle();
					}
				}
			);
	}
	if(document.getElementById('managevendors_vendorname').value==''){
		document.getElementById('managevendors_active').value = '1';
	}
	
	document.getElementById('managevendors_ajax_load').value ='1';
	if(document.getElementById('managevendors_ajax_load').value=='1'){
		getComment();
	}

	/*new Ajax.Request('/your/url', {
		  onSuccess: function(response) {
		    // Handle the response content...
		  }
		});*/
	
}// Attach the onload function 
Event.observe(window, 'load', init, false);


//function to hide and show the three field of subcontractor
function showhide(chk_val){
	
	if(chk_val.value == '1')
	{
		$$('.subcontract_field').each(
		   function (e) {
			  e.toggle();
		   } 
		);
		
		$$('label').each(
			function(e){
				if(e.readAttribute('for') == "managevendors_tripcharge" ||
				   e.readAttribute('for') == "managevendors_laborratefirsthour" ||
				   e.readAttribute('for') == "managevendors_laborrateadditionalhours"
					)						
				{
					e.toggle();
				}
			}
		);
				
	}
}

function makerequired(iof){
	node = $("managevendors_insuranceexpires");
	if(iof.value == '1')
	{
		node.addClassName('required-entry')
	}
	else{
		node.removeClassName('required-entry')
	}
}

function getState(){
	
	document.getElementById('managevendors_statename').value = document.getElementById('managevendors_state').options[document.getElementById('managevendors_state').selectedIndex].text;
    
}

function saveContact(){
	
	if(document.getElementById('contact_firstname').value==''){
		alert('Please fill first name');
		return false;		
	}

	if(document.getElementById('contact_lastname').value==''){
		alert('Please fill last name');
		return false;		
	}

	if(document.getElementById('contact_entity_id').value==''){
		new Ajax.Request(document.getElementById('form_save_url').value, {
			method: 'post',
		    parameters: {'firstname': document.getElementById('contact_firstname').value,
		    			 'lastname': document.getElementById('contact_lastname').value,
		    			 'title': document.getElementById('contact_title').value,
		    			 'officeno': document.getElementById('contact_officeno').value,
		    			 'mobileno': document.getElementById('contact_mobileno').value,
		    			 'email': document.getElementById('contact_email').value,
		    			 'primary': document.getElementById('contact_primary').value,
		    			 'status': document.getElementById('contact_status').value,
		    			 },
		  onSuccess: function(response) {
			  refresh();
			  resetForm();
			  document.getElementById('contact_tabs_form_contact_content').style.display='none';
		  }
		});
	}else{
		new Ajax.Request(document.getElementById('form_edit_url').value, {
			method: 'post',
		    parameters: {
			    		 'entity_id':document.getElementById('contact_entity_id').value,	
			    		 'firstname': document.getElementById('contact_firstname').value,
		    			 'lastname': document.getElementById('contact_lastname').value,
		    			 'title': document.getElementById('contact_title').value,
		    			 'officeno': document.getElementById('contact_officeno').value,
		    			 'mobileno': document.getElementById('contact_mobileno').value,
		    			 'email': document.getElementById('contact_email').value,
		    			 'primary': document.getElementById('contact_primary').value,
		    			 'status': document.getElementById('contact_status').value,
		    			 },
		  onSuccess: function(response) {
			  refresh();
			  //resetForm();
			  closeContactForm();
		  }
		});
	}
}
function refresh()
{
	
	new Ajax.Request(document.getElementById('managevendors_tabs_contacts').href, 
			{onSuccess: function(response) {
			  	
			  $('contact_list').update(response.responseText);
			  //document.getElementById('contact_tabs_form_contact_content').style.display='block';
			}
	});
}
function resetForm(){
	document.getElementById('contact_firstname').value = '';
	document.getElementById('contact_lastname').value ='';
	document.getElementById('contact_title').value='';
	document.getElementById('contact_officeno').value='';
	document.getElementById('contact_mobileno').value='';
	document.getElementById('contact_email').value='';
	document.getElementById('contact_entity_id').value = '';
	document.getElementById('contact_primary').value = '1';
	document.getElementById('contact_status').value = '1';
	
}

function getContact(contact_id){
		
		new Ajax.Request(document.getElementById('form_get_url').value, {
			method: 'post',
			parameters: {'contact_id': contact_id},
			requestHeaders: {Accept: 'application/json'},
		    onSuccess: function(response) {
			 var json = response.responseText.evalJSON(true);
			 document.getElementById('contact_tabs_form_contact_content').style.display='block';
			  	document.getElementById('contact_entity_id').value = json.entity_id;
			 	document.getElementById('contact_firstname').value = json.firstname;
				document.getElementById('contact_lastname').value = json.lastname;
				document.getElementById('contact_title').value= json.title;
				document.getElementById('contact_officeno').value= json.officeno;
				document.getElementById('contact_mobileno').value= json.mobileno;
				document.getElementById('contact_email').value= json.email;
				document.getElementById('contact_primary').value = json.primary;
				document.getElementById('contact_status').value = json.status;
				//document.getElementById('contact_primary').selectedIndex = json.primary;
		  }
		});
}

function openContactForm(){
	if(document.getElementById('contact_tabs_form_contact_content').style.display == 'none')
	{
		document.getElementById('contact_tabs_form_contact_content').style.display='block';
	}
	
	if(document.getElementById('contact_entity_id').value!=''){

		var r = confirm("Do you want to add new contact?");
		if (r == true)
	  	{
			resetForm();
	  	}
	}
	/*else
	{
		document.getElementById('add_comment_form').style.display = 'none';
	}*/	
}
function closeContactForm(){
	resetForm();
	if(document.getElementById('contact_tabs_form_contact_content').style.display == 'block')
	{
		document.getElementById('contact_tabs_form_contact_content').style.display='none';
	}
	
	/*else
	{
		document.getElementById('add_comment_form').style.display = 'none';
	}*/	
}

function getComment(){
	

	
	if(document.getElementById('managevendors_tabs_comment_section').hasAttribute('href')){
		new Ajax.Request(document.getElementById('managevendors_tabs_comment_section').href, {
			method: 'post',
			onSuccess: function(response) {
			
			$('managevendors_tabs_form_managevendors_content').insert(response.responseText);
			
		  }
		});
	}
}

</script>