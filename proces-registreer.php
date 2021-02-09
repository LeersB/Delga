<?php
include 'main.php';
if (!isset($_POST['email'], $_POST['wachtwoord'], $_POST['cwachtwoord'])) {
    exit('Vervolledig het registratie formulier!');
}
// Check of velden zijn ingevuld
if (empty($_POST['email']) || empty($_POST['wachtwoord']) || empty($_POST['voornaam']) || empty($_POST['achternaam']) || empty($_POST['adres_straat']) || empty($_POST['adres_nr']) || empty($_POST['adres_postcode']) || empty($_POST['adres_plaats']) || empty($_POST['adres_straat_2']) || empty($_POST['adres_nr_2']) || empty($_POST['adres_postcode_2']) || empty($_POST['adres_plaats_2'])) {
    exit('Vervolledig het registratie formulier!');
}
// Check geldig email
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    exit('E-mailadres is niet geldig!');
}
// wachtwoord tussen 8 en 16 tekens lang
if (strlen($_POST['wachtwoord']) > 16 || strlen($_POST['wachtwoord']) < 8) {
    exit('Wachtwoord moet tussen 8 en 16 karakters lang zijn!');
}
// Check wachtwoorden overeen
if ($_POST['cwachtwoord'] != $_POST['wachtwoord']) {
    exit('Wachtwoorden komen niet overeen!');
}
// Check account niet reeds bestaat.
$pdo_function = pdo_connect_mysql();
$stmt = $pdo_function->prepare('SELECT user_id, wachtwoord FROM users WHERE email = ?');
$stmt->execute([$_POST['email']]);
$account = $stmt->fetch(PDO::FETCH_ASSOC);
if ($account) {
    echo 'Dit e-mailadres bestaat al!';
} else {
    $stmt = $pdo_function->prepare('INSERT INTO users (email, wachtwoord, activatie_code, registratie_datum, voornaam, achternaam, adres_straat, adres_nr, adres_postcode, adres_plaats, adres_straat_2, adres_nr_2, adres_postcode_2, adres_plaats_2, telefoon_nr, bedrijfsnaam, btw_nr, user_level) VALUES (?, ?, ?, NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $wachtwoord = password_hash($_POST['wachtwoord'], PASSWORD_DEFAULT);
    $uniqid = account_activatie ? uniqid() : 'activated';
    $stmt->execute([ $_POST['email'], $wachtwoord, $uniqid, $_POST['voornaam'], $_POST['achternaam'], $_POST['adres_straat'], $_POST['adres_nr'], $_POST['adres_postcode'], $_POST['adres_plaats'], $_POST['adres_straat_2'], $_POST['adres_nr_2'], $_POST['adres_postcode_2'], $_POST['adres_plaats_2'], $_POST['telefoon_nr'], $_POST['bedrijfsnaam'], $_POST['btw_nr'], $_POST['user_level'] ]);
    if (account_activatie) {
        $activatie_link = activatie_link . '?email=' . $_POST['email'] . '&code=' . $uniqid;
        send_activatie_email($_POST['email'], $activatie_link, $_POST['voornaam'], $_POST['achternaam']);
        echo 'Bekijk uw email voor het activeren van je account!';
    } else {
        echo 'Je bent succesvol geregistreerd, u kan zich nu aanmelden!';
    }
}
?>
