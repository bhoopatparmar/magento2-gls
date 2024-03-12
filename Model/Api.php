<?php

namespace Salecto\GLS\Model;

use Magento\Framework\Api\ObjectFactory;
use Magento\Framework\Api\SimpleDataObjectConverter;
use SoapClient;
use SoapFault;
use Salecto\GLS\Api\Data\ParcelShopInterface;

class Api
{
    const BASE_URL = 'http://www.gls.dk/webservices_v3/';

    /**
     * @var SimpleDataObjectConverter
     */
    private $simpleDataObjectConverter;

    /**
     * @var ObjectFactory
     */
    private $objectFactory;

    /**
     * @param SimpleDataObjectConverter $simpleDataObjectConverter
     * @param ObjectFactory $objectFactory
     */
    public function __construct(
        SimpleDataObjectConverter $simpleDataObjectConverter,
        ObjectFactory $objectFactory
    ) {
        $this->simpleDataObjectConverter = $simpleDataObjectConverter;
        $this->objectFactory = $objectFactory;
    }

    /**
     * @param string $countryCode
     * @param string $zipCode
     * @param int $amount
     * @return array|false
     * @throws SoapFault
     */
    public function getParcelShops($countryCode, $zipCode, $amount)
    {
        return $this->request('wsShopFinder.asmx', function (SoapClient $client) use ($countryCode, $zipCode, $amount) {
            return $client->SearchNearestParcelShops([
                'zipcode' => $zipCode,
                'countryIso3166A2' => $countryCode,
                'Amount' => min($amount, 100)
            ]);
        }, function ($response) {
            $response = $this->mapResponse($response, 'SearchNearestParcelShopsResult/parcelshops/PakkeshopData');
            if ($response) {
                return $this->mapParcelShops($response);
            }
            return false;
        });
    }

    /**
     * @param $path
     * @param callable $func
     * @param callable $transformer
     * @return mixed
     * @throws SoapFault
     */
    public function request($path, callable $func, callable $transformer = null)
    {
        $response = $func($this->getClient($path));

        if ($response) {
            return $transformer === null ? $response : $transformer($response);
        }

        return false;
    }

    /**
     * @param string $path
     * @return SoapClient
     * @throws SoapFault
     */
    public function getClient(string $path)
    {
        return new SoapClient(static::BASE_URL . $path . '?WSDL', [
            'trace' => 1,
            'encoding' => 'UTF-8'
        ]);
    }

    /**
     * @param $response
     * @param $keyPath
     * @return null
     */
    protected function mapResponse($response, string $keyPath)
    {
        if (is_object($response)) {
            $response = $this->simpleDataObjectConverter->convertStdObjectToArray($response);
        }
        $data = $response;
        foreach (explode('/', $keyPath) as $key) {
            if (is_array($data) && isset($data[$key])) {
                $data = $data[$key];
            } else {
                return null;
            }
        }
        return $data;
    }

    /**
     * @param $parcelShopData
     * @return array
     */
    protected function mapParcelShops($parcelShopData)
    {
        $parcelShops = $this->simpleDataObjectConverter->convertStdObjectToArray($parcelShopData);

        return array_map(function ($parcelShop) {
            $parcelShopData = [];

            foreach ($parcelShop as $key => $value) {
                $parcelShopData[SimpleDataObjectConverter::camelCaseToSnakeCase($key)] = $value;
            }

            return $this->objectFactory->create(ParcelShopInterface::class, [
                'data' => $parcelShopData
            ]);
        }, $parcelShops);
    }
}
