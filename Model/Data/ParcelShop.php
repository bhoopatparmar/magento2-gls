<?php

namespace Salecto\GLS\Model\Data;

use Magento\Framework\DataObject;
use Salecto\GLS\Api\Data\ParcelShopInterface;

class ParcelShop extends DataObject implements ParcelShopInterface
{
    /**
     * @inheritDoc
     */
    public function getNumber()
    {
        return $this->getData(static::NUMBER);
    }

    /**
     * @inheritDoc
     */
    public function setNumber($string): \Salecto\Shipping\Api\Data\ParcelShopInterface
    {
        return $this->setData(static::NUMBER, $string);
    }

    /**
     * @inheritDoc
     */
    public function getCompanyName()
    {
        return $this->getData(static::COMPANY_NAME);
    }

    /**
     * @inheritDoc
     */
    public function setCompanyName($string): \Salecto\Shipping\Api\Data\ParcelShopInterface
    {
        return $this->setData(static::COMPANY_NAME, $string);
    }

    /**
     * @inheritDoc
     */
    public function getStreetName()
    {
        return $this->getData(static::STREET_NAME);
    }

    /**
     * @inheritDoc
     */
    public function setStreetName($string): \Salecto\Shipping\Api\Data\ParcelShopInterface
    {
        return $this->setData(static::STREET_NAME, $string);
    }

    /**
     * @inheritDoc
     */
    public function getZipCode()
    {
        return $this->getData(static::ZIP_CODE);
    }

    /**
     * @inheritDoc
     */
    public function setZipCode($string): \Salecto\Shipping\Api\Data\ParcelShopInterface
    {
        return $this->setData(static::ZIP_CODE, $string);
    }

    /**
     * @inheritDoc
     */
    public function getCity()
    {
        return $this->getData(static::CITY);
    }

    /**
     * @inheritDoc
     */
    public function setCity($string): \Salecto\Shipping\Api\Data\ParcelShopInterface
    {
        return $this->setData(static::CITY, $string);
    }

    /**
     * @inheritDoc
     */
    public function getCountryCode()
    {
        return $this->getData(static::COUNTRY_CODE_ISO);
    }

    /**
     * @inheritDoc
     */
    public function setCountryCode($string): \Salecto\Shipping\Api\Data\ParcelShopInterface
    {
        return $this->setData(static::COUNTRY_CODE_ISO, $string);
    }

    /**
     * @inheritDoc
     */
    public function getLongitude()
    {
        return $this->getData(static::LONGITUDE);
    }

    /**
     * @inheritDoc
     */
    public function setLongitude($string): \Salecto\Shipping\Api\Data\ParcelShopInterface
    {
        return $this->setData(static::LONGITUDE, $string);
    }

    /**
     * @inheritDoc
     */
    public function getLatitude()
    {
        return $this->getData(static::LATITUDE);
    }

    /**
     * @inheritDoc
     */
    public function setLatitude($string): \Salecto\Shipping\Api\Data\ParcelShopInterface
    {
        return $this->setData(static::LATITUDE, $string);
    }

    /**
     * @inheritDoc
     */
    public function getOpeningHours()
    {
        return $this->getData(static::OPENING_HOURS);
    }

    /**
     * @inheritDoc
     */
    public function setOpeningHours($string): \Salecto\Shipping\Api\Data\ParcelShopInterface
    {
        return $this->setData(static::OPENING_HOURS, $string);
    }
}
