<?php
include 'main.php';
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
// Check if the account with that username already exists
$stmt = $pdo->prepare('SELECT user_id, wachtwoord FROM users WHERE email = ?');
$stmt->execute([$_POST['email']]);
$account = $stmt->fetch(PDO::FETCH_ASSOC);
// Store the result so we can check if the account exists in the database.
if ($account) {
    // Username already exists
    echo 'Dit e-mailadres bestaat al!';
} else {
    // Username doesnt exists, insert new account
    $stmt = $pdo->prepare('INSERT INTO users (email, wachtwoord, activatie_code, registratie_datum, voornaam, achternaam, adres_straat, adres_nr, adres_postcode, adres_plaats, telefoon_nr, bedrijfsnaam, btw_nr) VALUES (?, ?, ?, NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    // We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in.
    $wachtwoord = password_hash($_POST['wachtwoord'], PASSWORD_DEFAULT);
    $uniqid = account_activatie ? uniqid() : 'activated';
    $stmt->execute([ $_POST['email'], $wachtwoord, $uniqid, $_POST['voornaam'], $_POST['achternaam'], $_POST['adres_straat'], $_POST['adres_nr'], $_POST['adres_postcode'], $_POST['adres_plaats'], $_POST['telefoon_nr'], $_POST['bedrijfsnaam'], $_POST['btw_nr'] ]);
    if (account_activatie) {
        // Account activation required, send the user the activation email with the "send_activation_email" function from the "main.php" file
        send_activation_email($_POST['email'], $uniqid);
        echo 'Bekijk uw email voor het activeren van je account!';
    } else {
        echo 'Je bent succesvol geregistreerd, u kan zich nu aanmelden!';
    }
}
?>
