<?php

namespace Salecto\GLS\Api\Carrier;

use Salecto\Shipping\Api\Carrier\CarrierInterface;

interface GLSInterface extends CarrierInterface
{
    const TYPE_NAME = 'gls';

    /**
     * @param string $country
     * @param string|null $postcode
     * @param int $amount
     * @return \Salecto\GLS\Api\Data\ParcelShopInterface[]
     */
    public function getParcelShops($country, $postcode = null, $amount = 30);
}
