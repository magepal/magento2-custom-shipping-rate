<?php
/**
 * Copyright © 2017 MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace MagePal\CustomShippingRate\Block\Adminhtml\Order\Create\Shipping\Method;


class Form extends \Magento\Sales\Block\Adminhtml\Order\Create\Shipping\Method\Form
{

    /**
     * Custom shipping rate
     *
     * @return string
     */
    public function getActiveCustomShippingRateMethod(){
        $rate = $this->getActiveMethodRate();
        return $rate && $rate->getCarrier() == \MagePal\CustomShippingRate\Model\Carrier::CODE ? $rate->getMethod() : '';
    }

    /**
     * Custom shipping rate
     *
     * @return string
     */
    public function getActiveCustomShippingRatePrice(){
        $rate = $this->getActiveMethodRate();
        return $this->getActiveCustomShippingRateMethod() && $rate->getPrice() ? $rate->getPrice() * 1 : '';
    }


    /**
     * Custom shipping rate
     *
     * @return string
     */
    public function isCustomShippingRateActive(){
        $rate = $this->getActiveMethodRate();
        return $rate && $rate->getCarrier() == \MagePal\CustomShippingRate\Model\Carrier::CODE ? true : false;
    }

}