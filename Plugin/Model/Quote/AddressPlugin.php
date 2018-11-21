<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\CustomShippingRate\Plugin\Model\Quote;

class AddressPlugin
{

    /**
     * @param \Magento\Quote\Api\Data\AddressInterface $subject
     * @param callable $proceed
     * @return mixed
     */
    public function aroundCollectShippingRates(\Magento\Quote\Api\Data\AddressInterface $subject, callable $proceed)
    {
        $price = null;
        $description = null;

        //get custom shipping rate set by admin
        foreach ($subject->getAllShippingRates() as $rate) {
            if ($rate->getCode() == $subject->getShippingMethod()) {
                $price = $rate->getPrice();
                $description = $rate->getMethodTitle();
                break;
            }
        }

        $return = $proceed();

        if ($price !== null) {
            //reset custom shipping rate
            foreach ($subject->getAllShippingRates() as $rate) {
                if ($rate->getCode() == $subject->getShippingMethod()) {
                    $rate->setPrice($price);
                    $rate->setCost($price);
                    $rate->setMethodTitle($description);
                    break;
                }
            }
        }

        return $return;
    }
}