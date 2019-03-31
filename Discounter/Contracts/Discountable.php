<?php

namespace Discounter\Contracts;

interface Discountable
{
    /**
     * Calculate this discount price
     *
     * @param float $basePrice
     * @param int   $qty
     * @param array $rules
     */
    public function calculate(float $basePrice, int $qty, array $rules);

    /**
     * Get the discounted price
     */
    public function get();
}
