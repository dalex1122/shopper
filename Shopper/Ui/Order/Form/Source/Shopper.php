<?php

namespace Alexsample\Shopper\Ui\Order\Form\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Alexsample\Shopper\Api\Data\ShopperInterface;

class Shopper implements OptionSourceInterface
{
    /**
     * @var array
     */
    protected $options;


    public function __construct(ShopperInterface $shopper)
    {
        $this->shopper = $shopper;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        if ($this->options !== null) {
            return $this->options;
        }

        $collection = $this->shopper->getCollection();
        $options = [];
        foreach ($collection as $item) {
            $options[] = [
                        'label' => $item->getName()
                            . ' ' . $item->getLastName()
                            . ' (ID: ' . $item->getId() . ')',
                        'value' => $item->getId(),
                    ];
        }

//        $nonEscapableNbspChar = html_entity_decode('&#160;', ENT_NOQUOTES, 'UTF-8');
//
//        $websiteCollection = $this->storeManager->getWebsites();
//        $groupCollection = $this->loadGroupCollection();
//        $stores = $this->storeManager->getStores();
//
//        foreach ($websiteCollection as $website) {
//            $websiteShow = false;
//            foreach ($groupCollection as $group) {
//                if ($website->getId() != $group->getWebsiteId()) {
//                    continue;
//                }
//                $groupShow = false;
//                foreach ($stores as $store) {
//                    if ($group->getId() != $store->getGroupId()) {
//                        continue;
//                    }
//                    if (!$websiteShow) {
//                        $options[] = ['label' => $website->getName(), 'value' => []];
//                        $websiteShow = true;
//                    }
//                    if (!$groupShow) {
//                        $groupShow = true;
//                        $values = [];
//                    }
//                    $values[] = [
//                        'label' => str_repeat($nonEscapableNbspChar, 4) . $store->getName(),
//                        'value' => $store->getId(),
//                    ];
//                }
//                if ($groupShow) {
//                    $options[] = [
//                        'label' => str_repeat($nonEscapableNbspChar, 4) . $group->getName(),
//                        'value' => $values,
//                    ];
//                }
//            }
//        }
//
        $this->options = $options;

        return $this->options;
    }

    /**
     * @return array
     */
//    protected function loadGroupCollection()
//    {
//        $groupCollection = [];
//        foreach ($this->storeManager->getWebsites() as $website) {
//            foreach ($website->getGroups() as $group) {
//                $groupCollection[$group->getId()] = $group;
//            }
//        }
//        return $groupCollection;
//    }
}
