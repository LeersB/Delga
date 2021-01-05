<?php
$menu = 5;
$error = '';
include 'main.php';
defined('winkelmand') or exit;

$pdo_function = pdo_connect_mysql();
if (isset($_GET['product_id'])) {
    $stmt = $pdo_function->prepare('SELECT * FROM producten WHERE product_id = ?');
    $stmt->execute([$_GET['product_id']]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$product) {
        $error = 'Product bestaat niet!';
    }
    // Select the product images (if any) from the products_images table
    //$stmt = $pdo->prepare('SELECT * FROM products_images WHERE product_id = ?');
    //$stmt->execute([$_GET['product_id']]);
    // Fetch the product images from the database and return the result as an Array
    //$product_imgs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Select the product options (if any) from the products_options table
    $stmt = $pdo_function->prepare('SELECT optie_titel, GROUP_CONCAT(optie_naam) AS opties, GROUP_CONCAT(eenheidsprijs) AS prijzen FROM product_opties WHERE product_id = ? GROUP BY optie_titel');
    $stmt->execute([$_GET['product_id']]);
    // Fetch the product options from the database and return the result as an Array
    $product_opties = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $error = 'Product bestaat niet!';
}
?>
<!DOCTYPE html>
<html class="h-100" lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
    <meta content="Delga contactgegevens" name="description">
    <meta content="Bart Leers" name="author">
    <title>Delga home</title>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/delga.css" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100">

<header>
    <?php include('includes/header.php'); ?>
</header>

<main class="flex-shrink-0" role="main">
    <div class="container">


        <?php if ($error): ?>

            <p class="content-wrapper error"><?= $error ?></p>

        <?php else: ?>

            <div class="row" id="content-wrapper">
                <div class="col-md">
                    <div class="card md-12">
                        <div class="row no-gutters g-0">
                            <div class="col-md-4">
                                <?php if (!empty($product['product_foto']) && file_exists('images/producten/' . $product['product_foto'])): ?>
                                    <img src="images/producten/<?= $product['product_foto'] ?>" class="card-img-top"
                                         alt="<?= $product['product_naam'] ?>">
                                <?php endif; ?>
                            </div>
                            <div class="col-md-8">
                                <h5 class="card-header text-uppercase"> <?= $product['product_naam'] ?></h5>
                                <div class="card-body">
                                    <p class="card-text"><?= $product['omschrijving'] ?></p>
                                    <p class="card-text"><?= $product['product_info'] ?></p>
                                    <?php if (!empty($product['verpakking'])): ?>
                                        <p class="card-text">Verpakking: <?= $product['verpakking'] ?></p>
                                    <?php endif; ?>
                                    <p class="text-danger"><?= $product['waarschuwing'] ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="col-md-4">
                                <span class="eenheidsprijs">
                                    <p class="card-text text-secondary"> <?= '€ ' ?><?= number_format($product['eenheidsprijs'], 2) ?></p>
                                </span>
                            </div>
                            <div class="input-group">
                                <form class="col-md-10" id="product-form" action="winkelmand.php" method="post">
                                    <div class="form-row">
                                        <?php foreach ($product_opties as $optie): ?>

                                            <div class="col-6">
                                                <select class="form-control" name="option-<?= $optie['optie_titel'] ?>"
                                                        required>
                                                    <option value="" selected disabled
                                                            style="display:none"><?= $optie['optie_titel'] ?></option>
                                                    <?php
                                                    $optie_naam = explode(',', $optie['opties']);
                                                    $optie_prijs = explode(',', $optie['prijzen']);
                                                    ?>
                                                    <?php foreach ($optie_naam as $k => $naam): ?>
                                                        <option value="<?= $naam ?>"
                                                                data-eenheidsprijs="<?= $optie_prijs[$k] ?>"><?= $naam ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        <?php endforeach; ?>

                                        <div class="col-3">
                                            <input type="number" class="form-control" name="quantity" value="1" min="1"
                                                   placeholder="Quantity" required>
                                            <input type="hidden" name="product_id"
                                                   value="<?= $product['product_id'] ?>">
                                        </div>

                                        <div class="col-1">
                                            <!--<input type="submit">-->
                                            <a href="#" class="btn btn-outline-success" id="submit"><i
                                                        class="fas fa-shopping-basket"></i></a></p>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="row"><br></div>
    </div>

    </div>
</main>

<?php include('includes/footer.php'); ?>
<script>
    if (document.querySelector(".card-footer #product-form")) {
        document.querySelectorAll(".card-footer #product-form select").forEach(ele => {
            ele.onchange = () => {
                let eenheidsprijs = 0.00;
                document.querySelectorAll(".card-footer #product-form select").forEach(e => {
                    if (e.value) {
                        eenheidsprijs += parseFloat(e.options[e.selectedIndex].dataset.eenheidsprijs);
                    }
                });
                if (eenheidsprijs > 0.00) {
                    document.querySelector(".card-footer .eenheidsprijs").innerHTML = '<p class="card-text text-secondary">' + ' € ' + eenheidsprijs.toFixed(2) + '</p>';
                }
            };
        });
    }
</script>
</body>
</html>