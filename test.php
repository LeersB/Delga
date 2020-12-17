<?php
$menu = 3;
?>

<!DOCTYPE html>
<html class="h-100" lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
    <meta content="Delga contactgegevens" name="description">
    <meta content="Bart Leers" name="author">
    <title>Delga</title>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/delga.css" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100">

<header>
    <?php include('includes/header.php'); ?>
</header>

<main class="flex-shrink-0" role="main">
    <div class="container">


        <div class="register">
            <h2>Maak je Delga account aan</h2>

            <form action="proces_registreer.php" method="post" autocomplete="off">
                <div class="row">

                    <legend class="legend col-md-12"><span>Persoonlijke informatie</span></legend>
                    <div class="input-group col-md-6">
                        <span class="input-group-text" id="voornaam"><i class="fas fa-user"></i></span>
                        <input type="text" class="form-control" id="voornaam" name="voornaam" placeholder="Voornaam"
                               required>
                    </div>
                    <div class="input-group col-md-6">
                        <span class="input-group-text" id="familienaam"><i class="fas fa-user"></i></span>
                        <input type="text" class="form-control" id="familienaam" name="familienaam"
                               placeholder="Familienaam" required>
                    </div>
                    <div class="input-group col-md-12"><br></div>
                    <div class="input-group col-md-12">
                        <span class="input-group-text" id="voornaam"><i class="fas fa-envelope"></i></span>
                        <input type="email" class="form-control" id="email" name="email"
                               placeholder="E-mailadres" required>
                    </div>
                    <div class="input-group col-md-12"><br></div>
                    <legend class="legend col-md-12"><span>Adres Gegevens</span></legend>


                    <div class="msg"></div>
                    <div class="input-group col-md-12"><br></div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Registreer</button>
                    </div>
                </div>
            </form>

            <div class="input-group col-md-12">
                <label class="form-label"></label>
            </div>


            <div class="col-12">
                <label for="inputAddress" class="form-label">Address</label>
                <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
            </div>


            <label for="wachtwoord">
                <i class="fas fa-lock"></i>
            </label>
            <input type="password" name="wachtwoord" placeholder="Wachtwoord" id="wachtwoord" required>

            <label for="cpassword">
                <i class="fas fa-lock"></i>
            </label>
            <input type="password" name="cwachtwoord" placeholder="Confirm Wachtwoord" id="cwachtwoord" required>

            <label for="email">
                <i class="fas fa-envelope"></i>
            </label>

            <input type="email" name="email" placeholder="Email" id="email" required>
            <div class="msg"></div>
            <input type="submit" value="Registreer">
            </form>
        </div>


        <form class="row g-3">
            <div class="input-group md-6">
                <span class="input-group-text" id="basic-addon1">@</span>
                <input type="text" class="form-control" placeholder="Username" aria-label="Username"
                       aria-describedby="basic-addon1">
            </div>

            <label for="basic-url" class="form-label">Your vanity URL</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon3"> <i class="fas fa-user"></i></span>
                <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3">
            </div>


            <div class="col-md-6">
                <label for="inputPassword4" class="form-label">Password</label>
                <input type="password" class="form-control" id="inputPassword4">
            </div>
            <div class="col-12">
                <label for="inputAddress" class="form-label">Address</label>
                <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
            </div>
            <div class="col-12">
                <label for="inputAddress2" class="form-label">Address 2</label>
                <input type="text" class="form-control" id="inputAddress2"
                       placeholder="Apartment, studio, or floor">
            </div>
            <div class="col-md-6">
                <label for="inputCity" class="form-label">City</label>
                <input type="text" class="form-control" id="inputCity">
            </div>
            <div class="col-md-4">
                <label for="inputState" class="form-label">State</label>
                <select id="inputState" class="form-select">
                    <option selected>Choose...</option>
                    <option>...</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="inputZip" class="form-label">Zip</label>
                <input type="text" class="form-control" id="inputZip">
            </div>
            <div class="col-12">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="gridCheck">
                    <label class="form-check-label" for="gridCheck">
                        Check me out
                    </label>
                </div>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Sign in</button>
            </div>
        </form>


        <form class="form create account form-create-account" method="post" id="form-validate"
              enctype="multipart/form-data" autocomplete="off">
            <input name="form_key" type="hidden"/>
            <fieldset class="fieldset create info">
                <legend class="legend"><span>Persoonlijke informatie</span></legend>
                <br>


                <div class="row customer-name-fields">
                    <div class="field field-name-firstname required col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="control">
                            <input type="text" id="firstname" name="firstname" placeholder="Voornaam" value=""
                                   title="Voornaam"
                                   class="input-text required-entry validate-length maximum-length-50">
                        </div>
                    </div>
                    <div class="field field-name-lastname required col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="control">
                            <input type="text" id="lastname" name="lastname" placeholder="Achternaam" value=""
                                   title="Achternaam"
                                   class="input-text required-entry validate-length maximum-length-50">
                        </div>
                    </div>
                </div>
                <div class="field&#x20;date&#x20;field-dob">
                    <label class="label" for="dob"><span>Geboortedatum</span></label>
                    <div class="control customer-dob">
                        <input type="text" name="dob" id="dob" value="" class=""
                               data-validate="{&quot;validate-date&quot;:{&quot;dateFormat&quot;:&quot;d\/MM\/y&quot;}}"/>
                        <script type="6aef75b2e1f9c27278ca7973-text/javascript">
            require(["jquery", "mage/calendar"], function($){
                    $("#dob").calendar({
                        showsTime: false,

                        dateFormat: "d/MM/y",
                        buttonImage: "https://d3bxxlhp29apvv.cloudfront.net/static/frontend/Mgs/claue/nl_BE/Magento_Theme/calendar.png",
                        yearRange: "-120y:c+nn",
                        buttonText: "Datum selecteren", maxDate: "-1d", changeMonth: true, changeYear: true, showOn: "both"})
            });




                        </script>
                    </div>
                </div>
                <div class="field gender">
                    <label class="label" for="gender"><span>Geslacht</span></label>
                    <div class="control">
                        <select id="gender" name="gender" title="Geslacht" class="form-control">
                            <option value="" selected="selected"></option>
                            <option value="1">heren</option>
                            <option value="2">dames</option>
                        </select>
                    </div>
                </div>
            </fieldset>
            <fieldset class="fieldset address">
                <legend class="legend"><span>Adres Gegevens</span></legend>
                <br>
                <input type="hidden" name="create_address" value="1"/>
                <div class="field street required">
                    <label for="street_1" class="label"><span>Adres</span></label>
                    <div class="control">
                        <input type="text" name="street[0]" value="" title="Adres" id="street_1"
                               class="input-text required-entry validate-length maximum-length-30"/>
                        <div class="nested">
                            <div class="field additional  required ">
                                <label class="label" for="street_2">
                                    <span>Adresregel 2</span>
                                </label>
                                <div class="control">
                                    <input type="text" name="street[1]" value="" title="Adresregel 2" id="street_2"
                                           class="input-text   required-entry  validate-length  maximum-length-10                                "/>
                                </div>
                            </div>
                            <div class="field additional ">
                                <label class="label" for="street_3">
                                    <span>Adresregel 3</span>
                                </label>
                                <div class="control">
                                    <input type="text" name="street[2]" value="" title="Adresregel 3" id="street_3"
                                           class="input-text   validate-length  maximum-length-5                                "/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="field zip required">
                    <label for="zip" class="label"><span>Postcode</span></label>
                    <div class="control">
                        <input type="text" name="postcode" value="" title="Postcode" id="zip"
                               class="input-text validate-zip-international  validate-length maximum-length-30"
                               data-validate="{'required':true, 'validate-zip-international':true}"/>
                    </div>
                </div>

                <div class="field region required">
                    <label for="region_id" class="label"><span>Provincie</span></label>
                    <div class="control">
                        <select id="region_id" name="region_id" title="Provincie" class="validate-select"
                                style="display:none;">
                            <option value="">Selecteer regio, staat of provincie.</option>
                        </select>
                        <input type="text" id="region" name="region" value="" title="Provincie" class="input-text "
                               style="display:none;"/>
                    </div>
                </div>
                <input type="hidden" name="default_billing" value="1"/>
                <input type="hidden" name="default_shipping" value="1"/>
                <div class="field telephone required">
                    <label for="telephone" class="label"><span>Telefoonnummer</span></label>
                    <div class="control">
                        <input type="text" name="telephone" id="telephone" value="" title="Telefoonnummer"
                               class="input-text validate-length maximum-length-20"/>
                    </div>
                </div>
                <div class="field company">
                    <label for="company" class="label"><span>Bedrijfsnaam</span></label>
                    <div class="control">
                        <input type="text" name="company" id="company" value="" title="Bedrijfsnaam"
                               class="input-text validate-length maximum-length-20"/>
                    </div>
                </div>
            </fieldset>
            <fieldset class="fieldset create account" data-hasrequired="* Verplichte velden">
                <legend class="legend"><span>Inloggegevens</span></legend>
                <br>
                <div class="field required">
                    <label for="email_address" class="label"><span>E-mailadres</span></label>
                    <div class="control">
                        <input type="email" name="email" id="email_address" autocomplete="email" value=""
                               title="E-mailadres" class="input-text validate-length maximum-length-50"
                               data-validate="{required:true} "/>
                    </div>
                </div>
                <div class="field password required">
                    <label for="password" class="label"><span>Wachtwoord </span></label>
                    <div class="control">
                        <input type="password" name="password" id="password" title="Wachtwoord " class="input-text"
                               data-password-min-length="8" data-password-min-character-sets="3"
                               data-validate="{required:true, 'validate-customer-password':true}"
                               autocomplete="off">
                        <div id="password-strength-meter-container" data-role="password-strength-meter"
                             aria-live="polite">
                            <div id="password-strength-meter" class="password-strength-meter">
                                Wachtwoordsterkte:
                                <span id="password-strength-meter-label" data-role="password-strength-meter-label">
Geen wachtwoord </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="field confirmation required">
                    <label for="password-confirmation" class="label"><span>Bevestig wachtwoord</span></label>
                    <div class="control">
                        <input type="password" name="password_confirmation" title="Bevestig wachtwoord"
                               id="password-confirmation" class="input-text"
                               data-validate="{required:true, equalTo:'#password'}"/>
                    </div>
                </div>
            </fieldset>
            <div class="actions-toolbar">
                <div class="primary">
                    <button type="submit" class="action submit primary" title="Een ZEB account aanmaken"><span>Een ZEB account aanmaken</span>
                    </button>
                </div>
                <div class="secondary">
                    <a class="action back"
                       href="https://www.zeb.be/nl/customer/account/login/"><span>Terug</span></a>
                </div>
            </div>
        </form>


    </div>
</main>

<?php include('includes/footer.php'); ?>
</body>
</html>