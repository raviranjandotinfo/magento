<?php
namespace Prince\Extrafee\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Data
 * @package Prince\Extrafee\Helper
 */
class Data extends AbstractHelper
{
    /**
     * @param $config
     * @return mixed
     */
    public function getConfig($config)
    {
        return $this->scopeConfig->getValue($config, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get module status
     *
     * @return bool
     */
    public function isEnable()
    {
        return (bool) $this->getConfig('extrafee/general/active');
    }

    /**
     * Get minimum order amount to add extrafee
     *
     * @return float
     */
    public function getMinOrderTotal()
    {
        return (float) $this->getConfig('extrafee/general/minorderamount');
    }

    /**
     * Get minimum order amount to add extrafee
     *
     * @return float
     */
    public function getMaxOrderTotal()
    {
        return (float) $this->getConfig('extrafee/general/maxorderamount');
    }

    /**
     * Get extrafee title
     *
     * @return string
     */
    public function getTitle()
    {
        return (string) $this->getConfig('extrafee/general/title');
    }

    /**
     * Get extrafee amount
     *
     * @return float
     */
    public function getExtraFee()
    {
        return (float) $this->getConfig('extrafee/general/price');
    }

    /**
     * Get extrafee price type
     *
     * @return int
     */
    public function getPriceType()
    {
        return (int) $this->getConfig('extrafee/general/pricetype');
    }

    /**
     * Get module status
     *
     * @return bool
     */
    public function isRefund()
    {
        return (bool) $this->getConfig('extrafee/general/refund');
    }
}