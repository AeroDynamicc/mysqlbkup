<?php include('config.php'); ?>
<?php
session_start();

// Kontrollime, kas kasutaja on juba sisse loginud
if (isset($_SESSION['tuvastamine'])) {
   header('Location: 07_admin.php');
   exit();
}

// Kontrollime, kas POST meetodiga saadetud andmed on saadaval
if (!empty($_POST['login']) && !empty($_POST['pass'])) {
    // Eemaldame kasutaja sisestusest kahtlase pahna
    $login = htmlspecialchars(trim($_POST['login']));
    $pass = htmlspecialchars(trim($_POST['pass']));

    // Uue kontrolli lisamine: kasutajanime unikaalsuse kontroll
    $query_username = "SELECT COUNT(*) FROM kasutajad WHERE kasutaja='$login'";
    $result_username = mysqli_query($yhendus, $query_username);
    $row_username = mysqli_fetch_array($result_username);
    $count_username = $row_username[0];
    
    if ($count_username > 0) {
        echo "Sellise kasutajanimega kasutaja on juba olemas. Palun vali teine kasutajanimi.";
    } else {
        // Parooli pikkuse kontroll
        if (strlen($pass) < 8) {
            echo "Parool peab olema vähemalt 8 tähemärki pikk.";
        } else {
            // Parooli krüpteerimine
            $sool = 'taiestisuvalinetekst';
            $kryp = crypt($pass, $sool);

            // Kontrollime kas andmebaasis on selline kasutaja ja parool
            $paring = "SELECT * FROM kasutajad WHERE kasutaja='$login' AND parool='$kryp'";
            $valjund = mysqli_query($yhendus, $paring);

            // Kui on, siis loome sessiooni ja suuname
            if (mysqli_num_rows($valjund) == 1) {
                $_SESSION['tuvastamine'] = 'misiganes';
                header('Location: 07_admin.php');
                exit();
            } else {
                echo "Kasutajanimi või parool on vale.";
            }
        }
    }
}
?>
<h1>Login</h1>
<form action="" method="post">
    Login: <input type="text" name="login"><br>
    Password: <input type="password" name="pass"><br>
    <input type="submit" value="Logi sisse">
</form>
