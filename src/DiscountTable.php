<?php

namespace Bundsgaard\Discounter;

use Bundsgaard\Discounter\Contracts\Discountable;

class DiscountTable
{
    private $discounter;

    private $showDiscountFreeRows = true;

    private $qty = 1;
    private $price = 0;
    private $discount = 0;
    private $table = [];

    /**
     * Constructor
     *
     * @param Discountable $discounter
     */
    public function __construct(Discountable $discounter)
    {
        $this->discounter = $discounter;
    }

    /**
     * Get the table
     *
     * @param float $basePrice
     * @param array $rules
     *
     * @return array
     */
    public function get(float $basePrice, array $rules)
    {
        if (empty($rules)) {
            return [];
        }

        $this->price = $basePrice;

        $lastRule = end($rules);
        $stopQty = $this->getStopQty($lastRule);

        while (true) {
            $discount = $this->discounter->calculate($this->price, $this->qty, $rules)->get();

            // If there's no discount, do not add the row.
            if (!$this->showDiscountFreeRows && !$this->hasDiscount($discount)) {
                continue;
            }

            // Add discount to table
            $this->addRow($discount);

            // Check if we should add more rows
            if ($this->shouldLoop($stopQty)) {
                continue;
            }

            // If the last rule is onwards (no stop) then add mark it as infinite
            if ($this->isRuleInfinite($lastRule)) {
                $this->markRuleInfinite();
            }

            break;
        }

        return $this->table;
    }

    /**
     * Hide rows which doesn't have any discounts
     *
     * @return this
     */
    public function hideDiscountFreeRows()
    {
        $this->showDiscountFreeRows = false;

        return $this;
    }

    /**
     * Show rows which doesn't have any discounts
     *
     * @return this
     */
    public function showDiscountFreeRows()
    {
        $this->showDiscountFreeRows = true;

        return $this;
    }

    /**
     * Add row to table
     *
     * @param float $discount
     *
     * @return void
     */
    private function addRow(float $discount)
    {
        $this->table[] = [
            'qty' => $this->qty,
            'amount' => $this->price - $discount,
        ];
    }

    /**
     * Check if the discount actually is a discount.
     * If not go to next qty (i.e. row number).
     *
     * @param  float   $discount
     *
     * @return boolean
     */
    private function hasDiscount(float $discount)
    {
        if ($discount == $this->price) {
            $this->qty++;

            return false;
        }

        return true;
    }

    /**
     * Check if the loop should continue. If so
     * increment the qty (i.e. row number).
     *
     * @param int $stop
     *
     * @return bool
     */
    private function shouldLoop(int $stop)
    {
        if ($this->qty != $stop) {
            $this->qty++;

            return true;
        }

        return false;
    }

    /**
     * Check if rule plus infinite.
     *
     * @param array $rule
     *
     * @return boolean
     */
    private function isRuleInfinite(array $rule)
    {
        return in_array($rule['operator'], ['>', '>=']);
    }

    /**
     * Add inifity sign/marking to the last row.
     *
     * @return void
     */
    private function markRuleInfinite()
    {
        $this->table[count($this->table) - 1]['qty'] = $this->qty .'&hellip; &infin;';
    }

    /**
     * Where to stop adding any more rows to table.
     *
     * @param array $lastRule
     *
     * @return int
     */
    private function getStopQty(array $lastRule)
    {
        return $lastRule['operator'] == '>' ? $lastRule['qty'] + 1 : $lastRule['qty'];
    }
}
