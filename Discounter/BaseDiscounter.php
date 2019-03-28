<?php

namespace Discounter;

abstract class BaseDiscounter
{
    /**
     * @var array
     */
    protected static $operators = [
        '>=' => 'gte',
        '>' => 'gt',
        '<=' => 'lte',
        '<' => 'lt',
        '=' => 'eq'
    ];

    /**
     * @var int
     */
    protected static $precision = 2;

    /**
     * Check if operator is allowed
     *
     * @param string $operator
     *
     * @return bool
     */
    protected static function hasOperator(string $operator)
    {
        return in_array($operator, array_keys(self::$operators));
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
