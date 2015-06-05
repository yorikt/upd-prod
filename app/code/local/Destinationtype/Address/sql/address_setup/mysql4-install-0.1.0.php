<?php

$installer = $this;

$installer->startSetup();

$this->addAttribute('customer_address', 'destination_type', array(
	'type' => 'varchar',
	'input' => 'text',
	'label' => 'Destination Type',
	'global' => 1,
	'visible' => 1,
	'required' => 0,
	'user_defined' => 1,
	'visible_on_front' => 1
));


if (version_compare(Mage::getVersion(), '1.6.0', '<='))
{
	$customer = Mage::getModel('customer/address');
	$attrSetId = $customer->getResource()->getEntityType()->getDefaultAttributeSetId();
	$this->addAttributeToSet('customer_address', $attrSetId, 'General', 'destination_type');
}

if (version_compare(Mage::getVersion(), '1.4.2', '>='))
{
	Mage::getSingleton('eav/config')
	->getAttribute('customer_address', 'destination_type')
	->setData('used_in_forms', array('customer_register_address','customer_address_edit','adminhtml_customer_address'))
	->save();
}

$tablequote = $this->getTable('sales/quote_address');
$installer->run("
ALTER TABLE  $tablequote ADD  `destination_type` varchar(255) NOT NULL
");

$tablequote = $this->getTable('sales/order_address');
$installer->run("
ALTER TABLE  $tablequote ADD  `destination_type` varchar(255) NOT NULL
");

$installer->endSetup(); 