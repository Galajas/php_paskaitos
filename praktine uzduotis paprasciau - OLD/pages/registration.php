<?php
if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $sex = $_POST['sex'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $code = $_POST['code'];

    $errors = [];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'][] = 'Neteisingas el. pastas';
    }

    if (strlen($password) < 9) {
        $errors['password'][] = 'slaptazodis turi buti ilgesnis nei 9 simboliai';
    }

    if (!preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password)) {
        $errors['password'][] = 'slaptazodyje turi buti raide ir skaicius';
    }

    if (!in_array($sex, ['male', 'female'])) {
        $errors['sex'][] = 'bloga lytis';
    }

    if (strlen($name) < 3 || strlen($name) > 60) {
        $errors['name'][] = 'vardas yra per ilgas arba per trumpas';
    }

    if ($email == $password) {
        $errors['password'][] = 'slaptazodis ir emailas negali buti vienodi';
    }

    if ($password != $password2) {
        $errors['password2'][] = 'Slaprazodiai nesutampa';
    }

    if ($age < 14 || $age > 60) {
        $errors['age'][] = 'blogas amzius';
    }

    if (file_exists(DATABASE_USERS_PATH . $email)) {
        $errors['email'][] = 'Pastas uzimtas';
    }

    if ($_SESSION['code'] != $code) {
        $errors['code'] = 'Blogas saugos kodas';
    }

    if (empty($errors)) {
        if (file_put_contents(DATABASE_USERS_PATH . $email, implode('|', [$name, $age, $sex, $password])) === false) {
            echo 'Nepavyko sukurti vartotojo';
        } else {
            header('Location: index.php?page=login&email=' . $email);
        }
    }
}
$_SESSION['code'] = rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
?>
<h1>Register</h1>
<form action="index.php?page=register" method="post">
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
                if (isset($errors['name'])) {
                    echo implode(',', $errors['name']);
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
                    <option value="male"
                        <?php
                        if (($sex ?? null) == 'male') {
                            echo 'selected';
                        }
                        ?>
                    >
                        Male
                    </option>
                    <option value="female"
                        <?php
                        if (($sex ?? null) == 'female') {
                            echo 'selected';
                        }
                        ?>
                    >
                        Female
                    </option>
                    Female
                    </option>
                </select>
            </td>
            <td>
                <?php
                if (isset($errors['sex'])) {
                    echo implode(',', $errors['sex']);
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
                    echo implode(',', $errors['age']);
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
                if (isset($errors['email'])) {
                    echo implode(',', $errors['email']);
                }
                ?>
            </td>
        </tr>
        <tr>
            <td>
                Slaptažodis:
            </td>
            <td>
                <input type="password" name="password">
            </td>
            <td>
                <?php
                if (isset($errors['password'])) {
                    echo implode(',', $errors['password']);
                }
                ?>
            </td>
        </tr>
        <tr>
            <td>
                Pakartoti slaptažodi:
            </td>
            <td>
                <input type="password" name="password2">
            </td>
            <td>
                <?php
                if (isset($errors['password2'])) {
                    echo implode(',', $errors['password2']);
                }
                ?>
            </td>
        </tr>
        <tr>
            <td>
                Saugos kodas: <?php echo $_SESSION['code'] ?>
            </td>
            <td>
                <input type="text" name="code">
            </td>
            <td>
                <?php
                if (isset($errors['code'])) {
                    echo $errors['code'];
                }
                ?>
            </td>
        </tr>
    </table>
    <button type="submit">Registruotis</button>
</form>