<?php
session_start();
$page = $_REQUEST['page'] ?? null;

const DATABASE_USERS_PATH = __DIR__ . '/database/users/';

function isLoged(): bool
{
    if (isset($_SESSION['email'])) {
        return true;
    } else {
        return false;
    }
}

if ($page === 'save_user') {
    $email = $_POST['email'];
    $sex = $_POST['sex'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $safe_code = $_POST['code'];

    $errors = [];

    if (!in_array($sex, ['male', 'female'])) {
        $errors['sex'][] = 'bloga lytis';
    }

    if (strlen($name) < 3 || strlen($name) > 60) {
        $errors['names'][] = 'vardas yra per ilgas arba per trumpas';
    }

    if (file_exists(DATABASE_USERS_PATH . $email)) {
        $errors['emails'][] = 'toks el. pastas uzimtas';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['emails'][] = 'Neteisingas el. pastas';
    }

    if ($email == $password) {
        $errors['emails'][] = 'slaptazodis ir emailas negali buti vienodi';
    }

    if ($password != $password2) {
        $errors['passwords_match'][] = 'Slaprazodiai nesutampa';
    }

    if (strlen($password) < 9) {
        $errors['passwords'][] = 'slaptazodis turi buti ilgesnis nei 9 simboliai';
    }

    if (!preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password)) {
        $errors['passwords'][] = 'slaptazodyje turi buti raide ir skaicius';
    }

    if ($age < 14 || $age > 60) {
        $errors['age'][] = 'blogas amzius';
    }

    if ($_SESSION['code'] !== $safe_code) {
        $errors['code'][] = 'Neteisingas saugos kodas';
    }

}
if ($page === 'save_user') {

    if (empty($errors)) {
        if (file_put_contents(DATABASE_USERS_PATH . $email, implode('|', [$name, $age, $sex, $password])) === false) {
            $errors[] = 'nepavyko sukurti vartotojo';
        } else {
            header("Location: index.php?page=login&email=$email");
        }
    }
}

if ($page === 'update_user') {

    $email = $_SESSION['email'];

    $name = $_POST['name'];
    $age = $_POST['age'];
    $sex = $_POST['sex'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    $user = file_get_contents(DATABASE_USERS_PATH . $email);
    $user = explode('|', $user);


    if ($name != '') {
        $user[0] = $name;
    } else {
        $name = $user[0];
    }

    if ($age != '-') {
        $user[1] = $age;
    } else {
        $age = $user[1];
    }

    if ($sex != '-') {
        $user[2] = $sex;
    } else {
        $sex = $user[2];
    }

    if ($password === $password2 && $password != '') {
        $user[3] = $password;
    } else {
        $password = $user[3];
    }

    file_put_contents(DATABASE_USERS_PATH . $email, implode('|', [$name, $age, $sex, $password]));
}

if ($page === 'login_user') {
    $email = $_POST['email'];
    $password = $_POST['password'];


    $errors = [];

    if (!file_exists(DATABASE_USERS_PATH . $email)) {
        $errors[] = 'Email not found';
    } else {
        $user_data = file_get_contents(DATABASE_USERS_PATH . $email);
        $password_explode = explode("|", $user_data);

        if ($password != $password_explode[3]) {
            $errors[] = 'Wrong passsword';
        }
    }


    if (empty($errors)) {
        $_SESSION['email'] = $email;
        header('Location: index.php');
    }


}

if ($page === 'save_about') {
    $text = $_POST['text_about'];

    file_put_contents('./database/about', $text);
}


if ($page === 'logout') {
    session_destroy();
    header('Location: index.php');
}

$_SESSION['code'] = rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);


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


        <?php if (isLoged() === true) { ?>
            <td>
                <a href="index.php?page=update">Update user</a>
            </td>

            <td>
                <a href="index.php?page=logout">Logout</a>
            </td>

        <?php } ?>
        <?php if (isLoged() === false) { ?>
            <td>
                <a href="index.php?page=login">Login</a>
            </td>
            <td>
                <a href="index.php?page=register">Register</a>
            </td>
        <?php } ?>


    </tr>
</table>


