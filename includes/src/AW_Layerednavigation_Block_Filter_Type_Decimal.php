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


class AW_Layerednavigation_Block_Filter_Type_Decimal extends AW_Layerednavigation_Block_Filter_Type_Abstract
{
    /**
     * @return int
     */
    public function getMinimumValue()
    {
        $value = $this->getFilter()->getCount();
        if (array_key_exists('min', $value) && isset($value['min'])) {
            return floor($value['min']);
        }
        return 0;
    }

    /**
     * @return int
     */
    public function getMaximumValue()
    {
        $value = $this->getFilter()->getCount();
        if (array_key_exists('max', $value) && isset($value['max'])) {
            return ceil($value['max']);
        }
        return 0;
    }

    /**
     * @return int
     */
    public function getMinimumAppliedValue()
    {
        $currentValue = $this->getFilter()->getCurrentValue();
        if (array_key_exists('from', $currentValue) && isset($currentValue['from'])) {
            return floor($currentValue['from']);
        }
        return $this->getMinimumValue();
    }

    /**
     * @return int
     */
    public function getMaximumAppliedValue()
    {
        $currentValue = $this->getFilter()->getCurrentValue();
        if (array_key_exists('to', $currentValue) && isset($currentValue['to'])) {
            return ceil($currentValue['to']);
        }
        return $this->getMaximumValue();
    }

    /**
     * @return string
     */
    public function getMinimumValuePrefix()
    {
        return '';
    }

    /**
     * @return string
     */
    public function getMaximumValuePrefix()
    {
        return '';
    }


    /**
     * @return string
     */
    protected function _getTemplate()
    {
        switch($this->getFilter()->getDisplayType()) {
            case AW_Layerednavigation_Model_Source_Filter_Display_Type::CHECKBOX_CODE:
                return 'aw_layerednavigation/filter/checkbox.phtml';
                break;
            case AW_Layerednavigation_Model_Source_Filter_Display_Type::RADIO_CODE:
                return 'aw_layerednavigation/filter/radiogroup.phtml';
                break;
            case AW_Layerednavigation_Model_Source_Filter_Display_Type::RANGE_CODE:
                return 'aw_layerednavigation/filter/range.phtml';
                break;
            case AW_Layerednavigation_Model_Source_Filter_Display_Type::FROM_TO_CODE:
                return 'aw_layerednavigation/filter/fromto.phtml';
                break;
            default:
                return '';
        }
    }
}
