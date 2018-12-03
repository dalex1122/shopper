<?php

namespace Alexsample\Shopper\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Alexsample\Shopper\Api\Data\ShopperInterface;

class Shopper extends AbstractDb
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ShopperInterface::TABLE_NAME, ShopperInterface::ID);
    }
}
