<?php

namespace Alexsample\Shopper\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Alexsample\Shopper\Api\Data\ShopperInterface;
use Alexsample\Shopper\Api\Repository\ShopperRepositoryInterface;

abstract class Shopper extends Action
{
    public function __construct(
        ShopperRepositoryInterface $shopperRepository,
        Context $context
    ) {
        $this->shopperRepository = $shopperRepository;
        $this->context = $context;

        parent::__construct($context);
    }

    /**
     * @param \Magento\Backend\Model\View\Result\Page $resultPage
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function initPage($resultPage)
    {
        $resultPage->setActiveMenu('Magento_Sales::sales');
        $resultPage->getConfig()->getTitle()->prepend(__('Shoppers'));

        return $resultPage;
    }

    /**
     * @return BrandPageInterface
     */
    public function initModel()
    {
        $model = $this->shopperRepository->create();

        if ($this->getRequest()->getParam('id')) {
            $model = $this->shopperRepository->get($this->getRequest()->getParam('id'));
        }

        return $model;
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->context->getAuthorization()->isAllowed('Alexsample_Shopper::shopper_shopper');
    }
}
