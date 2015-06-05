<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE_AFL.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    design
 * @package     default_default
 * @copyright   Copyright (c) 2013 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */
class Vendor_Vendors_Block_Adminhtml_Managevendors_Contactlist extends Mage_Adminhtml_Block_Template{}
$paramId  =  Mage::registry('paramId');
$form_save_url  =  Mage::registry('form_save_url');
$form_edit_url  =  Mage::registry('form_edit_url');
$form_get_url = Mage::registry('form_get_url');




$tableName = Mage::getSingleton("core/resource")->getTableName('vendors_managevendors_contact');
$tablename_vendor_cotact = Mage::getSingleton("core/resource")->getTableName('vendors_contact');

$connection = Mage::getSingleton('core/resource')
->getConnection('core_write');

$query = "SELECT * FROM  $tableName  as ven
		  LEFT JOIN  $tablename_vendor_cotact as ven_con
		  ON ven_con.entity_id = ven.contact_id
		  WHERE ven.managevendors_id = '$paramId'";
$contact_data = $connection->fetchAll($query);
//echo "<pre>";print_r($item_data);exit;

ob_start("callback");

?>

<div id="contact_list">
	<button id="" title="Reset" type="button" class="scalable " onclick="openContactForm();" style="float: right;margin-right:5px;">
	<span><span><span>Add Contact</span></span></span>
	</button>
	<div style="clear: both; height:6px">&nbsp;</div>
	<div id="contact_tabs_form_contact_content" style="display: none;" >
		
		<div class="entry-edit">
			<div class="entry-edit-head">
				<h4 class="icon-head head-edit-form fieldset-legend">Contact</h4>
				<div class="form-buttons"></div>
			</div>
			<div id="contact_contact_form" class="fieldset ">
				<div class="hor-scroll">
					<table cellspacing="0" class="form-list">
						<tbody>
							<tr>
								<td class="label"><label for="contact_firstname">First Name <span
										class="required">*</span>
								</label></td>
								<td class="value"><input type="text"
									class="required-entry input-text required-entry" value=""
									name="firstname" id="contact_firstname">
								</td>
							</tr>
							<tr>
								<td class="label"><label for="contact_lastname">Last Name <span
										class="required">*</span>
								</label></td>
								<td class="value"><input type="text"
									class="required-entry input-text required-entry" value=""
									name="lastname" id="contact_lastname">
								</td>
							</tr>
							<tr>
								<td class="label"><label for="contact_title">Title</label></td>
								<td class="value"><input type="text" class=" input-text"
									value="" name="title" id="contact_title">
								</td>
							</tr>
							<tr>
								<td class="label"><label for="contact_officeno">Office #</label>
								</td>
								<td class="value"><input type="text" class=" input-text"
									value="" name="officeno"
									id="contact_officeno">
								</td>
							</tr>
							<tr>
								<td class="label"><label for="contact_mobileno">Mobile #</label>
								</td>
								<td class="value"><input type="text" class=" input-text"
									value="" name="mobileno"
									id="contact_mobileno">
								</td>
							</tr>
							<tr>
								<td class="label"><label for="contact_email">Email</label></td>
								<td class="value"><input type="text" class=" input-text"
									value="" name="email" id="contact_email">
								</td>
							</tr>
							<tr>
								<td class="label"><label for="contact_primary">Primary <span
										class="required">*</span>
								</label></td>
								<td class="value"><select
									class="required-entry required-entry select"
									name="primary" id="contact_primary">
										<option selected="selected" value="1">Yes</option>
										<option value="0">No</option>
								</select>
								</td>
							</tr>
							<tr>
								<td class="label"><label for="contact_status">Status</label></td>
								<td class="value"><select class=" select" name="status"
									id="contact_status">
										<option selected="selected" value="1">Enabled</option>
										<option value="0">Disabled</option>
								</select>
								</td>
							</tr>
							<tr>
								<td class="label"></td>
								<td class="value">
									<input type="hidden" name="contact_entity_id" id="contact_entity_id" value="">
									<input type="hidden" id="form_save_url" value="<?php echo $form_save_url;?>">
									<input type="hidden" id="form_edit_url" value="<?php echo $form_edit_url;?>">
									<input type="hidden" id="form_get_url" value="<?php echo $form_get_url;?>">
									<button style="" onclick="saveContact();" class="scalable save" type="button" title="Save Contact" id="">
										<span><span><span>Save Contact</span></span></span>
									</button>
									<button id="" title="Reset" type="button" class="scalable " onclick="closeContactForm();" style="margin-left: 20px;">
									<span><span><span>Cancel</span></span></span>
									</button>			
								</td>
							</tr>
							
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	
	<div style="" id="managevendors_tabs_contacts_content">
		<div class="entry-edit-head">
			<h4 class="icon-head head-edit-form fieldset-legend">Contact List</h4>
			<div class="form-buttons"></div>
		</div>
		<div id="contact_grid">
			<div class="grid">
				<div class="hor-scroll">
					<table cellspacing="0" id="contact_grid_table" class="data">
						
						<thead>
							<tr class="headings">
								
								<th><span class="nobr"><span>First Name</span></span></th>
								<th><span class="nobr"><span>Last Name</span></span></th>
								<th><span class="nobr"><span>Title</span></span></th>
								<th><span class="nobr"><span>Office #</span></span></th>
								<th><span class="nobr"><span>Mobile #</span></span></th>
								<th><span class="nobr"><span>Email</span></span></th>
								<th><span class="nobr"><span>Primary</span></span></th>
								<th><span class="nobr"><span>Status</span></span></th>
								<th style="text-align: center;"><span class="nobr"><span>Action</span></span></th>
							</tr>
							
						</thead>
						<tbody>
							<?php if(!empty($contact_data)){
								foreach($contact_data as $contact_val){
							?>
								<tr title="#" onclick="getContact('<?php echo $contact_val['entity_id'];?>')" <?php echo ($contact_val['primary']=='1')?'style="background-color: #E7EFEF;cursor: pointer;"':'style="cursor: pointer;"' ?>>
									
									<td class="a-left "><?php echo $contact_val['firstname'];?></td>
									<td class="a-left "><?php echo $contact_val['lastname'];?></td>
									<td class="a-left "><?php echo $contact_val['title'];?></td>
									<td class="a-left "><?php echo $contact_val['officeno'];?></td>
									<td class="a-left "><?php echo $contact_val['mobileno'];?></td>
									<td class="a-left "><?php echo $contact_val['email'];?></td>
									<td class="a-left "><?php echo ($contact_val['primary']=='0')?'No':'Yes';?></td>
									<td class="a-left"><?php echo ($contact_val['status']=='0')?'Disabled':'Enabled';?></td>
									<td class="a-left last ajax" style="text-align:center !important;"><a href="javascript:void(0);"  onclick="getContact('<?php echo $contact_val['entity_id'];?>')">Edit</a></td>
								</tr>
							<?php }}?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	
	
	
	</div>
</div>
<?php 
ob_end_flush();
?>