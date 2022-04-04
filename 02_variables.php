<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
labas, vakaras <br>
</body>
</html>


<?php
// coments

/*
echo '<div>Labas ir tau!</div>'
*/

// echo '<div>Labas ir tau!</div>'

# echo '<div>Labas ir tau!</div>'

// what is a variable
//$name = 'robertas';

// variable types
/*
string
integer
float
boolean
null
array
object
resource
*/

// declare variable
$name = 'Robertas';
$age = 29;
$combName = "$name $age"; // dvigubas naudoti taip galima
$isMale = true;
$height = 1.86;
$salary = null;

// print the variables.
echo $name . '<br>';
echo $age . '<br>';
echo $combName . '<br>';
echo $isMale . '<br>';
echo $height . '<br>';
echo $salary . '<br>';

// print types of the variables
//echo gettype($name) . '<br>';
//echo gettype($age) . '<br>';
//echo gettype($combName) . '<br>';
//echo gettype($isMale) . '<br>';
//echo gettype($height) . '<br>';
//echo gettype($salary) . '<br>';

// print the whole variable
//var_dump($name, $age, $isMale, $height, $salary);

// change the value of the variable
//$name = 'Petras';
//
//echo $name . '<br>';

// variable checking functions
//$isStringName = is_string($name);
//var_dump($isStringName);

// variable checking functions
//$areWeHaveVariable = 'Yes';
//$a = isset($areWeHaveVariable); // tikrina ar yra priskirtas kintamasis.
//var_dump($a);

// constants apsiraso su define arba const
//define('PI', 3.14); //
//const PI = 3.14;
//
//echo PI . '<br>';
//
//var_dump(defined(constant_name: 'PI')); // ar aprasyta tokia constanta

// using PHP built-in constants
//echo SORT_ASC.'<br>';
//echo PHP_INT_MAX.'<br>';



?>