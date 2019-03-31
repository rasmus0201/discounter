<?php

namespace Discounter;

use Discounter\Contracts\Discountable;

class Discounter extends BaseDiscounter implements Discountable
{
    /**
     * @var bool
     */
    private $initialised = false;

    /**
     * @var float
     */
    protected $price;

    /**
     * @var int
     */
    protected $qty;

    /**
     * @var array
     */
    protected $rules;

    /**
     * Method to calculate a discounted price
     * based on a set of rules.
     *
     * @param float $basePrice
     * @param int   $qty
     * @param array $rules
     *
     * @return float
     */
    public function calculate(float $basePrice, int $qty, array $rules = [])
    {
        $this->rules = $rules;
        $this->price = $basePrice;
        $this->qty = $qty;

        $this->accumulate();

        return $this;
    }

    /**
     * Method to get calculated price
     *
     * @return float|null
     */
    public function get()
    {
        return round($this->price, self::$precision);
    }

    /**
     * Accumulate calculated discount rules
     *
     * @return void
     */
    private function accumulate()
    {
        if (empty($this->rules)) {
            return;
        }

        foreach ($this->rules as $rule) {
            $this->maybeApply($rule, function($ruleToApply) {
                $this->price = $this->calculatePrice($ruleToApply);
            });
        }
    }

    /**
     * Calculate the price for the current rule
     *
     * @param \stdClass $rule
     *
     * @return float
     */
    private function calculatePrice($rule)
    {
        if ($rule->type == 'percentage') {
            return self::calculatePercentage($this->price, $rule->amount);
        }

        return self::calculateFixed($this->price, $rule->amount);
    }
}
