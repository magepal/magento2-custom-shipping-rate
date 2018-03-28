<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\CustomShippingRate\Plugin\Quote\Address\Total;

class ShippingPlugin
{

    /**
     * @var \MagePal\CustomShippingRate\Helper\Data
     */
    protected $_customShippingRateHelper;

    /**
     * @param \Magento\Quote\Model\Quote
     */
    protected $_quote;

    /**
     * @param \MagePal\CustomShippingRate\Helper\Data $customShippingRateHelper
     */
    public function __construct(
        \MagePal\CustomShippingRate\Helper\Data $customShippingRateHelper
    ) {
        $this->_customShippingRateHelper = $customShippingRateHelper;
    }

    /**
     * @param \Magento\Quote\Model\Quote\Address\Total\Shipping $subject
     * @param callable $proceed
     * @param \Magento\Quote\Model\Quote $quote
     * @param \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment
     * @param \Magento\Quote\Model\Quote\Address\Total $total
     * @return mixed
     */
    public function aroundCollect(
        \Magento\Quote\Model\Quote\Address\Total\Shipping $subject,
        callable $proceed,
        \Magento\Quote\Model\Quote $quote,
        \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment,
        \Magento\Quote\Model\Quote\Address\Total $total
    ) {
        $returnValue = $proceed($quote, $shippingAssignment, $total);

        if (!$this->_customShippingRateHelper->isEnabled()) {
            return $returnValue;
        }

        $this->setQuote($quote);

        $address = $shippingAssignment->getShipping()->getAddress();
        $method = $shippingAssignment->getShipping()->getMethod();

        if (strpos($method, \MagePal\CustomShippingRate\Model\Carrier::CODE) !== false) {
            $customOption = $this->getCustomShippingJsonToArray($method);

            if ($customOption && strpos($method, $customOption['code']) !== false) {
                foreach ($address->getAllShippingRates() as $rate) {
                    if ($rate->getCode() == $customOption['code']) {
                        $cost = $customOption['rate'];

                        $rate->setPrice($cost);
                        //$rate->setMethodTitle($customOption['type']);

                        $address->setShippingMethod($customOption['code']);
                        $address->setShippingAmount($cost);
                        $address->setBaseShippingAmount($cost);
                        $address->setShippingDescription($rate->getCarrierTitle() . ' - ' . $rate->getMethodTitle());
                        $total->setShippingAmount($cost);
                        $total->setBaseShippingAmount($cost);

                        break;
                    }
                }
            }
        }

        return $returnValue;
    }

    /**
     * @param $json
     * @return array|bool
     */
    private function getCustomShippingJsonToArray($json)
    {
        $customOption = [
            'code' => '',
            'rate' => 0,
            'type' => ''
        ];

        $jsonToArray = (array)json_decode($json, true);

        if (!$json || count($jsonToArray) != 3) {
            $json = $this->getQuote()->getCustomShippingRateJson();

            if ($json) {
                $jsonToArray = (array)json_decode($json, true);
            }
        }

        if (is_array($jsonToArray) && count($jsonToArray) == 3) {
            foreach ($jsonToArray as $key => $value) {
                $customOption[$key] = $value;
            }

            $this->getQuote()->setCustomShippingRateJson($json);
            return $customOption;
        }

        return false;
    }

    /**
     * @param mixed $quote
     * @return ShippingPlugin
     */
    public function setQuote($quote)
    {
        $this->_quote = $quote;
        return $this;
    }

    /**
     * @return \Magento\Quote\Model\Quote
     */
    public function getQuote()
    {
        return $this->_quote;
    }
}
