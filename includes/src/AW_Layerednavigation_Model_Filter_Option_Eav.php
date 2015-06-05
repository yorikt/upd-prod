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


class AW_Layerednavigation_Model_Filter_Option_Eav extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('aw_layerednavigation/filter_option_eav');
    }

    /**
     * @param int $optionId
     * @param string $attributeCode
     * @param int $storeId
     *
     * @return AW_Layerednavigation_Model_Filter_Option_Eav
     */
    public function getFilterAttributeModelByCode($optionId, $attributeCode, $storeId)
    {
        $collection = $this->getCollection()
            ->addFieldToFilter('option_id', $optionId)
            ->addFieldToFilter('store_id', $storeId)
            ->addFieldToFilter('name', $attributeCode)
            ->setPageSize(1)
            ->setCurPage(1)
        ;
        return $collection->getFirstItem();
    }
}