<?php

// 1. sukurti masyva nuo 0 iki 21

$items = array();
for ($i = 0; $i <= 21; $i++)
{
    $items[] = $i;
}
echo '<br>';
// 2. pakeisti lyginius masyvo skaicius i raide x

foreach ($items as $key => $value) {
   if ($value % 2 === 0) {
       $items[$key] = 'x';
   }
}
//echo '<pre>';
//print_r($items);


// 3. suskaiciuoti kiek masyve yra x ir irasyti i faila x.txt
$count = 0;

foreach ($items as $value) {
    if ($value == 'x') {
        $count++;
    }
}

file_put_contents('x.txt', $count);


$x_count = 0;
$items = [];
for ($i = 0; $i <= 21; $i++) {
    if ($i % 2 === 0) {
        $items[] = 'x';
        $x_count++;
    } else {
        $items[] = $i;
    }
}

file_put_contents('x2.txt', $x_count);


