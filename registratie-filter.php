<?php
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
    function validate($str): string
    {
        return trim(htmlspecialchars($str));
    }

//Persoonlijke informatie
    if (!empty($filter_voornaam)) {
        $_SESSION['voornaam'] = $voornaam = validate($filter_voornaam);
        if (!preg_match('/^[a-zA-Z0-9\s\W]+$/', $voornaam)) {
            $error = 'Ongeldige voornaam';
        }
    }
    if (!empty($filter_achternaam)) {
        $achternaam = validate($filter_achternaam);
        if (!preg_match('/^[a-zA-Z0-9\s\W]+$/', $achternaam)) {
            $error = 'Ongeldige achternaam';
        }
    }
    if (!empty($filter_telefoon_nr)) {
        $telefoon_nr = validate($filter_telefoon_nr);
        if (!preg_match('/^[+][0-9\s]+$/', $telefoon_nr)) {
            $error = 'Ongeldige telefoonnummer, voorbeeld: +32495361149';
        }
    } else {
        $telefoon_nr = "";
    }
    if (!empty($filter_bedrijfsnaam)) {
        $bedrijfsnaam = validate($filter_bedrijfsnaam);
        if (!preg_match('/^[a-zA-Z0-9\s\W]+$/', $bedrijfsnaam)) {
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
    if (!empty($filter_wachtwoord)) {
        $wachtwoord = $filter_wachtwoord;
        if (strlen($wachtwoord) > 16 || strlen($wachtwoord) < 8) {
            $error = 'Wachtwoord moet tussen 8 en 16 karakters lang zijn!';
        }
    }
    if (!empty($filter_cwachtwoord)) {
        $cwachtwoord = $filter_cwachtwoord;
        if (strlen($cwachtwoord) > 16 || strlen($cwachtwoord) < 8) {
            $error = 'Wachtwoord moet tussen 8 en 16 karakters lang zijn!';
        }
    }
    if ($filter_cwachtwoord != $filter_wachtwoord) {
        $error = 'Wachtwoorden komen niet overeen!';
    }
}