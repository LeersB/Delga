<?php
$menu = 1;
include 'main.php';
check_loggedin($pdo);
?>

<!DOCTYPE html>
<html class="h-100" lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
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

<main class="flex-shrink-0" role="main">
    <div class="container">

        <div class="content">
            <h2>Home Pagina</h2>
            <p class="block">Welkom terug, <?= $_SESSION['voornaam'] ?> <?= $_SESSION['achternaam'] ?>!</p>
        </div>

    </div>
</main>

<?php include('includes/footer.php'); ?>
</body>
</html>