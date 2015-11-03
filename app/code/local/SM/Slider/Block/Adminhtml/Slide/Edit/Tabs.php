<?php
/**
 * Class SM_Slider_Block_Adminhtml_Slide_Edit_Tabs
 */
class SM_Slider_Block_Adminhtml_Slide_Edit_Tabs extends  Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * Initialize tabs block
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('item_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('sm_slider')->__('Slide Information'));
    }
}