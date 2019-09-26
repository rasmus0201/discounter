<?php

namespace Bundsgaard\Tests;

use PHPUnit\Framework\TestCase;
use Bundsgaard\Discounter\SelectiveDiscounter;

class BaseDiscounterTest extends TestCase
{
    /**
     * @expectedException Bundsgaard\Discounter\Exceptions\WrongOperatorException
     */
    public function test_throws_exception_if_wrong_operator()
    {
        $rules = [
            [
                'operator' => '>=',
                'qty' => 10,
                'amount' => 10,
                'type' => 'percentage',
            ],
            [
                'operator' => '!=',
                'qty' => 15,
                'amount' => 10,
                'type' => 'percentage',
            ],
        ];

        $discounter = new SelectiveDiscounter();

        $discounter->calculate(100, 10, $rules)->get();
    }
}
