<?php



namespace Prince\Extrafee\Model\Calculation;

use Magento\Framework\Exception\ConfigurationMismatchException;
use Magento\Quote\Model\Quote;
use Prince\Extrafee\Helper\Data as FeeHelper;
use Prince\Extrafee\Model\Calculation\Calculator\CalculatorInterface;
use Psr\Log\LoggerInterface;

/**
 * Class CalculationService acts as wrapper around actual CalculatorInterface so logic valid for all calculations like
 * min order amount is only done once.
 *
 * @package Prince\Extrafee\Model\Calculation
 */
class CalculationService implements CalculatorInterface
{
    /**
     * @var CalculatorFactory
     */
    protected $factory;

    /**
     * @var FeeHelper
     */
    protected $helper;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * CalculationService constructor.
     * @param CalculatorFactory $factory
     * @param FeeHelper $helper
     * @param LoggerInterface $logger
     */
    public function __construct(CalculatorFactory $factory, FeeHelper $helper, LoggerInterface $logger)
    {
        $this->factory = $factory;
        $this->helper = $helper;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function calculate(Quote $quote)
    {
        // If module not enabled the fee is 0.0
        if (!$this->helper->isEnable()) {
            return 0.0;
        }

        if (!$this->hasMinOrderTotal($quote)) {
            return 0.0;
        }

        if ($this->hasMaxOrderTotal($quote)) {
            return 0.0;
        }

        try {
            return $this->factory->get()->calculate($quote);
        } catch (ConfigurationMismatchException $e) {
            $this->logger->error($e);
            return 0.0;
        }
    }

    /**
     * @param Quote $quote
     * @return bool
     */
    private function hasMinOrderTotal(Quote $quote)
    {
        $amount = $quote->getSubtotal();
        return $this->helper->getMinOrderTotal() <= $amount ? true: false;
    }

    /**
     * @param Quote $quote
     * @return bool
     */
    private function hasMaxOrderTotal(Quote $quote)
    {
        $amount = $quote->getSubtotal();
        return $this->helper->getMaxOrderTotal() <= $amount ? true: false;
    }
}
