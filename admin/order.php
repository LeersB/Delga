<?php
$menuadmin = 4;
include 'main.php';
$pdo_function = pdo_connect_mysql();

$order_status = array('nieuw', 'uitvoering', 'afgewerkt', 'geannuleerd');

if (isset($_GET['order_nr'])) {
    // Get order_details
    $stmt = $pdo_function->prepare("SELECT p.product_foto AS img, p.product_naam, o.*, od.product_prijs, od.product_aantal, od.product_optie, od.levering_aantal FROM orders o JOIN order_details od ON od.order_nr = o.order_nr
    JOIN producten p ON p.product_id = od.product_id WHERE o.order_nr = ? ");
    $stmt->execute([$_GET['order_nr']]);
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Get order
    $stmt = $pdo_function->prepare("SELECT * FROM orders WHERE order_nr = ? ");
    $stmt->execute([$_GET['order_nr']]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if (isset($_POST['order_uitvoering'])) {
        // Update order status uitvoering
        $stmt = $pdo_function->prepare('UPDATE orders SET opmerking = ?, leveringsdatum = ?, order_status = ? WHERE order_nr = ?');
        $stmt->execute([$_POST['opmerking'], $_POST['leveringsdatum'], 'uitvoering', $_GET['order_nr']]);
        header('Location: order.php?order_nr=' . $_GET['order_nr']);
        exit;
    }
    if (isset($_POST['order_afgewerkt'])) {
        // Update order status afgewerkt
        $stmt = $pdo_function->prepare('UPDATE orders SET opmerking = ?, leveringsdatum = ?, order_status = ? WHERE order_nr = ?');
        $stmt->execute([$_POST['opmerking'], $_POST['leveringsdatum'], 'afgewerkt', $_GET['order_nr']]);
        header('Location: orders.php');
        exit;
    }
    if (isset($_POST['order_annuleren'])) {
        // Update order status geannuleerd
        $stmt = $pdo_function->prepare('UPDATE orders SET opmerking = ?, leveringsdatum = ?, order_status = ? WHERE order_nr = ?');
        $stmt->execute([$_POST['opmerking'], NULL, 'geannuleerd', $_GET['order_nr']]);
        header('Location: orders.php');
        exit;
    }
    if (isset($_POST['levering_aantal'])) {
        // Update order status geannuleerd
        $stmt = $pdo_function->prepare('UPDATE order_details SET levering_aantal = ? WHERE order_details_id = ?');
        $stmt->execute([$_POST['levering_aantal'], $_GET['details_id']]);
        header('Location: order.php?order_nr=' . $_GET['order_nr']);
        exit;
    }

} else {
    header('Location: orders.php');
    exit;
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
        <h5>Order status: <?= $order['order_status'] ?></h5>

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
                               value="<?= $order['leveringsdatum'] ?>" placeholder="Leveringsdatum" min="2021-01-01">
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
                <?php if ($order['order_status'] == 'nieuw') { ?>
                    <div class="col-md-8">
                        <a class="btn btn-secondary" href="orders.php" role="button"><i class="fas fa-times"></i> Annuleer</a>
                        <button type="submit" name="order_uitvoering" class="btn btn-success"><i class="fas fa-check"></i> Order in uitvoering
                        </button>
                        <button type="submit" name="order_afgewerkt" class="btn btn-success"><i class="fas fa-check-double"></i> Order afgewerkt
                        </button>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" name="order_annuleren" class="btn btn-danger"><i class="fas fa-times"></i> Order annuleren</button>
                    </div>
                <?php } elseif ($order['order_status'] == 'uitvoering') { ?>
                    <div class="col-md-8">
                        <a class="btn btn-secondary" href="orders.php" role="button"><i class="fas fa-times"></i> Annuleer</a>
                        <button type="submit" name="update" class="btn btn-success"><i class="fas fa-check"></i> Order in uitvoering
                        </button>
                        <button type="submit" name="order_afgewerkt" class="btn btn-success"><i class="fas fa-check-double"></i> Order afgewerkt
                        </button>
                    </div>
                <?php } else { ?>
                    <div class="col-md-8">
                        <a class="btn btn-secondary" href="orders.php" role="button"><i class="fas fa-times"></i> Annuleer</a>
                    </div>
                <?php } ?>

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
                    <th>Levering</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($orders as $order): ?>
                        <tr class="details" onclick="location.href='order.php?order_nr=<?= $order['order_nr'] ?>&details_id=<?= $order['order_details_id'] ?>'">
                            <td class="img">
                                <?php if (!empty($order['img']) && file_exists('../images/producten/' . $order['img'])): ?>
                                    <img src="../images/producten/<?=$order['img']?>" width="32" height="32" alt="<?=$order['product_naam']?>">
                                <?php endif; ?>
                            </td>
                            <td><?=$order['product_naam']?> <?=$order['product_optie']?></td>
                            <td class="responsive-hidden">€ <?=number_format($order['product_prijs'],2)?></td>
                            <td><?=$order['product_aantal']?></td>
                            <td>€&nbsp;<?=number_format($order['product_prijs'] * $order['product_aantal'], 2)?></td>
                            <td><?=$order['levering_aantal']?></td>
                            <td style="color: #28a745"><i class="fas fa-edit"></i></td>
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

