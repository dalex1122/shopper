<?php

namespace Alexsample\Shopper\Model;

use Magento\Framework\Model\AbstractModel;
use Alexsample\Shopper\Api\Data\OrderInterface;

class Order extends AbstractModel implements OrderInterface
{

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Alexsample\Shopper\Model\ResourceModel\Order::class);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * {@inheritdoc}
     */
    public function getOrderId()
    {
        return $this->getData(self::ORDER_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setOrderId($value)
    {
        return $this->setData(self::ORDER_ID, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getShopperId()
    {
        return $this->getData(self::SHOPPER_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setShopperId($value)
    {
        return $this->setData(self::SHOPPER_ID, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getOrderTotal()
    {
        return $this->getData(self::ORDER_TOTAL);
    }

    /**
     * {@inheritdoc}
     */
    public function setOrderTotal($value)
    {
        return $this->setData(self::ORDER_TOTAL, $value);
    }
}