<?php
include_once 'config.php';
session_start();

function pdo_connect_mysql() {
    try {
        // Connectie naar MySQL database via PDO
        return new PDO('mysql:host=' . db_host . ';dbname=' . db_name . ';db_port=' . db_port,db_user, db_password);
    } catch (PDOException $exception) {
        exit('Failed to connect to database!');
        //exit("Connection failed - ".$exception->getMessage());
    }
}
// Functie voor het controleren of user is ingelogd en of rememberme aanwezig is
function check_loggedin($pdo, $redirect_file = 'login.php') {
    // Controle rememberme variabelen en loggedin variabelen
    if (isset($_COOKIE['rememberme']) && !empty($_COOKIE['rememberme']) && !isset($_SESSION['loggedin'])) {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE terugkeer_code = ?');
        $stmt->execute([ $_COOKIE['rememberme'] ]);
        $account = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($account) {
            // User ok, aanmaken variabelen en user ingelogd houden
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['voornaam'] = $account['voornaam'];
            $_SESSION['achternaam'] = $account['achternaam'];
            //$_SESSION['email'] = $account['email'];
            $_SESSION['user_id'] = $account['user_id'];
            $_SESSION['user_level'] = $account['user_level'];
        } else {
            // User niet onthouden via rememberme
            header('Location: ' . $redirect_file);
            exit;
        }
    } else if (!isset($_SESSION['loggedin'])) {
        // User niet ingelogd
        header('Location: ' . $redirect_file);
        exit;
    }
}
// Functie verzenden activatie email
function send_activatie_email($email, $activatie_link, $voornaam, $achternaam) {
    $subject = 'Account activatie delga.be';
    $headers = 'From: ' . mail_from . "\r\n" . 'Reply-To: ' . mail_from . "\r\n" . 'Return-Path: ' . mail_from . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
    ob_start();
    include 'templates/activatie-email.php';
    $email_template = ob_get_clean();
    mail($email, $subject, $email_template, $headers);
}
// Functie verzenden wachtwoord email
function send_wachtwoord_email($email, $reset_link, $voornaam, $achternaam) {
    $subject = 'Wachtwoord herstel delga.be';
    $headers = 'From: ' . mail_from . "\r\n" . 'Reply-To: ' . mail_from . "\r\n" . 'Return-Path: ' . mail_from . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
    ob_start();
    include 'templates/wachtwoord-email.php';
    $email_template = ob_get_clean();
    mail($email, $subject, $email_template, $headers);
}
// Functie om een product te verkrijgen via product_id en opties string
function &get_delgashop_product($product_id, $opties) {
    $p = null;
    if (isset($_SESSION['delgashop'])) {
        foreach ($_SESSION['delgashop'] as &$product) {
            if ($product['product_id'] == $product_id && $product['opties'] == $opties) {
                $p = &$product;
                return $p;
            }
        }
    }
    return $p;
}
// Aantal producten in winkelmand delgashop
$aantal_winkelmand = isset($_SESSION['delgashop']) ? count($_SESSION['delgashop']) : 0;

// Functie verzenden order details email
function send_order_detail_email($email, $producten_winkelmand, $order_naam, $order_adres, $order_adres_2, $subtotaal, $order_nr) {
    $subject = 'Bestelling delga.be';
    $headers = 'From: ' . mail_from . "\r\n" . 'Reply-To: ' . mail_from . "\r\n" . 'Return-Path: ' . mail_from . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
    ob_start();
    include 'templates/bestel-email.php';
    $email_template = ob_get_clean();
    mail($email, $subject, $email_template, $headers);
}
// Functie verzenden order details email
function send_order_alert_email($email, $producten_winkelmand, $order_naam, $order_adres, $order_adres_2, $subtotaal, $order_nr) {
    $subject = 'Bestelling delga.be';
    $headers = 'From: ' . mail_from . "\r\n" . 'Reply-To: ' . mail_from . "\r\n" . 'Return-Path: ' . mail_from . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
    ob_start();
    include 'templates/bestel-email.php';
    $email_template = ob_get_clean();
    mail($email, $subject, $email_template, $headers);
}
?>
