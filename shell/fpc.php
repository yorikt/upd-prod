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


require_once 'abstract.php';

class Mirasvit_Shell_Fpc extends Mage_Shell_Abstract
{
    public function run()
    {
        if ($this->getArg('crawl')) {
            $crawler = Mage::getModel('fpc/crawler_crawl');
            $crawler->run(true);
        } else if ($this->getArg('crawler-status')) {
            echo Mage::helper('fpc')->getVariable('status').PHP_EOL;
        } else if ($this->getArg('update-log')) {
            $log = Mage::getSingleton('fpc/log');
            $log->importFileLog();
            $log->getResource()->aggregate();
        } else if ($this->getArg('clear-old')) {
            Mage::getSingleton('fpc/cache')->cleanOld();
        } else {
            echo $this->usageHelp();
        }
    }

    public function _validate()
    {
    }

    public function usageHelp()
    {
        return <<<USAGE
Usage:  php -f fpc.php -- [options]

  crawl             Run crawler for all allowed stores
  status            Show crawler status
  update-log        Update log data (import urls to crawler, update chart data)
  clear-old         Clear old cache
  help              This help

USAGE;
    }
}

$shell = new Mirasvit_Shell_Fpc();
$shell->run();
