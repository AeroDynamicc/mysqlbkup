<?php
$servername = "localhost";
$username = "muusikapood";
$password = "";
$dbname = "muusikapood";

// Loome ühenduse
$conn = new mysqli($servername, $username, $password, $dbname);

// Kontrollime ühendust
if ($conn->connect_error) {
    die("Ühenduse loomine ebaõnnestus: " . $conn->connect_error);
}
?>
