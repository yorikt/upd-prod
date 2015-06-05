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
 * Vendorrelation module install script
 *
 * @category    USAPoolDirect
 * @package     USAPoolDirect_Vendorrelation
 * @author      Ultimate Module Creator
 */
$this->startSetup();
$table = $this->getConnection()
    ->newTable($this->getTable('usapooldirect_vendorrelation/customervendorid'))
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Customervendorid ID')
    ->addColumn('customervendor_id', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'customervendor id')

    ->addColumn('status', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        ), 'Enabled')

     ->addColumn('status', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        ), 'Customervendorid Status')
    ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
            ), 'Customervendorid Modification Time')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        ), 'Customervendorid Creation Time') 
    ->setComment('Customervendorid Table');
$this->getConnection()->createTable($table);
$table = $this->getConnection()
    ->newTable($this->getTable('usapooldirect_vendorrelation/customervendorid_store'))
    ->addColumn('customervendorid_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        'primary'   => true,
        ), 'Customervendorid ID')
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Store ID')
    ->addIndex($this->getIdxName('usapooldirect_vendorrelation/customervendorid_store', array('store_id')), array('store_id'))
    ->addForeignKey($this->getFkName('usapooldirect_vendorrelation/customervendorid_store', 'customervendorid_id', 'usapooldirect_vendorrelation/customervendorid', 'entity_id'), 'customervendorid_id', $this->getTable('usapooldirect_vendorrelation/customervendorid'), 'entity_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($this->getFkName('usapooldirect_vendorrelation/customervendorid_store', 'store_id', 'core/store', 'store_id'), 'store_id', $this->getTable('core/store'), 'store_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Customervendorids To Store Linkage Table');
$this->getConnection()->createTable($table);
$this->endSetup();
