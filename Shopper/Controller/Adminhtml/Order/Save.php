<?php

namespace Alexsample\Shopper\Controller\Adminhtml\Order;

use Alexsample\Shopper\Controller\Adminhtml\Order;
use Alexsample\Shopper\Api\Data\OrderInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Alexsample\Shopper\Api\Repository\OrderRepositoryInterface;
use Magento\Backend\App\Action\Context;

class Save extends Order
{

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        Context $context
    ) {

        $this->orderRepository = $orderRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->context = $context;

        parent::__construct($orderRepository, $context);
    }
    /**
     * @return void
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam(OrderInterface::ID);
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            $model = $this->initModel();

            if ($id && !$model) {
                $this->messageManager->addErrorMessage(__('This shopper no longer exists.'));

                return $resultRedirect->setPath('*/*/');
            }

            $model->setData($data);

            try {
                $this->orderRepository->save($model);

                $this->messageManager->addSuccessMessage(__('Order was saved.'));

                if ($this->getRequest()->getParam('back') == 'edit') {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId()]);
                }

                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                if (!$this->isOrderIdUnique($data)) {
                    $this->messageManager->addErrorMessage(__('Order ID should be unique.'));
                    return $resultRedirect->setPath('*/*/');
                }
                $this->messageManager->addErrorMessage($e->getMessage());

                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }
    }

    /**
     * @param $data
     * @return bool
     */
    protected function isOrderIdUnique($data)
    {
        $criteria = $this->searchCriteriaBuilder->addFilter(
            OrderInterface::ORDER_ID,
            $data[OrderInterface::ORDER_ID],
            'eq'
        )->create();
        $searchResult = $this->orderRepository->getList($criteria);

        if ($searchResult->getTotalCount() > 0) {
            return false;
        }

        return true;
    }
}
