<?php

namespace Alexsample\Shopper\Model\ResourceModel\Shopper;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Alexsample\Shopper\Api\Data\ShopperInterface;

class Collection extends AbstractCollection
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Alexsample\Shopper\Model\Shopper::class,
            \Alexsample\Shopper\Model\ResourceModel\Shopper::class
        );

        $this->_idFieldName = ShopperInterface::ID;
    }
}
