<?php
$menu = 3;
include 'main.php';
$msg = '';
$msg2 = '';

if (isset($_POST['email'])) {
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$_POST['email']]);
    $account = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($account) {
        $stmt = $pdo->prepare('UPDATE users SET reset_code = ? WHERE email = ?');
        $uniqid = uniqid();
        $stmt->execute([$uniqid, $_POST['email']]);
        // Email to send below, TODO
        $subject = 'Wachtwoord herstel Delga.be';
        $headers = 'From: ' . mail_from . "\r\n" . 'Reply-To: ' . mail_from . "\r\n" . 'Return-Path: ' . mail_from . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
        $reset_link = 'http://test.delga.be/wachtwoord_reset.php?email=' . $_POST['email'] . '&code=' . $uniqid;
        $message = '<p>Beste,</p>
                    <p>Please click the following link to reset your password: <a href="' . $reset_link . '">' . $reset_link . '</a></p>
                    <p>Met vriendelijke groeten</p>';
        //
        mail($_POST['email'], $subject, $message, $headers);
        $msg2 = 'De link voor het opnieuw instellen van het wachtwoord is naar uw e-mailadres verstuurd!';
    } else {
        $msg = 'Er is geen account gevonden met dit e-mailadres!';
    }
}
?>
<!DOCTYPE html>
<html class="h-100" lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
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
            <form class="needs-validation" novalidate action="wachtwoord_aanvraag.php" method="post">
                <div class="input-group col-md-12"><h2>Wachtwoord vergeten</h2></div>
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
                    <button type="submit" value="submit" class="btn btn-primary"><i class="far fa-envelope"></i> Verstuur</button>
                </div>
            </form>
        </div>
    </div>
</main>

<?php include('includes/footer.php'); ?>
<script src="js/form-validation.js"></script>
</body>
</html>
