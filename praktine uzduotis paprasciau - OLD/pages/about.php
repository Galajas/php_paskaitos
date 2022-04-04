<h1>About</h1>
<?php
if (isset($_POST['about_text'])) {
    $about_text = $_POST['about_text'];
    $email = $_SESSION['email'];
    $update_time = date('Y-m-d H:i:s');
    file_put_contents(DATABASE_ABOUT_TEXT, implode('|', [$about_text, $email, $update_time]));
}
$about_text = file_get_contents(DATABASE_ABOUT_TEXT);
$about_text = explode('|', $about_text);

?>
<?php if (isLoged() === true) { ?>
    <form action="index.php?page=about" method="post">
        <table>
            <tr>
                <td>
                    Atnaujino:
                </td>
                <td>
                    <?php echo $about_text[1] ?>
                </td>
            </tr>
            <tr>
                <td>
                    Atnaujinimo data:
                </td>
                <td>
                    <?php echo $about_text[2] ?>
                </td>
            </tr>
            <table>

                <textarea name="about_text" rows="10" cols="60"><?php echo $about_text[0] ?></textarea>
                <button type="submit">Išsaugoti</button>
    </form>
<?php } else {
    ?>
    <table>

    <tr>
        <td>
            Atnaujino:
        </td>
        <td>
            <?php echo $about_text[1] ?>
        </td>
    </tr>
    <tr>
        <td>
            Atnaujinimo data:
        </td>
        <td>
            <?php echo $about_text[2] ?>
        </td>
    </tr>
    <tr>
        <td>
            Apie: <?php echo $about_text[0] ?>
        </td>
        <td>
            <?php echo $about_text[0] ?>
        </td>
    </tr>

    <table>

    <?php
}
?>