<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace MagePal\CustomShippingRate\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    public function getShippingType()
    {
        $arrayValues = [];
        $configData = $this->getConfigData('shipping_type');

        if (is_string($configData) && !empty($configData) && $configData !== '[]') {
            if ($this->isJson($configData)) {
                $arrayValues = json_decode($configData, true);
            } else {
                $arrayValues = array_values(unserialize($configData));
            }
        }

        return (array)$arrayValues;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return (bool)$this->getConfigData('active');
    }

    /**
     * Retrieve information from carrier configuration
     *
     * @param   string $field
     * @return  void|false|string
     */
    public function getConfigData($field)
    {
        $code = \MagePal\CustomShippingRate\Model\Carrier::CODE;
        if (empty($code)) {
            return false;
        }

        $path = 'carriers/' . $code . '/' . $field;

        return $this->scopeConfig->getValue(
            $path,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Magento 2.2 return json instead of serialize array
     *
     * @param   string $string
     * @return  bool
     */
    public function isJson($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}
