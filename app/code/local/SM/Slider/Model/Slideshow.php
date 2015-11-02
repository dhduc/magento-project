<?php
/**
 * Class SM_Slider_Model_Slide
 */
class SM_Slider_Model_Slideshow extends Mage_Core_Model_Abstract
{
    /**
     * Initialize resources
     */
    protected function _construct()
    {
        $this->_init('sm_slider/slideshow');
    }
}
