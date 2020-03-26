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
        // determine tier qty requirement
        $tierQty = max(array_keys($this->priceData[$code]));

        // get number of grouped products and number of single products
        $groups = (int)floor($qty / $tierQty);
        $singles = $qty % $tierQty;

        // multiple groups by tier price and single by single price and return the sum
        return ($groups * (float)$this->priceData[$code][$tierQty]) + ($singles * (float)$this->priceData[$code][1]);
    }

}
