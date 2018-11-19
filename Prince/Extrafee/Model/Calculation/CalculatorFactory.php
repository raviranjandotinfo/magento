<?php

namespace Prince\Extrafee\Model\Calculation;

use Magento\Framework\Exception\ConfigurationMismatchException;
use Magento\Framework\ObjectManagerInterface;
use Prince\Extrafee\Helper\Data as FeeHelper;
use Prince\Extrafee\Model\Config\Source\PriceType;

class CalculatorFactory
{
    /**
     * @var FeeHelper
     */
    protected $helper;

    /**
     * @var ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * CalculationFactory constructor.
     *
     * @param ObjectManagerInterface $objectManager
     * @param FeeHelper $helper
     */
    public function __construct(ObjectManagerInterface $objectManager, FeeHelper $helper)
    {
        $this->helper = $helper;
        $this->objectManager = $objectManager;
    }

    /**
     * @return Calculator\CalculatorInterface
     * @throws ConfigurationMismatchException
     */
    public function get()
    {
        switch ($this->helper->getPriceType()) {
            case PriceType::TYPE_FIXED:
                return $this->objectManager->get(Calculator\FixedCalculator::class);
            case PriceType::TYPE_PERCENTAGE:
                return $this->objectManager->get(Calculator\PercentageCalculator::class);
            case PriceType::TYPE_PER_ROW:
                return $this->objectManager->get(Calculator\PerRowCalculator::class);
            case PriceType::TYPE_PER_ITEM:
                return $this->objectManager->get(Calculator\PerItemCalculator::class);
            default:
                throw new ConfigurationMismatchException(__('Could not find price calculator for type %1', $this->helper->getPriceType()));
        }
    }
}