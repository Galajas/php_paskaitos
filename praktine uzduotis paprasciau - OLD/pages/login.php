<?php
if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $errors = [];

    if (empty($email) || empty($password)) {
        $errors[] = 'Yra tusciu lauku';
    }

    if (!file_exists(DATABASE_USERS_PATH . $email)) {
        $errors[] = 'Pasto nera';
    } else {
        $user = file_get_contents(DATABASE_USERS_PATH . $email);
        if($user){
            $user = explode('|', $user);

            if ($password != $user[3]) {
                $errors[] = 'blogas slaptazodis';
            }
        }
    }

    if (empty($errors)) {
        $_SESSION['email'] = $email;
        header('Location: index.php');
    }
}
?>
<h1>Login</h1>
<ul>
    <?php
    if (isset($errors)) {
        foreach ($errors as $error) {
            ?>
            <li>
                <?php echo $error ?>
            </li>
        <?php }
    } ?>
</ul>
<form action="index.php?page=login" method="post">
    <table>
        <tr>
            <td>
                Paštas:
            </td>
            <td>
                <input type="text" name="email" value="<?php echo $_GET['email'] ?? null ?>">
            </td>
        </tr>
        <tr>
            <td>
                Slaptažodis:
            </td>
            <td>
                <input type="password" name="password">
            </td>
        </tr>
    </table>
    <br/><br/>
    <button type="submit">Prisijungti</button>
</form>