<?php

namespace Salecto\GLS\Model\Carrier;

use Exception;
use Magento\Framework\App\Area;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Asset\Repository;
use Magento\Quote\Api\Data\ShippingMethodInterface;
use Magento\Quote\Model\Quote\Address\Rate;
use Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory;
use Magento\Quote\Model\Quote\Address\RateResult\MethodFactory;
use Magento\Shipping\Model\Rate\ResultFactory;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;
use Salecto\GLS\Api\Carrier\GLSInterface;
use Salecto\GLS\Api\Data\ParcelShopInterface;
use Salecto\GLS\Model\Api;
use Salecto\Shipping\Api\Carrier\MethodTypeHandlerInterface;
use Salecto\Shipping\Model\Carrier\AbstractCarrier;
use Salecto\Shipping\Model\RateManagement;

class GLS extends AbstractCarrier implements GLSInterface
{
    public $_code = self::TYPE_NAME;

    /**
     * @var Api
     */
    private $glsApi;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param ErrorFactory $rateErrorFactory
     * @param LoggerInterface $logger
     * @param RateManagement $rateManagement
     * @param MethodFactory $methodFactory
     * @param ResultFactory $resultFactory
     * @param Api $glsApi
     * @param Repository $assetRepository
     * @param StoreManagerInterface $storeManager
     * @param MethodTypeHandlerInterface|null $defaultMethodTypeHandler
     * @param array $methodTypeHandlers
     * @param array $data
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        ErrorFactory $rateErrorFactory,
        LoggerInterface $logger,
        RateManagement $rateManagement,
        MethodFactory $methodFactory,
        ResultFactory $resultFactory,
        Api $glsApi,
        Repository $assetRepository,
        StoreManagerInterface $storeManager,
        MethodTypeHandlerInterface $defaultMethodTypeHandler = null,
        array $methodTypeHandlers = [],
        array $data = []
    ) {
        $this->glsApi = $glsApi;
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $rateManagement, $methodFactory, $resultFactory, $assetRepository, $storeManager, $defaultMethodTypeHandler, $methodTypeHandlers, $data);
    }

    /**
     * Type name that links to the Rate model
     *
     * @return string
     */
    function getTypeName(): string
    {
        return static::TYPE_NAME;
    }

    /**
     * @param string $country
     * @param string|null $postcode
     * @param int $amount
     * @return ParcelShopInterface[]
     */
    public function getParcelShops($country, $postcode = null, $amount = 30)
    {
        if (empty($postcode)) {
            return [];
        }
        try {
            $parcelShops = $this->glsApi->getParcelShops($country, $postcode, $amount);
        } catch (Exception $e) {
            return [];
        }

        if (empty($parcelShops) || !$parcelShops) {
            return [];
        }

        return $parcelShops;
    }

    /**
     * @param ShippingMethodInterface $shippingMethod
     * @param Rate $rate
     * @param string|null $typeHandler
     * @return mixed
     */
    public function getImageUrl(ShippingMethodInterface $shippingMethod, Rate $rate, $typeHandler)
    {
        return $this->assetRepository->createAsset('Salecto_GLS::images/gls.svg', [
            'area' => Area::AREA_FRONTEND
        ])->getUrl();
    }
}
