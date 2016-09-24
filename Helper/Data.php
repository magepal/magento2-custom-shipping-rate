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

    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager;


    /**
     * Core store config
     *
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;


    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\ObjectManagerInterface
     */

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    )
    {
        $this->_scopeConfig = $scopeConfig;
        $this->_objectManager = $objectManager;
        parent::__construct($context);
    }


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

        return $this->_scopeConfig->getValue(
            $path,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }


}