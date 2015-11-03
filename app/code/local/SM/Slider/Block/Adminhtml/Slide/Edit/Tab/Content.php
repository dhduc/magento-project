<?php
/**
 * Class SM_Slider_Block_Adminhtml_Slide_Edit_Tab_Content
 */
class SM_Slider_Block_Adminhtml_Slide_Edit_Tab_Content
    extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    /**
     * Prepare form elements for tab
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        $model = Mage::registry('sm_slide');
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('item_main_');

        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend'    => Mage::helper('sm_slider')->__('Slide Content'),
        ));

        $fieldset->addField('text', 'textarea', array(
            'label'     => Mage::helper('sm_slider')->__('Text'),
            'required'  => false,
            'name'      => 'text',
            'style'     => 'width: 400px; height: 100px',
            'tabindex'  => 1
            ));

        $fieldset->addField('photo', 'editor', array(
            'name'      => 'photo',
            'label'     => Mage::helper('sm_slider')->__('Photo'),
            'title'     => Mage::helper('sm_slider')->__('Photo'),
            'style'     => 'width: 400px; height: 300px',
            'config'    => Mage::getSingleton('cms/wysiwyg_config')->getConfig(),
            'wysiwyg'   => true,
            'required'  => false,
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
        return Mage::helper('adminhtml')->__('Slide Content');
    }

    /**
     * Prepare title for tab
     * @return string
     */
    public function getTabTitle()
    {
        return Mage::helper('adminhtml')->__('Slide Content');
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