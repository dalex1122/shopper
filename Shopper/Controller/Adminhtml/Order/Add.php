<?php

namespace Alexsample\Shopper\Controller\Adminhtml\Order;

use Magento\Framework\Controller\ResultFactory;
use Alexsample\Shopper\Controller\Adminhtml\Order;

class Add extends Order
{
    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        $this->initPage($resultPage)->getConfig()->getTitle()->prepend(__('New Order'));

        $this->initModel();

        return $resultPage;
    }
}
