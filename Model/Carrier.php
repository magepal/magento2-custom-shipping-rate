<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace MagePal\CustomShippingRate\Model;

use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Shipping\Model\Carrier\AbstractCarrier;

class Carrier extends AbstractCarrier implements \Magento\Shipping\Model\Carrier\CarrierInterface
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
     * @var \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory
     */
    protected $_rateMethodFactory;

    /**
     * Carrier helper
     *
     * @var \Magento\Shipping\Helper\Carrier
     */
    protected $_carrierHelper;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    protected $_rateFactory;

    /**
     * @var \Magento\Framework\App\State
     */
    protected $_state;

    /**
     * @var \MagePal\CustomShippingRate\Helper\Data
     */
    protected $_customShippingRateHelper;

    /**
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param array $data
     * @param \Magento\Shipping\Model\Rate\ResultFactory $rateFactory
     * @param \Magento\Shipping\Helper\Carrier $carrierHelper
     * @param \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Shipping\Model\Rate\ResultFactory $rateFactory,
        \Magento\Shipping\Helper\Carrier $carrierHelper,
        \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory,
        \Magento\Framework\App\State $state,
        \MagePal\CustomShippingRate\Helper\Data $customShippingRateHelper,
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
     * @return \Magento\Quote\Model\Quote\Address\RateResult\Error|bool|Result
     */
    public function collectRates(RateRequest $request)
    {
        $result = $this->_rateFactory->create();

        if (!$this->getConfigFlag('active') || ($this->_state->getAreaCode() != \Magento\Backend\App\Area\FrontNameResolver::AREA_CODE && !$this->getConfigFlag('show_on_frontend'))) {
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
        return [$this->getCarrierCode() => __($this->getConfigData('name'))];
    }

    public function isTrackingAvailable()
    {
        return false;
    }
}
