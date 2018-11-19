<?php

namespace Prince\Extrafee\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

/**
 * Class PriceType
 * @package Prince\Extrafee\Model\Config\Source
 */
class PriceType implements ArrayInterface
{
    /**
     * Price type variants
     */
    const TYPE_FIXED = 0;
    const TYPE_PERCENTAGE = 1;
    const TYPE_PER_ROW = 2;
    const TYPE_PER_ITEM = 3;

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => self::TYPE_PERCENTAGE, 'label' => __('Percentage Price')],
            ['value' => self::TYPE_FIXED, 'label' => __('Fixed Price')],
            ['value' => self::TYPE_PER_ROW, 'label' => __('Per row')],
            ['value' => self::TYPE_PER_ITEM, 'label' => __('Per item')],
        ];
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        $result = [];
        foreach ($this->toOptionArray() as $option) {
            $result[$option['value']] = $option['label'];
        }
        return $result;
    }
}
