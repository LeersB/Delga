<?php
//define('shoppingcart', true);
$menu = 5;

include 'main.php';
//defined('shoppingcart') or exit;
$pdo_function = pdo_connect_mysql();
$stmt = $pdo_function->query('SELECT * FROM categorie');
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Get the current category from the GET request, if none exists set the default selected category to: all
$categorie = isset($_GET['categorie']) ? $_GET['categorie'] : 'all';
$category_sql = '';
if ($categorie != 'all') {
    $category_sql = 'WHERE categorie_id = :categorie';
}
// Get the sort from GET request, will occur if the user changes an item in the select box
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'sort1';
// The amounts of products to show on each page
$num_products_on_each_page = 8;
// The current page, in the URL this will appear as index.php?page=products&p=1, index.php?page=products&p=2, etc...
$current_page = isset($_GET['p']) && is_numeric($_GET['p']) ? (int)$_GET['p'] : 1;
// Select products ordered by the date added
if ($sort == 'sort1') {
    $stmt = $pdo_function->prepare('SELECT p.* FROM producten p  ' . $category_sql . ' ORDER BY p.product_naam ASC LIMIT :page,:num_products');
} elseif ($sort == 'sort2') {
    $stmt = $pdo_function->prepare('SELECT p.* FROM producten p ' . $category_sql . ' ORDER BY p.product_naam DESC LIMIT :page,:num_products');
} else {
    $stmt = $pdo_function->prepare('SELECT p.* FROM producten p ' . $category_sql . ' LIMIT :page,:num_products');
}
// bindValue will allow us to use integer in the SQL statement, we need to use for LIMIT
if ($categorie != 'all') {
    $stmt->bindValue(':categorie', $categorie, PDO::PARAM_INT);
}
$stmt->bindValue(':page', ($current_page - 1) * $num_products_on_each_page, PDO::PARAM_INT);
$stmt->bindValue(':num_products', $num_products_on_each_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the products from the database and return the result as an Array
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Get the total number of products
$stmt = $pdo_function->prepare('SELECT COUNT(*) FROM producten p ' . $category_sql);
if ($categorie != 'all') {
    $stmt->bindValue(':categorie', $categorie, PDO::PARAM_INT);
}
$stmt->execute();
$total_products = $stmt->fetchColumn()
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

        <div class="products content-wrapper">
            <h1>Producten</h1>
            <div class="products-header">
                <p><?= $total_products ?> product(en) gevonden</p>
            </div>
            <div class="row"><br></div>
            <form action="" method="get" class="products-form">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="categorie">Categorie</label>
                    </div>
                    <select class="custom-select" id="categorie" name="categorie">
                        <option value="all"<?= ($categorie == 'all' ? ' selected' : '') ?>>Alle producten
                        </option>
                        <?php foreach ($categories as $c): ?>
                            <option value="<?= $c['categorie_id'] ?>"<?= ($categorie == $c['categorie_id'] ? ' selected' : '') ?>><?= $c['categorie_naam'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="sort">Sorteren</label>
                    </div>
                    <select class="custom-select" name="sort" id="sort">
                        <option value="sort1"<?= ($sort == 'sort1' ? ' selected' : '') ?> selected>Oplopend
                        </option>
                        <option value="sort2"<?= ($sort == 'sort2' ? ' selected' : '') ?>>Aflopend</option>
                    </select>
                    <div class="input-group-append">
                        <button class="btn btn-secondary" type="submit">Toepassen</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="row"><br></div>
        <!--
        <div class="row" id="page-content-wrapper">


            <?php foreach ($products as $product): ?>
                <a href="product.php?page=&id=<?= $product['product_id'] ?>" class="product">
                    <div class="col-md-3">
                        <div class="card mb-2">
                            <?php if (!empty($product['product_foto']) && file_exists('images/producten/' . $product['product_foto'])): ?>
                                <img src="images/producten/<?= $product['product_foto'] ?>" class="card-img-top"
                                     alt="<?= $product['product_naam'] ?>">
                            <?php endif; ?>
                            <div class="card-header">
                                <h5><?= $product['product_naam'] ?></h5>
                            </div>
                            <div class="card-body">
                                <p class="card-text">
                                    <?= $product['omschrijving'] ?>
                                </p>
                                <p class="text-danger">  <?= $product['waarschuwing'] ?></p>


                                <p class="card-text text-secondary"> <?= '€ ' ?><?= number_format($product['eenheidsprijs'], 2) ?></p>
                                <a href="#" class="btn btn-primary">Go somewhere</a>
                            </div>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
-->
        <!--<svg class="bd-placeholder-img" width="200" height="250" role="img"><title>Placeholder</title>
            <rect width="100%" height="100%" fill="#55595c"/>
            <text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text>
        </svg>-->

        <div class="row mb-2">
            <?php foreach ($products as $product): ?>
                <div class="col-md-6">
                    <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                        <div class="card md-3" style="max-width: 540px;">
                            <h5 class="card-header"> <?= $product['product_naam'] ?></h5>
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <?php if (!empty($product['product_foto']) && file_exists('images/producten/' . $product['product_foto'])): ?>
                                        <img src="images/producten/<?= $product['product_foto'] ?>" class="card-img-top"
                                             alt="<?= $product['product_naam'] ?>">
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <p class="card-text"><?= $product['omschrijving'] ?></p>
                                        <p class="card-text"><small
                                                    class="text-danger"> <?= $product['waarschuwing'] ?></small></p>
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
            <?php endforeach; ?>
        </div>


        <!-- <div class="products-wrapper">
                <?php foreach ($products as $product): ?>
                    <a href="product.php?page=&id=<?= $product['product_id'] ?>" class="product">
                        <?php if (!empty($product['product_foto']) && file_exists('images/' . $product['product_foto'])): ?>
                            <img src="images/<?= $product['product_foto'] ?>" width="200" height="200" alt="<?= $product['product_naam'] ?>">
                        <?php endif; ?>
                            <?php if ($product['btw'] > 0): ?>
                                <span class="rrp"><?= '€ ' ?><?= number_format($product['btw'], 2) ?></span>
                            <?php endif; ?>
            </span>
                    </a>
                <?php endforeach; ?>
            </div>
        <div class="buttons">
            <?php if ($current_page > 1): ?>
                <a href="producten.php?p=<?= $current_page - 1 ?>&categorie_id=<?= $categorie ?>&sort=<?= $sort ?>">Prev</a>
            <?php endif; ?>
            <?php if ($total_products > ($current_page * $num_products_on_each_page) - $num_products_on_each_page + count($products)): ?>
                <a href="producten.php?p=<?= $current_page + 1 ?>&categorie_id=<?= $categorie ?>&sort=<?= $sort ?>">Next</a>
            <?php endif; ?>
        </div> -->


        <div class="btn-group" role="group" aria-label="Sorteren">
            <?php if ($current_page > 1): ?>
                <a type="button" class="btn btn-outline-success"
                   href="producten.php?p=<?= $current_page - 1 ?>&categorie_id=<?= $categorie ?>&sort=<?= $sort ?>">Terug</a>
            <?php endif; ?>
            <?php if ($total_products > ($current_page * $num_products_on_each_page) - $num_products_on_each_page + count($products)): ?>
                <a type="button" class="btn btn-outline-success"
                   href="producten.php?p=<?= $current_page + 1 ?>&categorie_id=<?= $categorie ?>&sort=<?= $sort ?>">Volgende</a>
            <?php endif; ?>
        </div>
        <div class="row"><br></div>
    </div>
</main>

<?php include('includes/footer.php'); ?>
</body>
</html>
