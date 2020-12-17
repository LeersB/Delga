<?php
include 'main.php';
if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// Now we check if the data was submitted, isset() function will check if the data exists.
if (!isset($_POST['email'], $_POST['wachtwoord'], $_POST['cwachtwoord'])) {
    exit('Vervolledig het registratie formulier!');
}
// Make sure the submitted registration values are not empty.
if (empty($_POST['email']) || empty($_POST['wachtwoord']) || empty($_POST['voornaam']) || empty($_POST['achternaam']) || empty($_POST['adres_straat']) || empty($_POST['adres_nr']) || empty($_POST['adres_postcode']) || empty($_POST['adres_plaats'])) {
    exit('Vervolledig het registratie formulier!');
}
// Check to see if the email is valid.
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    exit('E-mailadres is niet geldig!');
}
// Password must be between 5 and 20 characters long.
if (strlen($_POST['wachtwoord']) > 16 || strlen($_POST['wachtwoord']) < 8) {
    exit('Wachtwoord moet tussen 8 en 16 karakters lang zijn!');
}
// Check if both the password and confirm password fields match
if ($_POST['cwachtwoord'] != $_POST['wachtwoord']) {
    exit('Wachtwoorden komen niet overeen!');
}
// We need to check if the account with that username exists.
$stmt = $con->prepare('SELECT user_id, wachtwoord FROM users WHERE email = ?');
$stmt->bind_param('s', $_POST['email']);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    echo 'Dit e-mailadres bestaat al!';
} else {
    $stmt->close();
    $stmt = $con->prepare('INSERT INTO users (email, wachtwoord, activatie_code, registratie_datum, voornaam, achternaam, adres_straat, adres_nr, adres_postcode, adres_plaats, telefoon_nr, bedrijfsnaam, btw_nr) VALUES (?, ?, ?, NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $wachtwoord = password_hash($_POST['wachtwoord'], PASSWORD_DEFAULT);
    $uniqid = account_activatie ? uniqid() : 'activated';
    $stmt->bind_param('ssssssssssss',$_POST['email'],$wachtwoord, $uniqid, $_POST['voornaam'], $_POST['achternaam'], $_POST['adres_straat'], $_POST['adres_nr'], $_POST['adres_postcode'], $_POST['adres_plaats'], $_POST['telefoon_nr'], $_POST['bedrijfsnaam'], $_POST['btw_nr']);
    $stmt->execute();
    $stmt->close();
    if (account_activatie) {
        send_activation_email($_POST['email'], $uniqid);
        echo 'Bekijk uw email voor het activeren van je account!';
    } else {
        echo 'Je bent succesvol geregistreerd, u kan zich nu aanmelden!';
    }
}
?>
