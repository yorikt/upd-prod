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


class Mirasvit_MstCore_Helper_Version extends Mage_Core_Helper_Abstract
{
    protected static $_edition = false;

    public static function getEdition()
    {
        if (!self::$_edition) {
            $configEE = BP."/app/code/core/Enterprise/Enterprise/etc/config.xml";
            if (!file_exists($configEE)) {
                self::$_edition = 'ce';
            } else {
                $xml = @simplexml_load_file($configEE,'SimpleXMLElement', LIBXML_NOCDATA);
                if ($xml !== false) {
                    $package = (string)$xml->default->design->package->name;
                    if ($package == 'enterprise') {
                        self::$_edition = 'ee';
                    } else {
                        self::$_edition = 'pe';
                    }
                } else {
                    self::$_edition = 'unknown';
                }
            }
        }
        return self::$_edition;
    }
}