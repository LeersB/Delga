<?php
$menu = 5;
include 'main.php';
$pdo_function = pdo_connect_mysql();
check_loggedin($pdo_function);
// Default values for the input form elements
$account = [
    'voornaam' => '',
    'achternaam' => '',
    'adres_straat' => '',
    'adres_nr' => '',
    'adres_postcode' => '',
    'adres_plaats' => ''
];

// Error array, output errors on the form
$errors = [];
// Check if user is logged in
if (isset($_SESSION['loggedin'])) {
    $stmt = $pdo_function->prepare('SELECT * FROM users WHERE user_id = ?');
    $stmt->execute([$_SESSION['user_id']]);
    $account = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Process the order
$products_in_cart = isset($_SESSION['delgashop']) ? $_SESSION['delgashop'] : [];
$subtotaal = 0.00;
$levering = leveringskost;
// If there are products in cart
if ($products_in_cart) {
    $array_to_question_marks = implode(',', array_fill(0, count($products_in_cart), '?'));
    $stmt = $pdo_function->prepare('SELECT * FROM producten WHERE product_id IN (' . $array_to_question_marks . ')');
    $stmt->execute(array_column($products_in_cart, 'product_id'));
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Iterate the products in cart and add the meta data (product name, desc, etc)
    foreach ($products_in_cart as &$delgashop_product) {
        foreach ($products as $product) {
            if ($delgashop_product['product_id'] == $product['product_id']) {
                $delgashop_product['meta'] = $product;
                // Calculate the subtotal
                $product_prijs = $delgashop_product['optie_eenheidsprijs'] > 0 ? (float)$delgashop_product['optie_eenheidsprijs'] : (float)$product['eenheidsprijs'];
                $subtotaal += $product_prijs * (int)$delgashop_product['aantal'];
            }
        }
    }
}

// Make sure when the user submits the form all data was submitted and shopping cart is not empty
if (isset($_POST['voornaam'], $_POST['achternaam'], $_POST['adres_straat'], $_POST['adres_nr'], $_POST['adres_postcode'], $_POST['adres_plaats'], $_SESSION['delgashop'])) {
    $user_id = null;

    // If the user is already logged in
    if (isset($_SESSION['loggedin'])) {
        $user_id = $_SESSION['user_id'];
    } else {
        $errors[] = 'Account login required!';
    }
    if (!$errors) {

        if (isset($_POST['checkout']) && $products_in_cart) {
            // Process Normal Checkout
            // Iterate each product in the user's shopping cart
            // Unique transaction ID
            $transaction_id = strtoupper(uniqid('2021-') . substr(md5(mt_rand()), 0, 2));
            $stmt = $pdo_function->prepare('INSERT INTO orders (order_nr, totaal_prijs, order_status, order_datum, order_email, order_voornaam, order_achternaam, order_adres, gebruiker_id) VALUES (?,?,?,?,?,?,?,?,?)');
            $stmt->execute([
                $transaction_id,
                $subtotaal + $levering,
                '1',
                date('Y-m-d H:i:s'),
                isset($account['email']) && !empty($account['email']) ? $account['email'] : $_POST['email'],
                $_POST['voornaam'],
                $_POST['achternaam'],
                $_POST['order_adres'],
                $user_id
            ]);
            $order_id = $pdo_function->lastInsertId();
            foreach ($products_in_cart as $product) {
                // For every product in the shopping cart insert a new transaction into our database
                $stmt = $pdo_function->prepare('INSERT INTO order_details (order_nr, product_id, product_prijs, product_aantal, product_optie) VALUES (?,?,?,?,?)');
                $stmt->execute([$transaction_id, $product['product_id'], $product['optie_eenheidsprijs'] > 0 ? $product['optie_eenheidsprijs'] : $product['meta']['eenheidsprijs'], $product['aantal'], $product['opties']]);
            }
            send_order_details_email(
                isset($account['email']) && !empty($account['email']) ? $account['email'] : $_POST['email'],
                $products_in_cart,
                $_POST['voornaam'],
                $_POST['achternaam'],
                $_POST['adres_straat'],
                $_POST['adres_nr'],
                $_POST['adres_postcode'],
                $_POST['adres_plaats'],
                $subtotaal + $levering,
                $order_id
            );
            header('Location: besteld.php');
            exit;
        }
    }
    // Preserve form details if the user encounters an error
    $account = [
        'voornaam' => $_POST['voornaam'],
        'achternaam' => $_POST['achternaam'],
        'adres_straat' => $_POST['adres_straat'],
        'adres_nr' => $_POST['adres_nr'],
        'adres_postcode' => $_POST['adres_postcode'],
        'adres_plaats' => $_POST['adres_plaats']
    ];
}
// Redirect the user if the shopping cart is empty
if (empty($_SESSION['delgashop'])) {
    header('Location: winkelmand.php');
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


            <p class="error"><?= implode('<br>', $errors) ?></p>

            <?php if (!isset($_SESSION['loggedin'])): ?>
                <p>Already have an account? <a href="login.php">Log In</a></p>
            <?php endif; ?>

            <form class="needs-validation" novalidate action="" method="post">


                    <h2>Details bestelling</h2>

                    <div class="row">


                        <div class="input-group col-md-6">
                            <label class="sr-only" for="voornaam">Voornaam</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-user"></i></div>
                                </div>
                                <input type="text" class="form-control" value="<?= $account['voornaam'] ?>"
                                       id="voornaam" name="voornaam" placeholder="Voornaam"
                                       required>
                            </div>
                        </div>
                        <div class="input-group col-md-6">
                            <label class="sr-only" for="achternaam">Achternaam</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-user"></i></div>
                                </div>
                                <input type="text" class="form-control" value="<?= $account['achternaam'] ?>"
                                       id="achternaam" name="achternaam"
                                       placeholder="Achternaam" required>
                            </div>
                        </div>
                        <div class="input-group col-md-6">
                            <label class="sr-only" for="email">E-mailadres</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-envelope"></i></div>
                                </div>
                                <input type="email" class="form-control" value="<?= $account['email'] ?>" id="email"
                                       name="email"
                                       placeholder="E-mailadres"
                                       required>
                            </div>
                        </div>
                        <div class="input-group col-md-6">
                            <label class="sr-only" for="telefoon_nr">Telefoonnummer</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-phone-alt"></i></div>
                                </div>
                                <input type="text" class="form-control" value="<?= $account['telefoon_nr'] ?>"
                                       id="telefoon_nr" name="telefoon_nr"
                                       placeholder="Telefoonnummer">
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
                            <label class="sr-only" for="order_adres">Adres</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-house-user"></i></div>
                                </div>
                                <input type="text" class="form-control"
                                       value="<?= $account['adres_straat'], ' ', $account['adres_nr'], ' - ', $account['adres_postcode'], ' ', $account['adres_plaats'] ?>"
                                       id="order_adres" name="order_adres" placeholder="Adres" required>
                            </div>
                        </div>

                        <div class="input-group col-md-9 sr-only">
                            <label class="sr-only" for="adres_straat">Adres</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-house-user"></i></div>
                                </div>
                                <input type="text" class="form-control" value="<?= $account['adres_straat'] ?>"
                                       id="adres_straat" name="adres_straat"
                                       placeholder="Adres" required>
                            </div>
                        </div>
                        <div class="input-group col-md-3 sr-only">
                            <label class="sr-only" for="adres_nr">Nr. / Bus</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-house-user"></i></div>
                                </div>
                                <input type="text" class="form-control" value="<?= $account['adres_nr'] ?>"
                                       id="adres_nr" name="adres_nr"
                                       placeholder="Nr. / Bus" required>
                            </div>
                        </div>
                        <div class="input-group col-md-6 sr-only">
                            <label class="sr-only" for="adres_postcode">Postcode</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-house-user"></i></div>
                                </div>
                                <input type="text" class="form-control" value="<?= $account['adres_postcode'] ?>"
                                       id="adres_postcode" name="adres_postcode"
                                       placeholder="Postcode" required>
                            </div>
                        </div>
                        <div class="input-group col-md-6 sr-only">
                            <label class="sr-only" for="adres_plaats">Plaats</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-house-user"></i></div>
                                </div>
                                <input type="text" class="form-control" value="<?= $account['adres_plaats'] ?>"
                                       id="adres_plaats" name="adres_plaats"
                                       placeholder="Plaats" required>
                            </div>
                        </div>


                    </div>



                <div class="cart content-wrapper">


                    <div class="table-responsive-md">
                        <table class="table table-hover">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col"></th>
                                <th scope="col" colspan="2">Product</th>
                                <th scope="col" class="rhide">Prijs</th>
                                <th scope="col">Aantal</th>
                                <th scope="col">Totaal</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($products_in_cart as $num => $product): ?>
                                <tr>
                                    <td class="img">
                                        <?php if (!empty($product['meta']['product_foto']) && file_exists('images/producten/' . $product['meta']['product_foto'])): ?>
                                            <a href="product.php?product_id=<?= $product['product_id'] ?>">
                                                <img src="images/producten/<?= $product['meta']['product_foto'] ?>"
                                                     width="50" height="50"
                                                     alt="<?= $product['meta']['product_naam'] ?>">
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
                                        <td class="prijs rhide">
                                            € <?= number_format($product['optie_eenheidsprijs'], 2) ?></td>
                                    <?php else: ?>
                                        <td class="prijs rhide">
                                            € <?= number_format($product['meta']['eenheidsprijs'], 2) ?></td>
                                    <?php endif; ?>
                                    <td class="aantal">
                                        <input type="number" class="form-control ajax-update" disabled
                                               aria-label="Aantal"
                                               name="aantal-<?= $num ?>"
                                               value="<?= $product['aantal'] ?>" min="1" placeholder="Aantal" required>
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
                <button type="submit" name="checkout">Plaats Order</button>
            </form>
        </div>

    </div>
</main>

<?php include('includes/footer.php'); ?>

</body>
</html>
