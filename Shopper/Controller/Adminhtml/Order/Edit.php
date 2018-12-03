<?php

namespace Alexsample\Shopper\Controller\Adminhtml\Order;

use Magento\Framework\Controller\ResultFactory;
use Alexsample\Shopper\Api\Data\OrderInterface;
use Alexsample\Shopper\Controller\Adminhtml\Order;

class Edit extends Order
{
    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page\Interceptor $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        $id = $this->getRequest()->getParam('id');
        $model = $this->initModel();

        if ($id && !$model->getId()) {
            $this->messageManager->addErrorMessage(__('This order no longer exists.'));

            return $this->resultRedirectFactory->create()->setPath('*/*/');
        }

        $this->initPage($resultPage)->getConfig()->getTitle()->prepend(
            'Order ID: ' . $model->getOrderId()
        );

        return $resultPage;
    }
}
