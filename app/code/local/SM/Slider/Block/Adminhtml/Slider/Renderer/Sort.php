<?php
/**
 * Class SM_Slider_Block_Adminhtml_Slider_Renderer_Sort
 */
class SM_Slider_Block_Adminhtml_Slider_Renderer_Sort extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Input
{
    /**
     * Return html code for element
     * @param Varien_Object $row
     * @return string
     */
    public function render(Varien_Object $row)
    {
        $html = '<input type="text" ';
        $html .= 'name="' . $this->getColumn()->getId() . '[]" ';
        $html .= 'value="' . $row->getData($this->getColumn()->getIndex()) . '"';
        $html .= 'class="order input-text' . $this->getColumn()->getInlineCss() . '"/>';
        return $html;
    }
}