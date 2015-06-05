<?php
/**
 * Mirasvit
 *
 * This source file is subject to the Mirasvit Software License, which is available at http://mirasvit.com/license/.
 * Do not edit or add to this file if you wish to upgrade the to newer versions in the future.
 * If you wish to customize this module for your needs
 * Please refer to http://www.magentocommerce.com for more information.
 *
 * @category  Mirasvit
 * @package   Full Page Cache
 * @version   1.0.1
 * @revision  187
 * @copyright Copyright (C) 2014 Mirasvit (http://mirasvit.com/)
 */


class Mirasvit_Fpc_Model_Resource_Crawler_Url extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('fpc/crawler_url', 'url_id');
    }

    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        if ($object->isObjectNew() && !$object->hasCreatedAt()) {
            $object->setCreatedAt(Mage::getSingleton('core/date')->gmtDate());
        }

        $object->setUpdatedAt(Mage::getSingleton('core/date')->gmtDate());


        return parent::_beforeSave($object);
    }

    protected function _afterLoad(Mage_Core_Model_Abstract $object)
    {
        return parent::_afterLoad($object);
    }

    protected function _afterSave(Mage_Core_Model_Abstract $object)
    {
        return parent::_afterSave($object);
    }
}
