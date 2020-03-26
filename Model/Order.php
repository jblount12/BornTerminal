<?php

declare(strict_types=1);

namespace Model;

class Order
{
    /** @var array */
    private $items;
    /** @var Pricing */
    private $pricing;

    /**
     * Order constructor.
     * @param Pricing $pricing
     */
    public function __construct(Pricing $pricing)
    {
        $this->pricing = $pricing;
    }

    /**
     * @param string $item
     */
    public function addItem(string $item): void
    {
        if (isset($this->items[$item])) {
            $this->items[$item]['qty']++;
        } else {
            $this->items[$item]['qty'] = 1;
        }
        $this->items[$item]['subtotal'] = $this->pricing->getProductSubtotal($item, $this->items[$item]['qty']);
    }

    /**
     * @return string
     */
    public function getTotal(): string
    {
        $total = 0.00;
        foreach ($this->items as $item) {
            $total += $item['subtotal'];
        }
        return number_format($total, 2);
    }

}
