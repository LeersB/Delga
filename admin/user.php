<?php
$menuadmin = 2;
include 'main.php';
$pdo_function = pdo_connect_mysql();
// Default input user array
$user = array(
    'email' => '',
    'wachtwoord' => '',
    'voornaam' => '',
    'achternaam' => '',
    'adres_straat' => '',
    'adres_nr' => '',
    'adres_postcode' => '',
    'adres_plaats' => '',
    'adres_straat_2' => '',
    'adres_nr_2' => '',
    'adres_postcode_2' => '',
    'adres_plaats_2' => '',
    'telefoon_nr' => '',
    'bedrijfsnaam' => '',
    'btw_nr' => '',
    'activatie_code' => '',
    'terugkeer_code' => '',
    'user_level' => 'Prive'
);
$user_levels = array('Prive', 'Bedrijf', 'Admin');
if (isset($_GET['user_id'])) {
    $stmt = $pdo_function->prepare('SELECT * FROM users WHERE user_id = ?');
    $stmt->execute([$_GET['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $page = 'Edit';
    if (isset($_POST['submit'])) {
        // Update account
        $stmt = $pdo_function->prepare('UPDATE users SET email = ?, wachtwoord = ?, voornaam = ?, achternaam = ?, adres_straat = ?, adres_nr = ?, adres_postcode = ?, adres_plaats = ?, adres_straat_2 = ?, adres_nr_2 = ?, adres_postcode_2 = ?, adres_plaats_2 = ?, telefoon_nr = ?, bedrijfsnaam = ?, btw_nr = ?, activatie_code = ?, terugkeer_code = ?, user_level = ? WHERE user_id = ?');
        $wachtwoord = $user['wachtwoord'] != $_POST['wachtwoord'] ? password_hash($_POST['wachtwoord'], PASSWORD_DEFAULT) : $user['wachtwoord'];
        $stmt->execute([$_POST['email'], $wachtwoord, $_POST['voornaam'], $_POST['achternaam'], $_POST['adres_straat'], $_POST['adres_nr'], $_POST['adres_postcode'], $_POST['adres_plaats'], $_POST['adres_straat_2'], $_POST['adres_nr_2'], $_POST['adres_postcode_2'], $_POST['adres_plaats_2'], $_POST['telefoon_nr'], $_POST['bedrijfsnaam'], $_POST['btw_nr'], $_POST['activatie_code'], $_POST['terugkeer_code'], $_POST['user_level'], $_GET['user_id']]);
        header('Location: users.php');
        exit;
    }
    if (isset($_POST['delete'])) {
        // Delete account
        $stmt = $pdo_function->prepare('DELETE FROM users WHERE user_id = ?');
        $stmt->execute([$_GET['user_id']]);
        header('Location: users.php');
        exit;
    }
} else {
    // Create account
    $page = 'Create';
    if (isset($_POST['submit'])) {
        $stmt = $pdo_function->prepare('INSERT IGNORE INTO users (email, wachtwoord, user_level, activatie_code, registratie_datum, voornaam, achternaam, adres_straat, adres_nr, adres_postcode, adres_plaats, adres_straat_2, adres_nr_2, adres_postcode_2, adres_plaats_2, telefoon_nr, bedrijfsnaam, btw_nr) VALUES (?, ?, ?, ?, NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $wachtwoord = password_hash($_POST['wachtwoord'], PASSWORD_DEFAULT);
        $stmt->execute([$_POST['email'], $wachtwoord, $_POST['user_level'], $_POST['activatie_code'], $_POST['voornaam'], $_POST['achternaam'], $_POST['adres_straat'], $_POST['adres_nr'], $_POST['adres_postcode'], $_POST['adres_plaats'], $_POST['adres_straat_2'], $_POST['adres_nr_2'], $_POST['adres_postcode_2'], $_POST['adres_plaats_2'], $_POST['telefoon_nr'], $_POST['bedrijfsnaam'], $_POST['btw_nr']]);
        header('Location: users.php');
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
        <title>Delga admin user</title>
        <link href="../css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="../css/delga-admin.css" rel="stylesheet">
    </head>

    <body class="d-flex flex-column h-100">

        <header>
            <?php include('includes/header.php'); ?>
        </header>

        <main class="flex-shrink-0">
            <div class="container">

                <div class="content">

                    <form class="needs-validation" novalidate action="" method="post" autocomplete="off">
                        <div class="row">
                            <legend class="legend col-md-12"><span>Persoonlijke informatie</span></legend>
                            <div class="input-group col-md-6">
                                <label class="sr-only" for="voornaam">Voornaam</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-user"></i></div>
                                    </div>
                                    <input type="text" class="form-control" id="voornaam" name="voornaam"
                                           value="<?= $user['voornaam'] ?>" placeholder="Voornaam" required>
                                    <div class="invalid-feedback">Dit veld is verplicht.</div>
                                </div>
                            </div>
                            <div class="input-group col-md-6">
                                <label class="sr-only" for="achternaam">Achternaam</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-user"></i></div>
                                    </div>
                                    <input type="text" class="form-control" id="achternaam" name="achternaam"
                                           value="<?= $user['achternaam'] ?>" placeholder="Achternaam" required>
                                    <div class="invalid-feedback">Dit veld is verplicht.</div>
                                </div>
                            </div>
                            <div class="input-group col-md-6">
                                <label class="sr-only" for="telefoon_nr">Telefoonnummer</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-phone-alt"></i></div>
                                    </div>
                                    <input type="text" class="form-control" id="telefoon_nr" name="telefoon_nr"
                                           value="<?= $user['telefoon_nr'] ?>" placeholder="Telefoonnummer">
                                </div>
                            </div>
                            <div class="input-group col-md-12"><br></div>
                            <div class="input-group col-md-6">
                                <label class="sr-only" for="bedrijfsnaam">Bedrijfsnaam</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-industry"></i></div>
                                    </div>
                                    <input type="text" class="form-control" id="bedrijfsnaam" name="bedrijfsnaam"
                                           value="<?= $user['bedrijfsnaam'] ?>" placeholder="Bedrijfsnaam">
                                </div>
                            </div>
                            <div class="input-group col-md-6">
                                <label class="sr-only" for="btw_nr">BTW-nummer</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-industry"></i></i></div>
                                    </div>
                                    <input type="text" class="form-control" id="btw_nr" name="btw_nr"
                                           value="<?= $user['btw_nr'] ?>" placeholder="BTW-nummer">
                                </div>
                            </div>
                            <div class="input-group col-md-12"><br></div>

                            <legend class="legend col-md-12"><span>Adres Gegevens</span></legend>
                            <h5 class="legend col-md-12"><span>Facturatieadres</span></h5>
                            <div class="input-group col-md-9">
                                <label class="sr-only" for="adres_straat">Adres</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-house-user"></i></div>
                                    </div>
                                    <input type="text" class="form-control" id="adres_straat" name="adres_straat"
                                           value="<?= $user['adres_straat'] ?>" placeholder="Adres" required>
                                </div>
                            </div>
                            <div class="input-group col-md-3">
                                <label class="sr-only" for="adres_nr">Huisnummer / Bus</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-house-user"></i></div>
                                    </div>
                                    <input type="text" class="form-control" id="adres_nr" name="adres_nr"
                                           value="<?= $user['adres_nr'] ?>" placeholder="Huisnummer / Bus"
                                           required>
                                    <div class="invalid-feedback">Dit veld is verplicht.</div>
                                </div>
                            </div>
                            <div class="input-group col-md-6">
                                <label class="sr-only" for="adres_postcode">Postcode</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-house-user"></i></div>
                                    </div>
                                    <input type="text" class="form-control" id="adres_postcode"
                                           name="adres_postcode"
                                           value="<?= $user['adres_postcode'] ?>" placeholder="Postcode"
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
                                           value="<?= $user['adres_plaats'] ?>" placeholder="Plaats" required>
                                </div>
                            </div>
                            <div class="input-group col-md-12"><br></div>
                            <h5 class="legend col-md-12"><span>Leveringsadres</span></h5>
                            <div class="input-group col-md-9">
                                <label class="sr-only" for="adres_straat_2">Adres</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-house-user"></i></div>
                                    </div>
                                    <input type="text" class="form-control" id="adres_straat_2" name="adres_straat_2"
                                           value="<?= $user['adres_straat_2'] ?>" placeholder="Adres" required>
                                </div>
                            </div>
                            <div class="input-group col-md-3">
                                <label class="sr-only" for="adres_nr_2">Huisnummer / Bus</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-house-user"></i></div>
                                    </div>
                                    <input type="text" class="form-control" id="adres_nr_2" name="adres_nr_2"
                                           value="<?= $user['adres_nr_2'] ?>" placeholder="Huisnummer / Bus"
                                           required>
                                    <div class="invalid-feedback">Dit veld is verplicht.</div>
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
                                           value="<?= $user['adres_postcode_2'] ?>" placeholder="Postcode"
                                           required>
                                </div>
                            </div>
                            <div class="input-group col-md-6">
                                <label class="sr-only" for="adres_plaats_2">Plaats</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-house-user"></i></div>
                                    </div>
                                    <input type="text" class="form-control" id="adres_plaats_2" name="adres_plaats_2"
                                           value="<?= $user['adres_plaats_2'] ?>" placeholder="Plaats" required>
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
                                           value="<?= $user['email'] ?>" placeholder="E-mailadres" required>
                                    <div class="invalid-feedback">Dit veld is verplicht.</div>
                                </div>
                            </div>
                            <div class="input-group col-md-12">
                                <label class="sr-only" for="wachtwoord">Wachtwoord</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-lock"></i></div>
                                    </div>
                                    <input type="password" class="form-control" id="wachtwoord" name="wachtwoord"
                                           value="<?= $user['wachtwoord'] ?>" placeholder="Wachtwoord" required>
                                    <div class="invalid-feedback">Dit veld is verplicht.</div>
                                </div>
                            </div>
                            <div class="input-group col-md-6">
                                <label class="sr-only" for="activatie_code">Activatie</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-lock"></i></div>
                                    </div>
                                    <input type="text" class="form-control" id="activatie_code" name="activatie_code"
                                           value="<?= $user['activatie_code'] ?>" placeholder="Activatie" required>
                                </div>
                            </div>
                            <div class="input-group col-md-6">
                                <div class="input-group mb-2">
                                    <label class="sr-only" for="user_level">User_level</label>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-lock"></i></div>
                                    </div>
                                    <select class="custom-select" id="user_level" name="user_level">
                                        <?php foreach ($user_levels as $level): ?>
                                            <option value="<?= $level ?>"<?= $level == $user['user_level'] ? ' selected' : '' ?>><?= $level ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="input-group col-md-12"><br></div>
                            <div class="col-12">
                                <a class="btn btn-secondary" href="users.php" role="button"><i class="fas fa-times"></i> Annuleer</a>
                                <button type="submit" name="submit" class="btn btn-success"><i class="fas fa-check"></i> Opslaan</button>
                                <!--<button type="submit" name="delete" class="btn btn-danger">Verwijder</button>-->
                            </div>

                            <div class="input-group col-md-12"><br></div>
                        </div>
                    </form>
                </div>

            </div>
        </main>

        <?php include('includes/footer.php'); ?>

    </body>
</html>
