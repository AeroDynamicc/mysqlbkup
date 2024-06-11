<?php
session_start();

include('config.php'); // Lisame andmebaasi konfiguratsioonifaili

// Kasutaja registreerimise vormi töötlemine
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kasutajanimi = htmlspecialchars(trim($_POST['kasutajanimi']));
    $parool = htmlspecialchars(trim($_POST['parool']));
    $email = htmlspecialchars(trim($_POST['email']));

    // Parooli pikkuse kontroll
    if (strlen($parool) < 8) {
        echo "Parool peab olema vähemalt 8 tähemärki pikk.";
    } else {
        // Parooli krüpteerimine
        $hash = password_hash($parool, PASSWORD_DEFAULT);

        // Lisame kasutaja andmebaasi
        $query = "INSERT INTO kasutajad (kasutaja, parool, email) VALUES ('$kasutajanimi', '$hash', '$email')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "Uus kasutaja on edukalt registreeritud!";
        } else {
            echo "Kasutaja registreerimine ebaõnnestus. Palun proovi uuesti.";
        }
    }
}
?>

<h3>Tere tulemast admini lehele.</h3>
<h3>See administraatori leht on kaitstud.</h3>

<!-- Registreerimisvorm -->
<h2>Registreeri uus kasutaja</h2>
<form action="" method="post">
    <label for="kasutajanimi">Kasutajanimi:</label>
    <input type="text" id="kasutajanimi" name="kasutajanimi" required><br>
    <label for="parool">Parool:</label>
    <input type="password" id="parool" name="parool" required><br>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br>
    <input type="submit" value="Registreeri">
</form>
