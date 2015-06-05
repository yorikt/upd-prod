<?php 
/**
 * Magento
 *
 * @author    Meigeeteam http://www.meaigeeteam.com <nick@meaigeeteam.com>
 * @copyright Copyright (C) 2010 - 2012 Meigeeteam
 *
 */
class Meigee_ThemeOptionsUnique_Model_Related
{
    public function toOptionArray()
    {
        return array(  
            array('value'=>'related', 'label'=>Mage::helper('ThemeOptionsUnique')->__('Simple List')),
            array('value'=>'related_slider', 'label'=>Mage::helper('ThemeOptionsUnique')->__('Slider'))     
        );
    }

}