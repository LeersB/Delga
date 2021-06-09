<?php
$menu = 4;
include 'main.php';
$msg = '';
$error = '';
//Filters Persoonlijke informatie
$filter_voornaam = filter_input(INPUT_POST, 'voornaam', FILTER_SANITIZE_STRING);
$filter_achternaam = filter_input(INPUT_POST, 'achternaam', FILTER_SANITIZE_STRING);
$filter_telefoon_nr = filter_input(INPUT_POST, 'telefoon_nr', FILTER_SANITIZE_STRING);
$filter_bedrijfsnaam = filter_input(INPUT_POST, 'bedrijfsnaam', FILTER_SANITIZE_STRING);
$filter_btw_nr = filter_input(INPUT_POST, 'btw_nr', FILTER_SANITIZE_STRING);
//Filters Facturatieadres
$filter_adres_straat = filter_input(INPUT_POST, 'adres_straat', FILTER_SANITIZE_STRING);
$filter_adres_nr = filter_input(INPUT_POST, 'adres_nr', FILTER_SANITIZE_STRING);
$filter_adres_postcode = filter_input(INPUT_POST, 'adres_postcode', FILTER_SANITIZE_NUMBER_INT);
$filter_adres_plaats = filter_input(INPUT_POST, 'adres_plaats', FILTER_SANITIZE_STRING);
//Filters Leveringsadres
$filter_adres_straat_2 = filter_input(INPUT_POST, 'adres_straat_2', FILTER_SANITIZE_STRING);
$filter_adres_nr_2 = filter_input(INPUT_POST, 'adres_nr_2', FILTER_SANITIZE_STRING);
$filter_adres_postcode_2 = filter_input(INPUT_POST, 'adres_postcode_2', FILTER_SANITIZE_NUMBER_INT);
$filter_adres_plaats_2 = filter_input(INPUT_POST, 'adres_plaats_2', FILTER_SANITIZE_STRING);
//Filters Inloggegevens
$filter_email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$filter_wachtwoord = filter_input(INPUT_POST, 'wachtwoord');
$filter_cwachtwoord = filter_input(INPUT_POST, 'cwachtwoord');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // primary validate function
    function validate($str)
    {
        return trim(htmlspecialchars($str));
    }

    //Persoonlijke informatie
    if (!empty($filter_voornaam)) {
        $_SESSION['voornaam'] = $voornaam = validate($filter_voornaam);
        if (!preg_match('/^[a-zA-Z0-9\s]+$/', $voornaam)) {
            $error = 'Ongeldige voornaam';
        }
    }
    if (!empty($filter_achternaam)) {
        $achternaam = validate($filter_achternaam);
        if (!preg_match('/^[a-zA-Z0-9\s]+$/', $achternaam)) {
            $error = 'Ongeldige achternaam';
        }
    }
    if (!empty($filter_telefoon_nr)) {
        $telefoon_nr = validate($filter_telefoon_nr);
        if (!preg_match('/^[+][0-9\s]+$/', $telefoon_nr)) {
            $error = 'Ongeldige telefoon nummer, voorbeeld: +32495361149';
        }
    } else {
        $telefoon_nr = "";
    }
    if (!empty($filter_bedrijfsnaam)) {
        $bedrijfsnaam = validate($filter_bedrijfsnaam);
        if (!preg_match('/^[a-zA-Z0-9\s]+$/', $bedrijfsnaam)) {
            $error = 'Ongeldige bedrijfsnaam';
        }
    } else {
        $bedrijfsnaam = "";
    }
    if (!empty($filter_btw_nr)) {
        $btw_nr = validate($filter_btw_nr);
        if (!preg_match('/^[a-zA-Z0-9\s]+$/', $btw_nr)) {
            $error = 'Ongeldige btw nummer';
        }
    } else {
        $btw_nr = "";
    }

    // Facturatieadres
    if (empty($filter_adres_straat)) {
        $error = 'Vervolledig het registratie formulier!';
    } else {
        $adres_straat = validate($filter_adres_straat);
        if (!preg_match('/^[a-zA-Z0-9\s]+$/', $adres_straat)) {
            $error = 'Ongeldige straatnaam';
        }
    }
    if (empty($filter_adres_nr)) {
        $error = 'Vervolledig het registratie formulier!';
    } else {
        $adres_nr = validate($filter_adres_nr);
        if (!preg_match('/^[a-zA-Z0-9\s]+$/', $adres_nr)) {
            $error = 'Ongeldige adres nummer';
        }
    }
    if (empty($filter_adres_postcode)) {
        $error = 'Vervolledig het registratie formulier!';
    } else {
        $adres_postcode = validate($filter_adres_postcode);
        if (!preg_match('/^[0-9]+$/', $adres_postcode)) {
            $error = 'Postcode kan enkel 4 cijfers bevatten';
        }
    }
    if (empty($filter_adres_plaats)) {
        $error = 'Vervolledig het registratie formulier!';
    } else {
        $adres_plaats = validate($filter_adres_plaats);
        if (!preg_match('/^[a-zA-Z0-9\s]+$/', $adres_plaats)) {
            $error = 'Ongeldige plaats';
        }
    }
    // Leveringsadres
    if (isset($_POST['adres_factuur'])) {
        $adres_straat_2 = validate($filter_adres_straat);
        $adres_nr_2 = validate($filter_adres_nr);
        $adres_postcode_2 = validate($filter_adres_postcode);
        $adres_plaats_2 = validate($filter_adres_plaats);
    } else {
        if (empty($filter_adres_straat_2)) {
            $error = 'Vervolledig het registratie formulier!';
        } else {
            $adres_straat_2 = validate($filter_adres_straat_2);
            if (!preg_match('/^[a-zA-Z0-9\s]+$/', $adres_straat_2)) {
                $error = 'Ongeldige straatnaam';
            }
        }
        if (empty($filter_adres_nr_2)) {
            $error = 'Vervolledig het registratie formulier!';
        } else {
            $adres_nr_2 = validate($filter_adres_nr_2);
            if (!preg_match('/^[a-zA-Z0-9\s]+$/', $adres_nr_2)) {
                $error = 'Ongeldige adres nummer';
            }
        }
        if (empty($filter_adres_postcode_2)) {
            $error = 'Vervolledig het registratie formulier!';
        } else {
            $adres_postcode_2 = validate($filter_adres_postcode_2);
            if (!preg_match('/^[0-9\s]+$/', $adres_postcode_2)) {
                $error = 'Postcode kan enkel 4 cijfers bevatten';
            }
        }
        if (empty($filter_adres_plaats_2)) {
            $error = 'Vervolledig het registratie formulier!';
        } else {
            $adres_plaats_2 = validate($filter_adres_plaats_2);
            if (!preg_match('/^[a-zA-Z0-9\s]+$/', $adres_plaats_2)) {
                $error = 'Ongeldige plaats';
            }
        }
    }

    // Inloggegevens
    if (empty($filter_email)) {
        $error = 'Ongeldig e-mailadres';
    } else {
        $email = $filter_email;
    }
    if (empty($filter_wachtwoord)) {
        $error = 'Vervolledig het registratie formulier!';
    } else {
        $wachtwoord = $filter_wachtwoord;
        if (strlen($wachtwoord) > 16 || strlen($wachtwoord) < 8) {
            $error = 'Wachtwoord moet tussen 8 en 16 karakters lang zijn!';
        }
    }
    if (empty($filter_cwachtwoord)) {
        $error = 'Vervolledig het registratie formulier!';
    } else {
        $cwachtwoord = $filter_cwachtwoord;
        if (strlen($cwachtwoord) > 16 || strlen($cwachtwoord) < 8) {
            $error = 'Wachtwoord moet tussen 8 en 16 karakters lang zijn!';
        }
    }
    if ($filter_cwachtwoord != $filter_wachtwoord) {
        $error = 'Wachtwoorden komen niet overeen!';
    }

    if (empty($error)) {
        $pdo_function = pdo_connect_mysql();
        $stmtAccount = $pdo_function->prepare('SELECT user_id, wachtwoord FROM users WHERE email = ?');
        $stmtAccount->execute([$email]);
        $account = $stmtAccount->fetch(PDO::FETCH_ASSOC);
        if ($account) {
            $msg = 'Een account met dit e-mailadres bestaat al!';
        } else {
            $stmt = $pdo_function->prepare('INSERT INTO users (email, wachtwoord, activatie_code, registratie_datum, voornaam, achternaam, adres_straat, adres_nr, adres_postcode, adres_plaats, adres_straat_2, adres_nr_2, adres_postcode_2, adres_plaats_2, telefoon_nr, bedrijfsnaam, btw_nr, user_level) VALUES (?, ?, ?, NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $wachtwoord_hash = password_hash($wachtwoord, PASSWORD_DEFAULT);
            $uniqid = account_activatie ? uniqid() : 'activated';
            $stmt->execute([$email, $wachtwoord_hash, $uniqid, $voornaam, $achternaam, $adres_straat, $adres_nr, $adres_postcode, $adres_plaats, $adres_straat_2, $adres_nr_2, $adres_postcode_2, $adres_plaats_2, $telefoon_nr, $bedrijfsnaam, $btw_nr, $_POST['user_level']]);
            if (account_activatie) {
                $activatie_link = activatie_link . '?email=' . $email . '&code=' . $uniqid;
                send_activatie_email($email, $activatie_link, $voornaam, $achternaam);
                header('Location: registratie-voltooid.php');
                exit;
            } else {
                header('Location: registratie-voltooid.php');
                exit;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html class="h-100" lang="nl" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
    <meta name=”robots” content=”noindex,nofollow”>
    <meta content="Delga contactgegevens" name="description">
    <meta content="Bart Leers" name="author">
    <title>Delga account aanmaken</title>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/delga.css" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100">

<header>
    <?php include('includes/header.php'); ?>
</header>

<main class="flex-shrink-0">
    <div class="container">

        <div class="register">
            <h2>Maak uw Delga account aan</h2>
            <form class="needs-validation" novalidate action="" method="post" autocomplete="off">
                <div class="row">
                    <div class="legend col-md-12 h5">Persoonlijke informatie</div>
                    <div class="input-group col-md-6">
                        <label for="user_level"></label>
                        <select id="user_level" name="user_level" class="custom-select">
                            <option value="Prive" selected>Particuliere gebruiker</option>
                            <option value="Bedrijf">Zakelijke gebruiker</option>
                        </select>
                    </div>
                    <div class="input-group col-md-12"><br></div>
                    <div class="input-group col-md-6">
                        <label class="sr-only" for="voornaam">Voornaam</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-user"></i></div>
                            </div>
                            <input type="text" class="form-control" id="voornaam" name="voornaam" placeholder="Voornaam"
                                   maxlength="50"
                                   required value="<?php if (isset($voornaam)) echo $voornaam ?>">
                        </div>
                    </div>
                    <div class="input-group col-md-6">
                        <label class="sr-only" for="achternaam">Achternaam</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-user"></i></div>
                            </div>
                            <input type="text" class="form-control" id="achternaam" name="achternaam"
                                   placeholder="Achternaam" maxlength="50"
                                   required value="<?php if (isset($achternaam)) echo $achternaam ?>">
                        </div>
                    </div>
                    <div class="input-group col-md-6">
                        <label class="sr-only" for="telefoon_nr">Telefoonnummer</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-phone-alt"></i></div>
                            </div>
                            <input type="text" class="form-control" id="telefoon_nr" name="telefoon_nr"
                                   placeholder="Telefoonnummer"
                                   value="<?php if (isset($telefoon_nr)) echo $telefoon_nr ?>">
                        </div>
                    </div>
                    <div class="input-group col-md-12"><br></div>
                    <div class="form-group col-md-12" id="zakelijkDiv">
                        <div class="row">
                            <div class="input-group col-md-6">
                                <label class="sr-only" for="bedrijfsnaam">Bedrijfsnaam</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-industry"></i></div>
                                    </div>
                                    <input type="text" class="form-control" id="bedrijfsnaam" name="bedrijfsnaam"
                                           placeholder="Bedrijfsnaam" maxlength="50"
                                           value="<?php if (isset($bedrijfsnaam)) echo $bedrijfsnaam ?>">
                                </div>
                            </div>
                            <div class="input-group col-md-6">
                                <label class="sr-only" for="btw_nr">BTW-nummer</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-industry"></i></div>
                                    </div>
                                    <input type="text" class="form-control" id="btw_nr" name="btw_nr"
                                           placeholder="BTW-nummer" value="<?php if (isset($btw_nr)) echo $btw_nr ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 h5">Facturatieadres</div>
                    <div class="input-group col-md-9">
                        <label class="sr-only" for="adres_straat">Facturatieadres</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-house-user"></i></div>
                            </div>
                            <input type="text" class="form-control" id="adres_straat" name="adres_straat"
                                   placeholder="Facturatieadres" maxlength="80" required
                                   value="<?php if (isset($adres_straat)) echo $adres_straat ?>">
                        </div>
                    </div>
                    <div class="input-group col-md-3">
                        <label class="sr-only" for="adres_nr">Nr. / Bus</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-house-user"></i></div>
                            </div>
                            <input type="text" class="form-control" id="adres_nr" name="adres_nr"
                                   placeholder="Nr. / Bus" maxlength="20" required
                                   value="<?php if (isset($adres_nr)) echo $adres_nr ?>">
                        </div>
                    </div>

                    <div class="input-group col-md-6">
                        <label class="sr-only" for="adres_postcode">Postcode</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-house-user"></i></div>
                            </div>
                            <input type="text" class="form-control" id="adres_postcode" name="adres_postcode"
                                   placeholder="Postcode" maxlength="4" required
                                   value="<?php if (isset($adres_postcode)) echo $adres_postcode ?>">
                        </div>
                    </div>
                    <div class="input-group col-md-6">
                        <label class="sr-only" for="adres_plaats">Plaats</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-house-user"></i></div>
                            </div>
                            <input type="text" class="form-control" id="adres_plaats" name="adres_plaats"
                                   placeholder="Plaats" maxlength="50" required
                                   value="<?php if (isset($adres_plaats)) echo $adres_plaats ?>">
                        </div>
                    </div>
                    <div class="input-group col-md-12"><br></div>
                    <div class="col-md-12 h5">Leveringsadres</div>

                    <div class="col-md-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="adres_factuur" name="adres_factuur">
                            <label class="form-check-label" for="adres_factuur">Hetzelfde als facturatieadres</label>
                        </div>
                    </div>

                    <div class="form-group col-md-12" id="leveringsadres">
                        <div class="row">
                            <div class="input-group col-md-9">
                                <label class="sr-only" for="adres_straat_2">Leveringsadres</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-house-user"></i></div>
                                    </div>
                                    <input type="text" class="form-control" id="adres_straat_2" name="adres_straat_2"
                                           placeholder="Leveringsadres" maxlength="80" required
                                           value="<?php if (isset($adres_straat_2)) echo $adres_straat_2 ?>">
                                </div>
                            </div>
                            <div class="input-group col-md-3">
                                <label class="sr-only" for="adres_nr_2">Nr. / Bus</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-house-user"></i></div>
                                    </div>
                                    <input type="text" class="form-control" id="adres_nr_2" name="adres_nr_2"
                                           placeholder="Nr. / Bus" maxlength="20" required
                                           value="<?php if (isset($adres_nr_2)) echo $adres_nr_2 ?>">
                                </div>
                            </div>
                            <div class="input-group col-md-6">
                                <label class="sr-only" for="adres_postcode_2">Postcode</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-house-user"></i></div>
                                    </div>
                                    <input type="text" class="form-control" id="adres_postcode_2"
                                           name="adres_postcode_2"
                                           placeholder="Postcode" maxlength="4" required
                                           value="<?php if (isset($adres_postcode_2)) echo $adres_postcode_2 ?>">
                                </div>
                            </div>
                            <div class="input-group col-md-6">
                                <label class="sr-only" for="adres_plaats_2">Plaats</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-house-user"></i></div>
                                    </div>
                                    <input type="text" class="form-control" id="adres_plaats_2" name="adres_plaats_2"
                                           placeholder="Plaats" maxlength="50" required
                                           value="<?php if (isset($adres_plaats_2)) echo $adres_plaats_2 ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="input-group col-md-12"><br></div>

                    <div class="col-md-12 h5">Inloggegevens</div>

                    <div class="input-group col-md-12">
                        <label class="sr-only" for="email">E-mailadres</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-envelope"></i></div>
                            </div>
                            <input type="email" class="form-control" id="email" name="email" placeholder="E-mailadres"
                                   maxlength="100"
                                   required value="<?php if (isset($email)) echo $email ?>">
                        </div>
                    </div>
                    <div class="input-group col-md-12">
                        <label class="sr-only" for="wachtwoord">Wachtwoord</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-lock"></i></div>
                            </div>
                            <input type="password" class="form-control" id="wachtwoord" name="wachtwoord"
                                   placeholder="Wachtwoord" aria-describedby="wachtwoordHelpBlock" required>
                            <small id="wachtwoordHelpBlock" class="form-text text-muted col-md-12">
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
                    <div class="col-md-12 h5">
                        <p><?php if (isset($error)) echo $error ?><?php if (isset($msg)) echo $msg ?></p></div>

                    <div class="col-12">
                        <a class="btn btn-secondary" href="login.php" role="button"><i class="fas fa-times"></i>
                            Annuleer</a>
                        <button type="submit" class="btn btn-success" name="submit"><i class="fas fa-check"></i>
                            Registreer
                        </button>
                    </div>
                    <div class="input-group col-md-12"><br></div>
                </div>
            </form>
        </div>

    </div>
</main>

<?php include('includes/footer.php'); ?>
<script>
    $("#user_level").change(function () {
        if ($(this).val() === "Bedrijf") {
            $('#zakelijkDiv').show();
            $('#bedrijfsnaam').attr('required', '');
            $('#btw_nr').attr('required', '');
        } else {
            $('#zakelijkDiv').hide();
            $('#bedrijfsnaam').removeAttr('required');
            $('#btw_nr').removeAttr('required');
        }
    });
</script>
<script>
    $(function () {
        $("#adres_factuur").change(function () {
            if ($(this).val() === "Yes") {
                $('#leveringsadres').show();
                $(this).val("No");
                $('#adres_straat_2').attr('required', '');
                $('#adres_nr_2').attr('required', '');
                $('#adres_postcode_2').attr('required', '');
                $('#adres_plaats_2').attr('required', '');
            } else {
                $('#leveringsadres').hide();
                $(this).val("Yes");
                $('#adres_straat_2').removeAttr('required');
                $('#adres_nr_2').removeAttr('required');
                $('#adres_postcode_2').removeAttr('required');
                $('#adres_plaats_2').removeAttr('required');
            }
        });
    });
</script>
<script>
    $("#user_level").trigger("change");
</script>
<script src="js/form-validation.js"></script>
</body>
</html>