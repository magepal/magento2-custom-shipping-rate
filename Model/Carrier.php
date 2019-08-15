<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\CustomShippingRate\Model;

use Magento\Backend\App\Area\FrontNameResolver;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\State;
use Magento\Framework\Exception\LocalizedException;
use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory;
use Magento\Quote\Model\Quote\Address\RateResult\MethodFactory;
use Magento\Shipping\Helper\Carrier as ShippingCarrierHelper;
use Magento\Shipping\Model\Carrier\AbstractCarrier;
use Magento\Shipping\Model\Carrier\CarrierInterface;
use Magento\Shipping\Model\Rate\Result;
use Magento\Shipping\Model\Rate\ResultFactory;
use MagePal\CustomShippingRate\Helper\Data;
use Psr\Log\LoggerInterface;

/**
 * Class Carrier
 * @package MagePal\CustomShippingRate\Model
 */
class Carrier extends AbstractCarrier implements CarrierInterface
{
    /**
     * Code of the carrier
     *
     * @var string
     */
    const CODE = 'customshippingrate';

    /**
     * Code of the carrier
     *
     * @var string
     */
    protected $_code = self::CODE;

    /**
     *
     * @var MethodFactory
     */
    protected $_rateMethodFactory;

    /**
     * Carrier helper
     *
     * @var ShippingCarrierHelper
     */
    protected $_carrierHelper;

    /**
     * @var CollectionFactory
     */
    protected $_rateFactory;

    /**
     * @var State
     */
    protected $_state;

    /**
     * @var Data
     */
    protected $_customShippingRateHelper;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param ErrorFactory $rateErrorFactory
     * @param LoggerInterface $logger
     * @param ResultFactory $rateFactory
     * @param ShippingCarrierHelper $carrierHelper
     * @param MethodFactory $rateMethodFactory
     * @param State $state
     * @param Data $customShippingRateHelper
     * @param array $data
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        ErrorFactory $rateErrorFactory,
        LoggerInterface $logger,
        ResultFactory $rateFactory,
        ShippingCarrierHelper $carrierHelper,
        MethodFactory $rateMethodFactory,
        State $state,
        Data $customShippingRateHelper,
        array $data = []
    ) {
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);
        $this->_scopeConfig = $scopeConfig;
        $this->_rateErrorFactory = $rateErrorFactory;
        $this->_logger = $logger;
        $this->_rateFactory = $rateFactory;
        $this->_carrierHelper = $carrierHelper;
        $this->_rateMethodFactory = $rateMethodFactory;
        $this->_state = $state;
        $this->_customShippingRateHelper = $customShippingRateHelper;
    }

    /**
     * Collect and get rates
     *
     * @param RateRequest $request
     * @return Collection|Result
     * @throws LocalizedException
     */
    public function collectRates(RateRequest $request)
    {
        $result = $this->_rateFactory->create();

        if (!$this->getConfigFlag('active') || (!$this->isAdmin() && $this->hideShippingMethodOnFrontend())) {
            return $result;
        }

        foreach ($this->_customShippingRateHelper->getShippingType() as $shippingType) {
            $rate = $this->_rateMethodFactory->create();
            $rate->setCarrier($this->_code);
            $rate->setCarrierTitle($this->getConfigData('title'));
            $rate->setMethod($shippingType['code']);
            $rate->setMethodTitle($shippingType['title']);
            $rate->setCost($shippingType['price']);
            $rate->setPrice($shippingType['price']);

            $result->append($rate);
        }

        return $result;
    }

    /**
     * Get allowed shipping methods
     *
     * @return array
     */
    public function getAllowedMethods()
    {
        $result = [];
        foreach ($this->_customShippingRateHelper->getShippingType() as $shippingType) {
            $result[$shippingType['code']] = $shippingType['title'];
        }
        return $result;
    }

    /**
     * @return bool
     */
    public function isTrackingAvailable()
    {
        return false;
    }

    /**
     * @return bool
     * @throws LocalizedException
     */
    protected function hideShippingMethodOnFrontend()
    {
        return !$this->getConfigFlag('show_on_frontend');
    }

    /**
     * @return bool
     * @throws LocalizedException
     */
    protected function isAdmin()
    {
        return $this->_state->getAreaCode() == FrontNameResolver::AREA_CODE;
    }
}
