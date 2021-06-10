<?php
include 'main.php';
$filter_email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$filter_wachtwoord = filter_input(INPUT_POST, 'wachtwoord');
$pdo_function = pdo_connect_mysql();

$stmt = $pdo_function->prepare('SELECT * FROM users WHERE email = ?');
$stmt->execute([ $filter_email ]);
$account = $stmt->fetch(PDO::FETCH_ASSOC);
if ($account) {
    if (password_verify($filter_wachtwoord, $account['wachtwoord'])) {
        // Controleer of account geactiveerd is
        if ($account['activatie_code'] != 'activated') {
            // user heeft account nog niet geactiveerd
            echo 'U moet uw account activeren voor u kan aanmelden, klik <u><a href="activatie-resend.php">hier</a></u> voor het opnieuw verzenden van de activatie email!';
        } else {
            // Verification success!
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['user_id'] = $account['user_id'];
            $_SESSION['voornaam'] = $account['voornaam'];
            $_SESSION['achternaam'] = $account['achternaam'];
            $_SESSION['user_level'] = $account['user_level'];
            // if user rememberme heeft aangevinkt
            if (isset($_POST['rememberme'])) {
                $cookiehash = !empty($account['rememberme']) ? $account['rememberme'] : password_hash($account['user_id'] . $account['email'] . 'yoursecretkey', PASSWORD_DEFAULT);
                $days = 30;
                setcookie('rememberme', $cookiehash, (int)(time()+60*60*24*$days));
                $stmt = $pdo_function->prepare('UPDATE users SET terugkeer_code = ? WHERE user_id = ?');
                $stmt->execute([ $cookiehash, $account['user_id'] ]);
            }
            echo 'Success';
        }
    } else {
        echo 'Foutief wachtwoord!';
    }
} else {
    echo 'Geldig e-mailadres is verplicht!';
}