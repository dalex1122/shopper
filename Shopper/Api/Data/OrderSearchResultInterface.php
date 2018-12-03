<?php
namespace Alexsample\Shopper\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface OrderSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return \Alexsample\Shopper\Api\Data\OrderInterface[]
     */
    public function getItems();

    /**
     * @param \Alexsample\Shopper\Api\Data\OrderInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
