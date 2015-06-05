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


class AW_Layerednavigation_Model_Resource_Indexer_Type_OptionAttribute
    extends AW_Layerednavigation_Model_Resource_Indexer_Type_Abstract
{
    protected function _construct()
    {
        $this->_init('aw_layerednavigation/filter_index_option', 'entity_id');
    }

    protected function _validateAttribute($attribute)
    {
        if (in_array($attribute->getFrontendInput(),
            array(
                AW_Layerednavigation_Model_Synchronization_Option_Attribute::ATTRIBUTE_TYPE_SELECT,
                AW_Layerednavigation_Model_Synchronization_Option_Attribute::ATTRIBUTE_TYPE_MULTISELECT
            )
        )) {
            return true;
        }
        return false;
    }

    protected function _getAttributeCode()
    {
        return AW_Layerednavigation_Model_Source_Filter_Type::OPTION_ATTRIBUTE_CODE;
    }
}