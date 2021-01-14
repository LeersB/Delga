<?php
$menu = 3;
include 'main.php';
$msg = '';
$msg2 = '';
$pdo_function = pdo_connect_mysql();
// Now we check if the email from the resend activation form was submitted, isset() will check if the email exists.
if (isset($_POST['email'])) {
    $stmt = $pdo_function->prepare('SELECT * FROM users WHERE email = ? AND activatie_code != "" AND activatie_code != "activated"');
    $stmt->execute([ $_POST['email'] ]);
    $account = $stmt->fetch(PDO::FETCH_ASSOC);
    // If the account exists with the email
    if ($account) {
        // Account exist, the $msg variable will be used to show the output message (on the HTML form)
        send_activation_email($_POST['email'], $account['activatie_code']);
        $msg = 'De link voor het activeren van uw account is naar uw e-mailadres verstuurd!';
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
    <meta content="Delga contactgegevens" name="description">
    <meta content="Bart Leers" name="author">
    <title>Delga activatie email</title>
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
            <form class="needs-validation" novalidate action="activatie_resend.php" method="post">
                <div class="input-group col-md-12"><h2>Activeren Delga account</h2></div>
                <div class="input-group col-md-12">Voor het ontvangen van de activatie e-mail gelieve uw e-mailadres op te geven.</div>
                <div class="input-group col-md-12"><br></div>
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
