<?php

namespace Alexsample\Shopper\Controller\Adminhtml\Shopper;

use Magento\Framework\Controller\ResultFactory;
use Alexsample\Shopper\Controller\Adminhtml\Shopper;

class Add extends Shopper
{
    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        $this->initPage($resultPage)->getConfig()->getTitle()->prepend(__('New Shopper'));

        $this->initModel();

        return $resultPage;
    }
}
