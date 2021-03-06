<?php

namespace Prince\Extrafee\Model\Calculation\Calculator;

use Magento\Quote\Model\Quote;

class PerItemCalculator extends AbstractCalculator
{
    /**
     * {@inheritdoc}
     */
    public function calculate(Quote $quote)
    {
        $fee = $this->_helper->getExtraFee();
        return $fee * $quote->getItemsQty();
    }
}