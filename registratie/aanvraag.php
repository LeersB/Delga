<?php
$menu = 4;
include '../main.php';
?>
<!DOCTYPE html>
<html class="h-100" lang="nl">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
    <meta name=”robots” content=”noindex,nofollow”>
    <meta content="Delga contactgegevens" name="description">
    <meta content="Bart Leers" name="author">
    <title>Delga account aanmaken</title>
    <link href="../css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="../css/delga.css" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100">

<header>
    <?php include('../includes/header.php'); ?>
</header>

<main class="flex-shrink-0">
    <div class="container">

        <div class="register">
            <h2>Maak uw Delga account aan</h2>
            <form class="needs-validation" novalidate action="controle.php" method="post" autocomplete="off">
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
                            <input type="text" class="form-control" id="voornaam" name="voornaam" placeholder="Voornaam" maxlength="50"
                                   required>
                        </div>
                    </div>
                    <div class="input-group col-md-6">
                        <label class="sr-only" for="achternaam">Achternaam</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-user"></i></div>
                            </div>
                            <input type="text" class="form-control" id="achternaam" name="achternaam"
                                   placeholder="Achternaam" maxlength="50" required>
                        </div>
                    </div>

                    <div class="input-group col-md-6">
                        <label class="sr-only" for="telefoon_nr">Telefoonnummer</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-phone-alt"></i></div>
                            </div>
                            <input type="text" class="form-control" id="telefoon_nr" name="telefoon_nr"
                                   placeholder="Telefoonnummer">
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
                                           placeholder="Bedrijfsnaam" maxlength="50">
                                </div>
                            </div>
                            <div class="input-group col-md-6">
                                <label class="sr-only" for="btw_nr">BTW-nummer</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-industry"></i></div>
                                    </div>
                                    <input type="text" class="form-control" id="btw_nr" name="btw_nr"
                                           placeholder="BTW-nummer">
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
                                   placeholder="Facturatieadres" maxlength="80" required>
                        </div>
                    </div>
                    <div class="input-group col-md-3">
                        <label class="sr-only" for="adres_nr">Nr. / Bus</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-house-user"></i></div>
                            </div>
                            <input type="text" class="form-control" id="adres_nr" name="adres_nr"
                                   placeholder="Nr. / Bus" maxlength="20" required>
                        </div>
                    </div>

                    <div class="input-group col-md-6">
                        <label class="sr-only" for="adres_postcode">Postcode</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-house-user"></i></div>
                            </div>
                            <input type="text" class="form-control" id="adres_postcode" name="adres_postcode"
                                   placeholder="Postcode" maxlength="4" required>
                        </div>
                    </div>
                    <div class="input-group col-md-6">
                        <label class="sr-only" for="adres_plaats">Plaats</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-house-user"></i></div>
                            </div>
                            <input type="text" class="form-control" id="adres_plaats" name="adres_plaats"
                                   placeholder="Plaats" maxlength="50" required>
                        </div>
                    </div>
                    <div class="input-group col-md-12"><br></div>
                    <div class="col-md-12 h5">Leveringsadres</div>
                    <div class="input-group col-md-9">
                        <label class="sr-only" for="adres_straat_2">Leveringsadres</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-house-user"></i></div>
                            </div>
                            <input type="text" class="form-control" id="adres_straat_2" name="adres_straat_2"
                                   placeholder="Leveringsadres" maxlength="80" required>
                        </div>
                    </div>
                    <div class="input-group col-md-3">
                        <label class="sr-only" for="adres_nr_2">Nr. / Bus</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-house-user"></i></div>
                            </div>
                            <input type="text" class="form-control" id="adres_nr_2" name="adres_nr_2"
                                   placeholder="Nr. / Bus" maxlength="20" required>
                        </div>
                    </div>

                    <div class="input-group col-md-6">
                        <label class="sr-only" for="adres_postcode_2">Postcode</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-house-user"></i></div>
                            </div>
                            <input type="text" class="form-control" id="adres_postcode_2" name="adres_postcode_2"
                                   placeholder="Postcode" maxlength="4" required>
                        </div>
                    </div>
                    <div class="input-group col-md-6">
                        <label class="sr-only" for="adres_plaats_2">Plaats</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-house-user"></i></div>
                            </div>
                            <input type="text" class="form-control" id="adres_plaats_2" name="adres_plaats_2"
                                   placeholder="Plaats" maxlength="50" required>
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
                            <input type="email" class="form-control" id="email" name="email" placeholder="E-mailadres" maxlength="100"
                                   required>
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
                    <div class="input-group col-md-12"><br></div>

                    <div class="col-md-12"><p class="msg"></p></div>
                    <div class="input-group col-md-12"><br></div>
                    <div class="col-12">
                        <a class="btn btn-secondary" href="../login.php" role="button"><i class="fas fa-times"></i> Annuleer</a>
                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Registreer</button>
                    </div>
                    <div class="input-group col-md-12"><br></div>
                </div>
            </form>
        </div>

    </div>
</main>

<?php include('../includes/footer.php'); ?>
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
    $("#user_level").trigger("change");
</script>
<script src="../js/form-validation.js"></script>
</body>
</html>