<?php

namespace Alexsample\Shopper\Api\Data;

interface OrderInterface
{
    const TABLE_NAME = 'alx_order';

    const ID = 'id';
    const ORDER_ID = 'order_id';
    const SHOPPER_ID = 'shopper_id';
    const ORDER_TOTAL = 'order_total';

    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getOrderId();

    /**
     * @param string $value
     * @return $this
     */
    public function setOrderId($value);

    /**
     * @return int
     */
    public function getShopperId();

    /**
     * @param int $value
     * @return $this
     */
    public function setShopperId($value);

    /**
     * @return float
     */
    public function getOrderTotal();

    /**
     * @param float $value
     * @return $this
     */
    public function setOrderTotal($value);
}