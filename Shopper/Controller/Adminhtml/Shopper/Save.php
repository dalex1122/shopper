<?php

namespace Alexsample\Shopper\Controller\Adminhtml\Shopper;

use Alexsample\Shopper\Controller\Adminhtml\Shopper;
use Alexsample\Shopper\Api\Data\ShopperInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Alexsample\Shopper\Api\Repository\ShopperRepositoryInterface;
use Magento\Backend\App\Action\Context;

class Save extends Shopper
{
    public function __construct(
        ShopperRepositoryInterface $shopperRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        Context $context
    ) {

        $this->shopperRepository = $shopperRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->context = $context;

        parent::__construct($shopperRepository, $context);
    }

    /**
     * @return void
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam(ShopperInterface::ID);
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
                $this->shopperRepository->save($model);

                $this->messageManager->addSuccessMessage(__('Shopper was saved.'));

                if ($this->getRequest()->getParam('back') == 'edit') {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId()]);
                }

                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                if (!$this->isEmailUnique($data)) {
                    $this->messageManager->addErrorMessage(__('Email should be unique.'));
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
    protected function isEmailUnique($data)
    {
        $criteria = $this->searchCriteriaBuilder->addFilter(
            ShopperInterface::EMAIL,
            $data[ShopperInterface::EMAIL],
            'eq'
        )->create();
        $searchResult = $this->shopperRepository->getList($criteria);

        if ($searchResult->getTotalCount() > 0) {
            return false;
        }

        return true;
    }
}
