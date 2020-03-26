<?php

declare(strict_types=1);

namespace Model;

class Terminal
{
    /** @var string */
    public $total;

    /** @var Order */
    private $order;
    /** @var Pricing */
    private $pricing;

    public function setPricing(Pricing $pricing): void
    {
        $this->pricing = $pricing;
    }

    public function scan($code): void
    {
        if (!isset($this->order)) {
            $this->reset();
        }
        $this->order->addItem($code);
        $this->total = $this->order->getTotal();
    }

    public function reset(): void
    {
        $this->order = new Order($this->pricing);
        $this->total = '';
    }
}
