<?php
/**
 * Class SM_FeaturedProducts_Block_Adminhtml_System_Configuration_Implement
 */
class SM_FeaturedProducts_Block_Adminhtml_System_Configuration_Implement extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    /**
     * Return html code for tab section
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $html = '<div class="entry-edit-head collapseable"><a onclick="Fieldset.toggleCollapse(\'slider_template\'); return false;" href="#" id="slider_template-head" class="open">Implement Code</a></div>
            <input id="slider_template-state" type="hidden" value="1" name="config_state[slider_template]">
            <fieldset id="slider_template" class="config collapseable" style="">
            <h4 class="icon-head head-edit-form fieldset-legend">Code for Featured products slider:</h4>';

        $html .= '<div id="messages">
                <ul class="messages">
                    <li class="notice-msg">
                        <ul>
                            <li>' . Mage::helper('sm_featuredproducts')->__('Add code below to cms page or static page') . '</li>
                        </ul>
                    </li>
                </ul>
            </div>
            <br>
            <ul>
                <li>
                    <code>
                        {{block type="sm_featuredproducts/featuredproducts" name="sm.featuredproducts" template="featuredproducts/slider.phtml"}}
                    </code>
                </li>
            </ul>
            <br>';

        $html .= '<div id="messages">
                <ul class="messages">
                    <li class="notice-msg">
                        <ul>
                            <li>' . Mage::helper('sm_featuredproducts')->__('Add code below to layout') . '</li>
                        </ul>
                    </li>
                </ul>
            </div>
            <ul>
                <li>
                    <code>
                        &lt;block type="sm_featuredproducts/featuredproducts" name="sm.featuredproducts" template="featuredproducts/slider.phtml"&nbsp;/&gt;
                    </code>
                </li>
            </ul>
            <br>
            </fieldset>';

        return $html;
    }
}