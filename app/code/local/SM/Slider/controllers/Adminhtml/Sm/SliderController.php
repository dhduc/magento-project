<?php

/**
 * Class SM_Slider_Adminhtml_Sm_SliderController
 */
class SM_Slider_Adminhtml_Sm_SliderController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->loadLayout()->_setActiveMenu('sm_slider');
        $this->renderLayout();
    }

    /**
     * Grid ajax action
     */
    public function gridAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * New Slide
     */
    public function newAction()
    {
        $this->_forward('edit');
    }

    /**
     * Edit action
     */
    public function editAction()
    {
        $this->loadLayout()->_setActiveMenu('sm_slider');
        $this->_title($this->__('Slider Item'));

        $model = Mage::getModel('sm_slider/slider');
        $slider_id = $this->getRequest()->getParam('id');

        if ($slider_id) {
            $model->load($slider_id);
            if (!$model->getSlider_id()) {
                Mage::getSingleton('adminhtml/session')->addError('Item does not exist');
                $this->_redirect('*/*/');
            }
        }

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if ($data) {
            $model->setData($data)->setId($slider_id);
        }

        $model->setData($data)->setId($slider_id);
        Mage::register('sm_slider', $model);

        $slideCollection = Mage::getModel('sm_slider/slideshow')->getCollection()
            ->addFieldToFilter('slider_id', array('eq' => $slider_id));
        $slidesInfo = array();
        foreach ($slideCollection as $slide) {
            $slidesInfo[] = array(
                'slide_id' => $slide->getData('slide_id'),
                'sort_order' => $slide->getData('sort_order')
            );
        }

        Mage::register('slideCollection', $slideCollection);
        $this->renderLayout();
    }

    /**
     * Save action
     * @throws Exception
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            $slider_model = Mage::getModel('sm_slider/slider');
            $slideshow_model = Mage::getModel('sm_slider/slideshow');
            $slider_id = $this->getRequest()->getParam('slider_id');
            $connection = Mage::getSingleton('core/resource')->getConnection('core_write');
            try {
                $connection->beginTransaction();

                /* Save info of slider */
                $info = array(
                    'slider_id' => $this->getRequest()->getParam('slider_id'),
                    'slider_title' => $this->getRequest()->getParam('slider_title'),
                    'slider_description' => $this->getRequest()->getParam('slider_description'),
                    'status' => $this->getRequest()->getParam('enable'),
                    'created_at' => now(),
                    'updated_at' => now(),
                );

                if ($slider_id) {
                    $slider_model->load($slider_id);
                    $slider_model->setSlider_id($slider_id);
                }
                foreach ($info as $index => $value) {
                    $slider_model->setData($index, $value);
                }
                $slider_model->save();

                /* Save slide(s) of slider */
                $slide_collection = Mage::getModel('sm_slider/slideshow')->getCollection()
                    ->addFieldToFilter('slider_id', $slider_id);

                // Create array of current slides associations
                $current_slides = array();
                foreach ($slide_collection as $slide) {
                    $current_slides[] = $slide->getSlide_id();
                }

                // Save associated slide
                if (!empty($data['slideId'])) {
                    foreach ($data['slideId'] as $index => $slide_id) {
                        $slideshowId = $slideshow_model->getCollection()
                            ->addFieldToFilter('slider_id', $slider_model->getSlider_id())
                            ->addFieldToFilter('slide_id', $slide_id)
                            ->getFirstItem()
                            ->getId();
                        $info = array();
                        // Check if association already saved
                        if ($slideshowId) {
                            $info['id'] = $slideshowId;
                        }
                        $info['slider_id'] = $slider_model->getSlider_id();
                        $info['slide_id'] = $slide_id;

                        // Save sort order of slide
                        if (isset($data['sort_order'][$index])) {
                            $info['sort_order'] = $data['sort_order'][$index];
                        }

                        $slideshow_model->setData($info);
                        $slideshow_model->save();
                    }

                    // Delete if slide association saved not selected
                    foreach ($slide_collection as $item) {
                        if (!in_array($item->getSlide_id(), $data['slideId'])) {
                            $item->delete();
                        }
                    }
                } else {
                    // Delete if no items is selected
                    foreach ($slide_collection as $item) {
                        $item->delete();
                    }
                }

                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The item has been saved.'));
                // Check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/sm_slider/edit', array('id' => $slider_model->getSlider_id()));
                } else {
                    $this->_redirect('*/*/');
                }

                $connection->commit();
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $slider_id));
                $connection->rollBack();
            }
        }
    }

    /**
     * Slider delete action
     * @return SM_Slider_Adminhtml_Sm_SliderController|void
     */
    public function deleteAction()
    {
        if ($id = $this->getRequest()->getParam('id')) {
            $model = Mage::getModel('sm_slider/slider');
            $model->setId($id);
            try {
                $model->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The record has been deleted.'));
                $this->_redirect('*/*/');
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessages());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($this->__('An error occurred while deleting this item.'));
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
    }

    /**
     * Mass delete item(s) action
     */
    public function massDeleteAction()
    {
        $item_ids = $this->getRequest()->getParam('slider_id');
        if (!is_array($item_ids)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select items'));
        } else {
            try {
                $collection = Mage::getModel('sm_slider/slider')->getCollection()
                    ->addFieldToFilter('slider_id', array('in' => $item_ids));
                foreach ($collection as $item) {
                    $item->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Total of %d items were successfully deleted', count($item_ids))
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/index');
    }

    /**
     * Mass change status item(s) action
     */
    public function massStatusAction()
    {
        $item_ids = $this->getRequest()->getParam('slider_id');
        if (!is_array($item_ids)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select items'));
        } else {
            try {
                $collection = Mage::getModel('sm_slider/slider')->getCollection()
                    ->addFieldToFilter('slider_id', array('in' => $item_ids));
                foreach ($collection as $item) {
                    $item->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Total of %d items were successfully updated', count($item_ids))
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/index');
    }
}
