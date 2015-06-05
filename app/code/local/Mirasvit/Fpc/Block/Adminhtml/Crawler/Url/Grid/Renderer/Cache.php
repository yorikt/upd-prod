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


class Mirasvit_Fpc_Block_Adminhtml_Crawler_Url_Grid_Renderer_Cache
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $cache   = Mirasvit_Fpc_Model_Cache::getCacheInstance();
        $cacheId = $row->getData('cache_id');
        return ($cache->load($cacheId)) ?
            '<span class="grid-severity-notice"><span>In Cache</span></span>'
            : '<span class="grid-severity-major"><span>Pending</span></span>';
    }
}