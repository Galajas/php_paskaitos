<?php
$email = $_SESSION['email'];




$get_user = mysqli_query($database, "SELECT * FROM users WHERE email = '$email'");
$get_user = mysqli_fetch_array($get_user);

$name = $get_user['name'];
$age = $get_user['age'];
$sex = $get_user['sex'];
$password = $get_user['password'];
$credit = $get_user['credit'];
$credit_added = $get_user['credit_added'];


$action = $_GET['action'] ?? null;

if ($action == 'save') {
    $new_sex = $_POST['sex'];
    $new_name = $_POST['name'];
    $new_age = $_POST['age'];
    $new_password = $_POST['password'];
    $credit_post = $_POST['credit'];

    $errors = [];

    if (strlen($new_name) < 3 || strlen($new_name) > 60) {
        $errors['name'][] = 'vardas yra per ilgas arba per trumpas';
    }

    if (!in_array($new_sex, ['male', 'female'])) {
        $errors['sex'][] = 'bloga lytis';
    }

    if ($new_age < 14 || $new_age > 60) {
        $errors['age'][] = 'blogas amzius';
    }

    if (!empty($new_password)) {
        $password2 = $_POST['password2'];

        if (strlen($new_password) < 9) {
            $errors['password'][] = 'slaptazodis turi buti ilgesnis nei 9 simboliai';
        }

        if (!preg_match('/[A-Za-z]/', $new_password) || !preg_match('/[0-9]/', $new_password)) {
            $errors['password'][] = 'slaptazodyje turi buti raide ir skaicius';
        }

        if ($email == $new_password) {
            $errors['password'][] = 'slaptazodis ir emailas negali buti vienodi';
        }

        if ($new_password != $password2) {
            $errors['password2'][] = 'Slaprazodiai nesutampa';
        }
        $password = $new_password;
    }

    if (!empty($credit_post)) {
        $date = date('Y-m-d H:i:s');

        if (!empty($credit_added)) {
            $credit_added_plus = strtotime($credit_added) + 3600;
            $credit_added_plus = date('Y-m-d H:i:s', $credit_added_plus);


            if ($credit_added_plus < $date) {
                if ($credit_post < 0) {
                    $errors['credit'][] = 'Kreditai negali buti maziau nei 0';
                }
                $credit = $credit + $credit_post;
                $credit_added = $date;
            } else {
                $errors['credit'][] = "Negalite prideti kreditu, kreditus galesite prideti $credit_added_plus";
            }
        } else {
            if ($credit_post < 0) {
                $errors['credit'][] = 'Kreditai negali buti maziau nei 0';
            }
            $credit = $credit + $credit_post;
            $credit_added = $date;
        }
    }

    if (empty($errors)) {
        $sql = "update users set name = '$new_name', age = '$new_age', sex = '$new_sex', password = '$password', credit = '$credit', credit_added = '$credit_added'  where email = '$email'";
        mysqli_query($database, $sql);
        header('Location: index.php?page=settings');
    }
}
?>
<h1>Nustatymai</h1>
<form action="index.php?page=settings&action=save" method="post">
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
                Slapta??odis:
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
                Pakartoti slapta??odi:
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
                Prideti kreditu:
            </td>
            <td>
                <input type="number" name="credit">
            </td>
            <td>
                <?php
                if (isset($errors['credit'])) {
                    echo implode(',', $errors['credit']);
                }
                ?>
            </td>
        </tr>
    </table>
    <button type="submit">I??saugoti</button>
</form>