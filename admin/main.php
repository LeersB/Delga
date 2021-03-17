<?php
include_once '../config.php';
include_once '../main.php';
$pdo_function = pdo_connect_mysql();
check_loggedin($pdo_function, '../index.php');
$stmt = $pdo_function->prepare('SELECT * FROM users WHERE user_id = ?');
$stmt->execute([ $_SESSION['user_id'] ]);
$account = $stmt->fetch(PDO::FETCH_ASSOC);
// Controle of user admin rechten heeft
if ($account['user_level'] != 'Admin') {
    exit('You do not have permission to access this page!');
}

// Functie verzenden annulatie email
function send_annulatie_email($order_email, $order_nr, $order_naam) {
    $subject = 'Annulatie besteling delga.be';
    $headers = 'From: ' . mail_from . "\r\n" . 'Reply-To: ' . mail_from . "\r\n" . 'Return-Path: ' . mail_from . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
    ob_start();
    include '../templates/annulatie-email.php';
    $email_template = ob_get_clean();
    mail($order_email, $subject, $email_template, $headers);
}
?>
