<?php

namespace Alexsample\Shopper\Api\Repository;

use Magento\Framework\DataObject;
use Alexsample\Shopper\Api\Data\OrderInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface OrderRepositoryInterface
{
    /**
     * @return OrderInterface
     */
    public function create();

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magento\Framework\Api\SearchCriteriaInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * @param int $id
     * @return OrderInterface|DataObject|false
     */
    public function get($id);

    /**
     * @param OrderInterface $model
     * @return OrderInterface
     */
    public function save(OrderInterface $model);

    /**
     * @param OrderInterface $model
     * @return bool
     */
    public function delete(OrderInterface $model);

    /**
     * @param OrderInterface $order
     * @param string $token
     * @return string
     */
    public function createNewOrder(OrderInterface $order, $token);

    /**
     * @param int $id
     * @return array
     */
    public function getOrders(int $id);
}