<?php
session_start();
$page = $_GET['page'] ?? null;
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>
<body>
<div class="container">
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
        <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
            <li><a href="index.php" class="nav-link px-2 link-secondary">Home</a></li>
            <li><a href="index.php?page=about" class="nav-link px-2 link-dark">About</a></li>
        </ul>

        <div class="col-md-3 text-end">
            <?php if (isset($_SESSION['email'])) { ?>
                <a href="index.php?page=logout" class="btn btn-outline-primary me-2">Logout</a>
            <?php } else { ?>
                <a href="index.php?page=login" class="btn btn-outline-primary me-2">Login</a>
                <a href="index.php?page=register" class="btn btn-outline-primary me-2">Register</a>
            <?php } ?>
        </div>
    </header>
</div>
<div class="container col-xl-10 col-xxl-8 px-4 py-5">
    <?php

    switch ($page) {
        case null:
            ?>
            <h1>Home</h1>
            <?php
            break;
        case 'login':
            ?>
            <h1>Login</h1>
            <div class="row align-items-center g-lg-5 py-5">
                <div class="col-md-12 mx-auto col-lg-12">
                    <form class="p-4 p-md-5 border rounded-3 bg-light" action="index.php?page=login_submit" method="post">
                        <div class="form-floating mb-3">
                            <input name="email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                            <label for="floatingInput">Email address</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password">
                            <label for="floatingPassword">Password</label>
                        </div>
                        <button class="w-100 btn btn-lg btn-primary" type="submit">Login</button>
                    </form>
                </div>
            </div>
            <?php
            break;
        case 'register':
            ?>
            <h1>Register</h1>
            <div class="row align-items-center g-lg-5 py-5">
                <div class="col-md-12 mx-auto col-lg-12">
                    <form class="p-4 p-md-5 border rounded-3 bg-light" action="index.php?page=register_submit" method="post">
                        <div class="form-floating mb-3">
                            <input name="email" type="text" class="form-control" id="floatingInput" placeholder="name@example.com">
                            <label for="floatingInput">Email address</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password">
                            <label for="floatingPassword">Password</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input name="repeat_password"  type="password" class="form-control" id="floatingPassword" placeholder="Password">
                            <label for="floatingPassword">Repeat Password</label>
                        </div>
                        <button class="w-100 btn btn-lg btn-primary" type="submit">Register</button>
                    </form>
                </div>
            </div>
            <?php
            break;
        case 'about':
            ?>
            <h1>About</h1>
            <form action="index.php?page=about_submit" method="post">
                <div class="form-row">
                    <div class="col">
                        <input name="city" type="text" class="form-control" placeholder="City">
                    </div>
                    <div class="col">
                        <input name="state" type="text" class="form-control" placeholder="State">
                    </div>
                    <div class="col">
                        <input name="about" type="text" class="form-control" placeholder="About you">
                    </div>
                </div>
                <button class="w-100 btn btn-lg btn-primary" type="submit">Save info</button>

            </form>

            <?php
            break;

        case 'about_submit':
            $email = $_SESSION['email'] ?? null;
            $city = $_POST['city'] ?? null;
            $state = $_POST['state'] ?? null;
            $about = $_POST['about'] ?? null;

//            var_dump($email);


            $errors = [];

            if ($city == '' && $state == '' && $about == '') {
                $errors[] = 'Some of inputs is missing';
            }

            if ($email == null) {
                $errors[] = 'Need log in';
            }

            if (!empty($errors)) {
                echo '<pre>';
                print_r($errors);
                echo '</pre>';
            } else {
                file_put_contents(__DIR__ . "/database/users/$email about", $city . '|' . $state . '|' . '|' . $about);
                echo '<pre>';
                echo 'user created';
                echo '</pre>';
            }

            break;

        case 'register_submit':
            $email = $_POST['email'] ?? null;
            $password = $_POST['password'] ?? null;
            $repeat_password = $_POST['repeat_password'] ?? null;

            $errors = [];

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Email is wrong';
            }

            if (file_exists(__DIR__ . "/database/users/$email")) {
                $errors[] = 'Email is taken';
            }

            if (strlen($password) < 7) {
                $errors[] = 'Password too short';
            }

            if ($password != $repeat_password) {
                $errors[] = 'Passwords not match';
            }

            if (!empty($errors)) {
                echo '<pre>';
                print_r($errors);
                echo '</pre>';
            } else {
                file_put_contents(__DIR__ . "/database/users/$email", $password);
                echo 'user created';
            }
            break;
        case 'login_submit':
            $email = $_POST['email'] ?? null;
            $password = $_POST['password'] ?? null;

            $user_password = file_get_contents(__DIR__ . "/database/users/$email");

            $errors = [];

            if (!file_exists(__DIR__ . "/database/users/$email")) {
                $errors[] = 'Email not found';
            }

            if ($password != $user_password) {
                $errors[] = 'Wrong passsword';
            }

            if (!empty($errors)) {
                echo '<pre>';
                print_r($errors);
                echo '</pre>';
            } else {
                $_SESSION['email'] = $email;
                header('Location: index.php');
            }
            break;
        case 'logout':
            session_destroy();
            header('Location: index.php');
            break;
    }

    if (isset($_SESSION['email'])) {
        echo '<pre>';
        echo 'prisijunges';
        echo '</pre>';
    } else {
        echo '<pre>';
        echo 'atsijunges';
        echo '</pre>';
    }
    ?>
</div>

<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>

<!-- Option 2: Separate Popper and Bootstrap JS -->
<!--
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
-->
</body>
</html>
