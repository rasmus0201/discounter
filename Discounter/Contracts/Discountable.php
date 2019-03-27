<?php

namespace Discounter\Contracts;

interface Discountable
{
    /**
     * Instantiator of the discounter
     *
     * @param float $basePrice
     * @param int   $qty
     * @param array $rules
     */
    public static function calculate(float $basePrice, int $qty, array $rules);

    /**
     * Get the discounted price
     */
    public function get();
}
