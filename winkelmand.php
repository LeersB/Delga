<?php
$menu = 3;
include 'main.php';
$pdo_function = pdo_connect_mysql();
if (isset($_POST['product_id'], $_POST['aantal']) && is_numeric($_POST['product_id']) && is_numeric($_POST['aantal'])) {
    $product_id = (int) $_POST['product_id'];
    $aantal = abs((int) $_POST['aantal']);
    // Ophalen product opties
    $opties = '';
    $optie_eenheidsprijs = 0.00;
    foreach ($_POST as $k => $v) {
        if (strpos($k, 'optie-') !== false) {
            $opties .= str_replace('optie-', '', $k) . ' - ' . $v . ',';
            $stmtOpties = $pdo_function->prepare('SELECT * FROM product_opties WHERE optie_titel = ? AND optie_naam = ? AND product_id = ?');
            $stmtOpties->execute([str_replace('optie-', '', $k), $v, $product_id]);
            $optie = $stmtOpties->fetch(PDO::FETCH_ASSOC);
            $optie_eenheidsprijs += $optie['eenheidsprijs'];
        }
    }
    $opties2 = rtrim($opties, ',');
    $stmtProduct = $pdo_function->prepare('SELECT * FROM producten WHERE product_id = ?');
    $stmtProduct->execute([$_POST['product_id']]);
    $product = $stmtProduct->fetch(PDO::FETCH_ASSOC);
    if ($product && $aantal > 0) {
        // Product bestaat
        if (!isset($_SESSION['delgashop'])) {
            $_SESSION['delgashop'] = [];
        }
        $delgashop_product = &get_delgashop_product($product_id, $opties2);
        if ($delgashop_product) {
            // Product bestaat in winkelmand, update aantal
            $delgashop_product['aantal'] += $aantal;
        } else {
            // Product is niet in winkelmand, voeg toe
            $_SESSION['delgashop'][] = [
                'product_id' => $product_id,
                'aantal' => $aantal,
                'opties' => $opties2,
                'optie_eenheidsprijs' => $optie_eenheidsprijs,
            ];
        }
    }
    header('location: winkelmand.php');
    exit;
}
// Verwijder product uit winkelmand
if (isset($_GET['verwijder']) && is_numeric($_GET['verwijder']) && isset($_SESSION['delgashop']) && isset($_SESSION['delgashop'][$_GET['verwijder']])) {
    unset($_SESSION['delgashop'][$_GET['verwijder']]);
    header('location: winkelmand.php');
    exit;
}
// Leegmaken winkelmand
if (isset($_POST['leegmaken']) && isset($_SESSION['delgashop'])) {
    unset($_SESSION['delgashop']);
    header('location: winkelmand.php');
    exit;
}
// Updaten product aantal in winkelmand
if ((isset($_POST['updaten']) || isset($_POST['bestellen'])) && isset($_SESSION['delgashop'])) {
    // Overloop de producten voor het updaten van de aantallen in winkelmand
    foreach ($_POST as $k => $v) {
        if (strpos($k, 'aantal') !== false && is_numeric($v)) {
            $product_id = str_replace('aantal-', '', $k);
            $aantal = abs((int) $v);
            if (is_numeric($product_id) && isset($_SESSION['delgashop'][$product_id]) && $aantal > 0) {
                // Updaten nieuw aantal
                $_SESSION['delgashop'][$product_id]['aantal'] = $aantal;
            }
        }
    }
    // Bestellen van de producten door gebruiker te sturen naar besteld.php, winkelmand mag niet leeg zijn
    if (isset($_POST['bestellen']) && !empty($_SESSION['delgashop'])) {
        header('Location: bestellen.php');
        exit;
    }
    header('location: winkelmand.php');
    exit;
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
                $product_prijs = $delgashop_product['optie_eenheidsprijs'] > 0 ? (float) $delgashop_product['optie_eenheidsprijs'] : (float) $product['eenheidsprijs'];
                $subtotaal += $product_prijs * (int) $delgashop_product['aantal'];
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
        <title>Delga product info</title>
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="css/delga.css" rel="stylesheet">
        <style>
            dt {
                float: left;
                clear: left;
                width: 110px;
            }
            dd {
                margin: 0 0 0 80px;
                padding: 0 0 0.5em 0;
            }
        </style>
    </head>

    <body class="d-flex flex-column h-100">

        <header>
            <?php include('includes/header.php'); ?>
        </header>

        <main class="flex-shrink-0">
            <div class="container">

                <h2>Winkelmand</h2>

                <?php if (empty($producten_winkelmand)): $levering = 0 ?>
                    <p>Er zijn geen producten toegevoegd aan uw winkelmand!</p>
                <?php else: ?>
                    <form action="" method="post">
                        <div class="table-responsive-md">
                            <table class="table table-hover table-borderless">
                                <thead class="table-secondary">
                                    <tr>
                                        <th scope="col" colspan="2"></th>
                                        <th scope="col" colspan="2">Product</th>
                                        <th scope="col">Prijs</th>
                                        <th scope="col">Aantal</th>
                                        <th scope="col">Totaal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($producten_winkelmand as $num => $product): ?>
                                        <tr>
                                            <td class="text-secondary"><a href="winkelmand.php?verwijder=<?= $num ?>"
                                                                          class="verwijder"><i
                                                        class="fas fa-trash-alt"></i></a></td>
                                            <td>
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
                                            <td>
                                                <?= $product['opties'] ?>
                                                <input type="hidden" name="opties" value="<?= $product['opties'] ?>">
                                            </td>
                                            <?php if ($product['optie_eenheidsprijs'] > 0): ?>
                                                <td>
                                                    € <?= number_format($product['optie_eenheidsprijs'], 2) ?></td>
                                            <?php else: ?>
                                                <td>
                                                    € <?= number_format($product['meta']['eenheidsprijs'], 2) ?></td>
                                            <?php endif; ?>
                                            <td>
                                                <input type="number" class="form-control ajax-update" aria-label="Aantal"
                                                       name="aantal-<?= $num ?>"
                                                       value="<?= $product['aantal'] ?>" min="1" placeholder="Aantal" required>
                                            </td>
                                            <?php if ($product['optie_eenheidsprijs'] > 0): ?>
                                                <td>
                                                    € <?= number_format($product['optie_eenheidsprijs'] * $product['aantal'], 2) ?></td>
                                            <?php else: ?>
                                                <td>
                                                    € <?= number_format($product['meta']['eenheidsprijs'] * $product['aantal'], 2) ?></td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <dl>
                            <dt>Subtotaal: </dt>
                            <dd>€ <?= number_format($subtotaal, 2) ?></dd>
                            <dt>Levering: </dt>
                            <dd>€ <?= number_format($levering, 2) ?></dd>
                            <dt>Totaal: </dt>
                            <dd>€ <?= number_format($subtotaal + $levering, 2) ?></dd>
                        </dl>

                        <div class="buttons">
                            <button class="btn btn-secondary" type="submit" name="leegmaken"><i
                                    class="fas fa-trash-alt"></i> Leegmaken
                            </button>
                            <button class="btn btn-secondary" type="submit" name="updaten"><i class="fas fa-redo-alt"></i>
                                updaten
                            </button>
                            <button class="btn btn-success" type="submit" name="bestellen"><i class="fas fa-check"></i>
                                Bestellen
                            </button>
                        </div>
                        <div class="input-group col-md-12"><br></div>

                    </form>
                <?php endif; ?>

            </div>
        </main>

        <?php include('includes/footer.php'); ?>

    </body>
</html>