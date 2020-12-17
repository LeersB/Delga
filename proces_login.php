<?php
include 'main.php';
// Now we check if the data from the login form was submitted, isset() will check if the data exists.
if (!isset($_POST['email'], $_POST['wachtwoord'])) {
    // Could not get the data that should have been sent.
    exit('Please fill both the username and password fields!');
}
// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
$stmt = $con->prepare('SELECT user_id, wachtwoord, voornaam, achternaam, terugkeer_code, activatie_code, user_level FROM users WHERE email = ?');
// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
$stmt->bind_param('s', $_POST['email']);
$stmt->execute();
// Store the result so we can check if the account exists in the database.
$stmt->store_result();
// Check if the account exists:
if ($stmt->num_rows > 0) {
    $stmt->bind_result($user_id, $wachtwoord, $voornaam, $achternaam, $rememberme, $activatie_code, $user_level);
    $stmt->fetch();
    $stmt->close();
    // Account exists, now we verify the password.
    // Note: remember to use password_hash in your registration file to store the hashed passwords.
    if (password_verify($_POST['wachtwoord'], $wachtwoord)) {
        // Check if the account is activated
        if (account_activatie && $activatie_code != 'activated') {
            // User has not activated their account, output the message
            echo 'Please activate your account to login, click <a href="activatie_resend.php">here</a> to resend the activation email!';
        } else {
            // Verification success! User has loggedin!
            // Create sessions so we know the user is logged in, they basically act like cookies but remember the data on the server.
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['user_id'] = $user_id;
            $_SESSION['voornaam'] = $voornaam;
            $_SESSION['achternaam'] = $achternaam;
            $_SESSION['user_level'] = $user_level;
            // IF the user checked the remember me check box:
            if (isset($_POST['rememberme'])) {
                // Create a hash that will be stored as a cookie and in the database, this will be used to identify the user.
                $cookiehash = !empty($rememberme) ? $rememberme : password_hash($user_id . $_POST['email'] . 'yoursecretkey', PASSWORD_DEFAULT);
                // The amount of days a user will be remembered:
                $days = 30;
                setcookie('rememberme', $cookiehash, (int)(time()+60*60*24*$days));
                /// Update the "rememberme" field in the accounts table
                $stmt = $con->prepare('UPDATE users SET terugkeer_code = ? WHERE user_id = ?');
                $stmt->bind_param('si', $cookiehash, $user_id);
                $stmt->execute();
                $stmt->close();
            }
            echo 'Success'; // Do not change this line as it will be used to check with the AJAX code
        }
    } else {
        // Incorrect password
        echo 'Foutief wachtwoord!';
    }
} else {
    // Incorrect username
    echo 'Geldig e-mailadres is verplicht!';
}
?>
