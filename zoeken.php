<?php
$menu = 5;
$error = '';
include 'main.php';
// Check for search query
if (isset($_GET['query']) && $_GET['query'] != '') {
    // Escape the user query, prevent XSS attacks
    $search_query = htmlspecialchars($_GET['query'], ENT_QUOTES, 'UTF-8');
    $stmt = $pdo->prepare('SELECT * FROM producten WHERE product_naam LIKE ?');
    $stmt->execute(['%' . $search_query . '%']);
    $producten = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $total_products = count($producten);
} else {
    $error = 'Er is geen zoekopdracht ingevuld!';
}
?>
<!DOCTYPE html>
<html class="h-100" lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
    <meta content="Delga contactgegevens" name="description">
    <meta content="Bart Leers" name="author">
    <title>Delga zoek resultaat</title>
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

            <div class="products content-wrapper">

                <h1>Zoek resultaat voor "<?= $search_query ?>"</h1>

                <p><?= $total_products ?> product(en) gevonden</p>

                <div class="row mb-2">
                    <?php foreach ($producten as $product): ?>
                        <div class="col-md-6">
                            <div class="no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                                <div class="card">

                                    <div class="row no-gutters g-2">
                                        <div class="col-md-4">

                                            <?php if (empty($product['product_foto'])): ?>
                                                <svg class="card-img-top" role="img">
                                                    <title>Placeholder</title>
                                                    <rect width="100%" height="100%" fill="#55595c"/>
                                                </svg>
                                            <?php endif; ?>

                                            <?php if (!empty($product['product_foto']) && file_exists('images/producten/' . $product['product_foto'])): ?>
                                                <img src="images/producten/<?= $product['product_foto'] ?>"
                                                     class="card-img-top"
                                                     alt="<?= $product['product_naam'] ?>">
                                            <?php endif; ?>
                                        </div>

                                        <div class="col-md-8">
                                            <h5 class="card-header text-uppercase"> <?= $product['product_naam'] ?></h5>
                                            <div class="card-body">
                                                <p class="card-text"><?= $product['omschrijving'] ?></p>
                                                <?php if (!empty($product['verpakking'])): ?>
                                                    <p class="card-text">Verpakking: <?= $product['verpakking'] ?></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <p class="card-text text-secondary"> <?= '€ ' ?><?= number_format($product['eenheidsprijs'], 2) ?>
                                            <a href="#" class="btn btn-outline-success"><i
                                                        class="fas fa-shopping-basket"></i></a>
                                            <a href="product.php?&product_id=<?= $product['product_id'] ?>"
                                               class="btn btn-outline-secondary"><i class="fas fa-info"></i> Info</a>
                                        </p>

                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        <?php endif; ?>

    </div>
</main>

<?php include('includes/footer.php'); ?>
</body>
</html>