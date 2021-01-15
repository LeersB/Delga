<?php
include 'main.php';
$pdo_function = pdo_connect_mysql();
// Default input product values
$producten = array(
    'categorie_id' => '',
    'product_naam' => '',
    'product_foto' => '',
    'product_info' => '',
    'omschrijving' => '',
    'verpakking' => '',
    'waarschuwing' => '',
    'eenheidsprijs' => '',
    'btw' => ''
);

if (isset($_GET['product_id'])) {
    // Get the account from the database
    $stmt = $pdo_function->prepare('SELECT * FROM producten WHERE product_id = ?');
    $stmt->execute([$_GET['user_id']]);
    $producten = $stmt->fetch(PDO::FETCH_ASSOC);
    // ID param exists, edit an existing account
    $page = 'Edit';
    if (isset($_POST['submit'])) {
        // Update the account
        $stmt = $pdo_function->prepare('UPDATE producten SET categorie_id = ?, product_naam = ?, product_foto = ?, product_info = ?, omschrijving = ?, verpakking = ?, waarschuwing = ?, eenheidsprijs = ?, btw = ? WHERE product_id = ?');
        $stmt->execute([$_POST['categorie_id'], $_POST['product_naam'], $_POST['product_foto'], $_POST['product_info'], $_POST['omschrijving'], $_POST['verpakking'], $_POST['waarschuwing'], $_POST['eenheidsprijs'], $_POST['btw'], $_GET['product_id']]);
        header('Location: producten.php');
        exit;
    }
    if (isset($_POST['delete'])) {
        // Delete the account
        $stmt = $pdo_function->prepare('DELETE FROM producten WHERE product_id = ?');
        $stmt->execute([$_GET['product_id']]);
        header('Location: producten.php');
        exit;
    }
} else {
    // Create a new account
    $page = 'Create';
    if (isset($_POST['submit'])) {
        $stmt = $pdo_function->prepare('INSERT IGNORE INTO producten (categorie_id, product_naam, product_foto, product_info, omschrijving, verpakking, waarschuwing, eenheidsprijs, btw) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$_POST['categorie_id'], $_POST['product_naam'], $_POST['product_foto'], $_POST['product_info'], $_POST['omschrijving'], $_POST['verpakking'], $_POST['waarschuwing'], $_POST['eenheidsprijs'], $_POST['btw']]);
        header('Location: producten.php');
        exit;
    }
}
?>

<?= template_admin_header($page . ' Producten') ?>

<h2><?= $page ?> Gebruiker</h2>

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
                           value="<?= $user['achternaam'] ?>" placeholder="Achternaam" required>
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
                       value="<?= $user['adres_plaats'] ?>"
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

            <select id="role" name="role" style="margin-bottom: 30px;">
                <?php foreach ($user_levels as $level): ?>
                    <option value="<?= $level ?>"<?= $level == $user['user_level'] ? ' selected' : '' ?>><?= $level ?></option>
                <?php endforeach; ?>
            </select>

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
