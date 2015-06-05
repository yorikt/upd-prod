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


class AW_Layerednavigation_Block_Adminhtml_Filter_Edit_Tab_General_Abstract_Js extends Mage_Adminhtml_Block_Template
{
    public function isDefaultStore()
    {
        $storeId = (int)$this->getRequest()->getParam('store', Mage_Catalog_Model_Abstract::DEFAULT_STORE_ID);
        return $storeId === Mage_Catalog_Model_Abstract::DEFAULT_STORE_ID;
    }

    public function isCategoryFilter()
    {
        $filter = Mage::registry('current_filter');
        if (!$filter) {
            return false;
        }
        return $filter->getType() == AW_Layerednavigation_Model_Source_Filter_Type::CATEGORY_CODE;
    }
}