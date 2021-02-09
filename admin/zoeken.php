<?php
$menuadmin = 3;
$error = '';
include 'main.php';
$pdo_function = pdo_connect_mysql();
// Check for search query
if (isset($_GET['query']) && $_GET['query'] != '') {
    // Escape the user query, prevent XSS attacks
    $search_query = htmlspecialchars($_GET['query'], ENT_QUOTES, 'UTF-8');
    $order_by_list = array('product_id', 'categorie_naam', 'product_naam', 'verpakking', 'eenheidsprijs');
    $order_by = isset($_GET['order_by']) && in_array($_GET['order_by'], $order_by_list) ? $_GET['order_by'] : 'product_id';
    $order_sort = isset($_GET['order_sort']) && $_GET['order_sort'] == 'DESC' ? 'DESC' : 'ASC';
    $stmt = $pdo_function->prepare('SELECT * FROM producten p inner join categorie c on p.categorie_id = c.categorie_id WHERE p.product_naam LIKE :search_query ORDER BY ' . $order_by . ' ' . $order_sort);
    $stmt->bindValue(':search_query', '%' . $search_query . '%');
    $stmt->execute();
    $producten = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $total_products = count($producten);
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
    <title>Delga admin resultaat</title>
    <link href="../css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="../css/delga-admin.css" rel="stylesheet">
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

                <h2>Zoek resultaat voor "<?= $search_query ?>"</h2>

                <p><?= $total_products ?> product(en) gevonden</p>

                <h2>Producten</h2>

                <div class="content table-responsive-lg">
                    <table class="table table-success table-hover table-borderless">
                        <thead class="table-light">
                        <tr>
                            <th colspan="2">
                                <a href="zoeken.php?order_by=product_id&order_sort=<?= $order_sort == 'ASC' ? 'DESC' : 'ASC' ?><?= isset($_GET['query']) ? '&query=' . htmlentities($_GET['query'], ENT_QUOTES) : '' ?>">
                                    <i class="fas fa-hashtag"></i>
                                    <?php if ($order_by == 'product_id'): ?>
                                        <i class="fas fa-sort-numeric-<?= str_replace(array('ASC', 'DESC'), array('down', 'down-alt'), $order_sort) ?>"></i>
                                    <?php endif; ?>
                                </a>
                            </th>
                            <th>
                                <a href="zoeken.php?order_by=product_naam&order_sort=<?= $order_sort == 'ASC' ? 'DESC' : 'ASC' ?><?= isset($_GET['query']) ? '&query=' . htmlentities($_GET['query'], ENT_QUOTES) : '' ?>">
                                    Product naam
                                    <?php if ($order_by == 'product_naam'): ?>
                                        <i class="fas fa-sort-alpha-<?= str_replace(array('ASC', 'DESC'), array('down', 'down-alt'), $order_sort) ?>"></i>
                                    <?php endif; ?>
                                </a>
                            </th>
                            <th>
                                <a href="zoeken.php?order_by=categorie_naam&order_sort=<?= $order_sort == 'ASC' ? 'DESC' : 'ASC' ?><?= isset($_GET['query']) ? '&query=' . htmlentities($_GET['query'], ENT_QUOTES) : '' ?>">
                                    Categorie
                                    <?php if ($order_by == 'categorie_naam'): ?>
                                        <i class="fas fa-sort-alpha-<?= str_replace(array('ASC', 'DESC'), array('down', 'down-alt'), $order_sort) ?>"></i>
                                    <?php endif; ?>
                                </a>
                            </th>
                            <th>
                                <a href="zoeken.php?order_by=verpakking&order_sort=<?= $order_sort == 'ASC' ? 'DESC' : 'ASC' ?><?= isset($_GET['query']) ? '&query=' . htmlentities($_GET['query'], ENT_QUOTES) : '' ?>">
                                    Verpakking
                                    <?php if ($order_by == 'verpakking'): ?>
                                        <i class="fas fa-sort-alpha-<?= str_replace(array('ASC', 'DESC'), array('down', 'down-alt'), $order_sort) ?>"></i>
                                    <?php endif; ?>
                                </a>
                            </th>
                            <th>
                                <a href="zoeken.php?order_by=eenheidsprijs&order_sort=<?= $order_sort == 'ASC' ? 'DESC' : 'ASC' ?><?= isset($_GET['query']) ? '&query=' . htmlentities($_GET['query'], ENT_QUOTES) : '' ?>">
                                    Prijs
                                    <?php if ($order_by == 'eenheidsprijs'): ?>
                                        <i class="fas fa-sort-numeric-<?= str_replace(array('ASC', 'DESC'), array('down', 'down-alt'), $order_sort) ?>"></i>
                                    <?php endif; ?>
                                </a>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (empty($producten)): ?>
                            <tr>
                                <td colspan="8" style="text-align:center;">Er zijn geen producten aanwezig</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($producten as $product): ?>
                                <tr class="details"
                                    onclick="location.href='product.php?product_id=<?= $product['product_id'] ?>'">
                                    <td><?= $product['product_id'] ?></td>
                                    <td class="img">
                                        <?php if (!empty($product['product_foto']) && file_exists('../images/producten/' . $product['product_foto'])): ?>
                                            <img src="../images/producten/<?=$product['product_foto']?>" width="32" height="32" alt="<?=$product['product_naam']?>">
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $product['product_naam'] ?></td>
                                    <td><?= $product['categorie_naam'] ?></td>
                                    <td><?= $product['verpakking'] ?></td>
                                    <td>€&nbsp;<?= $product['eenheidsprijs'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        <?php endif; ?>

    </div>
</main>

<?php include('includes/footer.php'); ?>
</body>
</html>