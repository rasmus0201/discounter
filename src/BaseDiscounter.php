<?php

namespace Bundsgaard\Discounter;

abstract class BaseDiscounter
{
    /**
     * @var array
     */
    protected $operators = [
        '>=' => 'gte',
        '>' => 'gt',
        '<=' => 'lte',
        '<' => 'lt',
        '=' => 'eq'
    ];

    /**
     * @var int
     */
    protected $precision = 2;

    /**
     * Method to apply rule if it evalutes to true
     * If rule applies, call closure.
     *
     * @param array $rule
     * @param \Closure  $fn
     *
     * @return void
     *
     * @throws \Exception   If unkown operator
     */
    protected function maybeApply(array $rule, \Closure $fn)
    {
        if (!$this->hasOperator($rule['operator'])) {
            throw new \Exception('Unkown operator "' . $rule['operator'] . '"');
        }

        if (!$this->shouldApply($rule)) {
            return;
        }

        // Call closure function
        $fn($rule);
    }

    /**
     * Check if rule applies with the operator,
     * rule qty and product qty
     *
     * @param array $rule
     *
     * @return bool
     */
    protected function shouldApply(array $rule)
    {
        // Call the the mapped method,
        // with qty parameters to do logic
        return call_user_func_array(
            [$this, $this->operators[$rule['operator']]],
            [$this->qty, $rule['qty']]
        );
    }

    /**
     * Check if operator is allowed
     *
     * @param string $operator
     *
     * @return bool
     */
    protected function hasOperator(string $operator)
    {
        return in_array($operator, array_keys($this->operators));
    }

    /**
     * Calculate a fixed price given an amount
     *
     * @param float $minuend [price]
     * @param float $subtrahend [amount]
     *
     * @return float
     */
    protected static function calculateFixed(float $minuend, float $subtrahend)
    {
        return self::ensureNotNegative($minuend - $subtrahend);
    }

    /**
     * Calculate a new price based on a discount percentage
     *
     * @param float $multiplier [price]
     * @param float $multiplicand [percentage]
     *
     * @return float
     */
    protected static function calculatePercentage(float $multiplier, float $multiplicand)
    {
        $percentageValue = ($multiplier * self::percentToDecimal($multiplicand));

        return self::ensureNotNegative($multiplier - $percentageValue);
    }

    /**
     * Convert to decimal. Ex. 11% => 0.11
     *
     * @param float $percent
     *
     * @return float
     */
    protected static function percentToDecimal(float $percent)
    {
        return ($percent / 100);
    }

    /**
     * Ensure some value is always above or equal to 0
     *
     * @param float $value
     *
     * @return float
     */
    protected static function ensureNotNegative(float $value)
    {
        return $value > 0 ? $value : 0.0;
    }

    /**
     * Check if actual is greater than or equal to wanted
     *
     * @param int $actual
     * @param int $wanted
     *
     * @return bool
     */
    protected static function gte(int $actual, int $wanted)
    {
        return $actual >= $wanted;
    }

    /**
     * Check if actual is greater than wanted
     *
     * @param int $actual
     * @param int $wanted
     *
     * @return bool
     */
    protected static function gt(int $actual, int $wanted)
    {
        return $actual > $wanted;
    }

    /**
     * Check if actual is less than or equal to wanted
     *
     * @param int $actual
     * @param int $wanted
     *
     * @return bool
     */
    protected static function lte(int $actual, int $wanted)
    {
        return $actual <= $wanted;
    }

    /**
     * Check if actual is less than wanted
     *
     * @param int $actual
     * @param int $wanted
     *
     * @return bool
     */
    protected static function lt(int $actual, int $wanted)
    {
        return $actual < $wanted;
    }

    /**
     * Check if actual is equal to wanted
     *
     * @param int $actual
     * @param int $wanted
     *
     * @return bool
     */
    protected static function eq(int $actual, int $wanted)
    {
        return $actual == $wanted;
    }
}
