<?php

/**
 * Class SM_FeaturedProducts_Block_Featuredproducts
 */
class SM_FeaturedProducts_Block_Featuredproducts extends Mage_Core_Block_Template
{
    /**
     * @var $_itemCollection
     */
    protected $_itemCollection;

    /**
     * Number of product to display
     */

    const NUMBER = 10;

    /**
     * Return collection of all featured products
     * @return Mage_Catalog_Model_Resource_Product_Collection
     */
    protected function _prepareData()
    {
        $this->_itemCollection = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToSelect("*")
            ->addAttributeToFilter('is_featured', 1)
            ->setPageSize(self::NUMBER)->setCurPage(1);

        if ($this->isCategoryPage()) {
            $this->_itemCollection->addCategoryFilter($this->getCurrentCategory());
        }
        if (!Mage::helper('cataloginventory')->isShowOutOfStock()) {
            Mage::getSingleton('cataloginventory/stock')->addInStockFilterToCollection($this->_itemCollection);
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
        return ($currentRoute == 'cms') ? true : false;
    }

    /**
     * Get current category
     * @return Mage_Catalog_Model_Category
     */
    public function getCurrentCategory()
    {
        $currentCategory = Mage::registry('current_category');
        return (isset($currentCategory)) ? $currentCategory : null;
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
     * @return SM_FeaturedProducts_Block_Featuredproducts
     */
    public function getProductCollection()
    {
        return $this->_itemCollection;
    }

}