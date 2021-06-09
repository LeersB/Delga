<?php
$menu = 5;
include 'main.php';
$pdo_function = pdo_connect_mysql();
check_loggedin($pdo_function);
$msg = '';
include 'registratie-filter.php';
//global variabelen van registratie-filter.php
global $error;
global $voornaam;
global $achternaam;
global $telefoon_nr;
global $bedrijfsnaam;
global $btw_nr;
global $adres_straat;
global $adres_nr;
global $adres_postcode;
global $adres_plaats;
global $adres_straat_2;
global $adres_nr_2;
global $adres_postcode_2;
global $adres_plaats_2;
global $email;
global $wachtwoord;

//Get user
$stmt = $pdo_function->prepare('SELECT * FROM users WHERE user_id = ?');
$stmt->execute([$_SESSION['user_id']]);
$account = $stmt->fetch(PDO::FETCH_ASSOC);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($error)) {
        $stmt = $pdo_function->prepare('SELECT COUNT(*) FROM users WHERE (email = ?) AND email != ?');
        $stmt->execute([$email, $account['email']]);
        if ($result = $stmt->fetchColumn()) {
            $msg = 'Een account met dit e-mailadres bestaat reeds!';
        } else {
            // update profiel
            $uniqid = account_activatie && $account['email'] != $email ? uniqid() : $account['activatie_code'];
            $stmt = $pdo_function->prepare('UPDATE users SET email = ?, wachtwoord = ?, voornaam = ?, achternaam = ?, adres_straat = ?, adres_nr = ?, adres_postcode = ?, adres_plaats = ?, adres_straat_2 = ?, adres_nr_2 = ?, adres_postcode_2 = ?, adres_plaats_2 = ?, telefoon_nr = ?, bedrijfsnaam = ?, btw_nr = ?, activatie_code = ? WHERE user_id = ?');
            $wachtwoord_hash = !empty($wachtwoord) ? password_hash($wachtwoord, PASSWORD_DEFAULT) : $account['wachtwoord'];
            $stmt->execute([$email, $wachtwoord_hash, $voornaam, $achternaam, $adres_straat, $adres_nr, $adres_postcode, $adres_plaats, $adres_straat_2, $adres_nr_2, $adres_postcode_2, $adres_plaats_2, $telefoon_nr, $bedrijfsnaam, $btw_nr, $uniqid, $_SESSION['user_id']]);
            if (account_activatie && $account['email'] != $email) {
                $activatie_link = activatie_link . '?email=' . $email . '&code=' . $uniqid;
                send_activatie_email($email, $activatie_link, $voornaam, $achternaam);
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
    <meta name=”robots” content=”noindex,nofollow”>
    <meta content="Delga contactgegevens" name="description">
    <meta content="Bart Leers" name="author">
    <title>Delga account</title>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/delga.css" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100">

<header>
    <?php include('includes/header.php'); ?>
</header>

<main class="flex-shrink-0">
    <div class="container">
        <div class="content">
            <div class="jumbotron p-4 p-md-5 text-dark rounded bg-light">
                <div class="content profile">
                    <h2>Delga account</h2>
                    <div class="block">
                        <p>Uw account details staan hieronder.</p>
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" href="profiel.php">Profiel</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="bestellingen.php">Bestellingen</a>
                            </li>
                        </ul>

                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="profiel" role="tabpanel"
                                 aria-labelledby="profiel-tab">
                                <?php if (!isset($_GET['action'])): ?>
                                    <dl class="row">
                                        <div class="input-group col-md-12"><br></div>
                                        <dt class="col-md-3">Voornaam:</dt>
                                        <dd class="col-md-9"><?= $account['voornaam'] ?></dd>
                                        <dt class="col-md-3">Achternaam:</dt>
                                        <dd class="col-md-9"><?= $account['achternaam'] ?></dd>
                                        <dt class="col-md-3">Telefoonnummer:</dt>
                                        <dd class="col-md-9"><?= $account['telefoon_nr'] ?></dd>
                                        <dt class="col-md-3">E-mailadres:</dt>
                                        <dd class="col-md-9"><?= $account['email'] ?></dd>
                                        <?php if ($account['user_level'] == 'Bedrijf'): ?>
                                            <dt class="col-md-3">Bedrijfsnaam:</dt>
                                            <dd class="col-md-9"><?= $account['bedrijfsnaam'] ?></dd>
                                            <dt class="col-md-3">BTW-nummer:</dt>
                                            <dd class="col-md-9"><?= $account['btw_nr'] ?></dd>
                                        <?php endif; ?>
                                        <dt class="col-md-3">Facturatieadres:</dt>
                                        <dd class="col-md-9"><?= $account['adres_straat'], ' ', $account['adres_nr'] ?></dd>
                                        <dt class="col-md-3"></dt>
                                        <dd class="col-md-9"><?= $account['adres_postcode'], ' ', $account['adres_plaats'] ?></dd>
                                        <dt class="col-md-3">Leveringsadres:</dt>
                                        <dd class="col-md-9"><?= $account['adres_straat_2'], ' ', $account['adres_nr_2'] ?></dd>
                                        <dt class="col-md-3"></dt>
                                        <dd class="col-md-9"><?= $account['adres_postcode_2'], ' ', $account['adres_plaats_2'] ?></dd>
                                    </dl>

                                    <a class="btn btn-secondary" href="profiel.php?action=edit" role="button"><i
                                                class="far fa-edit"></i> Aanpassen</a>

                                <?php elseif ($_GET['action'] == 'edit'): ?>
                                    <div class="content profile">
                                        <div class="block">
                                            <form class="needs-validation" novalidate action="profiel.php?action=edit"
                                                  method="post">
                                                <div class="row">
                                                    <div class="input-group col-md-12"><br></div>
                                                    <div class="col-md-12 h5">Persoonlijke informatie</div>
                                                    <div class="input-group col-md-6">
                                                        <label class="sr-only" for="voornaam">Voornaam</label>
                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text"><i
                                                                            class="fas fa-user"></i></div>
                                                            </div>
                                                            <input type="text" class="form-control" id="voornaam"
                                                                   name="voornaam"
                                                                   value="<?= $account['voornaam'] ?>"
                                                                   placeholder="Voornaam" maxlength="50" required>
                                                        </div>
                                                    </div>
                                                    <div class="input-group col-md-6">
                                                        <label class="sr-only" for="achternaam">Achternaam</label>
                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text"><i
                                                                            class="fas fa-user"></i></div>
                                                            </div>
                                                            <input type="text" class="form-control" id="achternaam"
                                                                   name="achternaam"
                                                                   value="<?= $account['achternaam'] ?>"
                                                                   placeholder="Achternaam" maxlength="50" required>
                                                        </div>
                                                    </div>
                                                    <div class="input-group col-md-6">
                                                        <label class="sr-only" for="telefoon_nr">Telefoonnummer</label>
                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text"><i
                                                                            class="fas fa-phone-alt"></i></div>
                                                            </div>
                                                            <input type="text" class="form-control" id="telefoon_nr"
                                                                   name="telefoon_nr"
                                                                   value="<?= $account['telefoon_nr'] ?>"
                                                                   placeholder="Telefoonnummer">
                                                        </div>
                                                    </div>
                                                    <div class="input-group col-md-12"><br></div>
                                                    <?php if ($account['user_level'] == 'Bedrijf'): ?>
                                                        <div class="input-group col-md-6">
                                                            <label class="sr-only"
                                                                   for="bedrijfsnaam">Bedrijfsnaam</label>
                                                            <div class="input-group mb-2">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text"><i
                                                                                class="fas fa-industry"></i></div>
                                                                </div>
                                                                <input type="text" class="form-control"
                                                                       id="bedrijfsnaam"
                                                                       name="bedrijfsnaam"
                                                                       value="<?= $account['bedrijfsnaam'] ?>"
                                                                       placeholder="Bedrijfsnaam"
                                                                       required>
                                                            </div>
                                                        </div>
                                                        <div class="input-group col-md-6">
                                                            <label class="sr-only" for="btw_nr">BTW-nummer</label>
                                                            <div class="input-group mb-2">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text"><i
                                                                                class="fas fa-industry"></i></div>
                                                                </div>
                                                                <input type="text" class="form-control" id="btw_nr"
                                                                       name="btw_nr"
                                                                       value="<?= $account['btw_nr'] ?>"
                                                                       placeholder="BTW-nummer" required>
                                                            </div>
                                                        </div>
                                                        <div class="input-group col-md-12"><br></div>
                                                    <?php endif; ?>
                                                    <div class="col-md-12 h5">Facturatieadres</div>
                                                    <div class="input-group col-md-9">
                                                        <label class="sr-only" for="adres_straat">Adres</label>
                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text"><i
                                                                            class="fas fa-house-user"></i></div>
                                                            </div>
                                                            <input type="text" class="form-control" id="adres_straat"
                                                                   name="adres_straat"
                                                                   value="<?= $account['adres_straat'] ?>"
                                                                   placeholder="Adres" required>
                                                        </div>
                                                    </div>
                                                    <div class="input-group col-md-3">
                                                        <label class="sr-only" for="adres_nr">Huisnummer / Bus</label>
                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text"><i
                                                                            class="fas fa-house-user"></i></div>
                                                            </div>
                                                            <input type="text" class="form-control" id="adres_nr"
                                                                   name="adres_nr"
                                                                   value="<?= $account['adres_nr'] ?>"
                                                                   placeholder="Huisnummer / Bus"
                                                                   required>
                                                            <div class="invalid-feedback">Dit veld is verplicht.</div>
                                                        </div>
                                                    </div>
                                                    <div class="input-group col-md-6">
                                                        <label class="sr-only" for="adres_postcode">Postcode</label>
                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text"><i
                                                                            class="fas fa-house-user"></i></div>
                                                            </div>
                                                            <input type="text" class="form-control" id="adres_postcode"
                                                                   name="adres_postcode"
                                                                   value="<?= $account['adres_postcode'] ?>"
                                                                   placeholder="Postcode"
                                                                   required>
                                                        </div>
                                                    </div>
                                                    <div class="input-group col-md-6">
                                                        <label class="sr-only" for="adres_plaats">Plaats</label>
                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text"><i
                                                                            class="fas fa-house-user"></i></div>
                                                            </div>
                                                            <input type="text" class="form-control" id="adres_plaats"
                                                                   name="adres_plaats"
                                                                   value="<?= $account['adres_plaats'] ?>"
                                                                   placeholder="Plaats" required>
                                                        </div>
                                                    </div>
                                                    <div class="input-group col-md-12"><br></div>
                                                    <div class="col-md-12 h5">Leveringsadres</div>
                                                    <div class="input-group col-md-9">
                                                        <label class="sr-only" for="adres_straat_2">Adres</label>
                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text"><i
                                                                            class="fas fa-house-user"></i></div>
                                                            </div>
                                                            <input type="text" class="form-control" id="adres_straat_2"
                                                                   name="adres_straat_2"
                                                                   value="<?= $account['adres_straat_2'] ?>"
                                                                   placeholder="Adres" required>
                                                        </div>
                                                    </div>
                                                    <div class="input-group col-md-3">
                                                        <label class="sr-only" for="adres_nr_2">Huisnummer / Bus</label>
                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text"><i
                                                                            class="fas fa-house-user"></i></div>
                                                            </div>
                                                            <input type="text" class="form-control" id="adres_nr_2"
                                                                   name="adres_nr_2"
                                                                   value="<?= $account['adres_nr_2'] ?>"
                                                                   placeholder="Huisnummer / Bus"
                                                                   required>
                                                            <div class="invalid-feedback">Dit veld is verplicht.</div>
                                                        </div>
                                                    </div>
                                                    <div class="input-group col-md-6">
                                                        <label class="sr-only" for="adres_postcode_2">Postcode</label>
                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text"><i
                                                                            class="fas fa-house-user"></i></div>
                                                            </div>
                                                            <input type="text" class="form-control"
                                                                   id="adres_postcode_2"
                                                                   name="adres_postcode_2"
                                                                   value="<?= $account['adres_postcode_2'] ?>"
                                                                   placeholder="Postcode"
                                                                   required>
                                                        </div>
                                                    </div>
                                                    <div class="input-group col-md-6">
                                                        <label class="sr-only" for="adres_plaats_2">Plaats</label>
                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text"><i
                                                                            class="fas fa-house-user"></i></div>
                                                            </div>
                                                            <input type="text" class="form-control" id="adres_plaats_2"
                                                                   name="adres_plaats_2"
                                                                   value="<?= $account['adres_plaats_2'] ?>"
                                                                   placeholder="Plaats" required>
                                                        </div>
                                                    </div>
                                                    <div class="input-group col-md-12"><br></div>

                                                    <div class="col-md-12 h5">Inloggegevens</div>
                                                    <div class="input-group col-md-12">
                                                        <label class="sr-only" for="email">E-mailadres</label>
                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text"><i
                                                                            class="fas fa-envelope"></i></div>
                                                            </div>
                                                            <input type="email" class="form-control" id="email"
                                                                   name="email"
                                                                   value="<?= $account['email'] ?>"
                                                                   placeholder="E-mailadres" required>
                                                        </div>
                                                    </div>
                                                    <div class="input-group col-md-12">
                                                        <label class="sr-only" for="wachtwoord">Wachtwoord</label>
                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text"><i
                                                                            class="fas fa-lock"></i></div>
                                                            </div>
                                                            <input type="password" class="form-control" id="wachtwoord"
                                                                   name="wachtwoord"
                                                                   placeholder="Wachtwoord"
                                                                   aria-describedby="wachtwoordHelpBlock">
                                                            <small id="wachtwoordHelpBlock"
                                                                   class="form-text text-muted col-md-12">
                                                                Uw wachtwoord moet tussen 8 en 16 karakters lang zijn!
                                                            </small>
                                                        </div>
                                                    </div>
                                                    <div class="input-group col-md-12">
                                                        <label class="sr-only" for="cwachtwoord">Bevestig
                                                            wachtwoord</label>
                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text"><i
                                                                            class="fas fa-lock"></i></div>
                                                            </div>
                                                            <input type="password" class="form-control" id="cwachtwoord"
                                                                   name="cwachtwoord"
                                                                   placeholder="Bevestig wachtwoord">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 text-danger h5">
                                                        <p><?php if (isset($error)) echo $error ?><?php if (isset($msg)) echo $msg ?></p></div>
                                                    <div class="input-group col-md-12"><br></div>
                                                    <div class="col-12">
                                                        <a class="btn btn-secondary" href="profiel.php" role="button"><i
                                                                    class="fas fa-times"></i> Annuleer</a>
                                                        <button type="submit" class="btn btn-success"><i
                                                                    class="fas fa-check"></i> Opslaan
                                                        </button>
                                                    </div>
                                                    <div class="input-group col-md-12"><br></div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</main>

<?php include('includes/footer.php'); ?>
<script src="js/form-validation.js"></script>
</body>
</html>