<?php

namespace Discounter;

use Discounter\Contracts\Discountable;

class Discounter extends BaseDiscounter implements Discountable
{
    /**
    * @var \stdClass
    */
    private $currentRule;

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
     * This basically acts as a proxy to a non-static
     * instance of this class to utilize static call syntax,
     * when calling a Discounter
     *
     * @param float $basePrice
     * @param int   $qty
     * @param array $rules
     *
     * @return Discounter
     */
    public static function calculate(float $basePrice, int $qty, array $rules)
    {
        return new self(...func_get_args());
    }

    /**
     * Method to get calculated price
     *
     * @return float|null
     */
    public function get()
    {
        return $this->initialised ? round($this->price, self::$precision) : null;
    }

    /**
     * Construct a new Discounter and accumulate the rules.
     *
     * @param float $basePrice
     * @param int   $qty
     * @param array $rules
     *
     * @return self
     */
    private function __construct(float $basePrice, int $qty, array $rules)
    {
        $this->initialised = true;
        $this->rules = $rules;
        $this->price = $basePrice;
        $this->qty = $qty;

        $this->accumulate();

        return $this;
    }

    /**
     * Accumulate calculated discount rules
     *
     * @param array $rules
     *
     * @return void
     */
    private function accumulate()
    {
        if (empty($this->rules)) {
            return;
        }

        foreach ($this->rules as $rule) {
            $this->currentRule = $rule;

            $this->maybeApply(function() {
                $this->price = $this->calculatePrice();
            });
        }

        // Reset after the last rule
        $this->currentRule = null;
    }

    /**
     * Method to maybe if rule should apply
     * If rule applies, call closure.
     *
     * @param \Closure $fn
     *
     * @return void
     *
     * @throws \Exception   If unkown operator
     */
    private function maybeApply(\Closure $fn)
    {
        $operator = $this->currentRule->operator;

        if (!self::hasOperator($operator)) {
            throw new \Exception('Unkown operator "' . $operator . '"');
        }

        if (!$this->shouldApply()) {
            return;
        }

        // Call closure function
        $fn();
    }

    /**
     * Check if rule applies with the operator,
     * rule qty and product qty
     *
     * @return bool
     */
    private function shouldApply()
    {
        // Call the the mapped method,
        // with qty parameters to do logic
        return call_user_func_array(
            [$this, self::OPERATORS[$this->currentRule->operator]],
            [$this->qty, $this->currentRule->qty]
        );
    }

    /**
     * Calculate the price for the current rule
     *
     * @return float
     */
    private function calculatePrice()
    {
        $rule = $this->currentRule;

        if ($rule->type == 'percentage') {
            return self::calculatePercentage($this->price, $rule->amount);
        }

        return self::calculateFixed($this->price, $rule->amount);
    }
}
