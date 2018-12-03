<?php

namespace Alexsample\Shopper\Repository;

use Alexsample\Shopper\Api\Data\OrderInterface;
use Alexsample\Shopper\Api\Data\OrderInterfaceFactory;
use Alexsample\Shopper\Api\Repository\OrderRepositoryInterface;
use Alexsample\Shopper\Model\ResourceModel\Order\CollectionFactory;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Alexsample\Shopper\Api\Service\TokenServiceInterface;
use Alexsample\Shopper\Model\ResourceModel\Order as OrderResource;
use Alexsample\Shopper\Api\Data\OrderSearchResultInterfaceFactory;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Alexsample\Shopper\Api\Repository\ShopperRepositoryInterface;
use Alexsample\Shopper\Api\Data\ShopperInterface;

class OrderRepository implements OrderRepositoryInterface
{
    /**
     * @var OrderInterfaceFactory
     */
    private $factory;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var OrderResource
     */
    private $orderResource;

    /**
     * @var OrderSearchResultInterfaceFactory
     */
    private $orderSearchResultFactory;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var TokenServiceInterface
     */
    private $tokenService;

    public function __construct(
        OrderInterfaceFactory $factory,
        CollectionFactory $collectionFactory,
        OrderResource $orderResource,
        OrderSearchResultInterfaceFactory $orderSearchResultFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        ShopperRepositoryInterface $shopperRepository,
        TokenServiceInterface $tokenService
    ) {
        $this->factory = $factory;
        $this->collectionFactory = $collectionFactory;
        $this->orderResource = $orderResource;
        $this->orderSearchResultFactory = $orderSearchResultFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->shopperRepository = $shopperRepository;
        $this->tokenService = $tokenService;
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

        $searchResult = $this->orderSearchResultFactory->create();
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

        $this->orderResource->load($model, $id);

        if (!$model->getId()) {
            throw new NoSuchEntityException(__('Requested order doesn\'t exist'));
        }

        return $model->getId() ? $model : false;
    }

    /**
     * {@inheritdoc}
     */
    public function save(OrderInterface $model)
    {
        try {
            $this->orderResource->save($model);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__('Unable to save order #%1', $model->getId()));
        }

        return $model;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(OrderInterface $model)
    {
        try {
            $this->orderResource->delete($model);
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__('Unable to remove order #%1', $model->getId()));
        }
    }


    /**
     * {@inheritdoc}
     */
    public function createNewOrder(OrderInterface $order, $token)
    {
        if ($token != $this->tokenService->getToken()) {
            throw new NoSuchEntityException(__('Incorrect token. Please create using '
            . '"php bin/magento alexsample:shopper --create-token"'));
        }

        $criteria = $this->searchCriteriaBuilder->addFilter(
            ShopperInterface::ID,
            $order->getShopperId(),
            'eq'
        )->create();
        $searchResult = $this->shopperRepository->getList($criteria);
        if ($searchResult->getTotalCount() == 0) {
            throw new NoSuchEntityException(__('Shopper with ID ' . $order->getShopperId() . ' doesn\'t exist.' ));
        }

        try {
            $result = $this->save($order);
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
    public function getOrders(int $id)
    {
        $criteria = $this->searchCriteriaBuilder->addFilter(
            OrderInterface::SHOPPER_ID,
            $id,
            'eq'
        )->create();
        $searchResult = $this->getList($criteria);

        $orders = [];
        foreach ($searchResult->getItems() as $item) {
            $orders[] = $item->getData();
        }

        return $orders;
    }
}