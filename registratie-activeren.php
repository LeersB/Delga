<?php
$menu = 1;
include 'main.php';
$msg = '';
$pdo_function = pdo_connect_mysql();
$filter_email = filter_input(INPUT_GET, 'email', FILTER_VALIDATE_EMAIL);
$filter_code = filter_input(INPUT_GET, 'code', FILTER_SANITIZE_STRING);

if (isset($filter_email, $filter_code) && !empty($filter_code)) {
    $stmt = $pdo_function->prepare('SELECT * FROM users WHERE email = ? AND activatie_code = ?');
    $stmt->execute([ $filter_email, $filter_code ]);
    $account = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($account) {
        $stmt = $pdo_function->prepare('UPDATE users SET activatie_code = ? WHERE email = ?');
        $activated = 'activated';
        $stmt->execute([ $activated, $filter_email ]);
        $msg = 'Uw account is geactiveerd, je kan zich nu <a href="login.php">aanmelden</a>.';
    } else {
        $msg = 'Uw account is reeds geactiveerd of bestaat niet!';
    }
} else {
    $msg = 'Geen code of e-mailadres gespecificeerd!';
}
?>
<!DOCTYPE html>
<html class="h-100" lang="nl">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
    <meta name=”robots” content=”noindex,nofollow”>
    <meta content="Delga contactgegevens" name="description">
    <meta content="Bart Leers" name="author">
    <title>Delga home</title>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/delga.css" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100">

<header>
    <?php include('includes/header.php'); ?>
</header>

<main class="flex-shrink-0">
    <div class="container">

        <div class="content">
            <p><?= $msg ?></p>
        </div>

    </div>
</main>

<?php include('includes/footer.php'); ?>
</body>
</html>