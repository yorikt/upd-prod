<?php
/**
 * aheadWorks Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://ecommerce.aheadworks.com/AW-LICENSE.txt
 *
 * =================================================================
 *                 MAGENTO EDITION USAGE NOTICE
 * =================================================================
 * This software is designed to work with Magento community edition and
 * its use on an edition other than specified is prohibited. aheadWorks does not
 * provide extension support in case of incorrect edition use.
 * =================================================================
 *
 * @category   AW
 * @package    AW_Layerednavigation
 * @version    1.1.1
 * @copyright  Copyright (c) 2010-2012 aheadWorks Co. (http://www.aheadworks.com)
 * @license    http://ecommerce.aheadworks.com/AW-LICENSE.txt
 */


class AW_Layerednavigation_Model_Resource_Indexer_Filter extends Mage_Index_Model_Mysql4_Abstract
{
    protected $_types;

    protected function _construct()
    {

    }

    public function catalogProductSave(Mage_Index_Model_Event $event)
    {
        /* @var $product Mage_Catalog_Model_Product */
        $product    = $event->getDataObject();
        $attributes = $product->getAttributes();
        foreach ($attributes as $attribute) {
            $attributeCode = $attribute->getAttributeCode();
            if ($product->dataHasChangedFor($attributeCode)) {
                foreach ($this->getIndexers() as $indexer) {
                    $indexer->reindexAttribute($attribute, array($product->getId()));
                }
            }
        }
        return $this;
    }

    public function catalogProductMassAction(Mage_Index_Model_Event $event)
    {
        /* @var $actionObject Varien_Object */
        $actionObject = $event->getDataObject();
		if(is_object($actionObject)){
        $productIds = $actionObject->getProductIds();
        if (is_array($productIds)) {
            foreach ($this->getIndexers() as $indexer) {
                $indexer->reindexAttribute(null, $productIds);
            }
        }
		} // added by ankit
        return $this;
    }

    public function catalogProductDelete(Mage_Index_Model_Event $event)
    {
        /* @var $product Mage_Catalog_Model_Product */
        $data = $event->getNewData();
        if (empty($data['delete_product_id'])) {
            return $this;
        }
        foreach ($this->getIndexers() as $indexer) {
            $indexer->deleteProduct($data['delete_product_id']);
        }
        return $this;
    }

    public function getIndexers()
    {
        if (is_null($this->_types)) {
            $this->_types   = array(
                'category'     => Mage::getResourceModel('aw_layerednavigation/indexer_type_category'),
                'decimal'      => Mage::getResourceModel('aw_layerednavigation/indexer_type_decimalAttribute'),
                'option'       => Mage::getResourceModel('aw_layerednavigation/indexer_type_optionAttribute'),
                'option_yesno' => Mage::getResourceModel('aw_layerednavigation/indexer_type_yesnoAttribute'),
            );
        }
        return $this->_types;
    }

    public function getIndexer($type)
    {
        $indexers = $this->getIndexers();
        if (!isset($indexers[$type])) {
            Mage::throwException(
                Mage::helper('aw_layerednavigation')->__('Unknown Layered Navigation indexer type "%s".', $type)
            );
        }
        return $indexers[$type];
    }

    public function reindexAll()
    {
        foreach ($this->getIndexers() as $indexer) {
            $indexer->reindexAll();
        }
        return $this;
    }
}
