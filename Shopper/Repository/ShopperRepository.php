<?php

namespace Alexsample\Shopper\Repository;

use Alexsample\Shopper\Api\Data\ShopperInterface;
use Alexsample\Shopper\Api\Data\ShopperInterfaceFactory;
use Alexsample\Shopper\Api\Repository\ShopperRepositoryInterface;
use Alexsample\Shopper\Model\ResourceModel\Shopper\CollectionFactory;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Alexsample\Shopper\Model\ResourceModel\Shopper as ShopperResource;
use Alexsample\Shopper\Api\Data\ShopperSearchResultInterfaceFactory;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;

class ShopperRepository implements ShopperRepositoryInterface
{
    /**
     * @var ShopperInterfaceFactory
     */
    private $factory;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var ShopperResource
     */
    private $shopperResource;

    /**
     * @var ShopperSearchResultInterfaceFactory
     */
    private $shopperSearchResultFactory;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    public function __construct(
        ShopperInterfaceFactory $factory,
        CollectionFactory $collectionFactory,
        ShopperResource $shopperResource,
        ShopperSearchResultInterfaceFactory $shopperSearchResultFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->factory = $factory;
        $this->collectionFactory = $collectionFactory;
        $this->shopperResource = $shopperResource;
        $this->shopperSearchResultFactory = $shopperSearchResultFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function create()
    {
        return $this->factory->create();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->collectionFactory->create();
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }

        $searchResult = $this->shopperSearchResultFactory->create();
        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());
        return $searchResult;
    }

    /**
     * {@inheritdoc}
     */
    public function get($id)
    {
        $model = $this->create();

        $this->shopperResource->load($model, $id);

        if (!$model->getId()) {
            throw new NoSuchEntityException(__('Requested shopper doesn\'t exist'));
        }

        return $model->getId() ? $model : false;
    }

    /**
     * {@inheritdoc}
     */
    public function save(ShopperInterface $model)
    {
        try {
            $this->shopperResource->save($model);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__('Unable to save shopper #%1', $model->getId()));
        }

        return $model;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(ShopperInterface $model)
    {
        try {
            $this->shopperResource->delete($model);
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__('Unable to remove shopper #%1', $model->getId()));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function createNewShopper(ShopperInterface $shopper)
    {
        try {
            $result = $this->save($shopper);
            return $result->getId();
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__('Can\'t save: ',
                    $e->getMessage(),
                    $e->getCode()
                )
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function updateShopper(ShopperInterface $shopper)
    {
        $firstItem = $this->create()->getCollection()
            ->addFieldToFilter(ShopperInterface::EMAIL, $shopper->getEmail())
            ->getFirstItem();

        if ($id = $firstItem->getId()) {
            $model = $this->get($id);
            $shopper->setData(ShopperInterface::ID, $model->getShopperId());
            $model->setData($shopper->getData());
            try {
                $result = $this->save($shopper);
                return $result->getId();
            } catch (\Exception $e) {
                throw new CouldNotSaveException(__('Can\'t update: ',
                        $e->getMessage(),
                        $e->getCode()
                    )
                );
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getShopperById(int $id) {
        if ($shopper = $this->get($id)) {
            return $shopper->getData();
        } else {
            throw new NoSuchEntityException(__('Can\'t find such shopper'));
        }
    }
}