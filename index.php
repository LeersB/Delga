<?php
$menu = 1;
include 'main.php';

if (isset($_SESSION['loggedin'])) {
    header('Location: home.php');
    exit;
}
?>

<!DOCTYPE html>
<html class="h-100" lang="nl">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="google-site-verification" content="uob4YZXZZx-gAsAGY7fJlee25dMAOd3KDifIFnwPE4U">
    <meta content="Delga onderhoudsproducten" name="description">
    <meta content="Bart Leers" name="author">
    <title>Delga onderhoudsproducten</title>
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

<script>
    var disqus_config = (function () {
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
    })();

    document.querySelector(".search i").onclick = function() {
        this.style.display = "none";
        this.parentElement.querySelector("input").style.display = "block";
        this.parentElement.querySelector("input").focus();
    };
    document.querySelector(".search input").onkeyup = function(event) {
        if (event.keyCode === 13 && this.value.length > 0) {
            window.location.href = encodeURI("zoeken.php?query=" + this.value);
        }
    };
</script>
</body>
</html>
