<?php

use Discounter\Discounter;

include 'products.php';

$p1 = $product8;
$qty1 = 10;

$discounter1 = new Discounter();
$price1 = $discounter1->calculate($p1->price, $qty1, $p1->discounts)->get();

dump($price1);



$p2 = $product10;
$qty2 = 20;

$discounter2 = new Discounter();
$price2 = $discounter2->calculate($p2->price, $qty2, $p2->discounts)->get();

dump($price2);
