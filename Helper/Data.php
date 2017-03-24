<?php
/**
 * MagePal_AdminSalesOrderViewButton Magento component
 *
 * @category    MagePal
 * @package     MagePal_AdminSalesOrderViewButton
 * @author      MagePal Team <info@magepal.com>
 * @copyright   MagePal (http://www.magepal.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace MagePal\CustomShippingRate\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    public function getShippingType(){
        $arrayValues = [];
        $configData = $this->getConfigData('shipping_type');
        if (is_string($configData) && !empty($configData)) {
            $arrayValues = array_values(unserialize($configData));
        }


        return $arrayValues;
    }


    /**
     * @return \Psr\Log\LoggerInterface
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


}