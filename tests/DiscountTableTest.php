<?php

namespace Bundsgaard\Tests;

use Bundsgaard\Discounter\SelectiveDiscounter;
use Bundsgaard\Discounter\DiscountTable;
use PHPUnit\Framework\TestCase;

class DiscountTableTest extends TestCase
{
    private $basePrice = 100;

    public function test_get_best_discount_for_percentage_ruleset()
    {
        $rules = [
            [
                'operator' => '=',
                'qty' => 2,
                'amount' => 10,
                'type' => 'percentage',
            ],
            [
                'operator' => '>=',
                'qty' => 3,
                'amount' => 15,
                'type' => 'percentage',
            ],
        ];

        $discounter = new SelectiveDiscounter();
        $discountTable = new DiscountTable($discounter);

        $table = $discountTable->get($this->basePrice, $rules);

        $this->assertCount(2, $table);
        $this->assertEquals(10, $table[0]['amount']);
        $this->assertEquals(15, $table[1]['amount']);
    }
}