<!--content-->
<?php if ($page === null) { ?>
    <h1>Home</h1>
    <?php


    if (isset($_SESSION['email'])) {
        $email = $_SESSION['email'];
        $user_data = file_get_contents(DATABASE_USERS_PATH . $email);
        $data_explode = explode("|", $user_data);

        $user_name = $data_explode[0];
        ?>
        <h3>
            Sveiki <?php echo $user_name ?> prisijunge.
        </h3>
        <?php
    }
    ?>

<?php } elseif ($page === 'update' || $page === 'update_user') { ?>
    <h1>Atnaujinti informacija</h1>
    <form action="index.php?page=update_user" method="post">
        <table>
            <tr>
                <td>
                    Vardas:
                </td>
                <td>
                    <input type="text" name="name" value="<?php echo $name ?? null ?>">
                </td>
                <td>
                    <?php
                    if (isset($errors['names'])) {
                        echo implode(', ', $errors['names']);
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    Lytis:
                </td>
                <td>
                    <select name="sex">
                        <option value="">-</option>
                        <option value="male" >
                            Male
                        </option>
                        <option value="female" >
                            Female
                        </option>
                    </select>
                </td>
                <td>
                    <?php
                    if (isset($errors['sex'])) {
                        echo implode(', ', $errors['sex']);
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    Metai:
                </td>
                <td>
                    <select name="age">
                        <option value="">-</option>
                        <?php for ($i = 14; $i <= 60; $i++) { ?>
                            <option value="<?php echo $i; ?>"
                                <?php
                                if (($age ?? null) == $i) {
                                    echo 'selected';
                                }
                                ?>
                            >
                                <?php echo $i ?>
                            </option>
                        <?php } ?>
                    </select>
                </td>
                <td>
                    <?php
                    if (isset($errors['age'])) {
                        echo implode(', ', $errors['age']);
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    Slaptažodis:
                </td>
                <td>
                    <input type="text" name="password">
                </td>
                <td>
                    <?php
                    if (isset($errors['passwords'])) {
                        echo implode(', ', $errors['passwords']);
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    Pakartoti slaptažodi:
                </td>
                <td>
                    <input type="text" name="password2"">
                </td>
                <td>
                    <?php
                    if (isset($errors['passwords_match'])) {
                        echo implode(', ', $errors['passwords_match']);
                    }
                    ?>
                </td>
            </tr>
        </table>
        <button type="submit">Atnaujinti</button>
    </form>

<?php } elseif ($page === 'register' || $page === 'save_user') { ?>
    <h1>Register</h1>
    <form action="index.php?page=save_user" method="post">
        <table>
            <tr>
                <td>
                    Vardas:
                </td>
                <td>
                    <input type="text" name="name" value="<?php echo $name ?? null ?>">
                </td>
                <td>
                    <?php
                    if (isset($errors['names'])) {
                        echo implode(', ', $errors['names']);
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    Lytis:
                </td>
                <td>
                    <select name="sex">
                        <option value="">-</option>
                        <option value="male" <?php if (isset($sex) == 'male') {
                            echo 'selected';
                        } ?>>
                            Male
                        </option>
                        <option value="female" <?php if (isset($sex) == 'female') {
                            echo 'selected';
                        } ?>>
                            Female
                        </option>
                    </select>
                </td>
                <td>
                    <?php
                    if (isset($errors['sex'])) {
                        echo implode(', ', $errors['sex']);
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    Metai:
                </td>
                <td>
                    <select name="age">
                        <option value="">-</option>
                        <?php for ($i = 14; $i <= 60; $i++) { ?>
                            <option value="<?php echo $i; ?>"
                                <?php
                                if (($age ?? null) == $i) {
                                    echo 'selected';
                                }
                                ?>
                            >
                                <?php echo $i ?>
                            </option>
                        <?php } ?>
                    </select>
                </td>
                <td>
                    <?php
                    if (isset($errors['age'])) {
                        echo implode(', ', $errors['age']);
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    Paštas:
                </td>
                <td>
                    <input type="text" name="email" value="<?php echo $email ?? null ?>">
                </td>
                <td>
                    <?php
                    if (isset($errors['emails'])) {
                        echo implode(', ', $errors['emails']);
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    Slaptažodis:
                </td>
                <td>
                    <input type="text" name="password">
                </td>
                <td>
                    <?php
                    if (isset($errors['passwords'])) {
                        echo implode(', ', $errors['passwords']);
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    Pakartoti slaptažodi:
                </td>
                <td>
                    <input type="text" name="password2"">
                </td>
                <td>
                    <?php
                    if (isset($errors['passwords_match'])) {
                        echo implode(', ', $errors['passwords_match']);
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    Saugos kodas (<?php echo $_SESSION['code'] ?>) :
                </td>
                <td>
                    <input type="text" name="code">
                </td>
                <td>
                    <?php
                    if (isset($errors['code'])) {
                        echo implode(', ', $errors['code']);
                    }
                    ?>
                </td>
            </tr>
        </table>
        <button type="submit">Išsaugoti</button>
    </form>
<?php } elseif ($page === 'about' || $page === 'save_about') { ?>
    <h1>About</h1>
    <?php

    if (isset($_SESSION['email'])) {
        ?>
        <form action="index.php?page=save_about" method="post">
            <textarea name="text_about" rows="4" cols="50"></textarea>
            <button type="submit">Išsaugoti</button>
        </form>
    <?php }
    $text = file_get_contents('./database/about');
    echo $text;
    ?>


<?php } elseif ($page === 'login' || $page == 'login_user') { ?>
    <h1>Login</h1>


    <?php if (!empty($errors)) { ?>
        <ul>
            <?php foreach ($errors as $error) { ?>
                <li>
                    <?php echo $error ?>
                </li>
            <?php } ?>
        </ul>
    <?php } ?>

    <form action="index.php?page=login_user" method="post">
        <table>
            <tr>
                <td>
                    Paštas:
                </td>
                <td>
                    <input type="text" name="email" value="<?php echo $_GET['email'] ?? null ?> ">
                </td>
                <td>
                    <?php
                    if (isset($errors['emails'])) {
                        echo implode(', ', $errors['emails']);
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    Slaptažodis:
                </td>
                <td>
                    <input type="text" name="password">
                </td>
                <td>
                    <?php
                    if (isset($errors['passwords'])) {
                        echo implode(', ', $errors['passwords']);
                    }
                    ?>
                </td>
            </tr>
        </table>
        <br/><br/>
        <button type="submit">Prisijungti</button>
    </form>
<?php } elseif ($page === 'save_user') { ?>
    <h1>saugoti useri</h1>
<?php } elseif ($page === 'login_user') { ?>
    <h1>login useri</h1>
<?php } ?>


<br/><br/>
<!--footer-->
<?php
echo date('Y-m-d H:i:s');
?>
</body>
</html>