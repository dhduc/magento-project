<?php
/**
 * Class SM_Slider_Block_Adminhtml_Slider_Grid
 */
class SM_Slider_Block_Adminhtml_Slider_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Initialize grid default properties
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('sm_slider_grid');
        $this->setDefaultSort('slider_id');
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
        $collection = Mage::getModel('sm_slider/slider')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Prepare columns for grid
     * @return Mage_Adminhtml_Block_Widget_Grid
     * @throws Exception
     */
    protected function _prepareColumns()
    {
        $this->addColumn('slider_id', array(
            'header'=> Mage::helper('sm_slider')->__('Slider ID'),
            'align' =>'right',
            'index' => 'slider_id',
            'width' => '100px',
        ));

        $this->addColumn('slider_title', array(
            'header'=> Mage::helper('sm_slider')->__('Title'),
            'index' => 'slider_title',
        ));

        $this->addColumn('slider_description', array(
            'header'=> Mage::helper('sm_slider')->__('Description'),
            'index' => 'slider_description',
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
                )
            ),
            'filter' => false,
            'sortable' => false,
            'index' => 'stores',
        ));

        return parent::_prepareColumns();
    }

    /**
     * Return grid URL for ajax action
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }

    /**
     * Return row URL connect to edit item
     * @param $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getSlider_id()));
    }

    /**
     * Prepare massaction interface
     * @return SM_Slider_Block_Adminhtml_Slider_Grid
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('sm_slider');
        $this->getMassactionBlock()->setFormFieldName('slider_id');
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
