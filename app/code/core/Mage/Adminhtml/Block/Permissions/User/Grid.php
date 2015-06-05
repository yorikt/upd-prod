<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright   Copyright (c) 2013 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Adminhtml permissions user grid
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Adminhtml_Block_Permissions_User_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('permissionsUserGrid');
        $this->setDefaultSort('username');
        $this->setDefaultDir('asc');
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('admin/user_collection');
		$prefix = Mage::getConfig()->getTablePrefix();
		
		$collection->getSelect()
        ->joinLeft(array('t2' => $prefix.'admin_role'),'main_table.user_id = t2.user_id','t2.role_id')
        ->joinLeft(array('t3' => $prefix.'admin_role'),'t2.parent_id= t3.role_id','IF (t3.role_name IS NULL, \'None\', t3.role_name) AS role_name');

		       
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('user_id', array(
            'header'    => Mage::helper('adminhtml')->__('ID'),
            'width'     => 5,
            'align'     => 'right',
            'sortable'  => true,
            'index'     => 'user_id'
        ));
        
        $this->addColumn('firstname', array(
            'header'    => Mage::helper('adminhtml')->__('First Name'),
            'index'     => 'firstname'
        ));

        $this->addColumn('lastname', array(
            'header'    => Mage::helper('adminhtml')->__('Last Name'),
            'index'     => 'lastname'
        ));
        
        $this->addColumn('username', array(
        		'header'    => Mage::helper('adminhtml')->__('User Name'),
        		'index'     => 'username'
        ));
        
        $this->addColumn('email', array(
            'header'    => Mage::helper('adminhtml')->__('Email'),
            'width'     => 40,
            'align'     => 'left',
            'index'     => 'email'
        ));
        
        $this->addColumn('role_name', array(
        		'header'    => Mage::helper('adminhtml')->__('Role'),
        		'sortable'  => true,
        		'index'     => 'role_name'
        ));
        $this->addColumn('is_active', array(
            'header'    => Mage::helper('adminhtml')->__('Status'),
            'index'     => 'is_active',
            'type'      => 'options',
            'options'   => array('1' => Mage::helper('adminhtml')->__('Active'), '0' => Mage::helper('adminhtml')->__('Inactive')),
        ));
		
       $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('adminhtml')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('adminhtml')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'user_id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
        
        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('user_id' => $row->getId()));
    }

    public function getGridUrl()
    {
        //$uid = $this->getRequest()->getParam('user_id');
        return $this->getUrl('*/*/roleGrid', array());
    }

}
