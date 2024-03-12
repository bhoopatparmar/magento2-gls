<?php

namespace Salecto\GLS\Model\MethodType;

use Salecto\Shipping\Api\Carrier\MethodTypeHandlerInterface;
use Salecto\Shipping\Model\MethodType\AbstractParcelShop;

class ParcelShop extends AbstractParcelShop implements MethodTypeHandlerInterface
{
    /**
     * @return string
     */
    public function getTitle(): string
    {
        return __('Parcel Shop');
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return 'parcelshop';
    }
}
