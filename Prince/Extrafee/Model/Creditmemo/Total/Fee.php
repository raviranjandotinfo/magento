<?php

namespace Prince\Extrafee\Model\Creditmemo\Total;

use Magento\Sales\Model\Order\Creditmemo;
use Magento\Sales\Model\Order\Creditmemo\Total\AbstractTotal;
use Prince\Extrafee\Helper\Data as FeeHelper;

/**
 * Class Fee
 * @package Prince\Extrafee\Model\Creditmemo\Total
 */
class Fee extends AbstractTotal
{
    /**
     * @var FeeHelper
     */
    protected $helper;

    /**
     * Fee constructor.
     *
     * @param FeeHelper $helper
     * @param array $data
     */
    public function __construct(FeeHelper $helper, array $data = [])
    {
        parent::__construct($data);
        $this->helper = $helper;
    }

    /**
     * @param Creditmemo $creditmemo
     * @return $this
     */
    public function collect(Creditmemo $creditmemo)
    {
        $creditmemo->setFee(0);
        $creditmemo->setBaseFee(0);
        if (!$this->helper->isRefund()) {
            return $this;
        }

        $amount = $creditmemo->getOrder()->getFee();
        $creditmemo->setFee($amount);
        $creditmemo->setGrandTotal($creditmemo->getGrandTotal() + $amount);

        $baseAmount = $creditmemo->getOrder()->getBaseFee();
        $creditmemo->setBaseFee($baseAmount);
        $creditmemo->setBaseGrandTotal($creditmemo->getBaseGrandTotal() + $baseAmount);

        return $this;
    }
}
