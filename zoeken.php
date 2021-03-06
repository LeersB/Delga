<?php
$menu = 3;
$error = '';
include 'main.php';
$pdo_function = pdo_connect_mysql();

$aantal_pagina = aantal_pagina;
$pagina = filter_input(INPUT_GET, 'p', FILTER_SANITIZE_NUMBER_INT);
$query = filter_input(INPUT_GET, 'query', FILTER_SANITIZE_STRING);

if (isset($query) && $query != '') {
    $huidige_pagina = isset($pagina) && is_numeric($pagina) ? (int)$pagina : 1;
    // Escape the user query, prevent XSS attacks
    $search_query = htmlspecialchars($query, ENT_QUOTES, 'UTF-8');
    $stmtProducten = $pdo_function->prepare("SELECT * FROM producten WHERE product_level = 'actief' and product_naam LIKE :query LIMIT :pagina,:aantal");
    $stmtProducten->bindValue(':pagina', ($huidige_pagina - 1) * $aantal_pagina, PDO::PARAM_INT);
    $stmtProducten->bindValue(':aantal', $aantal_pagina, PDO::PARAM_INT);
    $stmtProducten->bindValue(':query', '%' . $search_query . '%');
    $stmtProducten->execute();
    $producten = $stmtProducten->fetchAll(PDO::FETCH_ASSOC);
    // Totaal aantal gevonden producten
    $stmt = $pdo_function->prepare("SELECT COUNT(*) FROM producten WHERE product_level = 'actief' and product_naam LIKE :query");
    $stmt->bindValue(':query', '%' . $search_query . '%');
    $stmt->execute();
    $totaal_producten = $stmt->fetchColumn();
    $totaal_pagina = round($totaal_producten / $aantal_pagina + 0.9, 1);

} else {
    $error = 'Er is geen zoekopdracht ingevuld!';
}
?>
<!DOCTYPE html>
<html class="h-100" lang="nl">
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

<main class="flex-shrink-0">
    <div class="container">

        <?php if ($error): ?>
            <p class="content-wrapper error"><?= $error ?></p>
        <?php else: ?>

            <div class="products content-wrapper">
                <h2>Zoek resultaat voor "<?= $search_query ?>"</h2>
                <p><?= $totaal_producten ?> product(en) gevonden</p>
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
                                        <p class="card-text text-secondary">
                                            €&nbsp;<?= number_format($product['eenheidsprijs'], 2) ?>
                                            <a href="product.php?id=<?= $product['product_id'] ?>"
                                               class="btn btn-outline-secondary"><i class="fas fa-info"></i> Info</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <nav aria-label="Sorteren">
                <ul class="pagination">
                    <li class="page-item <?php if ($huidige_pagina == 1): ?>disabled<?php endif; ?>">
                        <a class="page-link"
                           href="zoeken.php?p=<?= $huidige_pagina - 1 ?>&query=<?= $search_query ?>"
                           aria-label="Previous">
                            <span aria-hidden="true"><i class="fas fa-angle-double-left"></i></span>
                        </a>
                    </li>
                    <?php for ($pagina = 1; $pagina <= $totaal_pagina; $pagina++) { ?>
                        <li class="page-item <?php if ($huidige_pagina == $pagina): ?>active"
                            aria-current="page <?php endif; ?>">
                            <a class="page-link"
                               href="zoeken.php?p=<?= $pagina; ?>&query=<?= $search_query ?>"><?= $pagina; ?></a>
                        </li>
                    <?php } ?>
                    <li class="page-item <?php if ($totaal_producten == ($huidige_pagina * $aantal_pagina) - $aantal_pagina + count($producten)): ?>disabled<?php endif; ?>">
                        <a class="page-link"
                           href="zoeken.php?p=<?= $huidige_pagina + 1 ?>&query=<?= $search_query ?>"
                           aria-label="Next">
                            <span aria-hidden="true"><i class="fas fa-angle-double-right"></i></span>
                        </a>
                    </li>
                </ul>
            </nav>

        <?php endif; ?>

    </div>
</main>

<?php include('includes/footer.php'); ?>
</body>
</html>