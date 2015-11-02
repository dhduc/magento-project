<?php

/**
 * Class SM_Slider_Block_Adminhtml_Slide
 */
class SM_Slider_Block_Adminhtml_Slide extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * Block constructor
     */
    public function __construct()
    {
        $this->_blockGroup = 'sm_slider';
        $this->_controller = 'adminhtml_slide';
        $this->_headerText = Mage::helper('sm_slider')->__('Slide Manager');
        $this->_addButtonLabel = Mage::helper('sm_slider')->__('Add Slide');
        parent::__construct();
    }
}
