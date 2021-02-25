<?php
$menu = 3;
include 'main.php';
$pdo_function = pdo_connect_mysql();
check_loggedin($pdo_function);
// Check if user is logged in
if (isset($_SESSION['loggedin'])) {
    $stmt = $pdo_function->prepare('SELECT * FROM users WHERE user_id = ?');
    $stmt->execute([$_SESSION['user_id']]);
    $account = $stmt->fetch(PDO::FETCH_ASSOC);
}
// controle sessie variabelen voor producten in winkelmand delgashop
$producten_winkelmand = isset($_SESSION['delgashop']) ? $_SESSION['delgashop'] : [];
$subtotaal = 0.00;
$levering = leveringskost;
// If functie voor producten in winkelmand
if ($producten_winkelmand) {
    $lijst_delgashop = implode(',', array_fill(0, count($producten_winkelmand), '?'));
    $stmt = $pdo_function->prepare('SELECT * FROM producten WHERE product_id IN (' . $lijst_delgashop . ')');
    $stmt->execute(array_column($producten_winkelmand, 'product_id'));
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Overloop de producten in winkelmand en voeg meta data toe (product_naam, eenheidsprijs, ...)
    foreach ($producten_winkelmand as &$delgashop_product) {
        foreach ($products as $product) {
            if ($delgashop_product['product_id'] == $product['product_id']) {
                $delgashop_product['meta'] = $product;
                // Bereken subtotaal
                $product_prijs = $delgashop_product['optie_eenheidsprijs'] > 0 ? (float)$delgashop_product['optie_eenheidsprijs'] : (float)$product['eenheidsprijs'];
                $subtotaal += $product_prijs * (int)$delgashop_product['aantal'];

            }
        }
    }
}

if (isset($_POST['order_naam'], $_POST['order_adres'], $_POST['order_adres_2'], $_SESSION['delgashop'])) {
    if (isset($_SESSION['loggedin'])) {
        $user_id = $_SESSION['user_id'];
    }
    if (isset($_POST['bestellen']) && $producten_winkelmand) {
        // Uniek ID genereren
        $order_nr = strtoupper(uniqid('2021-') . substr(md5(mt_rand()), 0, 1));
        $stmt = $pdo_function->prepare('INSERT INTO orders (order_nr, totaal_prijs, order_status, order_datum, order_email, order_naam, order_adres, order_adres_2, user_id, opmerking) VALUES (?,?,?,?,?,?,?,?,?,?)');
        $stmt->execute([
            $order_nr,
            $subtotaal + $levering,
            'nieuw',
            date('Y-m-d H:i:s'),
            isset($account['email']) && !empty($account['email']) ? $account['email'] : $_POST['email'],
            $_POST['order_naam'],
            $_POST['order_adres'],
            $_POST['order_adres_2'],
            $user_id,
            $_POST['opmerking']
        ]);
        foreach ($producten_winkelmand as $product) {
            $stmt = $pdo_function->prepare('INSERT INTO order_details (order_nr, product_id, product_prijs, product_aantal, product_optie) VALUES (?,?,?,?,?)');
            $stmt->execute([$order_nr, $product['product_id'], $product['optie_eenheidsprijs'] > 0 ? $product['optie_eenheidsprijs'] : $product['meta']['eenheidsprijs'], $product['aantal'], $product['opties']]);
        }
        send_order_detail_email(
            isset($account['email']) && !empty($account['email']) ? $account['email'] : $_POST['email'],
            $producten_winkelmand,
            $_POST['order_naam'],
            $_POST['order_adres'],
            $_POST['order_adres_2'],
            $subtotaal + $levering,
            $order_nr
        );
        header('Location: besteld.php');
        exit;
    }
}

if (empty($_SESSION['delgashop'])) {
    header('Location: producten.php');
    exit;
}
?>
<!DOCTYPE html>
<html class="h-100" lang="nl">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
    <meta content="Delga contactgegevens" name="description">
    <meta content="Bart Leers" name="author">
    <title>Delga product info</title>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/delga.css" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100">

<header>
    <?php include('includes/header.php'); ?>
</header>

