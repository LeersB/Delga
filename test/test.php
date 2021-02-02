<?php
include 'main.php';
$pdo = pdo_connect_mysql();
// If the user clicked the add to cart button on the product page we can check for the form data
if (isset($_POST['product_id'], $_POST['quantity']) && is_numeric($_POST['product_id']) && is_numeric($_POST['quantity'])) {
    // Set the post variables so we easily identify them, also make sure they are integer
    $product_id = (int)$_POST['product_id'];
    // abs() function will prevent minus quantity and (int) will make sure the value is an integer
    $quantity = abs((int)$_POST['quantity']);
    // Get product options
    $options = '';
    $options_price = 0.00;
    foreach ($_POST as $k => $v) {
        if (strpos($k, 'option-') !== false) {
            $options .= str_replace('option-', '', $k) . '-' . $v . ',';
            $stmt = $pdo->prepare('SELECT * FROM product_opties WHERE optie_titel = ? AND optie_naam = ? AND product_id = ?');
            $stmt->execute([ str_replace('option-', '', $k), $v, $product_id ]);
            $option = $stmt->fetch(PDO::FETCH_ASSOC);
            $options_price += $option['eenheidsprijs'];
        }
    }
    $options = rtrim($options, ',');
    // Prepare the SQL statement, we basically are checking if the product exists in our database
    $stmt = $pdo->prepare('SELECT * FROM producten WHERE product_id = ?');
    $stmt->execute([ $_POST['product_id'] ]);
    // Fetch the product from the database and return the result as an Array
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    // Check if the product exists (array is not empty)
    if ($product && $quantity > 0) {
        // Product exists in database, now we can create/update the session variable for the cart
        if (!isset($_SESSION['cart'])) {
            // Shopping cart session variable doesnt exist, create it
            $_SESSION['cart'] = [];
        }
        $cart_product = get_cart_product($product_id, $options);
        if ($cart_product) {
            // Product exists in cart, update the quanity
            $cart_product['quantity'] += $quantity;
        } else {
            // Product is not in cart, add it
            $_SESSION['cart'][] = [
                'product_id' => $product_id,
                'quantity' => $quantity,
                'options' => $options,
                'options_price' => $options_price,
                'shipping_price' => 0.00
            ];
        }
    }
    // Prevent form resubmission...
    header('location: test.php');
    exit;
}
// Remove product from cart, check for the URL param "remove", this is the product id, make sure it's a number and check if it's in the cart
if (isset($_GET['remove']) && is_numeric($_GET['remove']) && isset($_SESSION['cart']) && isset($_SESSION['cart'][$_GET['remove']])) {
    // Remove the product from the shopping cart
    unset($_SESSION['cart'][$_GET['remove']]);
    header('location: test.php');
    exit;
}
// Empty the cart
if (isset($_POST['emptycart']) && isset($_SESSION['cart'])) {
    // Remove all products from the shopping cart
    unset($_SESSION['cart']);
    header('location: test.php');
    exit;
}
// Update product quantities in cart if the user clicks the "Update" button on the shopping cart page
if ((isset($_POST['update']) || isset($_POST['checkout'])) && isset($_SESSION['cart'])) {
    // Loop through the post data so we can update the quantities for every product in cart
    foreach ($_POST as $k => $v) {
        if (strpos($k, 'quantity') !== false && is_numeric($v)) {
            $product_id = str_replace('quantity-', '', $k);
            // abs() function will prevent minus quantity and (int) will make sure the number is an integer
            $quantity = abs((int)$v);
            // Always do checks and validation
            if (is_numeric($product_id) && isset($_SESSION['cart'][$product_id]) && $quantity > 0) {
                // Update new quantity
                $_SESSION['cart'][$product_id]['quantity'] = $quantity;
            }
        }
    }

    // Send the user to the place order page if they click the Place Order button, also the cart should not be empty
    if (isset($_POST['checkout']) && !empty($_SESSION['cart'])) {
        header('Location: index.php?page=checkout');
        exit;
    }
    header('location: test.php');
    exit;
}
// Check the session variable for products in cart
$products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$subtotal = 0.00;
$shippingtotal = 0.00;

$shipping_available = false;
// If there are products in cart
if ($products_in_cart) {
    // There are products in the cart so we need to select those products from the database
    // Products in cart array to question mark string array, we need the SQL statement to include: IN (?,?,?,...etc)
    $array_to_question_marks = implode(',', array_fill(0, count($products_in_cart), '?'));
    $stmt = $pdo->prepare('SELECT * FROM producten WHERE producten.product_id IN (' . $array_to_question_marks . ')');
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
                $product_price = $cart_product['options_price'] > 0 ? (float)$cart_product['options_price'] : (float)$product['eenheidsprijs'];
                $subtotal += $product_price * (int)$cart_product['quantity'];

            }
        }
    }
}
?>



<div class="cart content-wrapper">

    <h1>Shopping Cart</h1>

    <form action="" method="post">
        <table>
            <thead>
            <tr>
                <td colspan="2">Product</td>
                <td></td>
                <td class="rhide">Price</td>
                <td>Quantity</td>
                <td>Total</td>
            </tr>
            </thead>
            <tbody>
            <?php if (empty($products_in_cart)): ?>
                <tr>
                    <td colspan="6" style="text-align:center;">You have no products added in your Shopping Cart</td>
                </tr>
            <?php else: ?>
                <?php foreach ($products_in_cart as $num => $product): ?>
                    <tr>

                        <td>
                            <a href="product.php?id=<?=$product['product_id']?>"><?=$product['meta']['product_naam']?></a>
                            <br>
                            <a href="test.php?remove=<?=$num?>" class="remove">Remove</a>
                        </td>
                        <td class="price">
                            <?=$product['options']?>
                            <input type="hidden" name="options" value="<?=$product['options']?>">
                        </td>
                        <?php if ($product['options_price'] > 0): ?>
                            <td class="price rhide">€ <?=number_format($product['options_price'],2)?></td>
                        <?php else: ?>
                            <td class="price rhide">€ <?=number_format($product['meta']['eenheidsprijs'],2)?></td>
                        <?php endif; ?>
                        <td class="quantity">
                            <input type="number" class="ajax-update" name="quantity-<?=$num?>" value="<?=$product['quantity']?>" min="1"  placeholder="Quantity" required>
                        </td>
                        <?php if ($product['options_price'] > 0): ?>
                            <td class="price product-total">€ <?=number_format($product['options_price'] * $product['quantity'],2)?></td>
                        <?php else: ?>
                            <td class="price product-total">€ <?=number_format($product['meta']['eenheidsprijs'] * $product['quantity'],2)?></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>



        <div class="subtotal">
            <span class="text">Subtotal</span>
            <span class="price">€ <?=number_format($subtotal,2)?></span>
        </div>

        <div class="shipping">
            <span class="text">Shipping</span>
            <span class="price">€ <?=number_format($shippingtotal,2)?></span>
        </div>

        <div class="total">
            <span class="text">Total</span>
            <span class="price">€ <?=number_format($subtotal+$shippingtotal,2)?></span>
        </div>

        <div class="buttons">
            <input type="submit" value="Empty Cart" name="emptycart">
            <input type="submit" value="Update" name="update">
            <input type="submit" value="Checkout" name="checkout">
        </div>

    </form>

</div>


