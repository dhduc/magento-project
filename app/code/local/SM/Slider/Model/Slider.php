<?php
/**
 * Class SM_Slider_Model_Slider
 */
class SM_Slider_Model_Slider extends Mage_Core_Model_Abstract
{
    /**
     * Initialize resources
     */
    protected function _construct()
    {
        $this->_init('sm_slider/slider');
    }

    public function toOptionArray()
    {
        $collection = $this->getCollection();
        $array = array(
            array('value' => 0, 'label' => 'None')
        );

        foreach ($collection as $slider) {
            $array[] = array('value' => $slider->getSlider_id(), 'label' => $slider->getSlider_title());
        }

        return $array;
    }
}
