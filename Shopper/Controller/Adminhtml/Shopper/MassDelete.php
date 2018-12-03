<?php

namespace Alexsample\Shopper\Controller\Adminhtml\Shopper;

use Magento\Ui\Component\MassAction\Filter;
use Alexsample\Shopper\Model\ResourceModel\Shopper\CollectionFactory;
use Alexsample\Shopper\Controller\Adminhtml\Shopper;
use Alexsample\Shopper\Api\Data\ShopperInterface;
use Magento\Backend\App\Action\Context;
use Alexsample\Shopper\Api\Repository\ShopperRepositoryInterface;

class MassDelete extends Shopper
{
    public function __construct(
        ShopperRepositoryInterface $shopperRepository,
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory
    ) {
        parent::__construct($shopperRepository, $context);
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @return void
     */
    public function execute()
    {
        $ids = [];

        if ($this->getRequest()->getParam(ShopperInterface::ID)) {
            $ids = $this->getRequest()->getParam(ShopperInterface::ID);
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
                    $model = $this->shopperRepository->get($id);
                    $this->shopperRepository->delete($model);
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
