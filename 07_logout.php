<?php
session_start();
include('config.php');
if (!isset($_SESSION['tuvastamine'])) {
    header('Location: 07_login.php');
    exit();
}

// Logi välja
session_destroy();

// Suuna tagasi login lehele
header('Location: 07_login.php');
exit();
?>
