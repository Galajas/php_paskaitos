<?php
session_start();

//$_SESSION['user'] = "Petras";
//$_SESSION['age'] = 15;

print_r ($_SESSION);
echo '<br>';
print_r ($_SESSION['age']);

//unset($_SESSION['user']); // nuima
//session_destroy(); //sunaikina