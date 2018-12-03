<?php

namespace Alexsample\Shopper\Model\ResourceModel\Order;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Alexsample\Shopper\Api\Data\OrderInterface;

class Collection extends AbstractCollection
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Alexsample\Shopper\Model\Order::class,
            \Alexsample\Shopper\Model\ResourceModel\Order::class
        );

        $this->_idFieldName = OrderInterface::ID;
    }
}
