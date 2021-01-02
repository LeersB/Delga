<?php
$menu = 5;
$error = '';
include 'main.php';

// Prevent direct access to file
//defined('shoppingcart') or exit;
// Check to make sure the id parameter is specified in the URL
if (isset($_GET['product_id'])) {
    $stmt = $pdo->prepare('SELECT * FROM producten WHERE product_id = ?');
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
    //$stmt = $pdo->prepare('SELECT title, GROUP_CONCAT(name) AS options, GROUP_CONCAT(price) AS prices FROM products_options WHERE product_id = ? GROUP BY title');
    //$stmt->execute([ $_GET['id'] ]);
    // Fetch the product options from the database and return the result as an Array
    //$product_options = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Simple error to display if the id wasn't specified
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
                                        <p class="card-text"><?= $product['product_info'] ?></p>
                                        <p class="card-text">
                                            <?= $product['omschrijving'] ?></p>
                                        <p class="card-text">Verpakking: <?= $product['verpakking'] ?></p>
                                        <p class="text-danger">  <?= $product['waarschuwing'] ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <p class="card-text text-secondary"> <?= '€ ' ?><?= number_format($product['eenheidsprijs'], 2) ?>
                                    <a href="#" class="btn btn-outline-success"><i
                                                class="fas fa-shopping-basket"></i></a></p>
                            </div>
                        </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="row"><br></div>
    </div>
</main>

<?php include('includes/footer.php'); ?>
</body>
</html>