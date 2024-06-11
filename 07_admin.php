<?php
session_start();
include('config.php');

if (!isset($_SESSION['tuvastamine']) || $_SESSION['tuvastamine'] != 'misiganes') {
    header('Location: 07_login.php');
    exit();
}

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $parool = $_POST['parool'];

    if (strlen($parool) < 6) {
        $message = "Parool peab sisaldama vähemalt 6 tähte";
    } else {
        // Ühendume andmebaasiga
        $yhendus = mysqli_connect($db_server, $db_kasutaja, $db_salasona, $db_andmebaas);
        // Kontrollime ühendust
        if (!$yhendus) {
            die("Ühenduse loomine ebaõnnestus: " . mysqli_connect_error());
        }

        $sql = "INSERT INTO kasutajad (login, parool) VALUES ('$login', '$parool')";

        if (mysqli_query($yhendus, $sql)) {
            $message = "Uus kasutaja on edukalt lisatud!";
        } else {
            $message = "Viga andmebaasi lisamisel: " . mysqli_error($yhendus);
        }

        mysqli_close($yhendus);
    }
}

?>

<h1>Registreeri uus kasutaja</h1>
<!-- HTML vorm kasutaja registreerimiseks -->
<form action="" method="post">
    Login: <input type="text" name="login"><br>
    Password: <input type="password" name="parool"><br>
    <input type="submit" value="Registreeri">
</form>

<!-- Kuvame veateate, kui parooli pikkus on alla 6 tähe -->
<?php if (!empty($message)) echo "<p>$message</p>"; ?>

<a href="07_logout.php">Logi välja</a>