<main class="flex-shrink-0" role="main">
    <div class="container">

        <div class="checkout content-wrapper">

            <form class="needs-validation" novalidate action="" method="post">
                <h2>Details bestelling</h2>

                <div class="row">
                    <p class="legend col-md-12"><span>Beste <?= $account['voornaam']," ",$account['achternaam']?>, gelieve de volgende gegevens na te kijken voor u uw bestelling plaatst.</span></p>
                    <div class="input-group col-md-4 sr-only">
                        <label class="sr-only" for="order_naam">Naam</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-user"></i></div>
                            </div>
                            <input type="text" class="form-control" value="<?= $account['voornaam']," ",$account['achternaam']?>"
                                   id="order_naam" name="order_naam" placeholder="Naam" required>
                        </div>
                    </div>
                    <div class="input-group col-md-4 sr-only">
                        <label class="sr-only" for="email">E-mailadres</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-envelope"></i></div>
                            </div>
                            <input type="email" class="form-control" value="<?= $account['email'] ?>" id="email"
                                   name="email" placeholder="E-mailadres" required>
                        </div>
                    </div>
                    <div class="input-group col-md-4 sr-only">
                        <label class="sr-only" for="telefoon_nr">Telefoonnummer</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-phone-alt"></i></div>
                            </div>
                            <input type="text" class="form-control" value="<?= $account['telefoon_nr'] ?>"
                                   id="telefoon_nr" name="telefoon_nr" placeholder="Telefoonnummer">
                        </div>
                    </div>

                    <?php if ($account['user_level'] == 'Bedrijf'): ?>
                        <div class="input-group col-md-6">
                            <label class="sr-only" for="bedrijfsnaam">Bedrijfsnaam</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-industry"></i></div>
                                </div>
                                <input type="text" class="form-control" value="<?= $account['bedrijfsnaam'] ?>"
                                       id="bedrijfsnaam"
                                       name="bedrijfsnaam"
                                       placeholder="Bedrijfsnaam">
                            </div>
                        </div>
                        <div class="input-group col-md-6">
                            <label class="sr-only" for="btw_nr">BTW-nummer</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-industry"></i></div>
                                </div>
                                <input type="text" class="form-control" value="<?= $account['btw_nr'] ?>"
                                       id="btw_nr" name="btw_nr"
                                       placeholder="BTW-nummer">
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="input-group col-md-12">
                        <label class="sr-only" for="order_adres">Facturatieadres</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-house-user"></i>&nbsp;Facturatieadres
                                </div>
                            </div>
                            <input type="text" class="form-control"
                                   value="<?= $account['adres_straat'], ' ', $account['adres_nr'], ' - ', $account['adres_postcode'], ' ', $account['adres_plaats'] ?>"
                                   id="order_adres" name="order_adres" placeholder="Facturatieadres" required>
                        </div>
                    </div>
                    <div class="input-group col-md-12">
                        <label class="sr-only" for="order_adres_2">Leveringsadres</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-house-user"></i>&nbsp;Leveringsadres
                                </div>
                            </div>
                            <input type="text" class="form-control"
                                   value="<?= $account['adres_straat_2'], ' ', $account['adres_nr_2'], ' - ', $account['adres_postcode_2'], ' ', $account['adres_plaats_2'] ?>"
                                   id="order_adres_2" name="order_adres_2" placeholder="Leveringsadres" required>
                        </div>
                    </div>
                    <div class="input-group col-md-12">
                        <label class="sr-only" for="opmerking">Opmerking</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-pencil-alt"></i></div>
                            </div>
                            <textarea class="form-control" id="opmerking" name="opmerking"
                                      rows="3" maxlength="300"
                                      placeholder="Uw opmerking of suggestie kunt u hier plaatsen"></textarea>
                        </div>
                    </div>
                </div>

                <div class="cart content-wrapper">

                    <div class="table-responsive-md">
                        <table class="table table-hover table-borderless">
                            <thead class="table-secondary">
                            <tr>
                                <th scope="col"></th>
                                <th scope="col" colspan="2">Product</th>
                                <th scope="col" class="rhide">Prijs</th>
                                <th scope="col">Aantal</th>
                                <th scope="col">Totaal</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($producten_winkelmand as $num => $product): ?>
                                <tr>
                                    <td class="img">
                                        <?php if (!empty($product['meta']['product_foto']) && file_exists('images/producten/' . $product['meta']['product_foto'])): ?>
                                            <a href="product.php?id=<?= $product['product_id'] ?>">
                                                <img src="images/producten/<?= $product['meta']['product_foto'] ?>"
                                                     width="50" height="50"
                                                     alt="<?= $product['meta']['product_naam'] ?>">
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="product.php?id=<?= $product['product_id'] ?>"><?= $product['meta']['product_naam'] ?></a>
                                    </td>
                                    <td class="prijs">
                                        <?= $product['opties'] ?>
                                        <input type="hidden" name="opties" value="<?= $product['opties'] ?>">
                                    </td>
                                    <?php if ($product['optie_eenheidsprijs'] > 0): ?>
                                        <td class="prijs rhide">
                                            € <?= number_format($product['optie_eenheidsprijs'], 2) ?></td>
                                    <?php else: ?>
                                        <td class="prijs rhide">
                                            € <?= number_format($product['meta']['eenheidsprijs'], 2) ?></td>
                                    <?php endif; ?>
                                    <td class="aantal">
                                        <?= $product['aantal'] ?>
                                        <input type="hidden" name="aantal-<?= $num ?>" aria-label="Aantal"
                                               value="<?= $product['aantal'] ?>">
                                    </td>
                                    <?php if ($product['optie_eenheidsprijs'] > 0): ?>
                                        <td class="prijs product-totaal">
                                            € <?= number_format($product['optie_eenheidsprijs'] * $product['aantal'], 2) ?></td>
                                    <?php else: ?>
                                        <td class="prijs product-totaal">
                                            € <?= number_format($product['meta']['eenheidsprijs'] * $product['aantal'], 2) ?></td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="subtotaal">
                        <span class="text">Subtotaal</span>
                        <span class="prijs">€ <?= number_format($subtotaal, 2) ?></span>
                    </div>
                    <div class="verzending">
                        <span class="text">Levering</span>
                        <span class="prijs">€ <?= number_format($levering, 2) ?></span>
                    </div>
                    <div class="totaal">
                        <span class="text">Totaal</span>
                        <span class="prijs">€ <?= number_format($subtotaal + $levering, 2) ?></span>
                    </div>

                </div>
                <div><br></div>
                <a class="btn btn-secondary" href="winkelmand.php" role="button"><i class="fas fa-times"></i> Annuleer</a>
                <button class="btn btn-success" type="submit" name="bestellen"><i class="fas fa-check"></i> Plaats
                    bestelling
                </button>
            </form>
            <div class="input-group col-md-12"><br></div>
        </div>

    </div>
</main>

<?php include('includes/footer.php'); ?>

</body>
</html>