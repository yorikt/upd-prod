<?php 
/**
 * Magento
 *
 * @author    Meigeeteam http://www.meaigeeteam.com <nick@meaigeeteam.com>
 * @copyright Copyright (C) 2010 - 2012 Meigeeteam
 *
 */
class Meigee_ThemeOptionsUnique_Model_Prevnext
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'prevnext_disabled', 'label'=>Mage::helper('ThemeOptionsUnique')->__('Disable')),
            array('value'=>'prevnext', 'label'=>Mage::helper('ThemeOptionsUnique')->__('Enable'))          
        );
    }

}