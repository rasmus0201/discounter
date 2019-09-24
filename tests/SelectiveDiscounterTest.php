<?php

namespace Bundsgaard\Tests;

use Bundsgaard\Discounter\SelectiveDiscounter;
use PHPUnit\Framework\TestCase;

class SelectiveDiscounterTest extends TestCase
{
    private $basePrice = 100;

    public function test_get_best_discount_for_percentage_ruleset()
    {
        $simplePercentageRules = [
            [
                'operator' => '>=',
                'qty' => 10,
                'amount' => 10,
                'type' => 'percentage',
            ],
            [
                'operator' => '>=',
                'qty' => 20,
                'amount' => 20,
                'type' => 'percentage',
            ],
            [
                'operator' => '>=',
                'qty' => 30,
                'amount' => 30,
                'type' => 'percentage',
            ],
        ];

        $discounter = new SelectiveDiscounter();

        $cartQty = 10;
        $discountedPrice = $discounter->calculate($this->basePrice, $cartQty, $simplePercentageRules)->get();
        $this->assertEquals(90, $discountedPrice);

        $cartQty = 20;
        $discountedPrice = $discounter->calculate($this->basePrice, $cartQty, $simplePercentageRules)->get();
        $this->assertEquals(80, $discountedPrice);

        $cartQty = 30;
        $discountedPrice = $discounter->calculate($this->basePrice, $cartQty, $simplePercentageRules)->get();
        $this->assertEquals(70, $discountedPrice);
    }

    public function test_get_best_discount_for_fixed_amount_ruleset()
    {
        $simpleAmountRules = [
            [
                'operator' => '>=',
                'qty' => 10,
                'amount' => 20,
                'type' => 'amount',
            ],
            [
                'operator' => '>=',
                'qty' => 20,
                'amount' => 40,
                'type' => 'amount',
            ],
            [
                'operator' => '>=',
                'qty' => 30,
                'amount' => 60,
                'type' => 'amount',
            ],
        ];

        $discounter = new SelectiveDiscounter();

        $cartQty = 10;
        $discountedPrice = $discounter->calculate($this->basePrice, $cartQty, $simpleAmountRules)->get();
        $this->assertEquals(80, $discountedPrice);

        $cartQty = 20;
        $discountedPrice = $discounter->calculate($this->basePrice, $cartQty, $simpleAmountRules)->get();
        $this->assertEquals(60, $discountedPrice);

        $cartQty = 30;
        $discountedPrice = $discounter->calculate($this->basePrice, $cartQty, $simpleAmountRules)->get();
        $this->assertEquals(40, $discountedPrice);
    }

    public function test_should_round_to_int()
    {
        $rules = [
            [
                'operator' => '>=',
                'qty' => 10,
                'amount' => 12.5555,
                'type' => 'percentage',
            ]
        ];

        $discounter = new SelectiveDiscounter();
        $discounter->setPrecision(5);

        $cartQty = 30;
        $discountedPrice = $discounter->calculate($this->basePrice, $cartQty, $rules)->get();
        $this->assertEquals(87.4445, $discountedPrice);
    }

    public function test_should_not_run_if_no_rules()
    {
        $discounter = new SelectiveDiscounter();

        $cartQty = 30;
        $discountedPrice = $discounter->calculate($this->basePrice, $cartQty, [])->get();
        $this->assertEquals(100, $discountedPrice);
    }
}
