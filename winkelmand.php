<?php
$menu = 5;
include 'main.php';
$pdo_function = pdo_connect_mysql();
if (isset($_POST['product_id'], $_POST['aantal']) && is_numeric($_POST['product_id']) && is_numeric($_POST['aantal'])) {
    $product_id = (int)$_POST['product_id'];
    $aantal = abs((int)$_POST['aantal']);
    // Ophalen product opties
    $opties = '';
    $optie_eenheidsprijs = 0.00;
    foreach ($_POST as $k => $v) {
        if (strpos($k, 'optie-') !== false) {
            $opties .= str_replace('optie-', '', $k) . '-' . $v . ',';
            $stmt = $pdo_function->prepare('SELECT * FROM product_opties WHERE optie_titel = ? AND optie_naam = ? AND product_id = ?');
            $stmt->execute([str_replace('optie-', '', $k), $v, $product_id]);
            $optie = $stmt->fetch(PDO::FETCH_ASSOC);
            $optie_eenheidsprijs += $optie['eenheidsprijs'];
        }
    }
    $opties = rtrim($opties, ',');
    $stmt = $pdo_function->prepare('SELECT * FROM producten WHERE product_id = ?');
    $stmt->execute([$_POST['product_id']]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($product && $aantal > 0) {
        // Product bestaat
        if (!isset($_SESSION['delgashop'])) {
            $_SESSION['delgashop'] = [];
        }
        $delgashop_product = &get_delgashop_product($product_id, $opties);
        if ($delgashop_product) {
            // Product bestaat in winkelmand, update aantal
            $delgashop_product['aantal'] += $aantal;
        } else {
            // Product is niet in winkelmand, voeg toe
            $_SESSION['delgashop'][] = [
                'product_id' => $product_id,
                'aantal' => $aantal,
                'opties' => $opties,
                'optie_eenheidsprijs' => $optie_eenheidsprijs,
            ];
        }
    }
    header('location: winkelmand.php');
    exit;
}
// Remove product from cart
if (isset($_GET['remove']) && is_numeric($_GET['remove']) && isset($_SESSION['delgashop']) && isset($_SESSION['delgashop'][$_GET['remove']])) {
    // Remove the product from the shopping cart
    unset($_SESSION['delgashop'][$_GET['remove']]);
    header('location: winkelmand.php');
    exit;
}
// Empty the cart
if (isset($_POST['emptycart']) && isset($_SESSION['delgashop'])) {
    // Remove all products from the shopping cart
    unset($_SESSION['delgashop']);
    header('location: winkelmand.php');
    exit;
}
// Update product quantities in cart if the user clicks the "Update" button on the shopping cart page
if ((isset($_POST['update']) || isset($_POST['checkout'])) && isset($_SESSION['delgashop'])) {
    // Loop through the post data so we can update the quantities for every product in cart
    foreach ($_POST as $k => $v) {
        if (strpos($k, 'aantal') !== false && is_numeric($v)) {
            $product_id = str_replace('aantal-', '', $k);
            // abs() function will prevent minus quantity and (int) will make sure the number is an integer
            $aantal = abs((int)$v);
            // Always do checks and validation
            if (is_numeric($product_id) && isset($_SESSION['delgashop'][$product_id]) && $aantal > 0) {
                // Update new quantity
                $_SESSION['delgashop'][$product_id]['aantal'] = $aantal;
            }
        }
    }
    // Send the user to the place order page if they click the Place Order button, also the cart should not be empty
    if (isset($_POST['checkout']) && !empty($_SESSION['delgashop'])) {
        header('Location: index.php?page=checkout');
        exit;
    }
    header('location: winkelmand.php');
    exit;
}
// Check the session variable for products in cart
$products_in_cart = isset($_SESSION['delgashop']) ? $_SESSION['delgashop'] : [];
$subtotaal = 0.00;
$levering = leveringskost;
// If there are products in cart
if ($products_in_cart) {
    $array_to_question_marks = implode(',', array_fill(0, count($products_in_cart), '?'));
    $stmt = $pdo_function->prepare('SELECT * FROM producten WHERE producten.product_id IN (' . $array_to_question_marks . ')');
    $stmt->execute(array_column($products_in_cart, 'product_id'));
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Iterate the products in cart and add the meta data (product name, desc, etc)
    foreach ($products_in_cart as &$delgashop_product) {
        foreach ($products as $product) {
            if ($delgashop_product['product_id'] == $product['product_id']) {
                $delgashop_product['meta'] = $product;
                // Calculate the subtotal
                $product_price = $delgashop_product['optie_eenheidsprijs'] > 0 ? (float)$delgashop_product['optie_eenheidsprijs'] : (float)$product['eenheidsprijs'];
                $subtotaal += $product_price * (int)$delgashop_product['aantal'];

            }
        }
    }
}
?>
<!DOCTYPE html>
<html class="h-100" lang="en">
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


        <div class="cart content-wrapper">

            <h2>Winkelmand</h2>

            <form action="" method="post">
                <div class="table-responsive-md">
                <table class="table table-hover">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col" colspan="2"></th>
                        <th scope="col" colspan="2">Product</th>
                        <th scope="col" class="rhide">Prijs</th>
                        <th scope="col">Aantal</th>
                        <th scope="col">Totaal</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (empty($products_in_cart)): $levering = 0 ?>
                        <tr>
                            <td colspan="7" style="text-align:center;">Er zijn geen producten toegevoegd aan uw winkelmand!</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($products_in_cart as $num => $product): ?>
                            <tr>
                                <td class="text-secondary"><a href="winkelmand.php?remove=<?= $num ?>" class="remove"><i class="fas fa-trash-alt"></i></a></td>
                                <td class="img">
                                    <?php if (!empty($product['meta']['product_foto']) && file_exists('images/producten/' . $product['meta']['product_foto'])): ?>
                                        <a href="product.php?product_id=<?= $product['product_id'] ?>">
                                            <img src="images/producten/<?= $product['meta']['product_foto'] ?>"
                                                 width="50" height="50" alt="<?= $product['meta']['product_naam'] ?>">
                                        </a>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="product.php?product_id=<?= $product['product_id'] ?>"><?= $product['meta']['product_naam'] ?></a>
                                </td>
                                <td class="prijs">
                                    <?= $product['opties'] ?>
                                    <input type="hidden" name="opties" value="<?= $product['opties'] ?>">
                                </td>
                                <?php if ($product['optie_eenheidsprijs'] > 0): ?>
                                    <td class="price rhide">
                                        € <?= number_format($product['optie_eenheidsprijs'], 2) ?></td>
                                <?php else: ?>
                                    <td class="price rhide">
                                        € <?= number_format($product['meta']['eenheidsprijs'], 2) ?></td>
                                <?php endif; ?>
                                <td class="aantal">
                                    <input type="number" class="form-control ajax-update" aria-label="Aantal" name="aantal-<?= $num ?>"
                                           value="<?= $product['aantal'] ?>" min="1" placeholder="Aantal" required>
                                </td>
                                <?php if ($product['optie_eenheidsprijs'] > 0): ?>
                                    <td class="price product-totaal">
                                        € <?= number_format($product['optie_eenheidsprijs'] * $product['aantal'], 2) ?></td>
                                <?php else: ?>
                                    <td class="price product-totaal">
                                        € <?= number_format($product['meta']['eenheidsprijs'] * $product['aantal'], 2) ?></td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
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
                <div class="buttons">
                    <input type="submit" value="Leegmaken" name="emptycart">
                    <input type="submit" value="Updaten" name="update">
                    <input type="submit" value="Bestellen" name="checkout">
                </div>

            </form>
        </div>


    </div>
</main>

<?php include('includes/footer.php'); ?>

</body>
</html>