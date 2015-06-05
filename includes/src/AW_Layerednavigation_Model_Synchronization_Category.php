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

class AW_Layerednavigation_Model_Synchronization_Category
    extends AW_Layerednavigation_Model_Synchronization_Abstract
{
    protected $_categoryFilter = null;
    protected $_categoryCollection = null;

    protected $_categoryIdList = array();
    protected $_filterCategoryIdList = array();

    /**
     * Prepare categories and filter options
     */
    public function __construct()
    {
        foreach ($this->_getCategoryCollection() as $categoryId => $category) {
            $this->_categoryIdList[$categoryId] = $category->getId();
        }

        foreach ($this->_getCategoryFilter()->getOptionCollection() as $optionId => $optionModel) {
            $filterAdditionalData = $optionModel->getAdditionalData();
            if (array_key_exists('category_id', $filterAdditionalData)) {
                $this->_filterCategoryIdList[$optionId] = $filterAdditionalData['category_id'];
            }
        }
    }

    /**
     * Remove filter options which categories was deleted
     * Create new filter options for new categories
     */
    public function run()
    {
        $categoryFilterModel = $this->_getCategoryFilter();
        $this->_removeCategoryOptions();
        $this->_processCategoryTree($categoryFilterModel);
        $this->_processCategoryPath($categoryFilterModel);
    }

    public function runObserve($observer)
    {
        $this->run();
    }

    /**
     * Update EAV after category save
     */
    public function categoryPrepareSave($observer)
    {
        $category = $observer->getData('category');
        if (!$category->getId()) {
            return $this;
        }

        $synchMap = array(
            'name'        => 'title',
            'is_active'   => 'is_enabled',
            'description' => 'description',
        );

        $categorySynchList = array_keys($observer->getData('request')->getParam('synchronize', array()));
        $useDefaultList = $observer->getData('request')->getParam('use_default', array());

        $storeId = $category->getStoreId();
        $optionId = null;

        foreach ($this->_getCategoryFilter()->getOptionCollection() as $optionId => $optionModel) {
            if ($optionModel->getData('additional_data/category_id') == $category->getId()) {
                $optionId = $optionModel->getId();
                break;
            }
        }

        $categoryData = $observer->getData('request')->getParam('general', array());

        foreach ($categorySynchList as $attributeCode) {
            if (!array_key_exists($attributeCode, $synchMap)) {
                continue;
            }
            $eavOptionModel = Mage::getModel('aw_layerednavigation/filter_option_eav')->getFilterAttributeModelByCode(
                $optionId, $synchMap[$attributeCode], $storeId
            );
            if (in_array($attributeCode, $useDefaultList)) {
                if ($storeId !== Mage_Catalog_Model_Abstract::DEFAULT_STORE_ID) {
                    $eavOptionModel->delete();
                }
            } elseif (array_key_exists($attributeCode, $categoryData)) {
                $eavOptionModel
                    ->addData(
                        array(
                            'option_id' => $optionId,
                            'store_id'  => $storeId,
                            'name'      => $synchMap[$attributeCode],
                            'value'     => $categoryData[$attributeCode],
                        )
                    )
                    ->save()
                ;
            }
        }
    }

    /**
     * Get category filter, if filter does not exist, create it
     *
     * @return AW_Layerednavigation_Model_Filter
     */
    protected function _getCategoryFilter()
    {
        if ($this->_categoryFilter === null) {
            $collection = Mage::getResourceModel('aw_layerednavigation/filter_collection')
                ->addFieldToFilter(
                    'type', array('eq' => AW_Layerednavigation_Model_Source_Filter_Type::CATEGORY_CODE)
                )
            ;
            $categoryFilterModel = $collection->getFirstItem();

            if (!$categoryFilterModel->getId()) {
                $displayType = AW_Layerednavigation_Model_Source_Filter_Display_Type::RADIO_CODE;
                $imagePosition = AW_Layerednavigation_Model_Source_Filter_Image_Position::TEXT_ONLY_CODE;
                $categoryFilterData = array(
                    'title'                      => Mage::helper('aw_layerednavigation')->__('Category'),
                    'type'                       => AW_Layerednavigation_Model_Source_Filter_Type::CATEGORY_CODE,
                    'is_enabled'                 => 1,
                    'is_enabled_in_search'       => 1,
                    'code'                       => $this->getUniqueCode('category'),
                    'position'                   => 0,
                    'display_type'               => $displayType,
                    'image_position'             => $imagePosition,
                    'is_row_count_limit_enabled' => self::IS_ROW_COUNT_LIMIT_STATUS,
                    'row_count_limit'            => self::ROW_COUNT_LIMIT,
                    'additional_data'            => array(),
                );
                $categoryFilterModel->setData($categoryFilterData)->save();
            }
            $this->_categoryFilter = $categoryFilterModel;
        }
        return $this->_categoryFilter;
    }

    /**
     * Remove options which category was deleted
     */
    protected function _removeCategoryOptions()
    {
        foreach (array_diff($this->_filterCategoryIdList, $this->_categoryIdList) as $optionId => $categoryId) {
            Mage::getModel('aw_layerednavigation/filter_option')->setId($optionId)->delete();
        }
    }

    /**
     * Create new filter options for new categories
     *
     * @param AW_Layerednavigation_Model_Filter $categoryFilterModel
     */
    protected function _processCategoryTree($categoryFilterModel)
    {
        $categoryIdListForCreate = array_diff($this->_categoryIdList, $this->_filterCategoryIdList);

        $categoryCollection = Mage::getResourceModel('catalog/category_collection');
        foreach ($categoryCollection as $category) {
            if (in_array($category->getId(), $categoryIdListForCreate)) {

                $categoryNameList = $this->_getStoreCategoryNameList($category);
                $categoryStatusList = $this->_getStoreCategoryStatusList($category);
                $categoryDescriptionList = $this->_getStoreCategoryDescriptionList($category);

                $additionalData = array(
                    'category_id' => $category->getId(),
                    'parent_id'   => $category->getData('parent_id'),
                    'path'        => $category->getData('path'),
                );


                $optionModelData = array(
                    'filter_id'       => $categoryFilterModel->getId(),
                    'is_enabled'      => (int)$categoryStatusList[Mage_Catalog_Model_Abstract::DEFAULT_STORE_ID],
                    'position'        => (int)$category->getData('position'),
                    'title'           => $categoryNameList[Mage_Catalog_Model_Abstract::DEFAULT_STORE_ID],
                    'additional_data' => $additionalData,
                );

                if (
                    array_key_exists(Mage_Catalog_Model_Abstract::DEFAULT_STORE_ID, $categoryDescriptionList)
                    && trim($categoryDescriptionList[Mage_Catalog_Model_Abstract::DEFAULT_STORE_ID]) != ''
                ) {
                    $optionModelData['description'] = $categoryDescriptionList[Mage_Catalog_Model_Abstract::DEFAULT_STORE_ID];
                }

                $optionModel = Mage::getModel('aw_layerednavigation/filter_option')->setData($optionModelData)->save();
                // Save option labels for stores
                foreach ($categoryNameList as $storeId => $categoryLabel) {
                    if ($storeId != Mage_Catalog_Model_Abstract::DEFAULT_STORE_ID) {
                        $categoryOptionEavData = array(
                            'option_id' => $optionModel->getId(),
                            'store_id'  => $storeId,
                            'name'      => 'title',
                            'value'     => $categoryLabel,
                        );

                        Mage::getModel('aw_layerednavigation/filter_option_eav')
                            ->setData($categoryOptionEavData)
                            ->save()
                        ;
                    }
                }

                // Save option description for stores
                foreach ($categoryDescriptionList as $storeId => $categoryDescription) {
                    if ($storeId != Mage_Catalog_Model_Abstract::DEFAULT_STORE_ID) {
                        $categoryOptionEavData = array(
                            'option_id' => $optionModel->getId(),
                            'store_id'  => $storeId,
                            'name'      => 'description',
                            'value'     => $categoryDescription,
                        );

                        Mage::getModel('aw_layerednavigation/filter_option_eav')
                            ->setData($categoryOptionEavData)
                            ->save()
                        ;
                    }
                }

                // Save option status for stores
                foreach ($categoryStatusList as $storeId => $categoryStatus) {
                    if ($storeId != Mage_Catalog_Model_Abstract::DEFAULT_STORE_ID) {
                        $categoryOptionEavData = array(
                            'option_id' => $optionModel->getId(),
                            'store_id'  => $storeId,
                            'name'      => 'is_enabled',
                            'value'     => $categoryStatus,
                        );

                        Mage::getModel('aw_layerednavigation/filter_option_eav')
                            ->setData($categoryOptionEavData)
                            ->save()
                        ;
                    }
                }
            }
        }
    }

    /**
     * Update filter options for exists categories
     *
     * @param AW_Layerednavigation_Model_Filter $categoryFilterModel
     *
     * @return $this
     */
    protected function _processCategoryPath($categoryFilterModel)
    {
        foreach ($categoryFilterModel->getOptionCollection() as $option) {
            $category = Mage::getModel('catalog/category')->load($option->getData('additional_data/category_id'));
            if (null === $category->getId()) {
                continue;
            }
            $additionalData = $option->getData('additional_data');
            $additionalData['path'] = $category->getData('path');
            $additionalData['parent_id'] = $category->getData('parent_id');
            $option->setData('additional_data', $additionalData);
            try {
                $option->save();
            } catch (Exception $e) {
                Mage::logException($e);
            }
        }
        return $this;
    }

    /**
     * Retrieve category name list for stores
     *
     * @param Mage_Catalog_Model_Category $category
     *
     * @return array
     */
    protected function _getStoreCategoryNameList($category)
    {
        $categoryNameAttribute = $category->getResource()->getAttribute('name');

        $categoryVarcharTable = Mage::getSingleton('core/resource')->getTableName('catalog/category') . "_varchar";

        $attributeValueCollection = Mage::getResourceModel('catalog/category_collection');
        $attributeValueCollection
            ->getSelect()
            ->reset(Zend_Db_Select::COLUMNS)
            ->joinLeft(
                array('_category_name_value' => $categoryVarcharTable),
                join(
                    " AND ",
                    array(
                        "_category_name_value.attribute_id = {$categoryNameAttribute->getId()}",
                        "e.entity_id = _category_name_value.entity_id",
                        "e.entity_id = {$category->getId()}",
                    )
                ),
                array(
                     'category_id' => 'e.entity_id',
                     'store_id'    => '_category_name_value.store_id',
                     'value'       => '_category_name_value.value',
                )
            )
            ->where('_category_name_value.value IS NOT NULL')
        ;

        $categoryNameList = array();
        foreach ($attributeValueCollection as $categoryNameItem) {
            $categoryNameList[$categoryNameItem->getStoreId()] = $categoryNameItem->getValue();
        }
        return $categoryNameList;
    }

    /**
     * Retrieve category status list for stores
     *
     * @param Mage_Catalog_Model_Category $category
     *
     * @return array
     */
    protected function _getStoreCategoryStatusList($category)
    {
        $categoryStatusAttribute = $category->getResource()->getAttribute('is_active');
        $categoryIntTable = Mage::getSingleton('core/resource')->getTableName('catalog/category') . "_int";

        $attributeValueCollection = Mage::getResourceModel('catalog/category_collection');
        $attributeValueCollection
            ->getSelect()
            ->reset(Zend_Db_Select::COLUMNS)
            ->joinLeft(
                array('_category_status_value' => $categoryIntTable),
                join(
                    " AND ",
                    array(
                        "_category_status_value.attribute_id = {$categoryStatusAttribute->getId()}",
                        "e.entity_id = _category_status_value.entity_id",
                        "e.entity_id = {$category->getId()}",
                    )
                ),
                array(
                    'category_id' => 'e.entity_id',
                    'store_id'    => '_category_status_value.store_id',
                    'value'       => '_category_status_value.value',
                )
            )
            ->where('_category_status_value.value IS NOT NULL')
        ;

        $categoryStatusList = array();
        foreach ($attributeValueCollection as $categoryStatusItem) {
            $categoryStatusList[$categoryStatusItem->getStoreId()] = $categoryStatusItem->getValue();
        }
        return $categoryStatusList;
    }

    /**
     * Retrieve category description list for stores
     *
     * @param Mage_Catalog_Model_Category $category
     *
     * @return array
     */
    protected function _getStoreCategoryDescriptionList($category)
    {
        $categoryDescriptionAttribute = $category->getResource()->getAttribute('description');

        $categoryTextTable = Mage::getSingleton('core/resource')->getTableName('catalog/category') . "_text";

        $attributeValueCollection = Mage::getResourceModel('catalog/category_collection');
        $attributeValueCollection
            ->getSelect()
            ->reset(Zend_Db_Select::COLUMNS)
            ->joinLeft(
                array('_category_description_value' => $categoryTextTable),
                join(
                    " AND ",
                    array(
                         "_category_description_value.attribute_id = {$categoryDescriptionAttribute->getId()}",
                         "e.entity_id = _category_description_value.entity_id",
                         "e.entity_id = {$category->getId()}"
                    )
                ),
                array(
                     'category_id' => 'e.entity_id',
                     'store_id'    => '_category_description_value.store_id',
                     'value'       => '_category_description_value.value',
                )
            )
            ->where('_category_description_value.value IS NOT NULL')
        ;

        $categoryDescriptionList = array();
        foreach ($attributeValueCollection as $categoryDescriptionItem) {
            $categoryDescriptionList[$categoryDescriptionItem->getStoreId()] = $categoryDescriptionItem->getValue();
        }
        return $categoryDescriptionList;
    }

    /**
     * Get category collection
     *
     * @return Mage_Catalog_Model_Resource_Eav_Mysql4_Category_Collection
     */
    protected function _getCategoryCollection()
    {
        if ($this->_categoryCollection === null) {
            $this->_categoryCollection = Mage::getResourceModel('catalog/category_collection')
                ->addFieldToFilter('level', array('gt' => array(1)))
            ;
        }
        return $this->_categoryCollection;
    }
}