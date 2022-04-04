<?php

// Print current date
//echo date('Y-m-d H:i:s') . PHP_EOL;



// Print yesterday
// atima time() - kas yra sekundemis dabartine data ir atimam vienos paros sekundes
echo date('Y-m-d H:i:s', time() - 3600 * 24) . PHP_EOL;
// strtotime - tekstas kecia datos -1 days or months
echo date('Y-m-d H:i:s', strtotime('+1 months')) . PHP_EOL;

exit;

// Different format: https://www.php.net/manual/en/function.date.php
echo date('F j Y, H:i:s') . PHP_EOL;

// Print current timestamp
echo time() . PHP_EOL;

// Parse date: https://www.php.net/manual/en/function.date-parse.php
$dateString = '2020-02-06 12:45:35';
$parsedDate = date_parse($dateString);
echo '<pre>';
var_dump($parsedDate);
echo '</pre>';

// Parse date from format: https://www.php.net/manual/en/function.date-parse-from-format.php
$dateString = 'February 4 2020 12:45:35';

$parsedDate = date_parse_from_format('F j Y H:i:s', $dateString);
echo '<pre>';
var_dump($parsedDate);
echo '</pre>';