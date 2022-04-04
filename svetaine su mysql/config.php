<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// jungiames prie duomenu bazes
$database = mysqli_connect('127.0.0.1', 'root', '', 'casino');

// Tikrinam ar pavyko prisijungti prie duomenu bazes
if (!$database) {
    die("connection failed: " . mysqli_connect_error());
}



$page = $_REQUEST['page'] ?? null;

function isLoged(): bool
{
    if (isset($_SESSION['email'])) {
        return true;
    } else {
        return false;
    }
}

?>