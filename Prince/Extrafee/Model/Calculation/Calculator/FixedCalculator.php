<?php

namespace Prince\Extrafee\Model\Calculation\Calculator;

use Magento\Quote\Model\Quote;

class FixedCalculator extends AbstractCalculator
{
    /**
     * {@inheritdoc}
     */
    public function calculate(Quote $quote)
    {
        return $this->_helper->getExtraFee();
    }
}