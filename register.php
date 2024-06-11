<?php
$servername = "localhost";
$username = "root"; // Teie MySQL kasutajanimi
$password = "admin"; // Teie MySQL parool
$dbname = "kasutajadDB";

// Loo ühendus
$conn = new mysqli($servername, $username, $password, $dbname);

// Kontrolli ühendust
if ($conn->connect_error) {
    die("Ühenduse loomine ebaõnnestus: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kasutajanimi = trim($_POST['kasutajanimi']);
    $parool = $_POST['parool'];
    $email = trim($_POST['email']);

    // Kontrolli parooli pikkust
    if (strlen($parool) < 8) {
        die("Parool peab olema vähemalt 8 tähemärki pikk.");
    }

    // Kontrolli, kas kasutajanimi juba eksisteerib
    $stmt = $conn->prepare("SELECT COUNT(*) FROM kasutajad WHERE kasutajanimi = ?");
    $stmt->bind_param("s", $kasutajanimi);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        die("Kasutajanimi on juba kasutusel.");
    }

    // Krüpteeri parool ja lisa uus kasutaja andmebaasi
    $hashed_password = password_hash($parool, PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO kasutajad (kasutajanimi, parool, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $kasutajanimi, $hashed_password, $email);

    if ($stmt->execute()) {
        echo "Uus kasutaja on edukalt registreeritud.";
    } else {
        echo "Viga: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
