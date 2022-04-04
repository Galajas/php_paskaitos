<?php


/*
// Function which prints "Hello I am Zura"
function hello()
{
    echo 'Hello I am Zura' . PHP_EOL;
}

hello();
hello();
hello();


// Function with argument

// funkcijose rekomenduojama naudoti kintamuju tipus ko tiketis programai.
function hello(string $name,  int $age)
{
    echo "Hello I am $name. My age: $age";
}

hello('Robertas', 29);




// Create sum of two functions
/** slash + ** ir enter
 * @param int $a
 * @param int $b
 * @return int

function sum(int $a, int $b): int
{
    return $a + $b;
}

echo sum(4,5) . PHP_EOL;
echo sum(9,10) . PHP_EOL;


 */


// Create function to sum all numbers using ...$nums
//function sum(array $numbers)
//{
//    $sum = 0;
//    foreach ($numbers as $number) {
//        $sum += $number;
//    }
//    return $sum;
//}
//echo sum([1, 2, 3, 4, 6]);

// ... pavercia stringa i array ir tada foreachina sako geriau nenaudoti naudot auksciau esanti
//function sum(... $numbers)
//{
//    $sum = 0;
//    foreach ($numbers as $number) {
//        $sum += $number;
//    }
//    return $sum;
//}
//echo sum(1, 2, 3, 4, 6);



// Arrow functions
//function sum(...$nums)
//{
//    return array_reduce($nums, fn($carry, $n) => carry + $n);
//}
//echo sum(1, 2, 3, 4, 6);