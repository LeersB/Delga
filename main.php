<?php
include_once 'config.php';
session_start();
// Connect to the MySQL database using PDO
try {
    $pdo = new PDO('mysql:host=' . db_host . ';dbname=' . db_name . ';db_port=' . db_port,db_user, db_password);
} catch (PDOException $exception) {
// If there is an error with the connection, stop the script and display the error.
    exit('Failed to connect to database!');
//exit("Connection failed - ".$exception->getMessage());
}

function pdo_connect_mysql() {
    try {
        // Connect to the MySQL database using PDO...
        return new PDO('mysql:host=' . db_host . ';dbname=' . db_name . ';db_port=' . db_port,db_user, db_password);
    } catch (PDOException $exception) {
        // Could not connect to the MySQL database, if this error occurs make sure you check your db settings are correct!
        exit('Failed to connect to database!');
        //exit("Connection failed - ".$exception->getMessage());
    }
}
// The below function will check if the user is logged-in and also check the remember me cookie
function check_loggedin($pdo, $redirect_file = 'login.php') {
    // Check for remember me cookie variable and loggedin session variable
    if (isset($_COOKIE['rememberme']) && !empty($_COOKIE['rememberme']) && !isset($_SESSION['loggedin'])) {
        // If the remember me cookie matches one in the database then we can update the session variables.
        $stmt = $pdo->prepare('SELECT * FROM users WHERE terugkeer_code = ?');
        $stmt->execute([ $_COOKIE['rememberme'] ]);
        $account = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($account) {
            // Found a match, update the session variables and keep the user logged-in
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['voornaam'] = $account['voornaam'];
            $_SESSION['achternaam'] = $account['achternaam'];
            $_SESSION['user_id'] = $account['user_id'];
            $_SESSION['user_level'] = $account['user_level'];
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
