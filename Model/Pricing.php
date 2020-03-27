<?php

declare(strict_types=1);

namespace Model;

class Pricing
{
    /** @var array */
    private $priceData;

    /**
     * Pricing constructor.
     * @param array $priceData
     */
    public function __construct(array $priceData)
    {
        $this->priceData = $priceData;
    }

    /**
     * @param string $code
     * @param int $qty
     * @return float
     */
    public function getProductSubtotal(string $code, int $qty): float
    {
        // ensure we have price data for at least single qtys of this item
        if (!isset($this->priceData[$code][1])) {
            return 0;
        }

        // determine tier qty requirement
        $tierQty = max(array_keys($this->priceData[$code]));

        // get number of grouped products and number of single products
        $groups = (int)floor($qty / $tierQty);
        $singles = $qty % $tierQty;

        // multiply groups by tier price and singles by single price and return the sum
        return ($groups * (float)$this->priceData[$code][$tierQty]) + ($singles * (float)$this->priceData[$code][1]);
    }

}
