<?php
session_start();
if (isset($_SESSION['loggedin'])) {
    unset($_COOKIE['rememberme']);
    setcookie('rememberme', '', time() - 3600);
    unset($_SESSION['loggedin']);
    unset($_SESSION['voornaam']);
    unset($_SESSION['achternaam']);
    unset($_SESSION['user_id']);
    unset($_SESSION['user_level']);
    session_destroy();

    header('Location: index.php');
    exit();
}
?>
