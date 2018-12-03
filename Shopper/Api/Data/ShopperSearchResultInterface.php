<?php
namespace Alexsample\Shopper\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface ShopperSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return \Alexsample\Shopper\Api\Data\ShopperInterface[]
     */
    public function getItems();

    /**
     * @param \Alexsample\Shopper\Api\Data\ShopperInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
