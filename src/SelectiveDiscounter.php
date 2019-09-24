<?php

namespace Bundsgaard\Discounter;

use Bundsgaard\Discounter\Contracts\Discountable;

class SelectiveDiscounter extends BaseDiscounter implements Discountable
{
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

        $this->select();

        return $this;
    }

    /**
     * Method to get calculated price
     *
     * @return float|null
     */
    public function get()
    {
        return round($this->price, $this->precision);
    }

    /**
     * Method to set precision
     *
     * @param int $precision
     */
    public function setPrecision(int $precision)
    {
        $this->precision = $precision;
    }

    /**
     * Accumulate calculated discount rules
     *
     * @return void
     */
    private function select()
    {
        if (empty($this->rules)) {
            return;
        }

        // Store the base price as the lowest price at start
        $lowestPrice = $this->price;

        foreach ($this->rules as $rule) {
            $this->maybeApply($rule, function($ruleToApply) use (&$lowestPrice) {
                $newPrice = $this->priceAfterRule($ruleToApply);

                // If this rules price is less than the over-all lowest price
                // then this rule will give a greater discount,
                // and thereby is now the lowest price
                if ($newPrice < $lowestPrice) {
                    $lowestPrice = $newPrice;
                }
            });
        }

        // Set the price to the lowest price found compared to the different rules
        $this->price = $lowestPrice;
    }

    /**
     * Calculate the price for the current rule
     *
     * @param array $rule
     *
     * @return float
     */
    private function priceAfterRule($rule)
    {
        if ($rule['type'] == 'percentage') {
            return self::calculatePercentage($this->price, $rule['amount']);
        }

        return self::calculateFixed($this->price, $rule['amount']);
    }
}
