<?php
namespace Prince\Extrafee\Model\Calculation\Calculator;

use Magento\Quote\Model\Quote;

class PercentageCalculator extends AbstractCalculator
{
    /**
     * {@inheritdoc}
     */
    public function calculate(Quote $quote)
    {
        $fee = $this->_helper->getExtraFee();
        $subTotal = $quote->getSubtotal();
        return ($subTotal * $fee) / 100;
    }
}