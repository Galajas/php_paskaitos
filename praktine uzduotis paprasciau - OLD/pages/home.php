<h1>Home</h1>
<?php
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $user_data = file_get_contents(DATABASE_USERS_PATH . $email);
    $data_explode = explode("|", $user_data);

    $user_name = $data_explode[0];
}
?>
<h3>
    <?php
    if (isset($_SESSION['email'])) {
        ?> Sveiki <?php
        echo $user_name;
        ?>
        prisijunge.
        <?php
    }
    ?>

</h3>
