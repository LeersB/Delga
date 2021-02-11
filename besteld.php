<?php
$menu = 4;
include 'main.php';
$pdo_function = pdo_connect_mysql();
check_loggedin($pdo_function);
$error = '';

// Verwijder producten in winkelmand
unset($_SESSION['delgashop']);
?>
<!DOCTYPE html>
<html class="h-100" lang="nl">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
    <meta content="Delga contactgegevens" name="description">
    <meta content="Bart Leers" name="author">
    <title>Delga product bestelling</title>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/delga.css" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100">

<header>
    <?php include('includes/header.php'); ?>
</header>

<main class="flex-shrink-0" role="main">
    <div class="container">

<?php if ($error): ?>
    <p class="content-wrapper error"><?=$error?></p>
<?php else: ?>
    <div class="placeorder content-wrapper">
        <h1>Uw order is geplaatst</h1>
        <p>We danken u voor uw bestelling bij ons, we zullen u contacteren via email of telefonisch voor het verder afhandelen van uw bestelling.</p>
    </div>
<?php endif; ?>

</div>
</main>

<?php include('includes/footer.php'); ?>

</body>
</html>


