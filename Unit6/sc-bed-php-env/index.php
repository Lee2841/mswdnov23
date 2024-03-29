<?php
//Create an array
$cities = ['London', 'Paris', 'New York', 'Valletta', 'Bangkok'];
echo '<br><br>';
print_r($cities);


// Anoter way to create an array
$longCities = array('London', 'Paris', 'New York', 'Valletta', 'Bangkok'); 
echo '<br><br>';
print_r($longCities);


// An associative array
$company = [
    'CEO'=> 'Alice Anderson',
    'CTO'=> 'Bob Barker',
    'SVP Sales'=> 'Craig Coleman',
];
echo '<br><br>';
print_r($company);

// Accessing array values
printf('<p>The second city is %s', $cities[1]);
printf('<p>The CEO of the company is %s', $company['CEO']);

// Getting the size of the array
printf('There are %d cities in the array', count($cities));

// An example of 2D array
$gradebook = [
    'John Jefferson'=> ['English'=>92, 'Geography'=>76, 'Physics'=>80],
    'Georgia Graham' => ['English', 'French', 'Chemistry'],
    'Harriet Hasan' => ['Biology', 'Philosophy']
];
echo'<br><br>';
var_dump($gradebook);

printf('John got a %d in English', $gradebook['John Jefferson']['English']);

// Traversing an array (looping)
$planets = ['Mercury'=>'Rocky', 'Venus'=> 'Rocky','Earty'=> 'Rocky', 'Mars'=>'Rocky'
,'Jupiter' => 'Gas', 'Saturn' => 'Gas', 'Uranus'=>'Ice', 'Neptune'=>'Gas'];

foreach($planets as $planet=>$type) {
    printf('<p>%s is a %s planet.</p>', $planet, $type);
}

// Searching for an item in the array
$jupiterMoons = ['Europa', 'Io', 'Ganymede', 'Callisto'];
$search = 'Titan';
if (in_array($search, $jupiterMoons)) {
    printf('<p>%s is a moon of Juputer </p>', $search);
} else {
    printf('<p>%s is not a moon of Jupiter</p>', $search);
}