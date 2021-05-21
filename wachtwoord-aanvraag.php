<?php
$menu = 4;
include 'main.php';
$msg = '';
$msg2 = '';
$pdo_function = pdo_connect_mysql();
if (isset($_POST['email'])) {
    $stmt = $pdo_function->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$_POST['email']]);
    $account = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($account) {
        $stmt = $pdo_function->prepare('UPDATE users SET reset_code = ? WHERE email = ?');
        $uniqid = uniqid();
        $stmt->execute([$uniqid, $_POST['email']]);
        $reset_link = reset_link . '?email=' . $_POST['email'] . '&code=' . $uniqid;
        send_wachtwoord_email($_POST['email'], $reset_link, $account['voornaam'], $account['achternaam']);
        $msg2 = 'De link voor het opnieuw instellen van het wachtwoord is naar uw e-mailadres verstuurd!';
    } else {
        $msg = 'Er is geen account gevonden met dit e-mailadres!';
    }
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
    <title>Wachtwoord aanvraag</title>
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
            <form class="needs-validation" novalidate action="wachtwoord-aanvraag.php" method="post">
                <div class="input-group col-md-12"><h2>Wachtwoord vergeten</h2></div>
                <div class="input-group col-md-12"><p>Voer uw e-mailadres hieronder in om een wachtwoord reset link te ontvangen.</p></div>
                <div class="input-group col-md-12">
                    <label class="sr-only" for="email">E-mailadres</label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fas fa-envelope"></i></div>
                        </div>
                        <input type="email" class="form-control" id="email" name="email" placeholder="E-mailadres"
                               required>
                    </div>
                </div>
                <div class="col-md-12 text-danger msg"><?= $msg ?></div>
                <div class="col-md-12 text-success msg"><?= $msg2 ?></div>
                <div class="input-group col-md-12"><br></div>
                <div class="col-md-12">
                    <button type="submit" value="submit" class="btn btn-success"><i class="far fa-envelope"></i>
                        Verstuur
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>

<?php include('includes/footer.php'); ?>
<script src="js/form-validation.js"></script>
</body>
</html>
