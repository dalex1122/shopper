<?php

namespace Alexsample\Shopper\Controller\Adminhtml\Shopper;

use Alexsample\Shopper\Controller\Adminhtml\Shopper;

class Delete extends Shopper
{
    /**
     * @return void
     */
    public function execute()
    {
        if ($id = $this->getRequest()->getParam('id')) {
            try {
                $model = $this->shopperRepository->get($id);
                $this->shopperRepository->delete($model);

                $this->messageManager->addSuccessMessage(__('Shopper was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                $this->_redirect('*/*/edit', ['id' => $id]);
            }
        }
        $this->_redirect('*/*/');
    }
}
