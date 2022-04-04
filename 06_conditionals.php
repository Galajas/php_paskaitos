<?php

$age = 20;
$salary = 300000;

/*

// Sample if
if ($age == 20) {
    echo "1" . PHP_EOL;
}


// Without circle braces
if ($age === 20)
    echo "1" . PHP_EOL;

// Sample if-else
if ($age > 20) {
    echo "1" . PHP_EOL;
} else {
    echo "2" . PHP_EOL;
}

// Difference between == and ===
$age == 20; // true
$age == '20'; // true

$age === 20; // true
$age === '20'; // false

// if AND
if ($age > 20 && $salary === 300000) {

    // galimas naudojimas
}if ($age > 20 && ($salary === 300000 or $salary === 400000)) {

}
// if OR
if ($age > 20 OR $salary === 300000) {

    // arba su ||
}if ($age > 20 || $salary === 300000) {

}


// Ternary if
echo $age < 22 ? 'Young' : 'Old' . PHP_EOL;




// Short ternary
$myAge = $age ?: 18; // Equivalent of "$age ? $age : 18"

var_dump($myAge);



// Null coalescing operator jeigu name nera tada naudoja 'John'
$var = isset($name) ? $name : 'John';
$var = $name ?? 'John'; // Equivalent of above
echo $var . PHP_EOL;

*/



// switch
$userRole = 'admin'; // admin, editor, user

switch ($userRole) {
    case 'admin':
        echo 'You can do anything' . PHP_EOL;
        break;
    case 'editor':
        echo 'You can edit content' . PHP_EOL;
        break;
    case 'user':
        echo 'You can view posts and comment' . PHP_EOL;
        break;
    default:
        echo 'Unknown role' . PHP_EOL;
}
