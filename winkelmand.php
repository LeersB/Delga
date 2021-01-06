<?php
$menu = 5;
include 'main.php';
$pdo_function = pdo_connect_mysql();

if (isset($_POST['product_id'], $_POST['quantity']) && is_numeric($_POST['product_id']) && is_numeric($_POST['quantity'])) {
    $product_id = (int)$_POST['product_id'];
    $quantity = abs((int)$_POST['quantity']);
    // Get product options
    $opties = '';
    $optie_eenheidsprijs = 0.00;
    foreach ($_POST as $k => $v) {
        if (strpos($k, 'optie-') !== false) {
            $opties .= str_replace('optie-', '', $k) . '-' . $v . ',';
            $stmt = $pdo_function->prepare('SELECT * FROM product_opties WHERE optie_titel = ? AND optie_naam = ? AND product_id = ?');
            $stmt->execute([str_replace('optie-', '', $k), $v, $product_id]);
            $opties = $stmt->fetch(PDO::FETCH_ASSOC);
            $optie_eenheidsprijs += $opties['eenheidsprijs'];
        }
    }
    $opties = rtrim($opties, ',');
    $stmt = $pdo_function->prepare('SELECT * FROM producten WHERE product_id = ?');
    $stmt->execute([$_POST['product_id']]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($product > 0) {
        if (!isset($_SESSION['cart'])) {
            // Shopping cart session variable doesnt exist, create it
            $_SESSION['cart'] = [];
        }
        $cart_product = get_cart_product($product_id, $opties);
        if ($cart_product) {
            // Product exists in cart, update the quanity
            $cart_product['quantity'] += $quantity;
        } else {
            // Product is not in cart, add it
            $_SESSION['cart'][] = [
                'product_id' => $product_id,
                'quantity' => $quantity,
                'opties' => $opties,
                'optie_eenheidsprijs' => $optie_eenheidsprijs,
            ];
        }
    }
    // Prevent form resubmission...
    header('location: winkelmand.php');
    exit;
}
// Remove product from cart, check for the URL param "remove", this is the product id, make sure it's a number and check if it's in the cart
if (isset($_GET['remove']) && is_numeric($_GET['remove']) && isset($_SESSION['cart']) && isset($_SESSION['cart'][$_GET['remove']])) {
    // Remove the product from the shopping cart
    unset($_SESSION['cart'][$_GET['remove']]);
    header('location: winkelmand.php');
    exit;
}
// Empty the cart
if (isset($_POST['emptycart']) && isset($_SESSION['cart'])) {
    // Remove all products from the shopping cart
    unset($_SESSION['cart']);
    header('location: winkelmand.php');
    exit;
}
// Update product quantities in cart if the user clicks the "Update" button on the shopping cart page
if (isset($_POST['update']) && isset($_SESSION['cart'])) {
    // Loop through the post data so we can update the quantities for every product in cart
    foreach ($_POST as $k => $v) {
        if (strpos($k, 'quantity') !== false && is_numeric($v)) {
            $id = str_replace('quantity-', '', $k);
            // abs() function will prevent minus quantity and (int) will make sure the number is an integer
            $quantity = abs((int)$v);
            // Always do checks and validation
            if (is_numeric($id) && isset($_SESSION['cart'][$id]) && $quantity > 0) {
                // Update new quantity
                $_SESSION['cart'][$id]['quantity'] = $quantity;
            }
        }
    }
    header('location: winkelmand.php');
    exit;
}
// Send the user to the place order page if they click the Place Order button, also the cart should not be empty
if (isset($_POST['checkout']) && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    header('Location: checkout.php');
    exit;
}
// Check the session variable for products in cart
$products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$subtotaal = 0.00;
$shippingtotaal = 6.00;
// If there are products in cart
if ($products_in_cart) {
    // There are products in the cart so we need to select those products from the database
    // Products in cart array to question mark string array, we need the SQL statement to include: IN (?,?,?,...etc)
    $array_to_question_marks = implode(',', array_fill(0, count($products_in_cart), '?'));
    $stmt = $pdo_function->prepare('SELECT * FROM producten WHERE producten.product_id IN (' . $array_to_question_marks . ')');
    // We use the array_column to retrieve only the id's of the products
    $stmt->execute(array_column($products_in_cart, 'product_id'));
    // Fetch the products from the database and return the result as an Array
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Iterate the products in cart and add the meta data (product name, desc, etc)
    foreach ($products_in_cart as &$cart_product) {
        foreach ($products as $product) {
            if ($cart_product['product_id'] == $product['product_id']) {
                $cart_product['meta'] = $product;
                // Calculate the subtotal
                $product_prijs = $cart_product['optie_eenheidsprijs'] > 0 ? (float)$cart_product['optie_eenheidsprijs'] : (float)$product['eenheidsprijs'];
                $subtotaal += $product_prijs * (int)$cart_product['quantity'];
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
    <meta content="Delga winkelmand" name="description">
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

        <div class="cart content-wrapper">

            <h4>Winkelmand</h4>

            <form action="winkelmand.php" method="post">
                <table>
                    <thead>
                    <tr>
                        <td colspan="2">Product</td>
                        <td></td>
                        <td class="rhide">Prijs</td>
                        <td>Aantal</td>
                        <td>Totaal</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (empty($products_in_cart)): ?>
                        <tr>
                            <td colspan="6" style="text-align:center;">Er zijn geen producten toegevoegd in uw
                                winkelmand!
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($products_in_cart as $num => $product): ?>
                            <tr>
                                <td class="img">
                                    <?php if (!empty($product['meta']['product_foto']) && file_exists('images/producten/' . $product['meta']['product_foto'])): ?>
                                        <a href="product.php?id=<?= $product['product_id'] ?>">
                                            <img src="images/producten/<?= $product['meta']['product_foto'] ?>"
                                                 width="50" height="50" alt="<?= $product['meta']['product_naam'] ?>">
                                        </a>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="product.php?&id=<?= $product['product_id'] ?>"><?= $product['meta']['product_naam'] ?></a>
                                    <br>
                                    <a href="winkelmand.php?remove=<?= $num ?>" class="remove">Remove</a>
                                </td>
                                <td class="prijs">
                                    <?= $product['opties'] ?>
                                    <input type="hidden" name="opties" value="<?= $product['opties'] ?>">
                                </td>
                                <?php if ($product['optie_eenheidsprijs'] > 0): ?>
                                    <td class="prijs rhide"><?= '€ ' ?><?= number_format($product['$optie_eenheidsprijs'], 2) ?></td>
                                <?php else: ?>
                                    <td class="prijs rhide"><?= '€ ' ?><?= number_format($product['meta']['eenheidsprijs'], 2) ?></td>
                                <?php endif; ?>
                                <td class="quantity">
                                    <input type="number" name="quantity-<?= $num ?>" value="<?= $product['quantity'] ?>"
                                           min="1" placeholder="Quantity" required>
                                </td>
                                <?php if ($product['optie_eenheidsprijs'] > 0): ?>
                                    <td class="prijs"><?= '€ ' ?><?= number_format($product['$optie_eenheidsprijs'] * $product['quantity'], 2) ?></td>
                                <?php else: ?>
                                    <td class="prijs"><?= '€ ' ?><?= number_format($product['meta']['eenheidsprijs'] * $product['quantity'], 2) ?></td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>


                <div class="subtotaal">
                    <span class="text">Subtotaal</span>
                    <span class="prijs"><?= '€ ' ?><?= number_format($subtotaal, 2) ?></span>
                </div>

                <div class="verzending">
                    <span class="text">Verzending</span>
                    <span class="prijs"><?= '€ ' ?><?= number_format($shippingtotaal, 2) ?></span>
                </div>

                <div class="totaal">
                    <span class="text">Totaal</span>
                    <span class="prijs"><?= '€ ' ?><?= number_format($subtotaal + $shippingtotaal, 2) ?></span>
                </div>

                <div class="buttons">
                    <input type="submit" value="Winkelmand legen" name="emptycart">
                    <input type="submit" value="Update" name="update">
                    <input type="submit" value="Bestellen" name="checkout">
                </div>

            </form>

        </div>


    </div>
</main>

<?php include('includes/footer.php'); ?>
<script>
    if (document.querySelector(".cart .ajax-update")) {
        document.querySelectorAll(".cart .ajax-update").forEach(ele => {
            ele.onchange = () => {
                let formEle = document.querySelector("form");
                let formData = new FormData(formEle);
                formData.append("update", "Update");
                fetch(formEle.action, {
                    method: "POST",
                    body: formData
                }).then(function (response) {
                    return response.text()
                })
                    .then(function (html) {
                        let parser = new DOMParser();
                        let doc = parser.parseFromString(html, "text/html");
                        document.querySelector(".subtotaal").innerHTML = doc.querySelector(".subtotaal").innerHTML;
                        document.querySelector(".verzending").innerHTML = doc.querySelector(".verzending").innerHTML;
                        document.querySelector(".totaal").innerHTML = doc.querySelector(".totaal").innerHTML;
                        document.querySelectorAll(".product-totaal").forEach((e, i) => {
                            e.innerHTML = doc.querySelectorAll(".product-totaal")[i].innerHTML;
                        })
                    });
            };
        });
    }
</script>
</body>
</html>