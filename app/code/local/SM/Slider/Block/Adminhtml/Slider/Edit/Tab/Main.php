<?php
/**
 * Class SM_Slider_Block_Adminhtml_Slider_Edit_Tab_Main
 */
class SM_Slider_Block_Adminhtml_Slider_Edit_Tab_Main
    extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    /**
     * Prepare form element for tab
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        $model = Mage::registry('sm_slider');
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('item_main_');

        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend'    => Mage::helper('sm_slider')->__('Slider Information'),
        ));

        if ($model->getSlider_id()) {
            $fieldset->addField('slider_id', 'hidden', array(
                'name' => 'slider_id',
            ));
        }
        $fieldset->addField('slider_title', 'text', array(
            'name'      => 'slider_title',
            'label'     => Mage::helper('sm_slider')->__('Title'),
            'required'  => true,
            'tabindex'  => 1,
        ));
        $fieldset->addField('slider_description', 'textarea', array(
            'name'      => 'slider_description',
            'label'     => Mage::helper('sm_slider')->__('Description'),
            'required'  => false,
            'tabindex'  => 1,
        ));
        $fieldset->addField('status', 'select', array(
            'name'      => 'enable',
            'label'     => Mage::helper('sm_slider')->__('Status'),
            'required'  => false,
            'values' => array(
                0 => 'Disable',
                1 => 'Enable',
            ),
            'after_element_html' => '<small>Status of slider</small>',
            'width' => '50px',
            'tabindex' => 2,
        ));

        $form->setValues($model->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     * @return string
     */
    public function getTabLabel()
    {
        return Mage::helper('sm_slider')->__('Slider Infomation');
    }

    /**
     * Prepare title for tab
     * @return string
     */
    public function getTabTitle()
    {
        return Mage::helper('sm_slider')->__('Slider Infomation');
    }

    /**
     * Return whether tab can be shown
     * @return bool
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Return whether tab can be shown
     * @return bool
     */
    public function isHidden()
    {
        return false;
    }
}