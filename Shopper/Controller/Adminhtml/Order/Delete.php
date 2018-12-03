<?php

namespace Alexsample\Shopper\Controller\Adminhtml\Order;

use Alexsample\Shopper\Controller\Adminhtml\Order;

class Delete extends Order
{
    /**
     * @return void
     */
    public function execute()
    {
        if ($id = $this->getRequest()->getParam('id')) {
            try {
                $model = $this->orderRepository->get($id);
                $this->orderRepository->delete($model);

                $this->messageManager->addSuccessMessage(__('Order was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                $this->_redirect('*/*/edit', ['id' => $id]);
            }
        }
        $this->_redirect('*/*/');
    }
}
