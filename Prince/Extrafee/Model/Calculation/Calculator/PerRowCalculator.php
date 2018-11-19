<?php
namespace Prince\Extrafee\Model\Calculation\Calculator;

use Magento\Quote\Model\Quote;

class PerRowCalculator extends AbstractCalculator
{
    /**
     * {@inheritdoc}
     */
    public function calculate(Quote $quote)
    {
        $fee = $this->_helper->getExtraFee();
        return $fee * \count($quote->getAllVisibleItems());
    }
}