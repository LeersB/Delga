<?php
$menu = 4;
include 'main.php';
if (isset($_SESSION['loggedin'])) {
    header('Location: home.php');
    exit;
}
if (isset($_COOKIE['rememberme']) && !empty($_COOKIE['rememberme'])) {
    $pdo_function = pdo_connect_mysql();
    $stmt = $pdo_function->prepare('SELECT * FROM users WHERE terugkeer_code = ?');
    $stmt->execute([ $_COOKIE['rememberme'] ]);
    $account = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($account) {
        session_regenerate_id();
        $_SESSION['loggedin'] = TRUE;
        $_SESSION['voornaam'] = $account['voornaam'];
        $_SESSION['achternaam'] = $account['achternaam'];
        $_SESSION['user_id'] = $account['user_id'];
        $_SESSION['user_level'] = $account['user_level'];
        header('Location: home.php');
        exit;
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
    <title>Delga login</title>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/delga.css" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100">

<header>
    <?php include('includes/header.php'); ?>
</header>

<main class="flex-shrink-0">
    <div class="container">
        <div class="login-container row">
            <div class="col-sm-6 col-xs-12 pull-left">
                <div class="block block-customer-login">
                    <div class="block-title">
                        <h2 class="title" id="block-customer-login-heading"><span>Log in met je Delga account</span>
                        </h2>
                    </div>
                    <form class="needs-validation" novalidate action="proces-login.php" method="post" id="login-form">
                        <div class="field note margin-bottom10">Als u een account hebt, meld u dan hier aan.</div>
                        <div class="form-group email">
                            <label for="email" class="form-label">E-mailadres<em>*</em></label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="E-mail"
                                   maxlength="30" required>
                        </div>
                        <div class="form-group password">
                            <label for="wachtwoord">Wachtwoord<em>*</em></label>
                            <div class="control">
                                <input type="password" class="form-control" id="wachtwoord" name="wachtwoord"
                                       placeholder="Wachtwoord" minlength="8" maxlength="20" required>
                            </div>
                        </div>
                        <div class="form-group text-danger msg"></div>

                        <div class="row">
                            <div class="col">
                                <label id="rememberme">
                                    <input type="checkbox" name="rememberme"> Mij onthouden
                                </label>
                            </div>
                            <div class="col">
                                <a href="wachtwoord-aanvraag.php">Wachtwoord vergeten</a>
                            </div>
                        </div>

                        <div class="form-group login">
                            <div class="row">
                                <div class="col">
                                    <button class="btn btn-success" type="submit" name="submit"><i class="fas fa-sign-in-alt"></i> Aanmelden</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-sm-6 col-xs-12 pull-right">
                <div class="block block-new-customer">
                    <div class="block-title">
                        <h2 class="title" id="block-new-customer-heading" aria-level="2"><span>Eerste keer hier? Welkom!</span>
                        </h2>
                    </div>
                    <div class="block-content" aria-labelledby="block-new-customer-heading">
                        <p>Laat alvast je gegevens achter. <br>Met een eigen Delga account bestel je snel en 100%
                            veilig.</p>
                        <div class="actions-toolbar padding-top10">
                            <div class="primary">
                                <a href="registratie-aanvraag.php" class="action create btn btn-secondary"><span>Een Delga account aanmaken</span></a>
                            </div>
                            <div class="input-group col-md-12"><br></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include('includes/footer.php'); ?>

<script>
    document.querySelector(".login-container form").onsubmit = function (event) {
        event.preventDefault();
        var form_data = new FormData(document.querySelector(".login-container form"));
        var xhr = new XMLHttpRequest();
        xhr.open("POST", document.querySelector(".login-container form").action, true);
        xhr.onload = function () {
            if (this.responseText.toLowerCase().indexOf("success") !== -1) {
                window.location.href = "home.php";
            } else {
                document.querySelector(".msg").innerHTML = this.responseText;
            }
        };
        xhr.send(form_data);
    };
</script>
<script src="js/form-validation.js"></script>
</body>
</html>