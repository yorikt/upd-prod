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


class Mirasvit_MstCore_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $mstdir = Mage::getBaseDir('app').DS.'code'.DS.'local'.DS.'Mirasvit';

        if ($handle = opendir($mstdir)) {
            while (false !== ($entry = readdir($handle))) {
                if (substr($entry, 0, 1) != '.') {
                    echo strtoupper(substr($entry, 0, 3)).'/';
                }
            }
            closedir($handle);
        }
    }
}
