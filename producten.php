<?php
$menu = 5;
include 'main.php';

$pdo_function = pdo_connect_mysql();
$stmt = $pdo_function->query('SELECT * FROM categorie');
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Selecteer de huidige categorie anders selecteer all
$categorie = isset($_GET['categorie']) ? $_GET['categorie'] : 'all';
$category_sql = '';
if ($categorie != 'all') {
    $category_sql = 'WHERE p.categorie_id = :categorie';
}
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'sort1';
// Totaal getoonde producten per pagina
$num_products_on_each_page = 14;
// Huidige pagina
$current_page = isset($_GET['p']) && is_numeric($_GET['p']) ? (int)$_GET['p'] : 1;

if ($sort == 'sort1') {
    $stmt = $pdo_function->prepare('SELECT p.* FROM producten p ' . $category_sql . ' ORDER BY p.categorie_id, p.product_naam ASC LIMIT :page,:num_products');
} elseif ($sort == 'sort2') {
    $stmt = $pdo_function->prepare('SELECT p.* FROM producten p ' . $category_sql . ' ORDER BY p.product_naam ASC LIMIT :page,:num_products');
} elseif ($sort == 'sort3') {
    $stmt = $pdo_function->prepare('SELECT p.* FROM producten p ' . $category_sql . ' ORDER BY p.product_naam DESC LIMIT :page,:num_products');
} else {
    $stmt = $pdo_function->prepare('SELECT p.* FROM producten p ' . $category_sql . ' LIMIT :page,:num_products');
}
if ($categorie != 'all') {
    $stmt->bindValue(':categorie', $categorie, PDO::PARAM_INT);
}
$stmt->bindValue(':page', ($current_page - 1) * $num_products_on_each_page, PDO::PARAM_INT);
$stmt->bindValue(':num_products', $num_products_on_each_page, PDO::PARAM_INT);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Totaal aantal producten
$stmt = $pdo_function->prepare('SELECT COUNT(*) FROM producten p ' . $category_sql);
if ($categorie != 'all') {
    $stmt->bindValue(':categorie', $categorie, PDO::PARAM_INT);
}
$stmt->execute();
$total_products = $stmt->fetchColumn();
$total_pages = round($total_products / $num_products_on_each_page + 0.9, 1);
?>
<!DOCTYPE html>
<html class="h-100" lang="nl">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
    <meta content="Delga contactgegevens" name="description">
    <meta content="Bart Leers" name="author">
    <title>Delga producten</title>
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

            <form action="" method="get" class="product-form">
                <div class="row no-gutters">
                    <div class="input-group col-md-6 mb-2">
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
                    </div>
                    <div class="input-group col-md-6 mb-2">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="sort">Sorteren</label>
                        </div>
                        <select class="custom-select" name="sort" id="sort">
                            <option value="sort1"<?= ($sort == 'sort1' ? ' selected' : '') ?> selected>Categorie
                            </option>
                            <option value="sort2"<?= ($sort == 'sort2' ? ' selected' : '') ?>>Oplopend</option>
                            <option value="sort3"<?= ($sort == 'sort3' ? ' selected' : '') ?>>Aflopend</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>

        <div class="row"><br></div>

        <div class="row mb-2">
            <?php foreach ($products as $product): ?>
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
                                <div class="d-flex justify-content-between">
                                    <div class="p-2">
                                        <p class="card-text text-secondary">
                                            €&nbsp;<?= number_format($product['eenheidsprijs'], 2) ?></p>
                                    </div>
                                    <div class="p-2">
                                        <a href="product.php?&product_id=<?= $product['product_id'] ?>"
                                           class="btn btn-outline-secondary"><i class="fas fa-info"></i> Info</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <nav aria-label="Sorteren">
            <ul class="pagination">
                <li class="page-item <?php if ($current_page == 1): ?>disabled<?php endif; ?>">
                    <a class="page-link"
                       href="producten.php?p=<?= $current_page - 1 ?>&categorie=<?= $categorie ?>&sort=<?= $sort ?>"
                       aria-label="Previous">
                        <span aria-hidden="true"><i class="fas fa-angle-double-left"></i></span>
                    </a>
                </li>
                <?php for ($page = 1; $page <= $total_pages; $page++) { ?>
                    <li class="page-item <?php if ($current_page == $page): ?>active"
                        aria-current="page <?php endif; ?>">
                        <a class="page-link"
                           href="producten.php?p=<?= $page; ?>&categorie=<?= $categorie ?>&sort=<?= $sort ?>"><?= $page; ?></a>
                    </li>
                <?php } ?>
                <li class="page-item <?php if ($total_products == ($current_page * $num_products_on_each_page) - $num_products_on_each_page + count($products)): ?>disabled<?php endif; ?>">
                    <a class="page-link"
                       href="producten.php?p=<?= $current_page + 1 ?>&categorie=<?= $categorie ?>&sort=<?= $sort ?>"
                       aria-label="Next">
                        <span aria-hidden="true"><i class="fas fa-angle-double-right"></i></span>
                    </a>
                </li>
            </ul>
        </nav>

        <div class="row"><br></div>

    </div>
</main>

<?php include('includes/footer.php'); ?>
<script>
    if (document.querySelector(".product-form .input-group .custom-select")) {
        document.querySelector("#sort").onchange = () => document.querySelector(".product-form").submit();
        document.querySelector("#categorie").onchange = () => document.querySelector(".product-form").submit();
    }
</script>
</body>
</html>
