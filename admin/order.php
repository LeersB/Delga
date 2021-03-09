<?php
$menuadmin = 4;
include 'main.php';
$pdo_function = pdo_connect_mysql();

$order = array(
    'order_id' => '',
    'user_id' => '',
    'order_nr' => '',
    'order_email' => '',
    'order_naam' => '',
    'order_adres' => '',
    'order_adres_2' => '',
    'totaal_prijs' => '',
    'order_datum' => '',
    'opmerking' => '',
    'leveringsdatum' => '',
    'order_status' => ''
);
$order_status = array('nieuw', 'afgewerkt', 'geannuleerd');

if (isset($_GET['order_nr'])) {
    // Get order_details
    $stmt = $pdo_function->prepare("SELECT p.product_foto AS img, p.product_naam, o.*, od.product_prijs, od.product_aantal, od.product_optie, od.aantal_levering FROM orders o JOIN order_details od ON od.order_nr = o.order_nr
    JOIN producten p ON p.product_id = od.product_id WHERE o.order_nr = ? ");
    $stmt->execute([$_GET['order_nr']]);
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Get order
    $stmt = $pdo_function->prepare("SELECT * FROM orders WHERE order_nr = ? ");
    $stmt->execute([$_GET['order_nr']]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if (isset($_POST['submit'])) {
        // Update order
        $stmt = $pdo_function->prepare('UPDATE orders SET opmerking = ?, leveringsdatum = ?, order_status = ? WHERE order_nr = ?');
        $stmt->execute([$_POST['opmerking'], $_POST['leveringsdatum'], $_POST['order_status'], $_GET['order_nr']]);
        header('Location: orders.php');
        exit;
    }
    if (isset($_POST['update'])) {
        // Update order in scherm
        $stmt = $pdo_function->prepare('UPDATE orders SET opmerking = ?, leveringsdatum = ?, order_status = ? WHERE order_nr = ?');
        $stmt->execute([$_POST['opmerking'], $_POST['leveringsdatum'], $_POST['order_status'], $_GET['order_nr']]);
        header('Location: order.php?order_nr=' . $_GET['order_nr']);
        exit;
    }

}
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

        <form class="needs-validation" novalidate action="" method="post" autocomplete="off">
            <div class="row">
                <div class="input-group col-md-12"><br></div>
                <div class="input-group col-md-6">
                    <label class="sr-only" for="leveringsdatum">Leveringsdatum</label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fas fa-calendar-day"></i></div>
                        </div>
                        <input type="date" class="form-control" id="leveringsdatum" name="leveringsdatum"
                               value="<?= $order['leveringsdatum'] ?>" placeholder="Leveringsdatum" min="2021-01-01" required>
                    </div>
                </div>
                <div class="input-group col-md-6">
                    <div class="input-group mb-2">
                        <label class="sr-only" for="order_status">Order status</label>
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fas fa-list-ol"></i></div>
                        </div>
                        <select class="custom-select" id="order_status" name="order_status">
                            <?php foreach ($order_status as $status): ?>
                                <option value="<?= $status ?>"<?= $status == $order['order_status'] ? ' selected' : '' ?>><?= $status ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="input-group col-md-12">
                    <label class="sr-only" for="opmerking">Opmerking</label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fas fa-pencil-ruler"></i></div>
                        </div>
                        <textarea class="form-control" id="opmerking" name="opmerking"
                                  rows="3" maxlength="400"><?= $order['opmerking'] ?></textarea>
                    </div>
                </div>
                <div class="col-12">
                    <a class="btn btn-secondary" href="orders.php" role="button"><i class="fas fa-times"></i>
                        Annuleer</a>
                    <button type="submit" name="update" class="btn btn-success"><i class="fas fa-check"></i> Update
                    </button>
                    <button type="submit" name="submit" class="btn btn-success"><i class="fas fa-check-double"></i> Opslaan
                    </button>
                </div>
                <div class="input-group col-md-12"><br></div>
            </div>
        </form>

        <div class="content table-responsive-lg">
            <table class="table table-light table-borderless">
                <tbody>
                <?php if (empty($orders)): ?>
                    <tr>
                        <td colspan="8" style="text-align:center;">Er zijn geen recente orders vandaag</td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td colspan="8">
                            <div class="row">
                                <div class="col-md-4">
                                    <h5>Order nummer</h5>
                                    <p><?=$order['order_nr']?></p>
                                </div>
                                <div class="col-md-4">
                                    <h5>Aangemaakt</h5>
                                    <p><?=date('d-m-Y H:i:s', strtotime($order['order_datum']))?></p>
                                </div>
                                <div class="col-md-4">
                                    <h5>Naam</h5>
                                    <p><?=$order['order_naam']?></p>
                                </div>
                                <div class="col-md-4">
                                    <h5>Email</h5>
                                    <p><?=$order['order_email']?></p>
                                </div>
                                <div class="col-md-4">
                                    <h5>Facturatieadres</h5>
                                    <p><?=$order['order_adres']?></p>
                                </div>
                                <div class="col-md-4">
                                    <h5>Leveringsadres</h5>
                                    <p><?=$order['order_adres_2']?></p>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
                <table class="table table-hover table-success table-borderless">
                <thead class="table-light">
                <tr>
                    <th colspan="2">Product</th>
                    <th class="responsive-hidden">Prijs</th>
                    <th>Aantal</th>
                    <th>Totaal</th>
                    <th class="responsive-hidden">Status</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($orders as $order): ?>
                        <tr class="details">
                            <td class="img">
                                <?php if (!empty($order['img']) && file_exists('../images/producten/' . $order['img'])): ?>
                                    <img src="../images/producten/<?=$order['img']?>" width="32" height="32" alt="<?=$order['product_naam']?>">
                                <?php endif; ?>
                            </td>
                            <td><?=$order['product_naam']?> <?=$order['product_optie']?></td>
                            <td class="responsive-hidden">€ <?=number_format($order['product_prijs'],2)?></td>
                            <td><?=$order['product_aantal']?></td>
                            <td>€&nbsp;<?=number_format($order['product_prijs'] * $order['product_aantal'], 2)?></td>
                            <td class="responsive-hidden"><?=$order['order_status']?></td>
                        </tr>
                    <?php endforeach; ?>

                <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</main>

<?php include('includes/footer.php'); ?>
<script src="../js/form-validation.js"></script>
</body>
</html>

