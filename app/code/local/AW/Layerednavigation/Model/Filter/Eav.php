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


class AW_Layerednavigation_Model_Filter_Eav extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('aw_layerednavigation/filter_eav');
    }

    /**
     * @param int $filterId
     * @param string $attributeCode
     * @param int $storeId
     *
     * @return AW_Layerednavigation_Model_Filter_Eav
     */
    public function getFilterAttributeModelByCode($filterId, $attributeCode, $storeId)
    {
        /** @var AW_Layerednavigation_Model_Resource_Filter_Eav_Collection $collection */
        $collection = $this->getCollection()
            ->addFieldToFilter('filter_id', $filterId)
            ->addFieldToFilter('store_id', $storeId)
            ->addFieldToFilter('name', $attributeCode)
            ->setPageSize(1)
            ->setCurPage(1)
        ;
        return $collection->getFirstItem();
    }
}