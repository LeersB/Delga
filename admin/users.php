<?php
include 'main.php';
// Default input product values
$user = array(
    'email' => '',
    'wachtwoord' => '',
    'voornaam' => '',
    'achternaam' => '',
    'adres_straat' => '',
    'adres_nr' => '',
    'adres_postcode' => '',
    'adres_plaats' => '',
    'telefoon_nr' => '',
    'bedrijfsnaam' => '',
    'btw_nr' => '',
    'activatie_code' => '',
    'terugkeer_code' => '',
    'user_level' => 'User'
);
$user_levels = array('User', 'Admin');
if (isset($_GET['user_id'])) {
    // Get the account from the database
    $stmt = $con->prepare('SELECT email, wachtwoord, voornaam, achternaam, bedrijfsnaam, btw_nr, adres_straat, adres_nr, adres_postcode, adres_plaats, telefoon_nr, activatie_code, terugkeer_code, user_level FROM users WHERE user_id = ?');
    $stmt->bind_param('i', $_GET['user_id']);
    $stmt->execute();
    $stmt->bind_result($user['email'], $user['wachtwoord'], $user['voornaam'], $user['achternaam'], $user['bedrijfsnaam'], $user['btw_nr'], $user['adres_straat'], $user['adres_nr'], $user['adres_postcode'], $user['adres_plaats'], $user['telefoon_nr'], $user['activatie_code'], $user['terugkeer_code'], $user['user_level']);
    $stmt->fetch();
    $stmt->close();
    // ID param exists, edit an existing account
    $page = 'Edit';
    if (isset($_POST['submit'])) {
        // Update the account
        $wachtwoord = $user['wachtwoord'] != $_POST['wachtwoord'] ? password_hash($_POST['wachtwoord'], PASSWORD_DEFAULT) : $user['wachtwoord'];
        $stmt = $con->prepare('UPDATE IGNORE users SET email = ?, wachtwoord = ?, voornaam = ?, achternaam = ?, adres_straat = ?, adres_nr = ?, adres_postcode = ?, adres_plaats = ?, telefoon_nr = ?, bedrijfsnaam = ?, btw_nr = ?, activatie_code = ?, terugkeer_code = ?, user_level = ? WHERE user_id = ?');
        $stmt->bind_param('ssssssssssssssi', $_POST['email'], $wachtwoord, $_POST['voornaam'], $_POST['achternaam'], $_POST['adres_straat'], $_POST['adres_nr'], $_POST['adres_postcode'], $_POST['adres_plaats'], $_POST['telefoon_nr'], $_POST['bedrijfsnaam'], $_POST['btw_nr'], $_POST['activatie_code'], $_POST['terugkeer_code'], $_POST['user_level'], $_GET['user_id']);
        $stmt->execute();
        header('Location: index.php');
        exit;
    }
    if (isset($_POST['delete'])) {
        // Delete the account
        $stmt = $con->prepare('DELETE FROM users WHERE user_id = ?');
        $stmt->bind_param('i', $_GET['user_id']);
        $stmt->execute();
        header('Location: index.php');
        exit;
    }
} else {
    // Create a new account
    $page = 'Create';
    if (isset($_POST['submit'])) {
        $wachtwoord = password_hash($_POST['wachtwoord'], PASSWORD_DEFAULT);
        $stmt = $con->prepare('INSERT IGNORE INTO users (email, wachtwoord, user_level, activatie_code, registratie_datum, voornaam, achternaam, adres_straat, adres_nr, adres_postcode, adres_plaats, telefoon_nr, bedrijfsnaam, btw_nr) VALUES (?, ?, ?, ?, NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('sssssssssssss',$_POST['email'],$wachtwoord, $_POST['user_level'], $_POST['activatie_code'], $_POST['voornaam'], $_POST['achternaam'], $_POST['adres_straat'], $_POST['adres_nr'], $_POST['adres_postcode'], $_POST['adres_plaats'], $_POST['telefoon_nr'], $_POST['bedrijfsnaam'], $_POST['btw_nr']);
        $stmt->execute();
        header('Location: index.php');
        exit;
    }
}
?>


<?= template_admin_header($page . ' Account') ?>

<h2><?= $page ?> Account</h2>

<div class="content-block">

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
                           value="<?= $user['achternaam']?>" placeholder="Achternaam" required>
                    <div class="invalid-feedback">Dit veld is verplicht.</div>
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

            <div class="input-group col-md-9">
                <input type="text" class="form-control" id="adres_straat" name="adres_straat"
                       value="<?= $user['adres_straat'] ?>"
                       placeholder="Adres" required>
                <div class="invalid-feedback">Dit veld is verplicht.</div>
            </div>
            <div class="input-group col-md-3">
                <input type="text" class="form-control" id="adres_nr" name="adres_nr"
                       value="<?= $user['adres_nr'] ?>"
                       placeholder="Huisnummer / Bus" required>
                <div class="invalid-feedback">Dit veld is verplicht.</div>
            </div>
            <div class="input-group col-md-12"><br></div>
            <div class="input-group col-md-6">
                <input type="text" class="form-control" id="adres_postcode" name="adres_postcode"
                       value="<?= $user['adres_postcode'] ?>"
                       placeholder="Postcode" required>
                <div class="invalid-feedback">Dit veld is verplicht.</div>
            </div>
            <div class="input-group col-md-6">
                <input type="text" class="form-control" id="adres_plaats" name="adres_plaats"
                       value="<?= $user['adres_plaats']?>"
                       placeholder="Plaats" required>
                <div class="invalid-feedback">Dit veld is verplicht.</div>
            </div>
            <div class="input-group col-md-12"><br></div>
            <div class="input-group col-md-12">
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
            <div class="input-group col-md-12"><br></div>
            <div class="input-group col-md-12">
                <label class="sr-only" for="wachtwoord">Wachtwoord</label>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fas fa-lock"></i></div>
                    </div>
                    <input type="tekst" class="form-control" id="wachtwoord" name="wachtwoord"
                           value="<?= $user['wachtwoord'] ?>" placeholder="Wachtwoord" required>
                    <div class="invalid-feedback">Dit veld is verplicht.</div>
                </div>
            </div>
            <div class="input-group col-md-12"><br></div>
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
                <label class="sr-only" for="user_level">User_level</label>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fas fa-lock"></i></div>
                    </div>
                    <input type="text" class="form-control" id="user_level" name="user_level"
                           value="<?= $user['user_level'] ?>" placeholder="User_level" required>
                </div>
            </div>

            <div class="input-group col-md-12"><br></div>
            <div class="col-12">
                <button type="submit" name="submit" class="btn btn-primary">Opslaan</button>
                <?php if ($page == 'Edit'): ?>
                    <input type="submit" name="delete" value="Delete" class="delete">
                <?php endif; ?>
            </div>
            <div class="input-group col-md-12"><br></div>
        </div>
    </form>
</div>

<?= template_admin_footer() ?>
