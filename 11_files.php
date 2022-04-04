<?php
// Magic constants
//echo __FILE__ . '<br>';
//echo __DIR__ . '<br>';



// Create directory
//mkdir(__DIR__ .'/test/abc/a');



// Rename directory
//rename('test', 'test2');



// Delete directory
//rmdir('test2/abc/a');



// Read files and folders inside directory
//$files = scandir('./blocks');
//echo '<pre>';
//var_dump($files);
//echo '</pre>';



// file_get_contents, file_put_contents
//$text = file_get_contents('11_files/text.txt'); // paima vidu
//
//echo $text; // atvaizduoja faila
//
//echo '<br>';
//file_put_contents('11_files/text.txt', rand(0, 10) . $text); // ji papildo rand numeriu
//
//$text = file_get_contents('11_files/text.txt'); // ji is naujo paima
//
//echo $text; // atvaizduoja atnaujinta faila



// file_get_contents from URL
//$jsonContent = file_get_contents('https://jsonplaceholder.typicode.com/users');
//$users = json_decode($jsonContent);
//var_dump($users);


// Check if file exists or not
echo file_exists('11_files/text.txt'); // true

echo '<br>';

// Get file size
echo filesize('11_files/text.txt');

// Delete file
//unlink('lorem.txt');