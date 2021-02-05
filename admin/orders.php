<?php
$menuadmin = 4;
include 'main.php';
$pdo_function = pdo_connect_mysql();

$order_by_list = array('order_id', 'order_datum');
$order_by = isset($_GET['order_by']) && in_array($_GET['order_by'], $order_by_list) ? $_GET['order_by'] : 'order_id';
$order_sort = isset($_GET['order_sort']) && $_GET['order_sort'] == 'DESC' ? 'DESC' : 'ASC';

$stmt = $pdo_function->prepare('SELECT * FROM  orders ORDER BY ' . $order_by . ' ' . $order_sort);
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html class="h-100" lang="nl">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
    <meta content="Delga contactgegevens" name="description">
    <meta content="Bart Leers" name="author">
    <title>Delga admin orders</title>
    <link href="../css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="../css/delga-admin.css" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100">

<header>
    <?php include('includes/header.php'); ?>
</header>

<main class="flex-shrink-0" role="main">
    <div class="container">

        <h2>Orders</h2>

        <div class="content table-responsive-lg">
            <table class="table table-hover table-success table-borderless">
                <thead class="table-light">
                <tr>
                    <th>
                        <a href="orders.php?order_by=order_id&order_sort=<?= $order_sort == 'ASC' ? 'DESC' : 'ASC' ?>">
                            <i class="fas fa-hashtag"></i>
                            <?php if ($order_by == 'order_id'): ?>
                                <i class="fas fa-sort-numeric-<?= str_replace(array('ASC', 'DESC'), array('down', 'down-alt'), $order_sort) ?>"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>
                        <a href="orders.php?order_by=order_datum&order_sort=<?= $order_sort == 'ASC' ? 'DESC' : 'ASC' ?>">
                            Order datum
                            <?php if ($order_by == 'order_datum'): ?>
                                <i class="fas fa-sort-alpha-<?= str_replace(array('ASC', 'DESC'), array('down', 'down-alt'), $order_sort) ?>"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>Naam</th>
                    <!--<th></th>-->
                </tr>
                </thead>
                <tbody>
                <?php if (empty($orders)): ?>
                    <tr>
                        <td colspan="8" style="text-align:center;">Er zijn geen orders aanwezig</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($orders as $order): ?>
                        <tr class="details">
                            <!--<tr class="details" onclick="location.href='categorie.php?categorie_id=<?= $order['order_id'] ?>'">-->
                            <td><?= $order['order_id'] ?></td>
                            <td><?= $order['order_datum'] ?></td>
                            <td><?= $order['order_voornaam']," ", $order['order_achternaam']?></td>
                            <!--<td><a class="btn btn-outline-danger" href="categorie-delete.php?categorie_id=<?= $order['order_id'] ?>" role="button"><i class="fas fa-trash-alt"></i></a></td>-->
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

