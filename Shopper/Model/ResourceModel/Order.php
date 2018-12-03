<?php

namespace Alexsample\Shopper\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Alexsample\Shopper\Api\Data\OrderInterface;

class Order extends AbstractDb
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(OrderInterface::TABLE_NAME, OrderInterface::ID);
    }
}
