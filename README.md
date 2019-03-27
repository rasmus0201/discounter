# Discounter

Use the discounter as the following: (more examples in products.php)
```php
$basePrice = 1000;
$qty = 10;

$rule1 = new \stdClass();
$rule1->operator = '>=';
$rule1->qty = 10;
$rule1->amount = 12;
$rule1->type = 'percentage';

$rule2 = new \stdClass();
$rule2->operator = '=';
$rule2->qty = 5;
$rule2->amount = 8;
$rule2->type = 'percentage';

$rule3 = new \stdClass();
$rule3->operator = '<';
$rule3->qty = 4;
$rule3->amount = 75;
$rule3->type = 'fixed';

$rules = [
    $rule1,
    $rule2,
    $rule3
];

$discountedPrice = Discounter\Discounter::calculate($basePrice, $cartQty, $rules)->get();
```

### Available operators:
 - `>=` Greater than or equal to
 - `<=` Less than or equal to
 - `>` Greater than
 - `<` Less than
 - `=` Equal to
 
 ### Available discount types:
 - Fixed amount (`fixed`)
 - Percentage (`percentage`)
 

### Rule explanations:
```php
$rule1 = new \stdClass(); // Create new rule
$rule1->operator = '>='; // Set operator
$rule1->qty = 10; // Set the wanted cart qty
$rule1->amount = 12; // Set the amount of discount
$rule1->type = 'percentage'; // Set the type of discount
```
 
 
