<h1>Atspek skaiciu</h1>

<?php
$numbers = file_get_contents(DATABASE_NUMBERS);

$email = $_SESSION['email'];
$user_data = file_get_contents(DATABASE_USERS_PATH . $email);
$data_explode = explode("|", $user_data);
$user_name = $data_explode[0];
$user_age = $data_explode[1];
$user_sex = $data_explode[2];
$user_password = $data_explode[3];
$user_credits = $data_explode[4];


if (isset($_POST['number'])) {
    $guessed_number = $_POST['number'];
    $used_credits = $_POST['credit'];
    $date = date('Y-m-d H:i:s');

    $errors = [];

    if (empty($errors)) {

        if (($guessed_number < 0) || !is_numeric($guessed_number) ) {
            $errors[] = 'Negalimas spejamas skaicius';
        } else {
            $rand_digit = rand(0, 10);

            if ($guessed_number == $rand_digit) {
                $result = 'Atspejo';

            } else {
                $result = 'Neatspejo';
            }
            $new_try = [$_SESSION['email'], $guessed_number, $rand_digit, $result, $date];
            $new_try = implode('|', $new_try);


            if (!empty($numbers)) {
                $numbers = $new_try . "\n" . $numbers;
            } else {
                $numbers = $new_try;
            }

            file_put_contents(DATABASE_NUMBERS, $numbers);
        }

        if (($used_credits < 0) || !is_numeric($used_credits)) {
            $errors[] = 'Negalimas kreditu kiekis';
        } else {


            if ($guessed_number == $rand_digit) {
                $user_credits = $user_credits + $used_credits * 2;
                echo 'Laimejote ' . $used_credits * 2;
                $userData = implode('|', [$user_name, $user_age, $user_sex, $user_password, $user_credits]);

            } else {
                $user_credits = $user_credits - $used_credits;
                echo 'Pralaimejote ' . $used_credits;
                $userData = implode('|', [$user_name, $user_age, $user_sex, $user_password, $user_credits]);
            }

            file_put_contents(DATABASE_USERS_PATH . $email, $userData);
        }
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
    <table>
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
        </tr>

        <?php

        if (!empty($numbers)) {

            $winners = explode("\n", $numbers);

            $winners_array = [];
            for ($i = 0; $i < count($winners); $i++) {
                $winners_exp = explode('|', $winners[$i]);

                if ($winners_exp[3] == 'Atspejo') {
                    array_push($winners_array, $winners_exp[0]);
                }
            }
            $winners_array_sorted = array_count_values($winners_array);

            arsort($winners_array_sorted);

            $winners_key = array_keys($winners_array_sorted);

            for ($i = 0; $i < 3; $i++) {
                $email = $winners_key[$i];
                $user_data = file_get_contents(DATABASE_USERS_PATH . $email);
                $data_explode = explode("|", $user_data);
                $user_name = $data_explode[0];

                if ($i < count($winners_key)) {
                    $winners_result = $winners_array_sorted[$winners_key[$i]];

                    $percentage = $winners_result * (100 / count($winners_array));
                    ?>
                    <tr>
                        <td>
                            <?php echo $i + 1 ?>.
                        </td>
                        <td>
                            <?php echo $user_name ?>
                        </td>
                        <td>
                            <?php echo $winners_result ?>
                        </td>
                        <td>
                            <?php echo round($percentage) ?>%
                        </td>
                    </tr>

                <?php }
            }
        } ?>
    </table>
</fieldset>
<br/>
<br/>
<fieldset>
    <legend>Skaiciu tikimybes</legend>

    <table>
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
        <tr>
            <?php

            if (!empty($numbers)) {
            $probability = explode("\n", $numbers);
            $probability_array = [];
            for ($i = 0; $i < count($probability); $i++) {
                $probability_exp = explode('|', $probability[$i]);

                array_push($probability_array, $probability_exp[2]);
            }


            $probability_array_filtered = array_count_values($probability_array);
            arsort($probability_array_filtered);

            foreach ($probability_array_filtered

            as $id => $probability) {
            $percentage = $probability * (100 / count($probability_array));
            ?>
        <tr>

            <td>
                <?php echo $id ?>
            </td>
            <td>
                <?php echo $probability ?>
            </td>
            <td>
                <?php echo round($percentage) ?>%
            </td>
        </tr>

        <?php }
        } ?>
        </tr>
    </table>
</fieldset>
<br/>
<br/>
<fieldset>
    <legend>Spejimu istorija</legend>
    <table>
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
                Data
            </th>
        </tr>

        <?php


        if (!empty($numbers)) {
            $numbers_array = explode("\n", $numbers);


            foreach ($numbers_array as $data) {
                $data = explode('|', $data);

                $email = $data[0];
                $user_data = file_get_contents(DATABASE_USERS_PATH . $email);
                $data_explode = explode("|", $user_data);
                $user_name = $data_explode[0];

                ?>
                <tr>
                    <td>
                        <?php echo $user_name ?>
                    </td>
                    <td>
                        <?php echo $data[1] ?>
                    </td>
                    <td>
                        <?php echo $data[2] ?>
                    </td>
                    <td>
                        <?php echo $data[3] ?>
                    </td>
                    <td>
                        <?php echo $data[4] ?>
                    </td>
                </tr>
            <?php }
        } ?>

    </table>
</fieldset>