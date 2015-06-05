<?php
/**
 * USAPoolDirect_Vendorrelation extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       USAPoolDirect
 * @package        USAPoolDirect_Vendorrelation
 * @copyright      Copyright (c) 2014
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Customervendorid model
 *
 * @category    USAPoolDirect
 * @package     USAPoolDirect_Vendorrelation
 * @author      Ultimate Module Creator
 */
class USAPoolDirect_Vendorrelation_Model_Customervendorid
    extends Mage_Core_Model_Abstract {
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'usapooldirect_vendorrelation_customervendorid';
    const CACHE_TAG = 'usapooldirect_vendorrelation_customervendorid';
    /**
     * Prefix of model events names
     * @var string
     */
    protected $_eventPrefix = 'usapooldirect_vendorrelation_customervendorid';

    /**
     * Parameter name in event
     * @var string
     */
    protected $_eventObject = 'customervendorid';
    /**
     * constructor
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function _construct(){
        parent::_construct();
        $this->_init('usapooldirect_vendorrelation/customervendorid');
    }
    /**
     * before save customervendorid
     * @access protected
     * @return USAPoolDirect_Vendorrelation_Model_Customervendorid
     * @author Ultimate Module Creator
     */
    protected function _beforeSave(){
        parent::_beforeSave();
        $now = Mage::getSingleton('core/date')->gmtDate();
        if ($this->isObjectNew()){
            $this->setCreatedAt($now);
        }
        $this->setUpdatedAt($now);
        return $this;
    }
    /**
     * save customervendorid relation
     * @access public
     * @return USAPoolDirect_Vendorrelation_Model_Customervendorid
     * @author Ultimate Module Creator
     */
    protected function _afterSave() {
        return parent::_afterSave();
    }
    
    
    /**
     * get default values
     * @access public
     * @return array
     * @author Ultimate Module Creator
     */
    public function getDefaultValues() {
        $values = array();
        $values['status'] = 1;
        return $values;
    }
}
