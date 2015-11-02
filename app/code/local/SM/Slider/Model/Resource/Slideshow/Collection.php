<?php
/**
 * Class SM_Slider_Model_Resource_Slide_Collection
 */
class SM_Slider_Model_Resource_Slideshow_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Initilaize resources
     */
    protected function _construct()
    {
        $this->_init('sm_slider/slideshow');
    }
}
