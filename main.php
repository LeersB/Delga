<?php
include_once 'config.php';

session_start();
// Connect to the MySQL database using MySQLi
$con = mysqli_connect(db_host, db_user, db_password, db_name, db_port);
if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// Update the charset
mysqli_set_charset($con, 'utf8');
// The below function will check if the user is logged-in
function check_loggedin($con, $redirect_file = 'login.php') {
    // Check for remember me cookie variable and loggedin session variable
    if (isset($_COOKIE['rememberme']) && !empty($_COOKIE['rememberme']) && !isset($_SESSION['loggedin'])) {
        // If the remember me cookie matches one in the database then we can update the session variables.
        $stmt = $con->prepare('SELECT voornaam, achternaam, user_id, user_level FROM users WHERE terugkeer_code = ?');
        $stmt->bind_param('s', $_COOKIE['rememberme']);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            // Found a match, update the session variables and keep the user logged-in
            $stmt->bind_result($voornaam, $achternaam, $user_id, $user_level);
            $stmt->fetch();
            $stmt->close();
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['voornaam'] = $voornaam;
            $_SESSION['achternaam'] = $achternaam;
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_level'] = $user_level;
        } else {
            // If the user is not remembered redirect to the login page.
            header('Location: ' . $redirect_file);
            exit;
        }
    } else if (!isset($_SESSION['loggedin'])) {
        // If the user is not logged in redirect to the login page.
        header('Location: ' . $redirect_file);
        exit;
    }
}
// Send activation email function
function send_activation_email($email, $code) {
    $subject = 'Account activatie vereist';
    $headers = 'From: ' . mail_from . "\r\n" . 'Reply-To: ' . mail_from . "\r\n" . 'Return-Path: ' . mail_from . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
    $activate_link = activatie_link . '?email=' . $email . '&code=' . $code;
    $email_template = str_replace('%link%', $activate_link, file_get_contents('activatie_email.html'));
    mail($email, $subject, $email_template, $headers);
}
?>
