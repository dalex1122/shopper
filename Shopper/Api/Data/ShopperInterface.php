<?php

namespace Alexsample\Shopper\Api\Data;

interface ShopperInterface
{
    const TABLE_NAME = 'alx_shopper';

    const ID = 'shopper_id';
    const EMAIL = 'email';
    const NAME = 'name';
    const LAST_NAME = 'last_name';
    const PHONE = 'phone';
    const CITY = 'city';
    const STREET = 'street';
    const HOUSE_NUMBER = 'house_number';

    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @param string $value
     * @return $this
     */
    public function setEmail($value);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $value
     * @return $this
     */
    public function setName($value);

    /**
     * @return string
     */
    public function getLastName();

    /**
     * @param string $value
     * @return $this
     */
    public function setLastName($value);

    /**
     * @return string
     */
    public function getPhone();

    /**
     * @param string $value
     * @return $this
     */
    public function setPhone($value);

    /**
     * @return string
     */
    public function getCity();

    /**
     * @param string $value
     * @return $this
     */
    public function setCity($value);

    /**
     * @return string
     */
    public function getStreet();

    /**
     * @param string $value
     * @return $this
     */
    public function setStreet($value);

    /**
     * @return string
     */
    public function getHouseNumber();

    /**
     * @param string $value
     * @return $this
     */
    public function setHouseNumber($value);
}