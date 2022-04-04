<?php

$submit = $_GET['forma'] ?? null;

// ijungti klaidu pranesimus
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// jungiames prie duomenu bazes
$database = mysqli_connect('127.0.0.1', 'root', '', 'plovykla');

// Tikrinam ar pavyko prisijungti prie duomenu bazes
if (!$database) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($submit == 'create_service') {
    $service = $_POST['paslauga'];
    $price = $_POST['kaina'];
    $sql = "insert into paslaugos (pavadinimas,kaina) value ('$service', '$price')";
    mysqli_query($database, $sql);
    header('Location: plovykla.php');
}

if ($submit == 'create_employee') {
    $name = $_POST['vardas'];
    $sql = "insert into darbuotojai (vardas) value ('$name')";
    mysqli_query($database, $sql);
    header('Location: plovykla.php');
}

if ($submit == 'rezervation') {

    $vardas = $_POST['vardas'];
    $masinos_numeris = $_POST['masinos_numeris'];
    $paslaugosId = $_POST['service_id'];
    $darbuotojoId = $_POST['employee_id'];
    $data = $_POST['date'];
    $valanda = $_POST['time'];
    $data_su_laiku = $data . ' ' . $valanda;


    $rezervacijos = mysqli_fetch_all(
        mysqli_query($database, 'select * from rezervacijos'),
        MYSQLI_ASSOC
    );

    $errors = [];

    foreach ($rezervacijos as $rez) {
        if ($rez["data"] == $data_su_laiku && $rez["darbuotojas"] == $darbuotojoId) {
            $errors = 'Darbuotojas tuo metu uzimtas';
        }
    }

    if (empty($errors)) {
        $a = mysqli_query(
            $database,
            "insert into rezervacijos (rekvizitai, paslauga, data, car_numeriai,darbuotojas) value ('$vardas', '$paslaugosId', '$data_su_laiku', '$masinos_numeris','$darbuotojoId')"
        );
        header('Location: plovykla.php');
    } else {
//        header('Location: plovykla.php');
        echo $errors;
    }
}
?>


<form action="plovykla.php?forma=create_service" method="post">
    <fieldset>
        <legend>Paslaugos kurimas:</legend>

        <label for="service">Paslauga:</label>
        <input type="text" id="service" name="paslauga">
        <br>

        <label for="price">Kaina:</label>
        <input type="text" id="price" name="kaina">
        <br>

        <input type="submit" value="Sukurti">
    </fieldset>
</form>

<form action="plovykla.php?forma=create_employee" method="post">
    <fieldset>
        <legend>Prideti darbuotoja:</legend>
        <label for="name">Vardas:</label>
        <input type="text" id="name" name="vardas">
        <br>
        <input type="submit" value="Prideti">
    </fieldset>
</form>

<?php
$darbuotojai = mysqli_fetch_all(
    mysqli_query($database, 'select * from darbuotojai'),
    MYSQLI_ASSOC
);
$paslaugos = mysqli_fetch_all(
    mysqli_query($database, 'select * from paslaugos'),
    MYSQLI_ASSOC
);
?>
<form action="plovykla.php?forma=rezervation" method="post">
    <fieldset>
        <legend>Rezervacija:</legend>
        <label for="name">Vardas:</label>
        <input type="text" id="name" name="vardas">
        <br>
        <label for="car_number">Masinos numeris:</label>
        <input type="text" id="car_number" name="masinos_numeris">
        <br>
        <label for="service">Paslauga:</label>
        <select id="service" name="service_id">
            <?php foreach ($paslaugos as $paslauga) { ?>
                <option value="<?php echo $paslauga['id'] ?>"><?php echo $paslauga['pavadinimas'] ?></option>
            <?php } ?>
        </select>
        <br>
        <label for="employee">Darbuotojas:</label>
        <select id="employee" name="employee_id">
            <?php foreach ($darbuotojai as $darbuotojas) { ?>
                <option value="<?php echo $darbuotojas['id'] ?>"><?php echo $darbuotojas['vardas'] ?></option>
            <?php } ?>
        </select>
        <br>
        <label for="date">Data:</label>
        <input type="date" id="date" name="date">
        <br>
        <label for="time">Laikas:</label>

        <select id="time" name="time">
            <option value="">-</option>
            <?php for ($i = 8; $i <= 17; $i++) { ?>
                <option value="<?php echo $i . ':00'; ?>"
                >
                    <?php echo $i . ':00' ?>
                </option>
            <?php } ?>
        </select>

        <br>
        <input type="submit" value="Rezervuoti">
    </fieldset>
</form>

<fieldset>
    <legend>Darbotvarke:</legend>
    <table>
        <tr>
            <th>
                Data
            </th>
            <th>
                Darbuotojas
            </th>
            <th>
                Paslauga
            </th>
            <th>
                Uzsakovas
            </th>
            <th>
                Automobilio nr.
            </th>
        </tr>

        <?php
        $filter_rez = mysqli_fetch_all(
            mysqli_query($database, 'SELECT * FROM rezervacijos WHERE data BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 3 DAY) order by data'),
            MYSQLI_ASSOC
        );

        foreach ($filter_rez as $rez) {
            $rez_data = $rez["data"];
            $darbuotojas_id = $rez["darbuotojas"];
            $darbuotojas = mysqli_fetch_array(mysqli_query($database, "select vardas from darbuotojai where id = '$darbuotojas_id'"), MYSQLI_ASSOC);
            $paslauga_id = $rez["paslauga"];
            $paslauga = mysqli_fetch_array(mysqli_query($database, "select pavadinimas from paslaugos where id = '$paslauga_id'"), MYSQLI_ASSOC);
            $uzsakovas = $rez["rekvizitai"];
            $auto_nr = $rez["car_numeriai"];
            ?>
            <tr>
                <td>
                    <?php echo $rez_data ?>
                </td>
                <td>
                    <?php echo $darbuotojas["vardas"] ?>
                </td>
                <td>
                    <?php echo $paslauga["pavadinimas"] ?>
                </td>
                <td>
                    <?php echo $uzsakovas ?>
                </td>
                <td>
                    <?php echo $auto_nr ?>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>
</fieldset>