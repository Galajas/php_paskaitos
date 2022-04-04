<?php
/*
// while
while (true) { // Infinite loop: DON'T run this
    // Do something constantly
}


// Loop with $counter
$counter = 0; // When counter is 10??
while ($counter < 10) {
    echo $counter . PHP_EOL;
    // if ($counter > 5) break;
    $counter++;
}



// do - while
$counter = 0; // When counter is 10?
do {
    // Do some code right here
    $counter++;
} while ($counter < 10);



// for
for ($i = 0; $i < 10; $i++) {
    echo $i . PHP_EOL;
}





// foreach
$fruits = ["Banana", "Apple", "Orange"];
foreach ($fruits as $i => $fruit) {
    echo $i . ' ' . $fruit . PHP_EOL;
}

*/


// Iterate Over associative array.
$person = [
    'name' => 'Brad',
    'surname' => 'Traversy',
    'age' => 30,
    'hobbies' => ['Tennis', 'Video Games'],
];
foreach ($person as $key => $value) {
    if ($key === 'hobbies') {
        echo $key . ' ' . implode(', ', $value) . PHP_EOL;
    } else {
        echo $key . ' ' . $value . PHP_EOL;
    }
}