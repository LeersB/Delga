<?php
$menu = 4;
include 'main.php';
$pdo_function = pdo_connect_mysql();
check_loggedin($pdo_function);
$msg = '';

//Get orders
$stmt = $pdo_function->prepare('SELECT * FROM orders WHERE user_id = ? ORDER BY order_datum DESC');
$stmt->execute([$_SESSION['user_id']]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['id'])) {
//Get order_details
    $stmt = $pdo_function->prepare('SELECT p.product_foto AS img, p.product_naam, od.* FROM order_details od 
    JOIN producten p ON p.product_id = od.product_id WHERE order_nr = ?');
    $stmt->execute([$_GET['id']]);
    $order_detail = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html class="h-100" lang="nl">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
    <meta content="Delga contactgegevens" name="description">
    <meta content="Bart Leers" name="author">
    <title>Delga account</title>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/delga.css" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100">

<header>
    <?php include('includes/header.php'); ?>
</header>

<main class="flex-shrink-0" role="main">
    <div class="container">
        <div class="content">
            <div class="jumbotron p-4 p-md-5 text-dark rounded bg-light">
                <div class="content profile">
                    <h2>Delga account</h2>
                    <div class="block">
                        <p>Uw account details staan hieronder.</p>
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link" href="profiel.php">Profiel</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="bestellingen.php">Bestellingen</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active">
                                <?php if (!isset($_GET['id'])): ?>
                                    <div class="input-group col-md-12"><br></div>
                                    <div class="content table-responsive-lg">
                                        <table class="table table-success table-hover table-borderless">
                                            <thead class="table-light">
                                            <tr>
                                                <th><i class="fas fa-hashtag"></i></th>
                                                <th>Datum</th>
                                                <th>Totaal prijs</th>
                                                <th>Status</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php if (empty($orders)): ?>
                                                <tr>
                                                    <td colspan="4" style="text-align:center;">Er zijn geen bestellingen aanwezig</td>
                                                </tr>
                                            <?php else: ?>
                                                <?php foreach ($orders as $order): ?>
                                                    <tr class="details" onclick="location.href='bestellingen.php?id=<?= $order['order_nr'] ?>'">
                                                        <td><?= $order['order_nr'] ?></td>
                                                        <td><?= date('d-m-Y', strtotime($order['order_datum'])) ?></td>
                                                        <td><?= $order['totaal_prijs'] ?></td>
                                                        <td><?= $order['order_status'] ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php elseif ($_GET['id'] > '0'): ?>
                                    <div class="input-group col-md-12"><br></div>
                                    <div class="content table-responsive-lg">
                                        <table class="table table-success table-hover table-borderless">
                                            <thead class="table-light">
                                            <tr>
                                                <th colspan="3">Producten ordernummer: <?= $_GET['id'] ?></th>
                                                <th>Prijs</th>
                                                <th>Aantal</th>
                                                <th>Totaal</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($order_detail as $order): ?>
                                                <tr class="details"
                                                    onclick="location.href='product.php?id=<?= $order['product_id'] ?>'">
                                                    <td class="img">
                                                        <?php if (!empty($order['img']) && file_exists('images/producten/' . $order['img'])): ?>
                                                            <img src="images/producten/<?= $order['img'] ?>" width="32"
                                                                 height="32" alt="<?= $order['product_naam'] ?>">
                                                        <?php endif; ?>
                                                    <td><?= $order['product_naam'] ?></td>
                                                    <td><?= $order['product_optie'] ?></td>
                                                    <td>€ <?= $order['product_prijs'] ?></td>
                                                    <td><?= $order['product_aantal'] ?></td>
                                                    <td>€ <?= number_format($order['product_prijs'] * $order['product_aantal'], 2) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include('includes/footer.php'); ?>
<script src="js/form-validation.js"></script>
</body>
</html>
