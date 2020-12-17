<?php
$menu = 1;
include 'main.php';
$msg = '';
// First we check if the email and code exists, these variables will appear as parameters in the URL
if (isset($_GET['email'], $_GET['code']) && !empty($_GET['code'])) {
    $stmt = $con->prepare('SELECT * FROM users WHERE email = ? AND activatie_code = ?');
    $stmt->bind_param('ss', $_GET['email'], $_GET['code']);
    $stmt->execute();
    // Store the result so we can check if the account exists in the database.
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->close();
        // Account exists with the requested email and code.
        $stmt = $con->prepare('UPDATE users SET activatie_code = ? WHERE email = ? AND activatie_code = ?');
        // Set the new activation code to 'activated', this is how we can check if the user has activated their account.
        $newcode = 'activated';
        $stmt->bind_param('sss', $newcode, $_GET['email'], $_GET['code']);
        $stmt->execute();
        $stmt->close();
        $msg = 'Uw account is geactiveerd, je kan zich nu aanmelden!<br><a href="login.php">Login</a>';
    } else {
        $msg = 'The account is already activated or doesn\'t exist!';
    }
} else {
    $msg = 'No code and/or email was specified!';
}
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
            <p><?= $msg ?></p>
        </div>

    </div>
</main>

<?php include('includes/footer.php'); ?>
</body>
</html>
