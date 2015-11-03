<?php

/**
 * Class Mage_Catalog_Block_Product_List_Related
 */
class SM_PriceRelatedProducts_Block_Pricerelatedproducts extends Mage_Catalog_Block_Product_List_Related
{
    /**
     * @var $_itemCollection
     */
    protected $_itemCollection;

     /**
     * @const number product display
     */
    const NUMBER = 3;

    /**
     * Prepare data for collection
     * @return SM_PriceRelatedProducts_Block_Pricerelatedproducts
     */
    protected function _prepareData()
    {
        $product = Mage::registry('current_product');
        $currentPrice = (string) $product->getPrice();
        $number = self::NUMBER;

        $this->_itemCollection = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToSelect("*")
            ->addFieldToFilter('price', array('gt' => '0'));
        $select = $this->_itemCollection->getSelect();
        $priceRange = array(
            '*',
            new Zend_Db_Expr('abs(at_price.value - '. $currentPrice .')'),
            'range'
        );
        $columns = $select->getPart(Zend_Db_Select::COLUMNS);
        $columns[] = $priceRange;
        $select->setPart(Zend_Db_Select::COLUMNS, $columns);
        $select->order('range ASC')->limit($number);

        if (Mage::helper('catalog')->isModuleEnabled('Mage_Checkout')) {
            Mage::getResourceSingleton('checkout/cart')->addExcludeProductFilter($this->_itemCollection,
                Mage::getSingleton('checkout/session')->getQuoteId()
            );
            $this->_addProductAttributesAndPrices($this->_itemCollection);
        }
        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($this->_itemCollection);
        $this->_itemCollection->load();
        foreach ($this->_itemCollection as $_product) {
            $_product->setDoNotUseCategoryId(true);
        }

        return $this;

    }

    /**
     * Prepare html to display
     * @return Mage_Core_Block_Abstract
     */
    protected function _beforeToHtml()
    {
        $this->_prepareData();
        return parent::_beforeToHtml();
    }

    /**
     * Prepare products collection
     * @return SM_PriceRelatedProducts_Block_Pricerelatedproducts
     */
    public function getProductCollection()
    {
        return $this->_itemCollection;
    }

}