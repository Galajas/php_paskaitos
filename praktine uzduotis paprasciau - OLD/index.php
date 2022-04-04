<?php
include_once 'config.php';


?>
<hr>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hello, world!</title>
</head>
<body>
<style>
    table {
        padding: 10px;
    }

    td {
        padding: 10px;
    }
</style>
<!--menu-->
<table>
    <tr>
        <td>
            <a href="index.php">Home</a>
        </td>
        <td>
            <a href="index.php?page=about">About</a>
        </td>
        <td>
            <a href="index.php?page=news">Naujienos</a>
        </td>

        <td>
            <a href="index.php?page=spek_skaiciu">Atspek skaiciu</a>
        </td>

        <?php if (isLoged() === false) { ?>
            <td>
                <a href="index.php?page=login">Login</a>
            </td>
            <td>
                <a href="index.php?page=register">Register</a>
            </td>
        <?php } ?>
        <?php if (isLoged() === true) { ?>

            <td>
                <a href="index.php?page=settings">Nustatymai</a>
            </td>
            <td>
                <a href="index.php?page=logout">Atsijungti</a>
            </td>
        <?php } ?>
    </tr>
</table>

<?php
if ($page === null) {
    include 'pages/home.php';
} elseif ($page === 'register') {
    include 'pages/registration.php';
} elseif ($page === 'about') {
    include 'pages/about.php';
} elseif ($page === 'login') {
    include 'pages/login.php';
} elseif ($page === 'settings') {
    include 'pages/settings.php';
} elseif ($page === 'logout') {
    include 'pages/logout.php';
} elseif ($page === 'news') {
    include 'pages/news.php';
} elseif ($page === 'spek_skaiciu') {
    include 'pages/atspek_skaiciu.php';
}
?>

<br/><br/>
<!--footer-->
<?php
echo date('Y-m-d H:i:s');
?>
</body>
</html>