<?php

namespace Prince\Extrafee\Model;

use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Checkout\Model\Session;
use Prince\Extrafee\Helper\Data as FeeHelper;
use Prince\Extrafee\Model\Calculation\Calculator\CalculatorInterface;

/**
 * Class ExtraFeeConfigProvider
 * @package Prince\Extrafee\Model
 */
class ExtraFeeConfigProvider implements ConfigProviderInterface
{
    /**
     * @var FeeHelper
     */
    protected $helper;

    /**
     * @var Session
     */
    protected $checkoutSession;

    /**
     * @var CalculatorInterface
     */
    protected $calculator;

    /**
     * @param FeeHelper $helper
     * @param Session $checkoutSession
     * @param CalculatorInterface $calculator
     */
    public function __construct(FeeHelper $helper, Session $checkoutSession, CalculatorInterface $calculator) {
        $this->helper = $helper;
        $this->checkoutSession = $checkoutSession;
        $this->calculator = $calculator;
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        $extraFeeConfig = [];
        $quote = $this->checkoutSession->getQuote();
        $fee = $this->calculator->calculate($quote);

        $extraFeeConfig['fee_title'] = $this->helper->getTitle();
        $extraFeeConfig['extra_fee_amount'] = $fee;
        $extraFeeConfig['show_hide_extrafee'] = $fee > 0.0;
        return $extraFeeConfig;
    }
}
