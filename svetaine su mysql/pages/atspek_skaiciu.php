<h1>Atspek skaiciu</h1>
<style>
    .table th, .table td {
        border: 1px solid black;
        border-collapse: collapse;
        padding: 10px;
    }
</style>

<?php
$email = $_SESSION['email'];

$get_user = mysqli_query($database, "SELECT * FROM users WHERE email = '$email'");
$get_user = mysqli_fetch_all($get_user, MYSQLI_ASSOC);

//echo '<pre>';
//var_dump($get_user[0]);

$user_name = $get_user[0]["name"];
$user_age = $get_user[0]["age"];
$user_sex = $get_user[0]["sex"];
$user_password = $get_user[0]["email"];
$user_credits = $get_user[0]["credit"];


if (isset($_POST['number'])) {
    $guessed_number = $_POST['number'];
    $used_credits = $_POST['credit'];


    $errors = [];

    if (($guessed_number < 0) || !is_numeric($guessed_number) || $guessed_number > 10) {
        $errors[] = 'Negalimas spejamas skaicius';
    }

    if (($used_credits < 1) || !is_numeric($used_credits)) {
        $errors[] = 'Negalimas kreditu kiekis';
    }

    if (($used_credits > $user_credits)) {
        $errors[] = 'Neturite tiek kreditu';
    }



    if (empty($errors)) {
        $rand_digit = rand(0, 10);

        if ($guessed_number == $rand_digit) {
            $result = 'win';
            $win = $used_credits * 2;
            $user_credits = $user_credits + $win;
            echo 'Laimejote ' . $win;

        } else {
            $result = 'loss';
            $win = -$used_credits;
            $user_credits = $user_credits - $used_credits;
            echo 'Pralaimejote ' . $used_credits;
        }
        $sql_for_users = "update users set credit = '$user_credits' where email = '$email'";
        $sql_for_games = "insert into game_history (user_id, guesed_number, lucky_number, result, winnings) value ('$email', '$guessed_number', '$rand_digit', '$result', '$win')";

        mysqli_query($database, $sql_for_games);
        mysqli_query($database, $sql_for_users);
    }
}


if (isLoged() === true) {

    if (isset($errors)) {
        foreach ($errors as $error) {
            ?>
            <li>
                <?php echo $error ?>
            </li>
        <?php }
    } ?>

    <form action="index.php?page=spek_skaiciu" method="post">
        <table>
            <?php
            if ($user_credits >= 0) { ?>
            <tr>
                <td>
                    Jus turite kreditu: <?php echo $user_credits ?>.
                </td>
            </tr>
            <tr>
                <td>
                    Kiek naudoti kreditu:
                </td>
                <td>
                    <input type="number" name="credit">
                </td>
            </tr>
            <tr>
                <td>
                    Spejamas skaicius
                </td>
                <td>
                    <input type="number" name="number">
                </td>
            </tr>
        </table>
        <button type="submit">Speti</button>
        <?php } else {
            ?>
            <tr>
                <td>
                    Jus neturite kreditu, prasome prideti
                </td>
            </tr>
            </table>
        <?php }
        ?>

    </form>

<?php } ?>
<br/>

<br/>
<fieldset>
    <legend>Top 3 daugiausiai atspejo</legend>
    <table class="table">
        <tr>
        <tr>
            <th>
                Vieta
            </th>
            <th>
                Vardas
            </th>
            <th>
                Laimejimai
            </th>
            <th>
                Tikimybe, kad atspes
            </th>
            <th>
                Is viso yra laimejas kreditu.
            </th>
            <th>
                Is viso yra pralaimejas kreditu.
            </th>
        </tr>
        <?php
        $get_games_history = mysqli_fetch_all(mysqli_query($database, "select count(result) as games, sum(case when result = 'win' then 1 else 0 end) as wins, user_id from game_history group by user_id order by wins desc limit 3"), MYSQLI_ASSOC);

        foreach ($get_games_history as $id => $game) {
            $user = $game["user_id"];
            $user_name = mysqli_fetch_row(mysqli_query($database, "select name from users where email = '$user'"))[0];
            $user_winnings_credits = mysqli_fetch_array(mysqli_query($database, "select user_id, sum(case when result = 'win' then winnings else 0 end) as allWins from game_history where user_id = '$user'"))["allWins"];
            $user_loss_credits = mysqli_fetch_array(mysqli_query($database, "select user_id, sum(case when result = 'loss' then winnings else 0 end) as allLoss from game_history where user_id = '$user'"))["allLoss"];
            $games = $game["games"];
            $wins = $game["wins"];
            $probability = round(intval($wins) * (100 / intval($games)));
            ?>
            <tr>
                <td>
                    <?php echo ++$id ?>.
                </td>
                <td>
                    <?php echo $user_name ?>
                </td>
                <td>
                    <?php echo $wins ?>
                </td>
                <td>
                    <?php echo $probability ?> %
                </td>
                <td>
                    <?php echo $user_winnings_credits ?>
                </td>
                <td>
                    <?php echo $user_loss_credits ?>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>
</fieldset>
<br/>
<br/>
<fieldset>
    <legend>Skaiciu tikimybes</legend>
    <table class="table">
        <tr>
            <th>
                Skaicius
            </th>
            <th>
                Kiek kartų krito
            </th>
            <th>
                Tikimybe
            </th>
        </tr>

        <?php
        $get_filtered_games_history = mysqli_fetch_all(mysqli_query($database, "select lucky_number, count(lucky_number) as times from game_history group by lucky_number"), MYSQLI_ASSOC);
        $get_all_games_count = mysqli_fetch_array(mysqli_query($database, "select id, count(id) as allGames from game_history"), MYSQLI_ASSOC);
        $get_all_games_count = intval($get_all_games_count["allGames"]);

        foreach ($get_filtered_games_history as $game) {
            $digit = intval($game["lucky_number"]);
            $times = intval($game["times"]);
            $probability = round($times * (100 / $get_all_games_count));

            ?>
            <tr>
                <td>
                    <?php echo $digit ?>.
                </td>
                <td>
                    <?php echo $times ?>
                </td>
                <td>
                    <?php echo $probability ?> %
                </td>
            </tr>
            <?php
        }
        ?>
    </table>
</fieldset>
<br/>
<br/>
<fieldset>
    <legend>Spejimu istorija</legend>
    <table class="table">
        <tr>
            <th>
                Vardas
            </th>
            <th>
                Spetas skaicius
            </th>
            <th>
                Teisingas skaicius
            </th>
            <th>
                Rezultatas
            </th>
            <th>
                Laimėjimas
            </th>
            <th>
                Data
            </th>
        </tr>

        <?php
        $get_all_games = mysqli_fetch_all(mysqli_query($database, "select * from game_history group by created_at desc"), MYSQLI_ASSOC);

        foreach ($get_all_games as $game) {
            $user = $game["user_id"];
            $user_name = mysqli_fetch_row(mysqli_query($database, "select name from users where email = '$user'"))[0];

            $guesed_number = $game["guesed_number"];
            $lucky_number = $game["lucky_number"];
            $result = $game["result"];
            $winnings = $game["winnings"];
            $created = $game["created_at"];

            ?>
            <tr>
                <td>
                    <?php echo $user_name ?>.
                </td>
                <td>
                    <?php echo $guesed_number ?>
                </td>
                <td>
                    <?php echo $lucky_number ?>
                </td>
                <td>
                    <?php echo $result ?>
                </td>
                <td>
                    <?php echo $winnings ?>
                </td>
                <td>
                    <?php echo $created ?>
                </td>
            </tr>
            <?php
        }
        ?>

    </table>
</fieldset>