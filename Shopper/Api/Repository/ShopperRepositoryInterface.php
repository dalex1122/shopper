<?php

namespace Alexsample\Shopper\Api\Repository;

use Magento\Framework\DataObject;
use Alexsample\Shopper\Api\Data\ShopperInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface ShopperRepositoryInterface
{
    /**
     * @return ShopperInterface
     */
    public function create();

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magento\Framework\Api\SearchCriteriaInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * @param int $id
     * @return ShopperInterface|DataObject|false
     */
    public function get($id);

    /**
     * @param ShopperInterface $model
     * @return ShopperInterface
     */
    public function save(ShopperInterface $model);

    /**
     * @param ShopperInterface $model
     * @return bool
     */
    public function delete(ShopperInterface $model);

    /**
     * @param ShopperInterface $shopper
     * @return string
     */
    public function createNewShopper(ShopperInterface $shopper);

    /**
     * @param ShopperInterface $shopper
     * @return string
     */
    public function updateShopper(ShopperInterface $shopper);

    /**
     * @param int $id
     * @return array
     */
    public function getShopperById(int $id);
}