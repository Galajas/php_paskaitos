<h1>Home</h1>
<?php
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

    $get_user_name = mysqli_query($database, "SELECT name FROM users WHERE email = '$email'");
    $get_user_name = mysqli_fetch_object($get_user_name);
    $get_user_name = $get_user_name->name;
}
?>
<h3>
    <?php
    if (isset($_SESSION['email'])) {
        ?> Sveiki <?php
        echo $get_user_name;
        ?>
        prisijunge.
        <?php
    }
    ?>

</h3>
