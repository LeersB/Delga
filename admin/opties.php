<?php
$menuadmin = 3;
include 'main.php';
$pdo_function = pdo_connect_mysql();

$order_by_list = array('optie_id', 'product_naam', 'optie_titel', 'optie_naam', 'eenheidsprijs');
$order_by = isset($_GET['order_by']) && in_array($_GET['order_by'], $order_by_list) ? $_GET['order_by'] : 'optie_id';
$order_sort = isset($_GET['order_sort']) && $_GET['order_sort'] == 'DESC' ? 'DESC' : 'ASC';

$stmt = $pdo_function->prepare('SELECT optie_id, optie_titel, optie_naam, o.eenheidsprijs, o.product_id, product_naam FROM  product_opties o inner join producten p on o.product_id = p.product_id ORDER BY ' . $order_by . ' ' . $order_sort);
$stmt->execute();
$product_opties = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html class="h-100" lang="nl">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
    <meta content="Delga contactgegevens" name="description">
    <meta content="Bart Leers" name="author">
    <title>Delga admin product_optie</title>
    <link href="../css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="../css/delga.css" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100">

<header>
    <?php include('includes/header.php'); ?>
</header>

<main class="flex-shrink-0" role="main">
    <div class="container">

        <h2>Product opties</h2>

        <div class="content table-responsive-lg">
            <table class="table table-hover table-success table-borderless">
                <thead class="table-light">
                <tr>
                    <th>
                        <a href="opties.php?order_by=optie_id&order_sort=<?= $order_sort == 'ASC' ? 'DESC' : 'ASC' ?>">
                            <i class="fas fa-hashtag"></i>
                            <?php if ($order_by == 'optie_id'): ?>
                                <i class="fas fa-sort-numeric-<?= str_replace(array('ASC', 'DESC'), array('down', 'down-alt'), $order_sort) ?>"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>
                        <a href="opties.php?order_by=product_naam&order_sort=<?= $order_sort == 'ASC' ? 'DESC' : 'ASC' ?>">
                            Productnaam
                            <?php if ($order_by == 'product_naam'): ?>
                                <i class="fas fa-sort-alpha-<?= str_replace(array('ASC', 'DESC'), array('down', 'down-alt'), $order_sort) ?>"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>
                        <a href="opties.php?order_by=optie_titel&order_sort=<?= $order_sort == 'ASC' ? 'DESC' : 'ASC' ?>">
                            Titel
                            <?php if ($order_by == 'optie_titel'): ?>
                                <i class="fas fa-sort-alpha-<?= str_replace(array('ASC', 'DESC'), array('down', 'down-alt'), $order_sort) ?>"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>
                        <a href="opties.php?order_by=optie_naam&order_sort=<?= $order_sort == 'ASC' ? 'DESC' : 'ASC' ?>">
                            Naam
                            <?php if ($order_by == 'optie_naam'): ?>
                                <i class="fas fa-sort-alpha-<?= str_replace(array('ASC', 'DESC'), array('down', 'down-alt'), $order_sort) ?>"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>
                        <a href="opties.php?order_by=eenheidsprijs&order_sort=<?= $order_sort == 'ASC' ? 'DESC' : 'ASC' ?>">
                            Prijs
                            <?php if ($order_by == 'eenheidsprijs'): ?>
                                <i class="fas fa-sort-numeric-<?= str_replace(array('ASC', 'DESC'), array('down', 'down-alt'), $order_sort) ?>"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php if (empty($product_opties)): ?>
                    <tr>
                        <td colspan="8" style="text-align:center;">Er zijn geen producten aanwezig</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($product_opties as $product_optie): ?>
                        <tr class="details" onclick="location.href='optie.php?optie_id=<?= $product_optie['optie_id'] ?>'">
                            <td><?= $product_optie['optie_id'] ?></td>
                            <td><?= $product_optie['product_naam'] ?></td>
                            <td><?= $product_optie['optie_titel'] ?></td>
                            <td><?= $product_optie['optie_naam'] ?></td>
                            <td><?= $product_optie['eenheidsprijs'] ?></td>
                            <td><a class="btn btn-outline-danger" href="optie-delete.php?optie_id=<?= $product_optie['optie_id'] ?>" role="button"><i class="fas fa-trash-alt"></i></a></td>
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

