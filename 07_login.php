<?php
session_start();
include('config.php');
// Kontrollime, kas kasutaja on juba sisse logitud
if (isset($_SESSION['tuvastamine'])) {
    header('Location: 07_admin.php');
    exit();
}

// Kui login ja parool on saadetud
if (!empty($_POST['login']) && !empty($_POST['pass'])) {
    $login = $_POST['login'];
    $pass = $_POST['pass'];

    // Kontrollime, kas login ja parool on õiged
    if ($login == 'admin' && $pass == 'admin') {
        // Kui on, siis luuakse sessioon ja suunatakse admin lehele
        $_SESSION['tuvastamine'] = 'misiganes';
        header('Location: 07_admin.php');
        exit();
    } else {
        // Kui ei, siis kuvatakse vastav sõnum
        $message = "Vale login või parool, sisesta uuesti";
    }
}
?>

<h1>Login</h1>
<!-- Kui midagi läheb valesti, kuvatakse siin sõnum -->
<?php if (!empty($message)) echo "<p>$message</p>"; ?>

<form action="" method="post">
    Login: <input type="text" name="login"><br>
    Password: <input type="password" name="pass"><br>
    <input type="submit" value="Logi sisse">
</form>
