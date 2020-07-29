<?php
namespace Toppik\OrderSource\Controller\Adminhtml\Items;

use Magento\Framework\Controller\ResultFactory;

class Edit extends \Toppik\OrderSource\Controller\Adminhtml\Items
{
    /**
     * Edit Order Source
     *
     * @return \Magento\Framework\Controller\ResultInterface
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('id');
        $model = $this->_objectManager->create('Toppik\OrderSource\Model\Ordersource');

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This order source no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $this->_coreRegistry->register('order_source', $model);

        // 5. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
      
        $resultPage->getConfig()->getTitle()->prepend(__('Edit Order Source'));
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? $model->getLabel() : __('New Order Source'));
        return $resultPage;
    }
}