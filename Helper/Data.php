<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\CustomShippingRate\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected $codes = [
        'code' => [
            'label' => 'Code',
            'class' => 'validate-no-empty validate-data',
            'default' => ''
        ],
        'title' => [
            'label' => 'Title',
            'class' => 'validate-no-empty',
            'default' => ''
        ],
        'price' => [
            'label' => 'Price',
            'class' => 'validate-no-empty greater-than-equals-to-0',
            'default' => ''
        ],
        'sort_order' => [
            'label' => 'Admin Sort',
            'class' => 'validate-no-empty greater-than-equals-to-0',
            'default' => 99
        ]
    ];

    protected $headerTemplate;

    /**
     * @return array|mixed
     */
    public function getShippingType()
    {
        $arrayValues = [];
        $configData = $this->getConfigData('shipping_type');

        if (is_string($configData) && !empty($configData) && $configData !== '[]') {
            if ($this->isJson($configData)) {
                $arrayValues = (array) json_decode($configData, true);
            } else {
                $arrayValues = (array) array_values(unserialize($configData));
            }
        }

        $arrayValues = $this->shippingArrayObject($arrayValues);

        usort($arrayValues, function ($a, $b) {
            if (array_key_exists('sort_order', $a)) {
                return $a['sort_order'] - $b['sort_order'];
            } else {
                return 0;
            }
        });

        return $arrayValues;
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

    public function getHeaderTemplate()
    {
        if (!$this->headerTemplate) {
            $this->headerTemplate = [];

            foreach ($this->getHeaderColumns() as $key => $column) {
                $this->headerTemplate[$key] = $column['default'];
            }
        }

        return $this->headerTemplate;
    }

    /**
     * @return array
     */
    public function getHeaderColumns()
    {
        return $this->codes;
    }

    /**
     * @param $values
     * @return mixed
     */
    public function shippingArrayObject($values)
    {
        //fix existing options
        $requiredFields = $this->getHeaderTemplate();

        if (is_array($values)) {
            foreach ($values as $key => &$row) {
                $row = array_merge($requiredFields, $row);
            }
        }

        return $values;
    }
}
