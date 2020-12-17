<?php
$menu = 1;
include 'main.php';
// No need for the user to see the login form if they're logged-in so redirect them to the home page
if (isset($_SESSION['loggedin'])) {
    // If the user is not logged in redirect to the home page.
    header('Location: home.php');
    exit;
}
// Also check if they are "remembered"
if (isset($_COOKIE['rememberme']) && !empty($_COOKIE['rememberme'])) {
    // If the remember me cookie matches one in the database then we can update the session variables.
    $stmt = $con->prepare('SELECT user_id, voornaam, achternaam, user_level FROM users WHERE terugkeer_code = ?');
    $stmt->bind_param('s', $_COOKIE['rememberme']);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        // Found a match
        $stmt->bind_result($user_id, $voornaam, $achternaam, $user_level);
        $stmt->fetch();
        $stmt->close();
        session_regenerate_id();
        $_SESSION['loggedin'] = TRUE;
        $_SESSION['voornaam'] = $voornaam;
        $_SESSION['achternaam'] = $achternaam;
        $_SESSION['id'] = $user_id;
        $_SESSION['user_level'] = $user_level;
        header('Location: home.php');
        exit;
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
    <title>Delga</title>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/delga.css" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100">

<header>
    <?php include('includes/header.php'); ?>
</header>

<main class="flex-shrink-0" role="main">
    <div class="container">
        <p class="text-center"><img alt="" height="118" src="images/delga_gif.gif" width="246"></p>
        <div class="jumbotron p-4 p-md-5 text-dark rounded bg-light">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h3>
                        <dl class="row">
                            <dt class="col-lg-6">Zaakvoerder:</dt>
                            <dd class="col-lg-6">Delhaye&nbsp;Gabriël</dd>
                            <dt class="col-lg-6">Adres:</dt>
                            <dd class="col-lg-6">Voorzienigheidsstraat&nbsp;18<br>
                                8500&nbsp;Kortrijk
                            </dd>
                            <dt class="col-lg-6">Telefoon:</dt>
                            <dd class="col-lg-6">+32&nbsp;(0)56/22&nbsp;59&nbsp;62</dd>
                            <dt class="col-lg-6">GSM:</dt>
                            <dd class="col-lg-6">+32&nbsp;(0)495/36&nbsp;11&nbsp;49</dd>
                            <dt class="col-lg-6">E-mailadres:</dt>
                            <dd class="col-lg-6"><u><a href="mailto:info@delga.be?subject=info" class="text-primary">info@delga.be</a></u>
                            </dd>
                            <dt class="col-lg-6">HR:</dt>
                            <dd class="col-lg-6">Kortrijk&nbsp;117.854</dd>
                            <dt class="col-lg-6">BTW:</dt>
                            <dd class="col-lg-6">BE&nbsp;0524479592</dd>
                        </dl>
                    </h3>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include('includes/footer.php'); ?>

<script>var disqus_config = (function () {
        if (!localStorage.getItem('cookieconsent')) {
            document.body.innerHTML += '\
<div class="cookieconsent" style="position:fixed;padding:20px;left:0;bottom:0;background-color:#555D5D;color:#FFF;text-align:center;width:100%;z-index:99999;">\
    Wij gebruiken cookies om het gebruik van onze webwinkel te faciliteren en het inloggen op onze website te vergemakkelijken. <br>U kunt deze cookies uitzetten via uw browser maar dit kan het functioneren van onze website negatief aantasten. \
    <a href="#" style="color:#17a2b8;">Akkoord & sluiten</a>\
</div>\
';
            document.querySelector('.cookieconsent a').onclick = function (e) {
                e.preventDefault();
                document.querySelector('.cookieconsent').style.display = 'none';
                localStorage.setItem('cookieconsent', true);
            };
        }
    })();</script>
</body>
</html>
