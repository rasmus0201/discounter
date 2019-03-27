<?php

// qty = 10
// 1000
// 900
// 873
// -
// -
// = 873
$product1 = toJson([
    'price' => 1000,
    'discounts' => [
        [
            'operator' => '>=',
            'qty' => 10,
            'amount' => 100,
            'type' => 'fixed'
        ],
        [
            'operator' => '>=',
            'qty' => 3,
            'amount' => 3,
            'type' => 'percentage'
        ],
        [
            'operator' => '>=',
            'qty' => 20,
            'amount' => 20,
            'type' => 'percentage'
        ],
        [
            'operator' => '<',
            'qty' => 3,
            'amount' => 10,
            'type' => 'fixed'
        ]
    ]
]);


// qty = 10
// 1000
// 0
// 0
// = 0
$product2 = toJson([
    'price' => 1000,
    'discounts' => [
        [
            'operator' => '>=',
            'qty' => 10,
            'amount' => 100,
            'type' => 'percentage'
        ],
        [
            'operator' => '>=',
            'qty' => 5,
            'amount' => 10,
            'type' => 'percentage'
        ],
    ]
]);


// qty = 10
// 1000
// 900
// 810
// 729
// = 729
$product3 = toJson([
    'price' => 1000,
    'discounts' => [
        [
            'operator' => '>=',
            'qty' => 3,
            'amount' => 10,
            'type' => 'percentage'
        ],
        [
            'operator' => '>=',
            'qty' => 6,
            'amount' => 10,
            'type' => 'percentage'
        ],
        [
            'operator' => '>=',
            'qty' => 9,
            'amount' => 10,
            'type' => 'percentage'
        ],
    ]
]);

// qty = 10
// 1000
// 900
// -
// 810
// = 810
$product4 = toJson([
    'price' => 1000,
    'discounts' => [
        [
            'operator' => '>=',
            'qty' => 3,
            'amount' => 10,
            'type' => 'percentage'
        ],
        [
            'operator' => '>',
            'qty' => 10,
            'amount' => 25,
            'type' => 'percentage'
        ],
        [
            'operator' => '>=',
            'qty' => 6,
            'amount' => 10,
            'type' => 'percentage'
        ],
    ]
]);

// qty = 10
// 1000
// 900
// 675
// 607.5
// = 607.5
$product5 = toJson([
    'price' => 1000,
    'discounts' => [
        [
            'operator' => '>=',
            'qty' => 3,
            'amount' => 10,
            'type' => 'percentage'
        ],
        [
            'operator' => '>=',
            'qty' => 10,
            'amount' => 25,
            'type' => 'percentage'
        ],
        [
            'operator' => '>=',
            'qty' => 6,
            'amount' => 10,
            'type' => 'percentage'
        ],
    ]
]);

// qty = 10
// 1000
// -
// -
// -
// = 1000
$product6 = toJson([
    'price' => 1000,
    'discounts' => [
        [
            'operator' => '>=',
            'qty' => 12,
            'amount' => 10,
            'type' => 'percentage'
        ],
        [
            'operator' => '>=',
            'qty' => 15,
            'amount' => 100,
            'type' => 'fixed'
        ],
        [
            'operator' => '>=',
            'qty' => 20,
            'amount' => 3,
            'type' => 'percentage'
        ],
    ]
]);

// qty = 10
// 1000
// = 941.25 / 941.2474392084
$product7 = toJson([
    'price' => 1000,
    'discounts' => [
        [
            'operator' => '>=',
            'qty' => 0,
            'amount' => 10.283872,
            'type' => 'fixed'
        ],
        [
            'operator' => '>=',
            'qty' => 3,
            'amount' => 4.897231379823,
            'type' => 'percentage'
        ],
    ]
]);


// qty = 10
// 1000
// = 872.11 / 872.107723
$product8 = toJson([
    'price' => 1000,
    'discounts' => [
        [
            'operator' => '>=',
            'qty' => 0,
            'amount' => 8.298387642318,
            'type' => 'percentage'
        ],
        [
            'operator' => '>=',
            'qty' => 3,
            'amount' => 4.897231379823,
            'type' => 'percentage'
        ],
    ]
]);

// qty = 10
// 1000
// = 0
$product9 = toJson([
    'price' => 1000,
    'discounts' => [
        [
            'operator' => '>=',
            'qty' => 0,
            'amount' => 999.99,
            'type' => 'fixed'
        ],
        [
            'operator' => '>=',
            'qty' => 3,
            'amount' => 50,
            'type' => 'percentage'
        ],
    ]
]);

// qty = 10
// 1000
// 500
// 0
// = 0
$product10 = toJson([
    'price' => 1000,
    'discounts' => [
        [
            'operator' => '>=',
            'qty' => 0,
            'amount' => 50,
            'type' => 'percentage'
        ],
        [
            'operator' => '>=',
            'qty' => 3,
            'amount' => 750,
            'type' => 'fixed'
        ],
    ]
]);

// qty = 10
// 1000
// 0
// = 0
$product11 = toJson([
    'price' => 1000,
    'discounts' => [
        [
            'operator' => '>=',
            'qty' => 0,
            'amount' => 120,
            'type' => 'percentage'
        ],
    ]
]);
