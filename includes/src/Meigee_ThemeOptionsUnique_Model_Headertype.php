<?php 
/**
 * Magento
 *
 * @author    Meigeeteam http://www.meaigeeteam.com <nick@meaigeeteam.com>
 * @copyright Copyright (C) 2010 - 2012 Meigeeteam
 *
 */
class Meigee_ThemeOptionsUnique_Model_Headertype
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'0', 'label'=>Mage::helper('ThemeOptionsUnique')->__('Header Type 1')),
            array('value'=>'1', 'label'=>Mage::helper('ThemeOptionsUnique')->__('Header Type 2'))
        );
    }

}