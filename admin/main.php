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
?>
