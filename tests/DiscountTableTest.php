<?php

namespace Bundsgaard\Tests;

use Bundsgaard\Discounter\SelectiveDiscounter;
use Bundsgaard\Discounter\DiscountTable;
use PHPUnit\Framework\TestCase;

class DiscountTableTest extends TestCase
{
    private $basePrice = 100;

    public function test_get_table_percentage_ruleset()
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

    public function test_get_table_for_mixed_ruleset()
    {
        $rules = [
            [
                'operator' => '=',
                'qty' => 1,
                'amount' => 10,
                'type' => 'amount',
            ],
            [
                'operator' => '=',
                'qty' => 2,
                'amount' => 20,
                'type' => 'amount',
            ],
            [
                'operator' => '>=',
                'qty' => 3,
                'amount' => 15,
                'type' => 'percentage',
            ],
            [
                'operator' => '>',
                'qty' => 5,
                'amount' => 10,
                'type' => 'percentage',
            ],
        ];

        $discounter = new SelectiveDiscounter();
        $discountTable = new DiscountTable($discounter);

        $table = $discountTable->get($this->basePrice, $rules);

        $this->assertCount(6, $table);

        $this->assertEquals(10, $table[0]['amount']);
        $this->assertEquals(20, $table[1]['amount']);
        $this->assertEquals(15, $table[2]['amount']);
        $this->assertEquals(15, $table[3]['amount']);
        $this->assertEquals(15, $table[4]['amount']);
        $this->assertEquals(15, $table[4]['amount']);
    }
}
