<?php

namespace Alexsample\Shopper\Model;

use Magento\Framework\Model\AbstractModel;
use Alexsample\Shopper\Api\Data\ShopperInterface;

class Shopper extends AbstractModel implements ShopperInterface
{

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Alexsample\Shopper\Model\ResourceModel\Shopper::class);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * @return int
     */
    public function getEmail()
    {
        return $this->getData(self::EMAIL);
    }

    /**
     * @param int $value
     * @return $this
     */
    public function setEmail($value)
    {
        return $this->setData(self::EMAIL, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * {@inheritdoc}
     */
    public function setName($value)
    {
        return $this->setData(self::NAME, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getLastName()
    {
        return $this->getData(self::LAST_NAME);
    }

    /**
     * {@inheritdoc}
     */
    public function setLastName($value)
    {
        return $this->setData(self::LAST_NAME, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getPhone()
    {
        return $this->getData(self::PHONE);
    }

    /**
     * {@inheritdoc}
     */
    public function setPhone($value)
    {
        return $this->setData(self::PHONE, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getCity()
    {
        return $this->getData(self::CITY);
    }

    /**
     * {@inheritdoc}
     */
    public function setCity($value)
    {
        return $this->setData(self::CITY, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getStreet()
    {
        return $this->getData(self::STREET);
    }

    /**
     * {@inheritdoc}
     */
    public function setStreet($value)
    {
        return $this->setData(self::STREET, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getHouseNumber()
    {
        return $this->getData(self::HOUSE_NUMBER);
    }

    /**
     * {@inheritdoc}
     */
    public function setHouseNumber($value)
    {
        return $this->setData(self::HOUSE_NUMBER, $value);
    }
}