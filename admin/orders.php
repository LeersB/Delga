<?php
$menuadmin = 4;
include 'main.php';
$pdo_function = pdo_connect_mysql();

$order_by_list = array('order_id','order_datum','order_status');
$order_by = isset($_GET['order_by']) && in_array($_GET['order_by'], $order_by_list) ? $_GET['order_by'] : 'order_id';
$order_sort = isset($_GET['order_sort']) && $_GET['order_sort'] == 'ASC' ? 'ASC' : 'DESC';

$order_status = array('nieuw','afgewerkt','geannuleerd');
// Get orders
$stmt = $pdo_function->prepare('SELECT * FROM orders ORDER BY ' . $order_by . ' ' . $order_sort);
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

        <h2> Nieuwe Orders</h2>

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
                    <th class="responsive-hidden">
                        <a href="orders.php?order_by=order_datum&order_sort=<?= $order_sort == 'ASC' ? 'DESC' : 'ASC' ?>">
                            Datum
                            <?php if ($order_by == 'order_datum'): ?>
                                <i class="fas fa-sort-numeric-<?= str_replace(array('ASC', 'DESC'), array('down', 'down-alt'), $order_sort) ?>"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th class="responsive-hidden">Totaal</th>
                    <th class="responsive-hidden">Naam</th>
                    <th class="responsive-hidden">Email</th>
                    <th class="responsive-hidden">
                        <a href="orders.php?order_by=order_status&order_sort=<?= $order_sort == 'ASC' ? 'DESC' : 'ASC' ?>">
                            Status
                            <?php if ($order_by == 'order_status'): ?>
                                <i class="fas fa-sort-alpha-<?= str_replace(array('ASC', 'DESC'), array('down', 'down-alt'), $order_sort) ?>"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                <th></th>
                </tr>
                </thead>
                <tbody>
                <?php if (empty($orders)): ?>
                    <tr>
                        <td colspan="10" style="text-align:center;">Er zijn geen orders aanwezig</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($orders as $order): ?>
                        <tr class="details">
                            <td><?= $order['order_id'] ?></td>
                            <td class="responsive-hidden"><?=date('d-m-Y H:i:s', strtotime($order['order_datum']))?></td>
                            <td class="responsive-hidden">€&nbsp;<?=number_format($order['totaal_prijs'], 2)?></td>
                            <td class="responsive-hidden"><?=$order['order_naam']?></td>
                            <td class="responsive-hidden"><?=$order['order_email']?></td>
                            <td class="responsive-hidden"><?=$order['order_status']?></td>
                            <td><a class="btn btn-outline-success" href="order.php?order_nr=<?= $order['order_nr'] ?>" role="button"><i class="fas fa-edit"></i></a></td>
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

