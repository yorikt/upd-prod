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


class Mirasvit_Fpc_Model_Observer extends Varien_Debug
{
    //1 - only primary tags
    //2 - all tags
    protected $_cacheTagsLevel = 1;

    protected $_registerModelTagCalls = 0;

    public function __construct()
    {
        $this->_processor = Mage::getSingleton('fpc/processor');
        $this->_config    = Mage::getSingleton('fpc/config');
        $this->_isEnabled = Mage::app()->useCache('fpc');
    }


    protected function _getCookie()
    {
        return Mage::getSingleton('fpc/cookie');
    }

    public function isAllowed()
    {
        return $this->_isEnabled;
    }

    /**
     * Clean full page cache
     */
    public function cleanCache($observer)
    {
        if ($observer->getEvent()->getType() == 'fpc') {
            Mirasvit_Fpc_Model_Cache::getCacheInstance()->clean(Mirasvit_Fpc_Model_Processor::CACHE_TAG);
        }

        return $this;
    }

    public function flushCache($observer)
    {
        try {
            $allTypes = Mage::app()->useCache();
            foreach($allTypes as $type => $blah) {
              Mage::app()->getCacheInstance()->cleanType($type);
            }
        } catch (Exception $e) {}
    }

    /**
     * Invalidate full page cache
     */
    public function invalidateCache()
    {
        Mage::getSingleton('adminhtml/session')->addNotice(Mage::helper('fpc')->__('Refresh "Full Page Cache" to apply changes at frontend'));

        return $this;
    }


    public function registerModelTag($observer)
    {
        if (!$this->isAllowed()) {
            return $this;
        }

        if ($this->_cacheTagsLevel == 1 && $this->_registerModelTagCalls > 0) {
            return $this;
        }

        $object = $observer->getEvent()->getObject();
        if ($object && $object->getId()) {
            $tags = $object->getCacheIdTags();
            if ($tags) {
                if ($this->_cacheTagsLevel == 1) {
                    if (count($tags) > 0) {
                        $tags = array($tags[0]);
                    }
                }
                $this->_processor->addRequestTag($tags);
                $this->_registerModelTagCalls++;
            }
        }

        return $this;
    }

    public function registerProductTags($observer)
    {
        if (!$this->isAllowed() || $this->_cacheTagsLevel == 1) {
            return $this;
        }

        $object = $observer->getEvent()->getProduct();
        if ($object && $object->getId()) {
            $tags = $object->getCacheIdTags();
            if ($tags) {
                $this->_processor->addRequestTag($tags);
            }
        }
    }

    public function registerCollectionTag($observer)
    {
        if (!$this->isAllowed() || $this->_cacheTagsLevel == 1) {
            return $this;
        }

        $collection = $observer->getEvent()->getCollection();
        if ($collection) {
            foreach ($collection as $object) {
                $tags = $object->getCacheIdTags();
                if ($tags) {
                    $this->_processor->addRequestTag($tags);
                }
            }
        }

        return $this;
    }

    public function validateDataChanges(Varien_Event_Observer $observer)
    {
        $object = $observer->getEvent()->getObject();
        $object = Mage::getModel('fpc/validator')->checkDataChange($object);
    }

    public function validateDataDelete(Varien_Event_Observer $observer)
    {
        $object = $observer->getEvent()->getObject();
        $object = Mage::getModel('fpc/validator')->checkDataDelete($object);
    }

    public function onStockItemSaveAfter(Varien_Event_Observer $observer)
    {
        if ($observer->getDataObject() && $observer->getDataObject()->getProductId()) {
            $productId = $observer->getDataObject()->getProductId();
            Mirasvit_Fpc_Model_Cache::getCacheInstance()->clean('CATALOG_PRODUCT_'.$productId);
        }
    }
}