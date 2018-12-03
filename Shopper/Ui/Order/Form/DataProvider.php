<?php

namespace Alexsample\Shopper\Ui\Order\Form;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Alexsample\Shopper\Model\ResourceModel\Order\CollectionFactory;

class DataProvider extends AbstractDataProvider
{
    public function __construct(
        CollectionFactory $collectionFactory,
        $name,
        $primaryFieldName,
        $requestFieldName,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        $result = [];

        foreach ($this->collection->getItems() as $item) {
            $data = $item->getData();
            $result[$item->getId()] = $data;
        }

        return $result;
    }
}
