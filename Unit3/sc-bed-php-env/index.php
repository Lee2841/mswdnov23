<?php // Arithmetic Operators $a = 21; 
$b = 2; $intDiv = 8 / 2; 
echo '<h5>Arithmetic Operators</h5>'; 
printf('<p>%d + %d = %d</p>', $a, $b, $a + $b); 
printf('<p>%d - %d = %d</p>', $a, $b, $a - $b); 
printf('<p>%d * %d = %d</p>', $a, $b, $a * $b); 
printf('<p>%d / %d = %.1f</p>', $a, $b, $a / $b); 
printf('<p>%d %% %d = %.1f</p>', $a, $b, $a % $b); 
printf('<p>%d ** %d = %d</p>', $a, $b, $a ** $b); 
echo("8 / 2 = $intDiv, which is a " . gettype($intDiv));
//test
echo '<h5>Increment & Decrement</h5>'; 
$a = 0; $b = 0; 
printf('<p>a is %d. After ++a, a is %d</p>', $a, ++$a); 
printf('<p>b is %d. After b++, b is %d</p>', $b, $b++);

echo '<h5>Assignment With Operation</h5>'; $a = 1; 
printf('<p>a starts with the value %d</p>', $a); 
printf('<p>a+=5: %d', $a+=6); 
printf('<p>a-=4: %d', $a-=4); 
printf('<p>a*=2: %d', $a*=2); 
printf('<p>a/=2: %d', $a/=2); 
printf('<p>a%%=2: %d', $a%=2); 
echo '<p>' . $a .= ' is the final result</p>';

echo '<h5>Assignment By Value</h5>'; 
$a = 20; 
printf('<p>a starts with the value %d</p>', $a); 
$b = $a; 
$b = 30;
printf('<p>After changing b, a contains %d</p>', $a);

echo '<h5>Assignment By Reference</h5>'; 
$a = 20; 
printf('<p>a starts with the value %d</p>', $a); 
$b = &$a; 
$b = 30; 
printf('<p>After changing b, a contains %d</p>', $a);

// Control Flow 
echo '<h5>IF Statement</h5>'; 
$age = 23; 
if ($age >= 18) {     
    echo '<p>You can drive a car.</p>';  
 } else {     
        echo '<p>You cannot legally drive a car yet.</p>'; 
    }

echo '<h5>Multiple Outcomes</h5>'; 
$pizzaChoice = 2; 
if ($pizzaChoice === 1) {     
    echo '<p>Pizza Margherita</p>'; 
} elseif ($pizzaChoice === 2) {    
    echo '<p>Pizza Pepperoni</p>'; 
} elseif ($pizzaChoice === 3) {     
    echo '<p>Pizza Mushroom</p>'; 
} else {     
    echo '<p>You did not choose an available pizza!</p>'; 
}

$isRaining = true; 
$message = null; 
if ($isRaining === true) {     
    $message = 'Better take an umbrella!'; 
} else {    
     $message = 'Enjoy the day out!'; 
} 
echo "<p>$message</p>"; 

$isRaining = true; 
$message = $isRaining === true ? 'Better take an umbrella!' : 'Enjoy the day out!'; 
echo "<p>$message</p>";

$beanWeight = 50; 
$waterWeight = 200; 
if ($beanWeight > 30 && $waterWeight > 150) {     
    echo '<p>Coffee machine working...</p>'; 
} else {     
    echo '<p>Error: check coffee beans and water amount.</p>'; }

$grindWeight = 30; 
if ($beanWeight > 30 || $grindWeight > 20) {     
    echo '<p>Coffee machine working...</p>'; 
} else {     
    echo '<p>Error: check coffee beans/grind and water amount.</p>'; }

if (($beanWeight > 30 || $grindWeight > 20) && $waterWeight > 150) {     
    echo '<p>Coffee machine working...</p>'; 
} else {     
    echo '<p>Error: check coffee beans/grind and water amount.</p>'; }

// Switch statement 
$pizzaChoice = 2; 
switch ($pizzaChoice) {     
    case 1: echo '<p>Pizza Margherita</p>'; break;
    case 2: echo '<p>Pizza Pepperoni</p>'; break;  
    case 3: echo '<p>Pizza Mushroom</p>'; break;
    default: echo '<p>You did not choose an available pizza!</p>'; } 

// Iteration 
$fishingPermitExpires = 31; 
$currentDay = 25; 
while ($currentDay <= $fishingPermitExpires) {     
    echo "<p>Fishing on day $currentDay</p>";     
    $currentDay++; }

$fishingPermitExpires = 31; 
$currentDay = 25; 
do {    
     echo "<p>Fishing on day $currentDay</p>";     
     $currentDay++; 
    } while ($currentDay <= $fishingPermitExpires);

    $fishingPermitExpires = 31; 
    for ($currentDay = 25; 
    $currentDay <= $fishingPermitExpires; $currentDay++){     
        echo "<p>Fishing on day $currentDay</p>"; }

// For-each loop 
$students = ['Alice', 'Bob', 'Craig', 'Daniela', 'Elisa'];
foreach ($students as $id => $name) {
    echo "<p>Student $id: $name</p>";
}