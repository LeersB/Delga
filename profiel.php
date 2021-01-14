<?php
$menu = 4;
include 'main.php';
$pdo_function = pdo_connect_mysql();
check_loggedin($pdo_function);
$msg = '';
$stmt = $pdo_function->prepare('SELECT * FROM users WHERE user_id = ?');
$stmt->execute([$_SESSION['user_id']]);
$account = $stmt->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['voornaam'], $_POST['achternaam'], $_POST['wachtwoord'], $_POST['cwachtwoord'], $_POST['email'])) {

    if (empty($_POST['voornaam']) || (empty($_POST['achternaam'])) || empty($_POST['email'])) {
        $msg = 'Vervolledig het formulier!';
    } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $msg = 'E-mailadres is niet geldig!';
    } else if (!preg_match('/^[a-zA-Z]+$/', $_POST['voornaam'])) {
        $msg = 'Voornaam mag alleen uit letters bestaan!';
    } else if (!preg_match('/^[a-zA-Z]+$/', $_POST['achternaam'])) {
        $msg = 'Achternaam mag alleen uit letters bestaan!';
    } else if (!empty($_POST['wachtwoord']) && (strlen($_POST['wachtwoord']) > 16 || strlen($_POST['wachtwoord']) < 8)) {
        $msg = 'Wachtwoord moet tussen 8 en 16 karakters lang zijn!';
    } else if ($_POST['cwachtwoord'] != $_POST['wachtwoord']) {
        $msg = 'Wachtwoorden komen niet overeen!';
    }
    if (empty($msg)) {
        $stmt = $pdo_function->prepare('SELECT COUNT(*) FROM users WHERE (email = ?) AND email != ?');
        $stmt->execute([$_POST['email'], $_SESSION['email']]);
        if ($result = $stmt->fetchColumn()) {
            $msg = 'Een account met dit e-mailadres bestaat reeds!';
        } else {
            // update profiel
            $uniqid = account_activatie && $account['email'] != $_POST['email'] ? uniqid() : $account['activatie_code'];
            $stmt = $pdo_function->prepare('UPDATE users SET email = ?, wachtwoord = ?, voornaam = ?, achternaam = ?, adres_straat = ?, adres_nr = ?, adres_postcode = ?, adres_plaats = ?, telefoon_nr = ?, bedrijfsnaam = ?, btw_nr = ?, activatie_code = ? WHERE user_id = ?');
            $wachtwoord = !empty($_POST['wachtwoord']) ? password_hash($_POST['wachtwoord'], PASSWORD_DEFAULT) : $account['wachtwoord'];
            $stmt->execute([$_POST['email'], $wachtwoord, $_POST['voornaam'], $_POST['achternaam'], $_POST['adres_straat'], $_POST['adres_nr'], $_POST['adres_postcode'], $_POST['adres_plaats'], $_POST['telefoon_nr'], $_POST['bedrijfsnaam'], $_POST['btw_nr'], $uniqid, $_SESSION['user_id']]);
            $_SESSION['email'] = $_POST['email'];
            if (account_activatie && $account['email'] != $_POST['email']) {
                send_activation_email($_POST['email'], $uniqid);
                unset($_SESSION['loggedin']);
                $msg = 'U hebt het e-mailadres aangepast, u moet deze eerst terug activeren voor u kunt aanmelden!';
            } else {
                header('Location: profiel.php');
                exit;
            }
        }
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
    <title>Profiel Pagina</title>
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
            <?php if (!isset($_GET['action'])): ?>
                <div class="jumbotron p-4 p-md-5 text-dark rounded bg-light">
                    <div class="content profile">
                        <h2>Delga profiel</h2>
                        <div class="block">
                            <p>Uw account details staan hieronder.</p>

                            <dl class="row">
                                <dt class="col-md-3">Voornaam:</dt>
                                <dd class="col-md-9"><?= $account['voornaam'] ?></dd>
                                <dt class="col-md-3">Achternaam:</dt>
                                <dd class="col-md-9"><?= $account['achternaam'] ?></dd>
                                <dt class="col-md-3">Telefoonnummer:</dt>
                                <dd class="col-md-9"><?= $account['telefoon_nr'] ?></dd>
                                <dt class="col-md-3">E-mailadres:</dt>
                                <dd class="col-md-9"><?= $_SESSION['email'] ?></dd>
                                <dt class="col-md-3">Adres:</dt>
                                <dd class="col-md-9"><?= $account['adres_straat'] ?></dd>
                                <dt class="col-md-3">Huisnummer / Bus:</dt>
                                <dd class="col-md-9"><?= $account['adres_nr'] ?></dd>
                                <dt class="col-md-3">Postcode:</dt>
                                <dd class="col-md-9"><?= $account['adres_postcode'] ?></dd>
                                <dt class="col-md-3">Plaats:</dt>
                                <dd class="col-md-9"><?= $account['adres_plaats'] ?></dd>
                                <?php if ($account['user_level'] == 'Bedrijf'): ?>
                                    <dt class="col-md-3">Bedrijfsnaam:</dt>
                                    <dd class="col-md-9"><?= $account['bedrijfsnaam'] ?></dd>
                                    <dt class="col-md-3">BTW-nummer:</dt>
                                    <dd class="col-md-9"><?= $account['btw_nr'] ?></dd>
                                <?php endif; ?>
                            </dl>

                            <a class="btn btn-secondary" href="profiel.php?action=edit" role="button"><i
                                        class="far fa-edit"></i> Aanpassen</a>
                        </div>
                    </div>
                </div>
            <?php elseif ($_GET['action'] == 'edit'): ?>
                <div class="content profile">
                    <h2>Uw delga profiel aanpassen</h2>
                    <div class="block">
                        <form class="needs-validation" novalidate action="profiel.php?action=edit" method="post">
                            <div class="row">

                                <legend class="legend col-md-12"><span>Persoonlijke informatie</span></legend>
                                <div class="input-group col-md-6">
                                    <label class="sr-only" for="voornaam">Voornaam</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-user"></i></div>
                                        </div>
                                        <input type="text" class="form-control" id="voornaam" name="voornaam"
                                               value="<?= $account['voornaam'] ?>" placeholder="Voornaam" required>
                                    </div>
                                </div>
                                <div class="input-group col-md-6">
                                    <label class="sr-only" for="achternaam">Achternaam</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-user"></i></div>
                                        </div>
                                        <input type="text" class="form-control" id="achternaam" name="achternaam"
                                               value="<?= $account['achternaam'] ?>" placeholder="Achternaam" required>
                                    </div>
                                </div>
                                <div class="input-group col-md-12"><br></div>
                                <div class="input-group col-md-6">
                                    <label class="sr-only" for="telefoon_nr">Telefoonnummer</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-phone-alt"></i></div>
                                        </div>
                                        <input type="text" class="form-control" id="telefoon_nr" name="telefoon_nr"
                                               value="<?= $account['telefoon_nr'] ?>" placeholder="Telefoonnummer">
                                    </div>
                                </div>
                                <div class="input-group col-md-12"><br></div>

                                <legend class="legend col-md-12"><span>Adres Gegevens</span></legend>
                                <?php if ($account['user_level'] == 'Bedrijf'): ?>
                                <div class="input-group col-md-6">
                                    <label class="sr-only" for="bedrijfsnaam">Bedrijfsnaam</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-industry"></i></div>
                                        </div>
                                        <input type="text" class="form-control" id="bedrijfsnaam" name="bedrijfsnaam"
                                               value="<?= $account['bedrijfsnaam'] ?>" placeholder="Bedrijfsnaam" required>
                                    </div>
                                </div>
                                <div class="input-group col-md-6">
                                    <label class="sr-only" for="btw_nr">BTW-nummer</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-industry"></i></div>
                                        </div>
                                        <input type="text" class="form-control" id="btw_nr" name="btw_nr"
                                               value="<?= $account['btw_nr'] ?>" placeholder="BTW-nummer" required>
                                    </div>
                                </div>
                                <div class="input-group col-md-12"><br></div>
                                <?php endif; ?>
                                <div class="input-group col-md-9">
                                    <label class="sr-only" for="adres_straat">Adres</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-house-user"></i></div>
                                        </div>
                                        <input type="text" class="form-control" id="adres_straat" name="adres_straat"
                                               value="<?= $account['adres_straat'] ?>" placeholder="Adres" required>
                                    </div>
                                </div>
                                <div class="input-group col-md-3">
                                    <label class="sr-only" for="adres_nr">Huisnummer / Bus</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-house-user"></i></div>
                                        </div>
                                        <input type="text" class="form-control" id="adres_nr" name="adres_nr"
                                               value="<?= $account['adres_nr'] ?>" placeholder="Huisnummer / Bus"
                                               required>
                                        <div class="invalid-feedback">Dit veld is verplicht.</div>
                                    </div>
                                </div>
                                <div class="input-group col-md-12"><br></div>
                                <div class="input-group col-md-6">
                                    <label class="sr-only" for="adres_postcode">Postcode</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-house-user"></i></div>
                                        </div>
                                        <input type="text" class="form-control" id="adres_postcode"
                                               name="adres_postcode"
                                               value="<?= $account['adres_postcode'] ?>" placeholder="Postcode"
                                               required>
                                    </div>
                                </div>
                                <div class="input-group col-md-6">
                                    <label class="sr-only" for="adres_plaats">Plaats</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-house-user"></i></div>
                                        </div>
                                        <input type="text" class="form-control" id="adres_plaats" name="adres_plaats"
                                               value="<?= $account['adres_plaats'] ?>" placeholder="Plaats" required>
                                    </div>
                                </div>
                                <div class="input-group col-md-12"><br></div>

                                <legend class="legend col-md-12"><span>Inloggegevens</span></legend>
                                <div class="input-group col-md-12">
                                    <label class="sr-only" for="email">E-mailadres</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-envelope"></i></div>
                                        </div>
                                        <input type="email" class="form-control" id="email" name="email"
                                               value="<?= $_SESSION['email'] ?>" placeholder="E-mailadres" required>
                                    </div>
                                </div>
                                <div class="input-group col-md-12"><br></div>
                                <div class="input-group col-md-12">
                                    <label class="sr-only" for="wachtwoord">Wachtwoord</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-lock"></i></div>
                                        </div>
                                        <input type="password" class="form-control" id="wachtwoord" name="wachtwoord"
                                               placeholder="Wachtwoord" aria-describedby="wachtwoordHelpBlock">
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
                                               placeholder="Bevestig wachtwoord">
                                    </div>
                                </div>
                                <div class="col-md-12 text-danger msg"><?= $msg ?></div>
                                <div class="input-group col-md-12"><br></div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Opslaan
                                    </button>
                                    <a class="btn btn-secondary" href="profiel.php" role="button"><i
                                                class="fas fa-times"></i> Annuleer</a>
                                </div>
                                <div class="input-group col-md-12"><br></div>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php include('includes/footer.php'); ?>
<script src="js/form-validation.js"></script>
</body>
</html>
