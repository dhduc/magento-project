<?php

/**
 * Class SM_Slider_Adminhtml_Sm_SlideController
 */
class SM_Slider_Adminhtml_Sm_SlideController extends Mage_Adminhtml_Controller_Action
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
     * Edit Slide
     */
    public function editAction()
    {
        $this->loadLayout()->_setActiveMenu('sm_slider');
        $this->_title(Mage::helper('sm_slider')->__('Slide Item'));

        $model = Mage::getModel('sm_slider/slide');
        $slide_id = $this->getRequest()->getParam('id');

        if ($slide_id) {
            $model->load($slide_id);
            if (!$model->getSlide_id()) {
                Mage::getSingleton('adminhtml/session')->addError('Item does not exist');
                $this->_redirect('*/*/');
            }
        }

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if ($data) {
            $model->setData($data)->setId($slide_id);
        }

        $model->setData($data)->setId($slide_id);
        Mage::register('sm_slide', $model);

        $this->renderLayout();
    }

    /**
     * Save action
     * @throws Exception
     */
    public function saveAction()
    {
        if ($this->getRequest()->getPost()) {
            $data = array(
                'slide_id' => $this->getRequest()->getParam('slide_id'),
                'slide_title' => $this->getRequest()->getParam('slide_title'),
                'text' => $this->getRequest()->getParam('text'),
                'photo' => $this->getRequest()->getParam('photo'),
                'created_at' => now(),
                'updated_at' => now(),
                'status' => $this->getRequest()->getParam('status'),
            );

            $model = Mage::getModel('sm_slider/slide');

            if ($id = $this->getRequest()->getParam('slide_id')) {
                $model->load($id);
                $model->setId($id);
            }

            foreach ($data as $index => $value) {
                $model->setData($index, $value);
            }

            try {
                $model->save();

                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The item has been saved.'));
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/sm_slide/edit', array('id' => $this->getRequest()->getParam('slide_id')));
                } else {
                    $this->_redirect('*/*/');
                }
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $id));
            }
        }
    }


    /**
     * Slider delete action
     * @return SM_Slider_Adminhtml_Sm_SlideController|void
     */
    public function deleteAction()
    {
        if ($id = $this->getRequest()->getParam('id')) {
            $model = Mage::getModel('sm_slider/slide');
            $model->setId($id);

            try {
                $model->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The record has been deleted.'));
                $this->_redirect('*/*/');
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessages());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($this->__('An error occurred while deleting this item.'));
                Mage::logException($e);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
    }

    /**
     * Mass delete item(s) action
     */
    public function massDeleteAction()
    {
        $item_ids = $this->getRequest()->getParam('slide_id');
        if (!is_array($item_ids)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select items'));
        } else {
            try {
                $collection = Mage::getModel('sm_slider/slide')->getCollection()
                    ->addFieldToFilter('slide_id', array('in' => $item_ids));
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
     * Mass change status for item(s) action
     */
    public function massStatusAction()
    {
        $item_ids = $this->getRequest()->getParam('slide_id');
        if (!is_array($item_ids)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select items'));
        } else {
            try {
                $collection = Mage::getModel('sm_slider/slide')->getCollection()
                    ->addFieldToFilter('slide_id', array('in' => $item_ids));
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
