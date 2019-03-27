<?php

use Discounter\Discounter;

include 'products.php';

$p1 = $product8;
$qty1 = 10;

$price1 = Discounter::calculate($p1->price, $qty1, $p1->discounts)->get();

dump($price1);



$p2 = $product10;
$qty2 = 20;

$price2 = Discounter::calculate($p2->price, $qty2, $p2->discounts)->get();

dump($price2);
