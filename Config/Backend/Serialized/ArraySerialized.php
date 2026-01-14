<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * https://www.magepal.com | support@magepal.com
 */

namespace MagePal\CustomShippingRate\Config\Backend\Serialized;

use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Magento\Framework\Serialize\Serializer\Json;
use MagePal\CustomShippingRate\Helper\Data;

/**
 * Class ArraySerialized
 * @package MagePal\CustomShippingRate\Config\Backend\Serialized
 */
class ArraySerialized extends \Magento\Config\Model\Config\Backend\Serialized\ArraySerialized
{
    /**
     * @var Data
     */
    protected $helper;

    /**
     * ArraySerialized constructor.
     * @param Context $context
     * @param Registry $registry
     * @param ScopeConfigInterface $config
     * @param TypeListInterface $cacheTypeList
     * @param Data $helperData
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     * @param Json|null $serializer
     */
    public function __construct(
        Context $context,
        Registry $registry,
        ScopeConfigInterface $config,
        TypeListInterface $cacheTypeList,
        Data $helperData,
        ?AbstractResource $resource = null,
        ?AbstractDb $resourceCollection = null,
        array $data = [],
        ?Json $serializer = null
    ) {
        parent::__construct(
            $context,
            $registry,
            $config,
            $cacheTypeList,
            $resource,
            $resourceCollection,
            $data,
            $serializer
        );

        $this->helper = $helperData;
    }

    /**
     * @return void
     */
    protected function _afterLoad()
    {
        parent::_afterLoad();

        $this->setValue($this->helper->shippingArrayObject($this->getValue()));
    }
}
