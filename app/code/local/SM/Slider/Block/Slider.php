<?php
/**
 * Class SM_Slider_Block_Slider
 */
class SM_Slider_Block_Slider extends Mage_Core_Block_Template
{
    /**
     * @var $_itemCollection
     */
    protected $_itemCollection;

    /**
     * @return SM_Slider_Block_Slider
     */
    protected function _prepareData()
    {
        $slider_id = $this->getData('slider_id');
        if (!isset($slider_id)) {
            $this->_itemCollection = null;
            return $this;
        } else {
            $slider_model = Mage::getModel('sm_slider/slider')->getCollection()
                ->addFieldToFilter('slider_id', array('eq' => $slider_id))
                ->getFirstItem();
            if ($slider_model === null || $slider_model->getData('status') == 0) {
                $this->_itemCollection = null;
                return $this;
            } else {
                $reference_table = Mage::getSingleton('core/resource')->getTableName('sm_slider/slideshow');
                $slide_collection = Mage::getModel('sm_slider/slide')->getCollection()
                    ->addFieldToFilter('status', array('eq' => 1));
                 $slide_collection->getSelect()
                    ->joinLeft($reference_table,
                        'main_table.slide_id = '.$reference_table.'.slide_id',
                        array($reference_table.'.sort_order'))
                    ->where(''.$reference_table.'.slider_id = '.$slider_id.'')
                    ->order('sort_order', 'ASC');
                $this->_itemCollection = $slide_collection;

                return $this;
            }
        }
    }

    /**
     * Get img html code from content of editor
     * @param SM_Slider_Block_Slider
     * @return string
     * @throws Exception
     */
    public function getPhoto($item)
    {
        $helper = Mage::helper('cms');
        $processor = $helper->getPageTemplateProcessor();
        $html = $processor->filter($item->getData('photo'));
        $html = strip_tags($html, '<img>');
        return $html;
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
     * @return SM_Slider_Block_Slider
     */
    public function getCollection()
    {
        return $this->_itemCollection;
    }
}