<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

const DATABASE_USERS_PATH = __DIR__ . '/database/users/';
const DATABASE_ABOUT_TEXT = __DIR__ . '/database/about.txt';
const DATABASE_NEWS_TEXT = __DIR__ . '/database/news.txt';
const DATABASE_NUMBERS = __DIR__ . '/database/numbers.txt';

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