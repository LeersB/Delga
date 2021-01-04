<?php
include 'main.php';
// Now we check if the data from the login form was submitted, isset() will check if the data exists.
if (!isset($_POST['email'], $_POST['wachtwoord'])) {
    exit('Vul zowel uw e-mailadres als wachtwoord in!');
}
// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
$stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
$stmt->execute([ $_POST['email'] ]);
$account = $stmt->fetch(PDO::FETCH_ASSOC);
// Check if the account exists:
if ($account) {
    // Account exists, now we verify the password.
    if (password_verify($_POST['wachtwoord'], $account['wachtwoord'])) {
        // Check if the account is activated
        if (account_activatie && $account['activatie_code'] != 'activated') {
            // User has not activated their account, output the message
            echo 'Please activate your account to login, click <a href="activatie_resend.php">here</a> to resend the activation email!';
        } else {
            // Verification success! User has loggedin!
            // Create sessions so we know the user is logged in, they basically act like cookies but remember the data on the server.
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['email'] = $account['email'];
            $_SESSION['user_id'] = $account['user_id'];
            $_SESSION['voornaam'] = $account['voornaam'];
            $_SESSION['achternaam'] = $account['achternaam'];
            $_SESSION['user_level'] = $account['user_level'];
            // IF the user checked the remember me check box:
            if (isset($_POST['rememberme'])) {
                // Create a hash that will be stored as a cookie and in the database, this will be used to identify the user.
                $cookiehash = !empty($account['rememberme']) ? $account['rememberme'] : password_hash($account['user_id'] . $_account['email'] . 'yoursecretkey', PASSWORD_DEFAULT);
                // The amount of days a user will be remembered:
                $days = 30;
                setcookie('rememberme', $cookiehash, (int)(time()+60*60*24*$days));
                /// Update the "rememberme" field in the accounts table
                $stmt = $pdo->prepare('UPDATE users SET terugkeer_code = ? WHERE user_id = ?');
                $stmt->execute([ $cookiehash, $account['user_id'] ]);
            }
            echo 'Success'; // check with AJAX code
        }
    } else {
        echo 'Foutief wachtwoord!';
    }
} else {
    echo 'Geldig e-mailadres is verplicht!';
}
?>
