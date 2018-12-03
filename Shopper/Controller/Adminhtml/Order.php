<?php

namespace Alexsample\Shopper\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Alexsample\Shopper\Api\Data\OrderInterface;
use Alexsample\Shopper\Api\Repository\OrderRepositoryInterface;

abstract class Order extends Action
{
    public function __construct(
        OrderRepositoryInterface $orderRepository,
        Context $context
    ) {
        $this->orderRepository = $orderRepository;
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
        $resultPage->getConfig()->getTitle()->prepend(__('Orders'));

        return $resultPage;
    }

    /**
     * @return BrandPageInterface
     */
    public function initModel()
    {
        $model = $this->orderRepository->create();

        if ($this->getRequest()->getParam('id')) {
            $model = $this->orderRepository->get($this->getRequest()->getParam('id'));
        }

        return $model;
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->context->getAuthorization()->isAllowed('Alexsample_Shopper::shopper_order');
    }
}
