<?php
/**
 * Copyright © 2016 MagePal. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace MagePal\CustomShippingRate\Block\Adminhtml\System\Config\Form\Field;
use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
/**
 * Class Locations Backend system config array field renderer
 */
class ShippingList extends AbstractFieldArray
{
    /**
     * Initialise columns for 'Store Locations'
     * Label is name of field
     * Class is storefront validation action for field
     *
     * @return void
     */
    protected function _construct()
    {
        $this->addColumn(
            'code',
            [
                'label' => __('Code'),
                'class' => 'validate-no-empty validate-alphanum'
            ]
        );
        $this->addColumn(
            'title',
            [
                'label' => __('Title'),
                'class' => 'validate-no-empty'
            ]
        );
        $this->addColumn(
            'price',
            [
                'label' => __('Price'),
                'class' => 'validate-no-empty'
            ]
        );
        $this->_addAfter = false;
        parent::_construct();
    }
}
