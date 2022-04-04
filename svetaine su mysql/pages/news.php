<?php
$action = $_GET['action'] ?? null;
?>

<?php if ($action === 'edit') { ?>
    <h1>Naujienos redagavimas</h1>
<?php } else { ?>
    <h1>Naujienos</h1>
<?php } ?>

<?php

if (isLoged() === true) {

    $email = $_SESSION['email'];

    if ($action === 'delete') {
        $id = $_GET['id'];

        $sql = "delete from news where id = '$id'";
        mysqli_query($database, $sql);

    } else if ($action === 'edit') {

        $id = $_GET['id'];

        $new = mysqli_query($database, "select * from news where id = '$id' ");
        $new = mysqli_fetch_array($new, MYSQLI_ASSOC);
        $new_text = $new["text"];

//        var_dump($new);
//        $post_text = $new;


        if (isset($_POST['text'])) {
            $new_text = $_POST['text'];

            $sql = "update news set text = '$new_text' where id = '$id'";
            mysqli_query($database, $sql);

            echo 'naujiena atnaujinta';
        }
    } else {
        if (isset($_POST['text'])) {
            if (!empty($_POST['text'])) {
                $new = $_POST['text'];

                $sql = "insert into news (text, user_id) value ('$new', '$email')";
                mysqli_query($database, $sql);

                echo 'Naujiena irasyta';
            } else {
                echo 'Klaida';
            }
        }
    }


    ?>

    <?php if ($action === 'edit') { ?>
        <form action="index.php?page=news&action=edit&id=<?php echo $id ?>" method="post">
            <textarea name="text" rows="10" cols="60"><?php echo $new_text ?></textarea><br/>
            <button type="submit">Issaugoti</button>
        </form>
    <?php } else { ?>

        <form action="index.php?page=news" method="post">
            <textarea name="text" rows="10" cols="60"></textarea><br/>
            <button type="submit">Irasyti</button>
        </form>
    <?php } ?>

    <?php
}
?>
<br/>
<br/>
<ul>
    <?php
    if ($action != 'edit') {

        $get_news = mysqli_query($database, "SELECT * FROM news order by updated_at desc, created_at desc");
        $get_news = mysqli_fetch_all($get_news, MYSQLI_ASSOC);

        foreach ($get_news as $new) {

            ?>
            <li>
                Naujiena: <?php echo $new["text"] ?><br/>
                Parase: <?php
                $email = $new["user_id"];
                $get_user = mysqli_query($database, "SELECT * FROM users WHERE email = '$email'");
                $get_user = mysqli_fetch_array($get_user);
                $user_id = $get_user['name'];
                echo $user_id;
                ?><br/>
                Data sukūrimo: <?php echo $new["created_at"] ?><br/>
                <?php
                if ($new["updated_at"] != null) { ?>
                    Data atnaujinimo: <?php echo $new["updated_at"] ?><br/>
                <?php } ?>

                <?php if (isLoged() === true) { ?>
                    <br/>
                    <a href="index.php?page=news&action=delete&id=<?php echo $new["id"] ?>">Istrinti</a><br/>
                    <a href="index.php?page=news&action=edit&id=<?php echo $new["id"] ?>">Redaguoti</a><br/>
                <?php } ?>
                <hr>
            </li>
            <?php
        }
    }
    ?>
</ul>
