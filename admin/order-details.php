<?php
$menuadmin = 4;
include '../admin/main.php';
$pdo_function = pdo_connect_mysql();

$filter_order_by = filter_input(INPUT_GET, 'order_by', FILTER_SANITIZE_STRING);
$filter_order_sort = filter_input(INPUT_GET, 'order_sort', FILTER_SANITIZE_STRING);

$order_by_list = array('order_id', 'product_naam', 'order_datum', 'order_status');
$order_by = isset($filter_order_by) && in_array($filter_order_by, $order_by_list) ? $filter_order_by : 'order_id';
$order_sort = isset($filter_order_sort) && $filter_order_sort == 'ASC' ? 'ASC' : 'DESC';

// Get orders
$stmt = $pdo_function->prepare("SELECT p.product_foto AS img, p.product_naam, o.*, od.product_prijs, od.product_aantal, od.product_optie FROM orders o JOIN order_details od ON od.order_nr = o.order_nr
    JOIN producten p ON p.product_id = od.product_id WHERE o.order_status = 'nieuw' ORDER BY ' . $order_by . ' " . $order_sort);
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
            <?php include('../admin/includes/header.php'); ?>
        </header>

        <main class="flex-shrink-0">
            <div class="container">

                <h2>Orders</h2>

                <div class="content table-responsive-lg">
                    <table class="table table-hover table-success table-borderless">
                        <thead class="table-light">
                            <tr>
                                <th colspan="2">
                                    <a href="orders.php?order_by=order_id&order_sort=<?= $order_sort == 'ASC' ? 'DESC' : 'ASC' ?>">
                                        <i class="fas fa-hashtag"></i>
                                        <?php if ($order_by == 'order_id'): ?>
                                            <i class="fas fa-sort-numeric-<?= str_replace(array('ASC', 'DESC'), array('down', 'down-alt'), $order_sort) ?>"></i>
                                        <?php endif; ?>
                                    </a>
                                </th>
                                <th>
                                    <a href="orders.php?order_by=product_naam&order_sort=<?= $order_sort == 'ASC' ? 'DESC' : 'ASC' ?>">
                                        Product
                                        <?php if ($order_by == 'product_naam'): ?>
                                            <i class="fas fa-sort-alpha-<?= str_replace(array('ASC', 'DESC'), array('down', 'down-alt'), $order_sort) ?>"></i>
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
                                <th class="responsive-hidden">Prijs</th>
                                <th>Aantal</th>
                                <th>Totaal</th>
                                <th class="responsive-hidden">Email</th>
                                <th class="responsive-hidden">
                                    <a href="orders.php?order_by=order_status&order_sort=<?= $order_sort == 'ASC' ? 'DESC' : 'ASC' ?>">
                                        Status
                                        <?php if ($order_by == 'order_status'): ?>
                                            <i class="fas fa-sort-alpha-<?= str_replace(array('ASC', 'DESC'), array('down', 'down-alt'), $order_sort) ?>"></i>
                                        <?php endif; ?>
                                    </a>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($orders)): ?>
                                <tr>
                                    <td colspan="9" style="text-align:center;">Er zijn geen orders aanwezig</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($orders as $order): ?>
                                    <tr class="details">
                                        <td><?= $order['order_id'] ?></td>
                                        <td>
                                            <?php if (!empty($order['img']) && file_exists('../images/producten/' . $order['img'])): ?>
                                                <img src="../images/producten/<?= $order['img'] ?>" width="32" height="32" alt="<?= $order['product_naam'] ?>">
                                            <?php endif; ?>
                                        </td>
                                        <td><?= $order['product_naam'] ?> <?= $order['product_optie'] ?></td>
                                        <td class="responsive-hidden"><?= date('d-m-Y', strtotime($order['order_datum'])) ?></td>
                                        <td class="responsive-hidden">€ <?= number_format($order['product_prijs'], 2) ?></td>
                                        <td><?= $order['product_aantal'] ?></td>
                                        <td>€&nbsp;<?= number_format($order['product_prijs'] * $order['product_aantal'], 2) ?></td>
                                        <td class="responsive-hidden"><?= $order['order_email'] ?></td>
                                        <td class="responsive-hidden"><?= $order['order_status'] ?></td>
                                    </tr>
                                    <tr class="expanded-details">
                                        <td colspan="9">
                                            <div>
                                                <div>
                                                    <span>Order nummer</span>
                                                    <span><?= $order['order_nr'] ?></span>
                                                </div>
                                                <div>
                                                    <span>Aangemaakt</span>
                                                    <span><?= date('d-m-Y H:i:s', strtotime($order['order_datum'])) ?></span>
                                                </div>
                                                <div>
                                                    <span>Naam</span>
                                                    <span><?= $order['order_naam'] ?></span>
                                                </div>
                                                <div>
                                                    <span>Email</span>
                                                    <span><?= $order['order_email'] ?></span>
                                                </div>
                                                <div>
                                                    <span>Facturatieadres</span>
                                                    <span><?= $order['order_adres'] ?></span>
                                                </div>
                                                <div>
                                                    <span>Leveringsadres</span>
                                                    <span><?= $order['order_adres_2'] ?></span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </main>

        <?php include('../admin/includes/footer.php'); ?>
        <script>
            document.querySelectorAll(".details").forEach(function (detail) {
                detail.onclick = function () {
                    let display = this.nextElementSibling.style.display === 'table-row' ? 'none' : 'table-row';
                    this.nextElementSibling.style.display = display;
                };
            });
        </script>
    </body>
</html>