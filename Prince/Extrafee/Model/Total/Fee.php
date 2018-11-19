<?php

namespace Prince\Extrafee\Model\Total;

use Magento\Framework\Phrase;
use Magento\Quote\Api\Data\ShippingAssignmentInterface;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\Quote\Address;
use Prince\Extrafee\Helper\Data as FeeHelper;
use Prince\Extrafee\Model\Calculation\Calculator\CalculatorInterface;

/**
 * Class Fee
 * @package Prince\Extrafee\Model\Total
 */
class Fee extends Address\Total\AbstractTotal
{
    /**
     * @var FeeHelper
     */
    protected $helper;

    /**
     * @var CalculatorInterface
     */
    protected $calculator;

    /**
     * @param FeeHelper $helper
     * @param CalculatorInterface $calculator
     */
    public function __construct(FeeHelper $helper, CalculatorInterface $calculator) {
        $this->calculator = $calculator;
        $this->helper = $helper;
    }

    /**
     * @param Quote $quote
     * @param ShippingAssignmentInterface $shippingAssignment
     * @param Address\Total $total
     * @return $this
     */
    public function collect(Quote $quote, ShippingAssignmentInterface $shippingAssignment, Address\Total $total)
    {
        parent::collect($quote, $shippingAssignment, $total);

        $fee = $this->calculator->calculate($quote);
        $total->setTotalAmount('fee', $fee);
        $total->setBaseTotalAmount('fee', $fee);
        $total->setFee($fee);
        $total->setBaseFee($fee);
        $quote->setFee($fee);
        $quote->setBaseFee($fee);
        $quote->setGrandTotal($total->getGrandTotal() + $fee);
        $quote->setBaseGrandTotal($total->getBaseGrandTotal() + $fee);
        
        return $this;
    }

    /**
     * @param Address\Total $total
     */
    protected function clearValues(Address\Total $total)
    {
        $total->setTotalAmount('subtotal', 0);
        $total->setBaseTotalAmount('subtotal', 0);
        $total->setTotalAmount('tax', 0);
        $total->setBaseTotalAmount('tax', 0);
        $total->setTotalAmount('discount_tax_compensation', 0);
        $total->setBaseTotalAmount('discount_tax_compensation', 0);
        $total->setTotalAmount('shipping_discount_tax_compensation', 0);
        $total->setBaseTotalAmount('shipping_discount_tax_compensation', 0);
        $total->setSubtotalInclTax(0);
        $total->setBaseSubtotalInclTax(0);
    }

    /**
     * Assign subtotal amount and label to address object
     *
     * @param Quote $quote
     * @param Address\Total $total
     * @return array
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function fetch(Quote $quote, Address\Total $total)
    {
        $result = [];
        $fee = $this->calculator->calculate($quote);

        if ($fee > 0.0) {
            $result = [
                'code' => 'fee',
                'title' => $this->getLabel(),
                'value' => $fee
            ];
        }

        return $result;
    }

    /**
     * Get label
     *
     * @return Phrase
     */
    public function getLabel()
    {
        return __($this->helper->getTitle());
    }
}
