<?php
function add($num1, $num2)
{
    return $num1 + $num2;
}
$result = add(5, 7);
echo "<p>The result is $result</p>";
function add10($num)
{
    $num += 10;
}
$a = 4;
echo "<p>Value before function call: $a";
add10($a);
echo "<p>Value after function call: $a";
function add20(&$num)
{
    $num += 20;
}
$b = 4;
echo "<p>Value before function call: $b";
add10($b);
echo "<p>Value after function call: $b";
function raiseToPower($num, $power = 2)
{
    return pow($num, $power);
}
printf('<p>Optional argument is specified: %d</p>', raiseToPower(10, 5));
printf('<p>Optional argument is not specified: %d</p>', raiseToPower(10));
function sum()
{
    $total = 0;
    foreach (func_get_args() as $num) {
        $total += $num;
    }
    return $total;
}
printf('<p>Adding numbers together: %d</p>', sum(10, 87, 42, 56));
function sumVariadic(...$nums)
{     $total = 0;
    foreach ($nums as $num) {
        $total += $num;
    }
    return $total;
}
printf('<p>Adding numbers together: %d</p>', sumVariadic(10, 87, 42, 56));
$garage = ['Kia', 'BMW', 'Tesla', 'Ford']

function getVehicle($carNumber = 0)
{
    global $garage;
    return $garage[$carNumber];
} echo '<p>Array before changes:</p>';
print_r($garage);
$car = getVehicle(1);
$car = 'Mercedes';
echo '<p>Array after changes:</p>';
print_r($garage);
function &getVehicle2($carNumber = 0)
{
    global $garage;
    return $garage[$carNumber];
} echo '<p>Array before changes:</p>';
print_r($garage);
$car = &getVehicle(1);
$car = 'Mercedes';
echo '<p>Array after changes:</p>';
print_r($garage);
function showPrices(...$prices)
{
    function showAsEuro($value)
    {
        return '€' . number_format($value, 2, '.', ',');
    }     echo '<ul>';
    foreach ($prices as $price)
    {
        echo '<li>' . showAsEuro($price) . '</li>';
    }
    echo '</ul>'; } showPrices(34.789, 212.009, 1612.881, 12.89);
    // Variable Functions
function myFunc1()
{
    echo '<p>Hello! This is myFunc1()</p>';
}
function myFunc2($arg)
{
    echo "<p>Hello! This is myFunc2() with argument $arg</p>";
}
$myVar1 = 'myFunc1';
$myVar1();
$myVar2 = 'myFunc2';
$myVar2(1234);
// Anonoymous functions
$greeting = function ($name) {
    return "Hello, $name";
};
printf('<p>%s</p>', $greeting('Bob'));
// Fat-arrow syntax
$otherGreeting = fn($name) => "Hello again, $name";
printf('<p>%s</p>', $otherGreeting('Bob'));
$productPrices = [34.789, 212.009, 1612.881, 12.89];
$result = array_map(fn($price) => '€' . number_format($price, 2, '.', ','), $productPrices);
print_r($result);
// Fat-arrow functions can only have 1 line of code
// This is a closure (i.e. an anonoymous function used as an argument to another function)
$freeThreshold = 40;
$processedCart = array_map{
    function($price) use($freeThreshold){
        $deliver = ''
        if ($price > $freeThreshold) {
            $delivery = 'Free Delivery';
        }
        return '€'. number_format($price, 2, '.', '.') . "$delivery";
    },
    $productPrices
}
print_r($processedCart)
// Type Hinting
function showCartTotal(array $cartItems, string $currency, bool $rightPlacement, float $freeThreshold)
{
    $cartTotal = array_sum($cartItems);
    $formattedTotal = number_format($cartTotal, 2, '.', ',');
    $result = '<p>Your total is <strong>' . ($rightPlacement ? $formattedTotal . $currency : $currency . $formattedTotal) . '</strong></p>';
    if ($cartTotal > $freeThreshold)
    {
        $result .= '<p>Your cart qualifies for free delivery.</p>';
    }     return $result;
}
echo showCartTotal([12.18, 3.45, 11.80, 12.65], '€', false, 40);
// Static Variables
function sayHello($user)
{
    static $callCount = 0;
    $callCount++;
    echo "<p>Hello, $user. The function has been called $callCount times!";
}
sayHello('Bob');
sayHello('Alice');
sayHello('Terence');;
