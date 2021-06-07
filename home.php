<?php
$menu = 1;
include 'main.php';
$pdo_function = pdo_connect_mysql();
check_loggedin($pdo_function);
//statement producten
$stmtProducten = $pdo_function->prepare('SELECT * FROM producten WHERE product_id = 37 OR product_id = 1');
$stmtProducten->execute();
$producten = $stmtProducten->fetchAll(PDO::FETCH_ASSOC);
//statement product
$stmtProduct = $pdo_function->prepare('SELECT * FROM producten WHERE product_id = 34');
$stmtProduct->execute();
$product = $stmtProduct->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html class="h-100" lang="nl">
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

<main class="flex-shrink-0">
    <div class="container">

        <div class="content">
            <p class="block">Welkom terug, <?= $_SESSION['voornaam'] ?> <?= $_SESSION['achternaam'] ?>!</p>
        </div>
        <p class="text-center"><img alt="" height="118" src="images/delga_gif.gif" width="246"></p>
        <div class="row justify-content-md-center">
            <div class="col-md-8">
                <div class="list-group">
                    <div class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">Best verkopende producten bij delga.be</h5>
                        </div>
                    </div>
                </div>
                <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="row mb-2">
                                <div class="col-md-12">
                                    <div class="no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                                        <div class="card">
                                            <a href="product.php?id=<?= $product['product_id'] ?>">
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
                                                                <p class="card-text">
                                                                    Verpakking: <?= $product['verpakking'] ?></p>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="p-2">
                                                            <p class="card-text text-secondary">
                                                                €&nbsp;<?= number_format($product['eenheidsprijs'], 2) ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php foreach ($producten as $product): ?>
                        <div class="carousel-item">
                            <div class="row mb-2">
                                <div class="col-md-12">
                                    <div class="no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                                        <div class="card">
                                            <a href="product.php?id=<?= $product['product_id'] ?>">
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
                                                                <p class="card-text">
                                                                    Verpakking: <?= $product['verpakking'] ?></p>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="p-2">
                                                            <p class="card-text text-secondary">
                                                                €&nbsp;<?= number_format($product['eenheidsprijs'], 2) ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                        <span><i class="fa fa-angle-left" aria-hidden="true"
                                 style="color: black; font-size: xxx-large"></i></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                        <span><i class="fa fa-angle-right" aria-hidden="true"
                                 style="color: black; font-size: xxx-large"></i></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>

    </div>
</main>

<?php include('includes/footer.php'); ?>
</body>
</html>