<?php
/**
 * Class SM_Slider_Block_Adminhtml_Slider_Edit
 */
class SM_Slider_Block_Adminhtml_Slider_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Initialize edit form container
     */
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'slider_id';
        $this->_blockGroup = 'sm_slider';
        $this->_controller = 'adminhtml_slider';

        $this->_updateButton('save', 'label', Mage::helper('sm_slider')->__('Save Slider'));
        $this->_updateButton('delete', 'label', Mage::helper('sm_slider')->__('Delete Slider'));
        $this->_addButton('saveandcontinue', array(
            'label' => Mage::helper('sm_slider')->__('Save and Continue'),
            'onclick' => 'saveAndContinueEdit()',
            'class' => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('productsselector_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'productsselector_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'productsselector_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    /**
     * Get header text depending on loaded page
     * @return string
     */
    public function getHeaderText()
    {
        $model = Mage::registry('sm_slider');
        if ($model->getSlider_id()) {
            return Mage::helper('sm_slider')->__("Edit Slider '%s'", $this->escapeHtml($model->getSlider_title()));
        } else {
            return Mage::helper('sm_slider')->__('Add Slider');
        }
    }
}
