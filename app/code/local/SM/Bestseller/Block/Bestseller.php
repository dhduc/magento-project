<?php

/**
 * Class SM_Bestseller_Block_Bestseller
 */
class SM_Bestseller_Block_Bestseller extends Mage_Core_Block_Template
{
    /**
     * @var $_itemCollection
     */
    protected $_itemCollection;

    /**
     * Get collection of all bestseller products
     * @return mixed
     */
    protected function _prepareData()
    {
        $number_item = Mage::getStoreConfig('bestseller_config/general/number_product');
        $storeId = Mage::app()->getStore()->getId();

        $this->_itemCollection = Mage::getResourceModel('reports/product_collection')
            ->setStoreId($storeId)
            ->addStoreFilter($storeId)
            ->addAttributeToSelect(array('name', 'url_path', 'image'))
            ->addAttributeToFilter('status', 1)
            ->addFieldToFilter('visibility', Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
            ->addOrderedQty()
            ->setOrder('ordered_qty', 'desc')
            ->setPageSize($number_item)
            ->setCurPage(1);

        if (!Mage::helper('cataloginventory')->isShowOutOfStock()) {
            Mage::getSingleton('cataloginventory/stock')->addInStockFilterToCollection($this->_itemCollection);
        }

        if ($this->isCategoryPage()) {
            $this->_itemCollection->addCategoryFilter($this->getCurrentCategory());
        }

        return $this;
    }

    /**
     * Check if cms page
     * @return bool
     */
    public function isCmsPage()
    {
        $currentRoute = Mage::app()->getRequest()->getRouteName();
        if ($currentRoute == 'cms') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get current category
     * @return Mage_Catalog_Model_Category
     */
    public function getCurrentCategory()
    {
        $currentCategory = Mage::registry('current_category');
        return $currentCategory;
    }

    /**
     * Check if category page
     * @return bool
     */
    public function isCategoryPage()
    {
       if ((!$this->isCmsPage()) && ($this->getCurrentCategory() !== null)) {
           return true;
       } else {
           return false;
       }
    }

    /**
     * @return Mage_Core_Block_Abstract
     */
    protected function _beforeToHtml()
    {
        $this->_prepareData();
        return parent::_beforeToHtml();
    }

    /**
     * @return SM_Bestseller_Block_Bestseller
     */
    public function getProductCollection()
    {
        return $this->_itemCollection;
    }
}