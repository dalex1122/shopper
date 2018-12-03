<?php

namespace Alexsample\Shopper\Controller\Adminhtml\Order;

use Magento\Ui\Component\MassAction\Filter;
use Alexsample\Shopper\Model\ResourceModel\Order\CollectionFactory;
use Alexsample\Shopper\Controller\Adminhtml\Order;
use Alexsample\Shopper\Api\Data\OrderInterface;
use Magento\Backend\App\Action\Context;
use Alexsample\Shopper\Api\Repository\OrderRepositoryInterface;

class MassDelete extends Order
{
    public function __construct(
        OrderRepositoryInterface $orderRepository,
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory
    ) {
        parent::__construct($orderRepository, $context);
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @return void
     */
    public function execute()
    {
        $ids = [];

        if ($this->getRequest()->getParam(OrderInterface::ID)) {
            $ids = $this->getRequest()->getParam(OrderInterface::ID);
        }

        if ($this->getRequest()->getParam(Filter::SELECTED_PARAM)) {
            $ids = $this->getRequest()->getParam(Filter::SELECTED_PARAM);
        }

        if (!$ids) {
            $collection = $this->filter->getCollection($this->collectionFactory->create());
            $ids = $collection->getAllIds();
        }

        if ($ids) {
            try {
                foreach ($ids as $id) {
                    $model = $this->orderRepository->get($id);
                    $this->orderRepository->delete($model);
                }
                $this->messageManager->addSuccessMessage(
                    __('%1 item(s) was removed', count($ids))
                );
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Please select item(s)'));
            }
        } else {
            $this->messageManager->addErrorMessage(__('Please select item(s)'));
        }

        return $this->resultRedirectFactory->create()->setPath('*/*/');
    }
}
