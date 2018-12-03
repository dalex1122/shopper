<?php

namespace Alexsample\Shopper\Controller\Adminhtml\Shopper;

use Magento\Framework\Controller\ResultFactory;
use Alexsample\Shopper\Api\Data\ShopperInterface;
use Alexsample\Shopper\Controller\Adminhtml\Shopper;

class Edit extends Shopper
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
            $this->messageManager->addErrorMessage(__('This shopper no longer exists.'));

            return $this->resultRedirectFactory->create()->setPath('*/*/');
        }

        $this->initPage($resultPage)->getConfig()->getTitle()->prepend(
            $model->getName() . ' ' . $model->getLastName()
        );

        return $resultPage;
    }
}
