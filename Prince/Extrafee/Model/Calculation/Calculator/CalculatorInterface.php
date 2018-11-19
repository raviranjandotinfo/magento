<?php
namespace Prince\Extrafee\Model\Calculation\Calculator;

use Magento\Quote\Model\Quote;

interface CalculatorInterface
{
    /**
     * Calculate fee for quote
     *
     * @param Quote $quote
     * @return float
     */
    public function calculate(Quote $quote);
}