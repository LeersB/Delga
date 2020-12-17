<?php
$menu = 3;
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
    $stmt = $con->prepare('SELECT user_id, email, user_level FROM users WHERE terugkeer_code = ?');
    $stmt->bind_param('s', $_COOKIE['rememberme']);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        // Found a match
        $stmt->bind_result($user_id, $email, $user_level);
        $stmt->fetch();
        $stmt->close();
        session_regenerate_id();
        $_SESSION['loggedin'] = TRUE;
        $_SESSION['email'] = $email;
        $_SESSION['user_id'] = $user_id;
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
    <title>Delga login</title>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/delga.css" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100">

<header>
    <?php include('includes/header.php'); ?>
</header>

<main class="flex-shrink-0" role="main">
    <div class="container">
        <div class="login-container row">
            <div class="col-sm-6 col-xs-12 pull-left">
                <div class="block block-customer-login">
                    <div class="block-title">
                        <h2 class="title" id="block-customer-login-heading" role="heading"><span>Log in met je Delga account</span>
                        </h2>
                    </div>
                    <form class="needs-validation" novalidate action="proces_login.php" method="post" id="login-form">
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
                                    <input type="checkbox" name="rememberme"> Onthoud mij
                                </label>
                            </div>
                            <div class="col">
                                <a href="wachtwoord_aanvraag.php">Wachtwoord vergeten?</a>
                            </div>
                        </div>

                        <div class="form-group login">
                            <div class="row">
                                <div class="col">
                                    <input id="submit" class="btn btn-primary" type="submit" name="submit"
                                           value="Aanmelden">
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-sm-6 col-xs-12 pull-right">
                <div class="block block-new-customer">
                    <div class="block-title">
                        <h2 class="title" id="block-new-customer-heading" role="heading" aria-level="2"><span>Eerste keer hier? Welkom!</span>
                        </h2>
                    </div>
                    <div class="block-content" aria-labelledby="block-new-customer-heading">
                        <p>Laat alvast je gegevens achter. <br>Met een eigen Delga account bestel je snel en 100%
                            veilig.</p>
                        <div class="actions-toolbar padding-top10">
                            <div class="primary">
                                <a href="registreer.php" class="action create btn btn-secondary"><span>Een Delga account aanmaken</span></a>
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