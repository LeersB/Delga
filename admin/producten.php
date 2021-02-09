<?php
$menuadmin = 3;
include 'main.php';
$pdo_function = pdo_connect_mysql();

$order_by_list = array('product_id', 'categorie_naam', 'product_naam', 'verpakking', 'eenheidsprijs');
$order_by = isset($_GET['order_by']) && in_array($_GET['order_by'], $order_by_list) ? $_GET['order_by'] : 'product_id';
$order_sort = isset($_GET['order_sort']) && $_GET['order_sort'] == 'DESC' ? 'DESC' : 'ASC';

$stmt = $pdo_function->prepare('SELECT * FROM producten p inner join categorie c on p.categorie_id = c.categorie_id ORDER BY ' . $order_by . ' ' . $order_sort);
$stmt->execute();
$producten = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html class="h-100" lang="nl">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
    <meta content="Delga contactgegevens" name="description">
    <meta content="Bart Leers" name="author">
    <title>Delga admin product</title>
    <link href="../css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="../css/delga-admin.css" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100">

<header>
    <?php include('includes/header.php'); ?>
</header>

<main class="flex-shrink-0" role="main">
    <div class="container">

        <h2>Producten</h2>

        <div class="content table-responsive-lg">
            <table class="table table-success table-hover table-borderless">
                <thead class="table-light">
                <tr>
                    <th colspan="2">
                        <a href="producten.php?order_by=product_id&order_sort=<?= $order_sort == 'ASC' ? 'DESC' : 'ASC' ?>">
                            <i class="fas fa-hashtag"></i>
                            <?php if ($order_by == 'product_id'): ?>
                                <i class="fas fa-sort-numeric-<?= str_replace(array('ASC', 'DESC'), array('down', 'down-alt'), $order_sort) ?>"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>
                        <a href="producten.php?order_by=product_naam&order_sort=<?= $order_sort == 'ASC' ? 'DESC' : 'ASC' ?>">
                            Product naam
                            <?php if ($order_by == 'product_naam'): ?>
                                <i class="fas fa-sort-alpha-<?= str_replace(array('ASC', 'DESC'), array('down', 'down-alt'), $order_sort) ?>"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>
                        <a href="producten.php?order_by=categorie_naam&order_sort=<?= $order_sort == 'ASC' ? 'DESC' : 'ASC' ?>">
                            Categorie
                            <?php if ($order_by == 'categorie_naam'): ?>
                                <i class="fas fa-sort-alpha-<?= str_replace(array('ASC', 'DESC'), array('down', 'down-alt'), $order_sort) ?>"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>
                        <a href="producten.php?order_by=verpakking&order_sort=<?= $order_sort == 'ASC' ? 'DESC' : 'ASC' ?>">
                            Verpakking
                            <?php if ($order_by == 'verpakking'): ?>
                                <i class="fas fa-sort-alpha-<?= str_replace(array('ASC', 'DESC'), array('down', 'down-alt'), $order_sort) ?>"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>
                        <a href="producten.php?order_by=eenheidsprijs&order_sort=<?= $order_sort == 'ASC' ? 'DESC' : 'ASC' ?>">
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
</main>

<?php include('includes/footer.php'); ?>

</body>
</html>
