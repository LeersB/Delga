<?php
$menu = 3;
include 'main.php';
$msg = '';
$msg2 = '';
$pdo_function = pdo_connect_mysql();
if (isset($_GET['email'], $_GET['code']) && !empty($_GET['code'])) {
    $stmt = $pdo_function->prepare('SELECT * FROM users WHERE email = ? AND reset_code = ?');
    $stmt->execute([$_GET['email'], $_GET['code']]);
    $account = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($account) {
        if (isset($_POST['nwachtwoord'], $_POST['cwachtwoord'])) {
            if (strlen($_POST['nwachtwoord']) > 16 || strlen($_POST['nwachtwoord']) < 8) {
                $msg = 'Wachtwoord moet tussen 8 en 16 karakters lang zijn!';
            } else if ($_POST['nwachtwoord'] != $_POST['cwachtwoord']) {
                $msg = 'Wachtwoorden komen niet overeen!';
            } else {
                $stmt = $pdo_function->prepare('UPDATE users SET wachtwoord = ?, reset_code = "" WHERE email = ?');
                $wachtwoord = password_hash($_POST['nwachtwoord'], PASSWORD_DEFAULT);
                $stmt->execute([$wachtwoord, $_GET['email']]);
                $msg2 = 'Uw wachtwoord is aangepast! U kan zich nu <a href="login.php">aanmelden</a>!';
            }
        }
    } else {
        exit('Foutief e-mailadres en/of activatiecode!');
    }
} else {
    exit('Geef het e-mailadres en de code op!');
}
?>

<!DOCTYPE html>
<html class="h-100" lang="nl">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
    <meta content="Delga contactgegevens" name="description">
    <meta content="Bart Leers" name="author">
    <title>Wachtwoord vernieuwen</title>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/delga.css" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100">

<header>
    <?php include('includes/header.php'); ?>
</header>

<main class="flex-shrink-0" role="main">
    <div class="container">

        <div class="login">
            <h1>Wachtwoord aanpassen</h1>
            <form class="needs-validation" novalidate action="wachtwoord_reset.php?email=<?= $_GET['email'] ?>&code=<?= $_GET['code'] ?>" method="post">
                <div class="input-group col-md-12"><br></div>
                <div class="input-group col-md-12">
                    <label class="sr-only" for="nwachtwoord">Nieuw wachtwoord</label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fas fa-lock"></i></div>
                        </div>
                        <input type="password" class="form-control" id="nwachtwoord" name="nwachtwoord"
                               placeholder="Nieuw wachtwoord" aria-describedby="nwachtwoordHelpBlock" required>
                        <small id="nwachtwoordHelpBlock" class="form-text text-muted col-md-12">
                            Uw wachtwoord moet tussen 8 en 16 karakters lang zijn!
                        </small>
                    </div>
                </div>
                <div class="input-group col-md-12">
                    <label class="sr-only" for="cwachtwoord">Bevestig wachtwoord</label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fas fa-lock"></i></div>
                        </div>
                        <input type="password" class="form-control" id="cwachtwoord" name="cwachtwoord"
                               placeholder="Bevestig wachtwoord" required>
                    </div>
                </div>
                <div class="input-group col-md-12"><br></div>
                <div class="col-md-12 text-danger msg"><?= $msg ?></div>
                <div class="col-md-12 text-success msg2"><?= $msg2 ?></div>
                <div class="input-group col-md-12"><br></div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Verstuur</button>
                </div>
            </form>
        </div>
    </div>
</main>

<?php include('includes/footer.php'); ?>
<script src="js/form-validation.js"></script>
</body>
</html>
