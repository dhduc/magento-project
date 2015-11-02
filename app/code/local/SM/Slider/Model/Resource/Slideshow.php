<?php
/**
 * Class SM_Slider_Model_Resource_Slide
 */
class SM_Slider_Model_Resource_Slideshow extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Initialize resources
     */
    protected function _construct()
    {
        $this->_init('sm_slider/slideshow', 'id');
    }
}
