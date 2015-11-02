<?php
/**
 * Class SM_Slider_Block_Adminhtml_Slide_Grid
 */
class SM_Slider_Block_Adminhtml_Slide_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Initialize grid default properties
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('sm_slide_grid');
        $this->setDefaultSort('slide_id');
        $this->setDefaultDir('asc');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * Prepare collection for grid
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('sm_slider/slide')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Prepare grid columns
     * @return Mage_Adminhtml_Block_Widget_Grid
     * @throws Exception
     */
    protected function _prepareColumns()
    {
        $this->addColumn('slide_id', array(
            'header'=> Mage::helper('sm_slider')->__('Slide ID'),
            'align' =>'right',
            'index' => 'slide_id',
            'width' => '100px',
        ));

        $this->addColumn('slide_title', array(
            'header'=> Mage::helper('sm_slider')->__('Slide Title'),
            'index' => 'slide_title',
        ));

        $this->addColumn('created_at', array(
            'header'=> Mage::helper('sm_slider')->__('Created At'),
            'index' => 'created_at',
            'type' => 'date',
        ));

        $this->addColumn('updated_at', array(
            'header'=> Mage::helper('sm_slider')->__('Updated At'),
            'index' => 'updated_at',
            'type' => 'date',
        ));

        $this->addColumn('status', array(
            'header'=> Mage::helper('sm_slider')->__('Status'),
            'index' => 'status',
            'type' => 'options',
            'options' => array(
                0 => 'Disabled',
                1 => 'Enabled',
            ),
            'width' => '100px',
        ));

        $this->addColumn('action', array(
            'header' => Mage::helper('sm_slider')->__('Action'),
            'width' => '100px',
            'type' => 'action',
            'getter' => 'getId',
            'actions' => array(
                array(
                    'caption' => Mage::helper('sm_slider')->__('Edit Item'),
                    'image' => Mage::getDesign()->getSkinUrl('images/rule_chooser_trigger.gif'),
                    'url' => array(
                        'base' => '*/*/edit',
                        'params' => array('store' => $this->getRequest()->getParam('store'))
                    ),
                    'field' => 'id'
                )),
            'filter' => false,
            'sortable' => false,
            'index' => 'stores',
        ));

        return parent::_prepareColumns();
    }

    /**
     * Return row URL for edit item
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }

    /**
     * Return grid url for ajax action
     * @param $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getSlide_id()));
    }

    /**
     * Prepare massaction interface
     * @return SM_Slider_Block_Adminhtml_Slide_Grid
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('sm_slide');
        $this->getMassactionBlock()->setFormFieldName('slide_id');
        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('sm_slider')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('sm_slider')->__('Are you sure?'),
        ));

        $statuses = array(
            '0' => Mage::helper('sm_slider')->__('Disabled'),
            '1' => Mage::helper('sm_slider')->__('Enabled'),
        );

        $this->getMassactionBlock()->addItem('status', array(
            'label' => Mage::helper('sm_slider')->__('Change Status'),
            'url' => $this->getUrl('*/*/massStatus', array(
                '_current' => true,
            )),
            'additional' => array(
                'visibility' => array(
                    'name' => 'status',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('sm_slider')->__('Status'),
                    'values' => $statuses
                ),
            ),
        ));

        return $this;
    }
}
