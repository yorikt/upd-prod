<?php class Meigee_MeigeewidgetsUnique_Model_Columnsratio
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'1', 'label'=>Mage::helper('meigeewidgetsunique')->__('20/80')),
            array('value'=>'2', 'label'=>Mage::helper('meigeewidgetsunique')->__('25/75')),
            array('value'=>'3', 'label'=>Mage::helper('meigeewidgetsunique')->__('30/70')),
			array('value'=>'4', 'label'=>Mage::helper('meigeewidgetsunique')->__('35/65')),
            array('value'=>'5', 'label'=>Mage::helper('meigeewidgetsunique')->__('40/60')),
            array('value'=>'6', 'label'=>Mage::helper('meigeewidgetsunique')->__('45/55')),
			array('value'=>'7', 'label'=>Mage::helper('meigeewidgetsunique')->__('50/50'))
        );
    }

}