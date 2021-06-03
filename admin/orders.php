<?php
$menuadmin = 4;
include 'main.php';
$pdo_function = pdo_connect_mysql();

$filter_order_by = filter_input(INPUT_GET, 'order_by', FILTER_SANITIZE_STRING);
$filter_order_sort = filter_input(INPUT_GET, 'order_sort', FILTER_SANITIZE_STRING);

$order_by_list = array('order_id','order_datum');
$order_by = isset($filter_order_by) && in_array($filter_order_by, $order_by_list) ? $filter_order_by : 'order_id';
$order_sort = isset($filter_order_sort) && $filter_order_sort == 'DESC' ? 'DESC' : 'ASC';

$weergaven = isset($_GET['weergaven']) ? $_GET['weergaven'] : 'nieuw';
// Get orders
if ($weergaven == 'nieuw') {
    $stmt = $pdo_function->prepare("SELECT * FROM orders WHERE order_status = 'nieuw' ORDER BY " . $order_by . ' ' . $order_sort);
} elseif ($weergaven == 'uitvoering') {
    $stmt = $pdo_function->prepare("SELECT * FROM orders WHERE order_status = 'uitvoering' ORDER BY " . $order_by . ' ' . $order_sort);
} elseif ($weergaven == 'afgewerkt') {
    $stmt = $pdo_function->prepare("SELECT * FROM orders WHERE order_status = 'afgewerkt' ORDER BY " . $order_by . ' ' . $order_sort);
} elseif ($weergaven == 'geannuleerd') {
    $stmt = $pdo_function->prepare("SELECT * FROM orders WHERE order_status = 'geannuleerd' ORDER BY " . $order_by . ' ' . $order_sort);
}
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

<main class="flex-shrink-0">
    <div class="container">

        <form action="" method="get" class="product-form">
            <div class="row no-gutters">
        <div class="input-group col-md-6 mb-2">
            <div class="input-group-prepend">
                <label class="input-group-text" for="weergaven">Weergaven orders</label>
            </div>
            <select class="custom-select" name="weergaven" id="weergaven">
                <option value="nieuw"<?= ($weergaven == 'nieuw' ? ' selected' : '') ?> selected>Nieuw
                </option>
                <option value="uitvoering"<?= ($weergaven == 'uitvoering' ? ' selected' : '') ?>>Uitvoering</option>
                <option value="afgewerkt"<?= ($weergaven == 'afgewerkt' ? ' selected' : '') ?>>Afgewerkt</option>
                <option value="geannuleerd"<?= ($weergaven == 'geannuleerd' ? ' selected' : '') ?>>Geannuleerd</option>
            </select>
        </div>
        </div>
        </form>

        <div class="content table-responsive-lg">
            <table class="table table-hover table-success table-borderless">
                <thead class="table-light">
                <tr>
                    <th>
                        <a href="orders.php?weergaven=<?= $weergaven ?>&order_by=order_id&order_sort=<?= $order_sort == 'ASC' ? 'DESC' : 'ASC' ?>">
                            <i class="fas fa-hashtag"></i>
                            <?php if ($order_by == 'order_id'): ?>
                                <i class="fas fa-sort-numeric-<?= str_replace(array('ASC', 'DESC'), array('down', 'down-alt'), $order_sort) ?>"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>
                        <a href="orders.php?weergaven=<?= $weergaven ?>&order_by=order_datum&order_sort=<?= $order_sort == 'ASC' ? 'DESC' : 'ASC' ?>">
                            Datum
                            <?php if ($order_by == 'order_datum'): ?>
                                <i class="fas fa-sort-numeric-<?= str_replace(array('ASC', 'DESC'), array('down', 'down-alt'), $order_sort) ?>"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th class="responsive-hidden">Order nummer</th>
                    <th class="responsive-hidden">Totaal</th>
                    <th class="responsive-hidden">Naam</th>
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
                        <tr class="details"
                            onclick="location.href='order.php?order_nr=<?= $order['order_nr'] ?>'">
                            <td><?= $order['order_id'] ?></td>
                            <td><?=date('d-m-Y H:i:s', strtotime($order['order_datum']))?></td>
                            <td class="responsive-hidden"><?= $order['order_nr'] ?></td>
                            <td class="responsive-hidden">€&nbsp;<?=number_format($order['totaal_prijs'], 2)?></td>
                            <td class="responsive-hidden"><?= $order['order_naam'] ?></td>
                            <?php if ($order['order_status'] == 'nieuw' || $order['order_status'] == 'uitvoering') : ?>
                            <td style="color: #28a745"><i class="fas fa-edit"></i></td>
                                <?php else: ?>
                                <td></td>
                            <?php endif ?>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</main>

<?php include('includes/footer.php'); ?>
<script>
    if (document.querySelector(".product-form .input-group .custom-select")) {
        document.querySelector("#weergaven").onchange = () => document.querySelector(".product-form").submit();
    }
</script>
</body>
</html>