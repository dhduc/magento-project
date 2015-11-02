<?php
/**
 * Class SM_Slider_Block_Adminhtml_Slider_Edit_Tab_Content
 */
class SM_Slider_Block_Adminhtml_Slider_Edit_Tab_Content
    extends Mage_Adminhtml_Block_Widget_Grid
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
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
        $slider_id = $this->getSlider()->getSlider_id();
        $collection = Mage::getModel('sm_slider/slide')->getCollection()
            ->addFieldToFilter('status', array('eq' => 1));

        if ($slider_id) {
            $reference_table = Mage::getSingleton('core/resource')->getTableName('sm_slider/slideshow');
            $collection->getSelect()
            ->joinLeft(
                $reference_table,
                'main_table.slide_id = '.$reference_table.'.slide_id && '.$slider_id.' = '.$reference_table.'.slider_id',
                array($reference_table.'.sort_order')
            );
        }

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Prepare columns for grid
     * @return SM_Slider_Block_Adminhtml_Slider_Edit_Tab_Content
     * @throws Exception
     */
    protected function _prepareColumns()
    {
        $this->addColumn('slideId', array(
                'header_css_class'  => 'a-center',
                'type'              => 'checkbox',
                'align'             => 'center',
                'index'             => 'slide_id',
                'values'            => $this->_getSelectSlideShow(),
                'field_name'	    => 'slideId[]'
        ));

        $this->addColumn('slide_id', array(
                'header' => Mage::helper('sm_slider')->__('Slide ID'),
                'align' => 'right',
                'index' => 'slide_id',
                'width' => '30px',
        ));

        $this->addColumn('slide_title', array(
                'header' => Mage::helper('sm_slider')->__('Slide Title'),
                'index' => 'slide_title',
                'width' => '150px',
        ));

        $this->addColumn('sort_order', array(
                'index' => 'sort_order',
                'header' => Mage::helper('sm_slider')->__('Sort Order'),
                'align' => 'center',
                'field_name' => 'sort_order[]',
                'renderer' => 'sm_slider/adminhtml_slider_renderer_sort',
                'width' => '100px',
                'editable'  => true,
        ));

        $this->addColumn('created_at', array(
                'header' => Mage::helper('sm_slider')->__('Created At'),
                'index' => 'created_at',
                'type' => 'date',
                'width' => '50px',
        ));

        $this->addColumn('updated_at', array(
                'header' => Mage::helper('sm_slider')->__('Updated At'),
                'index' => 'updated_at',
                'type' => 'date',
                'width' => '50px',
        ));

        $this->addColumn('status', array(
                'header' => Mage::helper('sm_slider')->__('Status'),
                'index' => 'status',
                'type' => 'options',
                'options' => array(
                    0 => 'Disabled',
                    1 => 'Enabled',
                ),
                'width' => '50px',
        ));

        $this->addColumn('action', array(
            'header' => Mage::helper('catalog')->__('Action'),
            'width' => '100px',
            'type' => 'action',
            'getter' => 'getId',
            'actions' => array(
                array(
                    'caption' => Mage::helper('catalog')->__('Edit Item'),
                    'image' => Mage::getDesign()->getSkinUrl('images/rule_chooser_trigger.gif'),
                    'url' => array(
                        'base' => '*/sm_slide/edit',
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
        return $this->getUrl('*/sm_slide/grid', array('_current'=>true));
    }

    /**
     * Prepare label for tab
     * @return string
     */
    public function getTabLabel()
    {
        return Mage::helper('adminhtml')->__('Slides of Slider');
    }

    /**
     * Prepare title for tab
     * @return string
     */
    public function getTabTitle()
    {
        return Mage::helper('adminhtml')->__('Slide of Slider');
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

    /**
     * Return registry model
     * @return registry
     */
    public function getSlider()
    {
        return Mage::registry('sm_slider');
    }

    /**
     * Return selected slideshow
     * @return array
     */
    public function _getSelectSlideShow()
    {
        $model = Mage::registry('sm_slider');
        $slider_id = $model->getSlider_id();
        $slideCollection = Mage::getModel('sm_slider/slideshow')->getCollection()
            ->addFieldToFilter('slider_id', array('eq' => $slider_id));

        $reference = array();
        if ($slideCollection->getSize()) {
            foreach ($slideCollection as $slide) {
                $reference[] = $slide->getData('slide_id');
            }
        }

        return $reference;
    }
}