<?php

namespace Bundsgaard\Tests;

use Bundsgaard\Discounter\SimpleDiscounter;
use PHPUnit\Framework\TestCase;

class SimpleDiscounterTest extends TestCase
{
    private $basePrice = 100;

    public function test_get_accumulated_discount_for_ruleset()
    {
        $rules = [
            [
                'operator' => '<',
                'qty' => 5,
                'amount' => 10,
                'type' => 'percentage',
            ],
            [
                'operator' => '<=',
                'qty' => 10,
                'amount' => 10,
                'type' => 'percentage',
            ],
            [
                'operator' => '>',
                'qty' => 15,
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
                'operator' => '=',
                'qty' => 30,
                'amount' => 50,
                'type' => 'amount',
            ],
        ];

        $discounter = new SimpleDiscounter();

        $cartQty = 30;
        $discountedPrice = $discounter->calculate($this->basePrice, $cartQty, $rules)->get();
        $this->assertEquals(22, $discountedPrice);
    }

    public function test_get_accumulated_discount_for_ruleset_2()
    {
        $rules = [
            [
                'operator' => '<',
                'qty' => 8,
                'amount' => 20,
                'type' => 'percentage',
            ],
            [
                'operator' => '<=',
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

        $discounter = new SimpleDiscounter();

        $cartQty = 3;
        $discountedPrice = $discounter->calculate($this->basePrice, $cartQty, $rules)->get();
        $this->assertEquals(60, $discountedPrice);
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

        $discounter = new SimpleDiscounter();
        $discounter->setPrecision(5);

        $cartQty = 30;
        $discountedPrice = $discounter->calculate($this->basePrice, $cartQty, $rules)->get();
        $this->assertEquals(87.4445, $discountedPrice);
    }

    public function test_should_not_run_if_no_rules()
    {
        $discounter = new SimpleDiscounter();

        $cartQty = 30;
        $discountedPrice = $discounter->calculate($this->basePrice, $cartQty, [])->get();
        $this->assertEquals(100, $discountedPrice);
    }
}
