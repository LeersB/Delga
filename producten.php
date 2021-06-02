<?php
$menu = 3;
include 'main.php';
$pdo_function = pdo_connect_mysql();

$aantal_pagina = aantal_pagina;
$sort = filter_input(INPUT_GET, 'sorteer', FILTER_SANITIZE_NUMBER_INT);
$pagina = filter_input(INPUT_GET, 'p', FILTER_SANITIZE_NUMBER_INT);
$cat = filter_input(INPUT_GET, 'categorie', FILTER_SANITIZE_NUMBER_INT);

// Statement categories
$stmtCategories = $pdo_function->query('SELECT * FROM categorie');
$stmtCategories->execute();
$categories = $stmtCategories->fetchAll(PDO::FETCH_ASSOC);
// Selecteer de huidige categorie anders selecteer all
$categorie = isset($cat) ? $cat : '0';
$category_sql = '';
if ($categorie != '0') {
    $category_sql = "AND p.categorie_id = :categorie";
}
$sorteer = isset($sort) ? $sort : '1';
$huidige_pagina = isset($pagina) && is_numeric($pagina) ? (int) $pagina : 1;

if ($sorteer == '1') {
    $stmt = $pdo_function->prepare("SELECT p.* FROM producten p WHERE product_level = 'actief'" . $category_sql . " ORDER BY p.categorie_id, p.product_naam ASC LIMIT :pagina,:aantal");
} elseif ($sorteer == '2') {
    $stmt = $pdo_function->prepare("SELECT p.* FROM producten p WHERE product_level = 'actief'" . $category_sql . " ORDER BY p.product_naam ASC LIMIT :pagina,:aantal");
} elseif ($sorteer == '3') {
    $stmt = $pdo_function->prepare("SELECT p.* FROM producten p WHERE product_level = 'actief'" . $category_sql . " ORDER BY p.product_naam DESC LIMIT :pagina,:aantal");
} else {
    $stmt = $pdo_function->prepare("SELECT p.* FROM producten p WHERE product_level = 'actief'" . $category_sql . " LIMIT :pagina,:aantal");
}
if ($categorie != '0') {
    $stmt->bindValue(':categorie', $categorie, PDO::PARAM_INT);
}
$stmt->bindValue(':pagina', ($huidige_pagina - 1) * $aantal_pagina, PDO::PARAM_INT);
$stmt->bindValue(':aantal', $aantal_pagina, PDO::PARAM_INT);
$stmt->execute();
$producten = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Statement Totaal aantal producten
$stmtTotaal_producten = $pdo_function->prepare("SELECT COUNT(*) FROM producten p WHERE product_level = 'actief'" . $category_sql);
if ($categorie != '0') {
    $stmtTotaal_producten->bindValue(':categorie', $categorie, PDO::PARAM_INT);
}
$stmtTotaal_producten->execute();
$totaal_producten = $stmtTotaal_producten->fetchColumn();
$totaal_pagina = round($totaal_producten / $aantal_pagina + 0.9, 1);
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

        <main class="flex-shrink-0">
            <div class="container">
                <h1>Producten</h1>
                <p><?= $totaal_producten ?> product(en) gevonden</p>

                <form action="producten.php" method="get" class="product-form">
                    <div class="row no-gutters">
                        <div class="input-group col-md-6 mb-2">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="categorie">Categorie</label>
                            </div>
                            <select class="custom-select" id="categorie" name="categorie">
                                <option value="0"<?= ($categorie == '0' ? ' selected' : '') ?>>Alle producten
                                </option>
                                <?php foreach ($categories as $c): ?>
                                    <option value="<?= $c['categorie_id'] ?>"<?= ($categorie == $c['categorie_id'] ? ' selected' : '') ?>><?= $c['categorie_naam'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="input-group col-md-6 mb-2">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="sorteer">Sorteer</label>
                            </div>
                            <select class="custom-select" name="sorteer" id="sorteer">
                                <option value="1"<?= ($sorteer == '1' ? ' selected' : '') ?>>Categorie</option>
                                <option value="2"<?= ($sorteer == '2' ? ' selected' : '') ?>>Oplopend</option>
                                <option value="3"<?= ($sorteer == '3' ? ' selected' : '') ?>>Aflopend</option>
                            </select>
                        </div>
                    </div>
                </form>

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
                                        <div class="d-flex justify-content-between">
                                            <div class="p-2">
                                                <p class="card-text text-secondary">
                                                    €&nbsp;<?= number_format($product['eenheidsprijs'], 2) ?></p>
                                            </div>
                                            <div class="p-2">
                                                <a href="product.php?id=<?= $product['product_id'] ?>"
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
                        <li class="page-item <?php if ($huidige_pagina == 1): ?>disabled<?php endif; ?>">
                            <a class="page-link"
                               href="producten.php?p=<?= $huidige_pagina - 1 ?>&categorie=<?= $categorie ?>&sorteer=<?= $sorteer ?>"
                               aria-label="Previous">
                                <span aria-hidden="true"><i class="fas fa-angle-double-left"></i></span>
                            </a>
                        </li>
                        <?php for ($pagina = 1; $pagina <= $totaal_pagina; $pagina++) { ?>
                            <li class="page-item <?php if ($huidige_pagina == $pagina): ?>active"
                                    aria-current="page<?php endif; ?>">
                                <a class="page-link"
                                   href="producten.php?p=<?= $pagina; ?>&categorie=<?= $categorie ?>&sorteer=<?= $sorteer ?>"><?= $pagina; ?></a>
                            </li>
                        <?php } ?>
                        <li class="page-item <?php if ($totaal_producten == ($huidige_pagina * $aantal_pagina) - $aantal_pagina + count($producten)): ?>disabled<?php endif; ?>">
                            <a class="page-link"
                               href="producten.php?p=<?= $huidige_pagina + 1 ?>&categorie=<?= $categorie ?>&sorteer=<?= $sorteer ?>"
                               aria-label="Next">
                                <span aria-hidden="true"><i class="fas fa-angle-double-right"></i></span>
                            </a>
                        </li>
                    </ul>
                </nav>

            </div>
        </main>

        <?php include('includes/footer.php'); ?>
        <script>
            if (document.querySelector(".product-form .input-group .custom-select")) {
                document.querySelector("#sorteer").onchange = () => document.querySelector(".product-form").submit();
                document.querySelector("#categorie").onchange = () => document.querySelector(".product-form").submit();
            }
        </script>
    </body>
</html>